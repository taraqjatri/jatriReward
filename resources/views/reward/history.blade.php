@extends('master')

@section('title')
    PNR Users
@endsection

@section('header')
    <script src="{{ url()->asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
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
    <span class="breadcrumb-item active">PNR Submission History</span>
@endsection

@section('page_content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <form class="form-horizontal form-label-left" method="get"
                      action="{{ url('/pnr-submission-history') }}">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Status</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="status" class="form-control style-input">
                                    <option value="ALL" {{ (request('status') == 'ALL') ? 'selected' : '' }}>ALL
                                    </option>
                                    @foreach(\App\Constants\PNRStatus::all() as $name => $value)
                                        <option
                                            value="{{ $value }}" {{ (request('status') == $value) ? 'selected' : '' }}>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Date Range: </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control daterange-basic" name="date_range"
                                       autocomplete="off"
                                       value="{{ request('date_range') ?? '' }}"
                                       data-format="d/m/Y - d/m/Y"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Search By PNR</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input class="form-control style-input" type="text" name="pnr"
                                       value="{{ request('pnr') ?? '' }}" placeholder="PNR">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Search By Number</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input class="form-control style-input" type="text" name="number"
                                       value="{{ request('number') ?? '' }}" placeholder="Number">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Vehicle NO</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input class="form-control style-input" type="text" name="vehicle_no"
                                       value="{{ request('vehicle_no') ?? '' }}" placeholder="Vehicle NO">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Search By Seller Number</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input class="form-control style-input" type="text" name="seller_number"
                                       value="{{ request('seller_number') ?? '' }}" placeholder="Seller Number">
                            </div>
                        </div>

                        {{--                        <div class="form-group col-md-2">--}}
                        {{--                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Company</label>--}}
                        {{--                            <div class="col-md-12 col-sm-12 col-xs-12">--}}
                        {{--                                <select name="status" class="form-control style-input">--}}
                        {{--                                    <option value="#">Option 1</option>--}}
                        {{--                                    <option value="#">Option 2</option>--}}
                        {{--                                    <option value="#">Option 3</option>--}}
                        {{--                                </select>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

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


    <div class="col-12">
        <div class="row card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>#</th>
                                <th>PNR</th>
                                <th>User Info</th>
                                <th>Company</th>
                                <th>Vehicle NO</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Seller Info</th>
                                <th>Status</th>
                                <th>User Point</th>
                                <th>Seller Point</th>
                                <th>Datetime</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ request('page') ? $loop->iteration + ((request('page') - 1) * 50) : $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ url('pnr-submission-history/details/'.$user->id) }}">{{ $user->pnr }}</a>
                                    </td>
                                    <td>
                                        <b>Name:</b> {{ $user->user_name }} <br>
                                        <b>Phone:</b> {{ $user->user_mobile }}
                                    </td>
                                    <td>
                                        <b>ID:</b> {{ $user->company_id }} <br>
                                        <b>Name:</b> {{ $user->company_name }}
                                    </td>
                                    <td>{{ $user->vehicle_no }}</td>
                                    <td>{{ $user->from_stoppage }}</td>
                                    <td>{{ $user->to_stoppage }}</td>
                                    <td>
                                        <b>ID:</b> {{ $user->seller_id }} <br>
                                        <b>Name:</b> {{ $user->seller_name }} <br>
                                        <b>Phone:</b> {{ $user->seller_mobile }}
                                    </td>
                                    <td class="text-center">
                                        @if($user->status==\App\Constants\PNRStatus::VALID)
                                            <span class="badge bg-success">{{ \App\Constants\PNRStatus::VALID }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ \App\Constants\PNRStatus::INVALID }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->user_point }}</td>
                                    <td>{{ $user->seller_point }}</td>
                                    <td>{{ $user->created_at->format('F j, Y g:i A') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    {{ $users->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
