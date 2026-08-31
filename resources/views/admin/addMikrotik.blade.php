@include('adminPartial.nav')
<title>Add Mikrotik | Henix</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->

            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add Mikrotik</h3>
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
                    <form action="{{url('storeMikrotik')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>IP Address *</label>
                                <input type="text" class="form-control" name="mikrotik_ip" required>
                            </div>
                          
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>User *</label>
                                <input type="text" class="form-control" name="mikrotik_user" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Password *</label>
                                <input type="text" class="form-control" name="mikrotik_password" required>
                            </div>
                      
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" id="addMikrotik">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Add New Teacher Area End Here -->
            <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Henix</a> 2023. All rights reserved. Designed by <a
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
<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/add-teacher.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:36:38 GMT -->
</html>
