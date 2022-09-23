<?php if ($setting_so_onepagecheckout_layout_setting['payment_method_status'] == 1) {?>
	<div class="checkout-content checkout-payment-methods">
		<?php if ($error_warning) { ?>
			<div class="alert alert-warning warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			</div>
		<?php } ?>
		<?php if ($payment_methods) {?>
			<h2 class="secondary-title"><i class="fa fa-credit-card"></i><?php echo $text_title_payment_method;?></h2>
			<div class="box-inner">
				<?php foreach ($payment_methods as $payment_method) { ?>
					<?php if (isset($setting_so_onepagecheckout_layout_setting[$payment_method['code'].'_status']) && $setting_so_onepagecheckout_layout_setting[$payment_method['code'].'_status'] == 1) {?>
						<div class="pretty p-default p-round p-thick">		
							<?php if ($payment_method['code'] == $code || !$code || @$setting_so_onepagecheckout_layout_setting['so_onepagecheckout_default_payment'] == $payment_method['code']) { ?>							
								<input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked"/>
								<?php } else { ?>
								<input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>"/>
							<?php } ?>
							<div class="state p-primary-o">
								<label><?php echo $payment_method['title']; ?></label>
							</div>
						</div>
						<?php if (isset($payment_method['terms']) && $payment_method['terms']) { ?>
                            <div class="box-tip">
								<? echo $payment_method['terms']; ?>
							</div>
						<?php } ?>	
					<?php }?>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
<?php }?>