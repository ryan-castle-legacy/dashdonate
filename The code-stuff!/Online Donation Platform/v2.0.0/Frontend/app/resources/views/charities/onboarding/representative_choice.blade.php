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
	<div class='bg-blue w-100 min-height-100 pb-5'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>Charity Representative</h1>
				<p class='mb-3'>A trustee is needed to represent your charity on DashDonate.org.</p>
			</div>
		</div>
		<div class='container pb-5 charity_public_page'>


			<div class='row d-flex mb-4 justify-content-center'>


				<div class='col-6'>
					<div class='card'>
						<h3 class='text-center mb-3'>Trustees</h3>
						<p>I am a registered trustee of this charity, and I am happy to be the legal representative on DashDonate.org.</p>
						<a href='{{ route('charities-onboarding-confirm_details', ['charity_slug' => $charity->slug, 'optional' => 'representative']) }}' class='btn btn-primary btn-block'>I will represent my charity</a>
					</div>
				</div>


				<div class='col-6'>
					<div class='card'>
						<h3 class='text-center mb-3'>Staff</h3>
						<p>I need to invite a trustee to DashDonate.org to represent my charity.</p>
						<a href='{{ route('charities-onboarding-confirm_details', ['charity_slug' => $charity->slug, 'optional' => 'invite']) }}' class='btn btn-primary btn-block'>Invite a trustee</a>
					</div>
				</div>


			</div>


		</div>
	</div>
@endsection
