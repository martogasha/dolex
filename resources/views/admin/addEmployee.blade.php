@include('adminPartial.nav')
<title>Add Employee | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Add New Employee</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Add New Employee</li>
                </ul>
            </div>
            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Employee</h3>
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
                    <form action="{{route('storeEmployee')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>First Name *</label>
                                <input type="text" placeholder="First Name" class="form-control" name="first_name">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Last Name *</label>
                                <input type="text" placeholder="Last Name" class="form-control" name="last_name">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Email Address *</label>
                                <input type="email" placeholder="Email Address" class="form-control" name="email">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Phone</label>
                                <input type="text" placeholder="712345678" class="form-control" name="phone">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Role *</label>
                                <select class="select2" id="getRole" name="role">
                                    <option value="">Please Select Role *</option>
                                    <option value="0">Admin</option>
                                    <option value="1">User</option>
                                </select>
                            </div>
                            <div class="container" id="role_type">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="products" value="5" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Products</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="users" value="6" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">Users</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="customers" value="7" id="customCheck3">
                                            <label class="custom-control-label" for="customCheck3">Customers</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="payments" value="8" id="customCheck4">
                                            <label class="custom-control-label" for="customCheck4">Payments</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="expenses" value="9" id="customCheck5">
                                            <label class="custom-control-label" for="customCheck5">Expenses</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="estimate" value="10" id="customCheck6">
                                            <label class="custom-control-label" for="customCheck6">Estimate</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="invoice" value="11" id="customCheck7">
                                            <label class="custom-control-label" for="customCheck7">Invoice</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container" id="role_type1">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="products" value="5" id="customCheck1" checked>
                                            <label class="custom-control-label" for="customCheck1">Products</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="users" value="6" id="customCheck2" checked>
                                            <label class="custom-control-label" for="customCheck2">Users</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="customers" value="7" id="customCheck3" checked>
                                            <label class="custom-control-label" for="customCheck3">Customers</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="payments" value="8" id="customCheck4" checked>
                                            <label class="custom-control-label" for="customCheck4">Payments</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="expenses" value="9" id="customCheck5" checked>
                                            <label class="custom-control-label" for="customCheck5">Expenses</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="estimate" value="10" id="customCheck6" checked>
                                            <label class="custom-control-label" for="customCheck6">Estimate</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="invoice" value="11" id="customCheck7" checked>
                                            <label class="custom-control-label" for="customCheck7">Invoice</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
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
    $(document).ready(function () {
       $('#role_type').hide();
       $('#role_type1').hide();
    });
    $('#getRole').on('change',function () {
        $value = $('#getRole').val();
        if ($value==1){
            $('#role_type').show();
            $('#role_type1').hide();

        }
    }); $('#getRole').on('change',function () {
        $value = $('#getRole').val();
        if ($value==0){
            $('#role_type').hide();
            $('#role_type1').show();
        }
    });
        $('#payment_date').change(function () {
            var bandwidth = $('#bandwidth').val();
            switch (bandwidth){
                case '1':
                    one = 1000;
                break;
                case '2':
                    one = 2000;
                    break;
                case '3':
                    one = 3000;
                break;
                case '4':
                    one = 4000;
                break;
                case '5':
                    one = 5000;
                break;
            }
            $paidMonths = $('#paid_months').val();
                var startDate = $('#payment_date').val();
                var future = new Date(startDate);
                future.setDate(future.getDate() + 31);
                var dd = String(future.getDate()).padStart(2, '0');
                var mm = String(future.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = future.getFullYear();
                future = mm + '/' + dd + '/' + yyyy;
                $('#due_date').val(future);
                $('#amount').val(one);
                $('#amount_supposed_to_pay').val(one);

        });
        $('#paid_months').change(function () {
            $paidMonths = $(this).val();
            if ($paidMonths==1){
                var startDate1 = $('#payment_date').val();
                var future1 = new Date(startDate1);
                future1.setDate(future1.getDate() + 30);
                var dd1 = String(future1.getDate()).padStart(2, '0');
                var mm1 = String(future1.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy1 = future1.getFullYear();
                future1 = mm1 + '/' + dd1 + '/' + yyyy1;
                $('#due_date').val(future1);
                $('#amount').val(one);
                $('#amount_supposed_to_pay').val(one);
            }
            else if($paidMonths==2){
                var startDate2 = $('#payment_date').val();
                var future2 = new Date(startDate2);
                future2.setDate(future2.getDate() + 60);
                var dd2 = String(future2.getDate()).padStart(2, '0');
                var mm2 = String(future2.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy2 = future2.getFullYear();
                future2 = mm2 + '/' + dd2 + '/' + yyyy2;
                $('#due_date').val(future2);
                $('#amount').val(one*2);
                $('#amount_supposed_to_pay').val(one*2);
            }
            else{
                var startDate3 = $('#payment_date').val();
                var future3 = new Date(startDate3);
                future3.setDate(future3.getDate() + 90);
                var dd3 = String(future3.getDate()).padStart(2, '0');
                var mm3 = String(future3.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy3 = future3.getFullYear();
                future3 = mm3 + '/' + dd3 + '/' + yyyy3;
                $('#due_date').val(future3);
                $('#amount').val(one*3);
                $('#amount_supposed_to_pay').val(one*3);
            }

        });
        $('#addCustomer').click(function () {
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var location = $('#location').val();
            var bandwidth = $('#bandwidth').val();
            var paymentDate = $('#payment_date').val();
            var payment_date = new Date(paymentDate);
            payment_date.setDate(payment_date.getDate());
            var dd5 = String(payment_date.getDate()).padStart(2, '0');
            var mm5 = String(payment_date.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy5 = payment_date.getFullYear();
            payment_date = mm5 + '/' + dd5 + '/' + yyyy5;
            var due_date = $('#due_date').val();
            var date_to_send_sms = new Date(due_date);
            date_to_send_sms.setDate(date_to_send_sms.getDate() - 2);
            var dd4 = String(date_to_send_sms.getDate()).padStart(2, '0');
            var mm4 = String(date_to_send_sms.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy4 = date_to_send_sms.getFullYear();
            date_to_send_sms = mm4 + '/' + dd4 + '/' + yyyy4;
            var sms_date = date_to_send_sms
            var date1 = new Date();
            var date2 = new Date($('#due_date').val());
            var datediff = date2 - date1;
            var days  = datediff/1000/60/60/24;
            var amount = $('#amount').val();
            var amount_supposed_to_pay = $('#amount_supposed_to_pay').val();
            alert(amount_supposed_to_pay)
            rounded_date = Math.ceil(days);
            $.ajax({
                type:"get",
                url:"{{url('storeCustomer')}}",
                data:{'first_name':first_name,'last_name':last_name,'phone':phone,'email':email,'location':location,'bandwidth':bandwidth,'payment_date':payment_date,'due_date':due_date,'sms_date':sms_date,'time_difference':rounded_date,'amount':amount,'amount_supposed_to_pay':amount_supposed_to_pay},
                success:function (data) {
                    alert('ok');
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
