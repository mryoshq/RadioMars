<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackResource extends JsonResource
{
    protected $pack_variation;

    public function __construct($resource, $pack_variation = null)
    {
        parent::__construct($resource);
        $this->pack_variation = $pack_variation -1;
    }

    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'variations' => $this->variations,
        ];
        
        // For the 'ads.show' route, provide details for a specific variation
        if ($this->pack_variation !== null && $request->route()->named('ads.show')) {
            $data['period'] = $this->period[$this->pack_variation];
            $data['spots_number'] = $this->spots_number[$this->pack_variation];
            $data['price'] = $this->price[$this->pack_variation];
            $data['availability'] = $this->availability[$this->pack_variation];
        } 
        // For the 'packs.show' route, provide the entire details
        else if ($request->route()->named('packs.show')) {
            $data['period'] = $this->period;
            $data['spots_number'] = $this->spots_number;
            $data['price'] = $this->price;
            $data['description'] = $this->description;
            $data['days_of_week'] = $this->days_of_week;
            $data['times_of_day'] = $this->times_of_day;
            $data['availability'] = $this->availability;
        }

        return $data;
    }
}
