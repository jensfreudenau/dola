@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.records.title')</h3>
    @can('record_create')
        <p>
            <a href="{{ route('admin.records.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.records.title')
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped datatable">
                <thead>
                <tr>
                    <th>@lang('quickadmin.records.fields.header')</th>
                    <th>@lang('quickadmin.records.fields.sex')</th>
                    <th>@lang('quickadmin.records.fields.show')</th>
                    <th>@lang('quickadmin.records.fields.edit')</th>

                    <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @if (count($records) > 0)
                    @foreach ($records as $record)
                        <tr data-entry-id="{{ $record->id }}">
                            <td>{{ $record->header or '' }}</td>
                            <td>{{ $record->sex or '' }}</td>
                            <td>
                                @can('competition_view')
                                    <a href="{{ route('admin.records.show',[$record->id]) }}" class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                @endcan
                            </td>
                            <td>
                                @can('competition_edit')
                                    <a href="{{ route('admin.records.edit',[$record->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                @endcan
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9">@lang('quickadmin.qa_no_entries_in_table')</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

