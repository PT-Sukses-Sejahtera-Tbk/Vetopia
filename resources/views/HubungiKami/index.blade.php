@extends('layouts.main')

@section('container')
    <!-- Hero Section -->
    <div class="bg-vetopia-green py-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-black mb-3">Hubungi Kami</h1>
            <p class="text-black text-sm md:text-base">Kami siap membantu Anda melayani kesehatan hewan kesayangan Anda dengan tulus dan ikhlas!</p>
            <p class="text-black text-sm md:text-base">Jangan ragu untuk menghubungi kami melalui berbagai kontak berikut.</p>
        </div>
    </div>

    <!-- Contact Cards Section -->
    <div class="mx-auto px-4 py-12" style="max-width: 1300px;">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Email Card -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-vetopia-green rounded-full flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/hubungiKami/mail.png') }}" alt="Email Icon" class="w-6 h-6">
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                        <p class="text-sm text-gray-600 mb-2">Kirimkan pertanyaan atau keluhan Anda melalui email</p>
                        <a href="mailto:vetopiahappy@gmail.com" class="text-sm text-gray-900 font-medium hover:text-vetopia-green transition-colors">
                            vetopiahappy@gmail.com
                        </a>
                    </div>
                </div>
            </div>

            <!-- Telepon Card -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-vetopia-green rounded-full flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/hubungiKami/telefon.png') }}" alt="Phone Icon" class="w-6 h-6">
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                        <p class="text-sm text-gray-600 mb-2">Hubungi kami untuk konsultasi lebih cepat</p>
                        <a href="tel:+6281220867684" class="text-sm text-gray-900 font-medium hover:text-vetopia-green transition-colors">
                            +62 812-2086-7684
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alamat Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-vetopia-green rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('images/hubungiKami/maps.png') }}" alt="Location Icon" class="w-6 h-6">
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h3>
                    <p class="text-sm font-semibold text-gray-900 mb-1">Permata Kopo Blok A no.895 Sukamenak</p>
                    <p class="text-sm text-gray-600">Margahayu, Kab. Bandung</p>
                </div>
            </div>
        </div>

        <!-- Jam Operasional Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-vetopia-green rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('images/hubungiKami/jam.png') }}" alt="Clock Icon" class="w-6 h-6">
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Jam Operasional</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-semibold text-gray-900 mb-1">Senin - Jumat</p>
                            <p class="text-sm text-gray-600">09:00 - 18:00 WIB</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-semibold text-gray-900 mb-1">Sabtu - Minggu</p>
                            <p class="text-sm text-gray-600">09:00 - 14:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ikuti Kami Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-vetopia-green rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('images/hubungiKami/bumi.png') }}" alt="Social Media Icon" class="w-6 h-6">
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ikuti Kami</h3>
                    <p class="text-sm text-gray-600 mb-4">Tetap terhubung dengan kami melalui media sosial</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-vetopia-green transition-colors group">
                            <img src="{{ asset('images/hubungiKami/facebook.png') }}" alt="Facebook" class="w-5 h-5">
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-vetopia-green transition-colors group">
                            <img src="{{ asset('images/hubungiKami/instagram.png') }}" alt="Instagram" class="w-5 h-5">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection                                            