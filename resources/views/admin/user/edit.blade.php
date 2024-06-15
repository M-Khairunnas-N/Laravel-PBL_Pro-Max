@extends('admin.layouts.template')

@section('content')
    <form action="{{route('user.update', $user->user_id)}}" method="POST" id="user-form" enctype="multipart/form-data">
        @csrf
        <!--add 'PUT' method, because we use Route::put() for update-->
        {!! method_field('PUT') !!}

        <input type="hidden" name="user" value="{{json_encode(encrypt($user->toArray()))}}">
        <input type="hidden" name="updated_at" value="{{$user->updated_at}}">

        <div class="flex flex-col bg-white mx-5 my-5 rounded-md shadow-[0_-4px_0_0_rgba(29,78,216,1)]">
            <div class="flex justify-between items-center w-full py-2 border-b">
                <p class="text-lg mx-10">Ubah Data Penduduk</p>
            </div>
            <div class="flex flex-col lg:grid lg:grid-cols-2 my-[30px] mx-5 lg:mx-10 lg:gap-x-[101px] gap-[23px]">
                <div class="col-span-1 flex flex-col gap-[23px]">
                    <div class="flex flex-col w-full gap-[20px]">
                        <p class="text-base text-neutral-950">Nama Penduduk</p>
                        <input class="w-100 border text-neutral-950 border-none text-base font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none disabled:bg-transparent" value="{{ $pendudukNama }}" disabled>
                    </div>
                    <div class="flex flex-col w-full gap-[20px] " id="page_1">
                        <p class="text-base text-neutral-950">Level<span class="text-red-400">*</span></p>
                        <select name="level" id="level" class="w-100 border border-stone-400 text-sm font-normal pl-[10px] py-[10px] rounded-[5px] focus:outline-none">
                            @php
                                $options = ['ketua', 'kader', 'admin'];
                            @endphp
                            @foreach ($options as $option)
                                <option value="{{ $option }}" {{ old('level', $user->level) === $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('level')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-1 flex flex-col gap-[23px]">
                    <div class="flex flex-col w-full h-fill gap-[20px]">
                        <p class="text-base text-neutral-950">Upload Foto<span class="text-red-400">*</span></p>
                        <div class="px-4 py-6 w-full h-fill gap-5 border border-stone-400 rounded-[5px]">
                            <div id="image-preview" class="w-full p-6 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-center mx-auto text-center cursor-pointer">
                                <img src="" alt="" class="max-h-48 rounded-lg mx-auto" alt="Image preview" id="imageId">
                                <input id="upload" type="file" name="foto_profil" class="hidden" accept="image/*" />
                                <label for="upload" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-tanda w-8 h-8 text-gray-700 mx-auto mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <h5 class="text-tanda mb-2 text-xl font-bold tracking-tight text-gray-700">Pilih foto artikel</h5>
                                    <p class="text-tanda font-normal text-sm text-gray-400 md:px-6">Ukuran file foto maksimal <b class="text-gray-600">700kb</b></p>
                                    <p class="text-tanda font-normal text-sm text-gray-400 md:px-6">dan harus memiliki format <b class="text-gray-600">JPG, JPEG,PNG,GIF, atau SVG   </b></p>
                                    <span id="filename" class="text-gray-500 bg-gray-200 z-50"></span>
                                </label>
                            </div>
                        </div>
                        <p class="text-xs font-normal text-stone-400 mt-[-10px]">Klik pada foto untuk mengubahnya</p>
                        @error('foto_profil')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full gap-[20px]">
                        <p class="text-base text-neutral-950">Username<span class="text-red-400">*</span></p>
                        <input type="text" name="username" value="{{old('username', $user->username)}}" class="w-100 text-sm font-normal border border-stone-400 lg:pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan username">
                        @error('username')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full gap-[20px]">
                        <p class="text-base text-neutral-950">Password</p>
                        <input type="password" autocomplete="new-password" name="password" value="{{old('password')}}" id="password" class="w-100 text-sm font-normal border border-stone-400 lg:pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan password">
                        <span id="passwordError" class="text-red-500 hidden" style="grid-column: 2"></span>
                        <span class="text-neutral-500" style="grid-column: 2">kosongkan jika tidak ingin memperbarui</span>
                        @error('password')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full gap-[20px] ">
                        <p class="text-base text-neutral-950">Ulangi Password</p>
                        <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirm" class="w-100 text-sm font-normal border border-stone-400 lg:pl-[10px] py-[10px] rounded-[5px] focus:outline-none placeholder:text-gray-300" placeholder="Masukkan konfirmasi password">
                        <span id="passConfirmError" class="text-red-500 hidden" style="grid-column: 2"></span>
                        <span class="text-neutral-500" style="grid-column: 2">kosongkan jika tidak ingin memperbarui</span>
                    </div>
                </div>
            </div>
            <div class="grid md:grid-cols-2 mx-10 gap-x-[101px] pb-[30px]">
                <span id="page_1" class="col-span-1 hidden md:hidden"></span>
                <div class="col-span-2 flex justify-end items-center gap-[26px] pt-10 w-full" id="">
                    <p class="text-base"><span class="text-red-400">*</span>Wajib diisi</p>
                    <a href="{{ url('admin/user' . session('urlPagination')) }}" class="bg-gray-300 text-neutral-950 font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="page_1">Kembali</a>
                    <button type="submit" class="bg-blue-700 text-white font-bold text-base py-[5px] px-[19px] rounded-[5px]" id="simpan">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script>
        {{-- Script for styling image input --}}
        document.addEventListener('DOMContentLoaded', () => {
            const uploadInput = document.getElementById('upload');
            const filenameLabel = document.getElementById('filename');
            let imagePreview = document.getElementById('image-preview');
            let image = document.getElementById('imageId');
            let text = document.querySelectorAll('.text-tanda')
            let isEventListenerAdded = false;

            // Initialize the image preview if there's an existing image
            const existingImageUrl = '{{ $user->foto_profil }}'; // Make sure this variable is properly set in your server-side code

            if (existingImageUrl) {
                image.src = `${existingImageUrl}`;
                text.forEach(e => {
                    e.classList.toggle('hidden');
                })

                // Add event listener for image preview only once
                if (!isEventListenerAdded) {
                    imagePreview.addEventListener('click', () => {
                        uploadInput.click();
                    });
                    isEventListenerAdded = true;
                }
            }

            uploadInput.addEventListener('change', (event) => {
                const file = event.target.files[0];

                if (file) {
                    filenameLabel.textContent = file.name;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        image.src = `${e.target.result}`;

                        // Add event listener for image preview only once
                        if (!isEventListenerAdded) {
                            imagePreview.addEventListener('click', () => {
                                uploadInput.click();
                            });
                            isEventListenerAdded = true;
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    filenameLabel.textContent = '';
                    imagePreview.innerHTML = `<div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center text-gray-500">No image preview</div>`;
                    imagePreview.classList.add('border-dashed', 'border-2', 'border-gray-400');

                    // Remove the event listener when there's no image
                    imagePreview.removeEventListener('click', () => {
                        uploadInput.click();
                    });

                    isEventListenerAdded = false;
                }
            });

            uploadInput.addEventListener('click', (event) => {
                event.stopPropagation();
            });
        });

        document.getElementById("user-form").addEventListener("submit", function(event){
            let pwd = document.getElementById("password").value;
            let passwordError = document.getElementById("passwordError");
            let valid = true;

            if (!/[A-Z]/.test(pwd)) {
                passwordError.textContent = "Password harus memiliki setidaknya satu huruf kapital.";
                passwordError.classList.remove("hidden");
                valid = false;
            }
            if (!/[0-9]/.test(pwd)) {
                passwordError.textContent = "Password harus memiliki setidaknya 1 angka.";
                passwordError.classList.remove("hidden");
                valid = false;
            }
            if (pwd.length < 8 && pwd.length > 0) {
                passwordError.textContent = "Password minimal 8 karakter ";
                passwordError.classList.remove("hidden");
                valid = false;
            }
            if (pwd.length === 0) {
                valid = true;
            }
            if(!valid) {
                event.preventDefault();
            } else {
                passwordError.classList.add("hidden");
            }
        });
        document.getElementById("user-form").addEventListener("submit", function(event){
            let pwd = document.getElementById("password").value;
            let pwdConfirm = document.getElementById("password_confirm").value;
            let passConfirmError = document.getElementById("passConfirmError");
            let valid = true;

            if (pwd !== pwdConfirm) {
                passConfirmError.textContent = "Pastikan konfirmasi password sama dengan password baru.";
                passConfirmError.classList.remove("hidden");
                valid = false;
            }
            if (!/[A-Z]/.test(pwdConfirm)) {
                passConfirmError.textContent = "Password harus memiliki setidaknya satu huruf kapital.";
                passConfirmError.classList.remove("hidden");
                valid = false;
            }
            if (!/[0-9]/.test(pwdConfirm)) {
                passConfirmError.textContent = "Password harus memiliki setidaknya 1 angka.";
                passConfirmError.classList.remove("hidden");
                valid = false;
            }
            if (pwdConfirm.length < 8 && pwdConfirm.length > 0) {
                passConfirmError.textContent = "Password minimal 8 karakter ";
                passConfirmError.classList.remove("hidden");
                valid = false;
            }
            if (pwdConfirm.length === 0) {
                valid = true;
            }
            if(!valid) {
                event.preventDefault();
            } else {
                passConfirmError.classList.add("hidden");
            }
        });
    </script>
@endpush
