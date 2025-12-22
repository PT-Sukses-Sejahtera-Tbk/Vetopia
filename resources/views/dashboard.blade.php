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
            
            {{-- === TAMPILAN DASHBOARD USER === --}}
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

                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Jadwal Konsultasi</h3>
                        <p class="text-sm text-gray-500">Menunggu antrean dokter</p>
                    </div>
                    <div>
                        @forelse($upcomingSchedules as $schedule)
                            <div class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="font-bold text-blue-900">{{ $schedule->nama_hewan }}</div>
                                        <div class="text-xs text-blue-600">{{ \Carbon\Carbon::parse($schedule->tanggal_booking)->format('d M Y') }}</div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-white text-blue-800 border border-blue-200">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    Dokter: {{ $schedule->dokter->user->name ?? '-' }}
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-gray-500 italic">Tidak ada jadwal konsultasi aktif.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-indigo-700">Hasil Laboratorium</h3>
                        <p class="text-sm text-gray-500">Riwayat pemeriksaan lab selesai</p>
                    </div>

                    <div class="space-y-4">
                        @if(isset($labResults) && $labResults->count())
                            @foreach($labResults as $lab)
                                <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <span class="text-xs font-bold text-green-700 bg-green-200 px-2 py-0.5 rounded">SELESAI</span>
                                            <h4 class="font-bold text-gray-800 mt-1">{{ $lab->jenis_pemeriksaan }}</h4>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($lab->updated_at)->format('d M Y') }} • Hewan: {{ $lab->nama_hewan }}</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Tombol Lihat Hasil (Modal Trigger) --}}
                                    <button onclick="showLabResult('{{ $lab->jenis_pemeriksaan }}', '{{ $lab->hasil_pemeriksaan }}', '{{ $lab->catatan_dokter }}')" 
                                        class="w-full mt-2 py-1 text-sm text-center text-green-700 bg-white border border-green-200 rounded hover:bg-green-100 transition">
                                        Lihat Hasil
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="text-sm text-gray-500 italic py-4 text-center">Belum ada hasil lab yang keluar.</div>
                        @endif
                    </div>
                </div>

            </div>
            @endrole

            {{-- === TAMPILAN DASHBOARD DOKTER / ADMIN === --}}
            @hasanyrole('doctor|admin')
            <div class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="text-gray-500 text-sm">Total Pasien</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $data['total_users'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="text-gray-500 text-sm">Antrean Konsultasi</div>
                        <div class="text-3xl font-bold text-blue-600">{{ $data['pending_consultations'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="text-gray-500 text-sm">Antrean Lab (Approval)</div>
                        <div class="text-3xl font-bold text-orange-600">{{ $data['pending_lab'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="text-gray-500 text-sm">Hewan Terdaftar</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $data['total_hewan'] ?? 0 }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pasien Terbaru</h2>
                    <ul>
                        @foreach($data['recent_users'] ?? [] as $user)
                        <li class="border-b py-2 last:border-0 flex justify-between">
                            <span>{{ $user->name }}</span>
                            <span class="text-gray-400 text-sm">{{ $user->created_at->diffForHumans() }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endhasanyrole

        </div>
    </div>

    {{-- MODAL KHUSUS HASIL LAB USER --}}
    @role('user')
    <div id="labModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900" id="labModalTitle">Detail Hasil Lab</h3>
                <button onclick="closeLabModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <h4 class="text-sm font-bold text-gray-500 uppercase">Hasil Pemeriksaan</h4>
                    <p class="mt-1 text-gray-800 whitespace-pre-line bg-gray-50 p-3 rounded" id="labModalResult"></p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-500 uppercase">Catatan Dokter</h4>
                    <p class="mt-1 text-gray-800 italic" id="labModalNote"></p>
                </div>
            </div>
            <div class="p-4 bg-gray-50 rounded-b-lg text-right">
                <button onclick="closeLabModal()" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showLabResult(title, result, note) {
            document.getElementById('labModalTitle').innerText = title;
            document.getElementById('labModalResult').innerText = result;
            document.getElementById('labModalNote').innerText = note ? note : '- Tidak ada catatan -';
            document.getElementById('labModal').classList.remove('hidden');
        }

        function closeLabModal() {
            document.getElementById('labModal').classList.add('hidden');
        }
    </script>
    @endrole

</x-app-layout>