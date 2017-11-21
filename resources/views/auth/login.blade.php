@extends('layouts.auth')

@section('content')

    <h2>{{ ucfirst(config('app.name')) }} Login</h2>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were problems with input: <br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


        {{ Form::open(['url'=>url('login'), 'class' => 'form-horizontal']) }}
        <div class="form-group">
            {!! Form::label('email', 'Email', ['class'=>'col-md-4 control-label']) !!}
            {!! Form::text('email', null, ['class'=>'form-control col-md-6', 'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'Password', ['class'=>'col-md-4 control-label']) !!}
            {!! Form::password('password',['class'=>'form-control col-md-6', 'required']) !!}
        </div>
        <div class="form-group">
        {{ Form::submit('Login', ["class"=>"btn btn-primary", 'style'=>'margin-right: 15px;']) }}
            {!! Form::close() !!}
        </div>
    </form>


@endsection