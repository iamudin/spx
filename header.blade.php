<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- ================= NAVBAR ================= -->
<header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <a href="/" class="href">
            <div class="flex items-center gap-2">
                <img src="https://dummyimage.com/40x40/ef4444/ffffff&text=SPX" class="rounded" alt="SPX">
                <span class="font-bold text-lg text-red-600">SPX Expedisi</span>
            </div>
</a>
            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="hover:text-red-600">Beranda</a>
                <a href="/tentang-kami" class="hover:text-red-600">Tentang Kami</a>
                <a href="/kontak" class="hover:text-red-600">Kontak</a>
                @if(!Session::has('applier_id'))
                <a href="/auth" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Login
                </a>
                @else 
                    <a href="/auth/profile" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                        Profile
                    </a>

                    <form action="/auth/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="ml-2 flex items-center gap-2 bg-gray-100 text-red-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                            <!-- Icon Exit -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-13V5m-7 0h4" />
                            </svg>

                        </button>
                    </form>
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
                    <a href="/auth/profile" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                        Profile
                    </a>

                    <form action="/auth/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="ml-2 flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                            <!-- Icon Exit -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-13V5m-7 0h4" />
                            </svg>

                        </button>
                    </form>

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
            <a href="/" class="block hover:text-red-600">Beranda</a>
            <a href="/tentang-kami" class="block hover:text-red-600">Tentang Kami</a>
            <a href="/kontak" class="block hover:text-red-600">Kontak</a>
        </nav>
    </div>
</header>
