<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCashflowRequest extends FormRequest
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
            'payment' => 'nullable',
            'type' => 'required',
            'desc' => 'required',
            'amount' => 'required',
            'method' => 'required'
        ];
    }
    public function attributes(): array
    {
        return [
            'payment' => 'Pembayaran',
            'type' => 'Jenis Kas',
            'desc' => 'Diskripsi',
            'amount' => 'Jumlah',
            'method' => 'Metode'
        ];
    }
}
