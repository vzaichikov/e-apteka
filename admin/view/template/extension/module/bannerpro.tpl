<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-banner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-banner" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
						<div class="col-sm-10">
							<input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
							<?php if ($error_name) { ?>
								<div class="text-danger"><?php echo $error_name; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?> <i class="fa fa-desktop" aria-hidden="true"></i></label>
						<div class="col-sm-2">
							<input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
							<?php if ($error_width) { ?>
								<div class="text-danger"><?php echo $error_width; ?></div>
							<?php } ?>
						</div>
						<label class="col-sm-1 control-label" for="input-height"><?php echo $entry_height; ?> <i class="fa fa-desktop" aria-hidden="true"></i></label>
						<div class="col-sm-2">
							<input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
							<?php if ($error_height) { ?>
								<div class="text-danger"><?php echo $error_height; ?></div>
							<?php } ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-width_mobile"><?php echo $entry_width; ?> <i class="fa fa-mobile" aria-hidden="true"></i></label>
						<div class="col-sm-2">
							<input type="text" name="width_mobile" value="<?php echo $width_mobile; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
							<?php if ($error_width) { ?>
								<div class="text-danger"><?php echo $error_width; ?></div>
							<?php } ?>
						</div>
						<label class="col-sm-1 control-label" for="input-height_mobile"><?php echo $entry_height; ?> <i class="fa fa-mobile" aria-hidden="true"></i></label>
						<div class="col-sm-2">
							<input type="text" name="height_mobile" value="<?php echo $height_mobile; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
							<?php if ($error_height) { ?>
								<div class="text-danger"><?php echo $error_height; ?></div>
							<?php } ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
						<div class="col-sm-10">
							<input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
							<div id="banner-category" class="well well-sm" style="height: 150px; overflow: auto;">
								<?php foreach ($banner_categories as $category) { ?>
									<div id="banner-category<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
										<input type="hidden" name="categories[]" value="<?php echo $category['category_id']; ?>" />
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-animation"><?php echo $entry_animation; ?></label>
						<div class="col-sm-10">
							<select name="animation" id="input-animation" class="form-control">
								<option value="fade" <?php if ($animation == 'fade') { ?>selected="selected" <?php } ?>><?php echo $text_fade; ?></option>
								<option value="backSlide" <?php if ($animation == 'backSlide') { ?>selected="selected" <?php } ?>><?php echo $text_backslide; ?></option>
								<option value="goDown" <?php if ($animation == 'goDown') { ?>selected="selected" <?php } ?>><?php echo $text_godown; ?></option>
								<option value="fadeUp" <?php if ($animation == 'fadeUp') { ?>selected="selected" <?php } ?>><?php echo $text_fadeup; ?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-text"><?php echo $entry_text; ?></label>
						<div class="col-sm-10">
							<select name="text" id="input-text" class="form-control">
								<?php if ($text) { ?>
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
						<label class="col-sm-2 control-label" for="input-banner-bg"><?php echo $entry_banner_bg; ?></label>
						<div class="col-sm-8">
							<div class="input-group colorpicker-component">
								<input type="text" name="banner-bg" value="<?php echo $banner_bg; ?>" placeholder="<?php echo $entry_banner_bg; ?>" id="input-banner-bg" class="form-control" />
								<span class="input-group-addon"><i></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-texthover"><?php echo $entry_texthover; ?></label>
						<div class="col-sm-10">
							<select name="texthover" id="input-texthover" class="form-control">
								<?php if ($texthover) { ?>
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
						<label class="col-sm-2 control-label" for="input-navigation"><?php echo $entry_navigation; ?></label>
						<div class="col-sm-4">
							<select name="navigation" id="input-navigation" class="form-control">
								<?php if ($navigation == 'true') { ?>
									<option value="true" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="false"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="true"><?php echo $text_enabled; ?></option>
									<option value="false" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
						<label class="col-sm-2 control-label" for="input-pagination"><?php echo $entry_pagination; ?></label>
						<div class="col-sm-4">
							<select name="pagination" id="input-pagination" class="form-control">
								<?php if ($pagination == 'true') { ?>
									<option value="true" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="false"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="true"><?php echo $text_enabled; ?></option>
									<option value="false" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-mobile-image"><?php echo $entry_mobile; ?></label>
						<div class="col-sm-4">
							<select name="mobile_image" id="input-mobile-image" class="form-control">
								<?php if ($mobile_image) { ?>
									<option value="1" selected="selected"><?php echo $text_mobile_image; ?></option>
									<option value="0"><?php echo $text_mobile_text; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_mobile_image; ?></option>
									<option value="0" selected="selected"><?php echo $text_mobile_text; ?></option>
								<?php } ?>
							</select>
						</div>
						<label class="col-sm-2 control-label" for="input-hide-text"><?php echo $entry_hide_text; ?></label>
						<div class="col-sm-4">
							<select name="hide_text" id="input-hide-text" class="form-control">
								<?php if ($hide_text) { ?>
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
						<label class="col-sm-2 control-label" for="input-css-class"><?php echo $entry_css_class; ?></label>
						<div class="col-sm-4">
							<input type="text" name="css_class" value="<?php echo $css_class; ?>" placeholder="<?php echo $entry_css_class; ?>" id="input-css-class" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-4">
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
					<ul class="nav nav-tabs" id="language">
						<?php foreach ($languages as $language) { ?>
							<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
						<?php } ?>
					</ul>
					<div class="tab-content">
						<?php $image_row = 0; ?>
						<?php foreach ($languages as $language) { ?>
							<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
								<table id="images<?php echo $language['language_id']; ?>" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left">Айди для аналитики</td>
											<td class="text-left">Название</td>
											<td class="text-left"><?php echo $entry_link; ?></td>
											<td class="text-left"><?php echo $entry_image; ?> <i class="fa fa-desktop" aria-hidden="true"></i></td>
											<td class="text-left"><?php echo $entry_image; ?> <i class="fa fa-mobile" aria-hidden="true"></i></td>
											<td class="text-right"><?php echo $entry_sort_order; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($banner_images[$language['language_id']])) { ?>
											<?php foreach ($banner_images[$language['language_id']] as $banner_image) { ?>
												<tr id="image-row<?php echo $image_row; ?>">
												
													<td class="text-left" style="width: 20%;">
														
														<input type="text" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][banner_analytics_id]" value="<?php echo $banner_image['banner_analytics_id']; ?>" placeholder="DUREX_PROMO_BANNER" class="form-control" />
														
														<?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>
															<div class="text-danger"><?php echo $error_banner_image[$image_row][$language['language_id']]; ?></div>
														<?php } ?>
													</td>
												
													<td class="text-left" style="width: 20%;">
													
														<input type="text" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][banner_image_description]" value="<?php echo $banner_image['banner_image_description']; ?>" placeholder="Durex Promo" class="form-control" />
														
														<?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>
															<div class="text-danger"><?php echo $error_banner_image[$image_row][$language['language_id']]; ?></div>
														<?php } ?>
													</td>
													<td class="text-left" style="width: 20%;"><input type="text" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][link]" value="<?php echo $banner_image['link']; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>
													
													<td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $banner_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
													<input type="hidden" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
													
													<td class="text-left"><a href="" id="thumb-image_mobile<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $banner_image['thumb_mobile']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
													<input type="hidden" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][image_mobile]" value="<?php echo $banner_image['image_mobile']; ?>" id="input-image_mobile<?php echo $image_row; ?>" /></td>
													
													<td class="text-right" style="width: 10%;"><input type="text" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][sort_order]" value="<?php echo $banner_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
													<td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
												</tr>
												<?php $image_row++; ?>
											<?php } ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4"></td>
											<td class="text-left"><button type="button" onclick="addImage('<?php echo $language['language_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_banner_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						<?php } ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	$(function() {
		$('.colorpicker-component').colorpicker();
	});
	// Category
	$('input[name=\'category\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['category_id']
						}
					}));
				}
			});
		},
		'select': function(item) {
			$('input[name=\'category\']').val('');
			
			$('#banner-category' + item['value']).remove();
			
			$('#banner-category').append('<div id="banner-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="categories[]" value="' + item['value'] + '" /></div>');
		}
	});
	
	$('#banner-category').delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});
	
	//Banner Images
	
	
	
	var image_row = <?php echo $image_row; ?>;
	
	function addImage(language_id) {
		html  = '<tr id="image-row' + image_row + '">';
		
		html += '  <td class="text-left" style="width: 20%;">';
		html += '   <input type="text" name="banner_image[' + language_id + '][' + image_row + '][banner_analytics_id]" value="" placeholder="DUREX_PROMO_BANNER" class="form-control" />';
		html += '  </td>';		
		
		html += '  <td class="text-left" style="width: 20%;">';
		html += '   <input type="text" name="banner_image[' + language_id + '][' + image_row + '][banner_image_description]" value="" placeholder="Durex Promo" class="form-control" />';
		html += '  </td>';	
		html += '  <td class="text-left" style="width: 20%;"><input type="text" name="banner_image[' + language_id + '][' + image_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>';	
		html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="banner_image[' + language_id + '][' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
		
		html += '  <td class="text-left"><a href="" id="thumb-image_mobile' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="banner_image[' + language_id + '][' + image_row + '][image_mobile]" value="" id="input-image_mobile' + image_row + '" /></td>';
		
		html += '  <td class="text-right" style="width: 10%;"><input type="text" name="banner_image[' + language_id + '][' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
		
		$('#images' + language_id + ' tbody').append(html);
		image_row++;
	}
	$('#language a:first').tab('show');
	//-->
</script>
<?php echo $footer; ?>