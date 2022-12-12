<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Excel - @yield('title')</title>
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Roboto:500,400italic,100,700italic,300,700,500italic,400" rel="stylesheet">
        
        <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/switchery/switchery.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/jquery-ricksaw-chart/css/rickshaw.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/bootstrap-validator/bootstrapValidator.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/css/demo/jquery-steps.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/summernote/summernote.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/css/demo/jasmine.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/pace/pace.min.css')}}" rel="stylesheet">
        <script src="{{asset('assets/admin/plugins/pace/pace.min.js')}}"></script>
        <link href="{{asset('assets/admin/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
        <style>
           
        </style>
        @yield('css')

    </head>
    <body class="antialiased">
        @yield('content')
        @yield('js')
    </body>
</html>
