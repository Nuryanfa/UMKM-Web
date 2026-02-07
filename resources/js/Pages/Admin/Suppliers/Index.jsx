import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Swal from 'sweetalert2';

export default function AdminSuppliers({ suppliers }) {
    const { post } = useForm();

    const handleAction = (id, action) => {
        const isApprove = action === 'approve';
        Swal.fire({
            title: isApprove ? 'Setujui Supplier?' : 'Tolak Supplier?',
            text: isApprove 
                ? "Akun supplier akan diaktifkan dan dapat mulai berjualan." 
                : "Akun supplier akan dinonaktifkan.",
            icon: isApprove ? 'success' : 'warning',
            showCancelButton: true,
            confirmButtonColor: isApprove ? '#198754' : '#d33',
            confirmButtonText: isApprove ? 'Setujui' : 'Tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                post(`/admin/suppliers/${id}/${action}`, {
                    onSuccess: () => Swal.fire('Berhasil', isApprove ? 'Supplier disetujui.' : 'Supplier ditolak.', 'success')
                });
            }
        });
    };

    return (
        <AdminLayout>
            <Head title="Verifikasi Supplier" />
            
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-800">🚜 Verifikasi Supplier</h1>
                <p className="text-gray-500">Tinjau pendaftaran petani dan supplier baru.</p>
            </div>

            <div className="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-sm text-gray-600">
                        <thead className="bg-gray-50 text-gray-800 font-bold uppercase text-xs">
                            <tr>
                                <th className="px-6 py-4">Nama Supplier</th>
                                <th className="px-6 py-4">Email / Kontak</th>
                                <th className="px-6 py-4">Tanggal Daftar</th>
                                <th className="px-6 py-4">Status</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100">
                            {suppliers.length === 0 ? (
                                <tr>
                                    <td colSpan="5" className="px-6 py-12 text-center flex flex-col items-center justify-center text-gray-400">
                                        <div className="text-4xl mb-2">✨</div>
                                        <p>Semua beres! Tidak ada permintaan verifikasi baru.</p>
                                    </td>
                                </tr>
                            ) : (
                                suppliers.map((sup) => (
                                    <tr key={sup.id} className="hover:bg-gray-50 transition">
                                        <td className="px-6 py-4 font-medium text-gray-900 text-lg">
                                            {sup.name}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="text-gray-800 font-bold">{sup.email}</div>
                                            <div className="text-xs text-gray-400">{sup.no_hp || '-'}</div>
                                        </td>
                                        <td className="px-6 py-4">
                                            {new Date(sup.created_at).toLocaleDateString('id-ID')}
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                                PENDING
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <div className="flex justify-center gap-2">
                                                <button 
                                                    onClick={() => handleAction(sup.id, 'approve')}
                                                    className="bg-green-100 hover:bg-green-200 text-green-700 px-4 py-2 rounded-lg font-bold transition flex items-center gap-1"
                                                >
                                                    ✅ Setujui
                                                </button>
                                                <button 
                                                    onClick={() => handleAction(sup.id, 'reject')}
                                                    className="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-bold transition flex items-center gap-1"
                                                >
                                                    ❌ Tolak
                                                </button>
                                            </div>
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
