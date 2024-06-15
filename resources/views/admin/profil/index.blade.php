@extends('admin.layouts.template')

@section('content')
    <form method="POST" action="{{route('admin.profile.update', auth()->user()->user_id)}}" id="profile-form"
          enctype="multipart/form-data">
        @csrf
        <!--add 'PUT' method, because we use Route::put() for update-->
        {!! method_field('PUT') !!}

        <input type="hidden" name="level" value="{{ auth()->user()->level }}">
        <input type="hidden" name="user" value="{{ json_encode(encrypt($user)) }}">
        <input type="hidden" name="updated_at" value="{{ $user['updated_at'] }}">
        
        <div class="flex flex-col lg:grid max-md:grid-rows-1 lg:grid-cols-3 bg-white mx-5 mt-5 rounded-[15px] gap-0">
            <div class="flex flex-col items-center w-full pt-[30px] gap-[10px]">
                <p class="text-lg font-bold ">Informasi Profile</p>
                <div class=" w-[250px] h-fill gap-5  flex justify-center items-center rounded-[5px]">
                    <div id="image-preview"
                         class="w-full rounded-lg justify-center items-center mx-auto text-center cursor-pointer">
                        <img src="" alt="" class="w-full aspect-square rounded-[50px]" alt="Image preview" id="imageId">
                        <input id="upload" type="file" name="foto_profil" class="hidden" accept="image/*"/>
                        <label for="upload" class="cursor-pointer">
                            <span id="filename" class="text-gray-500 bg-gray-200 z-50"></span>
                        </label>
                    </div>
                </div>
                @error('foto_profil')
                <span class="text-red-500">{{$message}}</span>
                @enderror
                <div class="w-full text-center">
                    <p>{{$user['nama']}}</p>
                    <p>Kader Posyandu</p>
                </div>
                <div class="flex gap-[30px] font-bold">
                    <a href="{{'foto/' . auth()->user()->user_id . '/' . $user['updated_at'] }}" class="bg-red-600 text-white py-[10px] px-[17px] rounded-[5px]">Hapus</a>
                    <label for="upload" class="bg-blue-700 text-white py-[10px] px-[17px] rounded-[5px] cursor-pointer">Ubah</a>
                </div>
            </div>
            <div class="col-span-2 w-full h-full lg:py-10 pt-2">
                <div
                    class="flex flex-col my-[30px] lg:my-[55px] lg:py-[55px] mr-0 md:mr-[51px] lg:bg-gray-200 lg:rounded-[15px] gap-[15px] lg:gap-[60px]">
                    <div class="flex flex-col lg:grid pt-0 lg:grid-cols-2 justify-between px-[20px] lg:px-[61px]">
                        <p>Username</p>
                        <input type="text" class="w-full py-1 px-2 rounded-[4px]" name="username"
                               value="{{old('username', $user['username'])}}" id="username" required>
                        @error('username')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col lg:grid pt-0 md:grid-cols-2 justify-between px-[20px] md:px-[61px]">
                        <p>Password</p>
                        <input type="password" class="w-full py-1 px-2 rounded-[4px]" name="password" id="password"
                               autocomplete="new-password">
                        <span id="passwordError" class="text-red-500 hidden" style="grid-column: 2"></span>
                        <span class="text-neutral-500" style="grid-column: 2">kosongkan jika tidak ingin memperbarui</span>
                        @error('password')
                        <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col lg:grid pt-0 md:grid-cols-2 justify-between px-[20px] md:px-[61px]">
                        <p>Ulangi Password</p>
                        <input type="password" class="w-100 py-1 px-2 rounded-[4px]" name="password_confirmation"
                               id="password_confirm">
                        <span id="passConfirmError" class="text-red-500 hidden" style="grid-column: 2"></span>
                        <span class="text-neutral-500" style="grid-column: 2">kosongkan jika tidak ingin memperbarui</span>
                    </div>
                </div>
            </div>
            <div class="flex justify-end col-span-3 w-full pr-[51px] pb-[30px] gap-[30px]">
                @php
                    $previous = url()->previous();
                    if(Request::url() === $previous) 
                    {
                        $previous = url('admin');
                    }
                @endphp
            <a href="{{ $previous }}" class="bg-gray-300 py-[10px] px-[17px] rounded-[5px] text-center">Kembali</a>
            <button type="submit" id="submit" class="bg-blue-700 text-white py-[10px] px-[17px] rounded-[5px]" id="simpan">Simpan Data</button>
            </div>
        </div>
    </form>
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
    <script>
        document.getElementById("profile-form").addEventListener("submit", function (event) {
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
            if (!valid) {
                event.preventDefault();
            } else {
                passwordError.classList.add("hidden");
            }
        });
        document.getElementById("profile-form").addEventListener("submit", function (event) {
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
            if (!valid) {
                event.preventDefault();
            } else {
                passConfirmError.classList.add("hidden");
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const uploadInput = document.getElementById('upload');
            const filenameLabel = document.getElementById('filename');
            let imagePreview = document.getElementById('image-preview');
            let image = document.getElementById('imageId');
            let text = document.querySelectorAll('.text-tanda')
            let isEventListenerAdded = false;

            // Initialize the image preview if there's an existing image
            const existingImageUrl = "{{$user['foto_profil']}}"; // Make sure this variable is properly set in your server-side code

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
    </script>
@endpush
