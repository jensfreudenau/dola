@extends('layouts.front')


@section('content')
    <div class="container">
        <div class="row">
            <div class="[ col-xs-12 col-sm-8 ]">
                <h1>Wettk&auml;mpfe / {{$season}}</h1>

                <ul class="event-list">
                    @forelse($competitions as $competition)
                        @include('partials.competitionlist')
                    @empty
                        <li>
                            <p class="desc">keine Wettk&auml;mpfe.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
