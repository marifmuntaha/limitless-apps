<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
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
        return $this->merge([
            'role' => '2',
        ]);
    }
}
