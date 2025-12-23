<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pemeriksaan Lab') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Antrean Lab</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Lab</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pemeriksaans as $lab)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($lab->tanggal_booking)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="font-bold">{{ $lab->nama_hewan }}</div>
                                        <div class="text-xs text-gray-500">{{ $lab->spesies }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $lab->nama_pemilik }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <span class="font-medium">{{ $lab->jenis_pemeriksaan }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'dikonfirmasi' => 'bg-blue-100 text-blue-800',
                                                'menunggu_approval' => 'bg-orange-100 text-orange-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'dibatalkan' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusLabel = [
                                                'menunggu_approval' => 'Butuh Approval',
                                                'pending' => 'Pending',
                                                'dikonfirmasi' => 'Dikonfirmasi',
                                                'selesai' => 'Selesai',
                                                'dibatalkan' => 'Batal'
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$lab->status] ?? 'bg-gray-100' }}">
                                            {{ $statusLabel[$lab->status] ?? ucfirst($lab->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2 items-center">
                                            <button onclick="showDetail({{ $lab->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold mr-2">Detail</button>

                                            @if($lab->status == 'pending')
                                                <form action="{{ route('pemeriksaan.lab.updateStatus', $lab->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="dikonfirmasi">
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900 font-semibold">Konfirmasi</button>
                                                </form>
                                            
                                            @elseif($lab->status == 'dikonfirmasi')
                                                @role('doctor')
                                                    <a href="{{ route('pemeriksaan.lab.complete.form', $lab->id) }}" class="text-purple-600 hover:text-purple-900 font-bold border border-purple-600 px-3 py-1 rounded hover:bg-purple-50">Isi Hasil</a>
                                                @else
                                                    <span class="text-gray-400 italic text-xs">Menunggu Dokter</span>
                                                @endrole

                                            @elseif($lab->status == 'menunggu_approval')
                                                @role('admin')
                                                    <form action="{{ route('pemeriksaan.lab.updateStatus', $lab->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="selesai">
                                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold">✓ Approve</button>
                                                    </form>
                                                @else
                                                    <span class="text-orange-500 italic text-xs">Menunggu Admin</span>
                                                @endrole
                                            @endif
                                            
                                            @if(!in_array($lab->status, ['selesai', 'dibatalkan']))
                                                <form action="{{ route('pemeriksaan.lab.updateStatus', $lab->id) }}" method="POST" onsubmit="return confirm('Yakin batalkan?')">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="dibatalkan">
                                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Batal</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada antrean.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Detail Pemeriksaan Lab</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div id="modalContent" class="mt-4"></div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        const labData = @json($pemeriksaans);

        function showDetail(id) {
            const lab = labData.find(d => d.id === id);
            if (!lab) return;

            const date = new Date(lab.tanggal_booking);
            const formattedDate = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            const content = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div><p class="text-sm font-medium text-gray-500">Nama Hewan</p><p class="font-bold">${lab.nama_hewan}</p></div>
                        <div><p class="text-sm font-medium text-gray-500">Pemilik</p><p class="font-bold">${lab.nama_pemilik}</p></div>
                        <div><p class="text-sm font-medium text-gray-500">Status</p><p>${lab.status}</p></div>
                    </div>
                    <div class="border-t pt-3">
                        <p class="text-sm font-medium text-gray-500">Jenis Lab</p><p class="text-lg font-semibold text-indigo-700">${lab.jenis_pemeriksaan}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded"><p class="text-sm font-medium text-gray-500">Keluhan</p><p class="italic">"${lab.keluhan_atau_alasan}"</p></div>
                    ${(lab.status === 'menunggu_approval' || lab.status === 'selesai') && lab.hasil_pemeriksaan ? `
                    <div class="bg-green-50 p-3 rounded border border-green-200 mt-3">
                        <p class="text-sm font-bold text-green-800 mb-1">Hasil:</p><p class="text-sm text-gray-800 whitespace-pre-wrap">${lab.hasil_pemeriksaan}</p>
                    </div>` : ''}
                </div>
            `;
            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() { document.getElementById('detailModal').classList.add('hidden'); }
        document.getElementById('detailModal').addEventListener('click', function(e) { if (e.target === this) closeModal(); });
    </script>
</x-app-layout>