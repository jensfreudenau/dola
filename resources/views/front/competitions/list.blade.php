@extends('layouts.front')
@section('content')

    <div class="card card-default mb-5 p-5">

        <h3 class="pb-3">Wettk&auml;mpfe / {{$season}}</h3>
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

