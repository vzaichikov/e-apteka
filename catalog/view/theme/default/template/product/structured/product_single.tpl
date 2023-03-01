<div class="swiper-slide product-item product-single <?php if($product['quantity'] == 0) { ?>product-item-not-in-stock<? } ?>" data-product-id="<?php echo $product['product_id']; ?>" 
data-gtm-product='{<?php foreach ($product['ecommerceData'] as $ecommerceKey => $ecommerceValue) { ?>"<?php echo $ecommerceKey; ?>": "<?php echo $ecommerceValue; ?>",<?php } ?> "url": "<?php echo $product['href']; ?>"}' <?php if ($product['backlight']) { ?>style="background-color:<?php echo $product['backlight']; ?>"<? } ?>>
	<div class="product-layout__image 1">
		
		<?php if (!empty($product['product_xdstickers'])) { ?>
			<div class="xdstickers_wrapper<?php echo $xdstickers_position ?>">
				<?php foreach($product['product_xdstickers'] as $xdsticker) { ?>
					<div class="xdstickers <?php echo $xdsticker['id']; ?>">
						<?php echo $xdsticker['text']; ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
		
		<a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" >
			<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" width="200" height="200" class="img-responsive swiper-lazy" loading="lazy">
		</a>
		<?php if ($is_mobile) { ?>
			<?php if ($product['rating']) { ?>
				<div class="rating">
					<?php for ($i = 1; $i <= 5; $i++) { ?>
						<?php if ($product['rating'] < $i) { ?>
							<svg class="icon rating__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
							<?php } else { ?>
							<svg class="icon rating__icon is-active"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
	
	<div class="product-layout__caption">
		<?php if (!$is_mobile) { ?>
			<?php if ($product['rating']) { ?>
				<div class="rating">
					<?php for ($i = 1; $i <= 5; $i++) { ?>
						<?php if ($product['rating'] < $i) { ?>
							<svg class="icon rating__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
							<?php } else { ?>
							<svg class="icon rating__icon is-active"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>
		<div class="product-layout__name__wrap">
			<h4 class="product-layout__name"><a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></h4>
			<?php if ($product['manufacturer']) { ?>
				<small class='product-layout__name__manufacturer text-muted'><?php echo $product['manufacturer']; ?></small>
			<?php } ?>
		</div>
	</div>

	<div class="price_group">
		<div>
			<?php if($product['quantity'] > 0) { ?>
				<?php if ($product['price']) { ?>
					<div class="price <?php if (!$product['price_of_part']) { ?>no_price_of_part<?php } ?>">
						<?php if (!$product['special']) { ?>
							<?php echo $product['price']; ?>
						<?php } else { ?>
							<div class="group_price">
								<span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
							</div>							
						<?php } ?>
						
						<?php if ($product['tax']) { ?>
							<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
						<?php } ?>

						<?php if ($product['price_of_part']) { ?>
							<small><?php echo $product['text_full_pack']; ?></small>
						<?php } ?>
					</div>

				<?php } ?>
				<?php } else { ?>
				<p class="price price-not-in-stock"><?php echo $text_not_in_stock; ?></p>
			<?php } ?>
			<?php if($product['quantity'] > 0) { ?>
				<button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', 1, false, true);">
					<svg width="20" height="20" viewBox="0 0 26 25" fill="none" xmlns="https://www.w3.org/2000/svg">
						<path d="M1.19141 1.33936H5.38999L8.20304 15.6922C8.29902 16.1857 8.56192 16.629 8.94571 16.9445C9.3295 17.26 9.80973 17.4276 10.3023 17.418H20.5049C20.9975 17.4276 21.4777 17.26 21.8615 16.9445C22.2453 16.629 22.5082 16.1857 22.6042 15.6922L24.2836 6.6989H6.43963M10.6382 22.7775C10.6382 23.3695 10.1683 23.8495 9.58857 23.8495C9.00887 23.8495 8.53893 23.3695 8.53893 22.7775C8.53893 22.1855 9.00887 21.7056 9.58857 21.7056C10.1683 21.7056 10.6382 22.1855 10.6382 22.7775ZM22.1843 22.7775C22.1843 23.3695 21.7144 23.8495 21.1347 23.8495C20.555 23.8495 20.085 23.3695 20.085 22.7775C20.085 22.1855 20.555 21.7056 21.1347 21.7056C21.7144 21.7056 22.1843 22.1855 22.1843 22.7775Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<?php echo $button_cart; ?>										
				</button>
			<?php } ?>
		</div>
		<?php if($product['quantity'] > 0 && $product['price_of_part'] && $product['pov_part_id']) { ?>
			<div>
				<div class="price">	
					<?php if (!$product['price_of_part_special']) { ?>
							<span><?php echo $product['price_of_part']; ?></span>
						<?php } else { ?>
							<div class="group_price">
								<span class="price-new"><?php echo $product['price_of_part_special']; ?></span> <span class="price-old"><?php echo $product['price_of_part']; ?></span>
							</div>							
						<?php } ?>
					<small><?php echo $product['text_part_pack']; ?></small>
				</div>
				<span id="option_<?php echo $product['product_id']; ?>" style="display:none;"><input type='hidden' name="option[<?php echo $product['pov_part_id']['product_option_id']; ?>]" value="<?php echo $product['pov_part_id']['product_option_value_id']; ?>" /></span>
				<button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', 1, false, false);">
					<svg width="20" height="20" viewBox="0 0 26 25" fill="none" xmlns="https://www.w3.org/2000/svg">
						<path d="M1.19141 1.33936H5.38999L8.20304 15.6922C8.29902 16.1857 8.56192 16.629 8.94571 16.9445C9.3295 17.26 9.80973 17.4276 10.3023 17.418H20.5049C20.9975 17.4276 21.4777 17.26 21.8615 16.9445C22.2453 16.629 22.5082 16.1857 22.6042 15.6922L24.2836 6.6989H6.43963M10.6382 22.7775C10.6382 23.3695 10.1683 23.8495 9.58857 23.8495C9.00887 23.8495 8.53893 23.3695 8.53893 22.7775C8.53893 22.1855 9.00887 21.7056 9.58857 21.7056C10.1683 21.7056 10.6382 22.1855 10.6382 22.7775ZM22.1843 22.7775C22.1843 23.3695 21.7144 23.8495 21.1347 23.8495C20.555 23.8495 20.085 23.3695 20.085 22.7775C20.085 22.1855 20.555 21.7056 21.1347 21.7056C21.7144 21.7056 22.1843 22.1855 22.1843 22.7775Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<?php echo $button_cart; ?>										
				</button>
				
			</div>
		<?php } ?>
	</div>
	
	<div class="button-group">
		<button class="bbtn bbtn--transparent product-layout__btn-compare" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><svg class="icon featured__compare-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use></svg></button>
		
		<button class="bbtn bbtn--transparent product-layout__btn-wishlist" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><svg class="icon featured__wishlist-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#heart"></use></svg></button>							
	</div>
	<?php if (!empty($product['seo'])) { ?>
		<?php echo $product['seo']; ?>
	<?php } ?>
</div>	