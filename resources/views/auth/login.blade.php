@extends('layouts.loginLayout')

@section('content')
<div class="mainLoginPage  row m-0">
		<div class="login-container shadow-lg p-0">
			<div class="login-container-img">
                <div class="content">
                    <div class="text-white">
                        <div class="text-center">
                            {{-- <img src="{{asset('assets/img/ahf-logo.png')}}" width="140" alt=""> --}}
                            <h1 class="text-white">Logo is here</h1>
                        </div>
                        <h2 class="text-white">Accounts Management System</h2>
                    </div>
                </div>
			</div>
			<div class="login-container-content">
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
					<h1 class="mb-4">{{ __('Login') }}</h1>
					<p class="field">
                        <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror pt-0" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</p>
					<p class="field">
                        <label for="password" class="col-form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror pt-0" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</p>
                    <div class="form-group row justify-content-center">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary px-5">
                                    {{ __('Login') }}
                                </button>
                            </div>
                            <div class="col-10 p-0 text-right">
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


@endsection
