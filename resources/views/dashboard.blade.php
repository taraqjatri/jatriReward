@extends('master')

@section('title')
    Dashboard
@endsection

@section('external_js')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.0-alpha.1/jspdf.plugin.autotable.js"></script>
    <script src="{{ url()->asset('assets/js/pickers/daterangepicker.js') }}"></script>
    <script src="{{ url()->asset('assets/js/pickers/picker_date.js') }}"></script>
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item active">Dashboard</span>
@endsection

@section('page_content')
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <form class="" method="GET" action="{{ url('/dashboard') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="fw-bold col-md-12 col-sm-12 col-xs-12">Date Range: </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" class="form-control daterange-basic" name="date_range"
                                       autocomplete="off" value="{{ $date_range }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <label class="fw-bold col-md-12 col-sm-0 col-xs-0">&nbsp;</label>
                            <button type="submit"
                                    class="btn bg-dark col-lg-10 col-md-10 col-sm-12 col-xs-12 text-white">Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- Main charts -->
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Total Submission</h5>
                    </div>

                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    {{$dashboard_summaries['total_pnr']}}
                                </div>
                                <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                            </div>
                        </div>
                    </div>

                    <div class="chart position-relative" id="traffic-sources"></div>
                </div>
            </div>

            <div class="col-xl-3">

                <!-- Traffic sources -->
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Valid Submission</h5>
                    </div>

                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    {{$dashboard_summaries['total_valid_pnr']}}
                                </div>
                                <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                            </div>
                        </div>
                    </div>

                    <div class="chart position-relative" id="traffic-sources"></div>
                </div>
                <!-- /traffic sources -->

            </div>
            <div class="col-xl-3">

                <!-- Traffic sources -->
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Invalid Submission</h5>
                    </div>

                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    {{$dashboard_summaries['total_invalid_pnr']}}
                                </div>
                                <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                            </div>
                        </div>
                    </div>

                    <div class="chart position-relative" id="traffic-sources"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main charts -->

@endsection
