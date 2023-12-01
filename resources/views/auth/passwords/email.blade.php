{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
                <form method="POST" class="register-form" id="register-form" action="{{ route('password.email') }}">
                    @if (session('status'))
                        <div class="success-alert" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
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
                                <label for="email" class="required">Email</label>
                                <input type="text" name="email" id="email" />
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
@endsection
