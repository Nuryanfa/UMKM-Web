# UMKM Marketplace Platform

## Deskripsi
Project ini adalah platform marketplace berbasis web yang menghubungkan UMKM (Supplier) langsung dengan Pelanggan. Sistem ini memfasilitasi transaksi jual-beli online dengan manajemen terpusat oleh Admin. Platform ini dirancang untuk memberdayakan UMKM dengan memberikan wadah digital untuk memasarkan produk mereka.

Aplikasi ini menggunakan arsitektur Monolith Modern dengan **Laravel** sebagai backend API dan logika bisnis, serta **Inertia.js + React** sebagai frontend untuk memberikan pengalaman pengguna (UX) yang cepat dan responsif layaknya Single Page Application (SPA).

## Fitur Utama

### 1. Hak Akses (Role-Based Access Control)
Sistem memiliki tiga level pengguna yang berbeda:
*   **Admin**: Pengelola utama sistem.
*   **Supplier (UMKM)**: Penjual yang menawarkan produk.
*   **Pelanggan**: Pembeli produk.

### 2. Fitur Admin
*   **Dashboard**: Melihat ringkasan statistik platform.
*   **Manajemen Supplier**: Memverifikasi pendaftaran supplier (Approve/Reject).
*   **Manajemen Pesanan**: Memantau status pesanan yang masuk.
*   **Laporan**: Melihat laporan transaksi dan pendapatan.

### 3. Fitur Supplier
*   **Produk**: Menambah, mengedit, dan menghapus produk (CRUD).
*   **Dashboard**: Memantau penjualan dan stok produk sendiri.
*   **Kelola Toko**: Mengatur profil dan informasi toko.

### 4. Fitur Pelanggan
*   **Katalog Produk**: Menjelajahi produk yang tersedia dari berbagai UMKM.
*   **Keranjang Belanja**: Menambahkan produk ke keranjang sebelum checkout.
*   **Checkout & Pembayaran**: Integrasi dengan **Midtrans** untuk pembayaran otomatis.
*   **Invoice**: Melihat bukti transaksi pembelian.

## Teknologi & Tools

Project ini dibangun menggunakan teknologi modern untuk menjamin performa, keamanan, dan kemudahan pengembangan:

### Backend
*   **Laravel 11**: Framework PHP utama untuk struktur aplikasi, routing, dan keamanan.
*   **MySQL**: Database relasional untuk menyimpan data pengguna, produk, dan transaksi.
*   **Midtrans**: Payment Gateway untuk memproses pembayaran online.

### Frontend
*   **React.js**: Library JavaScript untuk membangun antarmuka pengguna yang interaktif.
*   **Inertia.js**: Jembatan antara Laravel dan React, memungkinkan penulisan aplikasi seperti SPA tanpa perlu membangun API terpisah secara manual.
*   **TailwindCSS**: Utilitas CSS untuk styling yang cepat dan responsif.
*   **Vite**: Build tool modern untuk frontend yang sangat cepat.

### Tools Pendukung
*   **Composer**: Dependency manager untuk PHP.
*   **NPM**: Package manager untuk JavaScript.
*   **Git**: Version control system.
