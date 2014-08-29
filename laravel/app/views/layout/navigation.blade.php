		
		
		@if(Auth::check())
			@if(Request::url()== 'http://wheremynomsat.com')
			<li class = "current_page_item"><a href="{{ URL::route('home') }}">Home</a></li>
			<li><a href="{{ URL::route('table') }}">Browse</a></li>
			<li><a href="{{ URL::route('favorite') }}">My Favorite Vendors</a></li>
			<li><a href="{{ URL::route('account-logout') }}">Logout</a></li>
			@endif
			
			@if(Request::url()== 'http://wheremynomsat.com/table')
			<li><a href="{{ URL::route('home') }}">Home</a></li>
			<li class = "current_page_item"><a href="{{ URL::route('table') }}">Browse</a></li>
			<li><a href="{{ URL::route('favorite') }}">My Favorite Vendors</a></li>
			<li><a href="{{ URL::route('account-logout') }}">Logout</a></li>
			@endif
			
			@if(Request::url()== 'http://wheremynomsat.com/favourite')
			<li><a href="{{ URL::route('home') }}">Home</a></li>
			<li><a href="{{ URL::route('table') }}">Browse</a></li>
			<li class = "current_page_item"><a href="{{ URL::route('favorite') }}">My Favorite Vendors</a></li>
			<li><a href="{{ URL::route('account-logout') }}">Logout</a></li>
			@endif
			
		@else
			@if(Request::url()== 'http://wheremynomsat.com')
			<li class = "current_page_item"><a href="{{ URL::route('home') }}">Home</a></li>
			<li><a href="{{ URL::route('table') }}">Browse</a></li>
			<li><a href="{{ URL::route('account-login') }}">Login</a></li>
			<li><a href="{{ URL::route('account-register') }}">Register</a></li>
			@endif
			
			@if(Request::url()== 'http://wheremynomsat.com/table')
			<li><a href="{{ URL::route('home') }}">Home</a></li>
			<li class = "current_page_item"><a href="{{ URL::route('table') }}">Browse</a></li>
			<li><a href="{{ URL::route('account-login') }}">Login</a></li>
			<li><a href="{{ URL::route('account-register') }}">Register</a></li>
			@endif
			
			@if(Request::url()== 'http://wheremynomsat.com/account/login')
			<li><a href="{{ URL::route('home') }}">Home</a></li>
			<li><a href="{{ URL::route('table') }}">Browse</a></li>
			<li class = "current_page_item"><a href="{{ URL::route('account-login') }}">Login</a></li>
			<li><a href="{{ URL::route('account-register') }}">Register</a></li>
			@endif
			
			@if(Request::url()== 'http://wheremynomsat.com/account/register')
			<li><a href="{{ URL::route('home') }}">Home</a></li>
			<li><a href="{{ URL::route('table') }}">Browse</a></li>
			<li><a href="{{ URL::route('account-login') }}">Login</a></li>
			<li class = "current_page_item"><a href="{{ URL::route('account-register') }}">Register</a></li>
			@endif
		@endif	
		
	
		
		