<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ControllerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PnrSubmissionRequest;
use App\Models\UserPNRSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserPnrSubmissionController extends Controller
{
    public function index(PnrSubmissionRequest $request): View
    {
        view()->share('page', config('app.nav.pnr_submission_history'));

        if (!ControllerHelper::checkAuthorization(config('access.reward.read'), auth()->user()->roles)) return view('welcome');

        $date_range = date('d/m/Y') . ' - ' . date('d/m/Y');

        if ($request->has('date_range') && !empty($request->date_range)) {
            $date_range = ControllerHelper::getDateDBFormatFromDateRange($request->date_range);
        }

        $submission_query = UserPNRSubmission::query();


        if (!empty($request)) {
            if ($request->has('status') && $request->status != 'ALL') {
                $submission_query->where('status', $request->status);
            }

            if ($request->has('date_range') && !empty($request->date_range)) {
                $submission_query->where('created_at', '>=', $date_range['from_date'])
                    ->where('created_at', '<=', $date_range['to_date'] . ' 23:59:59');
            }

            if ($request->has('pnr')) {
                $submission_query->where('pnr', 'like', '%' . $request->pnr . '%');
            }

            if ($request->has('number') && !empty($request->number)) {
                $submission_query->where('user_mobile', $request->number);
            }

            if ($request->has('vehicle_no') && !empty($request->vehicle_no)) {
                $submission_query->where('vehicle_no', 'like', '%' . $request->vehicle_no . '%');
            }

            if ($request->has('seller_number') && !empty($request->seller_number)) {
                $submission_query->where('seller_mobile', $request->seller_number);
            }
        }
        $users = $submission_query->paginate(50);

        return view('reward.history', compact('users'));
    }

    public function details($id): View|RedirectResponse
    {
        view()->share('page', config('app.nav.pnr_submission_history'));

        if (!ControllerHelper::checkAuthorization(config('access.reward.read'), auth()->user()->roles)) return view('welcome');

        $pnr_details = UserPNRSubmission::find($id);

        if (!$pnr_details) {
            return redirect('/pnr-submission-history')->withErrors('Unable to find this user');
        }
        return view('reward.details', compact('pnr_details'));
    }
}
