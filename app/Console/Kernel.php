<?php

namespace App\Console;

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
        // Payment overdue checking command
        \App\Console\Commands\CheckOverduePayments::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Check for overdue payments daily at 9:00 AM
        $schedule->command('payments:check-overdue')
                 ->dailyAt('09:00')
                 ->timezone('Asia/Colombo')
                 ->onSuccess(function () {
                     \Log::info('Payment overdue check completed successfully');
                 })
                 ->onFailure(function () {
                     \Log::error('Payment overdue check failed');
                 });
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
