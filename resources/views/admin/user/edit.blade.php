@extends('admin.layouts.master')
@section('body')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>
        {{$title}}
        @if ($user['members']['image_path'])
            @if (!auth()->user()->hasRole('user'))
                <img src="{{URL::to("/") ."/". $user['members']['image_path']}}" alt="Profile" class="rounded-circle" style="height:40px;width:40px">
            @endif
        @endif
    </h1>
    </div><!-- End Page Title -->
    @if (auth()->user()->hasRole('user'))
        @include('admin.user.user-view')
    @else
    <section class="section profile mt-4">
        <div class="row">
          <div class="col-xl-6">
              @foreach ($errors->all() as $error)
                  <div class="alert alert-danger alert-dismissible fade show">{{ $error }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endforeach
            <div class="card">
              <div class="card-body pt-3">
                <div class="tab-content pt-2">
                  <div class="t" id="profile-edit">
                    <!-- Profile Edit Form -->
                    <form action="{{route("admin.profile.uddate")}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">First Name <small class="text-danger">*</small></label>
                        <div class="col-md-8 col-lg-9">
                          <input name="first_name" type="text" class="form-control" id="fullName" value="{{$user['members']['first_name'] ?? ''}}" required>
                          <input name="id" type="hidden" class="form-control" id="fullName" value="{{$user['id']}}">
                          <input name="memberId" type="hidden" class="form-control" id="fullName" value="{{$user['members']['id']}}">
                          <input name="type" type="hidden" class="form-control" id="fullName" value="updateMember">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Last Name <small class="text-danger">*</small></label>
                        <div class="col-md-8 col-lg-9">
                          <input name="last_name" type="text" class="form-control" id="fullName" value="{{$user['members']['last_name'] ?? ''}}" required>
                        </div>
                      </div>


                      <div class="row mb-3">
                          <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone <small class="text-danger">*</small></label>
                          <div class="col-md-8 col-lg-9">
                            <input name="contact" type="text" class="form-control" id="Phone" value="{{$user['contact'] ?? ''}}" required>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email <small class="text-danger">*</small></label>
                          <div class="col-md-8 col-lg-9">
                            <input name="email" type="email" class="form-control" id="Email" value="{{$user['email'] ?? ''}}" required>
                          </div>
                        </div>

                      <div class="row mb-3">
                        <label for="about" class="col-md-4 col-lg-3 col-form-label">Address <small class="text-danger">*</small></label>
                        <div class="col-md-8 col-lg-9">
                          <textarea name="address" class="form-control" id="about" style="height: 100px" required>
                              {!! $user['members']['address'] ?? '' !!}
                          </textarea>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Reference Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="reference" type="text" class="form-control" value="{{$user['members']['reference'] ?? ''}}" id="reference">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Reference Number</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="reference_number" type="text" class="form-control" value="{{$user['members']['reference_number'] ?? ''}}" id="reference_number">
                        </div>
                      </div>
                      <div class="row mb-3">
                          <label for="Address" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                          <div class="col-md-8 col-lg-9">
                                  <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><input type="file" name="profile_image" /><i class="bi bi-upload"></i></a>
                                  <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image" onclick="removeFile()"><i class="bi bi-trash"></i></a>
                          </div>
                        </div>
                  </div>
                </div><!-- End Bordered Tabs -->

              </div>
            </div>

          </div>
          <div class="col-xl-6">
            <div class="card">
              <div class="card-body pt-3">
                <div class="tab-content pt-2">
                  <div class="t" id="profile-edit">
                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Membership <small class="text-danger">*</small></label>
                        <div class="col-md-8 col-lg-9">
                          <select class="form-select" name="payment" aria-label="Default select example">
                              <option value="General Member" {{$user['members']['payment'] == "General Member" ? "selected":""}}>General Member</option>
                              <option value="Life Member" {{$user['members']['payment'] == "Life Member" ? "selected":""}}>Life Member</option>
                              <option value="Donor Member" {{$user['members']['payment'] == "Donor Member" ? "selected":""}}>Donor Member</option>
                              <option value="Honorary Member" {{$user['members']['payment'] == "Honorary Member" ? "selected":""}}>Honorary Member</option>
                        </select>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Batch <small class="text-danger">*</small></label>
                        <div class="col-md-8 col-lg-9">
                          <select class="form-select" name="batch" aria-label="Default select example">
                              @for ($i=1; $i<=50; $i++ )
                                  @if (in_array($i, [24,25,26]))
                                      <option value="{{"Batch ".$i. " (MBA)"}}" {{$user['members']['batch'] == "Batch ".$i. " (MBA)" ? "selected" : ""}}>{{"Batch ".$i. " (MBA)"}}</option>
                                      <option value="{{"Batch ".$i. " (M.Com)"}}" {{$user['members']['batch'] == "Batch ".$i. " (M.Com)" ? "selected" : ""}}>{{"Batch ".$i. "(M.Com)"}}</option>
                                  @else
                                      <option value="{{"Batch ".$i}}" {{$user['members']['batch'] == "Batch ".$i ? "selected" : ""}}>{{"Batch ".$i}}</option>
                                  @endif
                              @endfor
                        </select>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">NID <small class="text-danger">*</small></label>
                        <div class="col-md-8 col-lg-9">
                          <input name="nid" type="text" class="form-control" id="fullName" value="{{$user['members']['nid'] ?? ''}}" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Date Of Birth <small class="text-danger">*</small></label>
                        <div class="col-md-8 col-lg-9">
                          <input name="dob" type="date" class="form-control" id="fullName" value="{{$user['members']['dob'] ?? ''}}" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Blood Group</label>
                        <div class="col-md-8 col-lg-9">
                          <select class="form-select" name="blood_group" aria-label="Default select example">
                              <option value="A+" {{$user['members']['blood_group'] == "A+" ? "selected" : ""}}>A+</option>
                              <option value="A-" {{$user['members']['blood_group'] == "A-" ? "selected" : ""}}>A-</option>
                              <option value="B+" {{$user['members']['blood_group'] == "B+" ? "selected" : ""}}>B+</option>
                              <option value="B-" {{$user['members']['blood_group'] == "B-" ? "selected" : ""}}>B-</option>
                              <option value="O+" {{$user['members']['blood_group'] == "O+" ? "selected" : ""}}>O+</option>
                              <option value="O-" {{$user['members']['blood_group'] == "O-" ? "selected" : ""}}>O-</option>
                              <option value="AB+" {{$user['members']['blood_group'] == "AB+" ? "selected" : ""}}>AB+</option>
                              <option value="AB-" {{$user['members']['blood_group'] == "AB-" ? "selected" : ""}}>AB-</option>
                        </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                          <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                          <div class="col-md-8 col-lg-9">
                            <input name="employeer_name" type="text" class="form-control" value="{{$user['members']['employeer_name'] ?? ''}}" id="company">
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Designation</label>
                          <div class="col-md-8 col-lg-9">
                            <input name="designation" type="text" class="form-control" id="Job" value="{{$user['members']['designation'] ?? ''}}">
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="Address" class="col-md-4 col-lg-3 col-form-label">Company Address</label>
                          <div class="col-md-8 col-lg-9">
                            <input name="employeer_address" type="text" class="form-control" id="Address" value="{{$user['members']['employeer_address'] ?? ''}}">
                          </div>
                        </div>
                      <div class="row mb-3">
                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Membership ID</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="membership_id" type="text" class="form-control" id="membership_id" value="{{$user['members']['membership_id'] ?? ''}}">
                        </div>
                      </div>
                  </div>
                </div><!-- End Bordered Tabs -->

              </div>
            </div>

          </div>

          @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
              <div class="text-center">
                  <button type="submit" class="btn btn-primary">Update Member</button>
              </div>
          @endif
          </form>

        </div>
      </section>
    @endif

  </main><!-- End #main -->
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
    <script>
        function removeFile(){
            $("input[type=file]").val("");
        }
    </script>
@endpush
@endsection
