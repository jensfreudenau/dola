<div class="form-group">
    {!! Form::label('header', Lang::get('quickadmin.header')) !!}
    {!! Form::text('header', null, ['id'=> 'competition-headline', 'class'=>'form-control']) !!}

    {!! Form::label('start_date', Lang::get('quickadmin.date')) !!}
    {!! Form::text('start_date', ( $competition ? $competition->getGermanDate($competition->start_date) : null) , ['id'=> 'competition-start_date', 'class'=>'form-control datepicker']) !!}

    {!! Form::label('submit_date', Lang::get('quickadmin.competitions.fields.submit_date')) !!}
    {!! Form::text('submit_date', ( $competition ? $competition->getGermanDate($competition->submit_date) : null) , ['id'=> 'competition-submit_date', 'class'=>'form-control datepicker']) !!}

    {!! Form::label('team_id', Lang::get('quickadmin.teams.title'), ['class' => 'control-label']) !!}
    {!! Form::select('team_id', $teams, ( $competition ? $competition->team_id: null), ['class' => 'form-control select2']) !!}

    {!! Form::label('address_id', Lang::get('quickadmin.addresses.title'), ['class' => 'control-label']) !!}
    {!! Form::select('address_id', $addresses, ( $competition ? $competition->addresses_id: null), ['class' => 'form-control select2']) !!}

    {!! Form::label('info', Lang::get('quickadmin.competitions.fields.info')) !!}
    {!! Form::text('info', null, ['id'=> 'competition-headline', 'class'=>'form-control']) !!}

    {!! Form::label('award', Lang::get('quickadmin.competitions.fields.award')) !!}
    {!! Form::text('award', null, ['id'=> 'competition-headline', 'class'=>'form-control']) !!}

    {!! Form::label('classes', Lang::get('quickadmin.competitions.fields.classes')) !!}
    {!! Form::text('classes', null, ['id'=> 'competition-headline', 'class'=>'form-control']) !!}

</div>

<div class="form-group">
    {!! Form::label('season', Lang::get('quickadmin.season')) !!}<br>
    <div class="btn-group" data-toggle="buttons">

        <label class="btn btn-primary {{$track}}">
            {{ Form::radio('season', 'bahn') }} @lang('quickadmin.competitions.track')
        </label>
        <label class="btn btn-primary {{$indoor}}">
            {{ Form::radio('season', 'halle') }} @lang('quickadmin.competitions.indoor')
        </label>
        <label class="btn btn-primary {{$cross}}">
            {{ Form::radio('season', 'cross', true, ['checked' => 'checked']) }} @lang('quickadmin.competitions.cross')
        </label>
    </div>
</div>
<div class="form-group">
    {!! Form::label('timetable_1', Lang::get('quickadmin.timetable'). '1') !!}
    {!! Form::textarea('timetable_1', null, ['id'=> 'competition-timetable_1', 'class'=>'form-control']) !!}

    {!! Form::label('timetable_2', Lang::get('quickadmin.timetable').'2') !!}
    {!! Form::textarea('timetable_2', null, ['id'=> 'competition-timetable_2', 'class'=>'form-control']) !!}

    {!! Form::label('timetable', 'Upload '.Lang::get('quickadmin.timetable')) !!}
    {!! Form::file('timetable') !!}

</div>