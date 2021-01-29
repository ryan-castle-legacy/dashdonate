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


		@error('url')
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
				<div class='col-12'>
					<div class='card'>

						<div class='row col-12'>
							<h5 class='m-0'>Authorised Websites</h5>
							<p class='w-100 mb-2'><small>To display a donation widget on a website, you must first authorise it.</small></p>
						</div>

						<div class='row'>
							<div class='col-9 w-100 m-0'>
								<p class='m-0'><small>URL</small></p>
							</div>
							<div class='col-3 w-100 m-0'>
								{{-- <p class='m-0'><small>Delete</small></p> --}}
							</div>
						</div>


						@if (@sizeof($charity->authorised_websites) == 0)
							<hr/>
							<div class='row'>
								<div class='col-12 w-100 m-0'>
									<div class='alert alert-info w-100 m-0'>
										<p class='m-0 p-0'>
											<i class='fas fa-info'></i>
											To display a donation widget on your site you must add the URL to this list.
										</p>
									</div>
								</div>
							</div>
						@else
							@foreach($charity->authorised_websites as $website)
								<hr/>
								<div class='row'>
									<div class='col-9 w-100 m-0 d-flex align-items-center'>
										<p class='m-0'>{{ $website->website_url }}</p>
									</div>
									<div class='col-3 text-right m-0'>
										<form method='POST' action='{{ route('modals-charities-dashboard-delete-widget-website', ['charity_slug' => $charity->slug]) }}'>
											@csrf
											<input type='hidden' name='website_id' value='{{ $website->id }}'/>
											<button type='submit' class='btn btn-secondary btn-sm m-0 pl-4'><i class='fas fa-trash p-0 m-0'></i>&nbsp; Delete</button>
										</form>
									</div>
								</div>
							@endforeach
						@endif

						@if (@$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
							<hr/>
							<div class='row col-12'>
								<p class='m-0'><small>
									<a class='btn btn-primary btn-sm m-0' data-toggle='modal' data-target='#modals-charities-invite_staff'><i class='fas fa-plus m-0'></i>&nbsp; Add website to list</a></small>
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
		@include('charities.modals.add_widget_website')
	@endif
@endsection
