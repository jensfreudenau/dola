@extends('layouts.front')
@section('content')

            <h2>Die nächsten Wettk&auml;mpfe</h2>

            <ul class="fa-ul">
                @forelse($competitions as $competition)
                    @include('partials.front.competitionlist')
                    @empty
                    <li>
                        <p class="desc">keine Wettk&auml;mpfe.</p>
                    </li>
                @endforelse
            </ul>

            <h2>Die letzten Wettk&auml;mpfe</h2>
            <ul class="fa-ul">
                @forelse($lastcompetitions as $competition)
                    @include('partials.front.competitionlist')
                @empty
                    <li>
                        <p class="desc">keine Wettk&auml;mpfe.</p>
                    </li>
                @endforelse
            </ul>
@endsection
