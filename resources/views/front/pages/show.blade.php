@extends('layouts.front')
@section('content')
 
    <div class="row">        
        <div class="col-sm-12">
            <h2>{{ $page->header }}</h2>
            {!! $page->content !!}
        </div>
    </div>
@endsection