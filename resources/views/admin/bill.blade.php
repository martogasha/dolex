@include('adminPartial.nav')
<title>Bill Customer | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Bill Customer</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Bill Customer</li>
                </ul>
            </div>
            @include('flash-message')
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Bill Customer</h3>
                        </div>
                        <div class="dropdown">
                            <form action="{{route('billing')}}" method="post">
                                @csrf
                           <button type="submit" class="btn btn-danger">Bill All</button>
                            </form>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-lg-12 col-12 form-group">
                                    <div class="col-md-12">
                                        <label>Select</label>
                                        <select class="form-control select2" name="user_id">
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                            @endforeach
                                        </select>
                            </div>
                                <form action="{{route('billingEach')}}" method="post">
                                    @csrf
                                <div class="userDetails">

                            </div>

                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                            </div>
                                </form>
                        </div>
                        </div>
                </div>
            </div>
            <!-- Add New Teacher Area End Here -->
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
<!-- Select 2 Js -->
<script src="js/select2.min.js"></script>
<!-- Date Picker Js -->
<script src="js/datepicker.min.js"></script>
<!-- Smoothscroll Js -->
<script src="js/jquery.smoothscroll.min.html"></script>
<!-- Scroll Up Js -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- Custom Js -->
<script src="js/main.js"></script>


</body>
<script>

    $('.select2').change(function () {
        var value = $(this).val();
        $.ajax({
            type:"get",
            url:"{{url('getUserInvoice')}}",
            data:{'id':value},
            success:function (data) {
                $('.userDetails').html(data);
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });

    });

</script>


<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/add-teacher.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:36:38 GMT -->
</html>
