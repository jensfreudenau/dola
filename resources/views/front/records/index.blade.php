@extends('layouts.front')
@section('content')
    <hr>
     
        <div class="col-sm-12">
            <h2>Rekorde</h2>
            <h3>Frauen</h3>
            <div class="list-group">
            @forelse($females as $female)
                    <a href="{{$female->id}}" class="list-group-item">{{$female->header}}</a>
                @empty
                    <p class="desc">keine Rekorde.</p>
                @endforelse
            </div>
            <h3>M&auml;nner</h3>
            <div class="list-group">
                @forelse($males as $male)
                    <a href="{{$male->id}}" class="list-group-item">{{$male->header}}</a>
                @empty
                    <p class="desc">keine Rekorde.</p>
                @endforelse
            </div>
        
    </div>
@endsection

