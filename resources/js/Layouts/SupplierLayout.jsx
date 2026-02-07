import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function SupplierLayout({ children }) {
    const { auth } = usePage().props;
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);

    const isActive = (path) => false; 

    return (
        <div className="min-h-screen bg-gray-50 font-sans flex text-gray-800">
            {/* Sidebar */}
            <aside className={`fixed inset-y-0 left-0 z-50 w-64 bg-green-900 text-white transform transition-transform duration-300 ease-in-out ${isSidebarOpen ? 'translate-x-0' : '-translate-x-full'} md:relative md:translate-x-0`}>
                <div className="flex items-center justify-between p-6 border-b border-green-800">
                    <span className="text-2xl font-bold tracking-wider text-green-300">SupplierPanel</span>
                    <button onClick={() => setIsSidebarOpen(false)} className="md:hidden text-green-300 hover:text-white">
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <nav className="p-4 space-y-2">
                    <Link href="/supplier/dashboard" className="flex items-center px-4 py-3 rounded-xl hover:bg-green-800 transition group">
                        <span className="text-xl mr-3 group-hover:text-green-300">🏠</span>
                        <span className="font-medium">Dashboard</span>
                    </Link>
                    <Link href="/supplier/produk" className="flex items-center px-4 py-3 rounded-xl hover:bg-green-800 transition group">
                         <span className="text-xl mr-3 group-hover:text-green-300">🥕</span>
                         <span className="font-medium">Kelola Produk</span>
                    </Link>
                     <Link href="/" className="flex items-center px-4 py-3 rounded-xl hover:bg-green-800 transition group mt-8">
                        <span className="text-xl mr-3 group-hover:text-green-300">🌍</span>
                        <span className="font-medium">Lihat Website</span>
                    </Link>
                     <Link href="/logout" method="post" as="button" className="flex w-full items-center px-4 py-3 rounded-xl hover:bg-red-900/50 text-red-200 transition mt-4">
                        <span className="text-xl mr-3">🚪</span>
                        <span className="font-medium">Logout</span>
                    </Link>
                </nav>
            </aside>

            {/* Main Content */}
            <div className="flex-1 flex flex-col overflow-hidden">
                {/* Header */}
                <header className="bg-white shadow-sm p-4 flex items-center justify-between">
                     <button onClick={() => setIsSidebarOpen(true)} className="md:hidden text-gray-600">
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 className="text-xl font-bold text-gray-800 ml-4 md:ml-0">
                        Selamat Datang, {auth.user.name} 🧑‍🌾
                    </h2>
                    <div className="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-lg shadow-inner">
                        🚜
                    </div>
                </header>

                {/* Page Content */}
                <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                    {children}
                </main>
            </div>
        </div>
    );
}
