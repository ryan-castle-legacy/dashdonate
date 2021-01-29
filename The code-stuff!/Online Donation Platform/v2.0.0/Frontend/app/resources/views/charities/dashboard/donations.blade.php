@extends('layouts.charity-dashboard', ['charity' => $charity])




@section('pre-scripts')
@endsection




@section('post-scripts')
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
@endsection




@section('content')
	<div class='dash_main'>


		@php $error_messages = 0; @endphp


		@if(session('success'))
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				<div class='alert alert-success w-100 mx-3'>
					<p class='m-0 p-0'>
						<i class='fas fa-check-circle'></i>
						{{ session('success') }}
					</p>
				</div>
			</div>
		@endif


		@error('error')
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				<div class='alert alert-danger w-100 mx-3'>
					<p class='m-0 p-0'>
						<i class='fas fa-exclamation-triangle'></i>
						{{ $message }}
					</p>
				</div>
			</div>
		@enderror


		@if ($error_messages > 0)
			<div class='col px-0 d-flex mb-4 mt-4 justify-content-center'>
		@else
			<div class='col px-0 d-flex mb-4 justify-content-center'>
		@endif
			<div class='row w-100'>


				<div class='col-6'>
					<div class='card donation_list'>

						<div class='col-12 px-0 mb-0 mt-0'>
							<h5 class='mb-0'>Successful Donations</h5>
							<p><small>All donations that have been made to your charity via DashDonate.org</small></p>
						</div>

						@if (sizeof($charity->donations) == 0)

							<div class='col-12 px-0 mb-0 mt-0'>
								<div class='alert alert-info w-100 m-0'>
									<p class='m-0 p-0'>
										<i class='fas fa-info'></i>
										Once you start capturing donations they will appear here.
									</p>
								</div>
							</div>

						@else

							@for ($i = 0; $i < sizeof($charity->donations); $i++)
								<div class='col-12 donation donation_nocard donation_forcharity'>

									<p>&pound;{{ number_format(($charity->donations[$i]->total_to_charity / 100), 2) }}</p>

									<p><small>{{ date('Y-m-d \a\t H:i', strtotime($charity->donations[$i]->date_taken)) }}</small></p>

								</div>
							@endfor

						@endif

					</div>
				</div>


				<div class='col-6'>

					<div class='card donation_list col-12'>

						<div class='col-12 px-0 mb-0 mt-0'>
							<h5 class='mb-0'>Scheduled Donations</h5>
							<p><small>Donations that are scheduled for future dates</small></p>
						</div>

						@if (sizeof($charity->scheduled_donations) == 0)

							<div class='col-12 px-0 mb-0 mt-0'>
								<div class='alert alert-info w-100 m-0'>
									<p class='m-0 p-0'>
										<i class='fas fa-info'></i>
										Scheduled donations will appear here.
									</p>
								</div>
							</div>

						@else

							@for ($i = 0; $i < sizeof($charity->scheduled_donations); $i++)
								@if ($charity->scheduled_donations[$i]->task_count === 1)
									<div class='col-12 donation donation_nocard donation_forcharity'>

										<p>&pound;{{ number_format(($charity->scheduled_donations[$i]->total_to_charity / 100), 2) }}</p>

										<p><small>Scheduled for the {{ date('jS F Y \a\t g:ia', strtotime($charity->scheduled_donations[$i]->date_to_process)) }}</small></p>

									</div>
								@endif
							@endfor

						@endif

					</div>

					<div class='card donation_list col-12 mt-4'>

						<div class='col-12 px-0 mb-0 mt-0'>
							<h5 class='mb-0'>Repeat Donations</h5>
							<p><small>Your donations that are set to repeat</small></p>
						</div>

						@if (sizeof($charity->repeat_donations) == 0)

							<div class='col-12 px-0 mb-0 mt-0'>
								<div class='alert alert-info w-100 m-0'>
									<p class='m-0 p-0'>
										<i class='fas fa-info'></i>
										Repeat donations will appear here.
									</p>
								</div>
							</div>

						@else
							@for ($i = 0; $i < sizeof($charity->repeat_donations); $i++)
								<div class='col-12 donation donation_nocard donation_forcharity'>

									<p>&pound;{{ number_format(($charity->repeat_donations[$i]->total_to_charity / 100), 2) }}</p>

									@php
										// Holder for the repeat string
										$repeat_string = 'Repeating ';
										// Check if interval is singular
										if ($charity->repeat_donations[$i]->meta->repeatingInterval == 1) {
											// Check if duration is set to weeks
											if ($charity->repeat_donations[$i]->meta->repeatingDuration == 'weeks') {
												// Set string to singular
												$repeat_string .= ' every week';
											} else {
												// Set string to singular
												$repeat_string .= ' every month';
											}
										} else {
											// Check if duration is set to weeks
											if ($charity->repeat_donations[$i]->meta->repeatingDuration == 'weeks') {
												// Set string to pleural
												$repeat_string .= ' every '.$charity->repeat_donations[$i]->meta->repeatingInterval.' weeks';
											} else {
												// Set string to pleural
												$repeat_string .= ' every '.$charity->repeat_donations[$i]->meta->repeatingInterval.' months';
											}
										}
										// Check if duration is set to weeks (rather than months)
										if ($charity->repeat_donations[$i]->meta->repeatingDuration == 'weeks') {
											// Get day of week
											$repeat_string .= ' (on '.$dateWeekdays[intval(substr($charity->repeat_donations[$i]->meta->repeatingAnchor, strlen('week-')))].'s)';
										} else {
											// Check if anchor is last day of month
											if ($charity->repeat_donations[$i]->meta->repeatingAnchor == 'month-last') {
												// Get day of month
												$repeat_string .= 'on the last day';
											} else {
												// Get day of month
												$repeat_string .= ' on the '.$dateDays[intval(substr($charity->repeat_donations[$i]->meta->repeatingAnchor, strlen('month-'))) - 1];
											}
											// Check if singular
											if ($charity->repeat_donations[$i]->meta->repeatingInterval == 1) {
												// Add to string
												$repeat_string .= ' of every month';
											} else {
												// Add to string
												$repeat_string .= ' of every '.$charity->repeat_donations[$i]->meta->repeatingInterval.' months';
											}
										}
									@endphp

									<div>
										<p><small>{{ $repeat_string }}</small></p>

										<p><small>Expected next on {{ date('l jS F Y \a\t g:ia', strtotime($charity->repeat_donations[$i]->date_to_process)) }}</small></p>

									</div>

								</div>
							@endfor
						@endif

					</div>

				</div>


			</div>
		</div>


	</div>
@endsection




@section('modals')
	@include('charities.modals.invite_staff')
@endsection
