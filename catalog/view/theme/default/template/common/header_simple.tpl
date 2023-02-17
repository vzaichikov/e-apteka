<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $htmllang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $htmllang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $htmllang; ?>">
	<!--<![endif]-->
	<head>
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
		
		<link rel="preconnect" href="//img.e-apteka.com.ua">
		<link rel="preconnect" href="//img0.e-apteka.com.ua">
		<link rel="preconnect" href="//img1.e-apteka.com.ua">
		<link rel="preconnect" href="//img2.e-apteka.com.ua">
		<link rel="preconnect" href="//img3.e-apteka.com.ua">
		<link rel="preconnect" href="//img4.e-apteka.com.ua">
		
		<link rel="preconnect" href="https://fonts.gstatic.com">
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
		<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
		<!-- <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" /> -->
		<!-- <link href="catalog/view/theme/default/stylesheet/swiper.min.css" rel="stylesheet" media="screen" />
		<script src="catalog/view/javascript/bootstrap/js/swiper.min.js" type="text/javascript"></script> -->
		<link href="catalog/view/theme/default/stylesheet/bootstrap.min.css" rel="stylesheet" media="screen" />
		<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		
		<?php foreach ($links as $link) { ?>
			<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
		<?php } ?>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
		<!-- <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->
		
		<style>
			html.vision img{
			-webkit-filter: grayscale(100%);
			    filter: grayscale(100%);
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
			@charset "UTF-8";button::-moz-focus-inner{padding:0;border:0}.slider__arrows{width:90px;display:-webkit-box;display:-ms-flexbox;display:flex}.slider__arrows>*:not(:last-child):after{content:"";display:block;width:1px;height:22px;background:#dcdcdc;position:absolute;top:50%;right:-6px;margin-top:-11px}.slider__arrow{width:32px;height:32px;position:relative;border-radius:50%;margin:0 6px}.slider__arrow .icon{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);width:8px;height:14px;fill:#353535}.slider--tabs .slider__arrows{display:none}.slider-tab-nav__arrow{display:none;width:32px;height:32px;position:absolute;z-index:100;border-radius:50%;margin:0 6px;top:50%;margin-top:-16px}.slider-tab-nav__arrow .icon{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);width:8px;height:14px;fill:#353535}.slider-tab-nav__arrow--prev{left:0}.slider-tab-nav__arrow--next{right:0}html{font-size:10px}body{font-family:"PragmaticaC",sans-serif;font-size:1.4rem;color:#000}h2,h3,h4{margin:0;padding:0}ul,li{list-style-type:none;margin:0;padding:0}img{max-width:100%;border-style:none;height:auto}a[href^="tel:"]{white-space:nowrap}p{color:#000;font-size:16px}.site{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;min-height:100vh}.site__content{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;margin-bottom:5rem}.header-call-back__text,.header-cart__title{position:relative;display:inline-block}.header-call-back__text:after,.header-cart__title:after{content:"";display:block;width:100%;height:2px;position:absolute;bottom:0;left:0;z-index:1;background:transparent -webkit-gradient(linear,left top,right top,color-stop(50%,transparent),color-stop(50%,#0385c1)) center center/6px;background:transparent -webkit-linear-gradient(left,transparent 50%,#0385c1 50%) center center/6px;background:transparent linear-gradient(90deg,transparent 50%,#0385c1 50%) center center/6px}.header{color:#fff;font-size:14px;top:-200px}.header .list-inline{margin-left:0}.header .compare__icon,.header .wishlist__icon{fill:#fff;width:20px;height:20px;position:relative;top:4px}.header .wishlist__icon{width:18px;height:18px}.header__top{background-color:#14a0d4}.header__top .dropdown-toggle{color:#fff}.header__account-icon{width:13px;height:15px;fill:#0385c1;margin-right:12px;position:relative;top:2px}.header__top-inner{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;min-height:36px;padding-bottom:3px}.header__top-left li,.header__top-right li{position:relative;padding:0}.header__top-left>li+li,.header__top-right>li+li{margin-left:15px;padding-left:15px}@media screen and (max-width:767px){.header__top-left>li+li,.header__top-right>li+li{margin-left:7px;padding-left:7px}}.header__top-left>li+li:before,.header__top-right>li+li:before{content:"";display:block;width:1px;height:15px;background:#0385c1;position:absolute;top:50%;left:0;margin-top:-7.5px}@media screen and (max-width:767px){.header__top-left{display:none}}.header__middle{background-color:#1cacdc;padding:26px 0 24px}@media screen and (max-width:1699px){.header__middle{padding:20px 0}}.header__middle-inner{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;height:56px}.header__middle-inner>*:not(:last-child){margin-right:30px}@media screen and (max-width:1699px){.header__middle-inner>*:not(:last-child){margin-right:20px}}@media screen and (max-width:767px){.header__middle-inner{-ms-flex-wrap:wrap;flex-wrap:wrap;height:auto}}.header__col-logo{width:375px;min-width:280px}@media screen and (max-width:767px){.header__col-logo{width:100%;margin-right:0!important;margin-bottom:18px;text-align:center}}@media screen and (max-width:767px){.header__col-logo .logo__img{margin:0 auto}}.header__col-search{width:700px}@media screen and (max-width:767px){.header__col-search{-webkit-box-flex:1;-ms-flex:1 0 calc(100% - 150px);flex:1 0 -webkit-calc(100% - 150px);flex:1 0 calc(100% - 150px);margin-right:5px!important}}.header__col-middle-btns{-webkit-box-flex:0;-ms-flex:0 0 420px;flex:0 0 420px}@media screen and (max-width:1199px){.header__col-middle-btns{-webkit-box-flex:0;-ms-flex:0 0 auto;flex:0 0 auto}}@media screen and (max-width:767px){.header__col-middle-btns{-webkit-box-flex:0;-ms-flex:0 0 110px;flex:0 0 110px}}.header__middle-btns{float:right;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.header__middle-btns li{padding:0}.header__middle-btns li+li{margin-left:3vw}@media screen and (max-width:1699px){.header__middle-btns li+li{margin-left:15px}}.header__bottom{background-color:#0385c1}@media screen and (max-width:767px){.header__bottom .container{padding-left:0}}.header__bottom-inner{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;position:relative}.header__bottom-inner>*:not(:first-child){margin-left:30px}@media screen and (max-width:1699px){.header__bottom-inner>*:not(:first-child){margin-left:20px}}.header-call-back{position:relative;padding-left:50px}@media screen and (max-width:1199px){.header-call-back{padding-left:0}}.header-call-back__icon{fill:#fff;width:34px;height:34px;position:absolute;top:0;left:0}@media screen and (max-width:1199px){.header-call-back__icon{position:static}}@media screen and (max-width:767px){.header-call-back__icon{width:30px;height:30px}}.header-call-back__phone{color:#fff;font-size:18px;font-weight:700;white-space:nowrap}@media screen and (max-width:1199px){.header-call-back__phone{display:none}}.header-call-back__text{color:#353535;font-size:15px}@media screen and (max-width:1199px){.header-call-back__text{display:none}}.header-cart{position:relative;padding-left:50px}@media screen and (max-width:1199px){.header-cart{padding-left:0}}.header-cart__btn{background-color:transparent;border:none}.header-cart__total-count{width:24px;height:24px;background-color:#e5354c;border-radius:50%;color:#fff;font-size:12px;font-weight:700;line-height:24px;text-align:center;position:absolute;top:-7px;left:27px;z-index:1}@media screen and (max-width:1199px){.header-cart__total-count{width:21px;height:21px;font-size:11px;line-height:21px}}.header-cart__icon{width:40px;height:34px;fill:#fff;position:absolute;top:0;left:0}@media screen and (max-width:1199px){.header-cart__icon{position:static}}@media screen and (max-width:767px){.header-cart__icon{width:35px;height:30px}}.header-cart__title{color:#353535;font-size:15px}@media screen and (max-width:1199px){.header-cart__title{display:none}}.header-cart__total{display:block;color:#fff;font-size:18px;font-weight:700;white-space:nowrap}@media screen and (max-width:1199px){.header-cart__total{display:none}}#cart .dropdown-menu{color:#353535;padding:0;border-top:3px solid #02a8f3}@media screen and (max-width:991px){#cart .dropdown-menu{display:none}}#cart .dropdown-menu li{margin-left:0}.header-account__link{color:#14a0d4;font-size:14px;font-weight:400;line-height:22px}.header-account .dropdown-menu{width:100%;max-width:390px;padding:10px}@media screen and (max-width:991px){.header-account .dropdown-menu{min-width:290px}}.header-account .dropdown-menu h2{color:#292836;font-size:22px;font-weight:900;text-align:center;margin-bottom:30px;letter-spacing:1.4px}.header-account .dropdown-menu .well{-webkit-box-shadow:none;box-shadow:none;background:#fff;margin:0;border:none;padding:40px 25px 10px}@media screen and (max-width:991px){.header-account .dropdown-menu .well{padding:40px 12px 10px}}.header-account .dropdown-menu .form-group{margin-bottom:20px}.header-account .dropdown-menu .form-control{height:40px;border:1px solid #e6e6e6;background-color:#ffffff;border-radius:0;font-size:14px!important;font-weight:400;line-height:48px;letter-spacing:0.7px}.header-account .dropdown-menu .bbtn{width:194px;height:50px;border-radius:5px;background-color:#1cacdc;color:#fff;font-size:14px;font-weight:700;line-height:48px;text-transform:uppercase;letter-spacing:2px;margin:0 auto 30px;padding:0;display:block}.social-login{color:#292836;font-size:14px;font-weight:400;line-height:22px;padding:12px 25px;border-top:1px solid #e6e6e6}@media screen and (max-width:991px){.social-login{padding:12px}}.social-login li{display:inline-block;border-bottom:none!important}.social-login__link{display:inline-block;width:29px;height:29px;border-radius:50%;text-align:center;padding-top:5px}.social-login__link--fb{background:#1b60a6}.social-login__icon{width:20px;height:20px;fill:#fff}#cleversearch form{margin:0}.sosearchpro-wrapper{max-width:100%}.search__inner{position:relative}.select_category{position:absolute;top:0;left:0;background:#fff;border-radius:5px 0 0 5px}@media screen and (max-width:1199px){.select_category{display:none}}.select_category:before{content:"";display:block;position:absolute;z-index:0;width:1px;height:22px;background:#efefef;top:50%;right:0;margin-top:-11px}.select_category:after{content:"тМ";position:absolute;right:12px;top:0;color:#a2a2a2;background:transparent;display:block;width:8px;height:100%;z-index:0;font-size:9px;line-height:40px}.select_category select{max-width:180px;line-height:38px;height:40px;color:#59595e;font-size:16px;font-weight:400;border-radius:5px 0 0 5px;border:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;background:transparent;position:relative;z-index:10;padding-left:17px}@media screen and (max-width:1699px){.select_category select{padding-left:5px;max-width:150px}}#cleversearch .autosearch-input{height:50px;border:none;border-radius:5px;color:#59595e;font-size:16px;font-weight:400;width:100%;padding-right:60px}@media screen and (max-width:1699px){#cleversearch .autosearch-input{padding-right:50px}}@media screen and (max-width:1199px){#cleversearch .autosearch-input{padding-left:10px;height:41px}}.sosearchpro-wrapper .input-group-btn{position:absolute;top:0;right:0;width:inherit;max-width:55px}@media screen and (max-width:1199px){.sosearchpro-wrapper .input-group-btn{max-width:41px}}.sosearchpro-wrapper .button-search{height:40px;padding:7px 10px;border-radius:0 5px 5px 0;background:#0385c1;border:1px solid #0385c1;-webkit-box-shadow:none;box-shadow:none;max-width:56px}@media screen and (max-width:1199px){.sosearchpro-wrapper .button-search{height:31px}}.sosearchpro-wrapper .button-search .icon{fill:#fff;max-width:100%;max-height:100%;position:static}@media screen and (max-width:1199px){.owl-carousel.carousel{padding:0 50px}}.owl-carousel .item__image{max-height:45px;margin-bottom:25px;padding-right:15px}.owl-carousel .item__title{color:#353535;font-size:16px;font-weight:700;text-transform:uppercase;margin-bottom:20px;padding-right:15px}.owl-carousel .item__text{color:#59595e;font-size:15px;line-height:22px;margin-bottom:25px;padding-right:15px}.owl-carousel .item__link{color:#14a0d4;font-size:16px;line-height:22px;padding-right:15px}.owl-carousel .item__link-icon{width:22px;height:15px;fill:#1cacdc;position:relative;top:2px}@media screen and (max-width:767px){.home-banner.owl-carousel{margin-left:-15px;width:-webkit-calc(100% + 30px);width:calc(100% + 30px)}}.featured-wrap{display:grid;grid-template-columns:repeat(3,1fr);grid-column-gap:30px;grid-row-gap:40px}@media screen and (max-width:1699px){.featured-wrap{grid-template-columns:1fr 1fr}}@media screen and (max-width:767px){.featured-wrap{grid-template-columns:1fr}}.featured{-webkit-box-shadow:0 3px 40px rgba(0,0,0,0.1);box-shadow:0 3px 40px rgba(0,0,0,0.1);border-radius:5px;border:1px solid #e6e6e6;background-color:#ffffff;overflow:hidden}.featured__header{height:46px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;border-bottom:1px solid #e6e6e6}.featured__icon-wrap{width:52px;height:100%;position:relative;background-color:#1cacdc}.featured__icon{max-width:30px;max-height:30px;fill:#fff;position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.featured__title{-webkit-box-flex:1;-ms-flex:1;flex:1;padding:0 25px;color:#353535;font-size:16px;font-weight:700;text-transform:uppercase;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}@media screen and (max-width:1199px){.featured__title{padding:0 0 0 12px}}.featured__arrows{width:90px;display:-webkit-box;display:-ms-flexbox;display:flex}.featured__arrows>*:not(:last-child):after{content:"";display:block;width:1px;height:22px;background:#dcdcdc;position:absolute;top:50%;right:-6px;margin-top:-11px}.featured__arrow{width:32px;height:32px;position:relative;border-radius:50%;margin:0 6px}.featured__arrow .icon{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);width:8px;height:14px;fill:#353535}.featured__item{padding:20px 15px 30px}.featured__item .product-layout{max-width:210px;margin:0 auto}.dropdown-menu{-webkit-box-shadow:0 3px 43px rgba(0,0,0,0.2);box-shadow:0 3px 43px rgba(0,0,0,0.2);border-radius:5px;background-color:#ffffff;padding:18px 12px}.language-list{display:block;text-transform:uppercase}.language-list .dropdown-menu{padding:10px 12px}.language-list li+li{margin-left:15px;margin-top:5px}@media screen and (max-width:767px){.language-list li+li{margin-left:0}}.language-list form{margin:0}.language-select{background-color:transparent;border:none;display:inline;padding:0;margin:0;text-transform:uppercase}.language-select.is-active{font-weight:700}.language-select-dropdown .language-select{color:#353535;font-size:14px;text-align:left}.social__item+.social__item{margin-left:15px}.social__link{display:block}.social__icon{fill:#fff;width:20px;height:20px;position:relative;top:4px}.modal-msg{display:none;position:fixed;width:70%;z-index:99999;padding:20px 10px;text-align:center;left:15%;top:40%;-webkit-box-shadow:0 3px 100px rgba(0,0,0,0.5);box-shadow:0 3px 100px rgba(0,0,0,0.5);border-radius:5px;border:1px solid #e6e6e6;background-color:#ffffff;font-size:18px}.modal-msg__close{position:absolute;top:0;right:0;z-index:1;opacity:.8;padding:5px}.modal-msg__close-icon{width:16px;height:16px;fill:#000}.catalog{position:relative}.catalog__heding{height:100%;background-color:#e5354c;text-transform:uppercase;padding:0 20px;line-height:56px;width:350px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;font-size:15px}@media screen and (max-width:1699px){.catalog__heding{max-width:190px}}.catalog__heding__icon{width:28px;height:17px;fill:#fff;margin-right:20px}.catalog__list-wrap{position:absolute;top:100%;left:0;z-index:11;display:none;-webkit-box-shadow:0 3px 40px rgba(0,0,0,0.1);box-shadow:0 3px 40px rgba(0,0,0,0.1);border:1px solid #e6e6e6;background-color:#ffffff;padding:25px 0;width:350px}@media screen and (max-width:991px){.catalog__list-wrap{width:320px}}@media screen and (min-width:1699px){.common-home .catalog__list-wrap{display:block}}.header-bottom-nav{width:100%;font-size:0;-webkit-box-flex:1;-ms-flex:1;flex:1}@media screen and (max-width:1199px){.header-bottom-nav{display:none}}.header-bottom-nav a{font-size:16px;font-weight:500;padding:0 20px;line-height:56px;color:#fff;display:inline-block;position:relative}.header-bottom-nav a:last-child{padding-right:0}@media screen and (max-width:1699px){.header-bottom-nav a{padding:0 14px}}.header-bottom-nav a+a:before{content:"";display:block;width:1px;height:22px;background:#14a0d4;position:absolute;top:50%;left:0;margin-top:-11px}.header-bottom-links{font-size:0;white-space:nowrap;display:-webkit-box;display:-ms-flexbox;display:flex}@media screen and (max-width:1199px){.header-bottom-links{margin-left:auto!important}}@media screen and (max-width:767px){.header-bottom-links{display:none}}.header-bottom-links a{padding:0 15px;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;color:#fff;text-transform:uppercase;font-size:14px;font-weight:700;line-height:56px;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.header-bottom-links a:last-child{padding-right:0}.header-bottom-links__icon{margin-right:12px}.header__mob-menu-btn{display:none;color:#ffffff;font-size:17px;font-weight:400;line-height:42px;margin-right:0}@media screen and (max-width:1199px){.header__mob-menu-btn{display:block}}.header__mob-menu{position:absolute;z-index:10;top:100%;right:0;background-color:#14a0d4;max-height:0;overflow:hidden;padding:0 30px;display:none}@media screen and (max-width:1199px){.header__mob-menu{display:block}}@media screen and (max-width:767px){.header__mob-menu{right:-15px}}.mob-menu__list{margin-bottom:30px}.mob-menu__phone-list{color:#ffffff;font-size:15px;font-weight:400;line-height:30px;margin-bottom:40px}.bbtn{display:inline-block;text-decoration:none;color:#fff;background-color:#14a0d4;border:1px solid #14a0d4;border-radius:5px;font-size:13px;line-height:13px;font-weight:700;text-transform:uppercase;text-align:center;padding:5px 10px;height:38px}.product-layout{text-align:center}.product-layout__image{margin-bottom:15px}.product-layout__image img{margin:0 auto}.product-layout__name,.product-layout__name a{color:#353535;font-size:15px;line-height:1.25em;height:2.6em;overflow:hidden;text-overflow:ellipsis;margin-bottom:10px}.banner-2{padding:65px 0}.banner-2__item{position:relative;margin-bottom:25px}.banner-2__content{position:absolute;top:0;left:0;bottom:0;max-width:300px;padding-left:50px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.banner-2__content>*:not(:last-child){margin-bottom:25px}@media screen and (max-width:580px){.banner-2__content{max-width:none;bottom:auto;padding:50px 25px 0;width:100%}}.banner-2__title{color:#353535;font-size:36px;font-weight:700;line-height:36px}.banner-2__text{color:#59595e;font-size:18px;font-weight:400}.banner-2__link{color:#1cacdc;font-size:16px;font-weight:400;line-height:22px}.banner-2__link-icon{width:22px;height:15px;fill:#1cacdc;position:relative;top:2px}@media screen and (max-width:580px){.banner-2__img{text-align:right;background:#f3f3f3;border-radius:5px}}@media screen and (max-width:580px){.banner-2__img img{display:inline-block}}@media screen and (max-width:767px){#carousel0 .item{text-align:center}.owl-carousel .item__image{margin:0 auto 20px}}@media screen and (min-width:1280px){.common-home .featured-wrap .featured.js-featured{max-height:465px; overflow: hidden;}}
			#mobile-main-menu,
			.header__mob-menu-btn.js-mob-menu-btn,
			.header__mobile{
			display: none;
			}
			.text-warning{color: #FF7815!important;}
			.show-mobile-menu{
			overflow: hidden !important;
			}
			#mobile-main-menu {
			background:transparent;
			border: 0;
			align-items: center;
			justify-content: center;
			}
			#mobile-main-menu svg{
			width: 25px;
			height: 35px;
			fill: #fff;
			}
			.mobile-menu-wrap{
			position: fixed;
			left: 0;
			right: 0;
			bottom: 0;
			top: 0;								
			z-index: 99999;				
			background: rgba(0,0,0,.5);
			overflow: scroll !important;
			transition: .3s ease-in-out;
			}
			#mobile-main-menu-close{
			position: fixed;
			bottom: 50px;
			right: 3%;
			width: 50px;
			height: 50px;
			background: #fff;
			z-index: 999999;
			border-radius: 50%;
			border: 0;
			display: none;
			align-items: center;
			justify-content: center;
			transition: .3s ease-in-out;
			}
			.show-mobile-menu #mobile-main-menu-close{
			display: flex;
			}
			#mobile-main-menu-close:after{
			content: '';
			display: block;
			width: 16px;
			height: 16px;
			filter: brightness(0.2);
			background-image: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjMyOXB0IiB2aWV3Qm94PSIwIDAgMzI5LjI2OTMzIDMyOSIgd2lkdGg9IjMyOXB0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Im0xOTQuODAwNzgxIDE2NC43Njk1MzEgMTI4LjIxMDkzOC0xMjguMjE0ODQzYzguMzQzNzUtOC4zMzk4NDQgOC4zNDM3NS0yMS44MjQyMTkgMC0zMC4xNjQwNjMtOC4zMzk4NDQtOC4zMzk4NDQtMjEuODI0MjE5LTguMzM5ODQ0LTMwLjE2NDA2MyAwbC0xMjguMjE0ODQ0IDEyOC4yMTQ4NDQtMTI4LjIxMDkzNy0xMjguMjE0ODQ0Yy04LjM0Mzc1LTguMzM5ODQ0LTIxLjgyNDIxOS04LjMzOTg0NC0zMC4xNjQwNjMgMC04LjM0Mzc1IDguMzM5ODQ0LTguMzQzNzUgMjEuODI0MjE5IDAgMzAuMTY0MDYzbDEyOC4yMTA5MzggMTI4LjIxNDg0My0xMjguMjEwOTM4IDEyOC4yMTQ4NDRjLTguMzQzNzUgOC4zMzk4NDQtOC4zNDM3NSAyMS44MjQyMTkgMCAzMC4xNjQwNjMgNC4xNTYyNSA0LjE2MDE1NiA5LjYyMTA5NCA2LjI1IDE1LjA4MjAzMiA2LjI1IDUuNDYwOTM3IDAgMTAuOTIxODc1LTIuMDg5ODQ0IDE1LjA4MjAzMS02LjI1bDEyOC4yMTA5MzctMTI4LjIxNDg0NCAxMjguMjE0ODQ0IDEyOC4yMTQ4NDRjNC4xNjAxNTYgNC4xNjAxNTYgOS42MjEwOTQgNi4yNSAxNS4wODIwMzIgNi4yNSA1LjQ2MDkzNyAwIDEwLjkyMTg3NC0yLjA4OTg0NCAxNS4wODIwMzEtNi4yNSA4LjM0Mzc1LTguMzM5ODQ0IDguMzQzNzUtMjEuODI0MjE5IDAtMzAuMTY0MDYzem0wIDAiIHN0eWxlPSJmaWxsOiNmZmY7Ii8+PC9zdmc+);
			background-size: cover;
			}
			.mobile-menu-wrap .mobile-menu__list{
			/*background: #0385c1;*/
			background-color: #fff;
			height: auto;
			min-height: 100%;
			width: 82%;
			max-width: 500px;
			/*padding: 20px 10px;*/
			transition: .3s ease-in-out;
			/*transform: translate(-100%);*/
			}
			.show-mobile-menu .mobile-menu-wrap .mobile-menu__list{
			/*transform: translate(0);*/
			}
			.header.is-fixed .mobile-menu-wrap  .header__logo{
			display: block !important;
			}
			#catalog_mobile .catalog__list-wrap{
			width: 100%;
			display: block;
			position: unset;
			padding: 0;
			margin: 20px 0;
			box-shadow: unset;
			border: 0;
			/*background-color: transparent;*/
			}
			#catalog_mobile .catalog__list{
			/*color: #fff;*/
			}
			#catalog_mobile .catalog__list>.catalog__list-item:not(:last-child) {
			border-bottom: 1px solid #e6e6e64f;
			}
			#catalog_mobile .catalog__list-icon {
			/*fill: #eeeeee;*/
			left: 5px;
			}
			#catalog_mobile .catalog__list-link:active .catalog__list-icon, 
			#catalog_mobile .catalog__list-link:focus .catalog__list-icon, 
			#catalog_mobile .catalog__list-link:hover .catalog__list-icon {
			fill: #14a0d4;
			}
			.show-mobile-menu.modal-open .modal {
			overflow-x: hidden;
			overflow-y: auto;
			z-index: 999999 !important;
			background: #000000a8;
			margin: auto;
			}
			.show-mobile-menu.modal-open .modal .modal-dialog{
			margin-left: auto;
			margin-right: auto;
			}
			.show-mobile-menu .modal-backdrop.in {
			opacity: 0;
			}
			.header__mobile{	
			background-color: #0385c1;			
			align-items: center;
			grid-template-columns: 50px 1fr 50px;
			grid-column-gap: 15px;
			padding: 10px;
			}
			.header__mobile.logged{
			grid-template-columns: 50px 1fr 40px 50px;
			}
			.header__mobile.logged .logged-mobile-header{
			text-align: center;
			}
			.header__mobile.logged .logged-mobile-header svg{
			margin: 0;
			width: 25px;
			height: 25px;
			}
			
			.header__mobile .button-search {
			background: #1cacdc !important;
			border-color: #1cacdc !important;
			}
			.header__mobile .header__col-search{
			width: 100%;
			}
			.mobile-menu-wrap  .mob-head-menu{
			background-color: #0385c1;	
			display: flex;
			align-items: center;
			justify-content: space-between;
			/*margin-bottom: 25px;*/
			padding: 20px 10px;
			}
			.mobile-menu-wrap  .mob-head-menu .dropdown-toggle{
			color: #fff;
			font-weight: 600;
			}
			.mobile-menu-wrap .lang{
			width: 50px;
			margin-left: 30px;
			}
			.mobile-menu-wrap .mob-menu__contacts{
			/*display: grid;*/
			margin: 20px 0;
			grid-template-columns: 1fr 1fr;
			}
			.mobile-menu-wrap .mob-menu__message-list {
			display: flex;
			margin: 15px 0;
			justify-content: space-evenly;
			}
			.mobile-menu-wrap .mob-menu__message-list a {
			display: flex;
			align-items: center;
			color: #525252;
			font-size: 14px;
			font-weight: 400;
			line-height: 1;
			padding: 5px 10px;
			}
			.mobile-menu-wrap .mob-menu__message-list a svg{
			width: 40px;
			height: 45px;
			margin-right: 7px;
			}
			.mobile-menu__list .mob-menu__list{
			margin-bottom: 15px;
			}
			.mobile-menu-wrap  .mob-menu__list a{
			color: #525252;
			font-size: 15px;
			font-weight: 400;
			margin-bottom: 8px;
			padding: 5px;
			}
			.mobile-menu-wrap .mob-wishlist li a{
			color: #525252;
			font-size: 15px;
			font-weight: 400;
			margin-bottom: 0;
			padding: 5px;
			display: block;
			}
			.mobile-menu-wrap .mob-menu__list a .fa {
			width: 25px;
			text-align: center;
			margin-right: 5px;
			font-size: 17px;
			}
			.mobile-menu-wrap .header-bottom-links__icon {
			margin-right: 10px;
			width: 25px;
			height: 25px;
			object-fit: contain;
			}

			.mobile-menu-wrap .mob-wishlist li svg,
			.dropdown.header__account li a svg {
			margin-right: 10px;
			width: 25px;
			height: 20px;
			object-fit: contain;
			fill: #525252;
			}
			.mobile-menu-wrap .mob-menu__social{
			display: flex;
			}
			.mobile-menu-wrap .mob-menu__social .social__item{
			margin: 0 5px;
			}
			.mobile-menu-wrap .social__icon{
			fill: #525252;
			width: 40px;
			height: 25px;
			}
			
			.mobile-menu-wrap .header__account-icon,
			.mobile-menu-wrap .head_menu .do-popup-element i{
			fill: #cfcfcf;
			width: 30px;
			height: 20px;
			color: #cfcfcf;
			font-size: 20px;
			text-align: center;
			margin-right: 12px;
			}
			.mobile-menu-wrap .head_menu .do-popup-element,
			.mobile-account span,
			.cardModal_mob .do-popup-element{
			color: #515151;
			padding: 10px 5px;
			font-size: 15px;
			display: block;
			/*margin: 0 0 25px;*/
			border-bottom: 1px solid #f7f7f7;
			}
			.cardModal_mob .do-popup-element {
			display: flex !important;
			}
			.cardModal_mob .do-popup-element b{
			font-weight: 400;
			display: block;
			font-size: 12px;
			color: #9a9a9a;
			}
			.mobile-menu-wrap .mob-menu__phone-list{
			/*margin: 20px 0;*/
			margin: 0;
			}
			.mobile-menu-wrap .mob-menu__phone-list a{
			color: #525252;
			font-size: 15px;
			font-weight: 400;
			line-height: 1;
			padding: 5px 10px;
			display: block;
			margin-bottom: 10px;
			
			}
			.mobile-menu-wrap .mobile-callback{
			width: 100%;
			margin-top: 10px;
			border: 0;
			padding: 13px;
			background: #0385c1;
			}
			.show-mobile-menu #loginModal{
			z-index: 999999 !important;			  	
			top: 25px !important;
			left: 0;
			right: 0;
			max-height: 90vh;
			overflow: scroll;
			}
			.show-mobile-login #mobile-logged,
			.show-mobile-cardModal .cardModal_wrap{
			display: block;
			position: fixed;
			z-index: 999999;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			background:#00000042;
			}
			.show-mobile-cardModal .cardModal_wrap #cardModal{
			top: 40px !important;
			}
			.show-mobile-cardModal .main-overlay-popup{
			display: none !important;
			}
			.show-mobile-cardModal #mobile-main-menu-close{
			z-index: 9999;
			}
			.show-mobile-cardModal  .mobile-menu-wrap{
			overflow: hidden !important;
			}
			.mobile-logged{
			/*display: block;
			position: unset;*/
			}
			.mobile-account{
			position: relative;
			}
			.dropdown.header__account.open>.dropdown-menu {
			    width: 210px;
			}
			.dropdown.header__account.open>.dropdown-menu li{
				margin: 0 !important;
			}
			.dropdown.header__account a,
			.dropdown.header__account li a{
				/*display: flex;
				align-items: center;*/
				color: #525252;
				font-size: 14px;
				font-weight: 700;
				line-height: 1;
				padding: 5px 10px;
				display: block;
			}
			.dropdown.header__account a > svg.header__account-icon{
				position: unset;
				margin: 0;
				width: 30px;
				height: 30px;
			}
			.dropdown.header__account li>a:hover,
			.dropdown.header__account a:hover{
				text-decoration: underline;
			    background-color: unset;
			    background-image: unset;
			    opacity: 1;
			    color: #525252;
			}
			#cardModal{
				display: none;
			}
			.simplecheckout-block.overlay-content .simplecheckout-block-content{
				opacity: .5;
				pointer-events: none;
			}
			#changeVisionHeader_1{
			    background: transparent;
			    border: 1px solid #0385c1;
			    width: 35px;
			    height: 35px;
			    display: flex;
			    align-items: center;
			    justify-content: center;
			    border-radius: 2px;
			    cursor: pointer;
			    margin-left: 15px;
			}
			#changeVisionHeader_1 i{
			    font-size: 19px;
			    color: #0385c1;
			}
			 #changeVisionHeader_1:hover{
			    background: #0385c1;
			}
			 #changeVisionHeader_1:hover i {
			    color: #fff;
			    
			}
			.font-size-btns #fontIncHeader_1,
			.font-size-btns #fontDecHeader_1{
			    margin-left: 10px;
			    background: transparent;
			    padding: 5px;
			    border: 1px solid #0385c1;
			    width: 35px;
			    height: 35px;
			    display: flex;
			    align-items: center;
			    justify-content: center;
			    border-radius: 2px;
			    cursor: pointer;
			}
			.header.is-fixed #changeVisionHeader_1{
			    display: none;
			}
			@media screen and (max-width:768px){
				.mobile-menu-wrap .dropdown-backdrop,
				.dropdown.header__account{
					display: none !important;
				}
				.header__top,
				.header__middle,
				.header__bottom{
					display: none;
				}
				#mobile-main-menu{
					display: flex;
				}
				.header__mobile{
					display: grid;
				}
			}
			@media screen and (max-width:480px){
				.mobile-menu-wrap .catalog__list-link,
				.mobile-menu-wrap .head_menu .do-popup-element, 
				.mobile-account span, 
				.cardModal_mob .do-popup-element{
				font-size: 14px;
				}
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
<header class="header-simple">
	<div class="container">
		<div class="wrap">
			<div class="header__col-logo">
				<div class="header__logo logo">
					<a href="<?php echo $home; ?>" class="logo__link"><img class="logo__img img-responsive" width="280" height="35" src="/catalog/view/theme/default/img/logo_blue.png" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"></a>
				</div>
			</div>
			<div class="header-order__contact">
				<div class="header-order__contact-title">
				<?php echo $text_simple_call; ?>
				</div>
				<div class="header-order__contact-tel"><a href="tel:+380445200333" class="element-target-click-event">+38(044)520-03-33</a></div>
				<div class="header-order__contact-tel"><a href="tel:+380683450131" class="element-target-click-event">+38 (068) 345 01 31</a></div>
				<li>
					<button id="changeVisionHeader_1" title="Версія для людей з порушеннями зору"><i class="fa fa-low-vision" aria-hidden="true"></i></button>
					<li class="font-size-btns" style="font-size: 14px;">
						<div id="fontIncHeader_1" class="">
						A-
						</div>
						<div id="fontDecHeader_1">
						A+
						</div>
						<div class="clearfix"></div>
					</li>
				</li>
			</div>
		</div>
	</div>
	<?php if ($logged) { ?>		
		<?php } else { ?>
		<?php echo $loginmodal; ?>										
	<?php } ?>
</header>
<div style="display:none">
<div class="search"><input type="text" name="search"></div>
<div id="mobile-main-menu" class="mobile-menu-wrap"></div>
<div id="mobile-main-menu-close"></div>
<div class="header__mobile">
	<div id="search">
		<div class="autosearch-input"></div>
	</div> 
</div>
</div>
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
	
	<script src="catalog/view/theme/default/js/lib/jquery.magnific-popup.min.js"></script>
	<script src="catalog/view/theme/default/js/lib/jquery.maskedinput.js"></script>
	<script src="catalog/view/theme/default/js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="catalog/view/theme/default/js/lib/jquery.mCustomScrollbar.concat.min.js"></script>
	
	<script src="catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
	<link href="catalog/view/javascript/jquery/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
	<link href="catalog/view/javascript/jquery/owl-carousel/owl.transitions.css" rel="stylesheet" type="text/css" />
	
	
	
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
	
	
	
	<script type="text/javascript" src="catalog/view/javascript/ajax-product-page-loader.js"></script>
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