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

class Billing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Billing clients';

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
        $getUsers = User::where('due_date', '<', Carbon::now())->get();
        
        $currentMonth = date('m');
      foreach ($getUsers as $getUser){
            $getExistingInvoice = Invoice::where('user_id',$getUser->id)->where('status',0)->latest('id')->first();
            if ($getExistingInvoice){
      
            }
            else{
                $currentBalance = $getUser->balance;
                $packageAmount = $getUser->package_amount;
                $newBalance = $currentBalance + $packageAmount;
                $date1 = $getUser->payment_date;
                $date2 =$getUser->due_date;
                $dateFormat = Carbon::parse($date2);

                $diff = abs(strtotime($date2) - strtotime($date1));

                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                if ($months==1){
                    $usage_time = $days+30;
                }
                else{
                    $usage_time = $days;
                }
                if ($newBalance<=0){
                    $createInvoice = Invoice::create([
                        'invoice_date'=>$dateFormat,
                        'amount'=>$getUser->package_amount,
                        'user_id'=>$getUser->id,
                        'usage_time'=>$usage_time,
                        'balance'=>0,
                        'status'=>1,
                        'statas'=>0,
                    ]);
                    $storeCash = Payment::create([
                        'user_id'=>$getUser->id,
                        'invoice_id'=>$createInvoice->id,
                        'amount'=>$getUser->package_amount,
                        'invoice_balance'=>$newBalance,
                        'date'=>$dateFormat,
                        'payment_method'=>'balance Carry Over',
                        'status'=>1,
                        'currentMonth'=>$currentMonth
                    ]);
                    $updateCashId = Invoice::where('id',$createInvoice->id)->update(['payment_id'=>$storeCash->id]);
                    $currentDate = $dateFormat;
                    $nextDate =  $currentDate->addMonth();
                    $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$newBalance]);
                    $updateAmount = User::where('id',$getUser->id)->update(['amount'=>$storeCash->amount]);
                    $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>$storeCash->date]);
                    $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$nextDate]);
                }
                else{
                    if ($currentBalance<0){
                        $createInvoice = Invoice::create([
                            'invoice_date'=>$dateFormat,
                            'amount'=>$getUser->package_amount,
                            'user_id'=>$getUser->id,
                            'usage_time'=>$usage_time,
                            'balance'=>$newBalance,
                            'status'=>0,
                            'statas'=>0,
                        ]);
                        $storeCash = Payment::create([
                            'user_id'=>$getUser->id,
                            'invoice_id'=>$createInvoice->id,
                            'amount'=>$currentBalance * -1,
                            'invoice_balance'=>$newBalance,
                            'date'=>$dateFormat,
                            'payment_method'=>'Balance Carry Over',
                            'status'=>1,
                            'currentMonth'=>$currentMonth,

                        ]);
                        $currentDate = $dateFormat;
                        $nextDate =  $currentDate->addMonth();
                        $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$newBalance]);
                        $updateAmount = User::where('id',$getUser->id)->update(['amount'=>0]);
                        $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>null]);
                        $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$nextDate]);
                    }
                    else{
                        $createInvoice = Invoice::create([
                            'invoice_date'=>$dateFormat,
                            'amount'=>$getUser->package_amount,
                            'user_id'=>$getUser->id,
                            'usage_time'=>$usage_time,
                            'balance'=>$newBalance,
                            'status'=>0,
                            'statas'=>0,
                        ]);
                        $currentDate = $dateFormat;
                        $nextDate =  $currentDate->addMonth();
                        $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$newBalance]);
                        $updateAmount = User::where('id',$getUser->id)->update(['amount'=>0]);
                        $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>null]);
                        $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$nextDate]);
                                    
            // Get the MikroTik API client using the configured facade
            $config = new Config([
            'host' => '197.248.58.123',
            'user' => 'admin',
            'pass' => 'KND@2020',
            'port' => 8728,
        ]);
        $client = new Client($config);
        $mikId = $getUser->mikrotik_id;

            // Create a query for the /ppp/profile/print command
            $getUser = User::where('mikrotik_id',$getUser->mikrotik_id)->value('dis_status');
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
          

        
                    }

                }


            }

        }
    }
}
