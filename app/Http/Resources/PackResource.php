<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class PackResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'period' => $this->period,
            'spots_number' => $this->spots_number,
            'price' => $this->price,
        ];
        
        // Only include the additional details when showing a single pack
        if ($request->route()->named('packs.show')) {
            $data['description'] = $this->description;
            $data['days_of_week'] = $this->days_of_week;
            $data['times_of_day'] = $this->times_of_day;
            $data['availability'] = $this->availability;
        }
        
        return $data;
    }
}