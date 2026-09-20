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
        try{
// String is the correct phone format
                        Log::info('hotspot');
                        Log::info($request->all());
                        $dateNow = Carbon::now();
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
                            'hotspot_id' => $createPayment->id,
                            'reason' => 1,
                            'status' => 0,
                            'date' => $dateNow,                           

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
         catch (\Exception $e) {
                      Log::info('Mpesa prompt error');

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