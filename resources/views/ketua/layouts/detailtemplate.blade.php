<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('img/logo_posyandu.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Sistem Informasi Posyandu</title>
    <style>
        *, html{
            font-family: 'Plus Jakarta Sans'
        }
    </style>
    @stack('css')
</head>
<body class="bg-gray-200 w-full md:h-screen">
    @include('ketua.layouts.header')
    <div class="flex lg:grid lg:grid-cols-6 h-full mt-[50px] md:mt-[88px]">
        <div id="sidebar" class="fixed z-20 h-full -translate-x-[999px] transform transition ease-in-out duration-500 sm:duration-700 col-span-1 lg:translate-x-0 ">
            @include('ketua.layouts.sidebar')
        </div>
        <div class="col-span-1 hidden lg:flex"></div>
        <div class="w-full md:col-span-5">
            <div class="flex text-base px-5 md:text-2xl pt-5">
                <p>SPK</p>
            </div>
            @yield('content')
        </div>
        @yield('js2')
    </div>
    @stack('js')
</body>
</html>
