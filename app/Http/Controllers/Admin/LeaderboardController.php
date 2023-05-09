<?php

namespace App\Http\Controllers\Admin;

use App\Constants\PNRStatus;
use App\Helper\ControllerHelper;
use App\Http\Controllers\Controller;
use App\Models\UserPNRSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function customerLeaderBoard(Request $request): View
    {
        view()->share('page', config('app.nav.customer_leader_board'));

        if (!ControllerHelper::checkAuthorization(config('access.reward.read'), auth()->user()->roles)) return view('welcome');

        $date = ControllerHelper::getTypeWiseFromDateToDate($request->type);
        $from = $date['from']->format('Y-m-d');
        $to = $date['to']->format('Y-m-d');

        $leaderboard = DB::table('user_p_n_r_submissions')
            ->selectRaw('id, user_id, user_name, user_mobile, user_point, CAST(SUM(user_point) as SIGNED ) as total_points',)
            ->where('status', PNRStatus::VALID)
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to . ' 23:59:59')
            ->groupBy('user_id')
            ->orderBy('total_points', 'DESC')
            ->limit(50)
            ->paginate(50);

        return view('reward.customer_leader_board', compact('leaderboard', 'from', 'to'));
    }

    public function customerHistory($user_id, Request $request): View|RedirectResponse
    {
        view()->share('page', config('app.nav.customer_leader_board'));

        if (!ControllerHelper::checkAuthorization(config('access.reward.read'), auth()->user()->roles)) return view('welcome');

        $date = ControllerHelper::getTypeWiseFromDateToDate($request->type);
        $from = $date['from']->format('Y-m-d');
        $to = $date['to']->format('Y-m-d');

        $pnr_submissions = DB::table('user_p_n_r_submissions')
            ->where('user_id', $user_id)
            ->where('status', PNRStatus::VALID)
            ->when(!empty($request->type), function ($q) use ($from, $to) {
                return $q->where('created_at', '>=', $from)
                    ->where('created_at', '<=', $to . ' 23:59:59');
            })
            ->latest('created_at')
            ->limit(50)
            ->paginate(50);

        if ($pnr_submissions->count() < 1) {
            return redirect()->back()->withErrors('Unable to find record of this user');
        }

        return view('reward.customer_history', compact('pnr_submissions', 'from', 'to'));
    }

    public function sellerLeaderBoard(Request $request)
    {
        view()->share('page', config('app.nav.seller_leader_board'));

        if (!ControllerHelper::checkAuthorization(config('access.reward.read'), auth()->user()->roles)) return view('welcome');

        $sellers = UserPNRSubmission::selectRaw('id, seller_id, seller_name, seller_mobile, seller_point, CAST(SUM(seller_point) as SIGNED ) as total_points')
            ->where('status', PNRStatus::VALID)
            ->groupBy('seller_id')
            ->orderBy('total_points', 'DESC');

        $date = ControllerHelper::getTypeWiseFromDateToDate($request->type);
        $from = $date['from']->format('Y-m-d');
        $to = $date['to']->format('Y-m-d');

        if (!empty(request())) {

            if ($request->has('seller_type') && $request->seller_type != 'ALL') {
                $sellers->where('seller_type', $request->seller_type);
            }

            $sellers->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to . ' 23:59:59');
        }

        $sellers_query = $sellers->limit(50);
        $sellers = $sellers_query->paginate(50);

        return view('reward.seller_leader_board', compact('sellers', 'from', 'to'));
    }

    public function sellerHistory($seller_id, Request $request): View|RedirectResponse
    {
        view()->share('page', config('app.nav.seller_leader_board'));

        if (!ControllerHelper::checkAuthorization(config('access.reward.read'), auth()->user()->roles)) return view('welcome');

        $date = ControllerHelper::getTypeWiseFromDateToDate($request->type);
        $from = $date['from']->format('Y-m-d');
        $to = $date['to']->format('Y-m-d');
        $seller_type = $request->seller_type;

        $seller_point_list = DB::table('user_p_n_r_submissions')
            ->select('*')
            ->where('seller_id', $seller_id)
            ->where('status', PNRStatus::VALID)
            ->when(!empty($request->type) && $request->type != 'ALL', function ($q) use ($from, $to) {
                return $q->where('created_at', '>=', $from)
                    ->where('created_at', '<=', $to . ' 23:59:59');
            })
            ->when(!empty($request->seller_type) && $request->seller_type != 'ALL' , function ($q) use ($seller_type) {
                return $q->where('seller_type', $seller_type);
            })
            ->latest('created_at')
            ->limit(50)
            ->simplePaginate(50);

        if ($seller_point_list->count() < 1) {
            return redirect()->back()->withErrors('Unable to find record of this seller');
        }

        return view('reward.seller_history', compact('seller_point_list', 'from', 'to'));
    }
}
