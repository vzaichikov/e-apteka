	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button class="close" type="button" data-dismiss="modal">×</button>
			<h2 id="boc_order_title" class="modal-title text-center"><?php echo $buyoneclick_title; ?></h2>
		</div>
		<div class="modal-body">
			<form id="boc_form" action="" role="form">
				<fieldset>
					<?php if ($buyoneclick_exan_status) { ?>
						<div id="source" style="display:none">
							<input id="sb_first_typ" class="hidden" type="text" name="sb_first_typ" value="">
							<input id="sb_first_src" class="hidden" type="text" name="sb_first_src" value="">
							<input id="sb_first_mdm" class="hidden" type="text" name="sb_first_mdm" value="">
							<input id="sb_first_cmp" class="hidden" type="text" name="sb_first_cmp" value="">
							<input id="sb_first_cnt" class="hidden" type="text" name="sb_first_cnt" value="">
							<input id="sb_first_trm" class="hidden" type="text" name="sb_first_trm" value="">
							
							<input id="sb_current_typ" class="hidden" type="text" name="sb_current_typ" value="">
							<input id="sb_current_src" class="hidden" type="text" name="sb_current_src" value="">
							<input id="sb_current_mdm" class="hidden" type="text" name="sb_current_mdm" value="">
							<input id="sb_current_cmp" class="hidden" type="text" name="sb_current_cmp" value="">
							<input id="sb_current_cnt" class="hidden" type="text" name="sb_current_cnt" value="">
							<input id="sb_current_trm" class="hidden" type="text" name="sb_current_trm" value="">
							
							<input id="sb_first_add_fd" class="hidden" type="text" name="sb_first_add_fd" value="">
							<input id="sb_first_add_ep" class="hidden" type="text" name="sb_first_add_ep" value="">
							<input id="sb_first_add_rf" class="hidden" type="text" name="sb_first_add_rf" value="">
							
							<input id="sb_current_add_fd" class="hidden" type="text" name="sb_current_add_fd" value="">
							<input id="sb_current_add_ep" class="hidden" type="text" name="sb_current_add_ep" value="">
							<input id="sb_current_add_rf" class="hidden" type="text" name="sb_current_add_rf" value="">
							
							<input id="sb_session_pgs" class="hidden" type="text" name="sb_session_pgs" value="">
							<input id="sb_session_cpg" class="hidden" type="text" name="sb_session_cpg" value="">
							
							<input id="sb_udata_vst" class="hidden" type="text" name="sb_udata_vst" value="">
							<input id="sb_udata_uip" class="hidden" type="text" name="sb_udata_uip" value="">
							<input id="sb_udata_uag" class="hidden" type="text" name="sb_udata_uag" value="">
							<input id="sb_promo_code" class="hidden" type="text" name="sb_promo_code" value="">
						</div>
					<?php } ?>
					<div id="boc_product_field" class="col-pd-15 col-mb-10">
						<div class="row boc_product_info">
							<?php if ($product) { ?>
								<div class="col-xs-12 col-sm-3">
									<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
								</div>
								<div class="col-xs-12 col-sm-9 text-left">
									<div class="row" style="width: calc(100% + 30px);">
										<div class="col-xs-12 col-sm-6">
											<div class="caption" style="padding-right:1em; padding-bottom:8px;">
												<p class="h4" style="margin-bottom:0; line-height:1;">
													<?php echo $product['name']; ?><br />
													<small class="product-layout__name__manufacturer text-muted" style="font-size:10px; line-height: 10px;"><?php echo $product['manufacturer']; ?></small>													
												</p>
												<?php if ($product['option']) { ?>
													<div class="product_options">
														<?php foreach ($product['option'] as $option) { ?>
															<small class="label label-info"><?php echo $option['value']; ?></small><br />
															<br />
														<?php } ?>
													</div>
												<?php } ?>
												<?php if (!empty($location)) { ?>
												<small class="text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_reserve2; ?> <?php echo $location['quantity']; ?> шт.</small>
												<?php } ?>
											</div>
										</div>
										<div class="col-xs-12 col-sm-4">
											<input type="hidden" value="<?php echo $product['numeric_price']; ?>" id="product-numeric-price-popup" />

											<div class="form-group" style="margin-bottom: 0px;">
												<div class="input-count">
													<button type="button" class="input-count__btn js-input-count-minus">–</button>
													<input type="text" name="quantity-popup-main" value="<?php echo $product['quantity']; ?>" data-maximum="<?php echo (!empty($location)?$location['quantity']:$product['maximum']); ?>" size="2" id="input-quantity-popup-main" class="input-count__num" />
													<button type="button" class="input-count__btn js-input-count-plus">+</button>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-2">
											<p class="h4" style="padding-top:8px;" id="product-total-popup"><?php echo $product['total']; ?></p>
										</div>
									</div>
								</div>
								<?php } else { ?>
								<div class="col-xs-12">
									<p class="text-center"><?php echo $text_empty; ?></p>
								</div>
							<?php } ?>
						</div>
						
						<?php if (!empty($product['is_preorder'])) { ?>
							<div><small class="text text-danger"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $text_available_on_preorder; ?></small></div>						
						<?php } ?>


						<?php if ($product['no_payment']) { ?>
						<div><small class="text text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_product_no_payment; ?></small></div>
						<?php } ?>
						
						<?php if ($product['no_shipping']) { ?>
						<div><small class="text text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_product_no_shipping; ?></small></div>
						<?php } ?>
                        
                        <?php if ($product['is_receipt']) { ?>
						<div><small class="text text-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_product_is_receipt; ?></small></div>
						<?php } ?>
                        
                        <?php if ($product['is_thermolabel']) { ?>
						<div><small class="text text-info"><i class="fa fa-snowflake-o" aria-hidden="true"></i> <?php echo $text_product_is_thermolabel; ?></small></div>
						<?php } ?>
						
						<?php if ($stock != '') { ?>
							<div class="row">
								<div class="col-xs-12"><div class="text-left text-danger"><i class="fa fa-exclamation-circle"></i> <strong><?php echo $stock; ?></strong></p></div>
							</div>
						<?php } ?>							
					</div>

					<?php if (!empty($location)) { ?>
							<input type="hidden" name="location_id" value="<?php echo $location['location_id']; ?>" />
							<div class="col-pd-15"><small class="text text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_reserve1; ?> <b><?php echo $location['address']; ?></b></small></div>
							<div class="col-pd-15">
							<small class="text text-success">	
								<i class="fa fa-clock-o text-success"></i> <?php echo $text_reserve3; ?> <?php echo $location['open']; ?>
								<?php if ($location['gmaps_link']) { ?>
									&nbsp;&nbsp;<a href="<?php echo $location['gmaps_link']; ?>" target="_blank"><i class="fa fa-map-marker"></i> <?php echo $text_reserve4; ?></a>
								<?php } ?>
							</small>
							</div>
							<div class="col-pd-15"><small class="text text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_reserve5; ?></small></div>
					<?php } ?>

					<div class="clearfix"></div>
					<div class="col-pd-15"><hr /></div>
					<div class="clearfix"></div>
					<div class="col-pd-15">
						<div style="display:none">
							<input id="boc_product_id" type="text" name="boc_product_id">
						</div>
						<?php if ($buyoneclick_field1_status) { ?>
							<div class="col-mb-10 input-group<?php if ($buyoneclick_field1_required) { echo ' has-warning';} ?>">
								<span class="input-group-addon"><i class="fa fa-fw fa-user" aria-hidden="true"></i></span>
								<input id="boc_name" class="form-control<?php if ($buyoneclick_field1_required) { echo ' required';} ?>" type="text" name="boc_name" placeholder="<?php echo $buyoneclick_field1_title; ?>" value="<?php echo (isset($customer_info) && ($customer_info['firstname'] != '' || $customer_info['lastname'] != '')) ? $customer_info['firstname'] . ' ' . $customer_info['lastname'] : ''; ?>" >
							</div>
						<?php } ?>
						<?php if ($buyoneclick_field2_status) { ?>
							<div class="col-mb-10 input-group<?php if ($buyoneclick_field2_required) { echo ' has-warning';} ?>">
								<span class="input-group-addon"><i class="fa fa-fw fa-phone-square" aria-hidden="true"></i></span>
								<input id="boc_phone" class="form-control<?php if ($buyoneclick_field2_required) { echo ' required';} ?>" type="tel" name="boc_phone" placeholder="<?php if ($buyoneclick_validation_type) { echo $buyoneclick_validation_type; } else { echo $buyoneclick_field2_title; } ?>"<?php if ($buyoneclick_validation_type) {echo ' data-pattern="true"';} else {echo ' data-pattern="false"';} ?> value="<?php echo (isset($customer_info) && $customer_info['telephone'] != '') ? $customer_info['telephone'] : ''; ?>" >
							</div>
							<div class="col-mb-10 input-group text-danger" style="display:none;" id="boc_phone_error">
							</div>
						<?php } ?>
						<?php if ($buyoneclick_field3_status) { ?>
							<div class="col-mb-10 input-group<?php if ($buyoneclick_field3_required) { echo ' has-warning';} ?>">
								<span class="input-group-addon"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i></span>
								<input id="boc_email" class="form-control<?php if ($buyoneclick_field3_required) { echo ' required';} ?>" type="email" name="boc_email" placeholder="<?php echo $buyoneclick_field3_title; ?>" value="<?php echo (isset($customer_info) && $customer_info['email'] != '') ? $customer_info['email'] : ''; ?>" >
							</div>
						<?php } ?>
						<?php if ($buyoneclick_field4_status) { ?>
							<div class="col-mb-10 form-group<?php if ($buyoneclick_field4_required) { echo ' has-warning';} ?>">
								<textarea id="boc_message" class="form-control<?php if ($buyoneclick_field4_required) { echo ' required';} ?>" name="boc_message" rows="3" placeholder="<?php echo $buyoneclick_field4_title; ?>" ></textarea>
							</div>
						<?php } ?>
						<?php if ($buyoneclick_agree_status) { ?>
							<div class="col-mb-10 checkbox">
								<label>
									<input id="boc_agree" type="checkbox" name="boc_agree" class="required" value="1"> <?=$buyoneclick_text_agree;?>
								</label>
							</div>
						<?php } ?>
					</div>
					<div class="clearfix"></div>
					<div class="col-pd-15"><hr /></div>
					<div class="clearfix"></div>
					<div id="ecommerce-result"></div>
					<div class="col-pd-15">
						<button type="submit" id="boc_submit" class="btn btn-lg btn-block btn-primary" style="max-width:250px; margin:0 auto;"><?php echo $buyoneclick_button_order; ?></button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$("#boc_phone").inputmask("+38(099)999-99-99");
	});

		$('#input-quantity-popup-main').on('keyup, change', function(){
			let price = $('#product-numeric-price-popup').val();
			let quantity = $('#input-quantity-popup-main').val();

			$('#product-total-popup').load('index.php?route=eapteka/buyoneclick/calculate&q='+quantity+'&p='+price);
		});

		$('#input-quantity-popup-main').on('keyup', function(){
			let maximum = parseInt($(this).attr('data-maximum'));			

			if (maximum && $(this).val() >= maximum){
				$(this).val(maximum);
				$(this).trigger('change');
			}
		});


		$('.input-count').on('click', '.js-input-count-minus', function(e) {
		e.preventDefault;
		
		var value = $(this).siblings('.input-count__num');
		var q = parseInt( value.val() );
		
		if ( q > 1) {
			q = q - 1;
			value.val(q);
			value.trigger('change');
		}
	});
	
	$('.input-count').on('click', '.js-input-count-plus', function(e) {
		e.preventDefault;
		
		var value = $(this).siblings('.input-count__num');
		var maximum = parseInt(value.attr('data-maximum'));
		var q = parseInt( value.val() );
		if (q < maximum){
			q = q + 1;
			value.val(q);
			value.trigger('change');
		}
	});
</script>