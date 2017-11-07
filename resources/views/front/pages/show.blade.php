@extends('layouts.front')
@section('content')
    <hr>
    <div class="row">

        <div class="col-xs-2"> </div>
        <div class="col-xs-12">
            <p class="size-h2">{{ $page->header }}</p>
            {!! $page->content !!}
        </div>
    </div>
@endsection