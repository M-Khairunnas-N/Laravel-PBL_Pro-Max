@extends('promosi.template')

@section('content')
    <div class="flex flex-col mx-auto h-screen my-8 p-4 rounded-md max-w-6xl bg-white">
        <p class="font-bold text-2xl text-center">Jadwal Kegiatan Selanjutnya</p>
        <div class="flex mt-8 mx-4 gap-4 flex-col sm:flex-row items-center">
            <p class="text-base text-neutral-950 text-center sm:text-left">Cari:</p>
            <x-input.search-input name="searchInput" placeholder="Cari nama atau tempat kegiatan"></x-input.search-input>
        </div>

        <input type="hidden" name="model" id="model" value="{{ encrypt('App\Models\Kegiatan') }}">
        <input type="hidden" name="url" id="url" value="{{ encrypt('/jadwal/kegiatan/') }}">
        <input type="hidden" name="filterName" id="filterName" value="{{ encrypt('kegiatan_id') }}">

        <div class="mx-4 my-5 overflow-x-auto">
            <x-table.data-table :dt="$kegiatans" :headers="['Nama Kegiatan', 'Tanggal Kegiatan', 'Pukul', 'Tempat Pelaksanaan']">
                @php
                    $no = ($kegiatans->currentPage() - 1) * $kegiatans->perPage() + 1;
                @endphp
                @foreach ($kegiatans as $kgt)
                <x-table.table-row>
                        <td class="tableBody">{{$kgt->nama}}</td>
                        <td class="tableBody">{{$kgt->tgl_kegiatan}}</td>
                        <td class="tableBody">{{$kgt->jam_mulai}} - selesai</td>
                        <td class="tableBody">{{$kgt->tempat}}</td>
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
        padding-inline: 1rem;
        padding-block: 0.5rem;
        text-align: left;
        border-bottom: 1px solid #A8A29E;
    }
    #ubah, #hapus {
        display: none;
    }
</style>
@endpush
    
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

    </script>
@endpush