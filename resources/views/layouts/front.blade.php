<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dortmunder Leichtathletik') }}</title>

    <!-- Styles -->

@include('partials.front.styles')


<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>

<body>
<div id="app">
    @include('partials.front.navbar')
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="page  ng-scope">
            <section class="panel panel-default">
                <div class="invoice-inner">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    <h1> {{ config('app.name', 'DoLa') }}
                                    </h1>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                @yield('content')
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                </div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>

<!-- Scripts -->

@include('partials.footer')
@include('partials.front.javascripts')
</body>
</html>
