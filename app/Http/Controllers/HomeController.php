<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    private $serverbk = 'https://call3.harmoniecrm.com/harmony_api/index.php';
    public function index(){
        $data = [];
        $http = new \GuzzleHttp\Client(); 
        $response = $http->get($this->serverbk.'/campaigns');
        //dd($response->getBody()->toArray());
        $contents = $response->getBody()->getContents();

        $data['campaigns'] = json_decode($contents);
            
        return view('Agent.auth.login',$data);
    }
    public function loginAdmin(){
        return view('Admin.auth.login');
    }
    public function loginAgent(){
        $data = [];
        $http = new \GuzzleHttp\Client(); 
        $response = $http->get($this->serverbk.'/campaigns');
        //dd($response->getBody()->toArray());
        $contents = $response->getBody()->getContents();
        $data['campaigns'] = json_decode($contents);
            
        return view('Agent.auth.login',$data);
    }
}
