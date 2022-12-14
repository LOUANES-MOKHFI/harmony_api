<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class ActionAgentController extends Controller
{
    
    //// fonction qui récuperer la liste des status
    public function getCampaignStatus(Request $request){
        $data = [];
        $data['statuses'] = DB::table('vicidial_campaign_statuses')->select('status','status_name')->distinct()->where('selectable','Y')->orderBy('status','ASC')->get();
        /*$data = [];
        //return response()->json($request->campaign);
        $data['statuses'] = DB::table('vicidial_campaign_statuses')->select('status','status_name')->distinct()->where('campaign_id',$request->campaign)->where('selectable','Y')->orderBy('status','ASC')->get();*/
        return response()->json($data);
    }

    //// fonction qui récuperer l'historique des appells pour un agent
    public function getCallLogs(Request $request){
        $user = $request->user;
        $server_ip = $request->server_ip;
        $campaign = $request->campaign;

        if($campaign == 1000101){
                $list_id = '14112022';
            }else{
                $list_id = '141120221';
            }

        $vicidial_lists = DB::table('vicidial_lists')->where('campaign_id',$campaign)->get();

        $data['calllogs'] = DB::table('vicidial_log')->where('vicidial_log.user',$user)->where('vicidial_log.campaign_id',$campaign)
            ->join('vicidial_list','vicidial_log.lead_id','=','vicidial_list.lead_id')
            //->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','vicidial_log.*')->orderBy('vicidial_log.call_date','DESC')
            ->limit(250)->get();
            
        return response()->json($data);
        

    }

    //// fonction qui récuperer la liste des rappels pour un agent (callback)
    public function getAgentCallBack(Request $request){
        $user = $request->user;
        $campaign = $request->campaign;
        $server_ip = $request->server_ip;
         $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->where('server_ip',$server_ip)->first();
         if(!empty($liveagent)){
            if($campaign == 1000101){
                $list_id = '14112022';
            }else{
                $list_id = '141120221';
            }
            $data['callbacks'] = DB::table('vicidial_callbacks')->where('vicidial_callbacks.user',$user)->where('vicidial_callbacks.campaign_id',$campaign)->where('vicidial_callbacks.lead_status','CBHOLD')
            ->join('vicidial_list','vicidial_callbacks.lead_id','=','vicidial_list.lead_id')
            //->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','vicidial_callbacks.callback_id','vicidial_callbacks.callback_time')
             ->get();
            $data['etat'] = 200;
            return response()->json($data);
         }else{
            $data['callbacks'] ='';
            $data['etat'] = 500;
            return response()->json($data);
         }  
    }
    //// fonction qui change le status (PAUSED, READY)
    public function PauseReady(Request $request){
            $username = $request->user ;
            $pass = $request->pass;
            $server_ip = $request->server_ip;
            //$agent_log = $request->agent_log;
            $stage = $request->stage;
            $agent_log_id = $request->agent_log_id;
            //$dial_method = 'RATIO';
            $campaign = $request->campaign;
            $comments = $request->comments;
            $VDRP_stage = $request->VDRP_stage;
            $AutoDialReady = $request->AutoDialReady;
            $AutoDialWaiting = $request->AutoDialWaiting;
            $session_name = $request->session_name;
            $campaignInfo = DB::table('vicidial_campaigns')->where('campaign_id',$campaign)->first();
            $dial_method = $campaignInfo->dial_method;
            $qm_extension = $request->extension;
            $auto_dial_level = $campaignInfo->auto_dial_level;
            if($VDRP_stage == 'PAUSED'){
                $agent_log = '';
            }else{
                $agent_log = 'NEW_ID'; 
            }
            $http = new \GuzzleHttp\Client(); 
            $response1 = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'user' => $username,
                    'pass' => $pass,
                    'server_ip' => $server_ip,
                    'agent_log' => $agent_log,
                    'stage' => $stage,
                    'agent_log_id' => $agent_log_id,
                    'session_name' => $session_name,
                    'dial_method' => $dial_method,
                    'comments' => $comments,
                    'campaign' => $campaign,
                    'wrapup'   => 'WRAPUP',
                    'VDRP_stage' => $VDRP_stage,
                    'AutoDialReady' => $AutoDialReady,
                    'AutoDialWaiting' => $AutoDialWaiting,
                    'auto_dial_level' => $auto_dial_level,
                    'qm_extension' => $qm_extension,
                    'ACTION'     => $request->action,
                ],
            ]);
        
        return response()->json($response1->getBody()->getContents());
    }
    //// fonction qui récuperer la liste des channel live pour un agent 
    public function getChannelLive(Request $request){

        //SELECT channel FROM live_channels where server_ip = '$server_ip' and extension = '$conf_exten';
        $channels = DB::table('live_sip_channels')->where('server_ip',$request->server_ip)->where('extension',$request->conf_exten)->get();

        $data = [];
        $data['etat'] = 200;
        $data['channels'] = $channels;
        return response()->json($data);
    }

    //// fonction qui refresh le random_id in vicidial_live_agent chaque 1 second
    public function refreshIncall(Request $request){
        $user = $request->user;
        $server_ip = $request->server_ip;

        $random = (rand(1000000, 9999999) + 10000000);
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->where('server_ip',$server_ip)->update([
                'random_id'=>$random
            ]);
        $data['etat'] = 200; 
        return response()->json($data);
    }
    //// fonction qui récuperer channel de l'appel pour un agent
    public function getChannel(Request $request){
        $user = $request->user;
        $server_ip = $request->server_ip;

        $random = (rand(1000000, 9999999) + 10000000);
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->where('server_ip',$server_ip)->update([
                'random_id'=>$random
            ]);
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->where('server_ip',$server_ip)->first();
        if($liveagent->lead_id > 0){
            $data['msg'] = 'lead affecter';
            $data['etat'] = 200; 
            $data['channel'] = $liveagent->channel;
            $data['lead_id'] = $liveagent->lead_id;
            $http = new \GuzzleHttp\Client(); 
            //$responseRecord = $http->post('https://call3.harmoniecrm.com/agc/api.php?source=test&user=6666&pass=0551797726&agent_user='.$user.'&function=audio_playback&value=ss-noservice&stage=PLAY&dial_override=Y'); 
            return response()->json($data);

        }else{
            $data['msg'] = 'aucun lead affecter';
            $data['etat'] = 201;
            $data['channel'] = '';
            $data['lead_id'] = 0;

            return response()->json($data);
        }

    }
    //// change status to incall for agent
    public function ChangeIncall(Request $request){
        $server_ip = $request->server_ip;
        $session_name = $request->session_name;
        $user = $request->user ;
        $pass = $request->pass;
        $orig_pass = $request->pass;
        
        $campaign = $request->campaign;
        $phone_login  = $request->phone_login;
        $phone_pass = $request->phone_pass;
        
        $agent_log_id = $request->agent_log_id;
        $userLogged = DB::table('vicidial_users')->where('user',$user)->where('active','Y')->first();
        $LOGemail = $userLogged->email != '' ? $userLogged->email : '';
        $agent_email = $LOGemail;
        $conf_exten = $request->conf_exten;
        $campaignInfo = DB::table('vicidial_campaigns')->where('campaign_id',$campaign)->first();
        $camp_script = $campaignInfo->campaign_script != '' ? $campaignInfo->campaign_script.'' : '';
        $in_script = '';//$request->CalL_ScripT_id;
        $customer_server_ip = '';//$request->lastcustserverip;
        $exten = $request->extension;
        $original_phone_login = $request->phone_login;
        $VDRP_stage = '';
        $previous_agent_log_id = $request->agent_log_id;
        $action = 'VDADcheckINCOMING';
        $http = new \GuzzleHttp\Client(); 
        $response1 = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
            'form_params' => [
                'server_ip'         => $server_ip,
                'session_name'      => $session_name,
                'user'              => $user,
                'pass'              => $pass,
                'orig_pass'         => $orig_pass,
                'campaign'          => $campaign,
                'ACTION'            => $action,
                'agent_log_id'      => $agent_log_id,
                'phone_login'       => $phone_login,
                'agent_email'       => $LOGemail,
                'conf_exten'        => $conf_exten,
                'camp_script'       => $camp_script,
                'in_script'         => $in_script,
                'customer_server_ip'=> $customer_server_ip,
                'exten'             => $exten,
                'original_phone_login'=> $original_phone_login,
                'phone_pass'        => $phone_pass,
                'VDRP_stage'        => $VDRP_stage,
                'previous_agent_log_id'=> $previous_agent_log_id
            ],
        ]);
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->where('server_ip',$server_ip)->first();

        if($response1->getStatusCode() == 200 && $liveagent->lead_id>0){
            
            $princ_list = DB::table('vicidial_list')->where('lead_id',$liveagent->lead_id)->first();

            $list_id = $princ_list->list_id;
            $called_count = $princ_list->called_count;
            $table = 'custom_'.$list_id;
            //return response()->json($list_id);
            $list = DB::table($table)
                        ->where($table.'.lead_id',$liveagent->lead_id)->first();
            //return response()->json($list);
            /*if($campaign == '1000101'){
                $list = DB::table('vicidial_list')->where('vicidial_list.list_id','14112022')
                ->join('custom_14112022','custom_14112022.lead_id','=','vicidial_list.lead_id')
                ->select('vicidial_list.*','custom_14112022.*')
                ->where('vicidial_list.lead_id',$liveagent->lead_id)->first();
                 $list = DB::table('custom_14112022')->where('custom_14112022.list_id','14112022')
                ->select('custom_14112022.*')
                ->where('vicidial_list.lead_id',$liveagent->lead_id)->first();
            }elseif($campaign == '2000202'){
                $list = DB::table('vicidial_list')->where('vicidial_list.list_id','141120221')
                ->join('custom_141120221','custom_141120221.lead_id','=','vicidial_list.lead_id')
                ->select('vicidial_list.*','custom_141120221.*')
                ->where('vicidial_list.lead_id',$liveagent->lead_id)->first();
            }*/
            
            //return response()->json($list);
            $phone = DB::table('phones')->where('login', $request->phone_login)
                                    ->where('pass', $request->phone_pass)
                                    ->where('active','Y')->first();
            $ext_context = $phone->ext_context;
            $conf_silent_prefix = '5';
            $channelrec = "Local/".$conf_silent_prefix.$conf_exten.'@'.$ext_context;
            
            $LiveSipChannel = DB::table('live_sip_channels')->where('server_ip',$request->server_ip)->where('extension',$request->conf_exten)->where('channel','LIKE','SIP/'.$user.'%')->first();
            //return $liveagent->channel;
            $data['agentchannel'] = $channelrec = "Local/".$conf_silent_prefix.$conf_exten.'@'.$ext_context;
            //$liveagent->channel;
            $data['id_total'] = $list->id_total;
            $data['list_id'] = $list_id;
            $data['called_count'] = $called_count;
            $data['uniqueid'] = $liveagent->uniqueid;
            $data['lead_id'] = $liveagent->lead_id;
            //$data['gender'] = $list->gender;
            $data['adr1_civilite_abrv'] = $list->adr1_civilite_abrv;
            $data['contact_nom'] = $list->contact_nom;
            $data['contact_prenom'] = $list->contact_prenom;
            
            
            $data['adr2'] = $list->adr2;
            $data['adr3'] = $list->adr3;
            $data['adr4_libelle_voie'] = $list->adr4_libelle_voie;
            $data['adr5'] = $list->adr5;
            $data['contact_cp'] = $list->contact_cp;
            $data['contact_ville'] = $list->contact_ville;
            $data['contact_tel'] = $list->contact_tel;
            $data['contact_email'] = $list->contact_email;
            ////// new 
                 $data['new_adr1_civilite_abrv'] = $list->new_adr1_civilite_abrv;
                 $data['new_contact_prenom'] = $list->new_contact_prenom;
                 $data['new_contact_nom'] = $list->new_contact_nom;
                 $data['new_raison_sociale'] = $list->new_raison_sociale;
                 $data['new_professionnel'] = $list->new_professionnel;
                 $data['new_activite1'] = $list->new_activite1;
                 $data['new_adr2'] = $list->new_adr2;
                 $data['new_adr3'] = $list->new_adr3;
                 $data['new_adr4_libelle_voie'] = $list->new_adr4_libelle_voie;
                 $data['new_adr5'] = $list->new_adr5;
                 $data['new_contact_cp'] = $list->new_contact_cp;
                 $data['new_contact_ville'] = $list->new_contact_ville;
                 $data['new_contact_tel'] = $list->new_contact_tel;
                 $data['new_contact_tel_port'] = $list->new_contact_tel_port;
                 $data['new_contact_email'] = $list->new_contact_email;
                 $data['new_tel2'] = $list->new_tel2;

            if($campaign == 1000101){
                 $data['tel1'] = $list->tel1;
                $data['commentaire'] = $list->commentaire;
                $data['raison_sociale'] = $list->raison_sociale;
                $data['professionnel'] = $list->professionnel;
            }elseif($campaign == 2000202){
                $data['Commentaire_call1'] = $list->Commentaire_call1;
                $data['contact_qualif1'] = $list->contact_qualif1;
                $data['contact_qualif2'] = $list->contact_qualif2;
                $data['accord_montant'] = $list->accord_montant;
                //$data['pa_montant'] = $list->pa_montant;
                //$data['frequence_pa'] = $list->frequence_pa;
                //$data['accord_montant'] = $list->accord_montant;
                $data['AcceuilTELEPHONE_PORTABLE'] = $list->AcceuilTELEPHONE_PORTABLE;
            }
            elseif($campaign == 3000303){
                $data['pa_montant'] = $list->pa_montant;
                $data['frequence_pa'] = $list->frequence_pa;
            }
            $data['etat'] = 200;
            $data['msg'] = 'success';
            return response()->json($data);
            
        }else{
            $data['etat'] = 401;
            $data['msg']  = "Erreur de serveur, on a pas pu récuperer la fiche de client"; 
            return response()->json($data);
        }
                
    }

    //// fonction qui récuperer le status de l'agent
    public function getStatus(Request $request){
        $user = $request->user;
        $agent = DB::table('vicidial_live_agents')->where('user',$user)->first();
        if($agent){
            $data['status'] = $agent->status;
            $data['etat'] = 200;
            $data['msg'] = "success, Vous etes connectee";
            return response()->json($data);
        }else{
            $data['etat'] = 500;
            $data['msg']  = "Erreur, Vous n'etes pas connectee";
            return response()->json($data);
        }
    }

    //// fonction qui couper l'appel par l'agent (hangup)
    public function hangup(Request $request){

        $username = $request->user;
         

        $pass = $request->pass;
        $server_ip = $request->server_ip;
        $lead_id = $request->lead_id;
        $list_id = $request->list_id;
        //$stage = $request->stage;
        $agent_log_id = $request->agent_log_id;/////
        //$dial_method = 'RATIO';
        $campaign = $request->campaign;
        //$comments = $request->comments;
        //$VDRP_stage = $request->VDRP_stage;
        //$AutoDialReady = $request->AutoDialReady;
        //$AutoDialWaiting = $request->AutoDialWaiting;
        $session_name = $request->session_name;////////
        $session_id = $request->conf_exten;////////
        $campaignInfo = DB::table('vicidial_campaigns')->where('campaign_id',$campaign)->first();
        $camp_script = $campaignInfo->campaign_script != '' ? $campaignInfo->campaign_script.'' : '';
        $dial_method = $campaignInfo->dial_method;
        $qm_extension = $request->extension;
        $auto_dial_level = $campaignInfo->auto_dial_level;
        $user_abb = $username.$username.$username.$username;
        $user_abb = preg_replace("/^\./i","",$user_abb);
        $epoch_sec = date("U");
        $channel = $request->channel;
        $queryCID = 'HLvdcW'.$epoch_sec.$user_abb;
        $phone_login  = $request->phone_login;//////
        $phone_pass = $request->phone_pass;///////
        $customer_server_ip = '';
        $exten = $request->extension;///////
        //$original_phone_login = $request->phone_login;
        $userLogged = DB::table('vicidial_users')->where('user',$username)->where('active','Y')->first();
        $LOGemail = $userLogged->email != '' ? $userLogged->email : '';
        $in_script = '';
        /////////////change to paused
        //return 'rfg'; 
        $phone = DB::table('phones')->where('login',$phone_login)
                                    ->where('pass',$phone_pass)
                                    ->where('active','Y')->first();
        $taskMDstage = 'end';
        $conf_silent_prefix = '5';
        $ext_context = $phone->ext_context;
        $recording_exten = $phone->recording_exten;
        $VDstop_rec_after_each_call = $phone->VDstop_rec_after_each_call;
        $protocol = $phone->protocol;
        $LasTCID = '';
        $inOUT = 'OUT';
        $dialed_label = '';
        $agentchannel = $request->agentchannel;
        $conf_dialed = 0;
        $leaving_threeway = 0;
        $hangup_all_non_reserved= '1';
        $blind_transfer = 0;
        $nodeletevdac = '';
        $alt_num_status = 1;
        $leave_3way_start_recording_triggerCALL = 1;
        $leave_3way_start_recording_filename = '';
        $channelrec = "Local/".$conf_silent_prefix.$session_id.'@'.$ext_context;
        $called_count = $request->called_count; 
        $uniqueid = $request->uniqueid;
        $uniqueid1 = $request->uniqueid1;
        $phone_number = $request->phone_number;
        $phone_code = $request->phone_code;
        
        $http1 = new \GuzzleHttp\Client(); 
       /* $queryCID1 = "HTvdcW".$epoch_sec.$user_abb;
        $response = $http1->post('https://call3.harmoniecrm.com/agc/manager_send.php', [
            'form_params' => [
                'user' => $username,
                'pass' => $pass,
                'server_ip' => $server_ip,
                'queryCID' => $queryCID1,
                'session_name' => $session_name,
                'log_campaign' => $campaign,
                'qm_extension' => $qm_extension,
                'ext_context'      => $ext_context,
                'exten'        => $conf_silent_prefix.$session_id,
                'format'       =>'text',
                'ACTION'       => 'HangupConfDial'
            ],
        ]);*/

        //return response()->json($response->getbody()->getcontents());
        $response1 = $http1->post('https://call3.harmoniecrm.com/agc/manager_send.php', [
            'form_params' => [
                'user' => $username,
                'pass' => $pass,
                'server_ip' => $server_ip,
                'queryCID' => $queryCID,
                'session_name' => $session_name,
                'log_campaign' => $campaign,
                'qm_extension' => $qm_extension,
                'channel'      => $channel,
                //'auto_dial_level'=> $auto_dial_level,
                //'call_server_ip' => $server_ip,
                //'secondS'      => 0,
                //'CalLCID'      =>$CalLCID, ////////////////////////////////////////////////////// a refaire
                //'stage'        => 'CALLHANGUP',
                //'nodeletevdac' => 0,
                //'campaign'     => $campaign,
                //'exten'        => $session_id,
                'format'       =>'text',
                'ACTION'       => 'Hangup'
            ],
        ]);
        $LiveSipChannel = DB::table('live_sip_channels')->where('server_ip',$server_ip)->where('extension',$session_id)->where('channel','LIKE','SIP/'.$username.'%')->first();
        $http2 = new \GuzzleHttp\Client(); 
        $response2 = $http2->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
            'form_params' => [
                'server_ip' => $server_ip,
                'session_name' => $session_name,
                'stage'        => $taskMDstage,
                'uniqueid'     => $uniqueid == 0 ? $uniqueid1 : $uniqueid,
                'user' => $username,
                'pass' => $pass,
                'campaign'    => $campaign,
                'lead_id'     => $lead_id,
                'list_id'     => $list_id,
                'length_in_sec'=> 0,
                'phone_code'   => $phone_code,
                'phone_number' => $phone_number,
                'exten'        => $recording_exten,
                'channel'      => $LiveSipChannel->channel,
                'start_epoch'  => 0,
                'auto_dial_level'=> $auto_dial_level,
                'VDstop_rec_after_each_call'=> $VDstop_rec_after_each_call,
                'conf_silent_prefix'=> $conf_silent_prefix,
                'protocol'   => $protocol,
                'extension'  => $exten,
                'ext_context'=> $ext_context,
                'conf_exten' => $session_id,
                'user_abb'   => $user_abb,
                'agent_log_id' => $agent_log_id,
                'MDnextCID' => $LasTCID,
                'inOUT' => $inOUT,
                'alt_dial' => $dialed_label,
                'DB'       => 0,
                'agentchannel' => $LiveSipChannel->channel,
                'conf_dialed' => $conf_dialed,
                'leaving_threeway' => $leaving_threeway,
                'hangup_all_non_reserved' => $hangup_all_non_reserved,
                'blind_transfer' => $blind_transfer,
                'dial_method' => $dial_method,
                'nodeletevdac' => $nodeletevdac,
                'alt_num_status' => $alt_num_status,
                'qm_extension' => $qm_extension,
                'called_count' => $called_count,
                'leave_3way_start_recording_trigger' => $leave_3way_start_recording_triggerCALL,
                'leave_3way_start_recording_filename' => $leave_3way_start_recording_filename,
                'channelrec' => $channelrec,
                'format'       =>'text',
                'ACTION'       => 'manDiaLlogCaLL'
            ],
        ]);
        //return response()->json($response2->getbody()->getcontents());
        //SELECT recording_id,start_epoch,filename FROM recording_log where $rec_searchSQL order by start_epoch desc;"
        $recording = DB::table('recording_log')->select('user','start_epoch','filename')->where('user',$username)->orderBy('start_epoch','DESC')->first();
        $channelrec1 = "Local/".$conf_silent_prefix.$session_id."@".$ext_context;
        //return response()->json($recording);  

        $response = $http1->post('https://call3.harmoniecrm.com/agc/manager_send.php', [
            'form_params' => [
                'user' => $username,
                'pass' => $pass,
                'server_ip' => $server_ip,
                'queryCID' => $queryCID,
                'session_name' => $session_name,
                'channel'      => $channelrec1,
                'filename'     => $recording->filename,
                'lead_id'     => $lead_id,
                'ext_priority'=> '1',
                'FROMvdc'     => 'Y',
                'FROMapi'     => '1',
                'uniqueid'     => $uniqueid,
                'ext_context'      => $ext_context,
                'exten'        => $recording_exten,//$conf_silent_prefix.$session_id,
                'format'       =>'text',
                'ACTION'       => 'StopMonitor'
            ],
        ]);   
            $data['contents'] = $response1->getBody()->getContents();
            if(str_contains($data['contents'],'Hangup command sent for Channel')){

                $data['etat'] = 200;
                $data['statuses'] = DB::table('vicidial_campaign_statuses')->select('status','status_name')->distinct()->where('selectable','Y')->orderBy('status','ASC')->get();

            }
            
        return response()->json($data);
    }

    //// fonction qui modifier le status de la fiche (Qualification)
    public function UpdateDispo(Request $request)
    {
            $username = $request->user;
            $pass = $request->pass;
            $server_ip = $request->server_ip;
           
            $stage = $request->stage;
            $agent_log_id = $request->agent_log_id;
            $campaign = $request->campaign;
            //$comments = $request->comments;            
            $session_name = $request->session_name;
            $session_id = $request->conf_exten;
            $campaignInfo = DB::table('vicidial_campaigns')->where('campaign_id',$campaign)->first();
            $camp_script = $campaignInfo->campaign_script != '' ? $campaignInfo->campaign_script.'' : '';
            $dial_method = $campaignInfo->dial_method;
            $auto_dial_level = $campaignInfo->auto_dial_level;
            $phone_login  = $request->phone_login;
            $phone_pass = $request->phone_pass;
            $customer_server_ip = '';
            $exten = $request->extension;
            $original_phone_login = $request->phone_login;
            $userLogged = DB::table('vicidial_users')->where('user',$username)->where('active','Y')->first();
            $LOGemail = $userLogged->email != '' ? $userLogged->email : '';
            $in_script = '';
            $lead_id = $request->lead_id; ////////
            $VU_user_group = $userLogged->user_group;
            $dispo_choice = $request->dispo_choice; ////// choice qualif
            $list_id = $request->list_id;
            $CallBackDatETimE = $request->CallBackDatETimE == null ? '' : $request->CallBackDatETimE;/////
            $CallBackrecipient = $request->CallBackrecipient;
            $use_internal_dnc = $campaignInfo->use_internal_dnc;
            $use_campaign_dnc = $campaignInfo->use_campaign_dnc;
            $LasTCID = '';
            $vtiger_callback_id = 0;
            $phone_number = $request->phone_number;
            $phone_code = $request->phone_code;
            $uniqueid = $request->uniqueid;
            $uniqueid1 = $request->uniqueid1;
            $CallBackLeadStatus = $request->CallBackLeadStatus;
            $comments = $request->comments == null ? '' : $request->comments;////////
            $custom_field_names = '';
            $call_notes = '';
            $dispo_comments = '';
            $cbcomment_comments = '';
            $qm_dispo_code = '';
            $system_settings = DB::table('system_settings')->get()[0];
            $email_enabled = $system_settings->allow_emails;
            $recording = DB::table('routing_initiated_recordings')->select('recording_id','filename','launch_time')->where('user',$username)->where('processed',0)->orderBy('launch_time','DESC')->first();
            //return response()->json($recording);
            $VDDCU_recording_id = $recording->recording_id;
            $recording_filename = $recording->filename;
            $callback_gmt_offset = '';
            $callback_timezone = '';
            $customer_sec = '';
            $parked_hangup = '0';
            $MDnextCID = '';
            $called_count = $request->called_count;
            $http = new \GuzzleHttp\Client(); 
            $response3 = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'server_ip' => $server_ip,
                    'session_name' => $session_name,
                    'user' => $username,
                    'pass' => $pass,
                    'orig_pass' => $pass,
                    'lead_id'      => $lead_id,
                    'stage'           => $lead_id,
                    'phone_number'    => $phone_number, 
                    'campaign'        => $campaign,
                    'agent_log_id'    => $agent_log_id,
                    'conf_exten'        => $session_id,
                    'user_group'        => $VU_user_group,
                    'ACTION'       => 'LeaDSearcHSelecTUpdatE'
                ],
            ]);
            $response2 = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'server_ip' => $server_ip,
                    'session_name' => $session_name,
                    'user' => $username,
                    'pass' => $pass,
                    'orig_pass' => $pass,
                    'dispo_choice' => $dispo_choice,
                    'lead_id'      => $lead_id,
                    'campaign' => $campaign,
                    'auto_dial_level' => $auto_dial_level,
                    'agent_log_id'    => $agent_log_id,
                    'CallBackDatETimE'=> $CallBackDatETimE,
                    'list_id'         => $list_id,
                    'recipient'       => $CallBackrecipient,
                    'use_internal_dnc'=> $use_internal_dnc,
                    'use_campaign_dnc'=> $use_campaign_dnc,
                    'MDnextCID'       => $MDnextCID,
                    'stage'           => 'end', 
                    'vtiger_callback_id'=> $vtiger_callback_id,
                    'phone_number'    => $phone_number,
                    'phone_code'      => $phone_code, 
                    'dial_method'     => $dial_method,
                    'uniqueid'     => $uniqueid == 0 ? $uniqueid1 : $uniqueid , 
                    'CallBackLeadStatus' => $CallBackLeadStatus,
                    'comments'        => $comments,
                    'custom_field_names'=> $custom_field_names,
                    'call_notes'      => $call_notes,
                    'dispo_comments'  => $dispo_comments,
                    'cbcomment_comments'=> $cbcomment_comments,
                    'qm_dispo_code'   => $qm_dispo_code,
                    'email_enabled'   => $email_enabled,
                    'recording_id'    => $VDDCU_recording_id,
                    'recording_filename' => $recording_filename,
                    'called_count'    => $called_count,
                    'parked_hangup'   => $parked_hangup,
                    'phone_login'     => $phone_login,///
                    'agent_email'     => $LOGemail,
                    'conf_exten'        => $session_id,
                    'camp_script'       => $camp_script,
                    'in_script'         => $in_script,
                    'customer_server_ip'=> $customer_server_ip,
                    'exten'             => $exten,
                    'original_phone_login'=> $phone_login,
                    'phone_pass'        => $phone_pass,
                    'callback_gmt_offset' => $callback_gmt_offset,
                    'callback_timezone'      => $callback_timezone,
                    'customer_sec'=> $customer_sec,
                    'call_server_ip' => '',
                    'format'       =>'text',
                    'ACTION'       => 'updateDISPO'
                ],
            ]);
            //return response()->json($response2->getBody()->getContents());

            
            
            //return response()->json($response3->getBody()->getContents());
            $content = $response2->getBody()->getContents();
            //return response()->json($content);
            if(str_contains($content,'Lead '.$lead_id.' has been changed to '.$dispo_choice.' Status') && $response2->getStatusCode() == 200){
                $data['dispo_choice'] = $dispo_choice;
                $data['etat'] = 200;
                return response()->json($data);
            }else{
                $data['etat'] = 500;
                return response()->json($data);
            }
            
    }
    public function updateQualifContact(Request $request){
        $user = $request->user;
        $list_id = $request->list_id;
        $lead_id = $request->lead_id;
        $campaign = $request->campaign;
        $dispo_choice = $request->dispo_choice;
        $list = DB::table('vicidial_list')->where('lead_id',$lead_id)->where('list_id',$list_id)->where('user',$user)
            ->update([
                'status' => $dispo_choice,
            ]);
        $list = DB::table('vicidial_log')->where('lead_id',$lead_id)->where('list_id',$list_id)->where('user',$user)->where('campaign_id',$campaign)
            ->update([
                'status' => $dispo_choice,
            ]);
        $data = [];
        $data['etat'] = 200;
        $data['msg'] = 'La Fiche a était requalifiée avec succes';
        return response()->json($data);

    }
    


    //// fonction qui activer le webphone apres 5 sec de l'actualisation de la page ou lors de clique sur button webphone
    public function activateWebphone(Request $request){
        $http = new \GuzzleHttp\Client();
        $responseWebPhone = $http->post('https://call3.harmoniecrm.com/agc/api.php?source=test&user=6666&pass=0551797726&agent_user='.$request->user.'&function=call_agent&value=CALL');
        return response()->json(['etat'=>200]);
    }

    //// fonction qui récuperer les information d'un fiche a partir de lead_id
    public function getLeadInfo(Request $request){
        $user = $request->user;
        $lead_id = $request->lead_id;
        $campaign = $request->campaign;
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->first();
        if(!empty($liveagent)){
            /*if($campaign == 1000101){
                $list_id = '14112022';
            }else{
                $list_id = '141120221';
            }*/

            /*$data['lead'] = DB::table('vicidial_list')->where('vicidial_list.user',$user)->where('vicidial_list.lead_id',$lead_id)
            ->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_'.$list_id.'.*')->first();*/

            
            $list = DB::table('vicidial_list')->where('vicidial_list.user',$user)
                                              ->where('vicidial_list.lead_id',$lead_id)->first();
            if(!$list){
                $data['lead'] ='';
                $data['etat'] = 500;
                return response()->json($data);
            }else{
                $list_id = $list->list_id;
                //$called_count = $list->called_count;
                $table = 'custom_'.$list_id;
                //return response()->json($list_id);
                $data['lead'] = DB::table($table)->where($table.'.lead_id',$lead_id)->first();
                //return response()->json($data);
                $vicidial_log = DB::table('vicidial_log')->select('uniqueid')->where('lead_id',$lead_id)->where('list_id',$list_id)->where('user',$user)->first();


                $data['uniqueid'] = $vicidial_log->uniqueid;
                $data['etat'] = 200;
                return response()->json($data);
            }
        }else{
            $data['lead'] ='';
            $data['etat'] = 500;
            return response()->json($data);
        }  
    }

    //// fonction qui récuperer les information d'un fiche a partir de phone_number
    public function getPhoneInfo(Request $request){
        $user = $request->user;
        $phone_number = $request->phone_number;
        $campaign = $request->campaign;
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->first();
        if(!empty($liveagent)){
            /*if($campaign == 1000101){
                $list_id = '14112022';
            }else{
                $list_id = '141120221';
            }*/
            /*$data['lead'] = DB::table('vicidial_list')->where('vicidial_list.phone_number',$phone_number)
            ->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_'.$list_id.'.*')->first();*/

            $list = DB::table('vicidial_list')->where('vicidial_list.phone_number',$phone_number)
                                              ->first();
            $list_id = $list->list_id;
            //$called_count = $list->called_count;
            $table = 'custom_'.$list_id;
            //return response()->json($list_id);
            $data['lead'] = DB::table($table)->where($table.'.lead_id',$list->lead_id)->first();

            $vicidial_log = DB::table('vicidial_log')->select('uniqueid')->where('lead_id',$list->lead_id)->where('list_id',$list_id)->where('user',$user)->first();

            $data['uniqueid'] = $vicidial_log->uniqueid;
            $data['etat'] = 200;
            return response()->json($data);
        }else{
            $data['lead'] ='';
            $data['etat'] = 500;
            return response()->json($data);
        }  
    }

    ////modification des informations pour une fiche et inserer les nouvelles informations 
    public function updateLeadInfo(Request $request){
        
        $data = [];
        
        $lead_id = $request->lead_id;
        $list = DB::table('vicidial_list')->where('lead_id',$lead_id)
                                              ->first();

        if(!empty($list)){
            $list_id = $list->list_id;
            $table = 'custom_'.$list_id;
            //return response()->json($list_custom = DB::table($table)->where($table.'.lead_id',$lead_id)->first());
            $list_custom = DB::table($table)->where($table.'.lead_id',$lead_id)->update([
                'new_contact_nom' => $request->new_contact_nom,
                'new_contact_prenom' => $request->new_contact_prenom,
                'new_RAISON_SOCIALE' => $request->new_raison_sociale,
                'new_professionnel' => $request->new_professionnel,
                'new_adr2' => $request->new_adr2,
                'new_adr3' => $request->new_adr3,
                'new_adr4_libelle_voie' => $request->new_adr4_libelle_voie,
                'new_adr1_civilite_abrv' => $request->new_adr1_civilite_abrv,
                //'new_adr5' => $request->new_adr5,
                'new_contact_cp' => $request->new_contact_cp,
                'new_contact_ville' => $request->new_contact_ville,
                'new_contact_tel' => $request->new_contact_tel,
                'contact_tel1' => $request->new_tel1,
                'new_contact_email' => $request->new_contact_email,
                'commentaire' => $request->commentaire,
                //'Commentaire_call1' => $request->commentaire,
                'cas_particulier' => $request->cas_particulier,
                //'type_accord' => $request->type_accord,
                //'envoi_courrier' => $request->envoi_courrier,
                'accord_montant' => $request->montant_don,
                'pa_montant' => $request->pa_montant,
                'frequence_pa' => $request->frequence_pa,
                
            ]);

            $list_principal = DB::table('vicidial_list')->where('vicidial_list.lead_id',$lead_id)->update([
                'comments' => $request->commentaire,
            ]);

            $data['etat'] = 200;
            //$data['list'] = $list;
            return response()->json($data);
        }else{
            $data['etat'] = 500;
            return response()->json($data);
        }
    }
    
    /////// recuperer le temps d'appel de  l'agent (status == Incall)
    public function getTimeIncall(Request $request){
        $user = $request->user;
        $lead_id = $request->lead_id;
        if($lead_id == null){
            $live_agent = DB::table('vicidial_live_agents')->where('user',$user)->first();
            $last_call = $live_agent->last_state_change;
        
            $date2 = date("H:i:s", strtotime($last_call));
            
            return response()->json($date2);
        }else{
            $live_agent = DB::table('vicidial_live_agents')->where('user',$user)->where('lead_id',$lead_id)->first();
            $last_call = $live_agent->last_state_change;
        
            $date2 = date("H:i:s", strtotime($last_call));
            
            return response()->json($date2);
        }
        
        
    }
    //// Function who implement a Manualdial with a phone number
    public function ManualDial(Request $request){
        $server_ip = $request->server_ip; ///sesssion
        $session_name = $request->session_name; ///sesssion
        $conf_exten = $request->conf_exten; ///sesssion
        $user = $request->user; ///sesssion
        $pass = $request->pass; ///sesssion
        $phone_login = $request->phone_login; ///sesssion
        $phone_pass = $request->phone_pass; ///sesssion
        $campaign = $request->campaign; //// session
        $phone_number = $request->phone_number; ///  view 
        $phone_code = $request->phone_code; //// view
        
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->first();
        //return response()->json($liveagent);
        if(!empty($liveagent)){
            /*if($campaign == 1000101){
                $list_id = '14112022';
            }else{
                $list_id = '141120221';
            }
            $data['lead'] = DB::table('vicidial_list')->where('vicidial_list.phone_number',$phone_number)
            ->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_'.$list_id.'.*')->first();
            //return response()->json($data['lead']);*/
            //$vicidial_log = DB::table('vicidial_log')->select('uniqueid')->where('lead_id',$data['lead']->lead_id)->where('list_id',$data['lead']->list_id)->where('user',$user)->first();


            $list = DB::table('vicidial_list')->where('phone_number',$phone_number)->first();
            $vicidial_log = DB::table('vicidial_log')->select('uniqueid')->where('lead_id',$list->lead_id)->where('list_id',$list->list_id)->where('user',$user)->first();
            $list_id = $list->list_id;
            $called_count = $list->called_count;
            $table = 'custom_'.$list_id;
            //return response()->json($list);
            $custom_list = DB::table($table)
                        ->where($table.'.lead_id',$list->lead_id)->first();

            $data['lead'] = $custom_list;
            $data['uniqueid'] = $vicidial_log->uniqueid;
            $data['etat'] = 200;
            //return response()->json($data);
            
            
            $lead_id = $data['lead']->lead_id;///
             
           // return response()->json($dd);
            
            $phone = DB::table('phones')->where('login',$phone_login)
                                        ->where('pass',$phone_pass)
                                        ->where('active','Y')->first();
            $recording_exten = $phone->recording_exten;
            $outbound_cid = $phone->outbound_cid;
            $ext_context = $phone->ext_context;
            $protocol = $phone->protocol;
            $VDstop_rec_after_each_call = $phone->VDstop_rec_after_each_call;
            $campaignInfo = DB::table('vicidial_campaigns')->where('campaign_id',$campaign)->first(); 
            $dial_timeout = $campaignInfo->manual_dial_timeout;
            $manual_dial_prefix = $campaignInfo->manual_dial_prefix;
            $omit_phone_code = $campaignInfo->omit_phone_code;
            $dial_method = $campaignInfo->dial_method;
            $campaign_rec_filename = $campaignInfo->campaign_rec_filename;
            $prefix_choice = '';
            if(strlen($prefix_choice)>0){ $call_prefix = $prefix_choice; }else{ $call_prefix = $manual_dial_prefix; } 
            $dial_prefix = $call_prefix;
            $call_cid = $outbound_cid; 
            $campaign_cid = $call_cid; 
            $omit_phone_code = $request->omit_phone_code; 
            $usegroupalias = 1;
            $active_group_alias = ''; 
            $account = $active_group_alias; 
            $agent_dialed_number = $request->phone_number; /// view
            $dialed_label = 'MANUAL';
            $agent_dialed_type = $dialed_label; 
            $dial_method = $dial_method; 
            $agent_log_id = $request->agent_log_id; /// view
            $security = $list->security_phrase;  /// view
            $qm_extension = $request->extension;
            $LastCallCID='';
            $old_CID = $LastCallCID; 
            $cid_lock = 1; 
            $temp_rir = 'Y';
            $routing_initiated_recording = $temp_rir; 
            $exten = $recording_exten; 
            $recording_filename = $campaign_rec_filename; 
            //$channel = $request->channelrec;
            $conf_silent_prefix = '5';
            $channel = "Local/".$conf_silent_prefix.$conf_exten."@".$ext_context; 
            $vendor_lead_code = $list->vendor_lead_code;  /// view
            $state = $list->state; /// view 
            $postal_code = $data['lead']->contact_cp;  /// view
            $ACTION = 'manDiaLonly';

            $http = new \GuzzleHttp\Client(); 
            $response2 = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'server_ip' => $server_ip, 
                    'session_name' => $session_name, 
                    'conf_exten' => $conf_exten, 
                    'user' => $user, 
                    'pass' => $pass, 
                    'lead_id' => $lead_id, ////
                    'phone_number' => $phone_number, 
                    'phone_code' => $phone_code, 
                    'campaign' => $campaign, 
                    'ext_context' => $ext_context, 
                    'dial_timeout' => $dial_timeout, 
                    'dial_prefix' => $dial_prefix, 
                    'campaign_cid' => $campaign_cid, 
                    'omit_phone_code' => $omit_phone_code, 
                    'usegroupalias' => $usegroupalias, 
                    'account' => $account, 
                    'agent_dialed_number' => $agent_dialed_number, 
                    'agent_dialed_type' => $agent_dialed_type, 
                    'dial_method' => $dial_method, 
                    'agent_log_id' => $agent_log_id, 
                    'security' => $security,
                    'qm_extension' => $qm_extension, 
                    'old_CID' => $old_CID, 
                    'cid_lock' => $cid_lock, 
                    'routing_initiated_recording' => $routing_initiated_recording, 
                    'exten' => $exten, 
                    'recording_filename' => $recording_filename, 
                    'channel' => $channel, 
                    'vendor_lead_code' => $vendor_lead_code, 
                    'phone_login' => $phone_login, 
                    'state' => $state, 
                    'postal_code' => $postal_code, 
                    'ACTION' => $ACTION,
                ],
            ]);
           //return response()->json($response2->getBody()->getContents());

            $LiveSipChannel = DB::table('live_sip_channels')->where('server_ip',$server_ip)->where('extension',$conf_exten)->where('channel','LIKE',$channel)->first();
            //return $conf_exten;
            $auto_dial_level = $campaignInfo->auto_dial_level;
            $inOUT = 'OUT';
            $hangup_all_non_reserved = 1;
            $blind_transfer = 0;
            $user_abb = $user.$user.$user.$user;
            $user_abb = preg_replace("/^\./i","",$user_abb);
            $conf_dialed = 0;
            $nodeletevdac = '';
            $alt_num_status = 1;
            $leave_3way_start_recording_trigger = 1;
            $leave_3way_start_recording_filename = '';
            
            $data['liveagent1'] = DB::table('vicidial_live_agents')->where('user',$user)->first();
            $data['caller_id'] = $data['liveagent1']->callerid;
            //return response()->json($liveagent1);
            //$liveagent1 = DB::table('vicidial_live_agents')->where('user',$user)->first();
            sleep(1);
            
            $data['call_log'] = DB::table('call_log')->select('uniqueid')->where('caller_code',$data['caller_id'])->first();
            $data['uniqueid1'] = $data['call_log']->uniqueid;
            //return response()->json($data['call_log']);
            $response3 = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'stage' => 'start',
                    'server_ip' => $server_ip, 
                    'session_name' => $session_name, 
                    'conf_exten' => $conf_exten, 
                    'user' => $user, 
                    'pass' => $pass, 
                    'lead_id' => $lead_id, ////
                    'list_id' => $list->list_id, ////
                    'uniqueid' => $data['call_log']->uniqueid,
                    'length_in_sec' => 0,
                    'phone_number' => $phone_number, 
                    'phone_code' => $phone_code, 
                    'campaign' => $campaign, 
                    'start_epoch'=> 0,
                    'auto_dial_level'=> $auto_dial_level,
                    'VDstop_rec_after_each_call'=> $VDstop_rec_after_each_call,
                    'conf_silent_prefix'=> $conf_silent_prefix,
                    'protocol'=> $protocol,
                    'extension'=> $qm_extension,
                    'inOUT'=> $inOUT,
                    'DB' => 0,
                    'alt_dial'=> $dialed_label,
                    'hangup_all_non_reserved'=> $hangup_all_non_reserved,
                    'blind_transfer'=> $blind_transfer,
                    'called_count'  => $list->called_count,
                    'ext_context' => $ext_context,
                    'user_abb'    => $user_abb, 
                    'agentchannel'    => $channel, 
                    'conf_dialed'    => $conf_dialed, 
                    'nodeletevdac'    => $nodeletevdac, 
                    'alt_num_status'    => $alt_num_status, 
                    'leave_3way_start_recording_trigger'    => $leave_3way_start_recording_trigger, 
                    'leave_3way_start_recording_filename'    => $leave_3way_start_recording_filename, 

                    'dial_timeout' => $dial_timeout, 
                    'dial_prefix' => $dial_prefix, 
                    'campaign_cid' => $campaign_cid, 
                    'omit_phone_code' => $omit_phone_code, 
                    'usegroupalias' => $usegroupalias, 
                    'account' => $account, 
                    'agent_dialed_number' => $agent_dialed_number, 
                    'agent_dialed_type' => $agent_dialed_type, 
                    'dial_method' => $dial_method, 
                    'agent_log_id' => $agent_log_id, 
                    'security' => $security,
                    'qm_extension' => $qm_extension, 
                    'old_CID' => $old_CID, 
                    'cid_lock' => $cid_lock, 
                    'routing_initiated_recording' => $routing_initiated_recording, 
                    'exten' => $exten, 
                    'recording_filename' => $recording_filename, 
                    'channel' => $channel, 
                    'vendor_lead_code' => $vendor_lead_code, 
                    'phone_login' => $phone_login, 
                    'state' => $state, 
                    'postal_code' => $postal_code, 
                    'ACTION' => 'manDiaLlogCaLL',
                ],
            ]);

           
            $LiveSipChannel = DB::table('live_sip_channels')->where('server_ip',$server_ip)->where('extension',$conf_exten)->where('channel','LIKE','SIP/'.$user.'%')->first();
            //return $LiveSipChannel;
            $data['agentchannel'] = $channel;
            $data['channel'] = $channel;
            $data['contents'] = $response2->getBody()->getContents();
            //$a = json_decode
            //$a = "M1221606150001811060\n22597\n";
            //$a = explode("\n",$data['contents']);
            //$a = $a[0];
            //dd($a);
            $data['etat'] = 200;
            $data['res'] = $response3->getBody()->getcontents();
        
            
            
            return response()->json($data);
        }
    }
    ///// recupere les lives statistiques de l'agent  
    public function getLiveStatisticAgent(Request $request){
        $data = [];
        $agentLive = $request->user;
        $date = date('Y-m-d');
        $admin = '6666';
        $passAdmin = '0551797726';//'0551797capital';//'0551797726';
        $datetime_start = date('Y-m-d');
        $datetime_end = date('Y-m-d');
        
        $argumenter = ['DM','DMPDC','DMPDL','DL','DLDPD','DLDANC','DLDAYC','DLDAIB',
                'DLDDIB','IND','INDOLD','PA','PAPAC','PAPAL','RA','RAA','RADPT','RADAAS','RAEN','RAPM','RATSNR','RADAS'];
        $data['qualifArg'] = DB::table('vicidial_log')->where(DB::raw("(DATE_FORMAT(call_date,'%Y-%m-%d'))"),$date)
                                                       ->whereIn('status',$argumenter)->where('user',$agentLive)->count();

        $positive = ['DMPDC','DMPDL','DL','DLDPD','DLDANC','DLDAYC','DLDAIB','DLDDIB'];
        $data['qualifPos'] = DB::table('vicidial_log')->where(DB::raw("(DATE_FORMAT(call_date,'%Y-%m-%d'))"),$date)
                                                       ->whereIn('status',$positive)->where('user',$agentLive)->count();
        
        $nonArgumenter = ['DOUBL','FNM','FNMF','FNMLD','HC','HCD','HCNPF','HCTAM','RP','REL','REP','RR','RRA','RRDPT','RRDAAS','RREN','RRPM','RRTSNR','RRDAS'];
        $data['nonArgumenter'] = DB::table('vicidial_log')->where(DB::raw("(DATE_FORMAT(call_date,'%Y-%m-%d'))"),$date)
                                                           ->whereIn('status',$nonArgumenter)->where('user',$agentLive)->count();
        $data['fiches'] = DB::table('vicidial_log')->where(DB::raw("(DATE_FORMAT(call_date,'%Y-%m-%d'))"),$date)
                                                    ->where('user',$agentLive)->count();

        $agentPause = DB::table('vicidial_agent_log')->where('user',$agentLive)
                            ->where(DB::raw("(DATE_FORMAT(event_time,'%Y-%m-%d'))"),$date)
                            ->sum('pause_sec');
        $agentTalk = DB::table('vicidial_agent_log')->where('user',$agentLive)
                            ->where(DB::raw("(DATE_FORMAT(event_time,'%Y-%m-%d'))"),$date)
                            ->sum('talk_sec');
        $agentDispo = DB::table('vicidial_agent_log')->where('user',$agentLive)
                            ->where(DB::raw("(DATE_FORMAT(event_time,'%Y-%m-%d'))"),$date)
                            ->sum('dispo_sec');
        $agentWait = DB::table('vicidial_agent_log')->where('user',$agentLive)
                            ->where(DB::raw("(DATE_FORMAT(event_time,'%Y-%m-%d'))"),$date)
                            ->sum('wait_sec');

        $data['debrief'] = '00:00:00';
        $data['pause'] = $this->changeFormatSec($agentPause);
        $data['heure_prod'] = $this->changeFormatSec($agentTalk+$agentDispo+$agentWait);
        $data['heure_presence'] = $this->changeFormatSec($agentTalk+$agentDispo+$agentWait+$agentPause);
                     
        //return response()->json($agentPause);
        $http = new \GuzzleHttp\Client(); 
        $response = $http->get('https://call3.harmoniecrm.com/vicidial/non_agent_api.php?source=test&function=agent_stats_export&time_format=M&stage=pipe&user='.$admin.'&pass='.$passAdmin.'&datetime_start='.$datetime_start.'+00:00:00&datetime_end='.$datetime_end.'+23:59:59');
        $data1['agents'] = $response->getBody()->getContents();
        $contents = $data1['agents'];
        $contents = json_encode ($data1['agents']);
        $contents = explode('"',$contents);
        $contents = explode('\n',$contents[1]);
        //dd($contents);
        $agents = [];
         
        foreach ($contents as $key => $agent) {
            $agent = explode('|',$agent);
           
                if(!empty($agent) || $agent != "" && !empty($agent[1])){
                    if($agent[0] == $agentLive){
                        $agent['Agent'] = $agent[1];
                        $agent['debrief'] = '00:00:00';
                        $agent['pause'] = $this->changeFormatSec($agent[9]);
                        $agent['heure_prod'] = $this->heureProd($agent[5],$agent[16],$agent[18]);
                        $agent['heure_presence'] = $this->changeFormatMinSec(($agent[4]));
                        array_push($agents,$agent);
                    }
                }

            
        }
       
        //$data['debrief'] = $agents[0]['debrief'];
        //$data['pause'] = $agents[0]['pause'];
        //$data['heure_prod'] = $agents[0]['heure_prod'];
        //$data['heure_presence'] = $agents[0]['heure_presence'];
        
        $data['etat'] = 200;
        return response()->json($data);
    }
    
     //// fonction qui récuperer la liste des rappels pour un agent (callback)
    public function getLiveCallback(Request $request){
        $user = $request->user;
        $campaign = $request->campaign;
        $server_ip = $request->server_ip;
        $timezone  = +1;
        $now =  gmdate("Y-m-d H:i", time() + 3600*($timezone+date("I")));
        //return response()->json($now);
         $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->where('server_ip',$server_ip)->first();
         if(!empty($liveagent)){
            /*if($campaign == 1000101){
                $list_id = '14112022';
            }else{
                $list_id = '141120221';
            }
            */

            $data['callbacks'] = DB::table('vicidial_callbacks')->where('vicidial_callbacks.user',$user)->where('vicidial_callbacks.campaign_id',$campaign)->where('vicidial_callbacks.lead_status','CBHOLD')->where(DB::raw("(DATE_FORMAT(vicidial_callbacks.callback_time,'%Y-%m-%d %H:%i'))"),$now)
            ->join('vicidial_list','vicidial_callbacks.lead_id','=','vicidial_list.lead_id')
            //->join('custom_'.$list_id,'custom_'.$list_id.'.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','vicidial_callbacks.callback_id','vicidial_callbacks.callback_time')
             ->first();

             //return $data;
             if($data['callbacks'] == ''){
                $data['callbacks'] ='';
                $data['etat'] = 500;
             }else{
                $data['callbacks'] =$data['callbacks'];
                $data['etat'] = 200;
             }
            return response()->json($data);
         }else{
            $data['callbacks'] ='';
            $data['etat'] = 500;
            return response()->json($data);
         }  
    }

    ///// fonction qui permet de récuperer les pauses code d'une compagne
    public function getPausesCode(Request $request){
        $user = $request->user;
        $campaign = $request->campaign;
        $server_ip = $request->server_ip;

        $pauses = DB::table('vicidial_pause_codes')->where('campaign_id',$campaign)->get();
        if(count($pauses)>0){
            $data['etat'] = 200;
            $data['pauses'] = $pauses;
            return response()->json($data);
        }else{
            $data['etat'] = 500;
            $data['pauses'] = '';  
            return response()->json($data);
        }
    }
    public function changePausesCode(Request $request){
        $user = $request->user;
        $pass = $request->pass;
        $phone_login = $request->phone_login;
        $phone_pass = $request->phone_pass;
        $campaign = $request->campaign;
        $server_ip = $request->server_ip;
        $conf_exten = $request->conf_exten;
        $extension = $request->extension;
        $session_name = $request->session_name;
        $protocol = $request->protocol;
        $agent_log_id = $request->agent_log_id;
        $pause_code = $request->pause_code;

        $userLogged = DB::table('vicidial_users')->where('user',$user)->where('active','Y')->first();
        $VU_user_group = $userLogged->user_group;
        $http = new \GuzzleHttp\Client();
        $response = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
            'form_params' => [
                'server_ip' => $server_ip,
                'session_name' => $session_name,
                'user' => $user,
                'pass' => $pass,
                'MgrApr_user' => $user,
                'MgrApr_pass'      => $pass,
                'status'           => $pause_code,
                'campaign'        => $campaign,
                'agent_log_id'    => $agent_log_id,
                'user_group'        => $VU_user_group,
                'format'       => 'text',
                'ACTION'       => 'PauseCodeMgrApr'
            ],
        ]);

        $phone = DB::table('phones')->where('login',$phone_login)->where('pass',$phone_pass)->where('active','Y')->first();
        $phone_ip = $phone->phone_ip;
        $enable_sipsak_messages = $phone->enable_sipsak_messages;
        $campaignInfo = DB::table('vicidial_campaigns')->where('campaign_id',$campaign)->first();
        //$dial_method = $campaignInfo->dial_method;
        $starting_dial_level  = $campaignInfo->auto_dial_level;
        $response2 = $http->post('https://call3.harmoniecrm.com/agc/vdc_db_query.php', [
            'form_params' => [
                'server_ip' => $server_ip,
                'session_name' => $session_name,
                'user' => $user,
                'pass' => $pass,
                'MgrApr_user' => $user,
                'MgrApr_pass'      => $pass,
                'status'           => $pause_code,
                'campaign'        => $campaign,
                'agent_log_id'    => $agent_log_id,
                'user_group'        => $VU_user_group,
                'extension'  => $extension,
                'protocol'  => $protocol,
                'phone_ip'  => $phone_ip,
                'enable_sipsak_messages'  => $enable_sipsak_messages,
                'stage'  => '1',
                'campaign_cid'  => '',
                'auto_dial_level'  => $starting_dial_level,
                'MDnextCID'  => '',
                'format'       => 'text',
                'ACTION'       => 'PauseCodeSubmit'
            ],
        ]);


        $data['contents'] = $response2->getBody()->getContents();
        $data['pause_code'] = $pause_code;
            if(str_contains($data['contents'],'Pause Code '.$pause_code.' has been recorded')){
                $data['etat'] = 200;
                return response()->json($data);
            }
            else{
                $data['etat'] = 500;
                return response()->json($data);
            }
    }
    ///// calculer l'heure de prod
    function heureProd($talk,$wait,$dispo){
        $talktable = explode(':',$talk);
        $talkSec = ($talktable[0]*60)+$talktable[1];

        //$pausesec = $pause;
        $waittable = explode(':',$wait);
        $waitposec = ($waittable[0]*60)+$waittable[1];

        //$pausesec = $pause;
        $dispotable = explode(':',$dispo);
        $disposec = ($dispotable[0]*60)+$dispotable[1];

        $prodsec = $talkSec + $waitposec + $disposec;

        if($prodsec < 3600){ 
            $heures = 0; 
            
            if($prodsec < 60){$minutes = 0;} 
            else{$minutes = floor($prodsec / 60);} 
            
            $secondes = floor($prodsec % 60); 
            } 
            else{ 
            $heures = floor($prodsec / 3600); 
            $secondes = floor($prodsec % 3600); 
            $minutes = floor($secondes / 60); 
            } 
            
            $secondes2 = floor($secondes % 60); 
            if($heures<10){$heures = '0'.$heures;}
            if($minutes<10){$minutes = '0'.$minutes;}
            if($secondes2<10){$secondes2 = '0'.$secondes2;}
            $prodFinal = $heures.':'.$minutes.':'.$secondes2; 
            return $prodFinal; 
    }
    //// transferer le temps en H:M:S
    function changeFormatSec($Time){
      
            if($Time < 3600){ 
            $heures = 0; 
            
            if($Time < 60){$minutes = 0;} 
            else{$minutes = floor($Time / 60);} 
            
            $secondes = floor($Time % 60); 
            } 
            else{ 
            $heures = floor($Time / 3600); 
            $secondes = floor($Time % 3600); 
            $minutes = floor($secondes / 60); 
            } 
            
            $secondes2 = floor($secondes % 60); 
            if($heures<10){$heures = '0'.$heures;}
            if($minutes<10){$minutes = '0'.$minutes;}
            if($secondes2<10){$secondes2 = '0'.$secondes2;}
            $TimeFinal = $heures.':'.$minutes.':'.$secondes2; 
            return $TimeFinal; 
    }
    function changeFormatMinSec($Time){
      
        $prestable = explode(':',$Time);
        $Time = ($prestable[0]*60)+$prestable[1];
        if($Time < 3600){ 
            $heures = 0; 
            
            if($Time < 60){$minutes = 0;} 
            else{$minutes = floor($Time / 60);} 
            
            $secondes = floor($Time % 60); 
            } 
            else{ 
            $heures = floor($Time / 3600); 
            $secondes = floor($Time % 3600); 
            $minutes = floor($secondes / 60); 
        } 
            
            $secondes2 = floor($secondes % 60); 
            if($heures<10){$heures = '0'.$heures;}
            if($minutes<10){$minutes = '0'.$minutes;}
            if($secondes2<10){$secondes2 = '0'.$secondes2;}
            $TimeFinal = $heures.':'.$minutes.':'.$secondes2; 
            return $TimeFinal; 
    }
    
}
