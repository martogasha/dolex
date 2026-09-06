@include('adminPartial.nav')
<title>Mikrotik Management | Henix</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Mikrotiks</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                    </li>
                    <li>Mikrotiks</li>
                </ul>
            </div>

            <!-- Breadcubs Area End Here -->
            <!-- Student Table Area Start Here -->
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Mikrotiks</h3>
                        </div>
              
                    </div>
                            @include('flash-message')
                    <div class="table-responsive">
                        <div class="col-lg-12 col-12 form-group">
                            <label>Search</label>
                            <input type="text" placeholder="Search" class="form-control" id="myInput">
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>

                                <th>Mikrotik Name</th>
                                <th>Mikrotik Ip Address</th>
                                <th>Mikrotik User</th>
                                <th>Mikrotik Password</th>
                                <th>Action</th>
                          
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach($mpesas as $mpesa)
                            <tr>

                                <td>{{$mpesa->name}}</td>
                                <td>{{$mpesa->ip}}</td>
                                <td>{{$mpesa->user}}</td>
                                <td>{{$mpesa->password}}</td>
                                <td>
                                        <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" 
                                        data-toggle="dropdown" aria-expanded="false">...</a>
                
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                            <a class="dropdown-item" href="{{url('editMikrotik',$mpesa->id)}}"><i
                                                        class="fas fa-edit text-blue"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
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
                <div class="copyright">© Copyrights <a href="#">Henix</a> 2026. All rights reserved. Designed by <a
                        href="#">Henix Technologies</a></div>
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
