@extends('layouts.main')




@section('pre-scripts')
@endsection




@section('post-scripts')
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
@endsection




@section('content')
	{{-- <hero class='bg-blue w-100 min-height-100 d-flex align-items-center pb-5'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1>DashDonate.org</h1>
				<p class='mb-3'>Landing page - More coming soon, please be patient</p>
			</div>
			<div class='col py-3 text-center'>


				<a class='btn btn-primary' href='{{ route('public-onboarding-register') }}'>Create Donor Account</a>

				<a class='btn btn-primary' href='{{ route('charities-onboarding-landing') }}'>Register Charity</a>


			</div>
		</div>
	</hero> --}}
	<hero class='bg-blue w-100 min-height-100'>
		<div class='container py-5 min-height-100 d-flex align-content-center public_page'>
			<div class='col py-3 text-center d-flex flex-column justify-content-center'>
				<h1 class='hero'>Let's do something amazing together</h1>
				<p class='mb-2'>With more transparency, better control over your donations, and greater connection to the causes you care about - help us make fundraising more rewarding for everyone.</p>

				<p class='mb-5'>
					<a href='{{ route('public-onboarding-landing') }}' class='btn mt-5 btn-primary'>For Donors</a>
					<a href='{{ route('charities-onboarding-landing') }}' class='btn mt-5 btn-primary'>For Charities</a>
					<a href='{{ route('public-onboarding-our_story') }}' class='btn mt-5 btn-primary'>Our Story</a>
				</p>

				<p class='mb-0'>Share us on social media</p>
				<p class='socials center mt-2 mb-0'>
					<a href='https://www.facebook.com/dashdonate/' target='_blank'><i class='fab fa-facebook'></i></a>
					<a href='https://twitter.com/dashdonate' target='_blank'><i class='fab fa-twitter'></i></a>
					<a href='https://www.instagram.com/dashdonate/' target='_blank'><i class='fab fa-instagram'></i></a>
					<a href='https://www.linkedin.com/company/dashdonate/' target='_blank'><i class='fab fa-linkedin'></i></a>
				</p>

			</div>
		</div>
	</div>
@endsection
