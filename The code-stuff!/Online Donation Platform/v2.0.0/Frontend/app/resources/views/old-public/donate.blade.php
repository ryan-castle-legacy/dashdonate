@extends('layouts.main')

@section('content')
	<hero class='bg-blue w-100 min-height-100 d-flex align-items-center'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<div id='dd_donation_form'></div>
			</div>
		</div>
	</hero>
@endsection


@section('post-scripts')
	<script src='{{ asset('widgets/donation.js') }}'></script>
	<script>window.DashDonate=window.DashDonate||{};window.DashDonate.site='DD-1234';</script>
@endsection


@section('pre-styles')
	<link rel='stylesheet' href='{{ asset('widgets/donation.css') }}'/>
@endsection
