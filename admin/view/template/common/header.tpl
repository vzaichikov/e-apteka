<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
	<head>
		<meta charset="UTF-8" />
		<title><?php echo $title; ?></title>
		<base href="<?php echo $base; ?>" />
		
		
		
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="194x194" href="/favicon-194x194.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png?v=bORwKrwnaR">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=bORwKrwnaR">
		<link rel="manifest" href="/site.webmanifest?v=bORwKrwnaR">
		<link rel="mask-icon" href="/safari-pinned-tab.svg?v=bORwKrwnaR" color="#01a0c6">
		<link rel="shortcut icon" href="/favicon.ico?v=bORwKrwnaR">
		<meta name="msapplication-TileColor" content="#01a0c6">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png?v=bORwKrwnaR">
		<meta name="theme-color" content="#ffffff">
		
		
		
		<?php if ($description) { ?>
			<meta name="description" content="<?php echo $description; ?>" />
		<?php } ?>
		<?php if ($keywords) { ?>
			<meta name="keywords" content="<?php echo $keywords; ?>" />
		<?php } ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		
		<link href="view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
		<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
		<script src="view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
		<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
		<link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
		<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
		<?php foreach ($styles as $style) { ?>
			<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
		<?php } ?>
		<?php foreach ($links as $link) { ?>
			<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
		<?php } ?>
		<script src="view/javascript/common.js" type="text/javascript"></script>
		<?php foreach ($scripts as $script) { ?>
			<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>
	</head>
	<body>
		<div id="container">
			<header id="header" class="navbar navbar-static-top">
				<div class="navbar-header">
					<?php if ($logged) { ?>
						<a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
					<?php } ?>
				<a href="<?php echo $home; ?>" class="navbar-brand"><img src="view/image/logo.png" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></a></div>
				<?php if ($logged) { ?>
					<script type="text/javascript"><!--
						function setMainTranslatorLanguage(language_id){
							$.ajax({
								url: 'index.php?route=module/auto_translator/changeMainTranslatorLanguageAjax&token=' + getURLVar('token'),
								type: 'post',
								data: 'language_id=' + language_id,
								dataType: 'text',
								error: function(xhr, ajaxOptions, thrownError) {
									alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
								},
								success: function(text) {
									location.reload();
								}
							});
						}
					//--></script>
					<ul class="nav pull-right">
						<? /*
							<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-files-o" aria-hidden="true"></i>
							<?php foreach ($languages as $language) { ?>
							<?php if ($language['language_id'] == $auto_translator_source) { ?>
							<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
							<? } ?>
							<? } ?>
							</a>
							<ul class="dropdown-menu dropdown-menu-right translator-dropdown" style="width: 230px;">
							<?php unset($language); foreach ($languages as $language) { ?>
							<?php if ($language['language_id'] != $auto_translator_source) { ?>
							<li class="">
							<a style="cursor:pointer;" onclick="setMainTranslatorLanguage(<?php echo $language['language_id']; ?>)"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
							</li>
							<? } ?>
							<? } ?>
							</ul>
							</li>
						*/ ?>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><?php if($alerts > 0) { ?><span class="label label-danger pull-left"><?php echo $alerts; ?></span><?php } ?> <i class="fa fa-bell fa-lg"></i></a>
							<ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
								<li class="dropdown-header"><?php echo $text_order; ?></li>
								<li><a href="<?php echo $processing_status; ?>" style="display: block; overflow: auto;"><span class="label label-warning pull-right"><?php echo $processing_status_total; ?></span><?php echo $text_processing_status; ?></a></li>
								<li><a href="<?php echo $complete_status; ?>"><span class="label label-success pull-right"><?php echo $complete_status_total; ?></span><?php echo $text_complete_status; ?></a></li>
								<li><a href="<?php echo $return; ?>"><span class="label label-danger pull-right"><?php echo $return_total; ?></span><?php echo $text_return; ?></a></li>
								<li class="divider"></li>
								<li class="dropdown-header"><?php echo $text_customer; ?></li>
								<li><a href="<?php echo $online; ?>"><span class="label label-success pull-right"><?php echo $online_total; ?></span><?php echo $text_online; ?></a></li>
								<li><a href="<?php echo $customer_approval; ?>"><span class="label label-danger pull-right"><?php echo $customer_total; ?></span><?php echo $text_approval; ?></a></li>
								<li class="divider"></li>
								<li class="dropdown-header"><?php echo $text_product; ?></li>
								<li><a href="<?php echo $product; ?>"><span class="label label-danger pull-right"><?php echo $product_total; ?></span><?php echo $text_stock; ?></a></li>
								<li><a href="<?php echo $review; ?>"><span class="label label-danger pull-right"><?php echo $review_total; ?></span><?php echo $text_review; ?></a></li>
								<li class="divider"></li>
								<li class="dropdown-header"><?php echo $text_affiliate; ?></li>
								<li><a href="<?php echo $affiliate_approval; ?>"><span class="label label-danger pull-right"><?php echo $affiliate_total; ?></span><?php echo $text_approval; ?></a></li>
							</ul>
						</li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home fa-lg"></i></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li class="dropdown-header"><?php echo $text_store; ?></li>
								<?php foreach ($stores as $store) { ?>
									<li><a href="<?php echo $store['href']; ?>" target="_blank"><?php echo $store['name']; ?></a></li>
								<?php } ?>
							</ul>
						</li>
						<li><a href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span> <i class="fa fa-sign-out fa-lg"></i></a></li>
					</ul>
				<?php } ?>
			</header>
				