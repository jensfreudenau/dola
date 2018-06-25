@extends('layouts.front')
@section('content')
    <div class="card card-default mb-5 p-5">
        @php
            $amountCompis = count($competitions);
        @endphp
        @if($amountCompis > 1)
            <h2 class="pb-3">Die nächsten {{$amountCompis}} Wettk&auml;mpfe</h2>
        @elseif($amountCompis == 1)
            <h2 class="pb-3">Der nächste Wettkampf</h2>
        @else
            <h2 class="pb-3">Zurzeit keine Wettk&auml;mpfe</h2>
        @endif
        <hr>
        <ul>
            @forelse($competitions as $competition)
                @include('partials.front.competitionlist')
            @empty
                <li>
                    <p class="desc">keine Wettk&auml;mpfe.</p>
                </li>
            @endforelse
        </ul>
    </div>
    <div class="card card-default mb-5 p-5">
        <h2 class="pb-3">Die letzten {{count($lastcompetitions)}} Wettk&auml;mpfe</h2>
        <hr>
        <ul>
            @forelse($lastcompetitions as $competition)
                @include('partials.front.competitionlist')
            @empty
                <li>
                    <p class="desc">keine Wettk&auml;mpfe.</p>
                </li>
            @endforelse
        </ul>

    </div>
@endsection
