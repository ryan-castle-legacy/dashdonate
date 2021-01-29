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
			<div class='col px-0 d-flex mb-4 justify-content-center'>
				<div class='row w-100'>
					<div class='col-12'>
						<div class='card'>
							<pre>
								{{ var_dump($charity->donations) }}
							</pre>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- <pre>{{ var_dump($charity) }}</pre> --}}
@endsection
