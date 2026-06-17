<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kent hotspot - Log in</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="dark">

    <!-- two other colors

<body class="lite">
<body class="dark">

-->


    <div class="ie-fixMinHeight">
        <div class="main">
            <div class="wrap animated fadeIn">
                <form name="login" action="$(link-login-only)" method="post" $(if chap-id) onSubmit="return doLogin()" $(endif)>
                    <input type="hidden" name="dst" value="$(link-orig)" />
                    <input type="hidden" name="popup" value="true" />
                    <div class="logo">
                      <div class="neon">Kent </div>
                      <div class="flux">Hotspot</div>
                    </div>



                    <p class="info $(if error)alert$(endif)">
              
                    </p>
                    <label>
                        <img class="ico" src="img/user.svg" alt="#" />
                        <input name="username" type="text" value="$(username)" placeholder="Username" />
                    </label>

                    <label>
                        <img class="ico" src="img/password.svg" alt="#" />
                        <input name="password" type="password" placeholder="Password" />
                    </label>

                    <input type="submit" value="Masuk" />

                </form>
                <p class="info bt">🚴🏻‍♂️💨 Feel the speed...</p>

            </div>
        </div>
    </div>
  
    <div class="section">
      <div class="price-list">
        <div class="card">
          <div class="title">Unlimited Harian</div>
          <ul class="list">
            <li>3 Jam:<strong>3rb</strong></li>
            <li>5 Jam:<strong>5rb</strong></li>
            <li>12 Jam:<strong>10rb</strong></li>
          </ul>
          <hr/>
          <a href="https://wa.me/62882021996939&text=🤩%20%20Halo%2C%20saya%20mau%20internet%20unlimited%20harian...">WA: 0882021996939</a>
        </div>
        <div class="card card-blue">
          <div class="title">Unlimited Mingguan</div>
          <ul class="list">
            <li>1 Minggu:<strong>20rb</strong></li>
            <li>2 Minggu:<strong>30rb</strong></li>
            <li>4 Minggu:<strong>35rb</strong></li>
          </ul>
          <hr/>
          <a href="https://wa.me/62882021996939&text=🤩%20%20Halo%2C%20saya%20mau%20internet%20unlimited%20mingguan...">WA: 0882021996939</a>
        </div>
        <div class="card card-purple">
          <div class="title">Unlimited Bulanan</div>
          <ul class="list">
            <li>2 devices:<strong>50rb</strong></li>
            <li>5 devices:<strong>100rb</strong></li>
            <li>Unlimited:<strong>Hubungi Kami</strong></li>
          </ul>
          <hr/>
          <a href="https://wa.me/62882021996939&text=🤩%20%20Halo%2C%20saya%20mau%20internet%20unlimited%20bulanan...">WA: 0882021996939</a>
        </div>
      </div>
    </div>
    <style>
        :root {
  --neon-light: #426DFB;
  --flux-light: #FB4264;
}

a,
body,
div,
form,
html,
img,
input,
label,
p,
span {
	margin: 0;
	padding: 0;
	border: 0;
	font-family: sans-serif, Arial
}

body,
html {
	min-height: 100%;
	overflow-x: hidden
}

body {
	background: #a2a09b;
	background: -webkit-linear-gradient(315deg, hsla(236.6, 0%, 53.52%, 1) 0, hsla(236.6, 0%, 53.52%, 0) 70%), -webkit-linear-gradient(65deg, hsla(220.75, 34.93%, 26.52%, 1) 10%, hsla(220.75, 34.93%, 26.52%, 0) 80%), -webkit-linear-gradient(135deg, hsla(46.42, 36.62%, 83.92%, 1) 15%, hsla(46.42, 36.62%, 83.92%, 0) 80%), -webkit-linear-gradient(205deg, hsla(191.32, 50.68%, 56.45%, 1) 100%, hsla(191.32, 50.68%, 56.45%, 0) 70%);
	background: linear-gradient(135deg, hsla(236.6, 0%, 53.52%, 1) 0, hsla(236.6, 0%, 53.52%, 0) 70%), linear-gradient(25deg, hsla(220.75, 34.93%, 26.52%, 1) 10%, hsla(220.75, 34.93%, 26.52%, 0) 80%), linear-gradient(315deg, hsla(46.42, 36.62%, 83.92%, 1) 15%, hsla(46.42, 36.62%, 83.92%, 0) 80%), linear-gradient(245deg, hsla(191.32, 50.68%, 56.45%, 1) 100%, hsla(191.32, 50.68%, 56.45%, 0) 70%)
}

a {
	color: #486173
}

input,
label {
	vertical-align: middle;
	white-space: normal;
	background: 0 0;
	line-height: 1
}

label {
	position: relative;
	display: block
}

p::first-letter {
	text-transform: uppercase
}

.main {
	min-height: calc(100vh - 90px);
	width: 100%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column
}

.ie-fixMinHeight {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex
}

.ico {
	height: 16px;
	position: absolute;
	top: 0;
	left: 0;
	margin-top: 13px;
	margin-left: 14px
}
/* 
.logo {
	max-width: 200px;
	display: block;
	margin: 0 auto 30px auto
}

.logo * {
	fill: #fff
}

.lite .logo * {
	fill: #444
} */

h1 {
	text-align: center;
	color: #fff;
	font-size: 24px!important
}

* {
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	font-size: 16px
}

.wrap {
	margin: auto;
	padding: 40px;
	-webkit-transition: width .3s ease-in-out;
	transition: width .3s ease-in-out
}

@media only screen and (min-width:1px) and (max-width:575px) {
	.wrap {
		width: 100%
	}
}

form {
	width: 100%;
	margin-bottom: 20px
}

@-webkit-keyframes fadeIn {
	from {
		opacity: 0
	}
	to {
		opacity: 1
	}
}

@keyframes fadeIn {
	from {
		opacity: 0
	}
	to {
		opacity: 1
	}
}

.fadeIn {
	-webkit-animation-name: fadeIn;
	animation-name: fadeIn
}

.animated {
	-webkit-animation-duration: 1s;
	animation-duration: 1s;
	-webkit-animation-fill-mode: both;
	animation-fill-mode: both
}

.info {
	color: #fff;
	text-align: center;
	margin-bottom: 30px
}

input {
	outline: 0;
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none
}

input:focus {
	outline: 0
}

input[type=password],
input[type=text] {
	width: 100%;
	border: 1px solid background-color: rgba(255, 255, 255, .8);
	height: 44px;
	padding: 3px 20px 3px 40px;
	margin-bottom: 20px;
	border-radius: 6px;
	background-color: rgba(255, 255, 255, .8);
	-webkit-transition: -webkit-box-shadow .3s ease-in-out;
	transition: -webkit-box-shadow .3s ease-in-out;
	transition: box-shadow .3s ease-in-out;
	transition: box-shadow .3s ease-in-out, -webkit-box-shadow .3s ease-in-out
}

input[type=password]:focus,
input[type=text]:focus {
	-webkit-box-shadow: 0 0 5px 0 rgba(255, 255, 255, 1);
	box-shadow: 0 0 5px 0 rgba(255, 255, 255, 1)
}

.bt {
	opacity: .4
}

input[type=submit] {
	background: #3e4d59;
	color: #fff;
	border: 0;
	cursor: pointer;
	text-align: center;
	width: 100%;
	height: 44px;
	border-radius: 6px;
	-webkit-transition: background .3s ease-in-out;
	transition: background .3s ease-in-out
}

input[type=submit]:focus,
input[type=submit]:hover {
	background: #33404a
}

table {
	border-collapse: collapse;
	width: 100%;
	margin-bottom: 20px
}

table td {
	color: #fff;
	border-bottom: 1px solid #e6e6e6;
	padding: 10px 4px 10px 0
}

table td:first-child {
	font-weight: 700
}

.lite {
	background: #fff
}

.lite input[type=password],
.lite input[type=text] {
	border: 1px solid #c3c3c3
}

.lite .info,
.lite h1,
.lite table td {
	color: #444
}

.lite input[type=password]:focus,
.lite input[type=text]:focus {
	-webkit-box-shadow:   box-shadow: 0 0 2.8rem blue, inset 0 0 2.5rem blue;
	box-shadow: box-shadow: 0 0 2.8rem blue, inset 0 0 2.5rem blue;
}

.dark {
	background: #343434
}

.dark input[type=submit] {
  color: #FED128;
	background: transparent;
  border: 2px solid #FED128;
  text-shadow: 0 0 1vw #FA1C16, 0 0 3vw #FA1C16, 0 0 10vw #FA1C16, 0 0 10vw #FA1C16, 0 0 .4vw #FED128, .5vw .5vw .1vw #806914;
  box-shadow: 0 0 3rem #FA1C16, inset 0 0 1rem #FA1C16;
}

.dark input[type=submit]:focus,
.dark input[type=submit]:hover {
	background: #b92f35
}

.dark input[type=password],
.dark input[type=text] {
  color: lightblue;
	background-color: transparent;
  border: 1px solid lightblue;
  box-shadow: 0 0 2rem blue, inset 0 0 1.8rem blue;
}

.dark a {
	color: #dc3a41
}

.dark table td {
	border-bottom: 1px solid #505050
}

.info.alert {
	color: #da3d41
}

@media (min-width:576px) {
	.wrap {
		width: 410px
	}
	* {
		font-size: 14px
	}
}


/* Neon Logo */
.logo {
  text-align: center;
}
@font-face {
  font-family: neon;
  src: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/707108/neon.ttf);
}
.flux {
  font-family: neon;
  font-size: 3em;
  line-height: 4rem;
text-shadow: 0 0 1vw #FA1C16, 0 0 3vw #FA1C16, 0 0 10vw #FA1C16, 0 0 10vw #FA1C16, 0 0 .4vw #FED128, .5vw .5vw .1vw #806914;
    color: #FED128;
}
.neon {
  font-family: neon;
  font-size: 3em;
  line-height: 3rem;
text-shadow: 0 0 1vw #1041FF, 0 0 3vw #1041FF, 0 0 10vw #1041FF, 0 0 10vw #1041FF, 0 0 .4vw #8BFDFE, .5vw .5vw .1vw #147280;
    color: #28D7FE;
}

/* Price List */
.price-list {
  display: flex;
  flex-direction: column;
  padding: 15vh auto;
}

.dark .price-list .card {
  background: transparent;
  margin: 3vh 9vw;
  padding: 2vh 20px;
  border-radius: 6px;
  border: 3px solid lightgreen;
  box-shadow: 0 0 2.8rem darkgreen, inset 0 0 2.7rem darkgreen;
}

.dark .price-list .card .title {
  color: lightgreen;
  font-size: 1.5em;
  text-align: center;
  text-shadow: 0 0 3rem green;
}

.dark .price-list .card .list {
  padding-left: 0;
  position: relative
}

.dark .price-list .card hr {
  border-color: lightgreen;
  height: 0;
  box-shadow: 0 0 1rem 1px green;
}

.dark .price-list .card .list li {
  color: lightgreen;
  list-style: none;
  line-height: 2em;
  display: block;
}

.dark .price-list .card .list li strong {
  right: 0;
  position: absolute;
}

.dark .price-list .card a {
  display: block;
  text-align: center;
  font-size: 1.1em;
  margin-top: 10px;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #FED128;
  text-shadow: 0 0 1vw #FA1C16, 0 0 3vw #FA1C16, 0 0 10vw #FA1C16, 0 0 10vw #FA1C16, 0 0 .4vw #FED128;
}

/* Blue Card */
.dark .price-list .card-blue {
  border: 3px solid lightblue;
  box-shadow: 0 0 2.8rem blue, inset 0 0 2.7rem blue;
}
.dark .price-list .card-blue .title {
  color: lightblue;
  text-shadow: 0 0 3rem blue;
}
.dark .price-list .card-blue .list li {
  color: lightblue;
}
.dark .price-list .card-blue hr {
  border-color: lightblue;
  box-shadow: 0 0 1rem 1px blue;
}

/* Purple Card */
.dark .price-list .card-purple {
  border: 3px solid pink;
  box-shadow: 0 0 2.8rem purple, inset 0 0 2.7rem purple;
}
.dark .price-list .card-purple .title {
  color: pink;
  text-shadow: 0 0 3rem purple;
}
.dark .price-list .card-purple .list li {
  color: pink;
}
.dark .price-list .card-purple hr {
  border-color: pink;
  box-shadow: 0 0 1rem 1px purple;
}

@media (min-width: 768px) {
  .price-list {
    flex-direction: row;
  }
  .dark .price-list .card {
    margin: auto 3vw;
    width: 30vw;
  }
}
        </style>
</body>

</html>
