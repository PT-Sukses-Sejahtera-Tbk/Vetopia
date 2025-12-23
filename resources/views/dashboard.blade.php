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
            <!-- Quick Actions Banner -->
            <div class="mb-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg">Riwayat Booking Konsultasi</h3>
                            <p class="text-blue-100 text-sm">Lihat status booking dan lakukan pembayaran</p>
                        </div>
                    </div>
                    <a href="{{ route('booking.myBookings') }}" 
                       class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold text-sm rounded-lg hover:bg-blue-50 transition duration-150 shadow-md">
                        Lihat Riwayat
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

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

                    <div>
                        @if(isset($upcomingSchedules) && $upcomingSchedules->count())
                            @foreach($upcomingSchedules as $schedule)
                                <div class="mb-4 p-5 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->tanggal_booking)->format('d M Y') }}</div>
                                    <div class="font-medium text-base">{{ $schedule->title ?? ($schedule->layanan->nama ?? 'Konsultasi') }}</div>
                                    <div class="text-sm text-gray-500">Dokter: {{ $schedule->dokter->user->name ?? ($schedule->dokter->name ?? '-') }}</div>
                                    <div class="mt-2">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full 
                                            @if($schedule->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($schedule->status == 'dikonfirmasi') bg-blue-100 text-blue-800
                                            @elseif($schedule->status == 'diperiksa') bg-purple-100 text-purple-800
                                            @elseif($schedule->status == 'selesai') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            @if($schedule->status == 'pending') Pending
                                            @elseif($schedule->status == 'dikonfirmasi') Dikonfirmasi
                                            @elseif($schedule->status == 'diperiksa') Diperiksa
                                            @elseif($schedule->status == 'selesai') Selesai
                                            @else {{ ucfirst($schedule->status) }}
                                            @endif
                                        </span>
                                    </div>
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
