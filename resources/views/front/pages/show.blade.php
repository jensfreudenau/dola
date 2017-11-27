@extends('layouts.front')
@section('content')
 
    <div class="row">        
        <div class="col-sm-12">
            <h2>{{ $page->header }}</h2>
            <span class="pages_table">
                {!! $page->content !!}
            </span>
        </div>
    </div>
@endsection