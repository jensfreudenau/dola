<dl class="dl-horizontal">
    <dt>Datum:</dt>
    <dd>{{ $competition->start_date }}</dd>
    <dt>Veranstaltung:</dt>
    <dd>{{ $competition->header }}</dd>
    <dt>Melder:</dt>
    <dd>{{ $announciator->name }}</dd>
    <dt>Telefon Nr.:</dt>
    <dd>{{ $announciator->telephone }}</dd>
    <dt>Email:</dt>
    <dd>{{ $announciator->email }}</dd>
    @if($announciator->resultlist)
        <dt>es ist eine Ergebnisliste angefordert worden:</dt>
        <dd></dd>
        <dt>Strasse:</dt>
        <dd>{{ $announciator->street }}</dd>
        <dt>Ort:</dt>
        <dd>{{ $announciator->city }}</dd>
    @endif
</dl>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-inverse">
        <tr>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Verein</th>
            <th>Geb. Jahr</th>
            <th>Altersklasse</th>
            <th>Disziplin</th>
            <th>Bestzeit</th>
        </tr>
        </thead>
        <tbody>

        @foreach($announciator->Participator as $participator)
            <tr>
                <td>{{$participator->prename}}</td>
                <td>{{$participator->lastname }}</td>
                <td>{{$participator->clubname }}</td>
                <td>{{$participator->birthyear }}</td>
                <td>{{$participator->ageclass->shortname }}</td>
                @if(!empty($participator->DisciplineShortName))
                    <td>{{$participator->DisciplineShortName}}</td>
                @else
                    <td>&nbsp;</td>
                @endif
                <td>{{$participator->best_time}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>