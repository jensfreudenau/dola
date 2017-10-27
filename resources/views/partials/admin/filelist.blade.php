<tr>
    <td>
        {{ $uploads->filename }}
    </td>
    <td>
        <a href="{{ url('upload/'.$uploads->filename) }}" target="_blank" class="right btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
    </td>
    <td>
        @can('competition_delete')

            {!! Form::model($competition, ['method' => 'POST', 'route' => ['admin.competitions.delete_file', $uploads->id], 'class' =>'form-inline form-delete']) !!}
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            {!! Form::hidden('id', $uploads->id) !!}
            {!! Form::hidden('competition_id', $competition->id) !!}
            {!! Form::submit(trans('quickadmin.qa_delete'), ['class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
            {!! Form::close() !!}
        @endcan
    </td>
</tr>