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

				@error('error')
					<div class='dd_notice dd_notice_danger'>
						<i class='fad fa-skull-cow'></i>
						<p>{{ $message }}</p>
					</div>
				@enderror

				@if ($charity->needs_details_review == true)
					@if (@$charity->local_staff_user->is_representative == true)
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>Before your charity becomes active on DashDonate.org, you need to review your charity's details. Once you have confirmed your charity's details, click the save button at the bottom of this page.</p>
						</div>
					@else
						<div class='dd_notice dd_notice_warning'>
							<i class='fad fa-exclamation-triangle'></i>
							<p>Before your charity becomes active on DashDonate.org, an administrator of your charity needs to review your charity's details.</p>
						</div>
					@endif
				@endif

			</div>
			@endif


			<div class='dd_card'>
				<div class='dd_card_main dd_card_main_col dd_card_main_xpad20 dd_card_main_ypad20'>


					<div class='row mb-4'>

						<div class='col-12 justify-content-center d-flex mb-1'>
							<input type='hidden' name='charity_logo_id' form='modals-charities-dashboard-about-confirm' value='{{ @$charity->details->logo_file_id }}'>
							@if (@$charity->details->logo)
								<div class='charity_logo charity_logo_fillable'>
									<div class='logo filled' style='background-image: url("{{ env('S3_URL').$charity->details->logo->s3_url }}")'><span>You need to upload a logo</span></div>
								</div>
							@else
								<div class='charity_logo charity_logo_fillable'>
									<div class='logo'><span>You need to upload a logo</span></div>
								</div>
							@endif
						</div>

						<div class='col-12 justify-content-center d-flex collapsable_file_container charity_about_logo_upload'>
							<div class='row col-6'>

								@if (@$charity->details->logo)
									<div class='collapsable_file_removable w-100'>
										<p class='m-0 mb-2 collapsable_file_replace'><small>Click here to replace image</small></p>
									</div>
								@else
									<div class='collapsable_file_removable d-none w-100'>
										<p class='m-0 mb-2 collapsable_file_replace'><small>Click here to replace image</small></p>
									</div>
								@endif

								@if (@$charity->details->logo)
									<div class='collapsable_file mt-3 collapsed w-100'>
								@else
									<div class='collapsable_file mt-3 w-100'>
								@endif
									<div class='custom-file' file_name='charity_logo'>
										<form method='POST' id='form_charity_logo' class='file_upload_form' enctype='multipart/form-data'>
											@csrf
											<input type='hidden' name='file_intent' value='charity_logo'/>
											<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
											<div class='col-12'>
												<input type='file' class='custom-file-input' id='charity_logo' name='file_upload' accept='image/png,image/jpeg'/>
												<label class='custom-file-label' for='charity_logo'>Choose file</label>
											</div>
										</form>
										<input type='submit' form='form_charity_logo' class='btn btn-primary w-100 m-0 mt-2 file-submit' value='Upload'/>
										<div class='form_error_container mt-2' field='charity_logo'></div>
										<div class='form_success_container mt-2' field='charity_logo'></div>
									</div>
								</div>


							</div>
						</div>

						<div class='form_error_container' field='charity_logo_id'>
							@error('charity_logo_id')
								<p>{{ $message }}</p>
							@enderror
						</div>
					</div>


					<div class='px-0 col-12'>
						<label for='display_name'>Your charity's display name</label>

						@if (old('display_name'))
							<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='display_name' id='display_name' value='{{ old('display_name') }}' required/>
						@else
							@if (@$charity->details->display_name != '')
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='display_name' id='display_name' value='{{ $charity->details->display_name }}' required/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='display_name' id='display_name' value='{{ $charity->name }}' required/>
							@endif
						@endif

						<div class='form_error_container' field='display_name'>
						@error('display_name')
							<p>{{ $message }}</p>
						@enderror
						</div>
					</div>


					<div class='px-0 col-12'>
						<label for='charity_slug'>Your charity's DashDonate.org URL</label>

						<div class='input-group'>
							<div class='input-group-prepend'>
								<label class='input-group-text' for='charity_slug'>https://dashdonate.org/charities/</label>
							</div>
							@if (old('charity_slug'))
								<input class='w-100 form-control slug-input' type='text' name='charity_slug' id='charity_slug' form='modals-charities-dashboard-about-confirm' value='{{ old('charity_slug') }}' autocomplete='no' required/>
							@else
								<input class='w-100 form-control slug-input' type='text' name='charity_slug' id='charity_slug' form='modals-charities-dashboard-about-confirm' value='{{ $charity->slug }}' autocomplete='no' required/>
							@endif
						</div>

						<div class='form_error_container' field='charity_slug'>
						@error('charity_slug')
							<p>{{ $message }}</p>
						@enderror
						</div>
					</div>


					<div class='px-0 col-12 mt-3'>
						<label for='display_bio'>Your charity's description</label>

						@if (old('display_bio'))
							<textarea class='form-control' rows='12' form='modals-charities-dashboard-about-confirm' name='display_bio' id='display_bio' required>{{ old('display_bio') }}</textarea>
						@else
							@if (@$charity->details->display_bio != '')
								<textarea class='form-control mb-0' rows='12' form='modals-charities-dashboard-about-confirm' name='display_bio' id='display_bio' required>{{ $charity->details->display_bio }}</textarea>
							@else
								<textarea class='form-control mb-0' rows='12' form='modals-charities-dashboard-about-confirm' name='display_bio' id='display_bio' required>{{ $charity->details->description_of_charity }}</textarea>
							@endif
						@endif

						<div class='form_error_container' field='display_bio'>
						@error('display_bio')
							<p>{{ $message }}</p>
						@enderror
						</div>
					</div>


				</div>
			</div>


			<div class='dd_card'>
				<div class='dd_card_main dd_card_main_col dd_card_main_xpad20 dd_card_main_ypad20'>


					<h5 class='mb-0'>Contact Details</h5>
					<p class='mb-4'><small>How supporters can get in touch with your charity</small></p>

					<div class='row'>

						<div class='col-4'>
							<label for='charity_website'>Public website (without "https://" or "http://")</label>
							@if (old('charity_website'))
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='charity_website' id='charity_website' value='{{ old('charity_website') }}' required/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='charity_website' id='charity_website' value='{{ @$charity->details->charity_website }}' required/>
							@endif
							<div class='form_error_container' field='charity_website'>
							@error('charity_website')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-4'>
							<label for='phone_number'>Telephone number</label>
							@if (old('phone_number'))
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='phone_number' id='phone_number' value='{{ old('phone_number') }}' required/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='phone_number' id='phone_number' value='{{ @$charity->details->phone_number }}' required/>
							@endif
							<div class='form_error_container' field='phone_number'>
							@error('phone_number')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-4'>
							<label for='charity_email'>Email address</label>
							@if (old('charity_email'))
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='charity_email' id='charity_email' value='{{ old('charity_email') }}' required/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='charity_email' id='charity_email' value='{{ @$charity->details->charity_email }}' required/>
							@endif
							<div class='form_error_container' field='charity_email'>
							@error('charity_email')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>

					</div>


				</div>
			</div>


			<div class='dd_card'>
				<div class='dd_card_main dd_card_main_col dd_card_main_xpad20 dd_card_main_ypad20'>


					<h5 class='mb-0'>Social Profiles</h5>
					<p class='mb-4'><small>Your charity's social media profiles</small></p>

					<div class='row'>

						<div class='col-3'>
							<label for='facebook_handle'>Facebook handle</label>
							@if (old('facebook_handle'))
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='facebook_handle' id='facebook_handle' placeholder='e.g. dashdonate' value='{{ old('facebook_handle') }}'/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='facebook_handle' id='facebook_handle' placeholder='e.g. dashdonate' value='{{ @$charity->details->facebook_handle }}'/>
							@endif
							<div class='form_error_container' field='facebook_handle'>
							@error('facebook_handle')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-3'>
							<label for='twitter_handle'>Twitter handle</label>
							@if (old('twitter_handle'))
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='twitter_handle' id='twitter_handle' placeholder='e.g. dashdonate' value='{{ old('twitter_handle') }}'/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='twitter_handle' id='twitter_handle' placeholder='e.g. dashdonate' value='{{ @$charity->details->twitter_handle }}'/>
							@endif
							<div class='form_error_container' field='twitter_handle'>
							@error('twitter_handle')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-3'>
							<label for='instagram_handle'>Instagram handle</label>
							@if (old('instagram_handle'))
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='instagram_handle' id='instagram_handle' placeholder='e.g. dashdonate' value='{{ old('instagram_handle') }}'/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='instagram_handle' id='instagram_handle' placeholder='e.g. dashdonate' value='{{ @$charity->details->instagram_handle }}'/>
							@endif
							<div class='form_error_container' field='instagram_handle'>
							@error('instagram_handle')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-3'>
							<label for='linkedin_handle'>LinkedIn handle</label>
							@if (old('linkedin_handle'))
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='linkedin_handle' id='linkedin_handle' placeholder='e.g. dashdonate' value='{{ old('linkedin_handle') }}'/>
							@else
								<input class='w-100' type='text' form='modals-charities-dashboard-about-confirm' name='linkedin_handle' id='linkedin_handle' placeholder='e.g. dashdonate' value='{{ @$charity->details->linkedin_handle }}'/>
							@endif
							<div class='form_error_container' field='linkedin_handle'>
							@error('linkedin_handle')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


					</div>


				</div>
			</div>


			@if (@Auth::user()->email == 'ryan@dashdonate.org' || @$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
				@if ($charity->needs_details_review == true)
					<div class='dd_notice dd_notice_success dd_notice_large my-4 mx-0'>
						<i class='fad fa-search'></i>
						<p>Once you're sure that your charity's details are correct you can publish your charity.</p>
						<a class='btn btn-primary btn-large' data-toggle='modal' data-target='#modals-charities-details_confirm'><i class='fas fa-save'></i> Publish charity</a>
					</div>
				@else
					<a class='btn btn-primary btn-sm my-4 mx-0' data-toggle='modal' data-target='#modals-charities-details_confirm'><i class='fas fa-save m-0'></i>&nbsp; Update charity details</a></small>
				@endif
			@endif


		</div>
	</div>
@endsection




@section('modals')
	@if (@Auth::user()->email == 'ryan@dashdonate.org' || @$charity->local_staff_user->is_representative == true || @$charity->local_staff_user->role == 'administrator')
		@include('charities.modals.details_confirm')
	@endif
@endsection
