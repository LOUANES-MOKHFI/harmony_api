<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VicidialCampaignRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'campaign_id' => $this->campaign_id,
            'campaign_name' => $this->campaign_name,
        ];
    }
}
