<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Hewan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('hewan.index') }}"
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:ring-4 focus:ring-gray-300">
                    Kembali
                </a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Side - Data Hewan -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-vetopia-green to-green-500 rounded-lg shadow-lg p-6 text-white">
                        <h3 class="text-lg font-semibold mb-6">Data Pasien</h3>

                        <!-- Avatar and Name -->
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-2xl">
                                {{ strtoupper(substr($hewan->nama, 0, 2)) }}
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-xl">{{ $hewan->nama }}</h4>
                                <span class="bg-green-200 text-green-800 text-xs px-2 py-1 rounded">ID:
                                    #{{ str_pad($hewan->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="space-y-3 bg-white bg-opacity-20 rounded-lg p-4">
                            <div class="flex justify-between">
                                <span class="text-green-100">Pemilik</span>
                                <span class="font-semibold">{{ $hewan->pemilik->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-100">Species</span>
                                <span class="font-semibold">{{ $hewan->jenis }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-100">Ras</span>
                                <span class="font-semibold">{{ $hewan->ras }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-100">Umur</span>
                                <span class="font-semibold">{{ $hewan->umur }} tahun</span>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Right Side - Rekam Medis List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Riwayat Rekam Medis</h3>

                        @if ($hewan->rekamMedis->isEmpty())
                            <p class="text-gray-500 text-center py-8">Belum ada riwayat rekam medis.</p>
                        @else
                            <div id="accordion-card" data-accordion="open">
                                @foreach ($hewan->rekamMedis as $index => $rekam)
                                    <h2 id="accordion-card-heading-{{ $index + 1 }}"
                                        class="{{ $index > 0 ? 'mt-4' : '' }}">
                                        <button type="button"
                                            class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-body rounded-base shadow-xs border border-default hover:text-heading hover:bg-neutral-secondary-medium gap-3 [&[aria-expanded='true']]:rounded-b-none [&[aria-expanded='true']]:shadow-none"
                                            data-accordion-target="#accordion-card-body-{{ $index + 1 }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="accordion-card-body-{{ $index + 1 }}">
                                            <span>Pemeriksaan -
                                                {{ \Carbon\Carbon::parse($rekam->tanggal_periksa)->format('d M Y') }}</span>
                                            <svg data-accordion-icon
                                                class="w-5 h-5 {{ $index === 0 ? 'rotate-180' : '' }} shrink-0"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-card-body-{{ $index + 1 }}"
                                        class="{{ $index === 0 ? '' : 'hidden' }} border border-t-0 border-default rounded-b-base shadow-xs"
                                        aria-labelledby="accordion-card-heading-{{ $index + 1 }}">
                                        <div class="p-4 md:p-5">
                                            <div class="flex justify-between p-2 bg-slate-200 rounded-lg mb-4">
                                                <span class="">Dokter</span>
                                                <span
                                                    class="font-semibold">{{ $rekam->dokter->user->name ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between p-2 bg-slate-200 rounded-lg mb-4">
                                                <span class="">Spesialis</span>
                                                <span
                                                    class="font-semibold">{{ $rekam->dokter->spesialisasi ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between p-2 bg-slate-200 rounded-lg mb-4">
                                                <span class="">Layanan</span>
                                                <span class="font-semibold">{{ $rekam->layanan->nama ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between p-2 bg-slate-200 rounded-lg mb-4">
                                                <span class="">Tanggal Periksa</span>
                                                <span
                                                    class="font-semibold">{{ \Carbon\Carbon::parse($rekam->tanggal_periksa)->format('d M Y') }}</span>
                                            </div>

                                            {{-- Diagnosa --}}
                                            <div class="mb-4 border-2 border-gray-200 rounded-2xl p-6">
                                                <div class="flex items-start mb-3">
                                                    <svg class="w-6 h-6 mr-3 text-gray-700" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <h4 class="text-base font-semibold text-gray-800">Diagnosa / Hasil
                                                        Pemeriksaan</h4>
                                                </div>
                                                <p class="text-gray-700 ml-9">{{ $rekam->diagnosa }}</p>
                                            </div>

                                            {{-- Tindakan --}}
                                            <div class="mb-4 border-2 border-gray-200 rounded-2xl p-6">
                                                <div class="flex items-start mb-3">
                                                    <svg class="w-6 h-6 mr-3 text-gray-700" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                        <path fill-rule="evenodd"
                                                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <h4 class="text-base font-semibold text-gray-800">Tindakan</h4>
                                                </div>
                                                <div class="text-gray-700 ml-9" style="white-space: pre-line;">
                                                    {{ $rekam->tindakan ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
