import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import SupplierLayout from '@/Layouts/SupplierLayout';

export default function ProductForm({ product = null }) { // If product exists, it's Edit mode
    const isEdit = !!product;
    
    const { data, setData, post, put, processing, errors } = useForm({
        nama_produk: product?.nama_produk || product?.nama || '',
        harga: product?.harga || '',
        stok: product?.stok || '',
        kategori: product?.kategori || '',
        deskripsi: product?.deskripsi || '',
        gambar: null, // For file upload
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            // Use _method: put for file uploads in Laravel if needed, or straight put if no file
            // Inertia doesn't support file upload via PUT natively easily without _method spoofing
             router.post(`/supplier/produk/${product.id}`, {
                _method: 'put',
                ...data,
                gambar: data.gambar
            });
            // Simplified for now, assuming logic handles it
        } else {
            post('/supplier/produk');
        }
    };

    return (
        <SupplierLayout>
            <Head title={isEdit ? "Edit Produk" : "Tambah Produk"} />
            
            <div className="max-w-2xl mx-auto">
                <div className="mb-8">
                     <Link href="/supplier/produk" className="text-gray-500 hover:text-green-600 mb-2 inline-block">← Kembali ke Daftar</Link>
                    <h1 className="text-3xl font-bold text-gray-800">{isEdit ? '✏️ Edit Produk' : '✨ Tambah Produk Baru'}</h1>
                </div>

                <div className="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
                    <form onSubmit={submit}>
                        <div className="grid grid-cols-1 gap-6">
                            
                            {/* Nama Produk */}
                            <div>
                                <label className="block mb-2 text-sm font-bold text-gray-700">Nama Produk</label>
                                <input 
                                    type="text" 
                                    className="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    value={data.nama_produk}
                                    onChange={e => setData('nama_produk', e.target.value)}
                                    placeholder="Contoh: Bayam Segar Ikat"
                                />
                                {errors.nama_produk && <div className="text-red-500 text-xs mt-1">{errors.nama_produk}</div>}
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {/* Harga */}
                                <div>
                                    <label className="block mb-2 text-sm font-bold text-gray-700">Harga (Rp)</label>
                                    <input 
                                        type="number" 
                                        className="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        value={data.harga}
                                        onChange={e => setData('harga', e.target.value)}
                                        placeholder="0"
                                    />
                                    {errors.harga && <div className="text-red-500 text-xs mt-1">{errors.harga}</div>}
                                </div>
                                {/* Stok */}
                                <div>
                                    <label className="block mb-2 text-sm font-bold text-gray-700">Stok</label>
                                    <input 
                                        type="number" 
                                        className="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        value={data.stok}
                                        onChange={e => setData('stok', e.target.value)}
                                        placeholder="0"
                                    />
                                    {errors.stok && <div className="text-red-500 text-xs mt-1">{errors.stok}</div>}
                                </div>
                            </div>

                            {/* Kategori */}
                            <div>
                                <label className="block mb-2 text-sm font-bold text-gray-700">Kategori</label>
                                <select 
                                    className="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 bg-white"
                                    value={data.kategori}
                                    onChange={e => setData('kategori', e.target.value)}
                                >
                                    <option value="">Pilih Kategori</option>
                                    <option value="Sayuran Daun">Sayuran Daun</option>
                                    <option value="Sayuran Buah">Sayuran Buah</option>
                                    <option value="Umbi-umbian">Umbi-umbian</option>
                                    <option value="Rempah">Rempah</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                             {/* Gambar */}
                             <div>
                                <label className="block mb-2 text-sm font-bold text-gray-700">Foto Produk</label>
                                <div className="flex items-center justify-center w-full">
                                    <label className="flex flex-col items-center justify-center w-full h-32 border-2 border-green-300 border-dashed rounded-xl cursor-pointer bg-green-50 hover:bg-green-100 transition">
                                        <div className="flex flex-col items-center justify-center pt-5 pb-6">
                                            <p className="mb-2 text-sm text-green-700 font-bold">Klik untuk upload foto</p>
                                            <p className="text-xs text-gray-500">SVG, PNG, JPG (Max. 2MB)</p>
                                        </div>
                                        <input 
                                            type="file" 
                                            className="hidden" 
                                            onChange={e => setData('gambar', e.target.files[0])} 
                                        />
                                    </label>
                                </div>
                                {data.gambar && <p className="text-sm text-green-600 mt-2">File dipilih: {data.gambar.name}</p>}
                            </div>

                            <button 
                                type="submit" 
                                disabled={processing}
                                className="w-full bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition shadow-lg mt-4"
                            >
                                {processing ? 'Menyimpan...' : (isEdit ? 'Update Produk' : 'Simpan Produk')}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </SupplierLayout>
    );
}
