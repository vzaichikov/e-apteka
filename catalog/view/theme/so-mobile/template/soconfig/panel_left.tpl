<div id="panel-menu" class="side-menu panel panel-left">
	<div class="content">
		<div class="panel-left__top clearfix text-center">
			<div class="panel-logo">
				   <?php  $this->soconfig->get_logoMobile();?>
			</div>
			<?php if($mobile['barsearch_status'] == 1):?>
			<div class="panel-search">
				<?php echo $search; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php if ($categories) { ?>
		<div class="panel-left__midde">
			 <div class="panel-group" id="panel-category" role="tablist" aria-multiselectable="true">
				<?php $i = 0; foreach ($categories as $category) { $i++; ?>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" >
						<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
						<?php if ($category['children']) { ?>
							<span class="head"><a  class="pull-right accordion-toggle" data-toggle="collapse" data-parent="#panel-category" href="#panel-category<?php echo $i; ?>" aria-expanded="true"></a></span>
						<?php } ?>
						
					</div>
					
					<?php if(!empty($category['children'])) { ?>
					<div id="panel-category<?php echo $i; ?>" class="panel-collapse collapse " role="tabpanel">
						<ul>
						   <?php foreach ($category['children'] as $child) { ?>
							<li>
							  <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
							</li>
						   <?php } ?>
						</ul>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			
			
		</div>
		<?php } ?>
		
		<div class="panel-left__bottom clearfix text-center">
			<?php if($mobile['barcompare_status'] == 1):?>
			<div class="col-xs-6">
				<i class="fa fa-check-square-o" aria-hidden="true"></i>
				<div class="bot-inner">
					<a href="<?php echo $compare; ?>"><?php echo $text_compare; ?></a>
				</div>
			</div>
			<?php endif; ?>
			<?php if($mobile['barwistlist_status'] == 1):?>
			<div class="col-xs-6">
				<i class="fa fa-heart" aria-hidden="true"></i>
				<div class="bot-inner">
					<a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a>
				</div>
			</div>
			<?php endif; ?>
			
			<?php if($mobile['barlanguage_status'] == 1 && !empty($language)):?>
			<div class="col-xs-6 panel-left__language">
				<?php echo $language; ?>
				<h4><?php echo $objlang->get('text_language'); ?></h4>
			</div>
			<?php endif; ?>
			<?php if($mobile['barcurenty_status'] == 1):?>
			<div class="col-xs-6 panel-left__currency">
				<?php echo $currency; ?> 
				<h4><?php echo $objlang->get('text_currency'); ?></h4>

			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

