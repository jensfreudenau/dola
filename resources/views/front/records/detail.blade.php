@extends('layouts.front')
@section('content')
    <hr>
    <div class="row">
        <div class="col-xs-10"></div>
        <div class="col-xs-2">
            <a href="{{ route('records.record') }}"
               class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
        <div class="col-xs-12">
            <p class="size-h2">{{ $record->header }}</p>
            {!! $record->records_table !!}
        </div>
    </div>
@endsection