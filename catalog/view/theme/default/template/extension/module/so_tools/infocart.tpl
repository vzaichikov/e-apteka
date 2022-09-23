<div class="popup popup-mycart popup-hidden" id="popup-mycart">
	<div class="popup-screen">
		<div class="popup-position">
			<div class="popup-container popup-small">
				<div class="popup-html">
					<div class="popup-header">
						<span><i class="fa fa-shopping-cart"></i><?php echo $text_shopping_cart?></span>
						<a class="popup-close" data-target="popup-close" data-popup-close="#popup-mycart"><i class="fa fa-times"></i></a>
					</div>
					<div class="popup-content">
						<div class="cart-header">
							<?php if ($products || $vouchers) { ?>
								<div class="notification gray">
									<p><?php echo $text_items_product?></p>
								</div>
								<table class="table table-striped">
									<?php foreach ($products as $product) { ?>
										<tr>
								  			<td class="text-left first">
								  				<?php if ($product['thumb']) { ?>
								    				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
								    			<?php } ?>
								    		</td>
								  			<td class="text-left">
								  				<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
								    			<?php if ($product['option']) { ?>
								    				<?php foreach ($product['option'] as $option) { ?>
								    					<br />
								    					- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
								    				<?php } ?>
								    			<?php } ?>
								    			<?php if ($product['recurring']) { ?>
								    				<br />
								    				- <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
								    			<?php } ?>
								    		</td>
								  			<td class="text-right">x <?php echo $product['quantity']; ?></td>
								  			<td class="text-right total-price"><?php echo $product['total']; ?></td>
								  			<td class="text-right last"><a href="javascript:;" onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>"><i class="fa fa-trash"></i></a></td>
										</tr>
									<?php } ?>
									<?php foreach ($vouchers as $voucher) { ?>
										<tr>
								  			<td class="text-left first"></td>
								  			<td class="text-left"><?php echo $voucher['description']; ?></td>
								  			<td class="text-right">x&nbsp;1</td>
								  			<td class="text-right"><?php echo $voucher['amount']; ?></td>
								  			<td class="text-right last"><a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>"><i class="fa fa-trash"></i></a></td>
										</tr>
									<?php } ?>
								</table>
								<div class="cart-bottom">
									<table class="table table-striped">
								  		<?php foreach ($totals as $total) { ?>
								  			<tr>
								    			<td class="text-left"><strong><?php echo $total['title']; ?></strong></td>
								    			<td class="text-right"><?php echo $total['text']; ?></td>
								  			</tr>
								  		<?php } ?>
									</table>
									<p class="text-center">
										<a href="<?php echo $cart; ?>" class="btn btn-view-cart"><strong><?php echo $text_cart; ?></strong></a>
										<a href="<?php echo $checkout; ?>" class="btn btn-checkout"><strong><?php echo $text_checkout; ?></strong></a>
									</p>
								</div>
							<?php }else {?>
								<div class="notification gray">
									<i class="fa fa-shopping-cart info-icon"></i>
									<p><?php echo $text_empty?></p>
								</div>
							<?php }?>
						</div>
					</div>			
				</div>
			</div>
		</div>
	</div>
</div>