<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Dasbor Tenant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Memanggil CSS AOS untuk Animasi -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-gray-50 overflow-x-hidden" style="font-family: 'Inter', sans-serif;">

    <!-- Top Bar Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 px-8 py-4 flex justify-between items-center" data-aos="fade-down" data-aos-duration="800">
        <div class="font-bold text-2xl text-gray-800" style="font-family: 'Playfair Display', serif;">
            Palazzo Palace
        </div>
        <div class="flex items-center space-x-6">
            <span class="text-gray-600 font-medium">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition duration-200 font-medium">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container mx-auto px-8 py-8 max-w-7xl">
        
        <!-- Hero Section -->
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-8 mb-8 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2" style="font-family: 'Playfair Display', serif;">
                    Halo, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600 text-lg">
                    Berikut adalah ringkasan status fasilitas di unit apartemen Anda saat ini.
                </p>
            </div>
            <!-- Area Tombol Pintasan -->
            <div class="flex flex-col sm:flex-row gap-4 w-full xl:w-auto">
                <a href="{{ route('tenant.complaints.index') }}" class="bg-white text-blue-600 border border-blue-200 px-6 py-4 rounded-xl font-bold hover:bg-blue-50 transition shadow-sm whitespace-nowrap text-center flex-1 sm:flex-none">
                    Lihat Riwayat Keluhan
                </a>
                <a href="{{ route('tenant.complaints.create') }}" class="bg-blue-600 text-white px-6 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-md whitespace-nowrap text-center flex-1 sm:flex-none">
                    + Buat Laporan Baru
                </a>
            </div>
        </div>

        <!-- Area Status Aset -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Playfair Display', serif;" data-aos="fade-right" data-aos-delay="200">Inventaris & Fasilitas Unit</h2>
            
            <!-- Grid Kartu Aset -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($assets as $asset)
                    @php
                        $bgColor = 'bg-green-100';
                        $textColor = 'text-green-700';
                        $iconColor = 'text-green-600';
                        $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';

                        if ($asset->condition === 'Needs Repair' || $asset->status === 'maintenance') {
                            $bgColor = 'bg-yellow-100';
                            $textColor = 'text-yellow-700';
                            $iconColor = 'text-yellow-600';
                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>';
                        } 
                        elseif ($asset->condition === 'Broken' || $asset->status === 'broken') {
                            $bgColor = 'bg-red-100';
                            $textColor = 'text-red-700';
                            $iconColor = 'text-red-600';
                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
                        }
                        
                        // Menghitung delay dinamis agar kartu muncul satu per satu berurutan
                        $animationDelay = 200 + ($loop->iteration * 100);
                    @endphp

                    <!-- Animasi ditambahkan di div kartu ini -->
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition" data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $animationDelay }}">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2 {{ $bgColor }} rounded-lg">
                                <svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $iconSvg !!}
                                </svg>
                            </div>
                            <span class="{{ $bgColor }} {{ $textColor }} text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $asset->condition }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg">{{ $asset->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Kategori: {{ $asset->category }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Script Inisialisasi AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // Animasi hanya berjalan satu kali saat di-scroll
            offset: 50  // Jarak trigger animasi dari bawah layar
        });
    </script>
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-8" data-aos="fade-in" data-aos-offset="0">
        <div class="container mx-auto px-8 max-w-7xl flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="font-bold text-xl text-gray-800" style="font-family: 'Playfair Display', serif;">
                Palazzo Palace
            </div>
            <p class="text-sm text-gray-500 font-medium">
                &copy; 2026 Palazzo Palace. Hak cipta dilindungi undang-undang.
            </p>
        </div>
    </footer>
</body>
</html>