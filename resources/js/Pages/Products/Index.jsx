import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import Swal from 'sweetalert2';

export default function Index({ produk, auth }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [categoryFilter, setCategoryFilter] = useState('All');

    // Filter logic
    const filteredProducts = produk.filter(item => 
        (categoryFilter === 'All' || item.kategori === categoryFilter) &&
        item.nama_produk.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const categories = ['All', ...new Set(produk.map(item => item.kategori))].filter(Boolean);

    return (
        <MainLayout>
            <Head title="Katalog Sayuran Segar" />
            
            <div className="min-h-screen bg-[#FAFAF9] pb-20">
                {/* Hero / Header Section */}
                <div className="bg-[#1B4D3E] text-white py-16 px-4 relative overflow-hidden">
                    <div className="absolute top-0 right-0 w-64 h-64 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                    <div className="absolute -bottom-8 -left-8 w-64 h-64 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

                    <div className="container mx-auto text-center relative z-10">
                        <h1 className="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                            Panen Terbaik Hari Ini 🌽
                        </h1>
                        <p className="text-green-100 text-lg max-w-2xl mx-auto leading-relaxed">
                            Langsung dari kebun petani lokal ke meja makan Anda. Segar, organik, dan penuh nutrisi.
                        </p>
                    </div>
                </div>

                {/* Search & Filter Bar */}
                <div className="container mx-auto px-4 -mt-8 relative z-20">
                    <div className="bg-white rounded-2xl shadow-xl p-4 md:p-6 flex flex-col md:flex-row gap-4 items-center justify-between border border-gray-100">
                        {/* Search */}
                        <div className="relative w-full md:w-1/3">
                            <span className="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input 
                                type="text"
                                placeholder="Cari sayuran..." 
                                className="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-green-500 transition shadow-sm"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>

                        {/* Categories */}
                        <div className="flex overflow-x-auto pb-2 md:pb-0 gap-2 w-full md:w-auto hide-scrollbar">
                            {categories.map(cat => (
                                <button
                                    key={cat}
                                    onClick={() => setCategoryFilter(cat)}
                                    className={`px-6 py-2 rounded-full whitespace-nowrap text-sm font-bold transition-all ${
                                        categoryFilter === cat 
                                        ? 'bg-[#1B4D3E] text-white shadow-lg transform scale-105' 
                                        : 'bg-gray-100 text-gray-600 hover:bg-green-100'
                                    }`}
                                >
                                    {cat}
                                </button>
                            ))}
                        </div>
                         
                        <div className="hidden md:block">
                            <Link href="/keranjang" className="flex items-center gap-2 text-gray-600 hover:text-green-700 font-bold">
                                <span>🛒</span>
                                <span>Keranjang</span>
                            </Link>
                        </div>
                    </div>
                </div>

                {/* Products Grid */}
                <div className="container mx-auto px-4 py-12">
                    {filteredProducts.length === 0 ? (
                         <div className="text-center py-20">
                            <div className="text-6xl mb-4">🥦</div>
                            <h3 className="text-xl font-bold text-gray-600">Produk tidak ditemukan</h3>
                            <p className="text-gray-400 mt-2">Coba kata kunci lain atau ubah filter kategori.</p>
                            <button onClick={() => {setSearchTerm(''); setCategoryFilter('All');}} className="mt-4 text-green-600 font-bold hover:underline">
                                Reset Filter
                            </button>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                            {filteredProducts.map((item) => (
                                <ProductCard key={item.id} item={item} auth={auth} />
                            ))}
                        </div>
                    )}
                </div>
            </div>
            
             <style>{`
                .hide-scrollbar::-webkit-scrollbar {
                  display: none;
                }
                .hide-scrollbar {
                  -ms-overflow-style: none;  /* IE and Edge */
                  scrollbar-width: none;  /* Firefox */
                }
                @keyframes blob {
                    0% { transform: translate(0px, 0px) scale(1); }
                    33% { transform: translate(30px, -50px) scale(1.1); }
                    66% { transform: translate(-20px, 20px) scale(0.9); }
                    100% { transform: translate(0px, 0px) scale(1); }
                }
                .animate-blob {
                    animation: blob 7s infinite;
                }
                .animation-delay-2000 {
                    animation-delay: 2s;
                }
            `}</style>
        </MainLayout>
    );
}

function ProductCard({ item, auth }) {
    const { data, setData, post, processing } = useForm({
        jumlah: 1
    });

    const submit = (e) => {
        e.preventDefault();
        if (!auth.user) {
            Swal.fire({
                title: 'Login Diperlukan',
                text: "Silakan login untuk mulai berbelanja!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Login Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/login';
                }
            });
            return;
        }

        post(`/keranjang/tambah/${item.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Ditambahkan!',
                    text: `${item.nama_produk} masuk keranjang.`,
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#1B4D3E',
                    color: '#fff',
                    iconColor: '#fff'
                });
            },
            onError: () => {
                 Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Stok tidak mencukupi.',
                });
            }
        });
    };

    return (
        <div className="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col border border-gray-100">
            {/* Image Container */}
            <div className="relative h-64 overflow-hidden bg-gray-100">
                <img 
                    src={item.gambar_produk ? `/${item.gambar_produk}` : 'https://placehold.co/600x600/E8F5E9/1B4D3E?text=Sayur+Segar'} 
                    alt={item.nama_produk}
                    className="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out"
                />
                 {/* Badges */}
                <div className="absolute top-4 left-4 z-10 flex flex-col gap-2">
                     {item.kategori && (
                        <span className="bg-white/90 backdrop-blur-sm text-green-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            {item.kategori}
                        </span>
                    )}
                </div>
                 <div className="absolute top-4 right-4 z-10">
                     <span className={`px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm ${item.stok > 0 ? 'bg-green-600' : 'bg-red-500'}`}>
                        {item.stok > 0 ? `Stok: ${item.stok}` : 'Habis'}
                     </span>
                 </div>
                 
                 {/* Quick Action Overlay */}
                 {item.stok > 0 && (
                    <div className="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <button 
                            onClick={submit}
                            disabled={processing}
                            className="bg-white text-green-700 font-bold py-3 px-6 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-lg hover:bg-green-50"
                        >
                            {processing ? '...' : '+ Quick Add'}
                        </button>
                    </div>
                 )}
            </div>
            
            <div className="p-6 flex flex-col flex-grow">
                <div className="mb-4">
                    <h3 className="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-700 transition">{item.nama_produk}</h3>
                    <p className="text-sm text-gray-500 line-clamp-2 leading-relaxed">{item.deskripsi || 'Kesegaran alami tanpa pestisida berbahaya, dipetik langsung saat Anda memesan.'}</p>
                </div>
                
                <div className="mt-auto pt-4 border-t border-gray-50">
                    <div className="flex justify-between items-center mb-4">
                        <div className="flex flex-col">
                            <span className="text-xs text-gray-400">Harga Satuan</span>
                            <span className="text-green-700 font-extrabold text-xl">
                                Rp{new Intl.NumberFormat('id-ID').format(item.harga)}
                            </span>
                        </div>
                        <span className="text-gray-400 text-sm bg-gray-50 px-2 py-1 rounded-lg">/{item.satuan || 'pack'}</span>
                    </div>
                    
                    <form onSubmit={submit} className="flex gap-2">
                         <div className="relative w-20">
                            <button 
                                type="button"
                                onClick={() => setData('jumlah', Math.max(1, data.jumlah - 1))}
                                className="absolute left-0 top-0 h-full w-8 text-gray-400 hover:text-green-600 font-bold"
                            >-</button>
                            <input 
                                type="number" 
                                min="1" 
                                max={item.stok} 
                                value={data.jumlah}
                                onChange={e => setData('jumlah', e.target.value)}
                                className="w-full text-center border-gray-200 bg-gray-50 rounded-xl py-2 px-6 text-sm font-bold focus:ring-0 focus:border-green-500"
                                disabled={item.stok <= 0}
                            />
                             <button 
                                type="button" 
                                onClick={() => setData('jumlah', Math.min(item.stok, data.jumlah + 1))}
                                className="absolute right-0 top-0 h-full w-8 text-gray-400 hover:text-green-600 font-bold"
                            >+</button>
                         </div>
                        <button 
                            type="submit" 
                            disabled={processing || item.stok <= 0}
                            className={`flex-1 py-3 px-4 rounded-xl font-bold text-white transition shadow-lg transform active:scale-95
                                ${item.stok > 0 
                                    ? 'bg-[#1B4D3E] hover:bg-[#153e32] hover:shadow-green-900/20' 
                                    : 'bg-gray-300 cursor-not-allowed shadow-none'}`}
                        >
                            {processing ? 'Menambahkan...' : (item.stok > 0 ? 'Keranjang 🛒' : 'Stok Habis')}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
}
