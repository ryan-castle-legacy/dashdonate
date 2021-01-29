@extends('layouts.main')

@section('content')
	<div class='flex-middle bg-blue min-height-100'>
		<div class='container w-100 flex-middle'>
			<div class='col py-3'>
				<div class='row'>
					<div class='col align-center flex-middle'>
						<h1 class='mb-0'>Join Us</h1>
						<p>Register your charity on DashDonate.org</p>
					</div>
				</div>
				<div class='row align-center flex-middle'>
					<div class='card login_card'>
						<form method='POST' class='col' action='{{ route('charity-register') }}'>
							@csrf
							<label for='country'>Select country <small>(We currently only support charities in the United Kingdom)</small></label>
							<select name='country' id='country' disabled/>
								<option default selected value='United Kingdom'>United Kingdom</option>
							</select>
							<label for='charity_name'>Charity name</label>
							<input type='text' name='charity_name' id='charity_name'/>
							<label for='charity_registration_number' class='flex-apart'>UK Charity Reg. No</label>
							<input type='text' name='charity_registration_number' id='charity_registration_number'/>
							<input type='submit' class='btn btn-primary mt-1 ml-0 mr-0 mb-0' value='Continue'/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
