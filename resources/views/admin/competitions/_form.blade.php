<div class="form-group">
    {!! Form::label('header', Lang::get('quickadmin.header')) !!}
    {!! Form::text('header', null, ['id'=> 'competition-headline', 'class'=>'form-control', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('start_date', Lang::get('quickadmin.date')) !!}
    {!! Form::text('start_date', ( $competition ? $competition->getGermanDate($competition->start_date) : null) , ['id'=> 'competition-start_date', 'class'=>'form-control datepicker']) !!}
</div>
<div class="form-group">
    {!! Form::label('submit_date', Lang::get('quickadmin.competitions.fields.submit_date')) !!}
    {!! Form::text('submit_date', ( $competition ? $competition->getGermanDate($competition->submit_date) : null) , ['id'=> 'competition-submit_date', 'class'=>'form-control datepicker']) !!}
</div>
{!! Form::label('team_id', Lang::get('quickadmin.teams.title'), ['class' => 'control-label']) !!}
<div class="form-group">
    {!! Form::select('team_id', $teams, ( $competition ? $competition->team_id: null), ['class' => 'form-control select2', 'required' ]) !!}
</div>
{!! Form::label('addresses_id', Lang::get('quickadmin.addresses.title'), ['class' => 'control-label']) !!}
<div class="form-group">
    {!! Form::select('addresses_id', $addresses, ( $competition ? $competition->addresses_id: null), ['class' => 'form-control select2', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('info', Lang::get('quickadmin.competitions.fields.info')) !!}
    {!! Form::text('info', null, ['id'=> 'competition-info', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('award', Lang::get('quickadmin.competitions.fields.award')) !!}
    {!! Form::text('award', null, ['id'=> 'competition-award', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('classes', Lang::get('quickadmin.competitions.fields.classes')) !!}
    {!! Form::text('classes', null, ['id'=> 'competition-classes', 'class'=>'form-control']) !!}

</div>
<div class="form-group">
    {!! Form::label('register', Lang::get('quickadmin.competitions.register')) !!}<br>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary ">
            {{ Form::radio('register', 1, 0) }} @lang('quickadmin.competitions.external_register')
        </label> <label class="btn btn-primary active">
            {{ Form::radio('register', 0, 1) }} @lang('quickadmin.competitions.intern_register')
        </label>
    </div>
</div>

<div class="form-group">
    {!! Form::label('season', Lang::get('quickadmin.season')) !!}<br>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary {{$track}}">
            {{ Form::radio('season', 'bahn',0,['required']) }} @lang('quickadmin.competitions.track')
        </label> <label class="btn btn-primary {{$indoor}}">
            {{ Form::radio('season', 'halle') }} @lang('quickadmin.competitions.indoor')
        </label> <label class="btn btn-primary {{$cross}}">
            {{ Form::radio('season', 'cross') }} @lang('quickadmin.competitions.cross')
        </label>
    </div>
</div>
<div class="form-group">
    {!! Form::label('timetable_1', Lang::get('quickadmin.timetable'). '1') !!}
    {!! Form::textarea('timetable_1', null, ['id'=> 'competition-timetable_1', 'class'=>'form-control']) !!}
</div>