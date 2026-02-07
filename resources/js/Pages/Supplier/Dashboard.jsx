import React, { useMemo } from 'react';
import { Head, Link } from '@inertiajs/react';
import SupplierLayout from '@/Layouts/SupplierLayout';
import { Chart as ChartJS, CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend } from 'chart.js';
import { Bar } from 'react-chartjs-2';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

// Helper
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

export default function SupplierDashboard({ 
    produkCount, 
    produkStokRendah, 
    totalPendapatan, 
    transaksiPending, 
    produkTerjual, // Object: { 'Bayam': 10, 'Wortel': 5 }
    produkList
}) {
    // Prepare Chart Data
    const chartData = useMemo(() => {
        const labels = Object.keys(produkTerjual);
        const data = Object.values(produkTerjual);

        return {
            labels,
            datasets: [
                {
                    label: 'Terjual (Unit)',
                    data: data,
                    backgroundColor: 'rgba(25, 135, 84, 0.6)',
                },
            ],
        };
    }, [produkTerjual]);

    return (
        <SupplierLayout>
            <Head title="Dashboard Supplier" />
            
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-800">🚜 Dashboard Supplier</h1>
                <p className="text-gray-500">Ringkasan performa penjualan dan stok produk Anda.</p>
            </div>
            
            {/* Stats Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                 <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div className="p-4 rounded-full bg-green-100 text-green-600 mr-4 text-2xl">🥬</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Total Produk</div>
                        <div className="text-2xl font-bold text-gray-800">{produkCount}</div>
                    </div>
                </div>
                 <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div className="p-4 rounded-full bg-blue-100 text-blue-600 mr-4 text-2xl">💰</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Pendapatan</div>
                        <div className="text-lg font-bold text-gray-800">{formatRupiah(totalPendapatan)}</div>
                    </div>
                </div>
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                     <div className="p-4 rounded-full bg-yellow-100 text-yellow-600 mr-4 text-2xl">⏳</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Pesanan Pending</div>
                        <div className="text-2xl font-bold text-gray-800">{transaksiPending}</div>
                    </div>
                </div>
                 <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                     <div className="p-4 rounded-full bg-red-100 text-red-600 mr-4 text-2xl">⚠️</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Stok Menipis</div>
                        <div className="text-2xl font-bold text-gray-800">{produkStokRendah.length}</div>
                    </div>
                </div>
            </div>

            {/* Warning Alert for Low Stock */}
            {produkStokRendah.length > 0 && (
                <div className="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl mb-8 shadow-sm">
                    <div className="flex items-center">
                        <div className="flex-shrink-0">
                            <svg className="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fillRule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clipRule="evenodd" />
                            </svg>
                        </div>
                        <div className="ml-3">
                            <h3 className="text-sm font-bold text-yellow-800">Perhatian: Stok Menipis</h3>
                            <div className="mt-2 text-sm text-yellow-700">
                                <ul className="list-disc pl-5 space-y-1">
                                    {produkStokRendah.map(p => (
                                        <li key={p.id}>
                                            <span className="font-semibold">{p.nama}</span> (Sisa: {p.stok}) - 
                                            <Link href={`/supplier/produk/${p.id}/edit`} className="ml-1 underline hover:text-yellow-900">Restock sekarang</Link>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {/* Chart Section */}
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 className="font-bold text-gray-800 mb-4 text-lg">📊 Penjualan Produk</h3>
                    <div className="h-64">
                         <Bar options={{ responsive: true, maintainAspectRatio: false }} data={chartData} />
                    </div>
                </div>

                {/* Recent Products Table */}
                 <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 className="font-bold text-gray-800">Daftar Produk Terbaru</h3>
                        <Link href="/supplier/produk" className="text-sm text-green-600 hover:underline">Kelola Semua</Link>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left">
                            <thead className="bg-gray-50 text-gray-600">
                                <tr>
                                    <th className="px-6 py-3">Nama</th>
                                    <th className="px-6 py-3">Harga</th>
                                    <th className="px-6 py-3">Stok</th>
                                    <th className="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {produkList.slice(0, 5).map(p => (
                                    <tr key={p.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4 font-medium">{p.nama}</td>
                                        <td className="px-6 py-4">{formatRupiah(p.harga)}</td>
                                        <td className="px-6 py-4">{p.stok}</td>
                                        <td className="px-6 py-4">
                                            {p.stok > 0 ? (
                                                <span className="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Tersedia</span>
                                            ) : (
                                                <span className="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Habis</span>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </SupplierLayout>
    );
}
