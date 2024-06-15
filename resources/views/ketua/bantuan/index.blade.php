@extends('ketua.layouts.template')

@section('content')
    <div class="flex flex-col bg-white mx-5 mt-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
        <div class="flex justify-between items-center w-full py-2 border-b">
            <p class="text-lg ml-10">Daftar Rekomendasi Rujukan</p>
            <a href="{{ url('ketua/bantuan/penerima') }}" class="bg-blue-700 text-sm text-white font-bold py-1 px-4 mr-10 rounded">Detail</a>
        </div>
        <div class="mx-10 my-[30px] overflow-x-auto">
            <x-table.data-table :dt="$bayis" :headers="['Nama Bayi', 'Nama Ibu', 'Nama Ayah', 'Periode Bantuan', 'Jenis Bantuan']">
                @php
                    $no = ($bayis->currentPage() - 1) * $bayis->perPage() + 1;
                @endphp
                @foreach ($bayis as $bayi)
                    <x-table.table-row> 
                        <td class="px-6 2xl:py-6 lg:py-5 border-b bg-white">{{ $bayi->nama }}</td>
                        <td class="px-6 2xl:py-6 lg:py-5 border-b bg-white">
                            @php
                                $ibu = $parents->filter(function ($parent) use ($bayi) {
                                    return $parent->hubungan_keluarga === 'Istri' && $parent->NKK === $bayi->NKK;
                                })->first();
                            @endphp
                            {{ $ibu? $ibu->nama : 'Tidak Ada Ibu' }}
                        </td>
                            <td class="px-6 2xl:py-6 lg:py-5 border-b bg-white">
                                @php
                                    $ayah = $parents->filter(function ($parent) use ($bayi) {
                                        return $parent->hubungan_keluarga === 'Kepala Keluarga' && $parent->NKK === $bayi->NKK;
                                    })->first();
                                @endphp
                                {{ $ayah? $ayah->nama : 'Tidak Ada Ayah' }}
                            </td>
                        <td class="px-6 2xl:py-6 lg:py-5 border-b bg-white">{{ Carbon\Carbon::parse($bayi->created_at)->format('F Y') }}</td>
                        <td class="px-6 2xl:py-6 lg:py-5 border-b bg-white">Rujukan Rumah Sakit/Puskesmas</td>
                    </x-table.table-row>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </x-table.data-table>
        </div>
    </div>
@endsection

@push('css')
<style>
    th, td {
        padding-inline: 20px;
        padding-block: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
</style>
@endpush
