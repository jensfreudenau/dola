@extends('layouts.front')
@section('content')
<div class="card card-default mb-5 p-3">
    <h2>Bestenliste</h2>
    <div class="row">

        <div class="col-sm-6">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Frauen</th>
                </tr>
                </thead>
                <tbody>
                @forelse($bestsFemale as $bestFemale)
                <tr>
                    <th scope="row"></th>
                    <td><a href="{{ asset('storage/bestenliste/'.$bestFemale->filename) }}" target="_blank">{{$bestFemale->year}}</a></td>
                </tr>
                @empty
                <tr>
                    <td><p class="desc">keine Bestenliste.</p></td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">M&auml;nner</th>
                </tr>
                </thead>
                <tbody>
                @forelse($bestsMale as $bestMale)
                <tr>
                    <th scope="row"></th>
                    <td><a href="{{ asset('storage/bestenliste/'.$bestMale->filename) }}" target="_blank">{{$bestMale->year}}</a></td>
                </tr>
                @empty
                <tr>
                    <td><p class="desc">keine Bestenliste.</p></td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>


@endsection

