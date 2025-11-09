@include('adminPartial.nav')
@if(\Illuminate\Support\Facades\Auth::check())
<title>{{\Illuminate\Support\Facades\Auth::user()->first_name}} {{\Illuminate\Support\Facades\Auth::user()->last_name}} | Japcom Networks</title>
@endif
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Account Setting</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Setting</li>
                </ul>
            </div>
            @include('flash-message')
            <!-- Breadcubs Area End Here -->
            <!-- Account Settings Area Start Here -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    @if(\Illuminate\Support\Facades\Auth::check())
                                    <h3>Edit {{\Illuminate\Support\Facades\Auth::user()->first_name}}</h3>
                                    @endif
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
                            <form action="{{url('editProfile',\Illuminate\Support\Facades\Auth::id())}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>First Name *</label>
                                        <input type="text" placeholder="First_Name" name="first_name" value="{{\Illuminate\Support\Facades\Auth::user()->first_name}}" class="form-control">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Last Name *</label>
                                        <input type="text" placeholder="Last_Name" name="last_name" value="{{\Illuminate\Support\Facades\Auth::user()->last_name}}" class="form-control">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}" class="form-control">
                                    </div>

                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Phone Number</label>
                                        <input type="text" placeholder="712345678" name="phone" value="{{\Illuminate\Support\Facades\Auth::user()->phone}}" class="form-control">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" placeholder="Password" id="pass" class="form-control">
                                    </div>

                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" placeholder="Confirm Password" id="confirmPassword" class="form-control">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                                        <div id="CheckPasswordMatch">
                                        </div>
                                    </div>

                                    <div class="col-12 form-group mg-t-8">
                                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                </div>
            <!-- Account Settings Area End Here -->
            <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">akkhor</a> 2019. All rights reserved. Designed by <a href="#">PsdBosS</a></div>
            </footer>
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
<!-- Scroll Up Js -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- Select 2 Js -->
<script src="js/select2.min.js"></script>
<!-- Date Picker Js -->
<script src="js/datepicker.min.js"></script>
<!-- Custom Js -->
<script src="js/main.js"></script>

</body>
<script>
    $('#confirmPassword').keyup(function () {
        var password = $('#pass').val();
        var confirmPassword = $('#confirmPassword').val();
        if (password != confirmPassword)
            $('#CheckPasswordMatch').html('Password Dont Match')
        else
            $('#CheckPasswordMatch').html('Password Match')

    });
</script>

<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/account-settings.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:35:35 GMT -->
</html>
