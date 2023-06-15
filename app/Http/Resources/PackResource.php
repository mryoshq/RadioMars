<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdResource;


class PackResource extends JsonResource
{
  
    public function toArray($request)
    {
        return [
            //'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'spots_number' => $this->spots_number,
            'days_of_week' => $this->days_of_week,
            'times_of_day' => $this->times_of_day,
            'availability' => $this->availability,
            'ads' => AdResource::collection($this->whenLoaded('ads')),
        ];
    }
}
