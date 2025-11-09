@include('adminPartial.nav')
<title>Employee List | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Employee</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>All Employee</li>
                </ul>
            </div>
            @include('flash-message')
            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Employee Data</h3>
                        </div>
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
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by location ..." class="form-control">
                            </div>
                            <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Name ..." class="form-control">
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
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
                            <tbody>
                            @foreach($customers as $customer)
                            <tr>

                                <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->phone}}</td>
                                @if($customer->role==0)
                                <td>Admin</td>
                                @else
                                    <td>User</td>
                                @endif
                                <td><a href="{{url('editUser',$customer->id)}}"><button class="btn btn-info">Edit</button></a>
                                    <button type="button" class="btn btn-danger view" id="{{$customer->id}}" data-toggle="modal" data-target="#west">Delete</button>
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
                <div class="copyright">© Copyrights <a href="#">akkhor</a> 2019. All rights reserved. Designed by <a
                        href="#">PsdBosS</a></div>
            </footer>
        </div>
    </div>
    <!-- Page Area End Here -->
</div>
<!-- Modal -->
<div class="modal fade" id="updateDueDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Due Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 col-12 form-group">
                        <div class="form-group" id="basic">
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateTimeButton">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="west" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ARE YOU SURE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('deleteUser')}}" method="post">
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
        url:"{{url('del')}}",
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

$(document).on('click','.view',function () {
        $value = $(this).attr('id');
        var date1 = new Date();
        var date2 = new Date($('#update_due_date').val());
        var datediff = date2 - date1;
        var days  = datediff/1000/60/60/24;
        rounded_date = Math.ceil(days);
        date2.setDate(date2.getDate());
        var dd = String(date2.getDate()).padStart(2, '0');
        var mm = String(date2.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = date2.getFullYear();
        due_date = mm + '/' + dd + '/' + yyyy;
        $.ajax({
            type:"get",
            url:"{{url('dueDate')}}",
            data:{'id':$value},
            success:function (data) {
                $('#basic').html(data);
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
    $('#updateTimeButton').on('click',function () {
        $value = $('#customer_id').val();
        var date1 = new Date();
        var date2 = new Date($('#update_due_date').val());
        var datediff = date2 - date1;
        var days  = datediff/1000/60/60/24;
        rounded_date = Math.ceil(days);
        date2.setDate(date2.getDate());
        var dd = String(date2.getDate()).padStart(2, '0');
        var mm = String(date2.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = date2.getFullYear();
        due_date = mm + '/' + dd + '/' + yyyy;
        $.ajax({
            type:"get",
            url:"{{url('updateDueDate')}}",
            data:{'id':$value,'due_date':due_date,'time_difference':rounded_date},
            success:function (data) {
             alert('Due Date Updated Success');
             $('#updateDueDate').modal('hide');
             location.reload();
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });

</script>
<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/all-student.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:35:18 GMT -->
</html>
