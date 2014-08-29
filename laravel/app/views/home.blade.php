@extends('layout.main')


@section('content')
<FORM METHOD="LINK" ACTION="upload.html">
For admin purposes only!<br>
<INPUT TYPE="submit" VALUE="Upload Data">
</FORM>
	@if(Auth::check())
		<p>Hello, {{ Auth::user()->username }}.</p>
	@else
		<p>You are not logged in.</p>
	@endif
@stop
