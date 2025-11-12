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


class AdminController extends Controller
{
    public function admin(){
        if (Auth::check()) {
            if (Auth::user()->role==0 || Auth::user()->role==1) {
                $notice = Notice::where('id','>',0)->first();
              $currentMonth = date('m');
              $currentYeah = date('Y');
              $mpesa = Mpesa::where('currentMonth',$currentMonth)->where('currentYear',$currentYeah)->sum('amount');
              $cash = Cash::where('currentMonth',$currentMonth)->where('currentYear',$currentYeah)->sum('amount');
              $expense = Expense::where('currentMonth',$currentMonth)->where('currentYear',$currentYeah)->sum('amount');
              $debt = User::where('balance','>',0)->sum('balance');
              $total = $mpesa + $cash;
              $net =$total - $expense;
                return view('admin.index',[
                    'notice'=>$notice,
                    'mpesa'=>$mpesa,
                    'cash'=>$cash,
                    'expense'=>$expense,
                    'net'=>$net,
                    'debt'=>$debt,
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
            if (Auth::user()->role==0 || Auth::user()->role==1) {
                return view('admin.profile');
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
        $edit->phone = $request->phone;
        $edit->email = $request->email;
        $edit->password = Hash::make($request->password);
        $edit->save();
        return redirect()->back()->with('success','profile updated success');
    }
    public function customers(){
        if (Auth::check()){
            $customers = User::where('role', 2)->orderByDesc('id')->get();
            return view('admin.customers',[
                'customers'=>$customers,
            ]);
        }
        else{
            return redirect(url('login'));
        }

    }
     public function Selectcustomers(){
        if (Auth::check()){
            $customers = User::where('role', 3)->orderByDesc('id')->get();
            return view('admin.customerSelect',[
                'customers'=>$customers,
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
            'host' => '192.168.88.1',
            'user' => 'admin',
            'pass' => 'password',
            'port' => 8728,
        ]);

        try {
            // Establish a connection to the MikroTik router
            $client = new Client($config);

            // Fetch all PPPoE secrets (configured users)
            $secretsQuery = new Query('/ppp/secret/getall');
            $pppSecrets = $client->query($secretsQuery)->read();
            dd($pppSecrets);

            // Fetch all active PPPoE connections
            $activeQuery = new Query('/ppp/active/getall');
            $pppActive = $client->query($activeQuery)->read();
            dd($pppActive);

            return response()->json([
                'secrets' => $pppSecrets,
                'active_connections' => $pppActive,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
        
        else{
            return redirect(url('login'));
        }

    }
         public function storePppoe(){
        if (Auth::check()){
            // Get MikroTik connection details from .env
        $config = new Config([
            'host' => '197.248.58.123',
            'user' => 'admin',
            'pass' => 'KND@2020',
            'port' => 8728,
        ]);

        try {
            // Establish a connection to the MikroTik router
            $client = new Client($config);
            // Fetch all PPPoE secrets (configured users)
            $secretsQuery = new Query('/ppp/secret/getall');
            $mikrotikUsers = $client->query($secretsQuery)->read();
            
            foreach ($mikrotikUsers as $mikrotikUser){
                if($mikrotikUser['comment']!=null){
                    $comment = $mikrotikUser['comment'];
                }
                else{
                    $comment = null;
                }
                if($mikrotikUser['profile']!=null){
                    $profile = $mikrotikUser['profile'];
                }
                else{
                    $profile = null;
                }
                
                
                $getUserId = User::where('mikrotik_id',$mikrotikUser['.id'])->value('id');
                if($getUserId==null){
                    $now = Carbon::now();
                    

                        $storePPPoe = User::create([
                        'first_name'=>$mikrotikUser['name'],
                        'location'=>$comment,
                        'last_name'=>$mikrotikUser['profile'],
                        'password'=>$mikrotikUser['password'],
                        'mikrotik_id'=>$mikrotikUser['.id'],
                        'dis_status'=>$mikrotikUser['disabled'],
                        'role'=>3,
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
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
               try {
            // Get the MikroTik API client using the configured facade
            $config = new Config([
            'host' => '197.248.58.123',
            'user' => 'admin',
            'pass' => 'KND@2020',
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
            return redirect()->back()->with('success','User Disabled Success');
            }
          

        } catch (\Exception $e) {
            // 5. Handle any connection or API errors
            return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
        }
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
        return view('admin.addEmployee');
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
        $store = User::create([
           'first_name'=>$request->first_name,
           'last_name'=>$request->last_name,
           'phone'=>$request->phone,
           'email'=>$request->email,
           'role'=>$request->role,
           'products'=>$request->products,
           'users'=>$request->users,
           'customers'=>$request->customers,
           'payments'=>$request->payments,
           'expenses'=>$request->expenses,
           'estimate'=>$request->estimate,
           'invoice'=>$request->invoice,
           'password'=>Hash::make('password'),
        ]);
        return redirect()->back()->with('success','EMPLOYEE ADDED SUCCESSFULLY');
    }
    public function employees(){
        $customers = User::where('role',1)->orWhere('role',0)->orderByDesc('id')->get();
        return view('admin.employee',[
            'customers'=>$customers
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
        return view('admin.addCustomer',[
            'profiles'=>$profiles
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
        return view('admin.customerDetail',[
            'user'=>$user,
            'invoices'=>$invoices,
            'invs'=>$invs,
            'invCount'=>$invCount
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
        if ($request->ajax()){
            $output = "";
        }
        $finalAmount = $request->amount_supposed_to_pay + $request->previous_balance;
        $bal = $finalAmount - $request->amount;
        $currentMonth = date('m');
        $currentYear = date('Y');
        $paymentDate =  date('d-m-Y', strtotime($request->payment_date));
        $store = User::create([
           'first_name'=>$request->first_name,
           'last_name'=>$request->bandwidth,
           'email'=>$request->email,
           'phone'=>$request->phone,
           'phoneOne'=>$request->phoneOne,
           'location'=>$request->location,
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
            'amount'=>$request->amount_supposed_to_pay,
            'user_id'=>$store->id,
            'usage_time'=>$usage_time,
            'balance'=>$finalAmount,
            'status'=>0,
            'statas'=>0,
        ]);
        $nextDate =  date('d-m-Y', strtotime($request->due_date));
        $updateBalance = User::where('id',$store->id)->update(['balance'=>$bal]);
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
                $createPayment = Cash::create([
                    'user_id'=>$store->id,
                    'invoice_id'=>$getInvoice->id,
                    'amount'=>$request->amount,
                    'date'=>$paymentDate,
                    'reason'=>'Internet Subscription',
                    'currentMonth'=>$currentMonth,
                    'currentYear' =>$currentYear,
                ]);
                $createPay = Payment::create([
                    'user_id'=>$store->id,
                    'invoice_id'=>$getInvoice->id,
                    'amount'=>$request->amount,
                    'date'=>$paymentDate,
                    'payment_method'=>'Cash',
                    'currentMonth'=>$currentMonth,
                ]);
                $updateBal = Invoice::where('user_id',$store->id)->update(['usage_time'=>10000]);
                $updateStatus = Invoice::where('user_id',$store->id)->update(['status'=>1]);
                $updateBalance = Invoice::where('user_id',$store->id)->update(['balance'=>$currentBalance]);
                $updatePaymentId = Invoice::where('user_id',$store->id)->update(['payment_id'=>$createPay->id]);
                $updateIBalance = Payment::where('invoice_id',$getInvoice->id)->where('id',$createPay->id)->update(['invoice_balance'=>$currentBalance]);
                $updateCashAmount = Invoice::where('user_id',$store->id)->update(['cash_id'=>$createPayment->id]);
                $updateCash = Invoice::where('user_id',$store->id)->update(['cash_amount'=>$request->amount]);
                $updateUserAmount = User::where('id',$store->id)->update(['amount'=>$request->amount]);
                $updateUserDate = User::where('id',$store->id)->update(['payment_date'=>$paymentDate]);
                $updateUserBalance = User::where('id',$store->id)->update(['balance'=>$currentBalance]);
            }
            else{
                $getInv = Invoice::where('user_id',$store->id)->where('status',0)->first();
                $currentBal = $getInv->balance - $request->amount;
                if ($currentBal>0){
                    $createPayment1 = Cash::create([
                        'user_id'=>$store->id,
                        'invoice_id'=>$getInvoice->id,
                        'amount'=>$request->amount,
                        'date'=>$paymentDate,
                        'reason'=>'Internet Subscription',
                        'currentMonth'=>$currentMonth,
                        'currentYear' =>$currentYear,
                    ]);
                    $createPay1 = Payment::create([
                        'user_id'=>$store->id,
                        'invoice_id'=>$getInv->id,
                        'amount'=>$request->amount,
                        'date'=>$paymentDate,
                        'payment_method'=>'Cash',
                        'currentMonth'=>$currentMonth,
                    ]);
                    $updateBalance = Invoice::where('id',$getInv->id)->update(['balance'=>$currentBal]);
                    $updateIBalance = Payment::where('invoice_id',$getInv->id)->where('id',$createPay1->id)->update(['invoice_balance'=>$currentBal]);
                    $updateCashAmount = Invoice::where('id',$getInv->id)->update(['payment_id'=>$createPay1->id]);
                    $updateCash = Invoice::where('id',$getInv->id)->update(['cash_amount'=>$request->amount]);
                    $updateUserA = User::where('id',$store->id)->update(['amount'=>$request->amount]);
                    $updateUserD = User::where('id',$store->id)->update(['payment_date'=>$paymentDate]);
                    $updateUserBal = User::where('id',$store->id)->update(['balance'=>$currentBal]);
                }
            }

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
                                    'host' => '192.168.88.1',
                                    'user' => 'admin',
                                    'pass' => 'password',
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
        $invoices  = Mpesa::whereBetween('created_at', array($start_date, $end_date))->get();
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
        return view('admin.mpesaReceipt',[
            'receipt'=>$receipt
        ]);
    }
    public function editUser($id){
        $user = User::find($id);
        return view('admin.editEmployee',[
            'user'=>$user
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
        $edit->phone = $request->phone;
        $edit->role = $request->role;
        $edit->products = $request->products;
        $edit->users = $request->users;
        $edit->customers = $request->customers;
        $edit->payments = $request->payments;
        $edit->expenses = $request->expenses;
        $edit->estimate = $request->estimates;
        $edit->invoice = $request->invoice;
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
        $date = $customer->payment_date;
        return view('admin.editCustomerDetail',[
            'customer'=>$customer,
            'date'=>$date
        ]);
    }
    public function activate(Request $request){
        $customer = User::find($request->user_id);
        $customer->role = 2;
        $customer->save();
        return redirect()->back()->with('success','Customer Activated');
    }
    public function editC(Request $request, $id){
        $edit = User::find($id);
        $bal = $edit->balance;
        $currentBal = $bal + $request->cBalance;
        $edit->first_name = $request->first_name;
        $edit->last_name = $request->bandwidth;
        $edit->email = $request->email;
        $edit->phone = $request->phone;
        $edit->phoneOne = $request->phoneOne;
        $edit->location = $request->location;
        $edit->package_amount = $request->package_amount;
        $edit->amount = $request->package_amount;
        $edit->payment_date = $request->payment_date;
        $edit->due_date = $request->due_date;
        $edit->balance = $currentBal;
        $edit->save();
        $getInvoiceId = Invoice::where('user_id',$id)->latest('id')->first();
        $paymentDate = Carbon::parse($request->payment_date);
        $currentMonth = date('m');
        if($request->payment_date){
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
            $dateFormat = Carbon::parse($request->due_date);
            $updateInvoiceDate = Invoice::where('user_id',$id)->latest('id')->update(['invoice_date'=>$dateFormat]);
            $dateForm = Carbon::parse($request->due_date);
            $twoDaysBefore = $dateForm->subDays(3);
            $updateInvoiceMessageDate = Invoice::where('user_id',$id)->latest('id')->update(['two_days_before'=>$twoDaysBefore]);
            $dateFor = Carbon::parse($request->due_date);
            $oneDayBefore = $dateFor->subDays(1);
            $updateInvoiceMDate = Invoice::where('user_id',$id)->latest('id')->update(['one_day_before'=>$oneDayBefore]);
            $updateInvoiceStatus = Invoice::where('user_id',$id)->latest('id')->update(['status'=>1]);
        }
        $dateFormat = Carbon::parse($request->due_date);
        $updateInvoiceDate = Invoice::where('user_id',$id)->latest('id')->update(['invoice_date'=>$dateFormat]);
        $getUser = User::find($id);
        if($getUser->payment_date!=null){
           

                    try {
                                // Get the MikroTik API client using the configured facade
                                $config = new Config([
                                'host' => '197.248.58.123',
                                'user' => 'admin',
                                'pass' => 'KND@2020',
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
                        Log::info('edit successfull but no connection to mikrotik');
                        return response()->json(['error' => 'Failed to disable PPPoE secret: ' . $e->getMessage()], 500);
                    }

        }
        return redirect(url('customers'))->with('success','CUSTOMER EDIT SUCCESS');
    }
    public function deleteUser(Request $request){
        $delete = User::find($request->userid);
        $delete->delete();
        return redirect(url('employees'))->with('success','USER DELETED SUCCESS');

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
        $deleteUser = User::where('id',$request->userid)->update(['package_amount'=>null]);
        $deleteInvoice = Invoice::where('user_id',$request->userid)->update(['statas',1]);
        return redirect(url('customers'))->with('success','CUSTOMER TERMINATED SUCCESS');

    }

}
