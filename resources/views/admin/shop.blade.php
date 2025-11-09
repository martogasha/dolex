@include('clientPartial.nav')
<title>Shop - Japcom Networks</title>
<header class="ps-header ps-header--13 ps-header--mobile">
        <div class="ps-noti">
            <div class="container">
                <p class="m-0">Due to the <strong>COVID 19 </strong>epidemic, orders may be processed with a slight delay</p>
            </div><a class="ps-noti__close"><i class="icon-cross"></i></a>
        </div>
        <div class="ps-header__middle">
            <div class="container">
                <div class="ps-header__left">
                    <ul class="ps-header__icons">
                        <li><a class="ps-header__item open-search" href="#"><i class="fa fa-search"></i></a></li>
                    </ul>
                </div>
                <div class="ps-logo"><a href="index-2.html"> <img src="img/logo-green.png" alt></a></div>
                <div class="ps-header__right">
                    <ul class="ps-header__icons">
                        <li><a class="ps-header__item" href="#"><i class="icon-cart-empty"></i><span class="badge">2</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="ps-categogy ps-categogy--dark">
        <div class="container">
            <ul class="ps-breadcrumb">
                <li class="ps-breadcrumb__item"><a href="{{url('/')}}">Home</a></li>
                <li class="ps-breadcrumb__item"><a href="{{url('shop')}}">Shop</a></li>
            </ul>
            <h1 class="ps-categogy__name">Face Masks - protective<sup>(150)</sup></h1>
            <div class="ps-categogy__content">
                <div class="row row-reverse">
                    <div class="col-12 col-md-9">
                        <div class="ps-categogy__wrapper">
                            <div class="ps-categogy__type"> <a href="category-list.html"><img src="img/icon/bars-dark.svg" alt></a><a href="category-grid-detail.html"><img src="img/icon/gird2-dark.svg" alt></a><a class="active" href="category-grid-green.html"><img src="img/icon/gird3-dark.svg" alt></a><a href="category-grid-separate.html"><img src="img/icon/gird4-dark.svg" alt></a></div>
                            <div class="ps-categogy__onsale">
                                <form>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="onSaleProduct">
                                        <label class="custom-control-label" for="onSaleProduct">Show only products on sale</label>
                                    </div>
                                </form>
                            </div>
                            <div class="ps-categogy__sort">
                                <form><span>Sort by</span>
                                    <select class="form-select">
                                        <option selected>Latest</option>
                                        <option value="Popularity">Popularity</option>
                                        <option value="Average rating">Average rating</option>
                                        <option value="Latest">Latest</option>
                                        <option value="Price: low to high">Price: low to high</option>
                                        <option value="Price: high to low">Price: high to low</option>
                                    </select>
                                </form>
                            </div>
                            <div class="ps-categogy__show">
                                <form><span>Show</span>
                                    <select class="form-select">
                                        <option selected>15</option>
                                        <option value="23">23</option>
                                        <option value="35">35</option>
                                        <option value="47">47</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="ps-categogy--grid">
                            <div class="row m-0">
                                @foreach($shops as $shop)
                                <div class="col-6 col-lg-4 col-xl-3 p-0">
                                    <div class="ps-product ps-product--standard">
                                        <div class="ps-product__thumbnail"><a class="ps-product__image" href="{{url('productDetail',$shop->id)}}">
                                                <figure><img src="{{asset('uploads/product/'.$shop->photo)}}" alt="alt" /><img src="img/products/medicine5.jpg" alt="alt" />
                                                </figure>
                                            </a>
                                            <div class="ps-product__actions">
                                                <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="#"><i class="fa fa-heart-o"></i></a></div>
                                                <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="#" data-toggle="modal" data-target="#popupCompare"><i class="fa fa-align-left"></i></a></div>
                                                <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Quick view"><a href="#" data-toggle="modal" data-target="#popupQuickview"><i class="fa fa-search"></i></a></div>
                                                <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#" data-toggle="modal" data-target="#popupAddcart"><i class="fa fa-shopping-basket"></i></a></div>
                                            </div>
                                            <div class="ps-product__badge">
                                                <div class="ps-badge ps-badge--sale">Sale</div>
                                            </div>
                                        </div>
                                        <div class="ps-product__content">
                                            <h5 class="ps-product__title"><a href="product1.html">{{$shop->name}}</a></h5>
                                            <div class="ps-product__meta"><span class="ps-product__price">Ksh {{$shop->amount}}</span>
                                            </div>
                                            <div class="ps-product__rating">
                                                <select class="ps-rating" data-read-only="true">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3" selected="selected">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select><span class="ps-product__review">( Reviews)</span>
                                            </div>
                                            <div class="ps-product__desc">
                                                <ul class="ps-product__list">
                                                    <li>Study history up to 30 days</li>
                                                    <li>Up to 5 users simultaneously</li>
                                                    <li>Has HEALTH certificate</li>
                                                </ul>
                                            </div>
                                            <div class="ps-product__actions ps-product__group-mobile">
                                                <div class="ps-product__quantity">
                                                    <div class="def-number-input number-input safari_only">
                                                        <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                        <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                        <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="ps-product__cart"> <a class="ps-btn ps-btn--warning" href="#" data-toggle="modal" data-target="#popupAddcart">Add to cart</a></div>
                                                <div class="ps-product__item cart" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#"><i class="fa fa-shopping-basket"></i></a></div>
                                                <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="wishlist.html"><i class="fa fa-heart-o"></i></a></div>
                                                <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="compare.html"><i class="fa fa-align-left"></i></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-6 col-lg-4 col-xl-3 p-0"> <a class="ps-nextpage" href="#"><span class="ps-nextpage__text">Next <br>page</span><i class="fa fa-chevron-right"></i></a></div>
                            </div>
                        </div>
                        <div class="ps-pagination">
                            <ul class="pagination">
                                <li><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-delivery ps-delivery--info" data-background="img/promotion/banner-delivery-3.jpg">
                            <div class="ps-delivery__content">
                                <div class="ps-delivery__text"> <i class="icon-shield-check"></i><span> <strong>100% Secure delivery </strong>without contacting the courier</span></div><a class="ps-delivery__more" href="#">More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="ps-widget ps-widget--product">
                            <div class="ps-widget__block">
                                <h4 class="ps-widget__title">Categories</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                                <div class="ps-widget__content ps-widget__category">
                                    <ul class="menu--mobile">
                                        <li><a href="#">Diagnosis</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                <li><a href="#">Biopsy tools</a></li>
                                                <li><a href="#">Endoscopes</a></li>
                                                <li><a href="#">Monitoring</a></li>
                                                <li><a href="#">Otoscopes</a></li>
                                                <li><a href="#">Oxygen concentrators</a></li>
                                                <li><a href="#">Tables and assistants</a></li>
                                                <li><a href="#">Thermometer</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Equipment</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                <li><a href="#">Blades</a></li>
                                                <li><a href="#">Education</a></li>
                                                <li><a href="#">Germicidal lamps</a></li>
                                                <li><a href="#">Heart Health</a></li>
                                                <li><a href="#">Infusion stands</a></li>
                                                <li><a href="#">Lighting</a></li>
                                                <li><a href="#">Machines</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Higiene</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                <li><a href="#">Disposable products</a></li>
                                                <li><a href="#">Face masks</a></li>
                                                <li><a href="#">Gloves</a></li>
                                                <li><a href="#">Protective covers</a></li>
                                                <li><a href="#">Sterilization</a></li>
                                                <li><a href="#">Surgical foils</a></li>
                                                <li><a href="#">Uniforms</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Laboratory</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                <li><a href="#">Devices</a></li>
                                                <li><a href="#">Diagnostic tests</a></li>
                                                <li><a href="#">Disinfectants</a></li>
                                                <li><a href="#">Dyes</a></li>
                                                <li><a href="#">Pipettes</a></li>
                                                <li><a href="#">Test-tubes</a></li>
                                                <li><a href="#">Tubes</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Tools</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                <li><a href="#">Accessories Tools</a></li>
                                                <li><a href="#">Blood pressure</a></li>
                                                <li><a href="#">Capsules</a></li>
                                                <li><a href="#">Dental</a></li>
                                                <li><a href="#">Micrscope</a></li>
                                                <li><a href="#">Pressure</a></li>
                                                <li><a href="#">Sugar level</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Wound Care</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                <li><a href="#">Bandages</a></li>
                                                <li><a href="#">Gypsum foundations</a></li>
                                                <li><a href="#">Patches and tapes</a></li>
                                                <li><a href="#">Stomatology</a></li>
                                                <li><a href="#">Surgical sutures</a></li>
                                                <li><a href="#">Uniforms</a></li>
                                                <li><a href="#">Wound healing</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ps-widget__block">
                                <h4 class="ps-widget__title">By price</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                                <div class="ps-widget__content">
                                    <div class="ps-widget__price">
                                        <div id="slide-price"></div>
                                    </div>
                                    <div class="ps-widget__input"><span class="ps-price" id="slide-price-min">$0</span><span class="bridge">-</span><span class="ps-price" id="slide-price-max">$820</span></div>
                                    <button class="ps-widget__filter">Filter</button>
                                </div>
                            </div>
                            <div class="ps-widget__block">
                                <h4 class="ps-widget__title">Color</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                                <div class="ps-widget__content">
                                    <div class="ps-widget__color">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="colorGray">
                                            <label class="custom-control-label" for="colorGray" style="--bg-color: #5b6c8f"></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="colorGreen">
                                            <label class="custom-control-label" for="colorGreen" style="--bg-color: #12a05c"></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="colorRed">
                                            <label class="custom-control-label" for="colorRed" style="--bg-color: #f00000"></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="colorYellow">
                                            <label class="custom-control-label" for="colorYellow" style="--bg-color: #ff9923"></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="colorBlack">
                                            <label class="custom-control-label" for="colorBlack" style="--bg-color: #313330"></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="colorBlue">
                                            <label class="custom-control-label" for="colorBlue" style="--bg-color: #58c8ec"></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="colorNavy">
                                            <label class="custom-control-label" for="colorNavy" style="--bg-color: #103178"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-widget__block">
                                <h4 class="ps-widget__title">Brands</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                                <div class="ps-widget__content">
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="BestPharm">
                                            <label class="custom-control-label" for="BestPharm">BestPharm</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="HeartRate">
                                            <label class="custom-control-label" for="HeartRate">HeartRate</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="HeartShield">
                                            <label class="custom-control-label" for="HeartShield">HeartShield</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="iHeart">
                                            <label class="custom-control-label" for="iHeart">iHeart</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="iLovehealth">
                                            <label class="custom-control-label" for="iLovehealth">iLovehealth</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="Medialarm">
                                            <label class="custom-control-label" for="Medialarm">Medialarm</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="Medicstore">
                                            <label class="custom-control-label" for="Medicstore">Medicstore</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="MyMedi">
                                            <label class="custom-control-label" for="MyMedi">MyMedi</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="Pharmy">
                                            <label class="custom-control-label" for="Pharmy">Pharmy</label>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="WeTakeCare">
                                            <label class="custom-control-label" for="WeTakeCare">WeTakeCare</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-widget__block">
                                <h4 class="ps-widget__title">Ratings</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                                <div class="ps-widget__content">
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="rating5">
                                            <label class="custom-control-label" for="rating5"> </label>
                                            <div class="custom-label">
                                                <select class="ps-rating" data-read-only="true">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5" selected="selected">5</option>
                                                </select><span>(6)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-widget__item">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="rating4">
                                            <label class="custom-control-label" for="rating4"> </label>
                                            <div class="custom-label">
                                                <select class="ps-rating" data-read-only="true">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4" selected="selected">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(9)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-widget__promo"><img src="img/banner-sidebar1.jpg" alt></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ps-section--newsletter ps-section--newsletter-inline">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-7">
                        <h3 class="ps-section__title">Join our newsletter and get $20 discount for your first order</h3>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="ps-section__content">
                            <form action="http://nouthemes.net/html/mymedi/do_action" method="post">
                                <div class="ps-form--subscribe">
                                    <div class="ps-form__control">
                                        <input class="form-control ps-input" type="email" placeholder="Enter your email address">
                                        <button class="ps-btn ps-btn--warning">Subscribe</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="ps-footer ps-footer--13">
            <div class="ps-footer--top">
                <div class="container">
                    <div class="row m-0">
                        <div class="col-12 col-sm-4 p-0">
                            <p class="text-center"><a class="ps-footer__link" href="#"><i class="icon-wallet"></i>100% Money back</a></p>
                        </div>
                        <div class="col-12 col-sm-4 p-0">
                            <p class="text-center"><a class="ps-footer__link" href="#"><i class="icon-bag2"></i>Non-contact shipping</a></p>
                        </div>
                        <div class="col-12 col-sm-4 p-0">
                            <p class="text-center"><a class="ps-footer__link" href="#"><i class="icon-truck"></i>Free delivery for order over $200</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="ps-footer__middle">
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="ps-footer--address">
                                        <div class="ps-logo"><a href="index-2.html"> <img src="img/sticky-logo.png" alt><img class="logo-white" src="img/logo-white.png" alt><img class="logo-black" src="img/Logo-black.png" alt><img class="logo-white-all" src="img/logo-white1.png" alt><img class="logo-green" src="img/logo-green.png" alt></a></div>
                                        <div class="ps-footer__title">Our store</div>
                                        <p>1487 Rocky Horse Carrefour<br>Arlington, TX 16819</p>
                                        <p><a target="_blank" href="https://www.google.com/maps/place/Arlington,+TX,+USA/@32.701968,-97.2054529,12z/data=!3m1!4b1!4m8!1m2!2m1!1s1487+Rocky+Horse+Carrefour+Arlington,+TX+16819!3m4!1s0x864e62d2e40898d3:0xb5ef6ac1fa05351!8m2!3d32.735687!4d-97.1080656">Show on map</a></p>
                                        <ul class="ps-social">
                                            <li><a class="ps-social__link facebook" href="#"><i class="fa fa-facebook"> </i><span class="ps-tooltip">Facebook</span></a></li>
                                            <li><a class="ps-social__link instagram" href="#"><i class="fa fa-instagram"></i><span class="ps-tooltip">Instagram</span></a></li>
                                            <li><a class="ps-social__link youtube" href="#"><i class="fa fa-youtube-play"></i><span class="ps-tooltip">Youtube</span></a></li>
                                            <li><a class="ps-social__link pinterest" href="#"><i class="fa fa-pinterest-p"></i><span class="ps-tooltip">Pinterest</span></a></li>
                                            <li><a class="ps-social__link linkedin" href="#"><i class="fa fa-linkedin"></i><span class="ps-tooltip">Linkedin</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="ps-footer--contact">
                                        <h5 class="ps-footer__title">Need help</h5>
                                        <div class="ps-footer__fax"><i class="icon-telephone"></i>0020 500 – MYMEDI – 000</div>
                                        <p class="ps-footer__work">Monday – Friday: 9:00-20:00<br>Saturday: 11:00 – 15:00</p>
                                        <hr>
                                        <p><a class="ps-footer__email" href="http://nouthemes.net/cdn-cgi/l/email-protection#1d7e7273697c7e695d78657c706d7178337e7270"> <i class="icon-envelope"></i><span class="__cf_email__" data-cfemail="b0d3dfdec4d1d3c4f0d5c8d1ddc0dcd59ed3dfdd">[email&#160;protected]</span> </a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <div class="ps-footer--block">
                                        <h5 class="ps-block__title">Information</h5>
                                        <ul class="ps-block__list">
                                            <li><a href="about-us.html">About us</a></li>
                                            <li><a href="#">Delivery information</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                            <li><a href="#">Sales</a></li>
                                            <li><a href="#">Terms &amp; Conditions</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="ps-footer--block">
                                        <h5 class="ps-block__title">Account</h5>
                                        <ul class="ps-block__list">
                                            <li><a href="#">My account</a></li>
                                            <li><a href="#">My orders</a></li>
                                            <li><a href="#">Returns</a></li>
                                            <li><a href="#">Shipping</a></li>
                                            <li><a href="wishlist.html">Wishlist</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="ps-footer--block">
                                        <h5 class="ps-block__title">Store</h5>
                                        <ul class="ps-block__list">
                                            <li><a href="#">Affiliate</a></li>
                                            <li><a href="#">Bestsellers</a></li>
                                            <li><a href="#">Discount</a></li>
                                            <li><a href="#">Latest products</a></li>
                                            <li><a href="#">Sale</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-footer--bottom">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <p>Copyright © 2021 Mymedi. All Rights Reserved</p>
                        </div>
                        <div class="col-12 col-md-6 text-right"><img src="img/payment.png" alt><img class="payment-light" src="img/payment-light.png" alt></div>
                    </div>
                </div>
            </div>
            <div class="ps-promo ps-footer--banner">
                <div class="ps-promo__item"><img class="ps-promo__banner" src="img/promotion/footer-banner.jpg" alt>
                    <div class="ps-promo__content">
                        <h4 class="ps-promo__name">Magic Mind</h4>
                        <p class="ps-promo__desc">New delivery!</p><a class="ps-promo__btn btn-green" href="#">Shop now</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<div class="ps-search">
    <div class="ps-search__content ps-search--mobile"><a class="ps-search__close" href="#" id="close-search"><i class="icon-cross"></i></a>
        <h3>Search</h3>
        <form action="http://nouthemes.net/html/mymedi/do_action" method="post">
            <div class="ps-search-table">
                <div class="input-group">
                    <input class="form-control ps-input" type="text" placeholder="Search for products">
                    <div class="input-group-append"><a href="#"><i class="fa fa-search"></i></a></div>
                </div>
            </div>
        </form>
        <div class="ps-search__result">
            <div class="ps-search__item">
                <div class="ps-product ps-product--horizontal">
                    <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                            <figure><img src="img/products/052.jpg" alt="alt" /></figure>
                        </a></div>
                    <div class="ps-product__content">
                        <h5 class="ps-product__title"><a>3-layer <span class='hightlight'>mask</span> with an elastic band (1 piece)</a></h5>
                        <p class="ps-product__desc">Study history up to 30 days Up to 5 users simultaneously Has HEALTH certificate</p>
                        <div class="ps-product__meta"><span class="ps-product__price">$38.24</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-search__item">
                <div class="ps-product ps-product--horizontal">
                    <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                            <figure><img src="img/products/033.jpg" alt="alt" /></figure>
                        </a></div>
                    <div class="ps-product__content">
                        <h5 class="ps-product__title"><a>3 Layer Disposable Protective Face <span class='hightlight'>mask</span>s</a></h5>
                        <p class="ps-product__desc">Study history up to 30 days Up to 5 users simultaneously Has HEALTH certificate</p>
                        <div class="ps-product__meta"><span class="ps-product__price sale">$14.52</span><span class="ps-product__del">$17.24</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-search__item">
                <div class="ps-product ps-product--horizontal">
                    <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                            <figure><img src="img/products/051.jpg" alt="alt" /></figure>
                        </a></div>
                    <div class="ps-product__content">
                        <h5 class="ps-product__title"><a>3-Ply Ear-Loop Disposable Blue Face <span class='hightlight'>mask</span></a></h5>
                        <p class="ps-product__desc">Study history up to 30 days Up to 5 users simultaneously Has HEALTH certificate</p>
                        <div class="ps-product__meta"><span class="ps-product__price sale">$14.99</span><span class="ps-product__del">$38.24</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-search__item">
                <div class="ps-product ps-product--horizontal">
                    <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                            <figure><img src="img/products/050.jpg" alt="alt" /></figure>
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
    </div>
</div>
<div class="ps-navigation--footer">
    <div class="ps-nav__item"><a href="#" id="open-menu"><i class="icon-menu"></i></a><a href="#" id="close-menu"><i class="icon-cross"></i></a></div>
    <div class="ps-nav__item"><a href="index-2.html"><i class="icon-home2"></i></a></div>
    <div class="ps-nav__item"><a href="my-account.html"><i class="icon-user"></i></a></div>
    <div class="ps-nav__item"><a href="wishlist.html"><i class="fa fa-heart-o"></i><span class="badge">3</span></a></div>
    <div class="ps-nav__item"><a href="shopping-cart.html"><i class="icon-cart-empty"></i><span class="badge">2</span></a></div>
</div>
<div class="ps-menu--slidebar">
    <div class="ps-menu__content">
        <ul class="menu--mobile">
            <li class="menu-item-has-children"><a href="#">Products</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                <ul class="sub-menu">
                    <li><a href="#">Wound Care</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                        <ul class="sub-menu">
                            <li><a href="category-list.html">Bandages</a></li>
                            <li><a href="category-list.html">Gypsum foundations</a></li>
                            <li><a href="category-list.html">Patches and tapes</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Higiene</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                        <ul class="sub-menu">
                            <li><a href="category-list.html">Disposable products</a></li>
                            <li><a href="category-list.html">Face masks</a></li>
                            <li><a href="category-list.html">Gloves</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Laboratory</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                        <ul class="sub-menu">
                            <li><a href="category-list.html">Devices</a></li>
                            <li><a href="category-list.html">Diagnostic tests</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="menu-item-has-children"><a href="#">Home Medical Supplies</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                <ul class="sub-menu">
                    <li><a href="category-list.html">Diagnosis</a></li>
                    <li><a href="category-list.html">Accessories Tools</a></li>
                    <li><a href="category-list.html">Bandages</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children"><a href="#">Homepages</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                <ul class="sub-menu">
                    <li><a href="index-2.html">Home 01</a></li>
                    <li><a href="home2.html">Home 02</a></li>
                    <li><a href="home3.html">Home 03</a></li>
                    <li><a href="home4.html">Home 04</a></li>
                    <li><a href="home5.html">Home 05</a></li>
                    <li><a href="home6.html">Home 06</a></li>
                    <li><a href="home7.html">Home 07</a></li>
                    <li><a href="home8.html">Home 08</a></li>
                    <li><a href="home9.html">Home 09</a></li>
                    <li><a href="home10.html">Home 10</a></li>
                    <li><a href="home11.html">Home 11</a></li>
                    <li><a href="home12.html">Home 12</a></li>
                    <li><a href="home13.html">Home 13</a></li>
                    <li><a href="home14.html">Home 14</a></li>
                    <li><a href="home15.html">Home 15</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children"><a href="category-list.html">Shop</a></li>
            <li class="menu-item-has-children"><a href="#">Pages</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                <ul class="sub-menu">
                    <li><a href="#">Category</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                        <ul class="sub-menu">
                            <li><a href="category-grid.html">Grid</a></li>
                            <li><a href="category-grid-detail.html">Grid with details</a></li>
                            <li><a href="category-grid-green.html">Grid with header green</a></li>
                            <li><a href="category-grid-dark.html">Grid with header dark</a></li>
                            <li><a href="category-grid-separate.html">Grid separate</a></li>
                            <li><a href="category-list.html">List</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Product</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                        <ul class="sub-menu">
                            <li><a href="product1.html">Layout 01</a></li>
                            <li><a href="product2.html">Layout 02</a></li>
                            <li><a href="product3.html">Layout 03</a></li>
                            <li><a href="product4.html">Layout 04</a></li>
                            <li><a href="product5.html">Layout 05</a></li>
                            <li><a href="product6.html">Layout 06</a></li>
                            <li><a href="product7.html">Layout 07</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Pages</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                        <ul class="sub-menu">
                            <li><a href="404.html">404</a></li>
                            <li><a href="about-us.html">About us</a></li>
                            <li><a href="my-account.html">My Account</a></li>
                            <li><a href="coming-soon-v1.html">Coming soon 1</a></li>
                            <li><a href="coming-soon-v2.html">Coming soon 2</a></li>
                            <li><a href="blog-post1.html">Blog post 1</a></li>
                            <li><a href="blog-post2.html">Blog post 2</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="menu-item-has-children"><a href="#">Collection</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                <ul class="sub-menu">
                    <li><a href="category-list.html">Face masks</a></li>
                    <li><a href="category-list.html">Dental</a></li>
                    <li><a href="category-list.html">Micrscope</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children"><a href="blog-sidebar1.html">Blog</a></li>
            <li class="menu-item-has-children"><a href="contact-us.html">Contact</a></li>
        </ul>
    </div>
    <div class="ps-menu__footer">
        <div class="ps-menu__item">
            <ul class="ps-language-currency">
                <li class="menu-item-has-children"><a href="#">English</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                    <ul class="sub-menu">
                        <li><a href="#">Français</a></li>
                        <li><a href="#">Deutsch</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children"><a href="#">USD</a><span class="sub-toggle"><i class="fa fa-chevron-down"></i></span>
                    <ul class="sub-menu">
                        <li><a href="#">USD</a></li>
                        <li><a href="#">EUR</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="ps-menu__item">
            <div class="ps-menu__contact">Need help? <strong>0020 500 - MYMEDI - 000</strong></div>
        </div>
    </div>
</div>
<button class="btn scroll-top"><i class="fa fa-angle-double-up"></i></button>
<div class="ps-preloader" id="preloader">
    <div class="ps-preloader-section ps-preloader-left"></div>
    <div class="ps-preloader-section ps-preloader-right"></div>
</div>
<div class="modal fade" id="popupQuickview" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered ps-quickview">
        <div class="modal-content">
            <div class="modal-body">
                <div class="wrap-modal-slider container-fluid ps-quickview__body">
                    <button class="close ps-quickview__close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="ps-product--detail">
                        <div class="row">
                            <div class="col-12 col-xl-6">
                                <div class="ps-product--gallery">
                                    <div class="ps-product__thumbnail">
                                        <div class="slide"><img src="img/products/001.jpg" alt="alt" /></div>
                                        <div class="slide"><img src="img/products/047.jpg" alt="alt" /></div>
                                        <div class="slide"><img src="img/products/047.jpg" alt="alt" /></div>
                                        <div class="slide"><img src="img/products/008.jpg" alt="alt" /></div>
                                        <div class="slide"><img src="img/products/034.jpg" alt="alt" /></div>
                                    </div>
                                    <div class="ps-gallery--image">
                                        <div class="slide">
                                            <div class="ps-gallery__item"><img src="img/products/001.jpg" alt="alt" /></div>
                                        </div>
                                        <div class="slide">
                                            <div class="ps-gallery__item"><img src="img/products/047.jpg" alt="alt" /></div>
                                        </div>
                                        <div class="slide">
                                            <div class="ps-gallery__item"><img src="img/products/047.jpg" alt="alt" /></div>
                                        </div>
                                        <div class="slide">
                                            <div class="ps-gallery__item"><img src="img/products/008.jpg" alt="alt" /></div>
                                        </div>
                                        <div class="slide">
                                            <div class="ps-gallery__item"><img src="img/products/034.jpg" alt="alt" /></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-6">
                                <div class="ps-product__info">
                                    <div class="ps-product__badge"><span class="ps-badge ps-badge--instock"> IN STOCK</span>
                                    </div>
                                    <div class="ps-product__branch"><a href="#">HeartRate</a></div>
                                    <div class="ps-product__title"><a href="#">Blood Pressure Monitor</a></div>
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4" selected="selected">4</option>
                                            <option value="5">5</option>
                                        </select><span class="ps-product__review">(5 Reviews)</span>
                                    </div>
                                    <div class="ps-product__desc">
                                        <ul class="ps-product__list">
                                            <li>Study history up to 30 days</li>
                                            <li>Up to 5 users simultaneously</li>
                                            <li>Has HEALTH certificate</li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__meta"><span class="ps-product__price">$77.65</span>
                                    </div>
                                    <div class="ps-product__quantity">
                                        <h6>Quantity</h6>
                                        <div class="d-md-flex align-items-center">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div><a class="ps-btn ps-btn--warning" href="#" data-toggle="modal" data-target="#popupAddcartV2">Add to cart</a>
                                        </div>
                                    </div>
                                    <div class="ps-product__type">
                                        <ul class="ps-product__list">
                                            <li> <span class="ps-list__title">Tags: </span><a class="ps-list__text" href="#">Health</a><a class="ps-list__text" href="#">Thermometer</a>
                                            </li>
                                            <li> <span class="ps-list__title">SKU: </span><a class="ps-list__text" href="#">SF-006</a>
                                            </li>
                                        </ul>
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
<div class="modal fade" id="popupCompare" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered ps-compare--popup">
        <div class="modal-content">
            <div class="modal-body">
                <div class="wrap-modal-slider ps-compare__body">
                    <button class="close ps-compare__close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="ps-compare--product">
                        <div class="ps-compare__header">
                            <div class="container">
                                <h2>Compare Products</h2>
                            </div>
                        </div>
                        <div class="ps-compare__content">
                            <div class="ps-compare__table">
                                <table class="table ps-table">
                                    <tbody>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <div class="ps-product__remove"><a href="#"><i class="fa fa-times"></i></a></div>
                                            <div class="ps-product__thumbnail"><a class="ps-product__image" href="product1.html">
                                                    <figure><img src="img/products/001.jpg" alt></figure>
                                                </a></div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title"><a href="product1.html">Blood Pressure Monitor</a></h5>
                                                <div class="ps-product__meta"><span class="ps-product__price">$77.65</span>
                                                </div>
                                                <button class="ps-btn ps-btn--warning">Add to cart</button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ps-product__remove"><a href="#"><i class="fa fa-times"></i></a></div>
                                            <div class="ps-product__thumbnail"><a class="ps-product__image" href="product1.html">
                                                    <figure><img src="img/products/034.jpg" alt></figure>
                                                </a></div>
                                            <div class="ps-product__content">
                                                <h5 class="ps-product__title"><a href="product1.html">Blood Pressure Monitor Upper Arm</a></h5>
                                                <div class="ps-product__meta"><span class="ps-product__del">$64.65</span><span class="ps-product__price sale">$86.67</span>
                                                </div>
                                                <button class="ps-btn ps-btn--warning">Add to cart</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>
                                            <ul class="ps-product__list">
                                                <li class="ps-check-line">5 cleaning programs</li>
                                                <li class="ps-check-line">Digital display</li>
                                                <li class="ps-check-line">Memory for 3 user</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="ps-product__list">
                                                <li class="ps-check-line">5 cleaning programs</li>
                                                <li class="ps-check-line">Digital display</li>
                                                <li class="ps-check-line">Memory for 3 user</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Availability</th>
                                        <td>
                                            <p class="ps-product__text ps-check-line">in stock</p>
                                        </td>
                                        <td>
                                            <p class="ps-product__text ps-check-line">in stock</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Weight</th>
                                        <td>
                                            <p class="ps-product__text">10 kg</p>
                                        </td>
                                        <td>
                                            <p class="ps-product__text">10 kg</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dimensions</th>
                                        <td>
                                            <p class="ps-product__text">10 × 10 × 10 cm</p>
                                        </td>
                                        <td>
                                            <p class="ps-product__text">10 × 10 × 10 cm</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Color</th>
                                        <td>
                                            <p class="ps-product__text">Red, Navy</p>
                                        </td>
                                        <td>
                                            <p class="ps-product__text">Green</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sku</th>
                                        <td>
                                            <p class="ps-product__text">SF-006</p>
                                        </td>
                                        <td>
                                            <p class="ps-product__text">BE-001</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td><span class="ps-product__price">$77.65</span>
                                        </td>
                                        <td><span class="ps-product__del">$64.65</span><span class="ps-product__price sale">$86.67</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="popupLanguage" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ps-popup--select">
        <div class="modal-content">
            <div class="modal-body">
                <div class="wrap-modal-slider container-fluid">
                    <button class="close ps-popup__close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="ps-popup__body">
                        <h2 class="ps-popup__title">Select language</h2>
                        <ul class="ps-popup__list">
                            <li class="language-item"> <a class="active btn" href="javascript:void(0);" data-value="English">English</a></li>
                            <li class="language-item"> <a class="btn" href="javascript:void(0);" data-value="Deutsch">Deutsch</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="popupCurrency" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ps-popup--select">
        <div class="modal-content">
            <div class="modal-body">
                <div class="wrap-modal-slider container-fluid">
                    <button class="close ps-popup__close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="ps-popup__body">
                        <h2 class="ps-popup__title">Select currency</h2>
                        <ul class="ps-popup__list">
                            <li class="currency-item"> <a class="active btn" href="javascript:void(0);" data-value="USD">USD</a></li>
                            <li class="currency-item"> <a class="btn" href="javascript:void(0);" data-value="EUR">EUR</a></li>
                            <li class="currency-item"> <a class="btn" href="javascript:void(0);" data-value="JPY">JPY</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="popupAddcart" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered ps-addcart">
        <div class="modal-content">
            <div class="modal-body">
                <div class="wrap-modal-slider container-fluid ps-addcart__body">
                    <button class="close ps-addcart__close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p class="ps-addcart__noti"> <i class="fa fa-check"> </i>Added to cart succesfully</p>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="ps-product ps-product--standard">
                                <div class="ps-product__thumbnail"><a class="ps-product__image" href="product1.html">
                                        <figure><img src="img/products/015.jpg" alt="alt" /><img src="img/products/040.jpg" alt="alt" />
                                        </figure>
                                    </a>
                                    <div class="ps-product__actions">
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="#"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="#" data-toggle="modal" data-target="#popupCompare"><i class="fa fa-align-left"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Quick view"><a href="#" data-toggle="modal" data-target="#popupQuickview"><i class="fa fa-search"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#" data-toggle="modal" data-target="#popupAddcart"><i class="fa fa-shopping-basket"></i></a></div>
                                    </div>
                                    <div class="ps-product__badge">
                                        <div class="ps-badge ps-badge--sale">Sale</div>
                                    </div>
                                </div>
                                <div class="ps-product__content">
                                    <h5 class="ps-product__title"><a href="product1.html">Lens Frame Professional Adjustable Multifunctional</a></h5>
                                    <div class="ps-product__meta"><span class="ps-product__price sale">$89.65</span><span class="ps-product__del">$60.65</span>
                                    </div>
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected="selected">5</option>
                                        </select><span class="ps-product__review">( Reviews)</span>
                                    </div>
                                    <div class="ps-product__desc">
                                        <ul class="ps-product__list">
                                            <li>Study history up to 30 days</li>
                                            <li>Up to 5 users simultaneously</li>
                                            <li>Has HEALTH certificate</li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__actions ps-product__group-mobile">
                                        <div class="ps-product__quantity">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="ps-product__cart"> <a class="ps-btn ps-btn--warning" href="#" data-toggle="modal" data-target="#popupAddcart">Add to cart</a></div>
                                        <div class="ps-product__item cart" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#"><i class="fa fa-shopping-basket"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="wishlist.html"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="compare.html"><i class="fa fa-align-left"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="ps-addcart__content">
                                <p>There are two items in your cart.</p>
                                <p class="ps-addcart__total">Total: <span class="ps-price">$44.00</span></p><a class="ps-btn ps-btn--border" href="#" data-dismiss="modal" aria-label="Close">Continue shopping</a><a class="ps-btn ps-btn--border" href="shopping-cart.html">View cart</a><a class="ps-btn ps-btn--warning" href="checkout.html">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="popupAddcartV2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered ps-addcart">
        <div class="modal-content">
            <div class="modal-body">
                <div class="wrap-modal-slider container-fluid ps-addcart__body">
                    <div class="ps-addcart__overlay">
                        <div class="ps-addcart__loading"></div>
                    </div>
                    <button class="close ps-addcart__close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p class="ps-addcart__noti"> <i class="fa fa-check"> </i>Added to cart succesfully</p>
                    <div class="ps-addcart__product">
                        <div class="ps-product ps-product--standard">
                            <div class="ps-product__thumbnail"><a class="ps-product__image" href="#">
                                    <figure><img src="img/products/015.jpg" alt><img src="img/products/040.jpg" alt></figure>
                                </a></div>
                            <div class="ps-product__content">
                                <div class="ps-product__title"><a>Lens Frame Professional Adjustable Multifunctional</a></div>
                                <div class="ps-product__quantity"><span>x2</span></div>
                                <div class="ps-product__meta"><span class="ps-product__price">$89.65</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-addcart__header">
                        <h3>Want o add one of these?</h3>
                        <p>People who buy this product buy also:</p>
                    </div>
                    <div class="ps-addcart__content">
                        <div class="owl-carousel" data-owl-auto="false" data-owl-loop="true" data-owl-speed="15000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="3" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="2" data-owl-item-lg="3" data-owl-item-xl="3" data-owl-duration="1000" data-owl-mousedrag="on">
                            <div class="ps-product ps-product--standard">
                                <div class="ps-product__thumbnail"><a class="ps-product__image" href="product1.html">
                                        <figure><img src="img/products/015.jpg" alt="alt" /><img src="img/products/040.jpg" alt="alt" />
                                        </figure>
                                    </a>
                                    <div class="ps-product__actions">
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="#"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="#" data-toggle="modal" data-target="#popupCompare"><i class="fa fa-align-left"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Quick view"><a href="#" data-toggle="modal" data-target="#popupQuickview"><i class="fa fa-search"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#" data-toggle="modal" data-target="#popupAddcart"><i class="fa fa-shopping-basket"></i></a></div>
                                    </div>
                                    <div class="ps-product__badge">
                                        <div class="ps-badge ps-badge--sale">Sale</div>
                                    </div>
                                </div>
                                <div class="ps-product__content">
                                    <h5 class="ps-product__title"><a href="product1.html">Lens Frame Professional Adjustable Multifunctional</a></h5>
                                    <div class="ps-product__meta"><span class="ps-product__price sale">$89.65</span><span class="ps-product__del">$60.65</span>
                                    </div>
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected="selected">5</option>
                                        </select><span class="ps-product__review">( Reviews)</span>
                                    </div>
                                    <div class="ps-product__desc">
                                        <ul class="ps-product__list">
                                            <li>Study history up to 30 days</li>
                                            <li>Up to 5 users simultaneously</li>
                                            <li>Has HEALTH certificate</li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__actions ps-product__group-mobile">
                                        <div class="ps-product__quantity">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="ps-product__cart"> <a class="ps-btn ps-btn--warning" href="#" data-toggle="modal" data-target="#popupAddcart">Add to cart</a></div>
                                        <div class="ps-product__item cart" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#"><i class="fa fa-shopping-basket"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="wishlist.html"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="compare.html"><i class="fa fa-align-left"></i></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-product ps-product--standard">
                                <div class="ps-product__thumbnail"><a class="ps-product__image" href="product1.html">
                                        <figure><img src="img/products/028.jpg" alt="alt" /><img src="img/products/045.jpg" alt="alt" />
                                        </figure>
                                    </a>
                                    <div class="ps-product__actions">
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="#"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="#" data-toggle="modal" data-target="#popupCompare"><i class="fa fa-align-left"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Quick view"><a href="#" data-toggle="modal" data-target="#popupQuickview"><i class="fa fa-search"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#" data-toggle="modal" data-target="#popupAddcart"><i class="fa fa-shopping-basket"></i></a></div>
                                    </div>
                                    <div class="ps-product__badge">
                                    </div>
                                </div>
                                <div class="ps-product__content">
                                    <h5 class="ps-product__title"><a href="product1.html">Digital Thermometer X30-Pro</a></h5>
                                    <div class="ps-product__meta"><span class="ps-product__price sale">$60.39</span><span class="ps-product__del">$89.99</span>
                                    </div>
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4" selected="selected">4</option>
                                            <option value="5">5</option>
                                        </select><span class="ps-product__review">( Reviews)</span>
                                    </div>
                                    <div class="ps-product__desc">
                                        <ul class="ps-product__list">
                                            <li>Study history up to 30 days</li>
                                            <li>Up to 5 users simultaneously</li>
                                            <li>Has HEALTH certificate</li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__actions ps-product__group-mobile">
                                        <div class="ps-product__quantity">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="ps-product__cart"> <a class="ps-btn ps-btn--warning" href="#" data-toggle="modal" data-target="#popupAddcart">Add to cart</a></div>
                                        <div class="ps-product__item cart" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#"><i class="fa fa-shopping-basket"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="wishlist.html"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="compare.html"><i class="fa fa-align-left"></i></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-product ps-product--standard">
                                <div class="ps-product__thumbnail"><a class="ps-product__image" href="product1.html">
                                        <figure><img src="img/products/020.jpg" alt="alt" /><img src="img/products/008.jpg" alt="alt" />
                                        </figure>
                                    </a>
                                    <div class="ps-product__actions">
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="#"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="#" data-toggle="modal" data-target="#popupCompare"><i class="fa fa-align-left"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Quick view"><a href="#" data-toggle="modal" data-target="#popupQuickview"><i class="fa fa-search"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#" data-toggle="modal" data-target="#popupAddcart"><i class="fa fa-shopping-basket"></i></a></div>
                                    </div>
                                    <div class="ps-product__badge">
                                        <div class="ps-badge ps-badge--hot">Hot</div>
                                    </div>
                                </div>
                                <div class="ps-product__content">
                                    <h5 class="ps-product__title"><a href="product1.html">Bronze Blood Pressure Monitor</a></h5>
                                    <div class="ps-product__meta"><span class="ps-product__price">$56.65 - $97.65</span>
                                    </div>
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected="selected">5</option>
                                        </select><span class="ps-product__review">( Reviews)</span>
                                    </div>
                                    <div class="ps-product__desc">
                                        <ul class="ps-product__list">
                                            <li>Study history up to 30 days</li>
                                            <li>Up to 5 users simultaneously</li>
                                            <li>Has HEALTH certificate</li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__actions ps-product__group-mobile">
                                        <div class="ps-product__quantity">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="ps-product__cart"> <a class="ps-btn ps-btn--warning" href="#" data-toggle="modal" data-target="#popupAddcart">Add to cart</a></div>
                                        <div class="ps-product__item cart" data-toggle="tooltip" data-placement="left" title="Add to cart"><a href="#"><i class="fa fa-shopping-basket"></i></a></div>
                                        <div class="ps-product__item" data-toggle="tooltip" data-placement="left" title="Wishlist"><a href="wishlist.html"><i class="fa fa-heart-o"></i></a></div>
                                        <div class="ps-product__item rotate" data-toggle="tooltip" data-placement="left" title="Add to compare"><a href="compare.html"><i class="fa fa-align-left"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-addcart__footer"><a class="ps-btn ps-btn--border" href="#" data-dismiss="modal" aria-label="Close">No thanks :(</a><a class="ps-btn ps-btn--warning" href="shopping-cart.html">Continue to Cart</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script data-cfasync="false" src="http://nouthemes.net/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="asset/plugins/jquery.min.js"></script>
<script src="asset/plugins/popper.min.js"></script>
<script src="asset/plugins/bootstrap4/js/bootstrap.min.js"></script>
<script src="asset/plugins/select2/dist/js/select2.full.min.js"></script>
<script src="asset/plugins/owl-carousel/owl.carousel.min.js"></script>
<script src="asset/plugins/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
<script src="asset/plugins/lightGallery/dist/js/lightgallery-all.min.js"></script>
<script src="asset/plugins/slick/slick/slick.min.js"></script>
<script src="asset/plugins/noUiSlider/nouislider.min.js"></script>
<!-- custom code-->
<script src="asset/js/main.js"></script>
</body>


<!-- Mirrored from nouthemes.net/html/mymedi/category-grid-green.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jun 2021 05:34:39 GMT -->
</html>
