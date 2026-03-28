@include('adminPartial.nav')
<title>Bandidth Monitor | Henix</title>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>Bandwidth Monitor</h3>
                <ul>
                    <li>
                        <a href="{{url('admin')}}">Admin</a>
                    </li>
                    <li>Bandwidth Monitor</li>
                </ul>
            </div>
            @include('flash-message');
            <!-- Breadcubs Area End Here -->
            <!-- Dashboard summery Start Here -->
     
       
          
            <div class="row gutters-20" id="basic">

            </div>
            <!-- Dashboard summery End Here -->
            <!-- Dashboard Content Start Here -->
        <div class="row gutters-20">
           
                        <div class="col-12 col-xl-6 col-3-xxxl">
                        <div class="card dashboard-card-three pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Bandwidth</h3>
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
                             <div id="update-container">
                         
                                </div>
                                <hr>
                                                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Send Message if no Bandwidth 
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Send Message if Bandwidth is being used Maximum
                                    </label>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6 col-4-xxxl">
                        <div class="card dashboard-card-five pd-b-20">
                            <div class="card-body pd-b-14">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Bandwidth Traffic</h3>
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
                                <h6 class="traffic-title">Unique Visitors</h6>
                                <div class="traffic-number">2,590</div>
                                <div class="traffic-bar">
                                    <div class="direct" data-toggle="tooltip" data-placement="top" title="Direct">
                                    </div>
                                    <div class="search" data-toggle="tooltip" data-placement="top" title="Search">
                                    </div>
                                    <div class="referrals" data-toggle="tooltip" data-placement="top" title="Referrals">
                                    </div>
                                    <div class="social" data-toggle="tooltip" data-placement="top" title="Social">
                                    </div>
                                </div>
                                <div class="traffic-table table-responsive">

<div class="speedometerWrapper-1SNrYKXY- summary-72Hk5lHE-"><span class="speedometerTitle-30PXfiU1-">Summary</span>
  <div class="container-35LdZfI9-">
    <div class="speedometerWrapper-2Sk-AbRs- large-F0Vy-oXn-">
      <div class="speedometerTextWrapper-3rhjdtpQ-"><span class="speedometerText-2TGWK5UK- textTop-5Hxhzgi0-">Neutral</span><span class="middleSignals-1AXHG4P7-"><span class="speedometerText-2TGWK5UK-">Sell</span><span class="speedometerText-2TGWK5UK-">Buy</span></span><span class="bottomSignals-1smB3q0x-"><span class="speedometerText-2TGWK5UK- textBottom-2ex1s6Bn-"><span class="textBottomWrap-3vGk2737-">Strong Sell</span></span>
        <span
          class="speedometerText-2TGWK5UK- textBottom-2ex1s6Bn-"><span class="textBottomWrap-3vGk2737-">Strong Buy</span></span>
          </span>
      </div>
      <div class="sizeWrapper-DAak2N29-">
        <div class="circleWrapper-3vsz9P9t-">
          <div class="sector-3OfELgoJ- sectorStrongSell-1ICuE5Ke-"></div>
          <div class="sector-3OfELgoJ- sectorSell-3X3gWwLa-"></div>
          <div class="sector-3OfELgoJ- sectorNeutral-31Kdaw2I-"></div>
          <div class="sector-3OfELgoJ- sectorBuy-15nv8L09-"></div>
          <div class="sector-3OfELgoJ- sectorStrongBuy-nwvRUQuu-"></div>
          <div class="semicircle-1DWyV1Bs- semicircleSell-2KWza7CC-"></div>
        </div>
        <div class="dot-aqQgEO_r-"></div>
             <div id="bandwidth"></div>

      </div>
    </div>
  </div>
  <div id="refreshPercentage">
      

</div>
  <div class="countersWrapper-1TsBXTyc-">
        <div class="counterWrapper-jlQrAsz2-"><span class="counterNumber-3l14ys0C- brandColor-1WP1oBmS-">3 Mbps</span><span class="counterTitle-1vYabOZy-">Upload Speed</span></div>

    <div class="counterWrapper-jlQrAsz2-"><span class="counterNumber-3l14ys0C- redColor-Hpg7doOR-">14 Mbps</span><span class="counterTitle-1vYabOZy-">Download Speed</span></div>
    <div class="counterWrapper-jlQrAsz2-"><span class="counterNumber-3l14ys0C- brandColor-1WP1oBmS-">3 Mbps</span><span class="counterTitle-1vYabOZy-">Upload Speed</span></div>
  </div>
</div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6 col-4-xxxl">
                        <div class="card dashboard-card-six pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1 mg-b-17">
                                    <div class="item-title">
                                        <h3>Notice Board</h3>
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
                                <div class="notice-box-wrap">
                                    <div class="notice-list">
                                        <div class="post-date bg-skyblue">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag mene esom text of the
                                                printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-yellow">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-pink">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag meneesom.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-skyblue">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag mene esom text of the
                                                printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-yellow">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag printing.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                    <div class="notice-list">
                                        <div class="post-date bg-pink">16 June, 2019</div>
                                        <h6 class="notice-title"><a href="#">Great School manag meneesom.</a></h6>
                                        <div class="entry-meta"> Jennyfar Lopez / <span>5 min ago</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            
                

            

            <!-- Dashboard Content End Here -->
            <!-- Social Media Start Here -->
            <!-- Social Media End Here -->
            <!-- Footer Area Start Here -->
          <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="#">Henix</a> 2026. All rights reserved. Designed by <a
                        href="#">Henix Technologies</a></div>
            </footer>
            <!-- Footer Area End Here -->
        </div>
    </div>
    <!-- Page Area End Here -->
</div>
<style>
        .container-1yeiTT0O- {
            overflow: auto;
            overflow-x: hidden;
            box-sizing: border-box;
            background-color: #fff;
            border-radius: 1px;
            box-shadow: 0 1px 8px 0 rgba(19,23,34,.5)
        }

        html.theme-dark .container-1yeiTT0O- {
            box-shadow: 0 1px 8px 0 rgba(0,0,0,.5);
            background-color: #1c2030
        }

        .container-1yeiTT0O-::-webkit-scrollbar {
            width: 5px;
            height: 5px
        }

        .container-1yeiTT0O-::-webkit-scrollbar-thumb {
            border: 1px solid;
            border-color: #f1f3f6;
            border-radius: 3px;
            background-color: #9db2bd
        }

        html.theme-dark .container-1yeiTT0O-::-webkit-scrollbar-thumb {
            background-color: #363c4e;
            border-color: #1c2030
        }

        .container-1yeiTT0O-::-webkit-scrollbar-track {
            background-color: transparent;
            border-radius: 3px
        }

        .container-1yeiTT0O-.top-eKw7x7mr- {
            background-color: #fff;
            border-radius: 1px;
            box-shadow: 0 -1px 8px 0 rgba(19,23,34,.5)
        }

        html.theme-dark .container-1yeiTT0O-.top-eKw7x7mr- {
            box-shadow: 0 -1px 8px 0 rgba(0,0,0,.5);
            background-color: #1c2030
        }

        .container-1yeiTT0O-.animated-3deVJX7u- {
            visibility: hidden
        }

        .technicalsTab-1vZ2_uY_- {
            background-color: #fff;
            padding: 25px;
            overflow: auto
        }

        .container-21YFOnrS- {
            background-color: #fff
        }

        html.theme-dark .container-21YFOnrS- {
            background-color: #171b29
        }

        .title-3XEQduY7- {
            margin-bottom: 20px;
            font-size: 20px;
            text-transform: uppercase;
            color: #4c525e
        }

        html.theme-dark .title-3XEQduY7- {
            color: #fff
        }

        .speedometersContainer-1EFQq-4i- {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            margin: 20px;
            margin-bottom: 40px
        }

        .speedometerWrapper-1SNrYKXY- {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            order: 2;
            min-width: 343px;
            contain: content
        }

        .speedometerTitle-30PXfiU1- {
            margin: 30px 0;
            font-size: 20px;
            color: #4a4a4a;
            letter-spacing: .3px;
            font-weight: 400
        }

        html.theme-dark .speedometerTitle-30PXfiU1- {
            color: #c5cbce
        }

        .speedometerSignal-pyzN--tL- {
            margin: 25px 0 30px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: .4px;
            font-weight: 700
        }

        .brandColor-1WP1oBmS- {
            color: #3bb3e4
        }

        .redColor-Hpg7doOR- {
            color: #ff4a68
        }

        .neutralColor-15OoMFX9- {
            color: #9db2bd
        }

        .countersWrapper-1TsBXTyc- {
            display: flex;
            justify-content: space-between
        }

        .counterWrapper-jlQrAsz2- {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 26px
        }

        .counterNumber-3l14ys0C- {
            font-size: 20px;
            margin-bottom: 5px
        }

        .counterTitle-1vYabOZy- {
            font-size: 12px;
            color: #9db2bd
        }

        html.theme-dark .counterTitle-1vYabOZy- {
            color: #758696
        }

        .tablesWrapper-3-2f1vZg- {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            border-top: 1px solid;
            border-top-color: #eceff2
        }

        html.theme-dark .tablesWrapper-3-2f1vZg- {
            border-top-color: #363c4e
        }

        .tablesWrapper-3-2f1vZg- table {
            width: 47%
        }

        .summary-72Hk5lHE- {
            order: 1;
            flex-grow: 2;
            width: 100%
        }

        .summary-72Hk5lHE- .speedometerSignal-pyzN--tL- {
            margin: 32px 0 18px;
            font-size: 30px
        }

        .page-wide .summary-72Hk5lHE- {
            order: 2;
            width: auto
        }

        .page-wide .speedometerWrapper-1SNrYKXY- {
            min-width: auto
        }

        .popupClass-3P4dHQMX- .summary-72Hk5lHE- {
            order: 1;
            flex-grow: 2;
            width: 100%
        }

        .tableWithAction-2OCRQQ8y- tr td:last-child,.tableWithAction-2OCRQQ8y- tr th:last-child {
            text-align: left
        }

        .maTable-27Z4Dq6Y- tr:nth-child(2n) {
            border-bottom: none
        }

        .maTable-27Z4Dq6Y- tr:nth-last-child(-n+3) {
            border-bottom: 1px solid;
            border-bottom-color: #eceff2
        }

        html.theme-dark .maTable-27Z4Dq6Y- tr:nth-last-child(-n+3) {
            border-bottom-color: #363c4e
        }

        .maTable-27Z4Dq6Y- tr:last-child {
            border-bottom: none
        }

        @media screen and (max-width: 500px) {
            .summary-72Hk5lHE- .speedometerSignal-pyzN--tL- {
                margin:25px 0 30px;
                font-size: 24px
            }
        }

        @media screen and (max-width: 980px) {
            .tablesWrapper-3-2f1vZg- table {
                width:100%
            }

            .speedometersContainer-1EFQq-4i- {
                margin-left: 0;
                margin-right: 0
            }
        }

        .techDialog-2PsqBA1H-.techDialog-2PsqBA1H- {
            max-width: 980px;
            max-height: 80%
        }

        .techDialog-2PsqBA1H-.techDialog-2PsqBA1H-,.techDialog-2PsqBA1H-.techDialog-2PsqBA1H->div {
            background-color: #fff
        }

        html.theme-dark .techDialog-2PsqBA1H-.techDialog-2PsqBA1H-,html.theme-dark .techDialog-2PsqBA1H-.techDialog-2PsqBA1H->div {
            background-color: #171b29
        }

        .techDialog-2PsqBA1H-.techDialog-2PsqBA1H- .dialogSymbol-3VbEPCJj- {
            font-size: 22px;
            margin-bottom: 20px
        }

        @media screen and (min-width: 1530px) {
            .techDialog-2PsqBA1H-.techDialog-2PsqBA1H- {
                max-width:1200px
            }

            .techDialog-2PsqBA1H-.techDialog-2PsqBA1H- .summary-72Hk5lHE- {
                order: 2;
                width: auto
            }

            .techDialog-2PsqBA1H-.techDialog-2PsqBA1H- .speedometerWrapper-1SNrYKXY- {
                min-width: auto
            }
        }

        th {
            font-weight: 400;
            letter-spacing: .2px
        }

        .table-1i1M26QY- {
            margin-top: 20px;
            width: 100%
        }

        .title-25TMqr29-,.title-25TMqr29- a {
            margin: 20px 0;
            color: #4c525e;
            font-size: 18px;
            text-transform: uppercase;
            text-align: left;
            font-weight: 700
        }

        html.theme-dark .title-25TMqr29-,html.theme-dark .title-25TMqr29- a {
            color: #d6d8e0
        }

        .feature-no-touch .title-25TMqr29- a:hover {
            color: #3bb3e4
        }

        .header-1ZkmwUSJ- {
            height: 40px;
            color: #9db2bd;
            font-size: 12px
        }

        html.theme-dark .header-1ZkmwUSJ- {
            color: #758696
        }

        .row-2H4iFp12- {
            height: 36px;
            color: #4a4a4a;
            font-size: 14px;
            border-bottom: 1px solid;
            border-bottom-color: #eceff2
        }

        html.theme-dark .row-2H4iFp12- {
            border-bottom-color: #363c4e;
            color: #d6d8e0
        }

        .row-2H4iFp12-:last-child {
            border: none
        }

        .row-2H4iFp12- a {
            color: #4a4a4a;
            transition: color .35s ease
        }

        html.theme-dark .row-2H4iFp12- a {
            color: #d6d8e0
        }

        .feature-no-touch .row-2H4iFp12- a:hover {
            color: #3bb3e4
        }

        html.feature-no-touch.theme-dark .row-2H4iFp12- a:hover {
            color: #299dcd
        }

        .cell-6KbOCOru- {
            padding-left: 16px;
            text-align: right
        }

        .cell-6KbOCOru-:first-child {
            padding-left: 0;
            text-align: left
        }

        .brandColor-2uL2f5w_- {
            color: #3bb3e4
        }

        .redColor-2RhlmomL- {
            color: #ff4a68
        }

        .neutralColor-1oFn_sJr- {
            color: #9db2bd
        }

        @media screen and (max-width: 1019px) {
            .cell-6KbOCOru-:first-child {
                padding:8px 0
            }
        }

        .container-35LdZfI9- {
            display: flex;
            justify-content: center
        }

        .speedometerWrapper-2Sk-AbRs- {
            display: flex;
            position: relative;
            flex-direction: column;
            align-items: center
        }

        .speedometerTextWrapper-3rhjdtpQ- {
            display: flex;
            position: absolute;
            flex-direction: column;
            width: 100%;
            left: 0;
            align-items: center
        }

        .speedometerText-2TGWK5UK- {
            display: flex;
            position: relative;
            width: 52px;
            justify-content: center;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: .4px;
            color: #262b3e
        }

        html.theme-dark .speedometerText-2TGWK5UK- {
            color: #9db2bd
        }

        .textTop-5Hxhzgi0- {
            width: 100%;
            text-align: center
        }

        .textBottom-2ex1s6Bn- {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            margin: 0
        }

        .textBottomWrap-3vGk2737- {
            width: 100%;
            display: flex;
            justify-content: center
        }

        .bottomSignals-1smB3q0x-,.middleSignals-1AXHG4P7- {
            display: flex;
            justify-content: space-between;
            margin: 20px 0
        }

        .middleSignals-1AXHG4P7- {
            width: 114%
        }

        .bottomSignals-1smB3q0x- {
            width: 153%;
            text-align: center
        }

        .sizeWrapper-DAak2N29- {
            position: relative;
            width: 220px;
            height: 110px;
            overflow: hidden;
            margin-top: 20px
        }

        .circleWrapper-3vsz9P9t- {
            position: relative;
            width: 220px;
            height: 220px;
            overflow: hidden;
            border-radius: 50%;
            z-index: 0
        }

        .sector-3OfELgoJ- {
            position: absolute;
            width: 109px;
            height: 109px;
            left: 0;
            top: 0;
            border: 1px solid;
            border-color: #fff;
            transform-origin: 100% 100%
        }

        html.theme-dark .sector-3OfELgoJ- {
            border-color: #171b29
        }

        .sectorStrongSell-1ICuE5Ke- {
            
            background-color: #3bb3e4;
            transform: rotate(0deg) skew(54deg)
        }

        .sectorSell-3X3gWwLa- {
            background-color: rgba(59,179,228,.6);
            transform: rotate(36deg) skew(54deg)
        }

        .sectorNeutral-31Kdaw2I- {
            background-color: #f2f3f5;
            transform: rotate(72deg) skew(54deg)
        }

        .sectorBuy-15nv8L09- {
            
            background-color: rgba(255,74,104,.6);
            transform: rotate(108deg) skew(54deg)
        }

        .sectorStrongBuy-nwvRUQuu- {
            background-color: #ff4a68;
            transform: rotate(144deg) skew(54deg)
        }

        .semicircle-1DWyV1Bs- {
            left: 4px;
            top: 4px;
            background-color: #fff;
            border: 1px solid;
            border-color: #fff;
            transition: box-shadow 1.5s ease
        }

        html.theme-dark .semicircle-1DWyV1Bs- {
            border-color: #171b29;
            background-color: #171b29
        }

        .semicircle-1DWyV1Bs-,.semicircle-1DWyV1Bs-:after,.semicircle-1DWyV1Bs-:before {
            position: absolute;
            width: 210px;
            height: 105px;
            border-top-left-radius: 210px;
            border-top-right-radius: 210px
        }

        .semicircle-1DWyV1Bs-:after,.semicircle-1DWyV1Bs-:before {
            content: " ";
            display: block;
            bottom: 0
        }

        .semicircle-1DWyV1Bs-:before {
            background-image: linear-gradient(190deg,hsla(0,0%,100%,0) 70%,#fff)
        }

        html.theme-dark .semicircle-1DWyV1Bs-:before {
            background-image: linear-gradient(190deg,rgba(23,27,41,0) 70%,#171b29)
        }

        .semicircle-1DWyV1Bs-:after {
            background-image: linear-gradient(170deg,hsla(0,0%,100%,0) 70%,#fff)
        }

        html.theme-dark .semicircle-1DWyV1Bs-:after {
            background-image: linear-gradient(170deg,rgba(23,27,41,0) 70%,#171b29)
        }

        .semicircleNeutral-3lwk7jok- {
            box-shadow: inset 0 30px 60px -10px #f2f3f5
        }

        html.theme-dark .semicircleNeutral-3lwk7jok- {
            box-shadow: inset 0 30px 60px -10px #4c525e
        }

        .semicircleBuy-1ZEulvsz- {
            box-shadow: inset 0 30px 60px -10px rgba(59,179,228,.3)
        }

        .semicircleStrongBuy-t0nVXukz- {
            box-shadow: inset 0 30px 60px -10px rgba(59,179,228,.6)
        }

        .semicircleSell-2KWza7CC- {
            box-shadow: inset 0 30px 60px -10px rgba(255,74,104,.3)
        }

        .semicircleStrongSell-33-gURxG- {
            box-shadow: inset 0 30px 60px -10px rgba(255,74,104,.6)
        }

        .dot-aqQgEO_r- {
            position: absolute;
            width: 8px;
            height: 8px;
            background-color: #131722;
            bottom: 0;
            left: calc(50% - 4px);
            border-radius: 4px
        }

        html.theme-dark .dot-aqQgEO_r- {
            background-color: #ebf7fc
        }

        .arrow-F-uE7IX8- {
            display: flex;
            position: absolute;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 8px;
            height: 97px;
            bottom: 4px;
            left: calc(50% - 4px);
            transform-origin: 50% 100%;
            transition: transform 1.5s ease
        }

        .arrowHidden-chDYo-JT- {
            width: 2px;
            height: 8px;
            background-color: transparent
        }

        .arrowMain-4Z6WqtKf- {
            width: 2px;
            height: 90px;
            border-radius: 1px;
            background-color: #131722
        }

        html.theme-dark .arrowMain-4Z6WqtKf- {
            background-color: #ebf7fc
        }

        .arrowToBuy-1R7d8UMJ- {
            transform: rotate(36deg)
        }

        .arrowToStrongBuy-1ydGKDOo- {
            transform: rotate(-72deg)
        }



        .arrowToStrongSell-3UWimXJs- {
            transform: rotate(72deg)
        }

        .arrowBuyShudder-3GMCnG5u- {
            animation: buyShudder-2ptjRbdg- 10s infinite
        }

        .arrowStrongBuyShudder-3xsGK8k5- {
            animation: strongBuyShudder-38RrFt0k- 10s infinite
        }

        .arrowSellShudder-mudaBhtR- {
            animation: sellShudder-1siBGPXF- 10s infinite
        }

        .arrowStrongSellShudder-2UJhm0_C- {
            animation: strongSellShudder-3CrPm8cD- 10s infinite
        }

        .arrowNeutralShudder-2HjunTMS- {
            animation: NeutralShudder-37Yt3Dxz- 10s infinite
        }



        .small-1oIKG7Gu- .sizeWrapper-DAak2N29- {
            width: 154px;
            height: 77px;
            margin-top: 15px
        }

        .small-1oIKG7Gu- .bottomSignals-1smB3q0x-,.small-1oIKG7Gu- .middleSignals-1AXHG4P7- {
            margin: 13px 0
        }

        .small-1oIKG7Gu- .middleSignals-1AXHG4P7- {
            width: 130%
        }

        .small-1oIKG7Gu- .bottomSignals-1smB3q0x- {
            width: 168%
        }

        .small-1oIKG7Gu- .speedometerText-2TGWK5UK- {
            font-size: 9px;
            width: 48px
        }

        .small-1oIKG7Gu- .circleWrapper-3vsz9P9t- {
            width: 154px;
            height: 154px
        }

        .small-1oIKG7Gu- .sector-3OfELgoJ- {
            width: 76px;
            height: 76px
        }

        .small-1oIKG7Gu- .semicircle-1DWyV1Bs-,.small-1oIKG7Gu- .semicircle-1DWyV1Bs-:after,.small-1oIKG7Gu- .semicircle-1DWyV1Bs-:before {
            width: 144px;
            height: 72px;
            border-top-left-radius: 144px;
            border-top-right-radius: 144px
        }

        .small-1oIKG7Gu- .arrow-F-uE7IX8- {
            height: 64px
        }

        .small-1oIKG7Gu- .arrowMain-4Z6WqtKf- {
            height: 70px
        }

        .elementWrap-1QD4r5YL- {
            max-width: 100%;
            flex-direction: column;
            align-items: flex-start
        }

        .elementWrap-1QD4r5YL-,.itemsWrap-3LXjIO26- {
            display: flex;
            position: relative
        }

        .item-17wa4fow- {
            display: flex;
            padding: 0 9px
        }

        .item-17wa4fow-:first-child {
            padding-left: 0
        }

        .item-17wa4fow-:last-child {
            padding-right: 0
        }

        .item-17wa4fow-.active-1jm_3h9d- .itemContent-OyUxIzTS- {
            color: #37a6ef;
            border: 1px solid #37a6ef;
            border-radius: 12px;
            cursor: default
        }

        .item-17wa4fow-.active-1jm_3h9d- .itemContent-OyUxIzTS-.dropdownItem-3AQdrpdG- {
            cursor: pointer
        }

        .itemContent-OyUxIzTS- {
            padding: 3px 12px 4px;
            cursor: pointer;
            text-align: center;
            transition: background-color .35s ease,color .35s ease;
            font-size: 13px;
            color: #4f5966;
            border: 1px solid transparent;
            border-radius: 12px;
            white-space: nowrap
        }

        html.theme-dark .itemContent-OyUxIzTS- {
            color: #f2f3f5
        }

        .feature-no-touch .itemContent-OyUxIzTS-:hover:not(.active-1jm_3h9d-) {
            background-color: #ebf7fc
        }

        html.feature-no-touch.theme-dark .itemContent-OyUxIzTS-:hover:not(.active-1jm_3h9d-) {
            background-color: #262b3e
        }

        .dropdownItem-3AQdrpdG- {
            width: 32px;
            box-sizing: border-box
        }

        .dropdownIcon-4sS1jqTr- {
            display: block;
            transform: rotate(90deg);
            transition: transform .35s ease
        }

        .dropdownIcon-4sS1jqTr-.active-1jm_3h9d- {
            transform: rotate(-90deg)
        }

        .dropdownListItem-IomHpQ5s- {
            white-space: nowrap;
            position: relative;
            cursor: pointer;
            padding: 10px 30px 10px 15px;
            transition: color .35s ease,background-color .35s ease;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .feature-no-touch .dropdownListItem-IomHpQ5s-:hover:not(.dropdownListItemActive-30IWK7as-) {
            color: #4a4a4a;
            background-color: #ebf7fc
        }

        html.feature-no-touch.theme-dark .dropdownListItem-IomHpQ5s-:hover:not(.dropdownListItemActive-30IWK7as-) {
            background-color: #262b3e;
            color: #c5cbce
        }

        .dropdownListItemNotActive-2dmeXX-V- {
            color: #4f5966
        }

        html.theme-dark .dropdownListItemNotActive-2dmeXX-V- {
            color: #f2f3f5
        }

        .dropdownListItemActive-30IWK7as- {
            background-color: #37a6ef;
            color: #fff
        }

        .wrap-UEegu6Ih- {
            position: relative
        }

        .list-7JvxPFnK- {
            background-color: #fff;
            padding: 15px 0
        }

        html.theme-dark .list-7JvxPFnK- {
            background-color: #131722
        }

        .list-7JvxPFnK- .item-319pyzE7- {
            white-space: nowrap;
            position: relative;
            cursor: pointer;
            padding: 10px 30px 10px 15px;
            transition: color .35s ease,background-color .35s ease;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .list-7JvxPFnK- .item-319pyzE7-.selected-1Wdh2MYE- {
            color: #4a4a4a;
            background-color: #eafafe;
            transition-duration: .06s
        }

        html.theme-dark .list-7JvxPFnK- .item-319pyzE7-.selected-1Wdh2MYE- {
            background-color: #21384d;
            color: #c5cbce
        }

        .feature-no-touch .list-7JvxPFnK- .item-319pyzE7-:hover:not(.selected-1Wdh2MYE-) {
            color: #4a4a4a;
            background-color: #f2f3f5;
            transition-duration: .06s
        }

        html.feature-no-touch.theme-dark .list-7JvxPFnK- .item-319pyzE7-:hover:not(.selected-1Wdh2MYE-) {
            background-color: #2f3241;
            color: #c5cbce
        }

        .feature-no-touch .list-7JvxPFnK- .item-319pyzE7-:active,.feature-touch .list-7JvxPFnK- .item-319pyzE7-:active {
            color: #4a4a4a;
            background-color: #ececec;
            transition-duration: .06s
        }

        html.feature-no-touch.theme-dark .list-7JvxPFnK- .item-319pyzE7-:active,html.feature-touch.theme-dark .list-7JvxPFnK- .item-319pyzE7-:active {
            background-color: #363c4e;
            color: #c5cbce
        }

        .list-7JvxPFnK- .bluishItem-gpuBPkGV- {
            white-space: nowrap;
            position: relative;
            cursor: pointer;
            padding: 10px 30px 10px 15px;
            transition: color .35s ease,background-color .35s ease;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .list-7JvxPFnK- .bluishItem-gpuBPkGV-.selected-1Wdh2MYE- {
            color: #fff;
            background-color: #37a6ef;
            transition-duration: .06s
        }

        .feature-no-touch .list-7JvxPFnK- .bluishItem-gpuBPkGV-:hover:not(.selected-1Wdh2MYE-) {
            color: #4a4a4a;
            background-color: #ebf7fc;
            transition-duration: .06s
        }

        html.feature-no-touch.theme-dark .list-7JvxPFnK- .bluishItem-gpuBPkGV-:hover:not(.selected-1Wdh2MYE-) {
            background-color: #262b3e;
            color: #c5cbce
        }

        .feature-no-touch .list-7JvxPFnK- .bluishItem-gpuBPkGV-:active,.feature-touch .list-7JvxPFnK- .bluishItem-gpuBPkGV-:active {
            color: #4a4a4a;
            background-color: #ececec;
            transition-duration: .06s
        }

        html.feature-no-touch.theme-dark .list-7JvxPFnK- .bluishItem-gpuBPkGV-:active,html.feature-touch.theme-dark .list-7JvxPFnK- .bluishItem-gpuBPkGV-:active {
            background-color: #363c4e;
            color: #c5cbce
        }

        .list-7JvxPFnK- .bluishItem-gpuBPkGV-.noPadding-1aLxS-Vh- {
            padding: 0
        }

        .list-oyzL7o_q- {
            display: flex;
            flex-direction: column;
            overflow: auto
        }

        .list-oyzL7o_q- .item-1s_Ss98n- {
            display: inline-flex;
            flex-shrink: 0
        }


</style>
<!-- jquery-->
<script src="js/jquery-3.3.1.min.js"></script>
<!-- Plugins js -->
<script src="js/plugins.js"></script>
<!-- Popper js -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Counterup Js -->
<script src="js/jquery.counterup.min.js"></script>
<!-- Moment Js -->
<script src="js/moment.min.js"></script>
<!-- Waypoints Js -->
<script src="js/jquery.waypoints.min.js"></script>
<!-- Scroll Up Js -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- Full Calender Js -->
<script src="js/fullcalendar.min.js"></script>
<!-- Chart Js -->
<script src="js/Chart.min.js"></script>
<!-- Custom Js -->
<script src="js/main.js"></script>

</body>

<script>
        function refreshUpdates() {
        $('#update-container').load("{{ url('/refresh') }}"); // The .load() method is a simple way to fetch data from the server and place the returned HTML into the selected element.
    }

    // Initial load
    refreshUpdates();

    // Set an interval to refresh the div every 10 seconds (10000 milliseconds).
    setInterval(refreshUpdates, 1000);
   function refreshBandwidth() {
        $('#bandwidth').load("{{ url('/refreshBandwidth') }}"); // The .load() method is a simple way to fetch data from the server and place the returned HTML into the selected element.
    }

    // Initial load
    refreshBandwidth();

    // Set an interval to refresh the div every 10 seconds (10000 milliseconds).
    setInterval(refreshBandwidth, 1000);
    function refreshPercentage() {
        $('#refreshPercentage').load("{{ url('/refreshPercentage') }}"); // The .load() method is a simple way to fetch data from the server and place the returned HTML into the selected element.
    }

    // Initial load
    refreshPercentage();

    // Set an interval to refresh the div every 10 seconds (10000 milliseconds).
    setInterval(refreshPercentage, 1000);
</script>


<!-- Mirrored from www.radiustheme.com/demo/html/psdboss/akkhor/akkhor/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jun 2021 10:34:59 GMT -->
</html>
