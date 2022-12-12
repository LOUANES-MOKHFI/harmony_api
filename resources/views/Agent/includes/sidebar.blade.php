<div class="page-sidebar-wrapper">
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <ul class="page-sidebar-menu page-sidebar-menu-closed"
                    data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li class="start active open cdashboard hidden"><a href="javascript:void(0)"
                                                                       onclick="Fncdashboard();" class="cdashboard"> <i
                                    class="icon-home"></i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>

                    <li id="li_search_contact" class=""><a data-target="#modal-gestioncontacts"
                                                           data-toggle="modal"> <i class="icon-magnifier"></i> <span
                                    class="title">Rechercher Contact</span>
                        </a>
                    </li>
                    <li class=""><a data-target="#modal-rappel-calendar"
                                    data-toggle="modal"> <i class="icon-clock"></i> <span class="title">
                                Prochains Rappels</span>
                        </a>
                    </li>
                    <!--li class=""><a data-target="#modal-dispatch"
                                    data-toggle="modal"> <i class="icon-directions"></i> <span class="title">
                                Dispatching</span>
                        </a></li>
                    <li class=""><a data-target="#modal-jobs"
                                    data-toggle="modal"> <i class="icon-layers"></i> <span class="title">
                                Jobs</span>
                        </a>
                    </li-->
                    <li id="li_stats" class=""><a data-target="#modal-statsagent" data-toggle="modal">
                            <i class="icon-bar-chart"></i>
                            <span class="alert_new_evaluation"></span>
                            <span class="title">Mes Statistiques</span>
                        </a>
                    </li>
                    <li id="li_fiche_vierge" class="hidden"><a data-target="#modal-contactvierge"
                                                                                data-toggle="modal"> <i
                                    class="fa fa-file-text-o"></i> <span
                                    class="title">Créer un contact vierge</span>
                        </a>
                    </li>
                    <li id="li_appel_manuel" class=""><a data-target="#modal-appel-manuel" data-from-menu="1" data-toggle="modal">
                            <i class="icon-call-out"></i> <span class="title">Appel Manuel</span>
                        </a>
                    </li>
                    <!--li id="li_sms_manuel" class=""><a data-target="#modal-sms-manuel" data-toggle="modal">
                            <i class="icon-bubble"></i> <span class="title">Envoyer un SMS</span>
                        </a>
                    </li>
                    <li class="" id="li_livechat_menu"><a data-target="#modal-live-chat"
                                                          data-toggle="modal"> <i class="icon-bubbles"></i> <span class="title">
                                Live Chat </span>
                        </a>
                    </li>

                    <li id="li_facebook"><a data-target="#facebook_modal"
                                            data-toggle="modal"> <i class="fa fa-facebook"></i><span
                                    class="face_alert_new_agent"></span> <span class="title">
                                Facebook</span>
                        </a>
                    </li-->
                    <li id="li_twitter" class="hidden"><a data-target="#twitter_modal"
                                                                      data-toggle="modal"> <i class="fa fa-twitter"></i> <span
                                    class="title">
                                Twitter</span>
                        </a></li>
                    <li id="piece_jointe" class="hidden"><a data-target="#piece_jointe_modal"
                                                            data-toggle="modal"> <i class="fa fa-link"></i> <span class="title">
                                Pièces Jointe</span>
                        </a>
                    </li>


                    <li id="lost_call" class="hidden"><a data-target="#ModalLostCall"
                                                                           data-toggle="modal"> <i class="icon-call-in"></i>
                            <span class="title">
                                Appel en absence</span>
                        </a>
                    </li>


                    <li id="externe_calendar" class="hidden"><a href="javascript:void(0)"
                                                                                     onClick="openAgenda();"> <i
                                    class="icon-calendar"></i> <span class="title">
                                Agenda partagé</span>
                        </a>
                    </li>
                    
                    <li class="in_call">
                    <a href="javascript:;"class="dropdown-toggle in_call hidden" data-toggle="modal" data-target="#myModalDtmf"  title=" DTMF" >
                                            <i class="icon-grid"></i><span class="title">
                                            DTMF</span>
                                        </a>
                    </li>

                    <li >
                    <a href="#" class="show_in_menu" data-target="#modal-echo-test" data-toggle="modal" title="Tester la qualité de communication" >
                                            <i class="fa fa-volume-up"></i><span class="title">
                                            Tester la qualité de communication</span>
                                        </a>
                    </li>
                    <li >
                        <a href="#" data-target="#modal-meetme" data-toggle="modal" title="Conférences" >
                            <i class="fa fa-users"></i><span class="title">
                                            Conférences</span>
                        </a>
                    </li>

                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
        </div>
         <!-- BEGIN QUICK SIDEBAR -->
         <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-bubbles"></i>
            </a>
            
            <!-- END QUICK SIDEBAR -->