@include('layouts.header')
<body>
	@csrf
	<div id='app'>
		<form id='logout' action='{{ route('logout') }}' method='POST'>@csrf</form>
		@yield('modals')
		@include('layouts.navbar')
		<main>


			{{-- <div class='bg-blue w-100 min-height-100 pb-5'>
				<div class='container pt-5'> --}}
			<div class='dashboard charity_dash_cont container px-0 pb-5 d-flex min-height-99'>
				<div class='dash_nav'>

					{{-- <pre>{{ var_dump(@$charity) }}</pre> --}}

					<div class='mb-4'>
						@if (@$charity->details->logo)
							<div class='charity_logo'>
								<div class='logo filled' style='background-image: url("{{ env('S3_URL').$charity->details->logo->s3_url }}")'></div>
							</div>
						@else
							<div class='charity_logo charity_logo_fillable'>
								<div class='logo'><span>You need to upload a logo</span></div>
							</div>
						@endif
					</div>

					<h5>{{ $charity->name }}</h5>
					<p><small>Registered Charity No. {{ $charity->charity_registration_number }}</small></p>

					<hr class='mx-2'/>

					<p class='char_dash_links_public'><a href='{{ route('charities-public-homepage', ['charity_slug' => $charity->slug]) }}' target='_blank'>Go to public page</a></p>

					<hr class='mx-2'/>

					<div class='char_dash_links'>
						<p><a href='{{ route('charities-dashboard', ['charity_slug' => $charity->slug]) }}'>Dashboard</a></p>
						<p><a href='{{ route('charities-dashboard-donations', ['charity_slug' => $charity->slug]) }}'>Donations</a></p>
						<p><a href='{{ route('charities-dashboard-about', ['charity_slug' => $charity->slug]) }}'>About</a></p>
						<p><a href='{{ route('charities-dashboard-staff', ['charity_slug' => $charity->slug]) }}'>Staff</a></p>
						<p><a href='{{ route('charities-dashboard-widgets', ['charity_slug' => $charity->slug]) }}'>Websites</a></p>
					</div>
				</div>
				@yield('content')
			</div>
			@include('layouts.footer')
		</main>
	</div>
	<script type='text/javascript'>var apiURL = "{{ env('API_URL') }}"; var s3URL = "{{ env('S3_URL') }}";</script>
</body>
</html>
