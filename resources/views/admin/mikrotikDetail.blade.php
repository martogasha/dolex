@include('adminPartial.nav')
<title>{{$mikrotik->name}} | Henix</title>
            <!-- Sidebar Area End Here -->
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>{{$mikrotik->name}} Dashboard</h3>
                    <ul>
                        <li>
                            <a href="{{url('admin')}}">Home</a>
                        </li>
                        <li>{{$mikrotik->name}}</li>
                    </ul>
                </div>
                @include('flash-message')
                <!-- Breadcubs Area End Here -->
                <div class="row">
                    <!-- Dashboard summery Start Here -->
                    <div class="col-12 col-4-xxxl">
                        <div class="row">
                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-magenta">
                                        <i class="flaticon-classmates text-magenta"></i>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-number"><span class="counter" data-num="35000">{{App\Models\User::where('mik_id',$mikrotik->id)->count()}}</span></div>
                                        <div class="item-title">Total Customers</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-blue">
                                        <i class="flaticon-shopping-list text-blue"></i>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-number"><span class="counter" data-num="{{App\Models\User::where('role',4)->where('mik_id',$mikrotik->id)->count()}}">{{App\Models\User::where('role',4)->where('mik_id',$mikrotik->id)->count()}}</span></div>
                                        <div class="item-title">Non Active Clients</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-yellow">
                                        <i class="flaticon-classmates text-magenta"></i>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-number"><span class="counter" data-num="{{App\Models\User::where('dis_status', 'true')->where('mik_id',$mikrotik->id)->count()}}" style="color:red;">{{App\Models\User::where('dis_status', 'true')->where('mik_id',$mikrotik->id)->count()}}</span></div>
                                        <div class="item-title">Disconnected Customers</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-red">
                                        <i class="flaticon-classmates text-magenta"></i>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-number"><span class="counter" data-num="{{App\Models\User::where('dis_status', 'false')->where('mik_id',$mikrotik->id)->count()}}">{{App\Models\User::where('dis_status', 'false')->where('mik_id',$mikrotik->id)->count()}}</span></div>
                                        <div class="item-title">Active Customers</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-4-xxxl">
                        <div class="row">

                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-blue">
                                        <i class="flaticon-shopping-list text-blue"></i>
                                    </div>
                                    <div class="item-content">
                                        <button type="button" id="buttonFromMikrotik" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-dodger-blue">Mikrotik to System</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-magenta">
                                        <i class="flaticon-classmates text-magenta"></i>
                                    </div>
                                    <div class="item-content">
                                        <button type="button" id="buttonAddCustomer" class="btn-fill-lmd radius-30 text-light shadow-dark-pastel-green bg-dark-pastel-green">Add Customer</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-yellow">
                                        <i class="flaticon-classmates text-magenta"></i>
                                    </div>
                                    <div class="item-content">
                                    <button type="button"id="buttonDisconnected" class="btn-fill-lmd radius-30 text-light shadow-red bg-red">Disconnected</button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                                <div class="dashboard-summery-two">
                                    <div class="item-icon bg-light-red">
                                        <i class="flaticon-classmates text-magenta"></i>
                                    </div>
                                    <div class="item-content">
                                        <button type="button" id="buttonActive" class="btn-fill-xl radius-30 text-light shadow-light-sea-green bg-light-sea-green">Active</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dashboard summery End Here -->
                    <!-- Students Chart End Here -->
                 
                    <!-- Students Chart End Here -->
                    <!-- Notice Board Start Here -->
                    <div class="col-lg-6 col-4-xxxl col-xl-6">
                        <div class="card dashboard-card-six">
                            <div class="card-body">
                                <div class="heading-layout1 mg-b-17">
                                    <div class="item-title">
                                        <h3>Notifications</h3>
                                    </div>
                                   <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" 
                                        data-toggle="dropdown" aria-expanded="false">...</a>
                
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="notice-box-wrap">
                                    <div class="notice-list">
                                        <div class="post-date bg-skyblue">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag mene esom tus eleifend lectus
                                            sed maximus mi faucibusnting.</a></h6>
                                        <div class="entry-meta">  Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-yellow">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag printing.</a></h6>
                                        <div class="entry-meta">  Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-pink">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag Nulla rhoncus eleifensed mim
                                            us mi faucibus id. Mauris vestibulum non purus lobortismenearea</a></h6>
                                        <div class="entry-meta">  Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-skyblue">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag mene esom  text of the printing.</a></h6>
                                        <div class="entry-meta">  Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-yellow">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag printing.</a></h6>
                                        <div class="entry-meta">  Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-pink">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag meneesom.</a></h6>
                                        <div class="entry-meta">  Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Notice Board End Here -->
                </div>
                <!-- Student Table Area Start Here -->
                <div class="row" id="fromMikrotik">
                    <div class="col-lg-12">
                        
                        <div class="card dashboard-card-eleven">
                            <div class="card-body">
                                  <div class="item-title">
                                        <h3><b>From Mikrotik to System</b></h3>
                                    </div>
                                @include('flash-message')
                                <div class="heading-layout1">
                                    <div class="col-12 form-group mg-t-8">
                                        <form action="{{url('storePppoe')}}">
                                            @csrf
                                            <input type="hidden" value="{{$mikrotik->id}}" name="mikrotik_id">
                                            <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Update</button>
                                        </form>
                                    </div>                   
                                </div>
                      
                                <div class="table-box-wrap">
                                
                        <div class="row-fluid" id="customerSelect">
                        <div class="col-lg-12 col-12 form-group">
                            <label>Search</label>
                            <input type="text" placeholder="Search" class="form-control" id="myInput">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                   
                                    <th></th>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    <th>Package</th>
                                    <th>Connection</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="myTableOne">
                                    @foreach($customers as $customer)
                                    <tr>
                                         @if($customer->role==3)
                                        <td><span class="badge badge-warning">Not Active</span></td> 
                                        @else
                                        <td><span class="badge badge-success">Active</span></td>
                                        @endif  
                                        <td>{{$customer->first_name}}</td>
                                        <td>{{$customer->location}}</td>
                                        <td>{{$customer->last_name}}</td>
                                        @if($customer->dis_status=='true')
                                        <td><span class="badge badge-danger">Disconnected</span></td> 
                                        @else
                                        <td><span class="badge badge-success">Active</span></td>
                                        @endif   
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                        <span class="flaticon-more-button-of-three-dots"></span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($customer->role==3)
                                                        <form action="{{url('activate')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{$customer->id}}" name="user_id">
                                                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Activate</button>
                                                        </form>
                                                        @else
                                                        <button class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Activated</button>
                                                        @endif
                                                        <br>
                                                          @if($customer->role==3)
                                                        <form action="{{url('noneActive')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{$customer->id}}" name="user_id">
                                                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Deactivate</button>
                                                        </form>
                                                        @else
                                                        <button class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Deactivated</button>
                                                        @endif  

                                                    </div>
                                                </div>
                                             </td>
                                             
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="active">
                    <div class="col-lg-12">
                        <div class="card dashboard-card-eleven">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Active Customers</h3>
                                    </div>
                                   <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" 
                                        data-toggle="dropdown" aria-expanded="false">...</a>
                
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-box-wrap">
                                
                        <div class="row-fluid" id="customerActive">
                        <div class="col-lg-12 col-12 form-group">
                            <label>Search</label>
                            <input type="text" placeholder="Search" class="form-control" id="myInputActive">
                        </div>
                                    <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Connection</th>
                                    <th>Balance</th>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    <th>A/c</th>
                                    
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Phone No:</th>
                                    <th>Due Date</th>
                                   
                                    <th>Msg Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="myTableActive">
                                @foreach($actives as $active)
                                <tr>
                                        @if($active->dis_status=='true')
                                            <td><span class="badge badge-danger">Disconnected</span></td> 
                                            @else
                                            <td><span class="badge badge-success">Active</span></td>
                                        @endif  
                                        
                                        @if($active->role==50)
                                        <td><span class="badge badge-warning">Sub-Account</span></td>
                                        @else
                                            @if($active->package_amount==null)
                                                <td><b style="color: red">TERMINATED</b></td>

                                            @elseif($active->balance<=0)
                                                <td><b style="color: green">Ksh: {{$active->balance}}</b></td>

                                            @else
                                            <td><b style="color: red">Ksh: {{$active->balance}}</b></td>

                                            @endif
                                        @endif
                                    @if(\App\Models\Duplicate::where('duplicate_id', $active->id)->doesntExist())
                                    <td>{{$active->first_name}}</td>

                                    @else
                                    <td>{{$active->first_name}} Sub A/c's <span class="badge badge-warning">{{\App\Models\Duplicate::where('duplicate_id', $active->id)->count()}}</span></td>

                                    @endif
                                    <td>{{$active->location}}</td>
                                    <td>{{$active->phone}}</td>
                                    
                                    <td>{{$active->last_name}}</td>
                                    @if($active->role==50)
                                        <td><span class="badge badge-warning">Sub-Account</span></td>
                                        @else
                                            @if($active->amount!=0)
                                                <td>Ksh: {{$active->amount}}</td>
                                            @else
                                                <td><span class="badge badge-danger">Not Paid</span></td>

                                            @endif
                                        @endif
                                    <td><span class="badge badge-success">{{$active->phoneOne}}</span></td>

                                    @if(\App\Models\Duplicate::where('user_id', $active->id)->exists())
                                    <td colspan="2" style="text-align:center;"><span class="badge badge-warning">Sub-Account of {{\App\Models\User::where('id', \App\Models\Duplicate::where('user_id', $active->id)->value('duplicate_id'))->value('first_name')}} {{\App\Models\User::where('id', \App\Models\Duplicate::where('user_id', $active->id)->value('duplicate_id'))->value('phone')}}</span></td>
                                    @else
                                            @if($active->due_date==0)
                                                <td><span class="badge badge-danger">Not Paid</span>
                                                </td>
                                            @else   
                                                <td>{{date('d/m/Y H:i:s',strtotime($active->due_date))}}</td>
                                            @endif
                                            @if(App\Models\Invoice::where('user_id',$active->id)->latest('id')->value('status')==0)
                                            <td><span class="badge badge-danger">Disconnected</span></td>
                                            @else
                                            
                                                @if(App\Models\Invoice::where('user_id',$active->id)->latest('id')->value('due_date_status')===null)
                                                <td>{{date('d/m/Y H:i:s',strtotime(App\Models\Invoice::where('user_id',$active->id)->latest('id')->value('one_day_before')))}}</td>
                                                @elseif(App\Models\Invoice::where('user_id',$active->id)->latest('id')->value('due_date_status')==0)
                                                <td><span class="badge badge-info">Msg Sent</span></td></td>
                                                @else
                                                <td><span class="badge badge-success">Paid</span></td></td>
                                                @endif
                                            @endif
                                        @endif
                                    <td>
                                        
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                                <span class="flaticon-more-button-of-three-dots"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{url('customerDetail',$active->id)}}"><i
                                                        class="fas fa-book-open text-orange-red"></i>View</a>
                                                <a class="dropdown-item" href="{{url('editCustomerDetail',$active->id)}}"><i
                                                        class="fas fa-edit text-blue"></i>Edit</a>
                                                <form action="{{url('noneActive')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{$active->id}}" name="user_id">
                                                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Deactivate</button>
                                                        </form>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        </div>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                   <div class="row" id="disconnected">
                    <div class="col-lg-12">
                        <div class="card dashboard-card-eleven">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Disconnected Customers</h3>
                                    </div>
                                   <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" 
                                        data-toggle="dropdown" aria-expanded="false">...</a>
                
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                        </div>
                                    </div>
                                </div>
                            <div class="table-box-wrap">
                                
                        <div class="row-fluid" id="customerDisconnected">
                        <div class="col-lg-12 col-12 form-group">
                            <label>Search</label>
                            <input type="text" placeholder="Search" class="form-control" id="myInputDisconnected">
                        </div>
                               <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Connection</th>
                                    <th>Balance</th>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    <th>A/c</th>
                                    
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Phone No:</th>
                                    <th>Due Date</th>
                                   
                                    <th>Msg Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="myTableDisconnected">
                                @foreach($disconnects as $disconnect)
                                <tr>
                                        @if($disconnect->dis_status=='true')
                                            <td><span class="badge badge-danger">Disconnected</span></td> 
                                            @else
                                            <td><span class="badge badge-success">Active</span></td>
                                        @endif  
                                        
                                        @if($disconnect->role==50)
                                        <td><span class="badge badge-warning">Sub-Account</span></td>
                                        @else
                                            @if($disconnect->package_amount==null)
                                                <td><b style="color: red">TERMINATED</b></td>

                                            @elseif($disconnect->balance<=0)
                                                <td><b style="color: green">Ksh: {{$disconnect->balance}}</b></td>

                                            @else
                                            <td><b style="color: red">Ksh: {{$disconnect->balance}}</b></td>

                                            @endif
                                        @endif
                                    @if(\App\Models\Duplicate::where('duplicate_id', $disconnect->id)->doesntExist())
                                    <td>{{$disconnect->first_name}}</td>

                                    @else
                                    <td>{{$disconnect->first_name}} Sub A/c's <span class="badge badge-warning">{{\App\Models\Duplicate::where('duplicate_id', $disconnect->id)->count()}}</span></td>

                                    @endif
                                    <td>{{$disconnect->location}}</td>
                                    <td>{{$disconnect->phone}}</td>
                                    
                                    <td>{{$disconnect->last_name}}</td>
                                    @if($disconnect->role==50)
                                        <td><span class="badge badge-warning">Sub-Account</span></td>
                                        @else
                                            @if($disconnect->amount!=0)
                                                <td>Ksh: {{$disconnect->amount}}</td>
                                            @else
                                                <td><span class="badge badge-danger">Not Paid</span></td>

                                            @endif
                                        @endif
                                    <td><span class="badge badge-success">{{$disconnect->phoneOne}}</span></td>

                                    @if(\App\Models\Duplicate::where('user_id', $disconnect->id)->exists())
                                    <td colspan="2" style="text-align:center;"><span class="badge badge-warning">Sub-Account of {{\App\Models\User::where('id', \App\Models\Duplicate::where('user_id', $disconnect->id)->value('duplicate_id'))->value('first_name')}} {{\App\Models\User::where('id', \App\Models\Duplicate::where('user_id', $disconnect->id)->value('duplicate_id'))->value('phone')}}</span></td>
                                    @else
                                            @if($disconnect->due_date==0)
                                                <td><span class="badge badge-danger">Not Paid</span>
                                                </td>
                                            @else   
                                                <td>{{date('d/m/Y H:i:s',strtotime($disconnect->due_date))}}</td>
                                            @endif
                                            @if(App\Models\Invoice::where('user_id',$disconnect->id)->latest('id')->value('status')==0)
                                            <td><span class="badge badge-danger">Disconnected</span></td>
                                            @else
                                            
                                                @if(App\Models\Invoice::where('user_id',$disconnect->id)->latest('id')->value('due_date_status')===null)
                                                <td>{{date('d/m/Y H:i:s',strtotime(App\Models\Invoice::where('user_id',$disconnect->id)->latest('id')->value('one_day_before')))}}</td>
                                                @elseif(App\Models\Invoice::where('user_id',$disconnect->id)->latest('id')->value('due_date_status')==0)
                                                <td><span class="badge badge-info">Msg Sent</span></td></td>
                                                @else
                                                <td><span class="badge badge-success">Paid</span></td></td>
                                                @endif
                                            @endif
                                        @endif
                                    <td>
                                        
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                                <span class="flaticon-more-button-of-three-dots"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{url('customerDetail',$disconnect->id)}}"><i
                                                        class="fas fa-book-open text-orange-red"></i>View</a>
                                                <a class="dropdown-item" href="{{url('editCustomerDetail',$disconnect->id)}}"><i
                                                        class="fas fa-edit text-blue"></i>Edit</a>
                                                <form action="{{url('noneActive')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{$disconnect->id}}" name="user_id">
                                                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Deactivate</button>
                                                        </form>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        </div>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card height-auto" id="addCustomer">

                <div class="card-body">
                    <h3><b>Add New Customer</b></h3>
                    <div class="heading-layout1">
                        <div class="item-title">
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>

                    <form action="{{url('storeCustomer')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$mikrotik->id}}" name="mikrotik_id">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label> Name *</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                           <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Comment</label>
                                <input type="text" class="form-control" name="comment" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Account No:</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Phone No:</label>
                                <input type="text" class="form-control" name="phoneOne" required>
                            </div>
                           
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package *</label>
                                <input type="text" class="form-control" name="bandwidth"/>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package Amount *</label>
                                <input type="text" class="form-control" name="package_amount" required/>

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Current Balance *</label>
                                <input type="text" class="form-control" disabled/>

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Add Balance *</label>
                                <input type="text" class="form-control" name="cBalance" placeholder="Ksh"/>

                            </div>
                              <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Payment Date *</label>
                                    <input type="date" class="form-control" name="payment_date"/>
                                </div>
                            </div>
                    
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Due Date *</label>
                                    <input type="date" class="form-control" name="due_date"/>
                                </div>
                            </div>
                 
                        
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                            </div>
                            
                        </div>
                    </form>
                    
                </div>
                
            </div>
                <!-- Student Table Area End Here -->
                    <footer class="footer-wrap-layout1">
                         <div class="copyright">© Copyrights <a href="#">Henix</a> 2026. All rights reserved. Designed by <a
                        href="#">Henix Technologies</a></div>
                    </footer>
                
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>


<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<!-- Plugins js -->
<script src="{{asset('js/plugins.js')}}"></script>
<!-- Popper js -->
<script src="{{asset('js/popper.min.js')}}"></script>
<!-- Bootstrap js -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Select 2 Js -->
<script src="{{asset('js/select2.min.js')}}"></script>
<!-- Date Picker Js -->
<script src="{{asset('js/datepicker.min.js')}}"></script>
<!-- Smoothscroll Js -->
<script src="{{asset('js/jquery.smoothscroll.min.html')}}"></script>
<!-- Scroll Up Js -->
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('js/main.js')}}"></script>

</body>
<script>
    $(document).on('click','.view',function () {
        $value = $(this).attr('id');
        $.ajax({
            type:"get",
            url:"{{url('delC')}}",
            data:{'id':$value},
            success:function (data) {
                $('#del').html(data);
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
    $(document).ready(function(){
        $("#fromMikrotik").hide();
        $("#disconnected").hide();
        $("#addCustomer").hide();
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableOne tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
           $("#myInputActive").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableActive tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
          $("#myInputDisconnected").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableDisconnected tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
 
 $("#buttonFromMikrotik").on("click", function() {
        $("#active").hide();
        $("#disconnected").hide();
        $("#fromMikrotik").show();
        $("#addCustomer").hide();

});
 $("#buttonActive").on("click", function() {
        $("#active").show();
        $("#fromMikrotik").hide();
        $("#disconnected").hide();
        $("#addCustomer").hide();


});
$("#buttonDisconnected").on("click", function() {
        $("#active").hide();
        $("#fromMikrotik").hide();
        $("#addCustomer").hide();
        $("#disconnected").show();

});
$("#buttonAddCustomer").on("click", function() {
        $("#active").hide();
        $("#fromMikrotik").hide();
        $("#disconnected").hide();
        $("#addCustomer").show();

});
</script>

<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/index5.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 20 Mar 2026 08:17:51 GMT -->
</html>