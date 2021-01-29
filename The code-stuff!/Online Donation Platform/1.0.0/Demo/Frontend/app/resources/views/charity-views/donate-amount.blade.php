@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<h1>Donate to {{ $charity->name }}</h1>
				</div>
                <div class="card-body">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('pre-scripts')
<script type='text/javascript'>
	{{-- Default donation values --}}
	var donation = {};
	{{-- Formula for calculating payment processing fees --}}
	var donation_fees = "{{ env('MIN_FEE_FORMULA_JS') }}";
	{{-- Minimum donation amount --}}
	var donation_minimum = parseFloat({{ env('MIN_DONATION_JS') }});
</script>
@endsection
