<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->type == 'select'){
            $resource = [
                'value' => $this->id,
                'label' => $this->name
            ];
        }
        else{
            $resource = [
                'id' => $this->id,
                'user' => $this->users,
                'category' => $this->categories,
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'installation' => $this->installation,
                'pppoe_user' => $this->pppoe_user,
                'pppoe_password' => $this->pppoe_password,
                'note' => $this->note,
                'status' => $this->status,
                'register' => Carbon::parse($this->installation)->translatedFormat('d F Y'),
                'lastLogin' => Carbon::parse($this->updated_at)->translatedFormat('d F Y'),
                'since' => Carbon::parse($this->installation)->diff(Carbon::now()),
                'background' => fake()->randomElement(["purple", "info", "danger", "primary", "warning", "success", "pink", "secondary", "blue"])
            ];
            $resource = $request->order ? Arr::set($resource, 'order', OrderResource::collection($this->orders)) : $resource;
            $resource = $request->product ? Arr::set($resource, 'product', $this->orders) : $resource;
            $resource = $request->invoice ? Arr::set($resource, 'invoice', $this->invoices) : $resource;
            $resource = $request->invoice ? Arr::set($resource, 'invoice', $this->invoices) : $resource;
        }
        return $resource;
    }
}
