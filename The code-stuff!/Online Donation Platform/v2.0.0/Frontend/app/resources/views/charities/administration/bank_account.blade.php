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
				<h1>Charity Bank Account</h1>
				<p class='mb-3'>We need your charity's bank account details.</p>
			</div>
		</div>


		<div class='container pb-0'>
			<form class='auto_validate_forms col d-flex mb-4 justify-content-center' id='charities-administration-collect_bank_account' action='{{ route('charities-administration-collect_bank_account', ['charity_slug' => $charity->slug]) }}' method='POST'>
				@csrf
				<div class='card card_form form'>
					<div class='row'>


						@error('error')
							<div class='col col-12 px-0 d-flex mb-1 justify-content-center'>
								<div class='alert alert-danger w-100 mx-3'>
									<p class='m-0 p-0'>
										<i class='fas fa-exclamation-triangle'></i>
										{{ $message }}
									</p>
								</div>
							</div>
						@enderror


						<div class='col-5'>
							<label for='sort_code'>Sort code</label>

							<input class='w-100' type='text' name='sort_code' id='sort_code' maxlength='8' value='{{ old('sort_code') }}' required/>

							<div class='form_error_container' field='sort_code'>
							@error('sort_code')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-7'>
							<label for='account_number'>Account number</label>

							<input class='w-100' type='text' name='account_number' id='account_number' maxlength='8' minlength='8' value='{{ old('account_number') }}' required/>

							<div class='form_error_container' field='account_number'>
							@error('account_number')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<p class='m-0 w-100 mt-3'>
								<input type='submit' form='charities-administration-collect_bank_account' class='btn btn-block mx-0 my-0 btn-primary' value='Submit'/>
							</p>
						</div>


					</div>
				</div>
			</form>


			<div class='col py-3 text-center'>
				<p class='w-100 text-center'><a href='{{ route('charities-dashboard', ['charity_slug' => $charity->slug]) }}'>Go back</a></p>
			</div>


		</div>
	</div>
@endsection
