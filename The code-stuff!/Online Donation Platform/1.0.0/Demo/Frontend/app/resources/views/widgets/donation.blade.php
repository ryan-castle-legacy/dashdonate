<div id='dd_donation_form_main' charity_site='{{ $charity_site }}' stage='amount' pk='{{ env('STRIPE_PK') }}'>

	<input type='hidden' name='dd_csrf_token' id='dd_csrf_token' value='{{ csrf_token() }}'/>

	<div class='dd_donation_form_header'>
		<p class='dd_donation_form_logo'><span style='background-image: url("{{ $charity_logo }}");'></span></p>
		<p class='dd_donation_form_title'>Donate to {{ $charity_name }}</p>
	</div>

	<div class='dd_donation_form_stages'>

		<div class='dd_donation_form_stage' stage='amount'>

			<div class='dd_donation_form_group dd_donation_form_group_amount_frequency'>
				<a class='dd_donation_form_group_amount_frequency_item selected' value='one-off'>Give Once</a>
				<a class='dd_donation_form_group_amount_frequency_item' value='custom'>Customised</a>
			</div>

			<div class='dd_donation_form_group dd_donation_form_group_amount_suggestions'>
				<a class='dd_donation_form_group_amount_suggestions_suggestion' value='1000'>&pound;10</a>
				<a class='dd_donation_form_group_amount_suggestions_suggestion' value='2000'>&pound;20</a>
				<a class='dd_donation_form_group_amount_suggestions_suggestion selected' value='3000'>&pound;30</a>
				<a class='dd_donation_form_group_amount_suggestions_suggestion' value='5000'>&pound;50</a>
				<a class='dd_donation_form_group_amount_suggestions_suggestion' value='10000'>&pound;100</a>
			</div>
			<div class='dd_donation_form_group dd_donation_form_group_currency'>
				<input type='number' class='large' id='dd_donation_form_amount' name='dd_donation_form_amount' value='30.00'/>
				<label for='dd_donation_form_amount'>&pound;</label>
			</div>
			<a class='dd_donation_form_group_next' style='background-color: {{ $primary_colour }};'>Next</a>
		</div>


		<div class='dd_donation_form_stage' stage='payment_method'>
			<h2>Payment Details</h2>

			<div class='dd_donation_form_stage_secure'>
				<i class=''></i>
				<p>We use <a href='https://stripe.com' target='_blank'>Stripe.com</a> to process donations, which ensures that your payment information is always stored and processed securely.</p>
			</div>


			<div class='dd_donation_form_group'>
				<label for=''>Email address</label>
				<input type='email' id='' name=''/>
			</div>



			<div class='dd_donation_form_group'>
				<label for=''>Credit or debit card</label>
				<div id='dd_donation_form_card'></div>
				<!-- Used to display form errors -->
				<div id='card-errors'></div>
			</div>

			<a class='dd_donation_form_group_next' style='background-color: {{ $primary_colour }};'>Confirm</a>
			<a class='dd_donation_form_group_go_back'>Go back</a>

		</div>




		<div class='dd_donation_form_stage' stage='confirm'>
			<h2>Confirm Donation</h2>

			<h1>Amount: £30</h1>
			<h1>Fees: £0.44</h1>
			<h1>Total: £30.44</h1>

			<a class='dd_donation_form_group_next' style='background-color: {{ $primary_colour }};'>Pay &pound;30.44</a>
			<a class='dd_donation_form_group_go_back'>Go back</a>

		</div>



		<div class='dd_donation_form_stage' stage='3d_secure'>
			<h2>3D Secure</h2>
			<div id='dd_donation_form_3d_secure'></div>
		</div>


		<div class='dd_donation_form_stage' stage='success'>
			<h2>Success</h2>
		</div>



	</div>


	{{-- <div class='dd_donation_form_group'>
		<label for='dd_donation_form_email'>Email address</label>
		<input type='email' id='dd_donation_form_email' name='dd_donation_form_email'/>
	</div>


	<div class='dd_donation_form_group'>
		<label for='dd_donation_form_email'>Email address</label>
		<input type='email' id='dd_donation_form_email' name='dd_donation_form_email'/>
	</div> --}}


	@if ($show_credit)
		<div class='dd_donation_form_credit'>
			<a href='{{ $powered_by_link }}'>Powered by<span></span></a>
		</div>
	@endif
<div>
