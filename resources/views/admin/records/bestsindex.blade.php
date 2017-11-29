@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.records.title')</h3>
    @can('record_create')
        <p>
            <a href="{{ route('admin.records.uploads') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    <div class="card card-default">
        <div class="card-heading">
            <h2>Frauen</h2>
        </div>

        @forelse($bests as $best)
            @if($best->sex == 'f')
                <a href="{{ asset('storage/bestenliste/'.$best->filename) }}" target="_blank" class="list-group-item">{{$best->year}} {{$best->filename}}</a>
            @endif
        @empty
            <p class="desc">keine Bestenliste.</p>
        @endforelse
    </div>
    <div class="card card-default">
        <div class="card-heading">
            <h2>M&auml;nner</h2>
        </div>
        @forelse($bests as $best)
            @if($best->sex == 'm')
                <a href="{{ asset('storage/bestenliste/'.$best->filename) }}" target="_blank" class="list-group-item">{{$best->year}} {{$best->filename}}</a>
            @endif
        @empty
            <p class="desc">keine Bestenliste.</p>
        @endforelse
    </div>
@stop

