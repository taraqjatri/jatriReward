@extends('master')

@section('title')
    PNR User Details
@endsection

@section('external_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.0-alpha.1/jspdf.plugin.autotable.js"></script>
    <script src="{{ url()->asset('assets/js/pickers/daterangepicker.js') }}"></script>
    <script src="{{ url()->asset('assets/js/pickers/picker_date.js') }}"></script>
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item">Reward</span>
    <a href="{{ url('/pnr-submission-history') }}" class="breadcrumb-item">PNR Submission History</a>
    <span class="breadcrumb-item active">Details</span>
@endsection

@section('page_content')
    <section>
        <div class="container">
            <div class="card">
                <h5 class="card-header text-center">Ticket Details</h5>
                <div class="card-body m-3">
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">PNR</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ $pnr_details->pnr }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">Serial</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ $pnr_details->serial }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">Product</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ $pnr_details->product }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">Company ID</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ $pnr_details->company_id }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">Company Name</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ $pnr_details->company_name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">Journey Date</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pnr_details->journey_date)->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">From</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ $pnr_details->from_stoppage }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class=" col-6">
                            <p class="mb-0">To</p>
                        </div>
                        <div class=" col-6">
                            <p class="text-muted mb-0">{{ $pnr_details->to_stoppage }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between">
                @if($pnr_details->status == \App\Constants\PNRStatus::VALID)
                    <div class="card col-6">
                        <h5 class="card-header text-center">User Details</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-6">
                                    <p class="mb-0">ID</p>
                                </div>
                                <div class=" col-5">
                                    <p class="text-muted mb-0">{{ $pnr_details->user_id }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-5">
                                    <p class="mb-0">Full Name</p>
                                </div>
                                <div class=" col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->user_name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-6">
                                    <p class="mb-0">Mobile</p>
                                </div>
                                <div class=" col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->user_mobile }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-6">
                                    <p class="mb-0">Point</p>
                                </div>
                                <div class=" col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->user_point }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-6">
                        <h5 class="card-header text-center">Seller Details</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-0">ID</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->seller_id }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-6">
                                    <p class="mb-0">Full Name</p>
                                </div>
                                <div class=" col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->seller_name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-6">
                                    <p class="mb-0">Mobile</p>
                                </div>
                                <div class=" col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->seller_mobile }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-6">
                                    <p class="mb-0">Type</p>
                                </div>
                                <div class=" col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->seller_type }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-6">
                                    <p class="mb-0">Point</p>
                                </div>
                                <div class=" col-6">
                                    <p class="text-muted mb-0">{{ $pnr_details->seller_point }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($pnr_details->status == \App\Constants\PNRStatus::INVALID)
                    <div class="card col-6">
                        <h5 class="card-header text-center">User Details</h5>
                        <div class="alert alert-danger" role="alert">
                            No data found.
                        </div>
                    </div>
                    <div class="card col-6">
                        <h5 class="card-header text-center">Seller Details</h5>
                        <div class="alert alert-danger" role="alert">
                            No data found.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
