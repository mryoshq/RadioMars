<?php

namespace App\Http\Resources; 

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdvertiserResource;
use App\Http\Resources\PackResource;
use App\Http\Resources\PaymentResource;

class AdResource extends JsonResource
{
 
    public function toArray($request)
    {
        return [ 
            'id' => $this->id,
            'text_content' => $this->text_content, 
            'audio_content' => $this->audio_content,
            'status' => $this->status,
            //'advertiser' => $this->advertiser_id,
            //'advertiser' => new AdvertiserResource($this->whenLoaded('advertiser')),
            'pack' => new PackResource($this->whenLoaded('pack')),
            //'pack' => $this->pack_id,
            'payment' => new PaymentResource($this->whenLoaded('payment')),
        ];
    }
}
