<div class="form-group {{ $errors->has('id') ? 'has-error' : ''}}">
    {!! Form::label('id', 'ID', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required','max'=>'9999999999999'] : ['class' => 'form-control','max'=>'9999999999999']) !!}
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

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'DESCRIPTION', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('description', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{--<div class="form-group {{ $errors->has('type_id') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('type_id', 'TYPE_ID', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::select('type_id', json_decode('{"1" : "A", "2" : "B", "3" : "C"}', true), null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('parent_id', 'PARENT_ID', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Form::select('parent_id', json_decode('{"1": "X", "2": "Y", "3": "Z"}', true), null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}--}}
        {{--{!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
