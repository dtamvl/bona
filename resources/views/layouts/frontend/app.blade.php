<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('/favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    

    <!-- Fonts -->
    <link href="{{ asset('assets/frontend/fonts/ionicons.svg') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js" />

    <!-- Styles -->
    <link href="{{ asset('assets/frontend/css/bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/css/swiper.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/css/ionicons.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://codeseven.github.io/toastr/build/toastr.min.css">

    
    @stack('css')
    
    <!-- {{-- Thông báo --}} -->
    @if(session('toastr'))
    <script>
        var TYPE_MESSAGE = "{{session('toastr.type')}}";
        var MESSAGE = "{{session('toastr.message')}}";
    </script>
    @endif
</head>
<body>
    
    @include('layouts.frontend.partial.header')


    @yield('content')


    @include('layouts.frontend.partial.footer')


    <!-- SCRIPTS -->

    <script src="{{ asset('assets/frontend/js/jquery-3.1.1.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/js/tether.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/scripts.js') }}"></script>

    <script src="https://codeseven.github.io/toastr/build/toastr.min.js" type="text/javascript" ></script>
    
    <script type="text/javascript" >
        if (typeof TYPE_MESSAGE !="undefined")
        {
            switch (TYPE_MESSAGE){
                case 'success':
                toastr.success(MESSAGE);
                break;
                case 'error':
                toastr.error(MESSAGE);
                break;
            }
        }
    </script>
    @stack('js')
</body>
</html>
