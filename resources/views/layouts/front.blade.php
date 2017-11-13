<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Miriam+Libre:400,700|Source+Sans+Pro:200,400,700,600,400italic,700italic" rel="stylesheet" type="text/css">
     

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
<div class="container">
    @include('partials.front.navtest')
    <main role="main" class="container-fluid">
        <div class="col-md-12">
            <section>
                <div class="container">
                    <div class="row">

                        @yield('content')

                    </div>
                </div>
            </section>

        </div>
    </main>
</div>
<!-- Scripts -->

@include('partials.footer')
@include('partials.front.javascripts')
</body>
</html>
