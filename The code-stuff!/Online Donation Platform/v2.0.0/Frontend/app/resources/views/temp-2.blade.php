@extends('layouts.main')




@section('pre-scripts')
@endsection




@section('post-scripts')
	<script src='{{ asset('widgets/donation-2.js') }}'></script>
	<script>window.DashDonate=window.DashDonate||{};window.DashDonate.key='{{ @$charity->api_site_id }}';</script>
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
	<link rel='stylesheet' href='{{ asset('widgets/donation-2.css') }}'/>
@endsection




@section('content')
	<div class='bg-blue w-100' id='make_donation'>
		<div class='container px-0 py-5 d-flex justify-content-center'>
			<div id='dd_widget'></div>
		</div>
	</div>
@endsection
