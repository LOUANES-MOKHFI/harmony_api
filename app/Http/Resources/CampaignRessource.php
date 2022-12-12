<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignRessource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private $campaign_id;
    private $campaign_name;
    public function toArray($request)
    {
        return [
            'campaign_id' => $this->campaign_id,
            'campaign_name' => $this->campaign_name,
        ];
    }
}
