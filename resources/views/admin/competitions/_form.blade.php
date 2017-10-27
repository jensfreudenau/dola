<div class="form-group">
    {!! Form::label('header', Lang::get('quickadmin.header')) !!}
    {!! Form::text('header', null, ['id'=> 'competition-headline', 'class'=>'form-control', 'required']) !!}

    {!! Form::label('start_date', Lang::get('quickadmin.date')) !!}
    {!! Form::text('start_date', ( $competition ? $competition->getGermanDate($competition->start_date) : null) , ['id'=> 'competition-start_date', 'class'=>'form-control datepicker']) !!}

    {!! Form::label('submit_date', Lang::get('quickadmin.competitions.fields.submit_date')) !!}
    {!! Form::text('submit_date', ( $competition ? $competition->getGermanDate($competition->submit_date) : null) , ['id'=> 'competition-submit_date', 'class'=>'form-control datepicker']) !!}

    {!! Form::label('team_id', Lang::get('quickadmin.teams.title'), ['class' => 'control-label']) !!}
    {!! Form::select('team_id', $teams, ( $competition ? $competition->team_id: null), ['class' => 'form-control select2', 'required' ]) !!}

    {!! Form::label('addresses_id', Lang::get('quickadmin.addresses.title'), ['class' => 'control-label']) !!}
    {!! Form::select('addresses_id', $addresses, ( $competition ? $competition->addresses_id: null), ['class' => 'form-control select2', 'required']) !!}

    {!! Form::label('info', Lang::get('quickadmin.competitions.fields.info')) !!}
    {!! Form::text('info', null, ['id'=> 'competition-info', 'class'=>'form-control']) !!}

    {!! Form::label('award', Lang::get('quickadmin.competitions.fields.award')) !!}
    {!! Form::text('award', null, ['id'=> 'competition-award', 'class'=>'form-control']) !!}

    {!! Form::label('classes', Lang::get('quickadmin.competitions.fields.classes')) !!}
    {!! Form::text('classes', null, ['id'=> 'competition-classes', 'class'=>'form-control']) !!}

</div>

<div class="form-group">
    {!! Form::label('season', Lang::get('quickadmin.season')) !!}<br>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary {{$track}}">
            {{ Form::radio('season', 'bahn', 'bahn') }} @lang('quickadmin.competitions.track')
        </label>
        <label class="btn btn-primary {{$indoor}}">
            {{ Form::radio('season', 'halle', 'halle') }} @lang('quickadmin.competitions.indoor')
        </label>
        <label class="btn btn-primary {{$cross}}">
            {{ Form::radio('season', 'cross', 'cross') }} @lang('quickadmin.competitions.cross')
        </label>
    </div>
</div>
<div class="form-group">
    {!! Form::label('timetable_1', Lang::get('quickadmin.timetable'). '1') !!}
    {!! Form::textarea('timetable_1', null, ['id'=> 'competition-timetable_1', 'class'=>'form-control']) !!}
</div>