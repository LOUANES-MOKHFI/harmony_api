<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class ActionAgentController extends Controller
{
    //// fonction qui récuperer la liste des status
    public function getCampaignStatus(){
        $data = [];
        $data['statuses'] = DB::table('vicidial_campaign_statuses')->select('status','status_name')->distinct()->where('selectable','Y')->orderBy('status','ASC')->get();
        return response()->json($data);
    }

    //// fonction qui récuperer l'historique des appells pour un agent
    public function getCallLogs(Request $request){
        $user = $request->user;
        $server_ip = $request->server_ip;
        $campaign = $request->campaign;

       
        $data['calllogs'] = DB::table('vicidial_log')->where('vicidial_log.user',$user)->where('vicidial_log.campaign_id',$campaign)
            ->join('vicidial_list','vicidial_log.lead_id','=','vicidial_list.lead_id')
            ->join('custom_222201','custom_222201.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','vicidial_log.*')->orderBy('vicidial_log.call_date','DESC')
             ->limit(250)->get();
            
        return response()->json($data);
        

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
            $response1 = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
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
            //$responseRecord = $http->post('https://call1.harmoniecrm.com/agc/api.php?source=test&user=66666&pass=0551797kamel2022&agent_user='.$user.'&function=audio_playback&value=ss-noservice&stage=PLAY&dial_override=Y'); 
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
        $response1 = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
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
            
            //$list = DB::table('vicidial_list')->where('lead_id',$liveagent->lead_id)->first();
            $list = DB::table('vicidial_list')->where('vicidial_list.list_id','222201')
            ->join('custom_222201','custom_222201.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_222201.*')
            ->where('vicidial_list.lead_id',$liveagent->lead_id)->first();
            //return response()->json($list);
            $phone = DB::table('phones')->where('login', $request->phone_login)
                                    ->where('pass', $request->phone_pass)
                                    ->where('active','Y')->first();
            $ext_context = $phone->ext_context;
            $conf_silent_prefix = '5';
            $channelrec = "Local/".$conf_silent_prefix.$conf_exten.'@'.$ext_context;
            
            $LiveSipChannel = DB::table('live_sip_channels')->where('server_ip',$request->server_ip)->where('extension',$request->conf_exten)->where('channel','LIKE','SIP/'.$user.'%')->first();

            $data['agentchannel'] = $LiveSipChannel->channel;
            $data['id_total'] = $list->id_total;
            $data['list_id'] = $list->list_id;
            $data['called_count'] = $list->called_count;
            $data['uniqueid'] = $liveagent->uniqueid;
            $data['lead_id'] = $liveagent->lead_id;
            $data['gender'] = $list->gender;
            $data['adr1_civilite_abrv'] = $list->adr1_civilite_abrv;
            $data['contact_nom'] = $list->contact_nom;
            $data['contact_prenom'] = $list->contact_prenom;
            $data['raison_sociale'] = $list->raison_sociale;
            $data['professionnel'] = $list->professionnel;
            $data['adr2'] = $list->adr2;
            $data['adr3'] = $list->adr3;
            $data['adr4_libelle_voie'] = $list->adr4_libelle_voie;
            $data['adr5'] = $list->adr5;
            $data['contact_cp'] = $list->contact_cp;
            $data['contact_ville'] = $list->contact_ville;
            $data['contact_tel'] = $list->contact_tel;
            $data['tel1'] = $list->tel1;
            $data['contact_email'] = $list->contact_email;
            $data['commentaire'] = $list->commentaire;
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
        $phone_number = $request->phone_number;
        $phone_code = $request->phone_code;
        
        $http1 = new \GuzzleHttp\Client(); 
       /* $queryCID1 = "HTvdcW".$epoch_sec.$user_abb;
        $response = $http1->post('https://call1.harmoniecrm.com/agc/manager_send.php', [
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
        $response1 = $http1->post('https://call1.harmoniecrm.com/agc/manager_send.php', [
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
        $http2 = new \GuzzleHttp\Client(); 
        $response2 = $http2->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
            'form_params' => [
                'server_ip' => $server_ip,
                'session_name' => $session_name,
                'stage'        => $taskMDstage,
                'uniqueid'     => $uniqueid,
                'user' => $username,
                'pass' => $pass,
                'campaign'    => $campaign,
                'lead_id'     => $lead_id,
                'list_id'     => $list_id,
                'length_in_sec'=> 0,
                'phone_code'   => $phone_code,
                'phone_number' => $phone_number,
                'exten'        => $recording_exten,
                'channel'      => $agentchannel,
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
                'agentchannel' => $agentchannel,
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

        $response = $http1->post('https://call1.harmoniecrm.com/agc/manager_send.php', [
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
       // return response()->json($response->getBody()->getcontents());  
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

            $VDDCU_recording_id = $recording->recording_id;
            $recording_filename = $recording->filename;
            $callback_gmt_offset = '';
            $callback_timezone = '';
            $customer_sec = '';
            $parked_hangup = '0';
            $MDnextCID = '';
            $called_count = $request->called_count;
            $http = new \GuzzleHttp\Client(); 
            $response2 = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
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
                    'stage'           => $campaign, 
                    'vtiger_callback_id'=> $vtiger_callback_id,
                    'phone_number'    => $phone_number,
                    'phone_code'      => $phone_code, 
                    'dial_method'     => $dial_method,
                    'uniqueid'        => $uniqueid, 
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
            
            $content = $response2->getBody()->getContents();
            //return response()->json($content);
            /////update montant don
            /*$list = DB::table('vicidial_list')->where('vicidial_list.lead_id',$lead_id)
            ->join('custom_222201','custom_222201.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_222201.*')->update([
                'accord_montant' => $request->montant_don,
            ]);*/
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
    //// fonction qui récuperer la liste des rappels pour un agent (callback)
    public function getAgentCallBack(Request $request){
        $user = $request->user;
        $campaign = $request->campaign;
        $server_ip = $request->server_ip;
         $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->where('server_ip',$server_ip)->first();
         if(!empty($liveagent)){

            $data['callbacks'] = DB::table('vicidial_callbacks')->where('vicidial_callbacks.user',$user)->where('vicidial_callbacks.campaign_id',$campaign)->where('vicidial_callbacks.lead_status','CBHOLD')
            ->join('vicidial_list','vicidial_callbacks.lead_id','=','vicidial_list.lead_id')
            ->join('custom_222201','custom_222201.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_222201.*','vicidial_callbacks.callback_id','vicidial_callbacks.callback_time')
             ->get();
            $data['etat'] = 200;
            return response()->json($data);
         }else{
            $data['callbacks'] ='';
            $data['etat'] = 500;
            return response()->json($data);
         }  
    }

    

    /*public function activateWebphone(Request $request){
        $http = new \GuzzleHttp\Client();
        $phone = DB::table('phones')->where('login',$request->phone_login)
                                    ->where('pass',$request->phone_pass)
                                    ->where('active','Y')->first();
        $ext_context = $phone->ext_context;
        $phone_ip = $phone->phone_ip;
        $outbound_cid = $phone->outbound_cid;
        $enable_sipsak_messages = $phone->enable_sipsak_messages;
        $system_settings = DB::table('system_settings')->get()[0];
        $allow_sipsak_messages = $system_settings->allow_sipsak_messages;
        $user_abb = $request->user.$request->user.$request->user.$request->user;
        $epoch_sec = date("U");
        $queryCID = 'HXvdcW'.$epoch_sec.$user_abb;
        $response = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'server_ip' => $request->server_ip,
                    'session_name' => $request->session_name,
                    'user' => $request->user,
                    'pass' => $request->pass,
                    'channel' => '',
                    'queryCID' => $queryCID,
                    'exten'      => $request->conf_exten,
                    'ext_context' => $ext_context,
                    'ext_priority' => '1',
                    'extension'    => $request->extension,
                    'protocol'=> $request->protocol,
                    'phone_ip'         => $phone_ip,
                    'enable_sipsak_messages'       => $enable_sipsak_messages,
                    'allow_sipsak_messages'=> $allow_sipsak_messages,
                    'campaign'=> $request->campaign,
                    'outbound_cid'       => $outbound_cid,
                    'format'       =>'text',
                    'ACTION'       => 'OriginateVDRelogin',
                ],
            ]);
        $content = $response->getBody()->getcontents();
        $contents = json_decode($content);

        $data['etat'] = 200;
        return response()->json($data);
    }*/


    //// fonction qui activer le webphone apres 5 sec de l'actualisation de la page ou lors de clique sur button webphone
    public function activateWebphone(Request $request){
        $http = new \GuzzleHttp\Client();
        $responseWebPhone = $http->post('https://call1.harmoniecrm.com/agc/api.php?source=test&user=66666&pass=0551797kamel2022&agent_user='.$request->user.'&function=call_agent&value=CALL');
        return response()->json(['etat'=>200]);
    }

    //// fonction qui récuperer les information d'un fiche a partir de lead_id
    public function getLeadInfo(Request $request){
        $user = $request->user;
        $lead_id = $request->lead_id;
        $liveagent = DB::table('vicidial_live_agents')->where('user',$user)->first();
        if(!empty($liveagent)){
            $data['lead'] = DB::table('vicidial_list')->where('vicidial_list.user',$user)->where('vicidial_list.lead_id',$lead_id)
            ->join('custom_222201','custom_222201.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_222201.*')->first();
            $vicidial_log = DB::table('vicidial_log')->select('uniqueid')->where('lead_id',$lead_id)->where('list_id',$data['lead']->list_id)->where('user',$user)->first();
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
        $list = DB::table('vicidial_list')->where('vicidial_list.lead_id',$request->lead_id)
            ->join('custom_222201','custom_222201.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_222201.*')->first();
        if(!empty($list)){
            $list = DB::table('vicidial_list')->where('vicidial_list.lead_id',$request->lead_id)
            ->join('custom_222201','custom_222201.lead_id','=','vicidial_list.lead_id')
            ->select('vicidial_list.*','custom_222201.*')
            ->update([
                'new_contact_nom' => $request->new_contact_nom,
                'new_contact_prenom' => $request->new_contact_prenom,
                'new_raison_sociale' => $request->new_raison_sociale,
                'new_professionnel' => $request->new_professionnel,
                'new_adr2' => $request->new_adr2,
                'new_adr3' => $request->new_adr3,
                'new_adr4_libelle_voie' => $request->new_adr4_libelle_voie,
                'new_adr1_civilite_abrv' => $request->new_adr1_civilite_abrv,
                'new_adr5' => $request->new_adr5,
                'new_contact_cp' => $request->new_contact_cp,
                'new_contact_ville' => $request->new_contact_ville,
                'new_contact_tel' => $request->new_contact_tel,
                'contact_tel1' => $request->new_tel1,
                'new_contact_email' => $request->new_contact_email,
                'commentaire' => $request->commentaire,
                'cas_particulier' => $request->cas_particulier,
                //'type_accord' => $request->type_accord,
                //'envoi_courrier' => $request->envoi_courrier,
                'accord_montant' => $request->montant_don,
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

    ///// recupere les lives statistiques de l'agent  
    public function getLiveStatisticAgent(Request $request){
        $data = [];
        $agentLive = $request->user;
        $date = date('Y-m-d');
        $admin = '66666';
        $passAdmin = '0551797kamel2022';//'0551797capital';//'0551797kamel2022';
        $datetime_start = date('Y-m-d');
        $datetime_end = date('Y-m-d');
        
        $argumenter = ['DM','DMPDC','DMPDL','DL','DLDPD','DLDANC','DLDAYC','DLDAIB',
                'DLDDIB','IND','INDOLD','PA','PAPAC','PAPAL','RA','RAA','RADPT','RADAAS','RAEN','RAPM','RATSNR','RADAS'];
        $data['qualifArg'] = DB::table('vicidial_list')->where(DB::raw("(DATE_FORMAT(modify_date,'%Y-%m-%d'))"),$date)
                                                       ->whereIn('status',$argumenter)->where('user',$agentLive)->count();

        $positive = ['DMPDC','DMPDL'];
        $data['qualifPos'] = DB::table('vicidial_list')->where(DB::raw("(DATE_FORMAT(modify_date,'%Y-%m-%d'))"),$date)
                                                       ->whereIn('status',$positive)->where('user',$agentLive)->count();
        
        $nonArgumenter = ['DOUBL','FNM','FNMF','FNMLD','HC','HCD','HCNPF','HCTAM','RP','REL','REP','RR','RRA','RRDPT','RRDAAS','RREN','RRPM','RRTSNR','RRDAS'];
        $data['nonArgumenter'] = DB::table('vicidial_list')->where(DB::raw("(DATE_FORMAT(modify_date,'%Y-%m-%d'))"),$date)
                                                           ->whereIn('status',$nonArgumenter)->where('user',$agentLive)->count();
        $data['fiches'] = DB::table('vicidial_list')->where(DB::raw("(DATE_FORMAT(modify_date,'%Y-%m-%d'))"),$date)
                                                    ->where('user',$agentLive)->count();
        $http = new \GuzzleHttp\Client(); 
        $response = $http->get('https://call1.harmoniecrm.com/vicidial/non_agent_api.php?source=test&function=agent_stats_export&time_format=M&stage=pipe&user='.$admin.'&pass='.$passAdmin.'&datetime_start='.$datetime_start.'+00:00:00&datetime_end='.$datetime_end.'+23:59:59');
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
       
        $data['debrief'] = $agents[0]['debrief'];
        $data['pause'] = $agents[0]['pause'];
        $data['heure_prod'] = $agents[0]['heure_prod'];
        $data['heure_presence'] = $agents[0]['heure_presence'];
        
        $data['etat'] = 200;
        return response()->json($data);
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
            $minutes = round($secondes / 60); 
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
