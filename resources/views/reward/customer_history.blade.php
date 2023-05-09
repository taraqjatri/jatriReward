@extends('master')

@section('title')
    Customer History
@endsection

@section('external_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.0-alpha.1/jspdf.plugin.autotable.js"></script>
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item">Reward</span>
    <a href="{{ url('/customer-leader-board') }}" class="breadcrumb-item"> Customer Leader Board</a>
    <span class="breadcrumb-item active">Submission History</span>
@endsection

@section('page_actions')
        <div class="dropdown ms-lg-3">
            <a href="#" class="d-flex align-items-center text-body dropdown-toggle py-2" data-bs-toggle="dropdown">
                <i class="icon-download4 me-1"></i>
                <span class="flex-1">Export</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end w-100 w-lg-auto" style="">
                <button onclick="exportCSV()" class="btn" style="background: none;"><i class="icon-file-excel me-2" style="color: #207245;"></i> Export to CSV</button>
                <li class="divider"></li>
            </div>
        </div>
@endsection

@section('page_content')
    <div class="col-12">
        <div class="row card">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <span class="badge bg-dark text-white m-2"> User ID: {{ $pnr_submissions->first()->user_id }} </span>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>SL</th>
                                <th>Point</th>
                                <th>T.Serial</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Company</th>
                                <th>Seller</th>
                                <th>Submitted At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pnr_submissions as $pnr)
                                <tr>
                                    <td>{{ request('page') ? $loop->iteration + ((request('page') - 1) * 50) : $loop->iteration }}</td>
                                    <td>{{ $pnr->user_point }}</td>
                                    <td>{{ $pnr->serial }}</td>
                                    <td>{{ $pnr->from_stoppage }}</td>
                                    <td>{{ $pnr->to_stoppage }}</td>
                                    <td>{{ $pnr->amount }}</td>
                                    <td>
                                        <b>ID:</b> {{ $pnr->company_id }}
                                        <b>Name:</b> {{ $pnr->company_name }}
                                    </td>
                                    <td>
                                        <b>ID: </b> {{ $pnr->seller_id }}
                                        <b>Name: </b> {{ $pnr->seller_name }}
                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $pnr->created_at)->format('F j, Y g:i A') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right">Total Point</th>
                                <th class="text-center">{{ $pnr_submissions->sum('user_point') }}</th>
                                <th colspan="8" class="text-center"></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    {{ $pnr_submissions->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_js')
    <script>
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            csvFile = new Blob(["\uFEFF" + csv], {
                type: 'text/csv; charset=utf-18'
            });

            downloadLink = document.createElement("a");

            downloadLink.download = filename;

            downloadLink.href = window.URL.createObjectURL(csvFile);

            downloadLink.style.display = "none";

            document.body.appendChild(downloadLink);

            downloadLink.click();
        }

        function exportCSV() {
            var currentTime = new Date().getTime();
            var filename = 'customer-history-' + currentTime + '.csv';
            var csv = [];
            var rows = document.querySelectorAll(".table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++) {
                    if (j === 2) cols[j] = ' ';
                    row.push(cols[j].innerText);
                }

                csv.push(row.join(","));
            }
            downloadCSV(csv.join("\n"), filename);
            return false; // add this line to prevent page refresh
        }
    </script>
@endsection
