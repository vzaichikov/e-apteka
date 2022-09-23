<?php if (!empty($products)) { ?>
	<script type="text/javascript">
		window.dataLayer = window.dataLayer || [];
		console.log('dataLayer.push <? echo $ecommerceEvent;?>');
		dataLayer.push({
			'event': '<? echo $ecommerceEvent;?>',
			'ecommerce': {
				'checkout': {
					'actionField': {'step': <? echo $ecommerceStep;?>, 'option': '<? echo $ecommerceEvent;?>'},
					'products': [
					<?php $i = 0; foreach ($products as $product) { ?>	
						{
							<?php $z = 0; foreach ($product['ecommerceData'] as $ecommerceKey => $ecommerceValue) { ?>
								'<?php echo $ecommerceKey; ?>': '<?php echo $ecommerceValue; ?>'<?php if ($z < (count($product['ecommerceData'] ) - 1)) {?>,<?php } ?><?php $z++; ?>
							<?php } ?>
						}<?php if ($i < (count($products) - 1)) {?>,<?php } ?>
						<?php $i++; ?>
					<?php } ?>				
					]
				}
			}				
		});
	</script>
<?php } ?>