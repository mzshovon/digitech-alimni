<section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            @if ($user['members']['image_path'])
            <img src="{{URL::to("/") ."/". $user['members']['image_path']}}" alt="Profile" class="rounded-circle">
            @endif
            <h2>{{$user['name']}}</h2>
            <h3>Membership ID: {{$user['members']['membership_id'] ?? "Not given yet"}}</h3>
            <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-xl-8">
          @foreach ($errors->all() as $error)
              <div class="alert alert-danger alert-dismissible fade show">{{ $error }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          @endforeach
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{$user['name'] ?? ''}}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Date of Birth</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['dob'] ?? ''}}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Payment</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['payment'] ?? ''}}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Batch</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['batch']?? "N/A"}}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Blood Group</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['blood_group'] ?? "N/A"}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Company</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['employeer_name'] ?? "N/A"}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Designation</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['designation'] ?? "N/A"}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8">Bangladesh</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['address'] ?? "N/A"}}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Employeer Address</div>
                  <div class="col-lg-9 col-md-8">{{$user['members']['employeer_address'] ?? "N/A"}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{$user['email'] ?? "N/A"}}</div>
                </div>

              </div>
            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>
