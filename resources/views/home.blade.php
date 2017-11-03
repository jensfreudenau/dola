@extends('layouts.front')
@section('content')

    <hr>
    <div class="row">
        <div class="col-xs-12">
            <p class="size-h2">Die nächsten Wettk&auml;mpfe</p>
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
@endsection
