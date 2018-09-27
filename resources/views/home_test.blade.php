<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Navbar Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Miriam+Libre:400,700|Source+Sans+Pro:200,400,700,600,400italic,700italic" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">
</head>

<body>

<div class="container">


    <nav class="navbar navbar-expand-lg navbar-light nav-pills background">


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Wettk&auml;mpfe </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/track">Bahn</a> <a class="dropdown-item" href="/indoor">Halle</a> <a class="dropdown-item" href="/cross">Strasse</a> <a class="dropdown-item" href="/announciators/create">Anmeldeformular</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/archive">Ergebnisarchiv</a> <a class="dropdown-item" href="/pages/conditions_track">Bedingnungen Bahn</a> <a class="dropdown-item" href="/pages/conditions_indoor">Bedingnungen Halle</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Statistik </a>
                    <div class="dropdown-menu" aria-labelledby="statistik">
                        <a class="dropdown-item" href="/records/record">Kreisrekorde</a> <a class="dropdown-item" href="/records/best/female">Frauen Bestenliste</a> <a class="dropdown-item" href="/records/best/male">M&auml;nner Bestenliste</a>
                    </div>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="wettkaempfe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kontakt</a>
                    <div class="dropdown-menu" aria-labelledby="Kontakt">
                        <a class="dropdown-item" href="/pages/vereine">Vereine</a> <a class="dropdown-item" href="/pages/adressen_kla">KLA Dortmund</a> <a class="dropdown-item" href="/pages/imprint">Impressum</a>
                    </div>
                </li>
            </ul>

        </div>

    </nav>

    <div class="jumbotron">
        <div class="col-sm-8 mx-auto">
            <div class="card card-default mb-5 p-3">
                <h3>Wettk&auml;mpfe / Bahn</h3>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <time date="17.05.2018">
                            <span class="day">17.</span> <span class="month">Mai</span> <span class="year">2018</span>
                        </time>
                        <div class="info">
                            <h4 class="title">
                                <a href="details/24">Läufertag des LC Rapid Dortmundi</a>
                            </h4>
                            <p class="desc"><span class="desc_type">Meldeschlu&szlig;: </span>15.05.2018</p>

                        </div>
                    </li>


                    <li>
                        <time date="28.05.2018">
                            <span class="day">28.</span> <span class="month">Mai</span> <span class="year">2018</span>
                        </time>
                        <div class="info">
                            <h4 class="title">
                                <a href="details/26">Schüler- und Jugendsportfest des LC Rapid Dortmund</a>
                            </h4>
                            <p class="desc"><span class="desc_type">Meldeschlu&szlig;: </span>23.05.2018</p>

                        </div>
                    </li>


                    <li>
                        <time date="28.05.2018">
                            <span class="day">28.</span> <span class="month">Mai</span> <span class="year">2018</span>
                        </time>
                        <div class="info">
                            <h4 class="title">
                                <a href="details/27">Schüler- und Jugendsportfest des LC Rapid Dortmund</a>
                            </h4>
                            <p class="desc"><span class="desc_type">Meldeschlu&szlig;: </span>23.05.2018</p>

                        </div>
                    </li>


                    <li>
                        <time date="09.07.2018">
                            <span class="day">09.</span> <span class="month">Juli</span> <span class="year">2018</span>
                        </time>
                        <div class="info">
                            <h4 class="title">
                                <a href="details/25">Schüler- und Jugendsportfest der DJK SuS Brambauer</a>
                            </h4>
                            <p class="desc"><span class="desc_type">Meldeschlu&szlig;: </span>03.07.2018</p>

                        </div>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>