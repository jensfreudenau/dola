<div class="form-group">
    {!! Form::label('header', Lang::get('quickadmin.header')) !!}
    {!! Form::text('header', null, ['id'=> 'competition-headline', 'class'=>'form-control', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('start_date', Lang::get('quickadmin.date')) !!}
    {!! Form::text('start_date', null , ['id'=> 'competition-start_date', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('submit_date', Lang::get('quickadmin.competitions.fields.submit_date')) !!}
    {!! Form::text('submit_date', null , ['id'=> 'competition-submit_date', 'class'=>'form-control']) !!}
</div>
{!! Form::label('organizer_id', Lang::get('quickadmin.organizers.title'), ['class' => 'control-label']) !!}
<div class="form-group">
    {!! Form::select('organizer_id', $organizers, ( $competition ? $competition->organizer_id: null), ['class' => 'form-control select2', 'required' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('info', Lang::get('quickadmin.competitions.fields.info')) !!}
    {!! Form::text('info', null, ['id'=> 'competition-info', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('award', Lang::get('quickadmin.competitions.fields.award')) !!}
    {!! Form::text('award', null, ['id'=> 'competition-award', 'class'=>'form-control']) !!}
</div>
@if (!$disabled)
    <div class="form-group">
        {!! Form::label('disciplines', Lang::get('quickadmin.competitions.fields.disciplines')) !!}
        {{ Form::select('disciplines[]', $disciplines, array_pluck($competition->disciplines, 'id'), ['multiple', 'class'=>'form-control select2']) }}
    </div>
    <div class="form-group">
        {!! Form::label('ageclasses', Lang::get('quickadmin.competitions.fields.classes')) !!}
        {!! Form::select('ageclasses[]', $ageclasses, array_pluck($competition->ageclasses, 'id'), ['multiple', 'class'=>'form-control select2']) !!}
    </div>
@endif
<div class="form-group">
    {!! Form::label('register', Lang::get('quickadmin.competitions.register')) !!}<br>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary {{$register['external']}}">
            {{ Form::radio('register', 1, 0) }} @lang('quickadmin.competitions.external_register')
        </label>
        <label class="btn btn-primary {{$register['internal']}}">
            {{ Form::radio('register', 0, 0) }} @lang('quickadmin.competitions.intern_register')

        </label>

    </div>
</div>
<div class="form-group">
    {!! Form::label('only_list', Lang::get('quickadmin.competitions.only_list')) !!}<br>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary  {{$onlyList['list']}}">
            {{ Form::radio('only_list', 1, true) }} @lang('quickadmin.competitions.list')
        </label>
        <label class="btn btn-primary {{$onlyList['not_list']}}">
            {{ Form::radio('only_list', 0, false) }} @lang('quickadmin.competitions.show')
        </label>
    </div>
</div>
<div class="form-group">
    {!! Form::label('season', Lang::get('quickadmin.season')) !!}<br>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary {{$season['track']}}">
            {{ Form::radio('season', 'bahn',0,['required']) }} @lang('quickadmin.competitions.track')
        </label>
        <label class="btn btn-primary {{$season['indoor']}}">
            {{ Form::radio('season', 'halle') }} @lang('quickadmin.competitions.indoor')
        </label>
        <label class="btn btn-primary {{$season['cross']}}">
            {{ Form::radio('season', 'cross') }} @lang('quickadmin.competitions.cross')
        </label>
    </div>
</div>
<div class="form-group">
    {!! Form::label('timetable_1', Lang::get('quickadmin.timetable'). '1') !!}
    {!! Form::textarea('timetable_1', null, ['id'=> 'competition-timetable_1', 'class'=>'form-control']) !!}
</div>
