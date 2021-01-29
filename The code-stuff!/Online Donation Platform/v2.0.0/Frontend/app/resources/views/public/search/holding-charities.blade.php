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
				<h1>Our Charities</h1>
				<p>We're working closely with a small number of charities to perfect the services we offer.</p>
				<p class='mb-0'>This page will change as we grow, so keep checking back!</p>
			</div>
		</div>
	</hero>

	<div class='w-100 d-flex align-items-center'>
		<div class='container px-0 py-5 charity_list_page public_page'>
			<div class='row d-flex justify-content-center text-center row-eq-height'>

				@if (@$charities && sizeof($charities) > 0)
					@for ($i = 0; $i < sizeof($charities); $i++)
						<div class='col-6 d-flex justify-content-center'>
							<a class='card py-5 d-flex justify-content-center col-12 charity_grid_item' href='{{ route('charities-public-homepage', ['charity_slug' => $charities[$i]->slug]) }}' target='_blank'>

								<div class='mb-4 w-100 d-flex justify-content-center'>
									<div class='charity_logo'>
										<div class='logo filled' style='background-image: url("{{ env('S3_URL').$charities[$i]->details->logo->s3_url }}")'></div>
									</div>
								</div>
								<h2 class='mb-3'><strong>{{ $charities[$i]->details->display_name }}</strong></h2>

								<p class='mb-0'><small>{{ $charities[$i]->name }} is a registered charity in England and Wales ({{ $charities[$i]->charity_registration_number }})</small></p>

							</a>
						</div>
					@endfor
				@endif

				<div class='col-6 text-center d-flex justify-content-center'>
					<div class='card py-5 d-flex justify-content-center'>
						<h1 class='mb-4'><i class='fas fa-share-square large_icon green_icon'></i></h1>
						<h3>Refer a Charity</h3>
						<p>Do you know a charity that we could help with donations?</p>
						<p class='mb-0 mt-3'><a class='btn btn-primary' href='mailto:charities@dashdonate.org' target='_blank'>Email us about this charity</a></p>
					</div>
				</div>

			</div>
		</div>
	</div>

@endsection
