<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-multiflat" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-multiflat" class="form-horizontal">
					<input type="hidden" name="multiflat_status" value="1">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-multiflat_name"><?php echo $text_multiflat_name; ?></label>
						<div class="col-sm-10">
							<input type="text" name="multiflat_name" value="<?php echo $multiflat_name; ?>" placeholder="<?php echo $text_multiflat_name; ?>" id="input-multiflat_name" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-multiflat_sort_order"><?php echo $text_multiflat_sort_order; ?></label>
						<div class="col-sm-10">
							<input type="text" name="multiflat_sort_order" value="<?php echo $multiflat_sort_order; ?>" placeholder="<?php echo $text_multiflat_sort_order; ?>" id="input-multiflat_sort_order" class="form-control" />
						</div>
					</div>
					<div class="table-responsive">
						<table id="module" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-center"><?php echo $entry_name; ?></td>
									<td class="text-center" width="50px"><?php echo $entry_cost; ?></td>
									<td class="text-center" width="50px"><?php echo $entry_min; ?></td>
									<td class="text-center" width="50px"><?php echo $entry_max; ?></td>
									<td class="text-center" width="70px">Беспл. от</td>
									<td class="text-center" width="50px"><?php echo $entry_tax_class; ?></td>
									<td class="text-center" width="50px"><?php echo $entry_geo_zone; ?></td>
									<td class="text-center" width="50px">Исключить кат.</td>
									<td class="text-center" width="50px">Стоимость кат.</td>
									<td class="text-center" width="50px">Это доставка</td>
									<td class="text-center" width="50px"><?php echo $entry_status; ?></td>
									<td class="text-center" style="width:30px;"><?php echo $entry_sort_order; ?></td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<?php $module_row = 0; ?>
								<?php foreach ($modules as $module) { ?>
									<tr id="module-row<?php echo $module_row; ?>">
										<td class="text-left"><input type="text" name="multiflat[<?php echo $module_row; ?>][name]" value="<?php echo $module['name']; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" /></td>
										<td class="text-left"><input type="text" name="multiflat[<?php echo $module_row; ?>][cost]" value="<?php echo $module['cost']; ?>" placeholder="<?php echo $entry_cost; ?>" class="form-control" /></td>
										<td class="text-left"><input type="text" name="multiflat[<?php echo $module_row; ?>][min]" value="<?php echo !empty($module['min']) ? $module['min'] : 0; ?>"  placeholder="<?php echo $entry_min; ?>" class="form-control" /></td>
										<td class="text-left"><input type="text" name="multiflat[<?php echo $module_row; ?>][max]" value="<?php echo !empty($module['max']) ? $module['max'] : 0; ?>" placeholder="<?php echo $entry_max; ?>" class="form-control" /></td>
										
										<td class="text-left"><input type="text" name="multiflat[<?php echo $module_row; ?>][free_from]" value="<?php echo !empty($module['free_from']) ? $module['free_from'] : 0; ?>" placeholder="<?php echo $entry_max; ?>" class="form-control" /></td>
										
										<td class="text-left"><select name="multiflat[<?php echo $module_row; ?>][tax_class_id]" class="form-control">
											<option value="0"><?php echo $text_none; ?></option>
											<?php foreach ($tax_classes as $tax_class) { ?>
												<?php if ($tax_class['tax_class_id'] == $module['tax_class_id']) { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select></td>
										<td class="text-left"><select name="multiflat[<?php echo $module_row; ?>][geo_zone_id]" class="form-control">
											<option value="0"><?php echo $text_all_zones; ?></option>
											<?php foreach ($geo_zones as $geo_zone) { ?>
												<?php if ($geo_zone['geo_zone_id'] == $module['geo_zone_id']) { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select></td>
										<td class="text-left">
											<select name="multiflat[<?php echo $module_row; ?>][category_id]" class="form-control">
												<?php foreach ($categories as $category) { ?>
													<?php if ($category['category_id'] == $module['category_id']) { ?>
														<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
														<?php } else { ?>
														<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
										
										<td class="text-left"><input type="text" name="multiflat[<?php echo $module_row; ?>][category_cost]" value="<?php echo !empty($module['category_cost']) ? $module['category_cost'] : 0; ?>" placeholder="<?php echo $entry_max; ?>" class="form-control" /></td>
										
										<td class="text-right"><select name="multiflat[<?php echo $module_row; ?>][is_delivery]" class="form-control">
											<?php if ($module['is_delivery']) { ?>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select></td>
										
										<td class="text-right"><select name="multiflat[<?php echo $module_row; ?>][status]" class="form-control">
											<?php if ($module['status']) { ?>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select></td>																			
										
										<td class="text-right"><input type="text" name="multiflat[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
										<td class="text-left"><button type="button" onclick="$('#module-row<?php echo $module_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
									</tr>
									<?php $module_row++; ?>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="8"></td>
									<td class="text-left"><button type="button" onclick="addModule();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</form>
			</div>
		</div>		
	</div>
</div>
<script type="text/javascript"><!--
	var module_row = <?php echo $module_row; ?>;
	
	function addModule() {
		html  = '<tr id="module-row' + module_row + '">';
		html += '  <td class="text-left"><input type="text" name="multiflat[' + module_row + '][name]" placeholder="<?php echo $entry_name; ?>" class="form-control" /></td>';
		html += '  <td class="text-left"><input type="text" name="multiflat[' + module_row + '][cost]" placeholder="<?php echo $entry_cost; ?>" class="form-control" /></td>';
		html += '  <td class="text-left"><input type="text" name="multiflat[' + module_row + '][min]"  placeholder="<?php echo $entry_min; ?>" class="form-control" /></td>';
        html += '  <td class="text-left"><input type="text" name="multiflat[' + module_row + '][max]"  placeholder="<?php echo $entry_max; ?>" class="form-control" /></td>';
		html += '  <td class="text-left"><select name="multiflat[' + module_row + '][tax_class_id]" class="form-control">';
		html += '    <option value="0"><?php echo $text_none; ?></option>';
		<?php foreach ($tax_classes as $tax_class) { ?>
			html += '    <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
		<?php } ?>
		html += '    </select></td>';
		html += '  <td class="text-left"><select name="multiflat[' + module_row + '][geo_zone_id]" class="form-control">';
		html += '    <option value="0"><?php echo $text_all_zones; ?></option>';
		<?php foreach ($geo_zones as $geo_zone) { ?>
			html += '    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>';
		<?php } ?>
		html += '  </select></td>';
		html += '  <td class="text-right"><select name="multiflat[' + module_row + '][status]" class="form-control">';
		html += '    <option value="1"><?php echo $text_enabled; ?></option>';
		html += '    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
		html += '  </select></td>';
		html += '<td class="text-left">';
        html += 	 '<select name="multiflat[<?php echo $module_row; ?>][category_id]" class="form-control">';
		<?php foreach ($categories as $category) { ?>
			html +=  '<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>';
		<?php } ?>
   		html += '</select>';
		html += '</td>';
		html += '  <td class="text-right"><input type="text" name="multiflat[' + module_row + '][sort_order]" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" onclick="$(\'#module-row' + module_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
		
		
		$('#module tbody').append(html);
		
		module_row++;
	}
//--></script>
<?php echo $footer; ?>