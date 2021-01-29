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
	<hero class='bg-blue w-100 d-flex align-items-center'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<p><a href='{{ route('public-dashboard') }}'><i class='fas fa-chevron-left'></i> Back to dashboard</a></p>
				<h1 class='mb-0'>My Donations</h1>
			</div>
		</div>
	</hero>

	<div class='w-100 d-flex align-items-center'>
		<div class='container px-0 py-5'>
			<div class='col py-3 px-0'>

				<div class='row justify-content-center'>


					<div class='col-6'>
						<div class='card donation_list'>

							<div class='col-12 px-0 mb-0 mt-0'>
								<h5 class='mb-0'>Successful Donations</h5>
								<p><small>This is a list of all donations you have made so far via DashDonate.org</small></p>
							</div>

							@if (sizeof($donation_data->donations) == 0)

								<div class='col-12 px-0 mb-0 mt-0'>
									<div class='alert alert-info w-100 m-0'>
										<p class='m-0 p-0'>
											<i class='fas fa-info'></i>
											Once you start making donations they will appear here.
										</p>
									</div>
								</div>

							@else

								@for ($i = 0; $i < sizeof($donation_data->donations); $i++)
									<div class='col-12 donation donation_nocard'>

										<a href='{{ route('charities-public-homepage', ['charity_slug' => $donation_data->donations[$i]->charity_slug]) }}' target='_blank' class='charity_logo'>
											<div class='logo filled' style='background-image: url("{{ @env('S3_URL').$donation_data->donations[$i]->charity->logo->s3_url }}")'></div>
										</a>

										<h4><a href='{{ route('charities-public-homepage', ['charity_slug' => $donation_data->donations[$i]->charity_slug]) }}' target='_blank'>{{ $donation_data->donations[$i]->charity->display_name }}</a></h4>

										<h5>&pound;{{ number_format(($donation_data->donations[$i]->amount / 100), 2) }}</h5>

										<p><small>Taken on the {{ date('jS F Y \a\t g:ia', strtotime($donation_data->donations[$i]->date_taken)) }}</small></p>

									</div>
								@endfor

							@endif

						</div>
					</div>


					<div class='col-4'>

						<div class='card donation_list col-12'>

							<div class='col-12 px-0 mb-0 mt-0'>
								<h5 class='mb-0'>Scheduled Donations</h5>
								<p><small>Your donations that are scheduled for future dates</small></p>
							</div>

							@if (sizeof($donation_data->scheduled_donations) == 0)

								<div class='col-12 px-0 mb-0 mt-0'>
									<div class='alert alert-info w-100 m-0'>
										<p class='m-0 p-0'>
											<i class='fas fa-info'></i>
											Your scheduled donations will appear here.
										</p>
									</div>
								</div>

							@else

								@for ($i = 0; $i < sizeof($donation_data->scheduled_donations); $i++)
									@if ($donation_data->scheduled_donations[$i]->task_count === 1)
										<div class='col-12 donation donation_nocard'>

											<a href='{{ route('charities-public-homepage', ['charity_slug' => $donation_data->scheduled_donations[$i]->charity_slug]) }}' target='_blank' class='charity_logo'>
												<div class='logo filled' style='background-image: url("{{ @env('S3_URL').$donation_data->scheduled_donations[$i]->charity->logo->s3_url }}")'></div>
											</a>

											<h4><a href='{{ route('charities-public-homepage', ['charity_slug' => $donation_data->scheduled_donations[$i]->charity_slug]) }}' target='_blank'>{{ $donation_data->scheduled_donations[$i]->charity->display_name }}</a></h4>

											<h5>&pound;{{ number_format(($donation_data->scheduled_donations[$i]->amount / 100), 2) }}</h5>

											<p><small>Scheduled for the {{ date('jS F Y \a\t g:ia', strtotime($donation_data->scheduled_donations[$i]->date_to_process)) }}</small></p>

											<p class='m-0 mb-1'>
												<button class='btn btn-secondary btn-secondary-outline mt-1 btn-sm btn-small m-0 cancel_donation_task' task='{{ $donation_data->scheduled_donations[$i]->task_group_token }}'>Cancel</button>
											</p>

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

							@if (sizeof($donation_data->repeat_donations) == 0)

								<div class='col-12 px-0 mb-0 mt-0'>
									<div class='alert alert-info w-100 m-0'>
										<p class='m-0 p-0'>
											<i class='fas fa-info'></i>
											Your repeat donations will appear here.
										</p>
									</div>
								</div>

							@else
								@for ($i = 0; $i < sizeof($donation_data->repeat_donations); $i++)
									<div class='col-12 donation donation_nocard'>

										<a href='{{ route('charities-public-homepage', ['charity_slug' => $donation_data->repeat_donations[$i]->charity_slug]) }}' target='_blank' class='charity_logo'>
											<div class='logo filled' style='background-image: url("{{ @env('S3_URL').$donation_data->repeat_donations[$i]->charity->logo->s3_url }}")'></div>
										</a>

										<h4><a href='{{ route('charities-public-homepage', ['charity_slug' => $donation_data->repeat_donations[$i]->charity_slug]) }}' target='_blank'>{{ $donation_data->repeat_donations[$i]->charity->display_name }}</a></h4>

										<h5>&pound;{{ number_format(($donation_data->repeat_donations[$i]->amount / 100), 2) }}</h5>

										@php
											// Holder for the repeat string
											$repeat_string = 'Repeating ';
											// Check if interval is singular
											if ($donation_data->repeat_donations[$i]->meta->repeatingInterval == 1) {
												// Check if duration is set to weeks
												if ($donation_data->repeat_donations[$i]->meta->repeatingDuration == 'weeks') {
													// Set string to singular
													// $repeat_string .= 'week';
												} else {
													// Set string to singular
													// $repeat_string .= 'month';
												}
											} else {
												// Check if duration is set to weeks
												if ($donation_data->repeat_donations[$i]->meta->repeatingDuration == 'weeks') {
													// Set string to pleural
													$repeat_string .= ' every '.$donation_data->repeat_donations[$i]->meta->repeatingInterval.' weeks';
												} else {
													// Set string to pleural
													$repeat_string .= ' every '.$donation_data->repeat_donations[$i]->meta->repeatingInterval.' months';
												}
											}
											// Check if duration is set to weeks (rather than months)
											if ($donation_data->repeat_donations[$i]->meta->repeatingDuration == 'weeks') {
												// Get day of week
												$repeat_string .= ' (on '.$dateWeekdays[intval(substr($donation_data->repeat_donations[$i]->meta->repeatingAnchor, strlen('week-')))].'s)';
											} else {
												// Check if anchor is last day of month
												if ($donation_data->repeat_donations[$i]->meta->repeatingAnchor == 'month-last') {
													// Get day of month
													$repeat_string .= 'on the last day';
												} else {
													// Get day of month
													$repeat_string .= ' on the '.$dateDays[intval(substr($donation_data->repeat_donations[$i]->meta->repeatingAnchor, strlen('month-'))) - 1];
												}
												// Check if singular
												if ($donation_data->repeat_donations[$i]->meta->repeatingInterval == 1) {
													// Add to string
													$repeat_string .= ' of every month';
												} else {
													// Add to string
													$repeat_string .= ' of every '.$donation_data->repeat_donations[$i]->meta->repeatingInterval.' months';
												}
											}
										@endphp
										<p><small>{{ $repeat_string }}</small></p>

										<p><small>Next on {{ date('l jS F Y \a\t g:ia', strtotime($donation_data->repeat_donations[$i]->date_to_process)) }}</small></p>

										<p class='m-0 mb-1'>
											<button class='btn btn-secondary btn-secondary-outline mt-1 btn-sm btn-small m-0 cancel_donation_task' task='{{ $donation_data->repeat_donations[$i]->task_group_token }}'>Cancel</button>
										</p>

									</div>
								@endfor
							@endif

						</div>

					</div>


				</div>

			</div>
		</div>
	</div>
@endsection
