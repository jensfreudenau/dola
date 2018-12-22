{{--<a class="header" href="{{ url('/') }}"><h1>{{ config('app.name', 'DoLa') }}</h1></a>--}}
<nav class="navbar navbar-light  navbar-expand-lg navbar-fixed-top nav-pills background py-5">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand mb-0">
        <a class="header" href="{{ url('/') }}">{{ config('app.name', 'DoLa') }}</a>
    </h1>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Wettk&auml;mpfe </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/track">Bahn</a>
                    <a class="dropdown-item" href="/indoor">Halle</a> <a class="dropdown-item" href="/cross">Strasse</a>
                    <a class="dropdown-item" href="/announciators/create">Anmeldeformular</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/pages/altersklassen">Altersklassen</a>
                    <a class="dropdown-item" href="/archive">Ergebnisarchiv</a>
                    <a class="dropdown-item" href="/pages/conditions_track">Bedingnungen Bahn</a>
                    <a class="dropdown-item" href="/pages/conditions_indoor">Bedingnungen Halle</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Statistik </a>
                <div class="dropdown-menu" aria-labelledby="statistik">
                    <a class="dropdown-item" href="/records/record">Kreisrekorde</a>
                    <a class="dropdown-item" href="/records/best">Bestenlisten</a>
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