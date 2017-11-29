@extends('layouts.front')
@section('content')        
        <div class="col-sm-12">
            <h2>Bestenliste</h2>
            <h3>{{ $header }}</h3>
            <div class="list-group">
            	@forelse($bests as $best)
                    <a href="{{ asset('storage/bestenliste/'.$best->filename) }}" target="_blank" class="list-group-item">{{$best->year}}</a>
                @empty
                    <p class="desc">keine Bestenliste.</p>
                @endforelse
            </div>
        </div>
@endsection

