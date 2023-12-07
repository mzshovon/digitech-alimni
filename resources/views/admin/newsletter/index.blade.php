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
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Template Name</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Sender</th>
                                        <th scope="col">Send At</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($newsLetters as $key => $newsLetter)
                                        <tr>
                                            <th scope="row">{{ $key++ }}</th>
                                            <td>{{ $newsLetter['template_name'] }}</td>
                                            <td>{{ $newsLetter['start_date']}}</td>
                                            <td>{{ $newsLetter['end_date'] }}</td>
                                            <td>{{ $newsLetter['operated_by'] }}</td>
                                            <td>{{ $newsLetter['send_at'] }}</td>
                                            <td><button class="btn btn-{{$newsLetter['status'] == 'Processing' ? 'warning' : ($newsLetter['status'] == 'Sent' ? 'success' : 'danger')}} btn-sm">{{ ucwords($newsLetter['status']) }}</button></td>
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
