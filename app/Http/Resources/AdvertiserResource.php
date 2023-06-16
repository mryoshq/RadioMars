<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\UserResource;

class AdvertiserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, 
            'domain' => $this->domain,
            'firm' => $this->firm, 
            'user' => new UserResource($this->whenLoaded('user')),
            'ads' => AdResource::collection($this->whenLoaded('ads')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
