<?php if(isset($special_products) && $special_products) { ?>
	
	<div class="row"><div class="col-md-12"><div class="action-slider" id="action-slider">
		
		<div class="slider__arrows">
			<div class="slider__arrow slider__arrow--prev">
				<svg class="icon">
				<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
			</svg>
		</div>
		<div class="slider__arrow slider__arrow--next">
			<svg class="icon">
			<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
		</svg>
	</div>
	</div>
	
	<div class="slider__list">
		<?php foreach ($special_products as $product) { ?>
			<div class="slider__item action-slider__item asi">
				<?php echo $product['seo']; ?>
				
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
					<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" loading="lazy" /></a>								
				</div>
				
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					
					
					<h4 class="asi__title"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
					<?php if ($product['price']) { ?>
						<p class="price">
							<?php if (!$product['special']) { ?>
								<?php echo $product['price']; ?>
								<?php } else { ?>
								<span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
							<?php } ?>
							<?php if ($product['tax']) { ?>
								<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
							<?php } ?>
						</p>
					<?php } ?>
					
					<div class="asi__timer timer">
					<?php echo $text_special_time_to_left; ?> <b><?php echo $product['dateDiff']; ?> дн.</b></p>
				</div>
			</div>
			
		</div>
	<?php } ?>
	</div>
</div>
</div>
</div>
<?php } ?>