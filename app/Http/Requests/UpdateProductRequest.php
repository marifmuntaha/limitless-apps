<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'code' => 'required',
            'name' => 'required',
            'desc' => 'nullable',
            'price' => 'required|integer',
            'cycle' => 'required',
            'image' => 'nullable'
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'Kode Produk',
            'name' => 'Nama Produk',
            'desc' => 'Diskripsi Produk',
            'price' => 'Harga Produk',
            'cycle' => 'Siklus Tagihan',
            'image' => 'Gambar'
        ];
    }
}
