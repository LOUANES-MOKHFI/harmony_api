<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CampaignRessource;
use DB;
use App\Models\VicidialCampaign;
class CampaignController extends Controller
{
    public function campaigns(){
        $data = [];
        
        $campaigns = DB::table('vicidial_campaigns')->select('campaign_id','campaign_name')->get();
       // return new CampaignRessource($campaigns);
        foreach ( $campaigns as $campaign ) {
            $data[] = [ 
                'campaign_id' => $campaign->campaign_id,
                'campaign_name' => $campaign->campaign_name,
            ];
        }
        
        return response()->json($data);
        //dd($data);
        //return response()->json($campaigns); 
    }
}
