<div class='dd_navigation'>

	<div class='dd_navigation_header'>
		@if (@$charity->details->logo->s3_url)
			<div class='dd_dashboard_logo'><span style='background-image: url("{{ env('S3_URL').$charity->details->logo->s3_url }}")'></span></div>
		@else
			<div class='dd_dashboard_logo empty'><span><i class='fad fa-upload'></i></span></div>
		@endif
		@if ($charity->details->display_name != '')
			<h1 class='dd_dashboard_name'>{{ $charity->details->display_name }}</h1>
		@else
			<h1 class='dd_dashboard_name'>{{ $charity->name }}</h1>
		@endif
		<p class='dd_dashboard_regnumber'>Reg. {{ $charity->charity_registration_number }}</p>
	</div>

	<a class='dd_dashboard_navlink' href='{{ route('charities-public-homepage', ['charity_slug' => $charity->slug]) }}' target='_blank'>
		<i class='fad fa-eye'></i>
		<p>Visit Public Page</p>
	</a>

	<div class='dd_dashboard_navlink_break'></div>

	@if (@$navSection == 'home')
		<a class='dd_dashboard_navlink current' href='{{ route('charities-dashboard', ['charity_slug' => $charity->slug]) }}'>
	@else
		<a class='dd_dashboard_navlink' href='{{ route('charities-dashboard', ['charity_slug' => $charity->slug]) }}'>
	@endif
		<i class='fad fa-home'></i>
		<p>Home</p>
	</a>
	@if (@$navSection == 'donations')
		<a class='dd_dashboard_navlink current' href='{{ route('charities-dashboard-donations', ['charity_slug' => $charity->slug]) }}'>
	@else
		<a class='dd_dashboard_navlink' href='{{ route('charities-dashboard-donations', ['charity_slug' => $charity->slug]) }}'>
	@endif
		<i class='fad fa-coins'></i>
		<p>Donations</p>
	</a>

	{{-- @if (@$navSection == 'fundraisers')
		<a class='dd_dashboard_navlink current' href='{{ route('charities-dashboard-fundraisers', ['charity_slug' => $charity->slug]) }}'>
	@else
		<a class='dd_dashboard_navlink' href='{{ route('charities-dashboard-fundraisers', ['charity_slug' => $charity->slug]) }}'>
	@endif
		<i class='fad fa-bullhorn'></i>
		<p>Fundraisers</p>
	</a> --}}
	@if (@$navSection == 'audience')
		<a class='dd_dashboard_navlink current' href='{{ route('charities-dashboard-audience', ['charity_slug' => $charity->slug]) }}'>
	@else
		<a class='dd_dashboard_navlink' href='{{ route('charities-dashboard-audience', ['charity_slug' => $charity->slug]) }}'>
	@endif
		<i class='fad fa-users'></i>
		<p>Audience</p>
	</a>

	<div class='dd_dashboard_navlink_break'></div>

	@if (@$navSection == 'charityInfo')
		<a class='dd_dashboard_navlink current' href='{{ route('charities-dashboard-about', ['charity_slug' => $charity->slug]) }}'>
	@else
		<a class='dd_dashboard_navlink' href='{{ route('charities-dashboard-about', ['charity_slug' => $charity->slug]) }}'>
	@endif
		<i class='fad fa-sliders-h'></i>
		<p>Charity Info</p>
	</a>
	@if (@$navSection == 'staff')
		<a class='dd_dashboard_navlink current' href='{{ route('charities-dashboard-staff', ['charity_slug' => $charity->slug]) }}'>
	@else
		<a class='dd_dashboard_navlink' href='{{ route('charities-dashboard-staff', ['charity_slug' => $charity->slug]) }}'>
	@endif
		<i class='fad fa-users-cog'></i>
		<p>Staff</p>
	</a>
	{{-- @if (@$navSection == 'settings')
		<a class='dd_dashboard_navlink current'>
	@else
		<a class='dd_dashboard_navlink'>
	@endif
		<i class='fad fa-cog'></i>
		<p>Settings</p>
	</a> --}}
</div>
