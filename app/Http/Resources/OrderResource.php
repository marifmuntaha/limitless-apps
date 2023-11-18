<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->exists('member')){
            $resource = [
                'id' => $this->id,
                'member' => $this->members,
                'product' => $this->products,
                'price' => $this->price,
                'cycle' => $this->cycle,
                'due' => $this->due,
                'status' => $this->status,
            ];
        }
        else {
            $resource = [
                'id' => $this->id,
                'product' => $this->products,
                'price' => $this->price,
                'cycle' => $this->cycle,
                'due' => $this->due,
                'status' => $this->status,
            ];
        }
        return $resource;
    }
}
