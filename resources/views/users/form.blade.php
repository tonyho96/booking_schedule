<div class="form-group {{ $errors->has('firstname') ? 'has-error' : ''}}">
    {!! Form::label('firstname', 'First Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('firstname', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('firstname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('lastname') ? 'has-error' : ''}}">
    {!! Form::label('lastname', 'Last Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
        {!! $errors->first('lastname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}" >
    {!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6" >
        {!! Form::password('password', ['class' => 'form-control', 'required' => empty($user) ? true : false, 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,32}$', 'oninput' => "this.setCustomValidity('')", 'oninvalid' => "this.setCustomValidity('Your password is not strong. Password must contain at least 8 characters, including UPPERCASE, lowercase, numbers and special characters (!@#$%^&*_=+-) ')"]) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : ''}}" >
    {!! Form::label('confirm_password', 'Password Confirmation', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6" >
        {!! Form::password('confirm_password', ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
        <p id="password_confirmation_error_message" class="help-block"></p>
    </div>
</div>

<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    {!! Form::label('role', 'Role', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('role', json_decode('{"1": "Driver","2": "Booking Manager"}', true), null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@push('js')
    <script>
		$('#confirm_password').on('keyup', function () {
			if ($('#password').val() === $('#confirm_password').val()) {
				$('#password_confirmation_error_message').fadeOut('slow').html('Matching').css('color', 'green');
			} else
				$('#password_confirmation_error_message').fadeIn().html('Not Matching').css('color', 'red');
		});
    </script>
@endpush