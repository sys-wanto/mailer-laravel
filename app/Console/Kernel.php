<?php

namespace App\Console;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\NotaDinas;
use App\Models\SuratTugas;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            SuratMasuk::where('created_at', '<', now()->subYears(5))->delete();
        })->daily();
        $schedule->call(function () {
            SuratKeluar::where('created_at', '<', now()->subYears(5))->delete();
        })->daily();
        $schedule->call(function () {
            NotaDinas::where('created_at', '<', now()->subYears(5))->delete();
        })->daily();
        $schedule->call(function () {
            SuratTugas::where('created_at', '<', now()->subYears(5))->delete();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
