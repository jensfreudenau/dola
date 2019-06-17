@extends('layouts.front')
@section('content')

    <div class="card card-default mb-5 p-3">
        <h3>Massen Anmeldung</h3>
        {!! Form::open(['method' => 'POST', 'route' => ['announciators/massupload']]) !!}
        <div class="form-group">
            {!! Form::label('competition_id', Lang::get('quickadmin.competitions.title'), ['class' => 'control-label']) !!}
            {!! Form::select('competition_id', $competitionselect, null, ['id'=> 'competition_id', 'class' => 'competition_select form-control','style'=>'width: 100%']) !!}
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="form-group float-right">
                    <div class="input-group">
                        {!! Form::button('<i class="fa fa-pencil" aria-hidden="true">
                        </i>&nbsp;auswählen', array('class' => 'btn btn-outline-primary', 'type' => 'submit')) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('hash',$hash) !!}
        {!! Form::close() !!}
    </div>
@stop

