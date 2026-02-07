import React from 'react';
import { Head, Link, useForm, router } from '@inertiajs/react'; // Ensure 'router' is imported correctly for manual visits if needed, or use useForm's patch
import MainLayout from '@/Layouts/MainLayout';
import Swal from 'sweetalert2';

// Helper for currency format
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

export default function CartIndex({ items, total, paymentStatus, orderId, latestTransaction }) {
    
    // Handlers
    const updateQuantity = (id, newQty, maxStock) => {
        if (newQty < 1 || newQty > maxStock) return;
        
        router.patch(`/keranjang/${id}`, { jumlah: newQty }, {
            preserveScroll: true,
            onSuccess: () => {
                // Optional toast
            }
        });
    };

    const deleteItem = (id) => {
        Swal.fire({
            title: 'Hapus produk?',
            text: "Produk akan dihapus dari keranjang.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(`/keranjang/${id}`, {
                    preserveScroll: true,
                     onSuccess: () => {
                        Swal.fire('Terhapus!', 'Produk telah dihapus.', 'success');
                    }
                });
            }
        });
    };

    return (
        <MainLayout>
            <Head title="Keranjang Belanja" />
            
            <div className="container mx-auto px-4 py-12 bg-gray-50/50 min-h-screen">
                <div className="max-w-6xl mx-auto">
                    <div className="mb-10 text-center">
                         <h1 className="text-4xl font-extrabold text-[#1B4D3E] mb-3">Keranjang Belanja 🛒</h1>
                         <p className="text-gray-500">Selesaikan pesanan Anda dan nikmati kesegaran alami.</p>
                    </div>
                
                {paymentStatus && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 animate-fade-in">
                        <div className={`bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full text-center transform transition-all scale-100 ${
                            paymentStatus === 'success' ? 'border-t-8 border-green-500' : 
                            paymentStatus === 'pending' ? 'border-t-8 border-yellow-500' : 'border-t-8 border-red-500'
                        }`}>
                            {paymentStatus === 'success' && (
                                <>
                                    <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <span className="text-4xl">🎉</span>
                                    </div>
                                    <h3 className="text-2xl font-extrabold text-gray-800 mb-2">Pembayaran Berhasil!</h3>
                                    <p className="text-gray-500 mb-6">Terima kasih! Pesanan Anda <strong>#{orderId}</strong> telah kami terima dan sedang diproses.</p>
                                    <div className="flex flex-col gap-3">
                                         {latestTransaction && (
                                            <a href={`/invoice/${orderId}`} className="w-full bg-blue-50 text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-blue-100 transition border border-blue-100">
                                                📄 Lihat Invoice
                                            </a>
                                         )}
                                        <Link href="/produk-publik" className="w-full bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg">
                                            🛍️ Belanja Lagi
                                        </Link>
                                    </div>
                                </>
                            )}
                             {paymentStatus === 'pending' && (
                                <>
                                     <div className="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                                        <span className="text-4xl">⏳</span>
                                    </div>
                                    <h3 className="text-2xl font-bold text-gray-800 mb-2">Menunggu Pembayaran</h3>
                                    <p className="text-gray-500 mb-6">Silakan selesaikan pembayaran Anda untuk pesanan <strong>#{orderId}</strong>.</p>
                                    <Link href="/produk-publik" className="w-full inline-block bg-yellow-400 text-yellow-900 px-6 py-3 rounded-xl font-bold hover:bg-yellow-500 transition">
                                        Mengerti
                                    </Link>
                                </>
                             )}
                             {paymentStatus === 'error' && (
                                 <>
                                     <div className="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <span className="text-4xl">❌</span>
                                    </div>
                                    <h3 className="text-2xl font-bold text-gray-800 mb-2">Pembayaran Gagal</h3>
                                    <p className="text-gray-500 mb-6">Maaf, terjadi kesalahan saat memproses pembayaran Anda.</p>
                                    <Link href="/keranjang" className="w-full inline-block bg-red-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-red-700 transition shadow-lg">
                                        Coba Lagi
                                    </Link>
                                 </>
                             )}
                        </div>
                    </div>
                )}

                {items.length === 0 && !paymentStatus ? (
                    <div className="text-center py-20 bg-white rounded-[2.5rem] shadow-sm border border-gray-100">
                         <div className="w-40 h-40 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce-slow">
                            <span className="text-8xl opacity-50">🧺</span>
                        </div>
                        <h3 className="text-2xl font-bold text-gray-800 mb-2">Keranjang Anda Kosong</h3>
                        <p className="text-gray-500 mt-2 max-w-md mx-auto">Sepertinya Anda belum memilih sayuran segar hari ini. Yuk, isi keranjangmu dengan kebaikan alam!</p>
                        <Link href="/produk-publik" className="mt-8 inline-flex items-center gap-2 bg-[#1B4D3E] text-white px-10 py-4 rounded-full font-bold hover:bg-[#153e32] transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            <span>🌿</span> Mulai Belanja
                        </Link>
                    </div>
                ) : ( items.length > 0 && (
                    <div className="flex flex-col lg:flex-row gap-8 items-start">
                        {/* Cart Items List */}
                        <div className="w-full lg:w-2/3 space-y-6">
                            {items.map((item) => (
                                <div key={item.id} className="group bg-white p-6 rounded-3xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 flex flex-col sm:flex-row items-center gap-6 relative">
                                    <div className="w-32 h-32 flex-shrink-0 bg-gray-50 rounded-2xl overflow-hidden shadow-inner">
                                         <img 
                                            src={item.produk.gambar_produk ? `/${item.produk.gambar_produk}` : 'https://placehold.co/150x150'} 
                                            alt={item.produk.nama_produk}
                                            className="w-full h-full object-cover transform group-hover:scale-110 transition duration-500"
                                        />
                                    </div>
                                    
                                    <div className="flex-grow text-center sm:text-left w-full">
                                        <div className="flex justify-between items-start mb-2">
                                            <h3 className="text-xl font-bold text-gray-900 line-clamp-1">{item.produk.nama_produk}</h3>
                                            <button 
                                                onClick={() => deleteItem(item.id)}
                                                className="text-gray-300 hover:text-red-500 transition px-2"
                                                title="Hapus"
                                            >
                                                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                        <p className="text-sm text-gray-500 mb-4">{item.produk.kategori || 'Sayuran Segar'}</p>
                                        
                                        <div className="flex flex-col sm:flex-row items-center justify-between gap-4">
                                            <p className="text-green-700 font-bold text-lg">{formatRupiah(item.produk.harga)}</p>
                                            
                                            <div className="flex items-center bg-gray-100/50 rounded-full p-1 border border-gray-200">
                                                <button 
                                                    onClick={() => updateQuantity(item.id, item.jumlah - 1, item.produk.stok)}
                                                    className="w-10 h-10 flex items-center justify-center bg-white text-gray-700 hover:text-green-700 rounded-full shadow-sm hover:shadow transition disabled:opacity-50"
                                                    disabled={item.jumlah <= 1}
                                                >
                                                    -
                                                </button>
                                                <input 
                                                    type="text" 
                                                    readOnly 
                                                    value={item.jumlah} 
                                                    className="w-12 text-center bg-transparent border-none font-bold text-gray-800 focus:ring-0 p-0" 
                                                />
                                                <button 
                                                    onClick={() => updateQuantity(item.id, item.jumlah + 1, item.produk.stok)}
                                                    className="w-10 h-10 flex items-center justify-center bg-[#1B4D3E] text-white rounded-full shadow-sm hover:bg-[#153e32] transition disabled:opacity-50"
                                                    disabled={item.jumlah >= item.produk.stok}
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Summary & Checkout */}
                        <div className="w-full lg:w-1/3">
                            <div className="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 sticky top-28">
                                <h3 className="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                    <span>🧾</span> Ringkasan
                                </h3>
                                
                                <div className="space-y-4 mb-8">
                                    <div className="flex justify-between text-gray-500">
                                        <span>Total Item</span>
                                        <span className="font-medium">{items.reduce((acc, curr) => acc + curr.jumlah, 0)} Pcs</span>
                                    </div>
                                    <div className="flex justify-between text-gray-500">
                                        <span>Subtotal</span>
                                        <span className="font-medium">{formatRupiah(total)}</span>
                                    </div>
                                     <div className="flex justify-between text-gray-500">
                                        <span>Pajak (0%)</span>
                                        <span className="font-medium">Rp 0</span>
                                    </div>
                                    <div className="border-t border-dashed border-gray-200 my-4 pt-4">
                                        <div className="flex justify-between items-center">
                                            <span className="text-lg font-bold text-gray-800">Total Akhir</span>
                                            <span className="text-3xl font-bold text-green-700">{formatRupiah(total)}</span>
                                        </div>
                                    </div>
                                </div>

                                {/* Promo Code Helper (Visual Only) */}
                                <div className="mb-6">
                                     <div className="flex gap-2">
                                        <input type="text" placeholder="Kode Promo" className="flex-1 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-green-500 focus:ring-green-200 transition px-4 py-3 text-sm" />
                                        <button className="bg-gray-200 text-gray-600 px-4 py-3 rounded-xl font-bold text-sm hover:bg-gray-300 transition">Gunakan</button>
                                     </div>
                                </div>

                                <Link 
                                    href="/pembayaran" 
                                    className="block w-full text-center bg-[#1B4D3E] text-white font-bold py-4 rounded-xl hover:bg-[#153e32] transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-lg mb-4"
                                >
                                    Lanjut Checkout ➔
                                </Link>
                                <Link 
                                    href="/produk-publik" 
                                    className="block w-full text-center text-gray-500 hover:text-green-700 font-semibold transition text-sm"
                                >
                                    Kembali Belanja
                                </Link>
                            </div>
                            
                             <div className="mt-6 bg-green-50 p-6 rounded-3xl border border-green-100 text-center">
                                <p className="text-green-800 text-sm font-medium">✨ Jaminan Kesegaran 100% atau Uang Kembali</p>
                            </div>
                        </div>
                    </div>
                ))}
                </div>
            </div>
        </MainLayout>
    );
}
