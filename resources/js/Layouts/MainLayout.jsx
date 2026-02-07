import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function MainLayout({ children }) {
    const { auth } = usePage().props;
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    // Mock cart count if not available in props yet (needs backend update for real count)
    const cartCount = 3; 

    return (
        <div className="min-h-screen flex flex-col font-sans bg-gray-50 text-gray-900">
            {/* Navbar - Beige Background */}
            <nav className="fixed w-full z-50 top-0 start-0 bg-[#F5F5DC] shadow-sm transition-all duration-300 border-b border-gray-200">
                <div className="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                    
                    {/* Left: Logo */}
                    <Link href="/" className="flex items-center space-x-2 group">
                        <div className="bg-green-100 p-2 rounded-full group-hover:rotate-12 transition-transform duration-300">
                             <span className="text-2xl">🌱</span>
                        </div>
                        <span className="self-center text-2xl font-extrabold text-green-700 tracking-tight">SayurSehat</span>
                    </Link>
                    
                    {/* Mobile Menu Button */}
                    <button 
                        onClick={() => setIsMenuOpen(!isMenuOpen)}
                        type="button" 
                        className="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    >
                        <span className="sr-only">Open main menu</span>
                        <svg className="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                            <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M1 1h15M1 7h15M1 13h15"/>
                        </svg>
                    </button>

                    {/* Right: Navigation & Actions */}
                    <div className={`${isMenuOpen ? 'block' : 'hidden'} w-full md:block md:w-auto`} id="navbar-default">
                        <ul className="font-medium flex flex-col items-center p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-white md:bg-transparent md:flex-row md:space-x-8 md:mt-0 md:border-0 md:items-center">
                            <li>
                                <Link href="/" className="block py-2 px-3 text-gray-700 rounded hover:text-green-700 md:p-0 transition-colors">Beranda</Link>
                            </li>
                            <li>
                                <Link href="/produk-publik" className="block py-2 px-3 text-gray-700 rounded hover:text-green-700 md:p-0 transition-colors">Produk</Link>
                            </li>
                             <li>
                                <Link href="/tentang-kami" className="block py-2 px-3 text-gray-700 rounded hover:text-green-700 md:p-0 transition-colors">Tentang</Link>
                            </li>
                            
                            {/* Search Icon */}
                            <li>
                                <button className="p-2 text-gray-500 hover:text-green-700 transition">
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </li>

                            {/* Cart Icon with Badge */}
                            <li>
                                <Link href="/keranjang" className="relative p-2 text-gray-500 hover:text-green-700 transition block">
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span className="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                        {cartCount}
                                    </span>
                                </Link>
                            </li>

                            {/* Divider on mobile hidden, visible on desktop */}
                            <li className="hidden md:block w-px h-6 bg-gray-300 mx-2"></li>

                            {auth.user ? (
                                <>
                                    <li>
                                        <Link href="/dashboard" className="block py-2 px-3 text-green-700 font-bold hover:text-green-800 md:p-0">
                                            Hi, {auth.user.name.split(' ')[0]}
                                        </Link>
                                    </li>
                                    <li>
                                         <Link href="/logout" method="post" as="button" className="block py-2 px-3 text-sm text-red-500 hover:text-red-700 md:p-0">Logout</Link>
                                    </li>
                                </>
                            ) : (
                                <li>
                                    <Link href="/login" className="flex items-center gap-2 bg-green-700 text-white px-5 py-2.5 rounded-full font-bold hover:bg-green-800 transition shadow-md hover:shadow-lg text-sm">
                                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Login / Daftar
                                    </Link>
                                </li>
                            )}
                        </ul>
                    </div>
                </div>
            </nav>

            {/* Main Content */}
            <main className="flex-grow pt-[80px]">
                {children}
            </main>

            {/* Footer */}
            <footer className="bg-white border-t border-gray-100 mt-auto py-12">
                <div className="container mx-auto px-4">
                    <div className="flex flex-col md:flex-row justify-between items-center gap-8">
                        <div className="text-center md:text-left">
                            <h5 className="font-extrabold text-2xl text-green-700 mb-2">SayurSehat UMKM</h5>
                            <p className="text-gray-500">Segar, Sehat, Langsung dari Petani.</p>
                        </div>
                        
                        <div className="text-center">
                            <h6 className="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wider">Metode Pembayaran Aman</h6>
                             <div className="bg-white p-4 rounded-xl shadow-sm border border-gray-50 inline-block">
                                <img 
                                    src="/image/payment_methods_logos.png" 
                                    alt="Payment Methods: QRIS, Bank Transfer, E-Wallet" 
                                    className="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300"
                                />
                             </div>
                        </div>

                        <div className="text-center md:text-right text-gray-400 text-sm">
                             <p>&copy; {new Date().getFullYear()} Hak Cipta Dilindungi.</p>
                             <div className="flex justify-center md:justify-end gap-4 mt-2">
                                 <a href="#" className="hover:text-green-600">Privacy</a>
                                 <a href="#" className="hover:text-green-600">Terms</a>
                             </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}
