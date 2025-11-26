<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminibotController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function chat(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
            ]);

            $userMessage = $request->input('message');
            $apiKey = env('GEMINI_API_KEY');

            if (empty($apiKey)) {
                return response()->json([
                    'reply' => "⚠️ **Error Konfigurasi:**\nAPI Key belum disetting di file .env."
                ]);
            }

            // DAFTAR MODEL (DISESUAIKAN UNTUK TAHUN 2025)
            // Kita gunakan alias 'gemini-flash' yang otomatis mengarah ke versi stabil terbaru
            $modelsToTry = [
                'gemini-2.0-flash',      // Versi stabil 2.0 (Harusnya ada di 2025)
                'gemini-flash',          // Alias generik (Paling aman, mengarah ke flash terbaru)
                'gemini-pro',            // Alias generik pro
                'gemini-2.0-flash-exp',  // Versi eksperimental (Cadangan)
            ];

            $botReply = null;
            $quotaError = false;     // Penanda khusus jika limit habis
            $lastError = '';
            
            $systemInstruction = "Kamu adalah Dr. Vet, asisten AI dokter hewan di klinik Vetopia. " . 
                                 "Jawablah dengan ramah, ringkas, dan gunakan Bahasa Indonesia. " .
                                 "Jangan berikan resep obat keras, sarankan ke klinik jika parah.";

            foreach ($modelsToTry as $model) {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

                try {
                    $response = Http::withoutVerifying()
                        ->withHeaders(['Content-Type' => 'application/json'])
                        ->post($url, [
                            'contents' => [
                                [
                                    'role' => 'user',
                                    'parts' => [['text' => $systemInstruction . "\n\nUser bertanya: " . $userMessage]]
                                ]
                            ]
                        ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                        if ($botReply) break;
                    } else {
                        $responseBody = $response->json();
                        $msg = $responseBody['error']['message'] ?? $response->body();
                        
                        // Cek apakah errornya karena Kuota/Limit
                        if (str_contains(strtolower($msg), 'quota') || $response->status() == 429) {
                             $quotaError = true;
                             $lastError .= "\n- {$model}: ⚠️ Limit Habis (Tunggu sebentar)";
                        } elseif (str_contains(strtolower($msg), 'not found')) {
                             $lastError .= "\n- {$model}: Tidak ditemukan (Versi usang)";
                        } else {
                             $lastError .= "\n- {$model}: " . $msg;
                        }
                    }
                } catch (\Exception $e) {
                    $lastError .= "\n- {$model} Error Koneksi: " . $e->getMessage();
                }
            }

            if (!$botReply) {
                // Pesan khusus jika masalahnya adalah KUOTA
                if ($quotaError) {
                    return response()->json([
                        'reply' => "⚠️ **Batas Penggunaan Tercapai (Quota Exceeded)**\n\n" .
                                   "Akun AI gratis ini sedang sibuk. Mohon tunggu sekitar 1-2 menit lalu coba lagi.\n\n" .
                                   "(Tips: Jika ini sering terjadi, pertimbangkan membuat API Key baru dengan akun Google lain)"
                    ]);
                }

                return response()->json([
                    'reply' => "⚠️ **Gagal Terhubung**\n\nDetail Error:\n" . $lastError
                ]);
            }

            return response()->json(['reply' => $botReply]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => "⚠️ **System Error:** " . $e->getMessage()
            ]);
        }
    }
}