<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" class="h-12" alt="Vetopia Logo" />
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="px-6 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition">
                    Home
                </a>
                <a href="/tentang" class="text-gray-700 hover:text-gray-900 transition">
                    Tentang
                </a>
                <a href="/layanan" class="text-gray-700 hover:text-gray-900 transition">
                    Layanan
                </a>
                <a href="/hubungi-kami" class="text-gray-700 hover:text-gray-900 transition">
                    Hubungi Kami
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-green-400 text-black rounded-full hover:bg-green-500 transition">
                        Go To Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-vetopia-green text-black rounded-full hover:bg-green-500 transition">
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 rounded-full bg-black text-white">Home</a>
            <a href="/tentang" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Tentang</a>
            <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Layanan</a>
            <a href="/hubungi-kami" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Hubungi Kami</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Masuk</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 bg-green-400 text-white rounded-full text-center">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
