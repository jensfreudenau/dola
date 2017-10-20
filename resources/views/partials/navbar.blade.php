<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Wettk&auml;mpfe <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/track">Bahn</a></li>
                        <li><a href="/indoor">Halle</a></li>
                        <li><a href="/cross">Strasse</a></li>
                        <li class="divider"></li>
                        <li><a href="/archive">Ergebnisarchiv</a></li>
                        <li><a href="/subscription">Anmeldeformular</a></li>
                        <li class="divider"></li>
                        <li><a href="/conditions/track">Bedingnungen Bahn</a></li>
                        <li><a href="/conditions/indoor">Bedingnungen Halle</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Statistik <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="records/best/female">Frauen Bestenliste</a></li>
                        <li><a href="records/record/female">Frauen Rekorde</a></li>
                        <li class="divider"></li>
                        <li><a href="records/best/male">M&auml;nner Bestenliste</a></li>
                        <li><a href="records/record/male">M&auml;nner Rekorde</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kontakt <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="contact/kla">Vereine</a></li>
                        <li><a href="contact/clubs">KLA Dortmund</a></li>
                        <li><a href="contact/imprint">Impressum</a></li>
                    </ul>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>