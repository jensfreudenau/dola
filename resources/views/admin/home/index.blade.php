@extends('layouts.app')

@section('content')

    @can('competition_create')
        <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>
        <p>
            <a href="{{ route('admin.competitions.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_dashboard')
        </div>
        <div class="panel-body table-responsive">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $competitions[0]->Participators->count() }} Anmeldungen </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart_0" width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $competitions[1]->Participators->count() }} Anmeldungen</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart_1"width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $competitions[2]->Participators->count() }} Anmeldungen</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart_2" width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $competitions[3]->Participators->count() }} Anmeldungen</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart_3" width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('javascript')

    <script>
        $(document).ready(function () {
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
                    display: true,
                    text: '{{$competitions[$key]->header}}'
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
    </script>
@endsection