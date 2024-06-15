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
        *,html{
            font-family: 'Plus Jakarta Sans'
        }
    </style>
</head>
<body>
    <div class="flex bg-gray-200 w-screen h-full justify-center items-center lg:h-screen">
        <div class="flex absolute right w-full pt-[10px] top-0 gap-2 px-2 justify-between lg:justify-start">
            <a href="{{ url('/') }}" class="back-button py-2 px-2 rounded-full bg-white hover:bg-neutral-950 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
        </div>
        <div class="bg-white w-full h-screen flex flex-col pt-[60px] py-[22px] gap-[50px] md:justify-center md:h-fit md:grid md:grid-cols-2 md:px-[100px] md:py-[55px] md:rounded-[25px] md:gap-[100px] md:mx-32 ">
            <div class="w-full flex flex-col px-[25px] md:justify-center">
                <p class="md:text-[31px] order-2 hidden md:flex">Sistem Informasi</p>
                <p class="font-bold md:text-[57px] order-3 hidden md:flex">Posyandu</p>
                <p class="font-bold text-[25px] md:text-[57px] order-2 md:hidden">Login</p>
                <p class="text-sm md:hidden order-3">Gunakan Akun Anda</p>
                <img src="{{ asset('img/logo_posyandu.png') }}" alt="logo Posyandu" class="w-[125px] -ml-4 md:w-[142px] md:h-[106.5px] md:hidden  order-1">
            </div>
            <div class="md:flex md:flex-col w-100 justify-center items-center px-[25px] md:gap-[42px]">
                <img src="{{ asset('img/logo_posyandu.png') }}" alt="logo Posyandu" class="w-[75px] md:w-[142px] md:h-[106.5px] hidden md:flex">
                @error('login_failed')
                    <div class="pl-5 py-[15px] bg-red-200 w-full fade show" role="alert">
                        <span class="alert-inner-text"><strong>Peringatan!</strong> {{ $message }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        {{--<span aria-hidden="true">&times;</span>--}}
                        </button>
                    </div>
                @enderror
                @error('error')
                    <div class="pl-5 py-[15px] bg-red-200 w-full fade show" role="alert">
                        <span class="alert-inner-text"><strong>Peringatan!</strong> {{ $message }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        {{--<span aria-hidden="true">&times;</span>--}}
                        </button>
                    </div>
                @enderror
                @if(session('success'))
                    <div class="pl-5 py-[15px] bg-green-200 w-full fade show" role="alert">
                        <span class="alert-inner-text"><strong>Berhasil</strong> {{ session('success') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        {{--<span aria-hidden="true">&times;</span>--}}
                        </button>
                    </div>
                @endif
                <div class="flex flex-col w-full gap-4">
                    <form method="post" action="{{route('login.auth')}}" id="login-form">
                        @csrf
                        <div class="flex flex-col w-full gap-[25px] md:gap-[30px]">
                            <input type="text" name="username" placeholder="Username" class=" w-full border border-stone-400 pl-2.5 py-[14px] rounded text-sm placeholder:text-sm md:pl-5 md:py-[10px] focus:outline-none md:placeholder:text-sm" required>
                            <input type="password" id="password" name="password" placeholder="Password" class="w-full border border-stone-400 pl-2.5 py-[14px] rounded text-sm placeholder:text-sm md:pl-5 md:py-[10px] focus:outline-none md:placeholder:text-sm placeholder:items-center" required>
                        </div>
                        <div class="flex left w-full">
                            <span id="passwordError" class="text-red-500 hidden"></span>
                        </div>
                        {{--<div class="flex left pt-4 w-full gap-4">--}}
                            {{--<input type="checkbox" name="remember" id="">--}}
                            {{--<p>Ingat saya</p>--}}
                        {{--</div>--}}
                        <div class="flex right w-full pt-[25px] gap-4 justify-center lg:justify-end">
                            <button class="bg-blue-700 w-full text-white text-sm py-[12px] px-[18px] md:w-fit md:text-base md:py-[10px] md:px-[17px] rounded-[5px] w-fit right-0" id="submit" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="border-t w-full m-0 p-0">
                <p class="text-xs text-stone-400">Sistem Informasi Posyandu</p>
            </div> --}}
            <footer class="fixed flex bg-blue-700 w-full bottom-0 py-2 lg:py-3 justify-center items-center gap-[10px] lg:gap-[21px] lg:hidden">
                <img src="{{ asset('img/logo-polinema.png')}}" alt="" class="w-[25px] lg:w-[33px] aspect-square">
                <img src="{{ asset('img/logo_jti_baru.png')}}" alt="" class="w-[25px] lg:w-[33px] aspect-square">
                <p class="text-white text-sm font-light md:text-base md:font-normal">&copy;JTI Polinema</p>
            </footer>
        </div>
        <footer class="fixed flex bg-blue-700 w-full bottom-0 lg:py-2 justify-center items-center gap-[10px] max-md:hidden lg:gap-[21px]">
            <img src="{{ asset('img/logo-polinema.png')}}" alt="" class="w-[25px] lg:w-[30px] aspect-square">
            <img src="{{ asset('img/logo_jti_baru.png')}}" alt="" class="w-[25px] lg:w-[30px] aspect-square">
            <p class="text-white text-sm font-light md:text-base md:font-normal">&copy;JTI Polinema</p>
        </footer>
    </div>
    <script>
        document.getElementById("login-form").addEventListener("submit", function(event){
            let pwd = document.getElementById("password").value;
            let passwordError = document.getElementById("passwordError");
            let valid = true;

            if (!/[A-Z]/.test(pwd)) {
                passwordError.textContent = "Password harus memiliki setidaknya satu huruf kapital.";
                passwordError.classList.remove("hidden");
                valid = false;
            }
            if (!/[0-9]/.test(pwd)) {
                passwordError.textContent = "Password harus memiliki setidaknya 1 angka.";
                passwordError.classList.remove("hidden");
                valid = false;
            }
            if (pwd.length < 8) {
                passwordError.textContent = "Password minimal 8 karakter ";
                passwordError.classList.remove("hidden");
                valid = false;
            }
            if(!valid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
