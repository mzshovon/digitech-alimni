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

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
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

@extends('frontend.partials.app')
@section('content')

<div class="main">
    <div class="container">
        <div class="signup-content">
            <div class="signup-img">
                <img src="{{URL::to('/')}}/public/landing/img/logo.png" alt="">
            </div>
            <div class="signup-form signin-padding">
                <form method="POST" class="register-form" id="register-form" action="{{route('login')}}">
                    @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="error-alert">
                            {{$error}}
                        </div>
                    @endforeach
                    @endif
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-input signup-responsive-logo">
                                <img src="{{URL::to('/')}}/public/landing/img/logo.png" alt="">
                            </div>
                            <div class="form-input">
                                <label for="email" class="required">Email or Phone Number</label>
                                <input type="text" name="username" id="email" />
                            </div>
                            <div class="form-input">
                                <label for="chequeno">Password</label>
                                <input type="password" name="password" id="password" />
                                <label id="show-hide-password" class="eye" for="password"></label>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-submit"> --}}
                    <input type="submit" value="Submit" class="submit" id="submit" name="submit" />
                        {{-- <input type="button" value="Reset" class="submit" id="reset" name="reset" /> --}}
                    {{-- </div> --}}
                    Forget password? <a href="{{route('password.request')}}">Reset Password</a>
                    <div style="margin-top:20px">Don't have an account yet? <a href="{{route('register')}}">Sign Up</a></div>
                </form>

            </div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        var password = document.getElementById('password');
        var toggler = document.getElementById('show-hide-password');
        showHidePassword = () => {
            if (password.type == 'password') {
                console.log("hello");
                password.setAttribute('type', 'text');
                toggler.classList.add('eye-off');
            } else {
                toggler.classList.remove('eye-off');
                password.setAttribute('type', 'password');
            }
        };
        toggler.addEventListener('click', showHidePassword);
    </script>
@endpush

@endsection
