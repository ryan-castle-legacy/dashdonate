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
	<div class='bg-blue w-100 min-height-100 pb-5'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>You've Been Invited</h1>
				<p class='mb-3'>{{ $inviter }} has invited you to join a charity on DashDonate.org.</p>
			</div>
		</div>
		<div class='container pb-5'>


			<form id='invite_respond_accept' action='{{ route('charities-invite-response', ['invite_token' => $invite_token]) }}' method='POST'>
				@csrf
				<input type='hidden' name='response' value='accept'/>
			</form>


			<form id='invite_respond_decline' action='{{ route('charities-invite-response', ['invite_token' => $invite_token]) }}' method='POST'>
				@csrf
				<input type='hidden' name='response' value='decline'/>
			</form>


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>


					<p class='m-0 w-100'>
						<input type='submit' form='invite_respond_accept' class='btn btn-block mx-0 my-0 btn-primary' value='Accept Invitation'/>
					</p>


					<p class='m-0 w-100 mt-3'>
						<input type='submit' form='invite_respond_decline' class='btn btn-block mx-0 my-0 btn-secondary' value='Decline Invitation'/>
					</p>


				</div>
			</div>


			<p class='m-0 mt-5 d-flex justify-content-center'><a href='{{ route('home') }}'>Return home</a></p>


		</div>
	</div>
@endsection
