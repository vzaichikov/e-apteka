<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $htmllang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $htmllang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $htmllang; ?>">
	<!--<![endif]-->
	<head>

		<link rel="dns-prefetch" href="//ajax.googleapis.com">
		<link rel="dns-prefetch" href="//www.google.com">
		<link rel="dns-prefetch" href="//fonts.googleapis.com">
		<link rel="dns-prefetch" href="//www.googletagmanager.com">
		<link rel="dns-prefetch" href="//connect.facebook.net">
		<link rel="dns-prefetch" href="//img.e-apteka.com.ua">
		<link rel="dns-prefetch" href="//img0.e-apteka.com.ua">
		<link rel="dns-prefetch" href="//img1.e-apteka.com.ua">
		<link rel="dns-prefetch" href="//img2.e-apteka.com.ua">
		<link rel="dns-prefetch" href="//img3.e-apteka.com.ua">
		<link rel="dns-prefetch" href="//img4.e-apteka.com.ua">
		
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link rel="preconnect" href="//img.e-apteka.com.ua">
		<link rel="preconnect" href="//img0.e-apteka.com.ua">
		<link rel="preconnect" href="//img1.e-apteka.com.ua">
		<link rel="preconnect" href="//img2.e-apteka.com.ua">
		<link rel="preconnect" href="//img3.e-apteka.com.ua">
		<link rel="preconnect" href="//img4.e-apteka.com.ua">

		<meta charset="UTF-8" />
		
		<?php include(DIR_TEMPLATEINCLUDE . 'structured/header_pwa.tpl'); ?>
		
		<?php $version = '031'; ?>
		
		<?php if ($noindex) { ?>
			<meta name="robots" content="noindex, nofollow" />
			<?php } elseif (isset($robots_meta)) { ?>
			<meta name="robots" content="<?php echo $robots_meta; ?>" />
			<?php } else { ?>
			<meta name="robots" content="index, follow" />
		<?php } ?>
		
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $title; ?></title>
		<base href="<?php echo $base; ?>" />
		
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="194x194" href="/favicon-194x194.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=bORwKrwnaR">
		<link rel="mask-icon" href="/safari-pinned-tab.svg?v=bORwKrwnaR" color="#01a0c6">
		<link rel="shortcut icon" href="/favicon.ico?v=bORwKrwnaR">
		<meta name="msapplication-TileColor" content="#01a0c6">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png?v=bORwKrwnaR">
		<meta name="theme-color" content="#ffffff">
				
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
		
		<link rel="preload" href="https://e-apteka.com.ua/catalog/view/javascript/font-awesome4.7/fonts/fontawesome-webfont.woff2" as="font" crossorigin>		
		
		<?php foreach ($hreflangs as $hreflang) { ?>
			<link rel="alternate" hreflang="<?php echo $hreflang['hreflang']; ?>" href="<?php echo $hreflang['href']; ?>" />
		<?php } ?>
		
		<?php if ($description) { ?>
			<meta name="description" content="<?php echo $description; ?>" />
		<?php } ?>
		<?php if ($keywords) { ?>
			<meta name="keywords" content= "<?php echo $keywords; ?>" />
		<?php } ?>
		<script src="/catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="/catalog/view/theme/default/stylesheet/bootstrap.min.css" rel="stylesheet" media="screen" />
		<script src="/catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>

		<?php foreach ($links as $link) { ?>
			<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
		<?php } ?>
		
		<style>
			.xdstickers{font-size: 10px;display: inline-block;}
			@charset "UTF-8";
			button::-moz-focus-inner{padding:0;border:0}
			body{
				overflow-x: hidden;
			}
			html.vision img{
			-webkit-filter: grayscale(100%);
			    filter: grayscale(100%);
			}
			.voice_search_btn{
			background: 0 0;
			border: 0;
			position: absolute;
			right: 56px;
			top: 0;
			bottom: 0;
			font-size: 18px;
			color: #1cacdc;
			width: 40px;
			}
			.voice_search_btn i{
				font-size: 18px;
			}
			.voice_search_btn.active{
			color: #0385c1;
			}
			body.vision * {
			    color: #000000 !important;
			    font-weight: 700;
			    border-radius: 0 !important;
			    border-color: #000 !important;
			    -webkit-transition: 0s ease-in-out;
			    -moz-transition: 0s ease-in-out;
			    -ms-transition: 0s ease-in-out;
			    -o-transition: 0s ease-in-out;
			    transition: 0s ease-in-out;
			    fill: #000 !important;
			    background: #fff !important;
			}
			body.vision #cleversearch .autosearch-input{
				border: 2px solid #000;
			}
			body.vision .mobile-menu-wrap {
			    background: rgba(0,0,0,.5) !important;
			}
			.slider__arrows{width:90px;display:-webkit-box;display:-ms-flexbox;display:flex}
			.slider__arrows>:not(:last-child):after{content:"";display:block;width:1px;height:22px;background:#dcdcdc;position:absolute;top:50%;right:-6px;margin-top:-11px}
			.slider__arrow{width:32px;height:32px;position:relative;border-radius:50%;margin:0 6px}
			.slider__arrow .icon{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);width:8px;height:14px;fill:#353535}
			.slider--tabs .slider__arrows{display:none}
			.slider-tab-nav__arrow{display:none;width:32px;height:32px;position:absolute;z-index:100;border-radius:50%;margin:0 6px;top:50%;margin-top:-16px}
			.slider-tab-nav__arrow .icon{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);width:8px;height:14px;fill:#353535}
			.slider-tab-nav__arrow--prev{left:0}
			.slider-tab-nav__arrow--next{right:0}
			html{font-size:10px}
			body{font-family:"PragmaticaC",sans-serif;font-size:1.4rem;color:#000}
			h2,h3,h4{margin:0;padding:0}
			ul,li{list-style-type:none;margin:0;padding:0}
			img{max-width:100%;border-style:none;height:auto}
			a[href^="tel:"]{white-space:nowrap}
			p{color:#000;font-size:16px}
			
			.site{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;min-height:100vh}
			.site__content{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;margin-bottom:5rem}
			.header-call-back__text,.header-cart__title{position:relative;display:inline-block}
			.header-call-back__text:after,.header-cart__title:after{content:"";display:block;width:100%;height:2px;position:absolute;bottom:0;left:0;z-index:1;background:transparent -webkit-gradient(linear,left top,right top,color-stop(50%,transparent),color-stop(50%,#0385c1)) center center/6px;background:transparent -webkit-linear-gradient(left,transparent 50%,#0385c1 50%) center center/6px;background:transparent linear-gradient(90deg,transparent 50%,#0385c1 50%) center center/6px}
			.header{color:#fff;font-size:14px;top:-200px}
			.header .list-inline{margin-left:0}
			.header .compare__icon,.header .wishlist__icon{fill:#fff;width:20px;height:20px;position:relative;top:4px}
			.header .wishlist__icon{width:18px;height:18px}
			.header__top{background-color:#14a0d4}
			.header__top .dropdown-toggle{color:#fff}
			.header__account-icon{width:13px;height:15px;fill:#0385c1;margin-right:12px;position:relative;top:2px}
			.header__top-inner{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;min-height:36px;padding-bottom:3px}
			.header__top-left li,.header__top-right li{position:relative;padding:0}
			.header__top-left>li+li,.header__top-right>li+li{margin-left:15px;padding-left:15px}
			@media screen and (max-width:767px) {
				.voice_search_btn {right: 42px;}
			.header__top-left>li+li,.header__top-right>li+li{margin-left:7px;padding-left:7px}
			}
			.header__top-left>li+li:before,.header__top-right>li+li:before{content:"";display:block;width:1px;height:15px;background:#0385c1;position:absolute;top:50%;left:0;margin-top:-7.5px}
			@media screen and (max-width:767px) {
			.header__top-left{display:none}
			}
			.header__middle{background-color:#1cacdc;padding:26px 0 24px}
			@media screen and (max-width:1699px) {
			.header__middle{padding:20px 0}
			}
			.header__middle-inner{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;height:56px}
			.header__middle-inner>:not(:last-child){margin-right:30px}
			@media screen and (max-width:1699px) {
			.header__middle-inner>:not(:last-child){margin-right:20px}
			}
			@media screen and (max-width:767px) {
			.header__middle-inner{-ms-flex-wrap:wrap;flex-wrap:wrap;height:auto}
			}
			.header__col-logo{width:375px;min-width:280px}
			@media screen and (max-width:767px) {
			.header__col-logo{width:100%;margin-right:0!important;margin-bottom:18px;text-align:center}
			}
			@media screen and (max-width:767px) {
			.header__col-logo .logo__img{margin:0 auto}
			}
			.header__col-search{width:700px}
			@media screen and (max-width:767px) {
			.header__col-search{-webkit-box-flex:1;-ms-flex:1 0 calc(100% - 150px);flex:1 0 -webkit-calc(100% - 150px);flex:1 0 calc(100% - 150px);margin-right:5px!important}
			}
			.header__col-middle-btns{-webkit-box-flex:0;-ms-flex:0 0 420px;flex:0 0 420px}
			@media screen and (max-width:1199px) {
			.header__col-middle-btns{-webkit-box-flex:0;-ms-flex:0 0 auto;flex:0 0 auto}
			}
			@media screen and (max-width:767px) {
			.header__col-middle-btns{-webkit-box-flex:0;-ms-flex:0 0 110px;flex:0 0 110px}
			}
			.header__middle-btns{float:right;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}
			.header__middle-btns li{padding:0}
			.header__middle-btns li+li{margin-left:3vw}
			@media screen and (max-width:1699px) {
			.header__middle-btns li+li{margin-left:15px}
			}
			.header__bottom{background-color:#0385c1}
			@media screen and (max-width:767px) {
			.header__bottom .container{padding-left:0}
			}
			.header__bottom-inner{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;position:relative}
			.header__bottom-inner>:not(:first-child){margin-left:30px}
			@media screen and (max-width:1699px) {
			.header__bottom-inner>:not(:first-child){margin-left:20px}
			}
			.header-call-back{position:relative;padding-left:50px}
			@media screen and (max-width:1199px) {
			.header-call-back{padding-left:0}
			}
			.header-call-back__icon{fill:#fff;width:34px;height:34px;position:absolute;top:0;left:0}
			@media screen and (max-width:1199px) {
			.header-call-back__icon{position:static}
			}
			@media screen and (max-width:767px) {
			.header-call-back__icon{width:30px;height:30px}
			}
			.header-call-back__phone{color:#fff;font-size:18px;font-weight:700;white-space:nowrap}
			@media screen and (max-width:1199px) {
			.header-call-back__phone{display:none}
			}
			.header-call-back__text{color:#353535;font-size:15px}
			@media screen and (max-width:1199px) {
			.header-call-back__text{display:none}
			}
			.header-cart{position:relative;padding-left:50px}
			@media screen and (max-width:1199px) {
			.header-cart{padding-left:0}
			}
			.header-cart__btn{background-color:transparent;border:none}
			.header-cart__total-count{width:24px;height:24px;background-color:#e5354c;border-radius:50%;color:#fff;font-size:12px;font-weight:700;line-height:24px;text-align:center;position:absolute;top:-7px;left:27px;z-index:1}
			@media screen and (max-width:1199px) {
			.header-cart__total-count{width:21px;height:21px;font-size:11px;line-height:21px}
			}
			.header-cart__icon{width:40px;height:34px;fill:#fff;position:absolute;top:0;left:0}
			@media screen and (max-width:1199px) {
			.header-cart__icon{position:static}
			}
			@media screen and (max-width:767px) {
			.header-cart__icon{width:35px;height:30px}
			}
			.header-cart__title{color:#353535;font-size:15px}
			@media screen and (max-width:1199px) {
			.header-cart__title{display:none}
			}
			.header-cart__total{display:block;color:#fff;font-size:18px;font-weight:700;white-space:nowrap}
			@media screen and (max-width:1199px) {
			.header-cart__total{display:none}
			}
			#cart .dropdown-menu{color:#353535;padding:0;border-top:3px solid #02a8f3}
			@media screen and (max-width:991px) {
			#cart .dropdown-menu{display:none}
			}
			#cart .dropdown-menu li{margin-left:0}
			.header-account__link{color:#14a0d4;font-size:14px;font-weight:400;line-height:22px}
			.header-account .dropdown-menu{width:100%;max-width:390px;padding:10px}
			@media screen and (max-width:991px) {
			.header-account .dropdown-menu{min-width:290px}
			}
			.header-account .dropdown-menu h2{color:#292836;font-size:22px;font-weight:900;text-align:center;margin-bottom:30px;letter-spacing:1.4px}
			.header-account .dropdown-menu .well{-webkit-box-shadow:none;box-shadow:none;background:#fff;margin:0;border:none;padding:40px 25px 10px}
			@media screen and (max-width:991px) {
			.header-account .dropdown-menu .well{padding:40px 12px 10px}
			}
			.header-account .dropdown-menu .form-group{margin-bottom:20px}
			.header-account .dropdown-menu .form-control{height:40px;border:1px solid #e6e6e6;background-color:#fff;border-radius:0;font-size:14px!important;font-weight:400;line-height:48px;letter-spacing:.7px}
			.header-account .dropdown-menu .bbtn{width:194px;height:50px;border-radius:5px;background-color:#1cacdc;color:#fff;font-size:14px;font-weight:700;line-height:48px;text-transform:uppercase;letter-spacing:2px;margin:0 auto 30px;padding:0;display:block}
			.social-login{color:#292836;font-size:14px;font-weight:400;line-height:22px;padding:12px 25px;border-top:1px solid #e6e6e6}
			@media screen and (max-width:991px) {
			.social-login{padding:12px}
			}
			.social-login li{display:inline-block;border-bottom:none!important}
			.social-login__link{display:inline-block;width:29px;height:29px;border-radius:50%;text-align:center;padding-top:5px}
			.social-login__link--fb{background:#1b60a6}
			.social-login__icon{width:20px;height:20px;fill:#fff}
			#cleversearch form{margin:0}
			.sosearchpro-wrapper{max-width:100%}
			.search__inner{position:relative}
			.select_category{position:absolute;top:0;left:0;background:#fff;border-radius:5px 0 0 5px}
			@media screen and (max-width:1199px) {
			.select_category{display:none}
			}
			.select_category:before{content:"";display:block;position:absolute;z-index:0;width:1px;height:22px;background:#efefef;top:50%;right:0;margin-top:-11px}
			.select_category:after{content:"тМ";position:absolute;right:12px;top:0;color:#a2a2a2;background:transparent;display:block;width:8px;height:100%;z-index:0;font-size:9px;line-height:40px}
			.select_category select{max-width:180px;line-height:38px;height:40px;color:#59595e;font-size:16px;font-weight:400;border-radius:5px 0 0 5px;border:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;background:transparent;position:relative;z-index:10;padding-left:17px}
			@media screen and (max-width:1699px) {
			.select_category select{padding-left:5px;max-width:150px}
			}
			#cleversearch .autosearch-input{height:50px;border:none;border-radius:0px!important;color:#59595e;font-size:16px;font-weight:400;width:100%;padding-right:60px}
			@media screen and (max-width:1699px) {
			#cleversearch .autosearch-input{padding-right:50px}
			}
			@media screen and (max-width:1199px) {
			#cleversearch .autosearch-input{padding-left:10px;height:41px}
			}
			.sosearchpro-wrapper .input-group-btn{position:absolute;top:0;right:0;width:inherit;max-width:55px}
			@media screen and (max-width:1199px) {
			.sosearchpro-wrapper .input-group-btn{max-width:41px}
			}
			.sosearchpro-wrapper .button-search{height:40px;padding:7px 10px;border-radius:0 5px 5px 0;background:#0385c1;border:1px solid #0385c1;-webkit-box-shadow:none;box-shadow:none;max-width:56px}
			@media screen and (max-width:1199px) {
			.sosearchpro-wrapper .button-search{height:31px}
			}
			.sosearchpro-wrapper .button-search .icon{fill:#fff;max-width:100%;max-height:100%;position:static}
			@media screen and (max-width:1199px) {
			.owl-carousel.carousel{padding:0 50px}
			}
			.owl-carousel .item__image{max-height:45px;margin-bottom:25px;padding-right:15px}
			.owl-carousel .item__title{color:#353535;font-size:16px;font-weight:700;text-transform:uppercase;margin-bottom:20px;padding-right:15px}
			.owl-carousel .item__text{color:#59595e;font-size:15px;line-height:22px;margin-bottom:25px;padding-right:15px}
			.owl-carousel .item__link{color:#14a0d4;font-size:16px;line-height:22px;padding-right:15px}
			.owl-carousel .item__link-icon{width:22px;height:15px;fill:#1cacdc;position:relative;top:2px}
			@media screen and (max-width:767px) {
			.home-banner.owl-carousel{margin-left:-15px;width:-webkit-calc(100% + 30px);width:calc(100% + 30px)}
			}
			.featured-wrap{display:grid;grid-template-columns:repeat(3,1fr);grid-column-gap:30px;grid-row-gap:40px}
			@media screen and (max-width:1699px) {
			.featured-wrap{grid-template-columns:1fr 1fr}
			}
			@media screen and (max-width:767px) {
			.featured-wrap{grid-template-columns:1fr}
			}
			.featured{-webkit-box-shadow:0 3px 40px rgba(0,0,0,0.1);box-shadow:0 3px 40px rgba(0,0,0,0.1);border-radius:5px;border:1px solid #e6e6e6;background-color:#fff;overflow:hidden}
			.featured__header{height:46px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;border-bottom:1px solid #e6e6e6}
			.featured__icon-wrap{width:52px;height:100%;position:relative;background-color:#1cacdc}
			.featured__icon{max-width:30px;max-height:30px;fill:#fff;position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}
			.featured__title{-webkit-box-flex:1;-ms-flex:1;flex:1;padding:0 25px;color:#353535;font-size:16px;font-weight:700;text-transform:uppercase;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
			@media screen and (max-width:1199px) {
			.featured__title{padding:0 0 0 12px}
			}
			.featured__arrows{width:90px;display:-webkit-box;display:-ms-flexbox;display:flex}
			.featured__arrows>:not(:last-child):after{content:"";display:block;width:1px;height:22px;background:#dcdcdc;position:absolute;top:50%;right:-6px;margin-top:-11px}
			.featured__arrow{width:32px;height:32px;position:relative;border-radius:50%;margin:0 6px}
			.featured__arrow .icon{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);width:8px;height:14px;fill:#353535}
			.featured__item{padding:20px 15px 30px}
			.featured__item .product-layout{max-width:210px;margin:0 auto}
			.dropdown-menu{-webkit-box-shadow:none!important;box-shadow:none!important;border-radius:0px!important;background-color:#fff;padding:18px 12px}
			.language-list{display:block;text-transform:uppercase}
			.language-list .dropdown-menu{padding:10px 12px}
			.language-list li+li{margin-left:15px;margin-top:5px}
			@media screen and (max-width:767px) {
			.language-list li+li{margin-left:0}
			}
			.language-list form{margin:0}
			.language-select{background-color:transparent;border:none;display:inline;padding:0;margin:0;text-transform:uppercase}
			.language-select.is-active{font-weight:700}
			.language-select-dropdown .language-select{color:#353535;font-size:14px;text-align:left}
			.social__item+.social__item{margin-left:15px}
			.social__link{display:block}
			.social__icon{fill:#fff;width:20px;height:20px;position:relative;top:4px}
			.modal-msg{display:none;position:fixed;width:70%;z-index:99999;padding:20px 10px;text-align:center;left:15%;top:40%;-webkit-box-shadow:0 3px 100px rgba(0,0,0,0.5);box-shadow:0 3px 100px rgba(0,0,0,0.5);border-radius:5px;border:1px solid #e6e6e6;background-color:#fff;font-size:18px}
			.modal-msg__close{position:absolute;top:0;right:0;z-index:1;opacity:.8;padding:5px}
			.modal-msg__close-icon{width:16px;height:16px;fill:#000}
			.catalog{position:relative}
			.catalog__heding{height:100%;background-color:#e5354c;text-transform:uppercase;padding:0 20px;line-height:56px;width:350px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;font-size:15px}
			@media screen and (max-width:1699px) {
			.catalog__heding{max-width:190px}
			}
			.catalog__heding__icon{width:28px;height:17px;fill:#fff;margin-right:20px}
			.catalog__list-wrap{position:absolute;top:100%;left:0;z-index:11;display:none;-webkit-box-shadow:0 3px 40px rgba(0,0,0,0.1);box-shadow:0 3px 40px rgba(0,0,0,0.1);border:1px solid #e6e6e6;background-color:#fff;padding:25px 0;width:350px}
			@media screen and (max-width:991px) {
			.catalog__list-wrap{width:320px}
			}
			@media screen and (min-width:1699px) {
			.common-home .catalog__list-wrap{display:block}
			}
			.header-bottom-nav{width:100%;font-size:0;-webkit-box-flex:1;-ms-flex:1;flex:1}
			@media screen and (max-width:1199px) {
			.header-bottom-nav{display:none}
			}
			.header-bottom-nav a{font-size:16px;font-weight:500;padding:0 20px;line-height:56px;color:#fff;display:inline-block;position:relative}
			.header-bottom-nav a:last-child{padding-right:0}
			@media screen and (max-width:1699px) {
			.header-bottom-nav a{padding:0 14px}
			}
			.header-bottom-nav a+a:before{content:"";display:block;width:1px;height:22px;background:#14a0d4;position:absolute;top:50%;left:0;margin-top:-11px}
			.header-bottom-links{font-size:0;white-space:nowrap;display:-webkit-box;display:-ms-flexbox;display:flex}
			@media screen and (max-width:1199px) {
			.header-bottom-links{margin-left:auto!important}
			}
			@media screen and (max-width:767px) {
			.header-bottom-links{display:none}
			}
			.header-bottom-links a{padding:0 15px;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;color:#fff;text-transform:uppercase;font-size:14px;font-weight:700;line-height:56px;-webkit-box-align:center;-ms-flex-align:center;align-items:center}
			.header-bottom-links a:last-child{padding-right:0}
			.header-bottom-links__icon{margin-right:12px}
			.header__mob-menu-btn{display:none;color:#fff;font-size:17px;font-weight:400;line-height:42px;margin-right:0}
			@media screen and (max-width:1199px) {
			.header__mob-menu-btn{display:block}
			}
			.header__mob-menu{position:absolute;z-index:10;top:100%;right:0;background-color:#14a0d4;max-height:0;overflow:hidden;padding:0 30px;display:none}
			@media screen and (max-width:1199px) {
			.header__mob-menu{display:block}
			}
			@media screen and (max-width:767px) {
			.header__mob-menu{right:-15px}
			}
			.mob-menu__list{margin-bottom:30px}
			.mob-menu__phone-list{color:#fff;font-size:15px;font-weight:400;line-height:30px;margin-bottom:40px}
			.bbtn{display:inline-block;text-decoration:none;color:#fff;background-color:#14a0d4;border:1px solid #14a0d4;border-radius:5px;font-size:13px;line-height:13px;font-weight:700;text-transform:uppercase;text-align:center;padding:5px 10px;height:38px}
			.product-layout{text-align:center}
			.product-layout__image{margin-bottom:15px}
			.product-layout__image img{margin:0 auto}
			.product-layout__name,.product-layout__name a{color:#353535;font-size:15px;line-height:1.25em;height:2.6em;overflow:hidden;text-overflow:ellipsis;margin-bottom:10px}
			.banner-2{padding:65px 0}
			.banner-2__item{position:relative;margin-bottom:25px}
			.banner-2__content{position:absolute;top:0;left:0;bottom:0;max-width:300px;padding-left:50px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}
			.banner-2__content>:not(:last-child){margin-bottom:25px}
			@media screen and (max-width:580px) {
			.banner-2__content{max-width:none;bottom:auto;padding:50px 25px 0;width:100%}
			}
			.banner-2__title{color:#353535;font-size:36px;font-weight:700;line-height:36px}
			.banner-2__text{color:#59595e;font-size:18px;font-weight:400}
			.banner-2__link{color:#1cacdc;font-size:16px;font-weight:400;line-height:22px}
			.banner-2__link-icon{width:22px;height:15px;fill:#1cacdc;position:relative;top:2px}
			@media screen and (max-width:580px) {
			.banner-2__img{text-align:right;background:#f3f3f3;border-radius:5px}
			}
			@media screen and (max-width:580px) {
			.banner-2__img img{display:inline-block}
			}
			@media screen and (max-width:767px) {
			#carousel0 .item{text-align:center}
			.owl-carousel .item__image{margin:0 auto 20px}
			}
			@media screen and (min-width:1280px) {
			.common-home .featured-wrap .featured.js-featured{max-height:465px;overflow:hidden}
			}
			.header__mob-menu-btn.js-mob-menu-btn,.header__mobile,.show-mobile-search .mobile-main-menu{display:none}
			.show-mobile-menu{overflow:hidden!important}
			.mobile-main-menu{background:transparent;border:0;align-items:center;justify-content:center; margin-right: 5px;}
			.mobile-main-menu svg{width:40px;height:40px;fill:#fff}
			.show-mobile-menu .mobile-menu-wrap{opacity:1}
			.mobile-menu-wrap{opacity:0;position:fixed;left:0;right:0;bottom:0;top:0;z-index:99999;background:rgba(0,0,0,.5);transition:.3s ease-in-out}
			.mobile-main-menu-close{position:fixed;bottom:50px;right:3%;width:50px;height:50px;background:#fff;z-index:999999;border-radius:50%;border:0;display:none;align-items:center;justify-content:center;transition:.3s ease-in-out}
			.show-mobile-menu .mobile-main-menu-close{display:flex}
			.mobile-main-menu-close:after{content:'';display:block;width:16px;height:16px;filter:brightness(0.2);background-image:url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjMyOXB0IiB2aWV3Qm94PSIwIDAgMzI5LjI2OTMzIDMyOSIgd2lkdGg9IjMyOXB0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Im0xOTQuODAwNzgxIDE2NC43Njk1MzEgMTI4LjIxMDkzOC0xMjguMjE0ODQzYzguMzQzNzUtOC4zMzk4NDQgOC4zNDM3NS0yMS44MjQyMTkgMC0zMC4xNjQwNjMtOC4zMzk4NDQtOC4zMzk4NDQtMjEuODI0MjE5LTguMzM5ODQ0LTMwLjE2NDA2MyAwbC0xMjguMjE0ODQ0IDEyOC4yMTQ4NDQtMTI4LjIxMDkzNy0xMjguMjE0ODQ0Yy04LjM0Mzc1LTguMzM5ODQ0LTIxLjgyNDIxOS04LjMzOTg0NC0zMC4xNjQwNjMgMC04LjM0Mzc1IDguMzM5ODQ0LTguMzQzNzUgMjEuODI0MjE5IDAgMzAuMTY0MDYzbDEyOC4yMTA5MzggMTI4LjIxNDg0My0xMjguMjEwOTM4IDEyOC4yMTQ4NDRjLTguMzQzNzUgOC4zMzk4NDQtOC4zNDM3NSAyMS44MjQyMTkgMCAzMC4xNjQwNjMgNC4xNTYyNSA0LjE2MDE1NiA5LjYyMTA5NCA2LjI1IDE1LjA4MjAzMiA2LjI1IDUuNDYwOTM3IDAgMTAuOTIxODc1LTIuMDg5ODQ0IDE1LjA4MjAzMS02LjI1bDEyOC4yMTA5MzctMTI4LjIxNDg0NCAxMjguMjE0ODQ0IDEyOC4yMTQ4NDRjNC4xNjAxNTYgNC4xNjAxNTYgOS42MjEwOTQgNi4yNSAxNS4wODIwMzIgNi4yNSA1LjQ2MDkzNyAwIDEwLjkyMTg3NC0yLjA4OTg0NCAxNS4wODIwMzEtNi4yNSA4LjM0Mzc1LTguMzM5ODQ0IDguMzQzNzUtMjEuODI0MjE5IDAtMzAuMTY0MDYzem0wIDAiIHN0eWxlPSJmaWxsOiNmZmY7Ii8+PC9zdmc+);background-size:cover}
			.mobile-menu-wrap .mobile-menu__list{background-color:#fff;height:auto;min-height:100%;width:82%;max-width:450px;transition:.3s ease-in-out}
			.show-mobile-menu .mobile-menu-wrap .mobile-menu__list{overflow-y:scroll;height:100%}
			.header.is-fixed .mobile-menu-wrap .header__logo{display:block!important}
			.header.is-fixed .header__col-lic{display:none!important}
			#catalog_mobile .catalog__list-wrap{width:100%;display:block;position:unset;padding:0;margin:20px 0;box-shadow:unset;border:0}
			#catalog_mobile .catalog__list>.catalog__list-item:not(:last-child){border-bottom:1px solid #e6e6e64f}
			#catalog_mobile .catalog__list-icon{left:5px}
			#catalog_mobile .catalog__list-link:active .catalog__list-icon,#catalog_mobile .catalog__list-link:focus .catalog__list-icon,#catalog_mobile .catalog__list-link:hover .catalog__list-icon{fill:#14a0d4}
			.show-mobile-menu.modal-open .modal{overflow-x:hidden;overflow-y:auto;z-index:999999!important;background:#000000a8;margin:auto}
			.show-mobile-menu .modal-backdrop.in{opacity:0}
			.header__mobile{background-color:#0385c1;align-items:center;grid-template-columns:50px 1fr 50px;grid-column-gap:15px;padding:10px}
			.header__mobile.logged{grid-template-columns:50px 1fr 40px 50px}
			.header__mobile.logged .logged-mobile-header{text-align:center}
			.header__mobile.logged .logged-mobile-header svg{margin:0;width:25px;height:25px}
			.header__mobile .button-search{background:#1cacdc!important;border-color:#1cacdc!important}
			.header__mobile .header__col-search{width:100%}
			.mobile-menu-wrap .mob-head-menu{background-color:#0385c1;display:flex;align-items:center;justify-content:space-between;padding:20px 10px}
			.mobile-menu-wrap .mob-head-menu .dropdown-toggle{color:#fff;font-weight:600}
			.mobile-menu-wrap .lang{width:50px;margin-left:30px}
			.mobile-menu-wrap .mob-menu__contacts{margin:20px 0;grid-template-columns:1fr 1fr}
			.mobile-menu-wrap .mob-menu__message-list{display:flex;margin:15px 0;justify-content:space-evenly}
			.mobile-menu-wrap .mob-menu__message-list a{display:flex;align-items:center;color:#525252;font-size:14px;font-weight:400;line-height:1;padding:5px 10px}
			.mobile-menu-wrap .mob-menu__message-list a svg{width:40px;height:45px;margin-right:7px}
			.mobile-menu__list .mob-menu__list{margin-bottom:15px}
			.mobile-menu-wrap .mob-menu__list a{color:#525252;font-size:15px;font-weight:400;margin-bottom:8px;padding:5px}
			.mobile-menu-wrap .mob-wishlist li a{color:#525252;font-size:15px;font-weight:400;margin-bottom:0;padding:5px;display:block}
			.mobile-menu-wrap .mob-menu__list a .fa{width:25px;text-align:center;margin-right:5px;font-size:17px}
			.mobile-menu-wrap .header-bottom-links__icon{margin-right:10px;width:25px;height:25px;object-fit:contain}
			.dropdown.header__account li a{font-size: 18px}
			.mobile-menu-wrap .mob-wishlist li svg,.dropdown.header__account li a svg{margin-right:10px;width:25px;height:20px;object-fit:contain;fill:#525252}
			.dropdown.header__account li a i{font-size: 20px;margin-right:14px;width: 25px;}
			.mobile-menu-wrap .mob-menu__social{display:flex}
			.mobile-menu-wrap .mob-menu__social .social__item{margin:0 5px}
			.mobile-menu-wrap .social__icon{fill:#525252;width:40px;height:25px}
			.mobile-menu-wrap .header__account-icon,.mobile-menu-wrap .head_menu .do-popup-element i{fill:#cfcfcf;width:30px;height:20px;color:#cfcfcf;font-size:20px;text-align:center;margin-right:12px}
			.mobile-menu-wrap .head_menu .do-popup-element,.mobile-account span,.cardModal_mob .do-popup-element{color:#515151;padding:10px 5px;font-size:15px;display:block;border-bottom:1px solid #f7f7f7}
			.cardModal_mob .do-popup-element{display:flex!important}
			.cardModal_mob .do-popup-element b{font-weight:400;display:block;font-size:12px;color:#9a9a9a}
			.mobile-menu-wrap .mob-menu__phone-list{margin:0}
			.mobile-menu-wrap .mob-menu__phone-list a{color:#525252;font-size:15px;font-weight:400;line-height:1;padding:5px 10px;display:flex;align-items: center;margin-bottom:10px}
			.mobile-menu-wrap .mob-menu__phone-list a svg{margin-right: 10px;}
			.mobile-menu-wrap .mobile-callback{width:100%;margin-top:10px;border:0;padding:13px;background:#0385c1}
			.mobile-menu-wrap .catalog__list-wrap .level_1 > .topmenu{display:none!important}
			.mobile-menu-wrap .language-list li+li{margin-left:0}
			.show-mobile-menu #loginModal{z-index:999999!important;top:25px!important;left:0;right:0;max-height:90vh;overflow:scroll}
			.show-mobile-login #mobile-logged,.show-mobile-cardModal .cardModal_wrap{display:block;position:fixed;z-index:999999;left:0;right:0;top:0;bottom:0;background:#00000042}
			.show-mobile-cardModal .cardModal_wrap #cardModal{top:40px!important}
			.show-mobile-cardModal .main-overlay-popup{display:none!important}
			.show-mobile-cardModal .mobile-main-menu-close{z-index:9999}
			.show-mobile-cardModal .mobile-menu-wrap{overflow:hidden!important}
			.mobile-account{position:relative}
			.dropdown.header__account.open>.dropdown-menu{width:210px}
			.dropdown.header__account.open>.dropdown-menu li{margin:0!important}
			.dropdown.header__account a,.dropdown.header__account li a{color:#525252;font-size:14px;font-weight:700;line-height:1;padding:5px 10px;display:block}
			.dropdown.header__account a > svg.header__account-icon{position:unset;margin:0;width:30px;height:30px}
			.dropdown.header__account li>a:hover,.dropdown.header__account a:hover{text-decoration:underline;background-color:unset;background-image:unset;opacity:1;color:#525252}
			#cardModal{display:none}
			@media screen and (max-width:768px) {
			.mobile-menu-wrap .dropdown-backdrop,.dropdown.header__account{display:none!important}
			.header__top,.header__middle,.header__bottom{display:none}
			.mobile-main-menu{display:flex}
			.header__mobile{display:grid}
			.show-mobile-menu{padding-right:0}
			.show-mobile-menu.modal-open .modal .modal-dialog{margin-left:auto;margin-right:auto}
			.mobile-menu-wrap .catalog__list-wrap .level_1 > .topmenu{display:unset!important}
			}
			@media screen and (min-width: 765px){
				
				#catalog_mobile .catalog__list > .catalog__list-item .catalog__list-link .catalog__list-arrow-wrap{
					opacity: 0;	
				}
			}
			@media screen and (max-width:480px) {
				.product-layout__image .xdstickers_wrapper{
					display: flex;
					max-width: 123px;
					top: 15px;
					flex-wrap: wrap;
				}
				.product-layout__image .xdstickers {
				    font-size: 9px;
				}
				.header.is-fixed{
					z-index: 1000 !important;
				}
			.mobile-menu-wrap .catalog__list-link,.mobile-menu-wrap .head_menu .do-popup-element,.mobile-account span,.cardModal_mob .do-popup-element{font-size:14px}
			#ratingBadgeContainer{position:unset!important;z-index:0!important;height:70px;border:1px none #f5f5f5;z-index:2147483647;position:fixed;right:0;bottom:0;box-shadow:#a20000 -1px 1px 3px;text-indent:0;margin:10px 0 0!important;margin-top:0;padding:0;background:transparent none repeat scroll 0 0;float:none;line-height:normal;font-size:1px;vertical-align:baseline;display:inline-block;width:165px;height:54px}
			#ratingBadgeContainer iframe{position:static!important}
			}
			
			@keyframes lds-rolling {
			0%{-webkit-transform:translate(-50%,-50%) rotate(0deg);transform:translate(-50%,-50%) rotate(0deg)}
			100%{-webkit-transform:translate(-50%,-50%) rotate(360deg);transform:translate(-50%,-50%) rotate(360deg)}
			}
			@-webkit-keyframes lds-rolling {
			0%{-webkit-transform:translate(-50%,-50%) rotate(0deg);transform:translate(-50%,-50%) rotate(0deg)}
			100%{-webkit-transform:translate(-50%,-50%) rotate(360deg);transform:translate(-50%,-50%) rotate(360deg)}
			}
			.lds-rolling{position:relative;text-align:center}
			.lds-rolling div,.lds-rolling div:after{position:absolute;width:160px;height:160px;border:20px solid #bbcedd;border-top-color:transparent;border-radius:50%}
			.lds-rolling div{-webkit-animation:lds-rolling 1s linear infinite;animation:lds-rolling 1s linear infinite;top:100px;left:100px}
			.lds-rolling div:after{-webkit-transform:rotate(90deg);transform:rotate(90deg)}
			.lds-rolling{width:200px!important;height:200px!important;-webkit-transform:translate(-100px,-100px) scale(1) translate(100px,100px);transform:translate(-100px,-100px) scale(1) translate(100px,100px);margin:0 auto}
			.col-pd-15{padding-left:15px;padding-right:15px}
			.col-mb-10{margin-bottom:10px}
			#boc_order hr{margin-top:0;margin-bottom:15px}
			.boc_product_info > div{line-height:120px}
			.boc_product_info > div > img{max-height:120px;margin:0 auto}
			.boc_product_info > div > img,.boc_product_info > div > div,.boc_product_info > div > p{display:inline-block;line-height:normal;vertical-align:middle}
			#boc_order .checkbox{margin-top:0;padding:0 10px;border:1px solid transparent;border-radius:6px}
			#boc_order .checkbox.has-error{border-color:#a94442}
			@media (max-width: 767px) {
			.boc_product_info > div{line-height:normal;text-align:center}
			}
		</style>
		
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-K3MKBK7');</script>
		<!-- End Google Tag Manager -->
	</head>
	<body class="<?php echo $class; ?>">
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K3MKBK7"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		
		<?php
			$logo = '/image/data/Logo_horisontal.png';
		?>
		<div class="site">
			<header class="site__header header">
				
				
				
				<div class="header__fixed-container">
					<?php if (!empty($modules)) { ?>
						<?php foreach ($modules as $module) { ?>
							<div><?php echo $module; ?></div>
						<?php } ?>
					<?php } ?>
					
					<!-- <div class="header__top">
						<div class="container">
						<div class="header__top-inner">
						
						<ul class="list-inline header__top-right">
						<li class="dropdown header__account header-account">
						<a href="javascript:void(0);" title="<?php echo $text_account; ?>" <?php if ($logged) { ?> class="dropdown-toggle"  data-toggle="dropdown"<?php } else { ?> class="do-popup-element" data-target="loginModal"<?php } ?>>
						<svg class="icon header__account-icon">
						<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#user"></use>
						</svg>
						<span><?php echo $text_account; ?></span>
						</a>
						
						<?php if ($logged) { ?>
							<ul class="dropdown-menu">
							<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
							<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
							<li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
							<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
							<li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
							</ul>
							<?php } else { ?>
							<?php echo $loginmodal; ?>
						<?php } ?>
						</li>
						
						
						</ul>
						</div>
						</div>
					</div> -->
					
					<div class="header__middle">
						<div class="container">
							<div class="header__middle-inner">								
								<div class="header__col-lic hidden-md hidden-xs">
									<a href="https://pharmacy.dls.gov.ua/check?EDRPOU=22974151" target="_blank" rel="nofollow noindex" noindex nofollow><img src="<?php echo $licence_logo; ?>" alt="Перевірити ліцензію" /></a>
								</div>
								<div class="header__col-logo">									
									<div class="header__logo logo">
										<a href="<?php echo $home; ?>" class="logo__link"><img class="logo__img img-responsive" width="180" src="https://e-apteka.com.ua/image/data/logo_eaptekav2.png" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"></a>
									</div>
								</div>
								<div class="header__col-search">
									<?php echo $search; ?>
								</div>
								<div class="header__col-middle-btns">
									<ul id="list-inline_btn" class="list-inline header__middle-btns">

										<li class="header__mobile-main-menu header-mobile-main-menu">	
											<button class="desktop mobile-main-menu">
												<svg height="384pt" viewBox="0 -53 384 384" width="384pt" xmlns="http://www.w3.org/2000/svg"><path d="m368 154.667969h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 32h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 277.332031h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/></svg>
											</button>
										</li>

										
										<li class="header__col-search_btn_mob" style="display: none;">
											<button><svg class="icon button-search__icon"><use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#search"></use></svg></button>
										</li>
										<li class="call-back-wrap">
											<div class="header__call-back header-call-back">
												<div class="header-call-back__link">
													<a class="call_href dropdown-toggle" data-toggle="dropdown">
														<svg class="header-call-back__icon" id="Слой_1" data-name="Слой 1" width="34" height="34" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-133{fill:#fff;}</style></defs><path class="cls-133" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"/><path class="cls-133" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"/><path class="cls-133" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"/><path class="cls-133" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"/><path class="cls-133" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"/><path class="cls-133" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"/></svg>
													</a>
													<?php /* ?>
													<a class="header-call-back__phone dropdown-toggle"  data-toggle="dropdown"><?php echo $text_callcenter; ?></a>
													<?php */ ?>
												<?php /* ?>	<br />
													<a href="javascript:void(0)" class="header-call-back__text" onclick="$('.imcallask-btn-mini').click();"><?php echo $text_order_call; ?></a>
												<?php */ ?>
													<ul class="dropdown-menu message-list">
														<li>
															<a href="https://t.me/agp_eapteka_bot">
																<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" fill="#039be5" r="12"/><path d="m5.491 11.74 11.57-4.461c.537-.194 1.006.131.832.943l.001-.001-1.97 9.281c-.146.658-.537.818-1.084.508l-3-2.211-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953z" fill="#fff"/></svg>
																Telegram
															</a>
														</li>
														<li>
															<a href="viber://pa?chatURI=eapteka">
																<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><g fill="#8e24aa"><path d="m23.155 13.893c.716-6.027-.344-9.832-2.256-11.553l.001-.001c-3.086-2.939-13.508-3.374-17.2.132-1.658 1.715-2.242 4.232-2.306 7.348-.064 3.117-.14 8.956 5.301 10.54h.005l-.005 2.419s-.037.98.589 1.177c.716.232 1.04-.223 3.267-2.883 3.724.323 6.584-.417 6.909-.525.752-.252 5.007-.815 5.695-6.654zm-12.237 5.477s-2.357 2.939-3.09 3.702c-.24.248-.503.225-.499-.267 0-.323.018-4.016.018-4.016-4.613-1.322-4.341-6.294-4.291-8.895.05-2.602.526-4.733 1.93-6.168 3.239-3.037 12.376-2.358 14.704-.17 2.846 2.523 1.833 9.651 1.839 9.894-.585 4.874-4.033 5.183-4.667 5.394-.271.09-2.786.737-5.944.526z"/><path d="m12.222 4.297c-.385 0-.385.6 0 .605 2.987.023 5.447 2.105 5.474 5.924 0 .403.59.398.585-.005h-.001c-.032-4.115-2.718-6.501-6.058-6.524z"/><path d="m16.151 10.193c-.009.398.58.417.585.014.049-2.269-1.35-4.138-3.979-4.335-.385-.028-.425.577-.041.605 2.28.173 3.481 1.729 3.435 3.716z"/><path d="m15.521 12.774c-.494-.286-.997-.108-1.205.173l-.435.563c-.221.286-.634.248-.634.248-3.014-.797-3.82-3.951-3.82-3.951s-.037-.427.239-.656l.544-.45c.272-.216.444-.736.167-1.247-.74-1.337-1.237-1.798-1.49-2.152-.266-.333-.666-.408-1.082-.183h-.009c-.865.506-1.812 1.453-1.509 2.428.517 1.028 1.467 4.305 4.495 6.781 1.423 1.171 3.675 2.371 4.631 2.648l.009.014c.942.314 1.858-.67 2.347-1.561v-.007c.217-.431.145-.839-.172-1.106-.562-.548-1.41-1.153-2.076-1.542z"/><path d="m13.169 8.104c.961.056 1.427.558 1.477 1.589.018.403.603.375.585-.028-.064-1.346-.766-2.096-2.03-2.166-.385-.023-.421.582-.032.605z"/></g></svg>
																Viber
															</a>
														</li>
														<li>
															<a href="http://m.me/192129140851355">
																<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 11.111c0 3.496 1.744 6.615 4.471 8.652v4.237l4.086-2.242c1.09.301 2.245.465 3.442.465 6.627 0 12-4.974 12-11.111.001-6.137-5.372-11.112-11.999-11.112s-12 4.974-12 11.111zm10.734-3.112 3.13 3.259 5.887-3.259-6.56 6.962-3.055-3.258-5.963 3.259z" fill="#2196f3"/></svg>
																Messenger
															</a>
														</li>
														<li>
															<a href="tel:+380445200333" class="header-call-back__phone">
																<svg class="" id="Слой_1" data-name="Слой 1" width="35" height="35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
																044-520-03-33
															</a>
															<a href="tel:+380683450131" class="header-call-back__phone">
																<svg class="" id="Слой_1" data-name="Слой 1" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
																068-345-01-31
															</a>
															<a href="tel:+380503450131" class="header-call-back__phone">
																<svg class="" id="Слой_1" data-name="Слой 1" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
																050-345-01-31
															</a>
															<a href="tel:+380733450131" class="header-call-back__phone">
																<svg class="" id="Слой_1" data-name="Слой 1" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
																073-345-01-31
															</a>
														</li>
													</ul>
												</div>
											</div>
										</li>

										<li class="dropdown header__account header-account">
											<a href="javascript:void(0);" title="<?php echo $text_account; ?>" class="dropdown-toggle"  data-toggle="dropdown">
												<svg class="icon header__account-icon">
													<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#user"></use>
												</svg>
											</a>
											<ul class="dropdown-menu">
												<?php if ($logged) { ?>
													<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
													<?php if ($card) { ?>
														<li>
															<a href="javascript:void(0);" class="do-popup-element" data-target="cardModal"><i class="fa fa-id-card-o"></i><?php echo $card; ?></a>
															<!-- <?php echo $cardmodal; ?>	 -->
														</li>
													<?php } ?>
													<li><a href="<?php echo $order; ?>"><i class="fa fa-history"></i><?php echo $text_order; ?></a></li>													
													<?php } else { ?>
													<a href="javascript:void(0);" class="do-popup-element" data-target="loginModal"><?php echo $text_account; ?></a>
												<?php } ?>
												<li>
													<a href="<?php echo $compare; ?>" title="Сравнение">
														<svg class="icon compare__icon">
															<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use>
														</svg>
														<?php echo $text_compare ?>
													</a>
												</li>
												<li>
													<a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>">
														<svg class="icon wishlist__icon">
															<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#heart"></use>
														</svg>
														<?php echo $text_wishlist ?>
													</a>
												</li>																								
												
											</ul>
											<?php if (!$logged) {
												echo $loginmodal;
											} ?>
											<?php if ($logged && $card) { ?>
												<?php echo $cardmodal; ?>
											<?php } ?>
										</li>

										<script>
											var copyCart = function(returnData){
												$('#mobile-cart').html(returnData);
											}
											var copyСustomer = function(returnData){
												$('#mobile-customer').html(returnData);
											}
										</script>
										<li id="wide-cart" class="ajax-module-reloadable" data-modpath="common/cart/info" data-afterload="copyCart"></li>
									</ul>
								</div>
							</div>  <!-- /.header__middle-inner -->
						</div>
					</div>  <!-- /.header__middle -->
					
					<div class="header__bottom">
						<div class="container">
							<div class="header__bottom-inner">
								
								<div id="catalog" class="catalog">
									<?php echo $catalog; ?>
									<!--div class="catalog__heding js-catalog-btn">
										<svg class="icon catalog__heding__icon">
										<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#burger"></use>
										</svg>Каталог<span class="hidden-lg hidden-md hidden-sm hidden-xs">&nbsp;&nbsp;товаров</span>
										</div>
										<div class="catalog__list-wrap">
									</div-->
								</div>
								
								<div class="header__bottom-nav header-bottom-nav">
									<a class="header-bottom-nav__link" href="<?php echo $drugstores; ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $text_a; ?></a>
									<a class="header-bottom-nav__link" href="<?php echo $delivery; ?>"><i class="fa fa-ambulance" aria-hidden="true"></i> <?php echo $text_de; ?></a>
									<a class="header-bottom-nav__link" href="<?php echo $about_us; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_about; ?></a>
									
									<a class="header-bottom-nav__link" href="<?php echo $vacancies; ?>"><i class="fa fa-bullhorn" aria-hidden="true"></i> <?php echo $text_vacancies; ?></a>
									
									<? /*
										<a class="header-bottom-nav__link" href="<?php echo $loyality; ?>"><?php echo $text_3; ?></a>
										<a class="header-bottom-nav__link" href="<?php echo $newsfeed; ?>"><?php echo $text_5; ?></a>
									*/ ?>
								</div>
								
								<div id="header__mob-menu" class="header__mob-menu mob-menu">
									<div class="mob-menu__list"></div>
									<div class="mob-menu__phone-list"></div>
									<ul class="mob-menu__social"></ul>
								</div>
								
								<div class="header__bottom-links header-bottom-links">

								<?php if ($display_promotions) { ?>	
									<a href="<?php echo $promotions; ?>" style="background-color: #e5354c; color: #fff;" title="<?php echo $text_promotions; ?>">
										<img src="/catalog/view/theme/default/img/action_inverted.svg" alt="action-icon" width="30px" height="30px" class="header-bottom-links__icon">
									<?php echo $text_promotions; ?></a>
								<?php } ?>

								<?php if ($display_specials) { ?>	
									<a href="<?php echo $specials; ?>" title="<?php echo $text_special; ?>">
										<img src="/catalog/view/theme/default/img/action.svg" alt="action-icon" width="30px" height="30px" class="header-bottom-links__icon">
									<?php echo $text_special; ?></a>
								<?php } ?>

									<? /*	<a href="<?php echo $spravochnik; ?>"><img src="/catalog/view/theme/default/img/info.svg" alt="action-icon" width="22px" height="26px" class="header-bottom-links__icon"><?php echo $text_spr; ?></a> */ ?>
								</div>
								<li><?php echo $language; ?></li>
								<li>
									<button id="changeVisionHeader" title="Версія для людей з порушеннями зору"><i class="fa fa-low-vision" aria-hidden="true"></i></button>
									<li class="font-size-btns" style="font-size: 14px;">
										<div id="fontIncHeader" class="">
										A-
										</div>
										<div id="fontDecHeader">
										A+
										</div>
										<div class="clearfix"></div>
									</li>
								</li>
								
								<div class="header__mob-menu-btn js-mob-menu-btn">Меню</div>
								
							</div>
						</div>
					</div>  <!-- /.header__bottom -->
					<div class="header__mobile <?php /* if ($logged) { ?>logged<?php } */ ?>">
						<button class="mobile-main-menu">
							<svg height="384pt" viewBox="0 -53 384 384" width="384pt" xmlns="http://www.w3.org/2000/svg"><path d="m368 154.667969h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 32h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 277.332031h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/></svg>
						</button>
						<div class="search-wrap">
							
						</div>
						<?php /* if ($logged) { ?>
							<a href="<?php echo $account; ?>" title="Войдите в личный кабинет" class="logged-mobile-header">
								<svg class="icon header__account-icon">
									<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#user"></use>
								</svg>
							</a>
						<?php } */ ?>						
						<span id="mobile-cart"><?php echo $cart; ?></span>
					</div>
				</div>  <!-- /.header__fixed-container -->
				<button class="mobile-main-menu-close"></button>
				<div class="mobile-menu-wrap" style="transform: translate(-100%);">
					
					<div class="mobile-menu__list">
						<div class="mob-head-menu">
							<div class="header__logo logo">
								<a href="<?php echo $home; ?>" class="logo__link"><img class="logo__img img-responsive" width="280" height="35" src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"></a>
							</div>
							<div class="lang">
								<?php echo $language; ?>
							</div>
						</div>
						<div class="head_menu">
							
							<?php if ($logged) { ?>
								<div class="mobile-account" style="position: relative;">
									<span class="dropdown-toggle" data-toggle="dropdown">
										<svg class="icon header__account-icon">
											<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#user"></use>
										</svg>
										<?php echo $text_account; ?> <i class="fa fa-caret-down"></i>
									</span>
									<ul class="dropdown-menu mobile-logged">
										<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
										<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
										<li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
										<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
										<li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
									</ul>									
								</div>
								<?php if ($card) { ?>
									<li class="cardModal_mob">
										<a href="javascript:void(0);" class="do-popup-element" data-target="cardModalMob"><i class="fa fa-id-card-o"></i>
											<span><?php echo $text_mycard; ?>
											<b><?php echo $text_mycard_small; ?></b></span>
										</a>
										<div class="cardModal_wrap"></div>
									</li>
								<?php } ?>
								<?php } else { ?>
								<a href="javascript:void(0);" title="Войдите в личный кабинет" class="do-popup-element" data-target="loginModal">
									<svg class="icon header__account-icon">
										<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#user"></use>
									</svg>
									<span><?php echo $text_account; ?></span>
								</a>								
							<?php } ?>
								<li class="cardModal_mob">
										<a href="javascript:void(0);" class="do-popup-element" onclick="initScanner();"><i class="fa fa-barcode"></i>
											<span>Пошук по штрихкоду</span>
										</a>									
								</li>

							
							
							
							<div id="catalog_mobile">
								
							</div>
							
							<div id="header__mob-menu_new">
								<div class="mob-menu__list"></div>
								<div class="mob-wishlist">
									<li>
										<a href="<?php echo $compare; ?>" title="Порівняння">
											<svg class="icon compare__icon">
												<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use>
											</svg>
											<?php echo $text_compare ?>
										</a>
									</li>
									<li>
										<a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>">
											<svg class="icon wishlist__icon">
												<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#heart"></use>
											</svg>
											<?php echo $text_wishlist ?>
										</a>
									</li>
								</div>
								<div class="mob-menu__message-list">
									<a href="https://t.me/agp_eapteka_bot">
										<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" fill="#039be5" r="12"/><path d="m5.491 11.74 11.57-4.461c.537-.194 1.006.131.832.943l.001-.001-1.97 9.281c-.146.658-.537.818-1.084.508l-3-2.211-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953z" fill="#fff"/></svg>
									</a>
									<a href="viber://pa?chatURI=eapteka">
										<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><g fill="#8e24aa"><path d="m23.155 13.893c.716-6.027-.344-9.832-2.256-11.553l.001-.001c-3.086-2.939-13.508-3.374-17.2.132-1.658 1.715-2.242 4.232-2.306 7.348-.064 3.117-.14 8.956 5.301 10.54h.005l-.005 2.419s-.037.98.589 1.177c.716.232 1.04-.223 3.267-2.883 3.724.323 6.584-.417 6.909-.525.752-.252 5.007-.815 5.695-6.654zm-12.237 5.477s-2.357 2.939-3.09 3.702c-.24.248-.503.225-.499-.267 0-.323.018-4.016.018-4.016-4.613-1.322-4.341-6.294-4.291-8.895.05-2.602.526-4.733 1.93-6.168 3.239-3.037 12.376-2.358 14.704-.17 2.846 2.523 1.833 9.651 1.839 9.894-.585 4.874-4.033 5.183-4.667 5.394-.271.09-2.786.737-5.944.526z"/><path d="m12.222 4.297c-.385 0-.385.6 0 .605 2.987.023 5.447 2.105 5.474 5.924 0 .403.59.398.585-.005h-.001c-.032-4.115-2.718-6.501-6.058-6.524z"/><path d="m16.151 10.193c-.009.398.58.417.585.014.049-2.269-1.35-4.138-3.979-4.335-.385-.028-.425.577-.041.605 2.28.173 3.481 1.729 3.435 3.716z"/><path d="m15.521 12.774c-.494-.286-.997-.108-1.205.173l-.435.563c-.221.286-.634.248-.634.248-3.014-.797-3.82-3.951-3.82-3.951s-.037-.427.239-.656l.544-.45c.272-.216.444-.736.167-1.247-.74-1.337-1.237-1.798-1.49-2.152-.266-.333-.666-.408-1.082-.183h-.009c-.865.506-1.812 1.453-1.509 2.428.517 1.028 1.467 4.305 4.495 6.781 1.423 1.171 3.675 2.371 4.631 2.648l.009.014c.942.314 1.858-.67 2.347-1.561v-.007c.217-.431.145-.839-.172-1.106-.562-.548-1.41-1.153-2.076-1.542z"/><path d="m13.169 8.104c.961.056 1.427.558 1.477 1.589.018.403.603.375.585-.028-.064-1.346-.766-2.096-2.03-2.166-.385-.023-.421.582-.032.605z"/></g></svg>
									</a>
									<a href="http://m.me/192129140851355">
										<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 11.111c0 3.496 1.744 6.615 4.471 8.652v4.237l4.086-2.242c1.09.301 2.245.465 3.442.465 6.627 0 12-4.974 12-11.111.001-6.137-5.372-11.112-11.999-11.112s-12 4.974-12 11.111zm10.734-3.112 3.13 3.259 5.887-3.259-6.56 6.962-3.055-3.258-5.963 3.259z" fill="#2196f3"/></svg>
									</a>
								</div>
								<div class="mob-menu__contacts">
									<div class="mob-menu__phone-list">
										<a href="tel:+380445200333" class="header-call-back__phone">

											<svg class="" id="Слой_1" data-name="Слой 1" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
											+38 044-520-03-33
										</a>
										<a href="tel:+380683450131" class="header-call-back__phone">
											<svg class="" id="Слой_1" data-name="Слой 1" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
											+38 068-345-01-31
										</a>
										<a href="tel:+380503450131" class="header-call-back__phone">
											<svg class="" id="Слой_1" data-name="Слой 1" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
											+38 050-345-01-31
										</a>
										<a href="tel:+380733450131" class="header-call-back__phone">
											<svg class="" id="Слой_1" data-name="Слой 1" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 33.98"><defs><style>.cls-134{fill:#0385c1;}</style></defs><path class="cls-134" d="M18.08,34c-7.42-.46-12.95-3.88-16.32-10.61A17.66,17.66,0,0,1,0,15.61a4.25,4.25,0,0,1,.89-2.69A11.73,11.73,0,0,1,5.23,9.55a1.66,1.66,0,0,1,2.21.9c1,2.13,2.07,4.26,3.1,6.38l.24.51a1.73,1.73,0,0,1-.7,2.46L7.8,21.23c-.48.3-.53.51-.26,1a9.43,9.43,0,0,0,4.2,4.2c.49.24.7.18,1-.28l1.47-2.33a1.7,1.7,0,0,1,2.35-.69l7,3.38A1.69,1.69,0,0,1,24.32,29a13.21,13.21,0,0,1-2.7,3.64A4.48,4.48,0,0,1,18.08,34Zm-3.79-8.14-.65,1a1.7,1.7,0,0,1-2.36.63,10.58,10.58,0,0,1-4.79-4.79,1.69,1.69,0,0,1,.64-2.38l1-.63-4-8.2a9.73,9.73,0,0,0-2.24,2,3,3,0,0,0-.74,2.18,32.21,32.21,0,0,0,.4,3.54,17.23,17.23,0,0,0,17,13.63,2.73,2.73,0,0,0,1.16-.26,7.32,7.32,0,0,0,2.76-2.71ZM5.09,10.89l4,8.17.24-.14c.65-.4.69-.55.36-1.23L6.46,11c-.25-.52-.51-.6-1-.33Zm9.82,14,8.16,4,.13-.23c.36-.65.29-.87-.36-1.18L21,26.56l-4.88-2.37c-.46-.22-.68-.16-.95.26C15.07,24.58,15,24.71,14.91,24.87Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M34,10.78a10.81,10.81,0,0,1-9.4,10.64A10.52,10.52,0,0,1,18,20.15a.93.93,0,0,0-.76-.11c-1.12.3-2.26.58-3.39.85-.58.15-.91-.19-.77-.77.29-1.17.59-2.33.86-3.5a.81.81,0,0,0-.08-.55A10.75,10.75,0,1,1,33.79,8.85C33.9,9.48,33.93,10.13,34,10.78ZM14.37,19.59l.38-.08,2.63-.67a1,1,0,0,1,.84.13,9.37,9.37,0,0,0,6,1.35,9.6,9.6,0,1,0-9.26-4.67,1.25,1.25,0,0,1,.16,1C14.84,17.63,14.62,18.59,14.37,19.59Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M22.64,11.31c.89.07,1.11.18,1.13.56s-.19.5-1.12.62c0,.44.13,1-.6,1.09-.39,0-.51-.24-.56-1.12-.48,0-1,0-1.46,0a.68.68,0,0,1-.71-.29c-.17-.3,0-.54.14-.78l2-3.05c.17-.27.37-.48.71-.38s.44.38.43.72C22.63,9.55,22.64,10.42,22.64,11.31Zm-1.75,0h.6v-.9Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M17,12.46h1.55c.42,0,.68.22.68.56s-.25.57-.66.57H16.49c-.42,0-.61-.22-.64-.63a2.06,2.06,0,0,1,1-2.1,12.14,12.14,0,0,0,1-.74.55.55,0,0,0,.23-.71.53.53,0,0,0-.57-.33.55.55,0,0,0-.51.54c-.06.41-.32.63-.66.57a.61.61,0,0,1-.46-.75,1.69,1.69,0,0,1,3.2-.56,1.64,1.64,0,0,1-.37,2c-.44.38-.92.7-1.37,1.06a3.89,3.89,0,0,0-.38.43Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M24.48,15.29a.59.59,0,0,1-.68-.74c.47-1.68,1-3.36,1.43-5,.27-.92.53-1.84.79-2.75a.67.67,0,0,1,.45-.52.6.6,0,0,1,.74.76c-.73,2.59-1.48,5.17-2.21,7.75A.65.65,0,0,1,24.48,15.29Z" transform="translate(0 -0.01)"></path><path class="cls-134" d="M29.16,9.07H27.83c-.41,0-.67-.23-.66-.57s.25-.56.67-.56q1,0,2,0c.55,0,.79.35.6.86-.53,1.45-1.08,2.89-1.62,4.33-.15.38-.44.54-.76.42a.58.58,0,0,1-.3-.82L29,9.43C29.08,9.33,29.11,9.22,29.16,9.07Z" transform="translate(0 -0.01)"></path></svg>
											+38 073-345-01-31
										</a>
									</div>
									<!-- <div class="mob-menu__message-list">
										<a href="https://t.me/agp_eapteka_bot">
										<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" fill="#039be5" r="12"/><path d="m5.491 11.74 11.57-4.461c.537-.194 1.006.131.832.943l.001-.001-1.97 9.281c-.146.658-.537.818-1.084.508l-3-2.211-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953z" fill="#fff"/></svg>
										Telegram
										</a>
										<a href="viber://pa?chatURI=eapteka">
										<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><g fill="#8e24aa"><path d="m23.155 13.893c.716-6.027-.344-9.832-2.256-11.553l.001-.001c-3.086-2.939-13.508-3.374-17.2.132-1.658 1.715-2.242 4.232-2.306 7.348-.064 3.117-.14 8.956 5.301 10.54h.005l-.005 2.419s-.037.98.589 1.177c.716.232 1.04-.223 3.267-2.883 3.724.323 6.584-.417 6.909-.525.752-.252 5.007-.815 5.695-6.654zm-12.237 5.477s-2.357 2.939-3.09 3.702c-.24.248-.503.225-.499-.267 0-.323.018-4.016.018-4.016-4.613-1.322-4.341-6.294-4.291-8.895.05-2.602.526-4.733 1.93-6.168 3.239-3.037 12.376-2.358 14.704-.17 2.846 2.523 1.833 9.651 1.839 9.894-.585 4.874-4.033 5.183-4.667 5.394-.271.09-2.786.737-5.944.526z"/><path d="m12.222 4.297c-.385 0-.385.6 0 .605 2.987.023 5.447 2.105 5.474 5.924 0 .403.59.398.585-.005h-.001c-.032-4.115-2.718-6.501-6.058-6.524z"/><path d="m16.151 10.193c-.009.398.58.417.585.014.049-2.269-1.35-4.138-3.979-4.335-.385-.028-.425.577-.041.605 2.28.173 3.481 1.729 3.435 3.716z"/><path d="m15.521 12.774c-.494-.286-.997-.108-1.205.173l-.435.563c-.221.286-.634.248-.634.248-3.014-.797-3.82-3.951-3.82-3.951s-.037-.427.239-.656l.544-.45c.272-.216.444-.736.167-1.247-.74-1.337-1.237-1.798-1.49-2.152-.266-.333-.666-.408-1.082-.183h-.009c-.865.506-1.812 1.453-1.509 2.428.517 1.028 1.467 4.305 4.495 6.781 1.423 1.171 3.675 2.371 4.631 2.648l.009.014c.942.314 1.858-.67 2.347-1.561v-.007c.217-.431.145-.839-.172-1.106-.562-.548-1.41-1.153-2.076-1.542z"/><path d="m13.169 8.104c.961.056 1.427.558 1.477 1.589.018.403.603.375.585-.028-.064-1.346-.766-2.096-2.03-2.166-.385-.023-.421.582-.032.605z"/></g></svg>
										Viber
										</a>
										<a href="http://m.me/192129140851355">
										<svg enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 11.111c0 3.496 1.744 6.615 4.471 8.652v4.237l4.086-2.242c1.09.301 2.245.465 3.442.465 6.627 0 12-4.974 12-11.111.001-6.137-5.372-11.112-11.999-11.112s-12 4.974-12 11.111zm10.734-3.112 3.13 3.259 5.887-3.259-6.56 6.962-3.055-3.258-5.963 3.259z" fill="#2196f3"/></svg>
										Messenger
										</a>
									</div> -->
								</div>
								
								<!-- <ul class="mob-menu__social"></ul> -->
							</div>
							<button  id="changeVision">Версія для людей з порушеннями зору</button>
							<li class="font-size-btns" style="font-size: 15px;">
								<div id="fontInc" class="">
								A-
								</div>
								<div id="fontDec">
								A+
								</div>
								<div class="clearfix"></div>
							</li>
							<button onclick="IMCallMeAskMe_formPopup();" class="mobile-callback"><?php echo $text_order_call; ?></button>
							
							
						</div>
						
					</div>
				</div>
				<?php if (!$logged) { ?>
					<div id="mobile-logged"></div>
				<?php } ?>
			</header>  <!-- /.site__header -->
			<div class="site__content">
				<link href="<?php echo $general_minified_css_uri; ?>" rel="stylesheet" type="text/css" />
				<?php if (!empty($added_minified_css_uri)) { ?>
					<link href="<?php echo $added_minified_css_uri; ?>" rel="stylesheet" type="text/css" />
				<?php } ?>
				
				<?php /* foreach ($styles as $style) { ?>
					<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
				<?php } */ ?>
				
				<?php if (!empty($general_minified_js_uri)) { ?>
					<script src="<?php echo $general_minified_js_uri; ?>" type="text/javascript"></script>
				<?php } ?>
				
				<?php if (!empty($added_minified_js_uri)) { ?>
					<script src="<?php echo $added_minified_js_uri; ?>" type="text/javascript"></script>
				<?php } ?>
				
				<?php /* foreach ($scripts as $script) { ?>
					<script src="<?php echo $script; ?>" type="text/javascript"></script>
				<?php } */ ?>
				
				<script src="/catalog/view/theme/default/js/lib/jquery.magnific-popup.min.js"></script>
				<script src="/catalog/view/theme/default/js/lib/jquery.maskedinput.js"></script>
				<script src="/catalog/view/theme/default/js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
				<script src="/catalog/view/theme/default/js/lib/jquery.mCustomScrollbar.concat.min.js"></script>
				
				<?php foreach ($analytics as $analytic) { ?>
					<?php echo $analytic; ?>
				<?php } ?>
				
				<?php if (!empty($xdstickers)) { ?>
					<style type="text/css">
						<?php echo $xdstickers_inline_styles; ?>
						<?php foreach ($xdstickers as $xdsticker) { ?>
							<?php if ($xdsticker['status'] == '1') { ?>
								.<?php echo $xdsticker['id'] ?> {
								background-color:<?php echo $xdsticker['bg'] ?>;
								color:<?php echo $xdsticker['color'] ?>;
								}
							<?php } ?>
						<?php } ?>
					</style>
				<?php } ?>
				
				
				
				<script type="text/javascript" src="/catalog/view/javascript/ajax-product-page-loader.js"></script>
				<style>
					#ajax_loader {
					width: 100%;
					height: 30px;
					margin-top: 15px;
					text-align: center;
					border: none!important;
					}
					#arrow_top {
					/*background: url("../../../../../image/chevron_up.png") no-repeat transparent;*/
					/*background-size: cover;*/
					background-color: #bcbcbc;
					border-radius: 50%;
					position: fixed;
					bottom: 50px;
					right: 15px;
					cursor: pointer;
					height: 50px;
					width: 50px;
					-webkit-transition: all .3s;
					-o-transition: all .3s;
					transition: all .3s;
					z-index: 100;
					}
					#arrow_top:hover {
					background-color: #14a0d4;
					}
					.arrow_top__icon {
					fill: #fff;
					width: 25px;
					height: 25px;
					margin: 10px auto 0;
					display: block;
					}
				</style>				