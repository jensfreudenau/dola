@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>
    @can('competition_create')
        <p>
            <a href="{{ route('admin.competitions.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($competitions) > 0 ? 'datatable' : '' }} @can('competition_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('competition_delete')
                            <th style="width:30px;text-align:center;"><input type="checkbox" id="select-all"/></th>
                        @endcan

                        <th>@lang('quickadmin.competitions.fields.header')</th>
                        <th>@lang('quickadmin.competitions.fields.start_date')</th>
                        <th>@lang('quickadmin.competitions.fields.season')</th>
                        <th>@lang('quickadmin.competitions.fields.participator')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                @if (count($competitions) > 0)
                    @foreach ($competitions as $competition)
                        <tr data-entry-id="{{ $competition->id }}">
                            @can('competition_delete')
                                <td></td>
                            @endcan

                            <td>{{ $competition->header or '' }}</td>
                            <td>{{ Carbon\Carbon::parse($competition->start_date)->format('d.m.Y') }}</td>
                            <td>{{ $competition->season or '' }}</td>
                            <td>{{ $competition->Participators->count() }}</td>
                            <td>
                                @can('competition_view')
                                    <a href="{{ route('admin.competitions.show',[$competition->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                @endcan
                                @can('competition_edit')
                                    <a href="{{ route('admin.competitions.edit',[$competition->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                @endcan
                                @can('competition_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.competitions.destroy', $competition->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
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

@section('javascript')
    <script>
        @can('competition_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.competitions.mass_destroy') }}';
        @endcan

    </script>
@endsection