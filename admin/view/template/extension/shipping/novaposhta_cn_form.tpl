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
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo $text_form; ?></h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo $text_sender; ?></h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender"><?php echo $entry_sender; ?></label>
										<div class="col-sm-9">
											<select name="sender" id="input-sender" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($senders as $v) { ?>
												<?php if ($v['Ref'] == $sender) { ?>
												<option value="<?php echo $v['Ref']; ?>" selected="selected"><?php echo $v['Description']; ?><?php echo ($v['CityDescription']) ? ', ' . $v['CityDescription'] : ''; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['Ref']; ?>"><?php echo $v['Description']; ?><?php echo ($v['CityDescription']) ? ', ' . $v['CityDescription'] : ''; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_contact_person"><?php echo $entry_contact_person; ?></label>
										<div class="col-sm-9">
											<select name="sender_contact_person" id="input-sender_contact_person" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($sender_contact_persons as $v) { ?>
												<?php if ($v['Ref'] == $sender_contact_person) { ?>
												<option value="<?php echo $v['Ref']; ?>" selected="selected"><?php echo $v['Description'] . ', ' . $v['Phones']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['Ref']; ?>"><?php echo $v['Description'] . ', ' . $v['Phones']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_contact_person_phone"><?php echo $entry_phone; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_contact_person_phone" value="" placeholder="<?php echo $entry_phone; ?>" id="input-sender_contact_person_phone" class="form-control" readonly />
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
										<label class="col-sm-3 control-label" for="input-sender_city_name"><?php echo $entry_city; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_city_name" value="<?php echo $sender_city_name; ?>" placeholder="<?php echo $text_select; ?>" id="input-sender_city_name" class="form-control" />
											<input type="hidden" name="sender_city" value="<?php echo $sender_city; ?>" id="input-sender_city" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-sender_address_name"><?php echo $entry_address; ?></label>
										<div class="col-sm-9">
											<input type="text" name="sender_address_name" value="<?php echo $sender_address_name; ?>" placeholder="<?php echo $text_select; ?>" id="input-sender_address_name" class="form-control" />
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
										<?php if ($recipient_address_type == 'warehouse') { ?>
										<label class="btn btn-default btn-sm active" data-toggle="tooltip" title="<?php echo $button_warehouse_delivery; ?>"><input type="radio" name="recipient_address_type" value="warehouse" id="input-recipient_address_type" checked><i class="fa fa-map-marker" aria-hidden="true"></i></label>
										<label class="btn btn-default btn-sm" data-toggle="tooltip" title="<?php echo $button_doors_delivery; ?>"><input type="radio" name="recipient_address_type" value="doors" id="input-recipient_address_type"><i class="fa fa-home" aria-hidden="true"></i></label>
										<?php } else { ?>
										<label class="btn btn-default btn-sm" data-toggle="tooltip" title="<?php echo $button_warehouse_delivery; ?>"><input type="radio" name="recipient_address_type" value="warehouse" id="input-recipient_address_type"><i class="fa fa-map-marker" aria-hidden="true"></i></label>
										<label class="btn btn-default btn-sm active" data-toggle="tooltip" title="<?php echo $button_doors_delivery; ?>"><input type="radio" name="recipient_address_type" value="doors" id="input-recipient_address_type" checked><i class="fa fa-home" aria-hidden="true"></i></label>
										<?php } ?>
									</div>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_name"><?php echo $entry_recipient; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_name" value="<?php echo $recipient_name; ?>" placeholder="<?php echo $text_select; ?>" id="input-recipient_name" class="form-control" />
											<input type="hidden" name="recipient" value="<?php echo $recipient; ?>" id="input-recipient" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_contact_person"><?php echo $entry_contact_person; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_contact_person" value="<?php echo $recipient_contact_person; ?>" placeholder="<?php echo $entry_contact_person; ?>" id="input-recipient_contact_person" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_contact_person_phone"><?php echo $entry_phone; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_contact_person_phone" value="<?php echo $recipient_contact_person_phone; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-recipient_contact_person_phone" class="form-control" />
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
											<input type="hidden" name="recipient_region_name" value="<?php echo $recipient_region_name; ?>" id="input-recipient_region_name" />
											<input type="hidden" name="recipient_district_name" value="<?php echo $recipient_district_name; ?>" id="input-recipient_district_name" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_city_name"><?php echo $entry_city; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_city_name" value="<?php echo $recipient_city_name; ?>" placeholder="<?php echo $entry_city; ?>" id="input-recipient_city_name" class="form-control" />
											<input type="hidden" name="recipient_city" value="<?php echo $recipient_city; ?>" id="input-recipient_city" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-recipient_warehouse_name"><?php echo $entry_warehouse; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_warehouse_name" value="<?php echo $recipient_warehouse_name; ?>" placeholder="<?php echo $entry_warehouse; ?>" id="input-recipient_warehouse_name" class="form-control" />
											<input type="hidden" name="recipient_warehouse" value="<?php echo $recipient_warehouse; ?>" id="input-recipient_warehouse" />
										</div>
									</div>
									<div class="form-group" style="display: none">
										<label class="col-sm-3 control-label" for="input-recipient_street_name"><?php echo $entry_street; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_street_name" value="<?php echo $recipient_street_name; ?>" placeholder="<?php echo $entry_street; ?>" id="input-recipient_street_name" class="form-control" />
											<input type="hidden" name="recipient_street" value="<?php echo $recipient_street; ?>" id="input-recipient_street" />
										</div>
									</div>
									<div class="form-group" style="display: none">
										<label class="col-sm-3 control-label" for="input-recipient_house"><?php echo $entry_house; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_house" value="<?php echo $recipient_house; ?>" placeholder="<?php echo $entry_house; ?>" id="input-recipient_house" class="form-control" />
										</div>
									</div>
									<div class="form-group" style="display: none">
										<label class="col-sm-3 control-label" for="input-recipient_flat"><?php echo $entry_flat; ?></label>
										<div class="col-sm-9">
											<input type="text" name="recipient_flat" value="<?php echo $recipient_flat; ?>" placeholder="<?php echo $entry_flat; ?>" id="input-recipient_flat" class="form-control" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo $text_departure_options; ?></h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-departure_type"><?php echo $entry_departure_type; ?></label>
										<div class="col-sm-9">
											<select name="departure_type" id="input-departure_type" class="form-control">
												<?php foreach ($references['cargo_types'] as $cargo_type) { ?>
												<?php if ($cargo_type['Ref'] == $departure) { ?>
												<option value="<?php echo $cargo_type['Ref']; ?>" selected="selected"><?php echo $cargo_type['Description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $cargo_type['Ref']; ?>"><?php echo $cargo_type['Description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-redbox_barcode"><?php echo $entry_redbox_barcode; ?></label>
										<div class="col-sm-9">
											<input type="text" name="redbox_barcode" value="<?php echo $redbox_barcode; ?>" placeholder="<?php echo $entry_redbox_barcode; ?>" id="input-redbox_barcode" class="form-control" />
										</div>
									</div>
									<?php foreach ($references['tires_and_wheels'] as $t_and_w) { ?>
									<div class="form-group" style="display: none;">
										<label class="col-sm-3 control-label" for="input-tires_and_wheels_<?php echo $t_and_w['Ref']; ?>"><?php echo $t_and_w['Description']; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="tires_and_wheels[<?php echo $t_and_w['Ref']; ?>]" value="<?php echo isset($tires_and_wheels[$t_and_w['Ref']]) ? $tires_and_wheels[$t_and_w['Ref']] : ''?>" placeholder="<?php echo $t_and_w['Description']; ?>" id="input-tires_and_wheels_<?php echo $t_and_w['Ref']; ?>" class="form-control" />
												<span class="input-group-addon"><?php echo $text_pc; ?></span>
											</div>
										</div>
									</div>
									<?php } ?>
									<div class="form-group" style="display: none;">
										<label class="col-sm-3 control-label" for="input-width"><?php echo $entry_width; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
												<span class="input-group-addon"><?php echo $text_cm; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group" style="display: none;">
										<label class="col-sm-3 control-label" for="input-length"><?php echo $entry_length; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="length" value="<?php echo $length; ?>" placeholder="<?php echo $entry_length; ?>" id="input-length" class="form-control" />
												<span class="input-group-addon"><?php echo $text_cm; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group" style="display: none;">
										<label class="col-sm-3 control-label" for="input-height"><?php echo $entry_height; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
												<span class="input-group-addon"><?php echo $text_cm; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-weight"><?php echo $entry_weight; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="weight" value="<?php echo $weight; ?>" placeholder="<?php echo $entry_weight; ?>" id="input-weight" class="form-control" />
												<span class="input-group-addon"><?php echo $text_kg; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-volume_general"><?php echo $entry_volume_general; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="volume_general" value="<?php echo $volume_general; ?>" placeholder="<?php echo $entry_volume_general; ?>" id="input-volume_general" class="form-control" />
												<span class="input-group-addon"><?php echo $text_cubic_meter; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-volume_weight"><?php echo $entry_volume_weight; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="volume_weight" value="<?php echo $volume_weight; ?>" placeholder="<?php echo $entry_volume_weight; ?>" id="input-volume_weight" class="form-control" readonly/>
												<span class="input-group-addon"><?php echo $text_kg; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-seats_amount"><?php echo $entry_seats_amount; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-btn">
													<button type="button" id="button-options_seat" data-toggle="modal" data-target="#modal-options-seat" data-tooltip="true" title="<?php echo $button_options_seat; ?>" class="btn btn-default"><i class="fa fa-cubes"></i></button>
												</span>
												<input type="text" name="seats_amount" value="<?php echo $seats_amount; ?>" placeholder="<?php echo $entry_seats_amount; ?>" id="input-seats_amount" class="form-control" />
												<span class="input-group-addon"><?php echo $text_pc; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-announced_price"><?php echo $entry_announced_price; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-btn">
													<button type="button" id="button-components_list" data-toggle="modal" data-target="#modal-totals-list" data-tooltip="true" title="<?php echo $button_components_list; ?>" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i></button>
												</span>
												<input type="text" name="announced_price" value="<?php echo $announced_price; ?>" placeholder="<?php echo $entry_announced_price; ?>" id="input-announced_price" class="form-control" />
												<span class="input-group-addon"><?php echo $text_grn; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-departure_description"><?php echo $entry_departure_description; ?></label>
										<div class="col-sm-9">
											<input type="text" name="departure_description" value="<?php echo $departure_description; ?>" placeholder="<?php echo $entry_departure_description; ?>" id="input-departure_description" class="form-control" />
										</div>
									</div>
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
												<?php if ($payer_type['Ref'] == 'ThirdPerson' && empty($sender_options['CanPayTheThirdPerson'])) { ?>
												<option value="<?php echo $payer_type['Ref']; ?>" disabled><?php echo $payer_type['Description']; ?></option>
												<?php } elseif ($payer_type['Ref'] == $payer) { ?>
												<option value="<?php echo $payer_type['Ref']; ?>" selected="selected"><?php echo $payer_type['Description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $payer_type['Ref']; ?>"><?php echo $payer_type['Description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group" style="display: none">
										<label class="col-sm-3 control-label" for="input-third_person"><?php echo $entry_third_person; ?></label>
										<div class="col-sm-9">
											<select name="third_person" id="input-third_person" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($references['third_persons'] as $v) { ?>
												<?php if ($v['Ref'] == $third_person) { ?>
												<option value="<?php echo $v['Ref']; ?>" selected="selected"><?php echo $v['Description']; ?>, <?php echo $v['CityDescription']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['Ref']; ?>"><?php echo $v['Description']; ?>, <?php echo $v['CityDescription']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-payment_type"><?php echo $entry_payment_type; ?></label>
										<div class="col-sm-9">
											<select name="payment_type" id="input-payment_type" class="form-control">
												<option value="0"><?php echo $text_select; ?></option>
												<?php foreach ($references['payment_types'] as $v) { ?>
												<?php if ($v['Ref'] == $payment_type) { ?>
												<option value="<?php echo $v['Ref']; ?>" selected="selected"><?php echo $v['Description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['Ref']; ?>"><?php echo $v['Description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-backward_delivery"><?php echo $entry_backward_delivery; ?></label>
										<div class="col-sm-9">
											<select name="backward_delivery" id="input-backward_delivery" class="form-control">
												<option value="0"><?php echo $text_select; ?></option>
												<option value="N"<?php echo ($backward_delivery == 'N') ? ' selected="selected"' : ''; ?>><?php echo $text_no_backward_delivery; ?></option>
												<?php foreach ($references['backward_delivery_types'] as $backward_delivery_type) { ?>
												<?php if ($backward_delivery_type['Ref'] == $backward_delivery) { ?>
												<option value="<?php echo $backward_delivery_type['Ref']; ?>" selected="selected"><?php echo $backward_delivery_type['Description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $backward_delivery_type['Ref']; ?>"><?php echo $backward_delivery_type['Description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group" style="display: none">
										<label class="col-sm-3 control-label" for="input-backward_delivery_total"><?php echo $entry_backward_delivery_total; ?></label>
										<div class="col-sm-9">
											<div class="input-group">
												<input type="text" name="backward_delivery_total" value="<?php echo $backward_delivery_total; ?>" placeholder="<?php echo $entry_backward_delivery_total; ?>" id="input-backward_delivery_total" class="form-control" />
												<span class="input-group-addon"><?php echo $text_grn; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group" style="display: none">
										<label class="col-sm-3 control-label" for="input-backward_delivery_payer"><?php echo $entry_backward_delivery_payer; ?></label>
										<div class="col-sm-9">
											<select name="backward_delivery_payer" id="input-backward_delivery_payer" class="form-control">
												<option value="0"><?php echo $text_select; ?></option>
												<?php foreach ($references['backward_delivery_payers'] as $v) { ?>
												<?php if ($v['Ref'] == $backward_delivery_payer) { ?>
												<option value="<?php echo $v['Ref']; ?>" selected="selected"><?php echo $v['Description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['Ref']; ?>"><?php echo $v['Description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group" style="display: none">
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
									<div class="form-group" style="display: none">
										<label class="col-sm-3 control-label" for="input-payment_card"><?php echo $entry_payment_card; ?></label>
										<div class="col-sm-9">
											<select name="payment_card" id="input-payment_card" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($references['payment_cards'] as $v) { ?>
												<?php if ($v['Ref'] == $payment_card) { ?>
												<option value="<?php echo $v['Ref']; ?>" selected="selected"><?php echo $v['Description']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $v['Ref']; ?>"><?php echo $v['Description']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
									<label class="col-sm-3 control-label" for="input-payment_control"><?php echo $entry_payment_control; ?></label>
									<div class="col-sm-9">
										<div class="input-group">
											<input type="text" name="payment_control" value="<?php echo $payment_control; ?>" placeholder="<?php echo $entry_payment_control; ?>" id="input-payment_control" class="form-control" />
											<span class="input-group-addon"><?php echo $text_grn; ?></span>
										</div>
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
											<label class="col-sm-3 control-label" for="input-departure_date"><?php echo $entry_departure_date; ?></label>
											<div class="col-sm-9">
												<div class="input-group date">
													<input type="text" name="departure_date" value="<?php echo $departure_date; ?>" placeholder="<?php echo $entry_departure_date; ?>" data-date-format="DD.MM.YYYY" id="input-departure_date" class="form-control">
													<span class="input-group-btn">
														<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-preferred_delivery_date"><?php echo $entry_preferred_delivery_date; ?></label>
											<div class="col-sm-9">
												<div class="input-group date">
													<input type="text" name="preferred_delivery_date" value="<?php echo $preferred_delivery_date; ?>" placeholder="<?php echo $entry_preferred_delivery_date; ?>" data-date-format="DD.MM.YYYY" id="input-preferred_delivery_date" class="form-control">
													<span class="input-group-btn">
														<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group" style="display: none">
											<label class="col-sm-3 control-label" for="input-time_interval"><?php echo $entry_preferred_delivery_time; ?></label>
											<div class="col-sm-9">
												<select name="time_interval" id="input-time_interval" class="form-control">
													<option value=""><?php echo $text_during_day; ?></option>
													<?php if (isset($time_intervals) && $time_intervals) { ?>
													<?php foreach ($time_intervals as $interval) { ?>
													<?php if ($interval['Number'] == $time_interval) { ?>
													<option value="<?php echo $interval['Number']; ?>" selected="selected"><?php echo $interval['Start'] . ' - ' . $interval['End']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $interval['Number']; ?>"><?php echo $interval['Start'] . ' - ' . $interval['End']; ?></option>
													<?php } ?>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-sales_order_number"><?php echo $entry_sales_order_number; ?></label>
											<div class="col-sm-9">
												<input type="text" name="sales_order_number" value="<?php echo $sales_order_number; ?>" placeholder="<?php echo $entry_sales_order_number; ?>" id="input-sales_order_number" class="form-control" />
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-packing_number"><?php echo $entry_packing_number; ?></label>
											<div class="col-sm-9">
												<input type="text" name="packing_number" value="<?php echo $packing_number; ?>" placeholder="<?php echo $entry_packing_number; ?>" id="input-packing_number" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-additional_information"><?php echo $entry_departure_additional_information; ?></label>
											<div class="col-sm-9">
												<textarea name="additional_information" rows="3" id="input-additional_information" maxlength="100" class="form-control"><?php echo $additional_information; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-rise_on_floor"><?php echo $entry_rise_on_floor; ?></label>
											<div class="col-sm-9">
												<input type="text" name="rise_on_floor" value="<?php echo $rise_on_floor; ?>" placeholder="<?php echo $entry_rise_on_floor; ?>" id="input-rise_on_floor" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="input-elevator"><?php echo $entry_elevator; ?></label>
											<div class="col-sm-9">
												<label class="radio-inline">
													<?php if ($elevator) { ?>
													<input type="checkbox" name="elevator" id="input-elevator" class="form-control" checked>
													<?php } else { ?>
													<input type="checkbox" name="elevator" id="input-elevator" class="form-control">
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Modal seats START -->
					<div class="modal fade" id="modal-options-seat" tabindex="-1" role="dialog" aria-labelledby="option-seat-label">
						<div class="modal-dialog modal-lg" role="document" style="width: 85%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="options-seat-label"><?php echo $heading_options_seat; ?></h4>
								</div>
								<div class="modal-body">
									<div class="table-responsive">
										<table class="table table-striped" id="table-seats">
											<thead>
												<tr>
													<td class="text-center"><?php echo $column_number; ?></td>
													<td class="text-center"><?php echo $column_volume; ?></td>
													<td class="text-center"></td>
													<td class="text-center"><?php echo $column_width; ?></td>
													<td class="text-center"><?php echo $column_length; ?></td>
													<td class="text-center"><?php echo $column_height; ?></td>
													<td class="text-center"><?php echo $column_weight; ?></td>
													<td class="text-center"><?php echo $column_volume_weight; ?></td>
													<td class="text-center" width="100px"><?php echo $column_action; ?></td>
												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="8"></td>
													<td class="text-center">
														<button type="button" onclick="addSeat();" data-toggle="modal"  data-tooltip=true title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" onclick="saveSeats();" class="btn btn-primary"><i class="fa fa-check"></i></button>
									<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal seats END -->

					<!-- Modal of totals list START -->
					<div class="modal fade" id="modal-totals-list" tabindex="-1" role="dialog" aria-labelledby="totals-list-label">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="totals-list-label"><?php echo $heading_components_list; ?></h4>
								</div>
								<div class="modal-body">
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
													<td class="text-center" id="td-announced_price_total"><strong><?php echo $announced_price; ?> <?php echo $text_grn; ?></strong></td>
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

		if (element.name == 'sender_contact_person') {
			post_data += '&f_sender=' + encodeURIComponent($('#input-sender').val());
		} else if (element.name == 'sender_city_name') {
			post_data += '&sender_city=' + encodeURIComponent($('#input-sender_city').val());
		} else if (element.name == 'sender_address_name') {
			post_data += '&sender_address=' + encodeURIComponent($('#input-sender_address').val()) + '&f_sender=' + encodeURIComponent($('#input-sender').val()) + '&sender_city=' + encodeURIComponent($('#input-sender_city').val());
		} else if (element.name == 'recipient_city_name') {
			post_data += '&recipient_city=' + encodeURIComponent($('#input-recipient_city').val());
		} else if (element.name == 'recipient_warehouse_name') {
			post_data += '&recipient_warehouse=' + encodeURIComponent($('#input-recipient_warehouse').val());
		} else if (element.name == 'recipient_street_name') {
			post_data += '&recipient_street=' + encodeURIComponent($('#input-recipient_street').val());
		}  else if (element.name == 'backward_delivery_total') {
			post_data += '&backward_delivery=' + encodeURIComponent($('#input-backward_delivery').val());
		}

		$.ajax( {
			url: 'index.php?route=extension/shipping/novaposhta/getCNForm&token=<?php echo $token; ?>',
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
			if (array['warning'] instanceof Array) {
				for(var w in array['warning']) {
					$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + array['warning'][w] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			} else {
				$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + array['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		}

		for(var field in array['errors']) {
			$('div.form-group').has('label[for="input-' + field + '"]').removeClass('has-success').addClass('has-error');
			$('#span-' + field).remove('.help-block');
			$('div.form-group > div[class^="col-sm"]').has('#input-' + field).append('<span id="span-' + field + '" class="help-block">' + array['errors'][field] + '</span>');
		}

		for(var field in array['success']) {
			$('div.form-group').has('label[for="input-' + field + '"]').removeClass('has-error').addClass('has-success');
			$('#span-' + field).remove('.help-block');
		}
	}

	function addSeat() {
		var row = '<tr>';

		row += '<td>' + ($('#table-seats tbody tr').length + 1) + '</td>';
		row += '<td><div class="input-group"><input type="text" name="volume" value="" id="input-seat-volume" class="form-control" /><span class="input-group-addon"><?php echo $text_cubic_meter; ?></span></div></td>';
		row += '<td><label class="col-sm-12 control-label"><?php echo $text_or; ?></label></td>';
		row += '<td><div class="input-group"><input type="text" name="width" value="" id="input-seat-width" class="form-control" /><span class="input-group-addon"><?php echo $text_cm; ?></span></div></td>';
		row += '<td><div class="input-group"><input type="text" name="length" value="" id="input-seat-length" class="form-control" /><span class="input-group-addon"><?php echo $text_cm; ?></span></div></td>';
		row += '<td><div class="input-group"><input type="text" name="height" value="" id="input-seat-height" class="form-control" /><span class="input-group-addon"><?php echo $text_cm; ?></span></div></td>';
		row += '<td><div class="input-group"><input type="text" name="actual_weight" value="" id="input-seat-actual-weight" class="form-control" /><span class="input-group-addon"><?php echo $text_kg; ?></span></div></td>';
		row += '<td><div class="input-group"><input type="text" name="volume_weight" value="" id="input-seat-volume-weight" class="form-control" readonly/><span class="input-group-addon"><?php echo $text_kg; ?></span></div></td>';
		row += '<td class="text-center"><button type="button" onclick="$(this).parents(\'tr\').remove()" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		row += '</tr>';

		$('#table-seats tbody').append(row);
	}

	function saveSeats() {
		var trs = $('#table-seats tbody tr');
		var seats = trs.length, weight = 0, volume = 0, volume_weight = 0;

		trs.each(function(i, element){
			tr = $(element);

			weight += +tr.find('#input-seat-actual-weight').val();
			volume += +tr.find('#input-seat-volume').val();
			volume_weight += +tr.find('#input-seat-volume-weight').val();
		} );

		$('#input-seats_amount').val(seats);
		$('#input-weight').val(weight);
		$('#input-volume_general').val(volume);
		$('#input-volume_weight').val(volume_weight);

		$('#modal-options-seat').modal('hide');
	}

	function saveAnnouncedPrice() {
		$('#input-announced_price').val(parseInt($('#td-announced_price_total')[0].outerText));

		$('#modal-totals-list').modal('hide');
	}

	function formHandler(element) {
		switch(element.id) {
			case 'input-sender':
				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/getNPData&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'action=getContactPerson&filter=' + encodeURIComponent(element.value),
					dataType: 'json',
					success: function (json) {
						var html = '<option value=""><?php echo $text_select; ?></option>';

						for (var i in json) {
							if (json[i]['Ref'] == "<?php echo $sender_contact_person; ?>") {
								html += '<option value="' + json[i]['Ref'] + '" selected="selected">' + json[i]['Description'] + ', ' + json[i]['Phones'] + '</option>';
							} else {
								html += '<option value="' + json[i]['Ref'] + '">' + json[i]['Description'] + ', ' + json[i]['Phones'] + '</option>';
							}
						}

						$('#input-sender_contact_person').html(html).trigger('change');
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus);
					}
				} );

				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/getNPData&token=<?php echo $token; ?>',
					type: 'post',
					data: 'action=getSenderOptions&filter=' + encodeURIComponent(element.value),
					dataType: 'json',
					success: function (json) {
						if (json['CanPayTheThirdPerson']) {
							$('#input-payer > option[value="ThirdPerson"]').prop('disabled', false).trigger('change');
						} else {
							$('#input-payer > option[value="ThirdPerson"]').prop('disabled', true).trigger('change');
						}

						if (json['CanAfterpaymentOnGoodsCost']) {
							$('[for="input-payment_control"]').filter(':hidden').parent().fadeIn();
						} else {
							$('[for="input-payment_control"]').filter(':visible').parent().fadeOut();
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus);
					}
				} );

				break;

			case 'input-sender_contact_person':
				var phone = element.selectedOptions[0].label.substr(element.selectedOptions[0].label.indexOf(', ') + 2);

				$('#input-sender_contact_person_phone').val(phone);

				break;

			case 'input-sender_region':
				$('#input-sender_city_name').val('').trigger('change');

			case 'input-sender_city_name':
				$('#input-sender_city, #input-sender_address, #input-sender_address_name').val('').trigger('change');

				break;

			case 'input-recipient_address_type':
				if (element.value == 'doors') {
					$('[for="input-recipient_warehouse_name"]').filter(':visible').parent().fadeOut();
					$('[for="input-recipient_street_name"], [for="input-recipient_house"], [for="input-recipient_flat"], [for="input-rise_on_floor"], [for="input-elevator"]').filter(':hidden').parent().fadeIn();

					if ($('#input-preferred_delivery_date').val()) {
						$('[for="input-time_interval"]').filter(':hidden').parent().fadeIn();
					}
				} else {
					$('[for="input-recipient_warehouse_name"]').filter(':hidden').parent().fadeIn();
					$('[for="input-recipient_street_name"], [for="input-recipient_house"], [for="input-recipient_flat"], [for="input-time_interval"], [for="input-rise_on_floor"], [for="input-elevator"]').filter(':visible').parent().fadeOut();
				}

				break;

			case 'input-recipient_name':
				$('#input-recipient').val('');

				break;

            case 'input-recipient_region':
                $('#input-recipient_region_name, #input-recipient_district_name').val('');

			case 'input-recipient_city_name':
				var
					address_type = $('#input-recipient_address_type:checked').val(),
					delivery_date = $('#input-preferred_delivery_date').val();

				if (address_type == 'doors' && delivery_date) {
					$.ajax( {
						url: 'index.php?route=extension/shipping/novaposhta/getNPData&token=<?php echo $token; ?>',
						type: 'post',
						data: 'action=getTimeIntervals&filter=' + encodeURIComponent(element.value) + '&delivery_date=' + encodeURIComponent(delivery_date),
						dataType: 'json',
						success: function (json) {
							var html = '<option value=""><?php echo $text_during_day; ?></option>';

							for (var i in json) {
								html += '<option value="' + json[i]['Number'] + '">' + json[i]['Start'] + ' - ' + json[i]['End'] + '</option>';
							}

							$('#input-time_interval').html(html);
						}
					} );
				}

				break;

			case 'input-recipient_warehouse_name':
				var departure_type = $('#input-departure_type').val();

				if (element.value.match(/почтомат|поштомат/i)) {
					if (departure_type == 'Parcel' || departure_type == 'Cargo') {
						$('[for="input-width"], [for="input-length"], [for="input-height"]').filter(':hidden').parent().fadeIn();
					} else if (departure_type == 'TiresWheels' || departure_type == 'Pallet'){
						$('#input-departure_type').val('Cargo').trigger('change');
					}

					$('#input-departure_type > option[value="TiresWheels"], #input-departure_type > option[value="Pallet"], #input-volume_general, #input-seats_amount, #button-options_seat').attr('disabled', true);
					$('#input-seats_amount').val('1');
				} else {
					$('[for="input-width"], [for="input-length"], [for="input-height"]').filter(':visible').parent().fadeOut();
					$('#input-departure_type > option[value="TiresWheels"], #input-departure_type > option[value="Pallet"], #input-volume_general, #input-seats_amount, #button-options_seat').attr('disabled', false);
				}

				break;

			case 'input-departure_type':
				var recipient_warehouse = $('#input-recipient_warehouse_name').val();

				if (element.value == 'Parcel' || element.value == 'Cargo') {
					var html = '<input type="text" name="weight" value="<?php echo $weight; ?>" placeholder="<?php echo $entry_weight; ?>" id="input-weight" class="form-control" />';

					$('#input-weight').replaceWith(html);

					$('[for*="input-tires_and_wheels"]').filter(':visible').parent().fadeOut();
					$('[for="input-weight"], [for="input-volume_weight"], [for="input-volume_general"]').filter(':hidden').parent().fadeIn();
					$('#button-options_seat, #input-seats_amount, #input-departure_description').attr('disabled', false);

					if (recipient_warehouse.match(/почтомат|поштомат/i)) {
						$('[for="input-width"], [for="input-length"], [for="input-height"]').filter(':hidden').parent().fadeIn();
						$('#button-options_seat, #input-seats_amount').attr('disabled', true);
						$('#input-seats_amount').val('1');
					}

					if (element.value == 'Cargo') {
                        $('[for="input-redbox_barcode"]').filter(':visible').parent().fadeOut();
                    } else {
                        $('[for="input-redbox_barcode"]').filter(':hidden').parent().fadeIn();
                        $('#input-redbox_barcode').trigger('change');
                    }
				} else if (element.value == 'Documents') {
					var html = '<select name="weight" id="input-weight" class="form-control"><option value=""><?php echo $text_select; ?></option><option value="0.1">0.1</option><option value="0.5">0.5</option><option value="1">1</option></select>';

					$('#input-weight').replaceWith(html);

					$('[for="input-redbox_barcode"], [for*="input-tires_and_wheels"], [for="input-volume_weight"], [for="input-volume_general"]').filter(':visible').parent().fadeOut();
					$('[for="input-weight"]').filter(':hidden').parent().fadeIn();
					$('#button-options_seat, #input-seats_amount').attr('disabled', false);
					$('#input-departure_description').attr('disabled', true).val('Документи');

					if (recipient_warehouse.match(/почтомат|поштомат/i)) {
						$('[for="input-width"], [for="input-length"], [for="input-height"]').filter(':visible').parent().fadeOut();
						$('#button-options_seat, #input-seats_amount').attr('disabled', true);
						$('#input-seats_amount').val('1');
					}
				} else if (element.value == 'TiresWheels') {
					$('[for="input-redbox_barcode"], [for="input-width"], [for="input-length"], [for="input-height"], [for="input-weight"], [for="input-volume_weight"], [for="input-volume_general"]').filter(':visible').parent().fadeOut();
					$('[for*="input-tires_and_wheels"]').filter(':hidden').parent().fadeIn();
					$('#button-options_seat, #input-seats_amount, #input-departure_description').attr('disabled', true);
					$('#input-departure_description').val('Шини та диски');
				}

				break;

            case 'input-redbox_barcode':
                if (element.value) {
                    $('[for="input-weight"], [for="input-volume_general"], [for="input-volume_weight"]').filter(':visible').parent().fadeOut();
                    $('#button-options_seat, #input-seats_amount').attr('disabled', true);
                    $('#input-seats_amount').val('1');
                } else {
					$('[for="input-weight"], [for="input-volume_general"], [for="input-volume_weight"]').filter(':hidden').parent().fadeIn();
                    $('#button-options_seat, #input-seats_amount').attr('disabled', false);
                }

                break;

			case (element.id.match(/input-tires_and_wheels_/) || {}).input:
				var c = 0;

				$('input[id^="input-tires_and_wheels"]').each(function() {
					c += +this.value;
				} );

				$('#input-seats_amount').val(c);

				break;

			case 'input-volume_general':
				$('#input-volume_weight').val((element.value * 250).toFixed(3));

				break;

			case 'input-width':
			case 'input-length':
			case 'input-height':
				$('#input-volume_general').val(($('#input-width').val() * $('#input-length').val() * $('#input-height').val() / 1000000).toFixed(3)).trigger('change');

				break;

			case 'input-seat-volume':
				$(element).parents('tr').find('#input-seat-volume-weight').val((element.value * 250).toFixed(3));

				break;

			case 'input-seat-width':
			case 'input-seat-length':
			case 'input-seat-height':
				var
					row = $(element).parents('tr'),
					width = row.find('#input-seat-width').val(),
					length = row.find('#input-seat-length').val(),
					height = row.find('#input-seat-height').val();

				row.find('#input-seat-volume').val((width * length * height / 1000000).toFixed(3)).trigger('change');

				break;

            case 'input-announced_price':
                var $backward_delivery_total = $('#input-backward_delivery_total');

                if (+element.value < +$backward_delivery_total.val() && $backward_delivery_total.is(':visible')) {
                    element.value = $backward_delivery_total.val();
                }

                break;

			case 'input-payer':
				if (element.value == 'ThirdPerson') {
					$('[for="input-third_person"]').filter(':hidden').parent().fadeIn();
					$('#input-payment_type > option[value ="NonCash"]').prop('selected', true);
					$('#input-payment_type > option[value="Cash"]').prop({'disabled': true, 'selected': false});
				} else {
					$('[for="input-third_person"]').filter(':visible').parent().fadeOut();
					$('#input-payment_type > option[value="Cash"]').prop('disabled', false);
				}

				$('#input-payment_type').trigger('change');

				break;

			case 'input-backward_delivery':
				if (element.value == 'Money') {
					$('[for="input-backward_delivery_total"], [for="input-backward_delivery_payer"], [for="input-money_transfer_method"]').filter(':hidden').parent().fadeIn();

					$('#input-money_transfer_method').trigger('change');
				} else {
					$('[for="input-backward_delivery_total"], [for="input-backward_delivery_payer"], [for="input-money_transfer_method"], [for="input-payment_card"]').filter(':visible').parent().fadeOut();
				}

				break;

			case 'input-backward_delivery_total':
			    var $announced_price = $('#input-announced_price');

			    if (+element.value > +$announced_price.val()) {
			        $announced_price.val(element.value);
                }

			    break;

			case 'input-money_transfer_method':
				if (element.value == 'to_payment_card') {
					$('[for="input-payment_card"]').filter(':hidden').parent().fadeIn();
				} else {
					$('[for="input-payment_card"]').filter(':visible').parent().fadeOut();
				}

				break;

            case 'input-payment_control':
                if (element.value) {
                    $('#input-backward_delivery > option[value ="N"]').prop('selected', true).trigger('change');
                } else {
                    $('#input-backward_delivery > option[value ="Money"]').prop('selected', true).trigger('change');
                }

                break;

			case 'input-preferred_delivery_date':
				if (element.value && $('#input-recipient_address_type:checked').val() == 'doors') {
					$('[for="input-time_interval"]').filter(':hidden').parent().fadeIn();
					$('#input-recipient_city_name').trigger('change')
				} else {
					$('[for="input-time_interval"]').filter(':visible').parent().fadeOut();
				}

				break;

			case 'input-elevator':
				if ($('#input-elevator:checked').val()) {
					$('#input-rise_on_floor').attr('disabled', true);
				} else {
                    $('#input-rise_on_floor').attr('disabled', false);
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

		$('#input-sender, input-sender_contact_person, #input-recipient_address, #input-recipient_address_type:checked, #input-departure_type, #input-payer, #input-backward_delivery, #input-elevator').each(function() {
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

		// Search sender city
		$('#input-sender_city_name').autocomplete( {
			source: function(request, response) {
				var post_data = 'city=' + encodeURIComponent(request) + '&region=' + encodeURIComponent($('#input-sender_region').val());

				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/autocomplete&token=<?php echo $token; ?>',
					type: 'post',
					data: post_data,
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['FullDescription'],
								value: item['Description'],
								ref:  item['Ref']
							}
						} ));
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus);
					}
				} );
			},
			select: function(item) {
				$(this).val(item['value']).trigger('change');
				setTimeout(function() { $('#input-sender_city').val(item['ref']); }, 150);
			}
		} );

		// Search address
		$('#input-sender_address_name').autocomplete( {
			source: function(request, response) {
				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/autocomplete&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'address=' + encodeURIComponent(request) + '&filter=' + encodeURIComponent($('#input-sender_city').val()) + '&sender=' + encodeURIComponent($('#input-sender').val()),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['Description'],
								value: item['Ref']
							}
						} ));
					}
				} );
			},
			select: function(item) {
				$(this).val(item['label']).trigger('change');
				$(this).siblings('input[type="hidden"]').val(item['value']);
			}
		} );

		// Search recipient
		$('#input-recipient_name').autocomplete( {
			source: function(request, response) {
				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/autocomplete&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'recipient_name=' + encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['FullDescription'],
								value: item['Description'],
								ref:   item['Ref']
							}
						}));
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus);
					}
				} );
			},
			select: function(item) {
				$(this).val(item['value']).trigger('change');
				setTimeout(function() { $('#input-recipient').val(item['ref']); }, 150);
			}
		} );

		// Search recipient city
		$('#input-recipient_city_name').autocomplete( {
			source: function(request, response) {
                var post_data;

				if ($('#input-recipient_address_type:checked').val() == 'warehouse') {
                    post_data = 'city=' + encodeURIComponent(request) + '&region=' + encodeURIComponent($('#input-recipient_region').val());
				} else {
                    post_data = 'settlement=' + encodeURIComponent(request)

                    if ($('#input-recipient_region').val()) {
                        post_data += encodeURIComponent(' ' + $('#input-recipient_region option:selected').text());
                    }
                }

				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/autocomplete&token=<?php echo $token; ?>',
					type: 'post',
					data: post_data,
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label:		  item['FullDescription'],
								value:		  item['Ref'],
								name:		  item['Description'],
								region_name:  item['Area'] || '',
								distric_name: item['Region'] || '',
							}
						} ));
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus);
					}
				} );
			},
			select: function(item) {
				$(this).val(item['name']).trigger('change');
				$('#input-recipient_city').val(item['value']);
				$('#input-recipient_region_name').val(item['region_name']);
				$('#input-recipient_district_name').val(item['distric_name']);
			}
		} );

		// Search warehouse
		$('#input-recipient_warehouse_name').autocomplete( {
			source: function(request, response) {
				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/autocomplete&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'filter=' + encodeURIComponent($('#input-recipient_city').val()) + '&warehouse=' + encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['Description'],
								value: item['Description'],
								ref:   item['Ref']
							}
						} ));
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus);
					}
				} );
			},
			select: function(item) {
				$(this).val(item['value']).trigger('change');
				$(this).siblings('input[type="hidden"]').val(item['ref']);
			}
		} );

		// Search street
		$('#input-recipient_street_name').autocomplete( {
			source: function(request, response) {
				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/autocomplete&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'filter=' + encodeURIComponent($('#input-recipient_city').val()) + '&street=' + encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['Description'],
								value: item['Description'],
								ref:   item['Ref']
							}
						} ));
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus);
					}
				} );
			},
			select: function(item) {
				$(this).val(item['value']).trigger('change');
				$(this).siblings('input[type="hidden"]').val(item['ref']);
			}
		} );

		// Departure description
		$('#input-departure_description').autocomplete({
			source: function(request, response) {
				$.ajax( {
					url: 'index.php?route=extension/shipping/novaposhta/autocomplete&token=<?php echo $token; ?>',
					type: 'post',
					data: 'departure_description=' + encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['Description'],
								value: item['Description'],
							}
						} ));
					}
				} );
			},
			select: function(item) {
				$(this).val(item['value']).triggerHandler('change');
			}
		} );

		// Save CN
		$('#button-save').on('click', function () {
			var $post_data = $('input[type="text"], input[type="radio"]:checked, input[type="checkbox"]:checked, select, textarea').filter(':visible').add('input[type="hidden"]');

			$.ajax( {
				url: 'index.php?route=extension/shipping/novaposhta/saveCN&order_id=<?php echo $order_id; ?>&cn_ref=<?php echo $cn_ref; ?>&token=<?php echo $token; ?>',
				type: 'POST',
				data: $post_data,
				dataType: 'json',
				beforeSend: function() {
					$('body').fadeTo('fast', 0.8).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				},
				complete: function(json){
					var $alerts = $('.alert-danger, .alert-success');

					if ($alerts.length !== 0) {
						setTimeout(function() { $alerts.remove(); }, 15000);
					}

					if (json['errors'] != 'undefined' || json['warning'] != 'undefined') {
						$('html, body').animate({ scrollTop: $('.has-error, .alert').offset().top }, 1000);
					}

					$('body').fadeTo('fast', 1)
					$('#ocmax-loader').remove();
				},
				success: function(json) {
					if (json['success']) {
						location.href = 'index.php?route=extension/shipping/novaposhta/getCNList&filter_departure_date_from=' + json['success'] + '&token=<?php echo $token; ?>';
					} else {
						$('.help-block').remove();
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