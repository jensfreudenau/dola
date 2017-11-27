<li><i class="fa-li fa fa-circle-o"></i>
    <time date="{{ $competition->start_date }}">
        <span class="day">{{ Carbon\Carbon::parse($competition->start_date)->format('d') }}.</span> <span class="month">{{ Carbon\Carbon::createFromTimeStamp(strtotime($competition->start_date))->formatLocalized('%B') }}</span> <span class="year">{{ Carbon\Carbon::parse($competition->start_date)->format('Y') }}</span>
    </time>
    <div class="info">
        <h4 class="title">
            @if($competition->only_list)
                {{ $competition->header }}
            @else
                <a href="details/{{ $competition->id }}">{{ $competition->header }}</a>
            @endif
        </h4>
        @if(!empty(trim($competition->classes)))
            <p class="desc"><span class="desc_type">Altersklassen: </span>{{ $competition->reduceClasses() }}</p>
        @endif
        @if(!empty(trim($competition->submit_date)))
            <p class="desc"><span class="desc_type">Meldeschlu&szlig;: </span>{{ $competition->submit_date}}</p>
        @endif
        @if(!empty(trim($competition->info)))
            <p class="desc"><span class="desc_type red_font">Info: &nbsp;</span>{{ $competition->info }}</p>
        @endif

        @foreach($competition->Uploads as $upload)
            @if($upload->type == config('constants.Additionals'))
                <a href="storage/{{$upload->type}}/{{$competition->season}}/{{$upload->filename}}" target="_blank">Zusatzinfos&nbsp;<i class="fa fa-external-link"></i></a>
            @endif
            @if($upload->type == config('constants.Participators'))
                <p class="desc"><a href="storage/{{$upload->type}}/{{$competition->season}}/{{$upload->filename}}" target="_blank">Teilnehmer&nbsp;<i class="fa fa-external-link"></i></a></p>
            @endif

            @if($upload->type == config('constants.Results'))
                <p class="desc"><a href="storage/{{$upload->type}}/{{$competition->season}}/{{$upload->filename}}" target="_blank">Ergebnisliste&nbsp;<i class="fa fa-external-link"></i></a></p>
            @endif

        @endforeach
    </div>
</li>
<hr>


