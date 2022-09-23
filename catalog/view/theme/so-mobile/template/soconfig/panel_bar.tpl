
<nav class="bar bar-tab">
	<a class="tab-item " href="<?php echo $home;?>" data-transition="slide-in">
		<span class="icon icon-home"></span>
		<span class="tab-label"><?php echo $objlang->get('text_home'); ?></span>
	</a>
	<a class="tab-item" href="<?php echo $menu_search?>" data-transition="slide-in">
		<span class="icon icon-search"></span>
		<span class="tab-label"><?php echo $objlang->get('text_search'); ?></span>
	</a>
	<a class="tab-item item-cart" href="<?php echo $shopping_cart; ?>" data-transition="slide-in">
		<span class="icon icon-download"></span>
		<div id="cart" class="btn-shopping-cart">
			<span class="total-shopping-cart cart-total-full">
				 <?php echo $text_items; ?>
			</span>
		</div>
		
		<span class="tab-label"><?php echo $objlang->get('text_cart'); ?></span>
	</a>
	<a class="tab-item" href="<?php echo $login;?>" data-transition="slide-in">
		<span class="icon icon-person"></span>
		<span class="tab-label"><?php echo $objlang->get('text_account'); ?></span>
	</a>
	<?php if($mobile['barmore_status']):?>
	<a class="tab-item tab-item--more tooltip-popovers"  href="<?php echo $home;?>#popover">
		<span class="icon icon-more"></span>
		<span class="tab-label"><?php echo $objlang->get('text_more'); ?></span>
	</a>
	<?php endif;?>
</nav>
<?php if($mobile['barmore_status']):?>
<div id="popover" class="popover fade bottom in right">
	<ul class="table-view">
		<?php foreach($mobile['listmenus'] as $menuitem) { ?>
		<li class="table-view-cell"><a class="tab-item" href="<?php echo $menuitem['link'];?>"> <?php echo $menuitem['name'];?> </a></li>
		<?php } ?>
	</ul>
</div>
<?php endif;?>
	

