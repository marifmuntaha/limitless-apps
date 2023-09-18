<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashflowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'payment' => $this->payment !== null ?: $this->payments,
            'type' => $this->type,
            'desc' => $this->desc,
            'amount' => $this->amount,
            'method' => $this->methods,
            'created' => Carbon::parse($this->created_at)->translatedFormat('d F Y'),
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('Y-m-d')
        ];
    }
}
