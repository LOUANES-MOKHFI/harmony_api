@extends('master')
@section('css')
<style>

    .modal-dialog {
        width: 1300px;
        margin: 30px auto;
    }

    #external-events {
        position: fixed;
        z-index: 2;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #ffffff;
        margin-top: 260px;
    }
    #TableHours {
        position: fixed;
        z-index: 2;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #ffffff;
        width: 10%;
    }
    #external-events .fc-event {
        margin: 1em 0;
        cursor: move;
    }
    .fc-button .fc-icon {
        color: black;
    }

    #timePAUSED,#timeREADY,#timeINCALL
    {
        width: 200px;
        height: 50px;
        line-height: 50px;
        border: 1px dotted #333;
        text-align: center;
        margin-bottom: 20px;
        font-size: 22px;
    }
    #presenter
    {
        font-size: 17px;
        visibility: hidden;
    }
    
    input[type="button"] {
        border: none;
        padding: 10px;
        background-color: rgba(50,205,50, 0.25);
        cursor: pointer;
    }
    .timePAUSEDDiv{
        padding: 4px;
        margin-left: 10px;
    }

</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
<link rel='stylesheet' href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css'/>
<link rel='stylesheet' href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css' />
<link rel='stylesheet' href='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<link rel="stylesheet" href="{{asset('assets/agents/metro-all.min.css')}}">

@endsection
@section('title')
Dashboard Agent
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
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar dashboard_agent">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet bordered">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic" style="cursor: pointer"
                                data-target="#user_pic_profile" data-toggle="modal">
                            <img
                                    src="{{asset('assets/agents/vvci/assets/sharedfiles/pic_user/default_user.jpg')}}"
                                    class="img-responsive avatar-upload" alt="">
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name"> {{Session::get('user')}} </div>
                            <div class="profile-usertitle-job">
                                <p><i class="icon-earphones-alt"></i> Poste : {{Session::get('phone_login')}}</p>
                                <p><i class="icon-user-following"></i> Compagne : {{Session::get('campaign')}}</p>
                                <div style="margin-left: 50px;" id="timePAUSED"></div> 
                            </div>
                            <input type="hidden" name="agent_status" id="agent_status" value="">
                            <input type="hidden" value="{{$etatAgent}}" id="etat_agent">

                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons">
                            <button type="button" data-value="PAUSED"
                                    class="btn btn-circle green-haze btn-sm  agentStatusButton">Démarrer la production
                            </button>
                            <div class="timePAUSEDDiv">
                                
                            </div>
                                  
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            
                        </div>
                        <!-- END MENU -->
                    </div>
                    <div class="portlet light bordered">
                        <div>
                            <h4 class="profile-desc-title">Pauses</h4>
                            <div class="margin-top-20 profile-desc-link">
                                <a data-target="#modal-pause-cafe" data-toggle="modal"  > <i class="fa fa-coffee"></i> Pause café </a>
                            </div>

                                <div class="margin-top-20 profile-desc-link"><a class="pause-generic log_action" data-log-action="request_pause" data-log-GRH_idpause="4" data-keyconfirmp="" data-idpause="4" data-confirm="0" data-pause-accepted="false"  data-label-pause="Pause Autre" > <i
                                                class="fa fa-pause"></i>
                                        Pause Autre <span class="label label-info hidden pause_traitement"  data-idpause="4"  data-keyconfirm="">En attente </span> </a>
                                </div>
                                <div class="margin-top-20 profile-desc-link"><a class="pause-generic log_action" data-log-action="request_pause" data-log-GRH_idpause="3" data-keyconfirmp="" data-idpause="3" data-confirm="0" data-pause-accepted="false"  data-label-pause="Pause Brief" > <i
                                                class="fa fa-pause"></i>
                                        Pause Brief <span class="label label-info hidden pause_traitement"  data-idpause="3"  data-keyconfirm="">En attente </span> </a>
                                </div>
                                <div class="margin-top-20 profile-desc-link"><a class="pause-generic log_action" data-log-action="request_pause" data-log-GRH_idpause="2" data-keyconfirmp="" data-idpause="2" data-confirm="0" data-pause-accepted="false"  data-label-pause="Pause Formation " > <i
                                                class="fa fa-pause"></i>
                                        Pause Formation  <span class="label label-info hidden pause_traitement"  data-idpause="2"  data-keyconfirm="">En attente </span> </a>
                                </div>
                                <div class="margin-top-20 profile-desc-link"><a class="pause-generic log_action" data-log-action="request_pause" data-log-GRH_idpause="1" data-keyconfirmp="" data-idpause="1" data-confirm="0" data-pause-accepted="false"  data-label-pause="Pause Dèj" > <i
                                                class="fa fa-pause"></i>
                                        Pause Dèj <span class="label label-info hidden pause_traitement"  data-idpause="1"  data-keyconfirm="">En attente </span> </a>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content dashboard_agent">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortable">
                            <div class="dashboard-stat yellow portlet portlet-sortable">
                                <div class="visual">
                                    <i class="fa  fa-calendar-check-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="" data-value=""><span id="nbrArgumente"></span></span>
                                    </div>
                                    <div class="desc">Argumenté</div>
                                </div>
                                <span class="more" href="javascript:;">
                            <span id="prctArgumente"></span>
                            % des Appels <!--i class="m-icon-swapright m-icon-white"></i-->
                        </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortable">
                            <div class="dashboard-stat green portlet portlet-sortable">
                                <div class="visual">
                                    <i class="fa  fa-thumbs-o-up"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="" data-value=""><span id="nbrPositif"></span></span>
                                    </div>
                                    <div class="desc">Positif</div>
                                </div>
                                <span class="more" href="javascript:;">
                            <span id="prctPositif"></span>
                            % des Appels <!--i class="m-icon-swapright m-icon-white"></i-->
                        </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortable">
                            <div class="dashboard-stat grey portlet portlet-sortable">
                                <div class="visual">
                                    <i class="fa fa-check-circle-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="" data-value=""><span id="nbrNoArgumente"></span></span>
                                    </div>
                                    <div class="desc">Non argumenté</div>
                                </div>
                                <span class="more" href="javascript:;">
                            &nbsp; <!--  View more <i
                                class="m-icon-swapright m-icon-white"></i>-->
                        </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortable">
                            <div class="dashboard-stat blue portlet portlet-sortable">
                                <div class="visual">
                                    <i class="icon-call-end"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="" data-value=""><span id="nbrRDV"></span></span>
                                    </div>
                                    <div class="desc">Fiches</div>
                                </div>
                                <span class="more" href="javascript:;">
                            &nbsp;<!--  View more <i
                                class="m-icon-swapright m-icon-white"></i>-->
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortable">
                            <div class="dashboard-stat purple">
                                <div class="visual">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="" data-value="89"></span><span
                                                id="presenceTime"></span>
                                    </div>
                                    <div class="desc">Heure présence</div>
                                </div>
                                <span class="more" href="javascript:;">
                            &nbsp;<!--  View more <i
                                class="m-icon-swapright m-icon-white"></i>-->
                        </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortable">
                            <div class="dashboard-stat blue portlet portlet-sortable">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="" data-value=""><span id="debriefTime"></span></span>
                                    </div>
                                    <div class="desc">Debrief</div>
                                </div>
                                <span class="more" href="javascript:;">
                            &nbsp;<!--  View more <i
                                class="m-icon-swapright m-icon-white"></i>-->
                        </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                            <div class="dashboard-stat red ui-sortable">
                                <div class="visual">
                                    <i class="fa fa-coffee"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                <span data-counter="" data-value=""><span id="cafeTime"></span>
                                </span>
                                    </div>
                                    <div class="desc">Pauses</div>
                                </div>
                                <span class="more" href="javascript:;">
                            &nbsp;<!--  View more <i
                                class="m-icon-swapright m-icon-white"></i>-->
                        </span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortable">
                            <div class="dashboard-stat green">
                                <div class="visual">
                                    <i class="fa fa-hourglass"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                <span data-counter="counteruppp" data-value="549"><span
                                            id="prodTime"></span></span>
                                    </div>
                                    <div class="desc">Heure production</div>
                                </div>
                                <span class="more" href="javascript:;">
                            &nbsp;<!--  View more <i
                                class="m-icon-swapright m-icon-white"></i>-->
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PORTLET -->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="fa fa-phone font-blue-madison"></i> <span
                                                class="caption-subject font-blue-madison bold uppercase">
                                        Mes rappels</span>
                                    </div>
                                    <div class="actions">
                                        <div class="portlet-input input-inline">
                                            <div class="checkbox-list">
                                                <input type="hidden" id="hidden_date_rappel" value="">
                                                <label class="checkbox-inline rp_plateau">
                                                    <input type="checkbox" id="obs_c_rappel_etat1" class="obs_c_rappel_etat_calendar" name="obs_c_rappel_etat[]" value="1" checked="checked"> Rappel perso                                              </label>
                                                <label class="checkbox-inline rp_plateau">
                                                    <input type="checkbox" id="obs_c_rappel_etat2" class="obs_c_rappel_etat_calendar" name="obs_c_rappel_etat[]" value="2"> Rappel plateau                                              </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <!--div class="col-md-3 col-sm-12 bloc-recherche-qualif-agenda-rappel">
                                            <h2 class="event-form-title margin-bottom-20">Filtrer vos rappels par qualification</h2>
                                            <div class="funkyradio  scroller" style="height: 400px;" data-handle-color="#637283" id="filtre-qualif">
                                            </div>


                                        </div-->

                                        <div class="col-md-12 col-sm-12 bloc-agenda-rappel">
                                            <div id="calendar"></div>

                                        </div>
                                    </div>
                                    <div class="row selected-filtre-qualification"></div>

                                </div>
                            </div>
                            <!-- END PORTLET -->
                        </div>
                        <div class="col-md-12">
                            <!-- BEGIN PORTLET -->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="fa fa-phone font-blue-madison"></i> <span
                                                class="caption-subject font-blue-madison bold uppercase">
                                Journal des appels</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 bloc_attente" style="display:none;">
                    <div class="col-md-6 coming-soon-content">
                        <h2 class="attente_ppp">En Attente d'un appel..</h2>

                        <br> 
                        <button class="btn btn-default btn-outlined btn-square back-to-menu agentStatusButton">      </a>
                    </div>
                    <div class="col-md-6 ">
                        <div id="timeREADY"></div>
                    </div>
                    
                </div>
                
                <div class="col-md-12 bloc_incall" id="production_tabs" style="display:none;" >
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                
                                <span>Informations sur le contact</span><br><br>
                                <a class="fa fa-user with-tooltip info-ctc info-ctc-open" data-action="toggle" data-side="top" data-original-title="Cliquer ici pour modifier les informations du contact"></a><span id="info-ctc-name"></span>
                            </div>
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
                                <input type="hidden" name="agent_status" id="agent_status" value="">
                                <input type="hidden" value="{{$etatAgent}}" id="etat_agent">
                                <input type="hidden" value="" id="agentchannel">

                                <button class="btn btn-danger" onclick="hangup()">Hangup</button>
                                <input type="hidden" id="channel" value=''>
                                <input type="hidden" id="lead_id" value=''>
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
                                        <div id="timeINCALL"></div>
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
                                <form id="RegisternewInfoContact" method="post">
                                    @csrf
                                    <div class="form-group" dir="ltr" data-prop="field_button" data-numfield="798"></div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="2">
                                        <span data-class="traduction-2-2">
                                            <style type="text/css">
                                                .col { float: left; width: 20%; min-width: 100px; text-align: center }
                                                    .clear { clear: both; }
                                            </style>
                                            <div class="col left">
                                                Ancien Don<input class="form-control" disabled="" id="" maxlength="3" name="Ancien_Don" type="text">
                                            </div>
                                            <div class="col mid">
                                                Ancien PA<input class="form-control" disabled="" id="" maxlength="3" name="Ancien_PA" type="text">
                                            </div>
                                            <div class="col right">
                                                Ancienne Fréquence<input class="form-control" disabled="" id="" maxlength="3" name="Ancienne_Frequence" type="text">
                                            </div>
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
                                        <cmkdefault><strong><span style="color:#0000FF;">ID TOTAL</span> : 506520884</strong></cmkdefault></h4>

                                        </span>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_description" data-numfield="12">
                                        <span data-class="traduction-2-12">
                                            <style type="text/css">
                                                .col { float: left; width: 33%; min-width: 160px; text-align: center }
                                                    .clear { clear: both; }</style>
                                            <div class="col left">
                                                    <br>
                                                    CIVILITE<input class="form-control new_x" readonly="" id="civilite" name="civilite" type="text" value="MME">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CIVILITE
                                                <select class="form-control" id="new_civilite" name="new_civilite">
                                                    <option value="M"> M</option>
                                                    <option value="MLLE"> MLLE</option>
                                                    <option value="MME"> MME</option>
                                                    <option value="M MME"> M MME</option>
                                                </select>
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
                                                    NOM<input class="form-control" id="contact_nom" readonly="" name="contact_nom" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_NOM<input class="form-control" id="new_contact_nom" name="new_contact_nom" type="text">
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
                                                    PRENOM<input class="form-control" id="contact_prenom" readonly="" name="contact_prenom" type="text" value="">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_PRENOM<input class="form-control" id="new_contact_prenom" name="new_contact_prenom" type="text" value="">
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
                                                    RAISON SOCIALE<input class="form-control" id="raison_sociale" readonly="" name="raison_sociale" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_RAISON SOCIALE<input class="form-control" id="new_raison_sociale" name="new_raison_sociale" type="text">
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
                                                    PROFESSIONNEL<input class="form-control" id="professionnel" readonly="" name="professionnel  " type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_PROFESSIONNEL<input class="form-control" id="new_professionnel" name="new_professionnel " type="text">
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
                                                    ADR2<input class="form-control" id="adr2" readonly="" name="adr2" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_ADR2<input class="form-control" id="new_adr2" name="new_adr2" type="text">
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
                                                    ADR3<input class="form-control" id="adr3" readonly="" name="adr3" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_ADR3<input class="form-control" id="new_adr3" name="new_adr3" type="text">
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
                                                    ADR4 LIBELLE VOIE<input class="form-control" id="adr4_libelle_voie" readonly="" name="adr4_libelle_voie" type="text">
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
                                                    ADR5<input class="form-control" id="adr5" readonly="" name="adr5" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_ADR5<input class="form-control" id="new_adr5" name="new_adr5" type="text">
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
                                                    CONTACT CP<input class="form-control" id="contact_cp" readonly="" name="contact_cp" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT CP<input class="form-control" id="new_contact_cp" name="new_contact_cp" type="text">
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
                                                    CONTACT VILLE<input class="form-control" id="contact_ville" readonly="" name="contact_ville" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT VILLE<input class="form-control" id="new_contact_ville" name="new_contact_ville" type="text">
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
                                                    CONTACT TEL<input class="form-control" id="contact_tel" readonly="" name="contact_tel" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT TEL<input class="form-control" id="new_contact_tel" name="new_contact_tel" type="text">
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
                                                    TEL1<input class="form-control" id="tel1" readonly="" name="tel1" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_TEL1<input class="form-control" id="new_tel1" name="new_tel1" type="text">
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
                                                    CONTACT EMAIL<input class="form-control" id="contact_email" readonly="" name="contact_email" type="text">
                                            </div>

                                            <div class="col mid">
                                                <br>
                                                new_CONTACT EMAIL<input class="form-control" id="new_contact_email" name="new_contact_email" type="text">
                                            </div>

                                            <div class="col right">
                                            </div>

                                            <div class="clear">
                                            </div>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Type Accord</label>
                                                    <select class="form-control" id="type_accord" name="type_accord">
                                                        <option value="" selected>-- choisir le type d'accord --</option>
                                                        <option value="Don avec montant">Don avec montant</option>
                                                        <option value="PA">PA</option>
                                                        <option value="Don en ligne">Don en ligne</option>
                                                        <option value="PA en ligne">PA en ligne</option>
                                                        <option value="Promesse Don en ligne">Promesse Don en ligne</option>
                                                        <option value="Promesse Pa en ligne">Promesse Pa en ligne</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Envoi Courrier </label>
                                                    <select class="form-control" id="envoi_courrier" name="envoi_courrier">
                                                        <option value="" selected>-- choisir le type d'envoi --</option>
                                                        <option value="Avec Courrier">Avec courrier</option>
                                                        <option value="Sans courrier">Sans courrier</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Cas Particulier </label>
                                                    <select class="form-control" id="cas_particulier" name="cas_particulier">
                                                        <option value="" selected>-- choisir le cas particulier --</option>
                                                        <option value="a arrete son pa">a arrete son pa</option>
                                                        <option value="ambassadeur UNADEV">ambassadeur UNADEV</option>
                                                        <option value="ne veut plus recevoir de courriers">ne veut plus recevoir de courriers</option>
                                                        <option value="ne veut plus recevoir appels de cette association">ne veut plus recevoir appels de cette association</option>
                                                        <option value="risque fort de plainte">risque fort de plainte</option>
                                                        <option value="personne mineure">personne mineure</option>
                                                        <option value="Bonne personne mais pas ancien donateur">Bonne personne mais pas ancien donateur</option>
                                                        <option value="deja en pa">deja en pa</option>
                                                        <option value="sous tutelle">sous tutelle</option>
                                                        <option value="Mécontent association">Mécontent association</option>
                                                        <option value="Ressort de l'Etat">Ressort de l'Etat</option>
                                                        <option value="Opposé aux PA">Opposé aux PA</option>
                                                        <option value="Refus conjoint">Refus conjoint</option>
                                                        <option value="Trop sollicité asso/entreprises">Trop sollicité asso/entreprises</option>
                                                        <option value="Donne 1 fois par an ou fin année">Donne 1 fois par an ou fin année</option>
                                                        <option value="Refus suite Coronavirus">Refus suite Coronavirus</option>
                                                        <option value="recu fiscal">recu fiscal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="montant_donDiv" style="display:none">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>MONTANT DON</label>
                                                <input type="number" min="0" name="" id="montant_don" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Déduction</label>
                                                <input type="text" readonly name="" id="deduction" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Final</label>
                                                <input type="text" readonly name="" id="montantfinal" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" dir="ltr" data-prop="field_textarea" data-numfield="33">
                                        <label class="control-label">
                                            <b data-class="traduction-2-33">Commentaire</b>
                                        </label>
                                        <textarea data-elid="33" name="commentaire" id="commentaire" rows="5" cols="6" class="form-control">
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-info" type="submit">VALIDER</button>
                                    </div>
                                </form>
                                
                                <div class="form-group" dir="ltr" data-prop="field_button" data-numfield="188">
                                    <a href="" target="_blank" class="btn blue btn-lg send_msg">Envoyer un Message</a>
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
                                                        <form id="Update_dispo">
                                                            @csrf
                                                            <input type="hidden" name="uniqueid" id="uniqueid">
                                                            <input type="hidden" name="list_id" id="list_id">
                                                            <input type="hidden" name="called_count" id="called_count">
                                                            <input type="hidden" name="lead_id" id="lead_id1">

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>don avec montant</label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="don_avec_montant">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>don en ligne </label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="don_en_ligne">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>hors cible </label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="hors_cible">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>pa </label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="pa">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>pa en ligne</label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="pa_en_ligne">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>refus argumente</label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="refus_argumente">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>refus de repondre</label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="refus_de_repondre">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>faux numéro machine</label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="faux_numero_machine">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Autres Qualificiation</label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="autre">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>CALLBK</label>
                                                                        <select name="dispo_choice" class="form-control dispo_choice" id="callback">
                                                                            <option value="" selected>-- choisir de la list --</option>
                                                                            <option value="CALLBK">CALLBK - RAPPEL </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="col-md-12">
                                                                    <div class="text-canter">
                                                                        <input type="checkbox" name="agent_status" id="agent_status" value="1">  Met en pause apres la qualificiation
                                                                    </div>
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
            </div>
            <!-- Modal En Attente d'un appel -->
            
        </div>
        
    </div>
</div>
<div class="row">
    <div class="col-md-8" style="display:none">
        <iframe src="{{$WebPhonEurl}}"  id="webphone" name="webphone" width="460px" height="500px" allow="microphone *; speakers *;"> </iframe>
    </div>
    <div class="col-md-4">
        <button class="btn btn-success" id="webphone1"> WebPhone</button>
    </div>
    <!-- <div class="col-md-3">
        <p>Session Id : {{Session::get('conf_exten')}}</p>
    </div> -->
</div>
<!-- <div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Channel</th>
                    <th>Hangup</th>
                    <th>Volum</th>
                </tr>
            </thead>
            <tbody id="channelLive">
                
            </tbody>
        </table>
    </div>
</div> -->
 

<main class="login-form" style="display:none">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    @if($etat == 200)
                        <div class="alert alert-success text-center">
                            {{$msg}}
                        </div>
                    @elseif($etat == 401)
                        <div class="alert alert-danger text-center">
                            {{$msg}}
                        </div>
                    @endif
                    USER : {{$user}}
                    PASS : {{$user}}


                    <div>
                        <input type="text" name="agent_status" id="agent_status" value="">
                        <input type="text" value="{{$etatAgent}}" id="etat_agent">
                        <input name="phone_code" type="text" class="form-control" id="phone_code" />
                        <button class="btn btn-success" data-value="PAUSED" id="agentStatusButton">Démarrer la production</button>
                        <div id="temppaused"></div>
                        <!--a href="{{route('change_status',$etatAgent)}}" class="btn @if($etatAgent == 'PAUSED') btn-success @else($etatAgent == 'READY') btn-primary @endif">
                            @if($etatAgent == 'PAUSED') Démarrer la production @else($etatAgent == 'READY') Vous etes ACTIVE @endif
                        </a-->
                        <a href="{{route('logout')}}" class="btn btn-info">Logout</a>

                        <button class="btn btn-danger" onclick="hangup()">Hangup</button>
                        <input type="text" id="channel" value=''>
                        <input type="text" id="lead_id" value=''>

                    </div>


                </div>
            </div>
        </div>
        
        
    </div>
</main>
<script src="{{asset('assets/admin/js/jquery-2.1.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/agents/metro.min.js')}}"></script>
<script src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<!-- <script type="text/javascript">
    //////////// get All chanel For user connected
    $(document).ready(function(){
        
        channel = setInterval(function(){

            $.ajax({
                url: 'get_channel_live',
                type: "get",
                success:function(response)
                {   
                    
                    channelslive = response.channels;
                    if(response.etat == 200){
                        $('#channelLive').empty();
                        channelslive.forEach(element =>
                                {       
                                        var l = element.channel;
                                        firstlettre = l.slice(0, 5);
                                        console.log(firstlettre);
                                        if(firstlettre == "Local"){
                                            var ll = 'recording';
                                        }else{
                                            var ll = 'HANGUP';
                                        }                          
                                        $('#channelLive').append(`
                                            <tr>
                                                <td>1</td>
                                                <td>${element.channel}</td>
                                                <td>${ll}</td>
                                                <td></td>
                                            </tr>
                                        `); 
                                    
                                });
                        //clearInterval(channel);
                    }

                },
            });
        },3000);
    })
</script> -->


<script>
    function myFunctionDate(sel, day, el){
        document.getElementById('date').value = sel;
    }

    ////change status (start production (READY) , stop production (PAUSED))
    $(".agentStatusButton").click(function(){
        //alert($(".agentStatusButton").attr("data-value"));
        status = $(".agentStatusButton").attr("data-value");
        if(status == 'QUEUE' || status == 'INCALL'){
            status = 'READY';
        }
            $.ajax({
                url: 'change_status/'+status,
                type: "get",
                success:function(response)
                {
                    if(response.etat == 200){
                        $(".agentStatusButton").attr("data-value",response.etatAgent);                                
                        //$('#etat_agent').attr("value",response.etatAgent);
                        document.getElementById('etat_agent').value = response.etatAgent;
                        //alert(response.etatAgent);
                        if(response.etatAgent == 'PAUSED'){
                           
                            $(".dashboard_panel").removeClass('darkBackground');
                            $('.bloc_attente').css('display','none');
                            $('.dashboard_agent').css('display','block');
                            $(".agentStatusButton").empty();
                            $(".agentStatusButton").html('Démarrer la production');
                            //$(".agentStatusButton").addClass('btn-success');
                            //$(".agentStatusButton").removeClass('btn-danger');
                            //EditTime();
                        }
                        if(response.etatAgent == 'READY'){
                            $(".dashboard_panel").addClass('darkBackground');
                            $('.dashboard_agent').css('display','none');
                            $('.bloc_attente').css('display','block');
                            $(".agentStatusButton").empty();
                            $(".agentStatusButton").append(`<i
                            class="fa fa-arrow-circle-o-left"></i> Retour au menu Principal `);
                           
                            //$(".agentStatusButton").addClass('btn-success');
                            //$(".agentStatusButton").removeClass('btn-danger');
                            //EditTime();

                        }

                    }
                },
            });
    });

    ///// lancer le viciphone

    $("#webphone1").click(function(){
        //alert($(".agentStatusButton").attr("data-value"));
        
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
                    
                    if(response.etat == 200){
                        toastr.success('webphone is activated');
  
                        clearInterval(incall);
                    }else{
                        toastr.error('webphone Not Activated');
                    }
                },
            });
        },6000);
    })
     ///// get channel and leadId for the live call
    $(document).ready(function(){
        getchannel = setInterval(function(){  
            //getLead = document.getElementById('lead_id').value = lead_id;
            var etat = $("#etat_agent").val();
            if(etat == 'READY'){
                //$(".dashboard_panel").addClass('darkBackground');

                chan = document.getElementById('channel').value;
                //alert(chan);
                if(chan == null || chan == ''){
                        /*if(getLead == null || getLead == ''){}
                        else{
                            //clearInterval(getchannel);
                        }*/
                        $.ajax({
                            url: 'get_channel/',
                            type: "GET",
                            success:function(response)
                            {
                                
                                status = response.etat;
                                msg = response.msg;
                            
                                if(status == 200){
                                    console.log(response);
                                    //var channel = document.getElementById('channel');
                                    
                                    lead_id = response.lead_id;
                                    channel = response.channel;
                                    document.getElementById('channel').value = channel;
                                    //channel.setAttribute('value', channel);
                                    document.getElementById('lead_id').value = lead_id;
                                    $('.send_msg').attr('href', 'send_msg_contact/'+lead_id);
                                }
                            },
                        });
                    }
                }  
            },1000);
    });

    ////change agent stat to incall and get contact information for the live call
    const ChangeToIncallIntervale = setInterval(ChangeToIncall, 1000);

    function ChangeToIncall()
    {
        phone = document.getElementById('tel1').value;
        if(phone == null || phone == ''){}
        else{
        }
        chan = document.getElementById('channel').value;

        if(chan == null || chan == ''){
        }else{    
            $.ajax({
                url: 'change_to_incall/',
                type: "GET",
                success:function(response)
                {
                   // console.log(response);
                    status = response.etat;
                    msg = response.msg;
                    if(status == 200){
                        
                        change = 1;
                        $(".dashboard_panel").removeClass('darkBackground');
                        $('.bloc_incall').css('display','block');
                        $('.bloc_attente').css('display','none');
                        $('.dashboard_agent').css('display','none');                   
                        document.getElementById('agentchannel').value = response.agentchannel;
                        document.getElementById('civilite').value = response.adr1_civilite_abrv;
                        document.getElementById('contact_nom').value = response.contact_nom;
                        //alert(document.getElementsByClassName('contact_nom').value);
                        document.getElementById('contact_prenom').value = response.contact_prenom;
                        document.getElementById('raison_sociale').value = response.raison_sociale;
                        document.getElementById('professionnel').value = response.professionnel;
                        document.getElementById('adr2').value = response.adr2;
                        document.getElementById('adr3').value = response.adr3;
                        document.getElementById('adr4_libelle_voie').value = response.adr4_libelle_voie;
                        document.getElementById('adr5').value = response.adr5;
                        document.getElementById('contact_ville').value = response.contact_ville;
                        document.getElementById('contact_cp').value = response.contact_cp;
                        document.getElementById('contact_tel').value = response.contact_tel;
                        document.getElementById('tel1').value = response.tel1;
                        document.getElementById('contact_email').value = response.contact_email;
                        document.getElementById('commentaire').value = response.commentaire;
                        document.getElementById('uniqueid').value = response.uniqueid;
                        document.getElementById('list_id').value = response.list_id;
                        document.getElementById('lead_id').value = response.lead_id;
                        document.getElementById('lead_id1').value = response.lead_id;
                        document.getElementById('called_count').value = response.called_count;
                        /////////
                        //document.getElementById('phone_code1').value = '33';
                        document.getElementById('phone_code').value = '33';
                        $("#info-ctc-name").html(`<span><i class="text-success fa fa-phone"></i>${response.tel1}</span> / <span><i class="text-success fa fa-fax"></i>${response.contact_tel}</span> / <span><i class="text-success fa fa-map"></i>${response.adr4_libelle_voie}</span> / ${response.contact_cp} / ${response.contact_ville} / ${response.adr1_civilite_abrv} / ${response.contact_prenom} / ${response.contact_nom}`);
                        
                        //ChangeToIncallIntervale = clearInterval(ChangeToIncallIntervale);
                    }
                },
            });
        
        }
    }
    ///// get Status and start chrono if status == INCALL
    $(document).ready(function(){
        const getStatus = setInterval(function(){ 
            $.ajax({
                url: 'refresh_incall/',
                type: "GET",
                success:function(response)
                {},
            }); 
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
    function hangup() {
        $("#myModal2").modal("hide");
        $("#divCalendar").css('display','none');
       
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
                        $('#don_avec_montant').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#don_en_ligne').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#faux_numero_machine').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#hors_cible').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#pa').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#pa_en_ligne').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#refus_argumente').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#refus_de_repondre').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        $('#autre').append(`
                            <option value=""> -- Choisir de la liste --</option>
                        `);
                        statuses.forEach(element =>
                                {   
                                    listStatus = element.status;
                                    abrv = listStatus.slice(0, 2);
                                    abrv3 = listStatus.slice(0, 3);
                                    
                                    listStatuslength = listStatus.length;
                                    if(abrv == "DM" && listStatuslength >2){
                                        $('#don_avec_montant').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }else if(abrv == "DL" && listStatuslength >2){
                                        $('#don_en_ligne').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }else if(abrv3 == "FNM" && listStatuslength >3){
                                        $('#faux_numero_machine').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }
                                    else if(abrv == "HC" && listStatuslength >2){
                                        $('#hors_cible').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }else if(abrv == "PA" && listStatuslength >2){
                                        $('#pa').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }else if(abrv == "PL" && listStatuslength >2){
                                        $('#pa_en_ligne').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }else if(abrv == "RA" && listStatuslength >2){
                                        $('#refus_argumente').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }else if(abrv == "RR" && listStatuslength >2){
                                        $('#refus_de_repondre').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `); 
                                    }else if(listStatus == "DOUBL" || listStatus == "IND" || listStatus == "INDOLD" || listStatus == "RP" || listStatus == "REL" || listStatus == "REP"){
                                        $('#autre').append(`
                                            <option value="${element.status}"> ${element.status_name}</option>
                                        `);
                                    }
                                    
                                });  
                               
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

    $('.dispo_choice').change(function() {
        
        if (this.value == 'CALLBK') {
            $("#divCalendar").css("display","block");
        }else{
            $("#divCalendar").css("display","none");
        }
    });
    $('#envoi_courrier').change(function() {
        //alert(this.value)
        if(this.value != null || this.value != ''){
            $('#montant_donDiv').css('display','block');
        }else{
            $('#montant_donDiv').css('display','none');
        }
    });
    
    ///// change qualif for contact and save it
    $('#Update_dispo').on('submit',function(e){
        e.preventDefault();
        let uniqueid = $('#uniqueid').val();
        let list_id = $('#list_id').val();
        let called_count = $('#called_count').val();
        let lead_id1 = $('#lead_id1').val();
        let agent_status = $('#agent_status:checked').val();
        let callback = $('#callback').val();
        let don_avec_montant = $("#don_avec_montant").val();
        let don_en_ligne = $("#don_en_ligne").val();
        let faux_numero_machine = $("#faux_numero_machine").val();
        let hors_cible = $("#hors_cible").val();
        let pa = $("#pa").val();
        let pa_en_ligne = $("#pa_en_ligne").val();
        let refus_argumente = $("#refus_argumente").val();
        let refus_de_repondre = $("#refus_de_repondre").val();
        let autre = $("#autre").val();
        let montant_don = $('#montant_don').val();
        let hour = $('#hour').val();
        let date = $('#date').val();
        let comments = $('#comments').val();
        
        

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
                    //dispo_choice:dispo_choice,
                    don_avec_montant:don_avec_montant,
                    callback:callback,
                    don_en_ligne:don_en_ligne,
                    faux_numero_machine:faux_numero_machine,
                    hors_cible:hors_cible,
                    pa:pa,
                    pa_en_ligne:pa_en_ligne,
                    refus_argumente:refus_argumente,
                    refus_de_repondre:refus_de_repondre,
                    autre:autre,
                    CallBackrecipient:CallBackrecipient,
                    hour:hour,
                    date:date,
                    comments:comments,
                    montant_don:montant_don,
                },
            success:function(response)
            {   
                $("#myModal2").modal("hide");
                //console.log(response);
                status = response.etat;
                msg = response.msg;

                if(status == 200){
                    document.getElementById('channel').value = '';
                    document.getElementById('lead_id').value = '';
                    //document.getElementById('adr1_civilite_abrv').value = '';
                    document.getElementById('uniqueid').value = '';
                    document.getElementById('lead_id1').value = '';
                    document.getElementById('list_id').value = '';
                    document.getElementById('called_count').value = '';
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

                    document.getElementById('new_contact_nom').value = '';
                    document.getElementById('new_contact_prenom').value = '';
                    document.getElementById('new_raison_sociale').value = '';
                    document.getElementById('new_professionnel').value = '';
                    document.getElementById('new_adr2').value = '';
                    document.getElementById('new_adr3').value = '';
                    document.getElementById('new_adr4_libelle_voie').value = '';
                    document.getElementById('new_adr5').value = '';
                    document.getElementById('new_contact_ville').value = '';
                    document.getElementById('new_contact_cp').value = '';
                    document.getElementById('new_contact_tel').value = '';
                    document.getElementById('new_tel1').value = '';
                    document.getElementById('new_contact_email').value = '';
                    document.getElementById('montant_don').value = '';
                    document.getElementById('deduction').value = '';
                    document.getElementById('montantfinal').value = '';
                    document.getElementById('comments').value = '';



                   /////////
                    document.getElementById('phone_code').value = '';          
                    $(".agentStatusButton").attr("data-value",response.etatAgent);                                
                    $(".agentStatusButton").html(response.etatAgent);
                    document.getElementById('etat_agent').value = response.etatAgent;
                    $('.bloc_incall').css('display','none');
                    $('.time1').css('display','none');
                    
                    if(response.etatAgent == 'PAUSED'){
                        $(".dashboard_panel").removeClass('darkBackground');
                        $('.bloc_attente').css('display','none');
                        $('.dashboard_agent').css('display','block');
                        $(".agentStatusButton").empty();
                        $(".agentStatusButton").html('Démarrer la production');

                    }
                    if(response.etatAgent == 'READY'){
                       // setInterval(ChangeToIncall, 1000);
                        $(".dashboard_panel").addClass('darkBackground');
                        $('.dashboard_agent').css('display','none');
                        $('.bloc_attente').css('display','block');
                        $(".agentStatusButton").empty();
                        $(".agentStatusButton").append(`<i
                        class="fa fa-arrow-circle-o-left"></i> Retour au menu Principal `);

                    }
                    
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
    ///calculer frai de transport
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

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'timeGrid' ],
                defaultView: 'timeGridWeek',
                selectable: true,
                customButtons: {
                    periode: {
                        text: 'TEMPO',
                        click: function() {
                            //
                        }
                    },
                },
                header: {
                    left: 'prev,next hours cp recup',
                    center: 'title',
                },
                droppable: true,
                eventLimit: true,
                locale: 'fr',
                weekNumbers: true,
                firstDay: 1,
                events : [
                    @foreach($callbacks as $callback)
                        {
                        
                            title : '{{$callback->contact_nom . ' ' . $callback->contact_prenom}}',
                            start : '{{ \Carbon\Carbon::parse($callback->callback_time)->format('Y-m-d') . 'T'.\Carbon\Carbon::parse($callback->callback_time)->format('h:m') }}',
                            url : '{{route('get_lead_info', $callback->lead_id)}}',
                            //id : 'getLeadInfo',
                            //lead_id : '{{$callback->lead_id}}',
                            color: '#BADA55',
                        },
                    @endforeach
                ],
               
                
                dateClick: function(info) {
                    var string = info.dateStr;
                    $('.date').val(string.substring(0,16));
                    $('.date_end').val(string.substring(0,16));
                    $('#basicExampleModal').modal();
                },
                drop: function(info) {
                    var employee_id = $('#employee_id').val();
                    var date = info.dateStr;
                    var event = info.draggedEl.textContent;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        method: 'POST',
                        url: '',
                        data: {
                            employee_id: employee_id,
                            date: date,
                            event: event
                        },
                        dataType: '',
                    })
                        .done(function(data) {
                            location.reload();
                        })
                        .fail(function(data) {
                            console.log(data);
                        });
                }
        });
        
        $("#getLeadInfo").click(function(){
            var getLeadInfo = calendar.getEventById('getLeadInfo'); // an event object!
            var lead_id = getLeadInfo.lead_id;
           // alert(lead_id);
        
        });
        calendar.render();
        $('.fc-today-button').text("Aujourd'hui");
        //Configuration de locale momentjs
        moment.locale('fr', {
            months : 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
            monthsShort : 'janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'.split('_'),
            monthsParseExact : true,
            weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
            weekdaysShort : 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
            weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
            weekdaysParseExact : true,
            longDateFormat : {
                LT : 'HH:mm',
                LTS : 'HH:mm:ss',
                L : 'DD/MM/YYYY',
                LL : 'D MMMM YYYY',
                LLL : 'D MMMM YYYY HH:mm',
                LLLL : 'dddd D MMMM YYYY HH:mm'
            },
            calendar : {
                sameDay : '[Aujourd’hui à] LT',
                nextDay : '[Demain à] LT',
                nextWeek : 'dddd [à] LT',
                lastDay : '[Hier à] LT',
                lastWeek : 'dddd [dernier à] LT',
                sameElse : 'L'
            },
            relativeTime : {
                future : 'dans %s',
                past : 'il y a %s',
                s : 'quelques secondes',
                m : 'une minute',
                mm : '%d minutes',
                h : 'une heure',
                hh : '%d heures',
                d : 'un jour',
                dd : '%d jours',
                M : 'un mois',
                MM : '%d mois',
                y : 'un an',
                yy : '%d ans'
            },
            dayOfMonthOrdinalParse : /\d{1,2}(er|e)/,
            ordinal : function (number) {
                return number + (number === 1 ? 'er' : 'e');
            },
            meridiemParse : /PD|MD/,
            isPM : function (input) {
                return input.charAt(0) === 'M';
            },
            // In case the meridiem units are not separated around 12, then implement
            // this function (look at locale/id.js for an example).
            // meridiemHour : function (hour, meridiem) {
            //     return /* 0-23 hour, given meridiem token and hour 1-12 */ ;
            // },
            meridiem : function (hours, minutes, isLower) {
                return hours < 12 ? 'PD' : 'MD';
            },
            week : {
                dow : 1, // Monday is the first day of the week.
                doy : 4  // Used to determine first week of the year.
            }
        });
        moment.locale("fr");
        var html = "<div><select id=\"select\">";
        for (let i = 0; i <= 3; i++) {
            var debut = moment().add(i, "w").startOf('isoWeek').format('D|MM|YYYY') + "-" + moment().add(i, "w").endOf('isoWeek').format('D|MM|YYYY');
            html = html.concat("<option value=\""+debut+"\">"+debut+"</option>")
        }
        html = html.concat('</div>');
        var datetime = moment().add(0, "w").startOf('isoWeek').format('YYYY-MM-D');
        $('.date').val(datetime + 'T08:00');
        $('.date_end').val(datetime + 'T12:30');
        $('.fc-periode-button').html(html);
        $('#submit').click(function() {
            var form = $('#addEmployee');
            $.ajax({
                method: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                dataType: "json"
            })
            .done(function(data) {
                location.reload();
            })
            .fail(function(data) {
                console.log(data);
            });
        });
        
    });
</script>
@endsection
