@extends('layouts.main')

@section('content')
	<div class='bg-blue w-100'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>You've Been Invited</h1>
				<p class='mb-3'>You have been invited to join '{{ $invite->charity->name }}' on DashDonate.</p>
			</div>
		</div>
		<div class='container pb-5'>
			<form id='invite_respond_accept' action='{{ route('charities-invite_staff_respond', ['invite_token' => $invite->invite_token]) }}' method='POST'>@csrf</form>
			<form id='invite_respond_decline' action='{{ route('charities-invite_staff_respond', ['invite_token' => $invite->invite_token]) }}' method='POST'>@csrf</form>
			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>

					<p class='m-0 w-100'>
						<input type='submit' form='invite_respond_accept' class='btn btn-block mx-0 my-0 btn-primary' value='Accept Invitation'/>
						<input type='hidden' form='invite_respond_accept' name='response' value='accept'/>
					</p>
					<p class='m-0 w-100 mt-3'>
						<input type='submit' form='invite_respond_decline' class='btn btn-block mx-0 my-0 btn-secondary' value='Decline Invitation'/>
						<input type='hidden' form='invite_respond_decline' name='response' value='decline'/>
					</p>

				</div>
			</div>

			<p class='m-0 mt-5 d-flex justify-content-center'><a href='{{ route('home') }}'>Return home</a></p>

		</div>
	</div>
@endsection
