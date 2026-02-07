import React, { useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import AOS from 'aos';
import 'aos/dist/aos.css';

export default function Home() {
    useEffect(() => {
        AOS.init({ duration: 1000, once: true });
    }, []);

    return (
        <MainLayout>
            <Head title="Beranda" />
            
            {/* Hero Section: Split Screen */}
            <section className="min-h-[calc(100vh-80px)] flex flex-col md:flex-row bg-[#FAFAF9]">
                {/* Left: Content */}
                <div className="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-16 lg:px-24 py-12 md:py-0 order-2 md:order-1">
                    <div data-aos="fade-right">
                        <span className="inline-block py-1 px-3 rounded-full bg-green-100 text-green-700 text-sm font-bold mb-6 tracking-wide">
                            🌱 Fresh From Local Farmers
                        </span>
                        <h1 className="text-5xl lg:text-7xl font-sans font-extrabold text-[#1B4D3E] leading-tight mb-6">
                            Sayur Segar,<br/>
                            Langsung dari<br/>
                            Petani Lokal.
                        </h1>
                        <p className="text-lg text-gray-600 mb-8 max-w-md leading-relaxed">
                            Nikmati kualitas terbaik hasil panen hari ini. Kami menghubungkan Anda langsung dengan petani untuk kesegaran yang tak tertandingi.
                        </p>
                        <div className="flex gap-4">
                            <Link href="/produk-publik" 
                                className="inline-flex items-center justify-center bg-[#10B981] hover:bg-[#059669] text-white font-bold py-4 px-10 rounded-full transition transform hover:scale-105 shadow-xl text-lg">
                                Belanja Sekarang
                            </Link>
                        </div>
                        
                        <div className="mt-12 flex items-center gap-4 text-sm text-gray-500 font-medium">
                            <div className="flex -space-x-3">
                                <div className="w-10 h-10 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs">🧑‍🌾</div>
                                <div className="w-10 h-10 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs">👩‍🌾</div>
                                <div className="w-10 h-10 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs">🚜</div>
                            </div>
                            <p>Didukung oleh 50+ Petani Lokal</p>
                        </div>
                    </div>
                </div>

                {/* Right: Image */}
                <div className="w-full md:w-1/2 relative order-1 md:order-2 h-[50vh] md:h-auto overflow-hidden">
                    <img 
                        src="/image/hero_vegetables_crate.png" 
                        alt="Sayur Segar dalam Peti Kayu" 
                        className="absolute inset-0 w-full h-full object-cover object-center transform transition duration-1000 hover:scale-105"
                    />
                     <div className="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent md:hidden"></div>
                </div>
            </section>

            {/* Portal Access Section */}
            <section className="py-24 bg-white">
                <div className="container mx-auto px-4">
                    <div className="text-center mb-16" data-aos="fade-up">
                        <h2 className="text-3xl font-bold text-gray-800">Akses Portal Anda</h2>
                        <div className="w-20 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
                    </div>
                    
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                        {/* Customer Card */}
                        <Link href="/dashboard" className="group bg-gray-50 p-8 rounded-3xl border border-gray-100 hover:border-green-300 hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center cursor-pointer" data-aos="fade-up" data-aos-delay="0">
                            <div className="w-20 h-20 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6 text-4xl shadow-inner group-hover:scale-110 transition-transform">
                                🛍️
                            </div>
                            <h3 className="text-2xl font-bold text-gray-800 mb-2">Dashboard Pelanggan</h3>
                            <p className="text-gray-500">Lacak pesanan & riwayat belanja Anda dengan mudah.</p>
                        </Link>

                        {/* Supplier Card */}
                        <Link href="/supplier/dashboard" className="group bg-gray-50 p-8 rounded-3xl border border-gray-100 hover:border-green-300 hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                             <div className="w-20 h-20 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 text-4xl shadow-inner group-hover:scale-110 transition-transform">
                                🚜
                            </div>
                            <h3 className="text-2xl font-bold text-gray-800 mb-2">Portal Petani/Supplier</h3>
                            <p className="text-gray-500">Kelola stok hasil panen dan pantau penjualan.</p>
                        </Link>
                    </div>

                    <div className="text-center mt-12" data-aos="fade-up" data-aos-delay="200">
                         <Link href="/admin/dashboard" className="inline-flex items-center text-gray-400 hover:text-green-600 transition text-sm font-medium gap-2">
                             <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                             Admin Panel Login
                         </Link>
                    </div>
                </div>
            </section>
        </MainLayout>
    );
}
