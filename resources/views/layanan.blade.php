@extends('layouts.main')

@section('container')
    <div class="my-10 text-gray-900 font-sans text-center">
        <p class="font-medium text-4xl">Pilih Layanan Kesehatan Hewan</p>
        <p class="my-10 text-xl font-normal">Kami menyediakan berbagai layanan kesehatan untuk hewan kesayangan Anda. Pilih
            layanan <br>yang sesuai dengan kebutuhan Anda.</p>
    </div>

    <!-- Service Cards -->
    <div class="max-w-7xl mx-auto px-4 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Booking Konsultasi -->
            <a href="{{ route('booking.konsultasi') }}"
                class="bg-white rounded-3xl border border-gray-200 p-8 text-center hover:shadow-lg transition-shadow block">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-vetopia-green rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-semibold mb-4">Booking Konsultasi</h3>
                <p class="text-gray-600 leading-relaxed">Jadwalkan konsultasi dengan dokter hewan profesional kami di
                    klinik. Dapatkan layanan terbaik untuk hewan Anda.</p>
            </a>

            <!-- Konsultasi Online -->
            <a href="{{ route('chat.index') }}"
                class="bg-white rounded-3xl border border-gray-200 p-8 text-center hover:shadow-lg transition-shadow block">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-vetopia-green rounded-2xl flex items-center justify-center">
                        <img src="{{ asset('images/KonsulOnlineIcon.png') }}" alt="Konsultasi Online" class="w-10 h-10">
                    </div>
                </div>
                <h3 class="text-2xl font-semibold mb-4">Konsultasi Online</h3>
                <p class="text-gray-600 leading-relaxed">Pemeriksaan kesehatan menyeluruh untuk hewan kesayangan Anda.
                    Deteksi dini masalah kesehatan hewan Anda.</p>
            </a>

            <!-- Penitipan Hewan -->
            <a href="{{ route('penitipan.hewan') }}"
                class="bg-white rounded-3xl border border-gray-200 p-8 text-center hover:shadow-lg transition-shadow block">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-vetopia-green rounded-2xl flex items-center justify-center">
                        <img src="{{ asset('images/PenitipanHewanIcon.png') }}" alt="Penitipan Hewan" class="w-10 h-10">
                    </div>
                </div>
                <h3 class="text-2xl font-semibold mb-4">Penitipan Hewan</h3>
                <p class="text-gray-600 leading-relaxed">Layanan Penitipan Hewan untuk menitipkan Hewan Anda</p>
            </a>
        </div>
    </div>
@endsection
