@extends('layouts.front')
@section('content')        
        <div class="col-sm-12">
            <h2>Bestenliste</h2>
            <h3>{{ $header }}</h3>
            <div class="list-group">
            	@forelse($bests as $best)
                    <a href="{{ asset('bestenliste/KBL_'.$best->year.'_'.$file.'.pdf') }}" target="_blank" class="list-group-item">{{$best->year}}</a>
                @empty
                    <p class="desc">keine Rekorde.</p>
            @endforelse
            </div>
        </div>
@endsection