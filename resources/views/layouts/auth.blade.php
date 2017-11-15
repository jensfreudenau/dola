<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.admin.head')
</head>

<body class="page-header-fixed">

    <div style="margin-top: 10%;"></div>

    <div class="container-fluid">
        @yield('content')
    </div>

    <div class="scroll-to-top"
         style="display: none;">
        <i class="fa fa-arrow-up"></i>
    </div>

    @include('partials.admin.javascripts')

</body>
</html>