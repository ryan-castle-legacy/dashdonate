@extends('layouts.main')




@section('pre-scripts')
@endsection




@section('post-scripts')

	{{-- Code to prefil email addresses (for DashDonate.org website only - This won't work on charity sites) --}}
	@if (Auth::check())
		<script>window.DashDonate=window.DashDonate||{};window.DashDonate.donor_email='{{ Auth::user()->email }}';</script>
	@endif

	@if (env('APP_ENV') == 'dev')
		<script src='{{ asset('widgets/donation.js') }}'></script>
	@else
		<script src='{{ asset('widgets/donation.min.js') }}'></script>
	@endif
	<script>window.DashDonate=window.DashDonate||{};window.DashDonate.site='{{ @$charity->api_site_id }}';</script>
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
	<link rel='stylesheet' href='{{ asset('widgets/donation.css') }}'/>
@endsection




@section('content')
	<div class='bg-blue w-100' id='make_donation'>
		<div class='container px-0 py-5 d-flex justify-content-center'>
			<div id='dd_donation_form' class='my-5'></div>
		</div>
	</div>
@endsection
