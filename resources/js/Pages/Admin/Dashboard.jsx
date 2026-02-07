import React, { useMemo } from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement
} from 'chart.js';
import { Line, Pie } from 'react-chartjs-2';

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement
);

// Helper
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

export default function AdminDashboard({ 
    supplierCount, 
    pelangganCount, 
    produkCount, 
    pesananCount,
    bulan,
    jumlahPesanan,
    produkTerlaris,
    suppliersTerbaru,
    pesananTerbaru
}) {

    // Chart Data Preparation
    const lineChartData = useMemo(() => ({
        labels: bulan,
        datasets: [
            {
                label: 'Jumlah Pesanan Bulanan',
                data: jumlahPesanan,
                borderColor: 'rgb(53, 162, 235)',
                backgroundColor: 'rgba(53, 162, 235, 0.5)',
                tension: 0.4
            },
        ],
    }), [bulan, jumlahPesanan]);

    const pieChartData = useMemo(() => {
        // Handle potential missing data gracefully
        const labels = produkTerlaris?.map(p => p.produk ? p.produk.nama_produk : 'Unknown') || [];
        const data = produkTerlaris?.map(p => p.total) || [];

        return {
            labels: labels,
            datasets: [
                {
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                    borderWidth: 1,
                },
            ],
        };
    }, [produkTerlaris]);

    return (
        <AdminLayout>
            <Head title="Admin Dashboard" />
            
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-800">📊 Dashboard Overview</h1>
                <p className="text-gray-500">Ringkasan statistik toko dan aktivitas terbaru.</p>
            </div>

            {/* Stats Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div className="p-4 rounded-full bg-blue-100 text-blue-600 mr-4 text-2xl">👷</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Suppliers</div>
                        <div className="text-2xl font-bold text-gray-800">{supplierCount}</div>
                    </div>
                </div>
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div className="p-4 rounded-full bg-green-100 text-green-600 mr-4 text-2xl">👥</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Pelanggan</div>
                        <div className="text-2xl font-bold text-gray-800">{pelangganCount}</div>
                    </div>
                </div>
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                     <div className="p-4 rounded-full bg-yellow-100 text-yellow-600 mr-4 text-2xl">🥕</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Produk</div>
                        <div className="text-2xl font-bold text-gray-800">{produkCount}</div>
                    </div>
                </div>
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                     <div className="p-4 rounded-full bg-red-100 text-red-600 mr-4 text-2xl">📦</div>
                    <div>
                        <div className="text-gray-500 text-sm font-bold uppercase">Pesanan</div>
                        <div className="text-2xl font-bold text-gray-800">{pesananCount}</div>
                    </div>
                </div>
            </div>

            {/* Charts Section */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 className="font-bold text-gray-800 mb-4 text-lg">📈 Tren Pesanan</h3>
                    <div className="h-64">
                         <Line options={{ responsive: true, maintainAspectRatio: false }} data={lineChartData} />
                    </div>
                </div>
                <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 className="font-bold text-gray-800 mb-4 text-lg">🍩 Produk Terlaris</h3>
                    <div className="h-64 flex justify-center">
                         <Pie options={{ responsive: true, maintainAspectRatio: false }} data={pieChartData} />
                    </div>
                </div>
            </div>

            {/* Recent Activity Section */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {/* Recent Orders */}
                <div className="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 className="font-bold text-gray-800">Pesanan Terbaru</h3>
                        <Link href="/admin/pesanan" className="text-sm text-blue-600 hover:underline">Lihat Semua</Link>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left">
                            <thead className="bg-gray-50 text-gray-600">
                                <tr>
                                    <th className="px-6 py-3">Kode</th>
                                    <th className="px-6 py-3">Pelanggan</th>
                                    <th className="px-6 py-3">Total</th>
                                    <th className="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {pesananTerbaru.map(p => (
                                    <tr key={p.id}>
                                        <td className="px-6 py-4 font-medium">#{p.kode_pesanan}</td>
                                        <td className="px-6 py-4">{p.user ? p.user.name : '-'}</td>
                                        <td className="px-6 py-4">{formatRupiah(p.total_harga)}</td>
                                        <td className="px-6 py-4">
                                            <span className={`px-2 py-0.5 rounded text-xs font-bold ${
                                                p.status === 'selesai' ? 'bg-green-100 text-green-700' : 
                                                p.status === 'dibatalkan' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'
                                            }`}>
                                                {p.status}
                                            </span>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* New Suppliers */}
                <div className="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 className="font-bold text-gray-800">Supplier Baru</h3>
                        <Link href="/admin/suppliers" className="text-sm text-blue-600 hover:underline">Kelola</Link>
                    </div>
                    <ul className="divide-y divide-gray-100">
                        {suppliersTerbaru.map(s => (
                            <li key={s.id} className="p-4 flex items-center justify-between hover:bg-gray-50">
                                <div>
                                    <div className="font-bold text-gray-800">{s.name}</div>
                                    <div className="text-xs text-gray-400">{new Date(s.created_at).toLocaleDateString()}</div>
                                </div>
                                <span className={`text-xs px-2 py-1 rounded font-bold ${s.status_akun === 'aktif' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'}`}>
                                    {s.status_akun || 'pending'}
                                </span>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>

        </AdminLayout>
    );
}
