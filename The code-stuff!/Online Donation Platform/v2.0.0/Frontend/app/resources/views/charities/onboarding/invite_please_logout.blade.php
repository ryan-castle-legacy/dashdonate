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
	<div class='bg-blue w-100 min-height-100 pb-5'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>Wrong Account</h1>
				<p class='mb-3'>You have been invited to join a charity, however you are already signed into another DashDonate.org account.</p>
			</div>
		</div>
		<div class='container pb-5' >


			<div class='row d-flex mb-4 justify-content-center'>


				<div class='col-4'>
					<div class='card'>
						<p>Please logout and register a new account using the email {{ @Cookie::get('register_email') }}.</p>
						<a href='{{ route('logout') }}' class='btn btn-primary btn-block'>Log me out</a>
					</div>
				</div>


			</div>


		</div>
	</div>
@endsection
