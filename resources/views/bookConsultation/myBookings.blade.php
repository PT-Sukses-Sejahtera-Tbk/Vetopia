<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Booking Konsultasi Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                    <!-- Booking List -->
                    @if ($bookings->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($bookings as $booking)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                                    <!-- Card Header with Status Badge -->
                                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $booking->nama_hewan }}</h3>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($booking->status === 'dikonfirmasi') bg-blue-100 text-blue-800
                                                @elseif($booking->status === 'diperiksa') bg-purple-100 text-purple-800
                                                @elseif($booking->status === 'menunggu pembayaran') bg-orange-100 text-orange-800
                                                @elseif($booking->status === 'selesai') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                @if($booking->status === 'pending') Pending
                                                @elseif($booking->status === 'dikonfirmasi') Dikonfirmasi
                                                @elseif($booking->status === 'diperiksa') Diperiksa
                                                @elseif($booking->status === 'menunggu pembayaran') Menunggu Pembayaran
                                                @elseif($booking->status === 'selesai') Selesai
                                                @else {{ $booking->status }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="p-4 space-y-3">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500">Dokter</p>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $booking->dokter ? 'Dr. ' . $booking->dokter->name : 'Belum ditentukan' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500">Tanggal Booking</p>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500">Spesies / Ras</p>
                                                <p class="text-sm font-medium text-gray-900">{{ $booking->spesies }} - {{ $booking->ras }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500">Keluhan</p>
                                                <p class="text-sm text-gray-900">{{ Str::limit($booking->keluhan, 80) }}</p>
                                            </div>
                                        </div>

                                        @if($booking->biaya)
                                            <div class="flex items-start pt-2 border-t border-gray-200">
                                                <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-xs text-gray-500">Biaya Konsultasi</p>
                                                    <p class="text-lg font-bold text-green-600">Rp {{ number_format($booking->biaya, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Card Footer with Actions -->
                                    <div class="p-4 bg-gray-50 border-t border-gray-200">
                                        @if($booking->status === 'menunggu pembayaran')
                                            <a href="{{ route('payment.show', $booking->id) }}"
                                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Bayar Sekarang
                                            </a>
                                        @elseif($booking->status === 'selesai')
                                            <div class="flex items-center justify-center text-green-600">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-sm font-medium">Konsultasi Selesai</span>
                                            </div>
                                        @else
                                            <div class="text-center text-sm text-gray-500">
                                                <svg class="w-5 h-5 mx-auto mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Menunggu proses dokter
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination if needed -->
                        <div class="mt-6">
                            <p class="text-sm text-gray-600">Total: {{ $bookings->count() }} booking</p>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada booking</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat booking konsultasi untuk hewan peliharaan Anda.</p>
                            <div class="mt-6">
                                <a href="{{ route('booking.konsultasi') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Buat Booking Baru
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
