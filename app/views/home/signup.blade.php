@extends('layout')

@section('scripts')
	{{HTML::script('js/signup.js')}}
	{{ HTML::script('js/ui-bootstrap-0.9.0.min.js') }}
	{{ HTML::script('js/ui-bootstrap-tpls-0.9.0.min.js') }}
@stop

@section('content')

	<?php 
		if(!isset($firstname))
			$firstname = Input::old('name');
		if(!isset($lastname))
			$lastname = Input::old('lastname');	
		if(!isset($username))
			$username = Input::old('username');
		if(!isset($password))
			$password = "";

	?>

	<div class="grid-100 grid-parent paragraphs-container white" ng-app="signup" ng-controller="SignUpController">
    	
    	<h1 style="font-size: 20px;">Create your account and start adwising</h1>

    	 {{ Form::open(array('ng-submit' => 'submit($event)', 'url' => 'users/register', 'files' => 'true', 'method' => 'post', 'name' => 'signup_form', 'id' => 'register'  )) }}
		 <input name="_token" type="hidden" value="HVbJiLi9AMSS8zHzU7mGhlvjIQhu897nPVJR4DoJ">


			<table cellpadding="10" cellspacing="10" id="register-table" style="width: 100%; table-layout: fixed;">
				
			<tr>
				<td>
					{{ Form::label('username', 'Username') }}
				</td>
				<td>
					&nbsp
				</td>
			</tr>
			<tr>
				<td> 
					{{ Form::text('username', $username, array('class' => 'form-control', 'required','ng-model' => 'username')) }}	
				</td>
				<td>
			      <label class="error-label"><?php 
			      if(isset($errors->get('username')[0]))
			      	echo $errors->get('username')[0];
			      ?></label>
			      <label class="error-label" ng-show="usernameMinLength">Username must contains at least 4 characters</label>
			      <label class="error-label" ng-show="usernameMaxLength">Username must contains at most 25 characters</label>
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('password', 'Password') }}
				</td>
			</tr>
			<tr>
				<td>
					{{ Form::password('password',  array('class' => 'form-control','ng-model' => 'password', 'value' => $password, 'required')) }}
				</td>
				<td>
					<label class="error-label"><?php 
				      if(isset($errors->get('password')[0]))
				      	echo $errors->get('password')[0];
				      else 
				      	echo "&nbsp";
				      ?></label>
				      <label class="error-label" ng-show="errorConfirmPassword">The passwords must match</label>	
				      <label class="error-label" ng-show="errorFormatPassword">The password must be between 6 and 20 characters and must contain at least one numeric digit, one uppercase and one lowercase letter</label>
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('password_confirmation', 'Confirm password') }}
				</td>
			</tr>
			<tr>
				<td>
					{{ Form::password('password_confirmation',  array('class' => 'form-control', 'required', 'ng-model' => 'password_confirm')) }}
					<label class="error-label" ng-model="errorPassword"></label>
				</td>
				<td>
					&nbsp
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('name', 'Name') }}
				</td>
			</tr>
			<tr>
				<td>
					{{ Form::text('name', $firstname, array('class' => 'form-control', 'required')) }}
				</td>
				<td>
					<label class="error-label"><?php 
				      if(isset($errors->get('name')[0]))
				      	echo $errors->get('name')[0];
				      ?></label>	
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('lastname', 'Last name') }}
				</td>
			</tr>
			<tr>
				<td>
					{{ Form::text('lastname', $lastname, array('class' => 'form-control', 'required')) }}
				</td>
				<td>
					<label class="error-label"><?php 
				      if(isset($errors->get('lastname')[0]))
				      	echo $errors->get('lastname')[0];
				      ?></label>
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('email', 'Email') }}
				</td>
			</tr>
			<tr>
				<td>
					{{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'required')) }}
				</td>
				<td>
					<label class="error-label"><?php 
				      if(isset($errors->get('email')[0]))
				      	echo $errors->get('email')[0];
				      ?></label>	
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('gender', 'Gender') }}
				</td>
			</tr>
			<tr>
				<td>
					{{ Form::radio('gender', 'male', array('checked' => 'true')) }} Male
					{{ Form::radio('gender', 'female') }} Female
				</td>
				<td>
					<label class="error-label"><?php 
				      if(isset($errors->get('gender')[0]))
				      	echo $errors->get('gender')[0];
				      ?></label>
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('birthday', 'Birthday') }}
				</td>
			</tr>
			<tr>
				<td>
					<p class="input-group">
		              <input type="text" name="birthday" class="form-control" value="{{ Input::old('birthday') }}" datepicker-popup="dd-MM-yyyy" ng-model="dt" is-open="opened" min="'01-01-1900'" max="'01-01-2020'" ng-required="true" close-text="Close" />
		              <span class="input-group-btn">
		                <button class="btn btn-default" style="margin-top: 5px;" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
		              </span>
		            </p>
				</td>
				<td>
					<label class="error-label"><?php 
				      if(isset($errors->get('birthday')[0]))
				      	echo $errors->get('birthday')[0];
				      ?></label>
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::label('image', 'Profile image') }}
				</td>
			</tr>

			<tr>
				<td>
					<input type="file" name="image" />
				</td>
				<td>
					<label class="error-label"><?php 
				      if(isset($errors->get('image')[0]))
				      	echo $errors->get('image')[0];
				      ?></label>
				</td>
			</tr>

			<tr>
				<td>
					{{ Form::submit('Create your account', array( 'class' => 'btn-primary create-account')) }}
				</td>
			</tr>

			</table>


		{{ Form::close() }}

    </div>

@stop