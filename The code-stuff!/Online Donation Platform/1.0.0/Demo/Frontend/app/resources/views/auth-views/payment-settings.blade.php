@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<h1>Payment Settings</h1>
				</div>
                <div class="card-body">
					<a class='btn btn-primary' href='{{ route('payment-add_card') }}'>Add new payment source</a>
					<pre>
						{{ var_dump($settings) }}
					</pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
