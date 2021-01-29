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
	<hero class='bg-blue w-100'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1 class='hero'>Determination to do good.</h1>
				<p class='mb-0'>That is what makes us unique.</p>
			</div>
		</div>
	</hero>

	<div>
		<div class='container py-5 px-0 public_page'>
			<div class='row px-0 py-3 justify-content-between key_point story'>
				<div class='col-sm-3 col-6'>
					<img src='{{ asset('img/ryan.jpg') }}' style='max-width: 100%; height: auto' class='about_ryan'/>
					<p class='mb-5'><small>Ryan Castle, Founder of DashDonate.org</small></p>
				</div>
				<div class='col-sm-8 col-6'>
					<h4 class='mt-0 mb-4'>Our Founder, Ryan Castle describes our story:</h4>
					<p class='mb-3'>"From before I can remember, I've always wanted to change the world.</p>
					<p class='mb-3'>In 2019, I was diagnosed with a brain tumour. This came as a huge shock, as there was no warning signs, and my symptoms were previously diagnosed as migraines. After emergency surgery, and a diagnosis of an aggressive and rare-form of incurable brain cancer, I was left stunned and struggling to find purpose.</p>
					<p class='mb-3'>A diagnosis like this is so lonely, and it makes you feel alien. However, all throughout the process of diagnosis, treatment and recovery, I was supported by so many different charities, all of which do amazing work but are not known to most.</p>
					<p class='mb-3'>With focussing on the tech sector for the last seven years, I had never looked far into charity. However after my diagnosis, I knew instantly that I needed to use my skills and experience in tech to give back to the people who helped me.</p>
					<p class='mb-3'>After looking back on my conversations with a number of charities, a devastating realisation was made - so many charities have to fight for survival due to lack of funds. This isn't the charities' fault, it's because the charities are so focussed on helping people, they spend too little time on raising awareness about the impact they make.</p>
					<p class='mb-5'>I knew I had to do something to help - and that's why I founded DashDonate.org."</p>
				</div>
			</div>
		</div>
	</div>
@endsection
