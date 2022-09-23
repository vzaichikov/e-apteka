<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save'); ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $objlang->get('entry_button_save')?></button>
				<a class="btn btn-success" onclick="$('#action').val('save_edit');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_edit'); ?>" ><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('entry_button_save_and_edit')?></a>
				<a class="btn btn-info" onclick="$('#action').val('save_new');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_new'); ?>" ><i class="fa fa-book"></i>  <?php echo $objlang->get('entry_button_save_and_new')?></a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_cancel'); ?>" class="btn btn-danger"><i class="fa fa-reply"></i>  <?php echo $objlang->get('entry_button_cancel')?></a>
			</div>
			<h1><?php echo $objlang->get('heading_title_so'); ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if (isset($error['warning'])) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['warning']; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_layout; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $subheading; ?></h3>
		</div>
		<div class="panel-body">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
				<div class="row">
					<ul class="nav nav-tabs" role="tablist">
						<li <?php if( $selectedid ==0 ) { ?>class="active" <?php } ?>> <a href="<?php echo $link; ?>"> <span class="fa fa-plus"></span> <?php echo $objlang->get('button_add_module');?></a></li>
						<?php $i=1; foreach( $moduletabs as $key => $module ){ ?>
						<li role="presentation" <?php if( $module['module_id']==$selectedid ) { ?>class="active"<?php } ?>>
						<a href="<?php echo $link; ?>&module_id=<?php echo $module['module_id']?>" aria-controls="bannermodule-<?php echo $key; ?>"  >
							<span class="fa fa-pencil"></span> <?php echo $module['name']?>
						</a>
						</li>
						<?php $i++ ;} ?>
					</ul>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<?php $module_row = 1; ?>
						<?php foreach ($modules as $module) { ?>
						<?php if( $selectedid ){ ?>
						<div class="pull-right">
							<a href="<?php echo $action;?>&delete=1" class="remove btn btn-danger" ><span><i class="fa fa-remove"></i> <?php echo $objlang->get('entry_button_delete');?></span></a>
						</div>
						<?php } ?>
						<div  id="tab-module<?php echo $module_row; ?>" class="col-sm-12">
							<div class="form-group"> <?php //<!-- Module Name--> ?>
								<input type="hidden" name="action" id="action" value=""/>
								<label class="col-sm-3 control-label" for="input-name"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_name_desc'); ?>"><?php echo $objlang->get('entry_name'); ?> </span></label>
								<div class="col-sm-9">
									<div class="col-sm-5">
										<input type="text" name="name" value="<?php echo $module['name']; ?>" placeholder="<?php echo $objlang->get('entry_name'); ?>" id="input-name" class="form-control" />
									</div>
									<?php if (isset($error['name'])) { ?>
									<div class="text-danger col-sm-12"><?php echo $error['name']; ?></div>
									<?php }?>
								</div>
							</div>
							<div class="form-group"> <?php //<!-- Header title--> ?>
								<label class="col-sm-3 control-label" for="input-head_name"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_head_name_desc'); ?>"><?php echo $objlang->get('entry_head_name'); ?> </span></label>
								<div class="col-sm-9">
									<div class="col-sm-5">
										<?php
											$i = 0;
											foreach ($languages as $language) { $i++; ?>
										<input type="text" name="module_description[<?php echo $language['language_id']; ?>][head_name]" placeholder="<?php echo $objlang->get('entry_head_name'); ?>" id="input-head-name-<?php echo $language['language_id']; ?>" value="<?php echo isset($module_description[$language['language_id']]['head_name']) ? $module_description[$language['language_id']]['head_name'] : ''; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
										<?php
												 if($i == 1){ ?>
										<input type="hidden" class="form-control" id="input-head_name" placeholder="<?php echo $objlang->get('entry_head_name'); ?>" value="<?php echo isset($module_description[$language['language_id']]['head_name']) ? $module_description[$language['language_id']]['head_name'] : ''; ?>" name="head_name">
										<?php }
												 ?>
										<?php } ?>
									</div>
									<div class="col-sm-3">
										<select  class="form-control" id="language">
											<?php foreach ($languages as $language) { ?>
											<option value="<?php echo $language['language_id']; ?>"> 
												<?php echo $language['name']; ?>
											</option>
											<?php } ?>
										</select>
									</div>
									<?php if (isset($error['head_name'])) { ?>
									<div class="text-danger col-sm-12"><?php echo $error['head_name']; ?></div>
									<?php }?>
								</div>
							</div>
							<div class="form-group"> <?php //<!--Display header title --> ?>
								<label class="col-sm-3 control-label" for="input-disp_title_module"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_title_module_desc'); ?>"><?php echo $objlang->get('entry_display_title_module'); ?> </span></label>
								<div class="col-sm-9">
									<div class="col-sm-5">
										<select name="disp_title_module" id="input-disp_title_module" class="form-control">
											<?php
											if ($module['disp_title_module']) { ?>
											<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
											<option value="0"><?php echo $objlang->get('text_no'); ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
											<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group"> <?php //<!--Status --> ?>
								<label class="col-sm-3 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $objlang->get('entry_status_desc'); ?>"><?php echo $objlang->get('entry_status'); ?> </span></label>
								<div class="col-sm-9">
									<div class="col-sm-5">
										<select name="status" id="input-status" class="form-control">
											<?php if ($module['status']) { ?>
											<option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
											<option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
											<option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane">
							<ul class="nav nav-tabs" id="so_youtech">
								<li>
									<a href="#so_module_module" data-toggle="tab">
										<?php echo $objlang->get('entry_module') ?>
									</a>
								</li>
								<li>
									<a href="#so_module_base_option" data-toggle="tab">
										<?php echo $objlang->get('entry_base_option') ?>
									</a>
								</li>
								<li>
									<a href="#so_module_attribute_option" data-toggle="tab">
										<?php echo $objlang->get('entry_attribute_option') ?>
									</a>
								</li>
								<li>
									<a href="#so_module_option_option" data-toggle="tab">
										<?php echo $objlang->get('entry_option_option') ?>
									</a>
								</li>
							</ul>
							<div class="tab-content">
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_module"> <?php //<!--General Option --> ?> 
									<div class="form-group"> <?php //<!--Class suffix --> ?>
										<label class="col-sm-3 control-label" for="input-class_suffix">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_class_suffix_desc'); ?>"><?php echo $objlang->get('entry_class_suffix'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="class_suffix" value="<?php echo $module['class_suffix']; ?>" id="input-class_suffix" class="form-control" />
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--In class --> ?>
										<label class="col-sm-3 control-label" for="input-in_class">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_in_class_desc'); ?>"><?php echo $objlang->get('entry_in_class'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="in_class" value="<?php echo $module['in_class']; ?>" id="input-in_class" class="form-control" />
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--use cache --> ?>
										<label class="col-sm-3 control-label" for="input-use_cache">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_use_cache_desc'); ?>"><?php echo $objlang->get('entry_use_cache'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['use_cache']) { ?>
													<input type="radio" name="use_cache" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="use_cache" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['use_cache']) { ?>
													<input type="radio" name="use_cache" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="use_cache" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group" id="input-cache_time_form"> <?php //<!--cache time --> ?>
										<label class="col-sm-3 control-label" for="input-cache_time">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_cache_time_desc'); ?>"><?php echo $objlang->get('entry_cache_time'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="cache_time" value="<?php echo $module['cache_time']; ?>" id="input-cache_time" class="form-control" />
											</div>
											<?php if (isset($error['cache_time'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['cache_time']; ?></div>
											<?php }?>
										</div>
									</div>
								</div>
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_base_option"> <?php // <!--Base Option -->?>
									<div class="form-group"> <?php //<!--Manufacturer --> ?>
										<div class="col-sm-3">
											<label class="col-sm-12 control-label"> 
												<?php echo $objlang->get('entry_manufacturer');?>
											</label>
											<div class="form-group" for="input-disp_manu_all">
												<div class="col-sm-6 col-sm-offset-6">
													<select name="disp_manu_all" id="input-disp_manu_all" class="form-control">
														<?php
														if ($module['disp_manu_all']) { ?>
														<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
														<option value="0"><?php echo $objlang->get('text_no'); ?></option>
														<?php } else { ?>
														<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
														<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-sm-9" style="border-left:#ccc 1px solid">
										<?php if(!empty($manufactures)){?>
											<?php foreach($manufactures as $item){ ?>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="input-disp_manu_id_<?php echo $item['manu_id'];?>"> 
														<?php echo $item['manu_name'];?>
													</label>
													<div class="col-sm-4">
														<select name="disp_manu_id_<?php echo $item['manu_id'];?>" id="input-disp_manu_id_<?php echo $item['manu_id'];?>" class="form-control">
															<?php
															if ($module['disp_manu_id_'.$item['manu_id']]) { ?>
															<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
															<option value="0"><?php echo $objlang->get('text_no'); ?></option>
															<?php } else { ?>
															<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
															<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											<?php } ?>
										<?php }?>	
										</div>
									</div>
									<div class="form-group"> <?php //<!--Price Product --> ?>
										<label class="col-sm-3 control-label" for="input-disp_pro_price">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_pro_price_desc'); ?>"><?php echo $objlang->get('entry_pro_price'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-4 col-sm-offset-2">
												<select name="disp_pro_price" id="input-disp_pro_price" class="form-control">
													<?php if ($module['disp_pro_price']) { ?>
													<option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } else { ?>
													<option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--Search --> ?>
										<label class="col-sm-3 control-label" for="input-disp_search_text">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_search_text_desc'); ?>"><?php echo $objlang->get('entry_search_text'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-4 col-sm-offset-2">
												<select name="disp_search_text" id="input-disp_search_text" class="form-control">
													<?php if ($module['disp_search_text']) { ?>
													<option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } else { ?>
													<option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-6">
												<label class="col-sm-6 control-label" for="input-character_search">
													<b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_character_search_desc'); ?>"><?php echo $objlang->get('entry_character_search'); ?> </span>
												</label>
												<div class="col-sm-6">
													<input type="text" name="character_search" value="<?php echo $module['character_search']; ?>" id="input-character_search" class="form-control" />
													<?php if (isset($error['character_search'])) { ?>
														<div class="text-danger col-sm-12"><?php echo $error['character_search']; ?></div>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--SubCategory --> ?>
										<label class="col-sm-3 control-label" for="input-disp_subcategory">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_subcategory_desc'); ?>"><?php echo $objlang->get('entry_subcategory'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-4 col-sm-offset-2">
												<select name="disp_subcategory" id="input-disp_subcategory" class="form-control">
													<?php if ($module['disp_subcategory']) { ?>
													<option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } else { ?>
													<option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--Reset All --> ?>
										<label class="col-sm-3 control-label" for="input-disp_reset_all">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_reset_all_desc'); ?>"><?php echo $objlang->get('entry_reset_all'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-4 col-sm-offset-2">
												<select name="disp_reset_all" id="input-disp_reset_all" class="form-control">
													<?php if ($module['disp_reset_all']) { ?>
													<option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } else { ?>
													<option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
													<option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_attribute_option"> <?php // <!--Attribute Option -->?>
								<?php if(!empty($attributes)){?>
									<?php foreach($attributes as $attribute_name => $attribute_arr){ ?>
										<div class="form-group">
											<div class="col-sm-3">
												<label class="col-sm-12 control-label" for="disp_att_group_id_<?php echo explode("_",$attribute_name)[0];?>"> 
													<?php echo explode("_",$attribute_name)[1];?>
												</label>
												<div class="form-group">
													<div class="col-sm-6 col-sm-offset-6">
														<select name="disp_att_group_id_<?php echo explode("_",$attribute_name)[0];?>" class="form-control" id="disp_att_group_id_<?php echo explode("_",$attribute_name)[0];?>">
															<?php
															if ($module['disp_att_group_id_'.explode("_",$attribute_name)[0]]) { ?>
															<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
															<option value="0"><?php echo $objlang->get('text_no'); ?></option>
															<?php } else { ?>
															<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
															<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
											
											<div class="col-sm-9" style="border-left:#ccc 1px solid">
												<?php foreach($attribute_arr as $item)
												{
												?>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="disp_att_id_<?php echo $item['attribute_id'];?>"> 
															<?php echo $item['attribute_name'];?>
														</label>
														<div class="col-sm-4">
															<select name="disp_att_id_<?php echo $item['attribute_id'];?>" class="form-control" id="disp_att_id_<?php echo $item['attribute_id'];?>">
																<?php
																if ($module['disp_att_id_'.$item['attribute_id']]) { ?>
																<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
																<option value="0"><?php echo $objlang->get('text_no'); ?></option>
																<?php } else { ?>
																<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
																<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												<?php 
												}
												?>
												
											</div>
										</div>
									<?php } ?>
								<?php }?>
								</div>
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_option_option">  <?php // <!-- Option -->?>
								<?php if(!empty($options)){ ?>
									<?php foreach($options as $item)
									{?>
									<div class="form-group"> <!--Display radio option -->
										<label class="col-sm-3 control-label" for="disp_opt_id_<?php echo $item['option_id'];?>">
											<?php echo $item['option_name']?> 
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="disp_opt_id_<?php echo $item['option_id'];?>" class="form-control" id="disp_opt_id_<?php echo $item['option_id'];?>">
													<?php
													if ($module['disp_opt_id_'.$item['option_id']]) { ?>
													<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
													<option value="0"><?php echo $objlang->get('text_no'); ?></option>
													<?php } else { ?>
													<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
													<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<?php 
									}?>
								<?php }?>
								</div>
							<?php // -----------------------------------------------------------------------?>
							</div>
						</div>
						<?php $module_row++; ?>
					<?php } ?>
					</div>
				</div>
        	</form>
        </div>
    </div>	
  </div>
	<script type="text/javascript"><!--
	$('input[name=\'category\']').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=module/so_basic_products/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
		select: function(item) {
			$('input[name=\'category\']').val('');
			
			$('#featured-category' + item['value']).remove();
			
			$('#featured-category').append('<div id="featured-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category[]" value="' + item['value'] + '" /></div>');	
		}
	});
		
	$('#featured-category').delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});
//--></script>
	<script type="text/javascript"><!--
	$('#so_youtech a:first').tab('show');
	if($("input[name='child_category']:radio:checked").val() == '0')
	{
		$('#input-category_depth_form').hide();
	}else
	{
		$('#input-category_depth_form').show();
	}

	$("input[name='child_category']").change(function(){
		val = $(this).val();
		if(val ==0)
		{
			$('#input-category_depth_form').hide();
		}else
		{
			$('#input-category_depth_form').show();
		}
	});
	if($("input[name='use_cache']:radio:checked").val() == '0')
	{
		$('#input-cache_time_form').hide();
	}else
	{
		$('#input-cache_time_form').show();
	}
	$("input[name='use_cache']").change(function(){
		val = $(this).val();
		if(val ==0)
		{
			$('#input-cache_time_form').hide();
		}else
		{
			$('#input-cache_time_form').show();
		}
	});
	$('#language').change(function(){
		var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-head-name-'+opt_select);
		$('[id^="input-head-name-"]').addClass('hide');
		_input.removeClass('hide');
	});

	$('.first-name').change(function(){
		$('input[name="head_name"]').val($(this).val());
	});
//--></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			var button = '<div class="remove-caching" style="margin-left: 15px"><button type="button" onclick="remove_cache()" title="<?php echo $objlang->get('entry_button_clear_cache'); ?>" class="btn btn-danger"><i class="fa fa-remove"></i> <?php echo $objlang->get('entry_button_clear_cache')?></button></div>';
			var button_min = '<div class="remove-caching" style="margin-left: 7px"><button type="button" onclick="remove_cache()" title="<?php echo $objlang->get('entry_button_clear_cache'); ?>" class="btn btn-danger"><i class="fa fa-remove"></i> </button></div>';
			if($('#column-left').hasClass('active')){
				$('#column-left #stats').after(button);
			}else{
				$('#column-left #stats').after(button_min);
			}
			$('#button-menu').click(function(){
				$('.remove-caching').remove();
				if($(this).parents().find('#column-left').hasClass('active')){
					$('#column-left #stats').after(button);
				}else{
					$('#column-left #stats').after(button_min);
				}
			});
		});
		function remove_cache(){
			var success_remove = '<?php echo $success_remove; ?>';
			$.ajax({
				type: 'POST',
				url: '<?php echo $linkremove; ?>',
				data: {	is_ajax_cache_lite: 1},
				success: function () {
					var html = '<div class="alert alert-success cls-remove-cache"> '+success_remove+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
					if(!($('.page-header .container-fluid .alert-success')).hasClass('cls-remove-cache')){
						$('.page-header .container-fluid').append(html);
					}
				},
			});
		}
	</script>
</div>
<?php echo $footer; die("123");?>