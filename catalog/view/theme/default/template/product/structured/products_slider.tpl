<style>
	
</style>

<div class="wrap-slider container">
	<div class="row">
		<div class="slider-nav col-xs-12 col-sm-12 col-md-12">	
			<h3 class="title-slider">
				<?php if($slider_title) { ?>
					<?php echo $slider_title; ?>
				<?php } ?>							
			</h3>
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
		<?php $sli=0; foreach ($slider_products as $product) { ?>
			<?php $product['ecommerceData']['position'] = $sli; $sli++;  ?>
			<?php if (!empty($slider_title)) { ?>								
				<?php $product['ecommerceData']['list'] = 'Slider: ' . prepareEcommString($slider_title);  ?>
				<?php } else { ?>
				<?php $product['ecommerceData']['list'] = 'Undefined Slider';  ?>
			<?php } ?>
			<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_single.tpl'); ?>
		<?php } ?>				
	</div>	
</div>
</div>
</div>

<script>
	<?php if ($slider_products) { ?>	
		$(document).ready(function(){
			
			
			if ((typeof fbq !== 'undefined')){
				<?php
					$contentIDString = "";
					foreach ($slider_products as $product){
						$contentIDString .= "'" . (int)$product['product_id'] . "',";
					}
					$contentIDString = rtrim($content_ids_str, ',');
				?>
				
				fbq('track', 'ViewContent', 
				{
					content_type: 'product',
					content_ids: [<?php echo $contentIDString; ?>]
				});
			}
			
			<?php $chunkedProducts = array_chunk($slider_products, 5); ?>			
			<?php $k = 0; foreach ($chunkedProducts as $key => $products) { ?>
				window.dataLayer = window.dataLayer || [];
				console.log('dataLayer.push impressions');
				dataLayer.push({
					'event': 'productImpression',
					'ecommerce': {
						'currencyCode': '<?php echo !empty($products[0]['ecommerceCurrency'])?$products[0]['ecommerceCurrency']:'UAH'; ?>',  
						'impressions':[
						<?php $i = 0; foreach ($products as $product) { ?>							
							{
								<?php foreach ($product['ecommerceData'] as $ecommerceKey => $ecommerceValue) { ?>
									'<?php echo $ecommerceKey; ?>': '<?php echo $ecommerceValue; ?>',
								<?php } ?>
								'position': '<?php echo $k; ?>',
								<?php if (!empty($slider_title)) { ?>								
									'list': 'Slider: <?php echo prepareEcommString($slider_title); ?>'
									<?php } else { ?>
									'list': 'Undefined Slider'
								<?php } ?>
							}<?php if ($i < (count($products) - 1)) {?>,<?php } ?>
							<?php $i++; ?>
							<?php $k++; ?>
						<?php } ?>
						]
					}
				});	
			<?php } ?>
		});
	<?php } ?>			
</script>

