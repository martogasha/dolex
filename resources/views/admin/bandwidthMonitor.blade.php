@include('adminPartial.nav')
<title>Bandidth Monitor | Henix</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Bandwidth Monitor</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Admin</a>
                    </li>
                    <li>Bandwidth Monitor</li>
                </ul>
            </div>
            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Dashboard summery Start Here -->
     
       
          
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
                                        <h3>Bandwidth</h3>
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
                             <div id="update-container">
                         
                                </div>
                                <hr>
                                                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Send Message if no Bandwidth 
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Send Message if Bandwidth is being used Maximum
                                    </label>
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
        function refreshUpdates() {
        $('#update-container').load("{{ url('/refresh') }}"); // The .load() method is a simple way to fetch data from the server and place the returned HTML into the selected element.
    }

    // Initial load
    refreshUpdates();

    // Set an interval to refresh the div every 10 seconds (10000 milliseconds).
    setInterval(refreshUpdates, 1000);
   
</script>


<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:34:59 GMT -->
</html>
