@props(['title' => 'Edukasi', 'items' => []])

<div class="bg-white gap-8 pr-6 pl-7 mb-10 rounded-[5px] mx-[22.5px] lg:mx-[55px] py-5 my-[30px] lg:my-[60px]">
    <div class="flex justify-between flex-col gap-5">
        <div class="flex w-full justify-between">
            <span class="text-lg lg:text-[26px] font-bold ">{{ $title }}</span>
        </div>

        <p class="text-[12px] lg:text-[18px]">Berita-berita seputar {{$title}}</p>
    </div>
    <div class="pt-5">
        <div class="grid grid-cols-2 lg:grid-cols-4 grid-flow-row gap-10 lg:gap-[22px] overflow-x-scroll scrollbar">
            @foreach ($items as $item)
            <a class="min-w-40 flex flex-col gap-[15px] pb-5" href="/read={{$item->artikel_id}}">
                <img src="{{$item->foto_artikel}}" alt="" class="w-full aspect-video">
                <p class="text-sm lg:text-[17px] font-semibold text-justify">{{$item->judul}}</p>
                <span class="text-sm lg:text-[17px] text-red-400 capitalize">{{implode(' ', explode('_',$item->tag))}}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>