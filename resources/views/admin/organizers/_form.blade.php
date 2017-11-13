{!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
{!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
{!! Form::label('leader', 'Leader', ['class' => 'control-label']) !!}
{!! Form::text('leader', old('leader'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
{!! Form::label('addresses_id', Lang::get('quickadmin.addresses.title'), ['class' => 'control-label']) !!}
{!! Form::select('addresses_id', $addresses, ( $organizer ? $organizer->address_id: null), ['class' => 'form-control select2']) !!}
{!! Form::label('homepage', 'Homepage', ['class' => 'control-label']) !!}
{!! Form::text('homepage', old('homepage'), ['class' => 'form-control', 'placeholder' => '']) !!}