@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.addresses.title')</h3>

    <div class="card card-default">
        <div class="card-heading">
            <h2>{{ $address->name }}</h2>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <table class="table table-hover">
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.name')</th>
                            <td>{{ $address->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.telephone')</th>
                            <td>{{ $address->telephone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.fax')</th>
                            <td>{{ $address->fax }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.street')</th>
                            <td>{{ $address->street }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.zip')</th>
                            <td>{{ $address->zip }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.city')</th>
                            <td>{{ $address->city }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.addresses.fields.email')</th>
                            <td>{{ $address->email }}</td>
                        </tr>
                    </table>
                </div>
                <div class="co-md-2"> <a href="{{ route('admin.addresses.index') }}"
                                         class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a></div>
            </div>
        </div>
        <div class="card-body">
            <ul>
            @foreach($address->organizers as $organizer)
                <li>{{$organizer->name}}</li>
            @endforeach
            </ul>
        </div>
    </div>
@stop