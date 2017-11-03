@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.records.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $record->header }}
        </div>
        <div class="panel-body">
            <div class="row">
                <p>&nbsp;</p>
                <a href="{{ route('admin.records.index') }}"
                   class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                <div class="col-md-10">
                    <table class="table table-hover">

                        <tr>
                            <th>@lang('quickadmin.competitions.fields.header')</th>
                            <td>{{ $record->header }}</td>
                        </tr>


                        <tr>
                            <td colspan="2">{!!  $record->records_table !!}</td>
                        </tr>

                    </table>



                </div>
            </div>
        </div>
    </div>
@stop