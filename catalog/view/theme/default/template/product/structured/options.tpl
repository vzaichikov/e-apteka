<?php if ($options) { ?>
	<div id="option<?php echo $product_id; ?>">
		<hr />
		<?php foreach ($options as $option) { ?>
			<?php if ($option['type'] == 'radio') { ?>
				<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
					<label class="control-label"><?php echo $option['name']; ?></label>
					<div id="input-option<?php echo $option['product_option_id']; ?>">
						<?php foreach ($option['product_option_value'] as $option_value) { ?>
							<div class="radio">
								<label>
									<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />								
									<?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
										(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</label>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>		
		<?php } ?>
	</div>
<?php } ?>