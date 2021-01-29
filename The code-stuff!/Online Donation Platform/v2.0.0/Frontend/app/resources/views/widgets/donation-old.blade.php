<div id='dd_donation_form_main' charity_site='{{ @$charity_site }}' stage='{{ @$initial_stage }}' pi='{{ @$intent_id }}' pk='{{ @$stripe_pk }}' ddws='{{ @$widget_session }}'>

	{{-- Check if widget is disabled --}}
	@if (!$is_activated)

		<div class='dd_donation_form_stage' stage='disabled'>
			<h2>Donations Disabled</h2>
			<p>To activate donations for this charity, please sign into DashDonate.org as a charity administrator.</p>

			<a class='dd_next_stage' href='{{ route('login') }}' target='_blank'>Go to DashDonate.org</a>
		</div>

	@else

		<input type='hidden' name='dd_csrf_token' id='dd_csrf_token' value='{{ $csrf_token }}'/>

		<input type='hidden' id='dd_fee_calc' value='{{ env('MIN_FEE_FORMULA_JS') }}'/>
		<input type='hidden' id='dd_min_don' value='{{ env('MIN_DONATION_JS') }}'/>



		@if ($initial_stage == 'charity')
			<div class='dd_donation_form_stage' stage='charity'>
				<h2>Choose a Charity</h2>
				<p>Select the charities that you wish to donate to</p>

				<input type='text' name='charity_id' value=''/>

				<a class='dd_next_stage'>Next</a>
			</div>
		@endif




		<div class='dd_donation_form_stage' stage='amount'>

			<h2>Make a Donation</h2>

			<div class='dd_donate_styles'>
				<a class='dd_donate_style selected'>Give Once</a>
				<a class='dd_donate_style dd_more_options'>More Options</a>
			</div>

			<p class='dd_input_label'>Donation amount</p>
			<div class='dd_amount_group'>
				<label>&pound;</label>
				<input type='number' step='0.01' name='donation_amount' value='10'/>
			</div>
			<p class='dd_err' for='donation_amount'></p>

			<div class='dd_amount_suggestions'>
				<a class='dd_amount_suggestion' value='5'>&pound;5</a>
				<a class='dd_amount_suggestion' value='15'>&pound;15</a>
				<a class='dd_amount_suggestion' value='25'>&pound;25</a>
				<a class='dd_amount_suggestion' value='50'>&pound;50</a>
				<a class='dd_amount_suggestion' value='100'>&pound;100</a>
			</div>

			@if ($charity_chosen)
				<a class='dd_next_stage'>Next</a>
				{{-- <a class='dd_next_mid dd_more_options'>More options</a>
				<a class='dd_next_stage dd_next_mid'>Next</a> --}}
			@else
				<a class='dd_next_stage dd_next_multi'>Next</a>
				<a class='dd_prev_stage'>Go back</a>
			@endif
		</div>




		<div class='dd_donation_form_stage' stage='monthly'>
			<h2>Customise My Donation</h2>
			<p>Did you know that you can customise your donation?</p>

			<br/>

			<p class='dd_input_label'>Why not;</p>
			<p class='dd_donate_suggestion'>&bull; Schedule a donation for the future</p>
			<p class='dd_donate_suggestion'>&bull; Set a repeating donation for an anniversary</p>
			<p class='dd_donate_suggestion'>&bull; Set up donations on pay-day</p>

			<br/>

			<p class='dd_input_label'>It's really simple - no need for Direct Debits or Standing Orders.</p>

			<a class='dd_next_mid dd_more_options'>Customise my donation</a>
			<a class='dd_next_stage dd_next_mid'>No thanks</a>
		</div>




		<div class='dd_donation_form_stage' stage='more_options'>
			<h2>Customisation Options</h2>
			<p>Please select how you would like to donate</p>


			<div class='dd_custom_option'>
				<div class='dd_checkbox_input'>
					<input type='checkbox' name='dd_make_scheduled' id='dd_make_scheduled'>
					<label class='dd_form_check_label' for='dd_make_scheduled'>Schedule a future donation</label>
				</div>
			</div>

			<div class='dd_custom_option'>
				<div class='dd_checkbox_input'>
					<input type='checkbox' name='dd_make_regular' id='dd_make_regular'>
					<label class='dd_form_check_label' for='dd_make_regular'>Setup regular donations</label>
				</div>
			</div>

			<a class='dd_next_stage dd_next_multi next_disabled'>Next</a>
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='more_options_scheduled'>
			<h2>Schedule a Donation</h2>
			<p>Pick a date for your donation.</p>

			<div class='dd_donation_form_group'>
				<label for='scheduled_donation_amount'>Donation amount</label>

				<div class='dd_amount_group'>
					<label>&pound;</label>
					<input type='number' step='0.01' name='scheduled_donation_amount' id='scheduled_donation_amount' value='10'/>
				</div>
				<p class='dd_err' for='scheduled_donation_amount'></p>
			</div>

			<div class='dd_donation_form_group'>
				<label for='scheduled_donation_date'>Date to take this donation</label>

				<div class='dd_donation_input_group'>
					<input type='number' class='date-format dd_input_validate' collective='scheduled_donation_date' id='scheduled_donation_date-day' name='scheduled_donation_date-day' value='' maxlength='2' maxvalue='31' minvalue='1' placeholder='DD' pattern='[0-9]' autocomplete='no' required/>

					<input type='number' class='date-format dd_input_validate' collective='scheduled_donation_date' id='scheduled_donation_date-month' name='scheduled_donation_date-month' value='' maxlength='2' maxvalue='12' minvalue='1' placeholder='MM' pattern='[0-9]' autocomplete='no' required/>

					<input type='number' class='date-format dd_input_validate' collective='scheduled_donation_date' id='scheduled_donation_date-year' name='scheduled_donation_date-year' value='' maxlength='4' maxvalue='' minvalue='1' placeholder='YYYY' pattern='[0-9]' autocomplete='no' required/>
				</div>

				<input type='hidden' valid_date name='scheduled_donation_date' required/>
				<p class='dd_err' for='scheduled_donation_date'></p>
			</div>

			<a class='dd_next_stage dd_next_multi'>Next</a>
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='more_options_repeat'>
			<h2>Donate Regularly</h2>
			<p>Make a regular donation</p>

			<div class='dd_donation_form_group'>
				<label for='repeat_donation_amount'>Donation amount</label>
				<div class='dd_amount_group'>
					<label>&pound;</label>
					<input type='number' step='0.01' name='repeat_donation_amount' id='repeat_donation_amount' value='10'/>
				</div>
				<p class='dd_err' for='repeat_donation_amount'></p>
			</div>

			<p>How regularly do you want to donate?</p>
			<div class='dd_donation_frequency'>
				<div class='dd_donation_form_group'>
					<label for='repeat_interval'>Every</label>
					<input type='number' name='repeat_interval' id='repeat_interval' value='1' minvalue='1' maxvalue='99'/>
				</div>

				<div class='dd_donation_form_group'>
					<select name='repeat_duration' id='repeat_duration'>
						<option value='weeks'>Weeks</option>
						<option value='months' selected>Months</option>
					</select>
				</div>
			</div>

			<div class='dd_donation_frequency dd_repeat_anchor'>
				<div class='dd_donation_form_group'>
					<label for='repeat_anchor'>On</label>
					<select name='repeat_anchor' id='repeat_anchor'></select>
					<p class='dd_err' for='repeat_anchor'></p>
				</div>
			</div>

			<p class='dd_err' for='repeat_duration'></p>
			<p class='dd_err' for='repeat_interval'></p>

			<a class='dd_next_stage dd_next_multi'>Next</a>
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='more_options_contact'>
			<h2>Contact Preferences</h2>
			<p>By default, we'll email you a day before taking donations.</p>

			<div class='dd_custom_option'>
				<div class='dd_checkbox_input'>
					<input type='checkbox' name='dd_turn_off_notifications' id='dd_turn_off_notifications'>
					<label class='dd_form_check_label' for='dd_turn_off_notifications'>Turn off these notifications</label>
				</div>
			</div>

			<a class='dd_next_stage dd_next_multi'>Next</a>
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='more_option_pay_today'>
			<h2>Do you want to donate now?</h2>

			<br/>

			<p class='dd_input_label'>Donation amount</p>
			<div class='dd_amount_group'>
				<label>&pound;</label>
				<input type='number' step='0.01' name='donation_amount_now' id='donation_amount_now' value='0'/>
			</div>
			<p class='dd_err' for='donation_amount_now'></p>

			<a class='dd_next_stage dd_next_multi'>Next</a>
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='fees'>
			<h2>Processing Fees</h2>
			<p>Would you like to cover the payment processing fees for your donation?</p>

			<div class='dd_fee_pay_option hidden' fee_field='now'>
				<div class='dd_checkbox_input'>
					<input type='checkbox' name='dd_pay_fees_now' id='dd_pay_fees_now'>
					<label class='dd_form_check_label' for='dd_pay_fees_now'>Add &pound;<span class='dd_donation_form_stage_fees_add'>1.00</span>&nbsp;to cover processing fees<br/>(for the donation taken now)</label>
				</div>
			</div>

			<div class='dd_fee_pay_option hidden' fee_field='scheduled'>
				<div class='dd_checkbox_input'>
					<input type='checkbox' name='dd_pay_fees_scheduled' id='dd_pay_fees_scheduled'>
					<label class='dd_form_check_label' for='dd_pay_fees_scheduled'>Add &pound;<span class='dd_donation_form_stage_fees_add'>1.00</span>&nbsp;to cover processing fees<br/>(for your scheduled donation)</label>
				</div>
			</div>

			<div class='dd_fee_pay_option hidden' fee_field='repeat'>
				<div class='dd_checkbox_input'>
					<input type='checkbox' name='dd_pay_fees_repeat' id='dd_pay_fees_repeat'>
					<label class='dd_form_check_label' for='dd_pay_fees_repeat'>Add &pound;<span class='dd_donation_form_stage_fees_add'>1.00</span>&nbsp;to cover processing fees<br/>(for your regular donation)</label>
				</div>
			</div>

			<a class='dd_next_stage dd_next_multi'>Next</a>
			{{-- <a class='dd_next_stage dd_next_multi'>Pay &pound;<span class='dd_donation_form_stage_fees_button_num'>10.00</span>&nbsp;by card</a> --}}
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='giftaid'>
			<h2>Are you eligible for Gift Aid</h2>
			<p>Gift Aid allows us to claim an extra 25p for every &pound;1 that you donate, at no cost to you.</p>

			<br/>

			<p>You are eligible for Gift Aid if you are a UK taxpayer.</p>
			<p>You must understand that if you pay less Income Tax and/or Capital Gains Tax than the amount of Gift Aid claimed on all of your donations in that tax year it is your responsibility to pay any difference.</p>

			<div class='dd_fee_pay_option'>
				<div class='dd_checkbox_input'>
					<input type='checkbox' name='dd_giftaid' id='dd_giftaid'>
					<label class='dd_form_check_label' for='dd_giftaid'>I am elibile for giftaid</label>
				</div>
			</div>

			<a class='dd_next_stage dd_next_multi'>Next</a>
			{{-- <a class='dd_next_stage dd_next_multi'>Pay &pound;<span class='dd_donation_form_stage_fees_button_num'>10.00</span>&nbsp;by card</a> --}}
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='payment_details'>
			<h2>Payment Details</h2>

			<div class='dd_donation_form_stage_secure'>
				<i class=''></i>
				<p>We use <a href='https://stripe.com' target='_blank'>Stripe.com</a> to process donations, which ensures that your payment information is always stored and processed securely.</p>
			</div>

			@if (@$email_prefillable == false)
				<div class='dd_donation_form_group'>
					<label for='email_address'>Email address</label>
					<input type='email' id='email_address' name='email_address' value=''/>
					<p class='dd_err' for='email_address'></p>
				</div>
			@else
				<input type='hidden' id='email_address' name='email_address' value='{{ $email_prefillable_value }}'/>
			@endif

			<div class='dd_donation_form_group'>
				<label for=''>Credit or debit card</label>
				<div id='dd_donation_form_card'></div>
				<!-- Used to display form errors -->
				<p class='dd_err' for='dd_card_errors'></p>
				{{-- <div id='card-errors'></div> --}}
			</div>

			<a class='dd_next_stage dd_next_multi'>Next</a>
			{{-- <a class='dd_next_stage dd_next_multi'>Pay &pound;<span class='dd_donation_form_stage_pay_btn_num'>10.00</span></a> --}}
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='confirm'>
			<h2>Confirm Donation</h2>
			<p>Please confirm your donation</p>

			<br/>

			<div summary_field='now'><p></p></div>
			<div summary_field='scheduled'><p></p></div>
			<div summary_field='repeat'><p></p></div>

			<a class='dd_next_stage dd_next_multi'>Donate now</span></a>
			<a class='dd_prev_stage'>Go back</a>
		</div>




		<div class='dd_donation_form_stage' stage='3d_secure'>
			<h2>Authorise Payment</h2>
			<div id='dd_donation_form_3d_secure'></div>
		</div>




		<div class='dd_donation_form_stage' stage='3d_secure_card'>
			<h2>Authorise Card</h2>
			<div id='dd_donation_form_3d_secure_card'></div>
		</div>




		<div class='dd_donation_form_stage' stage='error'>
			<h2>Something went wrong</h2>
			<p>Don't worry, we have not charged you.</p>

			<a class='dd_prev_stage dd_prev_stage_full'>Retry</a>
		</div>




		<div class='dd_donation_form_stage' stage='auth_failed'>
			<h2>Authentication Failed</h2>
			<p>Your payment failed to authenticate.</p>

			<a class='dd_prev_stage dd_prev_stage_full'>Retry</a>
		</div>




		<div class='dd_donation_form_stage' stage='card_auth_failed'>
			<h2>Authentication Failed</h2>
			<p>Your card failed to authenticate.</p>

			<a class='dd_prev_stage dd_prev_stage_full'>Retry</a>
		</div>




		<div class='dd_donation_form_stage' stage='card_declined'>
			<h2>Card Declined</h2>
			<p>Your card failed to charge.</p>

			<a class='dd_prev_stage dd_prev_stage_full'>Retry</a>
		</div>




		<div class='dd_donation_form_stage' stage='success'>
			<h2>Thank You</h2>
			<p>You will receive an email confirmation shortly about your donation</p>

			@if (!$is_on_dashdonate)
				<a href='https://dashdonate.org' target='_blank'>
					<div class='dd_donation_form_stage_manage'>
						<i class=''></i>
						<p>To view and manage your donations, head over to DashDonate.org.</p>
					</div>
				</a>
			@endif

		</div>




		<div class='dd_donation_form_stage' stage='processing'>
			<h2>Processing</h2>
			<p>We are processing your donation, please wait</p>
		</div>

	@endif

	@if ($show_credit)
		<div class='dd_donation_form_credit'>
			<a href='{{ $powered_by_link }}' target='_blank'>Powered by<span></span></a>
		</div>
	@endif

<div>
