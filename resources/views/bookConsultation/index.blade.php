<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Booking Konsultasi
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

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Tabs -->
                    <div class="mb-6">
                        <ul
                            class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                            <li class="me-2">
                                <a href="#" data-tab="pending" onclick="switchTab(event, 'pending')"
                                    class="tab-link inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active">
                                    Pending
                                </a>
                            </li>
                            <li class="me-2">
                                <a href="#" data-tab="dikonfirmasi" onclick="switchTab(event, 'dikonfirmasi')"
                                    class="tab-link inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50">
                                    Dikonfirmasi
                                </a>
                            </li>
                            <li class="me-2">
                                <a href="#" data-tab="diperiksa" onclick="switchTab(event, 'diperiksa')"
                                    class="tab-link inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50">
                                    Diperiksa
                                </a>
                            </li>
                            <li class="me-2">
                                <a href="#" data-tab="menunggu-pembayaran" onclick="switchTab(event, 'menunggu-pembayaran')"
                                    class="tab-link inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50">
                                    Menunggu Pembayaran
                                </a>
                            </li>
                            <li class="me-2">
                                <a href="#" data-tab="selesai" onclick="switchTab(event, 'selesai')"
                                    class="tab-link inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50">
                                    Selesai
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Pending Tab Content -->
                    <div id="pending-content" class="tab-content">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Hewan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pemilik</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            PJ</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Spesies</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Booking</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Keluhan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $pendingData = $bookings->where('status', 'pending'); @endphp
                                    @forelse ($pendingData as $index => $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->nama_hewan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->nama_pemilik }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->dokter ? 'Dr. ' . $booking->dokter->name : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->spesies }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($booking->keluhan, 30) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="showDetail({{ $booking->id }})"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Detail</button>
                                                @role('doctor')
                                                    <form
                                                        action="{{ route('booking.konsultasi.updateStatus', $booking->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="dikonfirmasi">
                                                        <button type="submit"
                                                            class="text-green-600 hover:text-green-900">Konfirmasi</button>
                                                    </form>
                                                @endrole
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Belum
                                                ada data pending</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Dikonfirmasi Tab Content -->
                    <div id="dikonfirmasi-content" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Hewan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pemilik</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            PJ</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Spesies</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Booking</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Keluhan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $dikonfirmasiData = $bookings->where('status', 'dikonfirmasi'); @endphp
                                    @forelse ($dikonfirmasiData as $index => $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->nama_hewan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->nama_pemilik }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->dokter ? 'Dr. ' . $booking->dokter->name : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->spesies }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($booking->keluhan, 30) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="showDetail({{ $booking->id }})"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Detail</button>
                                                @role('doctor')
                                                    <form
                                                        action="{{ route('booking.konsultasi.updateStatus', $booking->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="diperiksa">
                                                        <button type="submit"
                                                            class="text-green-600 hover:text-green-900">Periksa</button>
                                                    </form>
                                                @endrole
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Belum
                                                ada data dikonfirmasi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Diperiksa Tab Content -->
                    <div id="diperiksa-content" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Hewan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pemilik</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            PJ</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Spesies</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Booking</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Keluhan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $diperiksaData = $bookings->where('status', 'diperiksa'); @endphp
                                    @forelse ($diperiksaData as $index => $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->nama_hewan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->nama_pemilik }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->dokter ? 'Dr. ' . $booking->dokter->name : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->spesies }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($booking->keluhan, 30) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="showDetail({{ $booking->id }})"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Detail</button>
                                                @role('doctor')
                                                    <a href="{{ route('booking.konsultasi.complete.form', $booking->id) }}"
                                                        class="text-green-600 hover:text-green-900">Selesaikan</a>
                                                @endrole
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Belum ada data diperiksa</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Menunggu Pembayaran Tab Content -->
                    <div id="menunggu-pembayaran-content" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Hewan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pemilik</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            PJ</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Spesies</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Booking</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Biaya</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $menungguPembayaranData = $bookings->where('status', 'menunggu pembayaran'); @endphp
                                    @forelse ($menungguPembayaranData as $index => $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->nama_hewan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->nama_pemilik }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->dokter ? 'Dr. ' . $booking->dokter->name : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->spesies }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                                Rp {{ number_format($booking->biaya, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <button onclick="showDetail({{ $booking->id }})"
                                                    class="text-blue-600 hover:text-blue-900">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Tidak ada booking menunggu pembayaran
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Selesai Tab Content -->
                    <div id="selesai-content" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Hewan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pemilik</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            PJ</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Spesies</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Booking</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Keluhan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $selesaiData = $bookings->where('status', 'selesai'); @endphp
                                    @forelse ($selesaiData as $index => $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->nama_hewan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->nama_pemilik }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->dokter ? 'Dr. ' . $booking->dokter->name : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->spesies }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($booking->keluhan, 30) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="showDetail({{ $booking->id }})"
                                                    class="text-blue-600 hover:text-blue-900">Detail</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Belum ada data selesai</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Detail Booking Konsultasi</h3>
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
        const bookingData = @json($bookings);

        function switchTab(event, tabName) {
            event.preventDefault();

            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            document.querySelectorAll('.tab-link').forEach(tab => {
                tab.classList.remove('text-blue-600', 'bg-gray-100', 'active');
                tab.classList.add('hover:text-gray-600', 'hover:bg-gray-50');
            });

            document.getElementById(tabName + '-content').classList.remove('hidden');

            event.target.classList.add('text-blue-600', 'bg-gray-100', 'active');
            event.target.classList.remove('hover:text-gray-600', 'hover:bg-gray-50');
        }

        function showDetail(id) {
            const booking = bookingData.find(b => b.id === id);
            if (!booking) return;

            let statusLabel = booking.status;
            let statusClass = 'bg-gray-100 text-gray-800';

            if (booking.status === 'pending') {
                statusLabel = 'Pending';
                statusClass = 'bg-yellow-100 text-yellow-800';
            } else if (booking.status === 'dikonfirmasi') {
                statusLabel = 'Dikonfirmasi';
                statusClass = 'bg-blue-100 text-blue-800';
            } else if (booking.status === 'diperiksa') {
                statusLabel = 'Diperiksa';
                statusClass = 'bg-purple-100 text-purple-800';
            } else if (booking.status === 'menunggu pembayaran') {
                statusLabel = 'Menunggu Pembayaran';
                statusClass = 'bg-orange-100 text-orange-800';
            } else if (booking.status === 'selesai') {
                statusLabel = 'Selesai';
                statusClass = 'bg-green-100 text-green-800';
            }

            const content = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Hewan</p>
                            <p class="mt-1 text-sm text-gray-900">${booking.nama_hewan}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Pemilik</p>
                            <p class="mt-1 text-sm text-gray-900">${booking.nama_pemilik}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Dokter</p>
                            <p class="mt-1 text-sm text-gray-900">${booking.dokter ? booking.dokter.name : '-'}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Umur</p>
                            <p class="mt-1 text-sm text-gray-900">${booking.umur}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Spesies</p>
                            <p class="mt-1 text-sm text-gray-900">${booking.spesies}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ras</p>
                            <p class="mt-1 text-sm text-gray-900">${booking.ras}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Booking</p>
                            <p class="mt-1 text-sm text-gray-900">${new Date(booking.tanggal_booking).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Keluhan</p>
                        <p class="mt-1 text-sm text-gray-900">${booking.keluhan}</p>
                    </div>
                    ${booking.biaya ? `
                    <div>
                        <p class="text-sm font-medium text-gray-500">Biaya Konsultasi</p>
                        <p class="mt-1 text-lg font-semibold text-green-600">Rp ${parseInt(booking.biaya).toLocaleString('id-ID')}</p>
                    </div>
                    ` : ''}
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                                ${statusLabel}
                            </span>
                        </p>
                    </div>
                    ${booking.status === 'menunggu pembayaran' && booking.user_id === {{ auth()->id() }} ? `
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="/payment/${booking.id}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Bayar Sekarang
                        </a>
                    </div>
                    ` : ''}
                </div>
            `;

            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>
