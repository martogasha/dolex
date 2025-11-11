@include('adminPartial.nav')
<title>Mpesa Payments | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Mpesa Payments</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Mpesa Payments</li>
                </ul>
            </div>

            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Mpesa Payments</h3>
                        </div>
                        <div class="dropdown">
                            <a href="{{url('addMpesa')}}"><button class="btn btn-primary">Add Mpesa Payment</button></a>

                            <a href="{{url('mpesa')}}"><button class="btn btn-success">All Mpesa Records</button></a>
                        </div>
                    </div>
                    <form action="{{url('filterMpesa')}}" method="post">
                        @csrf
                        <div class="row gutters-8">
                            <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">Start Date *</label>
                                    <input type="date" class="form-control" name="start_date"/>
                                </div>                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <div class="form-group">
                                    <label for="dob">End Date *</label>
                                    <input type="date" class="form-control" name="end_date"/>
                                </div>
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    @if(isset($start_date))
                        <h3>Total from <b style="color: red">{{date('d-m-Y', strtotime($start_date))}}</b> to <b style="color: red">{{date('d-m-Y', strtotime($end_date))}}</b> = <b>SH {{$total}}</b></h3>
                    @else
                        <h3>Total for {{\Carbon\Carbon::now()->format('F')}} = <b>SH {{$total}}</b></h3>
                    @endif
                    <div class="table-responsive">
                        <div class="col-lg-12 col-12 form-group">
                            <label>Search (<b>Name, Phone Number, Amount, Mpesa code, Date...etc</b>)</label>
                            <input type="text" placeholder="Search" class="form-control" id="myInput">
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>

                                <th>Reference</th>
                                <th>Name</th>
                                <th>A/c No</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach($mpesas as $mpesa)
                            <tr>

                                <td>{{$mpesa->reference}}</td>
                                <td>{{$mpesa->senderFirstName}} {{$mpesa->senderMiddleName}} {{$mpesa->senderLastName}}</td>
                                <td>{{$mpesa->senderPhoneNumber}}</td>
                                <td><b>kSH: {{$mpesa->amount}}</b></td>
                                <td>{{date('d/m/Y',strtotime($mpesa->originationTime))}}</td>
                                <td>
                                    <a href="{{url('mpesaReceipt',$mpesa->id)}}"><button class="btn btn-success">Receipt</button></a>
                                </td>
                            </tr>
                            @endforeach

                                                    </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Student Table Area End Here -->
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
<!-- Scroll Up Js -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- Data Table Js -->
<script src="js/jquery.dataTables.min.js"></script>
<!-- Custom Js -->
<script src="js/main.js"></script>

</body>

<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/all-student.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:35:18 GMT -->
</html>
