import React, { useEffect } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post('/login');
    };

    return (
        <MainLayout>
            <Head title="Masuk" />
            <div className="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[#FAFAF9]">
                <div className="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100">
                    
                    {/* Left Side: Visual & Branding */}
                    <div className="w-full md:w-1/2 bg-[#1B4D3E] p-12 text-white flex flex-col justify-between relative overflow-hidden">
                        <div className="relative z-10">
                            <div className="flex items-center gap-2 mb-8 animate-fade-in-down">
                                <span className="text-3xl">🌱</span>
                                <span className="text-2xl font-bold tracking-tight">SayurSehat</span>
                            </div>
                            <h2 className="text-4xl lg:text-5xl font-extrabold leading-tight mb-6 animate-fade-in-up">
                                Kesegaran Alami,<br/>
                                Langsung ke Rumah.<br/>
                            </h2>
                            <p className="text-green-100 text-lg leading-relaxed max-w-sm animate-fade-in-up delay-100">
                                Masuk untuk melanjutkan belanja sayuran organik segar dari petani lokal terpercaya.
                            </p>
                        </div>
                        
                        {/* Decorative Circles */}
                        <div className="absolute -bottom-24 -left-24 w-64 h-64 bg-green-600 rounded-full opacity-30 blur-3xl"></div>
                        <div className="absolute top-0 right-0 w-96 h-96 bg-green-800 rounded-full opacity-20 blur-3xl"></div>

                        <div className="relative z-10 mt-12 animate-fade-in-up delay-200">
                            <div className="flex items-center gap-4">
                                <div className="flex -space-x-4">
                                    {[1,2,3].map(i =>(
                                        <div key={i} className="w-10 h-10 rounded-full bg-gray-200 border-2 border-[#1B4D3E] overflow-hidden">
                                            <img src={`https://i.pravatar.cc/100?img=${i+10}`} alt="User" />
                                        </div>
                                    ))}
                                </div>
                                <div className="text-sm">
                                    <p className="font-bold">1k+ Pelanggan Puas</p>
                                    <p className="text-green-200 text-xs">Bergabunglah bersama kami!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Right Side: Form */}
                    <div className="w-full md:w-1/2 p-8 md:p-16 bg-white flex flex-col justify-center">
                        <div className="max-w-sm mx-auto w-full">
                            <h3 className="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Kembali 👋</h3>
                            <p className="text-gray-500 mb-8">Silakan masukkan detail akun Anda.</p>

                            <form onSubmit={submit} className="space-y-6">
                                <div>
                                    <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input
                                        id="email"
                                        type="email"
                                        value={data.email}
                                        onChange={(e) => setData('email', e.target.value)}
                                        className="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 transition-all outline-none"
                                        placeholder="nama@email.com"
                                        required
                                    />
                                    {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email}</p>}
                                </div>

                                <div>
                                    <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input
                                        id="password"
                                        type="password"
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        className="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 transition-all outline-none"
                                        placeholder="••••••••"
                                        required
                                    />
                                    {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password}</p>}
                                </div>

                                <div className="flex items-center justify-between">
                                    <label className="flex items-center space-x-2 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            checked={data.remember}
                                            onChange={(e) => setData('remember', e.target.checked)}
                                            className="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500"
                                        />
                                        <span className="text-sm text-gray-600">Ingat Saya</span>
                                    </label>
                                    <Link href="/password/reset" className="text-sm font-medium text-green-600 hover:text-green-700">
                                        Lupa Password?
                                    </Link>
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full bg-[#1B4D3E] text-white font-bold py-4 rounded-xl hover:bg-[#153e32] transition-colors shadow-lg hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed flex justify-center items-center gap-2"
                                >
                                    {processing && (
                                        <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    )}
                                    {processing ? 'Masuk...' : 'Masuk Sekarang'}
                                </button>
                            </form>

                            <div className="mt-8 pt-8 border-t border-gray-100 text-center">
                                <p className="text-gray-500">
                                    Belum punya akun?{' '}
                                    <Link href="/register" className="font-bold text-green-700 hover:text-green-800 hover:underline">
                                        Daftar Gratis
                                    </Link>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             {/* Animations Style */}
             <style>{`
                @keyframes fade-in-down {
                    from { opacity: 0; transform: translateY(-20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                @keyframes fade-in-up {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fade-in-down { animation: fade-in-down 0.8s ease-out forwards; }
                .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
                .delay-100 { animation-delay: 0.1s; }
                .delay-200 { animation-delay: 0.2s; }
            `}</style>
        </MainLayout>
    );
}
