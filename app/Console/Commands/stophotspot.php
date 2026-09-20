<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exceptions\Controller;
use Illuminate\Http\JsonResponse;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use Carbon\Carbon;
use App\Models\Hotspot;
use App\Models\Hotlogs;
use App\Models\Cache;
use Illuminate\Support\Facades\Redirect; 
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class stophotspot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stophotspot';

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
        $dateNow = Carbon::now();
        $getUsers = Hotspot::where('end_date', '<', Carbon::now())->where('status',1)->get();
        foreach($getUsers as $getUser){
                $createlog = Hotlogs::create([
                    'amount' => $getUser->amount,
                    'hotspot_id' => $getUser->phone,
                    'reason' => 4,
                    'status' => 0,
                    'date' => $dateNow,
                    'end_date' => $getUser->end_date,                           

                ]);

                        try{
                                // 1. Connect to your MikroTik router
                        $client = new Client([
                                'host' => '10.50.0.3',
                                'user' => 'admin',
                                'pass' => '123456',
                                'port' => 8728,
                        ]);

                        $usernameToDisconnect = $getUser->phone;

                        // 2. Find the active session by username to get its internal .id
                        $findQuery = (new Query('/ip/hotspot/active/print'))
                            ->where('user', $usernameToDisconnect);

                        $activeSession = $client->query($findQuery)->read();

                        // 3. If the user is currently active, remove their active session
                        if (isset($activeSession[0]['.id'])) {
                            $sessionId = $activeSession[0]['.id'];

                            $removeQuery = (new Query('/ip/hotspot/active/remove'))
                                ->equal('.id', $sessionId);

                            $client->query($removeQuery)->read();
                        }
                            Log::info('Hotspot active user deleted');

                    }
               
                      catch (\Exception $e) {
                      Log::info('Error deleting active hotspot user');
                        $cache = Cache::create([
                                'user_id' => $getUser->id,
                                'status' => 52,
                            ]);

                    }

                try{
                        // 1. Connect to your MikroTik router
                    $client = new Client([
                        'host' => '10.50.0.3',
                        'user' => 'admin',
                        'pass' => '123456',
                        'port' => 8728,
                    ]);

                    $usernameTootipDelete = $getUser->phone;

                    // 2. Find the user by name to get their internal .id
                    $findQuery = (new Query('/ip/hotspot/user/print'))
                        ->where('name', $usernameTootipDelete);

                    $user = $client->query($findQuery)->read();

                    // 3. Check if user exists and delete via .id
                    if (isset($user[0]['.id'])) {
                        $userId = $user[0]['.id'];

                        $removeQuery = (new Query('/ip/hotspot/user/remove'))
                            ->equal('.id', $userId);

                        $client->query($removeQuery)->read();
                        Log::info('Hotspot user deleted');
                        $deleteHotspotUser = Hotspot::where('id',$getUser->id)->delete();


                    }
                }
                        catch (\Exception $e) {
                      Log::info('Error deleting hotspot user');
                       $cache = Cache::create([
                                'user_id' => $getUser->id,
                                'status' => 53,
                            ]);

                    }

              

                   
            




        }
    }
}
