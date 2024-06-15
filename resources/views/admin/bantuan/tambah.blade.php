@extends('admin.layouts.template')

@section('content')
    <div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
        <div class="flex justify-between items-center w-full py-2 border-b">
            <p class="text-sm md:text-lg ml-5 md:ml-10">Data Kriteria</p>
        </div>
            @if(session('success'))
                <div class="flex items-center p-1 mb-1 border-2 border-green-500 bg-green-100 text-green-700 rounded-md" id="message">
                    <p class="mr-4"> <b>BERHASIL</b> {{ session('success') }}</p>
                    <button id="close" class="ml-auto bg-transparent text-green-700 hover:text-green-900">
                        <span>&times;</span>
                    </button>
                </div>
            @elseif(session('error'))
                <div class="flex items-center p-4 mb-4 border-2 border-red-500 bg-red-100 text-red-700 rounded-md" id="message">
                    <p class="mr-4">{{ session('error') }}</p>
                    <button id="close" class="ml-auto bg-transparent text-red-700 hover:text-red-900">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

        {{-- <div class="grid lg:grid-cols-3 mx-10 my-[30px]"> --}}
        <form action="{{route('kriteria.store')}}" method="post">
            @csrf
            <div class="grid md:grid-cols-2 my-[30px] mx-10 gap-x-[101px]">
                <div class="md:col-span-1 flex flex-col gap-[23px] order-2">
                    {{-- KODE KRITERIA --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Kode Kriteria<span class="text-red-400">*</span></p>
                        <input type="text" step="any" name="kode" value="{{old('kode')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan kode kriteria awali dengan huruf C" required>
                        {{-- @if (session('kode'))
                            <span class="text-red-500 message">{{$message}}</span>                            
                        @else
                            <span class="text-neutral-400 message">kode diawali dengan huruf C diikuti angka</span>                                
                        @endif --}}
                        @error('kode')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                    
                    {{-- NAMA KRITERIA --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Nama Kriteria<span class="text-red-400">*</span></p>
                        <input type="text" step="any" name="nama" value="{{old('nama')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan nama kriteria" required>
                        @error('nama')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="md:col-span-1 flex flex-col gap-[23px] order-2">
                    {{-- BOBOT KRITERIA --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Bobot Kriteria<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="bobot" value="{{old('bobot')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan bobot kritria" required>
                        @error('bobot')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- BOBOT KRITERIA --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Jenis Kriteria<span class="text-red-400">*</span></p>
                        <input type="text" step="any" name="jenis" value="{{old('jenis')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan jenis kriteria" required>
                        @error('jenis')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- <div class="flex flex-col col-span-3 lg:col-span-1">
                <table class="w-fit h-fit">
                    <tbody>
                        <tr>
                            <td>Kode Kriteria</td>
                            <td>:</td>
                            <td><input type="text" name="" id=""></td>
                        </tr>
                        <tr>
                            <td>Nama Kriteria</td>
                            <td>:</td>
                            <td><input type="text" name="" id=""></td>
                        </tr>
                        <tr>
                            <td>Bobot Kriteria</td>
                            <td>:</td>
                            <td><input type="text" name="" id=""></td>
                        </tr>
                        <tr>
                            <td>Jenis Kriteria</td>
                            <td>:</td>
                            <td><input type="text" name="" id=""></td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
            {{-- <div class="flex flex-col col-span-3 lg:col-span-2 w-full rounded-2xl overflow-x-auto">
                <x-table.data-table :dt="$rentangs"
                                    :headers="['Kode Kriteria', 'Rentang Minimal', 'Rentang Maximal', 'Nilai']">
                    @foreach ($rentangs as $rtg)
                        <x-table.table-row>
                            <td class="tableBody">{{$rtg->kode}}</td>
                            <td class="tableBody">{{number_format($rtg->rentang_min, 3)}}</td>
                            <td class="tableBody">{{number_format($rtg->rentang_max, 3)}}</td>
                            <td class="tableBody">{{$rtg->nilai}}</td>
                        </x-table.table-row>
                    @endforeach
                </x-table.data-table>
            </div> --}}
        {{-- </div> --}}
            {{-- <div class="flex justify-end items-center w-full py-5 px-3 border-b">
                <a href="{{ url('admin/bantuan') }}" class="bg-gray-300 text-sm text-black font-bold py-2 px-4 mr-5 md:mr-10 rounded">Kembali</a>
            </div> --}}
            <div class="grid md:grid-cols-2 mx-10 gap-x-[101px] pb-[30px]">
                <span id="page_1" class="col-span-1 hidden md:hidden"></span>
                <div class="col-span-2 flex justify-end items-center gap-[26px] pt-10 w-full" id="">
                    <p class="text-xs"><span class="text-red-400">*</span>Wajib diisi</p>
                    <a href="{{ route('kriteria.index') }}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="page_1">Kembali</a>
                    <button type="submit" class="bg-blue-700 text-white font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="simpan">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
<script>
    function clearTable() {
        const table = document.getElementById('dataTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }

    function addRowToTable(item) {
        const table = document.getElementById('dataTable');
        const row = table.insertRow(-1);

        row.innerHTML = `
        <x-table.table-row>
                    <td class="px-6 border-b lg:py-2 bg-white">${item.nama}</td>
                    <td class="tableBody">${item.NIK}</td>
                    <td class="tableBody">${item.NKK}</td>
                    <td class="px-6 lg:py-2 text-nowrap border-b bg-white">${item.tgl_lahir}</td>
                    <td class="tableBody">${item.jenis_kelamin}</td>
                    <td class="tableBody">${item.hubungan_keluarga}</td>
                    <td class="tableBody">
                        <form action="penduduk/${item.penduduk_id}" method="post" class="flex items-center gap-2">
                            <a href="penduduk/${item.penduduk_id}" class="bg-blue-400 text-[12px] text-neutral-950 py-[5px] px-2 rounded-sm hover:bg-blue-600 hover:text-white">Detail</a>
                            <a href="penduduk/${item.penduduk_id}/edit" class="bg-yellow-400 text-[12px] text-neutral-950 py-[5px] px-2 rounded-sm hover:bg-yellow-300">Ubah</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="confirm('Apakah anda yakin ingin menghapus data?')" class="bg-red-400 text-[12px] text-neutral-950 py-[6px] px-2 rounded-sm hover:bg-red-600 hover:text-white">Hapus</button>
                        </form>
                    </td>
        </x-table.table-row>
    `;
    }

    async function searchFunction() {
        let input;
        input = document.getElementById('searchInput');
        search = input.value;

        try {
            // Make a request to the server
            const response = await fetch(`/api/penduduk/search?search=${search}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            const responseData = await response.json();

            clearTable();

            responseData[0].data.forEach(item => {
                addRowToTable(item);
            });


        } catch (error) {
            console.log(error);
            const table = document.getElementById('dataTable');

            clearTable();

            const row = table.insertRow(-1);
            row.innerHTML = `
                <td colspan="7" class="text-center p-6 bg-white border-b font-medium text-Neutral/60">Data tidak ditemukan</td>
                `;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        let div = document.getElementById('message');
        let button = document.getElementById('close');

        if (div && button) {
            button.addEventListener('click', function() {
                div.classList.add('hidden');
            });
        }
    });
</script>
@endpush