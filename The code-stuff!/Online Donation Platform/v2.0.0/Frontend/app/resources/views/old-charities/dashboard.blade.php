@extends('layouts.main')

@section('content')
	<div class='dashboard'>
		<div class='dash_nav'>

			@if ($charity->verified == false)
				<p><a href='{{ route('charities-dashboard_setup', ['charity_id' => $charity->id]) }}'>Verify my charity</a></p>
			@endif

			<p><a href='{{ route('charities-dashboard', ['charity_id' => $charity->id]) }}'>Dashboard</a></p>
			<p><a href='{{ route('charities-dashboard_donations', ['charity_id' => $charity->id]) }}'>Donations</a></p>
			<p><a href='{{ route('charities-dashboard_staff', ['charity_id' => $charity->id]) }}'>Staff</a></p>
		</div>
		<div class='dash_main'>

			@if ($charity->verified == false)
				<div class='col px-0 d-flex mb-4 justify-content-center'>

					<div class='alert alert-warning w-100 mx-3'>
						<p class='m-0 p-0'>
							<i class='fas fa-exclamation-triangle'></i>
							Your charity will not be visible to the public unless missing information is added.
						</p>
						<a href='{{ route('charities-dashboard_setup', ['charity_id' => $charity->id]) }}' class='btn btn-warning mx-0'><i class='fas fa-plus ml-0'></i> Add Information</a>
					</div>

				</div>
			@endif

			<div class='col px-0 d-flex mb-4 justify-content-center'>
				<div class='row w-100'>
					<div class='col-3'>
						<div class='card'>
							Today vs Yesterday
						</div>
					</div>
					<div class='col-3'>
						<div class='card'>
							Monthly + Trend
						</div>
					</div>
					<div class='col-3'>
						<div class='card'>
							Estimated donations this month
						</div>
					</div>
					<div class='col-3'>
						<div class='card'>
							Total Num Donations & Total Value
						</div>
					</div>
				</div>
			</div>
			<div class='col px-0 d-flex mb-4 justify-content-center'>
				<div class='row w-100'>
					<div class='col-8'>
						<div class='card'>
							Feed
						</div>
					</div>
					<div class='col-4'>
						<div class='card'>
							<pre>
								{{ var_dump($charity->donations) }}
							</pre>
						</div>
						<div class='card'>
							Latest Activity
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- <pre>{{ var_dump($charity) }}</pre> --}}
@endsection
