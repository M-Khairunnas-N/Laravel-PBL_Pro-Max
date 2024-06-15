<?php

namespace App\Http\Requests\Kader\Pemeriksaan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePemeriksaanRequest extends FormRequest
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
            'kader_id' => auth()->user()->kaders[0]->kader_id,
        ]);

        $this->request->replace(
            $this->only([
                'kader_id',
                'status',
                'berat_badan',
                'tinggi_badan',
                'pemeriksaan',
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
            'kader_id' => [
                'bail',
                'required',
                'integer',
                'exists:kaders,kader_id'
            ],
            'status' => [
                'bail',
                'required',
                'string',
                Rule::in(['sehat', 'sakit'])
            ],
            'berat_badan' => [
                'bail',
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
            ],
            'tinggi_badan' => [
                'bail',
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
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
             * costum message for kader_id column or field input
             */
            'kader_id.required' => 'kader ID harus di isi!',
            'kader_id.integer' => 'kader ID harus angka bulat!',
            'kader_id.exists' => 'kader ID tidak ada!',
            /**
             * costum message for status column or field input
             */
            'status.required' => 'status harus di isi!',
            'status.string' => 'status harus berupa string!',
            'status.in' => "status hanya boleh berisi: 'sehat' atau 'sakit' saja!",
            /**
             * costum message for tinggi_badan column or field input
             */
            'tinggi_badan.required' => 'tinggi badan harus di isi!',
            'tinggi_badan.numeric' => 'tinggi badan harus angka(decimal atau bulat)!',
            'tinggi_badan.regex' => 'tinggi badan maksimal 3 digit di depan koma dan belakang koma!',
            /**
             * costum message for berat_badan column or field input
             */
            'berat_badan.required' => 'berat badan harus di isi!',
            'berat_badan.numeric' => 'berat badan harus angka(decimal atau bulat)!',
            'berat_badan.regex' => 'berat badan maksimal 3 digit di depan koma dan belakang koma!',
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
        $oldData = json_decode($this->input('pemeriksaan'), true);

        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->request->all()))));
    }
}
