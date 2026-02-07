<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Sayuran</title>

    {{-- Favicon (Ikon Website) --}}
    {{-- GANTI 'your_website_logo.png' dengan nama file logo website Anda yang sebenarnya --}}
    <link rel="icon" href="{{ asset('/image/logoweb.jpg') }}" type="image/png">


    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    {{-- Global CSS Kustom Anda --}}
    <style>
        :root {
            --navbar-height: 60px; /* Variabel untuk tinggi navbar */
            --footer-height: 200px; /* Estimasi tinggi footer, sesuaikan jika perlu */
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease-out;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        [x-cloak] {
            display: none;
        }

        .nav-link {
            position: relative;
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            left: 0;
            bottom: 0;
            background-color: #ffffff;
            transition: width 0.3s ease-in-out;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: #e0ffe0 !important;
        }
        
        @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
        }

        .animated-fade-in {
            animation: fadeIn 1.5s ease-out forwards;  
        }

        .animated-fade-in-delay {
            opacity: 0;
            animation: fadeIn 1.5s ease-out 0.8s forwards;
        }

        /* Styling untuk bagian yang ingin fullscreen */
        .fullscreen-section {
            min-height: calc(100vh - var(--navbar-height)); 
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 6rem 0; /* Menambah padding vertikal untuk jarak konten dari tepi */
            position: relative;
        }
        
        .hero-section {
            /* GANTI URL INI DENGAN PATH GAMBAR BACKGROUND LANDING PAGE ANDA */
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset("image/backgroudwebsite.jpg") }}') center center no-repeat;
            background-size: cover;
            background-attachment: fixed; /* Efek parallax */
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            max-width: 700px;
        }
        .hero-section .btn {
            padding: 15px 30px;
            font-size: 1.25rem;
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            transition: transform 0.2s ease-in-out;
        }
        .hero-section .btn:hover {
            transform: translateY(-3px);
        }

        /* Styling card umum */
        .card {
            border-radius: 1rem;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        main {
            flex-grow: 1; /* Pastikan konten utama mengisi ruang yang tersedia */
        }

        footer {
            background-color: #f8f9fa; /* Warna latar footer yang lebih terang */
            padding: 3rem 0;
            color: #343a40; /* Warna teks gelap untuk kontras */
            margin-top: auto; /* Untuk menempel di bagian bawah */
        }
        footer a {
            color: #007bff; /* Warna link di footer */
            text-decoration: none; /* Hapus underline default */
        }
        footer a:hover {
            color: #0056b3;
            text-decoration: underline; /* Munculkan underline saat hover */
        }
        /* Responsiveness untuk font size */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }
            .hero-section p {
                font-size: 1.2rem;
            }
            .hero-section .btn {
                font-size: 1rem;
                padding: 10px 20px;
            }
            .fullscreen-section {
                padding: 4rem 0; /* Kurangi padding di mobile */
            }
            .navbar .container {
                flex-wrap: wrap; /* Izinkan wrap di mobile */
                justify-content: center !important;
            }
            .navbar-brand {
                margin-bottom: 1rem; /* Jarak antara brand dan hamburger di mobile */
            }
        }
        /* --- Modern UI Enhancements --- */
        body {
            background-color: #f8f9fa; /* Light grey background for better contrast */
        }
        
        .navbar-glass {
            background: rgba(25, 135, 84, 0.95); /* Green with slight transparency */
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .card-modern {
            border: none;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-rounded {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
    </style>
    <!-- ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <script>
        // Konfigurasi ScrollReveal
        const sr = ScrollReveal({
            distance: '60px',
            duration: 1000,
            easing: 'ease-in-out',
            origin: 'bottom',
            reset: false // Hanya animasikan sekali
        });

        // Efek untuk card
        sr.reveal('.reveal-card', { interval: 200 });

        // Efek untuk teks dengan animasi fade-in
        sr.reveal('.animated-fade-in', {
            duration: 1500,
            origin: 'bottom',
            distance: '20px',
            easing: 'ease-out',
            delay: 200,
            opacity: 0,
            afterReveal: function (el) { el.style.opacity = 1; el.style.transform = 'translateY(0)'; }
        });

        // Efek untuk teks dengan animasi fade-in-delay
        sr.reveal('.animated-fade-in-delay', {
            duration: 1500,
            origin: 'bottom',
            distance: '20px',
            easing: 'ease-out',
            delay: 800, // Lebih lama dari animated-fade-in
            opacity: 0,
            afterReveal: function (el) { el.style.opacity = 1; el.style.transform = 'translateY(0)'; }
        });
    </script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Vite CSS & JS --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body x-data>

    {{-- Navbar --}}
    <nav class="navbar navbar-dark bg-success" x-data="{ open: false }" style="min-height: var(--navbar-height);">
        <div class="container d-flex justify-content-between align-items-center position-relative">
            {{-- Branding --}}
            <a class="navbar-brand fw-bold z-10" href="/">UMKM Sayuran</a>

            {{-- Menu tengah (desktop) --}}
            <div class="position-absolute start-50 translate-middle-x d-none d-lg-block">
                <ul class="navbar-nav flex-row gap-4">
                    <li class="nav-item"><a class="nav-link text-white" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/tentang-kami">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/produk-publik">Produk</a></li>
                </ul>
            </div>

            {{-- Hamburger + dropdown --}}
            <div class="d-flex align-items-center" style="position: relative; z-index: 1050;">
                <button class="btn btn-outline-light" @click="open = !open" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open" x-cloak x-transition @click.outside="open = false"
                     class="position-absolute top-100 end-0 mt-2 bg-white shadow rounded z-1060"
                     style="min-width: 200px;">
                    @guest
                        {{-- Tampilkan ini jika user BELUM login --}}
                        <a class="dropdown-item py-2 px-3" href="{{ route('login') }}">Login</a>
                        <a class="dropdown-item py-2 px-3" href="{{ route('register') }}">Register</a>
                    @endguest

                    @auth
                        {{-- Tampilkan ini jika user SUDAH login --}}
                        <a class="dropdown-item py-2 px-3" href="/dashboard">Dashboard</a> {{-- Ini akan redirect ke dashboard sesuai role --}}
                        <hr class="my-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 px-3">Logout</button>
                        </form>
                    @endauth
                    
                    {{-- Tambahan menu publik yang mungkin ingin tetap ada di dropdown (sekarang selalu tampil di dropdown) --}}
                    <hr class="my-1"> {{-- Pemisah opsional --}}
                    <a class="dropdown-item py-2 px-3" href="/">Beranda</a>
                    <a class="dropdown-item py-2 px-3" href="/tentang-kami">Tentang</a>
                    <a class="dropdown-item py-2 px-3" href="/produk-publik">Produk</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="py-0">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-light text-center text-lg-start mt-auto py-4">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">UMKM Sayuran</h5>
                    <p>
                        Menyediakan sayuran segar langsung dari petani lokal untuk kebutuhan Anda.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Tautan Cepat</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="/" class="text-dark">Beranda</a></li>
                        <li><a href="/tentang-kami" class="text-dark">Tentang Kami</a></li>
                        <li><a href="/produk-publik" class="text-dark">Produk</a></li>
                        <li><a href="/keranjang" class="text-dark">Keranjang</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Kontak Kami</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="text-dark">Email: info@umkmsayuran.com</a></li>
                        <li><a href="#" class="text-dark">Telepon: +62 812-3456-7890</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 UMKM Sayuran. Hak Cipta Dilindungi.
        </div>
    </footer>


    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- Bootstrap JS (defer ditambahkan agar tidak memblokir render) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    
    {{-- SANGAT PENTING: TAMBAHKAN BARIS INI UNTUK MERENDER SEMUA SCRIPT YANG DI-PUSH --}}
    @stack('scripts') 
</body>
</html>
