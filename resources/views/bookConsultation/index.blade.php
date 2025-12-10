@extends('layouts.main')

@section('container')
    <div class="my-10 text-gray-900 font-sans text-center">
        <p class="font-medium text-2xl">Form Booking Layanan</p>
        <p class="text-sm font-normal">Lengkapi Informasi hewan kesayangan Anda untuk melakukan booking</p>
    </div>

@if(session('success'))
    <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
        <span class="font-medium">Berhasil!</span> {{ session('success') }}
    </div>
@endif

@if(session('error') || $errors->any())
    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
        </svg>
        <span class="font-medium">Gagal!</span> 
        @if(session('error'))
            {{ session('error') }}
        @else
            Mohon periksa kembali isian formulir Anda.
        @endif
    </div>
@endif

<div class="max-w-xl mx-auto px-4 pb-20">
    <div class="bg-white rounded-3xl border border-gray-200 p-8 shadow-sm">
        <form id="bookingForm" action="{{ route('booking.konsultasi.store') }}" method="POST">
            @csrf
            
            {{-- ========================= --}}
            {{-- Informasi Hewan --}}
            {{-- ========================= --}}
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-vetopia-green rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/catIcon.png') }}" alt="Cat Icon" class="w-5 h-5">
                    </div>
                    <h3 class="text-lg font-semibold">Informasi Hewan</h3>
                </div>

                {{-- Nama --}}
                <div class="mb-4">
                    <label for="nama_hewan" class="block text-sm font-medium text-gray-700 mb-2">Nama Hewan</label>
                    <input type="text" id="nama_hewan" name="nama_hewan" 
                           value="{{ old('nama_hewan') }}" 
                           placeholder="Contoh : Amba" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500">
                    <span class="error-message text-sm hidden" id="error-nama_hewan" style="color: #ef4444;">Nama hewan harus diisi</span>
                </div>

                {{-- Umur (baru: angka + satuan) --}}
                <div class="mb-4">
                    <label for="umur_angka" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                    <div class="flex">
                        <input type="number" id="umur_angka" name="umur_angka" 
                               value="{{ old('umur_angka') }}"
                               placeholder="Contoh: 3" 
                               class="w-2/3 px-4 py-3 border border-r-0 border-gray-300 rounded-l-lg placeholder-gray-500 focus:ring-0 focus:border-gray-300">
                        
                        <select id="satuan_umur" name="satuan_umur" 
                                class="w-1/3 px-4 py-3 border border-l-0 border-gray-300 rounded-r-lg bg-gray-50 text-gray-700 focus:ring-0 focus:border-gray-300">
                            <option value="Tahun" {{ old('satuan_umur') == 'Tahun' ? 'selected' : '' }}>Tahun</option>
                            <option value="Bulan" {{ old('satuan_umur') == 'Bulan' ? 'selected' : '' }}>Bulan</option>
                            <option value="Minggu" {{ old('satuan_umur') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                        </select>
                    </div>
                    <span class="error-message text-sm hidden" id="error-umur_angka" style="color: #ef4444;">Umur harus diisi</span>
                    <span class="error-message text-sm hidden" id="error-satuan_umur" style="color: #ef4444;">Satuan umur harus diisi</span>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="spesies" class="block text-sm font-medium text-gray-700 mb-2">Spesies</label>
                        <input type="text" id="spesies" name="spesies" 
                               value="{{ old('spesies') }}"
                               placeholder="Contoh : Anjing" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500">
                        <span class="error-message text-sm hidden" id="error-spesies" style="color: #ef4444;">Spesies harus diisi</span>
                    </div>
                    <div>
                        <label for="ras" class="block text-sm font-medium text-gray-700 mb-2">Ras</label>
                        <input type="text" id="ras" name="ras" 
                               value="{{ old('ras') }}"
                               placeholder="Contoh: Anjing Kampung" class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500">
                        <span class="error-message text-sm hidden" id="error-ras" style="color: #ef4444;">Ras harus diisi</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                    <textarea id="keluhan" name="keluhan" rows="4" 
                              placeholder="Contoh: Anjing saya terluka karena bertengkar" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none placeholder-gray-500">{{ old('keluhan') }}</textarea>
                    <span class="error-message text-sm hidden" id="error-keluhan" style="color: #ef4444;">Keluhan harus diisi</span>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- Tanggal --}}
            {{-- ========================= --}}
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-vetopia-green rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold">Tanggal Booking</h3>
                </div>

                <div class="mb-4">
                    <input type="date" id="tanggal_booking" name="tanggal_booking" 
                           value="{{ old('tanggal_booking') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <span class="error-message text-sm hidden" id="error-tanggal_booking" style="color: #ef4444;">Tanggal booking harus diisi</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-vetopia-green text-black font-semibold py-4 rounded-full hover:bg-green-500 transition-colors">
                Konfirmasi Booking
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    document.querySelectorAll('.error-message').forEach(error => error.classList.add('hidden'));
    document.querySelectorAll('input, textarea, select').forEach(input => {
        input.style.borderColor = '';
        input.classList.remove('border-red-500');
    });
    
    let isValid = true;
    const fields = ['nama_hewan','umur_angka','satuan_umur','spesies','ras','keluhan','tanggal_booking'];
    
    fields.forEach(field => {
        const input = document.getElementById(field);
        const error = document.getElementById('error-' + field);
        
        if (!input.value.trim()) {
            error.classList.remove('hidden');
            input.style.borderColor = '#ef4444';
            input.classList.add('border-red-500');
            isValid = false;
        }
    });

    if (isValid) {
        this.submit();
    } else {
        const firstError = document.querySelector('.border-red-500');
        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

document.querySelectorAll('input, textarea, select').forEach(input => {
    input.addEventListener('input', function() {
        const error = document.getElementById('error-' + this.id);
        if (this.value.trim()) {
            error.classList.add('hidden');
            this.style.borderColor = '';
            this.classList.remove('border-red-500');
        }
    });
});
</script>

@endsection
