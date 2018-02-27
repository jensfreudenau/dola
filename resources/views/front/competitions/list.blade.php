@extends('layouts.front')
@section('content')

    <div class="card card-default mb-5 p-3">

        <h3>Wettk&auml;mpfe / {{$season}}</h3>
        <hr>
        <ul class="fa-ul">
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

