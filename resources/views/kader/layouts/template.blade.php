<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('img/logo_posyandu.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    {{-- @include('kader.layouts.datatables') --}}
    @stack('css')
</head>
<body class="bg-gray-200 w-full md:h-screen scrollbar">
    @include('kader.layouts.header')
    <div class="flex h-full mt-[50px] lg:grid lg:grid-cols-6 2xl:grid-cols-6 min-[1920px]:grid-cols-8 md:mt-[88px]">
        <div id="sidebar" class="fixed z-20 h-full -translate-x-[999px] transform transition ease-in-out duration-500 sm:duration-700 col-span-1 lg:translate-x-0">
            @include('kader.layouts.sidebar')
        </div>
        <div class="col-span-1 hidden lg:flex"></div>
        <div class="w-full lg:col-span-5 2xl:col-span-5 min-[1920px]:col-span-7 lg:flex lg:flex-col lg:items-stretch">
            <div class="flex text-base px-5 md:text-2xl pt-5">
                @include('kader.layouts.breadcrumb')
            </div>
            @yield('content')
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
           // Select all number inputs
           const numberInputs = document.querySelectorAll('input[type="number"]');

           // Add event listener to each number input
           numberInputs.forEach(input => {
               input.addEventListener('input', function (e) {
                   if (e.target.value < 0) {
                       e.target.value = 0;
                   }
               });
           });
       });
   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @stack('js')
    <script>
        $(document).ready(function(){
            $('#simpan').click(function(){
                $(this).prop('disabled', true);
                $(this).html('Please wait...');
                $('form').submit();
            });
        });
    </script>
</body>
</html>