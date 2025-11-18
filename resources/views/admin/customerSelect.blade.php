@include('adminPartial.nav')
<title>Customer Select List | Japcom</title>
<!------ Include the above in your HEAD tag ---------->

        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3 id="titleSelect">Select Customers</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li id="smallTitleSelect">Select Customers ({{App\Models\User::where('role',3)->count()}})</li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                        @include('flash-message')
                    <div class="heading-layout1">
                        <div class="col-12 form-group mg-t-8">
                            <form action="{{url('storePppoe')}}">
                                @csrf
                                <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Update</button>
                            </form>
                            </div>                   
                    </div>
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
                                <tbody id="myTable">
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
            <!-- Student Table Area End Here -->
            <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Dolex</a> 2023. All rights reserved. Designed by <a
                        href="#">Dolex Technologies</a></div>
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
