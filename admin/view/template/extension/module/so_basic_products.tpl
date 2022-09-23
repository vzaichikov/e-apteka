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
				<?php //Nav tabs ?>
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
							<div class="form-group"> <?php // Module Name?>
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
							<div class="form-group"> <?php // Header title?>
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
							<div class="form-group"> <?php // Display header title?>
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
							<div class="form-group"> <?php // Status?>
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
									<a href="#so_module_source_option" data-toggle="tab">
										<?php echo $objlang->get('entry_source_option') ?>
									</a>
								</li>
								<li>
									<a href="#so_module_product_option" data-toggle="tab">
										<?php echo $objlang->get('entry_product_option') ?>
									</a>
								</li>
								<li>
									<a href="#so_module_image_option" data-toggle="tab">
										<?php echo $objlang->get('entry_image_option') ?>
									</a>
								</li>
								<li>
									<a href="#advanced_option" data-toggle="tab">
										<?php echo $objlang->get('entry_advanced_option') ?>
									</a>
								</li>
							</ul>
							<div class="tab-content">
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_module"> <?php // General Option?>
									
									<?php if(isset($type_layout)):?>
									<div class="form-group"> <?php //====Theme Custom Code=====?>
											<label class="col-sm-3 control-label" for="input-open_link"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_type_layout'); ?>"><?php echo $objlang->get('entry_type_layout'); ?> </span></label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<select name="type_layout" id="input-type_layout" class="form-control">
														<?php
															foreach($type_layout as $option_id => $option_value)
															{
																$selected = ($option_id == $module['type_layout']) ? 'selected' :'';
														?>
																<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
														<?php
															}
														?>
													</select>
												</div>
											</div>
									</div>
									<?php endif; ?>
									
									<div class="form-group"> <?php // Class suffix ?>
									
										<label class="col-sm-3 control-label" for="input-class_suffix">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_class_suffix_desc'); ?>"><?php echo $objlang->get('entry_class_suffix'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="class_suffix" value="<?php echo $module['class_suffix']; ?>" id="input-class_suffix" class="form-control" />
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Open link ?>
										<label class="col-sm-3 control-label" for="input-open_link">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_open_link_desc'); ?>"><?php echo $objlang->get('entry_open_link'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="item_link_target" id="input-open_link" class="form-control">
													<?php
														foreach($item_link_targets as $option_id => $option_value){
															$selected = ($option_id == $module['item_link_target']) ? 'selected' :'';
													?>
														<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Columns 1 ?>
										<label class="col-sm-3 control-label" for="input-column_1200">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column0_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column0" id="input-column_1200" class="form-control">
													<?php
													foreach($nb_columns as $option_id => $option_value){
															$selected = ($option_id == $module['nb_column0']) ? 'selected' :'';
													?>
														<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Columns 2 ?> 
										<label class="col-sm-3 control-label" for="input-column_992">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column1_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column1" id="input-column_992" class="form-control">
													<?php
													foreach($nb_columns as $option_id => $option_value){
														$selected = ($option_id == $module['nb_column1']) ? 'selected' :'';
													?>
														<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Columns 3 ?> 
										<label class="col-sm-3 control-label" for="input-column_768_991">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column2_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column2" id="input-column_768_992" class="form-control">
													<?php
													foreach($nb_columns as $option_id => $option_value){
														$selected = ($option_id == $module['nb_column2']) ? 'selected' :'';
													?>
														<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Columns 4 ?> 
										<label class="col-sm-3 control-label" for="input-column_480_767">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column3_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column3" id="input-column_480_767" class="form-control">
													<?php
													foreach($nb_columns as $option_id => $option_value) {
														$selected = ($option_id == $module['nb_column3']) ? 'selected' :'';
													?>
														<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Columns 5 ?>
										<label class="col-sm-3 control-label" for="input-column_0_479">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column4_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column4" id="input-column_0_479" class="form-control">
													<?php
													foreach($nb_columns as $option_id => $option_value){
														$selected = ($option_id == $module['nb_column4']) ? 'selected' :'';
													?>
														<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_source_option"> <?php // Source Option?>
									<div class="form-group"> <?php // Category ?>
										<label class="col-sm-3 control-label" for="input-category">
											<b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_category_desc'); ?>"><?php echo $objlang->get('entry_category'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="category" value="" placeholder="<?php echo $objlang->get('entry_category'); ?>" id="input-category" class="form-control" />
												<div id="featured-category" class="well well-sm" style="height: 150px; overflow: auto;">
													<?php foreach ($module['categorys'] as $category) { ?>
														<div id="featured-category<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
														<input type="hidden" name="category[]" value="<?php echo $category['category_id']; ?>" />
														</div>
													<?php } ?>
												</div>
											</div>
											<?php if (isset($error['category'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['category']; ?></div>
											<?php }?>
										</div>
									</div>
									<div class="form-group"> <?php // Child Category ?>
										<label class="col-sm-3 control-label" for="input-child_category">
											<b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_child_category_desc'); ?>"><?php echo $objlang->get('entry_child_category'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['child_category']) { ?>
													<input type="radio" name="child_category" value="1" checked="checked" />
													<?php echo $objlang->get('entry_include'); ?>
													<?php } else { ?>
													<input type="radio" name="child_category" value="1" />
													<?php echo $objlang->get('entry_include'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['child_category']) { ?>
													<input type="radio" name="child_category" value="0" checked="checked" />
													<?php echo $objlang->get('entry_exclude'); ?>
													<?php } else { ?>
													<input type="radio" name="child_category" value="0" />
													<?php echo $objlang->get('entry_exclude'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group" id="input-category_depth_form"> <?php // Category depth ?>
										<label class="col-sm-3 control-label" for="input-category_depth"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_category_depth_desc'); ?>"><?php echo $objlang->get('entry_category_depth'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="category_depth" value="<?php echo $module['category_depth']; ?>" id="input-category_depth" class="form-control" />
											</div>
											<?php if (isset($error['category_depth'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['category_depth']; ?></div>
											<?php }?>
										</div>
									</div>
									<div class="form-group"> <?php // Product Order ?>
										<label class="col-sm-3 control-label" for="input-product_order"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_product_order_desc'); ?>"><?php echo $objlang->get('entry_product_order'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="product_sort" id="input-product_order" class="form-control">
												<?php
												foreach($product_sorts as $option_id => $option_value){
													$selected = ($option_id == $module['product_sort']) ? 'selected' :'';
												?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
												<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Ordering ?>
										<label class="col-sm-3 control-label" for="input-ordering"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_ordering_desc'); ?>"><?php echo $objlang->get('entry_ordering'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="product_ordering" id="input-ordering" class="form-control">
												<?php
													foreach($product_orderings as $option_id => $option_value){
													$selected = ($option_id == $module['product_ordering']) ? 'selected' :'';
												?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
												<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Limitation ?>
										<label class="col-sm-3 control-label" for="input-limitation">
											<b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_limitation_desc'); ?>"><?php echo $objlang->get('entry_limitation'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="limitation" value="<?php echo $module['limitation']; ?>" id="input-limitation" class="form-control" />
											</div>
											<?php if (isset($error['limitation'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['limitation']; ?></div>
											<?php }?>
										</div>
									</div>
								</div>
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_product_option"> <?php // Product Option ?>
									<div class="form-group"> <?php // Display Title ?>
										<label class="col-sm-3 control-label" for="input-display_title">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_title_desc'); ?>"><?php echo $objlang->get('entry_display_title'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_title']) { ?>
													<input type="radio" name="display_title" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_title" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_title']) { ?>
													<input type="radio" name="display_title" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_title" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Title Maxlength ?>
										<label class="col-sm-3 control-label" for="input-title_maxlength"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_title_maxlength_desc'); ?>"><?php echo $objlang->get('entry_title_maxlength'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="title_maxlength" value="<?php echo $module['title_maxlength']; ?>" id="input-title_maxlength" class="form-control" />
											</div>
											<?php if (isset($error['title_maxlength'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['title_maxlength']; ?></div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group"> <?php // Display Description ?>
										<label class="col-sm-3 control-label" for="input-display_description"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_description_desc'); ?>"><?php echo $objlang->get('entry_display_description'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_description']) { ?>
													<input type="radio" name="display_description" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_description" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_description']) { ?>
													<input type="radio" name="display_description" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_description" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Display Maxlength ?>
										<label class="col-sm-3 control-label" for="input-description_maxlength"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_description_maxlength_desc'); ?>"><?php echo $objlang->get('entry_description_maxlength'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="description_maxlength" value="<?php echo $module['description_maxlength']; ?>" id="input-description_maxlength" class="form-control" />
											</div>
											<?php if (isset($error['description_maxlength'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['description_maxlength']; ?></div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group"> <?php // Display Price ?>
										<label class="col-sm-3 control-label" for="input-display_price"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_price_desc'); ?>"><?php echo $objlang->get('entry_display_price'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_price']) { ?>
													<input type="radio" name="display_price" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_price" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_price']) { ?>
													<input type="radio" name="display_price" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_price" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Display Add To Cart ?>
										<label class="col-sm-3 control-label" for="input-display_add_to_cart"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_add_to_cart_desc'); ?>"><?php echo $objlang->get('entry_display_add_to_cart'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_add_to_cart']) { ?>
													<input type="radio" name="display_add_to_cart" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_add_to_cart" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_add_to_cart']) { ?>
													<input type="radio" name="display_add_to_cart" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_add_to_cart" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Display Wishlist ?>
										<label class="col-sm-3 control-label" for="input-display_wishlist"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_wishlist_desc'); ?>"><?php echo $objlang->get('entry_display_wishlist'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_wishlist']) { ?>
													<input type="radio" name="display_wishlist" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_wishlist" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_wishlist']) { ?>
													<input type="radio" name="display_wishlist" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_wishlist" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Display Compare ?>
										<label class="col-sm-3 control-label" for="input-display_compare"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_compare_desc'); ?>"><?php echo $objlang->get('entry_display_compare'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_compare']) { ?>
													<input type="radio" name="display_compare" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_compare" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_compare']) { ?>
													<input type="radio" name="display_compare" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_compare" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Display Rating ?>
										<label class="col-sm-3 control-label" for="input-display_rating"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_rating_desc'); ?>"><?php echo $objlang->get('entry_display_rating'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_rating']) { ?>
													<input type="radio" name="display_rating" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_rating" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_rating']) { ?>
													<input type="radio" name="display_rating" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_rating" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Display Sale ?>
										<label class="col-sm-3 control-label" for="input-display_sale"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_sale_desc'); ?>"><?php echo $objlang->get('entry_display_sale'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_sale']) { ?>
													<input type="radio" name="display_sale" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_sale" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_sale']) { ?>
													<input type="radio" name="display_sale" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_sale" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Display New ?>
										<label class="col-sm-3 control-label" for="input-display_new"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_new_desc'); ?>"><?php echo $objlang->get('entry_display_new'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['display_new']) { ?>
													<input type="radio" name="display_new" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="display_new" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['display_new']) { ?>
													<input type="radio" name="display_new" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="display_new" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group" id="input-date_day_form"> <?php // New Date Day ?>
										<label class="col-sm-3 control-label" for="input-date_day"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_date_day_desc'); ?>"><?php echo $objlang->get('entry_date_day'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="date_day" value="<?php echo $module['date_day']; ?>" id="input-date_day" class="form-control" />
											</div>
											<?php if (isset($error['date_day'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['date_day']; ?></div>
											<?php }?>
										</div>
									</div>
									<div class="form-group"> <?php // Number Product Image ?>
										<label class="col-sm-3 control-label" for="input-product_image_num"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_product_image_num_desc'); ?>"><?php echo $objlang->get('entry_product_image_num'); ?> </span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="product_image_num" id="input-product_image_num" class="form-control">
													<?php
													foreach($product_image_nums as $option_id => $option_value)
													{
													$selected = ($option_id == $module['product_image_num']) ? 'selected' :'';
													?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
								
								</div>
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="so_module_image_option">  <?php // Image Option?>
									<div class="form-group"> <?php // Product Image?>
										<label class="col-sm-3 control-label" for="input-product_image">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_product_image_desc'); ?>"><?php echo $objlang->get('entry_product_image'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['product_image']) { ?>
													<input type="radio" name="product_image" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="product_image" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['product_image']) { ?>
													<input type="radio" name="product_image" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="product_image" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Product Get Image From Tab Data?>
										<label class="col-sm-3 control-label" for="input-product_get_image_data">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_product_get_image_data_desc'); ?>"><?php echo $objlang->get('entry_product_get_image_data'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['product_get_image_data']) { ?>
													<input type="radio" name="product_get_image_data" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="product_get_image_data" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['product_get_image_data']) { ?>
													<input type="radio" name="product_get_image_data" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="product_get_image_data" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Product Get Image From Tab Image ?>
										<label class="col-sm-3 control-label" for="input-product_get_image_image">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_product_get_image_image_desc'); ?>"><?php echo $objlang->get('entry_product_get_image_image'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['product_get_image_image']) { ?>
													<input type="radio" name="product_get_image_image" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="product_get_image_image" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['product_get_image_image']) { ?>
													<input type="radio" name="product_get_image_image" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="product_get_image_image" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Image width?>
										<label class="col-sm-3 control-label" for="input-width">
											<b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_width_desc'); ?>"><?php echo $objlang->get('entry_width'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="width" value="<?php echo $module['width']; ?>" id="input-width" class="form-control" />
											</div>
											<?php if (isset($error['width'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['width']; ?></div>
											<?php }?>
										</div>
									</div>
									<div class="form-group"> <?php // Image height?>
										<label class="col-sm-3 control-label" for="input-height">
											<b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_height_desc'); ?>"><?php echo $objlang->get('entry_height'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="height" value="<?php echo $module['height']; ?>" id="input-height" class="form-control" />
											</div>
											<?php if (isset($error['height'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['height']; ?></div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group"> <?php // Placeholder Path?>
										<label class="col-sm-3 control-label" for="input-product_placeholder_path">
											<b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_product_placeholder_path_desc'); ?>"><?php echo $objlang->get('entry_product_placeholder_path'); ?></span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="product_placeholder_path" value="<?php echo $module['product_placeholder_path']; ?>" id="input-product_placeholder_path" class="form-control" />
											</div>
											<?php if (isset($error['product_placeholder_path'])) { ?>
											<div class="text-danger col-sm-12"><?php echo $error['product_placeholder_path']; ?></div>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php // -----------------------------------------------------------------------?>
								<div class="tab-pane" id="advanced_option"> <?php // Advanced Option?>
									<div class="form-group"> <?php // Pre-text?>
										<label class="col-sm-3 control-label" for="input-pre_text"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_pre_text_desc'); ?>"><?php echo $objlang->get('entry_pre_text'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<textarea name="pre_text" id="input-pre_text" class="form-control"><?php echo $module['pre_text']; ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Post-text?>
										<label class="col-sm-3 control-label" for="input-post_text"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_post_text_desc'); ?>"><?php echo $objlang->get('entry_post_text'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<textarea name="post_text" id="input-post_text" class="form-control"><?php echo $module['post_text']; ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php // Use Cache?>
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
									<div class="form-group" id="input-cache_time_form"> <?php // Cache Time?>
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
							</div> <?php //.tab-content?>
						</div> <?php //.tab-pane?>
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
				url: 'index.php?route=extension/module/so_basic_products/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
	if($("input[name='child_category']:radio:checked").val() == '0'){
		$('#input-category_depth_form').hide();
	}else{
		$('#input-category_depth_form').show();
	}

	$("input[name='child_category']").change(function(){
		val = $(this).val();
		if(val ==0){
			$('#input-category_depth_form').hide();
		}else{
			$('#input-category_depth_form').show();
		}
	});
	if($("input[name='use_cache']:radio:checked").val() == '0'){
		$('#input-cache_time_form').hide();
	}else{
		$('#input-cache_time_form').show();
	}
	$("input[name='use_cache']").change(function(){
		val = $(this).val();
		if(val ==0){
			$('#input-cache_time_form').hide();
		}else{
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
	if($("input[name='display_new']:radio:checked").val() == '0'){
		$('#input-date_day_form').hide();
	}else	{
		$('#input-date_day_form').show();
	}
	$("input[name='display_new']").change(function(){
		val = $(this).val();
		if(val ==0)		{
			$('#input-date_day_form').hide();
		}else		{
			$('#input-date_day_form').show();
		}
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
<?php echo $footer; ?>