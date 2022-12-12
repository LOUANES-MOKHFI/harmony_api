<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('assets/agents/vvci/assets/cmk/css/agent-light/main.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/agents/style.css')}}" media="screen" type="text/css" />
    <title>Capital Corp - CRM - &copy;@yield('title')    </title>
    <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
        type="text/css" />

    <link href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}"
        rel="stylesheet" type="text/css" />

    <link type="text/css" rel="stylesheet"
        href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/animate/animate.css')}}">
    <link type="text/css" rel="stylesheet"
        href="{{asset('assets/agents/vvci/assets/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/agents/vvci/assets/cmk/css/cmk/cs-select.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/agents/vvci/assets/cmk/css/cmk/cs-skin-underline.css')}}" />
    <link rel="shortcut icon" href="{{asset('assets/agents/vvci/assets/icon/favicon.ico')}}">
    <style>
         body {
        font-size: 16px;
    }

    .filter-option,
    .bs-caret {
        color: #FFFFFF;
    }
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 220px;
        height: 220px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
        align : center;
        }

        /* Safari */
        @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
        
    </style>
</head>
<body class="h-screen bg-gray-200 bg-no-repeat bg-cover"
    style="background-image: url({{asset('assets/agents/img/bg_light.jpg')}}">
   

    @yield('content')
   
</body>
</html>