<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            'user' => 'required',
            'name' => 'required',
            'address' => 'nullable',
            'installation' => 'required',
            'pppoe_user' => 'nullable',
            'pppoe_password' => 'nullable',
            'note' => 'nullable',
            'status' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'user' => 'ID Pengguna',
            'name' => 'Nama Lengkap',
            'address' => 'Alamat',
            'installation' => 'Tanggal Pemasangan',
            'pppoe_user' => 'Nama PPPOE',
            'pppoe_password' => 'Kata Sandi PPPOE',
            'note' => 'Catatan',
            'status' => 'Status'
        ];
    }
}
