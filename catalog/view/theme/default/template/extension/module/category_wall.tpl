<style>
	.title-slider a{color:#353535}
	.title-slider button{margin-left:20px; background-color: #14a0d4; border: 1px solid #14a0d4;}
	.title-slider button > a{color:#FFF}
</style>
<div class="category-wall">	
	<?php foreach ($categories as $category) { ?>
		<div class="wrap-slider container featured_slider">
			<div class="row">
				<div class="slider-nav col-xs-12 col-sm-12 col-md-12"> 
					<div class="title-slider">
						<a href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
						<button class="hidden-xs bbtn bbtn-primary product__btn-cart"><a href="<?php echo $category['href']; ?>" ><?php echo $text_view_all; ?></a></button>						
					</div>
					
					<div class="slider-nav-btn">
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
				</div>
				<div class="swiper-container col-xs-12 col-sm-12 col-md-12"> 
					<div class="swiper-wrapper">        
						<?php foreach ($category['products'] as $product) { ?>  
							<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_single_slider.tpl'); ?>
						<?php } ?>     
					</div>  
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="clearfix"></div>
</div>