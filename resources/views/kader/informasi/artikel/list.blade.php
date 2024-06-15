@extends('kader.layouts.template')

@section('content')
<div class="flex w-full justify-center items-center my:2 lg:my-4 hidden" id="messageContainer">
    @if(session('success'))
        <div class="flex w-3/4 h-full items-center p-2 mb-1 border-2 border-green-500 bg-green-100 text-green-700 rounded-md" id="message">
            <p class="mr-4"> <b>BERHASIL </b> {{ session('success') }}</p>
            <button id="close" class="ml-auto bg-transparent text-green-700 hover:text-green-900">
                <span>&times;</span>
            </button>
        </div>
    @elseif(session('error'))
        <div class="flex w-3/4 h-full items-center p-4 mb-4 border-2 border-red-500 bg-red-100 text-red-700 rounded-md" id="message">
            <p class="mr-4">{{ session('error') }}</p>
            <button id="close" class="ml-auto bg-transparent text-red-700 hover:text-red-900">
                <span>&times;</span>
            </button>
        </div>
    @endif
</div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-[41px] my-5 mx-5">
        @foreach ($artikels as $artikel)
            <div
                class="w-100 flex flex-col justify-center items-center bg-white px-[15px] py-5 rounded-[15px] gap-[15px]">
                <img src="{{ $artikel->foto_artikel}}" alt="" class="w-[327px] h-[225px] rounded-[7.5px]">
                <h3 class="font-bold text-[15px] text-justify">{{ $artikel->judul}}</h3>
                <p class="text-[15px] text-justify">{{ substr($artikel->isi, 0, 200) }} {{ strlen($artikel->isi) > 100 ? '...' : '' }}</p>

                <form id="delete-form-{{$artikel->artikel_id}}" action="artikel/{{$artikel->artikel_id}}" method="post" class="flex items-center gap-2">
                    @php
                        session(['urlArtikel' => '']);
                    @endphp
                    <a href="artikel/{{$artikel->artikel_id}}"
                        class="bg-gray-300 text-[15px] py-[10px] px-[30px] rounded-[5px]">Lihat</a>
                    <a href="artikel/{{$artikel->artikel_id}}/edit"
                        class="bg-blue-700 text-[15px] text-white py-[10px] px-[30px] rounded-[5px]">Edit</a>
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="updated_at" value="{{ $artikel->updated_at }}">
                    <button type="button" data-id="{{$artikel->artikel_id}}" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="delete-btn bg-red-400 text-[15px] py-[10px] px-[30px] rounded-[5px] hover:bg-red-600 hover:text-white">Hapus</button>
                </form>

                <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden top-0 left-0 fixed z-50 justify-center items-center w-full md:inset-0 h-screen">
                    <div class="absolute p-4 w-full h-screen flex justify-center items-center backdrop-blur-sm">
                        <div class="relative bg-white rounded-lg shadow-md dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah yakin ingin menghapus artikel?</h3>
                                <button id="confirm-delete" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Ya
                                </button>
                                <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tidak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            let deleteFormId;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    deleteFormId = this.getAttribute('data-id');
                });
            });

            document.getElementById('confirm-delete').addEventListener('click', function() {
                document.getElementById('delete-form-' + deleteFormId).submit();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        const modalToggles = document.querySelectorAll('[data-modal-toggle]');
        const modals = document.querySelectorAll('.fixed');

        modalToggles.forEach(toggle => {
            toggle.addEventListener('click', function () {
                const modalId = toggle.getAttribute('data-modal-target');
                const modal = document.getElementById(modalId);
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            });
        });

        const modalHides = document.querySelectorAll('[data-modal-hide]');
        modalHides.forEach(hide => {
            hide.addEventListener('click', function () {
                const modalId = hide.getAttribute('data-modal-hide');
                const modal = document.getElementById(modalId);
                if (!modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                }
            });
        });
    });

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
@endpush
