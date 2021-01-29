{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('layouts.main')

@section('content')
	<div class='flex-middle bg-blue min-height-100'>
		<div class='container w-100 flex-middle'>
			<div class='col py-3'>
				<div class='row'>
					<div class='col align-center flex-middle'>
						<h1 class='mb-0'>Welcome back</h1>
						<p><a href='{{ route('register') }}' class='btn btn-link'>Don't have an account yet? Join now</a></p>
					</div>
				</div>
				<div class='row align-center flex-middle'>
					<div class='card login_card'>
						<form method='POST' class='col' action='{{ route('login') }}'>
							@csrf
							<label for='email'>Email address</label>
							<input type='email' name='email' id='email'/>
							{{-- <label for='password' class='flex-apart'>Password<span class='forgot-password'><a href=''>Forgot password?</a></span></label> --}}
							<label for='password' class='flex-apart'>Password</label>
							<input type='password' class='mb-0' name='password' id='password'/>
							<div class='checkbox-input'>
								<input type='checkbox' name='remember' id='remember'>
								<label class='form-check-label' for='remember'>Keep me logged in</label>
							</div>
							<input type='submit' class='btn btn-primary ml-0 mr-0' value='Login'/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
