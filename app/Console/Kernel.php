<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use App\Models\Band;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('billing')->everyMinute();
                    
                    Schedule::call(function () {
                            try{
                                $client = new Client([
                    'host' => '197.248.79.153',
                    'user' => 'admin',
                    'pass' => 'KND@2020',
                    'port' => 8728,
                ]);

                // Monitor traffic on ether1
                $query = new Query('/interface/monitor-traffic');
                $query->equal('interface', 'pppoe_bridge');
                $query->equal('once', ''); // Use for single check, remove for stream

                $traffic = $client->query($query)->read();
                $tx_speed = $traffic[0]['tx-bits-per-second'] / 1024 / 1024;
                $rx_speed = $traffic[0]['rx-bits-per-second']/ 1024 / 1024;
                $upload = round($rx_speed, 1);
                $download = round($tx_speed, 1);
                $date = Carbon::now();
                $band = Band::create([
                    'download' => $download,
                    'upload' => $upload,
                    'date' => $date,
                ]);
                        }
                catch (\Exception $e) {}
            })->everySecond();
         $schedule->command('sendSms')->everyMinute()->when(function () {
             $now = Carbon::now();
             return $now->hour >= 9; // Runs every minute if the hour is 9 AM or later
         });
         $schedule->command('downtime')->everyMinute();
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
