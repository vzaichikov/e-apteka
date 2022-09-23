<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
			</div>
			<div class="panel-body">				
				<form method="post" action="" enctype="multipart/form-data" id="form-order">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left">
										Телефон
									</td>
									<td class="text-left">
										Текст
									</td>
									<td class="text-left">
										Время заявки
									</td>
									<td class="text-left">
										Время звонка
									</td>
									<td class="text-left">
										Статус звонка
									</td>
									<td class="text-left">
										Все звонки
									</td>
									<td class="text-left">
										Разница
									</td>	
									<td class="text-left">
										Запись
									</td>
								</tr>
							</thead>
							<tbody>
								<?php if ($recalls) { ?>
									<?php foreach ($recalls as $recall) { ?>
										<td class="text-left">
											<code><?php echo $recall['telephone']; ?></code>
										</td>
										<td class="text-left" style="max-width:200px;">
											<small><?php echo $recall['text']; ?></small>
										</td>
										<td class="text-left">
											<?php echo $recall['date_added']; ?>
										</td>
										<td class="text-left">
											<?php if ($recall['lastcall']) { ?>
												<?php echo $recall['lastcall']['time']; ?>
												<?php } else { ?>
												<small class="label label-danger"><small>Нет звонка</small></small>
											<?php } ?>
										</td>
										<td class="text-left">
											<?php if ($recall['lastcall']) { ?>
												<?php if ($recall['lastcall']['status'] == 'ANSWERED') {?>
													<small class="label label-success"><small><?php echo $recall['lastcall']['status']; ?></small></small>
													<? } else { ?>
													<small class="label label-warning"><small><?php echo $recall['lastcall']['status']; ?></small></small>
												<?php } ?>
												<?php } else { ?>
												<small class="label label-danger"><small>Нет звонка</small></small>
											<?php } ?>
										</td>
										
										<td class="text-left">
											<?php if ($recall['listcalls']) { ?>
												<?php foreach ($recall['listcalls'] as $listcall) { ?>
													<?php echo $listcall['time']; ?>, <?php echo $listcall['timediff']; ?> мин, 
													<?php if ($recall['lastcall']['status'] == 'ANSWERED') {?>
														<small class="label label-success"><small><?php echo $recall['lastcall']['status']; ?></small></small>
														<? } else { ?>
														<small class="label label-warning"><small><?php echo $recall['lastcall']['status']; ?></small></small>
													<?php } ?><br />
												<?php } ?>
												<?php } else { ?>
												<small class="label label-danger"><small>Не было</small></small>
											<?php } ?>
										</td>	
										
										<td class="text-left">
											<?php if ($recall['lastcall']) { ?>
												<?php echo $recall['lastcall']['timediff']; ?> мин.
												<?php } else { ?>
												<small class="label label-danger"><small>Нет звонка</small></small>
											<?php } ?>
										</td>	
										<td class="text-left">
											<?php if ($recall['lastcall']) { ?>
												<a href="<?php echo $recall['lastcall']['record']; ?>" target="_blank">запись</a>
												<?php } else { ?>
												<small class="label label-danger"><small>Нет звонка</small></small>
											<?php } ?>
										</td>
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
		$('#button-shipping, #button-invoice').prop('disabled', true);
		
		var selected = $('input[name^=\'selected\']:checked');
		
		if (selected.length) {
			$('#button-invoice').prop('disabled', false);
		}
		
		for (i = 0; i < selected.length; i++) {
			if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
				$('#button-shipping').prop('disabled', false);
				
				break;
			}
		}
	});
	
	$('#button-shipping, #button-invoice').prop('disabled', true);
	
	$('input[name^=\'selected\']:first').trigger('change');
	
	// IE and Edge fix!
	$('#button-shipping, #button-invoice').on('click', function(e) {
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
<?php echo $footer; ?>										