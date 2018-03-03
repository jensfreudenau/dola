@extends('layouts.front')
@section('content')
    <div class="card card-default mb-5 p-3">
        <h3>Altersklasseneinteilung</h3>
        <div class="justify-content-center">
            <div class="jumbotron my-auto">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>Bezeichnung</td>
                            <td>Kurzname</td>
                            <td>Alter</td>
                            <td>Geburtsjahr</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ageclasses as $ageclass)
                            <tr>
                                <td>{{$ageclass['name']}}</td>
                                <td>{{$ageclass['shortname']}}</td>
                                <td>{{$ageclass['ageRange']}}</td>
                                <td>{{$ageclass['yearRange']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection