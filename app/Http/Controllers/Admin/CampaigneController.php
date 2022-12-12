<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CampaigneController extends Controller
{
    public function get_all_campaigns(){
        $campaigns = DB::table('vicidial_campaigns')->get();
        $data = [];
        if($campaigns){
            $data['etat'] = 200;
            $data['campaigns'] = $campaigns;
            return response()->json($data);
        }else{
            $data['etat'] = 500;
            $data['campaigns'] = [];
            return response()->json($data);
        }
    }
}
