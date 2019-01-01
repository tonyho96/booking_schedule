<div class="form-group {{ $errors->has('id') ? 'has-error' : ''}}">
    {!! Form::label('id', 'ID', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('id', isset( $project_id ) ? $project_id : null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'NAME', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
    {!! Form::label('code', 'INITIALS', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('code', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'DESCRIPTION', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('description', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('status_id') ? 'has-error' : ''}}">
    {!! Form::label('status_id', 'STATUS', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('status_id', json_decode('{"1" : "Active", "0" : "Inactive"}', true), null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('status_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{--<div class="form-group {{ $errors->has('start_timestamp') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('start_timestamp', 'START_TIMESTAMP', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::text('start_timestamp', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('start_timestamp', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('end_timestamp') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('end_timestamp', 'END_TIMESTAMP', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::text('end_timestamp', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('end_timestamp', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('private') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('private', 'PRIVATE', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::select('private', json_decode('{"1": "YES", "0": "NO"}', true), null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('private', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('parent_folder_id') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('parent_folder_id', 'PARENT_FOLDER_ID', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::number('parent_folder_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('parent_folder_id', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('client_person_id') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('client_person_id', 'CLIENT_PERSON_ID', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::number('client_person_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('client_person_id', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('client_organization_id') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('client_organization_id', 'CLIENT_ORGANIZATION_ID', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::number('client_organization_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('client_organization_id', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('project_order') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('project_order', 'PROJECT_ORDER', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::text('project_order', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('project_order', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('color_background') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('color_background', 'COLOR_BACKGROUND', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::color('color_background', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('color_background', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('color_text') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('color_text', 'COLOR_TEXT', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::text('color_text', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('color_text', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('created_id') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('created_id', 'CREATED_ID', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::number('created_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('created_id', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('created') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('created', 'CREATED', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::text('created', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('created', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('updated_id') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('updated_id', 'UPDATED_ID', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::number('updated_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('updated_id', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('updated') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('updated', 'UPDATED', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::text('updated', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('updated', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
