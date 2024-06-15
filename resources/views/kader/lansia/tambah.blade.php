@extends('kader.layouts.template')

@section('content')
    <form action="{{route('lansia.store')}}" method="post">
        @csrf
        <div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
            <div class="flex justify-between items-center w-full py-2 border-b">
                <p class="text-lg mx-10">Form Pemeriksaan Lansia</p>
            </div>

            <div class="grid md:grid-cols-2 my-[30px] mx-5 lg:mx-10 gap-x-[101px]">
                <div class="md:col-span-1 flex flex-col gap-[23px]">
                    <h2 class="font-bold text-lg">Data Lansia</h2>
                    <div class="flex border border-stone-400 rounded-md px-2 py-2">
                        <table class="w-fit capitalize">
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>
                                        <select name="penduduk_id" id="penduduk_id" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                                            <option value="" class="text-gray-300" id="params">Masukkan nama lansia</option>
                                            @foreach($lansiasData as $lansia)
                                                <option value="{{ $lansia->penduduk_id }}" class="text-neutral-950">{{ $lansia->nama }}</option>
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
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td><input type="text" value="" class="border-none" id="alamat" disabled></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="md:col-span-1 flex flex-col gap-[23px] max-md:mt-[23px]">
                    <h2 class="font-bold text-lg">Data Pemeriksaan</h2>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_1">
                        <p class="text-base text-neutral-950">Tanggal Pemeriksaan</p>
                        <p>{{ now('Asia/Jakarta')->locale('id')->day }} - {{ now('Asia/Jakarta')->locale('id')->translatedFormat('F') }} - {{ now('Asia/Jakarta')->locale('id')->year }}</p>
                    </div>

                    <div class="flex flex-col w-full h-fill gap-[20px] hidden" id="page_1">
                        <p class="text-base text-neutral-950 pr-[10px]">Alamat<span class="text-red-400">*</span></p>
                        <input type="text" id="alamat" class="w-100 text-sm font-normal border border-stone-300 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-400 cursor-not-allowed" placeholder="Otomatis terisi setelah memilih nama warga" disabled>
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px] ">
                        <p class="text-base text-neutral-950">Lingkar Perut<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="lingkar_perut" value="{{old('lingkar_perut')}}" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan lingkar perut">
                        @error('lingkar_perut')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px] ">
                        <p class="text-base text-neutral-950">Tensi Darah<span class="text-red-400">*</span></p>
                        <div class="flex gap-x-5 items-center md:me-[337px]">
                            <input type="number" name="tensi_darah" value="{{old('tensi_darah')}}" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="masukan tensi">
                            {{--<span class="w-fit">/</span>
                            <input type="text" class=" w-[83px] text-sm text-center font-normal border border-stone-400 py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Diastolik">--}}
                        </div>
                        @error('tensi_darah')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]">
                        <p class="text-base text-neutral-950">Tinggi Badan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="tinggi_badan" value="{{old('tinggi_badan')}}" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan tinggi badan">
                        @error('tinggi_badan')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px] ">
                        <p class="text-base text-neutral-950">Berat Badan<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="berat_badan" value="{{old('berat_badan')}}" class="w-100 text-sm font-normal border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan berat badan" required>
                        @error('berat_badan')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950">Gula Darah<span class="text-red-400">*</span></p>
                        <input type="number" name="gula_darah" value="{{old('gula_darah')}}" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan gula darah">
                        @error('gula_darah')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950">Asam Urat<span class="text-red-400">*</span></p>
                        <input type="number" step="any" name="asam_urat" value="{{old('asam_urat')}}" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan asam urat">
                        @error('asam_urat')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950">Kolesterol<span class="text-red-400">*</span></p>
                        <input type="number" name="kolesterol" value="{{old('kolesterol')}}" class="w-100 text-sm font-normal border border-stone-400 pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan kolesterol">
                        @error('kolesterol')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full h-fill gap-[20px]" id="page_2">
                        <p class="text-base text-neutral-950 pr-[10px]">Status Kesehatan?<span class="text-red-400">*</span></p>
                        <div class="flex items-center gap-10">
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:border-transparent -mr-[25px]" name="status" value="sehat" id="option1" required {{ old('status') === 'sehat' ? 'checked' : '' }}><span>Sehat</span>
                            <input type="radio" class="indeterminate:outline-2 indeterminate:outline-stone-400 indeterminate:w-4 indeterminate:py-[6px] checked:w-4 checked:outline-2 checked:bg-red-400 -mr-[25px]" name="status" value="sakit" id="option2" required {{ old('status') === 'sakit' ? 'checked' : '' }}><span>Sakit</span>
                        </div>
                        @error('status')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 mx-10 gap-x-[101px] pb-[30px]">
                <div class="col-span-2 flex justify-end items-center gap-[26px] w-full">
                    <p class="text-xs"><span class="text-red-400">*</span>Wajib diisi</p>
                    <a href="{{ url('kader/lansia' . session('urlPaginate'))}}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="page_1">Kembali</a>
                    <button type="submit" class="bg-blue-700 text-white font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="page_2">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
@endsection

{{-- @push('css')
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
        document.getElementById('penduduk_id').addEventListener('change', function() {
            let lansias = @json($lansiasData)

            for (let i = 0; i < lansias.length; i++) {
                if (lansias[i].penduduk_id.toString() === this.value) {
                    document.getElementById('alamat').value = lansias[i].alamat;
                    document.getElementById('alamat').innerText = lansias[i].alamat;
                    let tgl_lahir = new Date(lansias[i].tgl_lahir);
                    let sekarang = new Date();
                    document.getElementById('usia').value = (sekarang.getFullYear() - tgl_lahir.getFullYear()) + " tahun";
                    document.getElementById('usia').innerText = (sekarang.getFullYear() - tgl_lahir.getFullYear()) + " tahun";
                }
            }
        });
    </script>
@endpush --}}

@push('js')
<script>
    let nama = document.getElementById('params');
    let usia = document.getElementById('usia');
    let alamat = document.getElementById('alamat');
    let data;

    // Function to save data to localStorage
    function saveDataToLocalStorage() {
        const dataToSave = {
            nama: document.getElementById('penduduk_id').value,
            usiaOld: usia.value,
            alamatOld: alamat.value
        };
        localStorage.setItem('lansiaData', JSON.stringify(dataToSave));
    }

    // Function to load data from localStorage
    function loadDataFromLocalStorage() {
        const savedData = localStorage.getItem('lansiaData');
        if (savedData && @json(old('penduduk_id'))) {
            data = JSON.parse(savedData);
            inputData();
        }
    }

    function inputData() {
        if (data) {
            document.getElementById('penduduk_id').value = data.nama;
            usia.value = data.usiaOld;
            usia.innerText = data.usiaOld;
            alamat.value = data.alamatOld;
            alamat.innerText = data.alamatOld;
        }
    }

    document.getElementById('penduduk_id').addEventListener('change', function() {
        let lansias = @json($lansiasData);

        // Clear existing values before setting new ones
        clearFields();

        for (let i = 0; i < lansias.length; i++) {
            if (lansias[i].penduduk_id.toString() === this.value) {
                document.getElementById('alamat').value = lansias[i].alamat;
                document.getElementById('alamat').innerText = lansias[i].alamat;
                let tgl_lahir = new Date(lansias[i].tgl_lahir);
                let sekarang = new Date();
                document.getElementById('usia').value = (sekarang.getFullYear() - tgl_lahir.getFullYear()) + " tahun";
                document.getElementById('usia').innerText = (sekarang.getFullYear() - tgl_lahir.getFullYear()) + " tahun";
            }
        }

        saveDataToLocalStorage();
        data = {
            nama: document.getElementById('penduduk_id').value,
            usiaOld: usia.value,
            alamatOld: alamat.value
        };
    });

    function clearFields() {
        usia.value = '';
        usia.innerText = '';
        alamat.value = '';
        alamat.innerText = '';
    }

    // Load data from localStorage on page load
    window.addEventListener('load', loadDataFromLocalStorage);
</script>
@endpush
