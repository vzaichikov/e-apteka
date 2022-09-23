<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
    	<div class="container-fluid">
			<div class="row">
				<ul class="breadcrumb">
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
			<br>
			<h1><i class="fa fa-truck"></i> <?php echo $heading_title; ?> v. <?php echo $v; ?></h1>
			<div class="pull-right">
				<a id="button-save" class="btn btn-primary" role="button"><?php echo $button_save_cn; ?></a>
				<a href="<?php echo $cn_list; ?>" data-toggle="tooltip" title="<?php echo $button_cn_list; ?>" class="btn btn-default" role="button"><i class="fa fa-list-ul"></i></a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-danger" role="button"><i class="fa fa-reply"></i></a>
			</div>
    	</div>
  	</div>
  	<div class="container-fluid">
  	<?php if (!empty($error_warning)) { ?>
  		<?php foreach ($error_warning as $error) { ?>
    	<div class="alert alert-danger">
    		<i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
      		<button type="button" class="close" data-dismiss="alert">&times;</button>
    	</div>
    	<?php } ?>
    <?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title" style="padding-top: 5px;"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo $text_form; ?></h3>
				<div class="btn-group pull-right" data-toggle="buttons">
					<?php if ($method == 'EXPRESS') { ?>
					<label class="btn btn-warning btn-sm active" data-toggle="tooltip" title="<?php echo $button_express; ?>"><input type="radio" name="method" value="EXPRESS" id="input-method-e" checked>E</label>
					<label class="btn btn-warning btn-sm" data-toggle="tooltip" title="<?php echo $button_standard; ?>"><input type="radio" name="method" value="STANDARD" id="input-method-s">S</label>
					<?php } else { ?>
					<label class="btn btn-warning btn-sm" data-toggle="tooltip" title="<?php echo $button_express; ?>"><input type="radio" name="method" value="EXPRESS" id="input-method-e">E</label>
					<label class="btn btn-warning btn-sm active" data-toggle="tooltip" title="<?php echo $button_standard; ?>"><input type="radio" name="method" value="STANDARD" id="input-method-s" checked>S</label>
					<?php } ?>
				</div>
			</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading clearfix" style="padding-top: 5px; padding-bottom: 5px;">
									<h3 class="panel-title" style="padding-top: 5px;"><?php echo $text_sender; ?></h3>
									<div class="btn-group pull-right" data-toggle="buttons">
										<?php if ($sender_address_pick_up) { ?>
										<label class="btn btn-default btn-sm active" data-toggle="tooltip" title="<?php echo $button_address_pick_up; ?>"><input type="checkbox" name="sender_address_pick_up" id="input-sender_address_pick_up" value="1" checked><i class="fa fa-home" aria-hidden="true"></i></label>
										<?php } else { ?>
										<label class="btn btn-default btn-sm" data-toggle="tooltip" title="<?php echo $button_address_pick_up; ?>"><input type="checkbox" name="sender_address_pick_up" id="input-sender_address_pick_up" value="1"><i class="fa fa-home" aria-hidden="true"></i></label>
										<?php } ?>
									</div>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_type"><?php echo $entry_client_type; ?></label>
										<div class="col-sm-9">
											<select name="sender_type" id="input-sender_type" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($client_types as $v) { ?>
												<?php if ($v['id'] == $sender_type) { ?>
												<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_name"><?php echo $entry_sender; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_name" value="<?php echo $sender_name; ?>" placeholder="<?php echo $entry_sender; ?>" id="input-sender_name" class="form-control" />
											<input type="hidden" name="sender" value="<?php echo $sender; ?>" id="input-sender" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_tin"><?php echo $entry_tin; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_tin" value="<?php echo $sender_tin; ?>" placeholder="<?php echo $entry_tin; ?>" id="input-sender_tin" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_edrpou"><?php echo $entry_edrpou; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_edrpou" value="<?php echo $sender_edrpou; ?>" placeholder="<?php echo $entry_edrpou; ?>" id="input-sender_edrpou" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_bank_code"><?php echo $entry_bank_code; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_bank_code" value="<?php echo $sender_bank_code; ?>" placeholder="<?php echo $entry_bank_code; ?>" id="input-sender_bank_code" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_bank_account"><?php echo $entry_bank_account; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_bank_account" value="<?php echo $sender_bank_account; ?>" placeholder="<?php echo $entry_bank_account; ?>" id="input-sender_bank_account" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_email"><?php echo $entry_email; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_email" value="<?php echo $sender_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-sender_email" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_phone"><?php echo $entry_phone; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="sender_phone" value="<?php echo $sender_phone; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-sender_phone" class="form-control" />
												<span class="input-group-btn">
													<button type="button" id="button-sender_search" data-toggle="tooltip" title="<?php echo $button_search; ?>" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_region"><?php echo $entry_region; ?></label>
										<div class="col-sm-9">
											<select name="sender_region" id="input-sender_region" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($zones as $v) { ?>
												<?php if ($v['zone_id'] == $sender_region) { ?>
												<option value="<?php echo $v['zone_id']; ?>" selected="selected"><?php echo $v['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['zone_id']; ?>"><?php echo $v['name']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_city"><?php echo $entry_city; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_city" value="<?php echo $sender_city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-sender_city" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_street"><?php echo $entry_street; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_street" value="<?php echo $sender_street; ?>" placeholder="<?php echo $entry_street; ?>" id="input-sender_street" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_house"><?php echo $entry_house; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_house" value="<?php echo $sender_house; ?>" placeholder="<?php echo $entry_house; ?>" id="input-sender_house" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_flat"><?php echo $entry_flat; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_flat" value="<?php echo $sender_flat; ?>" placeholder="<?php echo $entry_flat; ?>" id="input-sender_flat" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_postcode"><?php echo $entry_postcode; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_postcode" value="<?php echo $sender_postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-sender_postcode" class="form-control" />
											<input type="hidden" name="sender_address" value="<?php echo $sender_address; ?>" id="input-sender_address" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading clearfix" style="padding-top: 5px; padding-bottom: 5px;">
									<h3 class="panel-title" style="padding-top: 5px;"><?php echo $text_recipient; ?></h3>
									<div class="btn-group pull-right" data-toggle="buttons">
										<?php if ($recipient_service_type == 'W') { ?>
										<label class="btn btn-default btn-sm active" data-toggle="tooltip" title="<?php echo $button_warehouse_delivery; ?>"><input type="radio" name="recipient_service_type" value="W" id="input-recipient_service_type" checked><i class="fa fa-map-marker" aria-hidden="true"></i></label>
										<label class="btn btn-default btn-sm" data-toggle="tooltip" title="<?php echo $button_doors_delivery; ?>"><input type="radio" name="recipient_service_type" value="D" id="input-recipient_service_type"><i class="fa fa-home" aria-hidden="true"></i></label>
										<?php } else { ?>
										<label class="btn btn-default btn-sm" data-toggle="tooltip" title="<?php echo $button_warehouse_delivery; ?>"><input type="radio" name="recipient_service_type" value="W" id="input-recipient_service_type"><i class="fa fa-map-marker" aria-hidden="true"></i></label>
										<label class="btn btn-default btn-sm active" data-toggle="tooltip" title="<?php echo $button_doors_delivery; ?>"><input type="radio" name="recipient_service_type" value="D" id="input-recipient_service_type" checked><i class="fa fa-home" aria-hidden="true"></i></label>
										<?php } ?>
									</div>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_type"><?php echo $entry_client_type; ?></label>
										<div class="col-sm-9">
											<select name="recipient_type" id="input-recipient_type" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($client_types as $v) { ?>
												<?php if ($v['id'] == $recipient_type) { ?>
												<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_name"><?php echo $entry_recipient; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_name" value="<?php echo $recipient_name; ?>" placeholder="<?php echo $entry_recipient; ?>" id="input-recipient_name" class="form-control" />
											<input type="hidden" name="recipient" value="<?php echo $recipient; ?>" id="input-recipient" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_tin"><?php echo $entry_tin; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_tin" value="<?php echo $recipient_tin; ?>" placeholder="<?php echo $entry_tin; ?>" id="input-recipient_tin" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_edrpou"><?php echo $entry_edrpou; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_edrpou" value="<?php echo $recipient_edrpou; ?>" placeholder="<?php echo $entry_edrpou; ?>" id="input-recipient_edrpou" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_phone"><?php echo $entry_phone; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="recipient_phone" value="<?php echo $recipient_phone; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-recipient_phone" class="form-control" />
												<span class="input-group-btn">
													<button type="button" id="button-recipient_search" data-toggle="tooltip" title="<?php echo $button_search; ?>" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_region"><?php echo $entry_region; ?></label>
										<div class="col-sm-9">
											<select name="recipient_region" id="input-recipient_region" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($zones as $v) { ?>
												<?php if ($v['zone_id'] == $recipient_region) { ?>
												<option value="<?php echo $v['zone_id']; ?>" selected="selected"><?php echo $v['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['zone_id']; ?>"><?php echo $v['name']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_city"><?php echo $entry_city; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_city" value="<?php echo $recipient_city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-recipient_city" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_street"><?php echo $entry_street; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_street" value="<?php echo $recipient_street; ?>" placeholder="<?php echo $entry_street; ?>" id="input-recipient_street" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_house"><?php echo $entry_house; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_house" value="<?php echo $recipient_house; ?>" placeholder="<?php echo $entry_house; ?>" id="input-recipient_house" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_flat"><?php echo $entry_flat; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_flat" value="<?php echo $recipient_flat; ?>" placeholder="<?php echo $entry_flat; ?>" id="input-recipient_flat" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_postcode"><?php echo $entry_postcode; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_postcode" value="<?php echo $recipient_postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-recipient_postcode" class="form-control" />
											<input type="hidden" name="recipient_address" value="<?php echo $recipient_address_id; ?>" id="input-recipient_address" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading clearfix" style="padding-top: 5px; padding-bottom: 5px;">
									<h3 class="panel-title" style="padding-top: 5px;"><?php echo $text_departure_options; ?></h3>
									<div class="pull-right">
										<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="<?php echo $button_add_seat; ?>" id="button-add-seat" onclick="addSeat();"><i class="fa fa-plus" aria-hidden="true"></i></button>
										<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="<?php echo $button_delete_seat; ?>" id="button-delete-seat" onclick="deleteSeat();"<?php echo ($seats_amount < 2) ? ' style="display: none;"' : '' ?>><i class="fa fa-minus" aria-hidden="true"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<?php for ($i = 0; $i < $seats_amount; $i++) { ?>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-weight-<?php echo $i; ?>"><?php echo $entry_weight; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="parcels[<?php echo $i; ?>][weight]" value="<?php echo (isset($parcels[$i])) ? $parcels[$i]['weight'] : 0; ?>" placeholder="<?php echo $entry_weight; ?>" id="input-weight-<?php echo $i; ?>" class="form-control" />
												<span class="input-group-addon"><?php echo $text_g; ?></span>
											</div>
                                            <input type="hidden" name="parcels[<?php echo $i; ?>][uuid]" value="<?php echo (isset($parcels[$i], $parcels[$i]['uuid'])) ? $parcels[$i]['uuid'] : ''; ?>" id="input-uuid-<?php echo $i; ?>" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-width-<?php echo $i; ?>"><?php echo $entry_width; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="parcels[<?php echo $i; ?>][width]" value="<?php echo (isset($parcels[$i])) ? $parcels[$i]['width'] : 0; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width-<?php echo $i; ?>" class="form-control" />
												<span class="input-group-addon"><?php echo $text_cm; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-length-<?php echo $i; ?>"><?php echo $entry_length; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="parcels[<?php echo $i; ?>][length]" value="<?php echo (isset($parcels[$i])) ? $parcels[$i]['length'] : 0; ?>" placeholder="<?php echo $entry_length; ?>" id="input-length-<?php echo $i; ?>" class="form-control" />
												<span class="input-group-addon"><?php echo $text_cm; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-height-<?php echo $i; ?>"><?php echo $entry_height; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="parcels[<?php echo $i; ?>][height]" value="<?php echo (isset($parcels[$i])) ? $parcels[$i]['height'] : 0; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height-<?php echo $i; ?>" class="form-control" />
												<span class="input-group-addon"><?php echo $text_cm; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-announced_price-<?php echo $i; ?>"><?php echo $entry_announced_price; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-btn">
													<button type="button" id="button-components_list-<?php echo $i; ?>" onclick="$('#input-announced_price_id').val('<?php echo $i; ?>');" data-toggle="modal" data-target="#modal-totals-list" data-tooltip="true" title="<?php echo $button_components_list; ?>" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i></button>
												</span>
												<input type="text" name="parcels[<?php echo $i; ?>][announced_price]" value="<?php echo (isset($parcels[$i])) ? $parcels[$i]['announced_price'] : 0; ?>" placeholder="<?php echo $entry_announced_price; ?>" id="input-announced_price-<?php echo $i; ?>" class="form-control" />
												<span class="input-group-addon"><?php echo $text_grn; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-departure_description-<?php echo $i; ?>"><?php echo $entry_departure_description; ?></label>
										<div class="col-sm-9">
											<textarea name="parcels[<?php echo $i; ?>][departure_description]" rows="2" id="input-departure_description-<?php echo $i; ?>" maxlength="40" class="form-control"><?php echo (isset($parcels[$i])) ? $parcels[$i]['departure_description'] : ''; ?></textarea>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo $text_payment; ?></h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-payer"><?php echo $entry_payer; ?></label>
										<div class="col-sm-9">
											<select name="payer" id="input-payer" class="form-control">
												<option value="0"><?php echo $text_select; ?></option>
												<?php foreach ($references['payer_types'] as $payer_type) { ?>
												<?php if ($payer_type['id'] == $payer) { ?>
												<option value="<?php echo $payer_type['id']; ?>" selected="selected"><?php echo $payer_type['description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $payer_type['id']; ?>"><?php echo $payer_type['description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-backward_delivery_total"><?php echo $entry_backward_delivery_total; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="backward_delivery_total" value="<?php echo $backward_delivery_total; ?>" placeholder="<?php echo $entry_backward_delivery_total; ?>" id="input-backward_delivery_total" class="form-control" />
												<span class="input-group-addon"><?php echo $text_grn; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-backward_delivery_payer"><?php echo $entry_backward_delivery_payer; ?></label>
										<div class="col-sm-9">
											<select name="backward_delivery_payer" id="input-backward_delivery_payer" class="form-control">
												<option value="0"><?php echo $text_select; ?></option>
												<?php foreach ($references['backward_delivery_payers'] as $v) { ?>
												<?php if ($v['id'] == $backward_delivery_payer) { ?>
												<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-money_transfer_method"><?php echo $entry_money_transfer_method; ?></label>
										<div class="col-sm-9">
											<select name="money_transfer_method" id="input-money_transfer_method" class="form-control">
												<option value="0"><?php echo $text_select; ?></option>
												<?php foreach ($money_transfer_methods as $k => $v) { ?>
												<?php if ($k == $money_transfer_method) { ?>
												<option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option>
												<?php } else { ?>
												<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo $text_additionally; ?></h3>
								</div>
								<div class="panel-body">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-recommended_letter"><?php echo $entry_recommended_letter; ?></label>
											<div class="col-sm-9">
												<label class="radio-inline">
													<?php if ($recommended_letter) { ?>
													<input type="checkbox" name="recommended_letter" id="input-recommended_letter" class="form-control" checked>
													<?php } else { ?>
													<input type="checkbox" name="recommended_letter" id="input-recommended_letter" class="form-control">
													<?php } ?>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-check_on_delivery"><?php echo $entry_check_on_delivery; ?></label>
											<div class="col-sm-9">
												<label class="radio-inline">
													<?php if ($check_on_delivery) { ?>
													<input type="checkbox" name="check_on_delivery" id="input-check_on_delivery" class="form-control" checked>
													<?php } else { ?>
													<input type="checkbox" name="check_on_delivery" id="input-check_on_delivery" class="form-control">
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-sms_message"><?php echo $entry_sms_message; ?></label>
											<div class="col-sm-9">
												<label class="radio-inline">
													<?php if ($sms_message) { ?>
													<input type="checkbox" name="sms_message" id="input-sms_message" class="form-control" checked>
													<?php } else { ?>
													<input type="checkbox" name="sms_message" id="input-sms_message" class="form-control">
													<?php } ?>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-on_fail_receive"><?php echo $entry_on_fail_receive; ?></label>
											<div class="col-sm-9">
												<select name="on_fail_receive" id="input-on_fail_receive" class="form-control">
													<option value="0"><?php echo $text_select; ?></option>
													<?php foreach ($fail_receive_types as $v) { ?>
													<?php if ($v['id'] == $on_fail_receive) { ?>
													<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Modal of totals list START -->
					<div class="modal fade" id="modal-totals-list" tabindex="-1" role="dialog" aria-labelledby="totals-list-label">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="totals-list-label"><?php echo $heading_components_list; ?></h4>
								</div>
								<div class="modal-body">
									<input type="hidden" name="announced_price_id" value="" id="input-announced_price_id">
									<div class="table-responsive">
										<table class="table table-striped" id="table-totals_list">
											<thead>
												<tr>
													<td><?php echo $column_description; ?></td>
													<td class="text-center"><?php echo $column_price; ?></td>
													<td class="text-center"><?php echo $column_action; ?></td>
												</tr>
											</thead>
											<tbody>
											<?php foreach ($totals as $i => $total) { ?>
												<tr>
													<td><?php echo $total['title']; ?></td>
													<td class="text-center"><?php echo $total['price']; ?> <?php echo $text_grn; ?></td>
													<td class="text-center">
														<?php if ($total['status']) { ?>
														<button type="button" class="btn btn-danger btn-xs" id="button-total_announced_price_minus"><i class="fa fa-minus"></i></button>
														<?php } else { ?>
														<button type="button" class="btn btn-success btn-xs" id="button-total_announced_price_plus"><i class="fa fa-plus"></i></button>
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
											</tbody>
											<tfoot>
												<tr>
													<td><strong><?php echo $text_announced_price; ?></strong></td>
													<td class="text-center" id="td-announced_price_total"><strong><?php echo (isset($parcels[$i])) ? $parcels[$i]['announced_price'] : 0; ?> <?php echo $text_grn; ?></strong></td>
													<td></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" onclick="saveAnnouncedPrice();" class="btn btn-primary"><i class="fa fa-check"></i></button>
									<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal of totals list END -->

				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	function validateForm(element) {
		var post_data = element.name + '=' + encodeURIComponent(element.value);

		if (element.name == 'backward_delivery_payer') {
			post_data += '&backward_delivery_total=' + encodeURIComponent($('#input-backward_delivery_total').val());
		}

		$.ajax( {
			url: 'index.php?route=extension/shipping/ukrposhta/getCNForm&token=<?php echo $token; ?>',
			type: 'POST',
			data: post_data,
			dataType: 'json',
			success: function(json) {
				checkErrors(json);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(textStatus);
			 }
		} );
	}

	function checkErrors(array) {
		if (array['warning']) {
			if (array['warning'] instanceof Array || array['warning'] instanceof Object) {
				for(var w in array['warning']) {
					$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + array['warning'][w] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			} else {
				$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + array['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		}

		for (var field in array['errors']) {
			$('div.form-group').has('label[for="input-' + field + '"]').removeClass('has-success').addClass('has-error');
			$('#span-' + field).remove('.help-block');
			$('div.form-group > div[class^="col-sm"]').has('#input-' + field).append('<span id="span-' + field + '" class="help-block">' + array['errors'][field] + '</span>');
		}

        for (var field in array['success']) {
            $('div.form-group').has('label[for="input-' + field + '"]').removeClass('has-error').addClass('has-success');
            $('#span-' + field).remove('.help-block');
        }

        if (array['errors'] && array['errors']['parcels']) {
            for (var i in array['errors']['parcels']) {
                for (var field in array['errors']['parcels'][i]) {
                    $('div.form-group').has('label[for="input-' + field + '-' + i + '"]').removeClass('has-success').addClass('has-error');
                    $('#span-' + field + '-' + i).remove('.help-block');
                    $('div.form-group > div[class^="col-sm"]').has('#input-' + field + '-' + i).append('<span id="span-' + field + '-' + i + '" class="help-block">' + array['errors']['parcels'][i][field] + '</span>');
                }
            }
        }

        if (array['success'] && array['success']['parcels']) {
            for (var i in array['success']['parcels']) {
                for (var field in array['success']['parcels'][i]) {
                    $('div.form-group').has('label[for="input-' + field + '-' + i + '"]').removeClass('has-error').addClass('has-success');
                    $('#span-' + field + '-' + i).remove('.help-block');
                }
            }
        }
	}

	function addSeat() {
		var
			html = '',
			count = $('input[id^="input-weight"]').length;

			if (count < 2) {
				$('#button-delete-seat').fadeIn();
			}

		html += '<div class="form-group"><label class="col-sm-3 control-label" for="input-weight-' + count + '"><?php echo $entry_weight; ?></label><div class="col-sm-9"><div class="input-group"><input type="text" name="parcels[' + count + '][weight]" value="0" placeholder="<?php echo $entry_weight; ?>" id="input-weight-' + count + '" class="form-control" /><span class="input-group-addon"><?php echo $text_g; ?></span></div></div></div>';
		html += '<div class="form-group"><label class="col-sm-3 control-label" for="input-width-' + count + '"><?php echo $entry_width; ?></label><div class="col-sm-9"><div class="input-group"><input type="text" name="parcels[' + count + '][width]" value="0" placeholder="<?php echo $entry_width; ?>" id="input-width-' + count + '" class="form-control" /><span class="input-group-addon"><?php echo $text_cm; ?></span></div></div></div>';
		html += '<div class="form-group"><label class="col-sm-3 control-label" for="input-length-' + count + '"><?php echo $entry_length; ?></label><div class="col-sm-9"><div class="input-group"><input type="text" name="parcels[' + count + '][length]" value="0" placeholder="<?php echo $entry_length; ?>" id="input-length-' + count + '" class="form-control" /><span class="input-group-addon"><?php echo $text_cm; ?></span></div></div></div>';
		html += '<div class="form-group"><label class="col-sm-3 control-label" for="input-height-' + count + '"><?php echo $entry_height; ?></label><div class="col-sm-9"><div class="input-group"><input type="text" name="parcels[' + count + '][height]" value="0" placeholder="<?php echo $entry_height; ?>" id="input-height-' + count + '" class="form-control" /><span class="input-group-addon"><?php echo $text_cm; ?></span></div></div></div>';
		html += '<div class="form-group"><label class="col-sm-3 control-label" for="input-announced_price-' + count + '"><?php echo $entry_announced_price; ?></label><div class="col-sm-9"><div class="input-group"><span class="input-group-btn"><button type="button" id="button-components_list-' + count + '" onclick="$(\'#input-announced_price_id\').val(' + count + ');" data-toggle="modal" data-target="#modal-totals-list" data-tooltip="true" title="<?php echo $button_components_list; ?>" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i></button></span><input type="text" name="parcels[' + count + '][announced_price]" value="0" placeholder="<?php echo $entry_announced_price; ?>" id="input-announced_price-' + count + '" class="form-control" /><span class="input-group-addon"><?php echo $text_grn; ?></span></div></div></div>';
		html += '<div class="form-group"><label class="col-sm-3 control-label" for="input-departure_description-' + count + '"><?php echo $entry_departure_description; ?></label><div class="col-sm-9"><textarea name="parcels[' + count + '][departure_description]" rows="2" id="input-departure_description-' + count + '" maxlength="40" class="form-control"></textarea></div></div>';

		$('textarea[id^="input-departure_description"]:last').parents('div.form-group').after(html);
	}

    function deleteSeat() {
        var count = $('input[id^="input-weight"]').length;

        if (count == 2) {
            $('#button-delete-seat').fadeOut();
        }

        $('input[id^="input-weight-"]:last').parents('div.form-group').remove();
        $('input[id^="input-width-"]:last').parents('div.form-group').remove();
        $('input[id^="input-length-"]:last').parents('div.form-group').remove();
        $('input[id^="input-height-"]:last').parents('div.form-group').remove();
        $('input[id^="input-announced_price-"]:last').parents('div.form-group').remove();
        $('textarea[id^="input-departure_description-"]:last').parents('div.form-group').remove();
    }

	function saveAnnouncedPrice() {
	    var id = $('#input-announced_price_id').val();

		$('#input-announced_price-' + id).val(parseInt($('#td-announced_price_total')[0].outerText));

		$('#modal-totals-list').modal('hide');
	}

	function formHandler(element) {
		switch(element.id) {
            case 'input-sender_type':
                if (element.value == 'COMPANY') {
                    $('#input-sender_tin').parents('div.form-group').fadeOut();
                    $('#input-sender_edrpou, #input-sender_bank_code, #input-sender_bank_account').parents('div.form-group').fadeIn();
                } else if (element.value == 'PRIVATE_ENTREPRENEUR') {
                    $('#input-sender_edrpou').parents('div.form-group').fadeOut();
                    $('#input-sender_tin, #input-sender_bank_code, #input-sender_bank_account').parents('div.form-group').fadeIn();
                } else {
                    $('#input-sender_edrpou, #input-sender_bank_code, #input-sender_bank_account').parents('div.form-group').fadeOut();
                    $('#input-sender_tin').parents('div.form-group').fadeIn();
                }

                break;

			case 'input-sender_name':
                if (!$('#input-sender_name').val()) {
                    $('#input-sender').val('');
                }

				break;

            case 'input-sender_region':
            case 'input-sender_city':
            case 'input-sender_street':
            case 'input-sender_house':
            case 'input-sender_flat':
            case 'input-sender_postcode':
                $('#input-sender_address').val('');

                break;

            case 'input-recipient_type':
                if (element.value == 'COMPANY') {
                    $('#input-recipient_tin').parents('div.form-group').fadeOut();
                    $('#input-recipient_edrpou').parents('div.form-group').fadeIn();
                } else if (element.value == 'PRIVATE_ENTREPRENEUR') {
                    $('#input-recipient_edrpou').parents('div.form-group').fadeOut();
                    $('#input-recipient_tin').parents('div.form-group').fadeIn();
                } else {
                    $('#input-recipient_tin, #input-recipient_edrpou').parents('div.form-group').fadeOut();
                }

                break;

            case 'input-recipient_name':
                if (!$('#input-recipient_name').val()) {
                    $('#input-recipient').val('');
                }

                break;

            case 'input-recipient_region':
            case 'input-recipient_city':
            case 'input-recipient_street':
            case 'input-recipient_house':
            case 'input-recipient_flat':
            case 'input-recipient_postcode':
                $('#input-recipient_address').val('');

                break;

			case 'input-backward_delivery_total':
				if (+element.value) {
					$('#input-backward_delivery_payer').trigger('change').parents('div.form-group').fadeIn();
				} else {
                    $('#input-backward_delivery_payer').trigger('change').parents('div.form-group').fadeOut();
				}

				break;

            case 'input-backward_delivery_payer':
                if (element.value == 'recipient' && $('#input-backward_delivery_total').val()) {
                    $('#input-money_transfer_method').parents('div.form-group').fadeIn();
                } else {
                    $('#input-money_transfer_method').parents('div.form-group').fadeOut();
                }

                break;
		}
	}

	$( function () {
		$('[data-tooltip=true]').tooltip();

		$('.date').datetimepicker( {pickTime: false} ).on('change', function () {
			var input = $(this).find('input')[0];

			formHandler(input);
			validateForm(input);
		} );

		$('form').on('change', 'input, select, textarea', function() {
			setTimeout(formHandler, 100, this);
			setTimeout(validateForm, 200, this);
		} );

		$('#input-sender_type, #input-recipient_type, #input-backward_delivery_total').each(function() {
			formHandler(this);
		} );

		// Change totals list
		$('#modal-totals-list').on('click', '#button-total_announced_price_minus, #button-total_announced_price_plus', function (e) {
			var b = $(e.currentTarget),
				cost = parseInt(b.parents('tr').find('td:eq(1)').text()),
				total = $('#td-announced_price_total')[0].outerText;

			if (e.currentTarget.id == 'button-total_announced_price_minus') {
				b.replaceWith('<button type="button" class="btn btn-success btn-xs" id="button-total_announced_price_plus"><i class="fa fa-plus"></i></button>');

				total = total.replace(/-?\d+/, parseInt(total) - cost);
			} else {
				b.replaceWith('<button type="button" class="btn btn-danger btn-xs" id="button-total_announced_price_minus"><i class="fa fa-minus"></i></button>');

				total = total.replace(/-?\d+/, parseInt(total) + cost);
			}

			$('#td-announced_price_total').html('<strong>' + total + '</strong>');
		} );

		$('#button-sender_search').on('click', function(e) {
			var $button = $(e.currentTarget);

			$.ajax( {
				url: 'index.php?route=extension/shipping/ukrposhta/ukrposhtaData&token=<?php echo $token; ?>',
				type: 'POST',
				data: 'action=getClientByPhone&filter=' + encodeURIComponent($('#input-sender_phone').val()),
				dataType: 'json',
				beforeSend: function() {
					$button.find('i').removeClass().addClass('fa fa-circle-o-notch fa-spin');
				},
				complete: function() {
					var $alerts = $('.alert-danger, .alert-success');

					setTimeout(function() { $alerts.fadeOut(); }, 5000);

					$button.find('i').removeClass().addClass('fa fa-search');
					$('div').removeClass('has-success has-error');
					$('span.help-block').remove();
				},
				success: function (json) {
					if (json['success']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('#input-sender_type').val(json['type']).trigger('change');
						$('#input-sender').val(json['uuid']);
						$('#input-sender_name').val(json['name']);
						$('#input-sender_tin').val(json['tin']);
						$('#input-sender_edrpou').val(json['edrpou']);
						$('#input-sender_bank_code').val(json['bankCode']);
						$('#input-sender_bank_account').val(json['bankAccount']);
						$('#input-sender_email').val(json['email']);
						$('#input-sender_address').val(json['addressId']);
						$('#input-sender_region').val(json['zone_id']);
						$('#input-sender_city').val(json['city']);
						$('#input-sender_street').val(json['street']);
						$('#input-sender_house').val(json['houseNumber']);
						$('#input-sender_flat').val(json['apartmentNumber']);
						$('#input-sender_postcode').val(json['postcode']);
					} else {
						if (json['error']) {
							$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						if (json['warning']) {
							$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
					}
				}
			} );
		} );

		$('#button-recipient_search').on('click', function(e) {
			var $button = $(e.currentTarget);

			$.ajax( {
				url: 'index.php?route=extension/shipping/ukrposhta/ukrposhtaData&token=<?php echo $token; ?>',
				type: 'POST',
				data: 'action=getClientByPhone&filter=' + encodeURIComponent($('#input-recipient_phone').val()),
				dataType: 'json',
				beforeSend: function() {
					$button.find('i').removeClass().addClass('fa fa-circle-o-notch fa-spin');
				},
				complete: function() {
					var $alerts = $('.alert-danger, .alert-success');

					setTimeout(function() { $alerts.fadeOut(); }, 5000);

					$button.find('i').removeClass().addClass('fa fa-search');
					$('div').removeClass('has-success has-error');
					$('span.help-block').remove();
				},
				success: function (json) {
					if (json['success']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('#input-recipient_type').val(json['type']).trigger('change');
						$('#input-recipient').val(json['uuid']);
						$('#input-recipient_name').val(json['name']);
						$('#input-recipient_tin').val(json['tin']);
						$('#input-recipient_edrpou').val(json['edrpou']);
						$('#input-recipient_address').val(json['addressId']);
						$('#input-recipient_region').val(json['zone_id']);
						$('#input-recipient_city').val(json['city']);
						$('#input-recipient_street').val(json['street']);
						$('#input-recipient_house').val(json['houseNumber']);
						$('#input-recipient_flat').val(json['apartmentNumber']);
						$('#input-recipient_postcode').val(json['postcode']);
					} else {
						if (json['error']) {
							$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						if (json['warning']) {
							$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
					}
				}
			} );
		} );

		// Save CN
		$('#button-save').on('click', function () {
			var $post_data = $('input[type="text"], input[type="radio"]:checked, input[type="checkbox"]:checked, select, textarea').filter(':visible').add('input[type="hidden"]');

			$.ajax( {
				url: 'index.php?route=extension/shipping/ukrposhta/saveCN&order_id=<?php echo $order_id; ?>&cn_uuid=<?php echo $cn_uuid; ?>&token=<?php echo $token; ?>',
				type: 'POST',
				data: $post_data,
				dataType: 'json',
				beforeSend: function() {
					$('body').fadeTo('fast', 0.8).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				},
				complete: function(json){
					var $alerts = $('.alert-danger, .alert-success');

					if ($alerts.length !== 0) {
						setTimeout(function() { $alerts.remove() }, 15000);
					}

					if (json['errors'] != 'undefined' || json['warning'] != 'undefined') {
						$('html, body').animate({ scrollTop: $('.has-error, .alert').offset().top }, 1000);
					}

					$('body').fadeTo('fast', 1)
					$('#ocmax-loader').remove();
				},
				success: function(json) {
					if (json['success']) {
						location.href = 'index.php?route=extension/shipping/ukrposhta/getCNList&token=<?php echo $token; ?>';
					} else {
						$('.help-block, .alert').remove();
						$('div').removeClass('has-error has-success');

						checkErrors(json);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(textStatus);
				},
			} );
		} );
	} );
//--></script>
<?php echo $footer; ?>