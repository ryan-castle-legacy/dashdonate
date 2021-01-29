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
				<h1>Charity Goals</h1>
				<p class='mb-3'>Let us know what your charity's goals are.</p>
			</div>
		</div>
		<div class='container pb-5'>
			<form class='auto_validate_forms' id='charities-onboarding-goals' action='{{ route('charities-onboarding-get_started') }}' method='POST'>
				@csrf


				@php
					// Create pre-selected value for goal options
					$goals_value = array();
					// Loop through goals
					foreach ($goals as $goal) {
						// Check if pre-selected
						if (@$goal['selected'] == true) {
							// Add to array
							$goals_value[sizeof($goals_value)] = $goal['name'];
						}
					}
					// Join goals
					$goals_value = implode(', ', $goals_value);
				@endphp
				<input type='hidden' name='goals_list' value='{{ $goals_value }}' required/>
			</form>


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card max_w_600 w-100'>
					<div class='row'>


						<div class='col-12 mb-1 mt-0'>
							<h5 class='mb-0'>What are your charity's goals?</h5>
							<p class='mb-0'><small>Please select all items that apply to your charity.</small></p>
						</div>


						@foreach ($goals as $goal)
							<div class='col-12'>
								<div class='checkbox-input mb-0'>
									@if (@$goal['selected'] == true)
										<input type='checkbox' class='form_collective' collective='goals_list' id='goals_list-{{ $goal['name'] }}' checked>
									@else
										<input type='checkbox' class='form_collective' collective='goals_list' id='goals_list-{{ $goal['name'] }}'>
									@endif
									<label class='form-check-label' for='goals_list-{{ $goal['name'] }}'>{{ $goal['label'] }}</label>
								</div>
							</div>
						@endforeach


						<div class='form_error_container col-12 m-0 mt-2' field='goals_list'>
						@error('goals_list')
							<p>{{ $message }}</p>
						@enderror
						</div>


						<div class='col-12 mt-4 mb-0'>
							<input type='submit' class='btn-primary btn-block m-0' form='charities-onboarding-goals' value='Next'/>
						</div>


					</div>
				</div>
			</div>


		</div>
	</div>
@endsection
