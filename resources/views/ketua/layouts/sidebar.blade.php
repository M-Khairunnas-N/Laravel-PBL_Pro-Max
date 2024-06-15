<aside class="static lg:fixed flex bg-white w-[236.094px] h-screen lg:h-full justify-center shadow-inner">
    <div class="content flex flex-col w-full gap-10 pt-10 mx-7">
        <a href="{{ url('/ketua') }}" class="containerSidebar active:bg-blue-900 {{ ($activeMenu == 'dashboard')? 'active stroke-white' : 'stroke-neutral-950 hover:text-white hover:bg-blue-600 hover:stroke-white'}}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
            </svg>
            <p class="text-base">Dashboard</p>
        </a>
        <a href="{{ url('/ketua/bantuan') }}" class="containerSidebar active:bg-blue-900 {{ ($activeMenu == 'bantuan')? 'active stroke-white' : 'stroke-neutral-950 hover:text-white hover:bg-blue-600 hover:stroke-white'}}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
              </svg>
            <p class="text-base">Rekomendasi Rujukan</p>
        </a>
    </div>
</aside>
