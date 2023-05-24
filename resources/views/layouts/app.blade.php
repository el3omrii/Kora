<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100" id="app">
    <div class="flex relative">
        <!-- Nav -->
        @include('layouts.navigation')

        <!-- main content -->
        <main class="flex-1 h-screen overflow-y-scroll overflow-x-hidden">
        <div class="md:hidden justify-between items-center bg-black text-white flex">
                <x-application-logo class="block h-9 w-auto fill-indigo-500" />
                {{ $header }}
                <button @click="navOpen = !navOpen" class="btn p-4 focus:outline-none hover:bg-gray-800">
                    <svg class="w-6 h-6 fill-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
            <section class="max-w-7xl mx-auto py-4 px-5">
            <div class="sm:hidden md:flex justify-between items-center border-b border-gray-300">
            {{ $header }}
        </div>
                {{ $slot }}
            </section>
        </main>
    </div>
</body>

</html>