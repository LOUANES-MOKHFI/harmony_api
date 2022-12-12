@extends('login')
@section('Title')
    Login
@endsection
@section('content')


<div class="flex items-center justify-center h-full">
    <div class="flex loader" style="display: none"></div>
    <div class="bg-black rounded-lg px-8 py-8 shadow-2xl">
        <div class="flex justify-center mb-8">
            <img src="{{asset('logo.png')}}" alt="" width="250"/>
        </div>
        <div class="flex" id="adblock_alert"></div>
                    

        <div class="alert alert-info alert-dismissable msg-tow-factor" style="display: none;">
                Pour des raisons de sécurité nous venons de vous envoyer un email contenant le code d'autorisation d'accès, veuillez consulter votre boîte email 
        </div>
    
        <!-- zone de connexion -->
        
        @if(session()->has('success'))
            <div class="alert alert-success text-center" id="msg">
            {{ session()->get('success') }}
            </div>
        @elseif(session()->has('error'))
                    <div class="alert alert-danger text-center" id="msg">
                    {{ session()->get('error') }}
                    </div>
        @endif
        <form class="form" id="" method="POST" action="{{ route('login.custom') }}">
            @csrf

            <div class="mb-6 flex" style="display:flex">
                <input class="w-full bg-gray-700 appearance-none rounded  py-4 px-4
                           text-white rounded-r-none leading-tight focus:outline-none focus:bg-gray-800"
                        id="username" name="user" required
                    type="text" placeholder="Nom d'utilisateur" >
                    @if ($errors->has('user'))
                        <span class="text-danger">{{ $errors->first('user') }}</span>
                    @endif
                <div
                    class="bg-gray-700 appearance-none   py-4 px-4 text-white leading-tight focus:outline-none focus:bg-gray-800">
                    @
                </div>
                <input
                    class="w-full bg-gray-700 appearance-none rounded  py-4 px-4 text-white rounded-l-none
                           leading-tight focus:outline-none focus:bg-gray-800"
                    placeholder="Compte" id="account" name="account"
                    readonly="readonly" value="capitalcorp"
                    type="text">
            </div>
           

            <div class="mb-6 form-login">

                <input
                    class="bg-gray-700 appearance-none rounded  py-4 px-4 text-white leading-tight w-full focus:outline-none focus:bg-gray-800"
                    type="password" placeholder="Mot de passe" name="pass" required
                    id="password" >
                    @if ($errors->has('pass'))
                        <span class="text-danger">{{ $errors->first('pass') }}</span>
                    @endif

            </div>
            <div class="mb-6 form-login">
                <select class="form-control" name="campaign" required>
                    <option selected value=""> -- Choisir la compagne --</option>
                    @isset($campaigns)
                    @foreach($campaigns as $camp)
                        <option value="{{$camp->campaign_id}}">{{$camp->campaign_id.' - '.$camp->campaign_name}}</option>
                    @endforeach
                    @endisset
                </select>
                

            </div>
            <div class="flex items-left" id="login_info"></div>
            
            <div class="flex items-center justify-between">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded focus:outline-none btn-login"
                    type="submit" id='submit' value='LOGIN'>
                    Connexion                    
                </button>
            </div>
        </form>

        <hr class="border-t border-white opacity-25 my-6">
        <p class="text-xl text-white text-center mb-2 opacity-75">
            Capital Corp - CRM - &copy;- 2022 - Tous droits réservés
        </p>
        <div class="flex justify-center">
            <img src="{{asset('assets/agents/img/logo.png')}}" alt="" width="150" class="opacity-75">
        </div>
    </div>
</div>
@endsection