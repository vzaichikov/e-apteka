<div class="simplecheckout-block" id="simplecheckout_payment" <?php echo $hide ? 'data-hide="true"' : '' ?> <?php echo $display_error && $has_error ? 'data-error="true"' : '' ?>>
    <?php if ($display_header) { ?>
        <div class="checkout-heading panel-heading"><i class="fa fa-credit-card"></i> <?php echo $text_checkout_payment_method ?></div>
	<?php } ?>
    <div class="alert alert-danger simplecheckout-warning-block" <?php echo $display_error && $has_error_payment ? '' : 'style="display:none"' ?>><?php echo $error_payment ?></div>
    <div class="simplecheckout-block-content">
		
		<?php /* if ($no_payment) { ?>
			<div class="alert alert-warning"><?php echo $text_no_payment; ?></div>
		<?php } */ ?>				
        <?php if (!empty($payment_methods)) { ?>
            <?php if ($display_type == 2 ) { ?>
                <?php $current_method = false; ?>
                <select data-onchange="reloadAll" name="payment_method">
                    <?php foreach ($payment_methods as $payment_method) { ?>
                        <option value="<?php echo $payment_method['code']; ?>" <?php echo !empty($payment_method['dummy']) ? 'disabled="disabled"' : '' ?> <?php echo !empty($payment_method['dummy']) ? 'data-dummy="true"' : '' ?> <?php if ($payment_method['code'] == $code) { ?>selected="selected"<?php } ?>><?php echo $payment_method['title']; ?></option>
                        <?php if ($payment_method['code'] == $code) { $current_method = $payment_method; } ?>
					<?php } ?>
				</select>
                <?php if ($current_method) { ?>
                    <?php if (!empty($current_method['description'])) { ?>
                        <div class="simplecheckout-methods-description"><?php echo $current_method['description']; ?></div>
					<?php } ?>
                    <?php if (!empty($rows)) { ?>
                        <?php foreach ($rows as $row) { ?>
							<?php echo $row ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				<?php } else { ?>
                <?php foreach ($payment_methods as $payment_method) { ?>
                    <div class="radio">
						<div class="el-radio">
							<input type="radio" data-onchange="reloadPaymentAndAll" name="payment_method" value="<?php echo $payment_method['code']; ?>" <?php echo !empty($payment_method['dummy']) ? 'disabled="disabled"' : '' ?> <?php echo !empty($payment_method['dummy']) ? 'data-dummy="true"' : '' ?> id="<?php echo $payment_method['code']; ?>" <?php if ($payment_method['code'] == $code) { ?>checked="checked"<?php } ?> />					
							<label class="el-radio-style" for="<?php echo $payment_method['code']; ?>">
								<span><?php echo $payment_method['title']; ?>
									<?php if (isset($payment_method['terms'])) { ?>
										<?php echo $payment_method['terms']; ?>
									<?php } ?>
									</span>
								</label>
							</div>
						</div>

						<?php if (!empty($payment_method['description']) && (!$display_for_selected || ($display_for_selected && $payment_method['code'] == $code))) { ?>
								<small class="text-info"><?php echo $payment_method['description']; ?></i></small>
						<?php } ?>

						<?php if (!empty($payment_method['text_danger']) && (!$display_for_selected || ($display_for_selected && $payment_method['code'] == $code))) { ?>
								<small class="text-danger"><?php echo $payment_method['text_danger']; ?></i></small>
						<?php } ?>

						<?php if ($payment_method['code'] == $code && !empty($rows)) { ?>
							<?php foreach ($rows as $row) { ?>
								<?php echo $row ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				<input type="hidden" name="payment_method_current" value="<?php echo $code ?>" />
				<input type="hidden" name="payment_method_checked" value="<?php echo $checked_code ?>" />
			<?php } ?>
			<?php if (empty($payment_methods) && $address_empty && $display_address_empty) { ?>
				<div class="simplecheckout-warning-text"><?php echo $text_payment_address; ?></div>
			<?php } ?>
			<?php if (empty($payment_methods) && !$address_empty) { ?>
				<div class="simplecheckout-warning-text"><?php echo $error_no_payment; ?></div>
			<?php } ?>
		</div>
	</div>		