@include('adminPartial.nav')
<title>Group Sms | Henix</title>
<!------ Include the above in your HEAD tag ---------->

        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3 id="titleAll">Group Sms</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li id="smallTitleAll">Group Sms</li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                    
                        @include('flash-message')
                    
                    </div>

                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Add Message</h3>
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
                        <form class="new-added-form" action="{{url('sendSingleSms')}}" method="post">
                            @csrf
                            <div class="row">
                    
                                <div class="col-lg-6 col-12 form-group">
                                    <textarea class="textarea form-control" name="message" id="form-message" cols="10" rows="9"></textarea>
                                </div>
                              
                                <div class="col-12 form-group mg-t-8">
                                       <button type="button" class="modal-trigger" data-toggle="modal"
                                    data-target="#standard-modal">
                                    Send
                                </button>
                                <!-- Modal -->
                                    <div class="modal fade" id="standard-modal" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Send SMS to Selected users</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure!
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="footer-btn bg-dark-low"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="footer-btn bg-linkedin">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    <h3 id="titleAll">Selected Users to send Message ({{App\Models\Singlesms::count()}})</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                 <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="myTable">
                                @foreach($customers as $customer)
                                <tr>
                                <td>{{$customer->user->first_name}} {{$customer->user->last_name}}</td>
                                <td>{{$customer->user->email}}</td>
                                <td>{{$customer->user->phoneOne}}</td>
                                @if($customer->user->role==0)
                                <td>Admin</td>
                                @endif
                                @if($customer->user->role==5)
                                <td>Technician</td>
                                @endif
                                @if($customer->user->role==6)
                                <td>Sales</td>
                                @endif
                                @if($customer->user->role==7)
                                <td>Finance</td>
                                @endif
                                @if($customer->user->role==8)
                                <td>Technician</td>
                                @endif
                               
                                <td>
                                    <a href="{{url('removeUser',$customer->id)}}"><button class="btn btn-danger">Remove</button></a>
                                    
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <br>
                 
                        <div class="row-fluid" id="customerAll">
                        <div class="col-lg-12 col-12 form-group">
                            <label>Search</label>
                            <input type="text" placeholder="Search" class="form-control" id="myInput">
                        </div>
                        <h3 id="titleAll">Users</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                 <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="myTable">
                                @foreach($users as $user)
                                <tr>
                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phoneOne}}</td>
                                @if($user->role==0)
                                <td>Admin</td>
                                @endif
                                @if($user->role==5)
                                <td>Technician</td>
                                @endif
                                @if($user->role==6)
                                <td>Sales</td>
                                @endif
                                @if($user->role==7)
                                <td>Finance</td>
                                @endif
                                @if($user->role==8)
                                <td>Technician</td>
                                @endif
                               
                                <td>
                                    <a href="{{url('selectUser',$user->id)}}"><button class="btn btn-info">Select</button></a>
                                    
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <!-- Student Table Area End Here -->
           <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Henix</a> 2026. All rights reserved. Designed by <a
                        href="#">Henix Technologies</a></div>
            </footer>
        </div>
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
            <form action="{{url('deleteC')}}" method="post" id="deleteCustomers">
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
<style>
    .select2-container .select2-selection--single{
        height:34px !important;
    }
    .select2-container--default .select2-selection--single{
        border: 1px solid #ccc !important;
        border-radius: 0px !important;
    }

</style>
<!-- jquery-->
<script src="js/jquery-3.3.1.min.js"></script>
<!-- Plugins js -->
<script src="js/plugins.js"></script>
<!-- Popper js -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Scroll Up Js -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- Data Table Js -->
<script src="js/jquery.dataTables.min.js"></script>
<!-- Custom Js -->
<script src="js/main.js"></script>
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
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


</script>
<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/all-student.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:35:18 GMT -->
</html>
