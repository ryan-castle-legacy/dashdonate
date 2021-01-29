@extends('layouts.main', ['charity' => $charity])




@section('pre-scripts')
@endsection




@section('post-scripts')
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
@endsection




@section('content')
	<div class='dd_dashboard dd_dashboard-charity'>
		@include('layouts.charityDashboard-navbar')
		<div class='dd_main'>

			@if ($hasNotice)
			<div class='dd_notices'>

				@if(session('success'))
					<div class='dd_notice dd_notice_success'>
						<i class='fad fa-check-circle'></i>
						<p>{{ session('success') }}</p>
					</div>
				@endif

				@error('error')
					<div class='dd_notice dd_notice_success'>
						<i class='fad fa-check-circle'></i>
						<p>{{ $message }}</p>
					</div>
				@enderror

				@if ($charity->needs_representative_id == true)
					@if (@$charity->local_staff_user->is_representative == true)
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>You need to provide personal identification documents in order for you to represent this charity.</p>
							<a href='{{ route('charities-onboarding-collect_representative_id', ['charity_slug' => $charity->slug]) }}' class='btn'><i class='fas fa-plus'></i> Add documents</a>
						</div>
					@else
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>Your representative needs to provide personal identification documents.</p>
						</div>
					@endif
				@else
					@if ($charity->representative_id_pending == true)
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>Your representative's personal identification documents are being reviewed.</p>
						</div>
					@endif
					@if ($charity->needs_bank_account == true)
						@if (@$charity->local_staff_user->is_representative == true)
							<div class='dd_notice dd_notice_warning'>
								<i class='fad fa-exclamation-triangle'></i>
								<p>You need to provide bank account details for this charity.</p>
								<a href='{{ route('charities-administration-collect_bank_account', ['charity_slug' => $charity->slug]) }}' class='btn'><i class='fas fa-plus'></i> Add account</a>
							</div>
						@else
							<div class='dd_notice dd_notice_warning'>
								<i class='fad fa-exclamation-triangle'></i>
								<p>Your representative needs to provide bank account details for your charity.</p>
							</div>
						@endif
					@elseif ($charity->bank_account_needs_verified == true)
						<div class='dd_notice dd_notice_info'>
							<i class='fad fa-info-circle'></i>
							<p>Your charity's bank account details are being reviewed.</p>
						</div>
					@endif
				@endif


				@if ($charity->needs_charity_proof_of_address == true)
					@if (@$charity->local_staff_user->is_representative == true)
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>You need to upload proof of your charity operating out of its registered address.</p>
							<a href='{{ route('charities-onboarding-collect_registered_address', ['charity_slug' => $charity->slug]) }}' class='btn'><i class='fas fa-plus'></i> Add documents</a>
						</div>
					@else
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>Your representative needs to provide proof of your charity operating out of its registered address.</p>
						</div>
					@endif
				@elseif ($charity->needs_charity_proof_of_address_pending == true)
					<div class='dd_notice dd_notice_info'>
						<i class='fad fa-info-circle'></i>
						<p>Your proof of your charity's registered address documents are being reviewed.</p>
					</div>
				@endif


				@if ($charity->needs_details_review == true)
					@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>Before your charity becomes active on DashDonate.org, you need to review your charity's details.</p>
							<a href='{{ route('charities-dashboard-about', ['charity_slug' => $charity->slug]) }}' class='btn'><i class='fas fa-plus'></i> Review details</a>
						</div>
					@else
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>Before your charity becomes active on DashDonate.org, an administrator of your charity needs to review your charity's details.</p>
						</div>
					@endif
				@endif


				@if ($charity->needs_staff_added == true)
					@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>You must add at least one other staff member to your charity.</p>
							<a href='{{ route('charities-dashboard-staff', ['charity_slug' => $charity->slug]) }}' class='btn'><i class='fas fa-plus'></i> Add staff</a>
						</div>
					@else
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>An administrator must add at least one other staff member to your charity</p>
						</div>
					@endif
				@endif


				{{-- <div class='dd_notice dd_notice_info'>
					<i class='fad fa-info-circle'></i>
					<p>Info</p>
				</div>
				<div class='dd_notice dd_notice_danger'>
					<i class='fad fa-skull-cow'></i>
					<p>Danger</p>
				</div>
				<div class='dd_notice dd_notice_warning'>
					<i class='fad fa-exclamation-triangle'></i>
					<p>Warning</p>
				</div>
				<div class='dd_notice dd_notice_success'>
					<i class='fad fa-check-circle'></i>
					<p>Success</p>
				</div> --}}
			</div>
			@endif


			<div class='dd_card_pair dd_card_pair-activity'>

				<div class='dd_activity_feed'>

					<div class='dd_notices'>
						<div class='dd_notice dd_notice_info'>
							<i class='fad fa-info-circle'></i>
							<p>Our top priority is keeping your supporters engaged, that's why we are working hard to build activity feeds into our next updates - we'll notify you when they're ready!</p>
						</div>
					</div>

					<div class='dd_card dd_card-activity'>
						<div class='dd_card-activity-header'>
							<div class='dd_card-activity-header-avatar'>
								<span style='background-image: url("{{ asset('img/ryan-avatar.jpg') }}")'></span>
							</div>
							<div class='dd_card-activity-header-name'>
								<h1>Ryan Castle<span></span></h1>
								<p>Founder of DashDonate.org</p>
							</div>
						</div>
						<div class='dd_card-activity-main'>
							<p>
								Hello, and welcome to DashDonate.org!
								<br>
								<br>
								Myself and the team at DashDonate.org can't thank you enough for being one of the first few charities on our site. We're focussed on making fundraising faster and easier for you so that you can focus on your charity, rather than generating money.
								<img src="http://asset.dashdonate.org/thank-you.png">
								We're right at the beginning of our journey, and we have so much to offer. Things may look a little rough around the edges. We are constantly improving, with our two goals being:
								<br>
								<br>
								&nbsp;&nbsp;1. To give donors complete control and freedom over their donations.<br>
								&nbsp;&nbsp;2. To empower charities with the best tech around so they can better focus on the work they do.
								<br>
								<br>
								I want to make it clear that we are not here to make a profit. No huge executive pay-checks or any of that stuff - every penny that is taken when making a donation goes to either the charity, is spent on fees with our payment processor, or it goes to improving the services we offer to charities.
								<br>
								<br>
								We're so excited to have you onboard, thank you for being part of our adventure!
								<br>
								<br>
								PS. If you have any suggestions as to how we can make donating better, feel free to send me an email at <a href="mailto:ryan@dashdonate.org" target="_blank">ryan@dashdonate.org</a>.
							</p>
						</div>
					</div>

					{{-- <div class='dd_card-activity_placeholder'>

						<div class='dd_card dd_card-activity'>

						</div>

						<div class='dd_card dd_card-activity'></div>
						<div class='dd_card-activity_placeholder_fader'><span></span></div>

					</div> --}}

				</div>


				<div class='dd_activity_feed_sidebar'>

					<div class='dd_card dd_card-ministats'>
						<div class='dd_card_head'>
							<p>Recent audience <small>(this week - wc. {{ $charity->dashboard->thisweek_weekstart }})</small></p>
						</div>
						<div class='dd_card_main'>
							<div class='dd_card_section dd_card_main-ministats-item'>
								<p>Visitors</p>
								<h1>{{ number_format($charity->dashboard->audience->visits->thisweek_total) }}</h1>
							</div>
						</div>
					</div>
					<a href='{{ route('charities-dashboard-audience', ['charity_slug' => $charity->slug]) }}' class='btn btn-small mb-3 w-100'>See more audience stats</a>

					<div class='dd_card dd_card-ministats'>
						<div class='dd_card_head'>
							<p>Recent donations <small>(this week - wc. {{ $charity->dashboard->thisweek_weekstart }})</small></p>
						</div>
						<div class='dd_card_main'>
							<div class='dd_card_section dd_card_main-ministats-item'>
								<p>Total Donated</p>
								<h1>&pound;{{ number_format(($charity->dashboard->donations->recent->thisweek_total - $charity->dashboard->donations->recent->thisweek_totalfees) / 100, 2) }}</h1>
								<h6>{{ $charity->dashboard->donations->recent->thisweek_count }} @php if ($charity->dashboard->donations->recent->thisweek_count === 1) { echo 'donation'; } else { echo 'donations'; } @endphp</h6>
							</div>
						</div>
					</div>
					<a href='{{ route('charities-dashboard-donations', ['charity_slug' => $charity->slug]) }}' class='btn btn-small w-100'>See more donation stats</a>


				</div>



			</div>
		</div>
	</div>
@endsection
