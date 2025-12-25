<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"
                        class="bg-vetopia-green px-3 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                        Back to Homepage
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @role('user')
                        <x-nav-link :href="route('hewan.index')" :active="request()->routeIs('hewan.index')">
                            {{ 'Hewan Saya' }}
                        </x-nav-link>
                        <x-nav-link :href="route('booking.myBookings')" :active="request()->routeIs('booking.myBookings')">
                            {{ 'Riwayat Booking' }}
                        </x-nav-link>
                        <x-nav-link :href="route('penitipan.hewan.index')" :active="request()->routeIs('penitipan.hewan.index')">
                            {{ 'Status Penitipan' }}
                        </x-nav-link>
                    @endrole
                    @role('doctor')
                        <x-nav-link :href="route('hewan.index')" :active="request()->routeIs('hewan.index')">
                            {{ 'Pasien Saya' }}
                        </x-nav-link>
                        <x-nav-link :href="route('booking.konsultasi.manage')" :active="request()->routeIs('booking.konsultasi.manage')">
                            {{ 'Antrean Konsultasi' }}
                        </x-nav-link>
                        <x-nav-link :href="route('pemeriksaan.lab.manage')" :active="request()->routeIs('pemeriksaan.lab.manage')">
                            {{ 'Pemeriksaan Lab' }}
                        </x-nav-link>
                    @endrole
                    @role('admin')
                        <x-nav-link :href="route('hewan.index')" :active="request()->routeIs('hewan.index')">
                            {{ 'Manajemen Hewan' }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.userManage.index')" :active="request()->routeIs('admin.userManage.index')">
                            {{ 'Manajemen User' }}
                        </x-nav-link>
                        <x-nav-link :href="route('penitipan.hewan.index')" :active="request()->routeIs('penitipan.hewan.index')">
                            {{ 'Penitipan Hewan' }}
                        </x-nav-link>
                        <x-nav-link :href="route('booking.konsultasi.manage')" :active="request()->routeIs('booking.konsultasi.manage')">
                            {{ 'Booking Konsultasi' }}
                        </x-nav-link>
                        <x-nav-link :href="route('pemeriksaan.lab.manage')" :active="request()->routeIs('pemeriksaan.lab.manage')">
                            {{ 'Pemeriksaan Lab' }}
                        </x-nav-link>
                    @endrole
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                {{-- Hanya User yang bisa melihat Lonceng Notifikasi --}}
@role('user')
                <div class="relative ml-3 mr-3">
                    <x-dropdown align="right" width="96">
                        <x-slot name="trigger">
                            <button class="relative p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div x-data="{ activeTab: 'unread' }">
                                
                                <div class="flex border-b border-gray-100 bg-gray-50 rounded-t-md">
                                    <button @click="activeTab = 'unread'" 
                                        :class="{ 'text-indigo-600 border-b-2 border-indigo-500': activeTab === 'unread', 'text-gray-500 hover:text-gray-700': activeTab !== 'unread' }"
                                        class="flex-1 py-3 text-sm font-semibold text-center transition-colors duration-150 focus:outline-none">
                                        Belum Dibaca ({{ Auth::user()->unreadNotifications->count() }})
                                    </button>
                                    <button @click="activeTab = 'read'" 
                                        :class="{ 'text-indigo-600 border-b-2 border-indigo-500': activeTab === 'read', 'text-gray-500 hover:text-gray-700': activeTab !== 'read' }"
                                        class="flex-1 py-3 text-sm font-semibold text-center transition-colors duration-150 focus:outline-none">
                                        Riwayat
                                    </button>
                                </div>

                                <div x-show="activeTab === 'unread'" class="max-h-96 overflow-y-auto">
                                    @forelse(Auth::user()->unreadNotifications as $notification)
                                        <a href="{{ route('markRead', $notification->id) }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 bg-white">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 pt-1">
                                                    <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div class="ml-3 w-0 flex-1">
                                                    <p class="text-sm font-bold text-gray-900">{{ $notification->data['title'] ?? 'Info' }}</p>
                                                    
                                                    {{-- PERBAIKAN: Hapus Str::limit dan tambah class break-words --}}
                                                    <p class="text-sm text-gray-600 mt-1 break-words whitespace-normal leading-snug">
                                                        {{ $notification->data['message'] ?? '' }}
                                                    </p>
                                                    
                                                    <p class="text-xs text-indigo-500 mt-2 font-semibold">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-8 text-sm text-gray-500 text-center flex flex-col items-center">
                                            <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Semua notifikasi sudah dibaca
                                        </div>
                                    @endforelse

                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <div class="block px-4 py-2 text-xs text-center bg-gray-50 hover:bg-gray-100 border-t border-gray-100">
                                            <a href="{{ route('markAllRead') }}" class="text-indigo-600 font-bold hover:underline">Tandai semua sudah dibaca</a>
                                        </div>
                                    @endif
                                </div>

                                <div x-show="activeTab === 'read'" class="max-h-96 overflow-y-auto" style="display: none;">
                                    @forelse(Auth::user()->readNotifications->take(20) as $notification)
                                        <div class="block px-4 py-3 border-b border-gray-100 bg-gray-50 opacity-75">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 pt-1">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div class="ml-3 w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-700">{{ $notification->data['title'] ?? 'Info' }}</p>
                                                    
                                                    {{-- PERBAIKAN: Hapus Str::limit untuk riwayat juga --}}
                                                    <p class="text-sm text-gray-500 mt-1 break-words whitespace-normal leading-snug">
                                                        {{ $notification->data['message'] ?? '' }}
                                                    </p>
                                                    
                                                    <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-sm text-gray-500 text-center">
                                            Belum ada riwayat notifikasi.
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endrole

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @role('user')
                <x-responsive-nav-link :href="route('hewan.index')" :active="request()->routeIs('hewan.index')">
                    {{ 'Hewan Saya' }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('booking.myBookings')" :active="request()->routeIs('booking.myBookings')">
                    {{ 'Riwayat Booking' }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('penitipan.hewan.index')" :active="request()->routeIs('penitipan.hewan.index')">
                    {{ 'Status Penitipan' }}
                </x-responsive-nav-link>
            @endrole
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>