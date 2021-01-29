<div class='modal' id='modals-charities-invite_staff' tabindex='-1' role='dialog' aria-hidden='true'>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title'>Add Website</h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>
			<form class='modal-body row auto_validate_forms' id='modals-charities-dashboard-add-widget-website' action='{{ route('modals-charities-dashboard-add-widget-website', ['charity_slug' => $charity->slug]) }}' method='POST'>
				@csrf


				<div class='col-12'>
					<label for='email'>Website URL</label>
					<input class='w-100' type='url' name='url' id='url' value='{{ old('url') }}' required/>

					<div class='form_error_container' field='url'>
					@error('url')
						<p>{{ $message }}</p>
					@enderror
					</div>

					@if(session('success'))
						<div class='form_success_container'>
							<p>{{ session('success') }}</p>
						</div>
					@enderror

				</div>


				<div class='col-12 mt-0'>

					<input type='submit' class='btn btn-block btn-primary mx-0' form='modals-charities-dashboard-add-widget-website' value='Add to list'/>

					<button type='button' class='btn btn-link w-100 btn-sm btn-block mx-0' data-dismiss='modal'>Cancel</button>

				</div>


			</form>
		</div>
	</div>
</div>
