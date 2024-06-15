<?php

namespace App\Http\Requests\Kader\Bayi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBayiRequest extends FormRequest
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
                'lingkar_kepala',
                'lingkar_lengan',
                'asi',
                'pemeriksaan_bayi'
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
            'lingkar_kepala' => [
                'bail',
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
            ],
            'lingkar_lengan' => [
                'bail',
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
            ],
            'asi' => [
                'bail',
                'required',
                'string',
                Rule::in(['iya', 'tidak'])
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
             * costum message for lingkar_kepala column or field input
             */
            'lingkar_kepala.required' => 'lingkar kepala harus di isi!',
            'lingkar_kepala.numeric' => 'lingkar kepala harus angka(decimal atau bulat)!',
            'lingkar_kepala.regex' => 'lingkar kepala maksimal 3 digit di depan koma dan belakang koma!',
            /**
             * costum message for lingkar_lengan column or field input
             */
            'lingkar_lengan.required' => 'lingkar lengan harus di isi!',
            'lingkar_lengan.numeric' => 'lingkar lengan harus angka(decimal atau bulat)!',
            'lingkar_lengan.regex' => 'lingkar lengan maksimal 3 digit di depan koma dan belakang koma!',
            /**
             * costum message for asi column or field input
             */
            'asi.required' => 'asi harus di isi!',
            'asi.string' => 'asi harus berupa string!',
            'asi.in' => "asi hanya boleh berisi: 'iya' atau 'tidak' saja!",
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
        $oldData = json_decode($this->input('pemeriksaan_bayi'), true);

        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->request->all()))));
    }
}
