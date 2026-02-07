import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

export default function About() {
    return (
        <MainLayout>
            <Head title="Tentang Kami" />
            <div className="bg-white py-16">
                <div className="container mx-auto px-4">
                    <div className="text-center max-w-3xl mx-auto mb-12">
                        <h1 className="text-4xl font-bold text-gray-800 mb-4">Tentang UMKM Sayuran</h1>
                        <p className="text-lg text-gray-600">
                            Kami adalah platform yang menghubungkan petani lokal langsung dengan Anda, menciptakan rantai pasok yang lebih adil dan segar.
                        </p>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div className="rounded-2xl overflow-hidden shadow-lg h-96">
                            <img 
                                src="https://placehold.co/800x600/198754/FFFFFF?text=Kebun+Sayur" 
                                alt="Kebun Sayur" 
                                className="w-full h-full object-cover"
                            />
                        </div>
                        <div>
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Misi Kami</h2>
                            <p className="text-gray-600 mb-6">
                                Kami berkomitmen untuk memberdayakan petani lokal dengan memberikan akses pasar yang lebih luas dan harga yang layak. 
                                Di sisi lain, kami ingin memastikan setiap keluarga mendapatkan akses mudah terhadap sayuran segar berkualitas tinggi tanpa bahan pengawet berbahaya.
                            </p>
                            
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Nilai Kami</h2>
                            <ul className="list-disc list-inside text-gray-600 space-y-2">
                                <li><strong>Integritas:</strong> Jujur dalam kualitas dan harga.</li>
                                <li><strong>Kualitas:</strong> Hanya produk terbaik yang sampai ke tangan Anda.</li>
                                <li><strong>Dampak Sosial:</strong> Tumbuh bersama komunitas petani.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
