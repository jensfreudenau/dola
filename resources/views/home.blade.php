@extends('layouts.front')
@section('content')


            <div class="card card-default mb-5 p-3">
                <h3 class="pb-3">Die nächsten {{count($competitions)}} Wettk&auml;mpfe</h3>
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
            <div class="card card-default mb-5 p-3">

                <h3 class="pb-3">Die letzten {{count($lastcompetitions)}} Wettk&auml;mpfe</h3>
                <hr>
                <ul class="fa-ul">
                    @forelse($lastcompetitions as $competition)
                        @include('partials.front.competitionlist')
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
