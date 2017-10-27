@extends('layouts.front')


@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="page  ng-scope">
            <section class="panel panel-default">
                <div class="invoice-inner">
                    <div class="row">
                        <div class="col-xs-10">
                            <section class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
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
                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-2"></div>
@endsection
