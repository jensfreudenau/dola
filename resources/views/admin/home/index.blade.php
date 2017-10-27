@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.games.title')</h3>
    @can('game_create')
        <p>
            <a href="{{ route('admin.games.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">

        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('game_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.games.mass_destroy') }}';
        @endcan

    </script>
@endsection