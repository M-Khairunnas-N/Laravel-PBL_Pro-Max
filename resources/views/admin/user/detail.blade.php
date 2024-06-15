@extends('admin.layouts.template')

@section('content')
    <div class="flex flex-col bg-white mx-5 my-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
        <div class="flex justify-between items-center w-full py-2 border-b">
            <p class="text-lg ml-10">Detail User</p>
        </div>
        <div class="flex flex-col gap-[15px] py-10 px-[10px] lg:px-[30px]">
            <table class="w-fit">
                <tbody>
                    <tr>
                        <td>Nama Penduduk</td>
                        <td>:</td>
                        <td>{{ $penduduk->nama }}</td>
                    </tr>
                    <tr>
                        <td>NIK Penduduk</td>
                        <td>:</td>
                        <td>{{ $penduduk->NIK }}</td>
                    </tr>
                    <tr>
                        <td>NKK Penduduk</td>
                        <td>:</td>
                        <td>{{ $penduduk->NKK }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin Penduduk</td>
                        <td>:</td>
                        <td>{{ $penduduk->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>:</td>
                        <td>{{ $user->level}}</td>
                    </tr>
                    <tr>
                        <td>Foto Profil</td>
                        <td>:</td>
                        <td><img src="{{ $user->foto_profil }}" alt="foto_profil"></td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end px-2">
                <a href="{{url('admin/user' . session('urlPagination'))}}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]">Kembali</a>
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
