@extends('master')

@section('title')
    Seller Leaderboard
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item">Reward</span>
    <span class="breadcrumb-item active">Seller Leader Board</span>
@endsection

@section('page_content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <form class="form-horizontal form-label-left" method="get" action="{{ url('/seller-leader-board') }}">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Leader Board Type</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="type" class="form-control style-input">
                                    <option value="ALL" {{ (request('type') == 'ALL') ? 'selected' : '' }}>ALL</option>
                                    @foreach(\App\Constants\QueryVariation::all() as $name => $value)
                                        <option
                                                value="{{ $value }}" {{ (request('type') == $value) ? 'selected' : '' }}>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Seller Type</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="seller_type" class="form-control style-input">
                                    <option value="ALL" {{ (request('seller_type') == 'ALL') ? 'selected' : '' }}> ALL
                                    </option>
                                    @foreach(\App\Constants\SellerType::all() as $name => $value)
                                        <option
                                                value="{{ $value }}" {{ (request('seller_type') == $value) ? 'selected' : '' }}>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
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

                @if(request('type') == \App\Constants\QueryVariation::WEEKLY || request('type') == \App\Constants\QueryVariation::MONTHLY)
                    <div class="card col-md-4 mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="card-title">Start Date</h5>
                                    <p class="card-text">{{ date('l, F j, Y', strtotime($from)) }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h5 class="card-title">End Date</h5>
                                    <p class="card-text">{{ date('l, F j, Y', strtotime($to)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
                                <th>SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Points</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sellers as $seller)
                                <form action="{{ url('seller-leader-board/details/'.$seller->seller_id) }}"
                                      method="get">
                                    <input type="hidden" name="type" value="{{request('type') }}">
                                    <input type="hidden" name="seller_type" value="{{request('seller_type') }}">
                                    <tr>
                                        <td>{{ request('page') ? $loop->iteration + ((request('page') - 1) * 50) : $loop->iteration }}</td>
                                        <td>{{ $seller->seller_name }}</td>
                                        <td>{{ $seller->seller_mobile }}</td>
                                        <td>{{ $seller->total_points }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-outline-primary">Details</button>
                                        </td>
                                    </tr>
                                </form>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    {{ $sellers->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
