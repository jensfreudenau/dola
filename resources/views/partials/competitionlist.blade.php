<li><i class="fa-li fa fa-check-square"></i>
    <time date="{{ $competition->start_date }}">
        <span class="day">{{ Carbon\Carbon::parse($competition->start_date)->format('d') }}.</span>
        <span class="month">{{ Carbon\Carbon::createFromTimeStamp(strtotime($competition->start_date))->formatLocalized('%B') }}</span>
        <span class="year">{{ Carbon\Carbon::parse($competition->start_date)->format('Y') }}</span>
    </time>
    <div class="info">
        <h3 class="title"><a href="details/{{ $competition->id }}">{{ $competition->header }}</a></h3>
        <p class="desc"><span class="desc_type">Altersklassen: </span>{{ $competition->reduceClasses() }}</p>
        <p class="desc"><span class="desc_type">Meldeschlu&szlig;: </span>{{ $competition->submit_date}}</p>
        @if(!empty(trim($competition->info)))
            <p class="desc"><span class="desc_type red_font">Info: &nbsp;</span>{{ $competition->info }}</p>
        @endif

        @foreach($competition->Uploads as $upload)
            @if($upload->type == config('constants.Participators'))
                <p class="desc"><a href="upload/{{$upload->type}}/{{$upload->filename}}" target="_blank">Teilnehmer</a></p>
            @endif

            @if($upload->type == config('constants.Results'))
                    <p class="desc"><a href="upload/{{$upload->type}}/{{$upload->filename}}" target="_blank">Ergebnisliste</a></p>
            @endif

        @endforeach
    </div>
</li>
<hr>


