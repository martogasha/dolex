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
                            @if(\Illuminate\Support\Facades\Auth::user()->role==5)
                            <span>Technician</span>
                            @endif
                              @if(\Illuminate\Support\Facades\Auth::user()->role==6)
                            <span>Sales</span>
                            @endif
                             @if(\Illuminate\Support\Facades\Auth::user()->role==7)
                            <span>Finance</span>
                            @endif
                              @if(\Illuminate\Support\Facades\Auth::user()->role==0)
                            <span>Admin</span>
                            @endif
                        </div>
                        @endif
                        <div class="admin-img">
                            <img src="{{asset('img/figure/admin.jpg')}}" alt="Admin">
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
           
            </ul>
        </div>
    </div>
    <!-- Header Menu Area End Here -->
    <!-- Page Area Start Here -->
    <div class="dashboard-page-one">
        <!-- Sidebar Area Start Here -->
        <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
         <div class="mobile-sidebar-header d-md-none">
                  
               </div>
            <div class="sidebar-menu-content">
                @auth
                <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        @if(auth()->user()->products!=null)
                        <li class="nav-item sidebar-nav-item">
                            <a href="{{url('admin')}}" class="nav-link"><i class="flaticon-dashboard"></i><span>Dashboard</span></a>
                        </li>
                        @endif
              
                        @if(auth()->user()->customers!=null)
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Customers</span></a>
                            <ul class="nav sub-group-menu">
                            
                                <li class="nav-item">
                                    <a href="{{url('customers')}}" class="nav-link"><i class="fas fa-angle-right"></i>Active
                                        Customers</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('all')}}" class="nav-link"><i class="fas fa-angle-right"></i>Disconnected
                                        Customers</a>
                                </li>
                           
                                <li class="nav-item">
                                    <a href="{{url('noneActivecustomers')}}" class="nav-link"><i class="fas fa-angle-right"></i>Non-Active
                                        Customers</a>
                                </li>
                          

                        
                            </ul>
                        </li>
                        @endif

                            @if(auth()->user()->customers!=null)
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Mikrotiks ({{App\Models\Mik::count()}})</span></a>
                            <ul class="nav sub-group-menu">
                            @foreach($mikrotiks as $mikrotik)
                                <li class="nav-item">
                                    <a href="{{url('mikrotikDetail',$mikrotik->id)}}" class="nav-link"><i class="fas fa-angle-right"></i>{{$mikrotik->name}}</a>
                                </li>
                            @endforeach

                        
                            </ul>
                        </li>
                        @endif
                   
                        @if(auth()->user()->payments!=null)
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i
                                    class="flaticon-books"></i><span>Payments</span></a>
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
            
             
                 

              
                        @if(auth()->user()->estimate!=null)
                         <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-settings"></i><span>Mikrotik Management</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{url('listMikrotik')}}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>List Mikrotiks</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('addMikrotik')}}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Add Mikrotik</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                         @if(auth()->user()->amount_supposed_to_be_paid!=null)
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-open-book"></i><span>Logs</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{url('logs')}}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Logs</a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        @if(auth()->user()->users!=null)
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-couple"></i><span>Users</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{url('users')}}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Users</a>
                                </li>

                                    <li class="nav-item">
                                    <a href="{{url('addUser')}}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Add Users</a>
                                </li>
                            </ul>
                        </li>
                        @endif

                </ul>
                @endauth
            </div>
        </div>
