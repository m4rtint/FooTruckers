@extends('layout.temp')
@section('content')
	<div id="content" style="background-color:#ffffff;width:50%; height:100%;margin:0 auto; overflow-y: auto;" class="image image-full">
	<form action="{{ URL::route('account-register-post')}}" method="post">
		<center><br>
		<font size="5">REGISTER</font><br><br>
		<div class="field">
			Username:<br> <input type="text" name="username" {{ (Input::old('username')) ? ' value="' . e(Input::old('username')) . '"' : '' }}>
			@if($errors->has('username'))
				{{ $errors->first('username') }}
			@endif
		</div>

		
		<div class="field">
			Password:<br> <input type="password" name="password">
			@if($errors->has('password'))
				{{ $errors->first('password') }}
			@endif
		</div>

		
		<div class="field">
			Password again: <br><input type="password" name="password_again">
			@if($errors->has('password_again'))
				{{ $errors->first('password_again') }}
			@endif
		</div>
		<br>
		<input type="submit" value="Register">
		</center>
		{{ Form::token() }}
		<br>
	</form>
	</div>
@stop