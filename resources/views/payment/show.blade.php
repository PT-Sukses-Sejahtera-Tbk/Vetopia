<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Konsultasi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                            {{ session('info') }}
                        </div>
                    @endif

                    <!-- Payment Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Detail Pembayaran</h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <span class="text-sm text-gray-600">Nama Hewan</span>
                                <span class="font-medium">{{ $booking->nama_hewan }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <span class="text-sm text-gray-600">Pemilik</span>
                                <span class="font-medium">{{ $booking->nama_pemilik }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <span class="text-sm text-gray-600">Dokter</span>
                                <span class="font-medium">{{ $booking->dokter->name }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <span class="text-sm text-gray-600">Tanggal Konsultasi</span>
                                <span class="font-medium">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <span class="text-sm text-gray-600">Spesies/Ras</span>
                                <span class="font-medium">{{ $booking->spesies }} - {{ $booking->ras }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-base font-semibold text-gray-800">Total Biaya</span>
                                <span class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($booking->biaya, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">Instruksi Pembayaran:</h4>
                        <ul class="list-disc list-inside text-sm text-blue-800 space-y-1">
                            <li>Klik tombol "Bayar Sekarang" di bawah</li>
                            <li>Pilih metode pembayaran yang Anda inginkan</li>
                            <li>Ikuti instruksi yang diberikan</li>
                            <li>Setelah pembayaran berhasil, status booking akan otomatis diupdate</li>
                        </ul>
                    </div>

                    <!-- Payment Button -->
                    <div class="flex flex-col items-center space-y-4">
                        <button id="pay-button"
                            class="w-full sm:w-auto px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Bayar Sekarang
                        </button>

                        <a href="{{ route('dashboard') }}"
                            class="text-sm text-gray-600 hover:text-gray-800 underline">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <!-- For Production, use this instead:
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    -->

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // Disable button to prevent double click
            this.disabled = true;
            this.innerHTML = '<svg class="animate-spin inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
            
            // Trigger Snap payment
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route("payment.finish") }}?order_id=' + result.order_id + 
                        '&status_code=' + result.status_code + 
                        '&transaction_status=' + result.transaction_status;
                },
                onPending: function(result) {
                    window.location.href = '{{ route("payment.unfinish") }}?order_id=' + result.order_id;
                },
                onError: function(result) {
                    window.location.href = '{{ route("payment.error") }}';
                },
                onClose: function() {
                    // Re-enable button if user closes the popup
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').innerHTML = '<svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Bayar Sekarang';
                    
                    alert('Anda menutup halaman pembayaran. Silakan klik tombol "Bayar Sekarang" untuk melanjutkan.');
                }
            });
        };
    </script>
</x-app-layout>
