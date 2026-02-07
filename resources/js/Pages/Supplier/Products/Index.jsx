import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import SupplierLayout from '@/Layouts/SupplierLayout';
import Swal from 'sweetalert2';

// Helper
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

export default function ProductIndex({ products }) { // Note: Controller passes 'products' (paginated usually) or 'produkList'
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Produk yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                destroy(`/supplier/produk/${id}`, {
                    onSuccess: () => Swal.fire('Terhapus!', 'Produk berhasil dihapus.', 'success')
                });
            }
        });
    };

    return (
        <SupplierLayout>
            <Head title="Kelola Produk" />
            
            <div className="flex justify-between items-center mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-800">🥕 Kelola Produk</h1>
                    <p className="text-gray-500">Tambah, edit, dan pantau stok produk Anda.</p>
                </div>
                <Link 
                    href="/supplier/produk/create" 
                    className="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2"
                >
                    <span>+</span> Tambah Produk
                </Link>
            </div>

            <div className="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-sm text-gray-600">
                        <thead className="bg-gray-50 text-gray-800 font-bold uppercase text-xs">
                            <tr>
                                <th className="px-6 py-4">Gambar</th>
                                <th className="px-6 py-4">Nama Produk</th>
                                <th className="px-6 py-4">Harga</th>
                                <th className="px-6 py-4">Stok</th>
                                <th className="px-6 py-4">Kategori</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100">
                             {/* Handle both Pagination object or Array */}
                             {(products.data || products).length === 0 ? (
                                <tr>
                                    <td colSpan="6" className="px-6 py-12 text-center text-gray-400">
                                        Belum ada produk. Silakan tambah produk baru.
                                    </td>
                                </tr>
                            ) : (
                                (products.data || products).map((product) => (
                                    <tr key={product.id} className="hover:bg-gray-50 transition">
                                        <td className="px-6 py-4">
                                            <div className="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                                <img 
                                                    src={product.gambar ? `/storage/${product.gambar}` : 'https://placehold.co/100x100?text=No+Img'} 
                                                    alt={product.nama_produk} 
                                                    className="w-full h-full object-cover"
                                                />
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 font-bold text-gray-900">{product.nama_produk || product.nama}</td>
                                        <td className="px-6 py-4 text-green-600 font-bold">{formatRupiah(product.harga)}</td>
                                        <td className="px-6 py-4">
                                            <span className={`px-2 py-1 rounded text-xs font-bold ${product.stok < 5 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'}`}>
                                                {product.stok} Unit
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">{product.kategori || 'Umum'}</span>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <div className="flex justify-center gap-2">
                                                <Link 
                                                    href={`/supplier/produk/${product.id}/edit`} 
                                                    className="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 p-2 rounded-lg transition"
                                                    title="Edit"
                                                >
                                                    ✎
                                                </Link>
                                                <button 
                                                    onClick={() => handleDelete(product.id)}
                                                    className="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition"
                                                    title="Hapus"
                                                >
                                                    🗑️
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
                {/* Simple Pagination if needed */}
                {products.links && (
                    <div className="p-4 border-t border-gray-100">
                        {/* Render pagination links here if using Laravel Pagination */}
                    </div>
                )}
            </div>
        </SupplierLayout>
    );
}
