<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Vetopia | {{ $title ?? 'Home' }}</title>
</head>

<body class="overflow-hidden">
    @include('partials.navbar')
    <section class="bg-white py-8 overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8 relative">
        <div class="px-4">
            <!-- Top Grid (6 cards) -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                <!-- Left Column -->
                <div class="space-y-4">
                    <!-- Top Left Image -->
                    <img src="{{ asset('images/home/img1.png') }}" alt="Vetopia Image" class="rounded-3xl h-48 w-full object-cover shadow-lg">
                    <!-- Bottom Left Image -->
                    <img src="{{ asset('images/home/img3.png') }}" alt="Vetopia Image" class="rounded-3xl h-48 w-full object-cover shadow-lg">
                </div>

                <!-- Middle Column (Larger) - Invisible -->
                <div class="md:col-span-3 space-y-4 invisible">
                    <!-- Top Middle Image -->
                    <div class="bg-gradient-to-br from-green-200 to-green-300 rounded-3xl h-48 shadow-lg"></div>
                    <!-- Bottom Middle Image -->
                    <div class="bg-gradient-to-br from-yellow-200 to-yellow-300 rounded-3xl h-48 shadow-lg"></div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <!-- Top Right Image -->
                    <img src="{{ asset('images/home/img2.png') }}" alt="Vetopia Image" class="rounded-3xl h-48 w-full object-cover shadow-lg">
                    <!-- Bottom Right Image -->
                    <img src="{{ asset('images/home/img4.png') }}" alt="Vetopia Image" class="rounded-3xl h-48 w-full object-cover shadow-lg">
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Card 1 -->
                <img src="{{ asset('images/home/img5.png') }}" alt="Vetopia Image" class="rounded-3xl h-64 w-full object-cover shadow-lg">
                <!-- Card 2 -->
                <img src="{{ asset('images/home/img6.png') }}" alt="Vetopia Image" class="rounded-3xl h-64 w-full object-cover shadow-lg">
                <!-- Card 3 -->
                <img src="{{ asset('images/home/img7.png') }}" alt="Vetopia Image" class="rounded-3xl h-64 w-full object-cover shadow-lg">
            </div>
        </div>

        <!-- Hero Text -->
        <div class="absolute inset-0 flex items-start justify-center z-10 pointer-events-none pt-20">
            <div class="text-center mb-12 pointer-events-auto w-1/2">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                    Kesehatan Hewan Tanpa Ribet, di Ujung Jari Anda!
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Atur janji temu, beli obat, dan terhubung dengan dokter hewan—<br>semuanya dari rumah.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-green-400 hover:bg-green-500 text-white text-lg font-semibold rounded-full transition duration-200 shadow-lg">
                    Mulai dengan vetopia
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</body>

</html>