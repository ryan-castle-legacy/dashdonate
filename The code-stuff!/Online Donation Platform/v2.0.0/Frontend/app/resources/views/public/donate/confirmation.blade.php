@extends('layouts.main')




@section('pre-scripts')
	<script>window.DashDonate=window.DashDonate||{};window.DashDonate.pk='{{ env('STRIPE_PK') }}'</script>
	<script>window.DashDonate.sharingLink='https://dashdonate.org/charities/{{ $task->charity->slug }}';
	window.DashDonate.sharingPrewritten='I\'m supporting {{ $task->charity->details->display_name }} via DashDonate.org, take a look at the amazing work they are doing!';
	window.DashDonate.sharingSubject='I\'m supporting {{ $task->charity->details->display_name }}!';
	window.DashDonate.sharingBody='I\'m supporting {{ $task->charity->details->display_name }} via DashDonate.org, take a look at the amazing work they are doing!\n\n' + window.DashDonate.sharingLink;
</script>
@endsection




@section('post-scripts')
	<script src='https://js.stripe.com/v3/'></script>
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
	<link rel='stylesheet' href='{{ asset('widgets/donation.css') }}'/>
@endsection




@section('content')

{{-- <pre>{{ var_dump($task->meta->fees) }}</pre> --}}

	@csrf
	<hero class='bg-blue w-100 min-height-100 d-flex align-items-center' task='{{ $task->task_token }}'>
		<div id='auth_widget' class='container p-0'>

			<div id='dd_widget_head'>
				<h1>We need you to authorise your donation of <strong>&pound;{{ number_format($task->meta->fees->totalCharge / 100, 2) }}</strong> to <strong>{{ $task->charity->details->display_name }}</strong>.</h1>
				<p>A charity registered in {{ $task->charity->details->commission_name }} - {{ $task->charity->charity_registration_number }}</p>
			</div>

			<div id='dd_widget'>

				<div id='dd_main' stage='payment'>


					<div class='dd_block dd_head'>
						<div class='dd_head_details'>
							<div class='dd_charity_logo'><span style='background-image: url("{{ env('S3_URL').$task->charity->details->logo->s3_url }}");'></span></div>
						</div>
					</div>


					<div class='dd_block dd_body'>

						<div class='dd_body_stage' stage='payment'>
							<h1>Payment Details</h1>
							@if (@$task->default_card && gettype($task->default_card) == 'object')
								@php
									// Switch card brand
									switch ($task->default_card->brand) {
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
										<p class='dd_card_num'>&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; {{ $task->default_card->last_four_digits }}</p>
										<p class='dd_card_expiry'><span>Expiry:</span>{{ date('m / Y', strtotime($task->default_card->expiry_date)) }}</p>
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
							<input id='dd_email' type='hidden' value='{{ Auth::user()->email }}'/>
							<div class='dd_btn_group'>
								<a class='dd_btn dd_btn_primary dd_next submitAuth'>Donate Now</a>
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
								<h1>{{ $task->charity->widgetText['thank_you_title'] }}</h1>
								<p>{{ $task->charity->widgetText['thank_you_message'] }}</p>
							</div>
							<div>
								<i class='dd_graphic dd_graphic_share'></i>
								<h2>Sharing your support is powerful</h2>
								@if (@$isFundraisingPage === true)
									<p>Sharing this fundraiser with your friends can help {{ @$fundraiserName }} raise over 3x more donations for {{ $charityInfo['name'] }}.</p>
								@else
									<p>Sharing this charity with your friends can help {{ $task->charity->details->display_name }} raise over 3x more donations.</p>
								@endif
								<div class='dd_share_buttons'>
									<a class='dd_btn dd_share dd_share_facebook' site='facebook'><i></i>Facebook</a>
									<a class='dd_btn dd_share dd_share_twitter' site='twitter'><i></i>Twitter</a>
									<a class='dd_btn dd_share dd_share_linkedin' site='linkedin'><i></i>LinkedIn</a>
									<a class='dd_btn dd_share dd_share_email' site='email'><i>&#64;</i>Send Email</a>
								</div>
							</div>
						</div>
					</div>

					<div class='dd_credit'>
						<a href='https://dashdonate.org' target='_blank'>Powered by</a>
					</div>

				</div>
			</div>
		</div>
	</hero>
@endsection
