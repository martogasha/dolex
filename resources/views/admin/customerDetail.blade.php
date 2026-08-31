@include('adminPartial.nav')
<title>{{$user->first_name}} {{$user->last_name}} Statements - Japcom Networks</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>{{$user->first_name}} {{$user->last_name}} Statements</h3>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>{{$user->first_name}} {{$user->last_name}}</li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Teacher Table Area Start Here -->
          <!-- Dashboard Content Start Here -->
                <div class="row gutters-20">        
                                     <div class="col-lg-6 col-xl-6 col-4-xxxl">
                        <div class="card dashboard-card-six pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1 mg-b-17">
                                    <div class="item-title">
                                        <h3>Logs</h3>
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
                                <div class="notice-box-wrap">
                                    @foreach($logs as $log)
                                    <div class="notice-list">
                                        <div class="post-date bg-pink">{{date('d/m/Y H:i:s',strtotime($log->date))}}</div>
                                        <h6 class="notice-title"><a href="#">{{$log->user->first_name}} ({{$log->user->phone}})</a></h6>
                                    @switch($log->reason)
                                    @case(0)
                                    <div class="entry-meta">Paid</div>
                                    @break
                                    @case(1)
                                    <div class="entry-meta">Customet Enabled</div>
                                    @break
                                    @case(11)
                                    <div class="entry-meta">Advanced Payment</div>
                                    @break
                                    @case(3)
                                    <div class="entry-meta">Balance Carried Over</div>
                                    @break
                                    @case(4)
                                    <div class="entry-meta">Balance Carried Over One</div>
                                    @break
                                    @case(6)
                                    <div class="entry-meta">Customer Disabled</div>
                                    @break
                                    @case(7)
                                    <div class="entry-meta">Customer Enabled</div>
                                    @break
                                    @case(8)
                                    <div class="entry-meta">Customer Disabled</div>
                                    @break
                                    @case(12)
                                    <div class="entry-meta">Customer Edit Success</div>
                                    @break
                                    
                                    @endswitch
                                    </div>
                                    @endforeach
                            
                                </div>
                            </div>
                        </div>
                    </div>
                 
                    <div class="col-lg-6 col-xl-6 col-4-xxxl">
                        <div class="card dashboard-card-six pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1 mg-b-17">
                                    <div class="item-title">
                                        <h3>Last Logout</h3>
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
                                <div class="notice-box-wrap">
                                    <div class="notice-list">
                                        <div class="post-date bg-skyblue">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag mene esom text of the
                                                printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-yellow">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-pink">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag meneesom.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-skyblue">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag mene esom text of the
                                                printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-yellow">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-pink">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag meneesom.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Teacher Table Area End Here -->
       <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Henix</a> 2026. All rights reserved. Designed by <a
                        href="#">Henix Technologies</a></div>
            </footer>
        </div>
    </div>
    <!-- Page Area End Here -->
</div>
<!-- jquery-->
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<!-- Plugins js -->
<script src="{{asset('js/plugins.js')}}"></script>
<!-- Popper js -->
<script src="{{asset('js/popper.min.js')}}"></script>
<!-- Bootstrap js -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Scroll Up Js -->
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
<!-- Data Table Js -->
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('js/main.js')}}"></script>

</body>
<script>
    const today = new Date()
    today.toLocaleString('default', { month: 'long' })
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/all-book.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:36:40 GMT -->
</html>
