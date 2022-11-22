<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class StatController extends Controller
{
    /*public function getAgentTimeDetail(){
        $data = [];
        vicidial_agent_visibility_log_archive
        vicidial_timeclock_log_archive
        vicidial_timeclock_log_archive
        vicidial_timeclock_log
        vicidial_agent_visibility_log_table
        vicidial_agent_visibility_log
        vicidial_timeclock_log



        $vicidial_user = DB::table('vicidial_users')->select('user_group')->where('user','66666')->get();


        $log_user_group = DB::table('vicidial_user_groups')->select('allowed_campaigns','admin_viewable_groups','admin_viewable_call_times')->where('user_group',$vicidial_user->user_group)->get();


        $user_group = DB::table('vicidial_user_groups')->select('user_group')->whereIn('user_group',['---ALL---',])->orderBy('user_group')->get();

        $stmt="select $userSQL,sum(login_sec) from ".$timeclock_log_table." where event IN('LOGIN','START') and event_date >= '$query_date_BEGIN' and event_date <= '$query_date_END' $TCuser_group_SQL group by user limit 10000000;";

        $punches_to_print = DB::table('vicidial_timeclock_log')->select('user','sum(login_sec)')->whereIn('event',['LOGIN','START'])->where('event_date','>=',$query_date_BEGIN)->where('event_date','<=',$query_date_END)->groupBy('user')->get();
        return response()->json($data);
    }*/

    public function ExportList(Request $request){
        $data = [];
            if($request->campaign_id == 1000101){
                $list_id = '14112022';
            }else{
                $list_id = '141120221';
            }
        if($request->type == 1){
            
                $lists = DB::table('vicidial_list')->where('vicidial_list.list_id',$list_id)
                ->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
                ->select('vicidial_list.*','custom_'.$list_id.'.*')
                //->where('custom_'.$list_id.'.lead_id','>','1809279')
                //->where('custom_'.$list_id.'.lead_id','<','1819280')
                ->where(DB::raw("(DATE_FORMAT(entry_date,'%Y-%m-%d'))"),$request->date_injection)
                ->get();
        }else{
            $lists = DB::table('vicidial_list')->where('vicidial_list.list_id',$list_id)
            ->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_'.$list_id.'.*')
            ->where('vicidial_list.status','<>','NEW')
            ->where('vicidial_list.user','<>','')
            ->where('vicidial_list.status','<>','INCALL')
            ->where(DB::raw("(DATE_FORMAT(modify_date,'%Y-%m-%d'))"),$request->date)->get();
        }
        
        //$data['lists'] = $lists;
        
        return response()->json($lists);
    }
    public function getUserName(Request $request){
        $agentId = $request->user_id;

        $Agent = DB::table('vicidial_users')->where('user',$agentId)->first();
        if(!$Agent){
            $data['etat'] = 500;
            return response()->json($data);
        }else{
            $data['etat'] = 200;
            $data['full_name'] = $Agent->full_name;
            return response()->json($data);

        }
        
        
    }
    public function getQualifPositive(Request $request){
        $agent = $request->user;
        $date = $request->date;
        $positive = ['DMPDC','DMPDL'];

        $qualifPos = DB::table('vicidial_log')->where(DB::raw("(DATE_FORMAT(call_date,'%Y-%m-%d'))"),$request->date)
                                               ->whereIn('status',$positive)->where('user',$agent)->count();
        return response()->json($qualifPos);
    }

    public function getQualifArgummenter(Request $request){
        $agent = $request->user;
        $date = $request->date;
        $argumenter = ['DM','DMPDC','DMPDL','DL','DLDPD','DLDANC','DLDAYC','DLDAIB',
                'DLDDIB','IND','INDOLD','PA','PAPAC','PAPAL','RA','RAA','RADPT','RADAAS','RAEN','RAPM','RATSNR','RADAS'];

        $qualifArg = DB::table('vicidial_log')->where(DB::raw("(DATE_FORMAT(call_date,'%Y-%m-%d'))"),$request->date)
                                               ->whereIn('status',$argumenter)->where('user',$agent)->count();
        return response()->json($qualifArg);
    }


    
}





