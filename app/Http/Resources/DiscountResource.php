<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'title' => $this->title,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'discount_code' => $this->discount_code,
        ];
    }
}
