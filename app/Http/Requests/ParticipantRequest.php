<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | DATA USER
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')
                    ->ignore(
                        $this->route('participant')?->user_id
                    ),
            ],

            'phone' => [
                'nullable',
                'string',
                'min:10',
                'max:20',
                'regex:/^[0-9+\-\s]+$/',
            ],


            /*
            |--------------------------------------------------------------------------
            | DATA PESERTA
            |--------------------------------------------------------------------------
            */

            'nik' => [
                'nullable',
                'digits:16',
            ],

            'gender' => [
                'nullable',
                'in:L,P',
            ],

            'birth_place' => [
                'nullable',
                'string',
                'min:2',
                'max:100',
            ],

            'birth_date' => [
                'nullable',
                'date',
                'date_format:Y-m-d',
                'before_or_equal:today',
                'after_or_equal:1950-01-01',
            ],

            'address' => [
                'nullable',
                'string',
                'min:5',
                'max:1000',
            ],

            'education' => [
                'nullable',
                'string',
                'max:100',
            ],

            'job' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status' => [
                'required',
                'string',
                'max:50',
            ],
        ];
    }


    public function messages(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */

            'name.required' =>
            'Nama wajib diisi.',

            'name.min' =>
            'Nama minimal 2 karakter.',

            'name.max' =>
            'Nama maksimal 100 karakter.',


            'email.required' =>
            'Email wajib diisi.',

            'email.email' =>
            'Format email tidak valid.',

            'email.unique' =>
            'Email tersebut sudah digunakan.',


            'phone.min' =>
            'Nomor telepon minimal 10 digit.',

            'phone.max' =>
            'Nomor telepon maksimal 20 karakter.',

            'phone.regex' =>
            'Nomor telepon hanya boleh berisi angka, spasi, tanda +, dan tanda -.',


            /*
            |--------------------------------------------------------------------------
            | PESERTA
            |--------------------------------------------------------------------------
            */

            'nik.digits' =>
            'NIK harus terdiri dari 16 digit.',


            'gender.in' =>
            'Jenis kelamin harus L atau P.',


            'birth_place.min' =>
            'Tempat lahir minimal 2 karakter.',

            'birth_place.max' =>
            'Tempat lahir maksimal 100 karakter.',


            'birth_date.date' =>
            'Tanggal lahir tidak valid.',

            'birth_date.date_format' =>
            'Format tanggal lahir harus YYYY-MM-DD.',

            'birth_date.before_or_equal' =>
            'Tanggal lahir tidak boleh lebih dari hari ini.',

            'birth_date.after_or_equal' =>
            'Tanggal lahir tidak boleh sebelum 1 Januari 1950.',


            'address.min' =>
            'Alamat minimal 5 karakter.',

            'address.max' =>
            'Alamat maksimal 1000 karakter.',


            'education.max' =>
            'Pendidikan maksimal 100 karakter.',


            'job.max' =>
            'Pekerjaan maksimal 100 karakter.',


            'status.required' =>
            'Status peserta wajib dipilih.',

            'status.max' =>
            'Status maksimal 50 karakter.',
        ];
    }
}
