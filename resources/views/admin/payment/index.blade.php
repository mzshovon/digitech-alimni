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
                                        onclick="createEditModalShow(null,null,null,null)">Add Manual Payment</a>
                                        <a href="{{route('admin.payment.charge')}}" class="btn btn-success btn-sm">Stripe Payment</a>
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
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Payment Channel</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Submitted At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $key => $payment)
                                        <tr>
                                            <th scope="row">{{ ++$key }}</th>
                                            <td>{{ $payment['user']['name'] }}</td>
                                            <td>{{ $payment['user']['email'] }}</td>
                                            <td>{{ $payment['user']['contact'] }}</td>
                                            <td>{{ $payment['payment_channel'] }}</td>
                                            <td>{{ $payment['trans_id'] }}</td>
                                            <td>{{ $payment['amount'] }}</td>
                                            <td><button class="btn btn-{{$payment['status'] == 'pending' ? 'warning' : ($payment['status'] == 'approved' ? 'success' : 'danger')}} btn-sm">{{ ucwords($payment['status']) }}</button></td>
                                            <td>{{ \Carbon\Carbon::parse($payment['created_at'])->format("d, M Y") }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm"
                                                onclick="createEditModalShow(`{{$payment['payment_channel']}}`,`{{$payment['amount']}}`,`{{$payment['trans_id']}}`, `{{$payment['user_id']}}`)">Update</a>
                                                @if ($payment['image_path'])
                                                    <a href="{{URL::to('/') ."/". $payment['image_path']}}" download="download" class="btn btn-outline-primary btn-sm">Download <i class="bi bi-download"></i></a>
                                                @endif
                                                @if (auth()->user()->hasRole('superadmin'))
                                                    @if (in_array($payment['status'], ["pending", "declined"]))
                                                        <a href="{{route('admin.payment.update.status',['id' => $payment['id'], 'status' => 'approved'])}}" class="btn btn-outline-success btn-sm"><i class="bi bi-check-circle"></i> Approve</a>
                                                        <a href="{{route('admin.payment.update.status',['id' => $payment['id'], 'status' => 'declined'])}}" class="btn btn-outline-danger btn-sm"><i class="bi bi-slash-circle"></i> Decline</a>
                                                    @else
                                                        <a href="{{route('admin.payment.update.status',['id' => $payment['id'], 'status' => 'pending'])}}" class="btn btn-outline-warning btn-sm"><i class="bi bi-slash-circle"></i> Pending</a>
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

                    {{--  Assign modal start  --}}
                    <div class="modal fade" id="create-or-edit-modal" tabindex="-1" data-bs-backdrop="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="submitModalForm" action="{{ route('admin.payment.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="id_user">
                                        <div class="modal-body">
                                                <div class="d-flex align-items-start">
                                                  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true" tabindex="-1" ><img src="https://freelogopng.com/images/all_img/1656235223bkash-logo.png" style="height: 20px;width:20px"/> Bkash</button>
                                                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" ><i class="bi bi-collection me-1 text-black"></i> Bank</button>
                                                  </div>
                                                  <div class="tab-content" id="v-pills-tabContent">
                                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                        Baksh No.: 01713-100850 (Personal)
                                                        <br><b><i>* (For Bkash Payment - Member should pay with Membership Fee plus Bkash Charge.)</i></b>
                                                    </div>
                                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                        <b>A/C Name:</b> CTG. UNIVERSITY MANAGEMENT ASSOCIATION <br>
                                                        <b>A/C. #</b> 4110-756757-300<br>
                                                        <b>Bank :</b> AB BANK LIMITED<br>
                                                        <b>Bank Branch Name:</b> CDA AVENUE BRANCH<br>
                                                        CHATTOGRAM
                                                    </div>
                                                  </div>
                                                </div>
                                              <br>
                                            <select name="payment_channel" id="id_payment_channel" class="form-control">
                                                <option id="option_idBkash" value="Bkash">Bkash</option>
                                                <option id="option_idBEFTN" value="BANK">BEFTN</option>
                                                <option id="option_idCheque" value="Cheque">Cheque</option>
                                            </select>
                                            <br>
                                            <input type="number" class="form-control" placeholder="Enter Payment Amount"
                                                name="amount" id="id_amount" required>
                                            <br>
                                            <input type="text" class="form-control" placeholder="Enter Transaction Number"
                                                name="trans_id" id="id_trans_id" required>
                                            <br>
                                            <input type="file" class="form-control" placeholder="Submit Payment Slip"
                                                name="payment_image" id="id_trans_id">
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
