@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
				<div class="card-header">
					<h1>Donation list</h1>
				</div>
                <div class="card-body">
					@if ($donations && gettype($donations) == 'array' && sizeof($donations) > 0)
						@foreach ($donations as $donation)
							<div>
								<h3>
									&pound;{{ number_format(($donation->amount / 100), 2) }}
									donated to
									<a href='{{ route('charity-homepage', ['slug' => $donation->charity_slug]) }}' target='_blank'>{{ $donation->charity_name }} ({{ $donation->charity_id }})</a>
								</h3>
								<h6><strong>[{{ $donation->payment_status }}]</strong></h6>
								<br/>
								<p>Charity Reg. No: {{ $donation->charity_registration_number }} </p>
								<p>Charity Payout. No: {{ $donation->payout_reference_id }} </p>
								<p>Donor: {{ $donation->user_name }} ({{ $donation->donor_id }}) - {{ $donation->email }}</p>
								<p>Anonymous Donation: {{ $donation->is_anonymous_donation }}</p>
								<p>Is Guest Donation: {{ $donation->is_guest_donation }}</p>
								<p>Stripe Payment ID: {{ $donation->stripe_payment_id }}</p>
								<p>Date Donation created: {{ date('jS F Y \a\t g:ia', strtotime($donation->date_taken)) }}</p>
								<p>Date Donation last updated: {{ date('jS F Y \a\t g:ia', strtotime($donation->donation_last_updated)) }}</p>
								<p>Total Fees: &pound;{{ number_format(($donation->total_fees / 100), 2) }}</p>
							</div>
							<hr/>
						@endforeach
					@else
						{{ var_dump($donations) }}
						<h4>No Donations Found!</h4>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
