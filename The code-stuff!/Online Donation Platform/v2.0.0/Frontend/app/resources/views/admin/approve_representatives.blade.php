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
				<h1 class='mb-0'>Representative Submission</h1>
			</div>
		</div>
	</hero>

	<div class='w-100 d-flex align-items-center'>
		<div class='container px-0 public_page py-5'>
			<div class='col py-3 px-0'>

				<div class='card col'>

					<h5 class='mb-2'>Representatives</h5>

					<div class='row col-12 px-0'>
						<div class='col-2 w-100 m-0'>
							<p class='m-0'><small>Name</small></p>
						</div>
						<div class='col-1 w-100 m-0'>
							<p class='m-0'><small>Charity</small></p>
						</div>
						<div class='col-5 w-100 m-0'>
							<p class='m-0'><small>Data</small></p>
						</div>
						<div class='col-2 w-100 m-0'>
							<p class='m-0'><small>Last Updated</small></p>
						</div>
						<div class='col-2 w-100 m-0'>
							<p class='m-0'><small>Submit</small></p>
						</div>
					</div>


					@for ($i = 0; $i < sizeof($representatives); $i++)
						<div class='row col-12 px-0'>

							<div class='col-2 w-100 m-0'>
								<p class='m-0'>{{ $representatives[$i]->legal_firstname.' '.$representatives[$i]->legal_lastname }}</p>
							</div>
							<div class='col-1 w-100 m-0'>
								<p class='m-0'>{{ $representatives[$i]->charity_id }}</p>
							</div>
							<div class='col-5 w-100 m-0'>
								<p class='m-0'><small>{{ var_dump($representatives[$i]) }}</small></p>
							</div>
							<div class='col-2 w-100 m-0'>
								<p class='m-0'>{{ date('Y-m-d H:i:s', strtotime($representatives[$i]->last_updated)) }}</p>
							</div>
							<div class='col-2 w-100 m-0'>
								@if ($representatives[$i]->stripe_id_front != null && $representatives[$i]->stripe_proof_of_address != null)
									<form method='post' action='{{ route('admin-representatives_approval-submit', ['representative_id' => $representatives[$i]->id]) }}'>
										@csrf
										<p class='m-0'><button type='submit' class='btn btn-primary btn-small w-100 m-0'>Submit</button></p>
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
