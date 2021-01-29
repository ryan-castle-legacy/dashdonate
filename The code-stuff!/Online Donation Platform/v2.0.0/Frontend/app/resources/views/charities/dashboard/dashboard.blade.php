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
				<div class='alert mb-1 alert-success w-100 mx-3'>
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
				<div class='alert mb-1 alert-danger w-100 mx-3'>
					<p class='m-0 p-0'>
						<i class='fas fa-exclamation-triangle'></i>
						{{ $message }}
					</p>
				</div>
			</div>
		@enderror


		@if ($charity->needs_representative_id == true)
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				@if (@$charity->local_staff_user->is_representative == true)
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							You need to provide personal identification documents in order for you to represent this charity.
						</p>
						<a href='{{ route('charities-onboarding-collect_representative_id', ['charity_slug' => $charity->slug]) }}' class='btn btn-warning mx-0'><i class='fas fa-plus ml-0'></i> Add documents</a>
					</div>
				@else
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							Your representative needs to provide personal identification documents.
						</p>
					</div>
				@endif
			</div>
		@else
			@if($charity->representative_id_pending == true)
				@php $error_messages++; @endphp
				<div class='col px-0 d-flex mb-1 justify-content-center'>
					<div class='alert mb-1 alert-info w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-info-circle'></i>
							Your representative's personal identification documents are being reviewed.
						</p>
					</div>
				</div>
			@endif
			@if($charity->needs_bank_account == true)
				@php $error_messages++; @endphp
				<div class='col px-0 d-flex mb-1 justify-content-center'>
					@if (@$charity->local_staff_user->is_representative == true)
						<div class='alert mb-1 alert-warning w-100 mx-3'>
							<p class='m-0 p-0'>
								<i class='fas fa-exclamation-triangle'></i>
								You need to provide bank account details for this charity.
							</p>
							<a href='{{ route('charities-administration-collect_bank_account', ['charity_slug' => $charity->slug]) }}' class='btn btn-warning mx-0'><i class='fas fa-plus ml-0'></i> Add bank account</a>
						</div>
					@else
						<div class='alert mb-1 alert-warning w-100 mx-3'>
							<p class='m-0 p-0'>
								<i class='fas fa-exclamation-triangle'></i>
								Your representative needs to provide bank account details for your charity.
							</p>
						</div>
					@endif
				</div>
			@elseif($charity->bank_account_needs_verified == true)
				@php $error_messages++; @endphp
				<div class='col px-0 d-flex mb-1 justify-content-center'>
					<div class='alert mb-1 alert-info w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-info-circle'></i>
							Your charity's bank account details are being reviewed.
						</p>
					</div>
				</div>
			@endif
		@endif




		@if ($charity->needs_charity_proof_of_address == true)
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				@if (@$charity->local_staff_user->is_representative == true)
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							You need to upload proof of your charity operating out of its registered address.
						</p>
						<a href='{{ route('charities-onboarding-collect_registered_address', ['charity_slug' => $charity->slug]) }}' class='btn btn-warning mx-0'><i class='fas fa-plus ml-0'></i> Add documents</a>
					</div>
				@else
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							Your representative needs to provide proof of your charity operating out of its registered address.
						</p>
					</div>
				@endif
			</div>
		@elseif($charity->needs_charity_proof_of_address_pending == true)
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				<div class='alert mb-1 alert-info w-100 mx-3'>
					<p class='m-0 p-0'>
						<i class='fas fa-info-circle'></i>
						Your proof of your charity's registered address documents are being reviewed.
					</p>
				</div>
			</div>
		@endif




		@if ($charity->needs_details_review == true)
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							Before your charity becomes active on DashDonate.org, you need to review your charity's details.
						</p>
						<a href='{{ route('charities-dashboard-about', ['charity_slug' => $charity->slug]) }}' class='btn btn-warning mx-0'><i class='fas fa-search ml-0'></i> Review details</a>

					</div>
				@else
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							Before your charity becomes active on DashDonate.org, an administrator of your charity needs to review your charity's details.
						</p>
					</div>
				@endif
			</div>
		@endif
		@if ($charity->needs_staff_added == true)
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							You must add at least one other staff member to your charity.
						</p>
						<a href='{{ route('charities-dashboard-staff', ['charity_slug' => $charity->slug]) }}' class='btn btn-warning mx-0'><i class='fas fa-plus ml-0'></i> Add staff</a>

					</div>
				@else
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							An administrator must add at least one other staff member to your charity.
						</p>
					</div>
				@endif
			</div>
		@endif



		@php $error_messages++; @endphp
		<div class='col px-0 d-flex mb-1 justify-content-center'>
			<div class='alert mb-1 alert-info w-100 mx-3'>
				<p class='m-0 p-0'>
					<i class='fas fa-info'></i>
					We have lots of exciting updates and features coming in the next few weeks! We'll be in touch soon with more details.
				</p>
			</div>
		</div>







		@if ($error_messages > 0)
			<div class='col px-0 d-flex mb-4 mt-4 justify-content-center'>
		@else
			<div class='col px-0 d-flex mb-4 justify-content-center'>
		@endif
			<div class='row w-100'>

				<div class='col-8'>

					<div class='col-12 px-0 mb-3 mt-0'>
						<h5>Activity Feed</h5>
					</div>

					<div class='donor_feed'>

						<div class='col-12 px-0 mb-3 mt-0'>
							<div class='alert alert-info w-100 m-0'>
								<p class='m-0 p-0'>
									<i class='fas fa-info'></i>
									Our top priority is keeping your supporters engaged, that's why we are working hard to build activity feeds into our next updates - we'll notify you when they're ready!
								</p>
							</div>
						</div>

						<div class='col-12 story'>

							<div class='header'>
								<div class='charity_logo'>
									<div class='logo filled' style='background-image: url("{{ asset('img/ryan-avatar.jpg') }}")'></div>
								</div>
								<h4>Ryan Castle, Founder of DashDonate.org</h4>
								<h5>Welcome to DashDonate.org</p>
							</div>

							<p>
								Hello, and welcome to DashDonate.org!
								<br/>
								<br/>
								Myself and the team at DashDonate.org can't thank you enough for being one of the first few charities on our site. We're focussed on making fundraising faster and easier for you so that you can focus on your charity, rather than generating money.
								<img src='http://asset.dashdonate.org/thank-you.png'/>
								We're right at the beginning of our journey, and we have so much to offer. Things may look a little rough around the edges. We are constantly improving, with our two goals being:
								<br/>
								<br/>
								&nbsp;&nbsp;1. To give donors complete control and freedom over their donations.<br/>
								&nbsp;&nbsp;2. To empower charities with the best tech around so they can better focus on the work they do.
								<br/>
								<br/>
								I want to make it clear that we are not here to make a profit. No huge executive pay-checks or any of that stuff - every penny that is taken when making a donation goes to either the charity, is spent on fees with our payment processor, or it goes to improving the services we offer to charities.
								<br/>
								<br/>
								We're so excited to have you onboard, thank you for being part of our adventure!
								<br/>
								<br/>
								PS. If you have any suggestions as to how we can make donating better, feel free to send me an email at <a href='mailto:ryan@dashdonate.org' target='_blank'>ryan@dashdonate.org</a>.
							</p>

						</div>

					</div>
				</div>


				<div class='col-4'>

					{{-- <div class='col-12 card mb-3 charity_stats'>
						<div id='test_chart' class='dd_chart'></div>
					</div> --}}

					<div class='col-12 px-0 mb-3 mt-0'>
						<h5>Audience</h5>
					</div>

					<div class='col-12 card mb-3 charity_stats'>
						<h6>Page Views</h6>
						@if (@$charity->page_views_total > 0)
							<h5>{{ @$charity->page_views_total }}</h5>
						@else
							<h5>0</h5>
						@endif
					</div>

					<div class='col-12 px-0 mb-3 mt-0'>
						<h5>Donations</h5>
					</div>

					<div class='col-12 card mb-3 charity_stats'>
						<h6>Today</h6>
						@if ($charity->donations_today_total == 0)
							<h5>&pound;0.00</h5>
						@else
							<h5>&pound;{{ number_format($charity->donations_today_total / 100, 2) }}</h5>
						@endif
						@if ($charity->donations_today == 1)
							<p><small>({{ $charity->donations_today }} donation)</small></p>
						@else
							<p><small>({{ $charity->donations_today }} donations)</small></p>
						@endif
					</div>

					<div class='col-12 card mb-3 charity_stats'>
						<h6>The Past 7 Days</h6>
						@if ($charity->donations_7days_total == 0)
							<h5>&pound;0.00</h5>
						@else
							<h5>&pound;{{ number_format($charity->donations_7days_total / 100, 2) }}</h5>
						@endif
						@if ($charity->donations_7days == 1)
							<p><small>({{ $charity->donations_7days }} donation)</small></p>
						@else
							<p><small>({{ $charity->donations_7days }} donations)</small></p>
						@endif
					</div>

					<div class='col-12 card mb-3 charity_stats'>
						<h6>Month To Date</h6>
						@if ($charity->donations_mtd_total == 0)
							<h5>&pound;0.00</h5>
						@else
							<h5>&pound;{{ number_format($charity->donations_mtd_total / 100, 2) }}</h5>
						@endif
						@if ($charity->donations_mtd == 1)
							<p><small>({{ $charity->donations_mtd }} donation)</small></p>
						@else
							<p><small>({{ $charity->donations_mtd }} donations)</small></p>
						@endif
					</div>

					<div class='col-12 card charity_stats'>
						<h6>All-Time</h6>
						@if ($charity->donations_alltime_total == 0)
							<h5>&pound;0.00</h5>
						@else
							<h5>&pound;{{ number_format($charity->donations_alltime_total / 100, 2) }}</h5>
						@endif
						@if ($charity->donations_alltime == 1)
							<p><small>({{ $charity->donations_alltime }} donation)</small></p>
						@else
							<p><small>({{ $charity->donations_alltime }} donations)</small></p>
						@endif
					</div>

					<a class='btn btn-outline btn-sm w-100 mt-3' href='{{ route('charities-dashboard-donations', ['charity_slug' => $charity->slug]) }}'>See more details/stats</a>

				</div>


			</div>
		</div>
	</div>
@endsection
