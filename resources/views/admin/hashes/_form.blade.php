<div class="col-sm-12 form-group">
    {!! Form::label('email', 'Email*', ['class' => 'control-label']) !!}
    {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
</div>

<div class="input-wrpr">
    {!! Form::label('active', Lang::get('quickadmin.hashes.fields.active')) !!}
    {!! Form::checkbox('active', '1'); !!}
</div>