@extends('kader.layouts.template')

@section('content')
    <form action="{{route('bayi.store')}}" method="POST">
        @csrf
        <div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(248,113,113,1)] rounded-md">
            <div class="flex justify-between items-center w-full py-2 border-b">
                <p class="text-lg mx-10">Form Pemeriksaan Bayi</p>
            </div>

            <div class="grid md:grid-cols-2 my-[30px] mx-5 lg:mx-10 gap-x-[101px]">

                {{-- KOLOM KANAN --}}
                <div class="md:col-span-1 flex flex-col gap-[23px] order-2">
                    <h2 class="font-bold text-lg">Data Pemeriksaan</h2>

                    <div class="flex flex-col w-full h-fill gap-[20px]" id="">
                        <p class="text-base text-neutral-950">Tanggal Pemeriksaan</p>
                        <p>{{ now('Asia/Jakarta')->locale('id')->day }} - {{ now('Asia/Jakarta')->locale('id')->translatedFormat('F') }} - {{ now('Asia/Jakarta')->locale('id')->year }}</p>
                    </div>

                    {{-- LINGKAR KEPALA --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Lingkar Kepala<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="lingkar_kepala" value="{{old('lingkar_kepala')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan lingkar kepala" required>
                        @error('lingkar_kepala')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END LINGKAR KEPALA --}}

                    {{-- LINGKAR LENGAN --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Lingkar Lengan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="lingkar_lengan" value="{{old('lingkar_lengan')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan lingkar lengan" required>
                        @error('lingkar_lengan')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END LINGKAR LENGAN --}}

                    {{-- BERAT BADAN --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950">Berat Badan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="berat_badan" value="{{old('berat_badan')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan berat badan" required>
                        @error('berat_badan')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END BERAT BADAN --}}

                    {{-- TINGGI BADAN --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Tinggi Badan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="tinggi_badan" value="{{old('tinggi_badan')}}" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan tinggi badan" required>
                        @error('tinggi_badan')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END TINGGI BADAN --}}

                    {{-- STATUS KESEHATAN --}}
                    <div class="flex flex-col w-full h-fill gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Status Kesehatan?<span class="text-red-400">*</span></p>
                        <div class="flex items-center gap-10">
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:border-transparent -mr-[25px]" name="status" value="sehat" id="option1" required {{ old('status') === 'sehat' ? 'checked' : '' }}><span>Sehat</span>
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:bg-red-400 -mr-[25px]" name="status" value="sakit" id="option2" required {{ old('status') === 'sakit' ? 'checked' : '' }}><span>Sakit</span>
                        </div>
                        @error('status')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- END STATUS KESEHATAN --}}

                    {{-- ASI EKSKLUSIF --}}
                    <div class="flex flex-col w-full h-fit gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">ASI Eksklusif?<span class="text-red-400">*</span></p>
                        <div class="flex items-center gap-10">
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:border-transparent -mr-[25px]" name="asi" value="iya" id="option1" required {{ old('asi') === 'iya' ? 'checked' : '' }}><span>Ya</span>
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:bg-red-400 -mr-[25px]" name="asi" value="tidak" id="option2" required {{ old('asi') === 'tidak' ? 'checked' : '' }}><span>Tidak</span>
                        </div>
                        @error('asi')
                            <span class="text-red-500 message">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                {{-- END ASI EKSKLUSIF --}}

                <div class="md:col-span-1 flex flex-col gap-[23px] max-md:mt-[23px] order-1">
                    {{-- SISI KIRI (COMMENT WHEN SHOWING TO LECTURER)--}}
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_">
                        <h2 class="font-bold text-lg">Data Bayi</h2>
                        <div class="flex border border-stone-400 rounded-md px-2 py-2">
                            <table class="w-fit capitalize">
                                <tbody>
                                    <tr>
                                        <td>Nama Bayi</td>
                                        <td>:</td>
                                        <td>
                                            <select name="penduduk_id" id="penduduk_id" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                                                <option value="0" class="text-gray-300" id="params">Masukkan nama bayi</option>
                                                @foreach($bayisData as $bayi)
                                                    <option value="{{ $bayi->penduduk_id }}" class="text-neutral-950" {{ old('penduduk_id') === strval($bayi->penduduk_id) ? 'selected' : '' }}>{{ $bayi->nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Usia</td>
                                        <td>:</td>
                                        <td><input type="text" value="" class="border-none" id="usia" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Golongan Usia</td>
                                        <td>:</td>
                                        <td><input type="text" value="" class="border-none" id="golongan" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ibu</td>
                                        <td>:</td>
                                        <td><input type="text" value="" class="border-none" id="ibu" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ayah</td>
                                        <td>:</td>
                                        <td><input type="text" value="" class="border-none" id="ayah" disabled></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="kategori_golongan" id="kategori_golongan">
            <div class="grid md:grid-cols-2 mx-10 gap-x-[101px] pb-[30px]">
                <span id="page_1" class="col-span-1 hidden md:hidden"></span>
                <div class="col-span-2 flex justify-end items-center gap-[26px] pt-10 w-full" id="">
                    <p class="text-xs"><span class="text-red-400">*</span>Wajib diisi</p>
                    <a href="{{ url('kader/bayi' . session('urlPagination')) }}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="page_1">Kembali</a>
                    <button type="submit" class="bg-blue-700 text-white font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="simpan">Simpan Data</button>
                </div>
            </div>


        </div>
    </form>
@endsection

@push('css')
<style>
    @media (min-width: 768px){
        td{
        padding-inline: 10px;
        padding-block: 8px;
        }
    }
</style>
@endpush

@push('js')
<script>
    let nama = document.getElementById('params');
    let golongan = document.getElementById('golongan');
    let usia = document.getElementById('usia');
    let ibu = document.getElementById('ibu');
    let ayah = document.getElementById('ayah');
    let data;

    // Function to save data to localStorage
    function saveDataToLocalStorage() {
        const dataToSave = {
            nama: document.getElementById('penduduk_id').value,
            golonganOld: golongan.value,
            usiaOld: usia.value,
            ibuOld: ibu.value,
            ayahOld: ayah.value
        };
        localStorage.setItem('bayiData', JSON.stringify(dataToSave));
    }

    // Function to load data from localStorage
    function loadDataFromLocalStorage() {
        const savedData = localStorage.getItem('bayiData');
        if (savedData && @json(old('penduduk_id'))) {
            data = JSON.parse(savedData);
            inputData();
        }
    }

    function inputData() {
        if (data) {
            document.getElementById('penduduk_id').value = data.nama;
            golongan.value = data.golonganOld;
            golongan.innerText = `${data.golonganOld}`;
            document.getElementById('kategori_golongan').value = data.golonganOld;
            usia.value = data.usiaOld;
            usia.innerText = data.usiaOld;
            ibu.value = data.ibuOld;
            ibu.innerText = data.ibuOld;
            ayah.value = data.ayahOld;
            ayah.innerText = data.ayahOld;
        }
    }

    document.getElementById('penduduk_id').addEventListener('change', function() {
        let bayis = @json($bayisData);
        let parents = @json($parentsData);
        let bayi;

        // Clear existing values before setting new ones
        clearFields();

        for (let i = 0; i < bayis.length; i++) {
            if (bayis[i].penduduk_id.toString() === this.value) {
                let tgl_lahir = new Date(bayis[i].tgl_lahir);
                let sekarang = new Date();
                let bulan = (sekarang.getFullYear() - tgl_lahir.getFullYear()) * 12;
                bulan -= tgl_lahir.getMonth();
                bulan += sekarang.getMonth();
                if (bulan > 0 && bulan <= 36) {
                    golongan.innerText = "bayi";
                    golongan.value = "bayi";
                    document.getElementById('kategori_golongan').value = "bayi";
                // } else if (bulan > 24 && bulan <= 36) {
                //     golongan.innerText = "batita";
                //     golongan.value = "batita";
                //     document.getElementById('kategori_golongan').value = "batita";
                } else if (bulan > 36 && bulan <= 60) {
                    golongan.innerText = "balita";
                    golongan.value = "balita";
                    document.getElementById('kategori_golongan').value = "balita";
                }
                usia.innerText = bulan + " bulan";
                usia.value = bulan + " bulan";
                bayi = bayis[i].NKK;
            }
        }

        for (let i = 0; i < parents.length; i++) {
            if (parents[i].NKK === bayi) {
                if (parents[i].hubungan_keluarga === 'Istri') {
                    ibu.value = parents[i].nama;
                    ibu.innerText = parents[i].nama;
                    break;
                } else {
                    ibu.value = "Data Ibu tidak ditemukan";
                    ibu.innerText = "Data Ibu tidak ditemukan";
                }
            }
        }

        for (let i = 0; i < parents.length; i++) {
            if (parents[i].NKK === bayi) {
                if (parents[i].hubungan_keluarga === 'Kepala Keluarga') {
                    ayah.value = parents[i].nama;
                    ayah.innerText = parents[i].nama;
                    break;
                } else {
                    ayah.value = "Data Ayah tidak ditemukan";
                    ayah.innerText = "Data Ayah tidak ditemukan";
                }
            }
        }

        saveDataToLocalStorage();
        data = {
            nama: document.getElementById('penduduk_id').value,
            golonganOld: golongan.value,
            usiaOld: usia.value,
            ibuOld: ibu.value,
            ayahOld: ayah.value
        };
    });

    function clearFields() {
        golongan.value = '';
        golongan.innerText = '';
        usia.value = '';
        usia.innerText = '';
        ibu.value = '';
        ibu.innerText = '';
        ayah.value = '';
        ayah.innerText = '';
    }


    // Load data from localStorage on page load
    window.addEventListener('load', loadDataFromLocalStorage);
</script>
@endpush

