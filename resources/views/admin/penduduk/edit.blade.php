@extends('admin.layouts.template')

@section('content')
    <form action="{{url('admin/penduduk/' . $penduduk->penduduk_id)}}" method="post">
        @csrf
        <!--add 'PUT' method, because we use Route::put() for update-->
        {!! method_field('PUT') !!}

        <input type="hidden" name="penduduk" value="{{json_encode($penduduk->toArray())}}">
        <input type="hidden" name="updated_at" value="{{$penduduk->updated_at}}">

        <div class="flex flex-col bg-white  mx-5 my-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
            <div class="flex justify-between items-center w-full py-2 border-b">
                <p class="text-lg mx-10">Ubah Data Penduduk</p>
            </div>

            <div class="grid lg:grid-cols-2 my-[10px] lg:my-[30px] mx-10 gap-x-[101px]">

                {{-- KOLOM KANAN --}}
                <div class="md:col-span-1 flex flex-col gap-[23px] order-2">

                    {{-- PENDIDIKAN --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Pendidikan<span class="text-red-400">*</span></p>
                        <select name="pendidikan" id="pendidikan" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            @php
                                $options = ['Belum Sekolah', 'Tidak Terpelajar', 'SD', 'SMP', 'SMA/SMK', 'D4/S1', 'S2 Keatas'];
                            @endphp
                            @foreach ($options as $option)
                                <option value="{{ $option }}" {{ old('pendidikan', $penduduk->pendidikan) == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('pendidikan')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END PENDIDIKAN --}}

                    {{-- HUBUNGAN KELUARGA --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Hubungan Keluarga<span class="text-red-400">*</span></p>
                        <select name="hubungan_keluarga" id="hubungan_keluarga" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            @php
                                $options = ['Kepala Keluarga', 'Istri', 'Anak'];
                            @endphp
                            @foreach ($options as $option)
                                <option value="{{ $option }}" {{ old('hubungan_keluarga', $penduduk->hubungan_keluarga) == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('hubungan_keluarga')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END HUBUNGAN KELUARGA --}}

                    {{-- RT --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">RT<span class="text-red-400">*</span></p>
                        <select name="RT" id="RT" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            @php
                                $options = ['RT 01', 'RT 02', 'RT 03', 'RT 04', 'RT 05', 'RT 06', 'RT 07', 'RT 08'];
                            @endphp
                            @foreach ($options as $option)
                                <option value="{{ $option }}" {{ old('RT', $penduduk->RT) == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('RT')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END RT --}}

                    {{-- ALAMAT --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Alamat<span class="text-red-400">*</span></p>
                        <textarea class="text-sm font-normal border border-stone-400 px-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" name="alamat" id="alamat" rows="2.5" maxlength="200" required>{{old('alamat', $penduduk->alamat)}}</textarea>
                        @error('alamat')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END ALAMAT --}}

                    {{-- NOMOR TELEPON --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Nomor Telepon</p>
                        <input type="number" value="{{old('no_telp',$penduduk->no_telp)}}" name="no_telp" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan Nomor Telepon">
                        @error('no_telp')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END NOMOR TELEPON --}}

                </div>
                {{-- END KOLOM KANAN --}}

                {{-- KOLOM KIRI --}}
                <div class="md:col-span-1 flex flex-col gap-[23px] max-md:mt-[23px] order-1">


                    {{-- NAMA --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Nama<span class="text-red-400">*</span></p>
                        <input type="text" step="any" value="{{old('nama', $penduduk->nama)}}" name="nama" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan Nama Penduduk" required>
                        @error('nama')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END NAMA --}}

                    {{-- NIK --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">NIK<span class="text-red-400">*</span></p>
                        <input type="number" value="{{old('NIK', $penduduk->NIK)}}" name="NIK" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan NIK" required>
                        @error('NIK')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END NIK --}}

                    {{-- NKK --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">NKK<span class="text-red-400">*</span></p>
                        <input type="number" name="NKK" value="{{old('NKK', $penduduk->NKK)}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan NKK" required>
                        @error('NKK')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END NKK --}}

                    {{-- TANGGAL LAHIR --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Tanggal Lahir<span class="text-red-400">*</span></p>
                        <input type="date" step="any" name="tgl_lahir" value="{{old('tgl_lahir', $penduduk->tgl_lahir)}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none" id="tanggal" required>
                        @error('tgl_lahir')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END TANGGAL LAHIR --}}

                    {{-- PENDAPATAN --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Pendapatan<span class="text-red-400">*</span></p>
                        <select name="pendapatan" id="pendapatan" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            @php
                                $options = ['Belum Bekerja', 'Rp 0 - Rp 500.000', 'Rp 500.000 - Rp 1.000.000', 'Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Keatas'];
                            @endphp
                            @foreach ($options as $option)
                                <option value="{{ $option }}" {{ old('pendapatan', $penduduk->pendapatan) == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('pendapatan')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END PENDAPATAN --}}

                    {{-- JENIS KELAMIN --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Jenis Kelamin<span class="text-red-400">*</span></p>
                        <div class="flex items-center gap-10">
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:border-transparent -mr-[25px]" name="jenis_kelamin" value="L" id="option1" required {{ old('jenis_kelamin', $penduduk->jenis_kelamin) === 'L' ? 'checked' : '' }}><span>Laki-laki</span>
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:bg-red-400 -mr-[25px]" name="jenis_kelamin" value="P" id="option2" required {{ old('jenis_kelamin', $penduduk->jenis_kelamin) === 'P' ? 'checked' : '' }}><span>Perempuan</span>
                        </div>
                        @error('jenis_kelamin')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END JENIS KELAMIN --}}

                </div>
                {{-- END KOLOM KIRI --}}
            </div>
            <div class="grid md:grid-cols-2 mx-10 gap-x-[101px] pb-[30px] pt-6">
                <div class="col-span-2 flex justify-end items-center gap-[26px] w-full" id="">
                    <p class="text-xs"><span class="text-red-400">*</span>Wajib diisi</p>
                    <a href="{{url('admin/penduduk' . session('urlPagination'))}}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="page_1">Kembali</a>
                    <button type="submit" class="bg-blue-700 text-white font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="simpan">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
@endsection

