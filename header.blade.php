<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPX Expedisi - Portal Lowongan Kerja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- ================= NAVBAR ================= -->
<header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <img src="https://dummyimage.com/40x40/ef4444/ffffff&text=SPX" class="rounded" alt="SPX">
                <span class="font-bold text-lg text-red-600">SPX Expedisi</span>
            </div>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="hover:text-red-600">Beranda</a>
                <a href="#" class="hover:text-red-600">Lowongan</a>
                <a href="#" class="hover:text-red-600">Tentang Kami</a>
                <a href="#" class="hover:text-red-600">Kontak</a>
                @if(!Session::has('applier_id'))
                <a href="/auth" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Login
                </a>
                @else 
                 <a href="/auth/dashboard" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Dashboard
                </a>
                @endif
            </nav>

            <!-- Mobile Actions -->
            <div class="md:hidden flex items-center gap-3">
                @if(!Session::has('applier_id'))

                <a href="/auth"
                   class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                    Login
                </a>
                @else  
                  <a href="/auth/dashboard"
                   class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                    Dashboard
                </a>
                @endif
                <button id="menu-toggle" class="text-2xl">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <nav class="px-6 py-4 space-y-3">
            <a href="#" class="block hover:text-red-600">Beranda</a>
            <a href="#" class="block hover:text-red-600">Lowongan</a>
            <a href="#" class="block hover:text-red-600">Tentang Kami</a>
            <a href="#" class="block hover:text-red-600">Kontak</a>
        </nav>
    </div>
</header>
