<?php

namespace App\Services;

use App\Constants\PNRStatus;
use App\Models\B2CService\User;
use Illuminate\Support\Facades\DB;

class LeaderboardService
{

    public static function getTypeWiseUserLeaderBoard($type): \Illuminate\Support\Collection
    {
        $from_to_dates = getTypeWiseFromDateToDate($type);
        $from = $from_to_dates['from']->format('Y-m-d');
        $to = $from_to_dates['to']->format('Y-m-d');
        $leaderboard = DB::table('user_p_n_r_submissions')
            ->selectRaw('user_id,  CAST(SUM(user_point) as SIGNED ) as total_point',)
            ->where('status', PNRStatus::VALID)
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to . ' 23:59:59')
            ->groupBy('user_id')
            ->orderBy('total_point', 'DESC')
            ->limit(10)
            ->get();
        $users = User::query()->select('id', 'first_name', 'last_name', 'image')->find($leaderboard->pluck('user_id'))->keyBy('id');
        foreach ($leaderboard as $singleOne) {
            if (isset($users[$singleOne->user_id])) {
                $singleOne->name = $users[$singleOne->user_id]->first_name;
                $singleOne->image = $users[$singleOne->user_id]->image;
            }
        }
        return $leaderboard;
    }

    public static function getTypeWiseSellerLeaderBoard($type): \Illuminate\Support\Collection
    {
        $from_to_dates = getTypeWiseFromDateToDate($type);
        $from = $from_to_dates['from']->format('Y-m-d');
        $to = $from_to_dates['to']->format('Y-m-d');
        return DB::table('user_p_n_r_submissions')
            ->selectRaw('seller_id, CAST(SUM(seller_point) as SIGNED ) as total_point, seller_name, seller_mobile',)
            ->where('status', PNRStatus::VALID)
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to . ' 23:59:59')
            ->groupBy('seller_id')
            ->orderBy('total_point', 'DESC')
            ->limit(10)
            ->get();

    }

    public static function getUsersDetails($user_ids)
    {
        return User::query()->select('id', 'first_name', 'last_name', 'image')->find($user_ids);
    }


}
