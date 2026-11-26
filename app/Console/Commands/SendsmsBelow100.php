<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class SendsmsBelow100 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendsmsBelow100';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS to admin if balance is below 100';

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
           $postData = [
                        'apikey' => '04be700f6000ae7ec7c7b7e75d7f0f52',
                        'partnerID' => 15,
    
                        
                    ];
                    $respons = Http::post('https://sms.imarabiz.com/api/services/getbalance/', $postData);
                    $data = $respons->json();
                    $balance = $data['credit'];
                    if($balance>100){

                        $postData = [
                        'apikey' => '04be700f6000ae7ec7c7b7e75d7f0f52',
                        'partnerID' => 15,
                        'mobile' => '0707870863',
                        
                        'message' => 'Dear Admin, your SMS balance is below 100. Please top up to avoid service interruption. CURRENT BALANCE: '.$balance.' ',
                        'shortcode' => 'DOLEX TECH',
                        
                    ];
                    $respons = Http::post('https://sms.imarabiz.com/api/services/sendsms/', $postData); 
                    }
    }
}
