@include('adminPartial.nav')
<title>Add Mpesa Payment | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Add Mpesa Payment</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Add Mpesa Payment</li>
                </ul>
            </div>
            @include('flash-message')
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add Mpesa Payment</h3>
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
                    <form action="{{route('makeMpesaPayment')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12 form-group">
                                    <div class="col-md-12">
                                        <label>Select</label>
                                        <select class="form-control select2" name="user_id">
                                            <option value="">Select</option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                            @endforeach
                                        </select>
                            </div>
                                <div class="col-lg-12 col-12 form-group">
                                    <label for="dob">Reference No *</label>
                                    <input type="text" name="reference" class="form-control">
                                </div>
                                <div class="userDetails">
                            </div>
                                 <div class="col-lg-12 col-12 form-group">
                                    <label for="dob">Amount</label>
                                    <input type="text" name="amount" class="form-control">
                                </div>
                                <div class="col-lg-6 col-6 form-group">
                                    <label for="dob">Payment Date *</label>
                                    <input type="date" id="paymentDate" class="form-control">
                                </div>
                                <input type="hidden" id="paymentDateFinal" name="payment_date">

                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                            </div>
                        </div>
                        </div>
                    </form>
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
    $('#paymentDate').change(function () {
        var paymentDate = $('#paymentDate').val();
        var payment_date = new Date(paymentDate);
        payment_date.setDate(payment_date.getDate());
        var dd5 = String(payment_date.getDate()).padStart(2, '0');
        var mm5 = String(payment_date.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy5 = payment_date.getFullYear();
        payment_date = mm5 + '/' + dd5 + '/' + yyyy5;
        $('#paymentDateFinal').val(payment_date);
    });

    $('.select2').change(function () {
        var value = $(this).val();
        $.ajax({
            type:"get",
            url:"{{url('getInvoice')}}",
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
