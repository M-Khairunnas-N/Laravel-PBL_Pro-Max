<?php

namespace App\Http\Requests\Admin\Kriteria;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKriteriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->request->replace(
            $this->only([
                'nama',
                'bobot',
                'jenis',
                'kriteria',
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
            'nama' => [
                'bail',
                'required',
                'string',
                'regex:/^[a-zA-Z\s.]{1,50}$/',
                'unique:kriterias,kode, '.$this->route('kriteria').',kode',
            ],
            'bobot' => [
                'bail',
                'required',
                'numeric',
                'regex:/^0(\.\d{1,3})?$/',
            ],
            'jenis' => [
                'bail',
                'required',
                'string',
                Rule::in(['benefit', 'cost']),
            ],
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
             * costum message for nama column or field input
             */
            'nama.required' => 'nama harus di isi!',
            'nama.string' => 'nama harus berupa string!',
            'nama.regex' => 'nama maksimal 50 serta hanya boleh huruf!',
            'nama.unique' => 'nama harus unik antara kriteria lain!',
            /**
             * costum message for bobot column or field input
             */
            'bobot.required' => 'bobot kriteria harus di isi!',
            'bobot.numeric' => "bobot kriteria angka(decimal atau bulat)!",
            'bobot.regex' => "bobot kritria harus diawali angka 0 dan maksimal 3 digit di belakang koma!",
            /**
             * costum message for jenis column or field input
             */
            'jenis.required' => 'jenis kriteria harus di isi!',
            'jenis.string' => 'jenis kriteria harus berupa string!',
            'jenis.in' => 'jenis kriteria hanya boleh berisi: benefit dan cost!',
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
        // dd(json_decode($this->input('kriteria')));
        $oldData = json_decode($this->input('kriteria'), true);

        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->request->all()))));
    }
}
