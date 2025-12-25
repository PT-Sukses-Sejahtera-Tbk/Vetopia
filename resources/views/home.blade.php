
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
<body class="bg-white overflow-x-hidden">
    @include('partials.navbar')

    <!-- Section 1 Hero Section -->
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
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-vetopia-green hover:bg-[#4EC95E] text-black text-lg font-semibold rounded-full transition duration-200 shadow-lg">
                    Mulai dengan vetopia
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

        <!-- Section 2: Mitra Terbaik untuk Kesehatan Sahabat Bulu Anda -->
    <section id="tentang" class="w-full bg-white flex flex-col items-center justify-center" style="min-height:900px; max-width:1920px; margin:auto;">
        <div class="flex flex-col items-center justify-center h-full py-24">
            <img src="{{ asset('images/home/logo.png') }}" alt="Vetopia Logo" class="mb-8" style="height:251px; width: 417px;">
            <h2 class="text-5xl md:text-6xl font-bold text-center mb-2">Mitra Terbaik Kesehatan</h2>
            <h2 class="text-5xl md:text-6xl font-bold text-center mb-6">Sahabat Bulu Anda</h2>  
            <p class="text-xl text-gray-700 text-center max-w-2xl">Vetopia hadir untuk memastikan hewan kesayangan Anda</p>
            <p class="text-xl text-gray-700 text-center max-w-2xl">mendapatkan perawatan terbaik, kapan pun dan di mana pun,</p>
            <p class="text-xl text-gray-700 text-center max-w-2xl">tanpa kerumitan.</p>
        </div>
        </section>
        
    <!-- Section 3Mengapa Vetopia -->
<section class="w-full text-white flex flex-col items-center justify-center elips-bg-section" style="min-height:1200px; max-width:2000px; margin:auto; background: url('{{ asset('images/home/elips.png') }}') no-repeat center center; background-size: cover; position: relative;">
        <!-- Konten utama -->
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-center h-full py-0 relative z-10" style="padding-top:0; padding-bottom:0;">
            <div class="flex flex-col gap-4 items-center md:items-end md:mr-8">
                <div style="width:464px; height:271px;" class="rounded-3xl bg-gray-800 overflow-hidden shadow-lg mb-4">
                    <img src="{{ asset('images/home/img8.png') }}" alt="Kucing" class="w-full h-full object-cover" style="transform: scale(1.2);">
                </div>
                <div style="width:464px; height:271px;" class="rounded-3xl bg-gray-800 overflow-hidden shadow-lg">
                     <img src="{{ asset('images/home/img9.png') }}" alt="Kucing" class="w-full h-full object-cover" style="transform: scale(1.2);">
                </div>
            </div>
            <div class="flex flex-col justify-start items-start md:items-start md:ml-8 max-w-2xl" style="margin-top: -150px;">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Mengapa <span class="text-[#4ADE80]">Vetopia?</span></h2>
                <p class="text-white text-lg mb-4 leading-relaxed">Kami tahu betapa berartinya hewan peliharaan bagi Anda. Namun, kami juga <br>tahu tantangan yang sering dihadapi: antrean klinik yang panjang, sulitnya <br>mencari jadwal dokter di tengah kesibukan, hingga bingung mencari obat yang <br>tepat.</p>
                <p class="text-white text-lg mb-4 leading-relaxed">Vetopia lahir dari satu keyakinan sederhana: <span class="text-[#4ADE80]">Merawat hewan peliharaan seharusnya tidak rumit.</span></p>
                <p class="text-white text-lg leading-relaxed">Kami membangun jembatan digital yang menghubungkan pemilik hewan, <br>dokter hewan profesional, dan akses obat-obatan dalam satu platform <br>terintegrasi. Misi kami adalah memberikan ketenangan pikiran (peace of mind) <br>bagi setiap pemilik hewan di Indonesia.</p>
        </div>
    </section>


<!--Section 4 Fitur -->
<section class="bg-white" style="max-width: 1920px; margin: auto; padding-top: 120px; padding-bottom: 60px;">
    <div class="container mx-auto px-4 flex flex-col justify-center">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center mb-16">
            <div>
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/home/icon1.png') }}" alt="Mudah & Praktis" style="width: 176px; height: 176px; object-fit: contain;">
                </div>
                <h4 class="text-2xl font-bold mb-4">Mudah & Praktis</h4>
                <p class="text-gray-600 text-lg px-4">Janji temu dokter hewan dan konsultasi kini ada di genggaman Anda. Tidak perlu lagi menelepon klinik satu per satu untuk mencari jadwal kosong.</p>
            </div>
            <div>
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/home/icon2.png') }}" alt="Layanan Terintegrasi" style="width: 176px; height: 176px; object-fit: contain;">
                </div>
                <h4 class="text-2xl font-bold mb-4">Layanan Terintegrasi</h4>
                <p class="text-gray-600 text-lg px-4">Dari konsultasi hingga resep obat, semuanya terhubung. Jika hewan Anda butuh obat, Anda bisa langsung memesannya di sini dan kami antar ke rumah.</p>
            </div>
            <div>
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/home/icon3.png') }}" alt="Terpercaya" style="width: 176px; height: 176px; object-fit: contain;">
                </div>
                <h4 class="text-2xl font-bold mb-4">Terpercaya</h4>
                <p class="text-gray-600 text-lg px-4">Kami hanya bekerja sama dengan dokter hewan berlisensi dan penyedia obat-obatan yang terverifikasi demi keamanan hewan kesayangan Anda.</p>
            </div>
        </div>
       
        <div class="text-center mb-12">
            <p class="text-gray-800 text-xl mb-2">Kami percaya bahwa hewan yang sehat adalah awal dari</p>
            <p class="text-gray-800 text-xl mb-8">kebahagiaan di rumah. Biarkan kami membantu Anda menjaga senyuman mereka.</p>
        </div>
       
        <div class="text-center">
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-vetopia-green hover:bg-[#4EC95E] text-black text-lg font-semibold rounded-full transition duration-200 shadow-lg">
                Mulai dengan vetopia
                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>

    <!Section 5-- Footer -->
<footer class="bg-[#262626] text-white" style="width: 100%; max-width: 1920px; min-height: 400px; margin: 0 auto; display: flex; align-items: center;">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <div class="md:col-span-5 space-y-10">
                    <div class="flex items-center gap-8">
                        <img src="{{ asset('images/home/logo.png') }}" alt="Vetopia Logo" style="height: 80px;">
                        <div class="flex gap-4 mt-2"> 
                            <a href="#" class="hover:opacity-80 transition">
                                <img src="{{ asset('images/home/facebook.png') }}" alt="Facebook" style="width: 40px; height: 40px;">
                            </a>
                            <a href="#" class="hover:opacity-80 transition">
                                <img src="{{ asset('images/home/instagram.png') }}" alt="Instagram" style="width: 40px; height: 40px;">
                            </a>
                        </div>
                    </div>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-5">
                            <div class="w-6 flex-shrink-0 mt-1">
                                <img src="{{ asset('images/home/maps.png') }}" alt="Maps" class="w-full">
                            </div>
                            <p class="text-white text-xl leading-relaxed font-medium">
                                Permata Kopo Blok 1 no.899<br>
                                Sukamenak Margahayu kab. Bandung
                            </p>
                        </div>
                        <div class="flex items-center gap-5">
                            <div class="w-6 flex-shrink-0">
                                <img src="{{ asset('images/home/telefon.png') }}" alt="Phone" class="w-full">
                            </div>
                            <p class="text-white text-xl font-medium">+62 881-2088-784</p>
                        </div>
                        <div class="flex items-center gap-5">
                            <div class="w-6 flex-shrink-0">
                                <img src="{{ asset('images/home/mail.png') }}" alt="Email" class="w-full">
                            </div>
                            <p class="text-white text-xl font-medium">vetopiashop@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1"></div>

                <div class="md:col-span-3 pt-2 flex flex-col gap-8">
                    <a href="#" class="text-2xl font-bold text-[#4ADE80] hover:text-white transition block">
                        Home
                    </a>
                    <a href="#" class="text-2xl font-bold text-[#4ADE80] hover:text-white transition block">
                        Tentang Kami
                    </a>
                </div>

                <div class="md:col-span-3 pt-2">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-[#4ADE80] mb-4">
                            Layanan
                        </h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-white text-lg hover:text-[#4ADE80] transition">Booking Konsultasi</a></li>
                            <li><a href="#" class="text-white text-lg hover:text-[#4ADE80] transition">Konsultasi Online</a></li>
                            <li><a href="#" class="text-white text-lg hover:text-[#4ADE80] transition">Rawat Jalan</a></li>
                        </ul>
                    </div>
                    
                    <a href="#" class="text-2xl font-bold text-[#4ADE80] hover:text-white transition block">
                        Hubungi Kami
                    </a>
                </div>

            </div>
        </div>
    </footer>
</body>
</html>