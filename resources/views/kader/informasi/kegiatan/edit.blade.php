@extends('kader.layouts.template')

@section('content')
    <form action="{{ url('kader/informasi/kegiatan/' . $kegiatan->kegiatan_id) }}" method="post">
        @csrf
        <!--add 'PUT' method, because we use Route::put() for update-->
        {!! method_field('PUT') !!}

        <input type="hidden" name="kegiatan" value="{{json_encode($kegiatan)}}">
        <input type="hidden" name="updated_at" value="{{$kegiatan->updated_at}}">
        <div class="flex flex-col bg-white mx-5 my-5 rounded-md">
            <div class="flex flex-col lg:grid lg:grid-cols-2 my-[30px] mx-5 lg:mx-10 lg:gap-x-[101px] gap-[23px]">
                <div class="col-span-1 flex flex-col gap-[23px]">
                    <div class="flex flex-col w-full gap-[20px]">
                        <p class="text-base text-neutral-950">Nama Kegiatan</p>
                        <input type="text" name="nama" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" value="{{ old('nama', $kegiatan->nama) }}" placeholder="Masukkan nama kegiatan">
                        <p class="text-xs font-normal text-stone-400 mt-[-10px]" id="counter">Nama kegiatan minimal 5 huruf - maximal 100 huruf</p>
                        @error('nama')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]">
                        <p class="text-base text-neutral-950">Tempat</p>
                        <input type="text" name="tempat" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" value="{{ old('tempat', $kegiatan->tempat) }}" placeholder="Masukkan tempat pelaksanaan">
                        <p class="text-xs font-normal text-stone-400 mt-[-10px]" id="counter">Tempat kegiatan minimal 5 huruf - maximal 200 huruf</p>
                        @error('tempat')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-1 flex flex-col lg:gap-[23px] gap-4">
                    <div class="flex flex-col w-full gap-5 lg:gap-[23px] mx-5 lg:mx-10 ml-0 lg:ml-2">
                        <p class="text-base text-neutral-950">Tanggal Kegiatan</p>
                        <div class="grid grid-cols-3 gap-5">
                            <input type="date" step="any" name="tgl_kegiatan" value="{{old('tgl_kegiatan', $kegiatan->tgl_kegiatan)}}" class="w-100 lg;col-span-1 col-span-2 text-sm font-normal border-stone-400 lg:pl-[10px] py-[10px] rounded-[5px] focus:outline-none" id="tanggal" required>
                            @error('tgl_kegiatan')
                            <span class="text-red-500">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full gap-[20px]">
                            <p class="text-base text-neutral-950">Pukul Kegiatan</p>
                            <div class="flex gap-x-5 items-center lg:me-[300px] me-[50px]">
                                <input type="time" id="timeInput" pattern="[0-9]{2}:[0-9]{2}" name="jam_mulai" class="w-full text-sm text-center font-normal border border-stone-400 py-[10px] lg:px-1.5 px-12 rounded-[5px] decoration-none focus:outline-none placeholder:text-gray-300" value="{{ old('jam_mulai', date('H:i:s', strtotime($kegiatan->jam_mulai))) }}" placeholder="Jam Mulai">
                                <span class="w-fit">-</span>
                                <span class="w-fit">Selesai</span>
                                @error('jam_mulai')
                                <span class="text-red-500">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-end gap-[26px] px-[50px] pb-10 w-full h-full">
                <a href="{{ url('kader/informasi/kegiatan' . session('urlPagination')) }}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[10px] px-[10px] rounded-[5px]">Kembali</a>
                <button type="submit" class="bg-blue-700 text-white font-bold text-base py-[10px] px-[10px] rounded-[5px]" id="simpan">Simpan</button>
            </div>
        </div>
    </form>
@endsection
