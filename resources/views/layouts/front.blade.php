<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
@include('partials.front.navbar')
<div class="container">
        <div class="jumbotron jumbotron-flex">
            <div class="col-sm-12 mx-auto">
                @yield('content')
            </div>
        </div>
    <div id="mesh"></div>
</div>

    
<!-- Scripts -->

@include('partials.footer')
@include('partials.front.javascripts')
@yield('page-script')
</div>
</body>
</html>
