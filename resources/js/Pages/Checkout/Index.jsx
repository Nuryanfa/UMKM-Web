import React, { useState, useEffect } from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import Swal from 'sweetalert2';

// Helper
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

export default function CheckoutIndex({ items, subtotal, couriers, midtransClientKey }) {
    const { auth } = usePage().props;
    const [selectedCourier, setSelectedCourier] = useState(null);
    const [processing, setProcessing] = useState(false);
    
    const { data, setData } = useForm({
        delivery_address: auth.user.alamat || '',
        courier_name: '',
        shipping_cost: 0
    });

    useEffect(() => {
        // Load Midtrans Snap Script
        const script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', midtransClientKey);
        document.body.appendChild(script);

        return () => {
            document.body.removeChild(script);
        }
    }, [midtransClientKey]);

    const handleCourierSelect = (courier) => {
        setSelectedCourier(courier);
        setData(prev => ({
            ...prev,
            courier_name: courier.name,
            shipping_cost: courier.cost
        }));
    };

    const handlePayment = () => {
        if (!data.delivery_address || data.delivery_address.length < 10) {
            Swal.fire('Gagal', 'Alamat pengiriman harus diisi lengkap (min 10 karakter).', 'warning');
            return;
        }
        if (!selectedCourier) {
            Swal.fire('Gagal', 'Pilih kurir pengiriman terlebih dahulu.', 'warning');
            return;
        }

        setProcessing(true);

        // Fetch to get Snap Token (Note: We use fetch instead of Inertia.post because we want to stay on page and open popup)
        // Or we can use Axios.
        // Fetch to get Snap Token with proper headers
        fetch('/pembayaran/proses', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json', // Critical for Laravel validation responses
                'X-Requested-With': 'XMLHttpRequest', // Helps Laravel identify AJAX
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(async res => {
            const isJson = res.headers.get('content-type')?.includes('application/json');
            const data = isJson ? await res.json() : null;

            if (!res.ok) {
                // Handle non-200 responses (e.g. 422 Validation Error)
                const errorMsg = (data && data.message) || (data && data.error) || 'Terjadi kesalahan pada server.';
                throw new Error(errorMsg);
            }
            return data;
        })
        .then(response => {
             setProcessing(false);
             if (response.error) {
                 Swal.fire('Gagal', response.error, 'error');
                 return;
             }

             if (response.snap_token) {
                 if (window.snap) {
                     window.snap.pay(response.snap_token, {
                         onSuccess: function(result) {
                             window.location.href = `/keranjang?payment_status=success&order_id=${result.order_id}`;
                         },
                         onPending: function(result) {
                             window.location.href = `/keranjang?payment_status=pending&order_id=${result.order_id}`;
                         },
                         onError: function(result) {
                             Swal.fire('Pembayaran Gagal', 'Maaf, pembayaran Anda gagal.', 'error');
                         },
                         onClose: function() {
                             Swal.fire('Dibatalkan', 'Anda menutup popup pembayaran.', 'info');
                         }
                     });
                 } else {
                      Swal.fire('Error', 'Sistem pembayaran belum siap. Silakan refresh halaman.', 'error');
                 }
             }
        })
        .catch(err => {
            setProcessing(false);
            console.error(err);
            Swal.fire('Gagal', err.message || 'Gagal memproses pembayaran.', 'error');
        });
    };

    const total = subtotal + (selectedCourier ? selectedCourier.cost : 0);

    return (
        <MainLayout>
             <Head title="Checkout" />
             <div className="container mx-auto px-4 py-8">
                <h1 className="text-3xl font-bold text-gray-800 mb-8 text-center">📦 Konfirmasi Pesanan</h1>
                
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Left Column: Form & Items */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* 1. Address Section */}
                        <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h2 className="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <span className="bg-green-100 text-green-600 w-8 h-8 flex items-center justify-center rounded-full text-sm mr-3">1</span>
                                Alamat Pengiriman
                            </h2>
                            <textarea 
                                className="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 bg-gray-50"
                                rows="3"
                                placeholder="Jalan, Nomor Rumah, RT/RW, Kecamatan, Kota, Kode Pos"
                                value={data.delivery_address}
                                onChange={e => setData('delivery_address', e.target.value)}
                            ></textarea>
                            <div className="mt-2 text-sm text-gray-500">
                                Penerima: <strong>{auth.user.name}</strong> ({auth.user.email})
                            </div>
                        </div>

                         {/* 2. Courier Section */}
                        <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h2 className="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <span className="bg-green-100 text-green-600 w-8 h-8 flex items-center justify-center rounded-full text-sm mr-3">2</span>
                                Metode Pengiriman
                            </h2>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {couriers.map((courier, idx) => (
                                    <div 
                                        key={idx}
                                        onClick={() => handleCourierSelect(courier)}
                                        className={`cursor-pointer border-2 rounded-xl p-4 transition-all ${
                                            selectedCourier?.name === courier.name 
                                            ? 'border-green-500 bg-green-50 ring-2 ring-green-200' 
                                            : 'border-gray-200 hover:border-green-300'
                                        }`}
                                    >
                                        <div className="flex justify-between items-center mb-1">
                                            <span className="font-bold text-gray-800">{courier.name}</span>
                                            {selectedCourier?.name === courier.name && (
                                                <span className="text-green-600 font-bold">✓</span>
                                            )}
                                        </div>
                                        <div className="text-green-600 font-bold">{formatRupiah(courier.cost)}</div>
                                        <div className="text-xs text-gray-400 mt-1">Estimasi: {courier.etd}</div>
                                    </div>
                                ))}
                            </div>
                        </div>
                        
                         {/* 3. Items Review */}
                        <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h2 className="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <span className="bg-green-100 text-green-600 w-8 h-8 flex items-center justify-center rounded-full text-sm mr-3">3</span>
                                Item Pesanan
                            </h2>
                            <ul className="divide-y divide-gray-100">
                                {items.map(item => (
                                    <li key={item.id} className="py-3 flex justify-between">
                                        <div className="flex items-center">
                                            <span className="bg-gray-100 px-2 py-1 rounded text-xs font-bold text-gray-600 mr-3">{item.jumlah}x</span>
                                            <span className="text-gray-700">{item.produk.nama_produk}</span>
                                        </div>
                                        <span className="font-medium text-gray-900">{formatRupiah(item.jumlah * item.produk.harga)}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>

                    {/* Right Column: Summary */}
                    <div className="lg:col-span-1">
                        <div className="bg-white p-6 rounded-3xl shadow-lg border border-gray-100 sticky top-24">
                            <h3 className="text-xl font-bold text-gray-800 mb-6">Ringkasan Pembayaran</h3>

                            <div className="space-y-3 mb-6 text-sm">
                                <div className="flex justify-between text-gray-600">
                                    <span>Subtotal Produk</span>
                                    <span>{formatRupiah(subtotal)}</span>
                                </div>
                                <div className="flex justify-between text-gray-600">
                                    <span>Biaya Pengiriman</span>
                                    <span className="text-green-600">{formatRupiah(selectedCourier ? selectedCourier.cost : 0)}</span>
                                </div>
                                <hr className="border-dashed border-gray-200" />
                                <div className="flex justify-between items-center text-lg">
                                    <span className="font-bold text-gray-800">Total Bayar</span>
                                    <span className="font-bold text-green-700 text-xl">{formatRupiah(total)}</span>
                                </div>
                            </div>
                            
                            <button
                                onClick={handlePayment}
                                disabled={processing || !selectedCourier}
                                className={`w-full py-4 rounded-xl font-bold text-white transition shadow-lg 
                                    ${processing || !selectedCourier 
                                        ? 'bg-gray-300 cursor-not-allowed' 
                                        : 'bg-green-600 hover:bg-green-700 hover:shadow-xl transform hover:-translate-y-1'
                                    }`}
                            >
                                {processing ? 'Memproses...' : 'Bayar Sekarang 🔒'}
                            </button>
                            
                            <p className="text-center text-xs text-gray-400 mt-4">
                                Pembayaran aman diproses oleh Midtrans.
                            </p>
                        </div>
                    </div>
                </div>
             </div>
        </MainLayout>
    );
}
