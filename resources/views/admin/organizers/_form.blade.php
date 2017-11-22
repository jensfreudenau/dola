<div class="col-sm-12 form-group">
    {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
</div>
<div class="col-sm-12 form-group">
    {!! Form::label('leader', 'Leader', ['class' => 'control-label']) !!}
    {!! Form::text('leader', old('leader'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
</div>
<div class="col-sm-12 form-group">
    {!! Form::label('addresses_id', Lang::get('quickadmin.addresses.title'), ['class' => 'control-label']) !!}
    {!! Form::select('addresses_id', $addresses, ( $organizer ? $organizer->address_id: null), ['class' => 'form-control select2']) !!}
</div>
<div class="col-sm-12 form-group">
    {!! Form::label('homepage', 'Homepage', ['class' => 'control-label']) !!}
    {!! Form::text('homepage', old('homepage'), ['class' => 'form-control', 'placeholder' => '']) !!}
</div>