@extends('layouts.front')
@section('content')
    <div class="card card-default mb-5 p-3">
    <div class="row">       
        
        <div class="col-sm-12">
            <h2>{{ $record->header }}</h2>
            <div class="float-sm-right"><a href="{{ route('records.record') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a></div>
            {!! $record->records_table !!}
        </div>



    </div>
    </div>
@endsection