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
    {!! Form::label('ignore_disciplines', Lang::get('quickadmin.competitions.ignore_disciplines')) !!}
    {{ Form::checkbox('ignore_disciplines') }}<br>
    {!! Form::label('disciplines', Lang::get('quickadmin.competitions.fields.disciplines')) !!}
    {{ Form::select('disciplines[]', $disciplines, array_pluck($competition->disciplines, 'id'), ['multiple', 'class'=>'form-control select2']) }}
</div>
<div class="form-group">
    {!! Form::label('ignore_ageclasses', Lang::get('quickadmin.competitions.ignore_ageclasses')) !!}
    {{ Form::checkbox('ignore_ageclasses') }}<br>
    {!! Form::label('ageclasses', Lang::get('quickadmin.competitions.fields.classes')) !!}
    {!! Form::select('ageclasses[]', $ageclasses, array_pluck($competition->ageclasses, 'id'), ['multiple', 'class'=>'form-control select2']) !!}
</div>
@endif
<div class="form-group">
    {!! Form::label('register', Lang::get('quickadmin.competitions.register')) !!}<br>
    {{ Form::radio('register', 0, 0,['required', 'id'=>'external_register']) }} @lang('quickadmin.competitions.external_register')
    {{ Form::radio('register', 0, 0,['required', 'id'=>'intern_register']) }} @lang('quickadmin.competitions.intern_register')
</div>
<div class="form-group">
    {!! Form::label('only_list', Lang::get('quickadmin.competitions.only_list')) !!}<br>
    {{ Form::radio('only_list', 0, 0,['required', 'id'=>'list']) }} @lang('quickadmin.competitions.list')
    {{ Form::radio('only_list', 0, 0,['required', 'id'=>'show']) }} @lang('quickadmin.competitions.show')
</div>
<div class="form-group">
    {!! Form::label('season', Lang::get('quickadmin.season')) !!}<br>
    {{ Form::radio('season', 'bahn',0,['required', 'id'=>'bahn']) }} @lang('quickadmin.competitions.track')
    {{ Form::radio('season', 'halle',0,['required', 'id'=>'halle']) }} @lang('quickadmin.competitions.indoor')
    {{ Form::radio('season', 'cross',0,['required', 'id'=>'cross']) }} @lang('quickadmin.competitions.cross')
</div>
<div class="form-group">
    {!! Form::label('timetable_1', Lang::get('quickadmin.timetable'). '1') !!}
    {!! Form::textarea('timetable_1', null, ['id'=> 'competition-timetable_1', 'class'=>'form-control']) !!}
</div>
