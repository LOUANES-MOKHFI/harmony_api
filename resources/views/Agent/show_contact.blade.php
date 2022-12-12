@extends('master')
@section('css')

<link rel="stylesheet" href="{{asset('assets/agents/index.css')}}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
<link rel='stylesheet' href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css'/>
<link rel='stylesheet' href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css' />
<link rel='stylesheet' href='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/agents/metro-all.min.css')}}">

@endsection
@section('title')
AFFICHER UNE FICHE 
@endsection
@section('content')


           
<!-- BEGIN QUICK SIDEBAR -->
<a href="javascript:;" class="page-quick-sidebar-toggler">
    <i class="icon-bubbles"></i>
</a>
<!-- END QUICK SIDEBAR --><!-- BEGIN CONTENT -->
<div class="page-content-wrapper">

    
    <div class="page-content">
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <!-- <h1>Chronomètre en Javascript</h1> -->

        
       
        <div class="row">
            <div class="col-md-12 dashboard_panel ">
                <div class="col-md-12 bloc_incall" id="production_tabs" >
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                
                                <span>Informations sur le contact</span><br><br>
                                <a class="fa fa-user with-tooltip info-ctc info-ctc-open" data-action="toggle" data-side="top" data-original-title="Cliquer ici pour modifier les informations du contact"></a><span id="info-ctc-name">
                                    <span><i class="text-success fa fa-phone"></i>{{$lead->tel1}}</span> / <span><i class="text-success fa fa-fax"></i>{{$lead->contact_tel}}</span> / <span><i class="text-success fa fa-map"></i>{{$lead->adr4_libelle_voie}}</span> / {{$lead->contact_cp}} / {{$lead->contact_ville}} / {{$lead->adr1_civilite_abrv}} / {{$lead->contact_nom}} / {{$lead->contact_prenom}} 
                                </span>
                            </div>
                            <button onclick="history.back()" class="btn btn-info">Retour</button>
                            <button  class="btn btn-circle btn-sm btn-icon-only splitrecording SplitRecordAct" type="button"
                                    style="position: fixed; z-index: 10000022; left: 0; top:65%">
                                <i class="fa fa-cut"></i>
                            </button>
                            <div class="tools font-blue uppercase" id="info_fichier"></div>
                        </div>
                        <div class="portlet-body">
                            <style>
                            
                                .sidebar.top {
                                    left: 0;
                                    right: 0;
                                    top: -1000000px;
                                    background: #fff;
                                    display: none;
                                }

                                .sidebars>.sidebar {
                                    box-shadow: 5px 0 5px rgba(0, 0, 0, 0.64);
                                    position: fixed;
                                    z-index: 9999;
                                }
                            </style>

                            <div id="content_ecran_conf" style="padding: 10px;">
                                
                                <div class="form-group" dir="ltr" data-prop="field_expert" data-numfield="2858">
                                    <span data-class="traduction-2-2858">
                                        <p style="text-align: center;">
                                            <span style="font-size:24px;">
                                                <span style="color:#FF0000;">
                                                    <strong>
                                                        <span style="background-color:#D3D3D3;">!!! ATTENTION !!!&nbsp;</span>
                                                    </strong>
                                                </span>
                                            </span>
                                        </p>

                                        <p style="text-align: center;">
                                            <span style="font-size:24px;"><span style="color:#000000;"><strong>
                                                <span style="background-color:#ff3333;">PRENDRE CONGE SI PROSPECT DONNE A L'AMBASSADEUR UNADEV&nbsp;<input id="date_chargement" name="hidden_date_chargement" type="hidden" value="20220919"></span></strong></span>
                                            </span>
                                        </p>

                                        <p id="limite" style="text-align: center;font-size:24px;">SVP DATE LIMITE RAPPEL PERSO: Sun Oct 09 2022 01:00:00 GMT+0100 (UTC+01:00)</p>
                                        
                                        <p id="tempCall" style="color: green;">
                                            <!-- <span id="extra-min">0</span><span id="min">4</span> <span>:</span> <span id="extra-sec" style="display: none;">0</span><span id="tempCall">57</span> -->
                                        </p>
                                            <style type="text/css">
                                                #all-time{
                                                font-family: 'Jazz LET';
                                                font-size: 45px;
                                                margin: 10px auto;
                                                width: 305px;
                                                text-align: left;
                                                padding: 0px;
                                                animation: flux 2s linear infinite;
                                                -moz-animation: flux 0.9s linear infinite;
                                                -webkit-animation: flux 0.9s linear infinite;
                                                -o-animation: flux 0.9s linear infinite;
                                                }

                                                @keyframes flux {
                                                0%,
                                                100% {
                                                    text-shadow: 0 0 1vw #1041FF, 0 0 0vw #1041FF, 0 0 0vw #1041FF, 0 0 0vw #1041FF, 0 0 .4vw #8BFDFE, .5vw .5vw .9vw #147280;
                                                    color: #28D7FE;
                                                }
                                                50% {
                                                    text-shadow: 0 0 .5vw #082180, 0 0 1.5vw #082180, 0 0 5vw #082180, 0 0 5vw #082180, 0 0 .2vw #082180, .5vw .5vw .9vw #0A3940;
                                                    color: #146C80;
                                                }
                                                }

                                                #extra-min {
                                                margin-left: 1%;
                                                }
                                            </style>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn btn-danger" onclick="requalifier()">Requalifier la fiche</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button onclick="ManualDial('{{$lead->phone_number}}')" data-phone="{{$lead->phone_number}}" class="btn btn-sm btn-danger "><i class="fa fa-phone"></i> Appel Manuel</button>
                                    </div>
                                    
                                </div>

                                @if(session()->has('success'))
                                            <div class="alert alert-success text-center" id="msg">
                                            {{ session()->get('success') }}
                                            </div>
                                @elseif(session()->has('error'))
                                            <div class="alert alert-danger text-center" id="msg">
                                            {{ session()->get('error') }}
                                            </div>
                                @endif
                                <form id="" method="post" action="{{route('register_new_contact_info_post')}}">
                                    @csrf
                                    <input type="hidden" id="lead_id" name="lead_id" value='{{$lead->lead_id}}'>
                                    <div class="form-group" dir="ltr" data-prop="field_button" data-numfield="798"></div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="2">
                                        <span data-class="traduction-2-2">
                                            <style type="text/css">
                                                .col { float: left; width: 20%; min-width: 100px; text-align: center }
                                                    .clear { clear: both; }
                                            </style>
                                            
                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="9">
                                        <span data-class="traduction-2-9">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }
                                            </style>
                                            <div class="col left">
                                                <br>
                                                Date Don<input class="form-control" disabled="" maxlength="3" name="Date_Don" type="text" id="">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                ID client<input class="form-control" disabled="" maxlength="3" name="ID_client" type="text" id="">
                                            </div>

                                            <div class="col right">
                                                <br>
                                                Modulo Client<input class="form-control" maxlength="3" disabled="" name="Modulo_Client" type="text" id="">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="414">
                                        <span data-class="traduction-2-414"><h4>
                                        <cmkdefault><strong><span style="color:#0000FF;">ID TOTAL</span> : {{$lead->id_total}}</strong></cmkdefault></h4>

                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    CIVILITE<input class="form-control new_x" readonly="" id="civilite" name="civilite" type="text" value="MME" value="{{$lead->adr1_civilite_abrv}}">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                    new_CIVILITE<input class="form-control new_x" readonly="" id="new_civilite" name="new_civilite" type="text" value="MME" value="{{$lead->new_adr1_civilite_abrv}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    NOM<input class="form-control" id="contact_nom" readonly="" value="{{$lead->contact_nom}}" name="contact_nom" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_NOM<input class="form-control" id="new_contact_nom" name="new_contact_nom" type="text" value="{{$lead->new_contact_nom}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    PRENOM<input class="form-control" id="contact_prenom" readonly="" value="{{$lead->contact_prenom}}" name="contact_prenom" type="text" 
                                                    >
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_PRENOM<input class="form-control" id="new_contact_prenom" name="new_contact_prenom" type="text" value="{{$lead->new_contact_prenom}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    RAISON SOCIALE<input class="form-control" id="raison_sociale" readonly="" value="{{$lead->raison_sociale}}" name="raison_sociale" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_RAISON SOCIALE<input class="form-control" id="new_raison_sociale" name="new_raison_sociale" type="text" value="{{$lead->new_raison_sociale}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    PROFESSIONNEL<input class="form-control" id="professionnel" readonly="" value="{{$lead->professionnel}}" name="professionnel  " type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_PROFESSIONNEL<input class="form-control" id="new_professionnel" name="new_professionnel " type="text" value="{{$lead->new_professionnel}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    ADR2<input class="form-control" id="adr2" readonly="" value="{{$lead->adr2}}" name="adr2" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_ADR2<input class="form-control" id="new_adr2" name="new_adr2" type="text" value="{{$lead->new_adr2}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    ADR3<input class="form-control" id="adr3" readonly="" value="{{$lead->adr3}}" name="adr3" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_ADR3<input class="form-control" value="{{$lead->new_adr3}}"  id="new_adr3" name="new_adr3" type="text">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    ADR4 LIBELLE VOIE<input class="form-control" id="adr4_libelle_voie" readonly="" value="{{$lead->adr4_libelle_voie}}" value="{{$lead->new_adr4_libelle_voie}}" name="adr4_libelle_voie" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_ADR4 LIBELLE VOIE<input class="form-control" id="new_adr4_libelle_voie" name="new_adr4_libelle_voie" type="text">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    ADR5<input class="form-control" id="adr5" readonly="" value="{{$lead->adr5}}" name="adr5" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_ADR5<input class="form-control" value="{{$lead->new_adr5}}" id="new_adr5" name="new_adr5" type="text">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    CONTACT CP<input class="form-control" id="contact_cp" readonly="" value="{{$lead->contact_cp}}" value="{{$lead->contact_cp}}" name="contact_cp" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT CP<input class="form-control" id="new_contact_cp" name="new_contact_cp" type="text" value="{{$lead->new_contact_cp}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    CONTACT VILLE<input class="form-control" id="contact_ville" readonly="" value="{{$lead->contact_ville}}" name="contact_ville" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT VILLE<input class="form-control" id="new_contact_ville" name="new_contact_ville" type="text" value="{{$lead->new_contact_ville}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    CONTACT TEL<input class="form-control" id="contact_tel" readonly="" value="{{$lead->contact_tel}}"  name="contact_tel" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT TEL<input class="form-control" id="new_contact_tel" name="new_contact_tel" type="text" value="{{$lead->new_contact_tel}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    TEL1<input class="form-control" id="tel1" readonly="" value="{{$lead->tel1}}" name="tel1" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_TEL1<input class="form-control" id="new_tel1" name="new_tel1" type="text" value="{{$lead->contact_tel1}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    CONTACT EMAIL<input class="form-control" id="contact_email" readonly="" value="{{$lead->contact_email}}" name="contact_email" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT EMAIL<input class="form-control" id="new_contact_email" name="new_contact_email" type="text" value="{{$lead->new_contact_email}}">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                   
                                    <div class="form-group" dir="ltr" data-prop="field_textarea" data-numfield="33">
                                        <label class="control-label">
                                            <b data-class="traduction-2-33">Commentaire</b>
                                        </label>
                                        <textarea data-elid="33" name="commentaire" id="commentaire"  rows="5" cols="6" class="form-control">
                                            {{$lead->commentaire}}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-info" type="submit">VALIDER</button>
                                    </div>
                                </form>
                                
                                <div class="form-group" dir="ltr" data-prop="field_button" data-numfield="188">
                                    <a href="{{route('send_msg_contact',$lead->lead_id)}}" target="_blank" class="btn blue btn-lg send_msg">Envoyer un Message</a>
                                </div>
                                <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="207">
                                    <span data-class="traduction-2-207">
                                        <p>
                                            <input class="form-control" id="" name="tel_joint" type="hidden" value="CMK_S_FIELD_DERNIER_TELEPHONE_COMPOSE">
                                        </p>

                                        <p>
                                        </p>
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal En Attente d'un appel -->
            <div id="myModal2" class="modal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 id="myModalLabel"></h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body container">
                                    <div class="row">
                                     <form id="" method="post" action="{{route('update_qualif_contact')}}">
                                        @csrf
                                        <input type="hidden" name="uniqueid" id="uniqueid" value="{{$uniqueid}}">
                                        <input type="hidden" name="list_id" id="list_id" value="{{$lead->list_id}}">
                                        <input type="hidden" name="called_count" id="called_count" value="{{$lead->called_count}}">
                                        <input type="hidden" name="lead_id" id="lead_id1" value="{{$lead->lead_id}}">
                                        <div class="row container text-canter">
                                            @isset($statuses)
                                                @foreach($statuses as $key => $status)
                                                    <?php $abrv = mb_substr($status->status, 0, 2) ?>
                                                    <?php $abrv3 = mb_substr($status->status, 0, 3) ?>
                                                    <?php $listStatuslength = strlen($status->status) ?>
                                                    @if($abrv == "DM" && $listStatuslength == 2)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div>
                                                    @elseif($abrv == "DL" && $listStatuslength == 2)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div> 
                                                    @elseif($abrv3 == "FNM" && $listStatuslength ==3)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div>
                                                    
                                                    @elseif($abrv == "HC" && $listStatuslength == 2)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div>
                                                    @elseif($abrv == "PA" && $listStatuslength == 2)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div>
                                                    @elseif($abrv == "PL" && $listStatuslength == 2)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div>
                                                    @elseif($abrv == "RA" && $listStatuslength == 2)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div> 
                                                    @elseif($abrv == "RR" && $listStatuslength == 2)
                                                        <div class="col-md-4">
                                                            <input type="radio" class="qualif" data-value="{{$status->status}}" name="qualif">
                                                            <label> {{$status->status_name}}</label>
                                                        </div>
                                                    @endif
                                                        
                                                @endforeach
                                            @endisset
                                            <div class="col-md-4">
                                                <input type="radio" class="qualif" data-value="qualifAutre" name="qualif">
                                                <label> Autres Qualificiations</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" class="qualif" data-value="CALLBK" name="qualif" value="CALLBK">
                                                <label> RAPPEL </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <ul class="list-group list-group-flush">
                                                @isset($statuses)
                                                    @foreach($statuses as $key => $status)
                                                        <?php $abrv = mb_substr($status->status, 0, 2) ?>
                                                        <?php $abrv3 = mb_substr($status->status, 0, 3) ?>
                                                        <?php $listStatuslength = strlen($status->status) ?>
                                                        @if($abrv == "DM" && $listStatuslength > 2)
                                                            <li class="list-group-item sub_qualif{{$abrv}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label>
                                                                </div>
                                                            </li>
                                                        @elseif($abrv == "DL" && $listStatuslength > 2)
                                                            <li class="list-group-item sub_qualif{{$abrv}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label> 
                                                                </div>
                                                            </li>
                                                        @elseif($abrv3 == "FNM" && $listStatuslength > 3)
                                                            <li class="list-group-item sub_qualif{{$abrv3}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label>
                                                                </div>
                                                            </li>

                                                        @elseif($abrv == "HC" && $listStatuslength > 2)
                                                            <li class="list-group-item sub_qualif{{$abrv}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label>
                                                                </div>
                                                            </li>
                                                        @elseif($abrv == "PA" && $listStatuslength > 2)
                                                            <li class="list-group-item sub_qualif{{$abrv}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label>
                                                                </div>
                                                            </li>
                                                        @elseif($abrv == "PL" && $listStatuslength > 2)
                                                            <li class="list-group-item sub_qualif{{$abrv}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label>
                                                                </div>
                                                            </li>
                                                        @elseif($abrv == "RA" && $listStatuslength > 2)
                                                            <li class="list-group-item sub_qualif{{$abrv}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label> 
                                                                </div>
                                                            </li>
                                                        @elseif($abrv == "RR" && $listStatuslength > 2)
                                                            <li class="list-group-item sub_qualif{{$abrv}}" style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label>
                                                                </div>
                                                            </li>
                                                        @elseif($status->status == "DOUBL" || $status->status == "IND" || $status->status == "INDOLD" || $status->status == "RP" || $status->status == "REL" || $status->status == "REP")
                                                            <li class="list-group-item sub_qualifAutre"  style="display: none;">
                                                                <div class="card-body">
                                                                <input type="radio" class="sub_qualif" data-value="{{$status->status}}" name="sub_qualif" value="{{$status->status}}">
                                                                <label> {{$status->status_name}}</label>
                                                                </div>
                                                            </li>
                                                        @endif

                                                    @endforeach
                                                @endisset
                                                        
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12 container">
                                            <div class="text-canter">
                                                <input type="checkbox" name="agent_status" id="agent_status" value="1">  Met en pause apres la qualificiation
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group" style="display:none" id="divCalendar">
                                            
                                            <div class="form-group col-md-12">
                                                <div data-role="calendar" id="calendar"  data-wide-point="sm" data-buttons="false" data-on-day-click="myFunctionDate"></div>
                                            
                                                <input type="hidden" name="date" id="date" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-4 col-lg-4">
                                                <label for="Hour">Heure :</label>
                                                <input type="time" name="hour" id="hour" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-4 col-lg-4">
                                                <input type="checkbox" name="CallBackOnlyMe" id="CallBackOnlyMe">  MY CALLBACK ONLY
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="comment">Comment :</label>
                                                <input name="comments" id="comments" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="text-center">
                                                <button class="btn btn-success" type="submit"><i class="fa fa-save"></i>Valider</button>
                                            </div>
                                        </div>

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
</div>


 
<script src="{{asset('assets/admin/js/jquery-2.1.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/agents/metro.min.js')}}"></script>
<script src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>


<script type="text/javascript">
    ///// hangup a live call and chanel
    function requalifier() {
        $("#myModal2").modal("show"); 
    }

    $('#envoi_courrier').change(function() {
        if(this.value != null || this.value != ''){
            $('#montant_donDiv').css('display','block');
        }else{
            $('#montant_donDiv').css('display','none');
        }
    });
    
    ///// change qualif for contact and save it
    $(document).on('click', '.qualif', function () {
        var value;
        value = $(this).attr('data-value');
        if(value == 'DM'){$('.sub_qualifDM').css('display','block');}else{$('.sub_qualifDM').css('display','none');}
        if(value == 'DL'){$('.sub_qualifDL').css('display','block');}else{$('.sub_qualifDL').css('display','none');}
        if(value == 'FNM'){$('.sub_qualifFNM').css('display','block');}else{$('.sub_qualifFNM').css('display','none');}
        if(value == 'HC'){$('.sub_qualifHC').css('display','block');}else{$('.sub_qualifHC').css('display','none');}
        if(value == 'PA'){$('.sub_qualifPA').css('display','block');}else{$('.sub_qualifPA').css('display','none');}
        if(value == 'PL'){$('.sub_qualifPL').css('display','block');}else{$('.sub_qualifPL').css('display','none');}
        if(value == 'RA'){$('.sub_qualifRA').css('display','block');}else{$('.sub_qualifRA').css('display','none');}
        if(value == 'RR'){$('.sub_qualifRR').css('display','block');}else{$('.sub_qualifRR').css('display','none');}
        if(value == 'CALLBK'){$('#divCalendar').css('display','block');}else{$('#divCalendar').css('display','none');}
        if(value == 'qualifAutre'){$('.sub_qualifAutre').css('display','block');}else{$('.sub_qualifAutre').css('display','none');}
        //alert(value);
    });
    $(document).on('click', '.sub_qualif', function () {
        var value;
        value = $(this).attr('data-value');
    });
    $('#Update_dispo').on('submit',function(e){
        e.preventDefault();
        
        var value;    
        value = $("input[type='radio'][class='sub_qualif']:checked").val();
        
        let uniqueid = $('#uniqueid').val();
        let list_id = $('#list_id').val();
        let called_count = $('#called_count').val();
        let lead_id1 = $('#lead_id1').val();
        let agent_status = $('#agent_status:checked').val();
        let hour = $('#hour').val();
        let date = $('#date').val();
        let comments = $('#comments').val();
        // alert(value);
        let CallBackOnlyMe = $('#CallBackOnlyMe').val();
        
        if(CallBackOnlyMe == 'on'){
            CallBackrecipient = 'USERONLY';            
        }else{
            CallBackrecipient = 'ANYONE';
        }        
        
        $.ajax({
            url: 'Update_dispo/',
            type: "get",
            data:{
                    "_token":"{{csrf_token()}}",
                    uniqueid:uniqueid,
                    list_id:list_id,
                    called_count:called_count,
                    lead_id:lead_id1,
                    agent_status:agent_status,
                    dispo_choice:value,
                    CallBackrecipient:CallBackrecipient,
                    hour:hour,
                    date:date,
                    comments:comments,
                },
            success:function(response)
            {   
                $("#myModal2").modal("hide");
                //console.log(response);
                status = response.etat;
                //alert(response);
                msg = response.msg;
                if(status == 200){
                   /////////
                   
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: msg + ' ' +response.dispo_choice,
                        showConfirmButton: true,
                        timer: 500
                    });

                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: true,
                        timer: 500
                    });
                }
                    
            },
            
        });
    });
   ////Send new contact info
    $('#RegisternewInfoContact').on('submit',function(e){

        e.preventDefault();
        let new_adr1_civilite_abrv = $('#new_civilite').val();
        let new_contact_nom = $('#new_contact_nom').val();
        let new_contact_prenom = $('#new_contact_prenom').val();
        let new_raison_sociale = $('#new_raison_sociale').val();
        let new_professionnel = $('#new_professionnel').val();
        let new_adr2 = $('#new_adr2').val();
        let new_adr3 = $('#new_adr3').val();
        let new_adr4_libelle_voie = $('#new_adr4_libelle_voie').val();
        let new_adr5 = $('#new_adr5').val();
        let new_contact_cp = $('#new_contact_cp').val();
        let new_contact_ville = $('#new_contact_ville').val();
        let new_contact_tel = $('#new_contact_tel').val();
        let new_tel1 = $('#new_tel1').val();
        let new_contact_email = $('#new_contact_email').val();
        let commentaire = $('#commentaire').val();
        let cas_particulier = $('#cas_particulier').val();
        let type_accord   = $('#type_accord').val();
        let envoi_courrier   = $('#envoi_courrier').val();
        let montant_don = $('#montant_don').val();
        let lead_id1 = $('#lead_id1').val();
        
        //// send contact info to controller
        $.ajax({
            url: 'register_new_contact_info/',
            type: "post",
            data:{
                    "_token":"{{csrf_token()}}",
                    new_adr1_civilite_abrv : new_adr1_civilite_abrv,
                    new_contact_nom : new_contact_nom,
                    new_contact_prenom : new_contact_prenom,
                    new_raison_sociale : new_raison_sociale,
                    new_professionnel : new_professionnel,
                    new_adr2 : new_adr2,
                    new_adr3 : new_adr3,
                    new_adr4_libelle_voie : new_adr4_libelle_voie,
                    new_adr5 : new_adr5,
                    new_contact_cp : new_contact_cp,
                    new_contact_ville : new_contact_ville,
                    new_contact_tel : new_contact_tel,
                    new_tel1 : new_tel1,
                    new_contact_email : new_contact_email,
                    commentaire : commentaire,
                    cas_particulier:cas_particulier,
                    type_accord: type_accord,
                    envoi_courrier : envoi_courrier, 
                    montant_don:montant_don,
                    lead_id : lead_id1,
        
                },
            success:function(response)
            {   
                /// return response
                status = response.etat;
                msg = response.msg;
                if(status == 200){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: msg,
                        showConfirmButton: true,
                        timer: 5000
                    });
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: true,
                        timer: 5000
                    });
                }
               
            },
        });
    });
</script>

<script>
    function myFunctionDate(sel, day, el){
        document.getElementById('date').value = sel;
    }

    ////change status (start production (READY) , stop production (PAUSED))
    $(".agentStatusButton").click(function(){
        status = $(".agentStatusButton").attr("data-value"); // get user live status
        if(status == 'QUEUE' || status == 'INCALL'){
            status = 'READY';
        }
            $.ajax({
                url: 'change_status/'+status,   /// send status in request
                type: "get",
                success:function(response)
                {
                    if(response.etat == 200){
                        $(".agentStatusButton").attr("data-value",response.etatAgent);                                
                        document.getElementById('etat_agent').value = response.etatAgent;
                        if(response.etatAgent == 'PAUSED'){
                           
                            $(".dashboard_panel").removeClass('darkBackground');
                            $('.bloc_attente').css('display','none');
                            $('.dashboard_agent').css('display','block');
                            $(".agentStatusButton").empty();
                            $(".agentStatusButton").html('Démarrer la production');
                        }
                        if(response.etatAgent == 'READY'){
                            $(".dashboard_panel").addClass('darkBackground');
                            $('.dashboard_agent').css('display','none');
                            $('.bloc_attente').css('display','block');
                            $(".agentStatusButton").empty();
                            $(".agentStatusButton").append(`<i
                            class="fa fa-arrow-circle-o-left"></i> Retour au menu Principal `);
                        }
                    }
                },
            });
    });

    ///// lancer le viciphone

    $("#webphone1").click(function(){        
        $.ajax({
            url: 'activate_webphone',
            type: "get",
            success:function(response)
            {   
                toastr.options = {
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "timeOut": "4000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                if(response.etat == 200){
                    toastr.success('webphone is activated');
                }else{
                    toastr.error('webphone Not Activated');
                }
            },
        });
    });
    ////// webphone wille be activate after 6 sec
    $(document).ready(function(){
        incall = setInterval(function(){
            $.ajax({
                url: 'activate_webphone',
                type: "get",
                success:function(response)
                {   
                    if(response.etat == 200){toastr.success('webphone is activated'); clearInterval(incall); }
                    else{ toastr.error('webphone Not Activated'); }
                },
            });
        },6000);
    })
     ///// get channel and leadId for the live call (CONTACT CALL)
    $(document).ready(function(){
        getchannel = setInterval(function(){  
            var etat = $("#etat_agent").val();
            if(etat == 'READY'){
                chan = document.getElementById('channel').value;
                if(chan == null || chan == ''){
                        $.ajax({
                            url: 'get_channel/',
                            type: "GET",
                            success:function(response)
                            {
                                status = response.etat;
                                msg = response.msg;
                                if(status == 200){
                                    console.log(response);                                    
                                    lead_id = response.lead_id;
                                    channel = response.channel;
                                    document.getElementById('channel').value = channel;
                                    //channel.setAttribute('value', channel);
                                    document.getElementById('lead_id').value = lead_id;
                                    $('.send_msg').attr('href', 'send_msg_contact/'+lead_id); /// add url to button send message or email to contact
                                }
                            },
                        });
                    }
                }  
            },1000);
    });


    
    ///// get Status and start chrono if status == INCALL
    $(document).ready(function(){
        const getStatus = setInterval(function(){ 
            
            lead_id = document.getElementById('lead_id').value;
            if(lead_id == '' || lead_id == null){
                $.ajax({
                    url: 'get_status/',
                    type: "GET",
                    success:function(response)
                    {
                        status = response.etat;                    
                        etatAgent = response.etatAgent;                    
                        if(status == 200){
                            $.ajax({
                                url: 'get_time_agent/',
                                type: "GET",
                                success:function(response)
                                {
                                    if(response.etat == 200){
                                        time = response.time;
                                        if(time < 3600){ 
                                        heures = 0; 
                                        
                                        if(time < 60){minutes = 0;} 
                                        else{minutes = Math.floor(time / 60);} 
                                        
                                        secondes = Math.floor(time % 60); 
                                        } 
                                        else{ 
                                        heures = Math.floor(time / 3600); 
                                        secondes = Math.floor(time % 3600); 
                                        minutes = Math.floor(secondes / 60); 
                                        } 
                                        
                                        secondes2 = Math.floor(secondes % 60); 
                                        if(heures<10){
                                            heures = '0' + heures;
                                        }
                                        if(minutes<10){
                                            minutes = '0' + minutes;
                                        }
                                        if(secondes2<10){
                                            secondes2 = '0' + secondes2;
                                        }
                                        afficher = heures + ":" + minutes + ":" + secondes2 ;
                                        if(etatAgent == 'PAUSED'){
                                            document.getElementById("timePAUSED").innerHTML = afficher;
                                            

                                            ;
                                        }
                                        if(etatAgent == 'READY'){

                                            document.getElementById("timeREADY").innerHTML = afficher;
                                        }
                                        
                                    }
                                }
                            }); 
                        }
                    },
                });
            }
            else{
                $.ajax({
                    url: 'get_status/',
                    type: "GET",
                    success:function(response)
                    {
                        status = response.etat;                    
                        if(status == 200){
                            if(response.etatAgent == 'INCALL'){
                                $.ajax({
                                    url: 'refresh_incall/',
                                    type: "GET",
                                    success:function(response)
                                    {},
                                }); 
                                $("time").css('display','none');
                                $.ajax({
                                    url: 'get_time_incall/'+lead_id,
                                    type: "GET",
                                    success:function(response)
                                    {
                                        if(response.etat == 200){
                                            time = response.time;
                                            if(time < 3600){ 
                                            heures = 0; 
                                            
                                            if(time < 60){minutes = 0;} 
                                            else{minutes = Math.floor(time / 60);} 
                                            secondes = Math.floor(time % 60); 
                                            } 
                                            else{ 
                                            heures = Math.floor(time / 3600); 
                                            secondes = Math.floor(time % 3600); 
                                            minutes = Math.floor(secondes / 60); 
                                            } 
                                            secondes2 = Math.floor(secondes % 60); 
                                            if(heures<10){
                                                heures = '0' + heures;
                                            }
                                            if(minutes<10){
                                                minutes = '0' + minutes;
                                            }
                                            if(secondes2<10){
                                                secondes2 = '0' + secondes2;
                                            }
                                            afficher = heures + ":" + minutes + ":" + secondes2 ;
                                            document.getElementById("timeINCALL").innerHTML = afficher;
                                            document.getElementById("timeINCALL1").innerHTML = afficher;
                                        }
                                    }
                                });
                                
                            }
                            

                        }
                    },
                }); 
            } 
        },1000);
    });
    ///// hangup a live call and chanel
    function hangupQualif() {
        $("#myModal2").modal("hide");
        $("#divCalendar").css('display','none');
        $('.sub_qualifDM').css('display','none');
        $('.sub_qualifDL').css('display','none');
        $('.sub_qualifFNM').css('display','none');
        $('.sub_qualifHC').css('display','none');
        $('.sub_qualifPA').css('display','none');
        $('.sub_qualifPL').css('display','none');
        $('.sub_qualifRA').css('display','none');
        $('.sub_qualifRR').css('display','none');
        $('#divCalendar').css('display','none');
        $('.sub_qualifAutre').css('display','none');
        $("input[type='radio'][class='qualif']:checked").prop('checked', false);
        $("input[type='radio'][class='sub_qualif']:checked").prop('checked', false);

        document.getElementById('date').value = '';
        document.getElementById('hour').value = '';
        document.getElementById('CallBackOnlyMe').value = '';
        document.getElementById('comments').value = '';
    
        //e.preventDefault();
        channel = document.getElementById('channel').value;
        agentchannel = document.getElementById('agentchannel').value;
        if(channel == null || channel == ''){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Aucun appel en cours',
                showConfirmButton: true,
                timer: 5000
            });
        }
        else{
            called_count = document.getElementById('called_count').value;
            uniqueid = document.getElementById('uniqueid').value;
            lead_id = document.getElementById('lead_id1').value;
            list_id = document.getElementById('list_id').value;
            phone_number = document.getElementById('tel1').value;
            phone_code = document.getElementById('phone_code').value;
            $.ajax({
                url: 'hangup/',
                data: {
                    called_count:called_count,
                    uniqueid:uniqueid,
                    lead_id:lead_id,
                    list_id:list_id,
                    phone_number:phone_number,
                    phone_code:phone_code,
                    channel:channel,
                    agentchannel:agentchannel
                },
                type: "get",
                success:function(response)
                {
                    $("#myModal2").modal("show");
                    //console.log(response.statuses);
                    if(response.etat == 200){
                        //arret();raz();
                        //chrono();//debut();
                        //alert(response.statuses);
                        statuses = response.statuses;
                        $(".quallif").empty();
                        $(".quallif").append(``);
                       // $('#ListQualification').empty();
                        $('#don_avec_montant').empty();
                        $('#don_en_ligne').empty();
                        $('#faux_numero_machine').empty();
                        $('#hors_cible').empty();
                        $('#pa').empty();
                        $('#pa_en_ligne').empty();
                        $('#refus_argumente').empty();
                        $('#refus_de_repondre').empty();
                        $('#autre').empty(); 
                        document.getElementById('id_total').value = '';
                        document.getElementById('civilite').value = '';
                        document.getElementById('contact_nom').value = '';
                      //alert(document.getElementsByClassName('contact_nom').value);
                        document.getElementById('contact_prenom').value = '';
                        document.getElementById('raison_sociale').value = '';
                        document.getElementById('professionnel').value = '';
                        document.getElementById('adr2').value = '';
                        document.getElementById('adr3').value = '';
                        document.getElementById('adr4_libelle_voie').value = '';
                        document.getElementById('adr5').value = '';
                        document.getElementById('contact_ville').value = '';
                        document.getElementById('contact_cp').value = '';
                        document.getElementById('contact_tel').value = '';
                        document.getElementById('tel1').value = '';
                        document.getElementById('contact_email').value = '';
                        document.getElementById('commentaire').value = '';
                       /////////
                        //document.getElementById('phone_code1').value = '';
                        document.getElementById('phone_code').value = '';   
                        document.getElementById('montant_don').value = '';   
                        document.getElementById('deduction').value = '';   
                        document.getElementById('montantfinal').value = '';   
                        document.getElementById('date').value = '';   
                        document.getElementById('hour').value = '';   
                        document.getElementById('CallBackOnlyMe').value = '';   
                       // document.getElementById('comment').value = '';   
                        document.getElementById('comments').value = '';   
                                
                    }
                },
            });
        }  
    }
    function hangup() {
        $("#myModal2").modal("hide");
        
    
        //e.preventDefault();
        channel = document.getElementById('channel').value;
        agentchannel = document.getElementById('agentchannel').value;
        if(channel == null || channel == ''){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Aucun appel en cours',
                showConfirmButton: true,
                timer: 5000
            });
        }
        else{
            called_count = document.getElementById('called_count').value;
            uniqueid = document.getElementById('uniqueid').value;
            lead_id = document.getElementById('lead_id1').value;
            list_id = document.getElementById('list_id').value;
            phone_number = document.getElementById('tel1').value;
            phone_code = document.getElementById('phone_code').value;
            $.ajax({
                url: 'hangup/',
                data: {
                    called_count:called_count,
                    uniqueid:uniqueid,
                    lead_id:lead_id,
                    list_id:list_id,
                    phone_number:phone_number,
                    phone_code:phone_code,
                    channel:channel,
                    agentchannel:agentchannel
                },
                type: "get",
                success:function(response)
                {
                    if(response.etat == 200){
                        statuses = response.statuses;          
                    }
                },
            });
        }  
    }


    $('#envoi_courrier').change(function() {
        if(this.value != null || this.value != ''){
            $('#montant_donDiv').css('display','block');
        }else{
            $('#montant_donDiv').css('display','none');
        }
    });
    ///// lancer un appel manuel 
    function ManualDial(phoneNumber){
       
        //let phoneNumber = $(".ManualDial").attr("data-phone"); 
        //alert(phoneNumber);
        $.ajax({
            url: 'manual_dial',
            type: "get",
            data:{
                    "_token":"{{csrf_token()}}",
                    phone_number:phoneNumber,
                },
            success:function(response)
            {   
                
                console.log(response);
                status = response.etat;
                msg = response.msg;

                if(status == 200){
                    document.getElementById('agentchannel').value = '';
                    document.getElementById('channel').value = '';
                    document.getElementById('id_total').innerHTML = '';
                    document.getElementById('civilite').value = '';
                    document.getElementById('contact_nom').value = '';
                    document.getElementById('contact_prenom').value = '';
                    document.getElementById('raison_sociale').value = '';
                    document.getElementById('professionnel').value = '';
                    document.getElementById('adr2').value = '';
                    document.getElementById('adr3').value = '';
                    document.getElementById('adr4_libelle_voie').value = '';
        
                    document.getElementById('adr5').value = '';
                    document.getElementById('contact_ville').value = '';
                    document.getElementById('contact_cp').value = '';
                    document.getElementById('contact_tel').value = '';
                    document.getElementById('tel1').value = '';
                    document.getElementById('contact_email').value = '';
                    document.getElementById('commentaire').value = '';
                    document.getElementById('uniqueid').value = '';
                    document.getElementById('list_id').value = '';
                    document.getElementById('lead_id').value = '';
                    document.getElementById('lead_id1').value = '';
                    document.getElementById('called_count').value = '';
                    lead = response.lead;
                    uniqueid = response.uniqueid;
                    channel = response.channel;
                    agentchannel = response.agentchannel;

                    $(".dashboard_panel").removeClass('darkBackground');
                    $('.bloc_incall').css('display','block');
                    $('.bloc_attente').css('display','none');
                    $('.dashboard_agent').css('display','none');                   
                    document.getElementById('agentchannel').value = agentchannel;
                    document.getElementById('channel').value = channel;
                    document.getElementById('id_total').innerHTML = lead.id_total;
                    document.getElementById('civilite').value = lead.adr1_civilite_abrv;
                    document.getElementById('contact_nom').value = lead.contact_nom;
                    document.getElementById('contact_prenom').value = lead.contact_prenom;
                    document.getElementById('raison_sociale').value = lead.raison_sociale;
                    document.getElementById('professionnel').value = lead.professionnel;
                    document.getElementById('adr2').value = lead.adr2;
                    document.getElementById('adr3').value = lead.adr3;
                    document.getElementById('adr4_libelle_voie').value = lead.adr4_libelle_voie;
                    document.getElementById('adr5').value = lead.adr5;
                    document.getElementById('contact_ville').value = lead.contact_ville;
                    document.getElementById('contact_cp').value = lead.contact_cp;
                    document.getElementById('contact_tel').value = lead.contact_tel;
                    document.getElementById('tel1').value = lead.tel1;
                    document.getElementById('contact_email').value = lead.contact_email;
                    document.getElementById('commentaire').value = lead.commentaire;
                    document.getElementById('uniqueid').value = uniqueid;
                    document.getElementById('list_id').value = lead.list_id;
                    document.getElementById('lead_id').value = lead.lead_id;
                    document.getElementById('lead_id1').value = lead.lead_id;
                    document.getElementById('called_count').value = lead.called_count;
                    /////////
                    document.getElementById('phone_code').value = '33';
                    $("#info-ctc-name").html(`<span><i class="text-success fa fa-phone"></i>${lead.tel1}</span> / <span><i class="text-success fa fa-fax"></i>${lead.contact_tel}</span> / <span><i class="text-success fa fa-map"></i>${lead.adr4_libelle_voie}</span> / ${lead.contact_cp} / ${lead.contact_ville} / ${lead.adr1_civilite_abrv} / ${lead.contact_nom} / ${lead.contact_prenom}`);
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: true,
                        timer: 500
                    });
                }
                    
                },
        });
    };
   
    

    
</script>


<script>
    ///calculate deduction and and final montant
    $('#montant_don').on('keyup',function(){
      
        montant_don = this.value;
        if(montant_don != null || montant_don != ''){
            var deduction = parseFloat(montant_don)*(66/100);
            var montantfinal = parseFloat(montant_don)*(34/100);

            if(this.value == ''){
                document.getElementById('deduction').value = '';
                document.getElementById('montantfinal').value = '';
            }else{
                document.getElementById('deduction').value = parseFloat(deduction).toFixed(2);
                document.getElementById('montantfinal').value = parseFloat(montantfinal).toFixed(2);
            }
            /*else if(this.value != '' && isNaN(deduction)){

                document.getElementById('deduction').value = parseFloat(deduction).toFixed(2);
            }*/

            //$('#deduction').html(deduction);
            //$('#montantfinal').html(montantfinal);
            
        }
    });
</script>
@endsection
