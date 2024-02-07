<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call( function(){
            $sharePerc = 75;
            $wallets = DB::table('artist_wallet')->get();

            $totalEarnOfMonth = DB::table('transaction')
            ->where('status', 1)
            ->where('plan_item_id', '<>', 'null')
            ->where('updated_at', '>=' , Carbon::now()->subDays(30))
            ->sum('price_T');

            $totalViewsOfMonth = DB::table('views')
            ->where('updated_at', '>=', Carbon::now()->subDays(30))
            ->count();

            foreach ($wallets as $wallet) {
                $artistViewsOfMonth = DB::table('views')
                ->join('songs', 'views.music_id' ,'=', 'songs.id')
                ->where('songs.owner_id', $wallet->artist_id)
                ->where('views.updated_at', '>=', Carbon::now()->subDays(30))
                ->count();

                $wallet_charge = ($totalViewsOfMonth == 0) ? 0 : ($artistViewsOfMonth/$totalViewsOfMonth) * (($totalEarnOfMonth * $sharePerc)/100);
                info($wallet_charge);
                DB::table('artist_wallet')
                ->where('artist_id', $wallet->artist_id)
                ->update([
                    'balance' => $wallet->balance + $wallet_charge,
                    'updated_at' => Carbon::now(),
                ]);
            }
        } )
        ->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
