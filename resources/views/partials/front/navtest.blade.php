
<!--Navbar-->
<header class="masthead">

    <h1><a class="navbar-brand" href="{{ url('/') }}">
         {{ config('app.name', 'DoLa') }}

    </a></h1>
    <nav class="navbar-nav navbar-expand-md rounded mb-3">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav text-md-center nav-justified w-50">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="wettkaempfe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Wettk&auml;mpfe</a>
                    <div class="dropdown-menu" aria-labelledby="wettkaempfe">

                        <a class="dropdown-item" href="/track">Bahn</a>
                        <a class="dropdown-item" href="/indoor">Halle</a>
                        <a class="dropdown-item" href="/cross">Strasse</a>
                        <a class="dropdown-item" href="/announciators/create">Anmeldeformular</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/archive">Ergebnisarchiv</a>
                        <a class="dropdown-item" href="/pages/conditions_track">Bedingnungen Bahn</a>
                        <a class="dropdown-item" href="/pages/conditions_indoor">Bedingnungen Halle</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="wettkaempfe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Statistik</a>
                    <div class="dropdown-menu" aria-labelledby="statistik">
                        <a class="dropdown-item" href="/records/record">Kreisrekorde</a>
                        <a class="dropdown-item" href="/records/best/female">Frauen Bestenliste</a>
                        <a class="dropdown-item" href="/records/best/male">M&auml;nner Bestenliste</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="wettkaempfe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kontakt</a>
                    <div class="dropdown-menu" aria-labelledby="Kontakt">
                            <a class="dropdown-item" href="/pages/vereine">Vereine</a>
                            <a class="dropdown-item" href="/pages/adressen_kla">KLA Dortmund</a>
                            <a class="dropdown-item" href="/pages/imprint">Impressum</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>