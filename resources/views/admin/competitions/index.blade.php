@extends('layouts.app')
@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>
    @can('competition_create')
        <p>
            <a href="{{ route('admin.competitions.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        </p>
    @endcan
    @if(Session::has('flash_message'))
        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em></div>
    @endif
    <div class="card card-default mb-5">
        <h2>Zukünftige Wettkämpfe</h2>
        <div class="card-body table-responsive">
            <table class="table table-striped {{ count($future) > 0 ? 'datatable' : '' }} @can('competition_delete') dt-select @endcan">
                <thead>
                <tr>
                    @can('competition_delete')
                        <th style="width:30px;text-align:center;"><input type="checkbox" id="select-all"/></th>
                    @endcan

                    <th>@lang('quickadmin.competitions.fields.header')</th>
                    <th>@lang('quickadmin.competitions.fields.start_date')</th>
                    <th>@lang('quickadmin.competitions.fields.season')</th>
                    <th>@lang('quickadmin.competitions.fields.participator')</th>
                    <th>@lang('quickadmin.competitions.fields.update')</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @if (count($future) > 0)
                    @foreach ($future as $competition)
                        <tr data-entry-id="{{ $competition->id }}">
                            @can('competition_delete')
                                <td></td>
                            @endcan

                            <td>{{ $competition->header or '' }}</td>
                            <td>{{ Carbon\Carbon::parse($competition->start_date)->format('d.m.Y') }}</td>
                            <td>{{ $competition->season or '' }}</td>
                            <td><a href="{{ route('admin.participators.listing',[$competition->id]) }}" >{{ $competition->Participators->count() }}</a></td>
                            <td>{{ Carbon\Carbon::parse($competition->updated_at)->format('d.m.Y') }}</td>
                            <td>
                                @can('competition_view')
                                    <a href="{{ route('admin.competitions.show',[$competition->id]) }}" class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                @endcan
                                @can('competition_edit')
                                    <a href="{{ route('admin.competitions.edit',[$competition->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                @endcan
                                @can('competition_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.competitions.destroy', $competition->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
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
    <div class="card card-default">
        <h2>Vergangene Wettkämpfe</h2>
        <div class="card-body table-responsive">
            <table class="table table-striped {{ count($elapsed) > 0 ? 'datatable' : '' }} @can('competition_delete') dt-select @endcan">
                <thead>
                <tr>
                    @can('competition_delete')
                        <th style="width:30px;text-align:center;"><input type="checkbox" id="select-all"/></th>
                    @endcan

                    <th>@lang('quickadmin.competitions.fields.header')</th>
                    <th>@lang('quickadmin.competitions.fields.start_date')</th>
                    <th>@lang('quickadmin.competitions.fields.season')</th>
                    <th>@lang('quickadmin.competitions.fields.participator')</th>
                    <th>@lang('quickadmin.competitions.fields.update')</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @if (count($elapsed) > 0)
                    @foreach ($elapsed as $competition)
                        <tr data-entry-id="{{ $competition->id }}">
                            @can('competition_delete')
                                <td></td>
                            @endcan

                            <td>{{ $competition->header or '' }}</td>
                            <td>{{ Carbon\Carbon::parse($competition->start_date)->format('d.m.Y') }}</td>
                            <td>{{ $competition->season or '' }}</td>
                            <td><a href="{{ route('admin.participators.listing',[$competition->id]) }}" >{{ $competition->Participators->count() }}</a></td>
                            <td>{{ Carbon\Carbon::parse($competition->updated_at)->format('d.m.Y') }}</td>
                            <td>
                                @can('competition_view')
                                    <a href="{{ route('admin.competitions.show',[$competition->id]) }}" class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                @endcan
                                @can('competition_edit')
                                    <a href="{{ route('admin.competitions.edit',[$competition->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                @endcan
                                @can('competition_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.competitions.destroy', $competition->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
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