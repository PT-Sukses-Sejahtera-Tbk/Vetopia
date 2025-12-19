<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GroqbotController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function chat(Request $request)
    {
        try {
            // 1. Validasi input
            $request->validate([
                'message' => 'required|string',
            ]);

            $userMessage = $request->input('message');
            
            // 2. Ambil API Key Groq dari .env
            $apiKey = env('GROQ_API_KEY');

            if (empty($apiKey)) {
                return response()->json([
                    'reply' => "⚠️ **Error Konfigurasi:**\nAPI Key Groq belum disetting di file .env. Silakan tambahkan GROQ_API_KEY=gsk_..."
                ]);
            }

            // 3. Konfigurasi Groq
            // Endpoint Groq (kompatibel dengan format OpenAI)
            $url = 'https://api.groq.com/openai/v1/chat/completions';
            
            // Model: Llama 3.3 70B (Sangat pintar & cepat)
            $model = 'llama-3.3-70b-versatile'; 

            $systemInstruction = "Kamu adalah Dr. Vet, asisten AI dokter hewan di klinik Vetopia. " . 
                                 "Jawablah dengan ramah, ringkas, dan gunakan Bahasa Indonesia. " .
                                 "Jangan berikan resep obat keras, sarankan ke klinik jika parah.";

            // 4. Kirim Request ke Groq
            try {
                $response = Http::withToken($apiKey) // Menggunakan Bearer Token
                    ->timeout(30) // Set timeout agar tidak loading selamanya
                    ->post($url, [
                        'model' => $model,
                        'messages' => [
                            ['role' => 'system', 'content' => $systemInstruction],
                            ['role' => 'user', 'content' => $userMessage]
                        ],
                        'temperature' => 0.7, // Tingkat kreativitas (0.0 - 1.0)
                        'max_tokens' => 1024, // Batas panjang jawaban
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    // Ambil jawaban dari struktur JSON Groq
                    $botReply = $data['choices'][0]['message']['content'] ?? 'Maaf, tidak ada respon.';
                    
                    return response()->json(['reply' => $botReply]);
                } else {
                    // Handle jika API menolak (misal key salah atau limit)
                    $err = $response->json();
                    $msg = $err['error']['message'] ?? 'Unknown error';
                    
                    return response()->json([
                        'reply' => "⚠️ **Groq Error:** " . $msg
                    ]);
                }

            } catch (\Exception $e) {
                return response()->json([
                    'reply' => "⚠️ **Gagal Terhubung:** " . $e->getMessage()
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'reply' => "⚠️ **System Error:** " . $e->getMessage()
            ]);
        }
    }
}