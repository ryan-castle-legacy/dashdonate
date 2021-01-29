@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<h1>User list</h1>
				</div>
                <div class="card-body">
					@if ($users && gettype($users) == 'array' && sizeof($users) > 0)
						@foreach ($users as $user)
							<div>
								<h3>{{ $user->name }}</h3>
								<p>Email: <strong>{{ $user->email }}</strong></p>
								<p>Created at: <strong>{{ date('jS F Y \a\t g:ia', strtotime($user->created_at)) }}</strong></p>
								<p>User Role: <strong>{{ $user->user_role }}</strong></p>
								<p>Is Admin: <strong>{{ $user->is_admin }}</strong></p>
								<p>Customer ID [STRIPE]: <strong>{{ $user->stripe_customer_id }}</strong></p>
							</div>
							<hr/>
						@endforeach
					@else
						<h4>No Users Found!</h4>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
