<div class="checkout-content checkout-cart">
    <h2 class="secondary-title"><i class="fa fa-shopping-cart"></i><?php echo $text_shopping_cart?> <?php if ($weight) echo '('.$weight.')'?></h2>
    <div>
        <div class="table-responsive checkout-product">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
						<th class="text-left picture"></th>
                        <th class="text-left name" colspan="2"><?php echo $column_name; ?></th>
						<? if ($need_select_location) { ?><th class="text-left name"></th><? } ?>
                        <th class="text-center quantity"><?php echo $column_quantity; ?></th>
                        <th class="text-center price"><?php echo $column_price; ?></th>
                        <th class="text-right total"><?php echo $column_total; ?></th>
					</tr>
				</thead>
                <tbody>
					<?php foreach ($products as $product) { ?>
						<tr>
							<td class="text-left picture">
								<?php if ($product['thumb']) { ?>
									<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
								<?php } ?>
							</td>
							<td class="text-left name" colspan="2">                           
								<a href="<?php echo $product['href']; ?>" class="product-name"><?php echo $product['name']; ?></a>
								<?php if (!$product['stock']) { ?>
									<span class="text-danger">***</span>
								<?php } ?>
								<?php foreach ($product['option'] as $option) { ?>
									<br/>
									&nbsp;
									<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
								<?php } ?>
								<?php if ($product['recurring']) { ?>
									<br/>
									<span class="label label-info"><?php echo $text_recurring_item; ?></span>
									<small><?php echo $product['recurring']; ?></small>
								<?php } ?>
							</td>					
							<td <? if (!$need_select_location) { ?>class='hidden'<? } ?>>
								<? if ($product['available_locations']) { ?>
									<select class="location_change" data-product-key="<?php echo $product[version_compare(VERSION, '2.1', '<') ? 'key' : 'cart_id']; ?>" name="location_id[<?php echo $product[version_compare(VERSION, '2.1', '<') ? 'key' : 'cart_id']; ?>]">
										<? $i=0; foreach ($product['available_locations'] as $location) {  ?>										
											<option <? if ($location['location_id'] == $product['location_id'] || (!$product['location_id'] && $i==0)) { ?>selected='selected'<? } ?> value="<? echo $location['location_id']; ?>"><? echo $location['name']?$location['name']:$location['dname']; ?></option>
											<option disabled>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $location['price']; ?></option>
										<? $i++; } ?>
									</select><br />
									<?php echo $text_selectlocation; ?>
									<? } else { ?>
									<span class=""></span>
								<? } ?>
							</td>
							<td class="text-left quantity">
								<div class="input-group">
									<input type="text" name="quantity[<?php echo $product[version_compare(VERSION, '2.1', '<') ? 'key' : 'cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />
									<span class="input-group-btn">
										<?php if ($setting_so_onepagecheckout_layout_setting['show_product_removecart']) {?>
											<span data-toggle="tooltip" title="<?php echo $button_remove; ?>" data-product-key="<?php echo $product[version_compare(VERSION, '2.1', '<') ? 'key' : 'cart_id']; ?>" class="btn-delete"><i class="fa fa-trash-o"></i></span>
										<?php }?>
										<?php if ($setting_so_onepagecheckout_layout_setting['show_product_qnty_update']) {?>
											<span data-toggle="tooltip" title="<?php echo $button_update; ?>" data-product-key="<?php echo $product[version_compare(VERSION, '2.1', '<') ? 'key' : 'cart_id']; ?>" class="btn-update"><i class="fa fa-refresh"></i></span>
										<?php }?>                                    
									</span>
								</div>
							</td>
							<td class="text-right price">
								<? if ($product['general_price'] && ($product['price'] != $product['general_price'])) { ?>
									<span class="price-new"><?php echo $product['price']; ?></span><br />
									<span class="price-old"><?php echo $product['general_price']; ?></span>								
									<? } else { ?>
									<?php echo $product['price']; ?>
								<? } ?>
							</td>
							<td class="text-right total"><?php echo $product['total']; ?></td>
						</tr>
					<?php } ?>
					<?php foreach ($vouchers as $voucher) { ?>
						<tr>
							<td class="text-left"><?php echo $voucher['description']; ?></td>
							<td class="text-left"></td>
							<td class="text-right">1</td>
							<td class="text-right"><?php echo $voucher['amount']; ?></td>
							<td class="text-right"><?php echo $voucher['amount']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
                <tfoot>
					<?php foreach ($totals as $total) { ?>
						<tr>
							<td <? if ($need_select_location) { ?>colspan="2"<? } ?> class="text-right"></td>
							<td colspan="4" class="text-right"><?php echo $total['title']; ?>:</td>
							<td class="text-right"><?php echo $total['text']; ?></td>
						</tr>
					<?php } ?>
				</tfoot>
			</table>
		</div>
		<? if ($payment) { ?>
			<div id="payment-confirm-button" class="hidden payment-<?php echo SoUtils::getProperty($session_data, 'payment_method.code'); ?>">
				<h2 class="secondary-title"><i class="fa fa-credit-card"></i><?php echo $text_payment_detail?></h2>
				<?php echo $payment; ?>
			</div>
		<? } ?>
	</div>
</div>

