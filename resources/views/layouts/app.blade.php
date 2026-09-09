<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace</title>
    
    <!-- Tautan Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">   
     
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        /* Kustomisasi scrollbar untuk kesan premium */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-gray-800 antialiased overflow-x-hidden">
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            @php
                $homeRoute = url('/login');
                if (auth()->check()) {
                    $homeRoute = match(auth()->user()->role) {
                        'admin' => route('admin.dashboard'),
                        'tenant' => route('tenant.dashboard'),
                        'technician' => route('technician.tasks.index'),
                        'owner' => route('owner.dashboard'),
                        default => url('/login'),
                    };
                }
            @endphp
            <a href="{{ $homeRoute }}" class="font-playfair font-bold text-2xl tracking-wide text-gray-900">Palazzo Palace</a>
            <div>
                @auth
                    <span class="mr-4 text-sm font-medium text-gray-600">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-800 hover:text-red-900 transition">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-10 px-6 pb-12">
        @yield('content')
    </div>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>
</html>