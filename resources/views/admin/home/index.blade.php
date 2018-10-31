@extends('layouts.app')

@section('content')

    @can('competition_create')
        <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>
        <p>
            <a href="{{ route('admin.competitions.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        </p>
    @endcan
    <div class="row">

        @if (count($competitions) > 0)
            @foreach($competitions as $key => $competition)

                @if(($key % 2) == 0)
                    <div class="col-md-6">
                        @endif
                        <div class="card m-3 p-3">
                            <div class="card-block">
                                <h3 class="card-title">{{ $competitions[$key]->Participators->count() }} Anmeldungen für</h3>
                                <h4 class="card-title">{{ $competitions[$key]->header }} am {{ $competitions[$key]->start_date }}</h4>
                                <div class="chart">
                                    <canvas id="lineChart_{{$key}}" width="400" height="250"></canvas>
                                </div>
                                <a href="{{ route('admin.competitions.edit',[$competition->id]) }}" class="btn btn-primary">@lang('quickadmin.qa_edit')</a>
                                <a href="{{ route('admin.competitions.show',[$competition->id]) }}" class="btn btn-elegant">@lang('quickadmin.qa_view')</a>
                                <a href="{{ route('admin.participators.listing',[$competition->id]) }}" class="btn btn-success">@lang('quickadmin.participator.title')</a>
                            </div>
                        </div>
                        @if(($key % 2) == 1) </div> @endif
            @endforeach
        @endif

    </div>


@stop


@section('javascript')

    <script>


        $(document).ready(function () {
                    @if (count($announces) > 0)
            let anz = 0;
            let areaChartCanvas = '';
            let areaChartData = {};
            let myLineChart = {};
            let areaChartOptions = {};

            @foreach ($announces as $key => $announce)

                areaChartCanvas = $('#lineChart_{{$key}}').get(0).getContext('2d');
            areaChartData = {
                labels: [
                    @foreach ($announce as $group => $result)
                        '{!! Carbon\Carbon::parse($result->created_at)->format('d.m.Y') !!}',
                    @endforeach
                ],
                datasets: [
                    {
                        fill: false,
                        borderColor: "#ea6c41",
                        data: [

                            @foreach ($announce as $group => $result)
                            {!! $result->anzahl !!},
                            @endforeach
                        ]
                    }
                ]
            };
            areaChartOptions = {
                legend: {
                    display: false,
                },
                title: {
                    display: false

                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };
            myLineChart = new Chart(areaChartCanvas, {
                type: 'line',
                data: areaChartData,
                options: areaChartOptions
            });
            @endforeach
        });
        @endif
    </script>
@endsection