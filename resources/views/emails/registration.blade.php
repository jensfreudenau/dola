<dl class="dl-horizontal">
    <dt>Datum:</dt>
    <dd>{{ $competition->start_date }}</dd>
    <dt>Veranstaltung:</dt>
    <dd>{{ $competition->header }}</dd>
    <dt>Melder:</dt>
    <dd>{{ $team->annunciator }}</dd>
    <dt>Telefon Nr.:</dt>
    <dd>{{ $team->telephone }}</dd>
    <dt>Email:</dt>
    <dd>{{ $team->email }}</dd>
    <dt>Verein:</dt>
    <dd>{{ $team->clubname }}</dd>
    @if($team->resultlist)
        <dt>es ist eine Ergebnisliste angefordert worden:</dt><dd></dd>
        <dt>Strasse:</dt>
        <dd>{{ $team->street }}</dd>
        <dt>Ort:</dt>
        <dd>{{ $team->city }}</dd>
    @endif
</dl>

<table class="table table-hover">
    <thead class="thead-inverse">
    <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Geb. Jahr</th>
        <th>Altersklasse</th>
        <th>Disziplin</th>
        <th>Bestzeit</th>
    </tr>
    </thead>
    <tbody>

    @foreach($team->Participator as $participator)
        <tr>
            <td>{{$participator->prename}}</td>
            <td>{{$participator['lastname'] }}</td>
            <td>{{$participator['birthyear'] }}</td>
            <td>{{$participator['age_group'] }}</td>
            <td>{{$participator['discipline'] }}</td>
            <td>{{$participator['best_time'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>