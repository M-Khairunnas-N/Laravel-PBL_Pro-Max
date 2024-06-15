@extends('kader.layouts.template')

@section('content')
<div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
    <div class="flex justify-between items-center w-full py-2 border-b">
        <p class="text-lg ml-10">Detail lansia</p>
    </div>
    <div class="flex flex-col gap-[15px] py-10 px-[15px] lg:px-[30px]">
        <table class="w-fit">
            <tbody>
                <tr>
                    <td>Kader Pengurus Data</td>
                    <td>:</td>
                    <td>{{ $dataKader['nama'] }}</td>
                </tr>
                <tr>
                    <td>NIK Kader</td>
                    <td>:</td>
                    <td>{{ $dataKader['NIK'] }}</td>
                </tr>
                <tr>
                    <td>Terahir Data Diubah</td>
                    <td>:</td>
                    <td>{{ now('Asia/Jakarta')->locale('id')->longRelativeToNowDiffForHumans($lansiaData->updated_at)}}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $lansiaData->penduduk->nama }}</td>
                </tr>
                <tr>
                    <td>Usia</td>
                    <td>:</td>
                    <td>{{ now()->diffInYears($lansiaData->penduduk->tgl_lahir) }} Tahun</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $lansiaData->penduduk->alamat}}</td>
                </tr>
                <tr>
                    <td>Tanggal Kunjungan</td>
                    <td>:</td>
                    <td>{{ $lansiaData->tgl_pemeriksaan}}</td>
                </tr>
                <tr>
                    <td>Berat Badan</td>
                    <td>:</td>
                    <td>{{ $lansiaData->berat_badan}} kg</td>
                </tr>
                <tr>
                    <td>Tinggi Badan</td>
                    <td>:</td>
                    <td>{{ $lansiaData->tinggi_badan}} cm</td>
                </tr>
                <tr>
                    <td>Lingkar Perut</td>
                    <td>:</td>
                    <td>{{ $lansiaData->pemeriksaan_lansia->lingkar_perut}} cm</td>
                </tr>
                <tr>
                    <td>Tensi Darah</td>
                    <td>:</td>
                    <td>{{ $lansiaData->pemeriksaan_lansia->tensi_darah}}</td>
                </tr>
                <tr>
                    <td>Gula Darah</td>
                    <td>:</td>
                    <td>{{ $lansiaData->pemeriksaan_lansia->gula_darah}} mg/dL</td>
                </tr>
                <tr>
                    <td>Asam Urat</td>
                    <td>:</td>
                    <td>{{ $lansiaData->pemeriksaan_lansia->asam_urat}} mg/dL</td>
                </tr>
                <tr>
                    <td>Kolesterol</td>
                    <td>:</td>
                    <td>{{ $lansiaData->pemeriksaan_lansia->kolesterol}} mg/dL</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end">
            <a href="{{  url('kader/lansia' . session('urlPagination'))}}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    td{
        padding-inline: 10px;
        padding-block: 8px;
    }
</style>
@endpush
