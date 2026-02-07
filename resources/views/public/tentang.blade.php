{{-- resources/views/public/tentang.blade.php --}}
@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
{{-- Bagian Tentang UMKM Sayuran - Deskripsi --}}
<section class="container-fluid py-5 fullscreen-section bg-light">
    <div class="container">
        <h2 class="text-center mb-4 animated-fade-in">Tentang UMKM Sayuran</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <p class="lead animated-fade-in-delay">Kami adalah platform yang menghubungkan Anda dengan sayuran segar berkualitas tinggi langsung dari petani lokal.</p>
                <p class="animated-fade-in-delay">
                    UMKM Sayuran didirikan dengan visi untuk mendukung pertanian lokal dan menyediakan akses mudah bagi masyarakat terhadap produk pertanian yang sehat dan berkualitas. Kami percaya bahwa setiap orang berhak mendapatkan makanan terbaik yang ditanam dengan cinta dan perhatian.
                </p>
                <p class="animated-fade-in-delay">
                    Melalui platform ini, kami berkomitmen untuk mendukung pertumbuhan UMKM pertanian, mengurangi rantai pasokan yang panjang, dan memastikan produk segar sampai ke tangan Anda dengan kualitas terbaik dan harga yang adil.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Bagian Visi & Misi - Menggunakan Card View dengan Animasi dan Perhiasan --}}
<section class="container-fluid py-5 fullscreen-section position-relative overflow-hidden">
    {{-- Elemen perhiasan (dekorasi latar belakang) --}}
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.05; pointer-events: none;">
        <i class="bi bi-tree-fill text-success" style="font-size: 15rem; position: absolute; top: 10%; left: 5%;"></i>
        <i class="bi bi-flower1 text-info" style="font-size: 10rem; position: absolute; bottom: 15%; right: 10%;"></i>
        <i class="bi bi-seed-fill text-warning" style="font-size: 12rem; position: absolute; top: 50%; left: 20%;"></i>
    </div>

    <div class="container position-relative z-1">
        <h2 class="text-center mb-5 animated-fade-in">Visi & Misi Kami</h2>
        <div class="row g-4 justify-content-center">
            {{-- Card Visi --}}
            <div class="col-md-6 reveal-card">
                <div class="card h-100 shadow-lg border-0 rounded-4 p-4 text-center d-flex flex-column justify-content-center">
                    <div class="card-body">
                        <i class="bi bi-eye-fill text-success mb-3 animated-fade-in" style="font-size: 4rem;"></i>
                        <h3 class="fw-bold mb-3 text-success animated-fade-in">Visi Kami</h3>
                        <p class="lead animated-fade-in-delay">Menjadi platform distribusi sayuran terkemuka yang memberdayakan petani lokal dan menjadi pilihan utama konsumen di seluruh Indonesia.</p>
                    </div>
                </div>
            </div>
            {{-- Card Misi --}}
            <div class="col-md-6 reveal-card">
                <div class="card h-100 shadow-lg border-0 rounded-4 p-4 d-flex flex-column justify-content-center">
                    <div class="card-body">
                        <i class="bi bi-bullseye text-primary mb-3 animated-fade-in" style="font-size: 4rem;"></i>
                        <h3 class="fw-bold mb-3 text-primary animated-fade-in">Misi Kami</h3>
                        <ul class="list-unstyled text-start mx-auto" style="max-width: 400px;">
                            <li class="mb-2 animated-fade-in-delay"><i class="bi bi-check-circle-fill text-success me-2"></i>Membangun rantai pasok yang efisien dan transparan.</li>
                            <li class="mb-2 animated-fade-in-delay" style="animation-delay: 0.9s;"><i class="bi bi-check-circle-fill text-success me-2"></i>Meningkatkan kesejahteraan petani melalui harga yang adil.</li>
                            <li class="mb-2 animated-fade-in-delay" style="animation-delay: 1.0s;"><i class="bi bi-check-circle-fill text-success me-2"></i>Menyediakan produk pertanian segar dan berkualitas tinggi.</li>
                            <li class="animated-fade-in-delay" style="animation-delay: 1.1s;"><i class="bi bi-check-circle-fill text-success me-2"></i>Mendorong praktik pertanian berkelanjutan dan inovatif.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Bagian Harapan - Dengan Jarak Cukup --}}
<section class="container-fluid py-5 fullscreen-section bg-light position-relative overflow-hidden">
    {{-- Elemen perhiasan latar belakang --}}
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.03; pointer-events: none;">
        <i class="bi bi-heart-fill text-danger" style="font-size: 18rem; position: absolute; top: 20%; right: 5%;"></i>
        <i class="bi bi-stars text-warning" style="font-size: 10rem; position: absolute; bottom: 5%; left: 15%;"></i>
    </div>
    <div class="container position-relative z-1">
        <h2 class="text-center mb-5 animated-fade-in">Harapan Kami</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center animated-fade-in-delay">
                <p class="lead">Kami berharap dapat menciptakan dampak positif yang berkelanjutan bagi seluruh komunitas, mulai dari petani hingga konsumen.</p>
                <p>
                    Dengan dukungan Anda, kami berambisi untuk memperluas jangkauan, menambah variasi produk, dan terus berinovasi dalam layanan. Bersama, kita bisa membangun masa depan pertanian yang lebih cerah dan sehat untuk semua.
                </p>
                <p class="fw-bold mt-4">Terima kasih telah mempercayai UMKM Sayuran!</p>
            </div>
        </div>
    </div>
</section>

{{-- Bagian Tim Kami - Dengan Animasi Hover yang Muncul --}}
<section class="container-fluid py-5 fullscreen-section bg-gradient-light-green">
    <div class="container">
        <h2 class="text-center mb-5 animated-fade-in">Tim Kami</h2>
        <div class="row justify-content-center row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            {{-- Anggota Tim 1 --}}
            <div class="col animated-card-reveal">
                <div class="team-card text-center h-100 d-flex flex-column align-items-center p-4">
                    <img src="{{ asset('image/myfoto.jpg') }}" class="img-fluid rounded-circle team-photo shadow-sm mb-3" alt="Foto CEO">
                    <h5 class="fw-bold mb-0">Muhamad Nur Yanfa</h5>

                    
                    {{-- Deskripsi muncul saat hover --}}
                    <div class="team-description w-100 text-small">

                    </div>
                </div>
            </div>

            {{-- Anggota Tim 2 --}}
            <div class="col animated-card-reveal" style="animation-delay: 0.2s;">
                <div class="team-card text-center h-100 d-flex flex-column align-items-center p-4">
                    <img src="{{ asset('image/irvan.jpg') }}" class="img-fluid rounded-circle team-photo shadow-sm mb-3" alt="Foto COO">
                    <h5 class="fw-bold mb-0">M Irvan Alfiyansah</h5>

                    
                    {{-- Deskripsi muncul saat hover --}}
                    <div class="team-description w-100 text-small">

                    </div>
                </div>
            </div>

            {{-- Anggota Tim 3 --}}
            <div class="col animated-card-reveal" style="animation-delay: 0.4s;">
                <div class="team-card text-center h-100 d-flex flex-column align-items-center p-4">
                    <img src="{{ asset('image/chelsea4.jpg') }}" class="img-fluid rounded-circle team-photo shadow-sm mb-3" alt="Foto Head of Marketing">
                    <h5 class="fw-bold mb-0">Chelsea Aaliyah</h5>

                    
                    {{-- Deskripsi muncul saat hover --}}
                    <div class="team-description w-100 text-small">
                        
                    </div>
                </div>
            </div>
            {{-- Anggota Tim 4 --}}
            <div class="col animated-card-reveal" style="animation-delay: 0.4s;">
                <div class="team-card text-center h-100 d-flex flex-column align-items-center p-4">
                    <img src="{{ asset('image/nuraeni.jpg') }}" class="img-fluid rounded-circle team-photo shadow-sm mb-3" alt="Foto Head of Marketing">
                    <h5 class="fw-bold mb-0">Nuraeni Yusuf</h5>

                    
                    {{-- Deskripsi muncul saat hover --}}
                    <div class="team-description w-100 text-small">
                        
                    </div>
                </div>
            </div>
            {{-- Anggota Tim 5 --}}
            <div class="col animated-card-reveal" style="animation-delay: 0.4s;">
                <div class="team-card text-center h-100 d-flex flex-column align-items-center p-4">
                    <img src="{{ asset('image/risa.jpg') }}" class="img-fluid rounded-circle team-photo shadow-sm mb-3" alt="Foto Head of Marketing">
                    <h5 class="fw-bold mb-0">Risa Andriani</h5>

                    
                    {{-- Deskripsi muncul saat hover --}}
                    <div class="team-description w-100 text-small">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
    <style>
        /* Gradien latar belakang untuk section Tim Kami */
        .bg-gradient-light-green {
            background: linear-gradient(to bottom, #f8f9fa, #e6ffe6); /* Warna dari putih ke hijau muda */
        }

        /* CSS untuk Foto Tim */
        .team-photo {
            width: 150px; /* Ukuran default */
            height: 150px;
            object-fit: cover; /* Memastikan gambar mengisi lingkaran tanpa distorsi */
            border: 5px solid #e0ffe0; /* Border hijau muda */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease-in-out;
        }

        .team-photo:hover {
            border-color: #28a745; /* Warna border saat hover */
            transform: scale(1.05);
        }

        /* Responsive untuk foto tim */
        @media (max-width: 768px) {
            .team-photo {
                width: 120px;
                height: 120px;
            }
        }

        /* CSS untuk Team Card (pengganti flip card) */
        .team-card {
            background-color: #fff;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Penting untuk menyembunyikan bagian deskripsi yang overflow */
            transition: all 0.3s ease-in-out;
            border: 1px solid #eee; /* Border tipis */
        }

        .team-card:hover {
            transform: translateY(-8px) scale(1.02); /* Sedikit naik dan membesar saat hover */
            box-shadow: 0 0.8rem 1.5rem rgba(0, 0, 0, 0.2); /* Shadow lebih kuat saat hover */
        }

        .team-description {
            max-height: 0; /* Awalnya tersembunyi */
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out, opacity 0.4s ease-out;
        }

        .team-card:hover .team-description {
            max-height: 200px; /* Tinggi maksimum yang cukup untuk deskripsi saat muncul */
            opacity: 1;
            padding-top: 15px; /* Sedikit padding di atas deskripsi */
            border-top: 1px solid #f0f0f0; /* Garis pemisah */
        }

        /* Animasi muncul otomatis saat loading halaman */
        @keyframes fadeInSlideUp {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .animated-card-reveal {
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInSlideUp 0.8s ease-out forwards;
            /* delay ditambahkan inline pada elemen HTML */
        }
        
        /* Font size kecil untuk deskripsi di dalam card */
        .text-small p, .text-small ul li {
            font-size: 0.9rem;
        }
    </style>
@endpush

@push('scripts')
    {{-- Tambahkan skrip khusus untuk halaman tentang jika diperlukan --}}
@endpush
