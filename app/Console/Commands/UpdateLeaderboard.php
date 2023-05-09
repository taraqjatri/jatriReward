<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;
use Log;

class UpdateLeaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-leaderboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Log::info($this->signature);
        $cacheService = new CacheService();
        $cache_date = todayDateCacheFormat();

        $cacheService->forgetAllTypeUserLeaderBoard($cache_date); // forget already cached data
        $cacheService->forgetAllTypeSellerLeaderBoard($cache_date); // forget already cached data

        $cacheService->getOrSetAllTypeWiseUserLeaderBoard($cache_date); // set all type leaderboard
        $cacheService->getOrSetAllTypeWiseSellerLeaderBoard($cache_date); // set all type leaderboard
    }
}
