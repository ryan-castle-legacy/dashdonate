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
	<hero class='bg-blue w-100 min-height-100 d-flex align-items-center pb-5'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1>Unauthorised</h1>
				<p class='mb-3'>Please ensure you are logged in with the correct account.</p>
				<a class='btn btn-primary mb-0' href='{{ route('home') }}'>Go home</a>
			</div>
		</div>
	</hero>
@endsection
