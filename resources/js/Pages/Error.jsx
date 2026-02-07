import React from 'react';
import { Head, Link } from '@inertiajs/react';

export default function Error({ status }) {
    const title = {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden',
    }[status];

    const description = {
        503: 'Maaf, kami sedang melakukan pemeliharaan. Silakan periksa kembali beberapa saat lagi.',
        500: 'Oops, terjadi kesalahan pada server kami.',
        404: 'Maaf, halaman yang Anda cari tidak dapat ditemukan.',
        403: 'Maaf, Anda tidak memiliki akses ke halaman ini.',
    }[status];

    return (
        <div className="min-h-screen flex items-center justify-center bg-green-50 font-sans">
            <Head title={title} />
            <div className="text-center p-8 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl max-w-lg border border-white/50">
                <div className="mb-6 flex justify-center">
                     <img 
                        src="/image/access_denied_cute.png" 
                        alt="Sad Broccoli" 
                        className="w-64 h-64 object-contain drop-shadow-lg animate-bounce-slow"
                    />
                </div>
                <h1 className="text-4xl font-extrabold text-green-800 mb-4">{status}</h1>
                <p className="text-lg text-gray-600 mb-8">{description}</p>
                <Link href="/" className="inline-block bg-green-600 text-white font-bold py-3 px-8 rounded-full hover:bg-green-700 transition transform hover:scale-105 shadow-md">
                    Kembali ke Beranda
                </Link>
            </div>
            <style>{`
                @keyframes bounce-slow {
                    0%, 100% { transform: translateY(-5%); }
                    50% { transform: translateY(5%); }
                }
                .animate-bounce-slow {
                    animation: bounce-slow 3s infinite ease-in-out;
                }
            `}</style>
        </div>
    );
}
