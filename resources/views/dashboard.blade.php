<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Selamat datang, ') }}@role('doctor')Dr. @endrole{{ Auth::user()->name }}!
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @role('user')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <h3 class="text-lg font-semibold mb-4">Hewan Terdaftar : {{ $userHewans->count() }}</h3>
                    
                    @if($userHewans->count() > 0)
                        <div class="mb-6 space-y-2">
                            @foreach($userHewans as $hewan)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                                        <span class="text-sm font-bold text-orange-600">
                                            {{ strtoupper(substr($hewan->nama, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $hewan->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $hewan->jenis }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
</x-app-layout>
