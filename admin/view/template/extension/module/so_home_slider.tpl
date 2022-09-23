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
                    <li role="presentation" <?php if( $module['module_id']==$selectedid ) {?>class="active"<?php } ?>>
                      <a href="<?php echo $link; ?>&module_id=<?php echo $module['module_id']?>" aria-controls="bannermodule-<?php echo $key; ?>"  >
                        <span class="fa fa-pencil"></span> <?php echo $module['name']?>
                       </a>
                      </li>
                    <?php $i++ ;} ?>
                  </ul>
                </div>
				<div class="row">
					<div class="col-sm-12">
						<div class="tab-pane">
							<ul class="nav nav-tabs" id="so_youtech">
								<li>
									<a href="#module" data-toggle="tab" onclick="$('#tab_module').val('add-module')">
										<?php echo $objlang->get('entry_module') ?>
									</a>
								</li>
								<?php if($selectedid){?>
								<li>
									<a href="#slider_option" data-toggle="tab" onclick="$('#tab_module').val('add-slide')">
										<?php echo $objlang->get('entry_slider_option') ?>
									</a>
								</li>
								<?php }?>
							</ul>
							<div class="tab-content">
								<div class="tab-pane" id="module">
								<?php $module_row = 1; ?>
								<?php foreach ($modules as $module) { ?>
								<?php if( $selectedid ){ ?>
									<div class="pull-right">
										<a href="<?php echo $link;?>&module_id=<?php echo $_GET['module_id']?>&delete=1" class="remove btn btn-danger" ><span><i class="fa fa-remove"></i> <?php echo $objlang->get('entry_button_delete');?></span></a>
									</div>
								<?php } ?>
								<div  id="tab-module<?php echo $module_row; ?>" class="col-sm-12">
									<div class="form-group"> <?php //<!-- Module Name--> ?>
										<input type="hidden" name="tab_module" id="tab_module" value=""/>
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
												<select  class="form-control" id="language_head-name">
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
													<?php  if ($module['status']) { ?>
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
									<div class="form-group"> <?php //<!--Class suffix --> ?>
										<label class="col-sm-3 control-label" for="input-class_suffix"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_class_suffix_desc'); ?>"><?php echo $objlang->get('entry_class_suffix'); ?> </span> </label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="class_suffix" value="<?php echo $module['class_suffix']; ?>" id="input-class_suffix" class="form-control" />
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--Open link--> ?>
										<label class="col-sm-3 control-label" for="input-open_link"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_open_link_desc'); ?>"><?php echo $objlang->get('entry_open_link'); ?> </span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="item_link_target" id="input-open_link" class="form-control">
													<?php 
														foreach($item_link_targets as $option_id => $option_value)
														{
															$selected = ($option_id == $module['item_link_target']) ? 'selected' :'';
													?>
															<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--column 1--> ?>
										<label class="col-sm-3 control-label" for="input-column_1200"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column0_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column0" id="input-column_1200" class="form-control">
													<?php
												foreach($nb_columns as $option_id => $option_value)
													{
													$selected = ($option_id == $module['nb_column0']) ? 'selected' :'';
													?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
													}
												?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--column 2--> ?>
										<label class="col-sm-3 control-label" for="input-column_992_1199"><span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column1_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column1" id="input-column_992_1199" class="form-control">
													<?php
												foreach($nb_columns as $option_id => $option_value)
													{
													$selected = ($option_id == $module['nb_column1']) ? 'selected' :'';
													?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
													}
												?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--column 3--> ?>
										<label class="col-sm-3 control-label" for="input-column_768_991"><span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column2_desc'); ?>"><?php echo $objlang->get('entry_column'); ?> </span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column2" id="input-column_768_991" class="form-control">
													<?php
												foreach($nb_columns as $option_id => $option_value)
													{
													$selected = ($option_id == $module['nb_column2']) ? 'selected' :'';
													?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
													}
												?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--column 4--> ?>
										<label class="col-sm-3 control-label" for="input-column_480_767"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column3_desc'); ?>"><?php echo $objlang->get('entry_column'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column3" id="input-column_480_767" class="form-control">
													<?php
												foreach($nb_columns as $option_id => $option_value)
													{
													$selected = ($option_id == $module['nb_column3']) ? 'selected' :'';
													?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
													}
												?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--column 5--> ?>
										<label class="col-sm-3 control-label" for="input-column_0_479"><span data-toggle="tooltip" title="<?php echo $objlang->get('entry_nb_column4_desc'); ?>"><?php echo $objlang->get('entry_column'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="nb_column4" id="input-column_0_479" class="form-control">
													<?php foreach($nb_columns as $option_id => $option_value)
													{
													$selected = ($option_id == $module['nb_column4']) ? 'selected' :'';
													?>
													<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
												}
											?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!-- width --> ?>
											<label class="col-sm-3 control-label" for="input-width"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_width_desc'); ?>"><?php echo $objlang->get('entry_width'); ?> </span></label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<input type="text" name="width" value="<?php echo $module['width']; ?>" id="input-width" class="form-control" />
												</div>
												<?php if (isset($error['width'])) { ?>
													<div class="text-danger col-sm-12"><?php echo $error['width']; ?></div>
												<?php }  ?>
											</div>
										</div>
									<div class="form-group"> <?php //<!-- height --> ?>
											<label class="col-sm-3 control-label" for="input-height"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_height_desc'); ?>"><?php echo $objlang->get('entry_height'); ?> </span></label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<input type="text" name="height" value="<?php echo $module['height']; ?>" id="input-height" class="form-control" />
												</div>								
												<?php if (isset($error['height'])) { ?>
													<div class="text-danger col-sm-12"><?php echo $error['height']; ?></div>
												<?php } ?>
											</div>
										</div>
									<div class="form-group"> <?php //<!--autoplay --> ?>
										<label class="col-sm-3 control-label" for="input-autoplay"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_autoplay_desc'); ?>"><?php echo $objlang->get('entry_autoplay'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['autoplay']) { ?>
													<input type="radio" name="autoplay" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="autoplay" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['autoplay']) { ?>
													<input type="radio" name="autoplay" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="autoplay" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--autoplay Timeout --> ?>
										<label class="col-sm-3 control-label" for="input-autoplayTimeout"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_autoplayTimeout_desc'); ?>"><?php echo $objlang->get('entry_autoplayTimeout'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="autoplayTimeout" value="<?php echo $module['autoplayTimeout']; ?>" id="input-autoplayTimeout" class="form-control" />
											</div>
											<?php if (isset($error['autoplayTimeout'])) { ?>
												<div class="text-danger col-sm-12"><?php echo $error['autoplayTimeout']; ?></div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group"> <?php //<!--autoplay Hover Pause --> ?>
										<label class="col-sm-3 control-label" for="input-autoplayHoverPause"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_autoplayHoverPause_desc'); ?>"><?php echo $objlang->get('entry_autoplayHoverPause'); ?></span></label>
										<div class="col-sm-9">	
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['autoplayHoverPause']) { ?>
													<input type="radio" name="autoplayHoverPause" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="autoplayHoverPause" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['autoplayHoverPause']) { ?>
													<input type="radio" name="autoplayHoverPause" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="autoplayHoverPause" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--autoplay Speed--> ?>
										<label class="col-sm-3 control-label" for="input-autoplaySpeed"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_autoplaySpeed_desc'); ?>"><?php echo $objlang->get('entry_autoplaySpeed'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="autoplaySpeed" value="<?php echo $module['autoplaySpeed']; ?>" id="input-autoplaySpeed" class="form-control" />
											</div>
											<?php if (isset($error['autoplaySpeed'])) { ?>
												<div class="text-danger col-sm-12"><?php echo $error['autoplaySpeed']; ?></div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group"> <?php //<!--start Position--> ?>
										<label class="col-sm-3 control-label" for="input-startPosition"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_startPosition_desc'); ?>"><?php echo $objlang->get('entry_startPosition'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<input type="text" name="startPosition" value="<?php echo $module['startPosition']; ?>" id="input-startPosition" class="form-control" />
											</div>
											<?php if (isset($error['startPosition'])) { ?>
												<div class="text-danger col-sm-12"><?php echo $error['startPosition']; ?></div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group"> <?php //<!--mouse Drag--> ?>
										<label class="col-sm-3 control-label" for="input-mouseDrag"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_mouseDrag_desc'); ?>"><?php echo $objlang->get('entry_mouseDrag'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['mouseDrag']) { ?>
													<input type="radio" name="mouseDrag" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="mouseDrag" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['mouseDrag']) { ?>
													<input type="radio" name="mouseDrag" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="mouseDrag" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--touch Drag--> ?>
										<label class="col-sm-3 control-label" for="input-touchDrag"><span data-toggle="tooltip" title="<?php echo $objlang->get('entry_touchDrag_desc'); ?>"><?php echo $objlang->get('entry_touchDrag'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['touchDrag']) { ?>
													<input type="radio" name="touchDrag" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="touchDrag" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['touchDrag']) { ?>
													<input type="radio" name="touchDrag" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="touchDrag" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--Loop--> ?>
										<label class="col-sm-3 control-label" for="input-loop">
											<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_loop_desc'); ?>">
												<?php echo $objlang->get('entry_loop'); ?>
											</span>
										</label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['loop']) { ?>
													<input type="radio" name="loop" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="loop" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['loop']) { ?>
													<input type="radio" name="loop" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="loop" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--dots--> ?>
										<label class="col-sm-3 control-label" for="input-dots"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_dots_desc'); ?>"><?php echo $objlang->get('entry_dots'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['dots']) { ?>
													<input type="radio" name="dots" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="dots" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['dots']) { ?>
													<input type="radio" name="dots" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="dots" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>	
									<div class="form-group"> <?php //<!--navs--> ?>
										<label class="col-sm-3 control-label" for="input-navs"><span data-toggle="tooltip" title="<?php echo $objlang->get('entry_navs_desc'); ?>"><?php echo $objlang->get('entry_navs'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<label class="radio-inline">
													<?php if ($module['navs']) { ?>
													<input type="radio" name="navs" value="1" checked="checked" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } else { ?>
													<input type="radio" name="navs" value="1" />
													<?php echo $objlang->get('text_yes'); ?>
													<?php } ?>
												</label>
												<label class="radio-inline">
													<?php if (!$module['navs']) { ?>
													<input type="radio" name="navs" value="0" checked="checked" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } else { ?>
													<input type="radio" name="navs" value="0" />
													<?php echo $objlang->get('text_no'); ?>
													<?php } ?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--animateOut--> ?>
										<label class="col-sm-3 control-label" for="input-animateOut"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_animateOut_desc'); ?>"><?php echo $objlang->get('entry_animateOut'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="animateOut" id="input-animateOut" class="form-control">
													<?php 
													foreach($animateOuts as $option_id => $option_value)
														{
															$selected = ($option_id == $module['animateOut']) ? 'selected' :'';
													?>
															<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--animateIn--> ?>
										<label class="col-sm-3 control-label" for="input-animateIn"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_animateIn_desc'); ?>"><?php echo $objlang->get('entry_animateIn'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<select name="animateIn" id="input-animateIn" class="form-control">
													<?php 
													foreach($animateIns as $option_id => $option_value)
														{
															$selected = ($option_id == $module['animateIn']) ? 'selected' :'';
													?>
															<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--Pre-text--> ?>
										<label class="col-sm-3 control-label" for="input-pre_text"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_pre_text_desc'); ?>"><?php echo $objlang->get('entry_pre_text'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<textarea name="pre_text" id="input-pre_text" class="form-control"><?php echo $module['pre_text']; ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group"> <?php //<!--Post-text--> ?>
										<label class="col-sm-3 control-label" for="input-post_text"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_post_text_desc'); ?>"><?php echo $objlang->get('entry_post_text'); ?></span></label>
										<div class="col-sm-9">
											<div class="col-sm-5">
												<textarea name="post_text" id="input-post_text" class="form-control"><?php echo $module['post_text']; ?></textarea>
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
								<?php $module_row++; ?>
								<?php } ?>
							<?php //----------------------------------------------------------------------- ?>
								</div>
								<?php if($selectedid){?>
								<div class="tab-pane" id="slider_option">
									<div class = "col-md-12">
										<div class="form-group"> <?php //<!-- Image slide--> ?>
											<label class="col-sm-2 control-label" for="input-slide_title"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_image_desc'); ?>"><?php echo $objlang->get('entry_image'); ?> </span></label>
											<div class="col-sm-10">
												<div class="col-sm-5">
													<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo isset($slide_description['thumb']) ? $slide_description['thumb'] : $module['thumb']; ?>" alt="" title="" data-placeholder="<?php echo isset($slide_description['thumb']) ? $slide_description['thumb'] : $module['thumb']; ?>" /></a>
													<input type="hidden" name="image" value="<?php echo isset($slide_description['image']) ? $slide_description['image'] : ''; ?>" id="input-image" />
													
												</div>
												<?php if (isset($error['image'])) { ?>
													<div class="text-danger col-sm-12"><?php echo $error['image']; ?></div>
												<?php }?>
											</div>
										</div>
										<div class="form-group"> <?php //<!--Link --> ?>
											<label class="col-sm-2 control-label" for="input-link"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_link_desc'); ?>"><?php echo $objlang->get('entry_link'); ?> </span> </label>
											<div class="col-sm-10">
												<div class="col-sm-5">
													<input type="text" name="slide_link" value="<?php echo isset($slide_description['url']) ? $slide_description['url'] : ''; ?>" id="input-link" class="form-control" />
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--Status slide --> ?>
											<label class="col-sm-2 control-label" for="input-slide_status"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_status_slide_desc'); ?>"><?php echo $objlang->get('entry_status'); ?> </span></label>
											<div class="col-sm-10">
												<div class="col-sm-5">
													<select name="slide_status" id="input-slide_status" class="form-control">
														<?php
														if (isset($slide_description['status']) && $slide_description['status']) { ?>
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
									</div>
									<div class = "col-md-12">
										<ul class="nav nav-tabs" id="language">
											<?php foreach ($languages as $language) { ?>
											<li>
												<a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab">
													<?php if(version_compare(VERSION, '2.1.0.2', '>')) { ?>
														<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
													<?php } else { ?>
														<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> 
													<?php }?>
													
													<?php echo $language['name']; ?>
												</a>
											</li>
											<?php } ?>
										</ul>
										<div class="tab-content">
										<?php foreach ($languages as $language) { ?>
											<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
												<div class="form-group"> <?php //<!-- Slide title--> ?>
												<label class="col-sm-2 control-label" for="input-slide_title"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_slide_title_desc'); ?>"><?php echo $objlang->get('entry_slide_title'); ?> </span></label>
													<div class="col-sm-10">
														<div class="col-sm-5">
															<input type="text" name="slide_description[<?php echo $language['language_id']; ?>][slide_title]" placeholder="<?php echo $objlang->get('entry_slide_title'); ?>" id="input-slide_title-<?php echo $language['language_id']; ?>" value="<?php echo isset($slide_description[$language['language_id']]['title']) ? $slide_description[$language['language_id']]['title'] : ''; ?>" class="form-control" />
															<input type="hidden" name="slide_description[<?php echo $language['language_id']; ?>][language_id]" value="<?php echo $language['language_id']; ?>" />
														</div>
														<?php if (isset($error['slide_title'])) { ?>
															<div class="text-danger col-sm-12"><?php echo $error['slide_title']; ?></div>
														<?php }?>
													</div>
												</div>
												<div class="form-group"> <?php //<!--Caption --> ?>
													<label class="col-sm-2 control-label" for="input-caption"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_caption_desc'); ?>"><?php echo $objlang->get('entry_caption'); ?> </span> </label>
													<div class="col-sm-10">
														<div class="col-sm-5">
															<input type="text" name="slide_description[<?php echo $language['language_id']; ?>][slide_caption]" placeholder="<?php echo $objlang->get('entry_caption'); ?>" id="input-slide_caption-<?php echo $language['language_id']; ?>" value="<?php echo isset($slide_description[$language['language_id']]['caption']) ? $slide_description[$language['language_id']]['caption'] : ''; ?>" class="form-control " />
														</div>
													</div>
												</div>
												<div class="form-group"> <?php //<!--Description --> ?>
													<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_description_desc'); ?>"><?php echo $objlang->get('entry_description'); ?> </span></label>
													<div class="col-sm-10">
														<div class="col-sm-12">
															<textarea name="slide_description[<?php echo $language['language_id']; ?>][slide_desciption]"  id="input-slide_desciption-<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($slide_description[$language['language_id']]['description']) ? $slide_description[$language['language_id']]['description'] : ''; ?> </textarea>
														</div>
													</div>
												</div>
											</div>
										<?php }?>
										</div>
									</div>
									<div id="slidesContent" class="col-md-12" style="border:#ccc 1px solid; padding:10px; background:#f5f5f5">
										<h3 style="text-align:center;background:#4e9e41; color:#fff; padding: 10px;font-weight:bold"><?php echo $objlang->get('label_listslide')?></h3>
										<div id="slides">
											<?php foreach ($slides as $slide) {?>
												<div id="slides_<?php echo $slide['id']?>" class="panel" style="border:#ccc 1px solid; padding:10px;">
													<div class="row">
														<div class="col-lg-1">
															<span><i class="fa fa-arrows "></i></span>
														</div>
														<div class="col-md-3">
															<img src="<?php echo $slide['image']?>" alt="" class="img-thumbnail" />
														</div>
														<div class="col-md-8">
															<h4 class="pull-left">
																#<?php echo $slide['id']?> - <?php echo $slide['title']?>
															</h4>
															<div class="btn-group-action pull-right">
																<?php if($slide['status'])?>

																<a class="btn btn-default"
																	href="<?php echo $link;?>&slide_id=<?php echo $slide['id']?>&tab=slide&module_id=<?php echo $module['moduleid']?>">
																	<i class="fa fa-edit"></i>
																	Edit
																</a>
																<a class="btn btn-default"
																	href="<?php echo $link;?>&slide_id=<?php echo $slide['id']?>&tab=slide&module_id=<?php echo $module['moduleid']?>&delete=1">
																	<i class="fa fa-trash"></i>
																	Delete
																</a>
															</div>
														</div>
													</div>
												</div>
											<?php }?>
										</div>
									</div>

								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
    </div>	
  </div>
 <?php if($selectedid){?>


<script>
  $(function() {
    $( "#slides" ).sortable({
		update: function(event, ui) {        
		var arr = $(this).sortable('toArray');
		$.ajax({
			url: 'index.php?route=module/so_home_slider/sortposition&token=<?php echo $token; ?>&sortarray=' +  arr,
			dataType: 'json'
		});
	  }
	});
    $( "#slides" ).disableSelection();
  });
  </script> 
<?php }?>
	<script type="text/javascript">
	<?php if(isset($_GET["tab"]) && $_GET["tab"] == "slide"){?>
	$('#so_youtech a:last').tab('show');
	<?php }else{?>
	$('#so_youtech a:first').tab('show');
	<?php }?>
	$('#language a:first').tab('show');
	if($("input[name='child_category']:radio:checked").val() == '0')
	{
		$('#input-category_depth_form').hide();
	}else
	{
		$('#input-category_depth_form').show();
	}
	$("input[name='child_category']:radio").change(function(){
		if($(this).val() == '0')
		{
			$('#input-category_depth_form').hide();
		}else
		{
			$('#input-category_depth_form').show();
		}
	});
		$('#language_head-name').change(function(){
			var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-head-name-'+opt_select);
			$('[id^="input-head-name-"]').addClass('hide');
			_input.removeClass('hide');
		});
		
		$('.first-name').change(function(){
			$('input[name="head-name"]').val($(this).val());
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
	</script>
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
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php echo $footer; ?>