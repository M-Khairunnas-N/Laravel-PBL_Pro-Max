<div class="flex flex-col justify-between w-full h-full overflow-x-auto">

    <table class="table-auto w-full xl:text-sm lg:text-xs font-normal capitalize" id="dataTable">
        <thead class="bg-gray-200">
        <tr class="text-neutral-950">

            @foreach($headers as $index => $header)

                @if($index == 0)
                    <th class="py-2 px-5 lg:px-6 rounded-tl-[10px] text-xs lg:text-sm text-start">{{ $header }}</th>

                @elseif($index == count($headers) - 1)
                    <th class="px-5 lg:px-6 py-2 rounded-tr-[10px] text-xs lg:text-sm text-start">{{ $header }}</th>

                @else
                    <th class="px-5 lg:px-6 py-2 text-xs lg:text-sm text-start">{{ $header }}</th>
                @endif

            @endforeach

        </tr>
        </thead>
        @if($dt->isEmpty())
            <tr>
                <td colspan="7" class="text-center p-6 bg-white border-b font-medium text-Neutral/60" id="loading">
                    Data tidak ditemukan
                </td>
            </tr>
        @else
            <tbody class="transition ease-in-out duration-200" id="bodyTable">
            {{$slot}}
            </tbody>
        @endif
    </table>
    <div class="flex justify-between items-center my-4" id="pagin">
        <div class="flex items-center list-none gap-2">
            {{ $dt->links() }}
        </div>
        <div class="text-sm text-neutral-950 font-normal">
            Menampilkan {{$dt->count()}} dari {{$dt->total()}} data
        </div>
    </div>
</div>
