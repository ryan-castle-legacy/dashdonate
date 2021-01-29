@extends('layouts.main')

@section('content')
	<div class='bg-blue w-100'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>Register your Charity</h1>
				<p class='mb-3'>Tell us a little bit about your charity.</p>
			</div>
		</div>
		<div class='container pb-5'>
			<form id='form_submit_charity_reg_form' action='{{ route('charities-register') }}' method='POST'>@csrf</form>
			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>

					<div>
						<label for='country'>Select country</label>
						<select name='country' form='form_submit_charity_reg_form' id='country' disabled/>
							<option default selected value='United Kingdom'>United Kingdom</option>
						</select>
					</div>

					<div>
						<label for='charity_name'>Charity name</label>
						<input class='w-100' form='form_submit_charity_reg_form' type='text' name='charity_name' id='charity_name' value='{{ old('charity_name') }}' required/>
						<p class='form_error_message' for='charity_name'>A charity name is required.</p>
					</div>

					<div>
						<label for='charity_reg'>Charity registration no.<br/><small>(we currently only support charities registered in England and Wales)</small></label>
						<input class='w-100' form='form_submit_charity_reg_form' type='text' name='charity_reg' id='charity_reg' value='{{ old('charity_reg') }}' required/>
						<p class='form_error_message' for='charity_reg'>A charity registration number is required.</p>
					</div>

					<div class='mt-3'>
						<a class='btn btn-primary m-0 w-100' id='submit_charity_reg_form'>
							<i class='spinner fas fa-circle-notch'></i>
							Register Charity
						</a>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
