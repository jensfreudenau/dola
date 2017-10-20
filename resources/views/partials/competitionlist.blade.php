<li>
    <time date="{{ $competition->start_date }}">
        <span class="day">{{ Carbon\Carbon::parse($competition->start_date)->format('d') }}</span>
        <span class="month">{{ Carbon\Carbon::createFromTimeStamp(strtotime($competition->start_date))->formatLocalized('%b') }}</span>
        <span class="year">{{ Carbon\Carbon::parse($competition->start_date)->format('Y') }}</span>
    </time>

    <div class="info">

        <h2 class="title"><a href="details/{{ $competition->id }}">{{ $competition->header }}</a></h2>
        <p class="desc">Altersklassen: {{ $competition->classes }}</p>
        <p class="desc">Meldeschlu&szlig;: {{ $competition->submit_date}}</p>
        @if(!empty(trim($competition->info)))
            <p class="desc">Info:{{ $competition->info }}</p>
        @endif
    </div>
</li>



