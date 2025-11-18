@extends('layouts.main')

@section('container')
    <div class="my-10 text-gray-900 font-sans text-center">
        <p class="font-medium text-2xl">Form Booking Layanan</p>
        <p class="text-sm font-normal">Lengkapi Informasi hewan kesayangan Anda untuk melakukan booking</p>
    </div>

    <!-- Form Container -->
    <div class="max-w-xl mx-auto px-4 pb-20">
        <div class="bg-white rounded-3xl border border-gray-200 p-8 shadow-sm">
                    <form action="#" method="POST" id="bookingForm">
                        @csrf
                        
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 bg-vetopia-green rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('images/catIcon.png') }}" alt="Cat Icon" class="w-5 h-5">
                                </div>
                                <h3 class="text-lg font-semibold">Informasi Hewan</h3>
                            </div>

                            <!-- Nama Hewan -->
                            <div class="mb-4">
                                <label for="nama_hewan" class="block text-sm font-medium text-gray-700 mb-2">Nama Hewan</label>
                                <input type="text" id="nama_hewan" name="nama_hewan" placeholder="Contoh : Amba" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500">
                                <span class="error-message text-sm hidden" id="error-nama_hewan" style="color: #ef4444;">Nama hewan harus diisi</span>
                            </div>

                            <!-- Umur and Spesies -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                                    <input type="text" id="umur" name="umur" placeholder="Contoh : 3 Tahun" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500">
                                    <span class="error-message text-sm hidden" id="error-umur" style="color: #ef4444;">Umur hewan harus diisi</span>
                                </div>
                                <div>
                                    <label for="spesies" class="block text-sm font-medium text-gray-700 mb-2">Spesies</label>
                                    <input type="text" id="spesies" name="spesies" placeholder="Contoh : Anjing" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500">
                                    <span class="error-message text-sm hidden" id="error-spesies" style="color: #ef4444;">Spesies hewan harus diisi</span>
                                </div>
                            </div>

                            <!-- Ras -->
                            <div class="mb-4">
                                <label for="ras" class="block text-sm font-medium text-gray-700 mb-2">Ras</label>
                                <input type="text" id="ras" name="ras" placeholder="Contoh: Anjing Kampung" class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500">
                                <span class="error-message text-sm hidden" id="error-ras" style="color: #ef4444;">Ras hewan harus diisi</span>
                            </div>

                            <!-- Keluhan -->
                            <div class="mb-4">
                                <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                                <textarea id="keluhan" name="keluhan" rows="4" placeholder="Contoh: Anjing saya terluka karena bertengkar" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none placeholder-gray-500"></textarea>
                                <span class="error-message text-sm hidden" id="error-keluhan" style="color: #ef4444;">Keluhan harus diisi</span>
                            </div>
                        </div>

                        <!-- Tanggal Booking Section -->
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <span class="error-message text-sm hidden" id="error-tanggal_booking" style="color: #ef4444;">Tanggal booking harus diisi</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-vetopia-green text-black font-semibold py-4 rounded-full hover:bg-green-500 transition-colors">
                            Konfirmasi Booking
                        </button>
                    </form>
                </div>
            </div>

    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Reset all error messages and border colors
            document.querySelectorAll('.error-message').forEach(error => {
                error.classList.add('hidden');
            });
            document.querySelectorAll('input, textarea').forEach(input => {
                input.style.borderColor = '';
                input.classList.remove('border-red-500');
            });
            
            let isValid = true;
            const fields = ['nama_hewan', 'umur', 'spesies', 'ras', 'keluhan', 'tanggal_booking'];
            
            fields.forEach(field => {
                const input = document.getElementById(field);
                const error = document.getElementById('error-' + field);
                
                if (!input.value.trim()) {
                    error.classList.remove('hidden');
                    input.style.borderColor = '#ef4444'; // Tailwind red-500
                    input.classList.add('border-red-500');
                    isValid = false;
                }
            });
            
            if (isValid) {
                // If all fields are valid, submit the form
                this.submit();
            } else {
                // Scroll to first error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Remove error when user starts typing
        document.querySelectorAll('input, textarea').forEach(input => {
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