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


		@error('email')
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


		@if ($charity->needs_staff_added == true)
			@php $error_messages++; @endphp
			<div class='col px-0 d-flex mb-1 justify-content-center'>
				@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
					<div class='alert mb-1 alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							You must add at least one other staff member to your charity.
						</p>
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


		@if ($error_messages > 0)
			<div class='col px-0 d-flex mb-4 mt-4 justify-content-center'>
		@else
			<div class='col px-0 d-flex mb-4 justify-content-center'>
		@endif
			<div class='row w-100'>
				<div class='col-12'>
					<div class='card'>

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

						@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
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


	</div>
@endsection




@section('modals')
	@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
		@include('charities.modals.invite_staff')
	@endif
@endsection
