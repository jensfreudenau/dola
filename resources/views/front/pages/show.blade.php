@extends('layouts.front')
@section('content')
    <div class="card card-default mb-5 p-3">
        <div class="row">
            <div class="col-sm-12">
                <h2>{{ $page->header }}</h2>
                <span class="pages_table">
                {!! $page->content !!}
            </span>
            </div>
        </div>
    </div>
@endsection