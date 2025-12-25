<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingKonsultasi;
use App\Models\PenitipanHewan; // Asumsi model Penitipan
use App\Notifications\SystemNotification;
use Carbon\Carbon;

class SendReminders extends Command
{
    protected $signature = 'app:send-reminders';
    protected $description = 'Kirim notifikasi pengingat H-1 untuk jadwal dan pembayaran';

    public function handle()
    {
        $besok = Carbon::tomorrow()->format('Y-m-d');

        // 1. Reminder Booking Konsultasi (H-1)
        $bookings = BookingKonsultasi::whereDate('tanggal_booking', $besok)
                    ->where('status', 'dikonfirmasi') // Hanya yang sudah confirm
                    ->get();

        foreach ($bookings as $booking) {
            $booking->user->notify(new SystemNotification(
                'Pengingat Jadwal Konsultasi',
                "Halo, besok adalah jadwal konsultasi untuk {$booking->nama_hewan}.",
                route('booking.myBookings')
            ));
        }

        // 2. Reminder Pembayaran (Status Menunggu Pembayaran)
        $unpaid = BookingKonsultasi::where('status', 'menunggu pembayaran')->get();
        foreach ($unpaid as $bill) {
             $bill->user->notify(new SystemNotification(
                'Tagihan Belum Dibayar',
                "Anda memiliki tagihan konsultasi untuk {$bill->nama_hewan}. Mohon segera lakukan pembayaran.",
                route('payment.show', $bill->id) // Asumsi route pembayaran
            ));
        }
        
        // 3. Reminder Penjemputan Hewan (Jika tanggal keluar adalah besok)
        // Pastikan Anda sudah punya Model PenitipanHewan yang sesuai
        $penitipan = \App\Models\PenitipanHewan::whereDate('tanggal_keluar', $besok)->get();
        foreach ($penitipan as $titip) {
            $titip->user->notify(new SystemNotification(
                'Jadwal Penjemputan Hewan',
                // Ubah baris yang error menjadi seperti ini:
       'Besok adalah jadwal penjemputan ' . ($titip->hewan->nama ?? 'hewan Anda') . ' dari penitipan.',
                route('penitipan.hewan.index') 
            ));
        }

        $this->info('Notifikasi pengingat berhasil dikirim!');
    }
}