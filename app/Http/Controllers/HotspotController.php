<?php

namespace App\Http\Controllers;
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

class HotspotController extends Controller
{
        public function hotspot(Request $request): JsonResponse
    {
        // 1. Process your logic here (e.g., fetch database records or compute information)
        $data = [
            'status' => 'success',
            'message' => 'Function initiated successfully!',
            'timestamp' => now()
        ];

        // 2. Return the response as JSON
        return response()->json($data, 200);
    }

    public function storeHotspotUser(Request $request){
        try{
        $currentTime = Carbon::now();
        if($request->amount == 10){
            $endNow = Carbon::now()->addHour();
            Log::info($endNow);
        }
        if($request->amount == 20){
            $endNow = $currentTime->addHours(3);
            Log::info($endNow);

        }
        if($request->amount == 30){
            $endNow = $currentTime->addHours(5);
            Log::info($endNow);

        }
        if($request->amount == 40){
            $endNow = $currentTime->addHours(12);
            Log::info($endNow);

        }
        if($request->amount == 50){
            $endNow = Carbon::now()->addDay();
            Log::info($endNow);

        }
        if($request->amount == 100){
            $endNow = Carbon::now()->addDays(3);
            Log::info($endNow);

        }
        if($request->amount == 300){
            $endNow = Carbon::now()->addWeek();
            Log::info($endNow);

        }
         if($request->amount == 1000){
            $endNow = Carbon::now()->addMonth();
            Log::info($endNow);

        }
         if($request->amount == 1){
            $endNow = Carbon::now()->addHour();
            Log::info($endNow);
        }
        if($request->amount == 2){
            $endNow = $currentTime->addHours(3);
            Log::info($endNow);

        }
        
// String is the correct phone format
                        Log::info('hotspot');
                        Log::info($request->all());
                        $dateNow = Carbon::now();
                        $getUser = Hotspot::where('phone',$request->phone)->first();
                        if(isset($getUser)){
                            Log::info('Hotspot user exist');

                            $updateUser = Hotspot::where('id',$getUser->id)
                              ->update([
                                    'mac' => $request->mac,
                                    'ip' => $request->ip,
                                    'amount' => $request->amount,
                                    'start_date' => $dateNow,
                                    'end_date' => $endNow,
                            ]);
                            $createlog = Hotlogs::create([
                            'amount' => $getUser->amount,
                            'hotspot_id' => $getUser->phone,
                            'reason' => 1,
                            'status' => 0,
                            'date' => $dateNow,
                            'end_date' => $endNow,                           

                        ]);
        $account = $getUser->phone;
        $cleanedNumber = $getUser->amount;
        $phoneNumber = $getUser->phone;
        $modifiedNumber = ltrim($phoneNumber, "0");
        $code = '254';
        $finalNumber = $code . $modifiedNumber;
        

                // Do not hard code these values
        $consumer_key ="HZKs4kTilx4xoc8CGKgR8t3Jkxe6A5Yp";
        $consumer_secret = "R2xDmkzkVtBAeU4C";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
        $curl_response = curl_exec($curl);
  
        $access_token = json_decode($curl_response);

        $token = $access_token->access_token;

        // Do not hard code these values
        $BusinessShortCode = 6589582;
        $passkey ='aee519d8ed8804ed7913d00cbd818c8d8c4f1e879c390cf0521a05cfe25ad9ca';
        $timestamp= Carbon::rawParse('now')->format('YmdHms');

        $password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        $Amount = $cleanedNumber;
        $PartyA = $finalNumber;
        $PartyB = 6589582;


        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json; charset=utf8',
            'Authorization:Bearer ' . $token
        )); //setting custom header
        
        
        $curl_post_data = array(
          //Fill in the request parameters with valid values
          'BusinessShortCode' => $BusinessShortCode,
          'Password' => $password,
          'Timestamp' => $timestamp,
          'TransactionType' => 'CustomerPayBillOnline',
          'Amount' => $Amount,
          'PartyA' => $PartyA,
          'PartyB' => $PartyB,
          'PhoneNumber' => $PartyA,
          'CallBackURL' => 'https://dolextechnologies.co.ke/storeWebhooks',
          'AccountReference' => $account,
          'TransactionDesc' => 'Testing stkpush on Sandbox '
        );
        
        $data_string = json_encode($curl_post_data);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
        $curl_response = curl_exec($curl);   

        Log::info('Mpesa Prompt initiated success');

                        }
                        else{
                            $createPayment = Hotspot::create([
                                'mac' => $request->mac,
                                'ip' => $request->ip,
                                'phone' => $request->phone,
                                'amount' => $request->amount,
                                'status' => 0,
                                'start_date' => $dateNow,  
                                'end_date' => $endNow,                        

                            ]);
                            $createlog = Hotlogs::create([
                            'amount' => $createPayment->amount,
                            'hotspot_id' => $createPayment->phone,
                            'reason' => 1,
                            'status' => 0,
                            'date' => $dateNow,
                            'end_date' => $endNow,                           

                        ]);
        $account = $createPayment->phone;
        $cleanedNumber = $createPayment->amount;
        $phoneNumber = $createPayment->phone;
        $modifiedNumber = ltrim($phoneNumber, "0");
        $code = '254';
        $finalNumber = $code . $modifiedNumber;
        

                // Do not hard code these values
        $consumer_key ="HZKs4kTilx4xoc8CGKgR8t3Jkxe6A5Yp";
        $consumer_secret = "R2xDmkzkVtBAeU4C";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
        $curl_response = curl_exec($curl);
  
        $access_token = json_decode($curl_response);

        $token = $access_token->access_token;

        // Do not hard code these values
        $BusinessShortCode = 6589582;
        $passkey ='aee519d8ed8804ed7913d00cbd818c8d8c4f1e879c390cf0521a05cfe25ad9ca';
        $timestamp= Carbon::rawParse('now')->format('YmdHms');

        $password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        $Amount = $cleanedNumber;
        $PartyA = $finalNumber;
        $PartyB = 6589582;


        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json; charset=utf8',
            'Authorization:Bearer ' . $token
        )); //setting custom header
        
        
        $curl_post_data = array(
          //Fill in the request parameters with valid values
          'BusinessShortCode' => $BusinessShortCode,
          'Password' => $password,
          'Timestamp' => $timestamp,
          'TransactionType' => 'CustomerPayBillOnline',
          'Amount' => $Amount,
          'PartyA' => $PartyA,
          'PartyB' => $PartyB,
          'PhoneNumber' => $PartyA,
          'CallBackURL' => 'https://dolextechnologies.co.ke/storeWebhooks',
          'AccountReference' => $account,
          'TransactionDesc' => 'Testing stkpush on Sandbox '
        );
        
        $data_string = json_encode($curl_post_data);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
        $curl_response = curl_exec($curl);   

        Log::info('Mpesa Prompt initiated success');
                        }
                       

        }
         catch (\Exception $e) {
                      Log::info('Mpesa prompt error');

                    }
    
                        
        
    }
        public function hotspotcache(){
         $caches = Cache::all();
         $dateNow = Carbon::now();  

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
                            Log::info('error');
                            return response()->json([
                                'status' => 'error',
                                'message' => $response['after']['message']
                            ], 400);
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
                            Log::info('Hotspot active user deleted in Cache');
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
                        Log::info('Hotspot user deleted in Cache');
                        $deleteCache = Cache::where('id',$cache->id)->delete();      

                    }
                }
                        catch (\Exception $e) {
                      Log::info('Cache Error deleting hotspot user');
                    

                    }
                    }

        }
    }
    
        public function stopHotspot(){
        $dateNow = Carbon::now();
        $getUsers = Hotspot::where('end_date', '<', Carbon::now())->where('status',1)->get();
        foreach($getUsers as $getUser){
                $createlog = Hotlogs::create([
                    'amount' => $getUser->amount,
                    'hotspot_id' => $getUser->id,
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

                    }
                }
                        catch (\Exception $e) {
                      Log::info('Error deleting hotspot user');

                    }

              

                   
            


        $deleteHotspotUser = Hotspot::where('id',$getUser->id)->delete();


        }
    }

      public function testHotspotUser(){
    
                        // String is the correct phone format
                        Log::info('hotspot');
                        try {
                        // 2. Initialize the MikroTik API Client
                        $client = new Client([
                            'host' => '10.50.0.2',
                            'user' => 'admin',
                            'pass' => '123456',
                            'port' => 8728,
                        ]);

                        // 3. Build the query payload targeting /ip/hotspot/user/add
                        $query = new Query('/ip/hotspot/user/add');
                        $query->equal('name', 'max');
                        $query->equal('password', 'max');
                        
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
                            Log::info('error');
                            return response()->json([
                                'status' => 'error',
                                'message' => $response['after']['message']
                            ], 400);
                        }

                            Log::info('Hotspot user successfully created on MikroTik.');
                    

                    } catch (Exception $e) {
                        Log::info('catch error');
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to connect to MikroTik Router: ' . $e->getMessage()
                        ], 500);
                    }


                        // 2. MikroTik Connection Details
                    $config = [
                            'host' => '10.50.0.2',
                            'user' => 'admin',
                            'pass' => '123456',
                            'port' => 8728,
                    ];

                    try {
                        $client = new Client($config);

                        // 3. Build the Hotspot Active Login Query
                        $query = (new Query('/ip/hotspot/active/login'))
                            ->equal('user', 'max')
                            ->equal('password', 'max')
                            ->equal('mac-address', 'C6:33:9F:80:0D:AB')
                            ->equal('ip', '10.5.50.252');

                        // 4. Send Query to RouterOS
                        $response = $client->query($query)->read();

                        return response()->json([
                            'status' => 'success',
                            'message' => 'User logged in successfully',
                            'data' => $response
                        ]);

                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to connect to MikroTik: ' . $e->getMessage()
                        ], 500);
                    }
        
    }
}