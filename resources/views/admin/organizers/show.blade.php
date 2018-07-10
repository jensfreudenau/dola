@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.organizers.title')</h3>
    <span><a href="{{ route('admin.organizers.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a></span>
    <span>
        @can('organizer_edit')
            <a href="{{ route('admin.organizers.edit',[$organizer->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
        @endcan
    </span>
    <div class="card card-default">


        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <tr>
                            <th>@lang('quickadmin.organizers.fields.name')</th>
                            <td>{{  $organizer->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.name')</th>
                            <td>{{  $organizer->leader }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizers.title')</th>
                            <td>{{  $organizer->address->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.street')</th>
                            <td>{{  $organizer->address->street }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.city')</th>
                            <td>{{  $organizer->address->zip }}&nbsp;{{  $organizer->address->city }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.email')</th>
                            <td>{{  $organizer->address->email }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="active"><a href="#track" aria-controls="track" role="tab" data-toggle="tab">@lang('quickadmin.competitions.track')</a></li>
                <li role="presentation" class=""><a href="#indoor" aria-controls="indoor" role="tab" data-toggle="tab">@lang('quickadmin.competitions.indoor')</a></li>
                <li role="presentation" class=""><a href="#cross" aria-controls="cross" role="tab" data-toggle="tab">@lang('quickadmin.competitions.cross')</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabcard" class="tab-pane active" id="track">
                    <table class="table table-striped {{ count($tracks) > 0 ? 'datatable' : '' }}">
                        <thead>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.header')</th>
                            <th>@lang('quickadmin.competitions.fields.start_date')</th>
                            <th>@lang('quickadmin.competitions.fields.submit_date')</th>
                            <th>@lang('quickadmin.competitions.fields.classes')</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($tracks) > 0)
                            @foreach ($tracks as $track)
                                <tr data-entry-id="{{ $track->id }}">
                                    <td>{{ $track->header}}</td>
                                    <td>{{ $track->start_date }}</td>
                                    <td>{{ $track->submit_date }}</td>
                                    <td>{{ $track->classes }}</td>
                                    <td>
                                        @can('organizer_view')
                                            <a href="{{ route('admin.competitions.show',[$track->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                        @endcan
                                        @can('organizer_edit')
                                            <a href="{{ route('admin.competitions.edit',[$track->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('organizer_delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.competitions.destroy', $track->id])) !!}
                                            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div role="tabcard" class="tab-pane " id="indoor">
                    <table class="table table-striped {{ count($indoors) > 0 ? 'datatable' : '' }}">
                        <thead>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.header')</th>
                            <th>@lang('quickadmin.competitions.fields.start_date')</th>
                            <th>@lang('quickadmin.competitions.fields.submit_date')</th>
                            <th>@lang('quickadmin.competitions.fields.classes')</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($indoors) > 0)
                            @foreach ($indoors as $indoor)
                                <tr data-entry-id="{{ $indoor->id }}">
                                    <td>{{ $indoor->header}}</td>
                                    <td>{{ $indoor->start_date }}</td>
                                    <td>{{ $indoor->submit_date }}</td>
                                    <td>{{ $indoor->classes }}</td>
                                    <td>
                                        @can('organizer_view')
                                            <a href="{{ route('admin.competitions.show',[$indoor->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                        @endcan
                                        @can('organizer_edit')
                                            <a href="{{ route('admin.competitions.edit',[$indoor->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('organizer_delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.competitions.destroy', $indoor->id])) !!}
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
                <div role="tabcard" class="tab-pane " id="cross">
                    <table class="table table-striped {{ count($crosses) > 0 ? 'datatable' : '' }}">
                        <thead>
                        <tr>
                            <th>@lang('quickadmin.competitions.fields.header')</th>
                            <th>@lang('quickadmin.competitions.fields.start_date')</th>
                            <th>@lang('quickadmin.competitions.fields.submit_date')</th>
                            <th>@lang('quickadmin.competitions.fields.classes')</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($crosses) > 0)
                            @foreach ($crosses as $cross)
                                <tr data-entry-id="{{ $cross->id }}">
                                    <td>{{ $cross->header}}</td>
                                    <td>{{ $cross->start_date }}</td>
                                    <td>{{ $cross->submit_date }}</td>
                                    <td>{{ $cross->classes }}</td>
                                    <td>
                                        @can('organizer_view')
                                            <a href="{{ route('admin.competitions.show',[$cross->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                        @endcan
                                        @can('organizer_edit')
                                            <a href="{{ route('admin.competitions.edit',[$cross->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('organizer_delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.competitions.destroy', $cross->id])) !!}
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

            <p>&nbsp;</p>

            <a href="{{ route('admin.organizers.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop