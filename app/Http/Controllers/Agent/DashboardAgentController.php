<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use GuzzleHttp\Client;
class DashboardAgentController extends Controller
{


    //private $SERVER1 = 'https://call3.callbk.tk/';
    private $SERVER2 = 'https://call3.harmoniecrm.com'; //// url utilisée pour l'api
    
    public function index(){
       //dd(Session::all());
        $data = [];
       
       //// envoyer une requete a l'api pour obtenir le status de l'agent
        $http = new \GuzzleHttp\Client();
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_status', [
            'form_params' => [
                'user' => Session::get('user'),
                'server_ip' => Session::get('server_ip'),
            ],
        ]);
        //////récupere le resultat de la requete
        $content = $response->getBody()->getcontents();
        ///// transformer le contenu en json
        $contents = json_decode($content);
        //dd($contents);
        if($contents->etat == 500){
            return redirect()->route('agent.login'); /// redirection vers la page login si etat == 500 (mot de passe ou usename incorrecte)
        }else{
            if(!empty(Session::get('user'))){ //// verifier si la session contient des données
                $data['user'] = Session::get('user');
                $data['campaign'] = Session::get('campaign');
                $data['server_ip'] = Session::get('server_ip');
                $data['conf_exten'] = Session::get('conf_exten');
                $data['extension'] = Session::get('extension');
                $data['session_name'] = Session::get('session_name');
                $data['protocol'] = Session::get('protocol');
                $data['full_name'] = Session::get('full_name');
                $data['etat'] = Session::get('etat');
                $data['msg'] = Session::get('msg');
                 //// envoyer une requete a l'api pour obtenir le status de l'agent
                $http = new \GuzzleHttp\Client();
                $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_status', [
                    'form_params' => [
                        'user' => Session::get('user'),
                        'server_ip' => Session::get('server_ip'),
                    ],
                ]);
                //////récupere le resultat de la requete
                $content = $response->getBody()->getcontents();
                ///// transformer le contenu en json
                $contents = json_decode($content);

                /////get list of campaigns status
                $responseCampStatus = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_campaigns_status', [
                    'form_params' => [
                        'user' => Session::get('user'),
                        'campaign' => Session::get('campaign'),
                        'server_ip' => Session::get('server_ip'),
                    ],
                ]);
                //dd(Session::get('campaign'));
                $contentStatus = $responseCampStatus->getBody()->getcontents();
                $contentCampStatus = json_decode($contentStatus);
                $data['statuses'] = $contentCampStatus->statuses;
                //dd($contentCampStatus);
                $httpCallLog = new \GuzzleHttp\Client();
                $responseCallLog = $httpCallLog->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_call_logs', [
                    'form_params' => [
                        'user' => Session::get('user'),
                        'server_ip' => Session::get('server_ip'),
                        'campaign' => Session::get('campaign'),
                    ],
                ]);
                $contentCallLogs = $responseCallLog->getBody()->getcontents();
                $contentCampStatus = json_decode($contentCallLogs);
                $data['calllogs'] = $contentCampStatus->calllogs;
                $http = new \GuzzleHttp\Client();
                $responsePauseCode = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_pauses_codes', [
                    'form_params' => [
                        'user' => Session::get('user'),
                        'server_ip' => Session::get('server_ip'),
                        'campaign' => Session::get('campaign'),
                    ],
                ]);
                $contentPauses = $responsePauseCode->getBody()->getcontents();
                $contentPauses = json_decode($contentPauses);
                $data['pauses'] = $contentPauses->pauses;
                //dd($data['pauses']=="");
                if($contents->etat == 200){
                    /// si l'etat == 200, envoyer une requete a l'api agent pour obtenir l'url de webphone
                    $responseWebPhone = $http->get('https://call3.harmoniecrm.com/agc/api.php?source=call3&user=6666&pass=0551797726&agent_user='.Session::get('user').'&function=webphone_url&value=DISPLAY');
                    
                    $data['WebPhonEurl'] = $responseWebPhone->getBody()->getcontents(); /// webphone url (viciphone)
                    ///// envoyer une requete a l'api pour connecter au webphone
                    $responseCallAgent = $http->get('https://call3.harmoniecrm.com/agc/api.php?source=call3&user=6666&pass=0551797726&agent_user='.Session::get('user').'&function=call_agent&value=CALL');
                    //dd($data['WebPhonEurl']);
                    $data['etatAgent'] = $contents->status;
                   
                }else{
                    $data['etatAgent'] = 'error';
                }
                
            }else{
                return redirect()->route('agent.login');
            }
        }
        ///// envoyer une requete pour récuperer les rappele (callback) de l'agent et les afficher sur le calendrier
        $responseCAllback = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_callbacks', [
            'form_params' => [
                'user' => Session::get('user'),
                'campaign' => Session::get('campaign'),
                'server_ip' => Session::get('server_ip'),
            ],
        ]);
        $contentcallback = $responseCAllback->getBody()->getcontents();
        $contentcallbacks = json_decode($contentcallback);
        //dd($contentcallbacks);
        if($contentcallbacks->etat == 200){
            $data['callbacks'] = $contentcallbacks->callbacks;
        }else{
            $data['callbacks'] = '';
        }
        return view('Agent.index',$data);
    }

    ///// fonction qui permet d'activer un code pause
    public function ChangePauseCode($pause_code){

        $http = new \GuzzleHttp\Client();
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/change_pause_code', [
            'form_params' => [
                'user' => Session::get('user'),
                'pass' => Session::get('pass'),
                'phone_login' => Session::get('phone_login'),
                'phone_pass' => Session::get('phone_pass'),
                'campaign' => Session::get('campaign'),
                'server_ip' => Session::get('server_ip'),
                'conf_exten' => Session::get('conf_exten'),
                'extension' => Session::get('extension'),
                'session_name' => Session::get('session_name'),
                'protocol' => Session::get('protocol'),
                'agent_log_id' => Session::get('agent_log_id'),
                'pause_code' => $pause_code,
            ],
        ]);
        $content = $response->getBody()->getcontents();
        $contents = json_decode($content);
        $data['etat'] = $contents->etat;
        $data['pause_code'] = $contents->pause_code;
        return response()->json($data);
    }
    //// fonction qui récuperer la liste des channel live pour un agent 
    public function getChannelLive(){
        $http = new \GuzzleHttp\Client();
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_channel_live', [
            'form_params' => [
                'server_ip' => Session::get('server_ip'),
                'conf_exten' => Session::get('conf_exten'),
            ],
        ]);
        $content = $response->getBody()->getcontents();
        $contents = json_decode($content);
        //dd($content);
        $data = [];
        $data['etat'] = $contents->etat;
        $data['channels'] = $contents->channels;
        return response()->json($data);
           
    }
    //// fonction qui activer le webphone apres 5 sec de l'actualisation de la page ou lors de clique sur button webphone
    public function activateWebphone(){

        $http = new \GuzzleHttp\Client();
        $responseWebPhone = $http->post('https://call3.harmoniecrm.com/agc/api.php?source=call3&user=6666&pass=0551797726&agent_user='.Session::get('user').'&function=call_agent&value=CALL');
        /*$response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/activate_webphone', [
            'form_params' => [
                'user' => Session::get('user'),
                'pass' => Session::get('pass'),
                'campaign' => Session::get('campaign'),
                'server_ip' => Session::get('server_ip'),
                'conf_exten' => Session::get('conf_exten'),
                'extension' => Session::get('extension'),
                'phone_login' => Session::get('phone_login'),
                'phone_pass' => Session::get('phone_pass'),
                'session_name' => Session::get('session_name'),
                'protocol' => Session::get('protocol'),
            ],
        ]);*/
        $content = $responseWebPhone->getBody()->getcontents();

        $contents = json_decode($content);

        $data['etat'] = 200;
        return response()->json($data);
    }
    //// fonction qui récuperer le status de l'agent
    public function getAgentStatus(){
        $http = new \GuzzleHttp\Client();
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_status', [
            'form_params' => [
                'user' => Session::get('user'),
                'server_ip' => Session::get('server_ip'),
            ],
        ]);
        $content = $response->getBody()->getcontents();
        $contents = json_decode($content);
    
        if($contents->etat == 200){
            $data['etatAgent'] = $contents->status;
        }else{
            $data['etatAgent'] = 'error';
        }
        $data['etat'] = $contents->etat;
        return response()->json($data);
    }

    /// fonction logout
    public function logout(){
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/logout', [
            'form_params' => [
                'user' => Session::get('user'),
                'pass' => Session::get('pass'),
                'phone_login' => Session::get('phone_login'),
                'phone_pass' => Session::get('phone_pass'),
                'campaign' => Session::get('campaign'),
                'server_ip' => Session::get('server_ip'),
                'conf_exten' => Session::get('conf_exten'),
                'extension' => Session::get('extension'),
                'session_name' => Session::get('session_name'),
                'protocol' => Session::get('protocol'),
                'agent_log_id' => Session::get('agent_log_id'),
            ],
        ]);

        $content = $response->getBody()->getcontents();
        //dd($content);
        //$response = $http->post('https://call3.harmoniecrm.com//agc/api.php?source=call3&user='.$request->user.'&pass='.$request->pass.'&agent_user='.$request->user.'&function=logout&value=LOGOUT');
        //Session::flush();

        Session::forget('user');
        Session::forget('campaign');
        Session::forget('phone_pass');
        Session::forget('pass');
        Session::forget('session_name');
        Session::forget('server_ip');
        Session::forget('phone_login');
        Session::forget('agent_log_id');
        Session::forget('conf_exten');
        Session::forget('extension');
        Session::forget('protocol');
       // dd($response->getBody()->getcontents());
        return redirect()->route('agent.login');
    }

    //// fonction qui change le status de l'agent
    public function ChangeStatus($etatAgent){
  
        $value = '';
        if($etatAgent == 'PAUSED'){
            $VDRP_stage = 'READY';
            $temp_auto = 1;
            $temp_auto_code = 'NXDIAL';
            $VDRP_stage = 'READY';
            $AutoDialReady = 1;
			$AutoDialWaiting = 1;
            $VDRP_stage_seconds = 0;
            $ACTION = 'VDADready';
            $safe_pause_counter = 0;
        }elseif($etatAgent == 'READY'){
            $VDRP_stage = 'PAUSED';
            $temp_auto = 1;
            $temp_auto_code = 'RQUEUE';
            $VDRP_stage = 'PAUSED';
			$AutoDialReady = 0;
			$AutoDialWaiting = 0;
			$pause_code_counter = 0;
            $ACTION = 'VDADpause';
        }else{
            $VDRP_stage = '';
            $temp_auto = '';
            $temp_auto_code = '';
            $VDRP_stage = '';
            $AutoDialReady = '';
			$AutoDialWaiting = '';
            $VDRP_stage_seconds = '';
            $safe_pause_counter = '';
        }
       //dd(Session::all());
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/update_status', [
            'form_params' => [
                'user' => Session::get('user'),
                'pass' => Session::get('phone_pass'),
                'agent_log_id' => Session::get('agent_log_id'),
                'campaign' => Session::get('campaign'),
                'session_name' => Session::get('session_name'),
                'stage' => $VDRP_stage,
                'VDRP_stage' => $VDRP_stage,
                'AutoDialReady' => $AutoDialReady,
                'AutoDialWaiting' => $AutoDialWaiting,
                'temp_auto' => $temp_auto,
                'action' => $ACTION,
                'temp_auto_code' => $temp_auto_code,
                'qm_extension' => Session::get('extension'),
                'server_ip' => Session::get('server_ip'),
            ],
        ]);
        $content = $response->getBody()->getcontents();
        //dd($content);
        if(str_contains($content,'READY')){
            $data['etatAgent'] = 'READY';
           
        }elseif(str_contains($content,'PAUSED')){
            $data['etatAgent'] = 'PAUSED';
            Session::forget('agent_log_id');
            $content = explode(':',$content);
            $content = explode('\n',$content[1]);
            $data['agent_log_id'] = $content[1];
            Session::put('agent_log_id', $data['agent_log_id']);
            

        }else{
            $data['etatAgent'] = $etatAgent;
        }
       
        $data['etat'] = 200;
        return response()->json($data);
    }
    public function ChangeStatusAjax($etatAgent){
  
        $value = '';
        if($etatAgent == 'PAUSED'){
            $VDRP_stage = 'READY';
            $temp_auto = 1;
            $temp_auto_code = 'NXDIAL';
            $VDRP_stage = 'READY';
            $AutoDialReady = 1;
            $AutoDialWaiting = 1;
            $VDRP_stage_seconds = 0;
            $safe_pause_counter = 0;
        }elseif($etatAgent == 'READY'){
            $VDRP_stage = 'PAUSED';
            $temp_auto = 1;
            $temp_auto_code = 'RQUEUE';
            $VDRP_stage = 'PAUSED';
            $AutoDialReady = 0;
            $AutoDialWaiting = 0;
            $pause_code_counter = 0;
        }
       //dd(Session::all());
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/refresh', [
            'form_params' => [
                'user' => Session::get('user'),
                'pass' => Session::get('phone_pass'),
                'agent_log_id' => Session::get('agent_log_id'),
                'campaign' => Session::get('campaign'),
                'session_name' => Session::get('session_name'),
                'stage' => $VDRP_stage,
                'VDRP_stage' => $VDRP_stage,
                'AutoDialReady' => $AutoDialReady,
                'AutoDialWaiting' => $AutoDialWaiting,
                'temp_auto' => $temp_auto,
                'temp_auto_code' => $temp_auto_code,
                'qm_extension' => Session::get('extension'),
                'server_ip' => Session::get('server_ip'),
            ],
        ]);
        $content = $response->getBody()->getcontents();
        
        if(str_contains($content,'READY')){
            $data['etatAgent'] = 'READY';
        }elseif(str_contains($content,'PAUSED')){
            $data['etatAgent'] = 'PAUSED';
        }
        
        return response()->json($data);
    }
    //// fonction qui récuperer les information d'un fiche a partir de lead_id
    public function get_contact_informations()
    {

        if(!empty(Session::get('user'))){
            $user = Session::get('user');
            $http = new \GuzzleHttp\Client();
            $response = $http->post($this->SERVER2.'/vicidial/non_agent_api.php?source=call3&user=6666&pass=0551797726&function=agent_status&agent_user='.$user.'&stage=csv&header=YES');
            //$contentType = $response->getHeaders()['content-type'][0];
            $content = $response->getBody()->getContents();
            
            $j_encoded = json_encode(utf8_encode($content));
            $content_encoded = explode('"',$j_encoded);
            try {
                $content_encoded = explode('\n',$content_encoded[1]);
                $content_encoded = explode(',',$content_encoded[1]);
                $lead_id = $content_encoded[2];
                return response()->json($lead_id);
                if($lead_id != 0){
                    $http = new \GuzzleHttp\Client();
                    $response = $http->post($this->SERVER2.'/vicidial/non_agent_api.php?source=call3&user=6666&pass=0551797capital&function=lead_all_info&lead_id='.$lead_id.'&header=YES&custom_fields=Y');
                    //$contentType = $response->getHeaders()['content-type'][0];
                    $content = $response->getBody()->getContents();
                  
                    $contact = [];
                    $j_encoded = json_encode(utf8_encode($content));
                    $content_encoded = explode('"',$j_encoded);
                  // dd($j_encoded);
                    $content_encoded = explode('\n',$content_encoded[1]);
                    //dd($content_encoded[1]);
                    $content_encoded = explode('|',$content_encoded[1]);
                    
                    $contact['status'] = $content_encoded[0];
                    $contact['user'] = $content_encoded[1];
                    $contact['vendor_lead_code'] = $content_encoded[2];
                    $contact['source_id'] = $content_encoded[3];
                    $contact['list_id'] = $content_encoded[4];
                    $contact['gmt_offset_now'] = $content_encoded[5];
                    $contact['phone_code'] = $content_encoded[6];
                    $contact['phone_number'] = $content_encoded[7];
                    $contact['title'] = $content_encoded[8];
                    $contact['first_name'] = $content_encoded[9];
                    $contact['middle_initial'] = $content_encoded[10];
                    $contact['last_name'] = $content_encoded[11];
                    $contact['address1'] = $content_encoded[12];
                    $contact['address2'] = $content_encoded[13];
                    $contact['address3'] = $content_encoded[14];
                    $contact['city'] = $content_encoded[15];
                    $contact['state'] = $content_encoded[16];
                    $contact['province'] = $content_encoded[17];
                    $contact['postal_code'] = $content_encoded[18];
                    $contact['country_code'] = $content_encoded[19];
                    $contact['gender'] = $content_encoded[20];
                    $contact['date_of_birth'] = $content_encoded[21];
                    $contact['alt_phone'] = $content_encoded[22];
                    $contact['email'] = $content_encoded[23];
                    $contact['security_phrase'] = $content_encoded[24];
                    $contact['comments'] = $content_encoded[25];
                    $contact['called_count'] = $content_encoded[26];
                    $contact['last_local_call_time'] = $content_encoded[27];
                    $contact['rank'] = $content_encoded[28];
                    $contact['owner'] = $content_encoded[29];
                    $contact['entry_list_id'] = $content_encoded[30];
                    $contact['lead_id'] = $content_encoded[31];
                    $contact['etat'] = 200;
                    return response()->json($contact);
                }else{
                    $contact['etat'] = 403;
                    $contact['msg'] = "L'agent est en pause";
                    return response()->json($contact);
                }



            } catch (\Throwable $th) {
                $contact['etat'] = 403;
                $contact['msg'] = "L'agent n'est pas connecter";
                return response()->json($contact);
            }
        }else{
            $contact['msg'] = 'Aucun session existe';
            $contact['etat'] = 401;
            return response()->json($contact);
        }       
    }
    //// fonction qui refresh le random_id in vicidial_live_agent chaque 1 second
    public function refreshIncall(){
        if(!empty(Session::get('user'))){
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/refresh_incall', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'server_ip' => Session::get('server_ip'),
                ],
            ]);
            $content = $response->getBody()->getcontents();
            $content = json_decode($content);
            $data = [];
            $data['etat'] = $content->etat;
            
            return response()->json($data);

        }
    }
    //// fonction qui récuperer channel de l'appel pour un agent
    public function getChannel(){
        if(!empty(Session::get('user'))){
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_channel', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'server_ip' => Session::get('server_ip'),
                ],
            ]);
            $content = $response->getBody()->getcontents();
            $content = json_decode($content);
            $data = [];
            $data['etat'] = $content->etat;
            $data['msg']  = $content->msg;
            $data['channel'] = $content->channel;
            $data['lead_id'] = $content->lead_id;
            
            return response()->json($data);

        }
    }
    //// change status to incall for agent
    public function ChangeIncall(){
        if(!empty(Session::get('user'))){
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/change_to_incall', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'pass' => Session::get('pass'),
                    'phone_login' => Session::get('phone_login'),
                    'phone_pass' => Session::get('phone_pass'),
                    'agent_log_id' => Session::get('agent_log_id'),
                    'campaign' => Session::get('campaign'),
                    'session_name' => Session::get('session_name'),
                    'conf_exten' => Session::get('conf_exten'),
                    'extension' => Session::get('extension'),
                    'server_ip' => Session::get('server_ip'),
                ],
            ]);
            $content = $response->getBody()->getcontents();
            //dd($content);
            $content = json_decode($content);
            $data = [];
            $data['etat'] = $content->etat;
            $data['msg']  = $content->msg;
            if($data['etat'] == 200){
                $data['id_total'] = $content->id_total;
                $data['list_id'] = $content->list_id;
                $data['called_count'] = $content->called_count;
                $data['uniqueid'] = $content->uniqueid;
                $data['lead_id'] = $content->lead_id;
                //$data['gender'] = $content->gender;
                $data['adr1_civilite_abrv'] = $content->adr1_civilite_abrv;
                $data['contact_nom'] = $content->contact_nom;
                $data['contact_prenom'] = $content->contact_prenom;
                
                
                $data['adr2'] = $content->adr2;
                $data['adr3'] = $content->adr3;
                $data['adr4_libelle_voie'] = $content->adr4_libelle_voie;
                $data['adr5'] = $content->adr5;
                $data['contact_cp'] = $content->contact_cp;
                $data['contact_ville'] = $content->contact_ville;
                $data['contact_tel'] = $content->contact_tel;
               
                $data['contact_email'] = $content->contact_email;
                 $data['new_adr1_civilite_abrv'] = $content->new_adr1_civilite_abrv;
                 $data['new_contact_prenom'] = $content->new_contact_prenom;
                 $data['new_contact_nom'] = $content->new_contact_nom;
                 $data['new_raison_sociale'] = $content->new_raison_sociale;
                 $data['new_professionnel'] = $content->new_professionnel;
                 $data['new_activite1'] = $content->new_activite1;
                 $data['new_adr2'] = $content->new_adr2;
                 $data['new_adr3'] = $content->new_adr3;
                 $data['new_adr4_libelle_voie'] = $content->new_adr4_libelle_voie;
                 $data['new_adr5'] = $content->new_adr5;
                 $data['new_contact_cp'] = $content->new_contact_cp;
                 $data['new_contact_ville'] = $content->new_contact_ville;
                 $data['new_contact_tel'] = $content->new_contact_tel;
                 $data['new_contact_tel_port'] = $content->new_contact_tel_port;
                 $data['new_contact_email'] = $content->new_contact_email;
                 $data['new_tel2'] = $content->new_tel2;
                //$data['commentaire'] = $content->commentaire;
                $data['agentchannel'] = $content->agentchannel;
                $data['campaign'] = Session::get('campaign');
                if(Session::get('campaign') == 1000101){
                    $data['tel1'] = $content->tel1;
                    $data['raison_sociale'] = $content->raison_sociale;
                    $data['commentaire'] = $content->commentaire;
                    $data['professionnel'] = $content->professionnel;
                }elseif(Session::get('campaign') == 2000202){
                    $data['Commentaire_call1'] = $content->Commentaire_call1;
                    $data['contact_qualif1'] = $content->contact_qualif1;
                    $data['contact_qualif2'] = $content->contact_qualif2;
                    $data['accord_montant'] = $content->accord_montant;
                    $data['pa_montant'] = $content->pa_montant;
                    //$data['frequence_pa'] = $content->frequence_pa;
                    //$data['accord_montant'] = $content->accord_montant;
                    $data['AcceuilTELEPHONE_PORTABLE'] = $content->AcceuilTELEPHONE_PORTABLE;
                }
                elseif(Session::get('campaign') == 3000303){
                    
                    $data['pa_montant'] = $content->pa_montant;
                    $data['frequence_pa'] = $content->frequence_pa;
                }
                return response()->json($data);
            }
            
            return response()->json($data);
            
            

        }
    }
    /////// recuperer le temps d'appel de  l'agent (status == Incall)
    public function getTimeIncall($lead_id){
        //dd($lead_id);
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_time_incall', [
            'form_params' => [
                'user' => Session::get('user'),
                'lead_id' => $lead_id,
            ],
        ]);
        $content = $response->getBody()->getcontents();
        $content = json_decode($content); 

        $timezone  = +1;
        $now =  gmdate("H:i:s", time() + 3600*($timezone+date("I")));
        $lastcall = explode(':',$content);
        $timeInSec = ($lastcall[0]*3600)+($lastcall[1]*60)+$lastcall[2];

        $nowTime = explode(':',$now);
        $nowInSec = ($nowTime[0]*3600)+($nowTime[1]*60)+$nowTime[2];
        $diff = $nowInSec - $timeInSec;
        $data = [];
        $data['time'] = $diff;
        $data['etat'] = 200;
        return response()->json($data);
    }
    /////// recuperer le chrono de l'agent (n'import quel status)
    public function getTimeAgent(){
        //dd($lead_id);
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_time_incall', [
            'form_params' => [
                'user' => Session::get('user'),
            ],
        ]);
        $content = $response->getBody()->getcontents();
        $content = json_decode($content); 

        $timezone  = +1;
        $now =  gmdate("H:i:s", time() + 3600*($timezone+date("I")));
        $lastcall = explode(':',$content);
        $timeInSec = ($lastcall[0]*3600)+($lastcall[1]*60)+$lastcall[2];

        $nowTime = explode(':',$now);
        $nowInSec = ($nowTime[0]*3600)+($nowTime[1]*60)+$nowTime[2];
        $diff = $nowInSec - $timeInSec;
        $data = [];
        $data['time'] = $diff;
        $data['etat'] = 200;
        return response()->json($data);
    }
    //// fonction qui couper l'appel par l'agent (hangup)
    public function hangup(Request $request){
        //dd(Session::get('user'));
        if(!empty(Session::get('user'))){
            $channel = $request->channel;
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/hangup', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'pass' => Session::get('pass'),
                    'campaign' => Session::get('campaign'),
                    'server_ip' => Session::get('server_ip'),
                    'conf_exten' => Session::get('conf_exten'),
                    'extension' => Session::get('extension'),
                    'session_name' => Session::get('session_name'),
                    'protocol' => Session::get('protocol'),
                    'agent_log_id' => Session::get('agent_log_id'),
                    'lead_id' => $request->lead_id,//////
                    'list_id' => $request->list_id,/////
                    'phone_login' => Session::get('phone_login'),
                    'phone_pass'  => Session::get('phone_pass'),
                    'called_count' => $request->called_count,///
                    'uniqueid' => $request->uniqueid,///
                    'uniqueid1' => $request->uniqueid1,///
                    'phone_number' => $request->phone_number,
                    'phone_code' => $request->phone_code,
                    'agentchannel' => $request->agentchannel,
                    'channel'  => $channel
                ],
            ]);
            $content = $response->getBody()->getcontents();
            //dd($content);
            $content = json_decode($content);
            
            $data = [];
            $data['statuses'] = $content->statuses;
            $data['etat'] = $content->etat;
            $data['msg'] = 'Hangup with success';
            return response()->json($data);

        }
    }

    //// fonction qui modifier le status de la fiche (Qualification)
    public function UpdateDispo(Request $request)
    {      
        //dd(Session::get('campaign'));
       if(!$request->dispo_choice ||  $request->dispo_choice == null){
            $data['etat'] = 401;
            $data['msg'] = 'stp, veuillez qualifiez votre fiche !!';
            return response()->json($data);
       }
        $dispo_choice = '';
        if($request->dispo_choice == "CALLBK"){
            $dispo_choice1 = "CBHOLD";
        }else{
            $dispo_choice1 = $request->dispo_choice;
        }

        $comments = $request->comments ? $request->comments : '';
        $CallBackrecipient = $request->CallBackrecipient ? $request->CallBackrecipient : '';
        $CallBackLeadStatus = $dispo_choice1;
        //dd($dispo_choice);
        $CallBackDatETimE = $request->date.' '.$request->hour.':00';
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/Update_dispo', [
            'form_params' => [
                'server_ip' => Session::get('server_ip'),
                'session_name' => Session::get('session_name'),
                'user' => Session::get('user'),
                'pass' => Session::get('pass'),
                'orig_pass' => Session::get('pass'),
                'dispo_choice' => $dispo_choice1,
                'lead_id'      => $request->lead_id,
                'campaign' => Session::get('campaign'),
                'agent_log_id' => Session::get('agent_log_id'),
                'list_id'         => $request->list_id,////*
                'stage'           => Session::get('campaign'),
                'uniqueid'        => $request->uniqueid, /////
                'uniqueid1'        => $request->uniqueid1, /////
                'called_count'    => $request->called_count,////*
                'phone_login'     => Session::get('phone_login'),///
                'conf_exten'        => Session::get('conf_exten'),
                'exten'             => Session::get('extension'),
                'original_phone_login'=> Session::get('phone_login'),///
                'phone_pass'        => Session::get('phone_pass'),///
                'CallBackDatETimE' => $CallBackDatETimE,
                'CallBackrecipient' => $CallBackrecipient,
                'CallBackLeadStatus'=> $CallBackLeadStatus,
                'comments' => $comments,
            ],
        ]);

            if($request->agent_status == 1){
                $agent_status = 'READY';

                $changeStatus = $this->ChangeStatus($agent_status);


            }else{
                $agent_status = 'PAUSED';
                $changeStatus = $this->ChangeStatus($agent_status);
            }

            $changeStatus = $changeStatus->getContent();
            $changeStatus = json_decode($changeStatus);

            $status = $response->getStatusCode();
            $content = $response->getBody()->getContents();
            $content = json_decode($content);
            //dd($content);
            if($content->etat == 200 ){
                $data['etat'] = 200;
                $data['changeStatus'] = $changeStatus;
                $data['msg'] = "L'appel est qualifié avec succés";
                $data['dispo_choice'] = $content->dispo_choice;
                $data['etatAgent'] = $changeStatus->etatAgent;
                return response()->json($data);

            }else{
                $data['etat'] = 500;
                $data['msg'] = "erreur de serveur, veuillez contactez le support téchnique !";
                $data['etatAgent'] = '';
                return response()->json($data);

            }
    }
    public function updateQualifContact(Request $request){

        $dispo_choice = '';
        if($request->qualif == "CALLBK"){
            $dispo_choice1 = "CBHOLD";
        }else{
            $dispo_choice1 = $request->sub_qualif;
        }
        //dd($dispo_choice1);
        $comments = $request->comments ? $request->comments : '';
        $CallBackrecipient = $request->CallBackrecipient ? $request->CallBackrecipient : '';
        $CallBackLeadStatus = $dispo_choice1;
        
        $CallBackDatETimE = $request->date.' '.$request->hour.':00';
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/update_qualif_contact', [
            'form_params' => [
               
                'user' => Session::get('user'),
                'dispo_choice' => $dispo_choice1,
                'lead_id'      => $request->lead_id,
                'campaign' => Session::get('campaign'),
                'list_id'         => $request->list_id,
                'CallBackDatETimE' => $CallBackDatETimE,
                'CallBackrecipient' => $CallBackrecipient,
                'CallBackLeadStatus'=> $CallBackLeadStatus,
                'comments' => $comments,
                'campaign' => Session::get('campaign'),
            ],
        ]);  
        $status = $response->getStatusCode();
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        if($content->etat == 200){
            return redirect()->back()->with(['success'=>$content->msg]);
        }else{
            return redirect()->back()->with(['error'=>'erreur de systeme, veuillez contactez le support technique !']);
        }
    }
    //// fonction qui récuperer les information d'un fiche a partir de lead_id
    public function getLeadInfo($lead_id){
        if($lead_id && $lead_id>0){
            $data = [];
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_lead_info', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'lead_id' => $lead_id,
                    'campaign' => Session::get('campaign'),
                ],
            ]);
            
            
            
            $content = $response->getBody()->getcontents();
            $content = json_decode($content);
            //dd($content);
            /////get list of campaigns status
            /*$responseCampStatus = $http->get('https://call3.harmoniecrm.com/harmony_api/index.php/get_campaigns_status', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'server_ip' => Session::get('server_ip'),
                ],
            ]);
            $contentStatus = $responseCampStatus->getBody()->getcontents();
            $contentCampStatus = json_decode($contentStatus);
            $data['statuses'] = $contentCampStatus->statuses;*/
           
            if($content->etat == 200){
            $data['uniqueid'] = $content->uniqueid;
            $data['lead'] = $content->lead;
            $data['etat'] = $content->etat;
            $data['campaign'] = Session::get('campaign');
            //dd($data);
            }else{
               $data['etat'] = $content->etat; 
            }
            //return view('Agent.show_contact',$data);
            return response()->json($data);
        }
    }

    //recuperer les information de contact a partir de l'url envoyée
    public function MsgContact(Request $request){
        $data = [];
        $data['email'] = /*'louanes.mokhfi@gmail.com';//*/$request->new_contact_email == null ? $request->contact_email : $request->new_contact_email; 
        $data['nom'] = /*'louanes';//*/$request->new_contact_nom == null ? $request->contact_nom : $request->new_contact_nom;
        $data['prenom'] = /*'mokhfi';//*/$request->new_contact_prenom == null ? $request->contact_prenom : $request->new_contact_prenom;
        $data['adr4'] = /*'35+CHE+DU+PAROIS';//*/$request->adr4_libelle_voie;
        $data['adr5'] = $request->adr5;
        $data['cp'] = $request->new_contact_cp == null ? $request->contact_cp : $request->new_contact_cp;
        $data['ville'] = $request->new_contact_ville == null ? $request->contact_ville : $request->new_contact_ville;
        $data['idtotal'] = /*'510344916';//*/$request->id_total;
        $data['civilite'] = 'U';//$request->gender;
        $data['mail'] = $request->new_contact_email == null ? $request->contact_email : $request->new_contact_email;
        $data['montant'] = $request->accord_montant;
        $data['assoc'] = /*'UNADEV';//*/$request->pour_client;
        $data['centre'] = /*'';//*/$request->pour_centre;
        $data['ope'] = /*'UNADEV+conquete';//*/$request->operation;
        $data['code'] =/*'FDS_UN_2201_P';//*/$request->code_marketing;
        $data['port'] = $request->contact_tel1 == null ? $request->tel1 : $request->contact_tel1;
        
        return view('Agent.msg_contact.index',$data);
    }

    //// envoyer un message au client (mail ou sms)
    public function SendMsg(Request $request){
        // dd($request->first_name);
        $email = $request->email; 
        $nom = $request->nom;
        $prenom = $request->prenom;
        $adr4 = $request->adr4;
        $adr5 = $request->adr5;
        $cp = $request->cp;
        $ville = $request->ville;
        $idtotal = $request->idtotal;
        $civilite = $request->civilite;
        $mail = $request->mail;
        $montant = /*'';//*/$request->montant;
        //$pa_montant = /*'';//*/$request->pa_montant;
        //$frequence_pa = /*'';//*/$request->frequence_pa;
        $assoc = $request->assoc;
        $centre = $request->centre;
        $ope = $request->ope;
        $code = $request->code;
        $port = $request->port;
        $type_function = $request->type_function;
        $http = new \GuzzleHttp\Client(); 
        if($type_function == "mail_info"){     
            $mail_info = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=mail_information&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=".$montant."&pamontant=&frequence=+&typeaccord=+&comment=";
            $response = $http->post($mail_info);
            $content = $response->getBody()->getContents();
            //dd($content);
            return redirect()->back()->with(['msg'=>$content]);
            
        }elseif($type_function == "sms_info"){ 
            $sms_info= "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=sms_information&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=".$port."&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=".$montant."&pamontant=&frequence=+&typeaccord=+&comment=";
            $response = $http->post($sms_info);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msg'=>$content]);
        }
        elseif($type_function == "mail_promesse"){   
            $mail_promesse = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=mail_promesse&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=".$montant."&pamontant=&frequence=+&typeaccord=+&comment=";
            $response = $http->post($mail_promesse);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msg'=>$content]);
        }
        elseif($type_function == "sms_promesse"){ 
            $sms_promesse = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=sms_promesse&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=".$port."&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=".$montant."&pamontant=&frequence=+&typeaccord=+&comment=";
            $response = $http->post($sms_promesse);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msg'=>$content]);
        }elseif($type_function == "mail_felicitation"){   
            $mail_felicitation = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=mail_felicitation&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=".$montant."&pamontant=&frequence=+&typeaccord=+&comment=";            
            $response = $http->post($mail_felicitation);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msg'=>$content]);
        }elseif($type_function == "sms_felicitation"){
            $sms_felicitation = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=sms_felicitation&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=".$port."&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=".$montant."&pamontant=&frequence=+&typeaccord=+&comment=";
            $response = $http->post($sms_felicitation);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msg'=>$content]);
        }elseif($type_function == "link_promesse"){
            $link_promesse = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=link_promesse&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=".$montant."&pamontant=&frequence=+&typeaccord=+&comment=";  
            $response = $http->post($link_promesse);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msg'=>$content]);
        }
    }
    public function SendMsgUnicef(Request $request){
        // dd($request->first_name);
        $email = $request->email; 
        $nom = $request->nom;
        $prenom = $request->prenom;
        $adr4 = $request->adr4;
        $adr5 = $request->adr5;
        $cp = $request->cp;
        $ville = $request->ville;
        $idtotal = $request->idtotal;
        $civilite = $request->civilite;
        $mail = $request->mail;
        $montant = /*'';//*/$request->montant;
        $assoc = $request->assoc;
        $centre = $request->centre;
        $ope = $request->ope;
        $code = $request->code;
        $port = $request->port;
        $type_function = $request->type_function;
        $http = new \GuzzleHttp\Client(); 
        if($type_function == "mail_info"){     
            $mail_info = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=mail_information&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=&pamontant=".$montant."&frequence=MENSUEL+&typeaccord=pa en ligne+&comment=";
            $response = $http->post($mail_info);
            $content = $response->getBody()->getContents();
            //dd($content);
            return redirect()->back()->with(['msgunicef'=>$content]);
            
        }elseif($type_function == "sms_info"){ 
            $sms_info= "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=sms_information&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=".$port."&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=&pamontant=".$montant."&frequence=MENSUEL+&typeaccord=pa en ligne+&comment=";
            $response = $http->post($sms_info);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msgunicef'=>$content]);
        }
        elseif($type_function == "mail_promesse"){   
            $mail_promesse = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=mail_promesse&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=&pamontant=".$montant."&frequence=MENSUEL+&typeaccord=pa en ligne+&comment=";
            $response = $http->post($mail_promesse);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msgunicef'=>$content]);
        }
        elseif($type_function == "sms_promesse"){ 
            $sms_promesse = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=sms_promesse&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=".$port."&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=&pamontant=".$montant."&frequence=MENSUEL+&typeaccord=pa en ligne+&comment=";
            $response = $http->post($sms_promesse);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msgunicef'=>$content]);
        }elseif($type_function == "mail_felicitation"){   
            $mail_felicitation = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=mail_felicitation&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=&pamontant=".$montant."&frequence=MENSUEL+&typeaccord=pa en ligne+&comment=";      
            $response = $http->post($mail_felicitation);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msgunicef'=>$content]);
        }elseif($type_function == "sms_felicitation"){
            $sms_felicitation = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=sms_felicitation&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=".$port."&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=&pamontant=".$montant."&frequence=MENSUEL+&typeaccord=pa en ligne+&comment=";
            $response = $http->post($sms_felicitation);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msgunicef'=>$content]);
        }elseif($type_function == "link_promesse"){
            $link_promesse = "https://api.fidelis-cc.fr/action.php?user=centre0&password=1pC1Bam9%C2%A2re=phoenix&function=link_promesse&civilite=M&nom=".$nom."&prenom=".$prenom."&adr4=".$adr4."&adr5=&cp=".$cp."&ville=".$ville."&port=&idtotal=".$idtotal."&assoc=".$assoc."&ope=".$ope."&code=".$code."&mail=".$email."&montant=&pamontant=".$montant."&frequence=MENSUEL+&typeaccord=pa en ligne+&comment=";
            $response = $http->post($link_promesse);
            $content = $response->getBody()->getContents();

            return redirect()->back()->with(['msgunicef'=>$content]);
        }
    }

    ////modification des informations pour une fiche et inserer les nouvelles informations 
    public function RegisternewInfoContact(Request $request){
        $http = new \GuzzleHttp\Client(); 

        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/update_lead_info', [
            'form_params' => [
                'user' => Session::get('user'),
                'campaign' => Session::get('campaign'),
                'lead_id' => $request->lead_id,
                'new_civilite'    => $request->new_civilite,
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
                'new_tel1' => $request->new_tel1,
                'new_contact_email' => $request->new_contact_email,
                'commentaire' => $request->commentaire,
                'cas_particulier' => $request->cas_particulier,
                //'type_accord' => $request->type_accord,
                //'envoi_courrier' => $request->envoi_courrier,
                'montant_don' => $request->montant_don,
                'pa_montant' => $request->montant_pa,
                'frequence_pa' => $request->frequence_pa,
                
            ],
        ]);

            $content = $response->getBody()->getcontents();
            $content = json_decode($content);
            //dd($content);
            $data = [];
            if($content->etat == 200){
                $data['etat'] = 200;
                $data['msg'] = "les informations de contact sont modifiées avec succès";
                return response()->json($data);
            }else{
                $data['etat'] = 500;
                $data['msg'] = "erreur de systeme ! les informations de contact ne sont pas enregistrer ";
                return response()->json($data);
            }
    }
    public function RegisternewInfoContactPost(Request $request){

        $http = new \GuzzleHttp\Client(); 

        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/update_lead_info', [
            'form_params' => [
                'user' => Session::get('user'),
                'campaign' => Session::get('campaign'),
                'lead_id' => $request->lead_id,
                'new_civilite'    => $request->new_civilite,
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
                'new_tel1' => $request->new_tel1,
                'new_contact_email' => $request->new_contact_email,
                'commentaire' => $request->commentaire,
                'cas_particulier' => $request->cas_particulier,
                //'type_accord' => $request->type_accord,
                //'envoi_courrier' => $request->envoi_courrier,
                'montant_don' => $request->montant_don,
            ],
        ]);

            $content = $response->getBody()->getcontents();
            $content = json_decode($content);
            //dd($content);
            $data = [];
            if($content->etat == 200){
                $data['etat'] = 200;
                $data['msg'] = "les informations de contact sont modifiées avec succès";
                return redirect()->back()->with(['success'=>$data['msg']]);
            }else{
                $data['etat'] = 500;
                $data['msg'] = "erreur de systeme ! les informations de contact ne sont pas enregistrer ";
                return redirect()->back()->with(['error'=>$data['msg']]);
            }
    }

    //recuperer les information de contact a partir de lead id envoyée
    public function SendMsgContactByLeadId($lead_id){
        if($lead_id && $lead_id>0){
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_lead_info', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'campaign' => Session::get('campaign'),
                    'lead_id' => $lead_id,
                ],
            ]);
            
            
            $content = $response->getBody()->getcontents();
            $content = json_decode($content);
            //dd($content->lead);
            $data = [];
            $data['email'] = /*'louanes.mokhfi@gmail.com';//*/$content->lead->new_contact_email == null ? $content->lead->contact_email : $content->lead->new_contact_email; 
            $data['nom'] = /*'louanes';//*/$content->lead->new_contact_nom == null ? $content->lead->contact_nom : $content->lead->new_contact_nom;
            $data['prenom'] = /*'mokhfi';//*/$content->lead->new_contact_prenom == null ? $content->lead->contact_prenom : $content->lead->new_contact_prenom;
            $data['adr4'] = /*'35+CHE+DU+PAROIS';//*/$content->lead->adr4_libelle_voie;
            $data['adr5'] = $content->lead->adr5;
            $data['cp'] = $content->lead->new_contact_cp == null ? $content->lead->contact_cp : $content->lead->new_contact_cp;
            $data['ville'] = $content->lead->new_contact_ville == null ? $content->lead->contact_ville : $content->lead->new_contact_ville;
            $data['idtotal'] = /*'510344916';//*/$content->lead->id_total;
            $data['civilite'] = $content->lead->new_adr1_civilite_abrv == null ? $content->lead->adr1_civilite_abrv : $content->lead->new_adr1_civilite_abrv;
            $data['mail'] = $content->lead->new_contact_email == null ? $content->lead->contact_email : $content->lead->new_contact_email;
            $data['montant'] = $content->lead->accord_montant == null ? $content->lead->pa_montant : $content->lead->accord_montant;
            //$data['montant'] = $content->lead->accord_montant;
            $data['assoc'] = /*'UNADEV';//*/$content->lead->pour_client;
            $data['centre'] = /*'';//*/$content->lead->pour_centre;
            $data['ope'] = /*'UNADEV+conquete';//*/$content->lead->operation;
            $data['code'] =/*'FDS_UN_2201_P';//*/$content->lead->code_marketing;
            $data['port'] = $content->lead->contact_tel1 == null ? $content->lead->tel1 : $content->lead->contact_tel1;
        
            return view('Agent.msg_contact.index',$data);
           // return response()->json($data);
        }
    }

    ///// recupere les lives statistiques de l'agent 
    public function getLiveStatisticAgent(){
        if(!empty(Session::get('user'))){
            $http = new \GuzzleHttp\Client(); 
            $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_live_statistic_agent', [
                'form_params' => [
                    'user' => Session::get('user'),
                    'server_ip' => Session::get('server_ip'),
                    'campaign' => Session::get('campaign'),
                ],
            ]);
            $data = [];
            $content = $response->getBody()->getcontents();
            $content = json_decode($content);
            //dd($content);
            return response()->json($content);

        }
    }

    public function ManualDial(Request $request){

        
        $user = Session::get('user');
        $phone_number = $request->phone_number;
        $phone_code = '33';
        //dd(Session::get('session_name'));
        /*$admin = '6666';
        $passAdmin = '0551797726';
        
        $http = new \GuzzleHttp\Client();
        $response = $http->get('https://call3.harmoniecrm.com/agc/api.php?source=test&user='.$admin.'&pass='.$passAdmin.'&agent_user='.$user.'&function=external_dial&value='.$phone_number.'&phone_code='.$phone_code.'&search=YES&preview=NO&focus=YES');
        $data['contents'] = $response->getBody()->getContents();
        //dd($data['contents']);
        if(str_contains($data['contents'],'SUCCESS: external_dial function set')){
            $data['etat'] = 200;*/
            $http = new \GuzzleHttp\Client();
            $responsePhone = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/manual_dial', [
                    'form_params' => [
                        'phone_number' => $phone_number,
                        'phone_code' => $phone_code,
                        'user' => Session::get('user'),
                        'campaign' => Session::get('campaign'),
                        'agent_log_id' => Session::get('agent_log_id'),
                        'extension' => Session::get('extension'),
                        'server_ip' => Session::get('server_ip'),
                        'session_name' => Session::get('session_name'),
                        'conf_exten' => Session::get('conf_exten'),
                        'pass' => Session::get('pass'),
                        'phone_login' => Session::get('phone_login'),
                        'phone_pass' => Session::get('phone_pass'),
                    ],
                ]);

            $content = $responsePhone->getBody()->getContents();
            $content = json_decode($content);
            //dd($content);
            $data['etat'] = $content->etat;
            if($data['etat'] == 200){
                $data['msg'] =  'lead exist';
                $data['uniqueid'] = $content->uniqueid1;
                $data['contents'] = $content->contents;
                $data['lead'] = $content->lead;
                $data['call_log'] = $content->call_log;
                $data['caller_id'] = $content->caller_id;
                $data['live_agent'] = $content->liveagent1;
                $data['res'] = $content->res;

                return response()->json($data);
            }else{
                $data['msg'] =  "Ce Numéro de télèphone n'existe pas dans nos enregistrement, veuillez verifier le numéro svp !!";
                return response()->json($data);
            }
        /*}else{
            $data['etat'] = 500;
            $data['msg'] =  "Ce Numéro de télèphone n'existe pas dans nos enregistrement, veuillez verifier le numéro svp !!";
            return response()->json($data);  
        }*/
    }

    public function getLiveCallback(){
        $data = [];
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_live_callback', [
            'form_params' => [
                'user' => Session::get('user'),
                'server_ip' => Session::get('server_ip'),
                'campaign' => Session::get('campaign'),
            ],
        ]);
        
        
        
        $content = $response->getBody()->getcontents();
        $content = json_decode($content);
        //dd($content);
        $data['etat'] = $content->etat;
        $data['lead'] = $content->callbacks;
        return response()->json($data);
    }
}