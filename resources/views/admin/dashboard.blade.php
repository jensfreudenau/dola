@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="card card-default">
                <div class="card-heading">Dashboard</div>

                <div class="card-body">
                    Your application's dashboard.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
