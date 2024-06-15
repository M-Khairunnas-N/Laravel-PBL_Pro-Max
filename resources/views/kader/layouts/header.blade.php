<nav class="grid grid-cols-3 md:grid-cols-4 py-2 lg:grid-cols-6 min-[1920px]:grid-cols-8 w-screen md:w-full h-fit md:py-5 bg-white shadow-md fixed top-0 z-50">
    <div class="flex w-fit col-span-1 px-5 items-center gap-2 lg:gap-0">
        <div class="flex lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" id="show">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
        </div>
        <img src="{{ asset('img/logo_posyandu.png') }}" alt="" class="aspect-auto w-14 lg:w-16 lg:h-auto">
        <div class="flex flex-col hidden lg:flex">
            <p class="text-neutral-950 text-xs">Sistem Informasi</p>
            <p class="text-neutral-950 text-2xl font-bold">Posyandu</p class="">
        </div>
    </div>
    <div class="flex col-span-2 md:col-span-3 justify-between align-middle px-5 lg:col-span-5 min-[1920px]:col-span-7">
        <div class="flex flex-col hidden md:flex">
            <p class="text-neutral-950 text-xs">Halo, {{auth()->user()->username}}</p>
            <p class="text-neutral-950 text-xl">{{ now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</p>
        </div>
        <div class="flex w-full justify-end md:w-fit md:gap-3" onmouseover="showDropdown()" onmouseout="hideDropdown()">
            <img src="{{ auth()->user()->foto_profil }}" alt="" class="w-9 h-9 rounded-full mt-1">
            <div class="flex flex-col">
                <p class="text-neutral-950 text-base hidden md:flex">{{auth()->user()->username}}</p>
                <p class="text-neutral-950 text-sm hidden md:flex">{{auth()->user()->level}}</p>
            </div>
            <div class="dropdown-content hidden absolute bg-white border border-gray-200 mt-12 rounded-md shadow-md">
                <!-- Isi dropdown content di sini -->
                <a href="{{ route('kader.profile') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b">Atur Profil</a>
                <form action="{{ route('kader.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="block px-4 py-2 w-full text-sm text-gray-700 text-start hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

@push('js')
<script>
function showDropdown(){document.querySelector(".dropdown-content").classList.remove("hidden")}
function hideDropdown(){document.querySelector(".dropdown-content").classList.add("hidden")}function show(e){e.classList.toggle("-translate-x-[999px]"),e.classList.toggle("translate-x-0")}let sidebar=document.getElementById("sidebar");document.getElementById("show").addEventListener("click",function(){show(sidebar)});
</script>
@endpush
