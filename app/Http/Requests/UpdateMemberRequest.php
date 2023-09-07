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
            'note' => 'nullable',
        ];
    }

    public function attributes(): array
    {
        return [
            'user' => 'ID Pengguna',
            'name' => 'Nama Lengkap',
            'address' => 'Alamat',
            'note' => 'Catatan',
        ];
    }
}
