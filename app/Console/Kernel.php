<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // TESTING.
        $schedule->command('generate:monthly-report')->monthlyOn(4, '15:15');
        // $schedule->command('send:monthly-report-broker')->monthlyOn(3, '14:35');
        $schedule->command('send:monthly-report-internal')->monthlyOn(4, '16:00');

        // $schedule->command('generate:monthly-report')->monthlyOn(4, '01:00');
        // $schedule->command('send:monthly-report-broker')->monthlyOn(4, '05:00');
        // $schedule->command('send:monthly-report-internal')->monthlyOn(5, '05:00');

        // generate tanggal 4. di bulan ini jam 1 pagi.
        // sending report broker tanggal 4, bulan ini, jam 5 pagi.
        // sending report internal tanggal 5, bulan ini, jam 5 pagi.
        // DI LIVE, REPORTGENERATOR (181), SEA (24)
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
