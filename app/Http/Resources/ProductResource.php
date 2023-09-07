<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = [];

        if ($request->type == 'select'){
            $resource = [
                'value' => $this->id,
                'label' => $this->name
            ];
        }
        else {
            $resource = parent::toArray($request);
        }
        return $resource;
    }
}