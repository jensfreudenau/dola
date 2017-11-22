@extends('layouts.app')

@section('javascript')
    @parent
@stop
@section('content')
    <div class="container">
        <div class="col-sm-10">
            <div class="card card-default">
                <div class="card-heading">
                    Adresse bearbeiten
                </div>
                <div class="card-body">
                    @include('common.errors')

                    {!! Form::model($address, ['method' => 'PUT', 'route' => ['admin.addresses.edit', $address->id]]) !!}

                    {{ method_field('PATCH') }}

                    @include ('admin.addresses._form')
                    {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
