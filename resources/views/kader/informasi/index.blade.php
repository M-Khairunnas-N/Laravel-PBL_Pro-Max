@extends('kader.layouts.template')

@section('content')
<div class="grid md:grid-cols-2 mt-5 mb-10 px-10 gap-12">
    <a href="{{ url('kader/informasi/artikel/create')}}">
        <div class="flex flex-col bg-white rounded-[15px] py-[47px] justify-center items-center hover:-translate-y-2 hover:ease-in-out hover:duration-300">
            <svg width="124" height="124" viewBox="0 0 124 124" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-700">
                <path d="M98.1667 103.333H25.8333C23.0928 103.333 20.4644 102.245 18.5266 100.307C16.5887 98.369 15.5 95.7407 15.5 93.0001V31.0001C15.5 28.2595 16.5887 25.6312 18.5266 23.6933C20.4644 21.7554 23.0928 20.6667 25.8333 20.6667H77.5C80.2406 20.6667 82.8689 21.7554 84.8068 23.6933C86.7446 25.6312 87.8333 28.2595 87.8333 31.0001V36.1667M98.1667 103.333C95.4261 103.333 92.7978 102.245 90.8599 100.307C88.922 98.369 87.8333 95.7407 87.8333 93.0001V36.1667M98.1667 103.333C100.907 103.333 103.536 102.245 105.473 100.307C107.411 98.369 108.5 95.7407 108.5 93.0001V46.5001C108.5 43.7595 107.411 41.1312 105.473 39.1933C103.536 37.2554 100.907 36.1667 98.1667 36.1667H87.8333M67.1667 20.6667H46.5M36.1667 82.6667H67.1667M36.1667 41.3334H67.1667V62.0001H36.1667V41.3334Z" stroke="#1D4ED8" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <p class="text-2xl">Buat Artikel</p>
                <p class="text-[17px] text-stone-400 text-center px-[90px] pt-[15px]">Tuliskan artikel anda untuk menarik minat masyarakat datang ke posyandu</p>
        </div>
    </a>

    <a href="{{ url('kader/informasi/kegiatan/create')}}">
        <div class="flex flex-col bg-white rounded-[15px] py-[47px] justify-center items-center hover:-translate-y-2 hover:ease-in-out hover:duration-300">
            <svg width="124" height="124" viewBox="0 0 124 124" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-700">
                <path d="M62 32.3071V99.4738M62 32.3071C55.9653 28.2978 47.771 25.8333 38.75 25.8333C29.729 25.8333 21.5347 28.2978 15.5 32.3071V99.4738C21.5347 95.4644 29.729 92.9999 38.75 92.9999C47.771 92.9999 55.9653 95.4644 62 99.4738M62 32.3071C68.0347 28.2978 76.229 25.8333 85.25 25.8333C94.2762 25.8333 102.465 28.2978 108.5 32.3071V99.4738C102.465 95.4644 94.2762 92.9999 85.25 92.9999C76.229 92.9999 68.0347 95.4644 62 99.4738" stroke="#1D4ED8" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <p class="text-2xl">Buat Kegiatan</p>
                <p class="text-[17px] text-stone-400 text-center px-[67px] pt-[15px]">Buat jadwal kegiatan posyandu agar masyarakat dan sesama kader mengetahuinya</p>
        </div>
    </a>

    <a href="{{ url('kader/informasi/artikel')}}">
        <div class="flex flex-col bg-white rounded-[15px] py-[47px] justify-center items-center hover:-translate-y-2 hover:ease-in-out hover:duration-300">
            <svg width="124" height="124" viewBox="0 0 124 124" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-700">
                <path d="M98.1667 103.333H25.8333C23.0928 103.333 20.4644 102.245 18.5266 100.307C16.5887 98.369 15.5 95.7407 15.5 93.0001V31.0001C15.5 28.2595 16.5887 25.6312 18.5266 23.6933C20.4644 21.7554 23.0928 20.6667 25.8333 20.6667H77.5C80.2406 20.6667 82.8689 21.7554 84.8068 23.6933C86.7446 25.6312 87.8333 28.2595 87.8333 31.0001V36.1667M98.1667 103.333C95.4261 103.333 92.7978 102.245 90.8599 100.307C88.922 98.369 87.8333 95.7407 87.8333 93.0001V36.1667M98.1667 103.333C100.907 103.333 103.536 102.245 105.473 100.307C107.411 98.369 108.5 95.7407 108.5 93.0001V46.5001C108.5 43.7595 107.411 41.1312 105.473 39.1933C103.536 37.2554 100.907 36.1667 98.1667 36.1667H87.8333M67.1667 20.6667H46.5M36.1667 82.6667H67.1667M36.1667 41.3334H67.1667V62.0001H36.1667V41.3334Z" stroke="#1D4ED8" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M101.619 42.9529L111.048 52.3822L101.619 42.9529ZM105.619 38.9529C106.869 37.7025 108.565 37 110.333 37C112.102 37 113.798 37.7025 115.048 38.9529C116.298 40.2033 117.001 41.8992 117.001 43.6675C117.001 45.4359 116.298 47.1318 115.048 48.3822L78.3333 85.0969H69V75.5715L105.619 38.9529Z" fill="white"/>
                <path d="M101.619 42.9529L111.048 52.3822M105.619 38.9529C106.869 37.7025 108.565 37 110.333 37C112.102 37 113.798 37.7025 115.048 38.9529C116.298 40.2033 117.001 41.8992 117.001 43.6675C117.001 45.4359 116.298 47.1318 115.048 48.3822L78.3333 85.0969H69V75.5715L105.619 38.9529Z" stroke="#1D4ED8" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <p class="text-2xl">Edit Artikel</p>
                <p class="text-[17px] text-stone-400 text-center px-[67px] pt-[15px]">Ada kesalahan penulisan? jangan panik, anda bisa mengubahnya di sini</p>
        </div>
    </a>

    <a href="{{ url('kader/informasi/kegiatan')}}">
        <div class="flex flex-col bg-white rounded-[15px] py-[47px] justify-center items-center hover:-translate-y-2 hover:ease-in-out hover:duration-300">
            <svg width="124" height="124" viewBox="0 0 124 124" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-700">
                <path d="M62 32.3071V99.4738M62 32.3071C55.9653 28.2978 47.771 25.8333 38.75 25.8333C29.729 25.8333 21.5347 28.2978 15.5 32.3071V99.4738C21.5347 95.4644 29.729 92.9999 38.75 92.9999C47.771 92.9999 55.9653 95.4644 62 99.4738M62 32.3071C68.0347 28.2978 76.229 25.8333 85.25 25.8333C94.2762 25.8333 102.465 28.2978 108.5 32.3071V99.4738C102.465 95.4644 94.2762 92.9999 85.25 92.9999C76.229 92.9999 68.0347 95.4644 62 99.4738" stroke="#1D4ED8" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M103.619 31.9529L113.048 41.3822L103.619 31.9529ZM107.619 27.9529C108.869 26.7025 110.565 26 112.333 26C114.102 26 115.798 26.7025 117.048 27.9529C118.298 29.2033 119.001 30.8992 119.001 32.6675C119.001 34.4359 118.298 36.1318 117.048 37.3822L80.3333 74.0969H71V64.5715L107.619 27.9529Z" fill="white"/>
                <path d="M103.619 31.9529L113.048 41.3822M107.619 27.9529C108.869 26.7025 110.565 26 112.333 26C114.102 26 115.798 26.7025 117.048 27.9529C118.298 29.2033 119.001 30.8992 119.001 32.6675C119.001 34.4359 118.298 36.1318 117.048 37.3822L80.3333 74.0969H71V64.5715L107.619 27.9529Z" stroke="#1D4ED8" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <p class="text-2xl">Edit Kegiatan</p>
                <p class="text-[17px] text-stone-400 text-center px-[67px] pt-[15px]">Ada kesalahan penulisan? jangan panik, anda bisa mengubahnya di sini</p>
        </div>
    </a>
</div>
@endsection
