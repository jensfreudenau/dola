<li>
    <time datetime="{{ Carbon\Carbon::parse($result->start_date)->format('d.m.Y') }}">
        <span class="day">{{ Carbon\Carbon::parse($result->start_date)->format('d') }}</span>
        <span class="month">{{ Carbon\Carbon::createFromTimeStamp(strtotime($result->start_date))->formatLocalized('%b') }}</span>
        <span class="year">{{ Carbon\Carbon::parse($result->start_date)->format('Y') }}</span>
    </time>

    <div class="info">
        <h2 class="title">{{ $result->header }}</h2>
        <p class="desc">{{ $result->results_1 }}</p>
        <p class="desc">{{ $result->results_2 }}</p>
        <p class="desc">{{ $result->results_3 }}</p>
    </div>
</li>