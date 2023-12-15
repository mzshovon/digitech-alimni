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
                                        <a href="javascript:void(0)" class="btn btn-success btn-sm"
                                        onclick="createEditModalShow(null,null,null,null)">Add Election</a>
                                    </h5>
                            </div>
                            @if (auth()->user()->hasRole('superadmin'))
                            <div class="card">
                                <div class="card-header">Filter</div>
                                <div class="card-body pt-4 pb-4">
                                    <form class="row" method="GET" action="{{route('admin.payment.filter')}}">
                                        @csrf
                                        {{-- <div class="col-md-3">
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
                                          </div> --}}
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Start At</th>
                                        <th scope="col">End At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($elections as $key => $election)
                                        <tr>
                                            <th scope="row">{{ ++$key }}</th>
                                            <td>{{ $election['title'] }}</td>
                                            <td>{{ $election['start_date'] }}</td>
                                            <td>{{ $election['end_date'] }}</td>
                                            <td><button class="btn btn-{{$election['status'] == 'running' ? 'warning' : ($election['status'] == 'approved' ? 'success' : 'danger')}} btn-sm">{{ ucwords($election['status']) }}</button></td>
                                            <td>{{ \Carbon\Carbon::parse($election['created_at'])->format("d, M Y") }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm">Update</a>
                                                {{-- @if ($election['image_path'])
                                                    <a href="{{URL::to('/') ."/". $election['image_path']}}" download="download" class="btn btn-outline-primary btn-sm">Download <i class="bi bi-download"></i></a>
                                                @endif --}}
                                                {{-- @if (auth()->user()->hasRole('superadmin'))
                                                    @if (in_array($election['status'], ["pending", "declined"]))
                                                        <a href="{{route('admin.election.update.status',['id' => $election['id'], 'status' => 'approved'])}}" class="btn btn-outline-success btn-sm"><i class="bi bi-check-circle"></i> Approve</a>
                                                        <a href="{{route('admin.election.update.status',['id' => $election['id'], 'status' => 'declined'])}}" class="btn btn-outline-danger btn-sm"><i class="bi bi-slash-circle"></i> Decline</a>
                                                    @else
                                                        <a href="{{route('admin.election.update.status',['id' => $election['id'], 'status' => 'pending'])}}" class="btn btn-outline-warning btn-sm"><i class="bi bi-slash-circle"></i> Pending</a>
                                                    @endif

                                                @endif --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                    {{--  Assign modal start  --}}
                    <div class="modal fade" id="create-or-edit-modal" tabindex="-1" data-bs-backdrop="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="submitModalForm" action="{{ route('admin.storeElection') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="id_user">
                                        <div class="modal-body">
                                            <input type="text" class="form-control" placeholder="Enter Election Title"
                                                name="title" id="id_title" required>
                                            <br>
                                            <input type="text" class="form-control" id="validationDefault01" placeholder="Start Date" name="start_date"
                                                onfocus="(this.type='date')" onblur="(this.type='text')" required>
                                            <br>
                                            <input type="text" class="form-control" id="validationDefault01" placeholder="End Date" name="end_date"
                                                onfocus="(this.type='date')" onblur="(this.type='text')" required>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit <i class="bi bi-coin"></i></button>
                                    </div>
                                </form>
                            </div>
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
        function createEditModalShow(payment_channel, amount, transId, userId) {
            console.log(payment_channel);
            if (payment_channel) {
                $("#option_id" + payment_channel).prop('selected', true);
            } else {
                $('#id_payment_channel').find($('option')).prop('selected', false);
            }
            if (amount) {
                $("#id_amount").val(amount);
            } else {
                $("#id_amount").val('');
            }
            if (transId) {
                $("#id_trans_id").val(transId);
            } else {
                $("#id_trans_id").val('');
            }
            if (userId) {
                $("#id_user").val(userId);
                var url = '{{ route('admin.payment.update', ':userId') }}';
                url = url.replace(':userId', userId);
                $('#submitModalForm').attr('action', url);
            } else {
                $("#id_user").val('');
                $('#submitModalForm').attr('action', `{{ route('admin.payment') }}`);
            }
            $("#create-or-edit-modal").modal('show')
        }

        // function deleteUser(url){
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //         }).then((result) => {
        //         if (result.isConfirmed) {
        //             let _token = fetchCsrfTokenFromForm();
        //             fetch(url, {
        //                 method : 'DELETE',
        //                 headers: {
        //                     'X-CSRF-Token' : _token,
        //                     'Content-Type':'application/json'
        //                 },
        //             }).then(response => response.json())
        //             .then((data) => {
        //                 if(data.statusCode == 200){
        //                     flashMessage(data.data.message);
        //                     pageReloadInGivenPeriod();
        //                 }
        //                 else {
        //                     flashMessage(data.data.message, 'error', data.status);
        //                 }
        //             }).catch(error => {
        //                 console.log(error);
        //             });
        //             // console.log(res);
        //         }
        //     })
        // }
    </script>
@endpush
