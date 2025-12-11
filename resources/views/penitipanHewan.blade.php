@extends('layouts.main')

@section('container')
    <div class="my-10 text-gray-900 font-sans text-center">
        <p class="font-medium text-2xl">Form Penitipan Hewan</p>
        <p class="text-sm font-normal">Lengkapi Informasi hewan kesayangan Anda untuk melakukan Penitipan Hewan</p>
    </div>

    <div class="max-w-xl mx-auto px-4 mb-6">
        @if (session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div>
                    <span class="font-medium">Berhasil!</span> {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <div>
                    <span class="font-medium">Gagal!</span>
                    @if (session('error'))
                        <p>{{ session('error') }}</p>
                    @endif
                    @if ($errors->any())
                        <ul class="mt-1.5 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div class="max-w-xl mx-auto px-4 pb-20">
        <div class="bg-white rounded-3xl border border-gray-200 p-8 shadow-sm">
            <form action="{{ route('penitipan.hewan.store') }}" method="POST" id="penitipanForm">
                @csrf

                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-vetopia-green rounded-lg flex items-center justify-center">
                            <img src="{{ asset('images/catIcon.png') }}" alt="Cat Icon" class="w-5 h-5">
                        </div>
                        <h3 class="text-lg font-semibold">Informasi Hewan</h3>
                    </div>

                    <div class="mb-4">
                        <label for="hewan_id" class="block text-sm font-medium text-gray-700 mb-2">Nama Hewan</label>
                        <select id="hewan_id" name="hewan_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <option value="">Pilih Hewan</option>
                            @foreach ($hewans as $hewan)
                                <option value="{{ $hewan->id }}" data-umur="{{ $hewan->umur }}"
                                    data-jenis="{{ $hewan->jenis }}" data-ras="{{ $hewan->ras }}"
                                    {{ old('hewan_id') == $hewan->id ? 'selected' : '' }}>
                                    {{ $hewan->nama }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error-message text-sm hidden" id="error-hewan_id" style="color: #ef4444;">Pilih hewan
                            terlebih dahulu</span>
                    </div>

                    <div class="mb-4">
                        <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                        <input type="text" id="umur" name="umur" value="{{ old('umur') }}" readonly
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                            placeholder="Otomatis terisi">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="spesies" class="block text-sm font-medium text-gray-700 mb-2">Spesies</label>
                            <input type="text" id="spesies" name="spesies" value="{{ old('spesies') }}" readonly
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                                placeholder="Otomatis terisi">
                        </div>

                        <div>
                            <label for="ras" class="block text-sm font-medium text-gray-700 mb-2">Ras</label>
                            <input type="text" id="ras" name="ras" value="{{ old('ras') }}" readonly
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                                placeholder="Otomatis terisi">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat_rumah" class="block text-sm font-medium text-gray-700 mb-2">Alamat Rumah</label>
                        <textarea id="alamat_rumah" name="alamat_rumah" rows="3"
                            placeholder="Contoh: Jl. Cijerah Indah Blok B4 No. 12, Kel. Cijerah, Kec. Bandung Kulon, Kota Bandung, Jawa Barat, 40213"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none placeholder-gray-500">{{ old('alamat_rumah') }}</textarea>
                        <span class="error-message text-sm hidden" id="error-alamat_rumah" style="color: #ef4444;">Alamat
                            rumah harus diisi</span>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-vetopia-green rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold">Tanggal Titip</h3>
                    </div>

                    <div class="mb-4">
                        <input type="date" id="tanggal_titip" name="tanggal_titip" value="{{ old('tanggal_titip') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer">
                        <span class="error-message text-sm hidden" id="error-tanggal_titip"
                            style="color: #ef4444;">Tanggal titip harus diisi</span>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-vetopia-green rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold">Tanggal Ambil</h3>
                    </div>

                    <div class="mb-4">
                        <input type="date" id="tanggal_ambil" name="tanggal_ambil"
                            value="{{ old('tanggal_ambil') }}" min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer">
                        <span class="error-message text-sm hidden" id="error-tanggal_ambil"
                            style="color: #ef4444;">Tanggal ambil harus diisi</span>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Jenis Service</label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button"
                            class="service-btn px-6 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-vetopia-green hover:bg-green-50 transition-colors {{ old('jenis_service') == 'pick-up' ? 'border-vetopia-green bg-green-50' : '' }}"
                            data-value="pick-up">
                            Pick - UP
                        </button>
                        <button type="button"
                            class="service-btn px-6 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-vetopia-green hover:bg-green-50 transition-colors {{ old('jenis_service') == 'drop-off' ? 'border-vetopia-green bg-green-50' : '' }}"
                            data-value="drop-off">
                            Drop-Off
                        </button>
                    </div>
                    <input type="hidden" id="jenis_service" name="jenis_service" value="{{ old('jenis_service') }}">
                    <span class="error-message text-sm hidden" id="error-jenis_service" style="color: #ef4444;">Jenis
                        service harus dipilih</span>
                </div>

                <button type="submit"
                    class="w-full bg-vetopia-green text-black font-semibold py-4 rounded-full hover:bg-green-500 transition-colors">
                    Konfirmasi Booking
                </button>
            </form>
        </div>
    </div>

    <script>
        // Make date inputs clickable to open picker
        document.getElementById('tanggal_titip').addEventListener('click', function() {
            try {
                this.showPicker();
            } catch (e) {
                // Fallback for browsers that don't support showPicker()
                this.focus();
            }
        });

        document.getElementById('tanggal_ambil').addEventListener('click', function() {
            try {
                this.showPicker();
            } catch (e) {
                // Fallback for browsers that don't support showPicker()
                this.focus();
            }
        });

        // Auto-fill hewan data when selected
        document.getElementById('hewan_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (selectedOption.value) {
                // Fill the fields with selected hewan data
                document.getElementById('umur').value = selectedOption.dataset.umur + ' Tahun';
                document.getElementById('spesies').value = selectedOption.dataset.jenis;
                document.getElementById('ras').value = selectedOption.dataset.ras;

                // Hide error
                document.getElementById('error-hewan_id').classList.add('hidden');
                this.style.borderColor = '';
                this.classList.remove('border-red-500');
            } else {
                // Clear fields if no selection
                document.getElementById('umur').value = '';
                document.getElementById('spesies').value = '';
                document.getElementById('ras').value = '';
            }
        });

        // Handle service button selection
        document.querySelectorAll('.service-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active state from all buttons
                document.querySelectorAll('.service-btn').forEach(b => {
                    b.classList.remove('border-vetopia-green', 'bg-green-50');
                    b.classList.add('border-gray-300');
                });

                // Add active state to clicked button
                this.classList.remove('border-gray-300');
                this.classList.add('border-vetopia-green', 'bg-green-50');

                // Set hidden input value
                document.getElementById('jenis_service').value = this.dataset.value;

                // Hide error if exists
                document.getElementById('error-jenis_service').classList.add('hidden');
            });
        });

        document.getElementById('penitipanForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Reset all error messages
            document.querySelectorAll('.error-message').forEach(error => {
                error.classList.add('hidden');
            });
            document.querySelectorAll('input, textarea, select').forEach(input => {
                input.style.borderColor = '';
                input.classList.remove('border-red-500');
            });

            let isValid = true;

            // Validasi visual
            const fields = ['hewan_id', 'alamat_rumah', 'tanggal_titip', 'tanggal_ambil', 'jenis_service'];

            fields.forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    const error = document.getElementById('error-' + field);
                    // Cek jika kosong
                    if (!input.value.trim()) {
                        if (error) error.classList.remove('hidden');

                        if (input.type !== 'hidden') {
                            input.style.borderColor = '#ef4444';
                            input.classList.add('border-red-500');
                        }
                        isValid = false;
                    }
                }
            });

            if (isValid) {
                this.submit();
            } else {
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        });

        // Remove error when user starts typing or selecting
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('input', function() {
                const error = document.getElementById('error-' + this.id);
                if (error && this.value.trim()) {
                    error.classList.add('hidden');
                    this.style.borderColor = '';
                    this.classList.remove('border-red-500');
                }
            });

            input.addEventListener('change', function() {
                const error = document.getElementById('error-' + this.id);
                if (error && this.value.trim()) {
                    error.classList.add('hidden');
                    this.style.borderColor = '';
                    this.classList.remove('border-red-500');
                }
            });
        });
    </script>
@endsection
