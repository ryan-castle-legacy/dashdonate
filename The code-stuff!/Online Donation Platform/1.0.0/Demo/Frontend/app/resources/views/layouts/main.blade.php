<!DOCTYPE html>
<html lang='en-gb'>
<head>
	<meta charset='utf-8'/>
	<meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no'/>
	<meta name='csrf-token' content='{{ csrf_token() }}'/>
	@if (isset($page_title))
		<title>DashDonate.org - {{ $page_title }}</title>
	@else
		<title>DashDonate.org - A better way to donate.</title>
	@endif
	<link rel='icon' type='image/png' href='{{ asset('favicon.png') }}'/>
	@yield('pre-scripts')
	<script src='{{ asset('js/jquery.js') }}' type='text/javascript'></script>
	<script src='{{ asset('js/bootstrap.js') }}' type='text/javascript'></script>
	<script src='{{ asset('js/dashdonate.js') }}' type='text/javascript'></script>
	@yield('post-scripts')
	@yield('pre-styles')
	<link href='{{ asset('css/bootstrap.min.css') }}' rel='stylesheet' type='text/css'/>
	<link href='{{ asset('css/fontawesome.min.css') }}' rel='stylesheet' type='text/css'/>
	<link href='{{ asset('css/dashdonate.css') }}' rel='stylesheet' type='text/css'/>
	@yield('post-styles')

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162206655-1"></script>
	<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','UA-162206655-1');</script>

</head>
<body>
	<div id='app'>
		{{-- <nav>
			{{-- <form id='search_site' action='{{ route('public-search_submit', ['type' => 'all']) }}' method='POST'>@csrf</form> --}}
			{{-- <form id='logout' action='{{ route('logout') }}' method='POST'>@csrf</form> --}}{{--
			<div class='container nav_container nav_fresh'>
				{{-- @if (Auth::check())
					<a href='{{ route('home') }}' class='nav_logo'></a>
				@else --}}{{--
					<a href='{{ route('public-home') }}' class='nav_logo'></a>
				{{-- @endif --}}
				{{-- <div id='search_btn' class='btn btn-link'>
					<a href='{{ route('public-search', ['type' => 'all']) }}' class='search_btn'>
						<i class='fas fa-search ml-0 my-0 label'></i>
						Search
					</a>
					<input type='text' class='form-control' form='search_site' name='nav_search_query' placeholder='Search for charities, fundraisers, and more'/>
					<button class='btn btn-submit' type='submit' form='search_site'>Search</button>
				</div> --}}
				{{-- <div class='dropdown-container' state='closed'>
					<div class='btn btn-link mr-0 ml-0 dropdown-trigger'>
						For Charities
						<small><i class='fas fa-chevron-down mr-0'></i></small>
					</div>
					<div class='dropdown-menu'>
						@if (Auth::check())
							<a href='{{ route('charity-register') }}' class='dropdown-link'>Register a Charity</a>
							@if (@Auth::user()->user_charities > 0)
								<a href='{{ route('public-for_charities') }}' class='dropdown-link'>My Charities</a>
							@endif
							<hr/>
							<a href='{{ route('public-for_charities') }}' class='dropdown-link'>How we can Help</a>
							<a href='{{ route('public-refer_charity') }}' class='dropdown-link'>Refer a Charity</a>
						@else
							<a href='{{ route('charity-register') }}' class='dropdown-link'>Register a Charity</a>
							<hr/>
							<a href='{{ route('public-for_charities') }}' class='dropdown-link'>How we can Help</a>
							<a href='{{ route('public-refer_charity') }}' class='dropdown-link'>Refer a Charity</a>
						@endif
					</div>
				</div> --}}{{--
				<a href='{{ route('public-for_donors') }}' class='btn btn-link mr-0 ml-0'>For Donors</a>
				<a href='{{ route('public-for_charities') }}' class='btn btn-link mr-0 ml-0'>For Charities</a>
				{{-- <div class='dropdown-container' state='closed'>
					<div class='btn btn-link mr-0 ml-0 dropdown-trigger'>
						For Donors
						<small><i class='fas fa-chevron-down mr-0'></i></small>
					</div>
					<div class='dropdown-menu'>
						@if (Auth::check())
							<a href='{{ route('user-my_donations') }}' class='dropdown-link'>Manage my Donations</a>
							<hr/>
							<a href='{{ route('public-search', ['type' => 'charities']) }}' class='dropdown-link'>Search for a Charity</a>
							<a href='{{ route('public-search', ['type' => 'fundraisers']) }}' class='dropdown-link'>Search for Fundraisers</a>
							<hr/>
							<a href='{{ route('charity-fundraise_for') }}' class='dropdown-link'>Fundraise for a Charity</a>
							<a href='{{ route('public-refer_charity') }}' class='dropdown-link'>Refer a Charity</a>
							<hr/>
							<a href='{{ route('public-for_donors') }}' class='dropdown-link'>Donation on your terms</a>
						@else
							<a href='{{ route('public-search', ['type' => 'charities']) }}' class='dropdown-link'>Search for a Charity</a>
							<a href='{{ route('public-search', ['type' => 'fundraisers']) }}' class='dropdown-link'>Search for Fundraisers</a>
							<hr/>
							<a href='{{ route('charity-fundraise_for') }}' class='dropdown-link'>Fundraise for a Charity</a>
							<a href='{{ route('public-refer_charity') }}' class='dropdown-link'>Refer a Charity</a>
							<hr/>
							<a href='{{ route('public-for_donors') }}' class='dropdown-link'>Donation on your terms</a>
							<a href='{{ route('register') }}' class='dropdown-link'>Join as a donor</a>
						@endif
					</div>
				</div> --}}{{--
				<a href='{{ route('public-about_dashdonate') }}' class='btn btn-link'>Our Story</a>

				<a href='{{ route('public-get_involved') }}' class='ml-2 btn btn-primary'>Get Involved</a>

				{{-- @if (Auth::check())
					<div class='dropdown-container' state='closed'>
						<div class='btn btn-link mr-0 ml-2 dropdown-trigger'>
							{{ Auth::user()->name }}
							<small><i class='fas fa-chevron-down mr-0'></i></small>
						</div>
						<div class='dropdown-menu'>
							<a href='{{ route('account-my_profile') }}' class='dropdown-link'>My Profile</a>
							<a href='{{ route('account-settings') }}' class='dropdown-link'>Account Settings</a>
							<a href='{{ route('payment-settings') }}' class='dropdown-link'>Payment Settings</a>
							@if (@Auth::user()->is_admin == true)
								<hr/>
								<a href='{{ route('admin-userlist') }}' class='dropdown-link'>User List</a>
								<a href='{{ route('admin-donationlist') }}' class='dropdown-link'>Donation List</a>
								<a href='{{ route('admin-charitylist') }}' class='dropdown-link'>Charity List</a>
								<a href='{{ route('admin-error_log') }}' class='dropdown-link'>Error Log</a>
							@endif
							<hr/>
							<button type='submit' form='logout' class='dropdown-link'>Log out</button>
						</div>
					</div>
				@else
					<a href='{{ route('login') }}' class='btn btn-link ml-2'>Login</a>
					<a href='{{ route('register') }}' class='btn btn-primary mr-0'>Register</a>
				@endif --}}{{--
			</div>
		</nav> --}}
		<nav>
			<div class='nav_container navbar'>
				<a href='{{ route('public-home') }}' class='nav_logo'></a>
				<div class='col-12 p-0 justify-content-end d-none d-md-flex'>
					<a href='{{ route('public-for_donors') }}' class='btn btn-link'>For Donors</a>
					<a href='{{ route('public-for_charities') }}' class='btn btn-link'>For Charities</a>
					<a href='{{ route('public-about_dashdonate') }}' class='btn btn-link'>Our Story</a>
					<a href='{{ route('public-get_involved') }}' class='btn btn-primary ml-3'>Get Involved</a>
				</div>
				<div class='col-12 p-0 justify-content-end d-flex d-md-none'>
					<a class='btn btn-primary ml-3' id='mobi_nav_trigger'><i class='fas fa-bars'></i></a>
				</div>
			</div>
		</nav>
		<div class='navbar-collapse collapse' id='mobi_nav'>
			<div class='col-12 d-flex flex-column'>
				<a href='{{ route('public-for_donors') }}' class='btn btn-link'>For Donors</a>
				<a href='{{ route('public-for_charities') }}' class='btn btn-link'>For Charities</a>
				<a href='{{ route('public-about_dashdonate') }}' class='btn btn-link'>Our Story</a>
				<a href='{{ route('public-get_involved') }}' class='btn btn-primary'>Get Involved</a>
			</div>
		</div>
		<main>
			@yield('content')
			<footer>
				<div class='container justify-content-between py-3'>
					<div class='row'>
						<div class='col-6 py-3'>
							<p class='footer_logo'></p>
							<p>&copy; {{ date('Y', time()) }} DashDonate.org</p>
							<p>All rights reserved</p>
							<br/>
							<p>DashDonate Ltd t/a DashDonate.org</p>
							<p>Company No. 12533371</p>
						</div>
						<div class='col-6 py-3 text-right'>
							<p class='socials text-right'>
								<a href='https://www.facebook.com/dashdonate/' target='_blank'><i class='fab fa-facebook-square'></i></a>
								<a href='https://twitter.com/dashdonate' target='_blank'><i class='fab fa-twitter'></i></a>
								<a href='https://www.instagram.com/dashdonate/' target='_blank'><i class='fab fa-instagram'></i></a>
							</p>
							</br>
							<p>Get in touch</p>
							<p class='opa-1'><a href='mailto:info@dashdonate.org' class='email_link' target='_blank'>info@dashdonate.org</a></p>
							<br/>
							<p>DashDonate Ltd, 5 McMillan Close</p>
							<p>Saltwell Business Park, Gateshead</p>
							<p>United Kingdom, NE9 5BF</p>
						</div>
					</div>
					{{-- <div class='col-6 d-flex  flex-sm-column'>
						<p class='footer_logo'></p>
						<p>&copy; {{ date('Y', time()) }} DashDonate.org</p>
						<p>All rights reserved</p>
						<br/>
						<p>DashDonate Ltd t/a DashDonate.org</p>
						<p>Company No. 12533371</p>
					</div>
					<div class='col-6 text-right'>
						<p class='socials text-right'>
							<a href='https://www.facebook.com/dashdonate/' target='_blank'><i class='fab fa-facebook-square'></i></a>
							<a href='https://twitter.com/dashdonate' target='_blank'><i class='fab fa-twitter'></i></a>
							<a href='https://www.instagram.com/dashdonate/' target='_blank'><i class='fab fa-instagram'></i></a>
						</p>
						</br>
						<p>Get in touch</p>
						<p class='opa-1'><a href='mailto:info@dashdonate.org' class='email_link' target='_blank'>info@dashdonate.org</a></p>
						<br/>
						<p>DashDonate Ltd, 5 McMillan Close</a>
						<p>Saltwell Business Park, Gateshead</a>
						<p>United Kingdom, NE9 5BF</a>
					</div> --}}
				</div>
			</footer>
		</main>
	</div>
</body>
</html>
