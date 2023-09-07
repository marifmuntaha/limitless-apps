<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === '1';
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
            'note' => 'nullable',
        ];
    }

    public function attributes(): array
    {
        return [
            'user' => 'ID Pengguna',
            'name' => 'Nama Lengkap',
            'address' => 'Alamat',
            'installation' => 'Tanggal Pemasangan',
            'note' => 'Catatan',
        ];
    }
    protected function prepareForValidation()
    {
        return $this->merge(['status' => '1']);
    }
}
