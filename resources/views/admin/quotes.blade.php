@include('adminPartial.nav')
<title>Quotation | Japcom</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Customers</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>All Quotations</li>
                    <button class="btn btn-success" style="float: right" data-toggle="modal" data-target="#invoiceModal">INVOICE</button>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Quotations</h3>
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
                    <div class="page-content container">
                        <div class="page-header text-blue-d2">
                            <div class="page-tools">
                                <div class="action-buttons">
                                    <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="Print" id="print_quotation">
                                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                                        Print
                                    </a>
                                    <a class="btn bg-white btn-light mx-1px text-95" href="#" id="cmd">
                                        <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                                        Export
                                    </a>
                                    <a class="btn bg-white btn-light mx-1px text-95" href="{{url('singleEstimate',$quote->id)}}" id="PDF">
                                        <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                                        Edit
                                    </a>
                                </div>
                            </div>
                            <div id="editor"></div>

                        </div>

                        <div class="container px-0" id="view_quotation">
                            <div class="row mt-4">
                                <div class="col-12 col-lg-10 offset-lg-1">
                                    <!-- .row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div>
                                                <span class="text-sm text-grey-m2 align-middle"><img src="{{asset('img/logo.jpg')}}" alt="logo"></span>
                                            </div>
                                        </div>
                                        <!-- /.col -->

                                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                            <hr class="d-sm-none" />
                                            <div class="text-grey-m2" style="text-align: right">
                                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125" style="color: black;font-size: 50px">
                                                    QUOTATION
                                                </div>

                                                <div class="my-2"></i> <span class="text-600 text-90" style="color: black">Dolex Technologies Limited</div>
                                                <div class="my-2"></i> <span class="text-600 text-90">Kagio<br></div>
                                                <div class="my-2"></i> <span class="text-600 text-90">0703725501</div>
                                                <div class="my-2"></i> <span class="text-600 text-90" >dolextech@outlook.com</div>

                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div>
                                                <span class="text-sm text-grey-m2 align-middle">BILL TO:</span>
                                                <span class="text-600 text-110 text-blue align-middle"  ><br>{{$quote->name}}</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->

                                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                            <hr class="d-sm-none" />
                                            <div class="text-grey-m2">
                                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                                    Quote Number :0{{$quote->id}}
                                                </div>

                                                <div class="my-2"></i> <span class="text-600 text-90">Quote Date:</span> {{$quote->estimate_date}}</div>
                                                <div class="my-2"></i> <span class="text-600 text-90">Expires On:</span> {{$quote->expiry_date->format('d/m/y')}}</div>
                                                <div class="my-2"></i> <span class="text-600 text-90" style="color: black"><b>Grand Total (KES):</b></span> <b style="color: black">SH{{$total}}.00</b></div>

                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>

                                    <div class="mt-4">
                                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                                            <div class="d-none d-sm-block col-1">#</div>
                                            <div class="col-9 col-sm-5" style="color: black">Description</div>
                                            <div class="d-none d-sm-block col-4 col-sm-2" style="color: black">Qty</div>
                                            <div class="d-none d-sm-block col-sm-2" style="color: black">Unit Price</div>
                                            <div class="col-2" style="color: black">Amount</div>
                                        </div>

                                        <div class="text-95 text-secondary-d3">
                                            @foreach($products as $product)
                                            <div class="row mb-2 mb-sm-0 py-25">
                                                <div class="d-none d-sm-block col-1">1</div>
                                                <div class="col-9 col-sm-5">{{$product->name}}</div>
                                                <div class="d-none d-sm-block col-2">{{$product->quantity}}</div>
                                                <div class="d-none d-sm-block col-2 text-95">SH{{$product->amount}}.00</div>
                                                <div class="col-2 text-secondary-d2">SH{{$product->amount*$product->quantity}}.00</div>
                                            </div>
                                            @endforeach

                                        </div>

                                        <div class="row border-b-2 brc-default-l2"></div>

                                        <!-- or use a table instead -->
                                        <!--
                                <div class="table-responsive">
                                    <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                        <thead class="bg-none bgc-default-tp1">
                                            <tr class="text-white">
                                                <th class="opacity-2">#</th>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th width="140">Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody class="text-95 text-secondary-d3">
                                            <tr></tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Domain registration</td>
                                                <td>2</td>
                                                <td class="text-95">$10</td>
                                                <td class="text-secondary-d2">$20</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                -->

                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0"></div>

                                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                                <div class="row my-2">
                                                    <div class="col-7 text-right" style="color: black">
                                                        Total
                                                    </div>
                                                    <div class="col-5">
                                                        <span class="text-120 text-secondary-d1">SH{{$total}}.00</span>
                                                    </div>
                                                </div>

                                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                                    <div class="col-7 text-right" style="color: black">
                                                        <b>Grand Total (KES):</b>
                                                    </div>
                                                    <div class="col-5">
                                                        <span><b style="font-size: 18px">SH{{$total}}.00</b></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <span class="text-secondary-d1 text-105" style="padding-left: 300px">We deliver as promised</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{url('invoice',$quote->id)}}" method="post">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Generate Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-12 form-group">
                        <div class="form-group">
                            <label for="dob">Invoice Date *</label>
                            <input type="date" class="form-control" name="invoice_date" id="estimated_date"/>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 form-group">
                        <div class="form-group">
                            <label for="dob">Payment Due *</label>
                            <input type="date" class="form-control" name="payment_due" id="expiry_date"/>
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <div class="form-group">
                            <label for="dob">Amount *</label>
                            <input type="text" class="form-control" value="{{$total}}" name="amount" id="amount"/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="generateInvoice">Save changes</button>
            </div>
        </div>
        </form>
    </div>
</div>
<style>
    body{
        margin-top:20px;
        color: #484b51;
    }
    .text-secondary-d1 {
        color: #728299!important;
    }
    .page-header {
        margin: 0 0 1rem;
        padding-bottom: 1rem;
        padding-top: .5rem;
        border-bottom: 1px dotted #e2e2e2;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -ms-flex-align: center;
        align-items: center;
    }
    .page-title {
        padding: 0;
        margin: 0;
        font-size: 1.75rem;
        font-weight: 300;
    }
    .brc-default-l1 {
        border-color: #dce9f0!important;
    }

    .ml-n1, .mx-n1 {
        margin-left: -.25rem!important;
    }
    .mr-n1, .mx-n1 {
        margin-right: -.25rem!important;
    }
    .mb-4, .my-4 {
        margin-bottom: 1.5rem!important;
    }

    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0,0,0,.1);
    }

    .text-grey-m2 {
        color: #888a8d!important;
    }

    .text-success-m2 {
        color: #86bd68!important;
    }

    .font-bolder, .text-600 {
        font-weight: 600!important;
    }

    .text-110 {
        font-size: 110%!important;
    }
    .text-blue {
        color: black!important;
    }
    .pb-25, .py-25 {
        padding-bottom: .75rem!important;
    }

    .pt-25, .py-25 {
        padding-top: .75rem!important;
    }
    .bgc-default-tp1 {
        background-color: rgba(8,238,235,255)!important;
    }
    .bgc-default-l4, .bgc-h-default-l4:hover {
        background-color: #f3f8fa!important;
    }
    .page-header .page-tools {
        -ms-flex-item-align: end;
        align-self: flex-end;
    }

    .btn-light {
        color: #757984;
        background-color: #f5f6f9;
        border-color: #dddfe4;
    }
    .w-2 {
        width: 1rem;
    }

    .text-120 {
        font-size: 120%!important;
    }
    .text-primary-m1 {
        color: #4087d4!important;
    }

    .text-danger-m1 {
        color: #dd4949!important;
    }
    .text-blue-m2 {
        color: #68a3d5!important;
    }
    .text-150 {
        font-size: 150%!important;
    }
    .text-60 {
        font-size: 60%!important;
    }
    .text-grey-m1 {
        color: #7b7d81!important;
    }
    .align-bottom {
        vertical-align: bottom!important;
    }
</style>

<!-- jquery-->
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<!-- Plugins js -->
<script src="{{asset('js/plugins.js')}}"></script>
<!-- Popper js -->
<script src="{{asset('js/popper.min.js')}}"></script>
<!-- Bootstrap js -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Scroll Up Js -->
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
<!-- Data Table Js -->
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('js/main.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

</body>
<script>
    $('#expiry_date').on('change',function () {
    })
    window.onload = function () {
        document.getElementById("cmd")
            .addEventListener("click", () => {
                const invoice = this.document.getElementById("view_quotation");
                console.log(invoice);
                console.log(window);
                var opt = {
                    margin: 1,
                    filename: 'quotation.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
                };
                html2pdf().from(invoice).set(opt).save();
            })
    }
</script>

<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/all-student.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:35:18 GMT -->
</html>
