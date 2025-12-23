<?php

namespace App\Http\Controllers;

use App\Models\BookingKonsultasi;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Show payment page for a booking
     */
    public function show($bookingId)
    {
        $booking = BookingKonsultasi::with('user', 'dokter')->findOrFail($bookingId);

        // Check authorization: only the booking owner can pay
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan pembayaran ini.');
        }

        // Check if booking is in 'menunggu pembayaran' status
        if ($booking->status !== 'menunggu pembayaran') {
            return redirect()->back()->with('error', 'Booking ini tidak dalam status menunggu pembayaran.');
        }

        // Create transaction details
        $orderId = 'VETOPIA-' . $booking->id . '-' . time();

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => (int) $booking->biaya,
        ];

        // Item details
        $itemDetails = [
            [
                'id' => 'konsultasi-' . $booking->id,
                'price' => (int) $booking->biaya,
                'quantity' => 1,
                'name' => 'Konsultasi Hewan - ' . $booking->nama_hewan,
            ],
        ];

        // Customer details
        $customerDetails = [
            'first_name' => $booking->user->name,
            'email' => $booking->user->email,
            'phone' => $booking->user->phone ?? '08123456789',
        ];

        // Transaction data
        $transaction = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Get Snap Token
            $snapToken = Snap::getSnapToken($transaction);

            return view('payment.show', compact('booking', 'snapToken'));
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            \Log::error('Midtrans Trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment notification from Midtrans
     */
    public function notification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;

            // Extract booking ID from order_id (format: VETOPIA-{booking_id}-{timestamp})
            $parts = explode('-', $orderId);
            $bookingId = $parts[1] ?? null;

            if (!$bookingId) {
                return response()->json(['message' => 'Invalid order ID'], 400);
            }

            $booking = BookingKonsultasi::find($bookingId);

            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            // Handle payment status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Payment successful
                    $booking->status = 'selesai';
                    $booking->save();
                }
            } elseif ($transactionStatus == 'settlement') {
                // Payment successful
                $booking->status = 'selesai';
                $booking->save();
            } elseif ($transactionStatus == 'pending') {
                // Payment pending, no action needed
                // Status remains 'menunggu pembayaran'
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                // Payment failed/cancelled, but we keep status as 'menunggu pembayaran'
                // so user can retry
            }

            return response()->json(['message' => 'Notification processed']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Handle payment finish (redirect from Midtrans)
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $transactionStatus = $request->transaction_status;

        // Extract booking ID
        $parts = explode('-', $orderId);
        $bookingId = $parts[1] ?? null;

        if (!$bookingId) {
            return redirect()->route('dashboard')->with('error', 'Invalid payment reference.');
        }

        $booking = BookingKonsultasi::find($bookingId);

        if (!$booking) {
            return redirect()->route('dashboard')->with('error', 'Booking tidak ditemukan.');
        }

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            // Update booking status to selesai
            $booking->status = 'selesai';
            $booking->save();

            return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Terima kasih.');
        } else {
            return redirect()->route('payment.show', $bookingId)
                ->with('info', 'Pembayaran belum selesai. Silakan coba lagi.');
        }
    }

    /**
     * Handle payment error
     */
    public function error(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan dalam proses pembayaran.');
    }

    /**
     * Handle unfinish payment (when user closes payment page)
     */
    public function unfinish(Request $request)
    {
        $orderId = $request->order_id;

        // Extract booking ID
        $parts = explode('-', $orderId);
        $bookingId = $parts[1] ?? null;

        if ($bookingId) {
            return redirect()->route('payment.show', $bookingId)
                ->with('info', 'Pembayaran belum selesai. Silakan lanjutkan pembayaran.');
        }

        return redirect()->route('dashboard')->with('info', 'Pembayaran belum selesai.');
    }
}
