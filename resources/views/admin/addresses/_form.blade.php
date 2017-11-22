<div class="form-group">
    {!! Form::label('name', Lang::get('quickadmin.addresses.fields.name')) !!}
    {!! Form::text('name', null, ['id'=> 'address-name', 'class'=>'form-control', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('telephone', Lang::get('quickadmin.addresses.fields.telephone')) !!}
    {!! Form::text('telephone', null, ['id'=> 'address-telephone', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('fax', Lang::get('quickadmin.addresses.fields.fax')) !!}
    {!! Form::text('fax', null, ['id'=> 'address-fax', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('street', Lang::get('quickadmin.addresses.fields.street')) !!}
    {!! Form::text('street', null, ['id'=> 'address-street', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('city', Lang::get('quickadmin.addresses.fields.city')) !!}
    {!! Form::text('city', null, ['id'=> 'address-city', 'class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('email', Lang::get('quickadmin.addresses.fields.email')) !!}
    {!! Form::email('email', null, ['id'=> 'address-email', 'class'=>'form-control']) !!}
</div>

