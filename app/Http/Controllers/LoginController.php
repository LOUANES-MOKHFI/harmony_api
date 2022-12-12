<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class LoginController extends Controller
{

    //private $server = 'https://call3.callbk.tk';
    private $server1 = 'https://call3.harmoniecrm.com';
    public function index()
    {
       
        return view('Agent.auth.login');
    }  
      
    public function customLogin(Request $request)
    {
    
        //dd($request->campaign);
        $request->validate([
            'user' => 'required',
            'pass' => 'required',
            'campaign' => 'required',
        ]);

       
        $http = new \GuzzleHttp\Client(); 
        $response = $http->post('https://call3.harmoniecrm.com/harmony_api/index.php/custom_login', [
            'form_params' => [
                'user' => $request->user,
                'pass' => $request->pass,
                'campaign' => $request->campaign,
            ],
        ]);
        
        
        if($response->getStatusCode() != 200){
            return  redirect()->route("agent.login")->withError('Email ou mot de passe incorrecte');
        }
        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents);
        
        $data['etat'] = $contents->etat;
        $data['msg']  = $contents->msg;
        if($data['etat'] == 401){
            return  redirect()->route("agent.login")->withError($data['msg']);
        }
        $data['user'] = $contents->user;
        $data['campaign'] = $contents->campaign;
        $data['session_name'] = $contents->session_name;
        $data['server_ip'] = $contents->server_ip;
        $data['agent_log_id'] = $contents->agent_log_id;
        $data['phone_login'] = $contents->phone_login;
        $data['phone_pass'] = $contents->phone_pass;
        $data['pass'] = $contents->pass;
        $data['conf_exten'] = $contents->conf_exten;
        $data['extension'] = $contents->extension;
        $data['protocol'] = $contents->protocol;
        $data['full_name'] = $contents->full_name;
       
       
        Session::put('user', $data['user']);
        Session::put('campaign', $data['campaign']);
        Session::put('phone_pass', $data['phone_pass']);
        Session::put('pass', $data['pass']);
        Session::put('session_name', $data['session_name']);
        Session::put('server_ip', $data['server_ip']);
        Session::put('phone_login', $data['phone_login']);
        Session::put('agent_log_id', $data['agent_log_id']);
        Session::put('conf_exten',$data['conf_exten']);
        Session::put('extension',$data['extension']);
        Session::put('protocol',$data['protocol']);
        Session::put('full_name',$data['full_name']);
        Session::put('etat', $data['etat']);
        Session::put('msg', $data['msg']);

        return redirect()->route('agent.index');
        
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return redirect()->route("login");
    }
}
