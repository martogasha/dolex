@include('adminPartial.nav')
<title>Invoice | Japcom</title>
<!-- Sidebar Area End Here -->
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Invoice</h3>
        <ul>
            <li>
                <a href="{{url('admin')}}">Home</a>
            </li>
            <li>Invoice</li>
        </ul>
    </div>
@include('flash-message')
<!-- Breadcubs Area End Here -->
    <!-- Add New Teacher Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Edit Invoice</h3>
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
                    <label>Name of Customer *</label>
                    <input type="text" value="{{$estimate->name}}" class="form-control" id="customer_name">
                    <input type="hidden" value="{{$estimate->id}}" id="estimateId">
                    <input type="hidden" value="{{$estimate->amount}}" id="invoiceAmount">
                </div>
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <div class="form-group">
                        <label for="dob">Invoiced Date *</label>
                        <input type="text" name=date value="{{$estimate->invoice_date}}" class="form-control air-datepicker" id="estimated_date">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <div class="form-group">
                        <label for="dob">Expiry Date *</label>
                        <input type="text" name=date value="{{$estimate->payment_due}}" class="form-control air-datepicker" id="expiry_date">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-lg-12 col-12 form-group">
                    <label>Product *</label>
                    <select class="select2" id="product_name">
                        <option>Select product</option>
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-xl-3 col-lg-12 col-12 form-group">
                    <label>Amount *</label>
                    <div id="amountDiv">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-12 form-group">
                    <label>Quantity *</label>
                    <select class="select2" id="quantity">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" id="storeQuotationButton">Add</button>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                    <tr>

                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ducts as $product)
                        @if($product->quotation_id!=0)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>Ksh: {{$product->amount}}</td>
                            <td>Ksh: {{$product->amount*$product->quantity}}</td>

                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-expanded="false">
                                        <span class="flaticon-more-button-of-three-dots"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item view" id="{{$product->id}}" href="#editModal" data-toggle="modal">Edit</a>
                                        <a class="dropdown-item delete" id="{{$product->id}}">Remove</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @else
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>Ksh: {{$product->amount}}</td>
                                <td>Ksh: {{$product->amount*$product->quantity}}</td>

                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item view" id="{{$product->id}}" href="#editModal" data-toggle="modal">Edit</a>
                                            <a class="dropdown-item delete" id="{{$product->id}}">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-12 form-group mg-t-8">
                <div class="row">
                    <a href="{{url('printInvoice',$quote->id)}}"><button class="btn-fill-lg bg-blue-dark btn-hover-yellow">view</button></a>
                    <button class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" id="editQuotation" style="margin-left: 20px">Save</button>
                    <form action="{{url('deleteQ', $quote->id)}}" method="post">
                        @csrf
                        <button type="submit" style="margin-left: 15px" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Delete</button>
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
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form action="{{route('editQProduct')}}" method="post">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="basic1">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="spinner" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-sm-6 text-center">
                    <p>PLEASE WAIT</p>
                    <div class="loader"></div>
                </div>
                <style>
                    .loader {
                        width:50px;
                        height:50px;
                        display:inline-block;
                        padding:0px;
                        opacity:0.5;
                        border:3px solid #09acfd;
                        -webkit-animation: loader 1s ease-in-out infinite alternate;
                        animation: loader 1s ease-in-out infinite alternate;
                    }

                    .loader:before {
                        content: " ";
                        position: absolute;
                        z-index: -1;
                        top: 5px;
                        left: 5px;
                        right: 5px;
                        bottom: 5px;
                        border: 3px solid #09acfd;
                    }

                    .loader:after {
                        content: " ";
                        position: absolute;
                        z-index: -1;
                        top: 15px;
                        left: 15px;
                        right: 15px;
                        bottom: 15px;
                        border: 3px solid #09acfd;
                    }

                    @keyframes loader {
                        from {transform: rotate(0deg) scale(1,1);border-radius:0px;}
                        to {transform: rotate(360deg) scale(0, 0);border-radius:50px;}
                    }
                    @-webkit-keyframes loader {
                        from {-webkit-transform: rotate(0deg) scale(1, 1);border-radius:0px;}
                        to {-webkit-transform: rotate(360deg) scale(0,0 );border-radius:50px;}
                    }

                    .loader1 {
                        display:inline-block;
                        font-size:0px;
                        padding:0px;
                    }
                    .loader1 span {
                        vertical-align:middle;
                        border-radius:100%;

                        display:inline-block;
                        width:10px;
                        height:10px;
                        margin:3px 2px;
                        -webkit-animation:loader1 0.8s linear infinite alternate;
                        animation:loader1 0.8s linear infinite alternate;
                    }
                    .loader1 span:nth-child(1) {
                        -webkit-animation-delay:-1s;
                        animation-delay:-1s;
                        background:rgba(245, 103, 115,0.6);
                    }
                    .loader1 span:nth-child(2) {
                        -webkit-animation-delay:-0.8s;
                        animation-delay:-0.8s;
                        background:rgba(245, 103, 115,0.8);
                    }
                    .loader1 span:nth-child(3) {
                        -webkit-animation-delay:-0.26666s;
                        animation-delay:-0.26666s;
                        background:rgba(245, 103, 115,1);
                    }
                    .loader1 span:nth-child(4) {
                        -webkit-animation-delay:-0.8s;
                        animation-delay:-0.8s;
                        background:rgba(245, 103, 115,0.8);

                    }
                    .loader1 span:nth-child(5) {
                        -webkit-animation-delay:-1s;
                        animation-delay:-1s;
                        background:rgba(245, 103, 115,0.4);
                    }

                    @keyframes loader1 {
                        from {transform: scale(0, 0);}
                        to {transform: scale(1, 1);}
                    }
                    @-webkit-keyframes loader1 {
                        from {-webkit-transform: scale(0, 0);}
                        to {-webkit-transform: scale(1, 1);}
                    }

                    .loader2 {
                        width:25px;
                        height:25px;
                        display:inline-block;
                        padding:0px;
                        border-radius:100%;
                        border:5px solid;
                        border-top-color:rgba(254, 168, 23, 0.65);
                        border-bottom-color:rgba(57, 154, 219, 0.65);
                        border-left-color:rgba(188, 84, 93, 0.95);
                        border-right-color:rgba(137, 188, 79, 0.95);
                        -webkit-animation: loader2 2s ease-in-out infinite alternate;
                        animation: loader2 2s ease-in-out infinite alternate;
                    }
                    @keyframes loader2 {
                        from {transform: rotate(0deg);}
                        to {transform: rotate(720deg);}
                    }
                    @-webkit-keyframes loader2 {
                        from {-webkit-transform: rotate(0deg);}
                        to {-webkit-transform: rotate(720deg);}
                    }

                    .loader3 {
                        width:50px;
                        height:50px;
                        display:inline-block;
                        padding:0px;
                        text-align:left;
                    }
                    .loader3 span {
                        position:absolute;
                        display:inline-block;
                        width:50px;
                        height:50px;
                        border-radius:100%;
                        background:rgba(135, 211, 124,1);
                        -webkit-animation:loader3 1.5s linear infinite;
                        animation:loader3 1.5s linear infinite;
                    }
                    .loader3 span:last-child {
                        animation-delay:-0.9s;
                        -webkit-animation-delay:-0.9s;
                    }
                    @keyframes loader3 {
                        0% {transform: scale(0, 0);opacity:0.8;}
                        100% {transform: scale(1, 1);opacity:0;}
                    }
                    @-webkit-keyframes loader3 {
                        0% {-webkit-transform: scale(0, 0);opacity:0.8;}
                        100% {-webkit-transform: scale(1, 1);opacity:0;}
                    }

                    .loader4 {
                        width:45px;
                        height:45px;
                        display:inline-block;
                        padding:0px;
                        border-radius:100%;
                        border:5px solid;
                        border-top-color:rgba(246, 36, 89, 1);
                        border-bottom-color:rgba(255,255,255, 0.3);
                        border-left-color:rgba(246, 36, 89, 1);
                        border-right-color:rgba(255,255,255, 0.3);
                        -webkit-animation: loader4 1s ease-in-out infinite;
                        animation: loader4 1s ease-in-out infinite;
                    }
                    @keyframes loader4 {
                        from {transform: rotate(0deg);}
                        to {transform: rotate(360deg);}
                    }
                    @-webkit-keyframes loader4 {
                        from {-webkit-transform: rotate(0deg);}
                        to {-webkit-transform: rotate(360deg);}
                    }

                    .loader5 {
                        display:inline-block;
                        width: 0;
                        height:0;
                        border-left: 10px solid transparent;
                        border-right: 10px solid transparent;
                        border-bottom: 10px solid #4183D7;
                        border-top: 10px solid #F5AB35;
                        -webkit-animation: loader5 1.2s ease-in-out infinite alternate;
                        animation: loader5 1.2s ease-in-out infinite alternate;
                    }

                    @keyframes loader5 {
                        from {transform: rotate(0deg);}
                        to {transform: rotate(720deg);}
                    }
                    @-webkit-keyframes loader5 {
                        from {-webkit-transform: rotate(0deg);}
                        to {-webkit-transform: rotate(720deg);}
                    }

                    .loader6 {
                        display:inline-block;
                        width: 20px;
                        height:20px;
                        border-left: 2px solid transparent;
                        border-right: 2px solid transparent;
                        border-bottom: 2px solid #D24D57;
                        border-top: 2px solid #D24D57;
                        -webkit-animation: loader6 1.8s ease-in-out infinite alternate;
                        animation: loader6 1.8s ease-in-out infinite alternate;
                    }

                    .loader6:before {
                        content: " ";
                        position: absolute;
                        z-index: -1;
                        top: 5px;
                        left: 0px;
                        right: 0px;
                        bottom: 5px;
                        border-left: 2px solid #D24D57;
                        border-right: 2px solid #D24D57;
                    }

                    @keyframes loader6 {
                        from {transform: rotate(0deg);}
                        to {transform: rotate(720deg);}
                    }
                    @-webkit-keyframes loader6 {
                        from {-webkit-transform: rotate(0deg);}
                        to {-webkit-transform: rotate(720deg);}
                    }


                    .loader7 {
                        display:inline-block;
                        width: 30px;
                        height: 4px;
                        background:#BE90D4;
                        -webkit-animation: loader7 1.5s linear infinite;
                        animation: loader7 1.5s linear infinite;
                    }


                    @keyframes loader7 {
                        from {transform: rotate(0deg);}
                        to {transform: rotate(720deg);}
                    }
                    @-webkit-keyframes loader7 {
                        from {-webkit-transform: rotate(0deg);}
                        to {-webkit-transform: rotate(720deg);}
                    }
                    .loader8 {
                        display:inline-block;
                        background: rgba(247, 202, 24,0.6);
                        width: 30px;
                        height: 30px;
                        position: relative;
                        text-align: center;

                        -webkit-transform: rotate(20deg);
                        -moz-transform: rotate(20deg);
                        -ms-transform: rotate(20deg);
                        -o-transform: rotate(20eg);
                        -webkit-animation: loader7 3s linear infinite;
                        animation: loader7 3s linear infinite;
                    }
                    .loader8:before {
                        content: "";
                        position: absolute;
                        top: 0;
                        left: 0;
                        height: 30px;
                        width: 30px;
                        background: rgba(247, 202, 24,0.5);
                        -webkit-transform: rotate(135deg);
                        -moz-transform: rotate(135deg);
                        -ms-transform: rotate(135deg);
                        -o-transform: rotate(135deg);
                    }

                    .loader9 {
                        display:inline-block;
                        position: relative;
                        width: 50px;
                        height: 50px;
                        -webkit-animation:loader9 1.5s linear infinite;
                        animation:loader9 1.5s linear infinite;
                    }
                    .loader9:before,
                    .loader9:after {
                        position: absolute;
                        content: "";
                        left: 30px;
                        top: 0;
                        width: 30px;
                        height: 50px;
                        background: red;
                        -moz-border-radius: 30px 30px 0 0;
                        border-radius: 30px 30px 0 0;
                        -webkit-transform: rotate(-45deg);
                        -moz-transform: rotate(-45deg);
                        -ms-transform: rotate(-45deg);
                        -o-transform: rotate(-45deg);
                        transform: rotate(-45deg);
                        -webkit-transform-origin: 0 100%;
                        -moz-transform-origin: 0 100%;
                        -ms-transform-origin: 0 100%;
                        -o-transform-origin: 0 100%;
                        transform-origin: 0 100%;
                    }
                    .loader9:after {
                        left: 0;
                        -webkit-transform: rotate(45deg);
                        -moz-transform: rotate(45deg);
                        -ms-transform: rotate(45deg);
                        -o-transform: rotate(45deg);
                        transform: rotate(45deg);
                        -webkit-transform-origin: 100% 100%;
                        -moz-transform-origin: 100% 100%;
                        -ms-transform-origin: 100% 100%;
                        -o-transform-origin: 100% 100%;
                        transform-origin :100% 100%;
                    }

                    @keyframes loader9 {
                        0% {transform: scale(0, 0);opacity:0;}
                        100% {transform: scale(1, 1);opacity:1;}
                    }
                    @-webkit-keyframes loader9 {
                        0% {-webkit-transform: scale(0, 0);opacity:0;}
                        100% {-webkit-transform: scale(1, 1);opacity:1;}
                    }

                </style>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="color: red">ARE YOU SURE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="deleteP">DELETE</button>
            </div>
        </div>
    </div>
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
<script src="{{(asset('js/jquery.smoothscroll.min.html'))}}"></script>
<!-- Scroll Up Js -->
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('js/main.js')}}"></script>

</body>
<script>
    $('#editQuotation').click(function () {
        $('#spinner').modal('show');
        $name = $('#customer_name').val();
        $estimate_date = $('#estimated_date').val();
        $expiry_date = $('#expiry_date').val();
        $id = $('#estimateId').val();
        $amount = $('#invoiceAmount').val();
        $.ajax({
            type:"get",
            url:"{{url('editInv')}}",
            data:{'name':$name, 'estimate_date':$estimate_date,'expiry_date':$expiry_date,'id':$id,'amount':$amount},
            success:function (data) {
                $('#spinner').modal('hide');
                location.reload();
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
    $(document).on('click','.view',function () {
        $value = $(this).attr('id');
        $.ajax({
            type:"get",
            url:"{{url('getQProducts')}}",
            data:{'id':$value},
            success:function (data) {
                $('#basic1').html(data);
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
    $('#product_name').on('change',function () {
        $value = $(this).val();
        $.ajax({
            type:"get",
            url:"{{url('getAmount')}}",
            data:{'id':$value},
            success:function (data) {
                $('#amountDiv').html(data);
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
    $(document).on('click','.delete',function () {
        $value = $(this).attr('id');
        $.ajax({
            type:"get",
            url:"{{url('deletePro')}}",
            data:{'id':$value},
            success:function (data) {
                alert('Deleted')
                location.reload();
            },
            error:function (error) {
                console.log(error)
                alert('error')

            }

        });
    });
    $('#storeQuotationButton').click(function () {
        var customer_name = $('#customer_name').val();
        var estimated_date = $('#estimated_date').val();
        var expiry_date = $('#expiry_date').val();
        var product_name = $('#product_name').val();
        var quantity = $('#quantity').val();
        var amount = $('#amount').val();
        var id = $('#estimateId').val();
        $.ajax({
            type:"get",
            url:"{{url('storeInvoice')}}",
            data:{'customer_name':customer_name,'estimated_date':estimated_date,'expiry_date':expiry_date,'product_name':product_name,'quantity':quantity,'amount':amount,'id':id},
            success:function (data) {
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
