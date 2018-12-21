@extends('layouts.app')

@section('content')
<h3 class="page-title">@lang('quickadmin.records.bests.title')</h3>
<div class="col">
    @can('record_create')
    <p>
        <a href="{{ route('admin.records.uploads') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Frauen</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Jahr</th>
                        <th>Dateiname</th>
                    </tr>
                    @forelse($bestsFemale as $key => $best)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td><a href="{{ asset('storage/bestenliste/'.$best->filename) }}" target="_blank">{{$best->year}}</a></td>
                        <td><a href="{{ asset('storage/bestenliste/'.$best->filename) }}" target="_blank">{{$best->filename}}</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td><p class="desc">keine Bestenliste.</p></td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">M&auml;nner</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Jahr</th>
                        <th>Dateiname</th>
                    </tr>
                    @forelse($bestsMale as $key => $best)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td><a href="{{ asset('storage/bestenliste/'.$best->filename) }}" target="_blank">{{$best->year}}</a></td>
                        <td><a href="{{ asset('storage/bestenliste/'.$best->filename) }}" target="_blank">{{$best->filename}}</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td><p class="desc">keine Bestenliste.</p></td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

@stop

