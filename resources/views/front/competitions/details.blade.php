@extends('layouts.front')


@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="page  ng-scope">


                <section class="panel panel-default">

                    <div class="invoice-inner">
                        <div class="row">
                            <div class="col-xs-10">
                                <p class="size-h1">{{ $competition->header }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-8">
                                <dl class="dl-horizontal">
                                    <dt>Datum:</dt>
                                    <dd>{{ $competition->start_date}}</dd>
                                    <dt>Meldeschluss:</dt>
                                    <dd>{{ $competition->submit_date }}</dd>
                                    <dt>Auszeichnungen:</dt>
                                    <dd>{{ $competition->award }}</dd>
                                    <dt>Klassen:</dt>
                                    <dd>{{ $competition->classes }}</dd>
                                    <dt>sportl. Leitung:</dt>
                                    <dd>{{ $competition->team->leader }}</dd>
                                    <dt>Meldeanschrift:</dt>
                                    <dd>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                {{ $competition->team->address->name }}<br>
                                                {{ $competition->team->address->street }}<br>
                                                {{ $competition->team->address->zip }}
                                                {{ $competition->team->address->city }}<br>
                                                <a href="mailto:{{ $competition->team->address->email }}">{{ $competition->team->address->email }}</a>
                                            </div>
                                        </div>
                                    </dd>
                                    @if ($competition->team->homepage)
                                        <dt>Webseite:</dt>
                                        <dd><a href="{{ $competition->team->homepage }}">{{ $competition->team->homepage }}</a></dd>
                                    @endif
                                    @if (trim($competition->info))
                                        <dt>Info:</dt>
                                        <dd>{{ $competition->info }}</dd>
                                    @endif

                                    <dt>Haftung:</dt>
                                    <dd>Veranstalter und Ausrichter &uuml;bernehmen keinerlei Haftung
                                        für Sch&auml;den jeglicher Art.</dd>
                                </dl>

                            </div>
                            <div class="col-xs-4 text-right">
                                <a ui-wave="" href="/teams/create/{{ $competition->id }}" class="btn btn-primary btn-raised btn-lg btn-w-lg ui-wave"><i class="fa fa-pencil"></i> anmelden</a>
                            </div>
                        </div>

                        <div class="divider divider-lg"></div>

                        {!! $competition->timetable_1 !!}
                        {!! $competition->timetable_2 !!}
                        <div class="callout callout-success">
                        <span>Elektronische Zeitnahme. &Auml;nderungen vorbehalten! Ohne Gew&auml;hr.
                        Die Wettk&auml;mpfe werden nach den g&uuml;ltigen Wettkampfbestimmungen ausgetragen und stehen unter amtlicher Aufsicht.
                        Wir w&uuml;nschen allen Teilnehmern eine gute Anreise und viel Erfolg.</span><br>
                        </div>


                    </div>
                </section>



            </div>

    </div>
    <div class="col-md-2"></div>
@endsection