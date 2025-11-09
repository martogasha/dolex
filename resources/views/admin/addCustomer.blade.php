@include('adminPartial.nav')
<title>Add Customer | Japcom</title>
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
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Customer</h3>
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
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Full Name *</label>
                                <input type="text" placeholder="First Name" class="form-control" id="first_name">
                            </div>
                        
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Email Address *</label>
                                <input type="email" placeholder="Email Address" class="form-control" id="email">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Account No:</label>
                                <input type="text" placeholder="DK1..." class="form-control" id="phone">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Phone No:</label>
                                <input type="text" placeholder="0712345678" class="form-control" id="phoneOne">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Location</label>
                                <input type="text" placeholder="Location" class="form-control" id="location">
                            </div>
                             <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Bandwidth *</label>
                                    <select class="select2" id="bandwidth">
                                        @foreach($profiles as $profile)
                                        <option value="{{$profile->profile}}">{{$profile->profile}}</option>
                                        @endforeach
                                    
                                    </select>
                                </div>

                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Payment Date *</label>
                                    <input type="date" class="form-control" id="payment_date"/>
                                </div>
                            </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Paid Months *</label>
                                    <select class="select2" id="paid_months">
                                        <option value="1">One Month</option>
                                        <option value="2">Two Months</option>
                                        <option value="3">Three Months</option>
                                    </select>
                                </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Due Date *</label>
                                    <input type="text" class="form-control" id="due_date"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Amount Supposed to be Paid</label>
                                <input type="text" placeholder="Ksh" class="form-control" id="amount_supposed_to_pay">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Previous Balance</label>
                                <input type="text" placeholder="Ksh" class="form-control" id="balance_carried">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Amount Paid</label>
                                <input type="text" placeholder="Ksh" class="form-control" id="amount">
                            </div>

                            <div class="col-12 form-group mg-t-8">
                                <button type="button" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" id="addCustomer">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                            </div>
                        </div>
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
        $('#payment_date').change(function () {
            var bandwidth = $('#bandwidth').val();
            switch (bandwidth){
                case 'profile-1MBPS':
                    one = 1000;
                break;
                case 'profile-2MBPS':
                    one = 2000;
                    break;
                case 'profile-10MBPS':
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
            var phoneOne = $('#phoneOne').val();
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
            var previous_balance = $('#balance_carried').val();
            rounded_date = Math.ceil(days);
            $.ajax({
                type:"get",
                url:"{{url('storeCustomer')}}",
                data:{'first_name':first_name,'last_name':last_name,'phone':phone,'phoneOne':phoneOne,'email':email,'location':location,'bandwidth':bandwidth,'payment_date':payment_date,'due_date':due_date,'sms_date':sms_date,'time_difference':rounded_date,'amount':amount,'amount_supposed_to_pay':amount_supposed_to_pay, 'previous_balance':previous_balance},
                success:function (data) {
                    alert('Customer Added Success');
                    location.reload();
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
