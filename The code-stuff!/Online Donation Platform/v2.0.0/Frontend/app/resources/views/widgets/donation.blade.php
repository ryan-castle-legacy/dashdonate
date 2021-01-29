<div id='dd_main' stage='cover'>


	<div class='dd_block dd_head'>
		<div class='dd_head_details'>
			<div class='dd_charity_logo'><span style='background-image: url("{{ $charityInfo['logoURL'] }}");'></span></div>
			<h1>{{ $charityInfo['name'] }}</h1>
			<p>(Charity registered in {{ $charityInfo['commissionName'] }} - {{ $charityInfo['registrationNumber'] }})</p>
		</div>
	</div>


	<div class='dd_block dd_body'>
	@if ($session['enabled'] === true)

		<div class='dd_body_stage' stage='cover'>
			<div class='dd_input_group'>
				<label for='dd_amount_now' label_value='Donation amount'>Donation amount</label>
				<div class='dd_input_set'>
					<label for='dd_amount_now'>&pound;</label>
					<input id='dd_amount_now' class='dd_amount' type='number' step='0.01' min='0' value='{{ number_format($defaultDonation['now'], 2) }}'/>
				</div>
				<div class='dd_amount_suggestions'>
					<a class='dd_suggestion' value='5.00'>&pound;5</a>
					<a class='dd_suggestion' value='15.00'>&pound;15</a>
					<a class='dd_suggestion' value='25.00'>&pound;25</a>
					<a class='dd_suggestion' value='50.00'>&pound;50</a>
					<a class='dd_suggestion' value='100.00'>&pound;100</a>
				</div>
			</div>
			<div class='dd_toggle_group' id='dd_pay_fees_now' toggled='false'>
				<div class='dd_toggler'>
					<i></i>
				</div>
				<label>Add &pound;<span class='dd_pay_fees_now_amount'>0.00</span> to cover fees for this donation.</label>
			</div>
			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_two_thirds dd_personalise'>Personalise</a>
				<a class='dd_btn dd_btn_primary dd_btn_third dd_next'>Next</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='upsell'>
			<p class='dd_breaktop'></p>
			<i class='dd_graphic dd_graphic_personalise'></i>
			<h1>Why not personalise your donation?</h1>

			<p class='dd_tleft dd_personalise_keypoint'><i class='dd_icon dd_icon_schedule'></i> Schedule a donation for the future</p>
			<p class='dd_tleft dd_personalise_keypoint'><i class='dd_icon dd_icon_payday'>&pound;</i> Set up donations for pay-day</p>
			<p class='dd_tleft dd_personalise_keypoint'><i class='dd_icon dd_icon_repeating'></i> Create repeating donations for anniversaries</p>

			<p class='dd_breaktop dd_smaller'>It's easy - no need to set up Direct Debits or Standing Orders.</small></p>

			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_two_thirds dd_personalise'>Personalise</a>
				<a class='dd_btn dd_btn_primary dd_btn_third dd_next'>No Thanks</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='personalise'>
			<h1>Personalise your donation</h1>
			<p class='dd_smaller'>Select your personalisation options.</small></p>

			<div class='dd_multi_select'>
				<div class='dd_multi_option' value='schedule'>
					<i class='dd_graphic dd_graphic_scheduled'></i>
					<h3>Schedule a donation</h3>
					<p>e.g. Your birthday, or an anniversary (one-off or annually).</p>
				</div>
				<div class='dd_multi_option' value='repeating'>
					<i class='dd_graphic dd_graphic_repeating'></i>
					<h3>Set up repeating donations</h3>
					<p>e.g. On pay-day, or every 3 months (weekly, monthly, etc).</p>
				</div>
			</div>

			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_third dd_back'>Back</a>
				<a class='dd_btn dd_btn_primary dd_btn_two_thirds dd_next disabled' id='dd_personalise'>Next</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='personalise_schedule'>
			<h1>Schedule a donation</h1>
			<p class='dd_smaller dd_breakbottom'>Set a donation to be made at a later date.</small></p>

			<div class='dd_input_group'>
				<label for='dd_amount_schedule' label_value='Donation amount'>Donation amount</label>
				<div class='dd_input_set'>
					<label for='dd_amount_schedule'>&pound;</label>
					<input id='dd_amount_schedule' class='dd_amount dd_input_mt' type='number' step='0.01' min='0' value='{{ number_format($defaultDonation['scheduled'], 2) }}'/>
				</div>
			</div>
			<div class='dd_input_group'>
				<label for='dd_date_schedule-day' label_value='Date to make donation'>Date to make donation</label>
				<input id='dd_date_schedule' name='dd_date_schedule' collective='dd_date_schedule' type='hidden'/>
				<div class='dd_input_set dd_date_set'>
					<input id='dd_date_schedule-day' name='dd_date_schedule-day' class='dd_date' collective='dd_date_schedule' type='number' placeholder='DD' value='' maxlength='2' maxvalue='31' minvalue='1' pattern='[0-9]' autocomplete='no'/>
					<i class='dd_date_break'></i>
					<input id='dd_date_schedule-month' name='dd_date_schedule-month' class='dd_date' collective='dd_date_schedule' type='number' placeholder='MM' value='' maxlength='2' maxvalue='12' minvalue='1' pattern='[0-9]' autocomplete='no'/>
					<i class='dd_date_break'></i>
					<input id='dd_date_schedule-year' name='dd_date_schedule-year' class='dd_date' collective='dd_date_schedule' type='number' placeholder='YYYY' value='' maxlength='4' maxvalue='' minvalue='2' pattern='[0-9]' autocomplete='no'/>
				</div>
			</div>
			<div class='dd_toggle_group dd_twelvemt' id='dd_annual' toggled='false'>
				<div class='dd_toggler'>
					<i></i>
				</div>
				<label>Make this donation every year.</label>
			</div>
			<div class='dd_toggle_group' id='dd_notif_scheduled' toggled='true'>
				<div class='dd_toggler'>
					<i></i>
				</div>
				<label>Remind me the day before making this donation.</label>
			</div>
			<div class='dd_toggle_group' id='dd_pay_fees_scheduled' toggled='false'>
				<div class='dd_toggler'>
					<i></i>
				</div>
				<label>Add &pound;<span class='dd_pay_fees_scheduled_amount'>0.00</span> to cover fees for this donation.</label>
			</div>
			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_third dd_back'>Back</a>
				<a class='dd_btn dd_btn_primary dd_btn_two_thirds dd_next'>Next</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='personalise_repeat'>
			<h1>Set up a repeating donation</h1>
			<p class='dd_smaller dd_breakbottom'>Set donations to be made regularly.</small></p>

			<div class='dd_input_group'>
				<label for='dd_amount_repeating' label_value='Donation amount'>Donation amount</label>
				<div class='dd_input_set'>
					<label for='dd_amount_repeating'>&pound;</label>
					<input id='dd_amount_repeating' class='dd_amount dd_input_mt' type='number' step='0.01' min='0' value='{{ number_format($defaultDonation['repeating'], 2) }}'/>
				</div>
			</div>

			<div class='dd_input_group dd_repeating_group'>
				<div>
					<p>I want to donate every</p>
					<input type='number' id='dd_repeat_interval' value='1'/>
					<select id='dd_repeat_duration'>
						<option value='weeks'>weeks</option>
						<option value='months' selected>months</option>
					</select>
				</div>
				<div>
					<p>on</p>
					<select id='dd_repeat_anchor'>
						<option>the last day of the month</option>
					</select>
				</div>
			</div>
			<div class='dd_toggle_group' id='dd_notif_repeating' toggled='true'>
				<div class='dd_toggler'>
					<i></i>
				</div>
				<label>Remind me the day before making each donation.</label>
			</div>
			<div class='dd_toggle_group' id='dd_pay_fees_repeating' toggled='false'>
				<div class='dd_toggler'>
					<i></i>
				</div>
				<label>Add &pound;<span class='dd_pay_fees_repeating_amount'>0.00</span> to cover fees for these donations.</label>
			</div>
			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_third dd_back'>Back</a>
				<a class='dd_btn dd_btn_primary dd_btn_two_thirds dd_next'>Next</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='personalise_now'>
			<h1>Do you want to make a donation now?</h1>
			<p class='dd_smaller dd_breakbottom'>You can make a donation now, along with your future donations.</small></p>
			<div class='dd_input_group'>
				<label for='dd_amount_now_personalised' label_value='Donation amount'>Donation amount</label>
				<div class='dd_input_set'>
					<label for='dd_amount_now_personalised'>&pound;</label>
					<input id='dd_amount_now_personalised' class='dd_amount' type='number' step='0.01' min='0' value='0.00'/>
				</div>
				<div class='dd_amount_suggestions'>
					<a class='dd_suggestion' value='5.00'>&pound;5</a>
					<a class='dd_suggestion' value='15.00'>&pound;15</a>
					<a class='dd_suggestion' value='25.00'>&pound;25</a>
					<a class='dd_suggestion' value='50.00'>&pound;50</a>
					<a class='dd_suggestion' value='100.00'>&pound;100</a>
				</div>
			</div>
			<div class='dd_toggle_group' id='dd_pay_fees_personalise_now' toggled='false'>
				<div class='dd_toggler'>
					<i></i>
				</div>
				<label>Add &pound;<span class='dd_pay_fees_personalise_now_amount'>0.00</span> to cover fees for this donation.</label>
			</div>
			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_third dd_back'>Back</a>
				<a class='dd_btn dd_btn_primary dd_btn_two_thirds dd_next'>Next</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='giftaid'>
			<h1>Gift Aid</h1>
			<p>Gift Aid allows us to reclaim tax on any donations made by UK taxpayers, which means your donations will be worth 25% more to us at no extra cost to you.</p>
			<p class='dd_breaktop'>Once you have made a donation, you can manage your Gift Aid details via your <a href='{{ $accountURL }}' target='_blank'>DashDonate.org account</a>.</p>
			<div class='dd_multi' id='dd_giftaid_toggle'>
				<a class='dd_multi_option dd_selected' value='do_not_claim'>Do not claim Gift Aid</a>
				<a class='dd_multi_option' value='claim'>Claim Gift Aid</a>
			</div>
			<p><small><a href='{{ $giftaidInfoURL }}' target='_blank'>(More information about Gift Aid)</a></small></p>
			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_third dd_back'>Back</a>
				<a class='dd_btn dd_btn_primary dd_btn_two_thirds dd_next'>Next</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='payment'>
			<h1>Payment Details</h1>
			@if (@$cardPrefilled->sources && gettype($cardPrefilled->sources) == 'array' && @sizeof($cardPrefilled->sources) > 0)
				@php
					// Switch card brand
					switch ($cardPrefilled->sources[0]->brand) {
						case 'Visa': case 'visa':
							$savedCardBrandClass = 'visa';
						break;
						case 'American Express': case 'amex':
							$savedCardBrandClass = 'amex';
						break;
						case 'Diners Club': case 'diners':
							$savedCardBrandClass = 'diners';
						break;
						case 'Discover': case 'discover':
							$savedCardBrandClass = 'disco';
						break;
						case 'JCB': case 'jcb':
							$savedCardBrandClass = 'jcb';
						break;
						case 'MasterCard': case 'mastercard':
							$savedCardBrandClass = 'master';
						break;
						case 'UnionPay': case 'unionpay':
							$savedCardBrandClass = 'union';
						break;
						default:
							$savedCardBrandClass = 'none';
						break;
					}
				@endphp
				<div class='dd_saved_card_container dd_show'>
					<label class='dd_saved_card_label'>Your saved card</label>
					<div class='dd_saved_card dd_card_{{ $savedCardBrandClass }}'>
						<i class='dd_card_logo'></i>
						<p class='dd_card_num'>&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; {{ $cardPrefilled->sources[0]->last_four_digits }}</p>
						<p class='dd_card_expiry'><span>Expiry:</span>{{ date('m / Y', strtotime($cardPrefilled->sources[0]->expiry_date)) }}</p>
					</div>
					<p class='dd_replace_saved_card'><a>(Replace your saved card)</a></p>
				</div>
				<div class='dd_new_card_container dd_card_field_hidden'>
					<div class='dd_input_group'>
						<label for='dd_card' label_value='Card number'>Card number</label>
						<div class='dd_input_set'>
							<div id='dd_card'></div>
						</div>
						<div class='dd_input_set_pair'>
							<div class='dd_input_set_pair_item'>
								<label for='dd_expiry' label_value='Expiry'>Expiry</label>
								<div class='dd_input_set dd_input_set_half'>
									<div id='dd_expiry'></div>
								</div>
							</div>
							<div class='dd_input_set_pair_item'>
								<label for='dd_cvc' label_value='Security code (CVC)'>Security code (CVC)</label>
								<div class='dd_input_set dd_input_set_half'>
									<div id='dd_cvc'></div>
								</div>
							</div>
						</div>
					</div>
					<p class='dd_use_saved_card'><a>(Use your saved card)</a></p>
				</div>
			@else
				<div class='dd_new_card_container'>
					<div class='dd_input_group'>
						<label for='dd_card' label_value='Card number'>Card number</label>
						<div class='dd_input_set'>
							<div id='dd_card'></div>
						</div>
						<div class='dd_input_set_pair'>
							<div class='dd_input_set_pair_item'>
								<label for='dd_expiry' label_value='Expiry'>Expiry</label>
								<div class='dd_input_set dd_input_set_half'>
									<div id='dd_expiry'></div>
								</div>
							</div>
							<div class='dd_input_set_pair_item'>
								<label for='dd_cvc' label_value='Security code (CVC)'>Security code (CVC)</label>
								<div class='dd_input_set dd_input_set_half'>
									<div id='dd_cvc'></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
			@if ($emailPrefilled != false)
				<input id='dd_email' type='hidden' value='{{ $emailPrefilled }}'/>
			@else
				<div class='dd_input_group'>
					<label for='dd_email' label_value='Email address'>Email address</label>
					<div class='dd_input_set'>
						<input id='dd_email' class='dd_email dd_minor' type='email' placeholder='your@email.com'/>
					</div>
				</div>
			@endif
			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_third dd_back'>Back</a>
				<a class='dd_btn dd_btn_primary dd_btn_two_thirds dd_next'>Next</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='confirm'>
			<p class='dd_breaktop'></p>
			<i class='dd_graphic dd_graphic_confirm'></i>
			<h1 class='dd_breakbottom'>Confirm the details of your donation<span>s</span>:</h1>

			<div class='dd_tleft dd_confirm_keypoint' keypoint='pay_now'>
				<i class='dd_icon dd_icon_payday'>&pound;</i>
				<div>
					<span class='dd_confirm_item'></span>
					<span></span>
				</div>
			</div>
			<div class='dd_tleft dd_confirm_keypoint' keypoint='scheduled'>
				<i class='dd_icon dd_icon_calendar'></i>
				<div>
					<span class='dd_confirm_item'></span>
					<span></span>
				</div>
			</div>
			<div class='dd_tleft dd_confirm_keypoint' keypoint='repeating'>
				<i class='dd_icon dd_icon_repeating'></i>
				<div>
					<span class='dd_confirm_item'></span>
					<span></span>
				</div>
			</div>

			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_third dd_back'>Back</a>
				<a class='dd_btn dd_btn_primary dd_btn_two_thirds dd_next'>Confirm</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='processing'>
			<h1>We are processing your request</h1>
			<p>This should not take long, please be patient.</p>
			<i class='dd_loader'></i>
		</div>


		<div class='dd_body_stage' stage='3dsecure_card'>
			<h1>We need you to authorise your card</h1>
			<p class='dd_smaller'>Please use the frame below to authorise use of your card.</p>
			<div class='dd_3dsecure_iframe'></div>
		</div>


		<div class='dd_body_stage' stage='3dsecure_payment'>
			<h1>We need you to authorise this payment</h1>
			<p class='dd_smaller'>Please use the frame below to authorise this payment.</p>
			<div class='dd_3dsecure_iframe'></div>
		</div>


		<div class='dd_body_stage' stage='error_general'>
			<p class='dd_breaktop'></p>
			<i class='dd_graphic dd_graphic_error'></i>
			<h1>Something went wrong</h1>
			<p class='dd_breakbottom'>Don't worry, you've not been charged.</p>

			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_primary dd_back'>Go back to try again</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='error_card'>
			<p class='dd_breaktop'></p>
			<i class='dd_graphic dd_graphic_card_error'></i>
			<h1>Card authorisation failed</h1>
			<p class='dd_breakbottom'>We could not authorise your card, please try again.</p>

			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_primary dd_back'>Go back</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='error_payment'>
			<p class='dd_breaktop'></p>
			<i class='dd_graphic dd_graphic_card_error'></i>
			<h1>Payment authorisation failed</h1>
			<p class='dd_breakbottom'>We could not authorise this payment, please try again.</p>

			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_primary dd_back'>Go back</a>
			</div>
		</div>


		<div class='dd_body_stage' stage='error_expired'>
			<p class='dd_breaktop'></p>
			<i class='dd_graphic dd_graphic_error'></i>
			<h1>Session has expired</h1>
			<p class='dd_breakbottom'>Don't worry, you've not been charged.</p>
			<p class='dd_breaktop'>You need to refresh this webpage.</p>

			<div class='dd_btn_group'>
				<a class='dd_btn dd_btn_primary dd_refresh_page'>Refresh page</a>
			</div>
		</div>


		<div class='dd_body_stage dd_sticky_sections' stage='complete'>
			<div>
				<h1>{{ $charityInfo['thank_you_title'] }}</h1>
				<p>{{ $charityInfo['thank_you_message'] }}</p>
			</div>
			<div>
				<i class='dd_graphic dd_graphic_share'></i>
				<h2>Sharing your support is powerful</h2>
				@if ($isFundraisingPage === true)
					<p>Sharing this fundraiser with your friends can help {{ $fundraiserName }} raise over 3x more donations for {{ $charityInfo['name'] }}.</p>
				@else
					<p>Sharing this charity with your friends can help {{ $charityInfo['name'] }} raise over 3x more donations.</p>
				@endif
				<div class='dd_share_buttons'>
					<a class='dd_btn dd_share dd_share_facebook' site='facebook'><i></i>Facebook</a>
					<a class='dd_btn dd_share dd_share_twitter' site='twitter'><i></i>Twitter</a>
					<a class='dd_btn dd_share dd_share_linkedin' site='linkedin'><i></i>LinkedIn</a>
					<a class='dd_btn dd_share dd_share_email' site='email'><i>&#64;</i>Send Email</a>
				</div>
			</div>
		</div>

	@else
		<div class='dd_body_stage' stage='cover'>
			<p class='dd_developer_notice'><strong>Online donations are not available at this time</strong>Please advise the owner of this website to contact <a href='mailto:charities@dashdonate.org?subject=Support%20Request' target='_blank'>charities@dashdonate.org</a> for support.</p>
		</div>
	@endif
	</div>

	<div class='dd_credit'>
		<a href='https://dashdonate.org' target='_blank'>Powered by</a>
	</div>

</div>
