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
use Illuminate\Support\Facades\Http;

class sendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendSms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send SMS to users';

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
          $gets =  Invoice::where('two_days_before', '<', Carbon::now())->get();
        foreach($gets as $get){
                $twoDays = $get->two_days_before;
              Log::info($twoDays);
                    $postData = [
                        'apikey' => '04be700f6000ae7ec7c7b7e75d7f0f52',
                        'partnerID' => 15,
                        'mobile' => $get->user->phoneOne,
                        'message' => 'Dear customer, your DOLEX subscription is due for renewal on '.date('d/m/Y',strtotime($get->user->due_date)).'. Pay to avoid disconnection. PAYBILL: 6589582 ACC NO: '.$get->user->phone.'',
                        'shortcode' => 'DOLEX TECH',
                        
                    ];
                    $respons = Http::post('https://sms.imarabiz.com/api/services/sendsms/', $postData);
                        $minusOneMonth = $twoDays->subMonth();
                        $invoiceMinus = Invoice::where('id',$get->id)->update(['two_days_before'=>$minusOneMonth]);
                                     
        }
    }
}
