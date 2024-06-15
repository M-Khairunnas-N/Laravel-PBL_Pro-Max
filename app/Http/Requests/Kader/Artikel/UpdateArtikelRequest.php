<?php

namespace App\Http\Requests\Kader\Artikel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtikelRequest extends FormRequest
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
        $this->merge([
            'tag' => implode(',', $this->input('tag', [])),
            /*'kader_id' => auth()->user()->kaders[0]->kader_id,*/
        ]);

        $this->request->replace($this->only([
            /*'kader_id',*/
            'judul',
            'isi',
            'tag',
            'foto_artikel',
            'artikel'
        ]));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           /* 'kader_id' => [
                'bail',
                'required',
                'integer',
                'exists:kaders,kader_id'
            ],*/
            'judul' => [
                'bail',
                'required',
                'string',
                'regex:/^([\w\s\n.,!;:?()-]{5,250})$/',
            ],
            'isi' => [
                'bail',
                'required',
                'string',
                'regex:/^[\w\s\n.,!;:?()-]{30,30000}$/',
            ],
            'tag' => [
                'bail',
                'required',
                'string',
                'regex:/^[a-zA-Z\s,_]{1,100}$/',
            ],
            'foto_artikel' => [
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
             * costum message for kader_id column or field input
             */
            /*'kader_id.required' => 'kader ID harus di isi!',
            'kader_id.integer' => 'kader ID harus angka bulat!',
            'kader_id.exists' => 'kader ID tidak ada!',*/
            /**
             * costum message for judul column or field input
             */
            'judul.required' => 'judul harus di isi!',
            'judul.string' => 'judul harus berupa string!',
            'judul.regex' => "judul minimal 5 dan maksimal 250 huruf serta tidak boleh ada tanda-tanda khusus!",
            /**
             * costum message for isi column or field input
             */
            'isi.required' => 'isi harus di isi!',
            'isi.string' => 'isi harus berupa string!',
            'isi.regex' => "isi minimal 30 dan maksimal 30.000 huruf serta tidak boleh ada tanda-tanda khusus!",
            /**
             * costum message for tag column or field input
             */
            'tag.required' => 'tag harus di isi!',
            'tag.string' => 'tag harus berupa string!',
            'tag.regex' => "tag maksimal 100 huruf serta tidak boleh ada tanda-tanda khusus!",
            /**
             * costum message for foto_artikel column or field input
             */
            'foto_artikel.image' => 'foto artikel harus berupa file foto!',
            'foto_artikel.mimes' => "foto artikel hanya boleh mempunyai extension: .jpeg, .jpg, .png, .gif, .svg !",
            'foto_artikel.max' => 'foto artikel maksimal berukuran 700 KiloBytes(KB) !'
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
        $oldData = json_decode($this->input('artikel'), true);
        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->input()))));

        /**
         * store image in public/artikel directory when user fill foto_artikel input
         */
        $image = $this->file('foto_artikel');
        if (isset($image)) {
            $this->merge([
                'foto_artikel' => $image
            ]);
        }
    }
}
