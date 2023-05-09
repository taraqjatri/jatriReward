<?php

namespace App\Http\Controllers\v1;

use App\Constants\PNRStatus;
use App\Enum\ProductListEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserPNRSubmissionResource;
use App\Models\UserPNRSubmission;
use App\Services\CacheService;
use App\Ticket\FindTicket;
use App\Ticket\TicketDetailsModel;
use Illuminate\Http\Request;

class PNRController extends Controller
{
    public function store(Request $request, FindTicket $findTicket, CacheService $cacheService)
    {
        $userPNRSubmission = new UserPNRSubmission ();
        $userPNRSubmission->status = PNRStatus::INVALID;
        $userPNRSubmission->user_id = $request->user()->id;
        $userPNRSubmission->user_name = $request->user()->first_name . ' ' . $request->user()->last_name;
        $userPNRSubmission->user_mobile = $request->user()->phone;
        $userPNRSubmission->pnr = $request->pnr;

        if ($request->pnr) {
            $ticket_details = $findTicket->getDetails($request->pnr);
            if ($ticket_details) {
                $userPNRSubmission->product = ProductListEnum::tryFrom(getDetailsFromAPNR($request->pnr)['product_code'])?->name;
                $userPNRSubmission->status = PNRStatus::VALID;
                $all_attributes_of_ticket_model = get_class_vars(TicketDetailsModel::class);
                foreach ($all_attributes_of_ticket_model as $k => $v) {
                    if (isset($ticket_details->$k)) $userPNRSubmission->setAttribute($k, $ticket_details->$k);
                }
            }
        }
        $userPNRSubmission->save();
        if ($userPNRSubmission->status == PNRStatus::VALID) { // if valid then new points added need to ensure leaderboard is updated
            $cacheService->forgetAllTypeUserLeaderBoard(todayDateCacheFormat());
            $cacheService->forgetAllTypeSellerLeaderBoard(todayDateCacheFormat());

        }

        return response()->success(message: 'PNR Submitted successfully', data: ['data' => new UserPNRSubmissionResource($userPNRSubmission)]);
    }

    public function pointHistory(Request $request)
    {
        $points_history = UserPNRSubmission::query()
            ->select('id', 'pnr','user_id', 'user_mobile', 'user_point', 'status', 'created_at')
            ->where([['user_id', $request->user()->id], ['status', PNRStatus::VALID]])
            ->orderBy('id', 'desc')
            ->paginate(50);
        return response()->success(['data' => $points_history]);
    }

}
