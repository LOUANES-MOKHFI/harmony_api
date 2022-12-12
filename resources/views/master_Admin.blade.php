<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HARMONIE - @yield('title')</title>
        <link rel="stylesheet" href="{{asset('assets/agents/fullcalendar/lib/main.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/agents/fullcalendar/lib/main.min.css')}}">
        <script src="{{asset('assets/agents/fullcalendar/lib/main.min.js')}}"></script>
        <style id="page-content-style">
            .page-content {
                opacity : 0;
            }
            .page-content-fb {
                opacity : 0;
            }
        </style>
        <script type="text/javascript">
            //Prevent Escape key from stopping page loading
            function handleEscape(e) {
                if (e && e.keyCode && e.keyCode == 27) e.preventDefault();
            }
            document.addEventListener("keydown",handleEscape);

            window.addEventListener("load",function() {
                document.removeEventListener("keydown",handleEscape);
            });

        </script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="{{asset('assets/agents/vvci/assets/cmk/css/google/google.fonts.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{asset('assets/agents/vvci/assets/cmk/vendors/multiple-select-master/multiple-select.css')}}"/>
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/bootstrap-editable/bootstrap3-editable/css/bootstrap-editable.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/animate.css/animate.css')}}" rel="stylesheet" type="text/css" />
        <!--<link href="{{asset('assets/agents/vvci/assets/metronic/assets/pages/css/todo.css')}}" rel="stylesheet" type="text/css" />-->
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/offline/offline-theme-chrome.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/offline/offline-language-french.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/scojs/sco.message.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/../cmk/css/cmk/maps.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/jquery.qtip.min.css')}}">
        
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/css/typeahead.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/flat-visual-chat/assets/css/filter.formatter.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/flat-visual-chat/assets/css/colpick.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/flat-visual-chat/assets/css/admin.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/jplayer-minimal/css/themicons.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/jplayer-minimal/css/style.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/scojs/sco.message.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/cmk/vendors/icomoon/style.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jstree/dist/themes/default/style.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/apps/css/todo-2.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/agents/vvci/assets/metronic/assets/apps/css/todo.min.css')}}">
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/css/components.css')}}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/layouts/layout4/css/layout.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/layouts/layout4/css/themes/light.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
      
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/jquery-countdown/jquery.countdown.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/pages/css/coming-soon.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/agents/vvci/assets/metronic/assets/apps/css/inbox.css')}}" rel="stylesheet" type="text/css" />

        <!-- END THEME LAYOUT STYLES -->
        
        
        <link href="{{asset('assets/agents/vvci/assets/cmk/css/cmk.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/chat/css/screen.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/chat/css/chat.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/agents/vvci/assets/cmk/vendors/intl-tel-input/css/intlTelInput.css')}}" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="{{asset('logo.png')}}">
        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <link media="all" type="text/css" rel="stylesheet" href="https://bootsnipp.com/css/fullscreen.css">

        <style>
           .darkBackground{
                background:radial-gradient(black, transparent)
           }
        </style>
        @yield('css')

    </head>
    
    <body class="page-container-bg-solid page-header-fixed page-footer-fixed page-sidebar-closed-hide-logo page-sidebar-closed page-md ">
        @include('Agent.includes.header')
        
        <div class="clearfix"> </div>
        <div class="page-container">
       
        @yield('content')
        </div>

        
        
        @include('Agent.includes.footer')

       
    </body>


    <script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/jquery-cookie/jquery.cookie.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('assets/agents/vvci/assets/cmk/vendors/multiple-select-master/jquery.multiple.select.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/agents/vvci/assets/cmk/vendors/jquery-highcharts/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/agents/vvci/assets/cmk/vendors/offline/offline.min.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/agents/vvci/assets/cmk/vendors/scojs/sco.message.js')}}"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/lz-strings.js')}}" type="text/javascript"></script>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/moment/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/moment/locale/fr.js')}}" type="text/javascript"></script>
<!-- script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}" type="text/javascript"></script -->
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js')}}"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/bootstrap-editable/bootstrap3-editable/js/bootstrap-editable.js')}}"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js')}}"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js')}}"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-typeahead/bootstrap3-typeahead.min.js')}}" type="text/javascript"></script>




<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/jillix-jQuery-sidebar/src/jquery.sidebar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>


<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->


<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/knockoutjs/knockout-3.4.0.js')}}"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/jquery.password-validation.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/jquery-password-generator-plugin.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/jquery.pulsate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/intl-tel-input/js/i18n/fr.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/vendors/intl-tel-input/js/intlTelInput.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/cmk/js/common/fn.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('assets/agents/vvci/assets/cmk/vendors/offline/offline.min.js')}}"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    var time_zone = "Europe/Paris";
</script>



<script>
    $.fn.select2.defaults.set("width", null);
    jQuery(document).ready(function() {
      

        $('#modal_help .modal-body').slimScroll({
            height: '380px'
        });
        $(".page_help").click(function() {
            var type = $(this).data('helptype');
            var id = $(this).data('helpid');
            $.ajax({
                type : "POST",
                url : base_url_ajax+"help/restclient/fetch/"+type+"/"+id,
                success : function(response) {
                    $("#modal_help .modal-body").html(response);
                    $("#modal_help").modal("show");
                }
            });
        });



        $('.modal-log-action').on('hidden.bs.modal', function(e) {
            var dataAgent=$(this).data();
            var dataAgent = $.extend( true, {}, $(this).data() );
            delete dataAgent['bs.modal'];
            dataAgent.logDebut_fin=1; //fin
            agentLogAction(dataAgent);
        });

        $('.modal-log-action').on('shown.bs.modal', function(e) {
            //var dataAgent=$(this).data();
            var dataAgent = $.extend( true, {}, $(this).data() );
            delete dataAgent['bs.modal'];
            dataAgent.logDebut_fin=0; //Debut
            agentLogAction(dataAgent);
        });


        /*//$('.sidebar-log-action').on('hidden.bs.collapse', function(e) {
        $(document).on("hidden.bs.collapse", ".sidebar-log-action", function() {
            var dataAgent=$(this).data();
            var dataAgent = $.extend( true, {}, $(this).data() );
            delete dataAgent['bs.modal'];
            dataAgent.logDebut_fin=1; //fin
            agentLogAction(dataAgent);
        });
        //$('.sidebar-log-action').on('shown.bs.collapse', function(e) {
        $(document).on("shown.bs.collapse", ".sidebar-log-action", function() {
            alert("rrrrggg");
            var dataAgent = $.extend( true, {}, $(this).data() );
            delete dataAgent['bs.modal'];
            dataAgent.logDebut_fin=0; //Debut
            agentLogAction(dataAgent);
        });*/



        
    });


    var loader = true;
    

    $(window).load(function() {
        //$(".page-content").children().css('cssText','opacity : 1 !important;');
        $(".page-content").fadeTo('slow',1);
        $("#page-content-style").remove();
    });

    function debug_cmk() {

    }

    //FIX BUG BOOTSTRAP TOOLTIP DESTROY
    $(document).on("click","[data-toggle='tooltip'],.call_contact,.call_contact_ws,.call_contact_recept",function() {
        $("*").tooltip('destroy');
    })

</script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-34731274-1']);
    _gaq.push(['_trackPageview']);
    _gaq.push(['_trackEvent', 'sharing', 'viewed full-screen', 'snippet M3jmA',0,true]);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    </script>
    <script type="text/javascript">
    (function($) { 
        $('#theme_chooser').change(function(){
            whichCSS = $(this).val();
            document.getElementById('snippet-preview').contentWindow.changeCSS(whichCSS);
        });
    })(jQuery);
    </script>


</body>


@yield('js')
</html>
