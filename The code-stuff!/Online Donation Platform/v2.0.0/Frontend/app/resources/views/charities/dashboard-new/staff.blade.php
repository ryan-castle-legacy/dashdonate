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
			<form class='auto_validate_forms' id='modals-charities-dashboard-about-confirm' action='{{ route('modals-charities-dashboard-about-confirm', ['charity_slug' => $charity->slug]) }}' method='POST'>@csrf</form>


			@if ($hasNotice)
			<div class='dd_notices'>

				@if(session('success'))
					<div class='dd_notice dd_notice_success'>
						<i class='fad fa-check-circle'></i>
						<p>{{ session('success') }}</p>
					</div>
				@endif

				@error('email')
					<div class='dd_notice dd_notice_danger'>
						<i class='fad fa-skull-cow'></i>
						<p>{{ $message }}</p>
					</div>
				@enderror

				@error('error')
					<div class='dd_notice dd_notice_danger'>
						<i class='fad fa-skull-cow'></i>
						<p>{{ $message }}</p>
					</div>
				@enderror

				@if ($charity->needs_staff_added == true)
					@if (@$charity->local_staff_user->is_representative == true)
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>You must add at least one other staff member to your charity.</p>
						</div>
					@else
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>An administrator must add at least one other staff member to your charity.</p>
						</div>
					@endif
				@endif

			</div>
			@endif


			<div class='dd_card'>
				<div class='dd_card_main dd_card_main_col dd_card_main_xpad20 dd_card_main_ypad20'>


					<div class='row col-12'>
						<h5 class='mb-2'>Charity Staff</h5>
					</div>

					<div class='row'>
						<div class='col-3 w-100 m-0'>
							<p class='m-0'><small>Name</small></p>
						</div>
						<div class='col-3 w-100 m-0'>
							<p class='m-0'><small>Email address</small></p>
						</div>
						<div class='col-3 w-100 m-0'>
							<p class='m-0'><small>Date added to charity</small></p>
						</div>
						<div class='col-2 w-100 m-0'>
							<p class='m-0'><small>Role</small></p>
						</div>
						<div class='col-1 w-100 m-0'>
							<p class='m-0'><small>Is Owner</small></p>
						</div>
					</div>

					@foreach($charity->staff as $staff)
						<hr/>
						<div class='row'>
							<div class='col-3 w-100 m-0'>
								@if (Auth::user()->id == $staff->details->id)
									@if ($staff->details->name == '')
										<p class='m-0'>Staff Member <small>(You)</small></p>
									@else
										<p class='m-0'>{{ $staff->details->name }} <small>(You)</small></p>
									@endif
								@else
									@if ($staff->details->name == '')
										<p class='m-0'>Staff Member</p>
									@else
										<p class='m-0'>{{ $staff->details->name }}</p>
									@endif
								@endif
							</div>
							<div class='col-3 w-100 m-0'>
								<p class='m-0'><small>{{ $staff->details->email }}</small></p>
							</div>
							<div class='col-3 w-100 m-0'>
								<p class='m-0'><small>{{ date('j M Y \a\t g:ia', strtotime($staff->date_added)) }}</small></p>
							</div>
							<div class='col-2 w-100 m-0'>
								<p class='m-0'><small>{{ ucwords($staff->role) }}</small></p>
							</div>
							<div class='col-1 w-100 m-0'>
								@if ($staff->is_owner)
									<p class='m-0'><small>Yes</small></p>
								@else
									<p class='m-0'><small>No</small></p>
								@endif
							</div>
						</div>
					@endforeach

					@if (@Auth::user()->email == 'ryan@dashdonate.org' || @$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
						<hr/>
						<div class='row col-12'>
							<p class='m-0'><small>
								<a class='btn btn-primary btn-sm m-0' data-toggle='modal' data-target='#modals-charities-invite_staff'><i class='fas fa-plus m-0'></i>&nbsp; Invite member of staff</a></small>
							</p>
						</div>
					@endif


				</div>
			</div>


		</div>
	</div>
@endsection




@section('modals')
	@if (@Auth::user()->email == 'ryan@dashdonate.org' || @$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
		@include('charities.modals.invite_staff')
	@endif
@endsection
