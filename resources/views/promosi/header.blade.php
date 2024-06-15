<nav class="grid grid-cols-1 lg:grid-cols-3 h-fit py-1 lg:py-5 bg-white shadow-md sticky top-0 z-50">
    <div class="flex w-full lg:w-fit col-span-1 px-5 items-center justify-between lg:justify-start">
        <div class="flex items-center">
            <img src="{{ asset('img/logo_posyandu.png') }}" alt="" class="w-16 h-auto">
            <div class="flex flex-col ml-3">
                <p class="text-neutral-950 text-xs hidden lg:flex">Sistem Informasi</p>
                <p class="text-neutral-950 text-2xl font-bold hidden lg:flex">Posyandu</p>
            </div>
        </div>
        <div class="lg:hidden md:">
            <button id="menu-btn" class="text-neutral-950 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
    <div id="menu" class="hidden lg:flex col-span-1 justify-center items-center px-5 w-full h-full md:h-auto md:mt-0 mt-5">
        <div class="flex flex-col md:flex-row gap-5 md:gap-[70px]">
        <a class="text-neutral-950 text-base align-middle py-2 px-4 md:py-0 transition ease-in-out duration-300 rounded-[20px] lg:rounded-none {{ ($activeMenu == 'berita') ? 'max-md:bg-gray-200 activeHeader lg:bg-none' : 'max-md:hover:bg-gray-100 focus:bg-gray-400 lg:bg-transparent lg:focus:border-blue-700 lg:hover:border-b-[3px] lg:hover:border-blue-700'}}" href="{{ url('') }}">Berita</a>
        <a class="text-neutral-950 text-base align-middle py-2 px-4 md:py-0 transition ease-in-out duration-300 rounded-[20px] lg:rounded-none {{ ($activeMenu == 'profil') ? 'max-md:bg-gray-200 activeHeader lg:bg-none' : 'max-md:hover:bg-gray-100 focus:bg-gray-400 lg:bg-transparent lg:focus:border-blue-700 lg:hover:border-b-[3px] lg:hover:border-blue-700'}}" href="{{ url('profil')}}">Profil</a>
        <a class="text-neutral-950 text-base align-middle py-2 px-4 md:py-0 transition ease-in-out duration-300 rounded-[20px] lg:rounded-none {{ ($activeMenu == 'jadwal') ? 'max-md:bg-gray-200 activeHeader lg:bg-none' : 'max-md:hover:bg-gray-100 focus:bg-gray-400 lg:bg-transparent lg:focus:border-blue-700 lg:hover:border-b-[3px] lg:hover:border-blue-700'}}" href="{{ url('jadwal')}}">Kegiatan</a>
            <a class="text-base text-center align-middle py-2 px-2 md:py-0 transition ease-in-out duration-300 rounded-[20px] lg:rounded-none bg-blue-700 text-white lg:hidden {{ ($activeMenu == 'login') ? 'lg:activeHeader' : 'hover:bg-blue-800'}}" href="{{ url('login')}}">Login</a>
        </div>
    </div>
    <div class="hidden lg:flex col-span-1 justify-end items-center w-full h-full">
        <a href="{{ url('login')}}" class="bg-blue-700 text-white rounded-[20px] px-5 py-2.5 mx-12">Login</a>
    </div>
</nav>

<script>
    document.getElementById('menu-btn').addEventListener('click', function() {
        var menu = document.getElementById('menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    });
    function show(e){e.classList.toggle("-translate-x-[999px]"),e.classList.toggle("translate-x-0")}let sidebar=document.getElementById("sidebar");document.getElementById("show").addEventListener("click",function(){show(sidebar)});
</script>
