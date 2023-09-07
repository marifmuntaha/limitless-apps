<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role == '1';
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
            'product' => 'required',
            'price' => 'required',
            'cycle' => 'required',
            'due' => 'required',
        ];
    }
    public function attributes(): array
    {
        return [
            'member' => 'Pelanggan',
            'product' => 'Produk',
            'price' => 'Harga',
            'cycle' => 'Siklus Tagihan',
            'due' => 'Jatuh Tempo',
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge(['status' => '1']);
    }
}
