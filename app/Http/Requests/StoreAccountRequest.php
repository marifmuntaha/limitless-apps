<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
            'bank' => 'required',
            'number' => 'required',
            'name' => 'required',
            'desc' => 'nullable'
        ];
    }
    public function attributes(): array
    {
        return [
            'bank' => 'Nama Bank',
            'number' => 'Nomor Rekening',
            'name' => 'Nama Pemilik',
            'desc' => 'Diskripsi'
        ];
    }
}
