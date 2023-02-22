<style type="text/css">
	@media screen and (max-width: 560px) {
		.product-category-list{
			gap: 10px;
		    display: grid;
		    grid-template-columns: 1fr 1fr !important;
		}
		.product-category-list .product-item{
		    padding: 10px;
		    display: flex;
		    flex-direction: column;
		}
		.product-category-list .product-item .product-layout__image{
			margin: 0;
		}
		.product-category-list .product-item .price_group{
			margin-top: auto;
		}
		.product-category-list .product-item .rating{
			display: block !important;
		}
		.product-category-list .product-item .product-layout__caption .product-layout__name a{
		    font-size: 12px;
		    line-height: 14px;
		    display: -webkit-box;
		    -webkit-line-clamp: 3;
		    -webkit-box-orient: vertical;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    max-height: 100%;
		}
		.product-category-list .product-item .product-layout__caption .product-layout__name__wrap {
		    height: 65px;
		    overflow: hidden;
		    margin-bottom: 5px;
		}
		.product-category-list .product-item .price_group .price {
		    font-size: 17px;
		    line-height: 16px;
		    justify-content: space-between;
		}
		.product-category-list .product-item .price_group .price.no_price_of_part{
			justify-content: center;
		}
		.product-category-list small.product-layout__name__manufacturer {
		    font-size: 9px;
		    line-height: 9px;
		    display: -webkit-box;
		    -webkit-line-clamp: 2;
		    -webkit-box-orient: vertical;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    margin-top: 5px;
		}
		.product-category-list .product-item .price_group>div button {
		    width: 35px;
		    height: 35px;
		    padding: 0;
		}
		.product-category-list .product-item .button-group .product-layout__btn-compare svg, 
		.product-category-list .product-item .button-group .product-layout__btn-wishlist svg {
		    width: 25px;
		    height: 25px;
		    display: flex;
		}
		.product-item .button-group .product-layout__btn-compare, .product-item .button-group .product-layout__btn-wishlist{
			position: absolute;
		    background: #ffffffd1;
		    display: flex;
		    align-items: center;
		    justify-content: center;
		}
		.product-item .button-group .product-layout__btn-compare{
			top: 10px;
		}
		.product-item .button-group .product-layout__btn-wishlist{
			top: 50px;
		}
	}
	
</style>
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