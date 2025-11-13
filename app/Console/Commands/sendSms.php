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
          $get =  $getUsers = User::where('role', 2)->get();
          
        foreach($gets as $get){
                $getInvoices = Invoice::where('user_id',$get->id)->latest('id')->get();
                foreach($getInvoices as $getInvoice){
                    $twoDays = $getInvoice->two_days_before;
                                Log::info($twoDays);
       
                    $dateFor = Carbon::parse($twoDays);
                        $minusOneMonth = $dateFor->addMonth();
                        $invoiceMinus = Invoice::where('id',$get->id)->update(['two_days_before'=>$minusOneMonth]);
                }
              
                                     
        }
    }
}
