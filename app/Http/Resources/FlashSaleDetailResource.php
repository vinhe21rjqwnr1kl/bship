<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'discount_id' => $this->discount_id,
            'type' => $this->type,
            'max_usage' => $this->max_usage,
            'number_user_usage' => $this->number_user_usage,
            'status' => $this->status,
//            'discount' => new DiscountResource($this->whenLoaded('discount')),
        ];
    }
}
