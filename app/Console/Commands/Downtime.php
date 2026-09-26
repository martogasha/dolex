<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cat;
use App\Exceptions\Controller;
use App\Models\Cash;
use App\Models\Expense;
use App\Models\Inv;
use App\Models\Invoice;
use App\Models\Mpesa;
use App\Models\Notice;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Hotspot;
use App\Models\Hotlogs;
use App\Models\Product;
use App\Models\Qproduct;
use App\Models\Quotation;
use App\Models\Logging;
use App\Models\User;
use App\Models\Cache;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Http;

class Downtime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downtime';

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
       $caches = Cache::all();
       $dateNow = Carbon::now();
        foreach($caches as $cache){
            if($cache->status==0 || $cache->status==2 || $cache->status==1){
           // Get the MikroTik API client using the configured facade
                            try{
                                            $config = new Config([
                                                'host' => $cache->user->mik->ip,
                                                'user' => $cache->user->mik->user,
                                                'pass' => $cache->user->mik->password,
                                                'port' => 8728,
                                        ]);
                                        $client = new Client($config);
                                        $mikId = $cache->user->mikrotik_id;

                                            // Create a query for the /ppp/profile/print command
                                            $getUser = User::where('mikrotik_id',$cache->user->mikrotik_id)->value('dis_status');
                                            if($getUser=='true'){
                                            $query = new Query('/ppp/profile/print');
                                        
                                            // 2. Build the RouterOS API query to disable the secret
                                            $query = (new Query('/ppp/secret/set'))
                                                ->equal('.id', $mikId)
                                                ->equal('disabled', 'no');

                                            // 3. Send the query and get the response
                                            $response = $client->query($query)->read();

                                            // 4. Handle the response
                                            $update = User::where('mikrotik_id',$mikId)->update(['dis_status'=>'false']);
                                            $createLogSeven = Logging::create([
                                                    'user_id' => $cache->user->id,
                                                    'reason' => 7,
                                                    'date' => $dateNow,
                                                ]);
                                            
                                            }
                                            else{
                                                $query = new Query('/ppp/profile/print');
                                        
                                            // 2. Build the RouterOS API query to disable the secret
                                            $query = (new Query('/ppp/secret/set'))
                                                ->equal('.id', $mikId)
                                                ->equal('disabled', 'yes');

                                            // 3. Send the query and get the response
                                            $response = $client->query($query)->read();

                                            // 4. Handle the response
                                            $update = User::where('mikrotik_id',$mikId)->update(['dis_status'=>'true']);
                                            $createLogEight = Logging::create([
                                                    'user_id' => $cache->user->id,
                                                    'reason' => 8,
                                                    'date' => $dateNow,
                                                ]);
                                            
                                            }
                                            $deleteCache = Cache::where('id',$cache->id)->delete();
                                }
                                    catch (\Exception $e) {
                                            // 5. Handle any connection or API errors
                                            Log::info('cache not executed');
                    
                                            return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                                        }
            }
       
        }
        foreach($caches as $cache){
            if($cache->status==3){
                           try {
                                // Get the MikroTik API client using the configured facade
                                $config = new Config([
                                    'host' => $cache->user->mik->ip,
                                    'user' => $cache->user->mik->user,
                                    'pass' => $cache->user->mik->password,
                                    'port' => 8728,
                            ]);
                            $bandwidth = $cache->user->last_name;
                            $client = new Client($config);
                            $query = (new Query('/ppp/secret/print'))->where('.id', $cache->user->mikrotik_id);
                            $secrets = $client->query($query)->read();
                            // $secrets will be an array containing the user's details if found.
                            
                            if (!empty($secrets)) {
                            $secretId = $secrets[0]['.id']; // Get the ID of the first matching user

                            $updateQuery = (new Query('/ppp/secret/set'))
                                ->equal('.id', $secretId)
                                ->equal('profile', $bandwidth); // Change the assigned profile
                                // ->equal('comment', 'Updated by Laravel'); // Add or change comments

                            $client->query($updateQuery)->read(); // Execute the update
                        }
                 
                          $deleteCache = Cache::where('id',$cache->id)->delete();      
                        
                    

                    } catch (\Exception $e) {
                        // 5. Handle any connection or API errors
                        Log::info('Cache profile not updated to '.$bandwidth.'');
                    
                        return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                    }
            }

        }
               foreach($caches as $cache){
                    if($cache->status==5){
                                  try {
                                    // Get the MikroTik API client using the configured facade
                                    $config = new Config([
                                        'host' => $cache->user->mik->ip,
                                        'user' => $cache->user->mik->user,
                                        'pass' => $cache->user->mik->password,
                                        'port' => 8728,
                                ]);
                                $bandwidth = '1MBPS';
                                $client = new Client($config);
                                $query = (new Query('/ppp/secret/print'))->where('.id', $cache->user->mikrotik_id);
                                $secrets = $client->query($query)->read();
                                // $secrets will be an array containing the user's details if found.
                                
                                if (!empty($secrets)) {
                                $secretId = $secrets[0]['.id']; // Get the ID of the first matching user

                                $updateQuery = (new Query('/ppp/secret/set'))
                                    ->equal('.id', $secretId)
                                    ->equal('profile', $bandwidth); // Change the assigned profile
                                    // ->equal('comment', 'Updated by Laravel'); // Add or change comments

                                $client->query($updateQuery)->read(); // Execute the update
                            }
                        
                                $deleteCache = Cache::where('id',$cache->id)->delete();      
                                
                            

                            } catch (\Exception $e) {
                                // 5. Handle any connection or API errors
                                Log::info('Cache profile not updated to 1mbps');
                            
                                return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                            }
                    }

        }

               foreach($caches as $cache){
                    if($cache->status==50){
                        $getHotspot = Hotspot::find($cache->user_id);
                                     try {
                        // 2. Initialize the MikroTik API Client
                        $client = new Client([
                            'host' => '10.50.0.3',
                            'user' => 'admin',
                            'pass' => '123456',
                            'port' => 8728,
                        ]);

                        // 3. Build the query payload targeting /ip/hotspot/user/add
                        $query = new Query('/ip/hotspot/user/add');
                        $query->equal('name', $getHotspot->phone);
                        $query->equal('password', $getHotspot->phone);
                    
                        
                        if (!empty($validated['profile'])) {
                            $query->equal('profile', $validated['profile']);
                        }
                        
                        if (!empty($validated['comment'])) {
                            $query->equal('comment', $validated['comment']);
                        }

                        // 4. Send the request and read the response
                        $response = $client->query($query)->read();

                        // Check if MikroTik returned an error array
                        if (isset($response['after']['message'])) {
                            Log::info('user may already exist');

                        }

                            Log::info('Hotspot user successfully created on MikroTik Cache');
                            $deleteCache = Cache::where('id',$cache->id)->delete();      
                    

                    } catch (\Exception $e) {
                        Log::info('Cache Failed to add hotspot user');
                         
                    }
                    }

        }
                       foreach($caches as $cache){
                    if($cache->status==51){
                        $getHotspot = Hotspot::find($cache->user_id);
                    try {
                        // 2. MikroTik Connection Details
                    $config = [
                            'host' => '10.50.0.3',
                            'user' => 'admin',
                            'pass' => '123456',
                            'port' => 8728,
                    ];

                    
                        $client = new Client($config);

                        // 3. Build the Hotspot Active Login Query
                        $query = (new Query('/ip/hotspot/active/login'))
                            ->equal('user', $getHotspot->phone)
                            ->equal('password', $getHotspot->phone)
                            ->equal('mac-address', $getHotspot->mac)
                            ->equal('ip', $getHotspot->ip);

                        // 4. Send Query to RouterOS
                        $response = $client->query($query)->read();

                        $createlog = Hotlogs::create([
                            'amount' => $getHotspot->amount,
                            'hotspot_id' => $getHotspot->phone,
                            'reason' => 3,
                            'status' => 1,
                            'date' => $dateNow,                           

                        ]);
                    Log::info('Hotspot user login in Cache');
                    $deleteCache = Cache::where('id',$cache->id)->delete();      


                    } catch (\Exception $e) {
                        Log::info('Cache Failed to login hotspot user');
                     
                    }
                    }

        }
               foreach($caches as $cache){
                    if($cache->status==52){
                        $getUser = Hotspot::find($cache->user_id);
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
                            Log::info('Hotspot active user deleted Cache');
                            $deleteCache = Cache::where('id',$cache->id)->delete();      

                    }
               
                      catch (\Exception $e) {
                      Log::info('Cache Error deleting active hotspot user');
                    

                    }
                    }

        }
             foreach($caches as $cache){
                    if($cache->status==53){
                        $getUser = Hotspot::find($cache->user_id);
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
                        Log::info('Hotspot user deleted Cache');
                        $deleteCache = Cache::where('id',$cache->id)->delete(); 
                        $deleteHotspotUser = Hotspot::where('id',$getUser->id)->delete();
     

                    }
                }
                        catch (\Exception $e) {
                      Log::info('Cache Error deleting hotspot user');
                    

                    }
                    }

        }
    }
}

