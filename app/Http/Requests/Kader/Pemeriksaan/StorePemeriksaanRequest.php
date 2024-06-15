<?php

namespace App\Http\Requests\Kader\Pemeriksaan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class StorePemeriksaanRequest extends FormRequest
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
        $routeName = Route::currentRouteName();
        $needles = collect(['bayi', 'lansia']);
        $this->merge([
            'golongan' => $needles->first(function ($needle) use ($routeName) {
                return str_contains($routeName, $needle);
            }),
            'kader_id' => auth()->user()->kaders[0]->kader_id,
        ]);

        $this->request->replace($this->only([
            'kader_id',
            'penduduk_id',
            'golongan',
            'status',
            'tinggi_badan',
            'berat_badan',
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
            'kader_id' => [
                'bail',
                'required',
                'integer',
                'exists:kaders,kader_id'
            ],
            'penduduk_id' => [
                'bail',
                'required',
                'integer',
                'exists:penduduks,penduduk_id'
            ],
            'status' => [
                'bail',
                'required',
                'string',
                Rule::in(['sehat', 'sakit'])
            ],
            'golongan' => [
                'bail',
                'required',
                'string',
                Rule::in(['lansia', 'bayi'])
            ],
            'tinggi_badan' => [
                'bail',
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d{1,3})?$/'
            ],
            'berat_badan' => [
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
             * costum message for penduduk_id column or field input
             */
            'penduduk_id.required' => 'penduduk ID harus di isi!',
            'penduduk_id.integer' => 'penduduk ID harus angka bulat!',
            'penduduk_id.exists' => 'penduduk ID tidak ada!',
            /**
             * costum message for status column or field input
             */
            'status.required' => 'status harus di isi!',
            'status.string' => 'status harus berupa string!',
            'status.in' => "status hanya boleh berisi: 'sehat' atau 'sakit' saja!",
            /**
             * costum message for golongan column or field input
             */
            'golongan.required' => 'golongan harus di isi!',
            'golongan.string' => 'golongan harus berupa string!',
            'golongan.in' => "golongan hanya boleh berisi: 'bayi' atau 'lansia' saja!",
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
}
