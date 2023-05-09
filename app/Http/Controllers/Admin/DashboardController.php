<?php

namespace App\Http\Controllers\Admin;

use App\Constants\PNRStatus;
use App\Helper\ControllerHelper;
use App\Http\Controllers\Controller;
use App\Models\UserPNRSubmission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        view()->share('page', config('app.nav')['dashboard']);
        if (!ControllerHelper::checkAuthorization(config('access.global.dashboard'), auth()->user()->roles)) return view('welcome');

        $date_range = $request->input('date_range',  date('d/m/Y') . ' - ' . date('d/m/Y'));
        $db_formatted_date = ControllerHelper::getDateDBFormatFromDateRange($date_range);
        $from_date = $db_formatted_date['from_date'];
        $to_date = $db_formatted_date['to_date'];
        $date_diff = ControllerHelper::getDateDifferenceInDays($from_date, $to_date);
        
        if (!ControllerHelper::isAllowedDateDiffServiceWise('DASHBOARD', ($date_diff+1))) {
            return redirect()->back()->with('error', "From date must be lesser than to date || maximum allowed days exceed.");
        }

        $pnr_submission = UserPNRSubmission::query()
            ->where('created_at', '>=', $from_date)
            ->where('created_at', '<=', $to_date . ' 23:59:59')
            ->get();
        $dashboard_summaries['total_pnr'] = $pnr_submission->count();
        $dashboard_summaries['total_valid_pnr'] = $pnr_submission->where('status', PNRStatus::VALID)->count();
        $dashboard_summaries['total_invalid_pnr'] = $pnr_submission->where('status', PNRStatus::INVALID)->count();

        return view('dashboard', compact('from_date', 'to_date', 'date_range', 'dashboard_summaries'));
    }

}
