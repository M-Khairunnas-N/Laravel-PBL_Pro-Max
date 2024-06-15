@extends('admin.layouts.template')

@section('content')
    <div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
        <div class="flex justify-between items-center w-full py-2 border-b">
            <p class="text-lg ml-10">Detail Penduduk</p>
        </div>
        <div class="flex flex-col gap-[15px] py-10 px-[10px] lg:px-[30px]">
            <table class="w-fit">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $penduduk->nama }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ $penduduk->tgl_lahir }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>{{ $penduduk->NIK}}</td>
                    </tr>

                    <tr>
                        <td>NKK</td>
                        <td>:</td>
                        <td>{{ $penduduk->NKK}}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}}</td>
                    </tr>
                    <tr>
                        <td>Hubungan Keluarga</td>
                        <td>:</td>
                        <td>{{ $penduduk->hubungan_keluarga}}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telepon</td>
                        <td>:</td>
                        @if($penduduk->no_telp === null)
                            <td>Tidak Punya</td>
                        @else
                            <td>{{ $penduduk->no_telp}}</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $penduduk->alamat}}</td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                        <td>{{ $penduduk->pendidikan}}</td>
                    </tr>
                    <tr>
                        <td>Rentang Pendapatan</td>
                        <td>:</td>
                        <td>{{ $penduduk->pendapatan}}</td>
                    </tr>
                    <tr>
                        <td>RT</td>
                        <td>:</td>
                        <td>{{ $penduduk->RT}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end px-2">
                <a href="{{url('admin/penduduk' . session('urlPagination'))}}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]">Kembali</a>
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
