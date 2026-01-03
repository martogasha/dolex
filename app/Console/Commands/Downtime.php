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
use App\Models\Product;
use App\Models\Qproduct;
use App\Models\Quotation;
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
        foreach($caches as $cache){
            if($cache->status==0 || $cache->status==2 || $cache->status==1){
           // Get the MikroTik API client using the configured facade
                            try{
                                            $config = new Config([
                                            'host' => '197.248.58.123',
                                            'user' => 'admin',
                                            'pass' => 'KND@2020',
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
                                'host' => '197.248.58.123',
                                'user' => 'admin',
                                'pass' => 'KND@2020',
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
                                    'host' => '197.248.58.123',
                                    'user' => 'admin',
                                    'pass' => 'KND@2020',
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
    }
}

