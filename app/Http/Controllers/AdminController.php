<?php

namespace App\Http\Controllers;

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
use App\Models\Band;
use App\Models\Logging;
use App\Models\Qproduct;
use App\Models\Quotation;
use App\Models\Mik;
use App\Models\Duplicate;
use App\Models\User;
use App\Models\Singlesms;
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
use App\Models\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class AdminController extends Controller
{
    public function admin(){
        if (Auth::check()) {
            if (Auth::user()->role==0 || Auth::user()->role==1 || Auth::user()->role==5 || Auth::user()->role==6 || Auth::user()->role==7 || Auth::user()->role==8) {
                $notice = Notice::where('id','>',0)->first();
              $currentMonth = date('m');
              $currentYeah = date('Y');
              $mpesa = Mpesa::where('currentMonth',$currentMonth)->where('currentYear',$currentYeah)->sum('amount');
              $cash = Cash::where('currentMonth',$currentMonth)->where('currentYear',$currentYeah)->sum('amount');
              $expense = Expense::where('currentMonth',$currentMonth)->where('currentYear',$currentYeah)->sum('amount');
              $debt = User::where('balance','>',0)->sum('balance');
              $total = $mpesa + $cash;
              $net =$total - $expense;
            $mikrotiks = Mik::all();

                return view('admin.index',[
                    'notice'=>$notice,
                    'mpesa'=>$mpesa,
                    'cash'=>$cash,
                    'expense'=>$expense,
                    'net'=>$net,
                    'debt'=>$debt,
                    'mikrotiks'=>$mikrotiks
                ]);
            }
        }
        else{
            return redirect(url('login'));
        }
    }
    public function showMonth(Request $request){
        if ($request->ajax()){
            $output = "";

            $monthNum  = $request->month;
            $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
            $output = '
                        <h3><b>'.$monthName.' - '.$request->year.'</b> Net Income</h3>

            ';
        }
        return response($output);
    }
    public function ajax(Request $request){
        if ($request->ajax()){
            $output = "";
            $mpesa = Mpesa::where('currentMonth',$request->month)->where('currentYear',$request->yeah)->sum('amount');
            $cash = Cash::where('currentMonth',$request->month)->where('currentYear',$request->yeah)->sum('amount');
            $expense = Expense::where('currentMonth',$request->month)->where('currentYear',$request->yeah)->sum('amount');
            $total = $mpesa + $cash;
            $net =$total - $expense;
            $output = '
<div class="col-lg-3 col-sm-6 col-12">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-fb hover-fb" style="background-color: dodgerblue">
                            <ersdiv class="media media-none--lg">
                                <div class="media-body space-sm">
                                    <h6 class="item-title">Customers</h6>
                                </div>
                            </div>
                            <div class="social-like">'.\App\Models\User::where('role',2)->count().'</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: mediumseagreen">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Users</h6>
                                </div>
                            </div>
                            <div class="social-like">'.\App\Models\User::where('role',1)->count().'</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: indianred">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Net Income</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like">'.$net.'</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: hotpink">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Mpesa Income</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like">'.$mpesa.'</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: mediumpurple">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Cash Income</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like">'.$cash.'</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Expenses</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like">'.$expense.'</div>
                        </div>
                    </div>
                </div>
            ';
        }
        return response($output);
    }
    public function editExpense($id){
        $expense = Expense::find($id);
        return view('admin.editExpense',[
            'expense'=>$expense
        ]);
    }
    public function eExpense(Request $request, $id){
        $edit = Expense::find($id);
        $edit->details = $request->details;
        $edit->amount = $request->amount;
        $edit->date = $request->date;
        $edit->save();
        return redirect(url('expenses'))->with('success','EXPENSE EDITED SUCCESS');
    }
    public function deleteExpense(Request $request){
        $delete = Expense::find($request->userid);
        $delete->delete();
        return redirect(url('expenses'))->with('success','EXPENSE DELETED SUCCESS');

    }
    public function deleteProduct(Request $request){
        $delete = Product::find($request->userid);
        $delete->delete();
        return redirect(url('products'))->with('success','PRODUCT DELETED SUCCESS');

    }
    public function mpesaCustomer($id){
        $customer = Mpesa::find($id);
        return view('admin.mpesaCustomer',[
            'customer'=>$customer
        ]);
    }
    public function profile(){
        if (Auth::check()) {
            $mikrotiks = Mik::all();
            if (Auth::user()->role==0 || Auth::user()->role==1 || Auth::user()->role==5 || Auth::user()->role==6 || Auth::user()->role==7 || Auth::user()->role==8) {
                return view('admin.profile',[
                    'mikrotiks'=>$mikrotiks
                ]);
            }
        }
        else{
            return redirect(url('login'));

        }
    }
    public function editProfile(Request $request , $id){
        $edit = User::find($id);
        $edit->first_name = $request->first_name;
        $edit->last_name = $request->last_name;
        $edit->phoneOne = $request->phone;
        $edit->email = $request->email;
        $edit->password = Hash::make($request->password);
        $edit->save();
        return redirect()->back()->with('success','profile updated success');
    }
    public function customers(){
        if (Auth::check()){
            $customers = User::where('dis_status','false')->where('role','!=',4)->orWhere('dis_status','true')->orderByDesc('id')->get();
            $mikrotiks = Mik::all();
            return view('admin.customers',[
                'customers'=>$customers,
                'mikrotiks'=>$mikrotiks
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function logs(){
        if (Auth::check()){
            $logs = Logging::latest()->get();
            $mikrotiks = Mik::all();
            return view('admin.logs',[
                'logs'=>$logs,
                'mikrotiks'=>$mikrotiks
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
     public function Selectcustomers(){
        if (Auth::check()){
            $customers = User::where('role', 3)->orderByDesc('id')->get();
            $mikrotiks = Mik::all();
            return view('admin.customerSelect',[
                'customers'=>$customers,
                'mikrotiks'=>$mikrotiks
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
       public function customerAll(){
        if (Auth::check()){
            $customers = User::where('dis_status','true')->orderByDesc('id')->get();
            $mikrotiks = Mik::all();
            return view('admin.customerAll',[
                'customers'=>$customers,
                'mikrotiks'=>$mikrotiks
            ]);
        }
        else{
            return redirect(url('login'));
        }
    }

    public function noneActivecustomers(){
        if (Auth::check()){
            $customers = User::where('role', 4)->orderByDesc('id')->get();
            $mikrotiks = Mik::all();
            return view('admin.customerNoneActive',[
                'customers'=>$customers,
                'mikrotiks'=>$mikrotiks
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
      public function pppoe(){
        if (Auth::check()){
            // Get MikroTik connection details from .env
        $config = new Config([
            'host' => '197.248.79.153',
            'user' => 'admin',
            'pass' => 'KND@2020',
            'port' => 8728,
        ]);

        try {
            // Establish a connection to the MikroTik router
            $client = new Client($config);

            // Fetch all PPPoE secrets (configured users)
            $secretsQuery = new Query('/ppp/secret/getall');
            $pppSecrets = $client->query($secretsQuery)->read();
           

            // Fetch all active PPPoE connections
            $activeQuery = new Query('/ppp/active/getall');
            $pppActive = $client->query($activeQuery)->read();
            dd($pppActive);

        
          
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
          return view('admin.livePppoe',[
            'secrets'=>$pppSecrets
        ]);
    }
        
        else{
            return redirect(url('login'));
        }

    }
         public function storePppoe(Request $request){
        if (Auth::check()){
            $getMikrotik = Mik::where('id',$request->mikrotik_id)->first();
            // Get MikroTik connection details from .env
                try {
                            $config = new Config([
                                'host' => $getMikrotik->ip,
                                'user' => $getMikrotik->user,
                                'pass' => $getMikrotik->password,
                                'port' => 8728,
                            ]);

                    
                        // Establish a connection to the MikroTik router
                        $client = new Client($config);
                        // Fetch all PPPoE secrets (configured users)
                        $secretsQuery = new Query('/ppp/secret/getall');
                        $mikrotikUsers = $client->query($secretsQuery)->read();
                    
                        
                        foreach ($mikrotikUsers as $mikrotikUser){
                        
                            if(isset($mikrotikUser['comment'])){
                                $comment = $mikrotikUser['comment'];
                            }
                            else{
                                $comment = null;
                            }
                            if(isset($mikrotikUser['profile'])){
                                $profile = $mikrotikUser['profile'];
                            }
                            else{
                                $profile = null;
                            }
                            if(isset($mikrotikUser['password'])){
                                $password = $mikrotikUser['password'];
                            }
                            else{
                                $password = 123;
                            }
                            if(isset($mikrotikUser['disabled'])){
                                $disabled = $mikrotikUser['disabled'];
                            }
                            else{
                                $disabled = null;
                            }
                            
                            $getUserId = User::where('mikrotik_id',$mikrotikUser['.id'])->value('id');
                            if($getUserId==null){
                                $now = Carbon::now();
                                

                                    $storePPPoe = User::create([
                                    'first_name'=>$mikrotikUser['name'],
                                    'location'=>$comment,
                                    'last_name'=>$profile,
                                    'password'=>$password,
                                    'mikrotik_id'=>$mikrotikUser['.id'],
                                    'dis_status'=>$disabled,
                                    'role'=>3,
                                    'mik_id'=>$request->mikrotik_id,
                                    'due_date'=>$now,
                        
                                    ]);
                                
                                
                                        $now = Carbon::now();
                                        $date1 = $now;
                                        $date2 =$now;

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
                                        $createInvoice = Invoice::create([
                                            'invoice_date'=>$now,
                                            'amount'=>0,
                                            'user_id'=>$storePPPoe->id,
                                            'usage_time'=>$usage_time,
                                            'balance'=>0,
                                            'status'=>0,
                                            'statas'=>0,
                                        ]);
                                    
                                                
                                    }

                                            
                        }
                                $client = new Client($config);

                        // Create a query for the /ppp/profile/print command
                        $query = new Query('/ppp/profile/print');

                        // Send the query and get the response from the router
                        $responses = $client->query($query)->read();
                        
                        foreach ($responses as $response){
                            $getProfile = Profile::where('idProf',$response['.id'])->value('idProf');
                            if($getProfile==null && $response['default'] == 'false'){
                        
                                // Using the standard PHP preg_replace() function
                        $string = $response['name'];
                        $only_digits = preg_replace("/[^0-9]/", '', $string);

                        // Cast the cleaned string to an integer
                        $number = (int) $only_digits;

                        // Alternatively, use the intval() function
                        $number = intval($only_digits);
                                

                        // Result: 123456
                        $storePPPoeProfile = Profile::create([
                            'profile'=>$response['name'],
                            'status'=>$response['default'],
                            'idProf'=>$response['.id'],
                            'value'=>$number,       
                                
                        ]);
                        
                        }
                    
                            }

                        return redirect()->back()->with('success','Updated Success');
            }
                 catch (\Exception $e) {
                                         return redirect()->back()->with('error','TRY AGAIN');
                                        }
        
    }
        
        else{
            return redirect(url('login'));
        }

    }
     public function getPppoeProfiles()
    {
        try {
            // Get the MikroTik API client using the configured facade
            $config = new Config([
            'host' => '192.168.88.1',
            'user' => 'admin',
            'pass' => 'password',
            'port' => 8728,
        ]);


            // Return the profiles as a JSON response
            return response()->json($response);
              

        } catch (\Exception $e) {
            // Handle any connection or API errors
            return response()->json(['error' => 'Failed to retrieve PPPoE profiles: ' . $e->getMessage()], 500);
        }
    }
    public function disablePppoeSecret($id)
    {
        $dateNow = Carbon::now();
               try {
            // Get the MikroTik API client using the configured facade
            $config = new Config([
                'host' => '102.209.56.86',
                'user' => 'admin',
                'pass' => '@anxvtT3n',
                'port' => 8728,
        ]);
        $client = new Client($config);

            // Create a query for the /ppp/profile/print command
            $getUser = User::where('mikrotik_id',$id)->value('dis_status');
            if($getUser=='true'){
            $query = new Query('/ppp/profile/print');
        
            // 2. Build the RouterOS API query to disable the secret
            $query = (new Query('/ppp/secret/set'))
                ->equal('.id', $id)
                ->equal('disabled', 'no');

            // 3. Send the query and get the response
            $response = $client->query($query)->read();

            // 4. Handle the response
            $update = User::where('mikrotik_id',$id)->update(['dis_status'=>'false']);
            $getUserId = User::where('mikrotik_id',$id)->first();
                  $createLog = Logging::create([
                            'user_id' => $getUserId->id,
                            'reason' => 22,
                            'date' => $dateNow,
                        ]);
            return redirect()->back()->with('success','User Enabled Success');
            
            }
            else{
                 $query = new Query('/ppp/profile/print');
        
            // 2. Build the RouterOS API query to disable the secret
            $query = (new Query('/ppp/secret/set'))
                ->equal('.id', $id)
                ->equal('disabled', 'yes');

            // 3. Send the query and get the response
            $response = $client->query($query)->read();

            // 4. Handle the response
            $update = User::where('mikrotik_id',$id)->update(['dis_status'=>'true']);
            $getUserId = User::where('mikrotik_id',$id)->first();
                  $createLog = Logging::create([
                            'user_id' => $getUserId->id,
                            'reason' => 23,
                            'date' => $dateNow,
                        ]);
            return redirect()->back()->with('success','User Disabled Success');
            }
          

        } catch (\Exception $e) {
            // 5. Handle any connection or API errors
            return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
        }
    }
    public function prompt($id){
        
        $customer = User::find($id);
        $account = $customer->phone;
        $cleanedNumber = $customer->package_amount;
        $phoneNumber = $customer->phoneOne;
        $modifiedNumber = ltrim($phoneNumber, "0");
        $code = '254';
        $finalNumber = $code . $modifiedNumber;
        

                // Do not hard code these values
                       $consumer_key ="dflOmBxekAw2elw32rejH8Xm5xkmht7RxFsXPuqSYfjA3wvb";
        $consumer_secret = "RZjnYDTR2EJtDuJRm3I3Gnhh3uv6tBQaqpAs3OSzxsM8bULVxkF6FuB91OD34GH4";
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
        $BusinessShortCode = 4311304;
        $passkey ='05e2b97433a94401c9a5330d35e8bdc88b3c0079233c9039d7b5694ba06d0df9';
        $timestamp= Carbon::rawParse('now')->format('YmdHms');

        $password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        $Amount = $cleanedNumber;
        $PartyA = $finalNumber;
        $PartyB = 4311304;


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
          'CallBackURL' => 'https://vumatelnetworks.co.ke/storeWebhooks',
          'AccountReference' => $account,
          'TransactionDesc' => 'Testing stkpush on Sandbox '
        );
        
        $data_string = json_encode($curl_post_data);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
        $curl_response = curl_exec($curl);   
          
                return redirect()->back()->with('success','CUSTOMER PROMPTED SUCCESS');

    }
    public function product(){
        $products = Product::orderByDesc('id')->get();
        return view('admin.products',[
            'products'=>$products
        ]);
    }
    public function editProd(Request $request, $id){
        $edit = Product::find($id);
        $edit->name = $request->name;
        $edit->amount = $request->amount;
        $edit->save();
        return redirect(url('products'))->with('success','PRODUCT EDITED SUCCESS');
    }
    public function editProduct($id){
        $product = Product::find($id);
        return view('admin.editProduct',[
            'product'=>$product
        ]);
    }
    public function addEmployee(){
        $mikrotiks = Mik::all();
        return view('admin.addEmployee',[
            'mikrotiks'=>$mikrotiks
        ]);
    }
    public function shop(){
        $oldCart = Session::get('cat');
        $cart = new Cat($oldCart);
        $shops = Product::all();
        return view('admin.shop',[
            'shops'=>$shops,
            'products'=>$cart->item,
            'totalPrice'=>$cart->totalPrice
        ]);
    }
    public function productDetail($id){
        $productDetail = Product::find($id);
        return view('admin.productDetail',[
            'productDetail'=>$productDetail
        ]);
    }
    public function storeQuotation(Request $request){
        if ($request->ajax()){
            $output = "";
        }
        $name = Product::where('id',$request->product_name)->first();
        $store = Qproduct::create([
           'name'=>$name->name,
           'quantity'=>$request->quantity,
           'amount'=>$request->amount,
           'total'=>$request->amount*$request->quantity,
           'quotation_id'=>$request->id,
        ]);
        return redirect()->back()->with('success','saved Success');
    }
    public function storeInvoice(Request $request){
        if ($request->ajax()){
            $output = "";
        }
        $name = Product::where('id',$request->product_name)->first();
        $store = Qproduct::create([
           'name'=>$name->name,
           'quantity'=>$request->quantity,
           'amount'=>$request->amount,
           'total'=>$request->amount*$request->quantity,
           'invoice_id'=>$request->id,
           'quotation_id'=>0,
        ]);
        return redirect()->back()->with('success','saved Success');
    }
    public function storeEmployee(Request $request){
        $store = new User();
        $store->first_name = $request->first_name;
        $store->last_name = $request->last_name;
        $store->phoneOne = $request->phone;
        $store->email = $request->email;
        $store->role = $request->role;
        $store->products = $request->dashboard;
        $store->customers = $request->customers;
        $store->payments = $request->payments;
        $store->expenses = $request->sms;
        $store->estimate = $request->band;
        $store->amount_supposed_to_be_paid = $request->logs;
        $store->users = $request->users;
        $store->password = Hash::make('password');

        
        $store->save();
        return redirect(url('users'))->with('success','USER ADDED SUCCESSFULLY');
    }
   public function employees(){
        $customers = User::where('role',1)->orWhere('role',0)->orWhere('role',5)->orWhere('role',6)->orWhere('role',7)->orWhere('role',8)->orderByDesc('id')->get();
        $mikrotiks = Mik::all();
        return view('admin.employee',[
            'customers'=>$customers,
            'mikrotiks'=>$mikrotiks
        ]);
    }
    public function addProduct(){
        return view('admin.addProduct');

    }
    public function storeProduct(Request $request){
        $store = new Product();
        $store->name = $request->input('name');
        $store->amount = $request->input('amount');
        $store->save();
        return redirect()->back()->with('success','PRODUCT SAVED');
    }
    public function addCustomer(){
        $profiles = Profile::all();
        $mikrotiks = Mik::all();
        return view('admin.addCustomer',[
            'profiles'=>$profiles,
            'mikrotiks'=>$mikrotiks
        ]);

    }
    public function addCash(){
        $users = User::where('role',2)->get();
        return view('admin.addCash',[
            'users'=>$users
        ]);

    }
    public function addMpesa(){
        $users = User::where('role',2)->get();
        return view('admin.addMpesa',[
            'users'=>$users
        ]);

    }
    public function bill(){
        $users = User::where('role',2)->get();
        return view('admin.bill',[
            'users'=>$users
        ]);

    }
    public function deletePro(Request $request){
        if ($request->ajax()){
            $delete = Qproduct::find($request->id);
            $delete->delete();
        }
    }
    public function editQProduct(Request $request){
        $edit = Qproduct::find($request->id);
        $quantity = $request->quantity;
        $amount = $request->amount;
        $edit->name = $request->name;
        $edit->quantity = $request->quantity;
        $edit->amount = $request->amount;
        $edit->total = $quantity*$amount;
        $edit->save();
        return redirect()->back()->with('success','Updated');
    }
    public function getQProducts(Request $request){
        if ($request->ajax()){
            $output = "";
            $get = Qproduct::find($request->id);
            $output = '
                    <input type="hidden" value="'.$get->id.'" name="id">
                      <div class="col-lg-12 col-12 form-group">
                    <label>Name</label>
                    <input type="text" value="'.$get->name.'" class="form-control" name="name">
                </div>
                <div class="col-lg-12 col-12 form-group">
                    <label>Quantity</label>
                    <input type="text" value="'.$get->quantity.'" class="form-control" name="quantity">
                </div>
                <div class="col-lg-12 col-12 form-group">
                    <label>Amount</label>
                    <input type="text" value="'.$get->amount.'" class="form-control" name="amount">
                </div>
            ';
        }
        return response($output);
    }
    public function notice(Request $request){
        $notice = Notice::all();
        if ($notice){
            $noticeupdate = ['message'=>$request->message,'date'=>Carbon::now()->format('d-m-Y')];
            $update = Notice::where('id','>',0)->update($noticeupdate);
        }
        $store = Notice::create([
            'message'=>$request->message,
            'date'=>Carbon::now()->format('d-m-Y'),
        ]);
        return redirect()->back()->with('success', 'NOTICE POSTED SUCCESS');
    }
    public function deleteNotice($id){
        $delete = Notice::find($id);
        $delete->delete();
        return redirect()->back()->with('success', 'NOTICE DELETED SUCCESS');

    }
    public function billing(Request $request){
        $getUsers = User::where('role',2)->get();
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
                        'invoice_date'=>$getUser->due_date,
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
                        'date'=>$getUser->due_date,
                        'payment_method'=>'balance Carry Over',
                        'status'=>1,
                        'currentMonth'=>$currentMonth
                    ]);
                    $updateCashId = Invoice::where('id',$createInvoice->id)->update(['payment_id'=>$storeCash->id]);
                    $nextDate =  date('Y-m-d', strtotime($getUser->due_date. ' + 1 month'));
                    $dateFormat = Carbon::createFromFormat('d/m/Y', $nextDate)->toDateString();
                    $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$newBalance]);
                    $updateAmount = User::where('id',$getUser->id)->update(['amount'=>$storeCash->amount]);
                    $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>$storeCash->date]);
                    $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$dateFormat]);
                }
                else{
                    if ($currentBalance<0){
                        $createInvoice = Invoice::create([
                            'invoice_date'=>$getUser->due_date,
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
                            'date'=>$getUser->due_date,
                            'payment_method'=>'Balance Carry Over',
                            'status'=>1,
                            'currentMonth'=>$currentMonth,

                        ]);
                        $nextDate =  date('m/d/Y', strtotime($getUser->due_date. ' + 1 month'));
                        $dateFormat = Carbon::createFromFormat('d/m/Y', $nextDate)->toDateString();
                        $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$newBalance]);
                        $updateAmount = User::where('id',$getUser->id)->update(['amount'=>0]);
                        $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>null]);
                        $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$dateFormat]);
                    }
                    else{
                        $createInvoice = Invoice::create([
                            'invoice_date'=>$getUser->due_date,
                            'amount'=>$getUser->package_amount,
                            'user_id'=>$getUser->id,
                            'usage_time'=>$usage_time,
                            'balance'=>$newBalance,
                            'status'=>0,
                            'statas'=>0,
                        ]);
                        $nextDate =  date('d/m/Y', strtotime($getUser->due_date. ' + 1 month'));
                        $dateFormat = Carbon::createFromFormat('d/m/Y', $nextDate)->toDateString();
                        $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$newBalance]);
                        $updateAmount = User::where('id',$getUser->id)->update(['amount'=>0]);
                        $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>null]);
                        $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$dateFormat]);
                    }

                }


            }

        }

        return redirect()->back()->with('success','ALL CUSTOMERS BILLED SUCCESSFULLY');
    }
    public function billingEach(Request $request){
        $currentMonth = date('m');
        $getExistingInvoice = Invoice::where('user_id',$request->id)->where('status',0)->first();
        $getUser = User::find($request->id);
        $paymentDate = date("d-m-Y", strtotime($request->payment_date));
        $dueDate = date("d-m-Y", strtotime($request->due_date));
        $time = strtotime($getUser->due_date);
        $nextDate = date("d-m-Y", strtotime("+1 month", $time));
        if ($getExistingInvoice){
            if ($getUser->payment_date==0){
                $nextDatePrototype =  date('d-m-Y', strtotime($getUser->due_date. ' - 1 month'));
                $date1 =$nextDatePrototype;
                $date2 =$getUser->due_date;
            }
            else{
                $date1 = $getUser->payment_date;
                $date2 =$getUser->due_date;
            }

            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            if ($months>=1){
                $usage_time = $days+30;
            }
            else{
                $usage_time = $days;
            }
            $total = $request->amount + $request->package_amount;
            $createInvoice = Invoice::create([
                'invoice_date'=>$dueDate,
                'amount'=>$request->package_amount,
                'user_id'=>$request->id,
                'usage_time'=>$getExistingInvoice->usage_time + $usage_time,
                'balance'=>$total,
                'status'=>0,
                'statas'=>0,
            ]);
            $terminateInvoice = Invoice::where('id',$getExistingInvoice->id)->update(['status'=>2]);
            $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$total]);
            $updateAmount = User::where('id',$getUser->id)->update(['amount'=>0]);
            $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>0]);
            $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$nextDate]);
        }
        else{

            $date1 = $getUser->payment_date;
            $date2 =$getUser->due_date;

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
            $total = $request->amount + $request->package_amount;
            if ($total<=0){
                $createInvoice = Invoice::create([
                    'invoice_date' => $dueDate,
                    'amount' => $request->package_amount,
                    'user_id' => $request->id,
                    'usage_time' => $usage_time,
                    'balance' => $total,
                    'status' => 1,
                    'statas' => 0,
                ]);
                $createP = Payment::create([
                    'invoice_id'=>$createInvoice->id,
                    'user_id'=>$request->id,
                    'date'=>$dueDate,
                    'amount'=>$request->package_amount,
                    'status'=>1,
                    'payment_method'=>'Balance Carry Over',
                    'currentMonth'=>$currentMonth,
                ]);
                $updateInvoice = Invoice::where('id',$createInvoice->id)->update(['payment_id'=>$createP->id]);
                $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$total]);
                $updateAmount = User::where('id',$getUser->id)->update(['amount'=>$createP->amount]);
                $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>$request->due_date]);
                $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$nextDate]);
            }
            else {
                $createInvoice1 = Invoice::create([
                    'invoice_date' => $dueDate,
                    'amount' => $request->package_amount,
                    'user_id' => $request->id,
                    'usage_time' => $usage_time,
                    'balance' => $total,
                    'status' => 0,
                    'statas' => 0,
                ]);
                $createP1 = Payment::create([
                    'invoice_id'=>$createInvoice1->id,
                    'user_id'=>$request->id,
                    'date'=>$dueDate,
                    'amount'=>$request->amount*-1,
                    'status'=>1,
                    'payment_method'=>'Balance Carry Over',
                    'currentMonth'=>$currentMonth,
                ]);
                $updateInvoice = Invoice::where('id',$createInvoice1->id)->update(['payment_id'=>$createP1->id]);
                $updateInvoice = Invoice::where('id',$createInvoice1->id)->update(['balance'=>$total]);
                $updateInvoice = Invoice::where('id',$createInvoice1->id)->update(['balance'=>$total]);
                $updateBalance = User::where('id',$request->id)->update(['balance'=>$total]);
                $updateAmount = User::where('id',$request->id)->update(['amount'=>0]);
                $updatePaymentDate = User::where('id',$request->id)->update(['payment_date'=>0]);
                $updateDueDate = User::where('id',$request->id)->update(['due_date'=>$nextDate]);
            }
        }

        return redirect()->back()->with('success','CUSTOMER BILLED SUCCESS');
    }
    public function autoBill(){
        $cDate = date('d-m-Y');
        $requests=User::where('due_date',$cDate)->get();
        foreach ($requests as $request){
            $currentMonth = date('m');
            $getExistingInvoice = Invoice::where('user_id',$request->id)->where('status',0)->first();
            $getUser = User::find($request->id);
            $paymentDate = date("d-m-Y", strtotime($request->payment_date));
            $dueDate = date("d-m-Y", strtotime($request->due_date));
            $time = strtotime($getUser->due_date);
            $nextDate = date("d-m-Y", strtotime("+1 month", $time));
            if ($getExistingInvoice){
                if ($getUser->payment_date==0){
                    $nextDatePrototype =  date('d-m-Y', strtotime($getUser->due_date. ' - 1 month'));
                    $date1 =$nextDatePrototype;
                    $date2 =$getUser->due_date;
                }
                else{
                    $date1 = $getUser->payment_date;
                    $date2 =$getUser->due_date;
                }

                $diff = abs(strtotime($date2) - strtotime($date1));

                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                if ($months>=1){
                    $usage_time = $days+30;
                }
                else{
                    $usage_time = $days;
                }
                $total = $request->amount + $request->package_amount;
                $createInvoice = Invoice::create([
                    'invoice_date'=>$dueDate,
                    'amount'=>$request->package_amount,
                    'user_id'=>$request->id,
                    'usage_time'=>$getExistingInvoice->usage_time + $usage_time,
                    'balance'=>$total,
                    'status'=>0,
                    'statas'=>0,
                ]);
                $terminateInvoice = Invoice::where('id',$getExistingInvoice->id)->update(['status'=>2]);
                $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$total]);
                $updateAmount = User::where('id',$getUser->id)->update(['amount'=>0]);
                $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>0]);
                $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$nextDate]);
            }
            else{

                $date1 = $getUser->payment_date;
                $date2 =$getUser->due_date;

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
                $total = $request->amount + $request->package_amount;
                if ($total<=0){
                    $createInvoice = Invoice::create([
                        'invoice_date' => $dueDate,
                        'amount' => $request->package_amount,
                        'user_id' => $request->id,
                        'usage_time' => $usage_time,
                        'balance' => $total,
                        'status' => 1,
                        'statas' => 0,
                    ]);
                    $createP = Payment::create([
                        'invoice_id'=>$createInvoice->id,
                        'user_id'=>$request->id,
                        'date'=>$dueDate,
                        'amount'=>$request->package_amount,
                        'status'=>1,
                        'payment_method'=>'Balance Carry Over',
                        'currentMonth'=>$currentMonth,
                    ]);
                    $updateInvoice = Invoice::where('id',$createInvoice->id)->update(['payment_id'=>$createP->id]);
                    $updateBalance = User::where('id',$getUser->id)->update(['balance'=>$total]);
                    $updateAmount = User::where('id',$getUser->id)->update(['amount'=>$createP->amount]);
                    $updatePaymentDate = User::where('id',$getUser->id)->update(['payment_date'=>$request->due_date]);
                    $updateDueDate = User::where('id',$getUser->id)->update(['due_date'=>$nextDate]);
                }
                else {
                    $createInvoice1 = Invoice::create([
                        'invoice_date' => $dueDate,
                        'amount' => $request->package_amount,
                        'user_id' => $request->id,
                        'usage_time' => $usage_time,
                        'balance' => $total,
                        'status' => 0,
                        'statas' => 0,
                    ]);
                    $createP1 = Payment::create([
                        'invoice_id'=>$createInvoice1->id,
                        'user_id'=>$request->id,
                        'date'=>$dueDate,
                        'amount'=>$request->amount*-1,
                        'status'=>1,
                        'payment_method'=>'Balance Carry Over',
                        'currentMonth'=>$currentMonth,
                    ]);
                    $updateInvoice = Invoice::where('id',$createInvoice1->id)->update(['payment_id'=>$createP1->id]);
                    $updateInvoice = Invoice::where('id',$createInvoice1->id)->update(['balance'=>$total]);
                    $updateInvoice = Invoice::where('id',$createInvoice1->id)->update(['balance'=>$total]);
                    $updateBalance = User::where('id',$request->id)->update(['balance'=>$total]);
                    $updateAmount = User::where('id',$request->id)->update(['amount'=>0]);
                    $updatePaymentDate = User::where('id',$request->id)->update(['payment_date'=>0]);
                    $updateDueDate = User::where('id',$request->id)->update(['due_date'=>$nextDate]);
                }
            }

        }
        return redirect()->back()->with('success','CUSTOMER BILLED SUCCESS');
    }

    public function downloadPdf(Request $request){
        // reference the Dompdf namespace

// instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('admin.receipt'));

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream();
    }
    public function pdf(){
        return view('admin.pdf');
    }
    public function ttt(){
        return view('admin.ttt');
    }
    public function receipt($id){
        $receipt = Cash::find($id);
        return view('admin.receipt',[
            'receipt'=>$receipt
        ]);
    }
    public function getUserInvoice(Request $request){
        if ($request->ajax()){
            $output = "";
        }
        $user = User::find($request->id);
        $output = '
<input type="hidden" value="'.$user->id.'" name="id">
           <div class="col-lg-12 col-12 form-group">
                                    <label>Location</label>
                                    <input type="text" placeholder="Location" value="'.$user->location.'" class="form-control" name="location">
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Package</label>
                                    <input type="text" placeholder="Package" value="'.$user->bandwidth.'" class="form-control" name="package">
                                </div>
                                   <div class="col-lg-12 col-12 form-group">
                    <label>Pakage Amount</label>
                    <input type="text" value="'.$user->package_amount.'" class="form-control" name="package_amount">
                </div>

                                <div class="col-lg-12 col-12 form-group">
                                    <label>Total Balance</label>
                                    <input type="text" placeholder="Amount" value="'.$user->balance.'" class="form-control" name="amount">
                                </div>
                            </div>
                            <input type="hidden" name="payment_date" value="'.$user->payment_date.'">
                            <input type="hidden" name="due_date" value="'.$user->due_date.'">
        ';
        return response($output);

    }
    public function getInvoice(Request $request){
        if ($request->ajax()){
            $output = "";
        }
        $user = User::find($request->id);
        $output = '
<input type="hidden" value="'.$user->id.'" name="user_id">
           <div class="col-lg-12 col-12 form-group">
                                    <label>Location</label>
                                    <input type="text" placeholder="Location" value="'.$user->location.'" class="form-control" name="location">
                                </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label>Package</label>
                                    <input type="text" placeholder="Package" value="'.$user->bandwidth.'" class="form-control" name="package">
                                </div>
                                   <div class="col-lg-12 col-12 form-group">
                    <label>Pakage Amount</label>
                    <input type="text" value="'.$user->package_amount.'" class="form-control" name="package_amount">
                </div>

                                <div class="col-lg-12 col-12 form-group">
                                    <label>Total Balance</label>
                                    <input type="text" placeholder="Amount" value="'.$user->balance.'" class="form-control">
                                </div>


        ';
        return response($output);

    }
        public function customerDetail($id){
        $user = User::find($id);
        $invoices = Invoice::where('user_id',$user->id)->latest()->take(2)->get();
        $invs = Invoice::where('user_id',$user->id)->get();
        $invCount = Invoice::where('user_id',$user->id)->count();
        $mikrotiks = Mik::all();
        $logs = Logging::where('user_id',$user->id)->latest()->get();
        return view('admin.customerDetail',[
            'user'=>$user,
            'invoices'=>$invoices,
            'invs'=>$invs,
            'invCount'=>$invCount,
            'mikrotiks'=>$mikrotiks,
            'logs'=>$logs
        ]);

    }
    public function expenses(){
        $expenses = Expense::all();
        $currentMonth = date('m');
        $total = Expense::where('currentMonth',$currentMonth)->sum('amount');
        return view('admin.expenses',[
            'expenses'=>$expenses,
            'total'=>$total
        ]);

    }
    public function addExpense(){
        return view('admin.addExpense');

    }
    public function storeExpense(Request $request){
        $currentMonth = date('m');
        $currentYear = date('Y');
        $storeExpense = Expense::create([
            'details'=>$request->input('details'),
            'amount'=>$request->input('amount'),
            'date'=>$request->input('date'),
            'currentMonth'=>$currentMonth,
            'currentYear'=>$currentYear,
        ]);
        return redirect()->back()->with('success','EXPENSES ADDED SUCCESSFULLY');
    }
    public function quotation(){
        $currentDate = Carbon::now()->format('d/m/Y');
        $store = Quotation::create([
            'name'=>'Enter Name',
            'estimate_date'=>$currentDate,
            'expiry_date'=>$currentDate,
            'status'=>0,
            'statas'=>0,
        ]);
        return redirect(url('singleEstimate',$store->id));
    }
    public function cInvoice(){
        $currentDate = Carbon::now()->format('d/m/Y');
        $store = Inv::create([
            'name'=>'Enter Name',
            'invoice_date'=>$currentDate,
            'payment_due'=>$currentDate,
            'amount'=>0,
            'status'=>0,
            'statas'=>0,
        ]);
        return redirect(url('singleInvoice',$store->id));
    }
    public function singleEstimate($id){
        $estimate = Quotation::find($id);
        $products = product::all();
        $ducts = Qproduct::where('quotation_id',$id)->get();
        $quote = Quotation::find($id);
        return view('admin.quotation',[
            'estimate'=>$estimate,
            'products'=>$products,
            'ducts'=>$ducts,
            'quote'=>$quote,
        ]);
    }
    public function editQuotes(Request $request){
        $edit= Quotation::find($request->id);
        $edit->name = $request->name;
        $edit->estimate_date = $request->estimate_date;
        $edit->expiry_date = $request->expiry_date;
        $edit->save();
    }
    public function editInv(Request $request){
        $edit= Inv::find($request->id);
        $editQuotationName = Inv::where('id',$edit->id)->update(['name'=>$request->name]);
        $edit->invoice_date = $request->estimate_date;
        $edit->payment_due = $request->expiry_date;
        $edit->amount = $request->amount;
        $edit->status =0;
        $edit->statas =0;
        $edit->save();
    }
    public function singleInvoice($id){
        $estimate = Inv::find($id);
        $products = product::all();
        $ducts = Qproduct::where('quotation_id',$estimate->quotation_id)->orWhere('invoice_id',$id)->get();
        $test = Qproduct::where('invoice_id',$id)->get();
        $quote = Inv::find($id);
        return view('admin.editInvoice',[
            'estimate'=>$estimate,
            'products'=>$products,
            'ducts'=>$ducts,
            'quote'=>$quote,
        ]);
    }
    public function getAmount(Request $request){
        $output ="";
        $getProduct = Product::find($request->id);
        $output='
            <input type="text" value="'.$getProduct->amount.'" class="form-control" id="amount">

        ';
        return response($output);
    }
    public function viewQuotation(){
        if (Auth::check()){
            $quotations = Quotation::orderByDesc('id')->get();
            $dates = Invoice::all();
            foreach ($dates as $date){

                // Declare and define two dates
                $date1 = strtotime($date->current_time);
                $date2 = strtotime($date->payment_due);

// Formulate the Difference between two dates
                $diff = abs($date2 - $date1);


// To get the year divide the resultant date into
// total seconds in a year (365*60*60*24)
                $years = floor($diff / (365*60*60*24));


// To get the month, subtract it with years and
// divide the resultant date into
// total seconds in a month (30*60*60*24)
                $months = floor(($diff - $years * 365*60*60*24)
                    / (30*60*60*24));


// To get the day, subtract it with years and
// months and divide the resultant date into
// total seconds in a days (60*60*24)
                $days = floor(($diff - $years * 365*60*60*24 -
                        $months*30*60*60*24)/ (60*60*24));

                $update = Invoice::where('id',$date->id)->update(['time_difference'=>$days]);
            }
            return view('admin.viewQuotes',[
                'quotations'=>$quotations
            ]);
        }
        else{
            return redirect(url('login'));
        }
    }
    public function allQuotes(){
        $quotations = Quotation::all();
        return view('admin.allQuotes',[
            'quotations'=>$quotations
        ]);
    }
   
    public function sendUserSms(){
        if (Auth::check()){
            $customers = Singlesms::get();
            $users = User::where('role',1)->orWhere('role',0)->orWhere('role',5)->orWhere('role',6)->orWhere('role',7)->orWhere('role',8)->orderByDesc('id')->get();

            return view('admin.userMessage',[
                'customers'=>$customers,
                'users'=>$users,
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
    public function selectUser($id){
        $getUser = User::find($id);
        $getSelectedUser = Singlesms::where('user_id',$getUser->id)->first();
        if($getSelectedUser){
        return redirect()->back()->with('error','USER ALREADY SELECTED');
        }
        else{
        $store = new Singlesms();
        $store->user_id = $getUser->id;
        $store->save();

        return redirect()->back()->with('success','USER SELECTED');

        }

    }
    public function removeUser($id){
        $getSelectedUser = Singlesms::find($id);
        $getSelectedUser->delete();
        return redirect()->back()->with('success','USER REMOVED');

    }

    public function deleteQ($id){
        $del = Quotation::find($id);
        $deleteProducts = Qproduct::where('quotation_id',$id)->delete();
        $del->delete();
        return redirect(url('viewQuotation'))->with('success','ESTIMATE DELETE SUCCESS');
    }
    public function expiredQuotes(){
        $quotations = Quotation::where('status');
        return view('admin.expiredQuotes',[
            'quotations'=>$quotations
        ]);
    }
    public function viewInvoice(){
        if (Auth::check()){
            $quotations = Inv::where('status',0)->get();
            return view('admin.viewInvoice',[
                'quotations'=>$quotations
            ]);
        }
        else{
            return redirect(url('login'));

        }

    }
    public function printInvoice($id){
        $quote = Inv::where('id',$id)->first();
        $products = Qproduct::where('quotation_id',$quote->quotation_id)->orWhere('invoice_id',$id)->get();
        $total = Qproduct::where('quotation_id',$quote->quotation_id)->orWhere('invoice_id',$id)->sum('total');
        return view('admin.invoice',[
            'quote'=>$quote,
            'products'=>$products,
            'total'=>$total,
        ]);
    }
    public function allInvoices(){
        $quotations = Invoice::all();
        return view('admin.allInvoice',[
            'quotations'=>$quotations
        ]);
    }
    public function currentDate(Request $request){
        if ($request->ajax()){
            $update = Inv::where('id','>',0)->update(['current_time'=>$request->current]);
            $dates = Inv::all();
            foreach ($dates as $date){

                // Declare and define two dates
                $date1 = strtotime($date->current_time);
                $date2 = strtotime($date->payment_due);

// Formulate the Difference between two dates
                $diff = abs($date2 - $date1);


// To get the year divide the resultant date into
// total seconds in a year (365*60*60*24)
                $years = floor($diff / (365*60*60*24));


// To get the month, subtract it with years and
// divide the resultant date into
// total seconds in a month (30*60*60*24)
                $months = floor(($diff - $years * 365*60*60*24)
                    / (30*60*60*24));


// To get the day, subtract it with years and
// months and divide the resultant date into
// total seconds in a days (60*60*24)
                $days = floor(($diff - $years * 365*60*60*24 -
                        $months*30*60*60*24)/ (60*60*24));
                $update = Inv::where('id',$date->id)->update(['time_difference'=>$days]);
            }
        }
    }
    public function currentDat(Request $request){
        if ($request->ajax()){
            $update = Quotation::where('id','>',0)->update(['current_date'=>$request->current]);
            $dates = Quotation::all();
            foreach ($dates as $date){

                // Declare and define two dates
                $date1 = strtotime($date->current_date);
                $date2 = strtotime($date->expiry_date);

// Formulate the Difference between two dates
                $diff = abs($date1 - $date2);


// To get the year divide the resultant date into
// total seconds in a year (365*60*60*24)
                $years = floor($diff / (365*60*60*24));


// To get the month, subtract it with years and
// divide the resultant date into
// total seconds in a month (30*60*60*24)
                $months = floor(($diff - $years * 365*60*60*24)
                    / (30*60*60*24));


// To get the day, subtract it with years and
// months and divide the resultant date into
// total seconds in a days (60*60*24)
                $days = floor(($diff - $years * 365*60*60*24 -
                        $months*30*60*60*24)/ (60*60*24));
                if ($days>0) {
                    $update = Quotation::where('id', $date->id)->update(['time_difference' => $days]);
                }
            }
        }
    }
    public function quotes(Request $request,$id){
        $quote = Quotation::where('id',$id)->first();
        $products = Qproduct::where('quotation_id',$quote->id)->get();
        $total = Qproduct::where('quotation_id',$quote->id)->sum('total');
        $updateStatus = Quotation::where('status',0)->update(['status'=>1]);
        return view('admin.quotes',[
            'quote'=>$quote,
            'products'=>$products,
            'total'=>$total,
        ]);
    }
    public function invoice(Request $request , $id){
        $storeInvoice = Inv::create([
           'quotation_id'=>$id,
           'invoice_date'=>$request->invoice_date,
           'payment_due'=>$request->payment_due,
           'amount'=>$request->amount,
           'status'=>0,
           'statas'=>0,
        ]);
        $invoiceId = Inv::where('quotation_id',$id)->first();

        $quote = Inv::where('id',$invoiceId->id)->first();
        $products = Qproduct::where('quotation_id',$id)->get();
        $total = Qproduct::where('quotation_id',$id)->sum('total');
        $updateQuotationStatus = Quotation::where('id',$id)->where('status',0)->update(['status'=>1]);
        return view('admin.invoice',[
            'quote'=>$quote,
            'products'=>$products,
            'total'=>$total,
        ]);
    }
    public function storeCustomer(Request $request){

      $getAccountNo = User::where('phone',$request->phone)->first();
        
        if(isset($getAccountNo->phone)){
        return redirect()->back()->with('error','ACCOUNT NUMBER ALREADY IN USE');

        }
        else{
                    $integer = (int) $request->bandwidth;
                    $bal = 0;
                    $now = Carbon::now();
                    $endDate = Carbon::parse($request->input('due_date'))->endOfDay();
                $store = User::create([
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->bandwidth,
                    'phone'=>$request->phone,
                    'location'=>$request->comment,
                    'phoneOne'=>$request->phoneOne,
                    'package_amount' => $request->package_amount,
                    'bandwidth'=>$integer,
                    'password'=>$request->password,
                    'payment_date'=>$request->payment_date,
                    
                    'due_date'=>!isset($endDate) ? $now : $endDate,
                    'balance'=> $bal + $request->cBalance,
                    'role'=>2,
                    'mik_id'=> $request->mikrotik_id,
                ]);
                    try {
                    // 2. Initialize connection to MikroTik RouterOS
                    $client = new Client([
                        'host' => $store->mik->ip,
                        'user' => $store->mik->user,
                        'pass' => $store->mik->password,
                        'port' => 8728,
                    ]);

                    // 3. Build the endpoint query to add the secret
                    $query = new Query('/ppp/secret/add');
                    $query->equal('name', $request->first_name);
                    $query->equal('password', $request->password);
                    $query->equal('comment', $request->comment);
                    $query->equal('service', 'pppoe');
                    $query->equal('profile', $request->bandwidth);

                    // 4. Send request to the router
                    $response = $client->query($query)->read();

                    // Check if MikroTik returned an execution error ("!trap")
                    if (isset($response['after']['message'])) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => $response['after']['message']
                        ], 400);
                    }

            
                    

                } catch (Exception $e) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Failed to connect or write to MikroTik: ' . $e->getMessage()
                    ], 500);
                }
                
                        $client = new Client([
                            'host' => $store->mik->ip,
                            'user' => $store->mik->user,
                            'pass' => $store->mik->password,
                            'port' => 8728,
                        ]);

                    // Build a query looking for the specific name
                    $query = (new Query('/ppp/secret/print'))
                        ->where('name', $request->first_name);

                    $response = $client->query($query)->read();
                    $mikrotikId = $response[0]['.id'];
                    $updateMikrotikId = User::where('phone',$request->phone)->update(['mikrotik_id' => $mikrotikId]);
            
                    
                    $dateFor = Carbon::parse($request->due_date);
                    $oneDayBefore = $dateFor->subDays(1);
                    
                   

                                if($store->balance > 0){
                                    try{
                                            $config = new Config([
                                                    'host' => $store->mik->ip,
                                                    'user' => $store->mik->user,
                                                    'pass' => $store->mik->password,
                                                    'port' => 8728,
                                        ]);
                                        $client = new Client($config);

                                            // Create a query for the /ppp/profile/print command
                                            $getUse = 'true';
                                            if($getUse!='true'){
                                            $query = new Query('/ppp/profile/print');
                                        
                                            // 2. Build the RouterOS API query to enable the secret
                                            $query = (new Query('/ppp/secret/set'))
                                                ->equal('.id', $mikrotikId)
                                                ->equal('disabled', 'no');

                                            // 3. Send the query and get the response
                                            $response = $client->query($query)->read();
                                            $update = User::where('mikrotik_id',$mikrotikId)->update(['dis_status'=>'false']);

                                            // 4. Handle the response

                                           
                                            
                                            
                                            }
                                            else{
                                                $query = new Query('/ppp/profile/print');
                                        
                                            // 2. Build the RouterOS API query to disable the secret
                                            $query = (new Query('/ppp/secret/set'))
                                                ->equal('.id', $mikrotikId)
                                                ->equal('disabled', 'yes');

                                            // 3. Send the query and get the response
                                            $response = $client->query($query)->read();
                                            $update = User::where('mikrotik_id',$mikrotikId)->update(['dis_status'=>'true']);
                                            // 4. Handle the response
                                            
                                            
                                            }
                                          
                                          
                                }
                                    catch (\Exception $e) {
                                            // 5. Handle any connection or API errors
                                            Log::info('Billed but no connection');
                                      
                                            
                                            return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                                        }
                                                 $createInvoice = Invoice::create([
                                                    'invoice_date'=>$now,
                                                    'amount'=>$request->package_amount,
                                                    'user_id'=>$store->id,
                                                    'usage_time'=>31,
                                                    'balance'=>0,
                                                    'status'=>0,
                                                    'statas'=>0,
                                                    'one_day_before'=>$oneDayBefore,
                                                    
                                                ]);
                                                $updateUserInvoice = User::where('id',$store->id)->update(['invoice'=>0]);

                                                $createLogtwentyOne = Logging::create([
                                                        'user_id' => $store->id,
                                                        'reason' => 21,
                                                        'date' => $now,
                                                        
                                                    ]);
                                                                                                             
                                }
                                else{
                                             $createInvoice = Invoice::create([
                                                'invoice_date'=>$now,
                                                'amount'=>$request->package_amount,
                                                'user_id'=>$store->id,
                                                'usage_time'=>31,
                                                'balance'=>0,
                                                'status'=>1,
                                                'statas'=>0,
                                                'one_day_before'=>$oneDayBefore,
                                            ]);

                                            $createLogtwentyOne = Logging::create([
                                                    'user_id' => $store->id,
                                                    'reason' => 21,
                                                    'date' => $now,
                                                    
                                                ]);
                                                $updateAmount = User::where('id',$store->id)->update(['amount'=>$request->package_amount, 'dis_status'=>'false']);
                                                
                                }

                            return redirect(url('customers'))->with('success','CUSTOMER CREATED SUCCESSFULLY');

        }
            
            

            
    }
    public function storeCustomerOne(Request $request){
        if ($request->ajax()){
            $output = "";
        }
        $finalAmount = $request->amount_supposed_to_pay + $request->previous_balance;
        $bal = $finalAmount - $request->amount;
        $mpesa = Mpesa::where('senderPhoneNumber',$request->phone)->first();
        $currentMonth = date('m');
        $currentYear = date('Y');
        $paymentDate =  date('d-m-Y', strtotime($request->payment_date));
        $store = User::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'phoneOne'=>$request->phoneOne,
            'location'=>$request->location,
            'bandwidth'=>$request->bandwidth,
            'payment_date'=>$paymentDate,
            'time_difference'=>$request->time_difference,
            'due_date'=>$request->due_date,
            'date_to_send_sms'=>$request->sms_date,
            'amount'=>$request->amount,
            'package_amount'=>$request->amount_supposed_to_pay,
            'amount_supposed_to_be_paid'=>$finalAmount - $request->amount,
            'balance'=>$bal,
            'role'=>2,
            'password'=>Hash::make('123456'),
        ]);
        $date1 = $request->payment_date;
        $date2 =$request->due_date;

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
        $createInvoice = Invoice::create([
            'invoice_date'=>$paymentDate,
            'amount'=>$finalAmount,
            'user_id'=>$store->id,
            'usage_time'=>$usage_time,
            'balance'=>$finalAmount,
            'status'=>0,
            'statas'=>0,
        ]);
        $nextDate =  date('d-m-Y', strtotime($request->due_date));
        $updateBalance = User::where('id',$store->id)->update(['balance'=>$finalAmount]);
        $updateAmount = User::where('id',$store->id)->update(['amount'=>0]);
        $updatePaymentDate = User::where('id',$store->id)->update(['payment_date'=>0]);
        $updateDueDate = User::where('id',$store->id)->update(['due_date'=>$nextDate]);

        $getMinUsage = Invoice::where('user_id',$store->id)->where('status',0)->min('usage_time');
        $getInvoice = Invoice::where('user_id',$store->id)->where('status',0)->where('usage_time',$getMinUsage)->first();
        $currentBalance = $getInvoice->balance - $request->amount;
        if ($request->amount==0){

        }
        else{
            if ($currentBalance<=0){
                $createPay = Payment::create([
                    'user_id'=>$store->id,
                    'invoice_id'=>$getInvoice->id,
                    'amount'=>$request->amount,
                    'date'=>$paymentDate,
                    'reference'=>$mpesa->reference,
                    'payment_method'=>'Mpesa',
                    'currentMonth'=>$currentMonth,
                ]);
                $updateBal = Invoice::where('user_id',$store->id)->update(['usage_time'=>10000]);
                $updateStatus = Invoice::where('user_id',$store->id)->update(['status'=>1]);
                $updateBalance = Invoice::where('user_id',$store->id)->update(['balance'=>$currentBalance]);
                $updatePaymentId = Invoice::where('user_id',$store->id)->update(['payment_id'=>$createPay->id]);
                $updateIBalance = Payment::where('invoice_id',$getInvoice->id)->where('id',$createPay->id)->update(['invoice_balance'=>$currentBalance]);
                $updateCashAmount = Invoice::where('user_id',$store->id)->update(['mpesa_id'=>$mpesa->id]);
                $updateCash = Invoice::where('user_id',$store->id)->update(['mpesa_amount'=>$request->amount]);
                $updateUserAmount = User::where('id',$store->id)->update(['amount'=>$request->amount]);
                $updateUserDate = User::where('id',$store->id)->update(['payment_date'=>$paymentDate]);
                $updateUserBalance = User::where('id',$store->id)->update(['balance'=>$currentBalance]);
            }
            else{
                $getInv = Invoice::where('user_id',$store->id)->where('status',0)->first();
                $currentBal = $getInv->balance - $request->amount;
                if ($currentBal>0){
                    $createPay1 = Payment::create([
                        'user_id'=>$store->id,
                        'invoice_id'=>$getInv->id,
                        'amount'=>$request->amount,
                        'date'=>$paymentDate,
                        'reference'=>$mpesa->reference,
                        'payment_method'=>'Mpesa',
                        'currentMonth'=>$currentMonth,
                    ]);
                    $updateBalance = Invoice::where('id',$getInv->id)->update(['balance'=>$currentBal]);
                    $updateIBalance = Payment::where('invoice_id',$getInv->id)->where('id',$createPay1->id)->update(['invoice_balance'=>$currentBal]);
                    $updateCashAmount = Invoice::where('id',$getInv->id)->update(['payment_id'=>$createPay1->id]);
                    $updateCash = Invoice::where('id',$getInv->id)->update(['mpesa_amount'=>$request->amount]);
                    $updateUserA = User::where('id',$store->id)->update(['amount'=>$request->amount]);
                    $updateUserD = User::where('id',$store->id)->update(['payment_date'=>$paymentDate]);
                    $updateUserBal = User::where('id',$store->id)->update(['balance'=>$currentBal]);
                }
            }

        }
    }

    public function dueDate(Request $request){
        if ($request->ajax()){
            $output = "";
        }
        $updateDueDate = User::where('id',$request->id)->first();
        $output = '
        <input type="date" class="form-control"  value="'.$updateDueDate->due_date.'" id="update_due_date"/>
        <input type="hidden" class="form-control"  value="'.$updateDueDate->id.'" id="customer_id"/>

        ';
        return response($output);
    }
    public function getInvoiceId(Request $request){
        if ($request->ajax()){
            $output = "";
            $getId = Invoice::find($request->id);
            $output = '
                <label><b>'.$getId->quotation->name.'</b></label>
              <input type="date" class="form-control" name="date"/>
                            <input type="hidden" value="'.$getId->id.'" name="invoice_id">
            ';
        }
        return response($output);
    }
   
    public function updateInvoiceDueDate(Request $request){
        $getId = Invoice::find($request->invoice_id);
        $updatePaymenDue = Invoice::where('id',$request->invoice_id)->update(['payment_due'=>$request->date]);
        return redirect(url('viewInvoice'))->with('success','Payment Due Date Updated Success');
    }
    public function updateDueDate(Request $request){
        if ($request->ajax()){
            $output = "";
        }
        $updateDueDate =User::where('id',$request->id)->update(['due_date'=>$request->due_date]);
        $updateTimeDifference =User::where('id',$request->id)->update(['time_difference'=>$request->time_difference]);
        $output=$request->time_difference;
        return response($output);
    }
    public function makeCashPayment(Request $request){
        $currentMonth = date('m');
        $currentYear = date('Y');
        $getMinUsage = Invoice::where('user_id',$request->user_id)->where('status',0)->min('usage_time');
        $getInvoice = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUsage)->first();
        $paymentDate = date("d-m-Y", strtotime($request->payment_date));
        if ($getInvoice){
            $currentBalance = $getInvoice->balance - $request->amount;
            $createPayment = Cash::create([
                'user_id'=>$request->user_id,
                'invoice_id'=>$getInvoice->id,
                'amount'=>$request->amount,
                'date'=>$paymentDate,
                'reason'=>'Internet Subscription',
                'currentMonth' =>$currentMonth,
                'currentYear' =>$currentYear,

            ]);
            $createPay = Payment::create([
                'user_id'=>$request->user_id,
                'invoice_id'=>$getInvoice->id,
                'reference'=>'cash_payment',
                'date'=>$paymentDate,
                'amount'=>$request->amount,
                'status'=>1,
                'payment_method'=>'Cash',
                'currentMonth' =>$currentMonth,

            ]);
            $updateBalance = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUsage)->update(['balance'=>$currentBalance]);
            $updateIBalance = Payment::where('invoice_id',$getInvoice->id)->where('id',$createPay->id)->update(['invoice_balance'=>$currentBalance]);
            $updateCashAmount = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUsage)->update(['cash_id'=>$createPayment->id]);
            $updatePaymentId = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUsage)->update(['payment_id'=>$createPay->id]);
            $updateCash = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUsage)->update(['cash_amount'=>$request->amount]);
            $updateAmountForUser = User::where('id',$request->user_id)->update(['amount'=>$request->amount]);
            $updateDateForUsers = User::where('id',$request->user_id)->update(['payment_date'=>$paymentDate]);
            $userBalance = Invoice::where('user_id',$request->user_id)->where('status',0)->sum('balance');
            $updateUserBalance = User::where('id',$request->user_id)->update(['balance'=>$userBalance]);
            $getInv = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUsage)->first();
            if ($getInv->balance==0){
                $updateBal = Invoice::where('id',$getInv->id)->update(['usage_time'=>2147483647]);
                $updateStatus = Invoice::where('id',$getInv->id)->update(['status'=>1]);
            }
            else{
                if ($getInv->balance<0){
                    $updateBal = Invoice::where('id',$getInv->id)->update(['usage_time'=>2147483647]);
                    $updateStatus = Invoice::where('id',$getInv->id)->update(['status'=>1]);
                    $getMinUs = Invoice::where('user_id',$request->user_id)->where('status',0)->min('usage_time');
                    $getIn = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUs)->first();
                    $getI = Invoice::where('user_id',$request->user_id)->where('balance','<',0)->first();
                    if ($getIn){
                        $currentBal = $getIn->balance + $getI->balance;
                        $createPay1 = Payment::create([
                            'user_id'=>$request->user_id,
                            'invoice_id'=>$getIn->id,
                            'reference'=>'cash_payment',
                            'date'=>$paymentDate,
                            'amount'=>$getI->balance * -1,
                            'status'=>1,
                            'payment_method'=>'Cash',
                            'currentMonth' =>$currentMonth,

                        ]);
                        $updateB = Invoice::where('id',$getIn->id)->where('status',0)->where('usage_time',$getMinUs)->update(['balance'=>$currentBal]);
                        $updateIB= Payment::where('invoice_id',$getIn->id)->where('id',$createPay1->id)->update(['invoice_balance'=>$currentBal]);
                        $updateCashA = Invoice::where('id',$getIn->id)->where('status',0)->where('usage_time',$getMinUs)->update(['payment_id'=>$createPay1->id]);
                        $updateC = Invoice::where('id',$getIn->id)->where('status',0)->where('usage_time',$getMinUs)->update(['cash_amount'=>-($getI->balance)]);
                        $updateUserA = User::where('id',$getIn->user_id)->update(['amount'=>$createPay1->amount]);
                        $updateUserD = User::where('id',$getIn->user_id)->update(['payment_date'=>$paymentDate]);
                        $userBal= Invoice::where('user_id',$getIn->user_id)->where('status',0)->sum('balance');
                        $updateUserBal = User::where('id',$getIn->user_id)->update(['balance'=>$userBal]);
                        $updateB = Invoice::where('id',$getI->id)->update(['balance'=>0]);
                        $getMinUs1 = Invoice::where('user_id',$request->user_id)->where('status',0)->min('usage_time');
                        $getIn1 = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUs1)->first();
                        if ($getIn1->balance==0){
                            $updateBal = Invoice::where('id',$getIn1->id)->update(['usage_time'=>2147483647]);
                            $updateStatus = Invoice::where('id',$getIn1->id)->update(['status'=>1]);
                        }
                        else{
                            if ($getIn1->balance<0){
                                $updateBal = Invoice::where('id',$getIn1->id)->update(['usage_time'=>2147483647]);
                                $updateStatus = Invoice::where('id',$getIn1->id)->update(['status'=>1]);
                                $getMinUs2 = Invoice::where('user_id',$request->user_id)->where('status',0)->min('usage_time');
                                $getIn2 = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUs2)->first();
                                $getI2 = Invoice::where('user_id',$request->user_id)->where('balance','<',0)->first();
                                if ($getIn2){
                                    $currentBal1 = $getIn2->balance + $getI2->balance;
                                    $createPay2 = Payment::create([
                                        'user_id'=>$request->user_id,
                                        'invoice_id'=>$getIn2->id,
                                        'reference'=>'cash_payment',
                                        'date'=>$paymentDate,
                                        'amount'=>$getI2->balance * -1,
                                        'status'=>1,
                                        'payment_method'=>'Cash',
                                        'currentMonth' =>$currentMonth,

                                    ]);
                                    $updateB2 = Invoice::where('id',$getIn2->id)->where('status',0)->where('usage_time',$getMinUs2)->update(['balance'=>$currentBal1]);
                                    $updateIB2= Payment::where('invoice_id',$getIn2->id)->where('id',$createPay2->id)->update(['invoice_balance'=>$currentBal1]);
                                    $updateCashA2 = Invoice::where('id',$getIn2->id)->where('status',0)->where('usage_time',$getMinUs2)->update(['payment_id'=>$createPay2->id]);
                                    $updateC2 = Invoice::where('user_id',$getIn2->id)->where('status',0)->where('usage_time',$getMinUs2)->update(['cash_amount'=>-($getI2->balance)]);
                                    $updateUserA2 = User::where('id',$getIn2->user_id)->update(['amount'=>$createPay2->amount]);
                                    $updateUserD2 = User::where('id',$getIn2->user_id)->update(['payment_date'=>$paymentDate]);
                                    $userBal1= Invoice::where('user_id',$getIn2->user_id)->where('status',0)->sum('balance');
                                    $updateUserBal1 = User::where('id',$getIn2->user_id)->update(['balance'=>$userBal1]);
                                    $updateB2 = Invoice::where('id',$getI2->id)->update(['balance'=>0]);
                                    $getMinUs2 = Invoice::where('user_id',$request->user_id)->where('status',0)->min('usage_time');
                                    $getIn2 = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUs2)->first();
                                    if ($getIn2->balance==0){
                                        $updateBal = Invoice::where('id',$getIn2->id)->update(['usage_time'=>2147483647]);
                                        $updateStatus = Invoice::where('id',$getIn2->id)->update(['status'=>1]);
                                    }
                                    else{
                                        if ($getIn2->balance<0){
                                            $updateBal = Invoice::where('id',$getIn2->id)->update(['usage_time'=>2147483647]);
                                            $updateStatus = Invoice::where('id',$getIn2->id)->update(['status'=>1]);
                                            $getMinUs3 = Invoice::where('user_id',$request->user_id)->where('status',0)->min('usage_time');
                                            $getIn3 = Invoice::where('user_id',$request->user_id)->where('status',0)->where('usage_time',$getMinUs3)->first();
                                            $getI3 = Invoice::where('user_id',$request->user_id)->where('balance','<',0)->first();
                                            if ($getIn3){
                                                $currentBal2 = $getIn3->balance + $getI3->balance;
                                                $createPay3 = Payment::create([
                                                    'user_id'=>$request->user_id,
                                                    'invoice_id'=>$getIn3->id,
                                                    'reference'=>'cash_payment',
                                                    'date'=>$paymentDate,
                                                    'amount'=>$getI3->balance * -1,
                                                    'status'=>1,
                                                    'payment_method'=>'Cash',
                                                    'currentMonth' =>$currentMonth,

                                                ]);
                                                $updateB2 = Invoice::where('id',$getIn3->id)->where('status',0)->where('usage_time',$getMinUs3)->update(['balance'=>$currentBal2]);
                                                $updateIB2= Payment::where('invoice_id',$getIn3->id)->where('id',$createPay3->id)->update(['invoice_balance'=>$currentBal2]);
                                                $updateCashA2 = Invoice::where('id',$getIn3->id)->where('status',0)->where('usage_time',$getMinUs3)->update(['payment_id'=>$createPay3->id]);
                                                $updateC2 = Invoice::where('user_id',$getIn3->id)->where('status',0)->where('usage_time',$getMinUs3)->update(['cash_amount'=>-($getI3->balance)]);
                                                $updateUserA2 = User::where('id',$getIn3->user_id)->update(['amount'=>$createPay3->amount]);
                                                $updateUserD2 = User::where('id',$getIn3->user_id)->update(['payment_date'=>$paymentDate]);
                                                $userBal1= Invoice::where('user_id',$getIn3->user_id)->where('status',0)->sum('balance');
                                                $updateUserBal1 = User::where('id',$getIn3->user_id)->update(['balance'=>$userBal1]);
                                                $updateB2 = Invoice::where('id',$getI3->id)->update(['balance'=>0]);
                                            }
                                            else{
                                                $updateUserBal1 = User::where('id',$request->user_id)->update(['balance'=>$getI3->balance]);

                                            }
                                        }

                                    }
                                }
                                else{
                                    $updateUserBal1 = User::where('id',$request->user_id)->update(['balance'=>$getI2->balance]);

                                }

                            }

                        }
                    }
                    else{
                        $updateUserBal1 = User::where('id',$request->user_id)->update(['balance'=>$getI->balance]);

                    }

                }
            }
        }
        else{
            $getUser = User::find($request->user_id);
            $getCurrectInvoice = Invoice::where('user_id',$request->user_id)->where('status',1)->latest('id')->first();
            $currenUserBalance = $getUser->balance - $request->amount;
            $createCash = Cash::create([
                'user_id'=>$request->user_id,
                'invoice_id'=>$getCurrectInvoice->id,
                'amount'=>$request->amount,
                'date'=>$paymentDate,
                'reason'=>'Internet Subscription',
                'currentMonth' =>$currentMonth,
                'currentYear' =>$currentYear,

            ]);
            $createPay = Payment::create([
                'user_id'=>$request->user_id,
                'invoice_id'=>$getCurrectInvoice->id,
                'reference'=>'cash_payment',
                'date'=>$paymentDate,
                'amount'=>$request->amount,
                'status'=>1,
                'payment_method'=>'Cash',
                'currentMonth' =>$currentMonth,
            ]);
            $updateIBalance = Payment::where('invoice_id',$getCurrectInvoice->id)->where('id',$createPay->id)->update(['invoice_balance'=>$currenUserBalance]);
            $updateCashAmount = Invoice::where('user_id',$request->user_id)->where('status',1)->update(['cash_id'=>$createCash->id]);
            $updatePaymentId = Invoice::where('user_id',$request->user_id)->where('status',1)->update(['payment_id'=>$createPay->id]);
            $updateCash = Invoice::where('user_id',$request->user_id)->where('status',1)->update(['cash_amount'=>$request->amount]);
            $updateUserAmount = User::where('id',$request->user_id)->update(['amount'=>$request->amount]);
            $updateUserDate = User::where('id',$request->user_id)->update(['payment_date'=>$paymentDate]);
            $userBalance = Invoice::where('user_id',$request->user_id)->where('status',1)->sum('balance');
            $updateUserBalance = User::where('id',$request->user_id)->update(['balance'=>$currenUserBalance]);
        }

        return redirect()->back()->with('success','PAYMENT ADDED SUCCESS');
    }
    public function makeMpesaPayment(Request $request){
        $dateFormats = $request->payment_date;
        $dateFormat = Carbon::parse($dateFormats);
        $currentMonth = date('m');
        $currentYear = date('Y');
            $getUserIdentification = User::where('id',$request->user_id )->first();
            $userDueDate = Carbon::parse($getUserIdentification->due_date);
                $getInvoice = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                if (!is_null($getInvoice)) {
                        $currentBalance = $getUserIdentification->balance - $request->amount;
                        $createPayment = Mpesa::create([
                            'reference' => $request->reference,
                            'originationTime' => $dateFormat,
                            'senderFirstName' => $getUserIdentification->first_name,
                            'senderMiddleName' => $getUserIdentification->last_name,
                            'senderPhoneNumber' => $getUserIdentification->phone,
                            'amount' => $request->amount,
                            'invoice_id' => $getInvoice->id,
                            'currentMonth' =>$currentMonth,
                            'currentYear' =>$currentYear,

                        ]);
                        $createPay = Payment::create([
                            'user_id' => $getUserIdentification->id,
                            'invoice_id' => $getInvoice->id,
                            'reference' => $request->reference,
                            'date' => $createPayment->originationTime,
                            'amount' => $createPayment->amount,
                            'status' => 1,
                            'payment_method' => 'Mpesa',
                            'currentMonth' =>$currentMonth,
                        ]);
                        $updateInvoiceBalance = Invoice::where('id', $getInvoice->id)->update(['balance' => $currentBalance]);
                        $updateInvoicePaymentId = Invoice::where('id', $getInvoice->id)->update(['payment_id' => $createPay->id]);
                        $updateInvoiceMId = Invoice::where('id', $getInvoice->id)->update(['mpesa_id' => $createPayment->id]);
                        $updateInvoiceMAmount = Invoice::where('id', $getInvoice->id)->update(['mpesa_amount' => $createPayment->amount]);
                        $updateIBalance = Payment::where('id', $createPay->id)->update(['invoice_balance' => $currentBalance]);
                        $updateUserAmount = User::where('id', $getUserIdentification->id)->update(['amount' => $createPayment->amount]);
                        $updateUserDate = User::where('id', $getUserIdentification->id)->update(['payment_date' => $createPay->date]);
                        $getUser = User::where('mikrotik_id',$getUserIdentification->mikrotik_id)->value('dis_status');
                        if($getUser=='true'){
                        $currentDate = $createPay->date;
                        $nextDate =  $currentDate->addMonth();
                        }
                        else{
                        $currentDate = $userDueDate;
                        $nextDate =  $currentDate->addMonth();
                        }
                        

                        $updateDueDate = User::where('id', $getUserIdentification->id)->update(['due_date' => $nextDate]);
                        $updateUserBalance = User::where('id', $getUserIdentification->id)->update(['balance' => $currentBalance]);
                        $getInv = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                        if ($getInv->balance == 0) {
                            $updateBal = Invoice::where('id', $getInv->id)->update(['usage_time' => 2147483647]);
                            $updateStatus = Invoice::where('id', $getInv->id)->update(['status' => 1]);
                                // Get the MikroTik API client using the configured facade
                                    $config = new Config([
                                        'host' => $getUserIdentification->mik->ip,
                                        'user' => $getUserIdentification->mik->user,
                                        'pass' => $getUserIdentification->mik->password,
                                        'port' => 8728,
                                ]);
                                $client = new Client($config);
                                $mikId = $getUserIdentification->mikrotik_id;

                                    // Create a query for the /ppp/profile/print command
                                    $getUser = User::where('mikrotik_id',$getUserIdentification->mikrotik_id)->value('dis_status');
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
                        } else {
                            if ($getInv->balance < 0) {
                                $updateBal = Invoice::where('id', $getInv->id)->update(['usage_time' => 2147483647]);
                                $updateStatus = Invoice::where('id', $getInv->id)->update(['status' => 1]);
                                $getIn = Invoice::where('user_id', $getUserIdentification->id)->where('status', 0)->first();
                                $getI = Invoice::where('user_id', $getUserIdentification->id)->where('balance', '<', 0)->first();
                                if ($getIn) {
                                    $currentBal = $getIn->balance + $getI->balance;
                                    $createPay1 = Payment::create([
                                        'user_id' => $getUserIdentification->id,
                                        'invoice_id' => $getIn->id,
                                        'reference' => $request->reference,
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
                                                    'reference' => $request->reference,
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
                                                                'reference' => $request->reference,
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
                else {
                            $createPayment = Mpesa::create([
                                'reference' => $request->reference,
                                'originationTime' => $dateFormat,
                                'senderFirstName' => $getUserIdentification->first_name,
                                'senderMiddleName' => $getUserIdentification->last_name,
                                'senderPhoneNumber' => $getUserIdentification->phone,
                                'amount' => $request->amount,
                                'currentMonth' =>$currentMonth,
                                'currentYear' =>$currentYear,
                            ]);
                            $updateUserAmount = User::where('id', $getUserIdentification->id)->update(['amount' => $createPayment->amount]);
                            $updateUserDate = User::where('id', $getUserIdentification->id)->update(['payment_date' => $createPayment->originationTime]);
                            $getUser = User::find($getUserIdentification->id);
                            $getBalance = $getUser->balance;
                            $currentBalance = $getUser->balance - $request->amount;
                            $updateUserBalance = User::where('id', $getUserIdentification->id)->update(['balance' => $currentBalance]);


                }
                return redirect()->back()->with('success','Mpesa Payment Added Success');

    }
    public function invoicePayment($id){
        $cashs = Payment::where('invoice_id',$id)->get();
        $invoice = Invoice::find($id);
        return view('admin.invoicePayment',[
            'cashs'=>$cashs,
            'invoice'=>$invoice
        ]);
    }
    public function filterInvoice(Request $request){
        $user = User::find($request->user_id);
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $start_date = date("m/d/Y", strtotime($startDate));
        $end_date = date("m/d/Y", strtotime($endDate));
        $invoices  = Invoice::whereBetween('invoice_date', array($start_date, $end_date))->where('user_id',$user->id)->get();
        return view('admin.customerDetail',[
            'invoices'=>$invoices,
            'user'=>$user,
        ]);
    }
    public function filterMpesa(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $invoices  = Mpesa::whereBetween('created_at', array($start_date, $end_date))->orderByDesc('id')->get();
        $total  = Mpesa::whereBetween('created_at', array($start_date, $end_date))->sum('amount');
        return view('admin.mpesa',[
            'mpesas'=>$invoices,
            'total'=>$total,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
        ]);
    }
    public function getReceipt($id){
        $receipt = Payment::find($id);
        return view('admin.rec',[
            'receipt'=>$receipt
        ]);
    }
    public function cashReceipt($id){
        $receipt = Cash::find($id);
        return view('admin.cashReceipt',[
            'receipt'=>$receipt
        ]);
    }
    public function mpesaReceipt($id){
        $receipt = Mpesa::find($id);
        $user = User::where('phone',$receipt->senderPhoneNumber)->first();
        return view('admin.mpesaReceipt',[
            'receipt'=>$receipt,
            'user'=>$user,
        ]);
    }
    public function editUser($id){
        $user = User::find($id);
        $mikrotiks = Mik::all();
        return view('admin.editEmployee',[
            'user'=>$user,
            'mikrotiks'=>$mikrotiks
        ]);
    }
    public function currentYear(){
        $currentYear = date('Y');
        $year = Cash::where('id','>',0)->update(['currentYear'=>$currentYear]);
        $year = Mpesa::where('id','>',0)->update(['currentYear'=>$currentYear]);
        $year = Expense::where('id','>',0)->update(['currentYear'=>$currentYear]);
        dd($currentYear);
    }
    public function editEmployee(Request $request,$id){
        $edit = User::find($id);
        $edit->first_name = $request->first_name;
        $edit->last_name = $request->last_name;
        $edit->email = $request->email;
        $edit->phoneOne = $request->phone;
        $edit->role = $request->role;
        $edit->products = $request->dashboard;
        $edit->customers = $request->customers;
        $edit->payments = $request->payments;
        $edit->expenses = $request->sms;
        $edit->estimate = $request->band;
        $edit->amount_supposed_to_be_paid = $request->logs;
        $edit->users = $request->users;
        $edit->save();
    return redirect(url('employees'))->with('success','USER EDITED SUCCESS');
    }
    public function resetUser(Request $request,$id){
        $reset = User::find($id);
        $reset->first_name = $request->first_name;
        $reset->last_name = $request->last_name;
        $reset->email = $request->email;
        $reset->phone = $request->phone;
        $reset->role = $request->role;
        $reset->products = $request->products;
        $reset->users = $request->users;
        $reset->customers = $request->customers;
        $reset->payments = $request->payments;
        $reset->expenses = $request->expenses;
        $reset->estimate = $request->estimates;
        $reset->invoice = $request->invoice;
        $reset->password = Hash::make($request->phone);
        $reset->save();
        return redirect(url('employees'))->with('success','USER EDITED SUCCESS');
    }
    public function editCustomerDetail(Request $request, $id){
        $customer = User::find($id);
        $custs = Duplicate::where('duplicate_id', $id)->orderByDesc('id')->get();
        $clients = User::where('role',2)->get();
        $mikrotiks = Mik::all();
        $secretPassword = null;
        $date = $customer->payment_date;

// 1. Initialize the client using your RouterOS credentials
        
        try{
             $client = new Client([
            'host' => $customer->mik->ip,
            'user' => $customer->mik->user,
            'pass' => $customer->mik->password,
            'port' => 8728,
        ]);

        // 2. Build the query object (e.g., getting secrets with 'default' profile)
        $query = new Query('/ppp/secret/print');
        $query->where('.id', $customer->mikrotik_id);

        // 3. Send the query and read the response
        $response = $client->query($query)->read();

        // 4. Extract only the 'name' field from the response
        $secretPassword  =  $response[0]['password'];

        }
         catch (\Exception $e) {
                                            // 5. Handle any connection or API errors
                                            Log::info('Account not found in Mikrotik');
                                            Log::info($e->getMessage());
                            
                                        }
       
        

        
        return view('admin.editCustomerDetail',[
            'customer'=>$customer,
            'custs'=>$custs,
            'clients'=>$clients,
            'date'=>$date,
            'mikrotiks'=>$mikrotiks,
            'password' => $secretPassword
        ]);
    }
     public function addCustomers(Request $request){

        // $randomNumber is now guaranteed to be unique and unused
         $mikrotiks = Mik::all();
        return view('admin.customerAdd',[
          
            'mikrotiks'=>$mikrotiks

        ]);
    }
    public function activate(Request $request){
        $customer = User::find($request->user_id);
        $customer->role = 2;
        $customer->save();
        return redirect()->back()->with('success','Customer Activated');
    }
     public function noneActive(Request $request){
        $customer = User::find($request->user_id);
        $customer->role = 4;
        $customer->save();
        $deleteInvoice = invoice::where('user_id',$customer->id)->delete();
        return redirect()->back()->with('success','Customer Deactivated');
    }

    public function subAccount(Request $request){
        Log::info('sub account added');
        $findDuplicate = Duplicate::where('user_id', $request->user_id)->first();
        
        if(!isset($findDuplicate)){
            $duplicate = Duplicate::create([
                'user_id' => $request->user_id,
                'duplicate_id' => $request->sub_id,
            ]);
            $updateRole = User::where('id', $request->user_id)->update(['role'=>50]);
            $deleteInvoice = invoice::where('user_id',$request->user_id)->delete();

            $findUser = User::where('id', $request->user_id)->first();
            $now = Carbon::now();
            $createLogthertyone = Logging::create([
                                'user_id' => $findUser->user_id,
                                'reason' => 31,
                                'date' => $now,
                                'name'=> $findUser->first_name,
                                'duplicate_id' => $request->sub_id,
                                
                            ]);

            return redirect()->back()->with('success','SUB-ACCOUNT ADDED SUCCESS');  

        }
        else{
            return redirect()->back()->with('error','SUB-ACCOUNT ALREADY EXIST');

        }

       
    }

    public function editC(Request $request, $id){
        $getAccountNo = User::where('phone',$request->phone)->first();
        
        if(isset($getAccountNo->phone)){
        return redirect()->back()->with('error','ACCOUNT NUMBER ALREADY IN USE');

        }
        else{
             $dateFormat = Carbon::parse($request->due_date);
        $endDate = Carbon::parse($request->input('due_date'))->endOfDay();
        $dateNow = Carbon::now();
        $nextDate = $endDate;
        $edit = User::find($id);
        $bal = $edit->balance;
        $currentBal = $bal + $request->cBalance;
        $edit->first_name = $request->first_name;
        $edit->last_name = $request->bandwidth;
        $edit->email = $request->email;
        if(!isset($request->phone)){

        }
        else{
            $edit->phone = $request->phone;
        }

          if(!isset($request->password)){

        }
        else{
            $getA = User::find($id);

          try {

                                // Get the MikroTik API client using the configured facade
                                $config = new Config([
                                    'host' => $getA->mik->ip,
                                    'user' => $getA->mik->user,
                                    'pass' => $getA->mik->password,
                                    'port' => 8728,
                            ]);
                            $client = new Client($config);
                            $query = (new Query('/ppp/secret/print'))->where('.id', $getA->mikrotik_id);
                            $secrets = $client->query($query)->read();
                            // $secrets will be an array containing the user's details if found.
                            
                            if (!empty($secrets)) {
                            $secretId = $secrets[0]['.id']; // Get the ID of the first matching user

                            $updateQuery = (new Query('/ppp/secret/set'))
                                ->equal('.id', $getA->mikrotik_id)
                                ->equal('password', $request->password); // Change the assigned profile
                                // ->equal('comment', 'Updated by Laravel'); // Add or change comments

                            $client->query($updateQuery)->read(); // Execute the update
                            
                        }
                 
                                
                        
                    

                    } catch (\Exception $e) {
                        // 5. Handle any connection or API errors
                        Log::info('password edit failed');
                    
                        return response()->json(['error' => 'Failed to update password secret: ' . $e->getMessage()], 500);
                    }    

        }
        
        $edit->phoneOne = $request->phoneOne;
        $edit->location = $request->comment;
        $edit->package_amount = $request->package_amount;
        $edit->amount = $request->package_amount;
        $edit->payment_date = $request->payment_date;
        $edit->due_date = $nextDate;
        $edit->balance = $currentBal;
        $edit->save();

          try {

                                // Get the MikroTik API client using the configured facade
                                $config = new Config([
                                    'host' => $edit->mik->ip,
                                    'user' => $edit->mik->user,
                                    'pass' => $edit->mik->password,
                                    'port' => 8728,
                            ]);
                            $client = new Client($config);
                            $query = (new Query('/ppp/secret/print'))->where('.id', $edit->mikrotik_id);
                            $secrets = $client->query($query)->read();
                            // $secrets will be an array containing the user's details if found.
                            
                            if (!empty($secrets)) {
                            $secretId = $secrets[0]['.id']; // Get the ID of the first matching user

                            $updateQuery = (new Query('/ppp/secret/set'))
                                ->equal('.id', $edit->mikrotik_id)
                                ->equal('name', $request->first_name)
                                ->equal('comment', $request->comment);
                                // ->equal('comment', 'Updated by Laravel'); // Add or change comments

                            $client->query($updateQuery)->read(); // Execute the update
                            
                        }
                 
                                
                        
                    

                    } catch (\Exception $e) {
                        // 5. Handle any connection or API errors
                        Log::info('password edit failed');
                    
                        return response()->json(['error' => 'Failed to update password secret: ' . $e->getMessage()], 500);
                    }    
        $createLogTwelve = Logging::create([
            'user_id' => $id,
            'reason' => 12,
            'date' => $dateNow,
            'name' => $request->first_name,
            'password' => $request->password,
            'account' => $request->phone,
            'phone_number' => $request->phoneOne,
            'package' => $request->bandwidth,
            'package_amount' => $request->package_amount,
            'current_balance' => $currentBal,
            'add_balance' => $request->cBalance,
            'payment_date' => $request->payment_date,
            'due_date' => $nextDate,
            'duplicate_id' => $request->sub_id,
        ]);
        $getInvoiceId = Invoice::where('user_id',$id)->latest('id')->first();
        $paymentDate = Carbon::parse($request->payment_date);
        $currentMonth = date('m');
        if($request->payment_date){
            if(!isset($getInvoiceId)){
                   $createInvoice = Invoice::create([
                            'invoice_date'=>$dateFormat,
                            'amount'=>$request->package_amount,
                            'user_id'=>$id,
                            'usage_time'=>null,
                            'balance'=>0,
                            'status'=>1,
                            'statas'=>0,
                        ]);


            }
            $getInvoiceId = Invoice::where('user_id',$id)->latest('id')->first();
            $createPay = Payment::create([
                'user_id' => $id,
                'invoice_id' => $getInvoiceId->id,
                'reference' => $request->reference,
                'date' => $paymentDate,
                'amount' => $request->package_amount,
                'status' => 1,
                'payment_method' => 'Mpesa',
                'currentMonth' =>$currentMonth,
            ]);
            $updatePaymentId = Invoice::where('user_id',$id)->latest('id')->update(['payment_id'=>$createPay->id]);
            
            $updateInvoiceDate = Invoice::where('user_id',$id)->latest('id')->update(['invoice_date'=>$dateFormat]);
            if($request->one_day_before){

            }
            else{
             $dateFormat = Carbon::parse($request->due_date);
             $nextDate = $dateFormat->addDay();
            $twoDaysBefore = $nextDate->subDays(3);
            $updateInvoiceMessageDate = Invoice::where('user_id',$id)->latest('id')->update(['two_days_before'=>$twoDaysBefore]);
            }
           if($request->two_days_before){

           }
           else{
             $dateFormat = Carbon::parse($request->due_date);
            $nextDate = $dateFormat->addDay();
            $oneDayBefore = $nextDate->subDays(2);
            $updateInvoiceMDate = Invoice::where('user_id',$id)->latest('id')->update(['one_day_before'=>$oneDayBefore]);
           }
          
            $updateInvoiceStatus = Invoice::where('user_id',$id)->latest('id')->update(['status'=>1]);
            $getLatestInvoice = Invoice::where('user_id',$id)->latest('id')->first();
            $getPreviousInvoices = Invoice::where('id','!=',$getLatestInvoice->id)->where('user_id',$id)->get();
            foreach($getPreviousInvoices as $getPreviousInvoice){
                $updateInvoiceStatas = invoice::where('id',$getPreviousInvoice->id)->update(['statas'=>1]);

            }
        }
        
        $updateInvoiceDate = Invoice::where('user_id',$id)->latest('id')->update(['invoice_date'=>$nextDate]);
        $updateMessagePaidTwo = Invoice::where('user_id', $id)->latest('id')->update([
                                'two_days_before_status' => null,
                                'due_date_status' => null,
                                ]);
        $getUser = User::find($id);
        if($getUser->payment_date!=null){
            if($request->one_day_before){
            $oneDaysBefore = Carbon::parse($request->one_day_before);
            $updateOneDay = Invoice::where('user_id',$id)->where('statas',0)->update(['one_day_before'=>$oneDaysBefore]);
            }
            if($request->two_days_before){
            $twoDaysBefore = Carbon::parse($request->two_days_before);
            $updateTwoDay = Invoice::where('user_id',$id)->where('statas',0)->update(['two_days_before'=>$twoDaysBefore]);
            }
                    if($getUser->payment_date!=null){
                                    try {
                                // Get the MikroTik API client using the configured facade
                                $config = new Config([
                                'host' => $getUser->mik->ip,
                                'user' => $getUser->mik->user,
                                'pass' => $getUser->mik->password,
                                'port' => 8728,
                            ]);
                            $client = new Client($config);

                                // Create a query for the /ppp/profile/print command
                                $getUse = User::where('mikrotik_id',$getUser->mikrotik_id)->value('dis_status');
                                if($getUse=='true'){
                                $query = new Query('/ppp/profile/print');
                            
                                // 2. Build the RouterOS API query to disable the secret
                                $query = (new Query('/ppp/secret/set'))
                                    ->equal('.id', $getUser->mikrotik_id)
                                    ->equal('disabled', 'no');

                                // 3. Send the query and get the response
                                $response = $client->query($query)->read();

                                // 4. Handle the response
                                $update = User::where('mikrotik_id',$getUser->mikrotik_id)->update(['dis_status'=>'false']);
                                
                        }
                    

                    } catch (\Exception $e) {
                        // 5. Handle any connection or API errors
                        Log::info('edit successfull but no connection to mikrotik to enable');
                        $cache = Cache::create([
                            'user_id' => $getUser->id,
                            'status' => 2,
                        ]);
                        return response()->json(['error' => 'Failed to enable PPPoE secret: ' . $e->getMessage()], 500);
                    }
                    
                      try {
                                // Get the MikroTik API client using the configured facade
                                $config = new Config([
                                'host' => $getUser->mik->ip,
                                'user' => $getUser->mik->user,
                                'pass' => $getUser->mik->password,
                                'port' => 8728,
                            ]);
                            $client = new Client($config);
                            $query = (new Query('/ppp/secret/print'))->where('.id', $getUser->mikrotik_id);
                            $secrets = $client->query($query)->read();
                            // $secrets will be an array containing the user's details if found.
                            
                            if (!empty($secrets)) {
                            $secretId = $secrets[0]['.id']; // Get the ID of the first matching user

                            $updateQuery = (new Query('/ppp/secret/set'))
                                ->equal('.id', $secretId)
                                ->equal('profile', $request->bandwidth); // Change the assigned profile
                                // ->equal('comment', 'Updated by Laravel'); // Add or change comments

                            $client->query($updateQuery)->read(); // Execute the update
                        }
                 
                                
                        
                    

                    } catch (\Exception $e) {
                        // 5. Handle any connection or API errors
                        Log::info('edit successfull but no connection to mikrotik to update profile');
                        $cache = Cache::create([
                            'user_id' => $getUser->id,
                            'status' => 3,
                        ]);
                        return response()->json(['error' => 'Failed to update Profile: ' . $e->getMessage()], 500);
                    }

                    }
                    else{

                    }
           

        

        }
        return redirect(url('customers'))->with('success','CUSTOMER EDIT SUCCESS');

        }
       
       
    }
    public function deleteUser(Request $request){
        $delete = User::find($request->userid);
        $delete->delete();
        return redirect(url('employees'))->with('success','USER DELETED SUCCESS');

    }
    public function bulksms(){
        return view('admin.bulksms');
    }
    public function sendBulkSms(Request $request){
           $ones =  Invoice::where('status',1)->where('statas',0)->get();
          
        foreach($ones as $one){
                $oneDay = $one->one_day_before;
              
           
                         $postData = [
                        'apikey' => '9324ef7e2034b5d479f64d31ae513215',
                        'partnerID' => 138,
                        'mobile' => $one->user->phoneOne,
                        
                        'message' => $request->message,
                        'shortcode' => 'VUMATEL',
                        
                    ];
                    $respons = Http::post('https://sms.imarabiz.com/api/services/sendsms/', $postData);

       
                                     
        }
                return redirect()->back()->with('success','MESSAGE SENT SUCCESSFULLY');

    
    }
       public function sendSingleSms(Request $request){
           $ones =  Singlesms::get();
           
          
        foreach($ones as $one){
                $oneDay = $one->one_day_before;
              
           
                         $postData = [
                        'apikey' => '9324ef7e2034b5d479f64d31ae513215',
                        'partnerID' => 138,
                        'mobile' => $one->user->phoneOne,
                        
                        'message' => $request->message,
                        'shortcode' => 'VUMATEL',
                        
                    ];
                    $respons = Http::post('https://sms.imarabiz.com/api/services/sendsms/', $postData);

       
                                     
        }
        Singlesms::truncate();
                return redirect()->back()->with('success','MESSAGE SENT SUCCESSFULLY');

    
    }
    public function del(Request $request){
        $output = "";
        $userId = User::find($request->id);
        $output = '
        <input type=hidden value='.$userId->id.' name=userid>
        ';
        return response($output);
    }
    public function delC(Request $request){
        $output = "";
        $userId = User::find($request->id);
        $output = '
        <input type=hidden value='.$userId->id.' name=userid>
        ';
        return response($output);
    }
       public function delDuplicate(Request $request){
        $output = "";
        $userId = Duplicate::find($request->id);
        $output = '
        <input type=hidden value='.$userId->id.' name=userid>
        ';
        return response($output);
    }
    public function delE(Request $request){
        $output = "";
        $userId = Expense::find($request->id);
        $output = '
        <input type=hidden value='.$userId->id.' name=userid>
        ';
        return response($output);
    }
    public function delP(Request $request){
        $output = "";
        $userId = Product::find($request->id);
        $output = '
        <input type=hidden value='.$userId->id.' name=userid>
        ';
        return response($output);
    }
    public function deleteC(Request $request){
            $findUser = User::where('id',$request->userid)->first();
            $storeName = Logging::where('user_id',$request->userid)->update(['name'=>$findUser->first_name]);
            $now = Carbon::now();
               $createLogtwenty = Logging::create([
                            'user_id' => $request->userid,
                            'reason' => 20,
                            'date' => $now,
                            'name'=> $findUser->first_name,
                            
                        ]);
        $deleteUser = User::where('id',$request->userid)->delete();
            // 1. Initialize MikroTik API Client
        // Ensure your MikroTik has the API service enabled under IP > Services > api
        $client = new Client([
            'host' => $findUser->mik->ip,
            'user' => $findUser->mik->user,
            'pass' => $findUser->mik->password,
            'port' => 8728,
        ]);

        // 2. Find the Secret's internal ID based on the username
        $query = (new Query('/ppp/secret/print'))
            ->where('.id', $findUser->mikrotik_id);

        $response = $client->query($query)->read();

        // Check if the secret exists
        if (empty($response)) {
            return response()->json(['message' => 'Secret not found in MikroTik.'], 404);
        }

        // Extract the unique .id (e.g., *1, *2)
        $secretId = $response[0]['.id'];

        // 3. Send the remove command
        $removeQuery = (new Query('/ppp/secret/remove'))
            ->equal('.id', $secretId);

        $client->query($removeQuery)->read();

       

        return redirect(url('noneActivecustomers'))->with('success','CUSTOMER DELETED SUCCESS');

    }
       public function deleteDuplicate(Request $request){
            $findUser = Duplicate::where('id',$request->userid)->first();
            $now = Carbon::now();
               $createLogTherty = Logging::create([
                            'user_id' => $findUser->user_id,
                            'reason' => 30,
                            'date' => $now,
                            'name'=> $findUser->user->first_name,
                            'duplicate_id' => $findUser->duplicate_id,
                            
                        ]);
        $deleteUser = Duplicate::where('id',$request->userid)->delete();
        $updateRole = User::where('id', $findUser->user_id)->update(['role'=>2]);
         $createInvoice = Invoice::create([
                                            'invoice_date'=>$now,
                                            'amount'=>0,
                                            'user_id'=>$request->user_id,
                                            'usage_time'=>0,
                                            'balance'=>0,
                                            'status'=>0,
                                            'statas'=>0,
                                        ]);
     

        return redirect()->back()->with('success','SUB-ACCOUNT REMOVED SUCCESS');

    }
      public function bandwidth(){
      
      return view('admin.bandwidthMonitor',[
          
        ]);

    }
        public function refresh(){
            try{
                    $client = new Client([
            'host' => '102.209.56.86',
            'user' => 'admin',
            'pass' => '@anxvtT3n',
            'port' => 8728,
]);

    // Monitor traffic on ether1
    $query = new Query('/interface/monitor-traffic');
    $query->equal('interface', 'pppoe_bridge');
    $query->equal('once', ''); // Use for single check, remove for stream

    $traffic = $client->query($query)->read();
    $tx_speed = $traffic[0]['tx-bits-per-second'] / 1024 / 1024;
    $rx_speed = $traffic[0]['rx-bits-per-second']/ 1024 / 1024;
    $upload = round($rx_speed, 1);
    $download = round($tx_speed, 1);

    
    return '              
                                <div class="student-report">
                                      <div class="student-count pseudo-bg-yellow">
                                        <h4 class="item-title">Download Speed</h4>
                                        <div class="item-number">'.$download.' Mbps</div>
                                    </div>
                                    <div class="student-count pseudo-bg-blue">
                                        <h4 class="item-title">Upload Speed</h4>
                                        <div class="item-number">'.$upload.' Mbps</div>
                                    </div>
                                  
                                </div>
            ';

            }
            catch (\Exception $e) {}
    
      
      

    }
            public function refreshBandwidth(){
            try{
                    $client = new Client([
                                'host' => '102.209.56.86',
                                'user' => 'admin',
                                'pass' => '@anxvtT3n',
                                'port' => 8728,
    ]);

    // Monitor traffic on ether1
    $query = new Query('/interface/monitor-traffic');
    $query->equal('interface', 'pppoe_bridge');
    $query->equal('once', ''); // Use for single check, remove for stream

    $traffic = $client->query($query)->read();
    $tx_speed = $traffic[0]['tx-bits-per-second'] / 1024 / 1024;
    $rx_speed = $traffic[0]['rx-bits-per-second']/ 1024 / 1024;
    $upload = round($rx_speed, 1);
    $download = round($tx_speed, 1);
    
    return '              
                                <div class="arrow-F-uE7IX8- arrowToSell-2niuhIkD- arrowSellShudder-mudaBhtR-" style="transform: rotate('.$upload.'deg);">
          <div class="arrowMain-4Z6WqtKf-"></div>
          <div class="arrowHidden-chDYo-JT-"></div>
        </div>
            ';

            }
            catch (\Exception $e) {}
    
      
      

    }
        public function refreshPercentage(){
            try{
                $latestBand = Band::latest()->take(2)->get();
                $latestRecord = $latestBand->first();
                $download = $latestRecord->download;
                $secondLatestRecord = $latestBand[1];
                $downloadOne = $secondLatestRecord->download;
                $percent = $download / $downloadOne;
                $percentag = $percent*100;
                $percentage = round($percentag);

                   
    
    return '              
            <span class="speedometerSignal-pyzN--tL- redColor-Hpg7doOR-">'.$percentage.' %</span>
            ';

            }
            catch (\Exception $e) {}
    
      
      

    }
    public function testing(){
     // 1. Configure the API connection
    $config = new Config([
                                'host' => '102.209.56.86',
                                'user' => 'admin',
                                'pass' => '@anxvtT3n',
                                'port' => 8728,
    ]);

    $client = new Client($config);

    // 2. Build the query to get simple queues
    $query = new Query('/queue/simple/getall');
    
    // Optional: Filter by name
    // $query->where('name', 'My_Queue_Name');

    // 3. Send request
    $response = $client->query($query)->read();
    dd($response);

    // The max-limit is usually in format "upload/download" (e.g., "1M/10M")
    return response()->json($response);
         
    }
    public function addMikrotik(){
        $mikrotiks = Mik::all();
        return view('admin.addMikrotik',[
            'mikrotiks'=>$mikrotiks
        ]);
    }
     public function mikrotikDetail($id){
        $mikrotik = Mik::find($id);
        $mikrotiks = Mik::all();
        $customers = User::where('role', 3)->where('mik_id',$id)->orderByDesc('id')->get();
        $actives = User::where('dis_status', 'false')->where('role','!=',4)->where('mik_id',$id)->orderByDesc('id')->get();
        $disconnects = User::where('dis_status', 'true')->where('role','!=',4)->where('mik_id',$id)->orderByDesc('id')->get();
        return view('admin.mikrotikDetail',[
            'mikrotik'=>$mikrotik,
            'mikrotiks'=>$mikrotiks,
            'customers'=>$customers,
            'disconnects'=>$disconnects,
            'actives'=>$actives,

        ]);
    }
    public function listMikrotik(){
        $mpesas = Mik::all();
        $mikrotiks = Mik::all();

        return view('admin.listMikrotik',[
            'mpesas'=>$mpesas,
            'mikrotiks'=>$mikrotiks
        ]);
    }

    public function storeMikrotik(Request $request){
                try {
            // Initialize connection using your MikroTik's IP, username, and password
            $client = new Client([
                'host' => $request->mikrotik_ip,
                'user' => $request->mikrotik_user,
                'pass' => $request->mikrotik_password,
                'port' => 8728,         // Default API port
            ]);

            // Create query to get system identity
            $query = new Query('/system/identity/print');

            // Execute the query
            $response = $client->query($query)->read();

            // Extract the 'name' from the MikroTik response
            $routerName = $response[0]['name'] ?? 'Unknown';
            $store = new Mik();
            $store->name = $routerName;
            $store->ip = $request->mikrotik_ip;
            $store->user = $request->mikrotik_user;
            $store->password = $request->mikrotik_password;
            $store->save();

         

        } catch (\Exception $e) {
            return redirect()->back()->with('error','Mikrotik Not Reached');

        }
        return redirect(url('listMikrotik'))->with('success','Mikrotik added Success');

    }
    public function editMikrotik($id){
        $edit = Mik::find($id);
        $mikrotiks = Mik::all();
        return view('admin.editMikrotik',[
            'edit'=>$edit,
            'mikrotiks'=>$mikrotiks
        ]);
    }
    public function editMik(Request $request){
        $edit = Mik::find($request->mikrotik_id);
        $edit->ip = $request->mikrotik_ip;
        $edit->user = $request->mikrotik_user;
        $edit->password = $request->mikrotik_password;
        $edit->save();

        return redirect(url('listMikrotik'))->with('success','Mikrotik Edit Success');

    }
    public function deleteMikrotik(Request $request){
        $deleteM = Mik::where('id',$request->mikrotik_id)->delete();
        return redirect()->back()->with('Mikrotik Deleted Success');
    }
    public function navbar(){
        $mikrotik = Mik::all();

        return view('adminPartial.nav',[
            'mikrotiks'=>$mikrotiks
        ]);
    }

}
