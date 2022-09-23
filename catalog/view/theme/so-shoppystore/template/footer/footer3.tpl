
<footer class="footer-container typefooter-<?php echo isset($typefooter) ? $typefooter : '3'?>">
	<?php if ($footertop) : ?>
	<div class="footer-newsletter">
		<?php echo $footertop; ?>
	</div>
	<?php endif; ?>
	
	<!-- FOOTER TOP -->
	<div class="footer-top footer-top-block">
		<div class="container">
			<div class="row">
				<?php if ($footer_block3) : ?>
				<!-- BOX ABOUT HTML -->
				<div class="col-lg-15 col-sm-12 col-xs-12 collapsed-block footer-links">
					<div class="module clearfix">
						<div  class="modcontent" >
							<div class="footer-newsletter">
								<?php echo $footer_block3; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<!-- BOX MY ACOUNT -->
				<div class="col-lg-15 col-sm-6 col-md-3 col-xs-12 box-account">
					<div class="module clearfix">
						<h3 class="footer-title"><?php echo $text_account; ?></h3>
						<div  class="modcontent" >
							<ul class="menu">
								<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
								<li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
								<li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
								<li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- BOX INFOMATION --> 
				<?php if ($informations) :?>
					<div class="col-lg-15 col-sm-6 col-md-3 col-xs-12 box-information">
						<div class="module clearfix">
							<h3 class="footer-title"><?php echo $text_information; ?></h3>
							<div  class="modcontent" >
								<ul class="menu">
									<?php foreach ($informations as $information) { ?>
									<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="col-lg-15 col-sm-6 col-md-3 col-xs-12 box-information">
					<div class="module clearfix">
						<h3 class="footer-title"><?php echo $text_extra; ?></h3>
						<div  class="modcontent" >
							<ul class="menu">
								<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
								<li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
								<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
								<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- BOX SEVICER -->
				<div class="col-lg-15 col-sm-6 col-md-3 col-xs-12 box-service">
					<div class="module clearfix">
						<h3 class="footer-title"><?php echo $text_service; ?></h3>
						<div  class="modcontent" >
							<ul class="menu">
								<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
								<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
								<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
							</ul>
						</div>
					</div>
				</div>	
				
	
				<hr>
			</div>
		</div>
	</div>
	<!-- FOOTER CENTER -->
	<div class="footer-center">
		<?php if($footerbottom):?>
		<div class="container">
			<?php echo $footerbottom; ?>
			
		</div>
		<?php endif;?>
	</div>
	
				
	<!-- FOOTER BOTTOM -->
	<div class="footer-bottom ">
		<div class="container">
			<div class="row">
				<?php $col_copyright = ($imgpayment_status) ? 'col-sm-7' : 'col-sm-12'?>
				<div class="<?php echo $col_copyright;?> copyright-text">
					<?php 
					$datetime = new DateTime();
					$cur_year	= $datetime->format('Y');
					echo (!isset($copyright) || !is_string($copyright) ? $powered : str_replace('{year}', $cur_year, $copyright));?>
				</div>

				<?php if (isset($imgpayment_status) && $imgpayment_status != 0) : ?>
				<div class="col-sm-5 text-right">
					<?php
					if ((isset($imgpayment) && $imgpayment != '') ) { ?>
						<img src="image/<?php echo  $imgpayment ?>"  alt="imgpayment">
					<?php } ?>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	

</footer>