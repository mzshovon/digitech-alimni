{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
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
                <form method="POST" class="register-form" id="register-form" action="{{ route('password.update') }}">
                    @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="error-alert">
                            {{$error}}
                        </div>
                    @endforeach
                    @endif
                    @csrf
                    <div class="form-row">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <div class="form-input signup-responsive-logo">
                                <img src="{{URL::to('/')}}/public/landing/img/logo.png" alt="">
                            </div>
                            <div class="form-input">
                                <label for="email" class="required">Email</label>
                                <input type="email" name="email" id="email" />
                            </div>
                            <div class="form-input">
                                <label for="password" class="required">Password</label>
                                <input type="password" name="password" id="password" />
                                <label id="show-hide-password" class="eye" for="password"></label>
                            </div>
                            <div class="form-input">
                                <label for="password_confirmation" class="required">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="confirm_password" />
                                <label id="show-hide-password-confirm" class="eye" for="password"></label>
                            </div>
                        </div>

                    </div>
                        <input type="submit" value="Reset" class="submit" id="submit" name="submit" />
                </form>

            </div>
            </div>
        </div>
    </div>

</div>
@push('script')
<script>
    var password = document.getElementById('password');
    var confirm_password = document.getElementById('confirm_password');
    var toggler = document.getElementById('show-hide-password');
    var confirmToggler = document.getElementById('show-hide-password-confirm');
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
    showHideConfirmPassword = () => {
        if (confirm_password.type == 'password') {
            console.log("hello");
            confirm_password.setAttribute('type', 'text');
            confirmToggler.classList.add('eye-off');
        } else {
            confirmToggler.classList.remove('eye-off');
            confirm_password.setAttribute('type', 'password');
        }
    };
    toggler.addEventListener('click', showHidePassword);
    confirmToggler.addEventListener('click', showHideConfirmPassword);
</script>

@endpush
@endsection
