@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $competition->header }}
        </div>
        <div class="panel-body">
            <div class="row">
                <p>&nbsp;</p>
                <a href="{{ route('admin.competitions.index') }}"
                class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                <div class="col-md-10">
                    <table class="table table-hover">
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.start_date')</th>
                            <td>{{ Carbon\Carbon::parse($competition->start_date)->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.header')</th>
                            <td>{{ $competition->header }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.award')</th>
                            <td>{{ $competition->award }}</td>
                        </tr>

                        <tr>
                            <th>@lang('quickadmin.addresses.title')</th>
                            <td>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ $competition->team->address->name }}<br>
                                        {{ $competition->team->address->street }}<br>
                                        {{ $competition->team->address->zip }}
                                        {{ $competition->team->address->city }}<br>
                                        {{ $competition->team->address->email }}<br>
                                        {{ $competition->team->homepage }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.info')</th>
                            <td>{{ $competition->info }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.submit_date')</th>
                            <td>{{ Carbon\Carbon::parse($competition->submit_date)->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">{!!  $competition->timetable_1 !!}</td>
                        </tr>
                        <tr>
                            <td colspan="2">{!! $competition->timetable_2 or '' !!}</td>
                        </tr>
                    </table>

                    <div class="panel-body table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>@lang('quickadmin.participator_team.fields.clubname')</th>
                                <th>@lang('quickadmin.participator_team.fields.annunciator')</th>
                                <th>@lang('quickadmin.participator.fields.name')</th>
                                <th>@lang('quickadmin.participator.fields.discipline')</th>
                                <th>@lang('quickadmin.participator.fields.age_group')</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($competition->Posts as $participator)
                                <tr>
                                    <td>{{$participator->ParticipatorTeam->clubname}}</td>
                                    <td>{{$participator->ParticipatorTeam->annunciator}}</td>
                                    <td>{{$participator->prename}} &nbsp; {{$participator->lastname}}</td>
                                    <td>{{$participator->discipline}}</td>
                                    <td>{{$participator->age_group}}</td>
                                </tr>
                            @endforeach
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop