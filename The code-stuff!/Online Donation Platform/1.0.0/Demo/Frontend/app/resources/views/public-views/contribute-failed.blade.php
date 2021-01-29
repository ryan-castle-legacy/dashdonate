@extends('layouts.main')

@section('content')
	<hero class='bg-blue w-100 min-height-100'>
		<div class='container py-5 min-height-100 d-flex align-content-center'>
			<div class='col py-3 text-center d-flex flex-column justify-content-center'>
				<h1 class='hero'>Something went wrong!</h1>
				<p class='mb-5'>Don't worry, no payment has been taken</p>

				<p class='mb-5'>We really appreciate your attempt to contribute to our project.<br/>We'd advise you check your bank, and please <a href='mailto:info@dashdonate.org' class='border_link' target='_blank'>get in touch</a> if this keeps happening.</p>
				<p class='mb-0'>Share us on social media</p>
				<p class='socials center mt-2 mb-3'>
					<a href='https://www.facebook.com/dashdonate/' target='_blank'><i class='fab fa-facebook-square'></i></a>
					<a href='https://twitter.com/dashdonate' target='_blank'><i class='fab fa-twitter'></i></a>
					<a href='https://www.instagram.com/dashdonate/' target='_blank'><i class='fab fa-instagram'></i></a>
				</p>
				<p>
					<a href='{{ route('public-get_involved') }}' class='btn mt-5 btn-primary'>Back to "Get Involved"</a>
				</p>
			</div>
		</div>
	</div>
@endsection
