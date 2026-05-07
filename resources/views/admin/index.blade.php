@include('adminPartial.nav')
<title>Admin | Henix</title>
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
                <div class="copyright">© Copyrights <a href="#">Henix</a> 2026. All rights reserved. Designed by <a
                        href="#">Henix Technologies</a></div>
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
