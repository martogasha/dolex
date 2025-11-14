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
          $gets =  Invoice::where('two_days_before', '<', Carbon::now())->where('status',1)->where('statas',0)->get();
          
        foreach($gets as $get){
                $twoDays = $get->two_days_before;
              Log::info($get->user->phoneOne);
       
                    $dateFor = Carbon::parse($twoDays);
                        $minusOneMonth = $dateFor->addMonth();
                        $invoiceMinus = Invoice::where('id',$get->id)->update(['two_days_before'=>$minusOneMonth]);
                                     
        }
        $ones =  Invoice::where('one_day_before', '<', Carbon::now())->where('status',1)->where('statas',0)->get();
          
        foreach($ones as $one){
                $oneDay = $one->one_day_before;
              Log::info($one->user->phoneOne);
       
                    $dateFor = Carbon::parse($oneDay);
                        $minusOneMonth = $dateFor->addMonth();
                        $invoiceMinus = Invoice::where('id',$one->id)->update(['one_day_before'=>$minusOneMonth]);
                                     
        }
    }
}
