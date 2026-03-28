<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use App\Models\Band;

class bandwidth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bandwidth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
  
    }
}
