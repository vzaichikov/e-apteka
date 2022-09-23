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
				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary" role="button"><i class="fa fa-plus"></i></a>
				<button type="button" id="button-delete" onclick="deleteCN(this);" data-toggle="tooltip" data-value="" title="<?php echo $button_delete; ?>" class="btn btn-danger" disabled="disabled"><i class="fa fa-trash-o"></i></button>
				<a href="<?php echo $back_to_orders; ?>" data-toggle="tooltip" title="<?php echo $button_back_to_orders; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
		</div>
	</div>
  	<div class="container-fluid">
   		<?php if ($success) { ?>
    		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      			<button type="button" class="close" data-dismiss="alert">&times;</button>
    		</div>
    	<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_consignment_note_list; ?></h3>
			</div>
			<div class="panel-body">
				<div class="well">
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label" for="input-filter_cn_number"><?php echo $entry_cn_number; ?></label>
						</div>
						<div class="col-sm-6">
							<label class="control-label" for="input-filter_order_id"><?php echo $entry_order_number; ?></label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<input type="text" name="filter_cn_number" value="<?php echo $filter_cn_number; ?>" placeholder="<?php echo $entry_cn_number; ?>" id="input-filter_cn_number" class="form-control" />
						</div>
						<div class="col-sm-6">
							<input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_number; ?>" id="input-filter_order_id" class="form-control" />
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-8">
								<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
							</div>
						</div>
					</div>
				</div>
				<form method="post" enctype="multipart/form-data" id="form">
					<div class="table-responsive" style="overflow-y:visible; overflow-x:visible;">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name^=selected]').prop('checked', this.checked); $('input[name^=selected]').triggerHandler('change');" /></td>
									<td<?php if (!in_array('cn_identifier', $displayed_information)) { echo ' style="display: none"'; } ?>><?php echo $column_cn_identifier; ?></td>
									<?php if (in_array('cn_number', $displayed_information)) { ?>
									<td><?php echo $column_cn_number; ?></td>
									<?php } ?>
									<?php if (in_array('order_number', $displayed_information)) { ?>
									<td><?php echo $column_order_number; ?></td>
									<?php } ?>
									<?php if (in_array('shipment_group', $displayed_information)) { ?>
									<td><?php echo $column_shipment_group; ?></td>
									<?php } ?>
									<?php if (in_array('estimated_shipping_date', $displayed_information)) { ?>
									<td><?php echo $column_estimated_shipping_date; ?></td>
									<?php } ?>
									<?php if (in_array('last_updated_status_date', $displayed_information)) { ?>
									<td><?php echo $column_last_updated_status_date; ?></td>
									<?php } ?>
									<?php if (in_array('last_modified_date', $displayed_information)) { ?>
									<td><?php echo $column_last_modified_date; ?></td>
									<?php } ?>
									<?php if (in_array('sender', $displayed_information)) { ?>
									<td><?php echo $column_sender; ?></td>
									<?php } ?>
									<?php if (in_array('sender_phone', $displayed_information)) { ?>
									<td><?php echo $column_sender_phone; ?></td>
									<?php } ?>
									<?php if (in_array('sender_address', $displayed_information)) { ?>
									<td><?php echo $column_sender_address; ?></td>
									<?php } ?>
									<?php if (in_array('recipient', $displayed_information)) { ?>
									<td><?php echo $column_recipient; ?></td>
									<?php } ?>
									<?php if (in_array('recipient_phone', $displayed_information)) { ?>
									<td><?php echo $column_recipient_phone; ?></td>
									<?php } ?>
									<?php if (in_array('recipient_address', $displayed_information)) { ?>
									<td><?php echo $column_recipient_address; ?></td>
									<?php } ?>
									<?php if (in_array('weight', $displayed_information)) { ?>
									<td><?php echo $column_weight; ?></td>
									<?php } ?>
									<?php if (in_array('seats_amount', $displayed_information)) { ?>
									<td><?php echo $column_seats_amount; ?></td>
									<?php } ?>
									<?php if (in_array('announced_price', $displayed_information)) { ?>
									<td><?php echo $column_announced_price; ?></td>
									<?php } ?>
									<?php if (in_array('shipping_cost', $displayed_information)) { ?>
									<td><?php echo $column_shipping_cost; ?></td>
									<?php } ?>
									<?php if (in_array('backward_delivery', $displayed_information)) { ?>
									<td><?php echo $column_backward_delivery; ?></td>
									<?php } ?>
									<?php if (in_array('delivery_type', $displayed_information)) { ?>
									<td><?php echo $column_delivery_type; ?></td>
									<?php } ?>
									<?php if (in_array('delivery_technology', $displayed_information)) { ?>
									<td><?php echo $column_delivery_technology; ?></td>
									<?php } ?>
									<?php if (in_array('description', $displayed_information)) { ?>
									<td><?php echo $column_description; ?></td>
									<?php } ?>
									<?php if (in_array('payer', $displayed_information)) { ?>
									<td><?php echo $column_payer; ?></td>
									<?php } ?>
									<?php if (in_array('status', $displayed_information)) { ?>
									<td><?php echo $column_status; ?></td>
									<?php } ?>
									<td class="text-center" width="120px"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
							<?php if ($cns) { ?>
								<?php foreach ($cns as $cn) { ?>
								<tr>

									<td class="text-center">
										<input type="checkbox" name="selected[]" value="<?php echo $cn['cn_identifier']; ?>" />
									</td>
									<td<?php if (!in_array('cn_identifier', $displayed_information)) { echo ' style="display: none"'; } ?>>
									<?php echo $cn['cn_identifier']; ?>
									<input type="hidden" name="uuids[]" value="<?php echo $cn['cn_identifier']; ?>" />
									</td>
									<?php if (in_array('cn_number', $displayed_information)) { ?>
									<td><?php echo $cn['cn_number']; ?></td>
									<?php } ?>
									<?php if (in_array('order_number', $displayed_information)) { ?>
									<td class="text-center">
										<?php if (isset($cn['order'])) { ?>
										<a href="<?php echo $cn['order']; ?>" target="_blank"><?php echo $cn['order_id']; ?></a>
										<?php } ?>
									</td>
									<?php } ?>
									<?php if (in_array('shipment_group', $displayed_information)) { ?>
									<td><?php echo $cn['shipment_group']; ?></td>
									<?php } ?>
									<?php if (in_array('estimated_shipping_date', $displayed_information)) { ?>
									<td><?php echo $cn['estimated_shipping_date']; ?></td>
									<?php } ?>
									<?php if (in_array('last_updated_status_date', $displayed_information)) { ?>
									<td><?php echo $cn['last_updated_status_date']; ?></td>
									<?php } ?>
									<?php if (in_array('last_modified_date', $displayed_information)) { ?>
									<td><?php echo $cn['last_modified_date']; ?></td>
									<?php } ?>
									<?php if (in_array('sender', $displayed_information)) { ?>
									<td><?php echo $cn['sender']; ?></td>
									<?php } ?>
									<?php if (in_array('sender_phone', $displayed_information)) { ?>
									<td><?php echo $cn['sender_phone']; ?></td>
									<?php } ?>
									<?php if (in_array('sender_address', $displayed_information)) { ?>
									<td><?php echo $cn['sender_address']; ?></td>
									<?php } ?>
									<?php if (in_array('recipient', $displayed_information)) { ?>
									<td><?php echo $cn['recipient']; ?></td>
									<?php } ?>
									<?php if (in_array('recipient_phone', $displayed_information)) { ?>
									<td><?php echo $cn['recipient_phone']; ?></td>
									<?php } ?>
									<?php if (in_array('recipient_address', $displayed_information)) { ?>
									<td><?php echo $cn['recipient_address']; ?></td>
									<?php } ?>
									<?php if (in_array('weight', $displayed_information)) { ?>
									<td><?php echo $cn['weight']; ?></td>
									<?php } ?>
									<?php if (in_array('seats_amount', $displayed_information)) { ?>
									<td><?php echo $cn['seats_amount']; ?></td>
									<?php } ?>
									<?php if (in_array('announced_price', $displayed_information)) { ?>
									<td><?php echo $cn['announced_price']; ?></td>
									<?php } ?>
									<?php if (in_array('shipping_cost', $displayed_information)) { ?>
									<td><?php echo $cn['shipping_cost']; ?></td>
									<?php } ?>
									<?php if (in_array('backward_delivery', $displayed_information)) { ?>
									<td><?php echo $cn['backward_delivery']; ?></td>
									<?php } ?>
									<?php if (in_array('delivery_type', $displayed_information)) { ?>
									<td><?php echo $cn['delivery_type']; ?></td>
									<?php } ?>
									<?php if (in_array('delivery_technology', $displayed_information)) { ?>
									<td><?php echo $cn['delivery_technology']; ?></td>
									<?php } ?>
									<?php if (in_array('description', $displayed_information)) { ?>
									<td><?php echo $cn['description']; ?></td>
									<?php } ?>
									<?php if (in_array('payer', $displayed_information)) { ?>
									<td><?php echo $cn['payer']; ?></td>
									<?php } ?>
									<?php if (in_array('status', $displayed_information)) { ?>
									<td><?php echo $cn['status']; ?></td>
									<?php } ?>
									<td class="text-center">
										<div class="btn-group">
											<a href="<?php echo $customized_printing . '&cn_number=' . $cn['cn_number'] . '&cn_uuid=' . $cn['cn_identifier']; ?>" id="button-customized-printing-<?php echo $cn['cn_number']; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $text_customized_printing; ?>" class="btn btn-default btn-sm" role="button"><i class="fa fa-print"></i></a>
											<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-header"><i class="fa fa-file-pdf-o fa-fw"></i> <?php echo $text_download_pdf; ?></li>
												<li><a href="<?php echo $print_sticker_100x100_pdf . '&cn_number=' . $cn['cn_number'] . '&cn_uuid=' . $cn['cn_identifier']; ?>" target="_blank"><?php echo $text_address_sticker_100x100; ?></a></li>
												<li><a href="<?php echo $print_sticker_group_100x100_pdf . '&cn_number=' . $cn['cn_number'] . '&cn_uuid=' . $cn['cn_identifier']; ?>" target="_blank"><?php echo $text_address_sticker_group_100x100; ?></a></li>
												<li><a href="<?php echo $print_group_form_103a_pdf . '&cn_number=' . $cn['cn_number'] . '&cn_uuid=' . $cn['cn_identifier']; ?>" target="_blank"><?php echo $text_group_form_103a; ?></a></li>
											</ul>
										</div>
										<div class="btn-group">
											<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i> <span class="caret"></span></button>
											<ul class="dropdown-menu dropdown-menu-right">
												<?php if ($cn['shipment_group']) { ?>
												<li><a onclick="deleteFromGroup(this);" style="cursor: pointer;"><i class="fa fa-outdent text-warning fa-fw" aria-hidden="true"></i> <?php echo $text_delete_from_group; ?></a></li>
												<?php } else { ?>
												<li><a onclick="addToGroup(this);" style="cursor: pointer;"><i class="fa fa-indent text-info fa-fw" aria-hidden="true"></i> <?php echo $text_add_to_group; ?></a></li>
												<?php } ?>
												<li><a href="<?php echo $add, '&cn_uuid=', $cn['cn_identifier']; ?>"><i class="fa fa-pencil text-primary fa-fw"></i> <?php echo $text_edit; ?></a></li>
												<li><a onclick="printSettings(this);" style="cursor: pointer;"><i class="fa fa-print fa-fw"></i> <?php echo $text_print_settings; ?></a></li>
												<li><a onclick="deleteCN(this);" style="cursor: pointer;"><i class="fa fa-trash-o text-danger fa-fw"></i> <?php echo $text_delete; ?></a></li>
											</ul>
										</div>
									</td>
								</tr>
							<?php } ?>
							<?php } else { ?>
								<tr>
									<td class="text-center" colspan="<?php echo count($displayed_information) + 2; ?>"><?php echo $text_no_results; ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
			</div>
		</div>
	</div>
	<!-- START Add to group -->
	<div class="modal fade" id="modal-add-to-group" tabindex="-1" role="dialog" aria-labelledby="modal-add-to-group-label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal-add-to-group-label"><?php echo $heading_adding_to_group; ?></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="cn_uuid_group" value="" id="input-cn_uuid_group">
					<div class="form-group clearfix">
						<label class="col-sm-4 control-label" for="input-shipment_group"><?php echo $entry_shipment_group; ?></label>
						<div class="col-sm-8">
							<select name="shipment_group" id="input-shipment_group" class="form-control">
								<option value=""><?php echo $text_add; ?></option>
								<?php foreach ($shipment_groups as $v) { ?>
								<option value="<?php echo $v['uuid']; ?>"><?php echo $v['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-sm-4 control-label" for="input-shipment_group_name"><?php echo $entry_name; ?></label>
						<div class="col-sm-8">
							<input type="text" name="shipment_group_name" id="input-shipment_group_name" class="form-control">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="addToGroup();"><i class="fa fa-check"></i></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- END Add to group -->
	<!-- START Print settings -->
	<div class="modal fade" id="modal-print-settings" tabindex="-1" role="dialog" aria-labelledby="modal-print-settings-label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal-print-settings-label"><?php echo $text_print_settings; ?></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" value="" id="input-print_button_id">
					<div class="form-group clearfix">
						<label class="col-sm-4 control-label" for="input-print_type"><?php echo $entry_print_type; ?></label>
						<div class="col-sm-8">
							<select name="print_type" id="input-print_type" class="form-control">
								<option value=""><?php echo $text_select; ?></option>
								<?php foreach ($print_types as $k => $v) { ?>
								<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-sm-4 control-label" for="input-print_format"><?php echo $entry_print_format; ?></label>
						<div class="col-sm-8">
							<select name="print_format" id="input-print_format" class="form-control">
								<option value=""><?php echo $text_select; ?></option>
								<?php foreach ($print_formats as $k => $v) { ?>
								<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-sm-4 control-label" for="input-print_sender_name"><?php echo $entry_print_sender_name; ?></label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="checkbox" name="print_sender_name" id="input-print_sender_name" class="form-control">
							</label>
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-sm-4 control-label" for="input-print_delivery_price"><?php echo $entry_print_delivery_price; ?></label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="checkbox" name="print_delivery_price" id="input-print_delivery_price" class="form-control">
							</label>
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-sm-4 control-label" for="input-print_declared_price"><?php echo $entry_print_declared_price; ?></label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="checkbox" name="print_declared_price" id="input-print_declared_price" class="form-control">
							</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="printSettings();"><i class="fa fa-check"></i></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- END Print settings -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script type="text/javascript"><!--
	function formHandler(element) {
		switch(element.id) {
			case 'input-shipment_group':
				if (!element.value) {
					$('#input-shipment_group_name').parents('div.form-group').fadeIn();
				} else {
					$('#input-shipment_group_name').parents('div.form-group').fadeOut();
				}

				break;
		}
	}

	function printSettings(self) {
		if ($('#modal-print-settings').is(':hidden')) {
			var p_id = $(self).parents('tr').find('a[id^="button-customized-printing"]')[0].id;

			$('#input-print_button_id').val(p_id);

			$('#modal-print-settings').modal('show');
		} else {
			var
				cn_number = $('#input-print_button_id').val().replace(/\D/g,''),
				print_type = $('#input-print_type').val(),
				print_format = $('#input-print_format').val(),
                print_sender_name = $('#input-print_sender_name:checked').val(),
                print_delivery_price = $('#input-print_delivery_price:checked').val(),
				print_declared_price = $('#input-print_declared_price:checked').val();

			new_href = 'index.php?route=extension/shipping/ukrposhta/printDocument&token=<?php echo $token; ?>&cn_number=' + cn_number + '&cn_uuid=' + $('tr:contains("' + cn_number + '")').find('input[name="uuids[]"]').val();

			if (print_type) {
				new_href += '&type=' + print_type;
			}

			if (print_format) {
				new_href += '&format=' + print_format;
            }

            if (print_sender_name) {
                new_href += '&print_sender_name=1';
            }

            if (!print_delivery_price) {
                new_href += '&hide_delivery_price=1';
            }

			if (!print_declared_price) {
				new_href += '&hide_declared_price=1';
			}

			$('#' + $('#input-print_button_id').val()).attr('href', new_href);

			$('#modal-print-settings').modal('hide');
		}
	}

	function addToGroup(self) {
		if ($('#modal-add-to-group').is(':hidden')) {
			var cn_uuid = $(self).parents('tr').find('input[name="selected[]"]').val();

			$('#input-cn_uuid_group').val(cn_uuid);
			$('#input-shipment_group > option:eq(1)').prop('selected', true);
			$('#input-shipment_group').trigger('change');
			$('#modal-add-to-group').modal('show');
		} else {
			var
				cn_uuid = $('#input-cn_uuid_group').val(),
				post_data = '&action=addShipmentToGroup';

			post_data += '&cn=' + cn_uuid;
			post_data += '&group_uuid=' + $('#input-shipment_group').val();
			post_data += '&group_name=' + $('#input-shipment_group_name').val();

			$.ajax( {
				type: 'POST',
				url: 'index.php?route=extension/shipping/ukrposhta/ukrposhtaData&token=<?php echo $token; ?>',
				data: post_data,
				dataType: 'json',
				success: function(json) {
					if (json['success']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('tr:contains("' + cn_uuid + '")').addClass('info');
					}

					if (json['error']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				}
			} );

			$('#modal-add-to-group').modal('hide');
		}
	}

	function deleteFromGroup(self) {
		var cn_uuid = $(self).parents('tr').find('input[name="selected[]"]').val(),
			post_data = '&action=deleteShipmentFromGroup';

		post_data += '&cn=' + cn_uuid;

		$.ajax( {
			type: 'POST',
			url: 'index.php?route=extension/shipping/ukrposhta/ukrposhtaData&token=<?php echo $token; ?>',
			data: post_data,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('tr:contains("' + cn_uuid + '")').addClass('warning');
				}

				if (json['error']) {
					$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			}
		} );
	}

	function deleteCN(self) {
	    if (!confirm('<?php echo $text_confirm; ?>')) {
	        return false;
        }

		var post_data;

		if (self.id == 'button-delete') {
			post_data = $('input[name^="selected"]:checked').parents('tr').find('input[name^="uuids"]').serialize();
		} else {
			post_data = $(self).parents('tr').find('input[name^="uuids"]').serialize();
		}

		$.ajax( {
			type: 'POST',
			url: 'index.php?route=extension/shipping/ukrposhta/deleteCN&token=<?php echo $token; ?>',
			data: post_data,
			dataType: 'json',
			beforeSend: function () {
				$(self).find('i').addClass('fa-spin');
				$(self).parents('div.btn-group').find('i').addClass('fa-spin');
			},
			complete: function () {
				var $alerts = $('.alert-danger, .alert-success');

				if ($alerts.length !== 0) {
					setTimeout(function() { $alerts.fadeOut() }, 5000);
				}

				$(self).find('i').removeClass('fa-spin');
				$(self).parents('div.btn-group').find('i').removeClass('fa-spin');
			},
			success: function(json) {
				if (json['success']) {
					for(var i in json['success']['uuids']) {
						$('input[value ="' + json['success']['uuids'][i] + '"]').parents('tr').fadeOut('slow');
					}

					$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success']['text'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['warning']) {
					for(var w in json['warning']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['warning'][w] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				}
			}
		} );
	}

	$(function() {
		$('.date').datetimepicker({
			pickTime: false
		} );

		$.ajaxSetup( {
			beforeSend: function () {
				$('body').fadeTo('fast', 0.7).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
			},
			complete: function () {
				var $alerts = $('.alert-danger, .alert-success');

				if ($alerts.length !== 0) {
					setTimeout(function() { $alerts.fadeOut() }, 5000);
				}

				$('body').fadeTo('fast', 1);
				$('#ocmax-loader').remove();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(textStatus);
			}
		} );

		if ('<?php echo $cn_uuid; ?>') {
			$('tr:contains("<?php echo $cn_uuid; ?>")').addClass('success');
		}

		$('input[name^="selected"]').on('change', function(e) {
			var selected = $('input[name^="selected"]:checked');

			if (selected.length) {
				$('#button-delete').attr('disabled', false);
			} else {
				$('#button-delete').attr('disabled', true);
			}
		} );

		$('#content').on('change', 'input, select, textarea', function() {
			setTimeout(formHandler, 100, this);
		} );

		$('#input-shipment_group').each(function() {
			formHandler(this);
		} );

		$('#button-filter').on('click', function() {
			var
				url = 'index.php?route=extension/shipping/ukrposhta/getCNList&token=<?php echo $token; ?>',
				filter_cn_number = $('#input-filter_cn_number').val(),
				filter_order_id = $('#input-filter_order_id').val();


			if (filter_cn_number) {
				url += '&filter_cn_number=' + encodeURIComponent(filter_cn_number);
			}

			if (filter_order_id) {
				url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
			}

			location = url;
		} );

	} );
//--></script>
<?php echo $footer; ?>