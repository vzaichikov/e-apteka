<header id="header" class=" variant typeheader-<?php echo isset($typeheader) ? $typeheader : '5'?>">
	<!-- HEADER TOP -->
	<div class="header-top compact-hidden">
		<div class="container">
			<div class="row">
				<div class="header-top-left form-inline col-sm-5 hidden-xs compact-hidden">
					<ul class="list-inline">
						<?php if($welcome_message_status):?>
						<li class="hidden-xs" >
							<i class="fa fa-envelope"></i>
							<?php
								if (isset($welcome_message) && is_string($welcome_message)) {
									echo html_entity_decode($welcome_message, ENT_QUOTES, 'UTF-8');
								} else {echo 'Default welcome msg!';}
							?>
						</li>
						<?php endif; ?>
					</ul>
				</div>
				<div class="header-top-right col-sm-7 collapsed-block col-xs-12 compact-hidden text-right">
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
							<?php if($checkout_status):?><li class="checkout"><a href="<?php echo $checkout; ?>" class="btn btn-link" title="<?php echo $text_checkout; ?>"><span ><?php echo $text_checkout; ?></span></a></li><?php endif; ?>
							
							
						</ul>
					</div>
					
					
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- HEADER CENTER -->
	<div class="header-center">
		<div class="container">
			<div class="row">
				<!-- LOGO -->
				<div class="navbar-logo col-lg-3 col-md-2 col-sm-3 col-xs-12">
				   <?php  $this->soconfig->get_logo();?>
				</div>
				<div class="box-center-r col-lg-9 col-md-10 col-sm-9 col-xs-12">
					<!-- BOX CONTENT SEARCH -->
					<?php echo $content_search; ?>
					
					<!-- LANGUAGE CURENTY -->
					<?php if($lang_status):?>
					<div class="curenty-laguage">
						<div class="form-group languages-block"><?php echo $currency; ?> </div>
						<div class="form-group languages-block"><?php echo $language; ?></div>
					</div>
					<?php endif; ?>
					
					<!-- BOX CART -->
					<div class="shopping_cart pull-right">
						<?php echo $cart; ?> 
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- HEADER BOTTOM -->
	<div class="header-bottom compact-hidden">
		<div class="container">
			<div class="row">
				<div class="menu-vertical col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<?php echo $content_menu1; ?>
				</div>

				<div class="content_menu col-lg-7 col-md-9 col-sm-9">
				   <?php echo $content_menu; ?>
				</div>
				
				<?php
					if($phone_status) {
						if (isset($contact_number) && is_string($contact_number)) {
						echo '<div class="custom-phone col-lg-2 col-md-2 hidden-md hidden-sm hidden-xs pull-right"><i class="textColor fa fa-phone"></i> '.html_entity_decode($contact_number, ENT_QUOTES, 'UTF-8').'</div>';
						}
					}
				?>
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