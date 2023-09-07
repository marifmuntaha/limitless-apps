<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'invoice' => 'required',
            'amount' => 'required',
            'method' => 'required',
            'at'    => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'invoice' => 'Tagihan',
            'amount' => 'Jumlah',
            'method' => 'Metode Pembayaran',
            'at'    => 'Tanggal Pembayaran'
        ];
    }
}
