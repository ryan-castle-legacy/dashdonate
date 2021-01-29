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
				<h1>Reset Your Password</h1>
				<p class='mb-3'>Use your email address to reset your password.</p>
			</div>
		</div>
		<form class='auto_validate_forms' id='public-forgot_password' action='{{ route('forgot-password') }}' method='POST' class='container pb-5'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12'>
							<label for='email'>Email address</label>

							<input class='w-100' form='public-forgot_password' type='email' name='email' id='email' value='{{ old('email') }}' required/>

							<div class='form_error_container' field='email'>
							@error('email')
								<p>{{ $message }}</p>
							@enderror
							</div>

							@if(session('success'))
								<div class='form_success_container'>
									<p>{{ session('success') }}</p>
								</div>
							@enderror
						</div>


						<div class='col-12 mt-3'>
							<input type='submit' class='btn btn-block btn-primary mx-0 mb-0' form='public-forgot_password' value='Reset Password'/>
						</div>


					</div>
				</div>
			</div>

			<div class='col-12 text-center m-0'>
				<a href='' class='btn btn-link'>Back to login</a>
			</div>

		</form>
	</div>

@endsection
