
<header id="header" class=" variant typeheader-<?php echo isset($typeheader) ? $typeheader : '1'?>">
	<!-- HEADER TOP -->
	<div class="header-top compact-hidden">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-2 nabar-logo">
					<!-- LOGO -->
					<div class="logo"><?php  $this->soconfig->get_logo();?></div>
				</div>
				<div class="col-lg-10 col-md-10 nabar-menus">
					<div class="header-right-top row compact-hidden">
						
						<div class="header-top-left  col-sm-6 col-xs-6">
							<ul class="list-inline">
								<?php
								if($phone_status) {
									if (isset($contact_number) && is_string($contact_number)) {
									echo '<li class="hidden-xs hidden-sm"><i class="fa fa-phone"></i> '.html_entity_decode($contact_number, ENT_QUOTES, 'UTF-8').'</li>';
									}
								}
									
								?>
								<?php if($welcome_message_status):?>
								<li class="hidden-xs" >
									<?php
										if (isset($welcome_message) && is_string($welcome_message)) {
											echo html_entity_decode($welcome_message, ENT_QUOTES, 'UTF-8');
										} else {echo 'Default welcome msg!';}
									?>
								</li>
								<?php endif; ?>
							</ul>
						</div>
						<div class="header-top-right collapsed-block col-sm-6 col-xs-6 text-right">
							<div class="btn-group tabBlocks" >
								<ul class="top-link list-inline">
									<li class="account" id="my_account"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="btn btn-link dropdown-toggle" data-toggle="dropdown"> <span ><?php echo $text_account; ?></span> <span class="fa fa-angle-down"></span></a>
										<ul class="dropdown-menu ">
											<?php if ($logged) { ?>
											<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
											<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
											<li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
											<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
											<li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
											<?php } else { ?>
											<li><a href="<?php echo $register; ?>"><i class="fa fa-user"></i> <?php echo $text_register; ?></a></li>
											<li><a href="<?php echo $login; ?>"><i class="fa fa-pencil-square-o"></i> <?php echo $text_login; ?></a></li>
											<?php } ?>
										</ul>
									</li>
									<!-- WISHLIST  -->
									<?php if($wishlist_status):?><li class="wishlist"><a href="<?php echo $wishlist; ?>" id="wishlist-total" class="btn btn-link" title="<?php echo $text_wishlist; ?>"><span ><?php echo $text_wishlist; ?></span></a></li><?php endif; ?>
									<!-- COMPARE -->
									<?php if($checkout_status):?><li class="checkout"><a href="<?php echo $checkout; ?>" class="btn btn-link" title="<?php echo $text_checkout; ?>"><span ><?php echo $text_checkout; ?></span></a></li><?php endif; ?>	<!-- LANGUAGE CURENTY -->
									<?php if($lang_status):?>
										<li > <?php echo $currency; ?> </li>
										<li ><?php echo $language; ?></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="header-right-bottom row">
						<div class="mega-horizontal col-md-9 col-sm-2 col-xs-5 ">
							<?php echo $content_menu; ?>
						</div>
						<div class="shopping_cart col-md-2 col-sm-8 col-xs-2">
							<?php echo $cart; ?> 
						</div>
						
						<div class="search-block col-md-1 col-sm-2 col-xs-5">
						   <?php echo $content_search; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Navbar switcher -->
	<?php if (!isset($toppanel_status) || $toppanel_status != 0) : ?>
	<?php if (!isset($toppanel_type) || $toppanel_type != 2 ) :  ?>
	<div class="navbar-switcher-container">
		<div class="navbar-switcher">
			<span class="i-inactive">
				<i class="fa fa-caret-down"></i>
			</span>
			 <span class="i-active fa fa-times"></span>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</header>