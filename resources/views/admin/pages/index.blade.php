@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.pages.title')</h3>
    @can('address_create')
        <p>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped {{ count($pages) > 0 ? 'datatable' : '' }} @can('address_delete') dt-select @endcan">
                <thead>
                <tr>
                    @can('address_delete')
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    @endcan
                    <th>@lang('quickadmin.pages.fields.header')</th>
                    <th>@lang('quickadmin.pages.fields.mnemonic')</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @if (count($pages) > 0)
                    @foreach ($pages as $address)
                        <tr data-entry-id="{{ $address->id }}">
                            @can('address_delete')
                                <td></td>
                            @endcan
                                <td>{{ $address->header }}</td>
                                <td>{{ $address->mnemonic }}</td>
                            <td>
                                @can('address_view')
                                    <a href="{{ route('admin.pages.show',[$address->id]) }}" class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                @endcan
                                @can('address_edit')
                                    <a href="{{ route('admin.pages.edit',[$address->id]) }}" class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                @endcan
                                @can('address_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.pages.destroy', $address->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
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
    </div>
@stop

@section('javascript')
    <script>
        @can('address_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.pages.mass_destroy') }}';
        @endcan

    </script>
@endsection