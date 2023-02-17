<div id="popupcart_extended">   
	<div class="head"><?php echo $head; ?>
		<div class="overlay-popup-close" onclick="$('#popupcart_extended').popup('hide')"></div>
	</div>
	<?php if ($products || $vouchers) { ?>
		<div class="popupcart_info">
			<table>
				<tr></tr>
				<?php foreach ($products as $key => $product) { ?>
					<tr class="row_<?php echo $key; ?>_<?php echo $product['id']; ?>">
						<td class="remove"><i class="fa fa-times-circle" title="<?php echo $button_remove; ?>" onclick="$('#product_cart_key_<?php echo $product['key']; ?>').val(''); updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', 'fullremove', $('#product_cart_previous_key_<?php echo $product['key']; ?>').val())" ></i></td>
						<td class="image">
							<?php if ($product['thumb']) { ?>
								<img src="<?php echo $product['thumb']; ?>" onclick="location='<?php echo $product['href']; ?>'" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
							<?php } ?>
						</td>
						<td class="name">
							<?php if (!empty($product['is_preorder'])) { ?>
									<div class="text-warning" style="padding:5px 0px 5px;">
										<label class="label label-warning"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $text_available_on_preorder; ?></label>
									</div>
							<?php } ?>

							<a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?>
								<br /><small class="product-layout__name__manufacturer text-muted" style="font-size:10px; line-height: 10px;"><?php echo $product['manufacturer']; ?></small>
							</a>
							<div style="margin-bottom: 15px;">
								<?php foreach ($product['option'] as $option) { ?>
									 <small class="label label-info"><?php echo $option['value']; ?></small><br />
								<?php } ?>
							</div>							
							<?php if (!$product['stock']) { ?>
								<?php if ($product['quantity'] >= $product['maximum']) { ?>
									<div class="text-danger"><small><i class="fa fa-exclamation-triangle"></i> <?php echo $in_stock; ?> <?php echo $product['maximum']; ?> <?php echo $pcs; ?></small></div>
								<?php } ?>
							<?php } ?>
						</td>
						<td class="quantity">
							<div>
								<input type="hidden" id="product_cart_previous_key_<?php echo $product['key']; ?>" value="<?php echo $product['quantity']; ?>" />
								<input type="text" id="product_cart_key_<?php echo $product['key']; ?>" name="<?php echo $product['key']; ?>" size="2" value="<?php echo $product['quantity']; ?>" onchange="updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', 'explicit', $('#product_cart_previous_key_<?php echo $product['key']; ?>').val());" />
								<?php if (!$product['stock']) { ?>
									<?php if ($product['quantity'] < $product['maximum']) { ?>
										<span class="plus" onclick="updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '+')">+</span>
										<?php } else { ?>
										<span class="plus" style="opacity:0.5; cursor:default">+</span>
									<?php } ?>
									<?php } else { ?>
									<span class="plus" onclick="let previousQuantity = $('#product_cart_key_<?php echo $product['key']; ?>').val(); updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '+', previousQuantity)">+</span>
								<?php } ?>
								<span class="minus" onclick="let previousQuantity = $('#product_cart_key_<?php echo $product['key']; ?>').val(); updateCart('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '-', previousQuantity)">-</span>
							</div>
						</td>
						<td class="price">						
							<p><?php echo $product['total']; ?></p>
						</td>
						
					</tr>
				<?php } ?>
			</table>
		</div>
		<div class="popupcart_total">
			<table>
				<?php foreach($totals as $total) { ?>
					<tr>
						<td class="right"><?php echo $total['title']; ?></td> <td class="right"><?php echo $total['text']; ?></td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<div class="popupcart_buttons">
			<?php if($button_shopping_show) { ?>
				<button type="button" class="product__btn-cart button btn btn-primary btn-lg" onclick="$('#popupcart_extended').popup('hide')" ><?php echo $button_shopping; ?></button>
				<?php } else { ?>
				<a class="continue" onclick="$('#popupcart_extended').popup('hide')"><?php echo $button_shopping; ?></a>
			<?php } ?>
			<?php if ($button_cart_show) { ?>
				<button type="button" class="product__btn-cart cont button btn btn-primary btn-lg" onclick="location='<?php echo $cart; ?>'" ><?php echo $button_cart; ?></button>
			<?php } ?>
			<button type="button" class="product__btn-cart  button btn btn-primary btn-lg" onclick="location='<?php echo $checkout; ?>'"><?php echo $button_checkout; ?></button>
		</div>		
		<?php } else { ?>
		<div class="empty"><?php echo $text_empty; ?></div>
	<?php } ?>
	<input type="hidden" name="addtocart_logic" value="<?php echo $addtocart_logic; ?>" />
	<input type="hidden" name="click_on_cart" value="<?php echo $click_on_cart; ?>" />
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#popupcart_extended').popup({transition: 'all 0.3s',	scrolllock: true});	
	});
	
	function p_array() {
		<?php foreach ($products as $product) { ?>
			<?php if($product['option']) { ?>
				replace_button('<?php echo $product['id']; ?>', 1);
				<?php } else { ?>
				replace_button('<?php echo $product['id']; ?>', 0);
			<?php } ?>
		<?php } ?>
	}
	
	function replace_button(product_id, options){
		if(options && $('.'+product_id).attr('id') == 'button-cart') {
			var text = '<?php echo $button_incart_with_options; ?>';
			} else {
			var text = '<?php echo $button_incart; ?>';
		}
		<?php if($button_incart_logic) { ?>
			$('html, body').find('.'+product_id).val(text).text(text).addClass('in_cart');
			<?php } else { ?>
			if(options) {
				$('html, body').find('.'+product_id).val(text).text(text).addClass('in_cart');
				} else {
				$('html, body').find('.'+product_id).attr('onclick', '$(\'#popupcart_extended\').popup(\'show\');').val(text).text(text).addClass('in_cart');
			}
		<?php } ?>
	}
</script>	