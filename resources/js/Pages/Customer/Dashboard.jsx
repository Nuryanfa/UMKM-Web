import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

// Helper
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });
};

export default function Dashboard({ auth, orders }) {
    return (
        <MainLayout>
            <Head title="Dashboard Pelanggan" />
            
            <div className="container mx-auto px-4 py-12">
                {/* Header */}
                <div className="bg-green-700 rounded-3xl p-8 md:p-12 text-white shadow-xl mb-12 relative overflow-hidden">
                    <div className="relative z-10">
                        <span className="bg-green-600/50 backdrop-blur px-3 py-1 rounded-full text-sm font-medium border border-green-500">
                           👋 Halo, {auth.user.name}
                        </span>
                        <h1 className="text-3xl md:text-5xl font-extrabold mt-4 mb-2">Selamat Datang Kembali!</h1>
                        <p className="text-green-100 max-w-xl text-lg">
                            Pantau pesanan sayuran segar Anda dan kelola akun dengan mudah di sini.
                        </p>
                    </div>
                     <div className="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-green-600 rounded-full opacity-50 blur-3xl"></div>
                     <div className="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-yellow-400 rounded-full opacity-20 blur-3xl"></div>
                </div>

                {/* Content Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Left: Quick Stats/Menu (Optional placeholder for now) */}
                    <div className="lg:col-span-1 space-y-6">
                         <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                             <h3 className="font-bold text-gray-800 mb-4 text-lg">Profil Saya</h3>
                             <div className="flex items-center gap-4 mb-6">
                                 <div className="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-xl">👤</div>
                                 <div className="overflow-hidden">
                                     <div className="font-bold text-gray-900 truncate">{auth.user.name}</div>
                                     <div className="text-sm text-gray-500 truncate">{auth.user.email}</div>
                                 </div>
                             </div>
                             <button className="w-full py-2 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition text-sm font-bold">
                                 Edit Profil
                             </button>
                         </div>
                    </div>

                    {/* Right: Order History */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div className="p-6 border-b border-gray-50 flex justify-between items-center">
                                <h3 className="font-bold text-xl text-gray-800">Riwayat Pesanan</h3>
                                <Link href="/produk-publik" className="text-sm text-green-600 hover:text-green-800 font-bold">
                                    + Pesan Baru
                                </Link>
                            </div>
                            
                            {orders.length === 0 ? (
                                <div className="p-12 text-center text-gray-500">
                                    <div className="text-6xl mb-4">🛒</div>
                                    <p className="mb-4">Belum ada riwayat pesanan.</p>
                                    <Link href="/produk-publik" className="inline-block bg-green-600 text-white px-6 py-2 rounded-full font-bold hover:bg-green-700 transition shadow-lg">
                                        Mulai Belanja
                                    </Link>
                                </div>
                            ) : (
                                <div className="divide-y divide-gray-100">
                                    {orders.map(order => (
                                        <div key={order.id} className="p-6 hover:bg-gray-50 transition">
                                            <div className="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
                                                <div>
                                                    <div className="flex items-center gap-2">
                                                        <span className="font-bold text-gray-900">#{order.order_id}</span>
                                                        <span className={`text-xs px-2 py-0.5 rounded-full font-bold ${
                                                            order.status === 'success' ? 'bg-green-100 text-green-700' :
                                                            order.status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'
                                                        }`}>
                                                            {order.status.toUpperCase()}
                                                        </span>
                                                    </div>
                                                    <p className="text-xs text-gray-400 mt-1">{formatDate(order.created_at)}</p>
                                                </div>
                                                <div className="text-right">
                                                    <div className="font-bold text-green-700 text-lg">{formatRupiah(order.total_harga)}</div>
                                                </div>
                                            </div>
                                            
                                            {/* Order Actions */}
                                            <div className="flex justify-end gap-3 mt-4">
                                                {order.status === 'pending' && (
                                                    <button className="text-sm bg-yellow-400 text-yellow-900 px-4 py-2 rounded-lg font-bold hover:bg-yellow-500 transition">
                                                        Bayar Sekarang
                                                    </button>
                                                )}
                                                <a href={`/invoice/${order.order_id}`} className="text-sm border border-gray-200 text-gray-600 px-4 py-2 rounded-lg font-bold hover:bg-gray-100 transition">
                                                    Invoice
                                                </a>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
