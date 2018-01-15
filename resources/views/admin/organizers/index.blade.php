@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.organizers.title')</h3>
    @can('organizer_create')
    <p>
        <a href="{{ route('admin.organizers.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped {{ count($organizers) > 0 ? 'datatable' : '' }} @can('organizer_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('organizer_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.organizers.fields.name')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($organizers) > 0)
                        @foreach ($organizers as $organizer)
                            <tr data-entry-id="{{ $organizer->id }}">
                                @can('organizer_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $organizer->name }}</td>
                                <td>
                                    @can('organizer_view')
                                    <a href="{{ route('admin.organizers.show',[$organizer->id]) }}" class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('organizer_edit')
                                    <a href="{{ route('admin.organizers.edit',[$organizer->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('organizer_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.organizers.destroy', $organizer->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('organizer_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.organizers.mass_destroy') }}';
        @endcan

    </script>
@endsection