<?php

namespace App\Constants;
enum CacheKey: string
{

    const CACHE_TIME = 3600;  //unit -> second
    const CACHE_TIME_15M = 900;  //unit -> second
    const CACHE_TIME_3H = 10800;  //unit -> second

    const CACHE_TIME_6H = 21600; //unit -> second

    const USER_LEADERBOARD_CACHE_KEY = 'USER_LEADERBOARD_CACHE_KEY';
    const SELLER_LEADERBOARD_CACHE_KEY = 'SELLER_LEADERBOARD_CACHE_KEY';
}
