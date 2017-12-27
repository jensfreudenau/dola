<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,700,600,400italic,700italic' rel='stylesheet' type='text/css'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dortmunder Leichtathletik') }}</title>
    @include('partials.front.styles')
<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">

        <div class="col-sm-10">
            @include('partials.front.navbar')

            <div class="section">
                <div class="col-sm">
                    @yield('content')
                </div>
            </div>
        </div>
         
    </div>
</div>


<!-- Scripts -->

@include('partials.footer')
@include('partials.front.javascripts')
@yield('page-script')
</body>
</html>
