<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Selamat datang, ') }}@role('doctor')Dr. @endrole{{ Auth::user()->name }}!
            </h2>

            <div class="flex items-center gap-4">
                {{-- Hewan avatars (user only) --}}
                @role('user')
                <div class="flex items-center gap-2">
                    @if(isset($userHewans) && $userHewans->count())
                        @foreach($userHewans as $h)
                            <form method="POST" action="{{ route('dashboard.setPet', $h->id) }}" class="inline">
                                @csrf
                                <button type="submit" title="{{ $h->nama }}" class="w-10 h-10 rounded-full overflow-hidden border-2 transition {{ ($mainPet && $mainPet->id === $h->id) ? 'border-vetopia-green' : 'border-gray-200' }} hover:border-vetopia-green">
                                    @if(isset($h->photo) && $h->photo)
                                        <img src="{{ asset($h->photo) }}" alt="{{ $h->nama }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-sm text-gray-600">{{ substr($h->nama,0,1) }}</div>
                                    @endif
                                </button>
                            </form>
                        @endforeach
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-sm text-gray-600">-</div>
                    @endif
                </div>

                {{-- Button add hewan (opens modal) --}}
                <button id="openAddHewan" class="w-10 h-10 rounded-full bg-vetopia-green text-black flex items-center justify-center text-xl hover:bg-green-500 transition">+</button>
                @endrole
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @role('user')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Pet Profile Card -->
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="rounded-xl overflow-hidden">
                            @if(isset($mainPet) && ($mainPet->photo ?? false))
                                <img src="{{ asset($mainPet->photo) }}" alt="{{ $mainPet->nama }}" class="w-full h-72 object-cover">
                            @else
                                <img src="{{ asset('images/home/pet-placeholder.png') }}" alt="pet" class="w-full h-72 object-cover">
                            @endif
                        </div>

                        <div class="mt-6 text-gray-700 text-lg">
                            <div class="flex justify-between mb-4">
                                <span class="font-semibold">Nama:</span>
                                <span class="font-medium">{{ $mainPet->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="font-semibold">Species:</span>
                                <span class="font-medium">{{ $mainPet->jenis ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="font-semibold">Ras:</span>
                                <span class="font-medium">{{ $mainPet->ras ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="font-semibold">Umur:</span>
                                <span class="font-medium">{{ isset($mainPet) ? $mainPet->umur . ' tahun' : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Schedule Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Upcoming schedule</h3>
                        <p class="text-sm text-gray-500">Jadwal konsultasi yang akan datang</p>
                    </div>

                        <div class="mb-6">
                        {{-- Simple calendar placeholder (static) --}}
                        <div class="w-full h-72 bg-gray-50 rounded-xl p-6 flex items-center justify-center text-gray-400">
                            <div class="text-center">
                                <div class="text-2xl font-semibold">{{ now()->format('M') }}</div>
                                <div class="text-4xl mt-2">{{ now()->format('d') }}</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        @if(isset($upcomingSchedules) && $upcomingSchedules->count())
                            @foreach($upcomingSchedules as $schedule)
                                <div class="mb-4 p-5 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->tanggal_booking)->format('d M Y') }}</div>
                                    <div class="font-medium text-base">{{ $schedule->title ?? ($schedule->layanan->nama ?? 'Konsultasi') }}</div>
                                    <div class="text-sm text-gray-500">Dokter: {{ $schedule->dokter->user->name ?? ($schedule->dokter->name ?? '-') }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-sm text-gray-500">Tidak ada jadwal konsultasi yang akan datang.</div>
                        @endif
                    </div>
                </div>

                <!-- History Checkup Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <h3 class="text-lg font-semibold mb-4">History Check up</h3>

                    @if(isset($mainPet) && method_exists($mainPet, 'rekamMedis') && $mainPet->rekamMedis()->count())
                        <ul class="space-y-4 text-sm">
                            @foreach($mainPet->rekamMedis()->latest()->take(5)->get() as $record)
                                <li class="p-3 border border-gray-100 rounded-lg">
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($record->tanggal_periksa)->format('d M Y') }}</div>
                                    <div class="font-medium">{{ $record->diagnosa }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit($record->tindakan, 120) }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-sm text-gray-500">Belum ada riwayat pemeriksaan.</div>
                    @endif
                </div>
            </div>
            @endrole

            @role('doctor')
            <div class="space-y-8">
                <!-- Consultation Schedule Section -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Jadwal Konsultasi Pasien</h2>
                        <p class="text-sm text-gray-500">Daftar jadwal konsultasi dari pasien Anda</p>
                    </div>

                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada jadwal konsultasi atau fitur masih dalam pengembangan.</p>
                    </div>
                </div>

                <!-- Medical Records Section -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Hasil Pemeriksaan Lab Pasien</h2>
                        <p class="text-sm text-gray-500">Daftar rekam medis dan hasil pemeriksaan yang telah Anda buat</p>
                    </div>

                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada rekam medis atau fitur masih dalam pengembangan.</p>
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>

    <!-- Add Hewan Modal (user only) -->
    @role('user')
    <div id="modalAddHewan" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl w-full max-w-xl p-6 mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Tambah Data Hewan</h3>
                <button id="closeAddHewan" class="text-gray-500">&times;</button>
            </div>

            <form id="formAddHewan" action="{{ route('hewan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Umur (tahun)</label>
                        <input type="number" name="umur" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                        <input type="text" name="jenis" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ras / Breed</label>
                        <input type="text" name="ras" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Hewan (opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full">
                        <p class="text-xs text-gray-400 mt-1">Format: jpeg,png,gif,webp — Maks 5MB</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" id="cancelAddHewan" class="px-4 py-2 rounded-lg border border-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-vetopia-green text-black font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const openBtn = document.getElementById('openAddHewan');
        const modal = document.getElementById('modalAddHewan');
        const closeBtn = document.getElementById('closeAddHewan');
        const cancelBtn = document.getElementById('cancelAddHewan');

        if (openBtn) openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
        if (closeBtn) closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
        if (cancelBtn) cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        // Close modal when clicking outside dialog
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    </script>
    @endrole
</x-app-layout>
