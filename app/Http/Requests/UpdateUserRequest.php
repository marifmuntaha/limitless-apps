<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'nullable|confirmed',
            'password_confirmation' => 'nullable',
            'name' => 'required',
            'image' => 'nullable'
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Alamat Email',
            'phone' => 'Nomor HP',
            'password' => 'Kata Sandi',
            'password_confirmation' => 'Ulangi Sandi',
            'name' => 'Nama Lengkap',
            'image' => 'Gambar'
        ];
    }

    protected function prepareForValidation()
    {

    }
}
