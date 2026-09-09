<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Pemeliharaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-blue-800 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center text-white">
            <a href="#" class="font-bold text-xl">SIPEMA</a>
            <div>
                @auth
                    <span class="mr-4">Halo, {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-8 px-4">
        @yield('content')
    </div>
</body>
</html>
