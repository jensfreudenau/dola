@extends('layouts.front')
@section('content')

            <h3>Die nächsten Wettk&auml;mpfe</h3>
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
