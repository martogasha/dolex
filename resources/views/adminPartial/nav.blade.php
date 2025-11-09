<!doctype html>
<html class="no-js" lang="">


<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:33:39 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/jp.png')}}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{asset('fonts/flaticon.css')}}">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/datepicker.min.css')}}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <!-- Modernize js -->
    <script src="{{asset('js/modernizr-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>

</head>

<body>
<!-- Preloader Start Here -->
<div id="preloader"></div>
<!-- Preloader End Here -->
<div id="wrapper" class="wrapper bg-ash">
    <!-- Header Menu Area Start Here -->
    <div class="navbar navbar-expand-md header-menu-one bg-light" >
        <div class="nav-bar-header-one" >
            <div class="header-logo" style="background-color: white">
                <a href="{{url('admin')}}">
                    <img src="{{asset('img/jp.png')}}" alt="logo"><span>Japcom Networks</span>
                </a>
            </div>
            <div class="toggle-button sidebar-toggle">
                <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                </button>
            </div>
        </div>
        <div class="d-md-none mobile-nav-bar">
            <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse" data-target="#mobile-navbar" aria-expanded="false">
                <i class="far fa-arrow-alt-circle-down"></i>
            </button>
            <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
            <ul class="navbar-nav">
                <li class="navbar-item header-search-bar">
                    <div class="input-group stylish-input-group">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="flaticon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                        <input type="text" class="form-control" placeholder="Find Something . . .">
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="navbar-item dropdown header-admin">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        @if(\Illuminate\Support\Facades\Auth::check())
                        <div class="admin-title">
                            <h5 class="item-title">{{\Illuminate\Support\Facades\Auth::user()->first_name}} {{\Illuminate\Support\Facades\Auth::user()->last_name}}</h5>
                            @if(\Illuminate\Support\Facades\Auth::user()->role==0)
                            <span>Admin</span>
                            @else
                                <span>Employee</span>

                            @endif
                        </div>
                        @endif
                        <div class="admin-img">
                            <img src="img/figure/admin.jpg" alt="Admin">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            @if(\Illuminate\Support\Facades\Auth::check())
                            <h6 class="item-title">{{\Illuminate\Support\Facades\Auth::user()->first_name}} {{\Illuminate\Support\Facades\Auth::user()->last_name}}</h6>
                        @endif
                        </div>
                        <div class="item-content">
                            <ul class="settings-list">
                                <li><a href="{{url('profile')}}"><i class="flaticon-user"></i>My Profile</a></li>
                                <form action="{{route('logout')}}" method="post" id="logoutButton">
                                    @csrf
                                <li><a href="javascript:document.getElementById('logoutButton').submit();"><i class="flaticon-turn-off"></i>Log Out</a></li>
                                </form>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="navbar-item dropdown header-message">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="far fa-envelope"></i>
                        <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                        <span>5</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">05 Message</h6>
                        </div>
                        <div class="item-content">
                            <div class="media">
                                <div class="item-img bg-skyblue author-online">
                                    <img src="img/figure/student11.png" alt="img">
                                </div>
                                <div class="media-body space-sm">
                                    <div class="item-title">
                                        <a href="#">
                                            <span class="item-name">Maria Zaman</span>
                                            <span class="item-time">18:30</span>
                                        </a>
                                    </div>
                                    <p>What is the reason of buy this item.
                                        Is it usefull for me.....</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="item-img bg-yellow author-online">
                                    <img src="img/figure/student12.png" alt="img">
                                </div>
                                <div class="media-body space-sm">
                                    <div class="item-title">
                                        <a href="#">
                                            <span class="item-name">Benny Roy</span>
                                            <span class="item-time">10:35</span>
                                        </a>
                                    </div>
                                    <p>What is the reason of buy this item.
                                        Is it usefull for me.....</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="item-img bg-pink">
                                    <img src="img/figure/student13.png" alt="img">
                                </div>
                                <div class="media-body space-sm">
                                    <div class="item-title">
                                        <a href="#">
                                            <span class="item-name">Steven</span>
                                            <span class="item-time">02:35</span>
                                        </a>
                                    </div>
                                    <p>What is the reason of buy this item.
                                        Is it usefull for me.....</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="item-img bg-violet-blue">
                                    <img src="img/figure/student11.png" alt="img">
                                </div>
                                <div class="media-body space-sm">
                                    <div class="item-title">
                                        <a href="#">
                                            <span class="item-name">Joshep Joe</span>
                                            <span class="item-time">12:35</span>
                                        </a>
                                    </div>
                                    <p>What is the reason of buy this item.
                                        Is it usefull for me.....</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="navbar-item dropdown header-notification">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="far fa-bell"></i>
                        <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                        <span>8</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">03 Notifiacations</h6>
                        </div>
                        <div class="item-content">
                            <div class="media">
                                <div class="item-icon bg-skyblue">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="post-title">Complete Today Task</div>
                                    <span>1 Mins ago</span>
                                </div>
                            </div>
                            <div class="media">
                                <div class="item-icon bg-orange">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="post-title">Director Metting</div>
                                    <span>20 Mins ago</span>
                                </div>
                            </div>
                            <div class="media">
                                <div class="item-icon bg-violet-blue">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="post-title">Update Password</div>
                                    <span>45 Mins ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Header Menu Area End Here -->
    <!-- Page Area Start Here -->
    <div class="dashboard-page-one">
        <!-- Sidebar Area Start Here -->
        <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
            <div class="mobile-sidebar-header d-md-none">
                <div class="header-logo">
                    <a href="{{url('admin')}}"><h3 style="color: white">Japcom Networks</h3></a>
                </div>
            </div>
            <div class="sidebar-menu-content">
                <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                    <li class="nav-item sidebar-nav-item">
                        <a href="{{url('admin')}}" class="nav-link"><i class="flaticon-dashboard"></i><span>Dashboard</span></a>
                    </li>
                    @if(\Illuminate\Support\Facades\Auth::user()->products==5)
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Products</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('products')}}" class="nav-link"><i class="fas fa-angle-right"></i>All
                                    Products</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('addProduct')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>Add Product</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->users==6)
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Users</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('employees')}}" class="nav-link"><i class="fas fa-angle-right"></i>All
                                    Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('addEmployee')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>Add User</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->customers==7)
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Customers</span></a>
                        <ul class="nav sub-group-menu">
                             <li class="nav-item">
                                <a href="{{url('pppoe')}}" class="nav-link"><i class="fas fa-angle-right"></i>PPPOE</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('customers')}}" class="nav-link"><i class="fas fa-angle-right"></i>Active
                                    Customers</a>
                            </li>
                             <li class="nav-item">
                                <a href="{{url('Selectcustomers')}}" class="nav-link"><i class="fas fa-angle-right"></i>Select
                                    Customers</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('addCustomer')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>Add Customer</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->payments==8)
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="flaticon-multiple-users-silhouette"></i><span>Payments</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('mpesa')}}" class="nav-link"><i class="fas fa-angle-right"></i>Mpesa</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('cash')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>Cash</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->expenses==9)
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-couple"></i><span>Expenses</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('expenses')}}" class="nav-link"><i class="fas fa-angle-right"></i>All
                                    Expenses</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('addExpense')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>Add Expense</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->estimate==10)
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-couple"></i><span>Estimate</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('quotation')}}" class="nav-link"><i class="fas fa-angle-right"></i>Create Estimate</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('viewQuotation')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>All Estimate</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->invoice==11)
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-couple"></i><span>Invoice</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('viewInvoice')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>All invoices</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('createInvoice')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>Create Invoices</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-couple"></i><span>Billing</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('bill')}}" class="nav-link"><i
                                        class="fas fa-angle-right"></i>Bill Customer</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
