<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Sendsmsbelowhundred;
use Illuminate\Support\Facades\Log; 


class Updatesendsmsbelow100 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Updatesendsmsbelow100';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update database table sendsmsbelowhundreds';

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
                        Log::info('Updating sendsmsbelowhundreds table status as one');
                        $update = Sendsmsbelowhundred::first();

                        if($update->status==0){
                            $update->status = 1;
                            $update->statas = 1;
                            $update->save();
                        }
                        // else{
                        //     Log::info('Updating sendsmsbelowhundreds table status as zero');
                        //     $update = Sendsmsbelowhundred::first();
                        //     if($update){
                        //         $update->status = 0;
                        //         $update->statas = 0;
                        //         $update->save();
                        //     }
                        // }
                 
                    }
               
    }
}
