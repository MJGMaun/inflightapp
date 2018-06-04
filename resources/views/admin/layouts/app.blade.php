<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet"> @yield('css')

</head>

<body>
        @include('admin.inc.navbar') 
        <div class="container-fluid">
                
                {{-- <div class="row"> --}}
                    @include('admin.inc.sidebar')
                    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><br>
                        @include('admin.inc.messages')
                        @yield('content')
                    </main>
                    
                {{-- </div> --}}
            </div>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    @yield('script')
    <script>
        feather.replace()
    </script>
</body>

</html>