@extends('ketua.layouts.template')

@section('content')
    {{-- <form action="{{route('bayi.store')}}" method="POST"> --}}
        @csrf
        <div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(248,113,113,1)] rounded-md">
            <div class="flex justify-between items-center w-full py-2 border-b">
                <p class="text-lg mx-10">Form Parameter Kriteria</p>
            </div>
            
            <div class="grid md:grid-cols-5 my-[30px] mx-10 gap-x-[101px]">
                <div class="md:col-span-1 flex flex-col gap-[23px]">
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_1">
                        <p class="text-base text-neutral-950">Berat Badan<span class="text-red-400">*</span></p>
                        <select name="penduduk_id" id="penduduk_id" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            <option value="" class="text-gray-300">- Pilih Bobot Kriteria -</option>
                            @for ($i = 1; $i <= 5; $i++)
                            <option value="{{$i}}" class="text-neutral-950">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_1">
                        <p class="text-base text-neutral-950">Tinggi Badan<span class="text-red-400">*</span></p>
                        <select name="penduduk_id" id="penduduk_id" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            <option value="" class="text-gray-300">- Pilih Bobot Kriteria -</option>
                            @for ($i = 1; $i <= 5; $i++)
                            <option value="{{$i}}" class="text-neutral-950">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_1">
                        <p class="text-base text-neutral-950">Pendidikan Orang Tua<span class="text-red-400">*</span></p>
                        <select name="penduduk_id" id="penduduk_id" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            <option value="" class="text-gray-300">- Pilih Bobot Kriteria -</option>
                            @for ($i = 1; $i <= 5; $i++)
                            <option value="{{$i}}" class="text-neutral-950">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_1">
                        <p class="text-base text-neutral-950">Pekerjaan Orang Tua<span class="text-red-400">*</span></p>
                        <select name="penduduk_id" id="penduduk_id" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            <option value="" class="text-gray-300">- Pilih Bobot Kriteria -</option>
                            @for ($i = 1; $i <= 6; $i++)
                            <option value="{{$i}}" class="text-neutral-950">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_1">
                        <p class="text-base text-neutral-950">Penghasilan Orang Tua<span class="text-red-400">*</span></p>
                        <select name="penduduk_id" id="penduduk_id" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            <option value="" class="text-gray-300">- Pilih Bobot Kriteria -</option>
                            @for ($i = 1; $i <= 5; $i++)
                            <option value="{{$i}}" class="text-neutral-950">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="md:col-span-1 flex flex-col gap-[23px]">
                    <div class="flex flex-col">
                        <h3 class="font-bold">Rentang Berat Badan</h3>
                        <p>6.6 - 7.6 = 1</p>
                        <p>5.5 - 6.5 = 2</p>
                        <p>4.4 - 5.4 = 3</p>
                        <p>3.3 - 4.3 = 4</p>
                        <p>2.2 - 3.2 = 5</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-bold">Rentang Tinggi Badan</h3>
                        <p>58 - 60 = 1</p>
                        <p>53 - 57 = 2</p>
                        <p>49 - 52 = 3</p>
                        <p>45 - 48 = 4</p>
                        <p>40 - 44 = 5</p>
                    </div>
                </div>
                <div class="md:col-span-2 flex flex-col gap-[23px]">
                    <div class="flex flex-col">
                        <h3 class="font-bold">Pekerjaan Orang Tua</h3>
                        <p>Karyawan swasta dan sebagainya = 1</p>
                        <p>Pekerjaan pendapatan rendah = 2</p>
                        <p>Petani = 3</p>
                        <p>Pekerja informal = 4</p>
                        <p>Pekerjaan buruh = 5</p>
                        <p>Pengangguran = 6</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </form>
@endsection
