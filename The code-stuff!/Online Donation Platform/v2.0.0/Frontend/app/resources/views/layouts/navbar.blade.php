<nav class='navbar navbar-expand-md'>
	<a class='logo' href='{{ route('home') }}'></a>

	<ul class='navbar-nav'>

		<li class='nav-item dropdown'>
			<a class='nav-link dropdown-toggle' id='navbar_forDonors' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>For Donors<i class='fas fa-chevron-down'></i></a>

			<div class='dropdown-menu' aria-labelledby='navbar_forDonors'>

				<a class='dropdown-item' href='{{ route('public-search-charities') }}'>Search our charities</a>
				<a class='dropdown-item' href='{{ route('public-onboarding-landing') }}'>How we are different</a>

				@if (Auth::check())
					<hr class='my-2'/>
					<a class='dropdown-item' href='{{ route('public-dashboard') }}'>Donor dashboard</a>
					<a class='dropdown-item' href='{{ route('public-dashboard-donations') }}'>My donations</a>
				@endif

			</div>
		</li>


		<li class='nav-item dropdown'>
			<a class='nav-link dropdown-toggle' id='navbar_forCharities' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>For Charities<i class='fas fa-chevron-down'></i></a>

			<div class='dropdown-menu' aria-labelledby='navbar_forCharities'>

				<a class='dropdown-item' href='{{ route('charities-onboarding-landing') }}'>DashDonate.org for charities</a>
				<a class='dropdown-item' href='{{ route('charities-onboarding-get_started') }}'>Register my charity</a>

				{{-- Check if user is logged in --}}
				@if (Auth::check())
					{{-- Get connected charities --}}
					@php $connected_charities = Auth::user()->getCharitiesConnected(); @endphp
					{{-- Check if there were charities found --}}
					@if (gettype($connected_charities) == 'array' && sizeof($connected_charities) > 0)
						<hr class='my-2'/>
						<p class='m-0 mb-1 px-3'><small>My charities</small></p>
						{{-- Loop through charities --}}
						@for ($view_x = 0; $view_x < sizeof($connected_charities); $view_x++)
							<a class='dropdown-item' href='{{ route('charities-dashboard', ['charity_slug' => $connected_charities[$view_x]->slug]) }}'>{{ $connected_charities[$view_x]->name }}</a>
						@endfor
					@endif
				@endif

			</div>
		</li>


		<li class='nav-item'>
			<a class='nav-link' href='{{ route('public-onboarding-our_story') }}'>Our Story</a>
		</li>


		{{-- Check if user is logged in --}}
		@if (Auth::check())

			{{-- Work out label to display for user --}}
			@php
				// Default value
				$view_x = 'Your Account';
				// Check if user has a name set
				if (Auth::user()->name != '') {
					// Set label as name
					$view_x = Auth::user()->name;
				}
			@endphp

			<li class='nav-item dropdown'>
				<a class='nav-link dropdown-toggle' id='navbar_account' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>{{ $view_x }}<i class='fas fa-chevron-down'></i></a>

				<div class='dropdown-menu' aria-labelledby='navbar_account'>

					<a class='dropdown-item' href='{{ route('public-account') }}'>Account settings</a>
					<a class='dropdown-item' href='{{ route('logout') }}'>Log out</a>

					{{-- Check if user is an administrator --}}
					@if (Auth::user()->isAdmin())
						<hr class='my-2'/>
						<a class='dropdown-item' href='{{ route('admin-data_dump', ['type' => 'users']) }}'>User List</a>
						<a class='dropdown-item' href='{{ route('admin-charity_approval') }}'>Charity Approval</a>
						<a class='dropdown-item' href='{{ route('admin-representatives_approval') }}'>Representative Approval</a>
						<a class='dropdown-item' href='{{ route('admin-data_dump', ['type' => 'widget-sessions']) }}'>Widget Sessions</a>
					@endif

				</div>
			</li>

		@else

			<li class='nav-item ml-3'>
				<a class='nav-link btn-link' href='{{ route('login') }}'>Login</a>
			</li>
			<li class='nav-item ml-1'>
				<a class='nav-link btn-primary' href='{{ route('public-onboarding-register') }}'>Register</a>
			</li>

		@endif

	</ul>

</nav>




<nav class='navbar mobile_navbar'>
	<a class='logo' href='{{ route('home') }}'></a>

	<a class='navbar-toggler' id='mobile_navbar_toggle'>
		<i class='fas fa-bars'></i>
		<i class='fas fa-times'></i>
	</a>

	<div class='navbar' id='navbar_mobile'>
		<ul class='navbar-nav mobile_main'>

			<li class='nav-item'>
				<a class='nav-link' dropdown_target='mobile_nav_forDonors'>For Donors<i class='fas fa-chevron-down'></i></a>
			</li>

			<li class='nav-item'>
				<a class='nav-link' dropdown_target='mobile_nav_forCharities'>For Charities<i class='fas fa-chevron-down'></i></a>
			</li>

			<li class='nav-item'>
				<a class='nav-link' href='{{ route('public-onboarding-our_story') }}'>Our Story</a>
			</li>

			{{-- Check if user is logged in --}}
			@if (Auth::check())

				{{-- Work out label to display for user --}}
				@php
					// Default value
					$view_x = 'Your Account';
					// Check if user has a name set
					if (Auth::user()->name != '') {
						// Set label as name
						$view_x = Auth::user()->name;
					}
				@endphp

				<li class='nav-item'>
					<a class='nav-link' dropdown_target='mobile_nav_account'>{{ $view_x }}<i class='fas fa-chevron-down'></i></a>
				</li>

			@else

				<li class='nav-item mt-3 px-2'>
					<a class='nav-link btn-link' href='{{ route('login') }}'>Login</a>
				</li>
				<li class='nav-item mt-1 px-2'>
					<a class='nav-link btn-primary' href='{{ route('public-onboarding-register') }}'>Register</a>
				</li>

			@endif

		</ul>


		<ul class='navbar-nav' target_dropdown='mobile_nav_forDonors'>

			<li class='nav-item'>
				<a class='nav-link' href='{{ route('public-search-charities') }}'>Search our charities</a>
			</li>

			<li class='nav-item'>
				<a class='nav-link' href='{{ route('public-onboarding-landing') }}'>How we are different</a>
			</li>

			@if (Auth::check())
				<hr class='my-2'/>

				<li class='nav-item'>
					<a class='nav-link' href='{{ route('public-dashboard') }}'>Donor dashboard</a>
				</li>

				<li class='nav-item'>
					<a class='nav-link' href='{{ route('public-dashboard-donations') }}'>My donations</a>
				</li>

			@endif

			<hr class='my-2'/>

			<li class='nav-item'>
				<a class='nav-link back_to_mobile_main'><i class='fas fa-chevron-left'></i> Go back</a>
			</li>

		</ul>


		<ul class='navbar-nav' target_dropdown='mobile_nav_forCharities'>

			<li class='nav-item'>
				<a class='nav-link' href='{{ route('charities-onboarding-landing') }}'>DashDonate.org for charities</a>
			</li>

			<li class='nav-item'>
				<a class='nav-link' href='{{ route('charities-onboarding-get_started') }}'>Register my charity</a>
			</li>

			{{-- Check if user is logged in --}}
			@if (Auth::check())
				{{-- Get connected charities --}}
				@php $connected_charities = Auth::user()->getCharitiesConnected(); @endphp
				{{-- Check if there were charities found --}}
				@if (gettype($connected_charities) == 'array' && sizeof($connected_charities) > 0)
					<hr class='my-2'/>
					<p class='m-0 mb-1 px-3 text-center w-100'><small>My charities</small></p>
					{{-- Loop through charities --}}
					@for ($view_x = 0; $view_x < sizeof($connected_charities); $view_x++)
						<li class='nav-item'>
							<a class='nav-link' href='{{ route('charities-dashboard', ['charity_slug' => $connected_charities[$view_x]->slug]) }}'>{{ $connected_charities[$view_x]->name }}</a>
						</li>
					@endfor
				@endif
			@endif

			<hr class='my-2'/>

			<li class='nav-item'>
				<a class='nav-link back_to_mobile_main'><i class='fas fa-chevron-left'></i> Go back</a>
			</li>

		</ul>


		@if (Auth::check())
			<ul class='navbar-nav' target_dropdown='mobile_nav_account'>

				{{-- <li class='nav-item'>
					<a class='nav-link' href='{{ route('public-account') }}'>Account Settings</a>
				</li> --}}

				<li class='nav-item'>
					<a class='nav-link' href='{{ route('public-account') }}'>Account settings</a>
					<a class='nav-link' href='{{ route('logout') }}'>Log out</a>
				</li>

				{{-- Check if user is an administrator --}}
				@if (@Auth::user()->isAdmin())
					<hr class='my-2'/>
					<li class='nav-item'>
						<a class='nav-link' href='{{ route('admin-data_dump', ['type' => 'users']) }}'>User List</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='{{ route('admin-charity_approval') }}'>Charity Approval</a>
					</li>
				@endif

				<hr class='my-2'/>

				<li class='nav-item'>
					<a class='nav-link back_to_mobile_main'><i class='fas fa-chevron-left'></i> Go back</a>
				</li>

			</ul>
		@endif







	</div>

</nav>
