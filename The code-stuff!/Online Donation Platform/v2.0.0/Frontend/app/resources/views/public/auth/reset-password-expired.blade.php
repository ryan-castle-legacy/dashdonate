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
				<h1>Password Reset Expired</h1>
				<p class='mb-3'>This password reset has expired.</p>
			</div>
		</div>
		<div class='container pb-5' >


			<div class='row d-flex mb-4 justify-content-center'>


				<div class='col-4'>
					<a href='{{ route('home') }}' class='btn btn-primary btn-block'>Go home</a>
				</div>


			</div>


		</div>
	</div>
@endsection
