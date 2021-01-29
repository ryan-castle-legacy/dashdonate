@extends('layouts.main')




@section('pre-scripts')
@endsection




@section('post-scripts')

	{{-- Code to prefil email addresses (for DashDonate.org website only - This won't work on charity sites) --}}
	@if (Auth::check())
		{{-- <script>window.DashDonate=window.DashDonate||{};window.DashDonate.donor_email='{{ Auth::user()->email }}';</script> --}}
	@endif

	@if (env('APP_ENV') == 'dev')
		<script src='{{ asset('widgets/donation.js') }}'></script>
	@else
		<script src='{{ asset('widgets/donation.min.js') }}'></script>
	@endif
	{{-- <script>window.DashDonate=window.DashDonate||{};window.DashDonate.site='{{ @$charity->api_site_id }}';</script> --}}
	<script>window.DashDonate=window.DashDonate||{};window.DashDonate.key='{{ @$charity->api_site_id }}';</script>
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
	<link rel='stylesheet' href='{{ asset('widgets/donation.css') }}'/>
@endsection




@section('content')
	<div class='w-100 d-flex align-items-center'>
		<div class='container px-0 py-5 charity_public_page'>
			<div class='col py-3 px-0 d-flex justify-content-center'>

				<div class='col-12 p-0'>

					<div class='charity_logo'>
						@if (@$charity->details->logo->s3_url)
							<div class='logo filled' style='background-image: url("{{ @env('S3_URL').$charity->details->logo->s3_url }}")'></div>
						@else
							<div class='logo'><span>You need to upload a logo</span></div>
						@endif
					</div>

					<div class='w-100 charity_details'>
						@if (@$charity->details->display_name)
							<h1 class='mb-1'>{{ $charity->details->display_name }}</h1>
						@else
							<h1 class='mb-1'>{{ $charity->name }}</h1>
						@endif

						<p class='mb-3'><small>{{ $charity->name }} is a registered charity in England and Wales ({{ $charity->charity_registration_number }})</small></p>

						<br/>

						@if ($charity->details->display_bio)
							<pre>{!! $charity->details->display_bio !!}</pre>
						@else
							<pre>Describe your charity here...</pre>
						@endif

						<a class='btn btn-primary mx-0 my-3' href='#make_donation'>Donate to us</a>

						<br/>

						<div class='row mt-3'>

							<div class='col-6'>
								<label>Contact Us</label>
								<p class='mb-0'>
									<i class='fas fa-link green_icon'></i>&nbsp;
									<a href='https://{{ $charity->details->charity_website }}' target='_blank'>{{ $charity->details->charity_website }}</a>
								</p>
								<p class='mb-0'>
									<i class='fas fa-at green_icon'></i>&nbsp;
									<a href='mailto:{{ $charity->details->charity_email }}' target='_blank'>{{ $charity->details->charity_email }}</a>
								</p>
								<p class='mb-0'>
									<i class='fas fa-phone green_icon'></i>&nbsp;
									<a href='tel:{{ $charity->details->phone_number }}' target='_blank'>{{ $charity->details->phone_number }}</a>
								</p>
							</div>

							@if ($charity->details->facebook_handle != '' ||
							$charity->details->instagram_handle 	!= '' ||
							$charity->details->twitter_handle 		!= '' ||
							$charity->details->linkedin_handle 		!= '')

								<div class='col-6'>
									<label>Social Media</label>

									@if ($charity->details->facebook_handle != '')
										<p class='mb-0'>
											<i class='fab fa-facebook-f green_icon'></i>&nbsp;
											<a href='https://www.facebook.com/{{ $charity->details->facebook_handle }}' target='_blank'>{{ $charity->details->facebook_handle }}</a>
										</p>
									@endif
									@if ($charity->details->instagram_handle != '')
										<p class='mb-0'>
											<i class='fab fa-instagram green_icon'></i>&nbsp;
											<a href='https://instagram.com/{{ $charity->details->instagram_handle }}' target='_blank'>{{ $charity->details->instagram_handle }}</a>
										</p>
									@endif
									@if ($charity->details->twitter_handle != '')
										<p class='mb-0'>
											<i class='fab fa-twitter green_icon'></i>&nbsp;
											<a href='https://twitter.com/{{ $charity->details->twitter_handle }}' target='_blank'>{{ $charity->details->twitter_handle }}</a>
										</p>
									@endif
									@if ($charity->details->linkedin_handle != '')
										<p class='mb-0'>
											<i class='fab fa-linkedin green_icon'></i>&nbsp;
											<a href='https://www.linkedin.com/company/{{ $charity->details->linkedin_handle }}' target='_blank'>{{ $charity->details->linkedin_handle }}</a>
										</p>
									@endif
								</div>
							@endif

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class='bg-blue w-100' id='make_donation'>
		<div class='container px-0 py-5 d-flex justify-content-center'>
			{{-- <div id='dd_donation_form' class='my-5'></div> --}}
			<div id='dd_widget'></div>
		</div>
	</div>
	{{-- <hero class='bg-blue w-100'>
		<div class='container py-0 py-5'>
			<div class='col text-center'>
				<div class='mb-4 w-100 d-flex justify-content-center'>
					@if (@$charity->details->logo)
						<div class='charity_logo'>
							<div class='logo filled' style='background-image: url("{{ env('S3_URL').$charity->details->logo->s3_url }}")'></div>
						</div>
					@endif
				</div>
				@if (@$charity->details->display_name)
					<h1 class='hero mb-3'>{{ $charity->details->display_name }}</h1>
				@else
					<h1 class='hero mb-3'>{{ $charity->name }}</h1>
				@endif
				<p class='mb-0'><small>{{ $charity->name }} is a registered charity in England and Wales ({{ $charity->charity_registration_number }})</small></p>
			</div>
		</div>
		<div class='container py-0 pb-5'>
			<div class='col text-center'>
				<div id='dd_donation_form'></div>
			</div>
		</div>
	</hero> --}}
@endsection
