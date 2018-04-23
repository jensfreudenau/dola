@extends('layouts.app')

@section('content')
    <h2 class="page-title">@lang('quickadmin.competitions.title')
        <span><a href="{{ route('admin.competitions.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a></span> <span>
            @can('competition_edit')
                <a href="{{ route('admin.competitions.edit',[$competition->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
            @endcan
        </span>
    </h2>
    <div class="card card-default">
        <div class="card-heading">
           <h2>{{ $competition->header }}</h2>
        </div>
        <div class="card-body">
            <div class="row">


                <h4 class="text-green">Anzahl Teilnehmer: {{$competition->Participators->count()}}</h4>
                <div class="card-body table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th>@lang('quickadmin.announciator.fields.clubname')</th>
                            <th>@lang('quickadmin.announciator.fields.annunciator')</th>
                            <th>@lang('quickadmin.participator.fields.name')</th>
                            <th>@lang('quickadmin.participator.fields.discipline')</th>
                            <th>@lang('quickadmin.participator.fields.age_group')</th>
                            <th>@lang('quickadmin.participator.fields.age_group')</th>
                            <th>@lang('quickadmin.participator.fields.best_time')</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($competition->Participators as $participator)
                            <tr>
                                <td>{{$participator->Announciator->clubname}}</td>
                                <td>{{$participator->Announciator->name}}</td>
                                <td>{{$participator->prename}} &nbsp; {{$participator->lastname}}</td>
                                <td>{{$participator->discipline}}</td>
                                <td>{{$participator->ageclass->shortname}}</td>
                                <td>{{$participator->best_time}}</td>
                            </tr>
                        @endforeach
                        <tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@stop