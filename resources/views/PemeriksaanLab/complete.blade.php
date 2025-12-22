<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Hasil Pemeriksaan Lab') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h3 class="font-bold text-lg mb-3 text-blue-800 border-b border-blue-200 pb-2">Data Pasien</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="mb-1"><strong class="text-gray-700">Hewan:</strong> <br> {{ $lab->nama_hewan }} ({{ $lab->spesies }})</p>
                                <p class="mb-1"><strong class="text-gray-700">Pemilik:</strong> <br> {{ $lab->nama_pemilik }}</p>
                            </div>
                            <div>
                                <p class="mb-1"><strong class="text-gray-700">Jenis Pemeriksaan:</strong> <br> 
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $lab->jenis_pemeriksaan }}
                                    </span>
                                </p>
                                <p class="mb-1"><strong class="text-gray-700">Rencana Datang:</strong> <br> {{ \Carbon\Carbon::parse($lab->tanggal_booking)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-blue-200">
                            <p><strong class="text-gray-700">Keluhan / Alasan:</strong> <br> <span class="italic text-gray-600">"{{ $lab->keluhan_atau_alasan }}"</span></p>
                        </div>
                    </div>

                    <form action="{{ route('pemeriksaan.lab.complete', $lab->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Analisis Lab <span class="text-red-500">*</span></label>
                            <textarea name="hasil_pemeriksaan" rows="6" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan / Rekomendasi Dokter</label>
                            <textarea name="catatan_dokter" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('pemeriksaan.lab.manage') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-medium">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-bold shadow-md">Simpan & Selesai</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>