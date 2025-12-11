<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Penitipan Hewan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Table Container -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Hewan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Pemilik
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Spesies
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Titip
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Ambil
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Service
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($penitipans as $penitipan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $i++ }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $penitipan->nama_hewan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $penitipan->nama_pemilik }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $penitipan->spesies }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($penitipan->tanggal_titip)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($penitipan->tanggal_ambil)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $penitipan->jenis_service == 'pick-up' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ ucfirst($penitipan->jenis_service) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($penitipan->status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($penitipan->status == 'approved')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                            @elseif($penitipan->status == 'rejected')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($penitipan->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="showDetail({{ $penitipan->id }})"
                                                class="text-blue-600 hover:text-blue-900 mr-3">Detail</button>
                                            <form action="#" method="POST" class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus penitipan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data penitipan hewan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Detail Penitipan Hewan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="mt-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        const penitipanData = @json($penitipans);

        function showDetail(id) {
            const penitipan = penitipanData.find(p => p.id === id);
            if (!penitipan) return;

            const content = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Hewan</p>
                            <p class="mt-1 text-sm text-gray-900">${penitipan.nama_hewan}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Pemilik</p>
                            <p class="mt-1 text-sm text-gray-900">${penitipan.nama_pemilik}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Umur</p>
                            <p class="mt-1 text-sm text-gray-900">${penitipan.umur}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Spesies</p>
                            <p class="mt-1 text-sm text-gray-900">${penitipan.spesies}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ras</p>
                            <p class="mt-1 text-sm text-gray-900">${penitipan.ras}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jenis Service</p>
                            <p class="mt-1 text-sm text-gray-900">${penitipan.jenis_service.toUpperCase()}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Titip</p>
                            <p class="mt-1 text-sm text-gray-900">${new Date(penitipan.tanggal_titip).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Ambil</p>
                            <p class="mt-1 text-sm text-gray-900">${new Date(penitipan.tanggal_ambil).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Alamat Rumah</p>
                        <p class="mt-1 text-sm text-gray-900">${penitipan.alamat_rumah}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                ${penitipan.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                  penitipan.status === 'approved' ? 'bg-green-100 text-green-800' : 
                                  'bg-red-100 text-red-800'}">
                                ${penitipan.status.charAt(0).toUpperCase() + penitipan.status.slice(1)}
                            </span>
                        </p>
                    </div>
                </div>
            `;

            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>
