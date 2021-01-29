@extends('layouts.main')

@section('content')
	<hero class='bg-blue w-100'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1 class='hero mb-5'>We're here to help, not to make a profit.</h1>
				<h3 class='mb-0'>No fees, unlimited support.</h3>
			</div>
			<div class='col py-3 text-center'>
				@if (@session('success_message'))
					<div class='row flex-middle'>
						<p>You've been added to our charity list, thank you!</p>
					</div>
					<form class='row flex-middle' method='POST' action='{{ route('pre-signup') }}'>
						@csrf
						<input type='email' name='email' disabled id='email' value='{{ old('email') }}' placeholder='Charity email address' required/>
						<input type='hidden' name='type' value='charity'/>
						<input type='submit' class='btn btn-primary mr-0' value='Keep me posted' disabled/>
					</form>
				@else
					<div class='row flex-middle'>
						<p>Want to get notified when we launch?</p>
					</div>
					<form class='row flex-middle' method='POST' action='{{ route('pre-signup') }}'>
						@csrf
						<input type='email' name='email' id='email' value='{{ old('email') }}' placeholder='Charity email address' required/>
						<input type='hidden' name='type' value='charity'/>
						<input type='submit' class='btn btn-primary mr-0' value='Keep me posted'/>
					</form>
				@endif
			</div>
		</div>
	</hero>
	<div>
		<div class='container py-5'>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Zero Fees</strong></h4>
				</div>
				<div class='col-8'>
					<p>No fees for charities, it's that simple.</p>
				</div>
			</div>

			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Increased Donor Loyalty</strong></h4>
				</div>
				<div class='col-8'>
					<p>We ensure that your donors know what their contributions enable you to do, and push any opportunty to spread the amazing work your charity is doing.</p>
					<p>Through our suite of community-focussed tools, donors are actively supporting charity, rather than just donating. This helps build loyaly, leading to repeat donation.</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Free Social Media Training</strong></h4>
				</div>
				<div class='col-8'>
					<p>Many small charities struggle to find the funds or resources to help them gain awareness online. This is why we offer free training for your existing charity workers, giving them new skills and educating them in how to make the most out of social media, without the cost of hiring new staff.</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Analytics for Everything</strong></h4>
				</div>
				<div class='col-8'>
					<p>We record everything to ensure you know what is working, and what is not.</p>
					<p>Analytics are the key to this, as we use them to track your charity's performance and suggest way to drive raising awareness.</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Unlimited Support</strong></h4>
				</div>
				<div class='col-8'>
					<p>We're here to help in any way we can, and we're open to suggestions.</p>
					<p>If you need us to make DashDonate work with your website, want a new management tool, or simply want some guidance, we are here to help.</p>
				</div>
			</div>
			<div class='row px-0 py-3 justify-content-between key_point'>
				<div class='col-3'>
					<h4><strong>Automated GiftAid</strong></h4>
				</div>
				<div class='col-8'>
					<p>GiftAid is processed automatically, with no fees for doing so - all we need is your details.</p>
				</div>
			</div>
		</div>
	</div>
@endsection
