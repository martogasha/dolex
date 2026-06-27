<?php

namespace App\Http\Controllers;
use App\Exceptions\Controller;
use Illuminate\Http\JsonResponse;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
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
    
        
        $customer = User::find($id);
        $account = $customer->phone;
        $cleanedNumber = $request->amount;
        $phoneNumber = $request->phone;
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
        $passkey ='05e2b97433a94401c9a5330d35e8bdc88b3c0079233c9039d7b5694ba06d0df9';
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
          'CallBackURL' => 'https://dolextechnologies.co.ke/api/storeWebhooks',
          'AccountReference' => $account,
          'TransactionDesc' => 'Testing stkpush on Sandbox '
        );
        
        $data_string = json_encode($curl_post_data);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
        $curl_response = curl_exec($curl);   
        Log::info($request->all());
    }
}
