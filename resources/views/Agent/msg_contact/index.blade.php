@extends('master_Admin')
@section('css')
<style>

    .modal-dialog {
        width: 1300px;
        margin: 30px auto;
    }

   
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">

@endsection
@section('title')
Dashboard Agent
@endsection
@section('content')


           

<div class="page-content">
    <div class="page-content">

        <div class="row">
            <div class="col-md-6 dashboard_panel ">
                <div class="portlet light ">
                        <div class="caption caption-md row">
                            <div class="col-md-3" style="border-right:1px solid black">
                                
                            </div>
                           
                        </div>
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            Envoyer Un message de confirmation au client
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <span class="text-danger">Merci de choisir une seule action</span>
                                @if(session()->has('msg'))
                                    <div class="alert alert-info text-center" id="msg">
                                    {{ session()->get('msg') }}
                                    </div>
                                @endif
                        <div class="container row">
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="link_promesse">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                    <button class="btn btn-warning">Formulaire En Ligne</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="sms_info">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-primary">SMS Information</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="sms_promesse">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-danger">SMS Promesse</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="sms_felicitation">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-success">SMS Félicitaion</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="mail_info">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-info">Mail Information</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="mail_promesse">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-danger">Mail Promesse</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="mail_felicitation">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-success">Mail Félicitaion</button>
                                </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>  
            <div class="col-md-6 dashboard_panel ">
                <div class="portlet light ">
                        <div class="caption caption-md row">
                            <div class="col-md-3" style="border-right:1px solid black">
                                
                            </div>
                           
                        </div>
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            Cette espace est réservé pour la compagne UNICEF
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <span class="text-danger">Merci de choisir une seule action</span>
                                @if(session()->has('msgunicef'))
                                    <div class="alert alert-info text-center" id="msgunicef">
                                    {{ session()->get('msgunicef') }}
                                    </div>
                                @endif
                        <div class="container row">
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg_unicef')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="link_promesse">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                    <button class="btn btn-warning">Formulaire En Ligne</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg_unicef')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="sms_info">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-primary">SMS Information</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg_unicef')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="sms_promesse">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-danger">SMS Promesse</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg_unicef')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="sms_felicitation">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-success">SMS Félicitaion</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg_unicef')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="mail_info">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-info">Mail Information</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg_unicef')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="mail_promesse">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-danger">Mail Promesse</button>
                                </form>
                                </div>
                            </div>
                            <div clas="col-md-3">
                                <div class="form-group"> 
                                <form action="{{route('send_msg_unicef')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type_function" value="mail_felicitation">
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="nom" value="{{$nom}}">
                                    <input type="hidden" name="prenom" value="{{$prenom}}">
                                    <input type="hidden" name="adr4" value="{{$adr4}}">
                                    <input type="hidden" name="adr5" value="{{$adr5}}">
                                    <input type="hidden" name="cp" value="{{$cp}}">
                                    <input type="hidden" name="ville" value="{{$ville}}">
                                    <input type="hidden" name="idtotal" value="{{$idtotal}}">
                                    <input type="hidden" name="civilite" value="{{$civilite}}">
                                    <input type="hidden" name="mail" value="{{$mail}}">
                                    <input type="hidden" name="montant" value="{{$montant}}">
                                    <input type="hidden" name="assoc" value="{{$assoc}}">
                                    <input type="hidden" name="centre" value="{{$centre}}">
                                    <input type="hidden" name="ope" value="{{$ope}}">
                                    <input type="hidden" name="code" value="{{$code}}">
                                    <input type="hidden" name="port" value="{{$port}}">
                                
                                    <button class="btn btn-success">Mail Félicitaion</button>
                                </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>      
                      
        </div> 
    </div>
</div>


<script src="{{asset('assets/admin/js/jquery-2.1.1.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
