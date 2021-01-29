@extends('layouts.main')

@section('content')
	<hero class='bg-blue w-100'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1 class='hero mb-3'>Help us change charity, for good.</h1>
			</div>
			<div class='col py-3 text-center'>
				@if (@session('success_message'))
					<div class='row flex-middle'>
						<p>You've been added to our waiting list, thank you!</p>
					</div>
					<form class='row flex-middle' method='POST' action='{{ route('pre-signup') }}'>
						@csrf
						<input type='email' name='email' disabled id='email' value='{{ old('email') }}' placeholder='Email address' required/>
						<input type='hidden' name='type' value='unknown'/>
						<input type='submit' class='btn btn-primary mr-0' value='Keep me posted' disabled/>
					</form>
				@else
					<div class='row flex-middle'>
						<p>Want to get notified when we launch?</p>
					</div>
					<form class='row flex-middle' method='POST' action='{{ route('pre-signup') }}'>
						@csrf
						<input type='email' name='email' id='email' value='{{ old('email') }}' placeholder='Email address' required/>
						<input type='hidden' name='type' value='unknown'/>
						<input type='submit' class='btn btn-primary mr-0' value='Keep me posted'/>
					</form>
				@endif
			</div>
		</div>
	</hero>
	<div>
		<div class='container py-5'>
			<div class='row px-0 py-3 mb-4 justify-content-between key_point'>
				<div class='col-12 text-center'>
					<p>Currently the team at DashDonate are focussing on the creation of our platform so that we can help charities as soon as possible. Due to the focus on development, we aren't able to spend as much time and money as we'd like on telling donors and charities about us.</p>
					<p>We'd be honoured if you could help us!</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Tell a charity about us</strong></h4>
				</div>
				<div class='col-8'>
					<p>If you know someone that works for a charity, we'd love for them to get in touch with us to see how we can help increase the number of donations they receive.</p>
					<p>Please get in contact with the charity worker you know and send them a link to our page for charities: https://dashdonate.org/for-charities</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Share on social media</strong></h4>
				</div>
				<div class='col-8'>
					<p>Our social media accounts are pretty new, and we don't have many followers. It'd be great if you could give us a like, share, and/or follow to help spread the word about us.</p>
					<p class='socials center flex-end mb-3'>
						<a href='https://www.facebook.com/dashdonate/' target='_blank'><i class='fab fa-facebook-square'></i></a>
						<a href='https://twitter.com/dashdonate' target='_blank'><i class='fab fa-twitter'></i></a>
						<a href='https://www.instagram.com/dashdonate/' target='_blank'><i class='fab fa-instagram'></i></a>
					</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Contribute to the project</strong></h4>
				</div>
				<div class='col-8'>
					<p>Creating a website costs a lot of money, and even once that's done, there are a large number of costs associated with contacting charities, marketing, and general business-running. Most of these items are being funded by Ryan Castle, our founder (<a href='{{ route('public-about_dashdonate') }}' target='_blank' class='border_link'>read his story here</a>).</p>
					<p>We're going to help charities regardless, however a contribution as little as &pound;2 will really make a difference in how many charities we can help. We would really appreciate if you could contribute.</p>

					<div class='col-12 login_card_cont justify-content-center align-content-center d-flex '>
						<div class='card login_card mt-5'>
							<form method='POST' id='payment-form' class='col' action='{{ route('public-contribute_submit') }}'>
							{{-- <form action="{{ route('payment-add_card') }}" method="post" id="payment-form"> --}}
								@csrf
								<p class='mb-0 w-100'><label for='name'>Your name</label></p>
								<input class='w-100' type='text' name='name' id='name' value='{{ old('name') }}' required/>
								@if (@session('form_error') && session('form_error') == 'name_is_required')
									<p class='form_error_message' for='name' style='display: block'>Your name is required.</p>
								@else
									<p class='form_error_message' for='name'>Your name is required.</p>
								@endif

								<p class='mb-0 w-100'><label for='email'>Email address</label></p>
								<input class='w-100' type='email' name='email' id='email' value='{{ old('email') }}' required/>
								@if (@session('form_error') && session('form_error') == 'email_invalid')
									<p class='form_error_message' for='email' style='display: block'>This is not a valid email address.</p>
								@else
									<p class='form_error_message' for='email'>This is not a valid email address.</p>
								@endif

								<label for='hearabout'>How did you hear about DashDonate?</label>
								<select id='hearabout' name='hearabout'>
									<option value='Word of mouth'>Word of mouth</option>
									<option value='LinkedIn'>LinkedIn</option>
									<option value='Twitter'>Twitter</option>
									<option value='Facebook'>Facebook</option>
									<option value='Other'>Other</option>
								</select>

								<hr/>

								<label for='donation_amount_not_final'>Amount you want to contribute</label>
								<div class='money_input'>
									<input type='number' name='donation_amount_not_final' id='donation_amount_not_final' value='5.00' required/>
									<i>&pound;</i>
								</div>
								@if (@session('form_error') && session('form_error') == 'donation_too_low_warning')
									<p class='form_error_message' for='donation_amount_not_final' style='display: block'>Please ensure your contribution is &pound;2 or more</p>
								@else
									<p class='form_error_message' for='donation_amount_not_final'>Please ensure your contribution is &pound;2 or more</p>
								@endif

								<label for='card-element'>Credit or debit card</label>
								<div id='card-element'>
									<!-- a Stripe Element will be inserted here. -->
								</div>
								<!-- Used to display form errors -->
								<div id='card-errors'></div>

								<script src='https://js.stripe.com/v3/'></script>
								<script>var stripe_pk = '{{ env('STRIPE_PK') }}';</script>

								<hr/>

								<div class='checkbox-input mb-0'>
									<input type='checkbox' name='get_in_touch' id='get_in_touch' checked>
									<label class='form-check-label' for='get_in_touch'>I'm happy to be contacted about my contribution</label>
								</div>

								<label class='mt-4'>By clicking 'contribute', I agree to the <a class='border_link' href='{{ route('public-terms_contribute') }}' target='_blank'>terms of contribution</a> and <a class='border_link' href='{{ route('public-privacy') }}' target='_blank'>privacy policy</a>.</label>


								<input type='submit' class='btn btn-primary ml-0 mt-3 mr-0' value='Contribute'/>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>








						{{-- <div class="card-body">
							<h5>Donation amount (&pound;)</h5>
							<form action='{{ route('charity-donate_submit', ['slug' => $charity->slug]) }}' method='POST'>
								@csrf

								@if (@old('donation_amount_not_final'))
									<input type='number' class='form-control form-control-lg' step='0.01' name='donation_amount_not_final' placeholder='0.00' value='{{ old('donation_amount_not_final') }}' autofocus/>
								@else
									<input type='number' class='form-control form-control-lg' step='0.01' name='donation_amount_not_final' placeholder='0.00' value='10.00' autofocus/>
								@endif
								<input type='hidden' name='donation_amount' value=''/>


								@if (@session('form_error') && session('form_error') == 'donation_too_low_warning')
									<p class='alert alert-danger mt-1 mb-0 w-100 border-red donation_too_low_warning'>Your donation amount must be at least &pound;{{ env('MIN_DONATION_PHP') }}.</p>
								@else
									<p class='alert alert-danger mt-1 mb-0 w-100 border-red donation_too_low_warning d-none'>Your donation amount must be at least &pound;{{ env('MIN_DONATION_PHP') }}.</p>
								@endif





								<p>Space for repeat/monthly/etc</p>





								@if ($cards && @sizeof($cards) > 0)
									<p>Choose payment source - <a href='{{ route('donation-add_card-empty', ['slug' => $charity->slug]) }}'>Add new card</a></p>

									@if (sizeof($cards) == 1)
										<p>**** **** **** {{ $cards[0]->last_four_digits }} - Expires {{ date('jS F Y', strtotime($cards[0]->expiry_date)) }}</p>
										<input type='hidden' name='card_id' value='{{ $cards[0]->id }}'/>
									@else
										<select class='form-control' name='card_id'>
										@for ($i = 0; $i < sizeof($cards); $i++)
											@if (@old('card_id') == $cards[$i]->id)
												<option value='{{ $cards[$i]->id }}' selected>**** **** **** {{ $cards[0]->last_four_digits }} - Expires {{ date('jS F Y', strtotime($cards[$i]->expiry_date)) }}</option>
											@else
												<option value='{{ $cards[$i]->id }}'>**** **** **** {{ $cards[0]->last_four_digits }} - Expires {{ date('jS F Y', strtotime($cards[$i]->expiry_date)) }}</option>
											@endif
										@endfor
										</select>
									@endif

									<hr/>

									<div class='card w-100 p-2 form-check'>
										@if (@old('hide_donation') == 'on')
											<input type='checkbox' class='form-control form-check-input' name='hide_donation' id='hide_donation' checked/>
										@else
											<input type='checkbox' class='form-control form-check-input' name='hide_donation' id='hide_donation'/>
										@endif
										<label class='mb-0 form-check-label' for='hide_donation'>Hide my donation from the public.</label>
									</div>

									<hr/>

									<div class='card w-100 p-2'>
										<p>Unlike most other donation platforms, DashDonate is a platform created by a charity. Our charity, The Ryan Castle Foundation, doesn't charge charities any membership or payment processing fees. Adding a small donation to us means we can continue to help more people. <a href='{{ route('charity-homepage', ['slug' => 'the-ryan-castle-foundation']) }}' target='blank'>Find out more about us</a>.</p>


										<select name='additional_donation' class='form-control'>
											<option value='fees_only'>Payment processing fees only (&pound;)</option>
											<option value='other'>Other</option>
										</select>
										@if (@session('form_error') && session('form_error') == 'unknown_fee_type')
											<p class='alert alert-danger mt-1 mb-0 w-100 border-red additional_not_valid_warning'>Something went wrong, please re-select your chosen option.</p>
										@endif



										<div class='additional_donation_other_dropdown d-none'>
											<p class='mb-0 mt-3'>Additional amount (&pound;)</p>
											<input type='number' class='form-control form-control-lg' step='0.01' name='additional_donation_other' placeholder='0.00'/>
										</div>
										@if (@session('form_error') && (session('form_error') == 'no_additional_fees_added' || session('form_error') == 'additional_fees_too_low'))
											<p class='alert alert-danger mt-1 mb-0 w-100 border-red additional_too_low_warning'>Your additional amount must be more than our payment processor's fees (<strong>&pound;{{ session('form_error_info') }}</strong>).</p>
										@else
											<p class='alert alert-danger mt-1 mb-0 w-100 border-red additional_too_low_warning d-none'>Your additional amount must be more than our payment processor's fees (<strong></strong>).</p>
										@endif
									</div>

									<hr/>
									<input type='submit' class='m-0 btn btn-primary' value='Pay' name='donate_submit_button'/>
								@else
									<p><a href='{{ route('donation-add_card-empty', ['slug' => $charity->slug]) }}'>Add new card</a></p>
								@endif
							</form>
						</div> --}}

@endsection
