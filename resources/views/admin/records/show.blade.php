@extends('layouts.app')

@section('content')
    <h2 class="page-title">@lang('quickadmin.records.title')</h2><h2>{{ $record->header }}</h2>
    <span><a href="{{ route('admin.records.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a></span>
    <span>
        @can('record_edit')
            <a href="{{ route('admin.records.edit',[$record->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
        @endcan
    </span>
    <div class="card card-default">

        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <table class="table table-hover">
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.header')</th>
                            <td>{{ $record->header }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">{!!  $record->records_table !!}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop