@include('adminPartial.nav')
<title>Add Customer | Henix</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
       <div class="breadcrumbs-area">
                <h3>Add New Customer</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Add New Customer</li>
                </ul>
            </div>

            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
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
                    <form action="{{url('storeCustomer')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label> Name *</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                           <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" required>
                            </div>
                           
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Account No:</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Phone No:</label>
                                <input type="text" class="form-control" name="phoneOne" required>
                            </div>
                           
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package *</label>
                                <input type="text" class="form-control" name="bandwidth"/>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package Amount *</label>
                                <input type="text" class="form-control" name="package_amount" required/>

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Current Balance *</label>
                                <input type="text" class="form-control" disabled/>

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Add Balance *</label>
                                <input type="text" class="form-control" name="cBalance" placeholder="Ksh"/>

                            </div>
                              <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Payment Date *</label>
                                    <input type="date" class="form-control" name="payment_date"/>
                                </div>
                            </div>
                    
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Due Date *</label>
                                    <input type="date" class="form-control" name="due_date"/>
                                </div>
                            </div>
                 
                        
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                            </div>
                            
                        </div>
                    </form>
                    
                </div>
                
            </div>
            <!-- Add New Teacher Area End Here -->
            <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Dolex</a> 2023. All rights reserved. Designed by <a
                        href="#">Dolex Technologies</a></div>
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
