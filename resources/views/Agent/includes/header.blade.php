
<div class="page-header navbar navbar-fixed-top" style="z-index: 90;">
            <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">

            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->
        <div class="page-actions">
            <div class="btn-group">
                <button type="button" class="btn red-haze btn-sm dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" data-close-others="true">
                    <span class="hidden-sm hidden-xs">Actions&nbsp;</span>
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li class="send_mail">


                        <a href="javascript:;">
                            <i class="icon-paper-plane"></i> Envoyer un email </a>
                    </li>
                    <li class="send_fax hidden">
                        <a href="javascript:;">
                            <i class="icon-printer"></i> Envoyer un fax </a>
                    </li>
                    <li class="send_sms hidden">
                        <a href="javascript:;">
                            <i class="icon-envelope"></i> Envoyer un sms </a>
                    </li>
                    <li class="divider sep_multi_canal"> </li>
                    <li>
                        <a href="javascript:;" class="get_assitance log_action"  data-log-action="header_send_notif" >
                            <i class="icon-graduation"></i> Notifier le superviseur
                        </a>
                    </li>

                    <li id="external-list-button" class="dropdown-submenu">
                        <a href="javascript:;">
                            <i class="fa fa-list-ol"></i> Listes externes                                </a>
                        <ul class="dropdown-menu external-list-button" id="external-lists-menu" role="menu" >
                        </ul>
                    </li>



                    <li id="print_pdf"  class="dropdown-submenu">
                        <a  href="javascript:;">
                            <i class="fa fa-file-pdf-o font-red"></i> Générer pdf                                </a>
                        <ul class="dropdown-menu print_pdf" role="menu" >

                        </ul>

                    </li>

                    
                    
                   
                </ul>
            </div>
        </div>

        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->


            <!--
            <form class="search-form" action="page_general_search_2.html" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" placeholder="Search..." name="query">
                    <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </a>
                    </span>
                </div>
            </form>
            -->
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide"> </li>
                    <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_queue_count" style="display:none">
                        <a href="javascript:;" class="dropdown-toggle header_queue_count_li" data-toggle="dropdown" data-close-others="true">

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <ul class="dropdown-menu-list scroller header_queue_count_ul" style="height: 250px;" data-handle-color="#637283">
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="separator hide"></li>
                    <li class="dropdown notification-phone-ringing hidden">
                        <a href="#" class="dropdown-toggle" data-original-title="" data-close-others="false">
                            <span class="badge bg-purple">
                                <i class="fa fa-bell font-red"></i> Appel entrant. Cliquer pour afficher.
                            </span>
                        </a>
                                <!-- span class="fa fa-circle fa-2x font-default" style="margin: 30px 0 0 0;"></span -->
                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification " id="">
                        <a href="javascript:;" class=" etat_comm_agent" data-toggle="dropdown" data-close-others="false" style="padding-top: 27px;"><i class="fa fa-bell"></i><span class="text-danger" style="font-size: 14px;padding-bottom: -20px;" id="callback_notification">0</span>
                        </a>
                        
                        <ul class="dropdown-menu">
                            
                            <li>
                              <ul class="dropdown-menu-list scroller" id="callback_info" style="height: 275px;" data-handle-color="#637283">

                              </ul>  
                            </li>
                            
                        </ul>
                        
                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification meetme-dropdown-list hidden">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                            <i class="fa fa-users font-blue"></i>
                        </a>
                        <ul class="dropdown-menu">
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-1">
                                        Conférence N°1                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-2">
                                        Conférence N°2                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-3">
                                        Conférence N°3                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-4">
                                        Conférence N°4                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-5">
                                        Conférence N°5                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-6">
                                        Conférence N°6                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-7">
                                        Conférence N°7                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-8">
                                        Conférence N°8                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-9">
                                        Conférence N°9                                            </a>
                                </li>
                                                                    <li>
                                    <a href="#" class="merge_into_meetme_button" data-meetme-id="capitalcorp-222-10">
                                        Conférence N°10                                            </a>
                                </li>
                            
                        </ul>
                    </li>
                    
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark hidden">
                        <a href="javascript:;" class="dropdown-toggle etat_comm_agent" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" >
                        </a>
                    </li>

                    
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle in_call hidden log_action" data-log-action="call_man_silence"  title="Muet" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"  onclick='sipToggleMute();'>
                                <i id="class_mute" class="fa fa-microphone-slash font-green"> </i>
                            </a> 
                    </li>


                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">


                        <a href="javascript:;" class="dropdown-toggle red hangup_call hidden log_action" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"  id="hangup_call">
                            <i class="icon-call-end font-red"> </i>
                        </a>

                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">
                        <a  class="dropdown-toggle GetTransfert" data-target="#transfer_list" data-toggle="modal">
                            <span class="sr-only">Transférer</span><i class="icon-action-redo font-purple"></i>
                        </a>
                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">
                        <a class="dropdown-toggle info-ctc in_prospect_btn info-ctc-open" data-action="toggle" data-side="top" style="display:none">
                            <span class="sr-only">Contact info</span> <i class="fa fa-user font-green-soft"></i>
                        </a>
                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">
                        <a class="dropdown-toggle "   style="display:none">
                            <div class="alert_new_eval">
                                <span class="badge badge-primary alert_new_eval_nb">  </span>
                            </div>
                        </a>
                    </li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->


                    <!--
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge badge-success"> 7 </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>
                                    <span class="bold">12 pending</span> notifications</h3>
                                <a href="page_user_profile_1.html">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">just now</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-success">
                                                    <i class="fa fa-plus"></i>
                                                </span> New user registered. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">3 mins</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-bolt"></i>
                                                </span> Server #12 overloaded. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">10 mins</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-warning">
                                                    <i class="fa fa-bell-o"></i>
                                                </span> Server #2 not responding. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">14 hrs</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-info">
                                                    <i class="fa fa-bullhorn"></i>
                                                </span> Application error. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">2 days</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-bolt"></i>
                                                </span> Database overloaded 68%. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">3 days</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-bolt"></i>
                                                </span> A user IP blocked. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">4 days</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-warning">
                                                    <i class="fa fa-bell-o"></i>
                                                </span> Storage Server #4 not responding dfdfdfd. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">5 days</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-info">
                                                    <i class="fa fa-bullhorn"></i>
                                                </span> System Error. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">9 days</span>
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-bolt"></i>
                                                </span> Storage server failed. </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    -->
                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide"> </li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->



                    <!--
                    <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-envelope-open"></i>
                            <span class="badge badge-danger"> 4 </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>You have
                                    <span class="bold">7 New</span> Messages</h3>
                                <a href="app_inbox.html">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    <li>
                                        <a href="#">
                                            <span class="photo">
                                                <img src="vvci/assets/metronic/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                <span class="from"> Lisa Wong </span>
                                                <span class="time">Just Now </span>
                                            </span>
                                            <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="photo">
                                                <img src="vvci/assets/metronic/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                <span class="from"> Richard Doe </span>
                                                <span class="time">16 mins </span>
                                            </span>
                                            <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="photo">
                                                <img src="vvci/assets/metronic/assets/layouts/layout3/img/avatar1.jpg" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                <span class="from"> Bob Nilson </span>
                                                <span class="time">2 hrs </span>
                                            </span>
                                            <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="photo">
                                                <img src="vvci/assets/metronic/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                <span class="from"> Lisa Wong </span>
                                                <span class="time">40 mins </span>
                                            </span>
                                            <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="photo">
                                                <img src="vvci/assets/metronic/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                <span class="from"> Richard Doe </span>
                                                <span class="time">46 mins </span>
                                            </span>
                                            <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    -->
                    <!-- END INBOX DROPDOWN -->
                    <li class="separator hide"> </li>
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->


                    <!--
                    <li class="dropdown dropdown-extended dropdown-tasks dropdown-dark" id="header_task_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-calendar"></i>
                            <span class="badge badge-primary"> 3 </span>
                        </a>
                        <ul class="dropdown-menu extended tasks">
                            <li class="external">
                                <h3>You have
                                    <span class="bold">12 pending</span> tasks</h3>
                                <a href="?p=page_todo_2">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                            <span class="task">
                                                <span class="desc">New release v1.2 </span>
                                                <span class="percent">30%</span>
                                            </span>
                                            <span class="progress">
                                                <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">40% Complete</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="task">
                                                <span class="desc">Application deployment</span>
                                                <span class="percent">65%</span>
                                            </span>
                                            <span class="progress">
                                                <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">65% Complete</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="task">
                                                <span class="desc">Mobile app release</span>
                                                <span class="percent">98%</span>
                                            </span>
                                            <span class="progress">
                                                <span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">98% Complete</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="task">
                                                <span class="desc">Database migration</span>
                                                <span class="percent">10%</span>
                                            </span>
                                            <span class="progress">
                                                <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">10% Complete</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="task">
                                                <span class="desc">Web server upgrade</span>
                                                <span class="percent">58%</span>
                                            </span>
                                            <span class="progress">
                                                <span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">58% Complete</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="task">
                                                <span class="desc">Mobile development</span>
                                                <span class="percent">85%</span>
                                            </span>
                                            <span class="progress">
                                                <span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">85% Complete</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="task">
                                                <span class="desc">New UI release</span>
                                                <span class="percent">38%</span>
                                            </span>
                                            <span class="progress progress-striped">
                                                <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">38% Complete</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    -->
                    <!-- END TODO DROPDOWN -->
                    
                    
                     
                    
                    
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-original-title="">
                                <i class="iconcmk-phone-registering status-web-phone font-yellow"></i>
                            </a>
                            <!-- span class="fa fa-circle fa-2x font-default" style="margin: 30px 0 0 0;"></span -->
                        </li>
                        <li class="dropdown dropdown-extended dropdown-inbox" id="header_postits">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-notebook" ></i>Notes                                </a>
                        <ul class="dropdown-menu">
                            <li class="external" style="cursor:pointer">
                                <h3><span class="bold" id="addnote"><i class="fa fa-plus font-blue"></i> Ajouter une note</span></h3>
                                <!-- a id="list_tasks">view all</a-->
                            </li>
                            <li>
                                <div class="form-group" id="newnote" data-action="add" style="padding:5px;display:none">
                                    <label class="font-blue" style="width:100%;text-align:center"><strong>Nouvelle note</strong></label>
                                    <textarea class="form-control" style="width:100%" rows="3" id="notetxt"></textarea>
                                    <input type="hidden" id="noteid">
                                    <span style="cursor:pointer;float:left"><i id="savenote" class="fa fa-save" style="color:#BDBDBD"></i></span><span style="cursor:pointer;float:right"> <i id="closenote" class="fa fa-times" style="color:red"></i></span>
                                </div>
                            </li>
                            <li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283" id="oldnotes">
                                </ul>
                            </li>
                            </li>
                        </ul>
                    </li>

                    <li class="separator hide">
                    </li>

                    <li class="dropdown dropdown-user dropdown-dark">
                        
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <span class="username username-hide-on-mobile">{{Session::get('full_name')}}@capitalcorp:{{Session::get('phone_login')}}</span>
                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                            <img alt="" class="img-circle header-avatar" src="{{asset('assets/agents/vvci/assets/sharedfiles/pic_user/default_user.jpg')}}" /> </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <!--
                            <li>
                                <a href="page_user_profile_1.html">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="app_calendar.html">
                                    <i class="icon-calendar"></i> My Calendar </a>
                            </li>
                            <li>
                                <a href="app_inbox.html">
                                    <i class="icon-envelope-open"></i> My Inbox
                                    <span class="badge badge-danger"> 3 </span>
                                </a>
                            </li>
                            <li>
                                <a href="app_todo_2.html">
                                    <i class="icon-rocket"></i> My Tasks
                                    <span class="badge badge-success"> 7 </span>
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="page_user_lock_1.html">
                                    <i class="icon-lock"></i> Lock Screen </a>
                            </li>

                            -->

                            <li class="user_logout">

                                <a data-toggle="modal" href="#basic_password">  <i class="fa fa-lock fa-fw"></i> Mot de passe</a>

                            </li>
                            <li class="user_logout">
                                <a class="logout_process" href="{{route('logout')}}" id="cmk_log_out_link">
                                    <i class="icon-logout"></i> Exit </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->


                    <li class="dropdown dropdown-extended quick-sidebar-toggler log_action" data-log-action="open_livechat">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <i class="icon-bubbles"></i>
                    </li>


                    <!-- END QUICK SIDEBAR TOGGLER -->
                    
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>