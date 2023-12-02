@extends('admin.layouts.master')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('body')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>{{$title}}</h1>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-12 col-12">
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
                  <form class="row" action="{{route('admin.newsletter.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-6 col-6">
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Members</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select" name="members" aria-label="Default select example">
                            <option value="">All</option>
                            <option value="General Member">General Member</option>
                            <option value="Life Member">Life Member</option>
                            <option value="Donor Member">Donor Member</option>
                            <option value="Honorary Member">Honorary Member</option>
                      </select>
                      </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Batch</label>
                        <div class="col-md-8 col-lg-9">
                          <select class="form-select" name="batch" aria-label="Default select example">
                            <option value="">All</option>
                              @for ($i=1; $i<=50; $i++ )
                                  @if (in_array($i, [24,25,26]))
                                      <option value="{{"Batch ".$i. " (MBA)"}}">{{"Batch ".$i. " (MBA)"}}</option>
                                      <option value="{{"Batch ".$i. " (M.Com)"}}">{{"Batch ".$i. "(M.Com)"}}</option>
                                  @else
                                      <option value="{{"Batch ".$i}}">{{"Batch ".$i}}</option>
                                  @endif
                              @endfor
                        </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                        <div class="input-group">
                            <select class="form-select multiple-columns" name="emails[]" multiple="multiple">
                                @forelse ($emails as $email)
                                    <option value="{{$email['email']}}">{{$email['email']}}</option>
                                @empty
                                    No Data found!
                                @endforelse
                              </select>
                          </div>
                    </div>
                    </div>
                    </div>
                    <div class="col-xl-6 col-6">
                    <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Starting Period</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="start_period" type="datetime-local" class="form-control" id="Email">
                        </div>
                        </div>
                        <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Ending Period</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="end_period" type="datetime-local" class="form-control" id="Email">
                        </div>
                        </div>
                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Template Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="template_name" type="text" class="form-control" id="reference">
                      </div>
                    </div>
                    </div>
                    <hr>
                    <div class="col-xl-12 col-12">
                        <div class="row mb-3">
                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Type Newsletter</label>
                              <textarea class="tinymce-editor" rows="3" name="news">
                              </textarea><!-- End TinyMCE Editor -->
                          </div>
                    </div>
                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Publish Newsletter</button>
          </div>
        </form>

      </div>
    </section>

  </main><!-- End #main -->
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.multiple-columns').select2({
                placeholder: 'Select emails'
            });
        });
        function removeFile(){
            $("input[type=file]").val("");
        }
        function confettiAnimation() {
            const duration = 5 * 1000,
            animationEnd = Date.now() + duration,
            defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
            }

            const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            const particleCount = 50 * (timeLeft / duration);

            // since particles fall down, start a bit higher than random
            confetti(
                Object.assign({}, defaults, {
                particleCount,
                origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
                })
            );
            confetti(
                Object.assign({}, defaults, {
                particleCount,
                origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
                })
            );
            }, 250);
        }
		@if(Session::has('success'))
            confettiAnimation();
		@endif

    </script>
@endpush
@endsection
