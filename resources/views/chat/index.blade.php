@extends('layouts.main')

@section('container')
    <!-- 1. HEADER HALAMAN -->
    <div class="pt-16 pb-8 text-center font-sans">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Konsultasi Online</h1>
        <p class="text-gray-500 font-normal text-lg">Dapatkan solusi cepat kesehatan hewan peliharaan Anda bersama AI</p>
    </div>

    <!-- 2. KONTAINER CHAT -->
    <div class="max-w-3xl mx-auto px-4 pb-20">
        
        <!-- Kartu Chat Utama -->
        <div class="bg-white rounded-[30px] shadow-xl overflow-hidden flex flex-col h-[650px] border border-gray-200">
            
            <!-- A. HEADER CHAT (Warna TEAL #009688) -->
            <div class="bg-[#009688] px-6 py-4 flex items-center gap-4 shadow-md z-10">
                <!-- Foto Profil: avatarai.png -->
                <div class="relative">
                    <img class="w-12 h-12 rounded-full object-cover border-2 border-white" 
                         src="{{ asset('images/Konsultasi_Online/avatarai.png') }}" 
                         alt="Avatar AI">
                    <!-- Status Dot -->
                    <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-[#00E676] border-2 border-[#009688] rounded-full"></div>
                </div>
                
                <!-- Nama & Status -->
                <div class="text-white">
                    <h3 class="font-bold text-lg leading-tight tracking-wide">Dr. Vet (AI Assistant)</h3>
                    <p class="text-xs text-white/90 font-medium flex items-center gap-1.5 opacity-90">
                        <span class="inline-block w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span> Online
                    </p>
                </div>
            </div>

            <!-- B. AREA CHAT -->
            <div id="chatBox" class="flex-1 bg-[#F5F5F5] p-6 overflow-y-auto space-y-5">
                <!-- Bubble AI (Kiri) -->
                <div class="flex justify-start w-full">
                    <div class="bg-white text-gray-800 rounded-tr-2xl rounded-br-2xl rounded-bl-2xl px-5 py-3.5 shadow-sm max-w-[80%] relative border border-gray-100">
                        <div class="absolute top-0 left-[-8px] w-0 h-0 border-t-[0px] border-r-[15px] border-b-[15px] border-transparent border-r-white"></div>
                        <p class="text-[15px] leading-relaxed text-gray-700">
                            Halo! Saya Dr. Vet. 👋 <br>
                            Silakan ceritakan keluhan hewan peliharaan Anda.
                        </p>
                        <span class="text-[10px] text-gray-400 mt-1.5 block text-right">{{ date('H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- C. LOADING INDICATOR -->
            <div id="loadingIndicator" class="hidden bg-[#F5F5F5] px-6 pb-2">
                <div class="bg-white px-4 py-2 rounded-full inline-flex items-center gap-2 shadow-sm border border-gray-100">
                    <span class="flex space-x-1">
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-75"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-150"></span>
                    </span>
                    <span class="text-xs text-gray-500 font-medium">Mengetik...</span>
                </div>
            </div>

            <!-- D. FOOTER INPUT (REVISI: Terpisah) -->
            <div class="bg-white p-5 border-t border-gray-100">
                <form id="chatForm" class="flex items-center gap-3 w-full">
                    @csrf
                    
                    <!-- Input Field (Terpisah, Border Hitam Tipis) -->
                    <input 
                        type="text" 
                        id="userMessage" 
                        name="message" 
                        class="flex-1 bg-white border border-gray-800 text-gray-900 font-medium placeholder-gray-900 rounded-[20px] py-3.5 px-6 focus:ring-2 focus:ring-[#009688] focus:border-[#009688] outline-none transition-all text-[15px]" 
                        placeholder="Ketika Pesan Anda....." 
                        required
                        autocomplete="off"
                    >
                    
                    <!-- Tombol Kirim (Terpisah, Kotak Hijau Rounded) -->
                    <button 
                        type="submit" 
                        id="sendBtn"
                        class="w-[54px] h-[54px] bg-[#65DF73] hover:bg-[#65DF73] rounded-[18px] flex items-center justify-center transition-all group disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0 shadow-sm"
                    >
                        <img src="{{ asset('images/Konsultasi_Online/send.png') }}" 
                             alt="Kirim" 
                             class="w-6 h-6 object-contain group-hover:scale-110 transition-transform">
                    </button>
                </form>
                
                <p class="text-center text-[11px] text-gray-400 mt-4 font-medium">
                    AI dapat melakukan kesalahan. Konsultasi fisik tetap disarankan.
                </p>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        const chatForm = document.getElementById('chatForm');
        const chatBox = document.getElementById('chatBox');
        const userMessageInput = document.getElementById('userMessage');
        const sendBtn = document.getElementById('sendBtn');
        const loadingIndicator = document.getElementById('loadingIndicator');

        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function appendMessage(message, isUser = false) {
            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            // Layout Bubble User
            const userBubble = `
                <div class="flex justify-end w-full animate-fade-in my-3">
                    <div class="bg-[#DCF8C6] text-gray-800 rounded-tl-2xl rounded-bl-2xl rounded-br-2xl px-5 py-3.5 shadow-sm max-w-[80%] relative border border-green-100">
                        <div class="absolute top-0 right-[-8px] w-0 h-0 border-t-[0px] border-l-[15px] border-b-[15px] border-transparent border-l-[#DCF8C6]"></div>
                        <p class="text-[15px] leading-relaxed whitespace-pre-wrap font-medium">${message}</p>
                        <span class="text-[10px] text-gray-500 mt-1.5 block text-right flex justify-end items-center gap-1">
                            ${time} ✓
                        </span>
                    </div>
                </div>
            `;

            // Layout Bubble AI
            const aiBubble = `
                <div class="flex justify-start w-full animate-fade-in my-3">
                    <div class="bg-white text-gray-800 rounded-tr-2xl rounded-br-2xl rounded-bl-2xl px-5 py-3.5 shadow-sm max-w-[80%] relative border border-gray-100">
                        <div class="absolute top-0 left-[-8px] w-0 h-0 border-t-[0px] border-r-[15px] border-b-[15px] border-transparent border-r-white"></div>
                        <p class="text-[15px] leading-relaxed whitespace-pre-wrap font-medium text-gray-700">${message}</p>
                        <span class="text-[10px] text-gray-400 mt-1.5 block text-right">${time}</span>
                    </div>
                </div>
            `;
            
            chatBox.insertAdjacentHTML('beforeend', isUser ? userBubble : aiBubble);
            scrollToBottom();
        }

        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = userMessageInput.value.trim();
            if (!message) return;

            appendMessage(message, true);
            userMessageInput.value = '';
            userMessageInput.disabled = true;
            sendBtn.disabled = true;
            
            loadingIndicator.classList.remove('hidden');
            scrollToBottom();

            try {
                const response = await fetch("{{ route('chat.process') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                loadingIndicator.classList.add('hidden');

                if (response.ok) {
                    appendMessage(data.reply, false);
                } else {
                    appendMessage("⚠️ Error: " + (data.reply || response.statusText), false);
                }

            } catch (error) {
                loadingIndicator.classList.add('hidden');
                appendMessage("⚠️ Gagal koneksi internet.", false);
            } finally {
                userMessageInput.disabled = false;
                sendBtn.disabled = false;
                userMessageInput.focus();
                scrollToBottom();
            }
        });
    </script>
    
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        #chatBox::-webkit-scrollbar {
            width: 5px;
        }
        #chatBox::-webkit-scrollbar-track {
            background: transparent;
        }
        #chatBox::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }
    </style>
@endsection