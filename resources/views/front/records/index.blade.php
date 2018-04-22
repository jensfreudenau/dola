@extends('layouts.front')
@section('content')

    <div class="card card-default mb-5 p-3">
        <h2>Stadion- und Hallenrekorde</h2>
        <h3>Frauen</h3>
        <div class="list-group">
            @forelse($females as $female)
                <a href="{{$female->mnemonic}}" class="list-group-item">{{$female->header}}</a>
            @empty
                <p class="desc">keine Rekorde.</p>
            @endforelse
        </div>
        <h3>M&auml;nner</h3>
        <div class="list-group mb-10">
            @forelse($males as $male)
                <a href="{{$male->mnemonic}}" class="list-group-item">{{$male->header}}</a>
            @empty
                <p class="desc">keine Rekorde.</p>
            @endforelse
        </div>
        <h2 class="mt-5">Kreisrekorde</h2>
        <h3>Frauen</h3>
        <div class="list-group">
            @forelse($kreisFemales as $kreisFemale)
                <a href="{{$kreisFemale->mnemonic}}" class="list-group-item">{{$kreisFemale->header}}</a>
            @empty
                <p class="desc">keine Rekorde.</p>
            @endforelse
        </div>
        <h3>M&auml;nner</h3>
        <div class="list-group">
            @forelse($kreisMales as $kreisMale)
                <a href="{{$kreisMale->mnemonic}}" class="list-group-item">{{$kreisMale->header}}</a>
            @empty
                <p class="desc">keine Rekorde.</p>
            @endforelse
        </div>
    </div>

@endsection

