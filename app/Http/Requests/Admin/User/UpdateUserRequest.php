<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->request->replace(
            $this->only([
                'username',
                'password',
                'password_confirmation',
                'level',
                'foto_profil',
                'user'
            ])
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'bail',
                'required',
                'string',
                /**
                 * Must start with an alphabetic character.
                 * Can contain the following characters: a-z, A-Z, 0-9, -, and _
                 */
                'regex:/^[a-zA-z][a-zA-Z0-9-_]{3,100}$/',
                'unique:users,username,' . $this->route('user') . ',user_id'
            ],
            'password' => [
                'bail',
                'nullable',
                'present_with:password_confirmation',
                'string',
                /**
                 * at least 8 characters
                 * must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number
                 * Can contain special characters
                 */
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,100}$/',
                'confirmed'
            ],
            'level' => [
                'bail',
                'required',
                'string',
                Rule::in(['kader', 'ketua', 'admin']),
                function ($attribute, $value, $fail) {
                    if ($value === 'ketua' and DB::table('users')->where('level', $value)->where('user_id', '!=', $this->route('user'))->exists()) {
                        $fail('Ketua maksimal 1 dan sudah ada datanya!');
                    }
                }
            ],
            'foto_profil' => [
                'bail',
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:700'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            /**
             * costum message for username column or field input
             */
            'username.required' => 'username harus di isi!',
            'username.string' => 'username harus berupa string!',
            'username.regex' => 'username minimal 3 dan maximal 100 serta harus dimulai dari huruf dan untuk karakter _ atau angka harus setelah huruf!',
            'username.unique' => 'username sudah terdaftar!',
            /**
             * costum message for password column or field input
             */
            'password.string' => 'password harus berupa string!',
            'password.regex' => "password minimal 8 karakter serta harus mempunyai minimal 1 huruf kapital dan 1 angka!",
            'password.confirmed' => 'password tidak sama dengan konfirmasi password!',
            /**
             * costum message for level column or field input
             */
            'level.required' => 'level harus di isi!',
            'level.string' => 'level harus berupa string!',
            'level.regex' => "level hanya boleh berisi: 'kader' , 'ketua' atau 'admin' saja!",
            /**
             * costum message for foto_profil column or field input
             */
            'foto_profil.image' => 'foto profil harus berupa file foto!',
            'foto_profil.mimes' => "foto profil hanya boleh mempunyai extension: .jpeg, .jpg, .png, .gif, .svg !",
            'foto_profil.max' => 'foto profil maksimal berukuran 700 KiloBytes(KB) !'
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        /**
         * compare updated data from user form with old data in
         * database and just replace request input with data that
         * changes
         */
        $oldData = decrypt(json_decode($this->input('user'), true));
        /**
         * fill old data with null, to compare if password is null in form, we not replace only that field
         */
        $oldData['password'] = null;
        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->input()))));

        /**
         * store image in public/user directory when user fill foto_profil input
         */
        $image = $this->file('foto_profil');

        if (isset($image)) {
            $this->merge([
                'foto_profil' => $image,
            ]);
        }
    }
}
