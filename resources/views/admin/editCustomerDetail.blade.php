@include('adminPartial.nav')
<title>{{$customer->first_name}} | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Edit <b style="color: red">{{$customer->first_name}}</b> </h3>
                <form action="{{url('disableC',$customer->mikrotik_id)}}">
                        @csrf
                @if($customer->dis_status != 'true')
                <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Disable</button>
                @else
                <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Enable</button>
                @endif
                </form>

                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Edit <b style="color: red">{{$customer->first_name}}</b></li>
                </ul>
            </div>
            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Add New Teacher Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Edit <b style="color: red">{{$customer->first_name}}</b></h3>
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
                    <form action="{{url('editC',$customer->id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>First Name *</label>
                                <input type="text" value="{{$customer->first_name}}" class="form-control" name="first_name">
                            </div>
                          
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Email Address *</label>
                                <input type="email" value="{{$customer->email}}" class="form-control" name="email">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Account No:</label>
                                <input type="text" value="{{$customer->phone}}" class="form-control" name="phone">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Phone No:</label>
                                <input type="text" value="{{$customer->phoneOne}}" class="form-control" name="phoneOne">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Location</label>
                                <input type="text" value="{{$customer->location}}" class="form-control" name="location">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package *</label>
                                <input type="text" value="{{$customer->last_name}}" class="form-control" name="bandwidth"/>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Package Amount *</label>
                                <input type="text" value="{{$customer->package_amount}}" class="form-control" name="package_amount"/>

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Current Balance *</label>
                                <input type="text" value="{{$customer->balance}}" class="form-control"/>

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Add Balance *</label>
                                <input type="text" class="form-control" name="cBalance" placeholder="Ksh"/>

                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Payment Date *</label>
                                    <input type="date" value="{{ old('payment_date', $customer->payment_date ? \Carbon\Carbon::parse($customer->payment_date)->format('Y-m-d') : '') }}" class="form-control" name="payment_date"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Due Date *</label>
                                    <input type="date" value="{{ old('due_date', $customer->due_date ? \Carbon\Carbon::parse($customer->due_date)->format('Y-m-d') : '') }}" class="form-control" name="due_date"/>
                                </div>
                            </div>
                             <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">3Days MSG *</label>
                                    <input type="date" value="" class="form-control" name="two_days_before"/>
                                </div>
                            </div>
                             <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">1Day MSG *</label>
                                    <input type="date" value="" class="form-control" name="one_day_before"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <div class="form-group">
                                        <label>Select</label>
                                        <select class="form-control select2" name="message_logic">
                                            <option value="0">Send Message</option>
                                            <option value="1">Dont Send Message</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" id="addCustomer">Save</button>
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
