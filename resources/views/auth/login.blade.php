<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Welcome</title>
    
    <!-- Tautan Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-gray-800 antialiased overflow-x-hidden">
    
    <!-- Hero Section -->
    <div class="relative h-screen flex items-center justify-center">
        <div class="absolute inset-0 z-0">
            <!-- Gambar placeholder rumah mewah -->
            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Palazzo Palace" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#F8F9FA] via-transparent to-transparent"></div>
        </div>
        
        <div class="relative z-10 text-center px-4" data-aos="fade-up" data-aos-duration="1200">
            <h2 class="text-white/80 tracking-widest text-sm uppercase mb-4 font-medium">Welcome to</h2>
            <h1 class="font-playfair text-5xl md:text-7xl text-white font-bold mb-4 drop-shadow-md">More Comfortable.<br>More Classy.</h1>
            <p class="text-white/90 text-lg md:text-xl font-light tracking-wide mb-10 max-w-2xl mx-auto">Make your living experience even more interactive and elegant with Palazzo Palace.</p>
            <a href="#login-portal" class="bg-white/90 backdrop-blur text-gray-900 px-8 py-3.5 rounded-full font-medium hover:bg-white transition duration-300 shadow-[0_8px_30px_rgb(0,0,0,0.12)]">Access Portal</a>
        </div>
    </div>

    <!-- Login Portal Section -->
    <div id="login-portal" class="py-24 bg-[#F8F9FA]">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-playfair text-4xl font-bold text-gray-900 mb-3">Find Your Space Here</h2>
                <p class="text-gray-500 font-light">Select your portal to enter the management system.</p>
            </div>
            
            @if($errors->any())
            <div class="max-w-md mx-auto mb-8 bg-red-50 border border-red-100 text-red-600 px-5 py-4 rounded-xl text-sm shadow-sm" data-aos="shake">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Resident Access -->
                <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:-translate-y-1 transition duration-500" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-playfair text-2xl font-semibold mb-8 text-gray-900 border-b border-gray-100 pb-4">Resident Access</h3>
                    <form method="POST" action="{{ route('login.tenant') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:bg-white outline-none transition text-sm" placeholder="resident@palazzo.com" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Password</label>
                            <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:bg-white outline-none transition text-sm" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-medium py-3.5 rounded-xl transition shadow-lg mt-2">Sign In</button>
                    </form>
                </div>

                <!-- Staff Access -->
                <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:-translate-y-1 transition duration-500" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="font-playfair text-2xl font-semibold mb-8 text-gray-900 border-b border-gray-100 pb-4">Management Access</h3>
                    <form method="POST" action="{{ route('login.staff') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Staff Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-400 focus:bg-white outline-none transition text-sm" placeholder="staff@palazzo.com" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Password</label>
                            <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-400 focus:bg-white outline-none transition text-sm" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="w-full bg-white border border-gray-300 text-gray-900 hover:bg-gray-50 font-medium py-3.5 rounded-xl transition shadow-sm mt-2">Sign In as Staff</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-8 text-center">
        <p class="text-sm text-gray-400 font-light">&copy; 2026 Palazzo Palace. All rights reserved.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true, easing: 'ease-out-cubic' });</script>
</body>
</html>