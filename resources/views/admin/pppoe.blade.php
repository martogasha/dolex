@include('adminPartial.nav')
<title>Pppoe List | Dolex</title>
<!------ Include the above in your HEAD tag ---------->

        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Customers</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Pppoe</li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Pppoe Data</h3>
                        </div>
                        @include('flash-message')
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                               aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-lg-12 col-12 form-group">
                            <label>Search</label>
                            <input type="text" placeholder="Search" class="form-control" id="myInput">
                        </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>Balance</th>
                                <th>Name</th>
                                <th>Address & A/c</th>
                                <th>Package</th>
                                <th>Amount</th>
                                <th>Phone No:</th>
                                <th>Due Date</th>
                                <th>Phone</th>
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach($customers as $customer)
                            <tr>
                                @if($customer->balance>0 && $customer->balance<$customer->package_amount)
                                    <td class="badge badge-pill badge-warning d-block mg-t-8">Pending</td>
                                @elseif($customer->package_amount==null)
                                    <td class="badge badge-pill badge-danger d-block mg-t-8">Terminated</td>

                                @else
                                    @if($customer->balance<=0)
                                        <td class="badge badge-pill badge-success d-block mg-t-8">Paid</td>
                                    @else
                                        @if($customer->package_amount<=$customer->balance)
                                            <td class="badge badge-pill badge-danger d-block mg-t-8">UnPaid</td>
                                        @endif
                                    @endif

                                @endif
                                    @if($customer->package_amount==null)
                                        <td><b style="color: red">TERMINATED</b></td>

                                    @elseif($customer->balance<=0)
                                        <td><b style="color: green">Ksh: {{$customer->balance}}</b></td>

                                    @else
                                    <td><b style="color: red">Ksh: {{$customer->balance}}</b></td>

                                @endif
                                <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                                <td>{{$customer->location}}(<b style="color: green">{{$customer->phone}}</b>)</td>
                                <td>{{$customer->bandwidth}} Mbps</td>
                                    @if($customer->amount!=0)
                                <td>Ksh: {{$customer->amount}}</td>
                                    @else
                                        <td><span class="badge badge-danger">Not Paid</span></td>

                                    @endif
                                <td><span class="badge badge-success">{{$customer->phoneOne}}</span></td>
                                    @if($customer->due_date==0)
                                        <td><span class="badge badge-danger">Not Paid</span>
                                        </td>
                                    @else
                                        <td>{{$customer->due_date}}</td>
                                    @endif
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{url('customerDetail',$customer->id)}}"><i
                                                    class="fas fa-book-open text-orange-red"></i>View</a>
                                            <a class="dropdown-item" href="{{url('editCustomerDetail',$customer->id)}}"><i
                                                    class="fas fa-edit text-blue"></i>Edit</a>
                                            <button type="button" class="btn btn-danger btn-lg btn-block view" id="{{$customer->id}}" data-toggle="modal" data-target="#west">Terminate</button>

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
