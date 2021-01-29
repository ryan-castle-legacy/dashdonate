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
				<h1 class='mb-0'>Charity Approval</h1>
			</div>
		</div>
	</hero>

	<div class='w-100 d-flex align-items-center'>
		<div class='container px-0 public_page py-5'>
			<div class='col py-3 px-0'>

				<div class='card col'>

					<h5 class='mb-2'>Charities</h5>

					<div class='row col-12 px-0'>
						<div class='col-4 w-100 m-0'>
							<p class='m-0'><small>Name</small></p>
						</div>
						<div class='col-3 w-100 m-0'>
							<p class='m-0'><small>Data</small></p>
						</div>
						<div class='col-3 w-100 m-0'>
							<p class='m-0'><small>Date Registered</small></p>
						</div>
						<div class='col-2 w-100 m-0'>
							<p class='m-0'><small>Action</small></p>
						</div>
					</div>


					@for ($i = 0; $i < sizeof($charities); $i++)
						<div class='row col-12 px-0'>
							<div class='col-4 w-100 m-0'>
								<p class='m-0'>{{ $charities[$i]->name }}</p>
							</div>
							<div class='col-3 w-100 m-0'>
								<p class='m-0'><small>{{ var_dump($charities[$i]) }}</small></p>
							</div>
							<div class='col-3 w-100 m-0'>
								<p class='m-0'>{{ date('Y-m-d H:i:s', strtotime($charities[$i]->date_created)) }}</p>
							</div>
							<div class='col-2 w-100 m-0'>
								@if ($charities[$i]->needs_dashdonate_approval == true)
									<form method='post' action='{{ route('admin-charity_approval-submit', ['charity_id' => $charities[$i]->id]) }}'>
										@csrf
										<input type='hidden' name='intent' value='approve'/>
										<p class='m-0'><button type='submit' class='btn btn-primary btn-small w-100 m-0'>Approve</button></p>
									</form>
								@else
									<form method='post' action='{{ route('admin-charity_approval-submit', ['charity_id' => $charities[$i]->id]) }}'>
										@csrf
										<input type='hidden' name='intent' value='disable'/>
										<p class='m-0'><button type='submit' class='btn btn-secondary btn-small w-100 m-0'>Disable</button></p>
									</form>
								@endif
							</div>
						</div>
						<hr/>
					@endfor


				</div>
			</div>
		</div>
	</div>
@endsection
