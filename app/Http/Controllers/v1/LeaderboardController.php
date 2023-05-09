<?php

namespace App\Http\Controllers\v1;

use App\Constants\PNRStatus;
use App\Constants\QueryVariation;
use App\Http\Controllers\Controller;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Str;

class LeaderboardController extends Controller
{
    public function leaderboard(Request $request, CacheService $cacheService)
    {
        $query_type = QueryVariation::DAILY;
        if ($request->type == 'weekly') $query_type = QueryVariation::WEEKLY;
        else if ($request->type == 'monthly') $query_type = QueryVariation::MONTHLY;

        $today_date_cache_format = todayDateCacheFormat();
        $leaderboard = $cacheService->getOrSetTypeWiseUserLeaderBoard($today_date_cache_format, $query_type);
        return response()->success(['data' => $leaderboard]);
    }
}
