@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $competition->header }}
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
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
                                        {{ $competition->address->name }}<br>
                                        {{ $competition->address->street }}<br>
                                        {{ $competition->address->zip }}
                                        {{ $competition->address->city }}<br>
                                        {{ $competition->address->email }}<br>
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
                </div>
            </div>
            <p>&nbsp;</p>
            <a href="{{ route('admin.competitions.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop