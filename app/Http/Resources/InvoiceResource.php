<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'number' => $this->number,
            'member' => new MemberResource($this->members),
            'product' => $this->products,
            'desc' => $this->desc,
            'amount' => $this->amount,
            'due' => $this->due,
            'status' => $this->status,
            'subscribe' => $this->subscribe,
            'create' => Carbon::parse($this->created_at)->translatedFormat('Y-m-d')
        ];
    }
}
