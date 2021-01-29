@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<h1>Charity list</h1>
				</div>
                <div class="card-body">
					@if ($charities && gettype($charities) == 'array' && sizeof($charities) > 0)
						@foreach ($charities as $charity)
							<div>
								<h3><a href='{{ route('charity-homepage', ['slug' => $charity->charity_slug]) }}' target='_blank'>{{ $charity->charity_name }} ({{ $charity->charity_id }})</a></h3>
								<p>Date created: {{ date('jS F Y \a\t g:ia', strtotime($charity->charity_date_created)) }}</p>
								<p>Charity Reg. No: {{ $charity->charity_registration_number }} </p>
								<p>Charity Payout. No: {{ $charity->payout_reference_id }} </p>
								<p>Owner: {{ $charity->user_name }} ({{ $charity->owner_id }}) - {{ $charity->owner_email }}</p>
							</div>
						@endforeach
					@else
						<h4>No Charities Found!</h4>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
