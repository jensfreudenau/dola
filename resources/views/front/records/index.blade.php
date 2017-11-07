@extends('layouts.front')
@section('content')
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <p class="size-h2">Rekorde</p>
            <p class="size-h3">Frauen</p>
            <div class="list-group">
            @forelse($females as $female)
                    <a href="{{$female->id}}" class="list-group-item">{{$female->header}}</a>
                @empty
                    <p class="desc">keine Rekorde.</p>
                @endforelse
            </div>
            <p class="size-h3">M&auml;nner</p>
            <div class="list-group">
                @forelse($males as $male)
                    <a href="{{$male->id}}" class="list-group-item">{{$male->header}}</a>
                @empty
                    <p class="desc">keine Rekorde.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

