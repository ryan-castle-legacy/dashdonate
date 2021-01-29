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
				<h1>For Donors</h1>
				<p class='mb-3'>Page to entice donors</p>
			</div>
			<div class='col py-3 text-center'>


				<a class='btn btn-primary' href='{{ route('public-onboarding-register') }}'>Create Donor Account</a>


			</div>
		</div>
	</hero> --}}
	<hero class='bg-blue w-100'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h4>What is a charity's biggest challenge?</h4>
				<h1 class='hero mb-5'>Fundraising.</h1>
				<p class='mb-0'>We are here to fix that.</p>
				<a class='btn btn-primary mb-0 mt-3' href='{{ route('public-search-charities') }}'>Search our charities</a>
				@if (!Auth::check())
					<a class='btn btn-primary mb-0 mt-3' href='{{ route('public-onboarding-register') }}'>Register as a Donor</a>
				@endif
			</div>
		</div>
	</hero>
	<div>
		<div class='container py-5 px-0 public_page'>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Donations done your way</strong></h4>
				</div>
				<div class='col-8'>
					<p>Let's say you want to donate to the homeless in winter, and drought charities in the summer. Or let's say you want to remember a deceased loved one on their birthday - we have you covered.</p>
					<p>Whatever routine or style of donation you want to take, we have a simple and easy way to make sure you are fully in control of your donations.</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Transparency all-round</strong></h4>
					<p>Coming soon!</p>
				</div>
				<div class='col-8'>
					<p>We ensure that all of our charities are transparent about where their donations are going. We give them a score, so that you don't have to interpret complicated charts or figures.</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>No spam, ever</strong></h4>
				</div>
				<div class='col-8'>
					<p>Nope, no marketing emails from from charities, only a weekly digest (if you want it).</p>
					<p>We know it can be annoying to get pestered by marketing emails, so we've locked all charity updates into a simple news feed on DashDonate.org - you receive donation information when you want it, not when you don't.</p>
				</div>
			</div>
		</div>
	</div>
@endsection
