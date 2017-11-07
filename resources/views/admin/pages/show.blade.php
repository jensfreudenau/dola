@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.pages.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $page->header }}
        </div>
        <div class="panel-body">
            <div class="row">
                <p>&nbsp;</p>
                <a href="{{ route('admin.pages.index') }}"
                   class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                <div class="col-md-10">
                    <table class="table table-hover">

                        <tr>
                            <th>@lang('quickadmin.pages.fields.header')</th>
                            <td>{{ $page->header }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.pages.fields.header')</th>
                            <td>{{ $page->mnemonic }}</td>
                        </tr>


                        <tr>
                            <td colspan="2">{!!  $page->content !!}</td>
                        </tr>

                    </table>



                </div>
            </div>
        </div>
    </div>
@stop