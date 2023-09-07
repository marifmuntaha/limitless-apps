<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['1', '2']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'member' => 'required',
            'product' => 'nullable',
            'desc' => 'required',
            'amount' => 'required',
            'status' => 'nullable',
            'due' => 'required',
            'note' => 'nullable'
        ];
    }

    public function attributes(): array
    {
        return [
            'member' => 'Pelanggan',
            'product' => 'Produk',
            'desc' => 'Diskripsi',
            'amount' => 'Harga',
            'status' => ' Status',
            'due' => 'Jatuh Tempo',
            'note' => 'Catatan'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'number' => fake()->randomNumber(8),
            'status' => '1',
        ]);
    }


}
