<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from nouthemes.net/html/mymedi/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jun 2021 05:16:06 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="{{asset('asset/img/jp.png')}}" rel="apple-touch-icon-precomposed">
    <link href="{{asset('asset/img/jp.png')}}" rel="shortcut icon" type="image/png">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" href="{{asset('asset/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/fonts/Linearicons/Font/demo-files/demo.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Jost:400,500,600,700&amp;display=swap&amp;ver=1607580870">
    <link rel="stylesheet" href="{{asset('asset/plugins/bootstrap4/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/owl-carousel/assets/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/slick/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/lightGallery/dist/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/lightGallery/dist/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/noUiSlider/nouislider.css')}}">
    <link rel="stylesheet" href="{{asset('asset/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('asset/css/home-1.css')}}">
</head>

<body>
<div class="ps-page">
    <header class="ps-header ps-header--1">
        <div class="ps-header__top">
            <div class="container">
                <div class="ps-header__text">Need help?</div>
            </div>
        </div>
        <div class="ps-header__middle">
            <div class="container">
                <div class="ps-logo"><a href="{{url('/')}}"> <img src="{{asset('asset/img/jp.png')}}" alt> <span style="font-size: 20px"><b>Japcom Networks</b></span><img class="sticky-logo" src="img/sticky-logo.png" alt></a></div><a class="ps-menu--sticky" href="#"><i class="fa fa-bars"></i></a>
                <div class="ps-header__right">
                    <ul class="ps-header__icons">
                        <li><a class="ps-header__item open-search" href="#"><i class="icon-magnifier"></i></a></li>
                        @if(\Illuminate\Support\Facades\Auth::check())
                        <li><a class="ps-header__item" href="{{url('account')}}"><i class="icon-user"></i></a>
                            @else
                            <li><a class="ps-header__item" href="{{url('login')}}"><i class="icon-enter"></i></a>
                                @endif
                            <div class="ps-login--modal">
                                <form method="get" action="http://nouthemes.net/html/mymedi/do_action">
                                    <div class="form-group">
                                        <label>Username or Email Address</label>
                                        <input class="form-control" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password">
                                    </div>
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox">
                                        <label>Remember Me</label>
                                    </div>
                                    <button class="ps-btn ps-btn--warning" type="submit">Log In</button>
                                </form>
                            </div>
                        </li>
                        <li><a class="ps-header__item" href="wishlist.html"><i class="fa fa-heart-o"></i><span class="badge">3</span></a></li>
                        <li><a class="ps-header__item" href="#" id="cart-mini"><i class="icon-cart-empty"></i><span class="badge">{{\Illuminate\Support\Facades\Session::has('cat') ? \Illuminate\Support\Facades\Session::get('cat')->totalQty: ''}}</span></a>
                            <div class="ps-cart--mini">
                                <ul class="ps-cart__items">
                                    @if(isset($products))
                                        @foreach($products as $product)
                                    <li class="ps-cart__item"   >
                                        <div class="ps-product--mini-cart"><a class="ps-product__thumbnail" href="product-default.html"><img src="{{asset('uploads/product/'.$product['item']['photo'])}}" alt="alt" /></a>
                                            <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">{{$product['item']['name']}} x {{$product['quantity']}}</a>
                                                <p class="ps-product__meta"> <span class="ps-product__price">Ksh:{{$product['item']['amount']*$product['quantity']}}</span></p>
                                            </div><a class="ps-product__remove" href="{{url('cartRemove',$product['item']['id'])}}"><i class="icon-cross"></i></a>
                                        </div>
                                    </li>
                                        @endforeach
                                    @endif
                                </ul>
                                @if(isset($totalPrice))
                                <div class="ps-cart__total"><span>Subtotal </span><span>Ksh:{{$totalPrice}}</span></div>
                                @endif
                                <div class="ps-cart__footer"><a class="ps-btn ps-btn--outline" href="{{url('cart')}}">View Cart</a><a class="ps-btn ps-btn--warning" href="{{url('checkout')}}">Checkout</a></div>
                            </div>
                        </li>
                    </ul>
                    <div class="ps-language-currency"><a class="ps-dropdown-value" href="javascript:void(0);" data-toggle="modal" data-target="#popupLanguage">English</a><a class="ps-dropdown-value" href="javascript:void(0);" data-toggle="modal" data-target="#popupCurrency">USD</a></div>
                    <div class="ps-header__search">
                        <form action="http://nouthemes.net/html/mymedi/do_action" method="post">
                            <div class="ps-search-table">
                                <div class="input-group">
                                    <input class="form-control ps-input" type="text" placeholder="Search for products">
                                    <div class="input-group-append"><a href="#"><i class="fa fa-search"></i></a></div>
                                </div>
                            </div>
                        </form>
                        <div class="ps-search--result">
                            <div class="ps-result__content">
                                <div class="row m-0">
                                    <div class="col-12 col-lg-6">
                                        <div class="ps-product ps-product--horizontal">
                                            <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                                                    <figure><img src="asset/img/products/052.jpg" alt="alt" /></figure>
                                                </a></div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title"><a>3-layer <span class='hightlight'>mask</span> with an elastic band (1 piece)</a></h5>
                                                <p class="ps-product__desc">Study history up to 30 days Up to 5 users simultaneously Has HEALTH certificate</p>
                                                <div class="ps-product__meta"><span class="ps-product__price">$38.24</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="ps-product ps-product--horizontal">
                                            <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                                                    <figure><img src="asset/img/products/033.jpg" alt="alt" /></figure>
                                                </a></div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title"><a>3 Layer Disposable Protective Face <span class='hightlight'>mask</span>s</a></h5>
                                                <p class="ps-product__desc">Study history up to 30 days Up to 5 users simultaneously Has HEALTH certificate</p>
                                                <div class="ps-product__meta"><span class="ps-product__price sale">$14.52</span><span class="ps-product__del">$17.24</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="ps-product ps-product--horizontal">
                                            <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                                                    <figure><img src="asset/img/products/051.jpg" alt="alt" /></figure>
                                                </a></div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title"><a>3-Ply Ear-Loop Disposable Blue Face <span class='hightlight'>mask</span></a></h5>
                                                <p class="ps-product__desc">Study history up to 30 days Up to 5 users simultaneously Has HEALTH certificate</p>
                                                <div class="ps-product__meta"><span class="ps-product__price sale">$14.99</span><span class="ps-product__del">$38.24</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="ps-product ps-product--horizontal">
                                            <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                                                    <figure><img src="asset/img/products/050.jpg" alt="alt" /></figure>
                                                </a></div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title"><a>Disposable Face <span class='hightlight'>mask</span> for Unisex</a></h5>
                                                <p class="ps-product__desc">Study history up to 30 days Up to 5 users simultaneously Has HEALTH certificate</p>
                                                <div class="ps-product__meta"><span class="ps-product__price sale">$8.15</span><span class="ps-product__del">$12.24</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ps-result__viewall"><a href="product-result.html">View all 5 results</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ps-navigation">
            <div class="container">
                <div class="ps-navigation__left">
                    <nav class="ps-main-menu">
                        <ul class="menu">
                            <li class="has-mega-menu"><a href="{{url('/')}}"> <i class="fa fa-bars"></i>Home<span class="sub-toggle"></span></a>
                            </li>
                            <li class="has-mega-menu"><a href="{{url('shop')}}"> Shop<span class="sub-toggle"></span></a>
                            </li>
                            <li class="has-mega-menu"><a href="blog-sidebar1.html">Services</a></li>
                            <li class="has-mega-menu"><a href="contact-us.html">Contact</a></li>
                            <li class="has-mega-menu"><a href="{{url('login')}}">Login</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="ps-navigation__right">Need help? <strong>+254 729 381059</strong></div>
            </div>
        </div>
    </header>
    <header class="ps-header ps-header--1 ps-header--mobile">
        <div class="ps-header__middle">
            <div class="container">
                <div class="ps-logo"><a href="{{url('/')}}"><img src="asset/img/jp.png" alt style="width: 30px;height: 30px"><b>Japcom Networks</b> </a></div>
                <div class="ps-header__right">
                    <ul class="ps-header__icons">
                        <li><a class="ps-header__item open-search" href="#"><i class="fa fa-search"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
