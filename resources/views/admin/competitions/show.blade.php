@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')
        <span><a href="{{ route('admin.competitions.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a></span> <span>
            @can('competition_edit')
                <a href="{{ route('admin.competitions.edit',[$competition->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
            @endcan
        </span>
    </h3>
    <div class="card card-default">
        <div class="card-heading">
            {{ $competition->header }}
        </div>
        <div class="card-body">
            <div class="row">

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
                            <th>@lang('quickadmin.competitions.fields.classes')</th>
                            <td>
                                @foreach ($competition->ageclasses as $ageclass)
                                    {{ $ageclass['shortname'] }},
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.diciplines')</th>
                            <td>
                                @foreach ($competition->disciplines as $discipline)
                                    {{ $discipline['shortname'] }},
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <th>@lang('quickadmin.addresses.title')</th>
                            <td>
                                <div class="card card-default">
                                    <div class="card-body">
                                        {{ $competition->organizer->address->name }}<br>
                                        {{ $competition->organizer->address->street }}<br>
                                        {{ $competition->organizer->address->zip }}
                                        {{ $competition->organizer->address->city }}<br>
                                        {{ $competition->organizer->address->email }}<br>
                                        {{ $competition->organizer->homepage }}
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
                        @if($additionals)
                            @foreach($additionals as $additional)
                                <tr>
                                    <th>{{$additional->key}}</th>
                                    <td>{{$additional->value}}</td>
                                </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td colspan="2">{!!  $competition->timetable_1 !!}</td>
                        </tr>

                    </table>

                    <h3 class="text-green">Anzahl Teilnehmer: {{$competition->Participators->count()}}</h3>
                    <span>
                            <a href="{{ url('admin/participators/download',[$competition->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_csv_download')</a>
                        </span>
                    <div class="card-body table-responsive">

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>@lang('quickadmin.announciator.fields.clubname')</th>
                                <th>@lang('quickadmin.announciator.fields.annunciator')</th>
                                <th>@lang('quickadmin.participator.fields.name')</th>
                                <th>@lang('quickadmin.participator.fields.discipline')</th>
                                <th>@lang('quickadmin.participator.fields.age_group')</th>
                                <th>@lang('quickadmin.participator.fields.best_time')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($announciators as $announciator)
                                @foreach($announciator->participator as $participator)
                                    <tr>
                                        <td>{{$announciator->clubname}}</td>
                                        <td>{{$announciator->name}}</td>
                                        <td>{{$participator->full_name}}</td>
                                        <td>{{$participator->Discipline->shortname}}</td>
                                        <td>{{$participator->Ageclass->shortname}}</td>
                                        <td>{{$participator->best_time}}</td>
                                    </tr>

                                @endforeach
                            @endforeach
                            <tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </div>
    </div>
@stop