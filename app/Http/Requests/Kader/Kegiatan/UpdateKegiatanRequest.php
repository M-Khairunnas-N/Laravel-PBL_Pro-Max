<?php

namespace App\Http\Requests\Kader\Kegiatan;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKegiatanRequest extends FormRequest
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
            /*'kader_id' => auth()->user()->kaders[0]->kader_id,*/
            'jam_mulai' => Carbon::make($this->input('jam_mulai'))->format('H:i:s'),
        ]);

        $this->request->replace(
            $this->only([
                /*'kader_id',*/
                'nama',
                'tgl_kegiatan',
                'jam_mulai',
                'tempat',
                'kegiatan',
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
            /*'kader_id' => [
                'bail',
                'required',
                'integer',
                'exists:kaders,kader_id',
            ],*/
            'nama' => [
                'bail',
                'required',
                'string',
                'regex:/^[a-zA-Z\s.,!;:?()-]{5,100}$/',
            ],
            'tgl_kegiatan' => [
                'bail',
                'required',
                'date_format:Y-m-d'
            ],
            'jam_mulai' => [
                'bail',
                'required',
                'date_format:H:i:s'
            ],
            'tempat' => [
                'bail',
                'required',
                'string',
                'regex:/^([\w\s\n.,!;:?()-]{5,200})$/',
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
           /* 'kader_id.required' => 'kader ID harus di isi!',
            'kader_id.integer' => 'kader ID harus angka bulat!',
            'kader_id.exists' => 'kader ID tidak ada!',*/
            /**
             * costum message for nama column or field input
             */
            'nama.required' => 'nama harus di isi!',
            'nama.string' => 'nama harus berupa string!',
            'nama.regex' => "nama minimal 5 dan maksimal 100 serta hanya boleh huruf!",
            /**
             * costum message for tgl_kegiatan column or field input
             */
            'tgl_kegiatan.required' => 'tanggal kegiatan harus di isi!',
            'tgl_kegiatan.date_format' => "tanggal kegiatan harus valid dengan format: Tahun-Bulan-Tanggal !",
            /**
             * costum message for jam_mulai column or field input
             */
            'jam_mulai.required' => 'jam mulai harus di isi!',
            'jam_mulai.date_format' => 'jam mulai harus valid dengan format: Jam:Menit:Detik !',
            /**
             * costum message for tempat column or field input
             */
            'tempat.required' => 'tempat harus di isi!',
            'tempat.string' => 'tempat harus berupa string!',
            'tempat.regex' => "tempat minimal 5 dan maksimal 200 huruf serta tidak boleh ada tanda-tanda khusus!",
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
        $oldData = json_decode($this->input('kegiatan'), true);

        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->request->all()))));
    }
}
