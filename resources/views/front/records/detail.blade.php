@extends('layouts.front')
@section('content')
    
    <div class="row">       
        
        <div class="col-sm-10">
            <h2>{{ $record->header }}</h2>
            {!! $record->records_table !!}
        </div>
        <div class="col-sm-2">
            <a href="{{ route('records.record') }}"
               class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@endsection