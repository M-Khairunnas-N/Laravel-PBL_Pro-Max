@extends('kader.layouts.template')

@section('content')
    <div class="flex flex-col my-5 mx-5 bg-white">
        <h1 class="font-bold text-justify w-full text-3xl px-10 py-10">{{ $artikel->judul}}</h1>
        <div class="flex w-full justify-center px-80">
            <img src="{{ $artikel->foto_artikel }}" alt="" class="w-full py-5 lg:py-10 text-center">
        </div>
        <p class="px-10 text-lg indent-20 text-justify pb-5 leading-relaxed">
            {{ $artikel->isi}}
        </p>
        <div class="flex w-full justify-end gap-[15px] font-bold px-10 pb-10">
            @php
                session(['urlArtikel' => $artikel->artikel_id]);
            @endphp
            <a href="{{ url('kader/informasi/artikel')}}" class="bg-gray-300 text-[15px] py-[10px] px-[30px] rounded-[5px]">Kembali</a>
            <a href="{{ url('kader/informasi/artikel/' . $artikel->artikel_id . '/edit')}}" class="bg-yellow-400 text-[15px py-[10px] px-[20px] rounded-[5px]">Edit</a>
        </div>
    </div>
@endsection
