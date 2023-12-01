@extends('admin.layouts.master')
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
                                        onclick="createEditModalShow(null,null,null)">Add new</a>
                                    </h5>
                                </div>
                            </div>
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Submitted At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $key => $contact)
                                        <tr>
                                            <th scope="row">{{ ++$key }}</th>
                                            <td>{{ $contact['user']['name'] }}</td>
                                            <td>{{ $contact['user']['email'] }}</td>
                                            <td>{{ $contact['subject'] }}</td>
                                            <td>{{ $contact['message'] }}</td>
                                            <td>{{ $contact['status'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($contact['created_at'])->format("d, M Y") }}</td>
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
                                <form id="submitModalForm" action="{{ route('admin.contact.submit') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Send Mail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="id_user">
                                        <div class="modal-body">
                                            <input type="text" class="form-control" placeholder="Enter subject"
                                                name="subject" id="id_subject" required>
                                            <br>
                                            <textarea name="message" class="form-control" id="id_message" required></textarea>
                                            <small>Enter your message here</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Send <i class="bi bi-send"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--  assign modal end  --}}

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
@push('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        function createEditModalShow(subject, message) {
            if (subject) {
                $("#id_subject").val(subject);
            } else {
                $("#id_subject").val('');
            }
            if (message) {
                $("#id_message").val(message);
            } else {
                $("#id_message").val('');
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
