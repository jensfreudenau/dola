@extends('layouts.front')
@section('content')

    <div class="card card-default mb-5 p-5">

        <h2 class="pb-3">Wettk&auml;mpfe / {{$season}}</h2>
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

@endsection

