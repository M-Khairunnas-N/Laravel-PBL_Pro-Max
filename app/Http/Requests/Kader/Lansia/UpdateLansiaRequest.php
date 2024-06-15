<?php

namespace App\Http\Requests\Kader\Lansia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLansiaRequest extends FormRequest
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
                'lingkar_perut',
                'gula_darah',
                'kolesterol',
                'tensi_darah',
                'asam_urat',
                'pemeriksaan_lansia',
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
            'lingkar_perut' => [
                'bail',
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
            ],
            'gula_darah' => [
                'bail',
                'required',
                'integer',
                'regex:/^\d{1,3}$/'
            ],
            'kolesterol' => [
                'bail',
                'required',
                'integer',
                'regex:/^\d{1,3}$/'
            ],
            'tensi_darah' => [
                'bail',
                'required',
                'integer',
                'regex:/^\d{1,3}$/'
            ],
            'asam_urat' => [
                'bail',
                'required',
                'numeric',
                'regex:/^\d{1,2}(\.\d{1,3})?$/'
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
             * costum message for lingkar_perut column or field input
             */
            'lingkar_perut.required' => 'lingkar perut harus di isi!',
            'lingkar_perut.numeric' => 'lingkar perut harus angka(decimal atau bulat)!',
            'lingkar_perut.regex' => 'lingkar perut maksimal 3 digit di depan koma dan belakang koma',
            /**
             * costum message for gula_darah column or field input
             */
            'gula_darah.required' => 'gula darah harus di isi!',
            'gula_darah.integer' => 'gula darah maksimal 3 digit angka',
            'gula_darah.regex' => 'gula darah maksimal 3 digit angka',
            /**
             * costum message for kolesterol column or field input
             */
            'kolesterol.required' => 'kolesterol harus di isi!',
            'kolesterol.integer' => 'kolesterol maksimal 3 digit angka',
            'kolesterol.regex' => 'kolesterol maksimal 3 digit angka',
            /**
             * costum message for tensi_darah column or field input
             */
            'tensi_darah.required' => 'tensi darah harus di isi!',
            'tensi_darah.integer' => 'tensi darah maksimal 3 digit angka',
            'tensi_darah.regex' => 'tensi darah maksimal 3 digit angka',
            /**
             * costum message for asam_urat column or field input
             */
            'asam_urat.required' => 'asam urat harus di isi!',
            'asam_urat.numeric' => 'asam urat harus angka(decimal atau bulat)!',
            'asam_urat.regex' => 'asam urat maksimal 2 digit di depan koma dan 3 digit di belakang koma',
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
        $oldData = json_decode($this->input('pemeriksaan_lansia'), true);

        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->request->all()))));
    }
}
