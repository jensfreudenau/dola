@extends('layouts.app')
@section('content')
    <div class="card card-default">
        <div class="card-body table-responsive">
            <h3 class="page-title">@lang('quickadmin.hashes.title')</h3>
            <div class="card-heading">
                @can('hashes_create')
                    <p>
                        <a href="{{ route('admin.hashes.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                    </p>
                @endcan
            </div>

            <table class="table table-striped {{ count($hashes) > 0 ? 'datatable' : '' }} @can('hashes_delete') dt-select @endcan">
                <thead>
                <tr>
                    @can('hashes_delete')
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    @endcan
                    <th>@lang('quickadmin.hashes.fields.email')</th>
                    <th>@lang('quickadmin.hashes.fields.hash')</th>
                    <th>@lang('quickadmin.hashes.fields.active')</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @if (count($hashes) > 0)
                    @foreach ($hashes as $hash)
                        <tr data-entry-id="{{ $hash->id }}">
                            @can('hashes_delete')
                                <td></td>
                            @endcan

                            <td>{{ $hash->email }}</td>
                            <td>{!! url('/') !!}/announciators/mass/{{ $hash->hash }}</td>
                            <td>{{ $hash->active }}</td>
                            <td>

                                @can('hashes_edit')
                                    <a href="{{ route('admin.hashes.edit',[$hash->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                @endcan
                                @can('hashes_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.hashes.destroy', $hash->id])) !!}
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
        @can('hashes_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.hashes.mass_destroy') }}';
        @endcan

    </script>
@endsection