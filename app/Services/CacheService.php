<?php

namespace App\Services;

use App\Constants\CacheKey;
use App\Constants\QueryVariation;
use Cache;

class CacheService
{
    public function getOrSetTypeWiseUserLeaderBoard($cached_date, $query_type)
    {
        $leaderboardService = new LeaderboardService ();
        return Cache::remember(CacheKey::USER_LEADERBOARD_CACHE_KEY . '_' . $query_type . '_' . $cached_date, CacheKey::CACHE_TIME_15M,
            function () use ($cached_date, $query_type, $leaderboardService) {
                return $leaderboardService->getTypeWiseUserLeaderBoard($query_type);
            });
    }

    public function getOrSetTypeWiseSellerLeaderBoard($cached_date, $query_type)
    {
        $leaderboardService = new LeaderboardService ();
        return Cache::remember(CacheKey::SELLER_LEADERBOARD_CACHE_KEY . '_' . $query_type . '_' . $cached_date, CacheKey::CACHE_TIME_15M,
            function () use ($cached_date, $query_type, $leaderboardService) {
                return $leaderboardService->getTypeWiseSellerLeaderBoard($query_type);
            });
    }

    public function forgetTypeSpecificUserLeaderBoard($cache_date, $query_variation)
    {
        return Cache::forget(CacheKey::USER_LEADERBOARD_CACHE_KEY . '_' . $query_variation . '_' . $cache_date);
    }

    public function forgetTypeSpecificSellerLeaderBoard($cache_date, $query_variation)
    {
        return Cache::forget(CacheKey::SELLER_LEADERBOARD_CACHE_KEY . '_' . $query_variation . '_' . $cache_date);
    }

    public function forgetAllTypeUserLeaderBoard($cache_date): void
    {
        $this->forgetTypeSpecificUserLeaderBoard($cache_date, QueryVariation::DAILY);
        $this->forgetTypeSpecificUserLeaderBoard($cache_date, QueryVariation::WEEKLY);
        $this->forgetTypeSpecificUserLeaderBoard($cache_date, QueryVariation::MONTHLY);
    }

    public function getOrSetAllTypeWiseUserLeaderBoard($cache_date): void
    {
        $this->getOrSetTypeWiseUserLeaderBoard($cache_date, QueryVariation::DAILY);
        $this->getOrSetTypeWiseUserLeaderBoard($cache_date, QueryVariation::WEEKLY);
        $this->getOrSetTypeWiseUserLeaderBoard($cache_date, QueryVariation::MONTHLY);
    }

    public function getOrSetAllTypeWiseSellerLeaderBoard($cache_date): void
    {
        $this->getOrSetTypeWiseSellerLeaderBoard($cache_date, QueryVariation::DAILY);
        $this->getOrSetTypeWiseSellerLeaderBoard($cache_date, QueryVariation::WEEKLY);
        $this->getOrSetTypeWiseSellerLeaderBoard($cache_date, QueryVariation::MONTHLY);
    }

    public function forgetAllTypeSellerLeaderBoard($cache_date): void
    {
        $this->forgetTypeSpecificSellerLeaderBoard($cache_date, QueryVariation::DAILY);
        $this->forgetTypeSpecificSellerLeaderBoard($cache_date, QueryVariation::WEEKLY);
        $this->forgetTypeSpecificSellerLeaderBoard($cache_date, QueryVariation::MONTHLY);
    }
}
