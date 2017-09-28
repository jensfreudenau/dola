{!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
{!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
{!! Form::label('leader', 'Leader', ['class' => 'control-label']) !!}
{!! Form::text('leader', old('leader'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
{!! Form::label('address_id', 'Address', ['class' => 'control-label']) !!}
{!! Form::select('address_id', $addresses, old('address_id'), ['class' => 'form-control select2']) !!}
{!! Form::label('homepage', 'Homepage', ['class' => 'control-label']) !!}
{!! Form::text('homepage', old('homepage'), ['class' => 'form-control', 'placeholder' => '']) !!}