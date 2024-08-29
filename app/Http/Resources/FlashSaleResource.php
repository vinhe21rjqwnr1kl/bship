<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
//            'flash_sale_details' => FlashSaleDetailResource::collection($this->whenLoaded('flashSaleDetails')),
        ];
    }
}
