<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Memuat Tailwind CSS via CDN untuk kemudahan -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}">
                                <svg class="block h-9 w-auto fill-current text-gray-800" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 0c17.67 0 32 14.33 32 32v64h-64v-64c0-17.67 14.33-32 32-32zm-32 128h64v64h-64v-64zm128-64v64h64v-32c0-17.67-14.33-32-32-32h-32zm-256 0c-17.67 0-32 14.33-32 32v32h64v-64h-32zm-64 128h64v64h-64v-64zm384 0h64v64h-64v-64zM256 256c-44.18 0-80 35.82-80 80s35.82 80 80 80 80-35.82 80-80-35.82-80-80-80zm160-64h-64v64h64v-64zm-384 0v64h64v-64h-64zm160 192v96h-32c-17.67 0-32 14.33-32 32s14.33 32 32 32h96c17.67 0 32-14.33 32-32s-14.33-32-32-32h-32v-96h64v-64h-192v64h64z"/></svg>
                            </a>
                        </div>
                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                           @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-indigo-400' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition">Dashboard</a>
                                <a href="{{ route('tutorials.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tutorials.*') ? 'border-indigo-400' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition">Manajemen Tutorial</a>
                           @endauth
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        @auth
                            <span class="mr-4 text-gray-700">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header') {{-- Menggunakan @yield untuk header --}}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('slot') {{-- INI PERUBAHANNYA: Mengganti {{ $slot }} menjadi @yield('slot') --}}
        </main>
    </div>
</body>
</html>
