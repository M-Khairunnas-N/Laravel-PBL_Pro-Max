@extends('ketua.layouts.template')

@section('content')
    <div class="flex flex-col bg-white mx-5 mt-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
        <div class="flex justify-between items-center w-full py-2 border-b">
            <p class="text-lg ml-10">Hasil Perhitungan SAW</p>
            <a href="{{ url('ketua/bantuan/penerima') }}" class="bg-gray-300 text-sm text-neutral-950 font-bold py-2 px-4 mr-1 md:mr-3 rounded">Kembali</a>
        </div>
    <div class="mx-10 my-[30px]">
            <table class="border-collapse w-full rounded-t-[10px] overflow-hidden">
                <thead class="bg-gray-200 border-b text-left py-5">
                    <th class="font-normal text-sm">Rangking</th>
                    <th class="font-normal text-sm">Nama Balita</th>
                    <th class="font-normal text-sm">Hasil Perhitungan</th>
                    </tr>
                </thead>
                <tbody class="">
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($bayiSAW as $key => $r)
                        <tr class="text-neutral-950 text-left">
                            <td class="font-normal text-sm">{{$i}}</td>
                            <td class="font-normal text-sm">
                                @foreach ($bayis as $bayi)
                                    @if ($bayi->penduduk_id == $countBayi[$key])
                                        {{$bayi->nama}}
                                    @break
                                    @endif
                                @endforeach
                            </td>
                            <td class="font-normal text-sm">{{number_format($r, 3)}}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    <div class="flex justify-between items-center w-full py-2 border-b">
        <p class="text-lg ml-10">Hasil Perhitungan Mabac</p>
    </div>
    <div class="mx-10 my-[30px]">
            <table class="border-collapse w-full rounded-t-[10px] overflow-hidden">
                <thead class="bg-gray-200 border-b text-left py-5">
                    <th class="font-normal text-sm">Rangking</th>
                    <th class="font-normal text-sm">Nama Balita</th>
                    <th class="font-normal text-sm">Hasil Perhitungan</th>
                    </tr>
                </thead>
                <tbody class="">
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($bayiMabac as $key => $r)
                        <tr class="text-neutral-950 text-left">
                            <td class="font-normal text-sm">{{$i}}</td>
                            <td class="font-normal text-sm">
                                @foreach ($bayis as $bayi)
                                    @if ($bayi->penduduk_id == $countBayi[$key])
                                        {{$bayi->nama}}
                                    @endif
                                @endforeach
                            </td>
                            <td class="font-normal text-sm">{{number_format($r, 3)}}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
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
