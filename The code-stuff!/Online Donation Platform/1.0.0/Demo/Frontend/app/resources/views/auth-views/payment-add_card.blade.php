@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<h1>Payment Settings</h1>
					<h3>Add New Payment Source</h3>
				</div>
                <div class="card-body">




<!-- The Styling File -->
<link rel="stylesheet" href="{{ asset('css/site.css') }}"/>

<form action="{{ route('payment-add_card') }}" method="post" id="payment-form">

	@if (Cookie::has('original_action'))
		<p>Original action:</p>
		<p>{{ Cookie::get('original_action') }}</p>
	@endif

	@csrf
	<div class="form-row">
		<label for="card-element">Credit or debit card</label>
		<div id="card-element">
			<!-- a Stripe Element will be inserted here. -->
		</div>
		<!-- Used to display form errors -->
		<div id="card-errors"></div>
	</div>
	<button>Submit Payment</button>
</form>
<!-- The needed JS files -->
<!-- JQUERY File -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<!-- Your JS File -->
<script>var stripe_pk = '{{ env('STRIPE_PK') }}';</script>
<script src="{{ asset('/js/site.js') }}"></script>





                </div>
            </div>
        </div>
    </div>
</div>
@endsection
