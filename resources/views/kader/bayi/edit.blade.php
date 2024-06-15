@extends('kader.layouts.template')

@section('content')
    <form action="{{url('kader/bayi/' . $bayiData->pemeriksaan_id)}}" method="post">
        @csrf
        <!--add 'PUT' method, because we use Route::put() for update-->
        {!! method_field('PUT') !!}

        <input type="hidden" name="pemeriksaan_bayi" value="{{$bayiData->pemeriksaan_bayi}}">
        <input type="hidden" name="pemeriksaan" value="{{ json_encode([
            'tgl_pemeriksaan' => $bayiData->tgl_pemeriksaan,
            'golongan' => $bayiData->golongan,
            'kader_id' => $bayiData->kader_id,
            'berat_badan' => $bayiData->berat_badan,
            'tinggi_badan' => $bayiData->tinggi_badan,
            'status' => $bayiData->status,
            'respon' => $bayiData->respon
            ])
        }}">
        <input type="hidden" name="updated_at" value="{{$bayiData->updated_at}}">

        <div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(248,113,113,1)] rounded-md">
            <div class="flex justify-between items-center w-full py-2 border-b">
                <p class="text-lg mx-10">Ubah Pemeriksaan Bayi</p>
            </div>
            <div class="grid md:grid-cols-2 my-[30px] mx-10 gap-x-[101px]">
                <div class="md:col-span-1 flex flex-col gap-[23px]">
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_1">
                        <p class="text-base text-neutral-950">Nama Bayi</p>
                        <input name="nama" id="filter" class="w-100 border text-neutral-950 border-none text-base font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none disabled:bg-transparent" value="{{$bayiData->penduduk->nama}}" disabled>
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950 pr-[10px]">Lingkar Lengan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="lingkar_lengan" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" value="{{ old('lingkar_lengan', $bayiData->pemeriksaan_bayi->lingkar_lengan) }}" placeholder="Masukkan lingkar lengan" required>
                        @error('lingkar_lengan')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950 pr-[10px]">Lingkar Kepala<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="lingkar_kepala" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" value="{{ old('lingkar_kepala', $bayiData->pemeriksaan_bayi->lingkar_kepala) }}" placeholder="Masukkan lingkar kepala" required>
                        @error('lingkar_kepala')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950">Berat Badan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="berat_badan" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" value="{{ old('berat_badan', $bayiData->berat_badan) }}" placeholder="Masukkan berat badan" required>
                        @error('berat_badan')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="md:col-span-1 flex flex-col gap-[23px]">
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950 pr-[10px]">Tinggi Badan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="tinggi_badan" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" value="{{ old('tinggi_badan', $bayiData->tinggi_badan) }}" placeholder="Masukkan tinggi badan" required>
                        @error('tinggi_badan')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950 pr-[10px]">Status Kesehatan?<span class="text-red-400">*</span></p>
                        <div class="flex items-center gap-10">
                                <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:border-transparent -mr-[25px]" name="status" value="sehat" id="option1" {{ old('status', $bayiData->status) === 'sehat' ? 'checked' : '' }}><span>Sehat</span>
                                <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[20px] checked:w-4 checked:outline-2 -mr-[25px]" name="status" value="sakit" id="option2" {{ old('status', $bayiData->status) === 'sakit' ? 'checked' : '' }}><span>Sakit</span>
                        </div>
                        @error('status')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950 pr-[10px]">ASI Eksklusif?<span class="text-red-400">*</span></p>
                        <div class="flex items-center gap-10">
                                <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:border-transparent -mr-[25px]" name="asi" value="iya" id="option1" {{ old('asi', $bayiData->pemeriksaan_bayi->asi) === 'iya' ? 'checked' : '' }}><span>Ya</span>
                                <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[20px] checked:w-4 checked:outline-2 -mr-[25px]" name="asi" value="tidak" id="option2" {{ old('asi', $bayiData->pemeriksaan_bayi->asi) === 'tidak' ? 'checked' : '' }}><span>Tidak</span>
                        </div>
                        @error('asi')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 mx-10 gap-x-[101px] pb-[30px]">
                <div class="col-span-2 flex justify-end items-center gap-[26px] w-full">
                    <p class="text-xs"><span class="text-red-400">*</span>Wajib diisi</p>
                    <a href="{{ url('kader/bayi' . session('urlPagination'))}}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="page_1">Kembali</a>
                    <button type="submit" class="bg-blue-700 text-white font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="simpan">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
@endsection

