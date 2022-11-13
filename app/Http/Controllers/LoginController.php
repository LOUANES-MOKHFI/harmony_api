<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;
class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
    public function customLogin(Request $request){
        $username = $request->user;
        $pass = $request->pass;
        $campaign = $request->campaign;
        $StarTtimE = date("U");
        $user = DB::table('vicidial_users')->where('user',$username)->where('pass',$pass)->first();
        if(!empty($user)){
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call1.harmoniecrm.com/agc/vicidial.php', [
                'form_params' => [
                    'VD_login' => $username,
                    'VD_pass' => $pass,
                    'phone_login' => $user->phone_login,
                    'phone_pass' => $user->phone_pass,
                    'VD_campaign' => $campaign,
                    'DB' => 0,
                    'JS_browser_height'=> 342,
                    'JS_browser_width' => 1366,
                    'LOGINvarONE'      => '',
                    'LOGINvarTWO'      => '',
                    'LOGINvarTHREE'      => '',
                    'LOGINvarFOUR'      => '',
                    'LOGINvarFIVE'      => '',
                    'hide_relogin_fields' => ''
                ],

               /* 'form_params' => [
                    'VD_login' => '3004',
                    'VD_pass' => 'Be5gcz',
                    'phone_login' => '3004',
                    'phone_pass' => 'Be5gcz',
                    'VD_campaign' => '1000101',
                    'DB' => 0,
                    'JS_browser_height'=> 323,
                    'JS_browser_width' => 1366
                ],*/
            ]);


            
            $response1 = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'user' => $username,
                    'pass' => $pass,
                    'ACTION'     => 'LogiNCamPaigns',
                    'format'     => 'html'
                ],
            ]);


            //return response()->json($response1->getBody()->getContents());
            //$responseWebPhone = $http->post('https://call1.harmoniecrm.com/agc/api.php?source=test&user=66666&pass=0551797kamel2022&agent_user='.$username.'&function=webphone_url&value=DISPLAY');
            
            if($response->getStatusCode() == 200){
                $phone = DB::table('phones')->where('login',$user->phone_login)->where('pass',$user->phone_pass)->where('active','Y')->first();
                $conference = DB::table('vicidial_conferences')->where('server_ip',$phone->server_ip)->where('extension','SIP/'.$user->phone_login)->first();
                //dd($conference);
                $session_id = $conference->conf_exten;

                $agent_Log = DB::table('vicidial_agent_log')
                ->where('user',$user->user)->where('server_ip',$phone->server_ip)
                ->where('campaign_id',$campaign)->where('sub_status','LOGIN')
                ->where('pause_sec',0)->orderBy('agent_log_id','DESC')->first();
                $session = DB::table('vicidial_session_data')->where('user',$user->user)->where('server_ip',$phone->server_ip)->where('campaign_id',$campaign)->first();
               
                $agent_log_id = $agent_Log->agent_log_id;
                $campaign_id = $agent_Log->campaign_id;
                $protocol = $phone->protocol;
                $extension = $phone->dialplan_number;

                $data['user'] = $user->user;
                $data['pass'] = $user->pass;
                $data['phone_login'] = $user->phone_login;
                $data['phone_pass'] = $user->phone_pass;
                $data['server_ip'] = $phone->server_ip;
                $data['agent_log_id'] = $agent_log_id;
                $data['campaign'] = $campaign_id;
                $data['session_name'] = $session->session_name;
                $data['protocol'] = $protocol;
                $data['extension'] = $extension;
                $data['conf_exten'] = $session_id;
                $data['etat'] = 200;
                $data['msg'] = "connexion avec succees";
                
                    if ( ($protocol == 'EXTERNAL') || ($protocol == 'Local') )
                    {
                         $protodial = 'Local';
                         $extendial = $extension;
                    //      var extendial = extension + "@" + ext_context;
                    }
                    else
                    {
                        $protodial = $protocol;
                        $extendial = $extension;
                    }
                $user_abb = $data['user'].$data['user'].$data['user'].$data['user'];
                $epoch_sec = $StarTtimE;
                $originatevalue = $protodial."/".$extendial;
                $queryCID = "ACagcW".$epoch_sec.$user_abb;
                $system_settings = DB::table('system_settings')->get()[0];


                $ext_context = $phone->ext_context;
                $login_context = $ext_context;
                $meetme_enter_login_filename = $system_settings->meetme_enter_login_filename;
                

                if (strlen($meetme_enter_login_filename) > 0)
                {$login_context = 'meetme-enter-login';}
                $phone_ip = $phone->phone_ip;
                $enable_sipsak_messages = $phone->enable_sipsak_messages;
                $allow_sipsak_messages = $system_settings->allow_sipsak_messages;
                $campaignn = DB::table('vicidial_campaigns')->where('campaign_id',$campaign_id)->first();
                $campaign_cid = $campaignn->campaign_cid;
                /*$response2 = $http->post('https://call1.harmoniecrm.com/agc/manager_send.php', [
                    'form_params' => [
                        'server_ip'    => $data['server_ip'],
                        'session_name' => $data['session_name'],
                        'user' => $data['user'],
                        'pass' => $data['pass'],
                        'channel'  => $originatevalue,
                        'queryCID' => $queryCID,
                        'exten'    => $session_id,
                        'ext_context' => $login_context,
                        'ext_priority'=>1,
                        'extension'   => $extension,
                        'protocol'    => $protocol,
                        'phone_ip'    => $phone_ip,
                        'enable_sipsak_messages' => $enable_sipsak_messages,
                        'allow_sipsak_messages'  => $allow_sipsak_messages,
                        'campaign'               => $campaign_id,
                        'outbound_cid'           => $campaign_cid,
                        'format'     => 'text',
                        'ACTION'     => 'OriginateVDRelogin'
                    ],
                ]);
                $content = $response2->getBody()->getContents();
                */
                // return response()->json($content);
                $http = new \GuzzleHttp\Client();
                $responseWebPhone = $http->post('https://call1.harmoniecrm.com/agc/api.php?source=test&user=66666&pass=0551797kamel2022&agent_user='.$data['user'].'&function=call_agent&value=CALL');
            $dial_method = $campaignn->dial_method;
               if($dial_method == "INBOUND_MAN"){
                $VICIDiaL_closer_blended = 0;
               }else{
                $VICIDiaL_closer_blended = 1;
               }

            $response2 = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'server_ip' => $data['server_ip'],
                    'session_name' => $data['session_name'],
                    'user' => $data['user'],
                    'pass' => $data['pass'],
                    'comments' => 'MGRLOCK',
                    'closer_blended' => $VICIDiaL_closer_blended,
                    'campaign' => $campaign_id,
                    'closer_choice' => 'MGRLOCK-',
                    'qm_extension' => $extension,
                    'qm_phone' => $data['user'].'@agents',
                    'dial_method' => $dial_method,
                    'ACTION'     => 'regCLOSER',
                    'format'     => 'text'
                ],
            ]);
            $response3 = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'server_ip' => $data['server_ip'],
                    'session_name' => $data['session_name'],
                    'user' => $data['user'],
                    'pass' => $data['pass'],
                    'comments' => 'MGRLOCK',
                    'agent_territories' => 'MGRLOCK',
                    'ACTION'     => 'regTERRITORY',
                    'format'     => 'text'
                ],
            ]);
            return response()->json($data);
            
            }
            else{
                $data['etat'] = 401;
                $data['msg'] = "Invalide username or password";
                return response()->json($data);
            }
        }
        else{
            $data['etat'] = 401;
            $data['msg'] = "Invalide username or password";
            return response()->json($data);
        }
        
    }
    
    public function logout(Request $request){


            $phone = DB::table('phones')->where('login',$request->phone_login)->where('pass',$request->phone_pass)->where('active','Y')->first();
            $phone_ip = $phone->phone_ip;
            $ext_context = $phone->ext_context;
            $enable_sipsak_messages = $phone->enable_sipsak_messages;
            $LogouTKicKAlL          = '1';
            $no_delete_sessions     = '1';
            $campaignInfo = DB::table('vicidial_campaigns')->where('campaign_id',$request->campaign)->first();
            $dial_method = $campaignInfo->dial_method;
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call1.harmoniecrm.com/agc/vdc_db_query.php', [
                'form_params' => [
                    'server_ip' => $request->server_ip,
                    'session_name' => $request->session_name,
                    'user' => $request->user,
                    'pass' => $request->pass,
                    'campaign' => $request->campaign,
                    'conf_exten' => $request->conf_exten,
                    'extension'=> $request->extension,
                    'protocol'      => $request->protocol,
                    'agent_log_id'      => $request->agent_log_id,
                    'enable_sipsak_messages' => $request->enable_sipsak_messages,
                    'no_delete_sessions'      => $no_delete_sessions,
                    'phone_ip'      => $phone_ip,
                    'LogouTKicKAlL'      => $LogouTKicKAlL,
                    'ext_context'      => $request->ext_context,
                    'qm_extension'     => $request->extension,
                    'stage'      => 'NORMAL',
                    'pause_trigger'    => 'PAUSE',
                    'dial_method'      => $dial_method,
                    'pause_max_url_trigger'  => '',
                    'format'      => 'text',
                    'ACTION'        => 'userLOGout',
                ],
            ]);

        
            if(str_contains($response->getBody()->getcontents(),'Agent '.$request->user.' is now in status PAUSED')){
                $data['msg']  = "logout success";
                $data['etat'] = 200;
                return response()->json($data);
            }else{
                $data['msg']  = "Erreur des parametres";
                $data['etat'] = 500;
                return response()->json($data);
            }   
    }

    public function customLogin1(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
                        //->withSuccess('Signed in');
        }
  
        return  redirect()->route("login")->withError('Email ou mot de passe incorrecte');
    }
    /*public function customLogin2(Request $request)
    {   
        
       

        $date = date("r");
        $ip = getenv("REMOTE_ADDR");
        $browser = getenv("HTTP_USER_AGENT");
        $script_name = getenv("SCRIPT_NAME");
        $server_name = getenv("SERVER_NAME");
        $server_addr = getenv("SERVER_ADDR");
        $server_port = getenv("SERVER_PORT");

        $isdst = date("I");
        $StarTtimE = date("U");
        $timezone  = +2;
        $now =  gmdate("Y-m-j H:i:s", time() + 3600*($timezone+date("I")));
        $NOW_TIME = $now;

        $tsNOW_TIME = date("YmdHis");
        $FILE_TIME = date("Ymd-His");
        $loginDATE = date("Ymd");
        $CIDdate = date("ymdHis");
        $random = (rand(1000000, 9999999) + 10000000);
        $closer_chooser_string='';
        $AT='@';
        $US='_';
        $DS='-';

        $PhonESComPIP = '1';
         
        //1-
        $user = DB::table('vicidial_users')->where('user',$request->user)->where('pass',$request->pass)->first();
        //dd($user);
        $VU_user_group = $user->user_group;
        $user_level = $user->user_level;
        $phone_login = $user->phone_login;
        $phone_pass  = $user->phone_pass;
        $viciLiveAgentcount = DB::table('vicidial_live_agents')->where('user',$request->user)->count();
         if($viciLiveAgentcount>0){
            $data['etat'] = 401;
            $data['msg'] = "Ce compte est deja connecte";
            $data['user'] = $user;
            $data['user'] = $user;
            return response()->json($data);
         }
        //2- 

        $allowed_campaigns = DB::table('vicidial_user_groups')->where('user_group',$VU_user_group)->first();
        $allowed_campaigns = $allowed_campaigns->allowed_campaigns;

        //3-
        $phone = DB::table('phones')->where('login',$user->phone_login)->where('pass',$user->phone_pass)->where('active','Y')->first();
        $computer_ip = $phone->computer_ip;
        $enable_sipsak_messages = $phone->enable_sipsak_messages;
        if ($PhonESComPIP == '1')
            {
            if (strlen($computer_ip) < 4)
                {
                DB::table('phones')->where('login',$phone_login)->where('pass',$phone_pass)->where('active','Y')->update(['computer_ip' => $ip]);
                }
            }
        if ($PhonESComPIP == '2')
            {
            DB::table('phones')->where('login',$phone_login)->where('pass',$phone_pass)->where('active','Y')->update(['computer_ip' => $ip]);
            }
        $protocol = $phone->protocol;
        $ext_context = $phone->ext_context;
        if($protocol == "EXTERNAL"){
            $protocol = 'Local';
        }
        $extension = $phone->dialplan_number;
        $server_ip = $phone->server_ip;
        $SIP_user = $protocol.'/'.$extension;
        if ((strlen($phone->dialplan_number)<5) and ($protocol == 'Local') )
            {
            $SIP_user = $protocol.'/'.$extension.$request->user;
            }
        $phone_ring_timeout = $phone->phone_ring_timeout;
        $on_hook_agent = $phone->on_hook_agent;
        //dd($SIP_user,$server_ip);
        //4-
        //->where('extension',$SIP_user)
        $conference = DB::table('vicidial_conferences')->where('server_ip',$server_ip)->first();
        //dd($conference);
        $session_id = $conference->conf_exten;

        //4-1
        $session_ext = $session_ext = preg_replace("[^a-z0-9]", "", $extension);
        if (strlen($session_ext) > 10) {$session_ext = substr($session_ext, 0, 10);}
        $session_rand = (rand(1,9999999) + 10000000);
        $session_name = $StarTtimE.$US.$session_ext.$session_rand;
        $client_session = DB::table('web_client_sessions')->insert([
            'extension'  => $extension,
            'server_ip' => $server_ip,
            'program' => 'vicidial',
            'start_time' => $NOW_TIME,
            'session_name' => $session_name,
        ]);
        
        
        
        //5-
        $user_Log = DB::table('vicidial_user_log')->insert([
            'user'  => $request->user,
            'event' => 'LOGIN',
            'campaign_id'=> $request->get('campaign'),
            'event_date' => $NOW_TIME,
            'event_epoch'=> $StarTtimE,
            'user_group' => $VU_user_group,
            'session_id' => $session_id,
            'server_ip'  => $server_ip,
            'extension'  => $SIP_user,
            'computer_ip'=> $ip,
            'data'   => '',
            'browser'    => $browser,
        ]);

        //6-
        $campaignAgent = DB::table('vicidial_campaign_agents')->where('user',$request->user)->where('campaign_id',$request->campaign)->first();
        $campaign_weight = $campaignAgent->campaign_weight;
        $calls_today = $campaignAgent->calls_today;
        //7-
        ///verify if user exist in live agent
         
        $Live_Agent = DB::table('vicidial_live_agents')->insert([
            'user'  => $request->user,
            'server_ip'  => $server_ip,
            'conf_exten' => $session_id,
            'lead_id'   => 0,
            'extension'  => $SIP_user,
            'status'     => 'PAUSED',
            'campaign_id'=> $request->get('campaign'),
            'random_id'  => $random,
            'last_call_time'   => $NOW_TIME,
            'last_update_time' => $tsNOW_TIME,
            'last_call_finish' => $NOW_TIME,
            'closer_campaigns' => $closer_chooser_string,
            'user_level'       => $user_level,
            'campaign_weight' => $campaign_weight,
            'calls_today' => $calls_today,
            'last_state_change'  => $NOW_TIME,
            'outbound_autodial'  => 'Y',
            'manager_ingroup_set'=> 'N',
            'on_hook_ring_time'  => $phone_ring_timeout,
            'on_hook_agent'      => $on_hook_agent,
        ]);

        $viciUser = DB::table('vicidial_users')->where('user',$request->user)->where('pass',$request->pass)->update([
            'shift_override_flag' => '1',
        ]);

        //7-1
        $campaignn = DB::table('vicidial_campaigns')->where('campaign_id',$request->get('campaign'))->first();

        //7-2
        $system_settings = DB::table('system_settings')->get()[0];
        //dd($system_settings);
        $allow_sipsak_messages = $system_settings->allow_sipsak_messages;

        $SIqueryCID = "S".$CIDdate.$session_id;
        if ( ($enable_sipsak_messages > 0) and ($allow_sipsak_messages > 0))
            {
            $SIPSAK_prefix = 'LIN-';
            $SIqueryCID = $SIPSAK_prefix.$request->campaign.$DS.$CIDdate;
            }
        $campaign_cid = $campaignn->campaign_cid;
        $SIP_user_DiaL = $protocol.'/'.$extension;
        $TEMP_SIP_user_DiaL = $SIP_user_DiaL;
        if ($on_hook_agent == 'Y')
            {$TEMP_SIP_user_DiaL = 'Local/8300@default';}
                ### insert a NEW record to the vicidial_manager table to be processed
          

        $vici_manager = DB::table('vicidial_manager')->insert([

              'uniqueid' => '', 
              'entry_date' => $NOW_TIME,
              'status' => 'NEW',
              'response' => 'N',
              'server_ip' => $server_ip,
              'channel' => '',
              'action' => 'Originate',
              'callerid' => $SIqueryCID,
              'cmd_line_b' => 'Channel: '.$TEMP_SIP_user_DiaL,
              'cmd_line_c' => 'Context: '.$ext_context,
              'cmd_line_d' => 'Exten: '.$session_id,
              'cmd_line_e' => 'Priority: 1',
              'cmd_line_f' => 'Callerid: "'.$SIqueryCID.'"<'.$campaign_cid.'>',
              'cmd_line_g' => '',
              'cmd_line_h' => '',
              'cmd_line_i' => '',
              'cmd_line_j' => '',
              'cmd_line_k' => ''
        ]);

         $live_sip_channels = DB::table('live_sip_channels')->insert([
            'channel' => $SIP_user_DiaL,
            'server_ip'  => $server_ip,
            'channel_group' => $SIqueryCID,
            'extension' => 'ring',
            'channel_data' => $protocol.'/ring'
        ]);
         
        //7-3
        $client_session_exist = DB::table('vicidial_session_data')->where('user',$request->user)->get();
        if(!empty($client_session_exist)){
            $client_session = DB::table('vicidial_session_data')->where('user',$request->user)->update([
                'session_name'  => $session_name,
                'user' => $request->user,
                'campaign_id' => $request->get('campaign'),
                'server_ip' => $server_ip,
                'conf_exten' => $session_id,
                'extension' => $extension,
                'login_time' => $NOW_TIME,
                'webphone_url' => '',
                'agent_login_call' => '||'.$NOW_TIME.'|NEW|N|'.$server_ip.'||Originate|'.$SIqueryCID.'|Channel: '.$TEMP_SIP_user_DiaL.'|Context: '.$ext_context.'|Exten: '.$session_id.'|Priority: 1'.'|Callerid: "'.$SIqueryCID.'"<'.$campaign_cid.'>|||||'
            ]);
        }else{
            $client_session = DB::table('vicidial_session_data')->insert([
                'session_name'  => $session_name,
                'user' => $request->user,
                'campaign_id' => $request->get('campaign'),
                'server_ip' => $server_ip,
                'conf_exten' => $session_id,
                'extension' => $extension,
                'login_time' => $NOW_TIME,
                'webphone_url' => '',
                'agent_login_call' => '||'.$NOW_TIME.'|NEW|N|'.$server_ip.'||Originate|'.$SIqueryCID.'|Channel: '.$TEMP_SIP_user_DiaL.'|Context: '.$ext_context.'|Exten: '.$session_id.'|Priority: 1'.'|Callerid: "'.$SIqueryCID.'"<'.$campaign_cid.'>|||||'
            ]);
        }


        //8-
        $agent_Log = DB::table('vicidial_agent_log')->insertGetId([
            'user'  => $request->user,
            'server_ip'  => $server_ip,
            'event_time' => $NOW_TIME,
            'campaign_id'=> $request->get('campaign'),
            'pause_epoch'  => $StarTtimE,
            'wait_epoch'  => $StarTtimE,
            'pause_sec'   => 0,
            'user_group' => $VU_user_group,
            'sub_status' => 'LOGIN',
            'pause_type' => 'AGENT',
        ]);
        $agent_log_id = $agent_Log;

        ///8-1
        $agent_visibility_log = DB::table('vicidial_agent_visibility_log')->insert([
            'db_time'  => $NOW_TIME,
            'event_start_epoch' => $StarTtimE,
            'event_end_epoch' => $StarTtimE,
            'user' => $request->user,
            'length_in_sec' => '0',
            'visibility' => 'LOGIN',
            'agent_log_id' => $agent_log_id,
            
        ]);
        //9-
        $campaign = DB::table('vicidial_campaigns')->where('campaign_id',$request->get('campaign'))->update(['campaign_logindate' => $NOW_TIME]);

        //10-
        $viciLiveAgent = DB::table('vicidial_live_agents')->where('user',$request->user)->update(['agent_log_id' => $agent_log_id]);

        //11-
        $viciUser = DB::table('vicidial_users')->where('user',$request->user)->where('shift_override_flag',1)->update([
            'shift_override_flag' => '0',
            'last_login_date'=>$NOW_TIME,
            'last_ip'=> $ip
        ]);
        $viciUser = DB::table('vicidial_campaigns')->where('campaign_id',$request->campaign)->update([
            'campaign_logindate' => $NOW_TIME,
        ]);
        $data['etat'] = 200;
        $data['msg'] = "Connexion avec succees";
        $data['user'] = $user;
        $data['campaign'] = $campaignn;
        $data['server_ip'] = $server_ip;
        $data['conf_exten'] = $session_id;
        $data['session_name'] = $session_name;
        $data['extension'] = $extension;
        $data['protocol'] = $protocol;

        return response()->json($data);
        //dd($viciUser);
        //return  redirect()->route("login")->withError('Email ou mot de passe incorrecte');
    }*/
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return redirect()->route("login");
    }


    /*function logout1(){
        $StarTtime = date("U");
        
        //return $request;
        $no_delete_sessions     = '1';
        $LogouTKicKAlL          = '1';

        //1-
        $user = DB::table('vicidial_users')->where('user',$request->user)->first();
        $user_group = $user->user_group;
        
        //2-
        ##### Insert a LOGOUT record into the user log
        $timezone  = +2;
        $now =  gmdate("Y-m-j H:i:s", time() + 3600*($timezone+date("I")));
        $NOW_TIME = $now;
        $userLog = DB::table('vicidial_user_log')->insert([
            'user'        => $user->user,
            'event'       => 'LOGOUT',
            'campaign_id' => $request->campaign,
            'event_date'  => $NOW_TIME,
            'event_epoch' => $StarTtime,
            'user_group'  => $user_group
        ]);
        
        
        //3-
        if ($no_delete_sessions < 1)
            {
            ##### Remove the reservation on the vicidial_conferences meetme room
            $vicidial_conferences = DB::table('vicidial_conferences')->where('server_ip',$request->server_ip)->where('conf_exten',$request->conf_exten)->update([
                'extension'   => '',
            ]);
        }

        //4-##### Delete the web_client_sessions
            $deletedSession = DB::table('web_client_sessions')->where('server_ip',$request->server_ip)->where('session_name',$request->session_name)->delete();
       
         //5-
        ##### Hangup the client phone
        /*$Livechanel =  DB::table('live_sip_channels')->where('server_ip',$request->server_ip)->where('channel','LIKE',$request->protocol.'/'.$request->extension)->orderBy('channel','DESC')->first();

       

        $agent_channel = $Livechanel->channel;
         $TEMP_SIP_user_DiaL = 'Local/55558600051@default';
  
        $vici_manager = DB::table('vicidial_manager')->where('cmd_line_b',$request->protocol.'/'.$request->extension)->update([
              'status' => 'DEAD',
            ]);
        $timezone  = +2;
        $now =  gmdate("Y-m-j H:i:s", time() + 3600*($timezone+date("I")));
        $NOW_TIME = $now;
        $vici_manager = DB::table('vicidial_manager')->insert([
              
              'uniqueid' => '', 
              'entry_date' => $NOW_TIME,
              'status' => 'SENT',
              'response' => 'N',
              'server_ip' => $request->server_ip,
              'channel' => '',
              'action' => 'Hangup',
              'callerid' => 'ULGH3459'.$StarTtime,
              'cmd_line_b' => 'Channel: '.$request->protocol.'/'.$request->extension,
              'cmd_line_c' => '',
              'cmd_line_d' => '',
              'cmd_line_e' => '',
              'cmd_line_f' => '',
              'cmd_line_g' => '',
              'cmd_line_h' => '',
              'cmd_line_i' => '',
              'cmd_line_j' => '',
              'cmd_line_k' => ''
        ]);

        $vici_manager = DB::table('vicidial_manager')->insert([
             
              'uniqueid' => '', 
              'entry_date' => $NOW_TIME,
              'status' => 'UPDATED',
              'response' => 'N',
              'server_ip' => $request->server_ip,
              'channel' => $TEMP_SIP_user_DiaL,
              'action' => 'Originate',
              'callerid' => 'ULGH3458'.$StarTtime,
              'cmd_line_b' => 'Channel: '.$TEMP_SIP_user_DiaL,
              'cmd_line_c' => 'Context: default',
              'cmd_line_d' => 'Exten: 8300',
              'cmd_line_e' => 'Priority: 1',
              'cmd_line_f' => 'Callerid: ULGH3458'.$StarTtime,
              'cmd_line_g' => '',
              'cmd_line_h' => '',
              'cmd_line_i' => '',
              'cmd_line_j' => '',
              'cmd_line_k' => ''
        ]);

        
       

            
            sleep(1);

            //6-
            $agent_log = DB::table('vicidial_live_agents')->where('server_ip',$request->server_ip)->where('user',$request->user)->first();
            //return response()->json($agent_log);
            $agent_log_id = $agent_log->agent_log_id;
            $deletedLiveAgent = DB::table('vicidial_live_agents')->where('server_ip',$request->server_ip)->where('user',$request->user)->delete();
            //7-
            ##### Delete the vicidial_live_inbound_agents records for this session
            $deletedLiveAgent = DB::table('vicidial_live_inbound_agents')->where('user',$request->user)->delete();

        //8-
            $pause_sec=0;

            $AgentLog = DB::table('vicidial_agent_log')->where('agent_log_id','>=',$agent_log_id)->where('user',$request->user)->first();
           
        if ((!empty($AgentLog)) and (strlen($AgentLog->talk_epoch<5)) and (strlen($AgentLog->dispo_epoch<5)) )
            {
            $agent_log_id = $AgentLog->agent_log_id;
            $pause_sec = (($StarTtime - $AgentLog->pause_epoch) + $AgentLog->pause_sec);

            $vicidial_agent_log = DB::table('vicidial_agent_log')->where('agent_log_id',$agent_log_id)
                ->update([
                    'pause_sec'   => $pause_sec,
                    'wait_epoch'  => $StarTtime
                 ]);
            }
        
    }*/
}
