<?php if ($setting_so_onepagecheckout_layout_setting['delivery_method_status'] == 1) {?>
	<div class="checkout-content checkout-shipping-methods">
		<?php if ($error_warning) { ?>
			<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
		<?php } ?>
		<?php if ($shipping_methods) { ?>
			<h2 class="secondary-title"><i class="fa fa-location-arrow"></i><?php echo $text_title_shipping_method;?></h2>
			<div class="box-inner">
				<?php foreach ($shipping_methods as $key=>$shipping_method) { ?>
					<p><strong><?php echo $shipping_method['title']; ?></strong></p>
					<?php if (!$shipping_method['error']) { ?>
						<?php foreach ($shipping_method['quote'] as $quote) { ?>
							<?php $_status = explode('.', $quote['code']);?>
							<?php if (isset($setting_so_onepagecheckout_layout_setting[$_status[0].'_status']) && $setting_so_onepagecheckout_layout_setting[$_status[0].'_status'] == 1) {?>
								<div class="pretty p-default p-round p-thick">
										<?php if ($quote['code'] == $code || !$code || @$setting_so_onepagecheckout_layout_setting['so_onepagecheckout_default_shipping'] == $_status[0]) { ?>
											<input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" checked="checked"/>
											<?php } else { ?>
											<input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>"/>
										<?php } ?>
										<div class="state p-primary-o">
											<label><?php echo $quote['title']; ?></label>
										</div>										
								</div>
								<?php if (isset($quote['terms']) && $quote['terms']) { ?>
									<div class="box-tip">
										<? echo $quote['terms']; ?>
									</div>
								<? } ?>
							<?php }?>
						<?php }?>
						<?php } else { ?>
						<div class="alert alert-danger"><?php echo $shipping_method['error']; ?></div>
					<?php } ?>
				<?php } ?>
			</div>
		<?php }?>
	</div>
<?php }?>