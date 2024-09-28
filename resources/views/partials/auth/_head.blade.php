<head>
    <base href="{{url('/')}}"/>
    <title>{{ __('Support Ticket') }} | @yield('title','Authentication')</title>
    <meta charset="utf-8" />
    <meta name="description" content="{{url()->full()}}" />
    <meta name="keywords" content="Support Ticket" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="_token" content="@php echo csrf_token(); @endphp" />
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/vendors/spectrum-2.0.5/dist/spectrum.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/vendors/themefy_icon/themify-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" type="text/css">

    @stack('styles')
</head>
