import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

export default function Register() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post('/register');
    };

    return (
        <MainLayout>
            <Head title="Daftar Akun" />
            <div className="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[#FAFAF9]">
                <div className="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row-reverse border border-gray-100">
                    
                    {/* Right Side: Visual & Branding */}
                    <div className="w-full md:w-1/2 bg-[#F3F4F6] p-12 flex flex-col justify-between relative overflow-hidden">
                         {/* Background Image Overlay */}
                         <div className="absolute inset-0 z-0">
                            <img 
                                src="/image/hero_vegetables_crate.png" 
                                alt="Fresh Vegetables" 
                                className="w-full h-full object-cover opacity-80"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                         </div>

                        <div className="relative z-10 text-white mt-auto">
                            <div className="mb-6 animate-fade-in-up">
                                <span className="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Komunitas Sehat</span>
                            </div>
                            <h2 className="text-4xl lg:text-5xl font-extrabold leading-tight mb-4 animate-fade-in-up">
                                Mulai Gaya Hidup<br/>Sehat Hari Ini.
                            </h2>
                            <p className="text-gray-200 text-lg leading-relaxed animate-fade-in-up delay-100">
                                Dapatkan akses eksklusif ke hasil panen terbaik dan promo menarik setiap minggunya.
                            </p>
                        </div>
                    </div>

                    {/* Left Side: Form */}
                    <div className="w-full md:w-1/2 p-8 md:p-16 bg-white flex flex-col justify-center">
                        <div className="max-w-sm mx-auto w-full">
                            <h3 className="text-2xl font-bold text-gray-900 mb-2">Buat Akun Baru 🚀</h3>
                            <p className="text-gray-500 mb-8">Isi data diri Anda untuk bergabung.</p>

                            <form onSubmit={submit} className="space-y-5">
                                <div>
                                    <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <input
                                        id="name"
                                        type="text"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        className="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 transition-all outline-none"
                                        placeholder="Nama Anda"
                                        required
                                    />
                                    {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name}</p>}
                                </div>

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

                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                        <input
                                            id="password"
                                            type="password"
                                            value={data.password}
                                            onChange={(e) => setData('password', e.target.value)}
                                            className="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 transition-all outline-none"
                                            placeholder="••••••"
                                            required
                                        />
                                        {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password}</p>}
                                    </div>
                                    <div>
                                        <label htmlFor="password_confirmation" className="block text-sm font-medium text-gray-700 mb-2">Konfirmasi</label>
                                        <input
                                            id="password_confirmation"
                                            type="password"
                                            value={data.password_confirmation}
                                            onChange={(e) => setData('password_confirmation', e.target.value)}
                                            className="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 transition-all outline-none"
                                            placeholder="••••••"
                                            required
                                        />
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full bg-[#1B4D3E] text-white font-bold py-4 rounded-xl hover:bg-[#153e32] transition-colors shadow-lg hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed mt-4"
                                >
                                    {processing ? 'Mendaftar...' : 'Daftar Sekarang'}
                                </button>
                            </form>

                            <div className="mt-8 pt-8 border-t border-gray-100 text-center">
                                <p className="text-gray-500">
                                    Sudah punya akun?{' '}
                                    <Link href="/login" className="font-bold text-green-700 hover:text-green-800 hover:underline">
                                        Masuk
                                    </Link>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             {/* Animations Style */}
             <style>{`
                @keyframes fade-in-up {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
                .delay-100 { animation-delay: 0.1s; }
            `}</style>
        </MainLayout>
    );
}
