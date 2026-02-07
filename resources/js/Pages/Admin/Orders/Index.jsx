import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Swal from 'sweetalert2';

// Helper
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

export default function AdminOrders({ orders }) {
    const { patch } = useForm();

    const handleStatusChange = (id, newStatus) => {
        Swal.fire({
            title: 'Ubah Status?',
            text: `Ubah status pesanan menjadi "${newStatus}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Ubah',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                patch(`/admin/pesanan/${id}/status`, { status: newStatus }, {
                    onSuccess: () => Swal.fire('Berhasil', 'Status pesanan berhasil diperbarui', 'success'),
                    onError: () => Swal.fire('Gagal', 'Terjadi kesalahan saat memperbarui status', 'error'),
                    data: { status: newStatus } // Ensure data is passed correctly usually via second arg, but standard inertia helpers put data in second arg
                });
                // Note: The inertia helper syntax is (url, data, options). Correct above.
            }
        });
    };

    const getStatusColor = (status) => {
        switch(status) {
            case 'diproses': return 'bg-blue-100 text-blue-700';
            case 'dikirim': return 'bg-yellow-100 text-yellow-700';
            case 'selesai': return 'bg-green-100 text-green-700';
            case 'dibatalkan': return 'bg-red-100 text-red-700';
            default: return 'bg-gray-100 text-gray-700';
        }
    };

    return (
        <AdminLayout>
            <Head title="Kelola Pesanan" />
            
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-800">📦 Kelola Pesanan</h1>
                <p className="text-gray-500">Pantau dan update status pesanan pelanggan.</p>
            </div>

            <div className="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-sm text-gray-600">
                        <thead className="bg-gray-50 text-gray-800 font-bold uppercase text-xs">
                            <tr>
                                <th className="px-6 py-4">ID Pesanan</th>
                                <th className="px-6 py-4">Pelanggan</th>
                                <th className="px-6 py-4">Tanggal</th>
                                <th className="px-6 py-4">Total</th>
                                <th className="px-6 py-4">Status</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100">
                            {orders.length === 0 ? (
                                <tr>
                                    <td colSpan="6" className="px-6 py-8 text-center text-gray-400">
                                        Belum ada pesanan masuk.
                                    </td>
                                </tr>
                            ) : (
                                orders.map((order) => (
                                    <tr key={order.id} className="hover:bg-gray-50 transition">
                                        <td className="px-6 py-4 font-medium text-gray-900">
                                            #{order.kode_pesanan || order.order_id}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="font-bold text-gray-800">{order.user.name}</div>
                                            <div className="text-xs text-gray-400">{order.user.email}</div>
                                        </td>
                                        <td className="px-6 py-4">
                                            {new Date(order.created_at).toLocaleDateString('id-ID')}
                                        </td>
                                        <td className="px-6 py-4 font-bold text-green-600">
                                            {formatRupiah(order.total_harga)}
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`px-3 py-1 rounded-full text-xs font-bold ${getStatusColor(order.status)}`}>
                                                {order.status.toUpperCase()}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <select 
                                                onChange={(e) => {
                                                    if (e.target.value) handleStatusChange(order.id, e.target.value);
                                                    e.target.value = ""; // Reset select for UX
                                                }}
                                                className="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                defaultValue=""
                                            >
                                                <option value="" disabled>Update Status</option>
                                                <option value="diproses">🔄 Diproses</option>
                                                <option value="dikirim">🚚 Dikirim</option>
                                                <option value="selesai">✅ Selesai</option>
                                                <option value="dibatalkan">❌ Batalkan</option>
                                            </select>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
