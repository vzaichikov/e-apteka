<div class="row">
	<div class="col-md-12">
		<div class="product-category-list">
			<?php $pli = 0; foreach ($products as $product) { ?>
				<?php $product['ecommerceData']['position'] = $pli; $pli++;  ?>
				<?php if (!empty($heading_title)) { ?>								
					<?php $product['ecommerceData']['list'] = prepareEcommString($heading_title);  ?>
					<?php } else { ?>
					<?php $product['ecommerceData']['list'] = 'Undefined Products List';  ?>
				<?php } ?>
				<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_single.tpl'); ?>
			<?php } ?>
		</div>
	</div>
</div>

<script>
	<?php if ($products) { ?>	
		$(document).ready(function(){			
			
			if ((typeof fbq !== 'undefined')){
				<?php
					$contentIDString = "";
					foreach ($products as $product){
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
			
			<?php $chunkedProducts = array_chunk($products, 5); ?>			
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
								<?php if (!empty($heading_title)) { ?>								
									'list': '<?php echo prepareEcommString($heading_title); ?>'
									<?php } else { ?>
									'list': 'Undefined Products List'
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