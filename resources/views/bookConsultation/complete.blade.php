<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lengkapi Rekam Medis - {{ $booking->nama_hewan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Booking Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Informasi Booking</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nama Hewan</p>
                                <p class="font-medium">{{ $booking->nama_hewan }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pemilik</p>
                                <p class="font-medium">{{ $booking->nama_pemilik }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Spesies</p>
                                <p class="font-medium">{{ $booking->spesies }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Ras</p>
                                <p class="font-medium">{{ $booking->ras }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Umur</p>
                                <p class="font-medium">{{ $booking->umur }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Booking</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm text-gray-600">Keluhan</p>
                            <p class="font-medium">{{ $booking->keluhan }}</p>
                        </div>
                    </div>

                    <!-- Rekam Medis Form -->
                    <form action="{{ route('booking.konsultasi.complete', $booking->id) }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="layanan_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Layanan <span class="text-red-500">*</span>
                                </label>
                                <select id="layanan_id" name="layanan_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">Pilih Layanan</option>
                                    @foreach ($layanan as $lay)
                                        <option value="{{ $lay->id }}"
                                            {{ old('layanan_id') == $lay->id ? 'selected' : '' }}>
                                            {{ $lay->nama_layanan }} - Rp
                                            {{ number_format($lay->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="diagnosa" class="block text-sm font-medium text-gray-700 mb-2">
                                    Diagnosa <span class="text-red-500">*</span>
                                </label>
                                <textarea id="diagnosa" name="diagnosa" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Masukkan hasil diagnosa..." required>{{ old('diagnosa') }}</textarea>
                                @error('diagnosa')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tindakan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tindakan <span class="text-red-500">*</span>
                                </label>
                                <textarea id="tindakan" name="tindakan" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Masukkan tindakan yang dilakukan..." required>{{ old('tindakan') }}</textarea>
                                @error('tindakan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                                <a href="{{ route('booking.konsultasi.manage') }}"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Selesaikan Konsultasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
