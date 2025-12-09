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
                    <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 text-white">
                        <h3 class="text-lg font-semibold mb-6">Data Pasien</h3>
                        
                        <!-- Avatar and Name -->
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-2xl">
                                {{ strtoupper(substr($hewan->nama, 0, 2)) }}
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-xl">{{ $hewan->nama }}</h4>
                                <span class="bg-green-200 text-green-800 text-xs px-2 py-1 rounded">ID: #{{ str_pad($hewan->id, 5, '0', STR_PAD_LEFT) }}</span>
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

                        <!-- Rekam Medis Item 1 -->
                        <div class="mb-4 border-2 border-gray-200 rounded-2xl p-6">
                            <div class="flex items-start mb-3">
                                <svg class="w-6 h-6 mr-3 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                                <h4 class="text-base font-semibold text-gray-800">Keluhan Awal</h4>
                            </div>
                            <p class="text-gray-700 ml-9">Hewan Lemas tidak mau makan</p>
                        </div>

                        <!-- Rekam Medis Item 2 -->
                        <div class="mb-4 border-2 border-gray-200 rounded-2xl p-6">
                            <div class="flex items-start mb-3">
                                <svg class="w-6 h-6 mr-3 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="text-base font-semibold text-gray-800">Diagonsa Dokter/ Hasil Pemeriksaan</h4>
                            </div>
                            <p class="text-gray-700 ml-9">Ditemukan Infeksi saluran pernapasan</p>
                        </div>

                        <!-- Rekam Medis Item 3 -->
                        <div class="mb-4 border-2 border-gray-200 rounded-2xl p-6">
                            <div class="flex items-start mb-3">
                                <svg class="w-6 h-6 mr-3 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="text-base font-semibold text-gray-800">Resep Obat dan Tindakan</h4>
                            </div>
                            <div class="text-gray-700 ml-9">
                                <ol class="list-decimal list-inside space-y-1">
                                    <li>AntiBiotik 3x sehari</li>
                                    <li class="ml-6">Vitamin B</li>
                                </ol>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
