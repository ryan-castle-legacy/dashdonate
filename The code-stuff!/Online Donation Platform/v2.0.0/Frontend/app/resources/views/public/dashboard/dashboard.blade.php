@extends('layouts.main')




@section('pre-scripts')
@endsection




@section('post-scripts')
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
@endsection




@section('content')
	<hero class='bg-blue w-100 d-flex align-items-center'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1 class='mb-0'>Welcome back, {{ Auth::user()->firstname }}</h1>
			</div>
		</div>
	</hero>

	<div class='w-100 d-flex align-items-center'>
		<div class='container donor_dash_cont px-0 py-5'>
			<div class='col py-3 px-0'>

				<div class='row justify-content-center dash_max_w'>

					<div class='col-4 mb-5'>

						<div class='col-12 px-0 mb-3 mt-0'>
							<h5>Recent Donations</h5>
						</div>

						<div class='donation_list'>

							@if (sizeof($dashboard_data->donations) == 0)
								<div class='col-12 card donation empty'>
									<p class='m-0 mb-2'><i class='fas fa-donate'></i>You haven't made any donations yet.</p>
									<a class='btn btn-link m-0' href='{{ route('public-search-charities') }}'>Search for a charity</a>
								</div>
							@else
								@for ($i = 0; $i < sizeof($dashboard_data->donations); $i++)
									<div class='col-12 card donation'>

										<a href='{{ route('charities-public-homepage', ['charity_slug' => $dashboard_data->donations[$i]->charity_slug]) }}' target='_blank' class='charity_logo'>
											<div class='logo filled' style='background-image: url("{{ @env('S3_URL').$dashboard_data->donations[$i]->charity->logo->s3_url }}")'></div>
										</a>

										<h4><a href='{{ route('charities-public-homepage', ['charity_slug' => $dashboard_data->donations[$i]->charity_slug]) }}' target='_blank'>{{ $dashboard_data->donations[$i]->charity->display_name }}</a></h4>

										<h5>&pound;{{ number_format(($dashboard_data->donations[$i]->amount / 100), 2) }}</h5>

										<p><small>Taken on the {{ date('jS F Y \a\t g:ia', strtotime($dashboard_data->donations[$i]->date_taken)) }}</small></p>

									</div>
								@endfor
								<a class='btn btn-outline btn-sm w-100' href='{{ route('public-dashboard-donations') }}'>See all donations</a>
							@endif

						</div>


					</div>

					<div class='col-8'>

						<div class='col-12 px-0 mb-3 mt-0'>
							<h5>Activity Feed</h5>
						</div>

						<div class='donor_feed'>

							<div class='col-12 px-0 mb-3 mt-0'>
								<div class='alert alert-info w-100 m-0'>
									<p class='m-0 p-0'>
										<i class='fas fa-info'></i>
										We know you want to keep up-to-date about the charities you support, that's why we are working hard to build activity feeds into our next updates - we'll notify you when they're ready!
									</p>
								</div>
							</div>

							<div class='col-12 story'>

								<div class='header'>
									<div class='charity_logo'>
										<div class='logo filled' style='background-image: url("{{ asset('img/ryan-avatar.jpg') }}")'></div>
									</div>
									<h4>Ryan Castle, Founder of DashDonate.org</h4>
									<h5>Thank you for being here!</p>
								</div>

								<p>
									Myself and the team at DashDonate.org can't thank you enough for being here and supporting charities though our site. We are here to make fundraising more rewarding for everyone, and we can't do it without you.
									<br/>
									<br/>
									In 2019, I was diagnosed with incurable cancer. A diagnosis like this is so lonely, and it makes you feel alien. However, all throughout the process of diagnosis, treatment and recovery, I was supported by so many different charities, all of which do amazing work but are not known to most.
									<br/>
									<br/>
									After looking back on my conversations with a number of charities, a devastating realisation was made - so many charities have to fight for survival due to lack of funds. This isn't the charities' fault, it's because the charities are so focussed on helping people, they spend too little time on raising awareness about the impact they make.
									<br/>
									<br/>
									I knew I had to do something to help - and that's why I founded DashDonate.org.
									<img src='http://asset.dashdonate.org/thank-you.png'/>
									We're right at the beginning of our journey, and we have so much to offer. Things may look a little rough around the edges. We are constantly improving, with our two goals being:
									<br/>
									<br/>
									&nbsp;&nbsp;1. To give donors complete control and freedom over their donations.<br/>
									&nbsp;&nbsp;2. To empower charities with the best tech around so they can better focus on the work they do.
									<br/>
									<br/>
									I want to make it clear that we are not here to make a profit. No huge executive pay-checks or any of that stuff - every penny that is taken when making a donation goes to either the charity, is spent on fees with our payment processor, or it goes to improving the services we offer to charities.
									<br/>
									<br/>
									We're so excited to have you onboard, thank you for being part of our adventure!
									<br/>
									<br/>
									PS. If you have any suggestions as to how we can make donating better, feel free to send me an email at <a href='mailto:ryan@dashdonate.org' target='_blank'>ryan@dashdonate.org</a>.
								</p>

							</div>

						</div>
					</div>


				</div>

			</div>
		</div>
	</div>
@endsection
