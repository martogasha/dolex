<?php

namespace App\Http\Controllers;

use App\Exceptions\Controller;
use App\Models\Cash;
use App\Models\Hotspotmpesa;
use App\Models\Mpesa;
use App\Models\Mik;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use App\Models\User;
use App\Models\Pppoeclientdetail;

use Illuminate\Support\Facades\Http;

class CashController extends Controller
{
    public function index(){
        $mpesas = Hotspotmpesa::where('id','>',0)->orderByDesc('id')->get();
        $currentMonth = date('m');
        $total = Hotspotmpesa::where('currentMonth',$currentMonth)->sum('amount');
        $mikrotiks = Mik::all();
        return view('admin.cash',[
            'mpesas'=>$mpesas,
            'total'=>$total,
            'mikrotiks'=>$mikrotiks
        ]);
    }
    public function test(){
        return view('admin.ttt');
    }
    public function testOne(){
        $posts = Http::post("https://test.synatechafrica.com/clients");
        return $posts;
    }


public function getPppoeClientDetails()
{
    $users = User::where('role',2)->get();
    foreach($users as $user){

            $username = $user->first_name;    
            // 1. Initialize client configuration
            $config = new Config([
                'host' => $user->mik->ip,
                'user' => $user->mik->user,
                'pass' => $user->mik->password,
                'port' => 8728,
            ]);

            $client = new Client($config);

            // 2. Check if the user is currently ACTIVE (Get Uptime & IP)
            $activeQuery = (new Query('/ppp/active/print'))
                ->where('name', $username)
                ->where('service', 'pppoe');
            
            $activeSessions = $client->query($activeQuery)->read();

            $status = 'offline';
            $uptime = null;
            $ipAddress = null;
            $lastLoggedOut = null;

            if (!empty($activeSessions)) {
                // User is online
                $status = 'online';
                $uptime = $activeSessions[0]['uptime'] ?? null;
                $ipAddress = $activeSessions[0]['address'] ?? null;
            }

            // 3. Check PPP Secrets (Get Last Logout Time)
            // Note: 'last-logged-out' is stored in the ppp/secret table
            $secretQuery = (new Query('/ppp/secret/print'))
                ->where('name', $username);

            $secrets = $client->query($secretQuery)->read();

            if (!empty($secrets)) {
                // RouterOS exposes 'last-logged-out' in secret details
                $lastLoggedOut = $secrets[0]['last-logged-out'] ?? 'Never';
            }
            $getPppoeclientdetail = Pppoeclientdetail::where('user_id',$user->id)->first();
            if(!isset($getPppoeclientdetail)){
                $storePPPoeDetail = Pppoeclientdetail::create([
                    'uptime'=>$uptime,
                    'last_logged_out'=>$lastLoggedOut,
                    'status'=>$status,
                    'user_id'=>$user->id,
                    'ip_address'=>$ipAddress,
                  
    
                ]);

            }
            else{
                $edit = Pppoeclientdetail::find($getPppoeclientdetail->id);
                $edit->uptime = $uptime;
                $edit->last_logged_out = $lastLoggedOut;
                $edit->status = $status;
                $edit->user_id = $user->id;
                $edit->ip_address = $ipAddress;
                $edit->save();
            }
    


    }
    
}
}
