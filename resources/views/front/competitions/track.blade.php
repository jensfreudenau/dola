@extends('layouts.front')
@section('content')


        <h3>Wettk&auml;mpfe / {{$season}}</h3>
        <hr>
        <ul class="fa-ul">
            @forelse($competitions as $competition)
                @include('partials.competitionlist')
            @empty
                <li>
                    <p class="desc">keine Wettk&auml;mpfe.</p>
                </li>
            @endforelse
        </ul>

@endsection

