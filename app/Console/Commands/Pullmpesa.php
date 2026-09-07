<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exceptions\Controller;
use App\Models\Invoice;
use App\Models\Mpesa;
use App\Models\Logging;
use App\Models\Pulltransaction;
use App\Models\Payment;
use App\Models\Duplicate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use App\Models\Cache;
use Illuminate\Support\Facades\Http;

class Pullmpesa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pullmpesa';

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
           $consumerKey = 'dflOmBxekAw2elw32rejH8Xm5xkmht7RxFsXPuqSYfjA3wvb';
            $consumerSecret = 'RZjnYDTR2EJtDuJRm3I3Gnhh3uv6tBQaqpAs3OSzxsM8bULVxkF6FuB91OD34GH4';

            $baseUrl = 'https://api.safaricom.co.ke';

            // Get token
            $credentials = base64_encode(
                $consumerKey . ':' . $consumerSecret
            );

            $ch = curl_init(
                $baseUrl .
                '/oauth/v1/generate?grant_type=client_credentials'
            );

            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic ' . $credentials
                ],
                CURLOPT_RETURNTRANSFER => true
            ]);

            $authResponse = curl_exec($ch);

            curl_close($ch);

            $authData = json_decode($authResponse, true);

            if (!isset($authData['access_token'])) {
                return response()->json($authData);
            }

            $token = $authData['access_token'];

            // Query
            $body = [
                'ShortCode' => '4311304',
                'OrganizationName' => "VUMATEL NETWORKS",
                'StartDate' => Carbon::now()->subDay()->format('Y-m-d H:i:s'),
                'EndDate' => Carbon::now()->format('Y-m-d H:i:s'),
                'OffSetValue' => '0'
            ];


            $ch = curl_init(
                $baseUrl . '/pulltransactions/v1/query'
            );

            curl_setopt_array($ch, [
                CURLOPT_POST => true,

                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],

                CURLOPT_POSTFIELDS => json_encode($body),

                CURLOPT_RETURNTRANSFER => true
            ]);

            $response = curl_exec($ch);

            $httpCode = curl_getinfo(
                $ch,
                CURLINFO_HTTP_CODE
            );

            curl_close($ch);
                    $data = json_decode($response, true);
                     

                if (!empty($data['Response'])) {

                    foreach ($data['Response']['0'] as $transaction) {
                        if (Mpesa::where('reference', $transaction['transactionId'])->exists()) {
                        }
                        else{
                            Log::info('Mpesa Does not exist in pull transaction table');
                            $createP1 = PullTransaction::create([
                                'transactionId' => $transaction['transactionId'],
                                'trxDate' => $transaction['trxDate'],
                                'msisdn' => $transaction['msisdn'],
                                'sender' => $transaction['sender'],
                                'transactiontype' => $transaction['transactiontype'],
                                'billreference' => $transaction['billreference'],
                                'amount' => $transaction['amount'],
                                'organizationname' =>$transaction['organizationname'],
                            ]);
                                    Log::info('Mpesa Doesnt Exists');
                                    $dateFormats = $transaction['trxDate'];
                                    $dateFormat = Carbon::parse($dateFormats);
                                    $dateNow = Carbon::now();
                                    $currentMonth = date('m');
                                    $currentYear = date('Y');
                                    $accountNumber = $transaction['billreference'];
                                    $cleanedAccountNumber = str_replace(' ', '', $accountNumber);
                                        $getUserIdentification = User::where('phone',$cleanedAccountNumber)->first();
                                        $getInvoice = null;
                                        if($getUserIdentification){
                                                    if($getUserIdentification->invoice === 0){
                                                        $getInvoice = Invoice::where('user_id', $getUserIdentification->id)->first();
                                                                $createPayment = Mpesa::create([
                                                                    'reference' => $transaction['transactionId'],
                                                                    'originationTime' => $dateFormat,
                                                                    'senderFirstName' => $getUserIdentification->first_name,
                                                                    'senderMiddleName' => $transaction['msisdn'],
                                                                    'senderPhoneNumber' => $getUserIdentification->phone,
                                                                    'amount' => $transaction['amount'],
                                                                    'invoice_id' => $getInvoice->id,
                                                                    'currentMonth' =>$currentMonth,
                                                                    'currentYear' =>$currentYear,

                                                                ]);
                                                                $createPay = Payment::create([
                                                                    'user_id' => $getUserIdentification->id,
                                                                    'invoice_id' => $getInvoice->id,
                                                                    'reference' => $createPayment->reference,
                                                                    'date' => $createPayment->originationTime,
                                                                    'amount' => $createPayment->amount,
                                                                    'status' => 1,
                                                                    'payment_method' => 'Mpesa',
                                                                    'currentMonth' =>$currentMonth,
                                                                ]);
                                                                $createLog = Logging::create([
                                                                    'user_id' => $getUserIdentification->id,
                                                                    'reason' => 0,
                                                                    'date' => $createPayment->originationTime,
                                                                    'amount' => $createPayment->amount,
                                                                ]);
                                                                $currentBalance = $getUserIdentification->balance - $createPayment->amount;
                                                                $updateStatus = Invoice::where('user_id', $getUserIdentification->id)->update(['status' => 1]);
                                                                $updateUserDate = User::where('id', $getUserIdentification->id)->update(['payment_date' => $createPay->date]);
                                                                $updateUserBalance = User::where('id', $getUserIdentification->id)->update(['balance' => $currentBalance]);
                                                                $updateUserAmount = User::where('id', $getUserIdentification->id)->update(['amount' => $createPayment->amount]);
                                                                $currentDate = $createPay->date;
                                                                $nextD =  $currentDate->addMonth();
                                                                $nextDate = Carbon::parse($nextD)->endOfDay();
                                                                $dateFor = Carbon::parse($nextDate)->startOfDay();
                                                                $oneDayBefore = $dateFor->subDays(1);
                                                                $updateInvoiceMDate = Invoice::where('user_id', $getUserIdentification->id)->update(['one_day_before'=>$oneDayBefore]);
                                                                $updateDueDate = User::where('id', $getUserIdentification->id)->update(['due_date' => $nextDate]);
                                                                $updateUserInvoice = User::where('id', $getUserIdentification->id)->update(['invoice'=>null]);
                                                                try{
                                                                                    $config = new Config([
                                                                                     'host' => $getUserIdentification->mik->ip,
                                                                                     'user' => $getUserIdentification->mik->user,
                                                                                     'pass' => $getUserIdentification->mik->password,
                                                                                     'port' => 8728,
                                                                                ]);
                                                                                $client = new Client($config);
                                                                                $mikId = $getUserIdentification->mikrotik_id;

                                                                                    // Create a query for the /ppp/profile/print command
                                                                                
                                                                                    $query = new Query('/ppp/profile/print');
                                                                                
                                                                                    // 2. Build the RouterOS API query to enable the secret
                                                                                    $query = (new Query('/ppp/secret/set'))
                                                                                        ->equal('.id', $mikId)
                                                                                        ->equal('disabled', 'no');

                                                                                    // 3. Send the query and get the response
                                                                                    $response = $client->query($query)->read();

                                                                                    // 4. Handle the response
                                                                                    $update = User::where('mikrotik_id',$mikId)->update(['dis_status'=>'false']);
                                                                                        $createLogOne = Logging::create([
                                                                                            'user_id' => $getUserIdentification->id,
                                                                                            'reason' => 1,
                                                                                            'date' => $dateNow,
                                                                                        ]);
                                                                                    
                                                                                    
                                                                                    
                                                                            
                                                                        }
                                                                            catch (\Exception $e) {
                                                                                    // 5. Handle any connection or API errors
                                                                                    Log::info('payment paid but no connection');
                                                                                    $cache = Cache::create([
                                                                                        'user_id' => $getUserIdentification->id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                                                                                }

                                                


                                                    }
                                                    else{
                                                        if($getUserIdentification){
                                                            $userDueDate = Carbon::parse($getUserIdentification->due_date);
                                                            $getInvoice = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                                                        }
                                                    
                                                        
                                                        if (!is_null($getInvoice)) {
                                                            if(Duplicate::where('duplicate_id',$getUserIdentification->id)->exists()){
                                                                        Log::info('Mpesa duplicate');
                                                                                    $currentBal = 1500 - $transaction['amount'];
                                                                            if($currentBal > 0){
                                                                                $currentBalance = $currentBal;
                                                                            }
                                                                            else{
                                                                                $currentBalance = 0;
                                                                            }
                                                                            $createPayment = Mpesa::create([
                                                                                'reference' => $transaction['transactionId'],
                                                                                'originationTime' => $dateFormat,
                                                                                'senderFirstName' => $getUserIdentification->first_name,
                                                                                'senderMiddleName' => $transaction['msisdn'],
                                                                                'senderPhoneNumber' => $getUserIdentification->phone,
                                                                                'amount' => $transaction['amount'],
                                                                                'invoice_id' => $getInvoice->id,
                                                                                'currentMonth' =>$currentMonth,
                                                                                'currentYear' =>$currentYear,

                                                                            ]);
                                                                            $createPay = Payment::create([
                                                                                'user_id' => $getUserIdentification->id,
                                                                                'invoice_id' => $getInvoice->id,
                                                                                'reference' => $createPayment->reference,
                                                                                'date' => $createPayment->originationTime,
                                                                                'amount' => $createPayment->amount,
                                                                                'status' => 1,
                                                                                'payment_method' => 'Mpesa',
                                                                                'currentMonth' =>$currentMonth,
                                                                            ]);
                                                                            $createLog = Logging::create([
                                                                                'user_id' => $getUserIdentification->id,
                                                                                'reason' => 0,
                                                                                'date' => $createPayment->originationTime,
                                                                                'amount' => $createPayment->amount,
                                                                            ]);
                                                                            $updateInvoiceBalance = Invoice::where('id', $getInvoice->id)->update(['balance' => $currentBalance]);
                                                                            $updateInvoicePaymentId = Invoice::where('id', $getInvoice->id)->update(['payment_id' => $createPay->id]);
                                                                            $updateInvoiceMId = Invoice::where('id', $getInvoice->id)->update(['mpesa_id' => $createPayment->id]);
                                                                            $updateInvoiceMAmount = Invoice::where('id', $getInvoice->id)->update(['mpesa_amount' => $createPayment->amount]);
                                                                            $updateIBalance = Payment::where('id', $createPay->id)->update(['invoice_balance' => $currentBalance]);
                                                                            $updateUserAmount = User::where('id', $getUserIdentification->id)->update(['amount' => $createPayment->amount]);
                                                                            $updateUserProfileAmount = User::where('id', $getUserIdentification->id)->update(['package_amount' => $createPayment->amount]);
                                                                            $updateUserDate = User::where('id', $getUserIdentification->id)->update(['payment_date' => $createPay->date]);
                                                                            $getUser = User::where('mikrotik_id',$getUserIdentification->mikrotik_id)->value('dis_status');
                                                                            if($getUser=='true'){
                                                                            $currentDate = $createPay->date;
                                                                            $nextD =  $currentDate->addMonth();
                                                                            $nextDate = $nextD->addDay();
                                                                            }
                                                                            else{
                                                                            $currentDate = $userDueDate;
                                                                            $nextD =  $currentDate->addMonth();
                                                                            $nextDate = $nextD->addDay();
                                                                            }
                                                                            
                                                                            

                                                                            $updateDueDate = User::where('id', $getUserIdentification->id)->update(['due_date' => $nextDate]);
                                                                            $updateUserBalance = User::where('id', $getUserIdentification->id)->update(['balance' => $currentBalance]);
                                                                            $getInv = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                                                                            $dateForm = Carbon::parse($nextDate);
                                                                            $twoDaysBefore = $dateForm->subDays(3);
                                                                            
                                                                            $updateInvoiceMessageDate = Invoice::where('id',$getInv->id)->update(['two_days_before'=>$twoDaysBefore]);
                                                                            $dateFor = Carbon::parse($nextDate);
                                                                            $oneDayBefore = $dateFor->subDays(1);
                                                                            $updateInvoiceMDate = Invoice::where('id',$getInv->id)->update(['one_day_before'=>$oneDayBefore]);
                                                                            if ($transaction['amount'] >= 1500 || $transaction['amount'] == 1 || $transaction['amount'] == 2) {
                                                                                $updateBal = Invoice::where('id', $getInv->id)->update(['usage_time' => 2147483647]);
                                                                                $updateStatus = Invoice::where('id', $getInv->id)->update(['status' => 1]);
                                                                                $getLatestInvoice = Invoice::where('id', $getInv->id)->first();
                                                                                    $getPreviousInvoices = Invoice::where('id','!=',$getLatestInvoice->id)->where('user_id',$getUserIdentification->id)->get();
                                                                                    foreach($getPreviousInvoices as $getPreviousInvoice){
                                                                                        $updateInvoiceStatas = invoice::where('id',$getPreviousInvoice->id)->update(['statas'=>1]);
                                                                                    }
                                                                                $getDuplicates = Duplicate::where('duplicate_id',$getUserIdentification->id)->get();
                                                                                foreach($getDuplicates as $getDuplicate){
                                                                                            // Get the MikroTik API client using the configured facade
                                                                                try{
                                                                                                $config = new Config([
                                                                                                    'host' => $getUserIdentification->mik->ip,
                                                                                                    'user' => $getUserIdentification->mik->user,
                                                                                                    'pass' => $getUserIdentification->mik->password,
                                                                                                    'port' => 8728,
                                                                                            ]);
                                                                                            $client = new Client($config);
                                                                                            $mikId = $getDuplicate->user->mikrotik_id;

                                                                                                // Create a query for the /ppp/profile/print command
                                                                                                $query = new Query('/ppp/profile/print');
                                                                                            
                                                                                                // 2. Build the RouterOS API query to enable the secret
                                                                                                $query = (new Query('/ppp/secret/set'))
                                                                                                    ->equal('.id', $mikId)
                                                                                                    ->equal('disabled', 'no');

                                                                                                // 3. Send the query and get the response
                                                                                                $response = $client->query($query)->read();

                                                                                                // 4. Handle the response
                                                                                                $update = User::where('mikrotik_id',$mikId)->update(['dis_status'=>'false']);
                                                                                                    $createLogOne = Logging::create([
                                                                                                        'user_id' => $getDuplicate->user_id,
                                                                                                        'reason' => 1,
                                                                                                        'date' => $dateNow,
                                                                                                    ]);
                                                                                                
                                                                                                
                                                                                                
                                                                        
                                                                                    }
                                                                                        catch (\Exception $e) {
                                                                                                // 5. Handle any connection or API errors
                                                                                                Log::info('payment paid but no connection');
                                                                                                $cache = Cache::create([
                                                                                                    'user_id' => $getDuplicate->user_id,
                                                                                                    'status' => 1,
                                                                                                ]);
                                                                                                return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                                                                                            }


                                                                                }
                                                                                
                                                                                    
                                                                                    // Get the MikroTik API client using the configured facade
                                                                                try{
                                                                                                $config = new Config([
                                                                                                    'host' => $getUserIdentification->mik->ip,
                                                                                                    'user' => $getUserIdentification->mik->user,
                                                                                                    'pass' => $getUserIdentification->mik->password,
                                                                                                    'port' => 8728,
                                                                                            ]);
                                                                                            $client = new Client($config);
                                                                                            $mikId = $getUserIdentification->mikrotik_id;

                                                                                                // Create a query for the /ppp/profile/print command
                                                                                            
                                                                                                $query = new Query('/ppp/profile/print');
                                                                                            
                                                                                                // 2. Build the RouterOS API query to enable the secret
                                                                                                $query = (new Query('/ppp/secret/set'))
                                                                                                    ->equal('.id', $mikId)
                                                                                                    ->equal('disabled', 'no');

                                                                                                // 3. Send the query and get the response
                                                                                                $response = $client->query($query)->read();

                                                                                                // 4. Handle the response
                                                                                                $update = User::where('mikrotik_id',$mikId)->update(['dis_status'=>'false']);
                                                                                                    $createLogOne = Logging::create([
                                                                                                        'user_id' => $getUserIdentification->id,
                                                                                                        'reason' => 1,
                                                                                                        'date' => $dateNow,
                                                                                                    ]);
                                                                                                
                                                                                                
                                                        
                                                                                    }
                                                                                        catch (\Exception $e) {
                                                                                                // 5. Handle any connection or API errors
                                                                                                Log::info('payment paid but no connection');
                                                                                                $cache = Cache::create([
                                                                                                    'user_id' => $getUserIdentification->id,
                                                                                                    'status' => 1,
                                                                                                ]);
                                                                                                return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                                                                                            }
                                                                                                
                                                                                        

                                                                           

                                                                            } else {

                                                                                if ($getInv->balance < 0) {
                                                                                    Log::info('Paid less');
                                                                                    dd('paid less');
                                                                                    $updateBal = Invoice::where('id', $getInv->id)->update(['usage_time' => 2147483647]);
                                                                                    $updateStatus = Invoice::where('id', $getInv->id)->update(['status' => 1]);
                                                                                    $getIn = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                                                                                    $getI = Invoice::where('user_id', $getUserIdentification->id)->where('balance', '<', 0)->first();
                                                                                    if ($getIn) {
                                                                                        $currentBal = $getIn->balance + $getI->balance;
                                                                                        $createPay1 = Payment::create([
                                                                                            'user_id' => $getUserIdentification->id,
                                                                                            'invoice_id' => $getIn->id,
                                                                                            'reference' => $transaction['transactionId'],
                                                                                            'date' => $dateFormat,
                                                                                            'amount' => $getI->balance * -1,
                                                                                            'status' => 1,
                                                                                            'payment_method' => 'Mpesa',

                                                                                        ]);
                                                                                        $updateB = Invoice::where('id', $getIn->id)->where('status', 0)->update(['balance' => $currentBal]);
                                                                                        $updateIB = Payment::where('invoice_id', $getIn->id)->where('id', $createPay1->id)->update(['invoice_balance' => $currentBal]);
                                                                                        $updateInvoicePayment = Invoice::where('id', $getIn->id)->where('status', 0)->update(['payment_id' => $createPay1->id]);
                                                                                        $updateC = Invoice::where('id', $getIn->id)->where('status', 0)->update(['mpesa_amount' => -($getI->balance)]);
                                                                                        $updateUserA = User::where('id', $getIn->user_id)->update(['amount' => $createPay1->amount]);
                                                                                        $updateUserD = User::where('id', $getIn->user_id)->update(['payment_date' => $createPay1->date]);
                                                                                        $userBal = Invoice::where('user_id', $getIn->user_id)->where('status', 0)->sum('balance');
                                                                                        $updateUserBal = User::where('id', $getIn->user_id)->update(['balance' => $userBal]);
                                                                                        $updateB = Invoice::where('id', $getI->id)->update(['balance' => 0]);
                                                                                        $getMinUs1 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                        $getIn1 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs1)->first();
                                                                                        if ($getIn1->balance == 0) {
                                                                                            $updateCashA = Invoice::where('id', $getIn->id)->where('status', 0)->update(['mpesa_id' => $createPay->id]);
                                                                                            $updateBal = Invoice::where('id', $getIn1->id)->update(['usage_time' => 2147483647]);
                                                                                            $updateStatus = Invoice::where('id', $getIn1->id)->update(['status' => 1]);
                                                                                        } else {
                                                                                            if ($getIn1->balance < 0) {
                                                                                                $updateBal = Invoice::where('id', $getIn1->id)->update(['usage_time' => 2147483647]);
                                                                                                $updateStatus = Invoice::where('id', $getIn1->id)->update(['status' => 1]);
                                                                                                $getMinUs2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                                $getIn2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs2)->first();
                                                                                                $getI2 = Invoice::where('user_id', $getUserIdentification->id)->where('balance', '<', 0)->first();
                                                                                                if ($getIn2) {
                                                                                                    $currentBal1 = $getIn2->balance + $getI2->balance;
                                                                                                    $createP = Payment::create([
                                                                                                        'user_id' => $getUserIdentification->id,
                                                                                                        'invoice_id' => $getIn2->id,
                                                                                                        'reference' => $transaction['transactionId'],
                                                                                                        'date' => $dateFormat,
                                                                                                        'amount' => $getI2->balance * -1,
                                                                                                        'status' => 1,
                                                                                                        'payment_method' => 'Mpesa',
                                                                                                    ]);
                                                                                                    $updateB2 = Invoice::where('id', $getIn2->id)->where('status', 0)->where('usage_time', $getMinUs2)->update(['balance' => $currentBal1]);
                                                                                                    $updateIB2 = Payment::where('invoice_id', $getIn2->id)->where('id', $createP->id)->update(['invoice_balance' => $currentBal1]);
                                                                                                    $updateC2 = Invoice::where('user_id', $getIn2->id)->where('status', 0)->where('usage_time', $getMinUs2)->update(['mpesa_amount' => -($getI2->balance)]);
                                                                                                    $updatePaymentId = Invoice::where('user_id', $getIn2->id)->where('status', 0)->where('usage_time', $getMinUs2)->update(['payment_id' => $createP->id]);
                                                                                                    $updateUserA2 = User::where('id', $getIn2->user_id)->update(['amount' => $createP->amount]);
                                                                                                    $updateUserD2 = User::where('id', $getIn2->user_id)->update(['payment_date' => $createP->date]);
                                                                                                    $userBal1 = Invoice::where('user_id', $getIn2->user_id)->where('status', 0)->sum('balance');
                                                                                                    $updateUserBal1 = User::where('id', $getIn2->user_id)->update(['balance' => $userBal1]);
                                                                                                    $updateB2 = Invoice::where('id', $getI2->id)->update(['balance' => 0]);
                                                                                                    $getMinUs2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                                    $getIn2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs2)->first();
                                                                                                    if ($getIn2->balance == 0) {
                                                                                                        $updateBal = Invoice::where('id', $getIn2->id)->update(['usage_time' => 2147483647]);
                                                                                                        $updateStatus = Invoice::where('id', $getIn2->id)->update(['status' => 1]);
                                                                                                    } else {
                                                                                                        if ($getIn2->balance < 0) {
                                                                                                            $updateBal = Invoice::where('id', $getIn2->id)->update(['usage_time' => 2147483647]);
                                                                                                            $updateStatus = Invoice::where('id', $getIn2->id)->update(['status' => 1]);
                                                                                                            $getMinUs3 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                                            $getIn3 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs3)->first();
                                                                                                            $getI3 = Invoice::where('user_id', $getUserIdentification->id)->where('balance', '<', 0)->first();
                                                                                                            if ($getIn3) {
                                                                                                                $currentBal2 = $getIn3->balance + $getI3->balance;
                                                                                                                $createP1 = Payment::create([
                                                                                                                    'invoice_id' => $getIn3->id,
                                                                                                                    'user_id' => $getUserIdentification->id,
                                                                                                                    'reference' => $transaction['transactionId'],
                                                                                                                    'date' => $dateFormat,
                                                                                                                    'amount' => $getI3->balance * -1,
                                                                                                                    'status' => 1,
                                                                                                                    'payment_method' => 'Mpesa',
                                                                                                                    'currentMonth' =>$currentMonth,
                                                                                                                ]);
                                                                                                                $updateB2 = Invoice::where('id', $getIn3->id)->where('status', 0)->where('usage_time', $getMinUs3)->update(['balance' => $currentBal2]);
                                                                                                                $updateIB2 = Payment::where('invoice_id', $getIn3->id)->where('id', $createP1->id)->update(['invoice_balance' => $currentBal2]);
                                                                                                                $updateCashA2 = Invoice::where('id', $getIn3->id)->where('status', 0)->where('usage_time', $getMinUs3)->update(['payment_id' => $createP1->id]);
                                                                                                                $updateC2 = Invoice::where('user_id', $getIn3->id)->where('status', 0)->where('usage_time', $getMinUs3)->update(['mpesa_amount' => -($getI3->balance)]);
                                                                                                                $updateUserA2 = User::where('id', $getIn3->user_id)->update(['amount' => $createP1->amount]);
                                                                                                                $updateUserD2 = User::where('id', $getIn3->user_id)->update(['payment_date' => $createP1->date]);
                                                                                                                $userBal1 = Invoice::where('user_id', $getIn3->user_id)->where('status', 0)->sum('balance');
                                                                                                                $updateUserBal1 = User::where('id', $getIn3->user_id)->update(['balance' => $userBal1]);
                                                                                                                $updateB2 = Invoice::where('id', $getI3->id)->update(['balance' => 0]);
                                                                                                            } else {
                                                                                                                $updateUserBal1 = User::where('id', $getUserIdentification->id)->update(['balance' => $getI3->balance]);

                                                                                                            }
                                                                                                        }

                                                                                                    }
                                                                                                } else {
                                                                                                    $updateUserBal1 = User::where('id', $getUserIdentification->id)->update(['balance' => $getI2->balance]);

                                                                                                }

                                                                                            }

                                                                                        }
                                                                                    } else {
                                                                                        $updateUserBal1 = User::where('id', $getUserIdentification->id)->update(['balance' => $getI->balance]);

                                                                                    }

                                                                                }

                                                                            }
                                                            }
                                                            else{
                                                                    Log::info('Mpesa no duplicate');
                                                                        $currentBal = 1500 - $transaction['amount'];
                                                                        if($currentBal > 0){
                                                                            $currentBalance = $currentBal;
                                                                        }
                                                                        else{
                                                                            $currentBalance = 0;
                                                                        }
                                                                        $createPayment = Mpesa::create([
                                                                            'reference' => $transaction['transactionId'],
                                                                            'originationTime' => $dateFormat,
                                                                            'senderFirstName' => $getUserIdentification->first_name,
                                                                            'senderMiddleName' => $transaction['msisdn'],
                                                                            'senderPhoneNumber' => $getUserIdentification->phone,
                                                                            'amount' => $transaction['amount'],
                                                                            'invoice_id' => $getInvoice->id,
                                                                            'currentMonth' =>$currentMonth,
                                                                            'currentYear' =>$currentYear,

                                                                        ]);
                                                                        $createPay = Payment::create([
                                                                            'user_id' => $getUserIdentification->id,
                                                                            'invoice_id' => $getInvoice->id,
                                                                            'reference' => $createPayment->reference,
                                                                            'date' => $createPayment->originationTime,
                                                                            'amount' => $createPayment->amount,
                                                                            'status' => 1,
                                                                            'payment_method' => 'Mpesa',
                                                                            'currentMonth' =>$currentMonth,
                                                                        ]);
                                                                        $createLog = Logging::create([
                                                                            'user_id' => $getUserIdentification->id,
                                                                            'reason' => 0,
                                                                            'date' => $createPayment->originationTime,
                                                                            'amount' => $createPayment->amount,
                                                                        ]);
                                                                        $updateInvoiceBalance = Invoice::where('id', $getInvoice->id)->update(['balance' => $currentBalance]);
                                                                        $updateInvoicePaymentId = Invoice::where('id', $getInvoice->id)->update(['payment_id' => $createPay->id]);
                                                                        $updateInvoiceMId = Invoice::where('id', $getInvoice->id)->update(['mpesa_id' => $createPayment->id]);
                                                                        $updateInvoiceMAmount = Invoice::where('id', $getInvoice->id)->update(['mpesa_amount' => $createPayment->amount]);
                                                                        $updateIBalance = Payment::where('id', $createPay->id)->update(['invoice_balance' => $currentBalance]);
                                                                        $updateUserAmount = User::where('id', $getUserIdentification->id)->update(['amount' => $createPayment->amount]);
                                                                        $updateUserProfileAmount = User::where('id', $getUserIdentification->id)->update(['package_amount' => $createPayment->amount]);
                                                                        $updateUserDate = User::where('id', $getUserIdentification->id)->update(['payment_date' => $createPay->date]);
                                                                        $getUser = User::where('mikrotik_id',$getUserIdentification->mikrotik_id)->value('dis_status');
                                                                        if($getUser=='true'){
                                                                        $currentDate = $createPay->date;
                                                                        $nextD =  $currentDate->addMonth();
                                                                        $nextDate = $nextD->addDay();
                                                                        }
                                                                        else{
                                                                        $currentDate = $userDueDate;
                                                                        $nextD =  $currentDate->addMonth();
                                                                        $nextDate = $nextD->addDay();
                                                                        }
                                                                        
                                                                        

                                                                        $updateDueDate = User::where('id', $getUserIdentification->id)->update(['due_date' => $nextDate]);
                                                                        $updateUserBalance = User::where('id', $getUserIdentification->id)->update(['balance' => $currentBalance]);
                                                                        $getInv = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                                                                        $dateForm = Carbon::parse($nextDate);
                                                                        $twoDaysBefore = $dateForm->subDays(3);
                                                                        
                                                                        $updateInvoiceMessageDate = Invoice::where('id',$getInv->id)->update(['two_days_before'=>$twoDaysBefore]);
                                                                        $dateFor = Carbon::parse($nextDate);
                                                                        $oneDayBefore = $dateFor->subDays(1);
                                                                        $updateInvoiceMDate = Invoice::where('id',$getInv->id)->update(['one_day_before'=>$oneDayBefore]);
                                                                        if ($transaction['amount'] >= 1500 || $transaction['amount'] == 1 || $transaction['amount'] == 2) {
                                                                            $updateBal = Invoice::where('id', $getInv->id)->update(['usage_time' => 2147483647]);
                                                                            $updateStatus = Invoice::where('id', $getInv->id)->update(['status' => 1]);
                                                                            $getLatestInvoice = Invoice::where('id', $getInv->id)->first();
                                                                                $getPreviousInvoices = Invoice::where('id','!=',$getLatestInvoice->id)->where('user_id',$getUserIdentification->id)->get();
                                                                                foreach($getPreviousInvoices as $getPreviousInvoice){
                                                                                    $updateInvoiceStatas = invoice::where('id',$getPreviousInvoice->id)->update(['statas'=>1]);
                                                                                }
                                                                                if($transaction['amount']>=1500 && $transaction['amount'] < 2000){
                                                                                    $bandwidth = '8MBPS';
                                                                                }
                                                                                if($transaction['amount']>=2000 && $transaction['amount'] < 2500){
                                                                                    $bandwidth = '15MBPS';
                                                                                }
                                                                                if($transaction['amount']>=2500 && $transaction['amount'] < 3000){
                                                                                    $bandwidth = '20MBPS';
                                                                                }
                                                                                if($transaction['amount']>=3000 && $transaction['amount'] < 3500){
                                                                                    $bandwidth = '30MBPS';
                                                                                }
                                                                                if($transaction['amount']>=9600 && $transaction['amount'] < 10000){
                                                                                    $bandwidth = '80MBPS';
                                                                                }
                                                                            
                                                                                if($transaction['amount']==1){
                                                                                    $bandwidth = '6MBPS';
                                                                                }
                                                                                if($transaction['amount']==2){
                                                                                    $bandwidth = '8MBPS';
                                                                                }
                                                                                $updateUserProfile = User::where('id', $getUserIdentification->id)->update(['last_name' => $bandwidth]);
                                                                                
                                                                                // Get the MikroTik API client using the configured facade
                                                                            try{
                                                                                            $config = new Config([
                                                                                                'host' => $getUserIdentification->mik->ip,
                                                                                                'user' => $getUserIdentification->mik->user,
                                                                                                'pass' => $getUserIdentification->mik->password,
                                                                                                'port' => 8728,
                                                                                        ]);
                                                                                        $client = new Client($config);
                                                                                        $mikId = $getUserIdentification->mikrotik_id;

                                                                                            // Create a query for the /ppp/profile/print command
                                                                                        
                                                                                            $query = new Query('/ppp/profile/print');
                                                                                        
                                                                                            // 2. Build the RouterOS API query to enable the secret
                                                                                            $query = (new Query('/ppp/secret/set'))
                                                                                                ->equal('.id', $mikId)
                                                                                                ->equal('disabled', 'no');

                                                                                            // 3. Send the query and get the response
                                                                                            $response = $client->query($query)->read();

                                                                                            // 4. Handle the response
                                                                                            $update = User::where('mikrotik_id',$mikId)->update(['dis_status'=>'false']);
                                                                                                $createLogOne = Logging::create([
                                                                                                    'user_id' => $getUserIdentification->id,
                                                                                                    'reason' => 1,
                                                                                                    'date' => $dateNow,
                                                                                                ]);
                                                                                            
                                                                                            
                                                                                
                                                                                }
                                                                                    catch (\Exception $e) {
                                                                                            // 5. Handle any connection or API errors
                                                                                            Log::info('payment paid but no connection');
                                                                                            $cache = Cache::create([
                                                                                                'user_id' => $getUserIdentification->id,
                                                                                                'status' => 1,
                                                                                            ]);
                                                                                            return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                                                                                        }
                                                                                            
                                                                                        try {
                                                                                                    // Get the MikroTik API client using the configured facade
                                                                                                    $config = new Config([
                                                                                                        'host' => $getUserIdentification->mik->ip,
                                                                                                        'user' => $getUserIdentification->mik->user,
                                                                                                        'pass' => $getUserIdentification->mik->password,
                                                                                                        'port' => 8728,
                                                                                                    ]);
                                                                                                $client = new Client($config);
                                                                                                $query = (new Query('/ppp/secret/print'))->where('.id', $getUserIdentification->mikrotik_id);
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
                                                                                    
                                                                                                    
                                                                                            
                                                                                        

                                                                                        } catch (\Exception $e) {
                                                                                            // 5. Handle any connection or API errors
                                                                                            Log::info('Paid but profile not updated');
                                                                                            $cache = Cache::create([
                                                                                                'user_id' => $getUserIdentification->id,
                                                                                                'status' => 3,
                                                                                            ]);
                                                                                            return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                                                                                        }
                                                                                                                            

                                                                        } else {

                                                                            if ($getInv->balance < 0) {
                                                                                Log::info('Paid less');
                                                                                dd('paid less');
                                                                                $updateBal = Invoice::where('id', $getInv->id)->update(['usage_time' => 2147483647]);
                                                                                $updateStatus = Invoice::where('id', $getInv->id)->update(['status' => 1]);
                                                                                $getIn = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                                                                                $getI = Invoice::where('user_id', $getUserIdentification->id)->where('balance', '<', 0)->first();
                                                                                if ($getIn) {
                                                                                    $currentBal = $getIn->balance + $getI->balance;
                                                                                    $createPay1 = Payment::create([
                                                                                        'user_id' => $getUserIdentification->id,
                                                                                        'invoice_id' => $getIn->id,
                                                                                        'reference' => $transaction['transactionId'],
                                                                                        'date' => $dateFormat,
                                                                                        'amount' => $getI->balance * -1,
                                                                                        'status' => 1,
                                                                                        'payment_method' => 'Mpesa',

                                                                                    ]);
                                                                                    $updateB = Invoice::where('id', $getIn->id)->where('status', 0)->update(['balance' => $currentBal]);
                                                                                    $updateIB = Payment::where('invoice_id', $getIn->id)->where('id', $createPay1->id)->update(['invoice_balance' => $currentBal]);
                                                                                    $updateInvoicePayment = Invoice::where('id', $getIn->id)->where('status', 0)->update(['payment_id' => $createPay1->id]);
                                                                                    $updateC = Invoice::where('id', $getIn->id)->where('status', 0)->update(['mpesa_amount' => -($getI->balance)]);
                                                                                    $updateUserA = User::where('id', $getIn->user_id)->update(['amount' => $createPay1->amount]);
                                                                                    $updateUserD = User::where('id', $getIn->user_id)->update(['payment_date' => $createPay1->date]);
                                                                                    $userBal = Invoice::where('user_id', $getIn->user_id)->where('status', 0)->sum('balance');
                                                                                    $updateUserBal = User::where('id', $getIn->user_id)->update(['balance' => $userBal]);
                                                                                    $updateB = Invoice::where('id', $getI->id)->update(['balance' => 0]);
                                                                                    $getMinUs1 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                    $getIn1 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs1)->first();
                                                                                    if ($getIn1->balance == 0) {
                                                                                        $updateCashA = Invoice::where('id', $getIn->id)->where('status', 0)->update(['mpesa_id' => $createPay->id]);
                                                                                        $updateBal = Invoice::where('id', $getIn1->id)->update(['usage_time' => 2147483647]);
                                                                                        $updateStatus = Invoice::where('id', $getIn1->id)->update(['status' => 1]);
                                                                                    } else {
                                                                                        if ($getIn1->balance < 0) {
                                                                                            $updateBal = Invoice::where('id', $getIn1->id)->update(['usage_time' => 2147483647]);
                                                                                            $updateStatus = Invoice::where('id', $getIn1->id)->update(['status' => 1]);
                                                                                            $getMinUs2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                            $getIn2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs2)->first();
                                                                                            $getI2 = Invoice::where('user_id', $getUserIdentification->id)->where('balance', '<', 0)->first();
                                                                                            if ($getIn2) {
                                                                                                $currentBal1 = $getIn2->balance + $getI2->balance;
                                                                                                $createP = Payment::create([
                                                                                                    'user_id' => $getUserIdentification->id,
                                                                                                    'invoice_id' => $getIn2->id,
                                                                                                    'reference' => $transaction['transactionId'],
                                                                                                    'date' => $dateFormat,
                                                                                                    'amount' => $getI2->balance * -1,
                                                                                                    'status' => 1,
                                                                                                    'payment_method' => 'Mpesa',
                                                                                                ]);
                                                                                                $updateB2 = Invoice::where('id', $getIn2->id)->where('status', 0)->where('usage_time', $getMinUs2)->update(['balance' => $currentBal1]);
                                                                                                $updateIB2 = Payment::where('invoice_id', $getIn2->id)->where('id', $createP->id)->update(['invoice_balance' => $currentBal1]);
                                                                                                $updateC2 = Invoice::where('user_id', $getIn2->id)->where('status', 0)->where('usage_time', $getMinUs2)->update(['mpesa_amount' => -($getI2->balance)]);
                                                                                                $updatePaymentId = Invoice::where('user_id', $getIn2->id)->where('status', 0)->where('usage_time', $getMinUs2)->update(['payment_id' => $createP->id]);
                                                                                                $updateUserA2 = User::where('id', $getIn2->user_id)->update(['amount' => $createP->amount]);
                                                                                                $updateUserD2 = User::where('id', $getIn2->user_id)->update(['payment_date' => $createP->date]);
                                                                                                $userBal1 = Invoice::where('user_id', $getIn2->user_id)->where('status', 0)->sum('balance');
                                                                                                $updateUserBal1 = User::where('id', $getIn2->user_id)->update(['balance' => $userBal1]);
                                                                                                $updateB2 = Invoice::where('id', $getI2->id)->update(['balance' => 0]);
                                                                                                $getMinUs2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                                $getIn2 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs2)->first();
                                                                                                if ($getIn2->balance == 0) {
                                                                                                    $updateBal = Invoice::where('id', $getIn2->id)->update(['usage_time' => 2147483647]);
                                                                                                    $updateStatus = Invoice::where('id', $getIn2->id)->update(['status' => 1]);
                                                                                                } else {
                                                                                                    if ($getIn2->balance < 0) {
                                                                                                        $updateBal = Invoice::where('id', $getIn2->id)->update(['usage_time' => 2147483647]);
                                                                                                        $updateStatus = Invoice::where('id', $getIn2->id)->update(['status' => 1]);
                                                                                                        $getMinUs3 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->min('usage_time');
                                                                                                        $getIn3 = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->where('usage_time', $getMinUs3)->first();
                                                                                                        $getI3 = Invoice::where('user_id', $getUserIdentification->id)->where('balance', '<', 0)->first();
                                                                                                        if ($getIn3) {
                                                                                                            $currentBal2 = $getIn3->balance + $getI3->balance;
                                                                                                            $createP1 = Payment::create([
                                                                                                                'invoice_id' => $getIn3->id,
                                                                                                                'user_id' => $getUserIdentification->id,
                                                                                                                'reference' => $transaction['transactionId'],
                                                                                                                'date' => $dateFormat,
                                                                                                                'amount' => $getI3->balance * -1,
                                                                                                                'status' => 1,
                                                                                                                'payment_method' => 'Mpesa',
                                                                                                                'currentMonth' =>$currentMonth,
                                                                                                            ]);
                                                                                                            $updateB2 = Invoice::where('id', $getIn3->id)->where('status', 0)->where('usage_time', $getMinUs3)->update(['balance' => $currentBal2]);
                                                                                                            $updateIB2 = Payment::where('invoice_id', $getIn3->id)->where('id', $createP1->id)->update(['invoice_balance' => $currentBal2]);
                                                                                                            $updateCashA2 = Invoice::where('id', $getIn3->id)->where('status', 0)->where('usage_time', $getMinUs3)->update(['payment_id' => $createP1->id]);
                                                                                                            $updateC2 = Invoice::where('user_id', $getIn3->id)->where('status', 0)->where('usage_time', $getMinUs3)->update(['mpesa_amount' => -($getI3->balance)]);
                                                                                                            $updateUserA2 = User::where('id', $getIn3->user_id)->update(['amount' => $createP1->amount]);
                                                                                                            $updateUserD2 = User::where('id', $getIn3->user_id)->update(['payment_date' => $createP1->date]);
                                                                                                            $userBal1 = Invoice::where('user_id', $getIn3->user_id)->where('status', 0)->sum('balance');
                                                                                                            $updateUserBal1 = User::where('id', $getIn3->user_id)->update(['balance' => $userBal1]);
                                                                                                            $updateB2 = Invoice::where('id', $getI3->id)->update(['balance' => 0]);
                                                                                                        } else {
                                                                                                            $updateUserBal1 = User::where('id', $getUserIdentification->id)->update(['balance' => $getI3->balance]);

                                                                                                        }
                                                                                                    }

                                                                                                }
                                                                                            } else {
                                                                                                $updateUserBal1 = User::where('id', $getUserIdentification->id)->update(['balance' => $getI2->balance]);

                                                                                            }

                                                                                        }

                                                                                    }
                                                                                } else {
                                                                                    $updateUserBal1 = User::where('id', $getUserIdentification->id)->update(['balance' => $getI->balance]);

                                                                                }

                                                                            }

                                                                        }

                                                                    }
                                                        

                                                        }
                                                        else {
                                                                    $createPayment = Mpesa::create([
                                                                    'reference' => $transaction['transactionId'],
                                                                    'originationTime' => $dateFormat,
                                                                    'senderFirstName' => $getUserIdentification->first_name,
                                                                    'senderMiddleName' => $transaction['msisdn'],
                                                                    'senderPhoneNumber' => $getUserIdentification->phone,
                                                                    'amount' => $transaction['amount'],
                                                                    'currentMonth' =>$currentMonth,
                                                                    'currentYear' =>$currentYear,
                                                               
                                                                    ]);
                                                                    

                                                                    if($getUserIdentification){
                                                                    $updateUserAmount = User::where('id', $getUserIdentification->id)->update(['amount' => $createPayment->amount]);
                                                                    $updateUserDate = User::where('id', $getUserIdentification->id)->update(['payment_date' => $createPayment->originationTime]);
                                                                    $getUser = User::find($getUserIdentification->id);
                                                                    $getBalance = $getUser->balance;
                                                                    $currentBalance = $getUser->balance - $transaction['amount'];
                                                                    $updateUserBalance = User::where('id', $getUserIdentification->id)->update(['balance' => $currentBalance]);
                                                                    
                                                                    $getMessageDate = Invoice::where('user_id', $getUserIdentification->id)->where('statas',0)->first();
                                                                    $dateFor = Carbon::parse($getMessageDate->two_days_before);
                                                                    $addMonth = $dateFor->addMonth();
                                                                    $dateForm = Carbon::parse($getMessageDate->one_day_before);
                                                                    $addOneMonth = $dateForm->addMonth();
                                                                    $updateInvoice = Invoice::where('id', $getMessageDate->id)->update([
                                                                                            'two_days_before' => $addMonth,
                                                                                            'one_day_before' => $addOneMonth,
                                                                                        ]);
                                                                    }
                                                                    $updateMessagePaidTwo = Invoice::where('user_id', $getUserIdentification->id)->update([
                                                                        'two_days_before_status' => 1,
                                                                        'due_date_status' => 1,
                                                                        ]);
                                                                    $createLogEleven = Logging::create([
                                                                    'user_id' => $getUserIdentification->id,
                                                                    'reason' => 11,
                                                                    'date' => $createPayment->originationTime,
                                                                    'amount' => $createPayment->amount,
                                                                ]);
                                                            


                                                        }
                                                        
                                                    }


                                        }
                                        else{
                                                $createPayment = Mpesa::create([
                                
                                                'reference' => $transaction['transactionId'],
                                                'originationTime' => $dateFormat,
                                                'senderFirstName' => 'Not Available',
                                                'senderMiddleName' => $transaction['msisdn'],
                                                'senderPhoneNumber' => 'Not Available',
                                                'amount' => $transaction['amount'],
                                                'currentMonth' =>$currentMonth,
                                                'currentYear' =>$currentYear,
                                                ]);
                                                        

                                        

                                        }



                        }
                     
                 
                    }
                }

           
         
    }
}
