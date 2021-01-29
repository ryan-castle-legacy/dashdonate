@extends('layouts.main')

@section('content')
	{{-- <hero class='bg-blue w-100'>
		<div class='container min-height-100'>
			<div class='col-12'>
				<div class='row hero_img_cont'>
					<div class='col-6 flex-column flex-middle'>
						<h1 class='hero'>Let's do something amazing together</h1>
						<p class='mr-2 mt-3 mb-5'>Help us make fundraising more rewarding for everyone, with more transparency, better control over your donations, and greater connection to the causes you care about.</p>
						<p class='mb-0 mt-3'>
							<a href='{{ route('public-get_involved') }}' class='btn btn-primary ml-0'>Get Involved</a>
							<a href='{{ route('public-about_dashdonate') }}' class='btn btn-link'>Our Story</a>
						</p>
					</div>
					<div class='col-6 hero_img_cont_2 flex-middle flex-end'>
						<div class='hero_image' style='background-image: url("");'>
							<div class='fake_charity_page'>
								<div class='fake_charity_page_hero'></div>
								<div class='fake_charity_page_logo'></div>
								<div class='fake_charity_page_name'></div>
								<div class='fake_charity_page_info'></div>
								<div class='fake_charity_page_post'></div>
								<div class='fake_charity_page_post'></div>
								<div class='fake_charity_page_post'></div>
								<div class='fake_charity_page_post'></div>
							</div>
						</div>
						<div class='hero_image hero_image_small_left' style='background-image: url("{{ asset('img/hero_image.jpeg') }}");'></div>
						<div class='hero_donation_list'>
							<div class='hero_donation'>
								<p class='donation_successful'><i class='fas fa-check'></i></p>
								<p class='donation_amount'>£25.00</p>
								<p class='donation_via'>via DashDonate.org</p>
							</div>
							<div class='hero_donation'>
								<p class='donation_successful'><i class='fas fa-check'></i></p>
								<p class='donation_amount'>£15.00</p>
								<p class='donation_via'>via Facebook.com</p>
							</div>
							<div class='hero_donation'>
								<p class='donation_successful'><i class='fas fa-check'></i></p>
								<p class='donation_amount'>£50.00</p>
								<p class='donation_via'>via DashDonate.org</p>
							</div>
							<div class='hero_donation'>
								<p class='donation_successful'><i class='fas fa-check'></i></p>
								<p class='donation_amount'>£5.00</p>
								<p class='donation_via'>via DashDonate.org</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</hero>--}}
	<hero class='bg-blue w-100 min-height-100'>
		<div class='container py-5 min-height-100 d-flex align-content-center'>
			<div class='col py-3 text-center d-flex flex-column justify-content-center'>
				<h1 class='hero'>Let's do something amazing together</h1>
				<p class='mb-2'>With more transparency, better control over your donations, and greater connection to the causes you care about - help us make fundraising more rewarding for everyone.</p>

				<p class='mb-5'>
					<a href='{{ route('public-for_donors') }}' class='btn mt-5 btn-primary'>For Donors</a>
					<a href='{{ route('public-for_charities') }}' class='btn mt-5 btn-primary'>For Charities</a>
					<a href='{{ route('public-about_dashdonate') }}' class='btn mt-5 btn-primary'>Our Story</a>
					<a href='{{ route('public-get_involved') }}' class='btn mt-5 btn-primary'>Get Involved</a>
				</p>

				<p class='mb-0'>Share us on social media</p>
				<p class='socials center mt-2 mb-0'>
					<a href='https://www.facebook.com/dashdonate/' target='_blank'><i class='fab fa-facebook-square'></i></a>
					<a href='https://twitter.com/dashdonate' target='_blank'><i class='fab fa-twitter'></i></a>
					<a href='https://www.instagram.com/dashdonate/' target='_blank'><i class='fab fa-instagram'></i></a>
				</p>

			</div>
		</div>
	</div>
@endsection
