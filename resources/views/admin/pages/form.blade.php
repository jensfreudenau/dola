<div class="form-group">
    {!! Form::label('mnemonic', Lang::get('quickadmin.pages.fields.mnemonic')) !!}
    {!! Form::text('mnemonic', null, ['id'=> 'record-mnemonic', 'class'=>'form-control', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('content', Lang::get('quickadmin.content.fields.content')) !!}
    {!! Form::textarea('content', null, ['id'=> 'page-content', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('header', Lang::get('quickadmin.pages.fields.header')) !!}
    {!! Form::text('header', null, ['id'=> 'record-header', 'class'=>'form-control', 'required']) !!}

</div>