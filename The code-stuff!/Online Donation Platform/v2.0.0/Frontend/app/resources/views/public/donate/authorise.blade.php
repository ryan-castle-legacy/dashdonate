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
	<hero class='bg-blue w-100 min-height-100 d-flex align-items-center pb-5' task='{{ $task->task_token }}'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1>Authorise Your Donation</h1>
				<p class='mb-3'>You need to authorise your donation of <strong>&pound;{{ number_format($task->amount / 100, 2) }}</strong> to <strong>{{ $task->charity->name }}</strong>.</p>

				<iframe id='iframe_3ds_verify_donation' class='my-3' src='{{ @$intent->next_action->use_stripe_sdk->stripe_js }}'></iframe>

				<div class='d-none m-0 mt-5' id='success'>
					<h4>Thank You</h4>
					<p>Your donation has been taken.</p>
					<p><a href='{{ route('public-dashboard') }}' class='btn mt-2 btn-primary'>My dashboard</a></p>
				</div>

				<div class='d-none m-0 mt-5' id='error'>
					<h4>Donation Unsuccessful</h4>
					<p>We were unable to take your donation.</p>
					<p><a href='{{ route('public-dashboard-donations') }}' class='btn mt-2 btn-primary'>Manage my donations</a></p>
				</div>

			</div>
		</div>
	</hero>
@endsection
