@extends('layouts.front')
@section('content')
 
    <div class="col-md-12">
    <h2>Wettk&auml;mpfe / {{$season}}</h2>
    </div>
 
    
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

