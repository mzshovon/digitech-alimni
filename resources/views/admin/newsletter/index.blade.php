@extends('admin.layouts.master')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('body')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>{{ $title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item">{{$title}}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title">{{ $title }}
                                        <a href="{{route('admin.newsletter.create')}}" class="btn btn-success btn-sm">Add new</a>
                                    </h5>
                            </div>
                            @if (auth()->user()->hasRole('superadmin'))
                            <div class="card">
                                <div class="card-header">Filter</div>
                                <div class="card-body pt-4 pb-4">
                                    <form class="row" method="GET" action="{{route('admin.payment.filter')}}">
                                        @csrf
                                        <div class="col-md-3">
                                            <div class="input-group">
                                              <select class="form-select multiple-columns" name="columns[]" multiple="multiple">
                                                  <option value="Name">Name</option>
                                                  <option value="Email">Email</option>
                                                  <option value="Contact Number">Contact Number</option>
                                                  <option value="Payment Channel">Payment Channel</option>
                                                  <option value="Transaction ID">Transaction ID</option>
                                                  <option value="Amount">Amount</option>
                                                  <option value="Status">Status</option>
                                                  <option value="Submitted At">Submitted At</option>
                                                </select>
                                            </div>
                                          </div>
                                        <div class="col-md-3">
                                            <select class="form-select" name="status" aria-label="Default select example">
                                                <option selected value="">Choose Status</option>
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>
                                                <option value="declined">Declined</option>
                                              </select>
                                        </div>
                                        <div class="col-md-3">
                                          <input type="text" class="form-control" id="validationDefault01" placeholder="From" name="from" onfocus="(this.type='date')" onblur="(this.type='text')" >
                                        </div>
                                        <div class="col-md-3">
                                          <input type="text" class="form-control" id="validationDefault01" placeholder="To" name="to" onfocus="(this.type='date')" onblur="(this.type='text')" >
                                        </div>
                                        <div class="col-md-3">
                                          <button class="btn btn-primary" type="submit"><i class="bi bi-download"></i> Download</button>
                                        </div>
                                      </form>
                                    </div>
                                    </div>
                            </div>
                            @endif
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Template Name</th>
                                        <th scope="col">News</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Sender</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Send At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($newsLetters as $key => $newsLetter)
                                        <tr>
                                            <th scope="row">{{ ++$key }}</th>
                                            <td>{{ $newsLetter['template_name'] }}</td>
                                            <td>{{ $newsLetter['news'] }}</td>
                                            <td>{{ $newsLetter['start_date']}}</td>
                                            <td>{{ $newsLetter['end_date'] }}</td>
                                            <td>{{ $newsLetter['operated_by'] }}</td>
                                            <td><button class="btn btn-{{$newsLetter['status'] == 'pending' ? 'warning' : ($newsLetter['status'] == 'approved' ? 'success' : 'danger')}} btn-sm">{{ ucwords($newsLetter['status']) }}</button></td>
                                            <td>{{ \Carbon\Carbon::parse($newsLetter['created_at'])->format("d, M Y") }}</td>
                                            <td>
                                                @if (auth()->user()->hasRole('superadmin'))
                                                    @if (in_array($newsLetter['status'], ["pending", "declined"]))
                                                        <a href="{{route('admin.payment.update.status',['id' => $newsLetter['id'], 'status' => 'approved'])}}" class="btn btn-outline-success btn-sm"><i class="bi bi-check-circle"></i> Approve</a>
                                                        <a href="{{route('admin.payment.update.status',['id' => $newsLetter['id'], 'status' => 'declined'])}}" class="btn btn-outline-danger btn-sm"><i class="bi bi-slash-circle"></i> Decline</a>
                                                    @else
                                                        <a href="{{route('admin.payment.update.status',['id' => $newsLetter['id'], 'status' => 'pending'])}}" class="btn btn-outline-warning btn-sm"><i class="bi bi-slash-circle"></i> Pending</a>
                                                    @endif

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        $(document).ready(function() {
            $('.multiple-columns').select2({
                placeholder: 'Select columns'
            });
        });
    </script>
@endpush
