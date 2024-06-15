@extends('ketua.layouts.detailtemplate')

@section('content')
    <div class="flex flex-col bg-white mx-5 mt-5 shadow-[0_-4px_0_0_rgba(29,78,216,1)] rounded-md">
        <div class="flex justify-between items-center w-full py-2 border-b">
            <p class="text-lg ml-10">Detail Data Bayi Rujukan</p>
        </div>
        <div class="container px-4 mx-auto">

        <div class="p-6 m-20 bg-white rounded shadow">
            {!! $chart->container() !!}
            <div class="flex justify-end">
                <a href="{{ url('ketua/bantuan/penerima') }}" class="bg-gray-300 text-sm text-neutral-950 font-bold py-2 px-4 mr-1 md:mr-3 rounded">Kembali</a>
            </div>
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
@push('js')
<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}
@endpush