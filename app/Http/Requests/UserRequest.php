<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [

            'name' => ['required', 'string', 'max:100'],

            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'phone' => ['nullable', 'string', 'max:20'],

            'role' => ['required'],

            'is_active' => ['required', 'boolean'],

            'password' => [
                $userId ? 'nullable' : 'required',
                'min:8',
            ],

        ];
    }
}
