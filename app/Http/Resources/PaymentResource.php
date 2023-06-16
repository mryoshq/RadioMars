<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            //'advertiser_id'=> $this->advertiser_id,
            'ad' => new AdResource($this->whenLoaded('ad')),
        ];
    } 
}