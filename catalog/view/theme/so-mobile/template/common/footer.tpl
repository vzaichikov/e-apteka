<?php if(isset($registry)){$this->soconfig = new Soconfig($registry);} ?>
		<div class="container footer-content">
			<?php if ($mobile['phone_status'] && $mobile['email_status']):?>
			<div class="footernav-top">
				<div class="need-help">
					<p><?php echo $objlang->get('text_needhelp')?></p>
					<div class="nh-contact">
						<?php if ($mobile['phone_status']):?><a href="tel:<?php echo $mobile['phone_text'];?>"><i class="fa fa-phone"></i><?php echo $mobile['phone_text'];?></a> <?php endif;?>
						<?php if ($mobile['email_status']):?><a class="need-help-padding" href="mailto:<?php echo $mobile['email_text'];?>" target="_top"><i class="fa fa-envelope-o"></i> <?php echo $objlang->get('text_emailus')?></a> <?php endif;?>
					</div>
				</div>
			</div>
			<?php endif;?>
			
			<?php if ($mobile['customfooter_status']):?>
			<div class="footernav-social">
				<?php echo  html_entity_decode($mobile['customfooter_text'], ENT_QUOTES, 'UTF-8');?>
			</div>
			<?php endif;?>
			
			<?php if ($mobile['menufooter_status'] ):?>
			<div class="footernav-midde">
				<ul class="footer-link-list row">
					<?php 
					if(isset($mobile['footermenus'])){
						foreach($mobile['footermenus'] as $nummber => $menuitem) { ?>
						<li class="col-xs-6"><a href="<?php echo $menuitem['link'];?>"> <?php echo $menuitem['name'];?> </a></li>
						<?php }
					}
					?>
					
				</ul>
			</div>
			<?php endif;?>
			
			<div class="footernav-bottom">
				<div class="text-center">
					<?php if ( !empty($mobile['imgpayment'] )) : ?>
						<p class="nomargin"><img alt="Footer Image" class="form-group" src="<?php echo 'image/'.$mobile['imgpayment'];?>"></p>
					<?php endif;?>
					
					<?php 
					$datetime = new DateTime();
					$cur_year	= $datetime->format('Y');
					$copyright = $mobile['copyright'];
					echo (!isset($copyright) || !is_string($copyright) ? $powered : str_replace('{year}', $cur_year,html_entity_decode($copyright, ENT_QUOTES, 'UTF-8')));
					?>
					
				</div>
			</div>
		</div>
		
	</div>
	<!-- End Main Content -->
	
	</div>
	<!-- End Main wrapper -->
	
    <?php 
		//Render Panel Left
		include(DIR_TEMPLATE.'so-mobile/template/soconfig/panel_left.tpl');
	?>
</body>
</html>
