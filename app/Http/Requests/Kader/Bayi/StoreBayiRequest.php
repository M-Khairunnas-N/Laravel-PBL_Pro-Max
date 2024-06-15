<?php

namespace App\Http\Requests\Kader\Bayi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBayiRequest extends FormRequest
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
        $this->request->replace($this
            ->only([
                'lingkar_kepala',
                'lingkar_lengan',
                'asi',
                'kategori_golongan'
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
                /**
                 * here some explanation in regex below:
                 *
                 * 1. /.../ :in start and end is like mandatory to
                 * grouping all regex element inside
                 *
                 * 2. ^ : Begining => match the begining of string or
                 * value, but you can also define begining of a line if
                 * multilne flag(m) enable
                 *
                 * 3. \d : matches any digit character between 0-9 and
                 * with quantifer {1,3} will match from one-digit to
                 * three-digit number, this mandatory for our
                 * lingkar_kepala column, because had 3 digit before
                 * comma
                 *
                 * 4. (...): capturing group multiple tokens together
                 * and creates a capture group for extracting a
                 * substring or using a backreferences
                 *
                 * 5. \. : Escaped character for dot(.) in char code 46
                 *
                 * 6. \d{1,3} : like explanation number 3, but this for
                 * validation precision after comma
                 *
                 * 7. ? : quantifer for matching our captured group in
                 * '()' element that return digit number with dot, this
                 * result with after comma numeric that must between 0-1
                 *
                 * 8. $ : End => matches the end of string or end of a line if the multiline flag(m) is enabled
                 */
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
            ],
            'lingkar_lengan' => [
                'bail',
                'required',
                'numeric',
                /**
                 * you can look explanation regex below in
                 * lingkar_kepala regex, because this has same regex
                 * logic
                 */
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
            ],
            'asi' => [
                'bail',
                'required',
                'string',
                Rule::in(['iya', 'tidak'])
            ],
            'kategori_golongan' => [
                'bail',
                'required',
                'string',
                Rule::in(['bayi', 'balita'])
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
             * costum message for lingkar_kepala column or field input
             */
            'lingkar_kepala.required' => 'lingkar kepala harus di isi!',
            'lingkar_kepala.numeric' => 'lingkar kepala harus angka(decimal atau bulat)!',
            'lingkar_kepala.regex' => 'lingkar kepala maksimal 3 digit di depan koma dan belakang koma',
            /**
             * costum message for lingkar_lengan column or field input
             */
            'lingkar_lengan.required' => 'lingkar lengan harus di isi!',
            'lingkar_lengan.numeric' => 'lingkar lengan harus angka(decimal atau bulat)!',
            'lingkar_lengan.regex' => 'lingkar lengan maksimal 3 digit di depan koma dan belakang koma',
            /**
             * costum message for asi column or field input
             */
            'asi.required' => 'asi harus di isi!',
            'asi.string' => 'asi harus berupa string!',
            'asi.in' => "asi hanya boleh berisi: 'iya' atau 'tidak' saja",
            /**
             * costum message for kategori_golongan column or field input
             */
            'kategori_golongan.required' => 'kategori golongan harus di isi!',
            'kategori_golongan.string' => 'kategori golongan harus berupa string!',
            'kategori_golongan.in' => "kategori golongan hanya boleh berisi: 'bayi' atau 'balita' saja",
        ];
    }
}
