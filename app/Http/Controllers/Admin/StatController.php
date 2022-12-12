<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\UnadevListExport;
use App\Exports\AgentTimeDetailExport;
use Maatwebsite\Excel\Excel;
class StatController extends Controller
{
    public function new_statistics(){
        $data = [];
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_all_agents');
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        $data['agentslive'] = $content->agents;
        $data['campaigns'] = $content->campaigns;
        $data['lists'] = $content->lists;
       // dd($data['lists']);
        $data['etat'] = 401;
        return view('Admin.statistics.index1',$data);
        //dd('ff');
        
    }

    public function new_show_stat_agents(Request $request){
        if(!$request->ids){
            $data1 = [];
            $data1['etat'] = 401;
            $data1['msg'] = 'Veuillez selectionner la liste svp !';
            return response()->json($data1); 
        }
        if(!$request->campaigns){
            $data1 = [];
            $data1['etat'] = 401;
            $data1['msg'] = 'Veuillez selectionner la compagne svp !';
            return response()->json($data1); 
        }
        if(!$request->day){
            $data1 = [];
            $data1['etat'] = 401;
            $data1['msg'] = 'Veuillez selectionner la date svp !';
            return response()->json($data1); 
        }
        $nbrAgent = 0;
        foreach($request->ids as $agnbr){
            $nbrAgent++;
        }
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/new_show_stat_agents',[
            'form_params' => [
                'ids' => $request->ids,
                //'campaignsids' => $request->campaignsids,
                'day' => $request->day,
                'campaigns' => $request->campaigns,
            ],
        ]);
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        //return $content;
        $agents = $content->vicidial_agent_log;
        $wait = [];
        $pause = [];
        $talk = [];
        $dispo = [];
        $prod = [];
        $DMtalk = [];
        $DMprod = [];
        $DMdispo = [];
        $allagentInfo = [];
        $positive = ['DMPDC','DMPDL','PAPAC','PAPAL','PLDD','PLAIB','PLDIB'];
        $argumenter = ['DM','DMPDC','DMPDL','DL','DLDPD','DLDANC','DLDAYC','DLDAIB',
                'DLDDIB','IND','INDOLD','PA','PAPAC','PAPAL','RA','RAA','RADPT','RADAAS','RAEN','RAPM','RATSNR','RADAS'];
        $totalPos = 0;
        $totalPourcPos = 0;
        $totalPourcPosArg = 0;
        $agentDAT = [];
        $agentDC = [];
        $agentDMC = [];
        $agentDT = [];
        $agentDPROD = [];
        $agentDMPROD = [];
        $totalAppels = 0;
        $totalPos = 0;
        $totalArg = 0;
        $nbrAgents = 0;
        $totalPourcPos = 0;
        $totalPourcPosArg = 0;
        $totalPourcArg = 0;
        $totalArgHour = 0;
        //dd($agents);
        foreach ($agents as $key => $agent) {
            $nbrAgents++;
            $waitSec = 0;
            $talkSec = 0;
            $pauseSec = 0;
            $dispoSec = 0;
            $deadSec = 0;
            $nbrAppels = 0;
            $PosAppels = 0;
            $ArgAppels = 0;
            foreach ($agent as $key => $age) {
                $waitSec = $waitSec+$age->wait_sec;
                $talkSec = $talkSec+$age->talk_sec;
                $pauseSec = $pauseSec+$age->wait_sec;
                $dispoSec = $dispoSec+$age->dispo_sec;
                $deadSec = $deadSec+$age->dead_sec;
                if($age->status != null){
                    $nbrAppels++;
                }
                if(in_array($age->status, $positive)){
                    $PosAppels++;
                }
                if(in_array($age->status, $argumenter)){
                    $ArgAppels++;
                }
            }
            $wait=$this->changeFormatSec($waitSec);
            $talk=$this->changeFormatSec($talkSec+$deadSec);
            $prod=$this->changeFormatSec($waitSec+$talkSec+$dispoSec);
            $dispo=$this->changeFormatSec($dispoSec);
            

            //array_push($wait,$this->changeFormatSec($waitSec));
            //$DMtalk = $this->changeFormatSec(($talkSec+$deadSec)/$nbrAgent);
            //$DMprod = $this->changeFormatSec(($waitSec+$talkSec+$dispoSec)/$nbrAgent);
            //array_push($DMdispo,$this->changeFormatSec($dispoSec/$nbrAgent));
            $agentInfo['Agent'] = $this->getUserName($agent[0]->user);
            $agentInfo['Dat'] = $wait; ///calculer le temps d'attente (status = ready)
            array_push($agentDAT,$agentInfo['Dat']);
            $agentInfo['Dc'] = $talk; /// la duree de communication (status = incall )
            array_push($agentDC,$agentInfo['Dc']);

            $agentInfo['Dmc'] = $this->changeFormatSec(($talkSec+$deadSec)/$nbrAgent);   /// duree moyenne de comunication
            array_push($agentDMC,$agentInfo['Dmc']);

            $agentInfo['DT'] = $dispo; /// duree de traitement (status = dispo)
            array_push($agentDT,$agentInfo['DT']);
            $agentInfo['Dprod'] = $prod; /// duree de production (status = ready on dispo or incall)
            array_push($agentDPROD,$agentInfo['Dprod']);
            $agentInfo['Dmprod'] = $this->changeFormatSec(($waitSec+$talkSec+$dispoSec)/$nbrAgent); // duree moyenne de production
            array_push($agentDMPROD,$agentInfo['Dmprod']);
            $agentInfo['Dpa'] = '00:00:00';
            $agentInfo['appels'] = $nbrAppels;
            $totalAppels = $totalAppels + $agentInfo['appels'];
            $agentInfo['pos'] = $PosAppels; /// nbr fiches qualifier positivement (don, promesse..)
            $totalPos = $totalPos + $agentInfo['pos'];

            $agentInfo['pourcpos'] = round(($PosAppels/$nbrAppels)*$PosAppels,2);
            $totalPourcPos = $totalPourcPos + $agentInfo['pourcpos'];
            $agentInfo['pourcposArg'] = round(($PosAppels/$ArgAppels)*100,2);
            $totalPourcPosArg = $totalPourcPosArg + $agentInfo['pourcposArg'];
            $agentInfo['Arg'] = $ArgAppels; /// nbr appeles argumenters
            $totalArg = $totalArg + $agentInfo['Arg'];

            $agentInfo['pourcArg'] = round(($ArgAppels/$nbrAppels)*100,2);
            $totalPourcArg = $totalPourcArg + $agentInfo['pourcArg'];
            
            $agentInfo['ArgH'] = $this->ArgumentParHeure($ArgAppels,$this->changeFormatSec(($waitSec+$talkSec+$dispoSec)));
            $totalArgHour = $totalArgHour + $agentInfo['ArgH'];
            $agentInfo['Dhold'] = '00:00:00';
            array_push($allagentInfo,$agentInfo);
           
        }
        //dd($totalArgHour/);
        $totalAgentInfo = [];

        $totalAgentInfo['Dat'] = $this->TotalTime($agentDAT); ///calculer le temps d'attente (status = ready)

        $totalAgentInfo['Dc'] = $this->TotalTime($agentDC); /// la duree de communication (status = incall )
        $totalAgentInfo['Dmc'] = $this->TotalTime($agentDMC);   /// duree moyenne de comunication
        $totalAgentInfo['Dt'] = $this->TotalTime($agentDT); /// duree de traitement (status = dispo)
        
        $totalAgentInfo['Dprod'] = $this->TotalTime($agentDPROD); /// duree de production (status = ready on dispo or incall)
        $totalAgentInfo['Dmprod'] = $this->TotalTime($agentDMPROD); // duree moyenne de production
        $totalAgentInfo['Dpa'] = '00:00:00';
        $totalAgentInfo['appels'] = round($totalAppels,2);  //// nbr de appeles
        $totalAgentInfo['pos'] = round($totalPos,2); /// nbr fiches qualifier positivement (don, promesse..)
        $totalAgentInfo['pourcpos'] = $totalPourcPos = 0 ? 0 : round($totalPourcPos / $nbrAgents,2); 
        $totalAgentInfo['pourcposArg'] = $totalPourcPosArg = 0 ? 0 : round($totalPourcPosArg/$nbrAgents,2);
        $totalAgentInfo['Arg'] = round($totalArg,2); /// nbr appeles argumenters
        $totalAgentInfo['pourcArg'] = $totalPourcArg = 0 ? 0 : round($totalPourcArg/$nbrAgents,2);
        $totalAgentInfo['ArgH'] = $totalArgHour = 0 ? 0 : round($totalArgHour/$nbrAgents,2);
        $totalAgentInfo['Dhold'] = '00:00:00';
        $data['totalAgentInfo'] = $totalAgentInfo;
        $data['agents'] = $allagentInfo;
        $data['etat'] = 200;
        return response()->json($data); 
        //dd($allagentInfo);
        
    }

    public function statistics(){
        //dd('ff');
        $data = [];
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_all_agents');
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        
        
        $data['lists'] = $content->agents;
        //dd($data['agentslive']);
        $http = new \GuzzleHttp\Client();
        $admin = '6666';
        $passAdmin = '0551797726';//'0551797capital';//'0551797726';
        $datetime_start = date('Y-m-d');
        $datetime_end = date('Y-m-d');
        $response = $http->get('https://call3.harmoniecrm.com/vicidial/non_agent_api.php?source=test&function=agent_stats_export&time_format=M&stage=pipe&user='.$admin.'&pass='.$passAdmin.'&datetime_start='.$datetime_start.'+00:00:00&datetime_end='.$datetime_end.'+23:59:59');
        //dd($response->getBody()->getContents());
        $data['datetime_start'] = $datetime_start;
        $data['datetime_end'] = $datetime_end;
        $data['agents'] = $response->getBody()->getContents();
        //dd($data['agents']);
        if(str_contains($data['agents'],'agent_stats_export NO RECORDS FOUND')){
            $data['error1'] = 'Aucun statistiqus existes !!';
            $data['etat'] = 401;
            return view('Admin.statistics.index',$data); 
        }else{
           if(str_contains($data['agents'],'ERROR: Login incorrect')){
            
            $data['error1'] = 'Login Incorrecte, verifiez votre username ou mot de passe !!';
            $data['etat'] = 401;
            return view('Admin.statistics.index',$data); 
            }

            $data['etat'] = 200;
            $contents =$data['agents'];
            $contents = json_encode ($data['agents']);
            $contents = explode('"',$contents);
            $contents = explode('\n',$contents[1]);
            //dd($contents);
            $agents = [];
            $agentDAT = [];
            $agentDC = [];
            $agentDMC = [];
            $agentDT = [];
            $agentDPROD = [];
            $agentDMPROD = [];
            $totalAppels = 0;
            $totalPos = 0;
            $totalArg = 0;
            $nbrAgents = 0;
            $totalPourcPos = 0;
            $totalPourcPosArg = 0;
            $totalPourcArg = 0;
            $totalArgHour = 0;

            foreach ($contents as $key => $agent) {
                //dd($agent[1]);
                $agent = explode('|',$agent);
                //dd($agent[3]);
               //dd($this->ArgumentParHeure($this->QualifArgumenter($agent[1]),$this->changeFormatMinSec($agent[4])));
                if(!empty($agent) && $agent[0] != ''){
                    //dd($agent);
                    $nbrAgents++;
                    

                    $agentInfo['Agent'] = $agent[1];
                    $agentInfo['Dat'] = $this->changeFormatMinSec($agent[16]); ///calculer le temps d'attente (status = ready)
                    array_push($agentDAT,$agentInfo['Dat']);
                    $agentInfo['Dc'] = $this->changeFormatMinSec($agent[17]); /// la duree de communication (status = incall )
                    array_push($agentDC,$agentInfo['Dc']);
                    $agentInfo['Dmc'] = $this->DMCom($agent[17],$agent[3]);   /// duree moyenne de comunication

                    array_push($agentDMC,$agentInfo['Dmc']);
                    $agentInfo['DT'] = $this->changeFormatMinSec($agent[18]); /// duree de traitement (status = dispo)
                    array_push($agentDT,$agentInfo['DT']);                    
                    $agentInfo['Dprod'] = $this->heureProd($agent[5],$agent[16],$agent[18]); /// duree de production (status = ready on dispo or incall)
                    array_push($agentDPROD,$agentInfo['Dprod']);
                    $agentInfo['Dmprod'] = $this->DMProd($agent[5],$agent[18],$agent[16],$agent[3]); // duree moyenne de production
                    array_push($agentDMPROD,$agentInfo['Dmprod']);
                    $agentInfo['Dpa'] = '00:00:00';
                    $agentInfo['appels'] = $agent[3];  //// nbr de appeles
                    $totalAppels = $totalAppels + $agentInfo['appels'];
                    $agentInfo['pos'] = $this->QualifPostitif($agent[0]); /// nbr fiches qualifier positivement (don, promesse..)
                    $totalPos = $totalPos + $agentInfo['pos'];
                    

                    $agentInfo['pourcpos'] = $agent[3] == 0 ? 0 : round(($this->QualifPostitif($agent[0])/$agent[3])*100,2);
                    $totalPourcPos = $totalPourcPos + $agentInfo['pourcpos'];
                    $agentInfo['pourcposArg'] = $this->QualifArgumenter($agent[0]) == 0 ? 0 :round(($this->QualifPostitif($agent[0])/$this->QualifArgumenter($agent[0]))*100,2);
                    $totalPourcPosArg = $totalPourcPosArg + $agentInfo['pourcposArg'];
                    $agentInfo['Arg'] = $this->QualifArgumenter($agent[0]); /// nbr appeles argumenters
                    $totalArg = $totalArg + $agentInfo['Arg'];

                    $agentInfo['pourcArg'] = $agent[3] == 0 ? 0 : round(($this->QualifArgumenter($agent[0])/$agent[3])*100,2); 
                    $totalPourcArg = $totalPourcArg + $agentInfo['pourcArg'];
                    $agentInfo['ArgH'] = $this->ArgumentParHeure($this->QualifArgumenter($agent[0]),$this->changeFormatMinSec($agent[4]));
                    $totalArgHour = $totalArgHour + $agentInfo['ArgH'];
                    $agentInfo['Dhold'] = '00:00:00';

                    array_push($agents,$agentInfo);
                }
                
            }

                $totalAgentInfo = [];

                $totalAgentInfo['Dat'] = $this->TotalTime($agentDAT); ///calculer le temps d'attente (status = ready)

                $totalAgentInfo['Dc'] = $this->TotalTime($agentDC); /// la duree de communication (status = incall )
                $totalAgentInfo['Dmc'] = $this->TotalTime($agentDMC);   /// duree moyenne de comunication
                $totalAgentInfo['Dt'] = $this->TotalTime($agentDT); /// duree de traitement (status = dispo)
                
                $totalAgentInfo['Dprod'] = $this->TotalTime($agentDPROD); /// duree de production (status = ready on dispo or incall)
                $totalAgentInfo['Dmprod'] = $this->TotalTime($agentDMPROD); // duree moyenne de production
                $totalAgentInfo['Dpa'] = '00:00:00';
                $totalAgentInfo['appels'] = round($totalAppels,2);  //// nbr de appeles
                $totalAgentInfo['pos'] = round($totalPos,2); /// nbr fiches qualifier positivement (don, promesse..)
                $totalAgentInfo['pourcpos'] = round($totalPourcPos / $nbrAgents,2); 
                $totalAgentInfo['pourcposArg'] = round($totalPourcPosArg/$nbrAgents,2);
                $totalAgentInfo['Arg'] = round($totalArg,2); /// nbr appeles argumenters
                $totalAgentInfo['pourcArg'] = round($totalPourcArg/$nbrAgents,2);
                $totalAgentInfo['ArgH'] = round($totalArgHour/$nbrAgents,2);
                $totalAgentInfo['Dhold'] = '00:00:00';
            //dd($totalAgentInfo);




                //dd($totalAgentInfo);
            $data['agents'] = $agents;
            $data['totalAgentInfo'] = $totalAgentInfo;
            return view('Admin.statistics.index',$data); 
        }
        
    }
    public function showStatAgents(Request $request){
        
        $data = [];
        $http = new \GuzzleHttp\Client();
        $admin = '6666';
        $passAdmin = '0551797726';//'0551797capital';//'0551797726';
        $datetime_start = date('Y-m-d');
        $datetime_end = date('Y-m-d');
        $response = $http->get('https://call3.harmoniecrm.com/vicidial/non_agent_api.php?source=test&function=agent_stats_export&time_format=M&stage=pipe&user='.$admin.'&pass='.$passAdmin.'&datetime_start='.$datetime_start.'+00:00:00&datetime_end='.$datetime_end.'+23:59:59');
        
        $data['datetime_start'] = $datetime_start;
        $data['datetime_end'] = $datetime_end;
        $data['agents'] = $response->getBody()->getContents();
        //dd($data['agents']);
        if(str_contains($data['agents'],'agent_stats_export NO RECORDS FOUND')){
            $data['error1'] = 'Aucun statistiqus existes !!';
            $data['etat'] = 401;
            return view('Admin.statistics.index',$data); 
        }else{
           if(str_contains($data['agents'],'ERROR: Login incorrect')){
            
            $data['error1'] = 'Login Incorrecte, verifiez votre username ou mot de passe !!';
            $data['etat'] = 401;
            return view('Admin.statistics.index',$data); 
            }
            $data['etat'] = 200;
            $contents =$data['agents'];
            $contents = json_encode ($data['agents']);
            $contents = explode('"',$contents);
            $contents = explode('\n',$contents[1]);
            //dd($contents);
            $agents = [];
            $agentDAT = [];
            $agentDC = [];
            $agentDMC = [];
            $agentDT = [];
            $agentDPROD = [];
            $agentDMPROD = [];
            $totalAppels = 0;
            $totalPos = 0;
            $totalArg = 0;
            $nbrAgents = 0;
            $totalPourcPos = 0;
            $totalPourcPosArg = 0;
            $totalPourcArg = 0;
            $totalArgHour = 0;

            foreach ($contents as $key => $agent) {
                //dd($agent[1]);
                $agent = explode('|',$agent);
                
               //dd($this->ArgumentParHeure($this->QualifArgumenter($agent[1]),$this->changeFormatMinSec($agent[4])));
                if(!empty($agent) && $agent[0] != '' && in_array($agent[0], $request->ids)){

                    $nbrAgents++;
                    $agentInfo['Agent'] = $agent[1];
                    $agentInfo['Dat'] = $this->changeFormatMinSec($agent[16]); ///calculer le temps d'attente (status = ready)
                    array_push($agentDAT,$agentInfo['Dat']);
                    $agentInfo['Dc'] = $this->changeFormatMinSec($agent[17]); /// la duree de communication (status = incall )
                    array_push($agentDC,$agentInfo['Dc']);
                    $agentInfo['Dmc'] = $this->DMCom($agent[17],$agent[3]);   /// duree moyenne de comunication
                    array_push($agentDMC,$agentInfo['Dmc']);
                    $agentInfo['DT'] = $this->changeFormatMinSec($agent[18]); /// duree de traitement (status = dispo)
                    array_push($agentDT,$agentInfo['DT']);                    
                    $agentInfo['Dprod'] = $this->heureProd($agent[5],$agent[16],$agent[18]); /// duree de production (status = ready on dispo or incall)
                    array_push($agentDPROD,$agentInfo['Dprod']);
                    $agentInfo['Dmprod'] = $this->DMProd($agent[5],$agent[18],$agent[16],$agent[3]); // duree moyenne de production
                    array_push($agentDMPROD,$agentInfo['Dmprod']);
                    $agentInfo['Dpa'] = '00:00:00';
                    $agentInfo['appels'] = $agent[3];  //// nbr de appeles
                    $totalAppels = $totalAppels + $agentInfo['appels'];
                    $agentInfo['pos'] = $this->QualifPostitif($agent[0]); /// nbr fiches qualifier positivement (don, promesse..)
                    $totalPos = $totalPos + $agentInfo['pos'];

                    $agentInfo['pourcpos'] = $agent[3] == 0 ? 0 : round(($this->QualifPostitif($agent[0])/$agent[3])*100,2);
                    $totalPourcPos = $totalPourcPos + $agentInfo['pourcpos'];
                    $agentInfo['pourcposArg'] = $this->QualifArgumenter($agent[0]) == 0 ? 0 :round(($this->QualifPostitif($agent[0])/$this->QualifArgumenter($agent[0]))*100,2);
                    $totalPourcPosArg = $totalPourcPosArg + $agentInfo['pourcposArg'];
                    $agentInfo['Arg'] = $this->QualifArgumenter($agent[0]); /// nbr appeles argumenters
                    $totalArg = $totalArg + $agentInfo['Arg'];

                    $agentInfo['pourcArg'] = $agent[3] == 0 ? 0 : round(($this->QualifArgumenter($agent[0])/$agent[3])*100,2); 
                    $totalPourcArg = $totalPourcArg + $agentInfo['pourcArg'];
                    $agentInfo['ArgH'] = $this->ArgumentParHeure($this->QualifArgumenter($agent[0]),$this->changeFormatMinSec($agent[4]));
                    $totalArgHour = $totalArgHour + $agentInfo['ArgH'];
                    $agentInfo['Dhold'] = '00:00:00';
                    

                    array_push($agents,$agentInfo);
                }
                
            }
            //dd($totalPourcPosArg);
                $totalAgentInfo = [];

                $totalAgentInfo['Dat'] = $this->TotalTime($agentDAT); ///calculer le temps d'attente (status = ready)

                $totalAgentInfo['Dc'] = $this->TotalTime($agentDC); /// la duree de communication (status = incall )
                $totalAgentInfo['Dmc'] = $this->TotalTime($agentDMC);   /// duree moyenne de comunication
                $totalAgentInfo['Dt'] = $this->TotalTime($agentDT); /// duree de traitement (status = dispo)
                
                $totalAgentInfo['Dprod'] = $this->TotalTime($agentDPROD); /// duree de production (status = ready on dispo or incall)
                $totalAgentInfo['Dmprod'] = $this->TotalTime($agentDMPROD); // duree moyenne de production
                $totalAgentInfo['Dpa'] = '00:00:00';
                $totalAgentInfo['appels'] = round($totalAppels,2);  //// nbr de appeles
                $totalAgentInfo['pos'] = round($totalPos,2); /// nbr fiches qualifier positivement (don, promesse..)
                $totalAgentInfo['pourcpos'] = $totalPourcPos = 0 ? 0 : round($totalPourcPos / $nbrAgents,2); 
                $totalAgentInfo['pourcposArg'] = $totalPourcPosArg = 0 ? 0 : round($totalPourcPosArg/$nbrAgents,2);
                $totalAgentInfo['Arg'] = round($totalArg,2); /// nbr appeles argumenters
                $totalAgentInfo['pourcArg'] = $totalPourcArg = 0 ? 0 : round($totalPourcArg/$nbrAgents,2);
                $totalAgentInfo['ArgH'] = $totalArgHour = 0 ? 0 : round($totalArgHour/$nbrAgents,2);
                $totalAgentInfo['Dhold'] = '00:00:00';
            //dd($agents);


                //dd($totalAgentInfo);
            $data['agents'] = $agents;
            $data['totalAgentInfo'] = $totalAgentInfo;
            return response()->json($data); 
        }
    }
    public function ExportTimeAgent(Request $request){
        $data = [];
        $http = new \GuzzleHttp\Client();
        $admin = '6666';
        $passAdmin = '0551797726';//'0551797capital';//'0551797726';
        $datetime_start = $request->datetime_start;
        $datetime_end = $request->datetime_end;
        
        //$response = $http->get('https://call3.harmoniecrm.com/vicidial/non_agent_api.php?source=test&function=agent_stats_export&time_format=M&stage=pipe&user=6666&pass=0551797726&datetime_start=2022-10-03+00:00:00&datetime_end=2022-10-03+23:59:59');
        $response = $http->get('https://call3.harmoniecrm.com/vicidial/non_agent_api.php?source=test&function=agent_stats_export&time_format=M&stage=pipe&user='.$admin.'&pass='.$passAdmin.'&datetime_start='.$datetime_start.'+00:00:00&datetime_end='.$datetime_end.'+23:59:59');
        
        $data['datetime_start'] = $datetime_start;
        $data['datetime_end'] = $datetime_end;
        $data['agents'] = $response->getBody()->getContents();
        //dd($data['agents']);
        if(str_contains($data['agents'],'agent_stats_export NO RECORDS FOUND')){
            return redirect()->back()->with(['error1'=>'Aucun statistiqus existes avec cette date !!']);
        }
        if(str_contains($data['agents'],'ERROR: Login incorrect')){
            return redirect()->back()->with(['error1'=>'Login Incorrecte, verifiez votre username ou mot de passe !!']);
        }
        $contents =$data['agents'];
        $contents = json_encode ($data['agents']);
        $contents = explode('"',$contents);
        $contents = explode('\n',$contents[1]);
        //dd($contents);
        $agents = [];
        foreach ($contents as $key => $agent) {
            //d($agent[1]);
            $agent = explode('|',$agent);
            //dd($agent[1]);
            if(!empty($agent) && $agent[0] != ''){
                $agent['Agent'] = $agent[1];
                $agent['Groupe_agent'] = 'Fidelis_agents';
                $agent['genre'] = '';
                $agent['matricule'] = '';
                $agent['code_externe'] = '';
                $agent['agent_login'] = $agent[0];
                $agent['debut'] = '00:00:00';
                $agent['fin'] = '00:00:00';
                $agent['debrief'] = '00:00:00';
                $agent['pause'] = $this->changeFormatSec($agent[9]);
                $agent['pause_prod'] = '00:00:00';
                $agent['pause_forma'] = '00:00:00';
                $agent['pause_brief'] = '00:00:00';
                $agent['pause_productive'] = '00:00:00';
                $agent['pause_cafe'] = '00:00:00';
                $agent['pause_dej'] = '00:00:00';
                $agent['pause_autre'] = '00:00:00';
                $agent['menu'] = $this->changeFormatMinSec($agent[18]);
                $agent['heure_prod'] = $this->heureProd($agent[5],$agent[16],$agent[18]);
                $agent['heure_presence'] = $this->changeFormatMinSec($agent[4]);
                $agent['duree_conv'] = $this->changeFormatMinSec($agent[17]);
                $agent['duree_mise_att'] = '00:00:00';
               
                array_push($agents,$agent);
            }
            
        }
        
        $agents1 = [];
        foreach ($agents as $agent) {
            $agents1[] = [
                'Agent' => $agent['Agent'],
                'Groupe_agent' => $agent['Groupe_agent'],
                'genre' => $agent['genre'],
                'matricule' => $agent['matricule'],
                'code_externe' => $agent['code_externe'],
                'agent_login' => $agent['agent_login'],
                'debut' => $agent['debut'],
                'fin' => $agent['fin'],
                'debrief' => $agent['debrief'],
                'pause' => $agent['pause'],
                'pause_prod' => $agent['pause_prod'],
                'pause_forma' => $agent['pause_forma'],
                'pause_brief' => $agent['pause_brief'],
                'pause_productive' => $agent['pause_productive'],
                'pause_cafe' => $agent['pause_cafe'],
                'pause_dej' => $agent['pause_dej'],
                'pause_autre' => $agent['pause_autre'],
                'menu' => $agent['menu'],
                'heure_prod' => $agent['heure_prod'],
                'heure_presence' => $agent['heure_presence'],
                'duree_conv' => $agent['duree_conv'],
                'duree_mise_att' => $agent['duree_mise_att'],
            ];
         }
      
        return (new AgentTimeDetailExport($agents1))->download('agent_time_detail.xlsx');
        //return view('Admin.statistics.index',$data);
    }

    public function ExportList(Request $request){
       // return $request->list;
        /*$t = [];
        $stack = array("orange", "banana");
        return array_push($stack, "apple", "raspberry");
        return array_push($t, $d);
        return $v;*/
        if(!$request->list){
            return redirect()->back()->with(['error'=>"Veuillez choisir les lists svp !!"]);
        }
        if($request->type == 1){
            /*if(!$request->date_injection){
                return redirect()->back()->with(['error'=>"Veuillez choisir la date d'injection de fichier svp !!"]);
            }  */
        }/*else{
            if(!$request->date){
                return redirect()->back()->with(['error'=>'Veuillez choisir la date svp !!']);
            } 
        }*/
        
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/export_list',[
            'form_params' => [
                'date' => $request->date,
                'type' => $request->type,
                'date_injection' => $request->date_injection,
                'list' => $request->list,
            ],
        ]);
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
       // dd($content);

        if(count($content)<1){
            return redirect()->back()->with(['error'=>'Aucun contact existe avec cette date !!']);
        }
        $lists = $content;
        //dd($lists);
        foreach($content as $lists){
            foreach ($lists as $list) {
                if($list->user == '' || $list->user == 'VDAD'){
                    $userr = '';
                }else{
                    $userr = $this->getUserName($list->user);
                }
                //$userr = $list->user == 'VDAD' ? '' : $this->getUserName($list->user);
            
                $date1 = date("Ymd", strtotime($list->modify_date));
                $data[] = [
                  'contact_date_fiche'=> $list->modify_date == "0000-00-00 00:00:00" ? '' : $date1,
                  'pour_centre'=> $list->pour_centre,
                  'date_chargement'=> $list->date_chargement,
                  'contact_qualif1'=> $this->Status($list->status),
                  'id_total'=> $list->id_total,
                  'accord_montant'=> $list->accord_montant,
                  'contact_qualif2'=> $this->SubStatus($list->status),
                  'cas_particulier'=> $list->cas_particulier,
                  'pa_montant'=> $list->pa_montant,
                  'pa_frequence'=> '',//$list->pa_frequence,
                  'adr1_civilite_abrv'=> $list->adr1_civilite_abrv,
                  'contact_nom'=> $list->first_name,
                  'contact_prenom'=> $list->last_name,
                  'adr2'=> $list->adr2,
                  'adr3'=> $list->adr3,
                  'adr4_libelle_voie'=> $list->adr4_libelle_voie,
                  'adr5'=> $list->adr5,
                  'contact_cp'=> $list->postal_code,
                  'contact_ville'=> $list->city,
                  'contact_email'=> $list->contact_email,
                  'contact_tel'=> $list->contact_tel,
                  'contact_tel_port'=> $list->contact_tel_port,
                  'numero_appeler'=> $list->phone_number,
                  'new_RAISON_SOCIALE'=> $list->new_raison_sociale,
                  'duree'=> '',//$list->duree,
                  'code_marketing'=> $list->code_marketing,
                  'rf_pro'=> '',//$list->rf_pro,
                  'id_client'=> '',//$list->id_client,
                  'envoi_sms'=> '',//$list->envoi_sms,
                  'envoi_mail'=> '',//$list->envoi_mail,
                  'indice'=> $list->indice,
                  'valid_coordonnees'=> '',//$list->valid_coordonnees,
                  'tel_joint'=> 'CMK_S_FIELD_DERNIER_TELEPHONE_COMPOSE',//$list->tel_joint,
                  'agent'=> $userr,
                  'Acceuil :: TELEPHONE_PORTABLE'=> $list->contact_tel1,
                  'contact_email1'=> $list->contact_email1,
                  'CMK_S_FIELD_DMC_OUT'=> $list->date_chargement,
                  'Commentaire_call1'=> $list->commentaire,
                ];
             }
        }
        //$data = $content->lists;
        //dd($data);
        //dd(date('Ymd_his'));
        return (new UnadevListExport($data))->download('export_'.date('Ymd_his').'.xlsx');
        //dd($content->lists);
    }

    public function getUserName($userId){
        //dd($userId);
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_user_name',[
            'form_params' => [
                'user_id' => $userId,
            ],
        ]);
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        //dd($content);
        if($content->etat == 200){
            return $content->full_name;
        }else{
            return '';

        }
        
    }
    function Status($status){
        if($status == 'NEW'){
             return $status = '';
        }elseif($status == 'NA' || $status == 'N'){
            return $status = 'injoignable';
        }elseif($status == 'NA' || $status == 'N'){
            return $status = 'injoignable';
        }elseif($status == 'B'){
            return $status = 'occupe';
        }elseif($status == 'DL' || $status == 'DLDPD' || $status == 'DLDAYC' || $status == 'DLDANC' || $status == 'DLDAIB' || $status == 'DLDDCB' || $status == 'DLDDIB'){
            return $status = 'don en ligne';
        }
        elseif($status == 'DOUBL'){
            return $status = 'doublon';
        }elseif($status == 'DM' || $status == 'DMPDC' || $status == 'DMPDL'){
            return $status = 'don avec montant';
        }elseif($status == 'FNM' || $status == 'FNMF' || $status == 'FNMLD'){
            return $status = 'faux numero machine';
        }elseif($status == 'HC' || $status == 'HCD' || $status == 'HCNPF' || $status == 'HCTAM'){
            return $status = 'hors cible';
        }elseif($status == 'IND'){
            return $status = 'indecis Don';
        }elseif($status == 'INDOLD'){
            return $status = 'indecis don_old';
        }elseif($status == 'PA' || $status == 'PAPAC' || $status == 'PAPAL'){
            return $status = 'pa';
        }
        elseif($status == 'PL' || $status == 'PLDD' || $status == 'PLANC' || $status == 'PLAYC' || $status == 'PLAIB' || $status == 'PLDCB' || $status == 'PLDIB'){
            return $status = 'pa en ligne';
        }elseif($status == 'RP'){
            return $status = 'rappel personnel';
        }elseif($status == 'RA' || $status == 'RAA' || $status == 'RADPT' || $status == 'RADAAS' || $status == 'RAEN' || $status == 'RAPM' || $status == 'RATSNR' || $status == 'RADAS'){
            return $status = 'refus argumente';
        }elseif($status == 'RR' || $status == 'RRA' || $status == 'RRDPT' || $status == 'RRDAAS' || $status == 'RREN' || $status == 'RRPM' || $status == 'RRTSNR' || $status == 'RRDAS'){
            return $status = 'refus de repondre';
        }elseif($status == 'REL'){
            return $status = 'relance';
        }elseif($status == 'REP'){
            return $status = 'repondeur';
        }elseif($status == 'WFT'){
            return $status = 'workFlow Test';
        }else{
            return $status = 'injoignable';
        }
    }


    function SubStatus($substatus){
        //DM
        if($substatus == 'NA' || $substatus == 'N'){
            return $substatus = 'injoignable';
        }elseif($substatus == 'NA' || $substatus == 'N'){
            return $substatus = 'injoignable';
        }elseif($substatus == 'B'){
            return $substatus = 'occupe';
        }elseif($substatus == 'DMPDC'){
            return $substatus = 'promesse don avec courrier';
        }elseif($substatus == 'DMPDL'){
            return $substatus = 'promesse don en ligne';
        }////DL
        elseif($substatus == 'DLDPD'){
            return $substatus = 'en differe par donateur';
        }elseif($substatus == 'DLDAYC'){
            return $substatus = 'en direct par agent - CB - sans crypto';
        }elseif($substatus == 'DLDANC'){
            return $substatus = 'en direct par agent - CB - avec crypto';
        }elseif($substatus == 'DLDAIB'){
            return $substatus = 'en direct par agent - IBAN';
        }elseif($substatus == 'DLDDCB'){
            return $substatus = 'en direct par donateur - CB';
        }elseif($substatus == 'DLDDIB'){
            return $substatus = 'en direct par donateur - IBAN';
        }////DOUBL
        elseif($substatus == 'DOUBL'){
            return $substatus = 'doublon';
        }////FNM
        elseif($substatus == 'FNMF'){
            return $substatus = 'fax';
        }elseif($substatus == 'FNMLD'){
            return $substatus = 'ligne en derangement';
        }///HC
        elseif($substatus == 'HCD'){
            return $substatus = 'decede';
        }elseif($substatus == 'HCNPF'){
            return $substatus = 'ne parle pas français';
        }elseif($substatus == 'HCTAM'){
            return $substatus = 'trop age ou malade';
        }///IND
        elseif($substatus == 'IND'){
            return $substatus = '';
        }///INDOLD
        elseif($substatus == 'INDOLD'){
            return $substatus = '';
        }///PA
        elseif($substatus == 'PAPAC'){
            return $substatus = 'promesse pa avec courrier';
        }elseif($substatus == 'PAPAL'){
            return $substatus = 'promesse pa en ligne';
        }///PL
        elseif($substatus == 'PLDD'){
            return $substatus = 'en differe par donateur';
        }elseif($substatus == 'PLANC'){
            return $substatus = 'en direct par agent - CB - sans crypto';
        }elseif($substatus == 'PLAYC'){
            return $substatus = 'en direct par agent - CB - avec crypto';
        }elseif($substatus == 'PLAIB'){
            return $substatus = 'en direct par agent - IBAN';
        }elseif($substatus == 'PLDCB'){
            return $substatus = 'en direct par donateur - CB';
        }elseif($substatus == 'PLDIB'){
            return $substatus = 'en direct par donateur - IBAN';
        }///RP
        elseif($substatus == 'RP'){
            return $substatus = '';
        }///RA
        elseif($substatus == 'RAA'){
            return $substatus = 'autre';
        }elseif($substatus == 'RADPT'){
            return $substatus = 'donnera plus tard';
        }elseif($substatus == 'RADAAS'){
            return $substatus = 'dons autres associations';
        }elseif($substatus == 'RAEN'){
            return $substatus = 'entreprise';
        }elseif($substatus == 'RAPM'){
            return $substatus = 'pas les moyens';
        }elseif($substatus == 'RATSNR'){
            return $substatus = 'trop solicite - ne pas rappeler pendant 6 mois';
        }elseif($substatus == 'RADAS'){
            return $substatus = 'vient de donner a cette association';
        }///RA
        elseif($substatus == 'RRA'){
            return $substatus = 'autre';
        }elseif($substatus == 'RRDPT'){
            return $substatus = 'donnera plus tard';
        }elseif($substatus == 'RRDAAS'){
            return $substatus = 'dons autres associations';
        }elseif($substatus == 'RREN'){
            return $substatus = 'entreprise';
        }elseif($substatus == 'RRPM'){
            return $substatus = 'pas les moyens';
        }elseif($substatus == 'RRTSNR'){
            return $substatus = 'trop solicite - ne pas rappeler pendant 6 mois';
        }elseif($substatus == 'RRDAS'){
            return $substatus = 'vient de donner a cette association';
        }///REL
        elseif($substatus == 'REL'){
            return $substatus = '';
        }///REP
        elseif($substatus == 'REP'){
            return $substatus = '';
        }elseif($substatus == 'WFT'){
            return $substatus = '';
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
      //dd($Time);
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

    function DMProd($talk,$wait,$dispo,$appels){
        $talktable = explode(':',$talk);
        $talkSec = ($talktable[0]*60)+$talktable[1];

        //$pausesec = $pause;
        $waittable = explode(':',$wait);
        $waitposec = ($waittable[0]*60)+$waittable[1];

        $dispotable = explode(':',$dispo);
        $disposec = ($dispotable[0]*60)+$dispotable[1];

        $prodsec = $talkSec + $waitposec + $disposec;

        if($appels<1){
            $dmp = 0;
        }else{
            $dmp = $prodsec/$appels;
        }
        if($dmp < 3600){ 
            $heures = 0; 
            
            if($dmp < 60){$minutes = 0;} 
            else{$minutes = floor($dmp / 60);} 
            
            $secondes = floor($dmp % 60); 
            } 
            else{ 
            $heures = floor($dmp / 3600); 
            $secondes = floor($dmp % 3600); 
            $minutes = floor($secondes / 60); 
            } 
            
            $secondes2 = floor($secondes % 60); 
            if($heures<10){$heures = '0'.$heures;}
            if($minutes<10){$minutes = '0'.$minutes;}
            if($secondes2<10){$secondes2 = '0'.$secondes2;}
            $TimeFinal = $heures.':'.$minutes.':'.$secondes2; 
            return $TimeFinal;
    }
    function DMCom($dc,$appels){
        $prestable = explode(':',$dc);
        $dc = ($prestable[0]*60)+$prestable[1];
        if($appels<1){
            $dmc = 0;
        }else{
            $dmc = $dc/$appels;
        }
        if($dmc < 3600){ 
            $heures = 0; 
            
            if($dmc < 60){$minutes = 0;} 
            else{$minutes = floor($dmc / 60);} 
            
            $secondes = floor($dmc % 60); 
            } 
            else{ 
            $heures = floor($dmc / 3600); 
            $secondes = floor($dmc % 3600); 
            $minutes = floor($secondes / 60); 
            } 
            
            $secondes2 = floor($secondes % 60); 
            if($heures<10){$heures = '0'.$heures;}
            if($minutes<10){$minutes = '0'.$minutes;}
            if($secondes2<10){$secondes2 = '0'.$secondes2;}
            $TimeFinal = $heures.':'.$minutes.':'.$secondes2; 
            return $TimeFinal;
    }

    function QualifPostitif($agent){
        $http = new \GuzzleHttp\Client();
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_Qualif_Positive',[
            'form_params' => [
                'user' => $agent,
                'date' => date('Y-m-d'),
            ],
        ]);
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        return $content;
    }

    function QualifArgumenter($agent){
        $http = new \GuzzleHttp\Client();
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/get_Qualif_Argumenter',[
            'form_params' => [
                'user' => $agent,
                'date' => date('Y-m-d'),
            ],
        ]);
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        return $content;
    }

    function ArgumentParHeure($arg,$prod){
       //dd($prod);
        $prodTable = explode(':',$prod);
        $prod = ($prodTable[0]*3600)+($prodTable[1]*60)+$prodTable[2];
        $prodH = round($prod/3600,2);
        if($arg == 0 || $prodH == 0){
            $arg_par_h = 0;
        }else{
            $arg_par_h = $arg/$prodH;
        }               
        return round($arg_par_h,2); 
    }

    function TotalTime($agentTime){
        //dd($agentTime);
        $timeTotal = 0;
        foreach ($agentTime as $key => $time) {
            //if($key == 1){
            $timeTable = explode(':',$time);
            $time = ($timeTable[0]*3600)+($timeTable[1]*60)+$timeTable[2];
            
            $timeTotal = $timeTotal + $time;
            //}
        }
        if($timeTotal < 3600){ 
            $heures = 0; 
            
            if($timeTotal < 60){$minutes = 0;} 
            else{$minutes = floor($timeTotal / 60);} 
            
            $secondes = floor($timeTotal % 60); 
            } 
            else{ 
            $heures = floor($timeTotal / 3600); 
            $secondes = floor($timeTotal % 3600); 
            $minutes = floor($secondes / 60); 
            } 
            
            $secondes2 = floor($secondes % 60); 
            if($heures<10){$heures = '0'.$heures;}
            if($minutes<10){$minutes = '0'.$minutes;}
            if($secondes2<10){$secondes2 = '0'.$secondes2;}
            $TimeFinal = $heures.':'.$minutes.':'.$secondes2; 
            return $TimeFinal;
        //dd($TimeFinal);
    }

}
