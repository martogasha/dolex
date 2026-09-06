@include('adminPartial.nav')
<title>{{$customer->first_name}} | Henix</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Edit <b style="color: red">{{$customer->first_name}}</b> 
                @if(\App\Models\Duplicate::where('user_id', $customer->id)->exists())
                Sub-Account of <span style="color:blue;">{{\App\Models\User::where('id', \App\Models\Duplicate::where('user_id', $customer->id)->value('duplicate_id'))->value('first_name')}} {{\App\Models\User::where('id', \App\Models\Duplicate::where('user_id', $customer->id)->value('duplicate_id'))->value('phone')}}</span>
                @endif
                </h3>
                <form action="{{url('disableC',$customer->mikrotik_id)}}">
                        @csrf
                @if($customer->dis_status != 'true')
                <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Disable</button>
                @else
                <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Enable</button>
                @endif
                </form>
                
                

                <ul>
                   <br>
                </ul>
                @if(\App\Models\Duplicate::where('user_id', $customer->id)->exists())
                @else
                            <form action="{{url('prompt',$customer->id)}}">
                                    @csrf
                                <button type="submit" class="btn-fill-lg bg-success btn-hover-yellow">Prompt</button>
                        
                            </form>
                        <br>
                            <div id="subDiv">
                                <button id="subButton" class="btn-fill-lg bg-warning btn-hover-yellow">Add Sub-accounts</button>

                            </div>

                        <br>
                        <form action="{{url('subAccount',$customer->id)}}" method="post">
                                @csrf
                                <input type="hidden" name="sub_id" value="{{$customer->id}}">
                                <div class="col-xl-3 col-lg-6 col-12 form-group" id="subaccount">
                                            <div class="form-group">
                                                <label>Select Account</label>
                                                <select class="form-control select2" name="user_id">
                                                    @foreach($clients as $client)
                                                    <option value="{{$client->id}}">{{$client->first_name}} {{$client->phone}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                    <button type="submit" class="btn-fill-lg bg-warning btn-hover-yellow">Save Sub-accounts</button>

                                    </div>
                    
                        </form>
                @endif

                   
            </div>

            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Edit <b style="color: red">{{$customer->first_name}} <span style="color:blue;">{{$customer->phone}}</span></b></h3>
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
                    <form action="{{url('editC',$customer->id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label> Name *</label>
                                <input type="text" value="{{$customer->first_name}}" class="form-control" name="first_name">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label> Password: <b>{{$password}}</b></label>
                                <input type="text" class="form-control" name="password">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Account No: <b>{{$customer->phone}}</b></label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                            @if(\App\Models\Duplicate::where('user_id', $customer->id)->exists())
                            @else
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Phone No:</label>
                                    <input type="text" value="{{$customer->phoneOne}}" class="form-control" name="phoneOne" required>
                                </div>
                            @endif
                           
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package *</label>
                                <input type="text" value="{{$customer->last_name}}" class="form-control" name="bandwidth"/>
                            </div>
                          
                            @if(\App\Models\Duplicate::where('user_id', $customer->id)->exists())
                            @else
                              <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package Amount *</label>
                                <input type="text" value="{{$customer->package_amount}}" class="form-control" name="package_amount" required/>

                            </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Current Balance *</label>
                                    <input type="text" value="{{$customer->balance}}" class="form-control" disabled/>

                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Add Balance *</label>
                                    <input type="text" class="form-control" name="cBalance" placeholder="Ksh"/>

                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <div class="form-group">
                                        <label for="dob">Payment Date *</label>
                                        <input type="date" value="{{ old('payment_date', $customer->payment_date ? \Carbon\Carbon::parse($customer->payment_date)->format('Y-m-d') : '') }}" class="form-control" name="payment_date"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <div class="form-group">
                                        <label for="dob">Due Date *</label>
                                        <input type="date" value="{{ old('due_date', $customer->due_date ? \Carbon\Carbon::parse($customer->due_date)->format('Y-m-d') : '') }}" class="form-control" name="due_date"/>
                                    </div>
                                </div>
                                  <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <div class="form-group">
                                    <label>Comment *</label>
                                        <input type="text" value="{{$customer->location}}" class="form-control" name="comment"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <div class="form-group">
                                        <label for="dob">1Day MSG *</label>
                                        <input type="date" value="" class="form-control" name="one_day_before"/>
                                    </div>
                                </div>
                            @endif
                        
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" id="addCustomer">Save</button>
                            </div>
                            
                        </div>
                    </form>
                    <br>
                    @if(\App\Models\Duplicate::where('user_id', $customer->id)->exists())
                    @else
                        <div class="row-fluid" id="customerAll">
                            <div class="col-lg-12 col-12 form-group">
                                <h3><b>Sub Accounts</b></h3>
                                <input type="text" placeholder="Search" class="form-control" id="myInput">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Connection</th>
                                        <th>Name</th>
                                        <th>A/c</th>
                                        
                                        <th>Package</th>
                                    
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="myTable">
                                    @foreach($custs as $cust)
                                    <tr>
                                            @if($cust->user->dis_status=='true')
                                                <td><span class="badge badge-danger">Disconnected</span></td> 
                                                @else
                                                <td><span class="badge badge-success">Active</span></td>
                                            @endif  

                                    
                                        
                                        <td>{{$cust->user->first_name}}</td>
                                        <td>{{$cust->user->phone}}</td>
                                        
                                        <td>{{$cust->user->last_name}}</td>
                                        
                                        <td>
                                            
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{url('editCustomerDetail',$cust->user_id)}}"><i
                                                            class="fas fa-edit text-blue"></i>Edit</a>
                                                    <div class="col-12 form-group mg-t-8">
                                                            <button type="button" class="btn-fill-xl text-light bg-red view" data-toggle="modal"
                                                            data-target="#west" id="{{$cust->id}}">
                                                            Remove
                                                        </button>
                                                    </div>
                                                

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                                            </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                
                    
                </div>

                    
            </div>
            <!-- Add New Teacher Area End Here -->
            <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Henix</a> 2026. All rights reserved. Designed by <a
                        href="#">Henix Technologies</a></div>
            </footer>
        </div>
    </div>
    <!-- Page Area End Here -->
</div>
<div class="modal fade" id="west" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ARE YOU SURE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('deleteDuplicate')}}" method="post" id="deleteCustomers">
                @csrf
                <div id="del">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- jquery-->
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

<script>
$(document).ready(function() {
    $("#subaccount").hide();
});
$("#subButton").click(function(){
  $("#subaccount").show();
  $("#subDiv").hide();
});
    $(document).on('click','.view',function () {
        $value = $(this).attr('id');
        $.ajax({
            type:"get",
            url:"{{url('delDuplicate')}}",
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
    </script>
</body>
<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/add-teacher.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:36:38 GMT -->
</html>
