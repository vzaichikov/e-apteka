<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-special" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-special" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
						<li><a href="#tab-special" data-toggle="tab"><?php echo $tab_special; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" id="language">
								<?php foreach ($languages as $language) { ?>
									<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
									<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
											<div class="col-sm-10">
												<input type="text" name="special_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_title[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
											<div class="col-sm-10">
												<input type="text" name="special_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_meta_title[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
											<div class="col-sm-10">
												<input type="text" name="special_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta-h1<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_meta_title[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
											<div class="col-sm-10">
												<textarea name="special_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
											<div class="col-sm-10">
												<textarea name="special_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
											<div class="col-sm-10">
												<textarea name="special_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['description'] : ''; ?></textarea>
												<?php if (isset($error_description[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label">Картинка<br /><i class="fa fa-info-circle"></i> для списка, 400 на 300</label>
											<div class="col-sm-3">
												<a href="" id="thumb-image-<?php echo $language['language_id']; ?>" data-toggle="image" class="img-thumbnail">
													
													<img src="<?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['thumb'] : $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
												</a>
												
												<input type="hidden" name="special_description[<?php echo $language['language_id']; ?>][image]" value="<?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['image'] : ''; ?>" id="input-image-<?php echo $language['language_id']; ?>" />
												
												
											</div>
											
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label">Баннер<br /><i class="fa fa-info-circle"></i> для страницы, 965 на 395</label>
											<div class="col-sm-3">
												<a href="" id="thumb-banner-<?php echo $language['language_id']; ?>" data-toggle="image" class="img-thumbnail">
													
													<img src="<?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['banner_thumb'] : $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
												</a>
												
												<input type="hidden" name="special_description[<?php echo $language['language_id']; ?>][banner]" value="<?php echo isset($special_description[$language['language_id']]) ? $special_description[$language['language_id']]['banner'] : ''; ?>" id="input-banner-<?php echo $language['language_id']; ?>" />
											</div>
										</div>
										
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="tab-pane" id="tab-data">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
								<div class="col-sm-10">
									<div class="well well-sm" style="height: 150px; overflow: auto;">
										<div class="checkbox">
											<label>
												<?php if (in_array(0, $special_store)) { ?>
													<input type="checkbox" name="special_store[]" value="0" checked="checked" />
													<?php echo $text_default; ?>
													<?php } else { ?>
													<input type="checkbox" name="special_store[]" value="0" />
													<?php echo $text_default; ?>
												<?php } ?>
											</label>
										</div>
										<?php foreach ($stores as $store) { ?>
											<div class="checkbox">
												<label>
													<?php if (in_array($store['store_id'], $special_store)) { ?>
														<input type="checkbox" name="special_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
														<?php echo $store['name']; ?>
														<?php } else { ?>
														<input type="checkbox" name="special_store[]" value="<?php echo $store['store_id']; ?>" />
														<?php echo $store['name']; ?>
													<?php } ?>
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
								<div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
									<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
								</div>								
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_banner; ?></label>
								<div class="col-sm-10"><a href="" id="thumb-banner" data-toggle="image" class="img-thumbnail"><img src="<?php echo $banner_thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
									<input type="hidden" name="banner" value="<?php echo $banner; ?>" id="input-banner" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
								<div class="col-sm-6">
									<div class="input-group date">
										<input type="text" name="date_added" value="<?php echo $date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
										<span class="input-group-btn">
											<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
										</span></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-date-added"><?php echo $entry_date_end; ?></label>
								<div class="col-sm-4">
									<div class="input-group date">
										<input type="text" name="date_end" value="<?php echo $date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
										<span class="input-group-btn">
											<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
										</span></div>
								</div>									
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
									<?php if ($error_keyword) { ?>
										<div class="text-danger"><?php echo $error_keyword; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-4">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-counter"><?php echo $entry_counter; ?></label>
								<div class="col-sm-10">
									<select name="counter" id="input-counter" class="form-control">
										<?php if ($counter) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-total"><?php echo $entry_total; ?></label>
								<div class="col-sm-10">
									<select name="total" id="input-total" class="form-control">
										<?php if ($total) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-show-title"><?php echo $entry_show_title; ?></label>
								<div class="col-sm-10">
									<select name="show_title" id="input-show-title" class="form-control">
										<?php if ($show_title) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
									<select name="status" id="input-status" class="form-control">
										<?php if ($status) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-special">
							<div class="table-responsive">
								<table id="special" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-center"><?php echo $column_image; ?></td>
											<td class="text-left"><?php echo $entry_product; ?></td>
											<td class="text-left"><?php echo $entry_current_price; ?></td>
											<td class="text-left"><?php echo $entry_current_special; ?></td>
											<td class="text-left"><?php echo $entry_price; ?></td>
											<td class="text-left"><?php echo $entry_percent; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php $special_row = 0; ?>
										<?php foreach ($special_products as $product) { ?>
											<tr id="special-row<?php echo $special_row; ?>">
												<td class="text-left">
													<img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
												</td>
												<td class="text-left" style="width: 60%;">
													<input type="text" name="special_product[<?php echo $special_row; ?>][name]" value="<?php echo $product['name']; ?>" placeholder="<?php echo $entry_product; ?>" class="form-control" />
												<input type="hidden" name="special_product[<?php echo $special_row; ?>][product_id]" value="<?php echo $product['product_id']; ?>" /></td>
												<td class="text-left">
													<span class="label label-success"><?php echo $product['current_price']; ?></span>
												</td>
												<td class="text-left">
													<?php foreach ($product['current_specials'] as $current_special) { ?>
														<span class="label label-danger"><?php echo $current_special['price']; ?></span><br />
													<?php } ?>
												</td>
												<td class="text-left" style="width: 10%;">
												<input type="text" name="special_product[<?php echo $special_row; ?>][price]" value="<?php echo $product['price']; ?>" placeholder="0" class="form-control" /></td>
												<td class="text-left" style="width: 10%;">
												<input type="text" name="special_product[<?php echo $special_row; ?>][percent]" value="<?php echo $product['percent']; ?>" placeholder="0" class="form-control" /></td>
												<td class="text-left"><button type="button" onclick="$('#special-row<?php echo $special_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
											</tr>
											<?php $special_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3"></td>
											<td class="text-left"><button type="button" onclick="addProduct();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript"><!--
		var special_row = <?php echo $special_row; ?>;
		
		function addProduct() {
			html  = '<tr id="special-row' + special_row + '">';
			html += '<td class="text-left"><span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span></td>';
			html += '  <td class="text-left" style="width: 60%;"><input type="text" name="special_product[' + special_row + '][name]" value="" placeholder="<?php echo $entry_product; ?>" class="form-control" /><input type="hidden" name="special_product[' + special_row + '][product_id]" value="" /></td>';
			html += '<td class="text-left"></td>';
			html += '<td class="text-left"></td>';
			html += '  <td class="text-left"><input type="text" name="special_product[' + special_row + '][price]" value="" placeholder="0" class="form-control" /></td>';
			html += ' <td class="text-left"><input type="text" name="special_product[' + special_row + '][percent]" value="" placeholder="0" class="form-control" /></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';
			
			$('#special tbody').append(html);
			
			special_autocomplete(special_row);
			
			special_row++;
		}
		
		function special_autocomplete(special_row) {
			$('input[name=\'special_product[' + special_row + '][name]\']').autocomplete({
				'source': function(request, response) {
					$.ajax({
						url: 'index.php?route=catalog/ochelp_special/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
						dataType: 'json',
						success: function(json) {
							response($.map(json, function(item) {
								return {
									label: item['name'],
									value: item['product_id']
								}
							}));
						}
					});
				},
				'select': function(item) {
					$('input[name=\'special_product[' + special_row + '][name]\']').val(item['label']);
					$('input[name=\'special_product[' + special_row + '][product_id]\']').val(item['value']);
				}
			});
		}
		
		$('#special tbody tr').each(function(index, element) {
			special_autocomplete(index);
		});
		
		<?php foreach ($languages as $language) { ?>
			<?php if ($ckeditor) { ?>
				ckeditorInit('input-description<?php echo $language['language_id']; ?>', '<?php echo $token; ?>');
				<?php } else { ?>
				$('#input-description<?php echo $language['language_id']; ?>').summernote({
					height: 300,
					lang:'<?php echo $lang; ?>'
				});
			<?php } ?>
		<?php } ?>
	//--></script> 
	<script type="text/javascript"><!--
		$('.date').datetimepicker({
			pickTime: false
		});
		$('#language a:first').tab('show');
	//--></script>
</div>
<?php echo $footer; ?>