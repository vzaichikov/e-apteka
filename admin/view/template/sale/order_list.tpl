<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">

				<button type="submit" id="button-addtoqueue" form="form-order" formaction="<?php echo $addtoqueue; ?>" data-toggle="tooltip" title="Добавить в очередь" class="btn btn-info"><i class="fa fa-spinner"></i> Добавить в очередь</button>

				<a href="<?php echo $calls; ?>" data-toggle="tooltip" title="Звонки по заказам" class="btn btn-primary"><i class="fa fa-phone"></i> Звонки по заказам</a>
				<a href="<?php echo $recalls; ?>" data-toggle="tooltip" title="Обратные звонки" class="btn btn-primary"><i class="fa fa-phone"></i> Обратные звонки</a>
				



		<?php if ($aqe_enabled) { ?><label for="batch_edit" class="hidden" id="batch-edit-container"><input type="checkbox" id="batch-edit"<?php echo ($batch_edit) ? ' checked' : ''; ?>> <?php echo $text_batch_edit; ?></label><?php } ?>
			
				<button type="submit" id="button-shipping" form="form-order" formaction="<?php echo $shipping; ?>" formtarget="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></button>
				<button type="submit" id="button-invoice" form="form-order" formaction="<?php echo $invoice; ?>" formtarget="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></button>
				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button type="button" id="button-delete" form="form-order" formaction="<?php echo $delete; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<?php if ($success) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>

		<?php if ($aqe_enabled) { ?>
  <div class="alerts">
	<div class="container-fluid" id="alerts">
	</div>
  </div>
		<?php } ?>
			
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
			</div>
			<div class="panel-body">
				<div class="well">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
							</div>
							<div class="form-group">
								<input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
							</div>
							<div class="form-group">
								
								<input type="text" name="filter_card" value="<?php echo $filter_card; ?>" placeholder="<?php echo $entry_card; ?>" id="input-cart" class="form-control" />
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<select name="filter_order_status" id="input-order-status" class="form-control">
									<option value="*">Статус</option>
									<?php if ($filter_order_status == '0') { ?>
										<option value="0" selected="selected"><?php echo $text_missing; ?></option>
										<?php } else { ?>
										<option value="0"><?php echo $text_missing; ?></option>
									<?php } ?>
									<?php foreach ($order_statuses as $order_status) { ?>
										<?php if ($order_status['order_status_id'] == $filter_order_status) { ?>
											<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<input type="text" name="filter_total" value="<?php echo $filter_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
							</div>
							
							
							<div class="form-group">
								<select name="filter_order_shipping_code" id="input-order-status" class="form-control">
									<option value="*">Способ доставки</option>
									<?php foreach ($shipping_methods as $shipping_method) { ?>
										<?php if ($shipping_method['shipping_code'] == $filter_order_shipping_code) { ?>
											<option value="<?php echo $shipping_method['shipping_code']; ?>" selected="selected"><?php echo $shipping_method['shipping_method']; ?> (<?php echo $shipping_method['shipping_code']; ?>)</option>
											<?php } else { ?>
											<option value="<?php echo $shipping_method['shipping_code']; ?>"><?php echo $shipping_method['shipping_method']; ?> (<?php echo $shipping_method['shipping_code']; ?>)</option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div class="input-group date">
									<input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span></div>
							</div>
							<div class="form-group">
								<div class="input-group date">
									<input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span></div>
							</div>
							
						</div>
						<div class="col-sm-2">							
							<div class="form-group">
								<div class="input-group date">
									<input type="text" name="filter_date_added_from" value="<?php echo $filter_date_added_from; ?>" placeholder="Дата от" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group date">
									<input type="text" name="filter_date_added_to" value="<?php echo $filter_date_added_to; ?>" placeholder="Дата до" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
							
						</div>
						<div class="col-sm-2">							
							<div class="form-group">
								<select name="filter_manufacturer_id" id="input-manufacturer_id" class="form-control">
									<option value="*">Производитель</option>								
									<?php foreach ($manufacturers as $manufacturer) { ?>
										<?php if ($manufacturer['manufacturer_id'] == $filter_manufacturer_id) { ?>
											<option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<input type="text" name="filter_product_name" value="<?php echo $filter_product_name; ?>" placeholder="Товар" id="input-product-name" class="form-control" />
							</div>
							<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
						</div>
					</div>					
				</div>
				<div class="row">
					<div class="alert alert-info">
						<div class="col-sm-4">
							
							Всего: <b><?php echo $order_total;?></b>, <b><?php echo $order_sum_total; ?></b>, чек <b><?php echo $order_avg_cheque; ?></b>
							<br />
							Этот месяц: <b><?php echo $order_total_month;?></b>, <b><?php echo $order_sum_total_month; ?></b>
						</div>

						<div class="col-sm-4">
							Сегодня: <b><?php echo $order_total_today;?></b>, <b><?php echo $order_sum_total_today; ?></b>
							<br />
							Вчера: <b><?php echo $order_total_yesterday;?></b>, <b><?php echo $order_sum_total_yesterday; ?></b>						
						</div>

						<div class="col-sm-4">
							Время локальное: <b><?php echo $times['local']; ?></b>
							<br />							
							Время Asterisk <b><?php echo $times['calls']; ?></b>							
						</div>

					</div>
				</div>
				<form method="post" action="" enctype="multipart/form-data" id="form-order">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked).trigger('change');" /></td>
									<td class="text-right"><?php if ($sort == 'o.order_id') { ?>
										<a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
									<?php } ?></td>
									<td class="text-left">Товары
									</td>
									<td class="text-left"><?php if ($sort == 'customer') { ?>
										<a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
									<?php } ?></td>
									<td class="text-left"><?php if ($sort == 'order_status') { ?>
										<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
									<?php } ?></td>
									<td class="text-left">
										Оплата, доставка
									</td>							
									<td class="text-right"><?php if ($sort == 'o.total') { ?>
										<a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
									<?php } ?></td>
									<td class="text-left"><?php if ($sort == 'o.date_added') { ?>
										<a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
									<?php } ?></td>
									<? /*	<td class="text-left"><?php if ($sort == 'o.date_modified') { ?>
										<a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
										<?php } ?></td>
									*/ ?>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($orders) { ?>
									<?php foreach ($orders as $order) { ?>
										<tr>
											<td class="text-center"><?php if (in_array($order['order_id'], $selected)) { ?>
												<input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
											<?php } ?>
											<input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
											<td class="text-right">											
												<kbd><?php echo $order['order_id']; ?></kbd>
												
												
												<?php if (!empty($order['eapteka_id'])) { ?>
													<br /><span class="label label-success"><?php echo $order['eapteka_id']; ?></span>
												<?php } ?>
												
												<br />
												<?php if ($order['customer_id']) { ?>		
													<span class="label label-warning"><?php echo $order['customer_id']; ?></span>
													<?php } else { ?>
													<span class="label label-danger">без регистрации</span>
												<?php } ?>
												
												
												
											</td>
											<td class="text-right" style="max-width:250px;">
												<?php foreach ($order['products'] as $product) { ?>
													<code><small><? echo $product['name']; ?></small></code>
													<?php foreach ($product['option'] as $option) { ?>
														<br /><small class="label label-info"><small><?php echo $option['value']; ?></small></small>
													<?php } ?>
													<br />
												<?php } ?>
											</td>
											<td class="text-left" style="white-space: nowrap;">
												<b><?php echo $order['customer']; ?></b>
												
												<?php if ($order['card']) { ?>					
													<span class="label label-success"><?php echo $order['card']; ?></span>
												<?php } ?>
												
												<div>
													<code><?php echo $order['telephone']; ?></code>
													<span class='click2call' data-phone="<?php echo $order['telephone']; ?>"></span>
													
													<?php if ($order['lastcall']) { ?>
														<br /><small><small><i class="fa fa-info-circle"></i> Оформлен в <?php echo $order['date_added']; ?></small></small><br />
														<small><small><i class="fa fa-phone"></i> Звонок в <?php echo $order['lastcall']['time']; ?></small></small><br />
														<small><small><i class="fa fa-clock-o"></i> разница <?php echo $order['lastcall']['timediff']; ?> мин</small></small><br />
														<small class="label label-info"><small><?php echo $order['lastcall']['status']; ?></small></small>
														
														<?php if ($order['lastcall']['record']) { ?>
															<a href="<?php echo $order['lastcall']['record']; ?>" target="_blank">запись</a>
														<?php } ?>
														<? } else { ?>
														<br /><small class="label label-danger"><small>Нет звонка</small></small>
													<?php } ?>
													
												</div>
											</td>
											
											<td class="text-left">
												
												<?php if ($order['order_status_id'] == $config_order_status_id) { ?>
													<span class="label label-warning">
														<?php echo $order['order_status']; ?>
													</span>
													<?php } elseif ($order['order_status_id'] == 8) { ?>
													<span class="label label-danger">
														<?php echo $order['order_status']; ?>
													</span>
													<?php } else { ?>
													<span class="label label-info">
														<?php echo $order['order_status']; ?>
													</span>
												<?php } ?>
												
												<?php if ($order['in_queue']) { ?>
													<span class="label label-danger"><i class="fa fa-spinner fa-spin"></i> очередь</span> 
												<? } ?>
												
												
											</td>
											<td class="text-left">
												<span class="label label-success"><?php echo $order['payment_method']; ?></span><br />
												<span class="label label-info"><?php echo $order['shipping_method']; ?></span>
												
												<?php if (!empty($order['uuid'])) { ?>
													<br /><br /><span class="label label-warning"><?php echo $order['uuid']; ?></span>
													
													<?php } ?>
												
											</td>
											<td class="text-right"><b><?php echo str_replace(' ', '', $order['total']); ?></b></td>
											<td class="text-left">
												<?php echo $order['date_added']; ?>
												<br />
												<?php echo $order['date_modified']; ?>
												
											</td>
											<td class="text-right"><a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
											<? /* <a href="<?php echo $order['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> */ ?></td>
										</tr>
									<?php } ?>
									<?php } else { ?>
									<tr>
										<td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
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
	<script type="text/javascript"><!--
		$('#button-filter').on('click', function() {
			url = 'index.php?route=sale/order&token=<?php echo $token; ?>';
			
			var filter_order_id = $('input[name=\'filter_order_id\']').val();
			
			if (filter_order_id) {
				url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
			}
			
			var filter_customer = $('input[name=\'filter_customer\']').val();
			
			if (filter_customer) {
				url += '&filter_customer=' + encodeURIComponent(filter_customer);
			}
			
			
			var filter_card = $('input[name=\'filter_card\']').val();
			
			if (filter_card) {
				url += '&filter_card=' + encodeURIComponent(filter_card);
			}
			
			var filter_order_status = $('select[name=\'filter_order_status\']').val();
			
			if (filter_order_status != '*') {
				url += '&filter_order_status=' + encodeURIComponent(filter_order_status);
			}
			
			var filter_order_shipping_code = $('select[name=\'filter_order_shipping_code\']').val();
			
			if (filter_order_shipping_code != '*') {
				url += '&filter_order_shipping_code=' + encodeURIComponent(filter_order_shipping_code);
			}
			
			var filter_manufacturer_id = $('select[name=\'filter_manufacturer_id\']').val();
			
			if (filter_manufacturer_id != '*') {
				url += '&filter_manufacturer_id=' + encodeURIComponent(filter_manufacturer_id);
			}
			
			var filter_total = $('input[name=\'filter_total\']').val();
			
			if (filter_total) {
				url += '&filter_total=' + encodeURIComponent(filter_total);
			}
			
			var filter_product_name = $('input[name=\'filter_product_name\']').val();
			
			if (filter_product_name) {
				url += '&filter_product_name=' + encodeURIComponent(filter_product_name);
			}
			
			var filter_date_added = $('input[name=\'filter_date_added\']').val();
			
			if (filter_date_added) {
				url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
			}
			
			var filter_date_added_from = $('input[name=\'filter_date_added_from\']').val();
			
			if (filter_date_added_from) {
				url += '&filter_date_added_from=' + encodeURIComponent(filter_date_added_from);
			}
			
			var filter_date_added_to = $('input[name=\'filter_date_added_to\']').val();
			
			if (filter_date_added_to) {
				url += '&filter_date_added_to=' + encodeURIComponent(filter_date_added_to);
			}
			
			var filter_date_modified = $('input[name=\'filter_date_modified\']').val();
			
			if (filter_date_modified) {
				url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
			}
			
			location = url;
		});
	//--></script>
	<script type="text/javascript"><!--
		$('input[name=\'filter_customer\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'filter_customer\']').val(item['label']);
			}
		});
	//--></script>
	
	<script type="text/javascript"><!--
		$('input[name^=\'selected\']').on('change', function() {
			$('#button-shipping, #button-invoice #button-addtoqueue').prop('disabled', true);
			
			var selected = $('input[name^=\'selected\']:checked');
			
			if (selected.length) {
				$('#button-invoice #button-addtoqueue').prop('disabled', false);
			}
			
			for (i = 0; i < selected.length; i++) {
				if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
					$('#button-shipping').prop('disabled', false);
					
					break;
				}
			}
		});
		
		$('#button-shipping, #button-invoice #button-addtoqueue').prop('disabled', true);
		
		$('input[name^=\'selected\']:first').trigger('change');
		
		// IE and Edge fix!
		$('#button-shipping, #button-invoice #button-addtoqueue').on('click', function(e) {
			$('#form-order').attr('action', this.getAttribute('formAction'));
		});
		
		$('#button-delete').on('click', function(e) {
			$('#form-order').attr('action', this.getAttribute('formAction'));
			
			if (confirm('<?php echo $text_confirm; ?>')) {
				$('#form-order').submit();
				} else {
				return false;
			}
		});
	//--></script>
	<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	<link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
	<script type="text/javascript"><!--
		$('.date').datetimepicker({
			pickTime: false
		});
	//--></script></div>

					<!-- START Shipping Data -->
					<style>
						.btn-novaposhta {
							color: #333;
							background-color: #ff392e;
							border-color: #ccc;
						}
						.btn-light-novaposhta {
							color: #333;
							background-color: #fff;
							border-color: #ff392e;
						}
						.btn-ukrposhta {
							color: #333;
							background-color: #ffce2f;
							border-color: #ccc;
						}
						.btn-light-ukrposhta {
							color: #333;
							background-color: #fff;
							border-color: #ffce2f;
						}
					</style>
					<!-- START Modal assignment CN to order -->
					<div class="modal fade" id="assignment-cn-to-order" tabindex="-1" role="dialog" aria-labelledby="assignment-cn-to-order-label">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="assignment-cn-to-order-label"><?php echo $heading_cn; ?></h4>
								</div>
								<div class="modal-body">
									<div class="form-group clearfix">
										<input type="hidden" name="cn_order_id" value="" id="cn_order_id" />
										<input type="hidden" name="cn_shipping_method" value="" id="cn_shipping_method" />
										<label class="col-sm-2 control-label" for="cn_number"><?php echo $entry_cn_number; ?></label>
										<div class="col-sm-10">
											<input type="text" name="cn_number" value="" placeholder="<?php echo $entry_cn_number; ?>" id="cn_number" class="form-control" />
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" onclick="assignmentCN();"><i class="fa fa-check"></i></button>
									<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- END Modal assignment CN to order -->

					<script type="text/javascript"><!--
						function deleteCN(self, shipping_method) {
							var post_data = 'order_id=' + $(self).parents('tr').find('input[name^="selected"]').val();

							$.ajax( {
								url: 'index.php?route=extension/shipping/' + shipping_method + '/deleteCNFromOrder&token=<?php echo $token; ?>',
								type: 'POST',
								data: post_data,
								dataType: 'json',
								beforeSend: function () {
									$('body').fadeTo('fast', 0.7).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
								},
								complete: function () {
									var $alerts = $('.alert-danger, .alert-success');

									if ($alerts.length !== 0) {
										setTimeout(function() { $alerts.fadeOut() }, 5000);
									}

									$('body').fadeTo('fast', 1)
									$('#ocmax-loader').remove();
								},
								success: function(json) {
									if(json['error']) {
										$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
									}

									if (json['success']) {
										$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

										setTimeout(function() {
												location.reload();
											},
											2000
										);
									}

									$('html, body').animate({ scrollTop: 0 }, 'slow');
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.log(textStatus);
								}
							} );
						}

						function assignmentCN(self, shipping_method) {
							if (typeof(self) !== 'undefined') {
								$('#cn_order_id').val($(self).parents('tr').find('input[name^="selected"]').val());
							}

							if (shipping_method) {
								$('#cn_shipping_method').val(shipping_method);
							}

							if ($('#assignment-cn-to-order').is(':hidden')) {
								$('#assignment-cn-to-order').modal('show');
							} else {
								var post_data = 'order_id=' + $('#cn_order_id').val() + '&cn_number=' + $('#cn_number').val();

								$.ajax( {
									url: 'index.php?route=extension/shipping/' + $('#cn_shipping_method').val() + '/addCNToOrder&token=<?php echo $token; ?>',
									type: 'POST',
									data: post_data,
									dataType: 'json',
									beforeSend: function () {
										$('body').fadeTo('fast', 0.7).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
									},
									complete: function () {
										var $alerts = $('.alert-danger, .alert-success');

										if ($alerts.length !== 0) {
											setTimeout(function() { $alerts.fadeOut() }, 5000);
										}

										$('body').fadeTo('fast', 1)
										$('#ocmax-loader').remove();
									},
									success: function(json) {
										if(json['error']) {
											$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
										}

										if (json['success']) {
											$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

											setTimeout(function() {
													location.reload();
												},
												2000
											);
										}

										$('html, body').animate({ scrollTop: 0 }, 'slow');
									},
									error: function (jqXHR, textStatus, errorThrown) {
										console.log(textStatus);
									}
								} );

								$('#assignment-cn-to-order').modal('hide');
							}
						}

						$(function() {
							var post_data = $('input[name^="selected"]');

							$.ajax( {
								url: 'index.php?route=sale/order/getShippingData&token=<?php echo $token; ?>',
								type: 'POST',
								data: post_data,
								dataType: 'json',
								success: function(json) {
									if(json['error']) {
										$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

										$('html, body').animate({ scrollTop: 0 }, 'slow');
									}

									if (json instanceof Object) {
										if (json['shipping_methods']) {
											var btn_l = '<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-ul"></i> <span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right">';

											for (var i in json['shipping_methods']) {
												btn_l += '<li class="dropdown-header">' + json['shipping_methods'][i]['heading'] + '</li>';

												if (json['shipping_methods'][i]['cn_list']) {
													btn_l += '<li><a href="' + json['shipping_methods'][i]['cn_list']['href'] + '">' + json['shipping_methods'][i]['cn_list']['text'] + '</a></li>';
												}

												btn_l += '<li role="separator" class="divider"></li>';
											}

											btn_l += '</ul></div> ';

											$('div.container-fluid div.pull-right:last').prepend(btn_l);
										}

										for (var i in json['orders']) {
											var
												c       = 0,
												f       = false,
												b_class = '',
												btn_o   = '<div class="btn-group"><button type="button" id="button-cn-' + i + '" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right">';

											btn_o += '<li class="dropdown-header">' + json['heading_cn'] + '</li>';
											btn_o += '<li role="separator" class="divider"></li>';

											for (var ii in json['orders'][i]) {
												c++;

												btn_o += '<li class="dropdown-header">' + json['shipping_methods'][ii]['heading'] + '</li>';

												if (json['orders'][i][ii]['create']) {
													btn_o += '<li><a href="' + json['orders'][i][ii]['create']['href'] + '">' + json['orders'][i][ii]['create']['text'] + '</a></li>';
												}

												if (json['orders'][i][ii]['edit']) {
													f = true;
													btn_o += '<li><a href="' + json['orders'][i][ii]['edit']['href'] + '">' + json['orders'][i][ii]['edit']['text'] + '</a></li>';
												}

												if (json['orders'][i][ii]['delete']) {
													f = true;
													btn_o += '<li><a style="cursor: pointer;" onclick="deleteCN(this, \'' + ii + '\');">' + json['orders'][i][ii]['delete']['text'] + '</a></li>';
												}

												if (json['orders'][i][ii]['assignment']) {
													btn_o += '<li><a style="cursor: pointer;" onclick="assignmentCN(this, \'' + ii + '\');">' + json['orders'][i][ii]['assignment']['text'] + '</a></li>';
												}

												btn_o += '<li role="separator" class="divider"></li>';

												if (f) {
													b_class = 'btn-' + ii;

													continue;
												} else {
													b_class = 'btn-light-' + ii;
												}
											}

											btn_o += '</ul></div> ';

											$('input[value="' + i + '"]').parents('tr').find('td:last').prepend(btn_o);

											if (c != 1) {
												if (f) {
													b_class = 'btn-info';
												} else {
													b_class = 'btn-default';
												}
											}

											$('input[value="' + i + '"]').parents('tr').find('[id^="button-cn"]').addClass(b_class);
										}
									}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.log(textStatus);
								}
							} );
						} );
					//--></script>
					<!-- END Shipping Data -->
    			
	<?php echo $footer; ?>												