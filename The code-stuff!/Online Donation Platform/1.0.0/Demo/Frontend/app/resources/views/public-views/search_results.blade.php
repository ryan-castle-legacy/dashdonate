@extends('layouts.main')

@section('content')
	<div class='flex-middle'>
		<div class='container flex-middle'>
			<div class='row py-3'>
				<div class='col'>
					<p>Search for</p>
					<input type='text' class='form-control-lg' name='search_query' value='{{ $query }}' placeholder='Search for charities, fundraisers, and more'/>
				</div>
			</div>
		</div>

	</div>
@endsection
