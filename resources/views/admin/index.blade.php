@include('adminPartial.nav')
<title>Admin | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Admin Dashboard</h3>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>Admin</li>
                </ul>
            </div>
            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Dashboard summery Start Here -->
            @if(is_null($notice))
            <div class="row gutters-20">
                <h5>Published at:</h5>
                <div class="col-xl-12 col-sm-12 col-12">
                    <div class="dashboard-summery-one mg-b-20">
                        <div class="row align-items-center">
                            @if(\Illuminate\Support\Facades\Auth::user()->role==0)
                            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add Notice</button>
                            @endif
                                <div class="col-6" id="pot">
                                <h4 style="color: red"><b>Notice Board</b></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="row gutters-20">
                    <h5>Published at:<b>{{$notice->date}}</b></h5>
                    <div class="col-xl-12 col-sm-12 col-12">
                        @if(\Illuminate\Support\Facades\Auth::user()->role==0)
                            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add Notice</button>
                            <form action="{{url('deleteNotice',$notice->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove Notice</button>
                            </form>
                        @endif
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6" id="pot">
                                    <h4 style="color: red"><b>{{$notice->message}}</b></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Post Notice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('notice')}}" method="post">
                            @csrf
                        <div class="modal-body">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="message-text" name="message"></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send Notice</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <style>
                #pot {
                    bottom: 15%;
                    position: absolute;
                    -webkit-animation: linear infinite;
                    -webkit-animation-name: run;
                    -webkit-animation-duration: 20s;
                }
                @-webkit-keyframes run {
                    0% {
                        left: 0;
                    }
                    50% {
                        left: 100%;
                    }
                    100% {
                        left: 0;
                    }
                }
            </style>
            <div class="dropdown">
                <div id="hideMonth"><h3><b>{{\Carbon\Carbon::now()->format('F')}} - {{\Carbon\Carbon::now()->format('Y')}}</b> Net Income</h3></div>
                <div id="showMonth"></div>
                <div class="row" style="padding-left:200px">
                    <div class="form-group">
                        <label for="sel1">Year</label>
                        <select class="form-control" id="year">
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Month</label>
                        <select class="form-control" id="month">
                            <option value="1">Jan</option>
                            <option value="2">Feb</option>
                            <option value="3">Mar</option>
                            <option value="4">Apr</option>
                            <option value="5">May</option>
                            <option value="6">Jun</option>
                            <option value="7">Jul</option>
                            <option value="8">Aug</option>
                            <option value="9">Sept</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row gutters-20" id="report">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <a href="{{url('customers')}}">
                        <div class="card dashboard-card-seven">
                            <div class="social-media bg-fb hover-fb" style="background-color: dodgerblue">
                                <div class="media media-none--lg">
                                    <div class="media-body space-sm">
                                        <h6 class="item-title">Customers</h6>
                                    </div>
                                </div>
                                <div class="social-like">{{\App\Models\User::where('role',2)->count()}}</div>
                            </div>
                        </div>
                        </a>
                    </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <a href="{{url('employees')}}">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: mediumseagreen">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Users</h6>
                                </div>
                            </div>
                            <div class="social-like">{{\App\Models\User::where('role',1)->count()}}</div>
                        </div>
                    </div>
                    </a>
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
                            <div class="social-like"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <a href="{{url('mpesa')}}">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: hotpink">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Mpesa Income</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <a href="{{url('cash')}}">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: mediumpurple">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Cash Income</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <a href="{{url('expenses')}}">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Expenses</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card dashboard-card-seven">
                        <div class="social-media bg-twitter hover-twitter" style="background-color: yellowgreen">
                            <div class="media media-none--lg">

                                <div class="media-body space-sm">
                                    <h6 class="item-title">Debt</h6>
                                </div>
                            </div>
                            <span>KSH</span>
                            <div class="social-like">{{$debt}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters-20" id="basic">

            </div>
            <!-- Dashboard summery End Here -->
            <!-- Dashboard Content Start Here -->
            <div class="row gutters-20" id="scrollToReports">
                    <div class="col-12 col-xl-6 col-3-xxxl">
                        <div class="card dashboard-card-three pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Customer</h3>
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
                                <div class="doughnut-chart-wrap">
                                    <canvas id="student-doughnut-chart" width="100" height="300"></canvas>
                                </div>
                                <div class="student-report">
                                    <div class="student-count pseudo-bg-blue">
                                        <h4 class="item-title">Paid Customers</h4>
                                        <div class="item-number">45,000</div>
                                    </div>
                                    <div class="student-count pseudo-bg-yellow">
                                        <h4 class="item-title">Unpaid Customers</h4>
                                        <div class="item-number">1,05,000</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-4-xxxl">
                        <div class="card dashboard-card-four pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Event Calender</h3>
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
                                <div class="calender-wrap">
                                    <div id="fc-calender" class="fc-calender"></div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <!-- Dashboard Content End Here -->
            <!-- Social Media Start Here -->
            <!-- Social Media End Here -->
            <!-- Footer Area Start Here -->
            <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Japcom Networks</a> 2021. All rights reserved. Designed by <a
                        href="#">Japcom Networks</a></div>
            </footer>
            <!-- Footer Area End Here -->
        </div>
    </div>
    <!-- Page Area End Here -->
</div>
<!-- jquery-->
<script src="js/jquery-3.3.1.min.js"></script>
<!-- Plugins js -->
<script src="js/plugins.js"></script>
<!-- Popper js -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Counterup Js -->
<script src="js/jquery.counterup.min.js"></script>
<!-- Moment Js -->
<script src="js/moment.min.js"></script>
<!-- Waypoints Js -->
<script src="js/jquery.waypoints.min.js"></script>
<!-- Scroll Up Js -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- Full Calender Js -->
<script src="js/fullcalendar.min.js"></script>
<!-- Chart Js -->
<script src="js/Chart.min.js"></script>
<!-- Custom Js -->
<script src="js/main.js"></script>

</body>
<script>
    $('#month').on('change',function () {
        $month = $(this).val();
        $year = $('#year').val();
        $.ajax({
            type:"get",
            url:"{{url('ajax')}}",
            data:{'yeah':$year,'month':$month},
            success:function (data) {
                $('#report').hide();
                $('#basic').html(data);
                $.ajax({
                    type:"get",
                    url:"{{url('showMonth')}}",
                    data:{'year':$year,'month':$month},
                    success:function (data) {
                        $('#hideMonth').hide();
                        $('#showMonth').html(data);
                    },
                    error:function (error) {
                        console.log(error)
                        alert('error')

                    }

                });
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
    $('#year').on('change',function () {
        $year = $(this).val();
        $month = $('#month').val();
        $.ajax({
            type:"get",
            url:"{{url('ajax')}}",
            data:{'yeah':$year,'month':$month},
            success:function (data) {
                $('#report').hide();
                $('#basic').html(data);
                $.ajax({
                    type:"get",
                    url:"{{url('showMonth')}}",
                    data:{'year':$year,'month':$month},
                    success:function (data) {
                        $('#hideMonth').hide();
                        $('#showMonth').html(data);
                    },
                    error:function (error) {
                        console.log(error)
                        alert('error')

                    }

                });
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
</script>


<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:34:59 GMT -->
</html>
