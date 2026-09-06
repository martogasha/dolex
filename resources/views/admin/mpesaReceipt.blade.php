@include('adminPartial.nav')
@if(!is_null($receipt->invoice_id))
<title>{{$receipt->invoice->user->first_name}} Receipt - Henix Networks</title>
@else
    <title>{{$receipt->senderFirstName}} Receipt - Henix Networks</title>

@endif
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="page-content container">
    <div class="page-header text-blue-d2">
       

        <div class="page-tools">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Print
                </a>
                <a class="btn bg-white btn-light mx-1px text-95" href="#" id="PDF">
                    <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                    Export
                </a>
            </div>
        </div>
    </div>
<br>
    <div class="container px-0" id="receipt">
  <div class="container">
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <span class="text-sm text-grey-m2 align-middle"><img src="{{asset('img/jp.png')}}" alt="logo" style="width:150px;height:150px;"></span>
                        <div class="d-flex justify-content-end">
                           <h2 class="mb-1 text-muted">RECEIPT</h2>
                        </div>
                     <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Recieved From:</h5>
                                <p class="mb-1">{{$user->first_name}}</p>
                               
                                <p>{{$user->phoneOne}}</p>
                            </div>
                        </div>
                        <!-- end col -->
                  
                        <!-- end col -->
                    </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Paid To:</h5>
                                <p class="mb-1">Paybill: 4311304</p>
                                <p class="mb-1">Vumatel Networks</p>
                                <p class="mb-1">Greec Towers</p>
                                <p>Ruiru, 00233</p>
                              
                            </div>
                        </div>
                        <!-- end col -->
                  
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    
                    <div class="py-2">

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>DESCRIPTION</th>
                                        <th>RATE</th>
                                        <th>QUANTITY</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    <tr>
                                          <td>
                                            <div>
                                                <p class="text-muted mb-0">30 - day Internet Subscription</p>
                                                <h5 class="text-truncate font-size-14 mb-1">( {{date('jS M',strtotime($receipt->originationTime))}} to {{date('jS M',strtotime($user->due_date))}} )</h5>
                                                
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14 mb-1">{{ number_format($receipt->amount, 0, '.', ',') }}</h5>
                                            </div>
                                        </td>
                                        <td style="text-align:center;">1</td>
                                         <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14 mb-1">{{ number_format($receipt->amount, 0, '.', ',') }}</h5>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    <!-- end tr -->
                             
                                    <!-- end tr -->
                         
                                    <!-- end tr -->
                  
                                    <!-- end tr -->
                              
                                    <!-- end tr -->
                                     <hr>
                                    <tr>
                                        <th scope="row" colspan="4" class="border-0 text-end">TOTAL</th>
                                        <td class="border-0 text-end"><h4 class="m-0 fw-semibold">{{ number_format($receipt->amount, 0, '.', ',') }}</h4></td>
                                    </tr>
                                    <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
              
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
</div>
    </div>
</div>
<style>
   
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

<script>
    window.onload = function () {
        document.getElementById("PDF")
            .addEventListener("click", () => {
                const invoice = this.document.getElementById("receipt");
                console.log(invoice);
                console.log(window);
                var opt = {
                    margin: 1,
                    filename: 'receipt.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                html2pdf().from(invoice).set(opt).save();
            })
    }
</script>
