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

		<?php if (is_array($opengraphs)) { ?>
			<?php foreach ($opengraphs as $opengraph) { ?>
				<?php if ($content = strip_tags(html_entity_decode($opengraph['content'], ENT_QUOTES, 'UTF-8'))) { ?>
					<meta property="<?php echo $opengraph['meta'] ?>" content="<?php echo $content; ?>" />
				<?php } ?>
			<?php } ?>
		<?php } ?>
		
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $title; ?></title>
		<base href="<?php echo $base; ?>" />
		
		<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="194x194" href="/icons/favicon-194x194.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="192x192" href="/icons/android-chrome-192x192.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png?v=bORwKrwnaR">
		<link rel="mask-icon" href="/icons/safari-pinned-tab.svg?v=bORwKrwnaR" color="#01a0c6">
		<link rel="shortcut icon" href="/favicon.ico?v=bORwKrwnaR">
		<meta name="msapplication-TileColor" content="#01a0c6">
		<meta name="msapplication-TileImage" content="/icons/mstile-144x144.png?v=bORwKrwnaR">
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

		<?php foreach ($tlt_metatags as $metatag) { ?>
			<meta <?php echo $metatag['type']; ?>="<?php echo $metatag['name']; ?>" content="<?php echo $metatag['content']; ?>" />
		<?php } ?>

		<script src="/catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="/catalog/view/theme/default/stylesheet/bootstrap.min.css" rel="stylesheet" media="screen" />
		<script src="/catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>

		<?php foreach ($links as $link) { ?>
			<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
		<?php } ?>
		
		<?php include(DIR_TEMPLATEINCLUDE . 'structured/header_styles.tpl'); ?>
		
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-K3MKBK7');</script>

		<?php if ($hb_snippets_kg_enable == '1'){echo html_entity_decode($hb_snippets_kg_data);} ?>
		<?php if ($hb_snippets_local_enable == 'y'){echo html_entity_decode($hb_snippets_local_snippet);} ?>
			
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
					
					<div class="header__middle">
						<div class="container">
							<div class="header__middle-inner">								
								<div class="header__col-lic hidden-md hidden-xs">
									<a href="<?php echo $licence_href; ?>" target="_blank" rel="nofollow noindex" noindex nofollow><img src="<?php echo $licence_logo; ?>" alt="Перевірити ліцензію" /></a>
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
													<?php /* ?>
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
													<?php */ ?>
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
									
									<? /*
									<a class="header-bottom-nav__link" href="<?php echo $vacancies; ?>"><i class="fa fa-bullhorn" aria-hidden="true"></i> <?php echo $text_vacancies; ?></a>
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
								<?php /* ?>
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
								<?php */ ?>
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