@include('adminPartial.nav')
<title>Invoice List | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Invoices</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>All Invoices</li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Invoices</h3>
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
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by location ..." class="form-control">
                            </div>
                            <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Name ..." class="form-control">
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <a href="{{url('viewInvoice')}}"> <h4>Unpaid</h4></a>
                        <a href="{{url('allInvoices')}}"><h4 style="padding-left: 100px;text-decoration: underline" id="allInvoices">All Invoices</h4></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>Due</th>
                                <th>Date</th>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Amount due</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            @foreach($quotations as $quotation)
                            <tr>
                                @if($quotation->status==0)
                                    <td class="badge badge-pill badge-danger d-block mg-t-8">Overdue</td>
                                @else
                                    <td class="badge badge-pill badge-success d-block mg-t-8">Paid</td>
                                @endif
                                <td style="color: red">{{$quotation->time_difference}} Days ago</td>
                                <td>{{$quotation->payment_due}}</td>
                                    <input type="hidden" value="{{$quotation->payment_due}}" id="payment_due">
                                    <input type="hidden" value="{{$quotation->id}}" id="invoice_id">
                                <td>00{{$quotation->id}}</td>
                                <td>{{$quotation->quotation->name}}</td>
                                <td>SH {{$quotation->amount}}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{url('quotes',$quotation->id)}}"><i
                                                    class="fas fa-eye text-orange-red"></i>View</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                        </div>
                                    </div>
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
                <div class="copyright">© Copyrights <a href="#">akkhor</a> 2019. All rights reserved. Designed by <a
                        href="#">PsdBosS</a></div>
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
    $(document).ready(function () {
        var date2 = new Date();
        date2.setDate(date2.getDate());
        var dd = String(date2.getDate()).padStart(2, '0');
        var mm = String(date2.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = date2.getFullYear();
        due_date = mm + '/' + dd + '/' + yyyy;
        $.ajax({
            type:"get",
            url:"{{url('currentDate')}}",
            data:{'current':due_date},
            success:function (data) {
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
</script>

<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/all-student.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:35:18 GMT -->
</html>
