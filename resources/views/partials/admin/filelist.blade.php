<tr>
    <td>
        {{ $uploads->filename }}
    </td>
    <td>

        <a href="{{Storage::url($uploads->type . '/'. $competition->season . '/' . $uploads->filename )}}" target="_blank" class="right btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
    </td>
    <td>
        @can('competition_delete_file')
            {!! Form::open(array(
                'style' => 'display: inline-block;',
                'method' => 'DELETE',
                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                'route' => ['admin.competitions.delete_file', $uploads->id])) !!}
            {!! Form::hidden('id', $uploads->id) !!}
            {!! Form::hidden('competition_id', $competition->id) !!}
            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
            {!! Form::close() !!}
        @endcan
    </td>
</tr>