@extends('layout.temp')

@section('content')
<div id="content" style="background-color:#ffffff;width:50%; height:100%;margin:0 auto; overflow-y: auto;" class="image image-full">
	<form action="{{ URL::route('account-login-post') }}" method="post">
		<center>
		<div style="height:300px; width:260px">
		<br><br>
		<font size="5">LOGIN</font><br><br>
		<div class="field">
			Username:<br><input type="text" name="username" {{ (Input::old('username')) ? ' value="' . e(Input::old('username')) . '"' : '' }}>
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
		<br>
		<input type="submit" value="Login">
		</center>
		</div>
		{{ Form::token() }}
	</form>
</div>
@stop