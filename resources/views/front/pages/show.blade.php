@extends('layouts.front')
@section('content')
    <div class="card card-default mb-5 p-3">

                <h2>{{ $page->header }}</h2>

                {!! $page->content !!}


    </div>
@endsection