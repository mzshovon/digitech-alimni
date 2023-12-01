{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                    {{ __('Register') }}
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
<img id="myImg" src="" hidden alt="Snow" style="width:100%;max-width:300px">

<!-- The Modal -->
    <div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
    </div>
<div class="main">
    <div class="container">
        <div class="signup-content">
            <div class="signup-img">
                <img src="{{URL::to('/')}}/public/landing/img/logo.png" alt="">
            </div>
            <div class="signup-form">

                <form method="POST" class="register-form" id="register-form" action="{{route('register')}}" enctype="multipart/form-data">
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
                                <label for="first_name" class="required">First name</label>
                                <input type="text" name="first_name" id="first_name" />
                            </div>
                            <div class="form-input">
                                <label for="last_name" class="required">Last name</label>
                                <input type="text" name="last_name" id="last_name" />
                            </div>
                            <div class="form-input">
                                <label for="email" class="required">Email</label>
                                <input type="text" name="email" id="email" />
                            </div>
                            <div class="form-input">
                                <label for="contact" class="required">Phone number</label>
                                <input type="text" name="contact" id="contact" />
                            </div>
                            <div class="form-input">
                                <label for="nid" class="required">NID Number</label>
                                <input type="text" name="nid" id="nid" />
                            </div>
                            <div class="form-input">
                                <label for="dob" class="required">Date Of Birth</label>
                                <input type="date" name="dob" id="dob" />
                            </div>
                            <div class="form-input">
                                <label for="address" class="required">Contact Address</label>
                                <input type="text" name="address" id="address" />
                            </div>
                            <div class="form-input">
                                <label for="profile_image" class="required">Upload Profile Image</label>
                                <input type="file" name="profile_image" id="profile_image" />
                            </div>
                            <div class="form-select">
                                <div class="label-flex">
                                    <label for="batch">Blood Group</label>
                                </div>
                                <div class="select-list">
                                    <select name="blood_group" id="batch-select">
                                        <option disabled selected>Select Blood Group</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="form-select">
                                <div class="label-flex">
                                    <label for="batch">Batch No</label>
                                    <a href="#" class="form-link">Batch detail</a>
                                </div>
                                <div class="select-list">
                                    <input type="hidden" name="batch" id="batch">
                                    <select name="batch" id="batch-select">
                                        <option disabled selected>Select Batch</option>
                                        @for ($i=1; $i<=50 ; $i++)
                                            @if (in_array($i, [24,25,26]))
                                                <option value="{{"Batch ".$i. " (MBA)"}}">{{"Batch ".$i. " (MBA)"}}</option>
                                                <option value="{{"Batch ".$i. " (M.Com)"}}">{{"Batch ".$i. "(M.Com)"}}</option>
                                            @else
                                                <option value="{{'Batch '.$i}}" >Batch {{$i}}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                            </div>
                                <div class="form-input">
                                    <label for="employeer_name">Employer's / Business Name</label>
                                    <input type="text" name="employeer_name" id="employee_name" />
                                </div>
                                <div class="form-input">
                                    <label for="chequeno">Designation</label>
                                    <input type="text" name="designation" id="designation" />
                                </div>
                                <div class="form-input">
                                    <label for="employeer_address">Employer's / Business Address</label>
                                    <input type="text" name="employeer_address" id="employer_address" />
                                </div>
                                <div class="form-input">
                                    <label for="chequeno">Reference Name</label>
                                    <input type="text" name="reference" id="reference" />
                                </div>
                                <div class="form-input">
                                    <label for="chequeno">Reference Number</label>
                                    <input type="text" name="reference_number" id="reference_number" />
                                </div>
                                <div class="form-input">
                                    <label for="password" class="required">Password</label>
                                    <input type="password" name="password" id="password" />
                                    <label id="show-hide-password" class="eye" for="password"></label>
                                    <small style="color: grey;font-style:italic">** Password must be at least 8 characters **</small>
                                </div>
                                <div class="form-input">
                                    <label for="confirm_password" class="required">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="confirm_password" />
                                    <label id="show-hide-password-confirm" class="eye" for="password"></label>
                                </div>
                            </div>
                            <input type="hidden" name="payment" id="payment" />
                            <div class="form-radio">
                                <div class="label-flex">
                                    <label for="payment" class="required">Payment Mode</label>
                                </div>
                                <div class="form-radio-group">
                                    <div class="form-radio-item">
                                        <input type="radio" name="payments" id="life_member" >
                                        <label for="life_member">Life Member</label>
                                        <span class="check"></span>
                                    </div>
                                    </div>
                                <div class="form-radio-group">
                                    <div class="form-radio-item">
                                        <input type="radio" name="payments" id="general_member" >
                                        <label for="general_member">General Member</label>
                                        <span class="check"></span>
                                    </div>
                                    </div>
                                <div class="form-radio-group">
                                    <div class="form-radio-item">
                                        <input type="radio" name="payments" id="donor_member" >
                                        <label for="donor_member">Donor Member</label>
                                        <span class="check"></span>
                                    </div>
                                    </div>
                                    <div class="form-radio-group">
                                    <div class="form-radio-item">
                                        <input type="radio" name="payments" id="honorary_member">
                                        <label for="honorary_member">Honorary Member</label>
                                        <span class="check"></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-submit">
                        <input type="submit" value="Submit" class="submit" id="submit" name="submit" />
                        <div style="margin-top:20px">Already a member? <a href="{{route('login')}}">Sign In</a></div>
                        {{-- <input type="button" value="Reset" class="submit" id="reset" name="reset" /> --}}
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@push('script')

<script>
    // var modal = document.getElementById("myModal");
    // var modalImg = document.getElementById("img01");
    // modal.style.display = "block";
    // if(screen.width < 700) {
    //     modalImg.src = "{{URL::to('/').'/public/frontend/images/Payment Details Mobile. Ver..png'}}";
    //     modalImg.style.width = "350px";
    //     modalImg.style.height = "550px";
    // } else {
    //     modalImg.src = "{{URL::to('/').'/public/frontend/images/Payment Details Dek. Ver..png'}}";
    // }


    // // Get the <span> element that closes the modal
    // var span = document.getElementsByClassName("close")[0];
    // var main = document.getElementsByClassName("main")[0];

    // main.style.opacity = "0.5";

    // span.onclick = function() {
    //     modal.style.display = "none";
    //     main.style.opacity = "1";
    // }

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

    // modal.onclick = function() {
    //     modal.style.display = "none";
    //     main.style.opacity = "1";
    // }

</script>

@endpush
@endsection

