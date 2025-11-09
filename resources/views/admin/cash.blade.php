@include('adminPartial.nav')
<title>Cash Payments | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Cash Payments</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Cash Payments</li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Cash Payments</h3>
                        </div>
                        <div class="dropdown">
                            <a href="{{url('addCash')}}"><button class="btn btn-primary">Add Cash Payment</button></a>
                        </div>
                    </div>
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Name ..." class="form-control">
                            </div>
                            <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by amount ..." class="form-control">
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                            <tr>

                                <th>Name</th>
                                <th>Amount</th>
                                <th>Date Of Payment</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashs as $cash)
                                @if(!is_null(\App\Models\User::find($cash->user_id)))
                            <tr>

                                <td>{{$cash->user->first_name}} {{$cash->user->last_name}}</td>
                                <td><b>Ksh: {{$cash->amount}}</b></td>
                                <td>{{$cash->date}}</td>
                                <td><a href="{{url('cashReceipt',$cash->id)}}"><button class="btn btn-success">Receipt</button></a></td>
                            </tr>
                                @endif
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
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container">
                <div class="row">

                    <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                        <div class="row">
                            <div class="receipt-header">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="receipt-left">
                                        <img class="img-responsive" alt="iamgurdeeposahan" src="http://bootsnipp.com/img/avatars/bcf1c0d13e5500875fdd5a7e8ad9752ee16e7462.jpg" style="width: 71px; border-radius: 43px;">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                    <div class="receipt-right">
                                        <h5>TechiTouch.</h5>
                                        <p>+91 12345-6789 <i class="fa fa-phone"></i></p>
                                        <p>info@gmail.com <i class="fa fa-envelope-o"></i></p>
                                        <p>Australia <i class="fa fa-location-arrow"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="receipt-header receipt-header-mid">
                                <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                                    <div class="receipt-right">
                                        <h5>Gurdeep Singh <small>  |   Lucky Number : 156</small></h5>
                                        <p><b>Mobile :</b> +91 12345-6789</p>
                                        <p><b>Email :</b> info@gmail.com</p>
                                        <p><b>Address :</b> Australia</p>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="receipt-left">
                                        <h1>Receipt</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="col-md-9">Payment for August 2016</td>
                                    <td class="col-md-3"><i class="fa fa-inr"></i> 15,000/-</td>
                                </tr>
                                <tr>
                                    <td class="col-md-9">Payment for June 2016</td>
                                    <td class="col-md-3"><i class="fa fa-inr"></i> 6,00/-</td>
                                </tr>
                                <tr>
                                    <td class="col-md-9">Payment for May 2016</td>
                                    <td class="col-md-3"><i class="fa fa-inr"></i> 35,00/-</td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <p>
                                            <strong>Total Amount: </strong>
                                        </p>
                                        <p>
                                            <strong>Late Fees: </strong>
                                        </p>
                                        <p>
                                            <strong>Payable Amount: </strong>
                                        </p>
                                        <p>
                                            <strong>Balance Due: </strong>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <strong><i class="fa fa-inr"></i> 65,500/-</strong>
                                        </p>
                                        <p>
                                            <strong><i class="fa fa-inr"></i> 500/-</strong>
                                        </p>
                                        <p>
                                            <strong><i class="fa fa-inr"></i> 1300/-</strong>
                                        </p>
                                        <p>
                                            <strong><i class="fa fa-inr"></i> 9500/-</strong>
                                        </p>
                                    </td>
                                </tr>
                                <tr>

                                    <td class="text-right"><h2><strong>Total: </strong></h2></td>
                                    <td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i> 31.566/-</strong></h2></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="receipt-header receipt-header-mid receipt-footer">
                                <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                                    <div class="receipt-right">
                                        <p><b>Date :</b> 15 Aug 2016</p>
                                        <h5 style="color: rgb(140, 140, 140);">Thank you for your business!</h5>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="receipt-left">
                                        <h1>Signature</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <style>
        .text-danger strong {
            color: #9f181c;
        }
        .receipt-main {
            background: #ffffff none repeat scroll 0 0;
            border-bottom: 12px solid #333333;
            border-top: 12px solid #9f181c;
            padding: 40px 30px !important;
            position: relative;
            box-shadow: 0 1px 21px #acacac;
            color: #333333;
            font-family: open sans;
        }
        .receipt-main p {
            color: #333333;
            font-family: open sans;
            line-height: 1.42857;
        }
        .receipt-footer h1 {
            font-size: 15px;
            font-weight: 400 !important;
            margin: 0 !important;
        }
        .receipt-main::after {
            background: #414143 none repeat scroll 0 0;
            content: "";
            height: 5px;
            left: 0;
            position: absolute;
            right: 0;
            top: -13px;
        }
        .receipt-main thead {
            background: #414143 none repeat scroll 0 0;
        }
        .receipt-main thead th {
            color:#fff;
        }
        .receipt-right h5 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 7px 0;
        }
        .receipt-right p {
            font-size: 12px;
            margin: 0px;
        }
        .receipt-right p i {
            text-align: center;
            width: 18px;
        }
        .receipt-main td {
            padding: 9px 20px !important;
        }
        .receipt-main th {
            padding: 13px 20px !important;
        }
        .receipt-main td {
            font-size: 13px;
            font-weight: initial !important;
        }
        .receipt-main td p:last-child {
            margin: 0;
            padding: 0;
        }
        .receipt-main td h2 {
            font-size: 20px;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
        }
        .receipt-header-mid .receipt-left h1 {
            font-weight: 100;
            margin: 34px 0 0;
            text-align: right;
            text-transform: uppercase;
        }
        .receipt-header-mid {
            margin: 24px 0;
            overflow: hidden;
        }

        #container {
            background-color: #dcdcdc;
        }
    </style>
<!-- Modal -->
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


<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/all-student.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:35:18 GMT -->
</html>
