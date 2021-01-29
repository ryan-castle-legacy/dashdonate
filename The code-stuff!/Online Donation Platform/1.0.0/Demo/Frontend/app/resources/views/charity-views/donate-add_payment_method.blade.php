@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<h1>Donate to {{ $charity->name }}</h1>
					<h5>Select a payment method</h5>
				</div>
                <div class="card-body">
					<form action='{{ route('donation-card_needed', ['donation_id' => $donation_id]) }}' method='POST'>
						@csrf

						@if ($cards && @sizeof($cards) > 0)
							<p>Choose payment source - <a href='{{ route('donation-add_card', ['donation_id' => $donation_id]) }}'>Add new card</a></p>

							@if (sizeof($cards) == 1)
								<p>**** **** **** {{ $cards[0]->last_four_digits }} - Expires {{ date('jS F Y', strtotime($cards[0]->expiry_date)) }}</p>
								<input type='hidden' name='card_id' value='{{ $cards[0]->id }}'/>
							@else
								<select class='form-control' name='card_id'>
								@for ($i = 0; $i < sizeof($cards); $i++)
									<option value='{{ $cards[$i]->id }}'>**** **** **** {{ $cards[0]->last_four_digits }} - Expires {{ date('jS F Y', strtotime($cards[$i]->expiry_date)) }}</option>
								@endfor
								</select>
							@endif

							<hr/>
							<input type='submit' class='m-0 btn btn-primary' value='Choose Payment Method'/>
						@else
							<p><a href='{{ route('donation-add_card', ['donation_id' => $donation_id]) }}'>Add a payment method</a></p>
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
