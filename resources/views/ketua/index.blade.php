@extends('ketua.layouts.template')

@section('content')
<div class="flex flex-col mt-[30px] mx-10 gap-[30px] relative hidden" id="messageContainer">
    <div class="flex w-full h-full justify-center items-center absolute" >
        @if(session('success'))
            <div class="flex w-full h-full items-center p-4 mb-4 border-2 border-green-500 bg-green-100 text-green-700 rounded-md" id="message">
                <p class="mr-4"> <b>BERHASIL </b> {{ session('success') }}</p>
                <button id="close" class="ml-auto bg-transparent text-green-700 hover:text-green-900">
                    <span>&times;</span>
                </button>
            </div>
        @elseif(session('error'))
            <div class="flex w-full h-full items-center p-4 mb-4 border-2 border-red-500 bg-red-100 text-red-700 rounded-md" id="message">
                <p class="mr-4">{{ session('error') }}</p>
                <button id="close" class="ml-auto bg-transparent text-red-700 hover:text-red-900">
                    <span>&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>
<div class="grid lg:grid-cols-3 mx-5 mt-5 sm:mb-5 lg:mb-5 gap-5">
    @php
        $golongan = ['Lansia', 'Bayi'];
    @endphp
    @for($i = 0; $i < 2; $i++)
        <div class="flex flex-col bg-white rounded-2xl pr-6 pl-7 gap-9">
            <div class="flex w-full justify-between pt-5">
                <p class="font-medium text-base">Jumlah {{ $data['golongan_all'][$i]->golongan ?? $golongan[$i] }}</p>
            </div>
            <h1 class="text-5xl font-medium">{{ $data['golongan_all'][$i]->total ?? 0}}</h1>
            <p class="text-xs text-stone-400 pb-4">Seluruhnya</p>
        </div>
        <div class="flex flex-col bg-white rounded-2xl pr-6 pl-7 gap-9">
            <div class="flex w-full justify-between pt-5">
                <p class="font-medium text-base">Jumlah {{ $data['golongan_subMonth'][$i]->golongan ?? $golongan[$i] }}</p>
            </div>
            <h1 class="text-5xl font-medium">{{ $data['golongan_subMonth'][$i]->total ?? 0}}</h1>
            <p class="text-xs text-stone-400 pb-4">Sebulan Terakhir</p>
        </div>
        <div class="flex flex-col bg-white rounded-2xl pr-6 pl-7 gap-9">
            <div class="flex w-full justify-between pt-5">
                <p class="font-medium text-base">Jumlah {{ $data['status'][$i]->golongan ?? $golongan[$i]}} Sakit</p>
            </div>
            {{-- {{ !empty($data['status'][$i]) ? $data['status'][$i]->total : 0}} --}}
            {{-- this bellow code same above code--}}
            <h1 class="text-5xl font-medium">{{ $data['status'][$i]->total ?? 0}}</h1>
            <p class="text-xs text-stone-400 pb-4">Sebulan Terakhir</p>
        </div>
    @endfor
</div>
<div class="grid grid-cols-3 mx-5 mt-5 mb-10 gap-5">

    {{-- Card Kunjungan Anggota --}}
    <div class="flex flex-col col-span-3 lg:col-span-1 w-full bg-white rounded-2xl pr-6 pl-7 lg:mb-10 gap-9">
        <div class="flex w-full justify-between pt-5">
            <p class="font-medium text-base">Kunjungan Anggota</p>
        </div>
        <div class="z-10">
            {!! $chart->container() !!}
        </div>
    </div>

    {{-- Card Agenda Posyandu --}}
    <div class="flex flex-col col-span-3 lg:col-span-2 w-full bg-white rounded-2xl pr-6 pl-7 pb-9 gap-5 overflow-x-auto">
        <div class="flex w-full justify-between pt-6 align-middle">
            <p class="font-medium lg:text-xl">Agenda Posyandu</p>
            <div class="flex gap-4">
                <x-input.search-input name="searchInput" placeholder="Cari nama atau tempat kegiatan"></x-input.search-input>
            </div>
        </div>
        <x-table.data-table :dt="$data['kegiatan']" 
                            :headers="['Nama Kegiatan', 'Tanggal Pelaksanan', 'Pukul', 'Tempat Pelaksanaan']">
            @php
                $no = ($data['kegiatan']->currentPage() - 1) * $data['kegiatan']->perPage() + 1;
            @endphp
            @foreach ($data['kegiatan'] as $kd)
                <x-table.table-row>
                    <td class="tableBody">{{$kd->nama}}</td>
                    <td class="tableBody">{{ date('d-M-Y', strtotime($kd->tgl_kegiatan))}}</td>
                    <td class="tableBody">{{ date('H:i', strtotime($kd->jam_mulai)) }} - Selesai</td>
                    <td class="tableBody">{{$kd->tempat}}</td>
                </x-table.table-row>
            @php
                $no++;
            @endphp
            @endforeach
        </x-table.data-table>
    </div>
</div>
@endsection

@push('js')
<script>
    function formatDate(dateString) {
        const date = new Date(dateString);
        
        const day = date.getDate().toString().padStart(2, '0'); // Pad single digit days with a leading zero
        const month = date.toLocaleString('en-US', { month: 'short' }); // Get short month name
        const year = date.getFullYear();

        return `${day}-${month}-${year}`;
    }

    function formatTime(timeString) {
        const [hour, minute, second] = timeString.split(':');

        const formattedHour = hour.padStart(2, '0');
        const formattedMinute = minute.padStart(2, '0');

        return `${formattedHour}:${formattedMinute}`;
    }

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
                        <td class="tableBody">${item.nama}</td>
                        <td class="tableBody">${formatDate(item.tgl_kegiatan)}</td>
                        <td class="tableBody">${formatTime(item.jam_mulai)} - Selesai</td>
                        <td class="tableBody">${item.tempat}</td>
                    </x-table.table-row>
    `;

        }

        async function searchFunction() {
            let input;
            input = document.getElementById('searchInput');
            search = input.value;

            try {
                // Make a request to the server
                const response = await fetch(`/api/informasi/search?search=${search}`, {
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
                console.error('Fetch error:', error);
                // console.log(error);
                const table = document.getElementById('dataTable');
                
                clearTable();
                
                const row = table.insertRow(-1);
                row.innerHTML = `
                <td colspan="7" class="text-center p-6 bg-white border-b font-medium text-Neutral/60">Data tidak ditemukan</td>
                `;
            }
        }

    document.getElementById('searchInput').addEventListener('keyup', searchFunction);

    document.addEventListener("DOMContentLoaded", function() {
        const messageContainer = document.getElementById('messageContainer');
        const message = document.getElementById('message');
        const closeButton = document.getElementById('close');

        if (message) {
            messageContainer.classList.remove('hidden');
            
            // Hide message after 5 seconds
            setTimeout(function() {
                messageContainer.classList.add('hidden');
                message.classList.add('hidden');
            }, 3000);
            
            // Hide message on close button click
            closeButton.addEventListener('click', function() {
                messageContainer.classList.add('hidden');
                message.classList.add('hidden');
            });
        }
    });

    // jQuery to handle fade out effect after 5 seconds
    $(document).ready(function (){
        setTimeout(function() {
            $('#message').fadeOut('fast', function() {
                $(this).addClass('hidden');
                $('#messageContainer').addClass('hidden');
            });
        }, 3000);
    });
    </script>
    <script src="{{ $chart->cdn() }}"></script>
    {{$chart->script() }}
@endpush
