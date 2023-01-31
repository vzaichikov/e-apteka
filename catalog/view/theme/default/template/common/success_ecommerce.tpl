<script type="text/javascript">
	window.dataLayer = window.dataLayer || [];
	console.log('dataLayer.push ' + 'orderPurchaseSuccess');
	dataLayer.push({
		'event': 'orderPurchaseSuccess',
		'ecommerce': {
			'currencyCode': '<?php echo $ecommerceData['currencyCode']; ?>',  
			'purchase': {
				'id': '<? echo $ecommerceData['id'] ?>',                        
				'affiliation': '<? echo $ecommerceData['affiliation'] ?>',
				'revenue': '<? echo $ecommerceData['revenue'] ?>',  
				'tax':'<? echo $ecommerceData['tax'] ?>',

				<?php if (!empty($ecommerceData['coupon'])) { ?>
					'coupon':'<? echo $ecommerceData['coupon'] ?>',
				<?php } ?>

				'shipping': '<? echo $ecommerceData['shipping'] ?>',
				'actionField': {
					'id': '<? echo $ecommerceData['id'] ?>',                        
					'affiliation': '<? echo $ecommerceData['affiliation'] ?>',
					'revenue': '<? echo $ecommerceData['revenue'] ?>',  
					'tax':'<? echo $ecommerceData['tax'] ?>',

					<?php if (!empty($ecommerceData['coupon'])) { ?>
						'coupon':'<? echo $ecommerceData['coupon'] ?>',
					<?php } ?>

					'shipping': '<? echo $ecommerceData['shipping'] ?>'
				},
				'products': [
					<? $i=0; foreach ($ecommerceData['products'] as $ecommerceProduct) { ?>
						{
							'id' : '<? echo $ecommerceProduct['id']; ?>',
							'name' : '<? echo $ecommerceProduct['name'] ?>',
							'brand' : '<? echo $ecommerceProduct['brand'] ?>',
							'category' : '<? echo $ecommerceProduct['category'] ?>',
							'price' : '<? echo $ecommerceProduct['price'] ?>',
							'quantity' : '<? echo $ecommerceProduct['quantity'] ?>',
							'total' : '<? echo $ecommerceProduct['total'] ?>'
						}	<? if ($i < count($ecommerceData['products'])) { ?>,<?php } $i++; ?>
					<? } ?>

					]					
			}	
		}
	});
</script>