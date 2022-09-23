<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save'); ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $objlang->get('entry_button_save')?></button>
				<a class="btn btn-success" onclick="$('#action').val('save_edit');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_edit'); ?>"><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('entry_button_save_and_edit')?></a>
				<a class="btn btn-info" onclick="$('#action').val('save_new');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_new'); ?>"><i class="fa fa-book"></i>  <?php echo $objlang->get('entry_button_save_and_new')?></a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_cancel'); ?>" class="btn btn-danger"><i class="fa fa-reply"></i>  <?php echo $objlang->get('entry_button_cancel')?></a>
			</div>
			<?php //div.pull-right ?>
			<h1><?php echo $objlang->get('heading_title_so_'); ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li>
					<a href="<?php echo $breadcrumb['href']; ?>">
						<?php echo $breadcrumb['text']; ?>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
		<?php //.container-fluid ?>
	</div>
	<?php //.page-header ?>
	<div class="container-fluid">
		<?php if (isset($error['warning'])) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
			<?php echo $error['warning']; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i>
			<?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<div class="alert alert-info"><i class="fa fa-info-circle"></i>
			<?php echo $text_layout; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $subheading; ?></h3>
			</div>
			<?php //div.panel-heading ?>
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
				<div class="panel-body">
					<?php // Nav tabs  ?>
					<div class="rows">
						<ul class="nav nav-tabs" role="tablist">
							<li <?php if( $selectedid==0 ) { ?>class="active"
								<?php } ?>>
								<a href="<?php echo $link; ?>"> <span class="fa fa-plus"></span>
									<?php echo $objlang->get('button_add_module');?>
								</a>
							</li>
							<?php $i=1; foreach( $moduletabs as $key => $module ){ ?>
							<li role="presentation" <?php if( $module[ 'module_id']==$selectedid ) { ?>class="active"
								<?php } ?>>
								<a href="<?php echo $link; ?>&module_id=<?php echo $module['module_id']?>">
									<span class="fa fa-pencil"></span>
									<?php echo $module['name']?>
								</a>
							</li>
							<?php $i++ ;} ?>
						</ul>
					</div>
					<?php //div.row ?>
					<div class="rows">
						<?php $module_row = 1; ?>
						<?php foreach ($modules as $key => $module) {?>
						<?php if( $selectedid ){ ?>
						<div class="pull-right">
							<a href="<?php echo $action;?>&delete=1" class="remove btn btn-danger"><span><i class="fa fa-remove"></i> <?php echo $objlang->get('entry_button_delete');?></span></a>
						</div>
						<?php //div.pull-right ?>
						<?php } ?>
						<div id="tab-module<?php echo $module_row; ?>" class="col-sm-12">
							<div class="form-group">
								<?php // Module Name ?>
								<input type="hidden" name="action" id="action" value="" />
								<textarea name="page_builder[<?php echo $key; ?>][config]" class="hidden-content-layout hide"><?php echo $module['page_builder'];?></textarea>
								<label class="col-sm-3 control-label" for="input-name"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_name_desc'); ?>"><?php echo $objlang->get('entry_name'); ?> </span></label>
								<div class="col-sm-9">
									<div class="col-sm-5">
										<input type="text" name="name" value="<?php echo $module['name']; ?>" placeholder="<?php echo $objlang->get('entry_name'); ?>" id="input-name" class="form-control" />

									</div>
									<?php if (isset($error['name'])) { ?>
									<div class="text-danger col-sm-12">
										<?php echo $error['name']; ?>
									</div>
									<?php }?>
								</div>
							</div>
							<div class="form-group">
								<?php // Status  ?>
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
							<hr>
						</div>
						<?php //div#tab-module ?>
						<div class="tab-pane">
							<div class="row">
								<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
									<div class="add-row-new col-lg-3" data-toggle="modal" data-target="#config_row" data-backdrop="static" data-keyboard="false"> <i class="fa fa-plus"></i>
										<?php echo $objlang->get('text_add_row'); ?>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
									<label class="col-sm-6 control-label"><span data-toggle="tooltip" title="<?php echo $objlang->get('text_show_number_col_desc'); ?>"><?php echo $objlang->get('text_show_number_col'); ?> </span></label>
									<div class="btn-group button-enablegrid col-sm-6">
										<button class="btn btn-default show-column" onclick="$('.layout-builder').addClass('show-column').removeClass('hide-column');" type="button"><span class="fa fa-check-square-o"></span></button>
										<button class="btn btn-default hide-column" onclick="$('.layout-builder').removeClass('show-column').addClass('hide-column');" type="button"><span class="fa fa-square-o"></span></button>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
									<label class="col-lg-4 control-label"><span data-toggle="tooltip" title="<?php echo $objlang->get('text_design_in_desc'); ?>"><?php echo $objlang->get('text_design_in'); ?> </span></label>
									<div class="btn-group change-screens col-lg-8">
										<button class="btn btn-default active so-page-screens" data-option="lg_col" type="button" data-placement="top" data-screensTitle="<?php echo $objlang->get('text_change_col_lg');?>"><span class="fa fa-desktop"></span></button>
										<button class="btn btn-default so-page-screens" data-option="md_col" type="button" data-placement="top" data-screensTitle="<?php echo $objlang->get('text_change_col_md');?>"><span class="fa fa-laptop"></span></button>
										<button class="btn btn-default so-page-screens" data-option="sm_col" type="button" data-placement="top" data-screensTitle="<?php echo $objlang->get('text_change_col_sm');?>"> <span class="fa fa-tablet"></span></button>
										<button class="btn btn-default so-page-screens" data-option="xs_col" type="button" data-placement="top" data-screensTitle="<?php echo $objlang->get('text_change_col_xs');?>"><span class="fa fa-mobile"></span> </button>
									</div>
									<?php //.btn-group change-screens ?>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
									<label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $objlang->get('text_import_data_desc'); ?>"><?php echo $objlang->get('text_import_data'); ?> </span></label>
									<div class="col-sm-6">
										<select name="import_theme" class="form-control">
											<option value="0"><?php echo $objlang->get('text_select_theme'); ?></option>
											<option value="1"><?php echo $objlang->get('text_theme_sportbike'); ?></option>
											<option value="2"><?php echo $objlang->get('text_theme_computer'); ?></option>
										</select>
									</div>
									<div class="col-sm-3">
										<button class="btn btn-default btn-import_data" onclick="$('#action').val('import_data');$('#form-featured').submit();"><?php echo $objlang->get('text_import_data'); ?></button>
									</div>
								</div>
							</div> <?php //.row ?>
							<hr>
							<div class="layout-builder-wrapper"> <?php //layout-builder-wrapper ?>
								<div id="layout-builder<?php echo $key; ?>" class="layout-builder">
									<div class="so-col-content">
										<div class="inner-col"></div>
									</div>
								</div>
							</div> <?php //.layout-builder-wrapper ?>
							<hr>
							<div class="row">
								<div class="col-lg-4 col-lg-offset-4">
									<div class="add-row-new pull-center" data-toggle="modal" data-target="#config_row" data-backdrop="static" data-keyboard="false"> <i class="fa fa-plus"></i>
										<?php echo $objlang->get('text_add_row'); ?>
									</div>
								</div>
							</div>
						</div>
						<?php //.tab-pane ?>
						<?php $module_row++; ?>
						<?php } ?>
					</div>
					<?php //.rows ?>
				</div>
				<?php //.panel-body ?>

			</form>
		</div>
		<?php //.panel panel-default ?>
	</div>
	<?php //.container-fluid ?>
</div>
<?php //#content ?>

<?php ////////////////////////////////// # Config Row //////////////////////////////// ?>
<div id="config_row" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" data-sub="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $objlang->get('text_config_row');?></h4>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="tab-pane">
						<ul class="nav nav-tabs" id="so_row_settings">
							<li>
								<a href="#row_config" data-toggle="tab">
									<?php echo $objlang->get('entry_config') ?>
								</a>
							</li>
							<li>
								<a href="#row_advanced_setting" data-toggle="tab">
									<?php echo $objlang->get('entry_advanced') ?>
								</a>
							</li>
						</ul>
					</div>
					<?php //.tab-pane ?>
					<div class="tab-content">
						<div class="tab-pane" id="row_config">
							<?php //Row Config  ?>
							<div class="form-group">
								<?php /// number item in row  ?>
								<label for="number_col" class="control-label col-sm-6"><?php echo $objlang->get('text_col_num');?>:</label>
								<div class="col-sm-6">
									<select name="number-col" class="form-control" id="number_col">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>"><?php echo $i;?> <?php echo $i== 1? $objlang->get('text_item') : $objlang->get('text_items');?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
						</div>
						<div class="tab-pane" id="row_advanced_setting">
							<?php //Row Advanced  ?>
							<div class="form-group">
								<?php // screens active after save  ?>
								<label for="screens_active" class="control-label col-sm-6"><?php echo $objlang->get('text_screen_active');?>:</label>
								<div class="col-sm-6">
									<select name="screens-active" class="form-control" id="screens_active">
										<option value="lg_col"><?php echo $objlang->get('text_large_col');?></option>
										<option value="md_col"><?php echo $objlang->get('text_medium_col');?></option>
										<option value="sm_col"><?php echo $objlang->get('text_small_col');?></option>
										<option value="xs_col"><?php echo $objlang->get('text_extra_col');?></option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<hr>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_style_width_column');?></h4>
							<div class="form-group">
								<?php // Column Large  ?>
								<label for="large_col_cr" class="control-label col-sm-6"><?php echo $objlang->get('text_large_col_');?>:</label>
								<div class="col-sm-6">
									<select name="large-col" class="form-control" id="large_col_cr">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==3) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php // Column Medium  ?>
								<label for="medium_col_cr" class="control-label col-sm-6"><?php echo $objlang->get('text_medium_col_');?>:</label>
								<div class="col-sm-6">
									<select name="medium-col" class="form-control" id="medium_col_cr">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==4) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php // Small Column  ?>
								<label for="small_col_cr" class="control-label col-sm-6"><?php echo $objlang->get('text_small_col_');?>:</label>
								<div class="col-sm-6">
									<select name="small-col" class="form-control" id="small_col_cr">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==6) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php // Extra Column  ?>
								<label for="extra_col_cr" class="control-label col-sm-6"><?php echo $objlang->get('text_extra_col_');?>:</label>
								<div class="col-sm-6">
									<select name="extra-col" class="form-control" id="extra_col_cr">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==12) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
						</div>
					</div>
					<?php //.tab-content ?>
				</form>
			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit-save pull-left"><i class="fa fa-save"></i> <?php echo $objlang->get('text_save_all');?></button>
				<button type="button" class="btn btn-success submit"><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('text_save_change');?></button>
				<button type="button" class="btn btn-danger so-close" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#config_row ?>

<?php ////////////////////////////////// # Config Column ///////////////////////////// ?>
<div id="config_column" class="modal fade" tabindex="-1" role="dialog" data-sub="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $objlang->get('text_config_col');?></h4>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="tab-pane">
						<ul class="nav nav-tabs" id="so_col_settings">
							<li>
								<a href="#col_config" data-toggle="tab">
									<?php echo $objlang->get('entry_config') ?>
								</a>
							</li>
							<li>
								<a href="#col_advanced_setting" data-toggle="tab">
									<?php echo $objlang->get('entry_advanced') ?>
								</a>
							</li>
						</ul>
					</div>
					<?php //.tab-pane ?>
					<div class="tab-content">
						<div class="tab-pane" id="col_config">
							<?php //Col Config  ?>
							<div class="form-group">
								<?php // number item  ?>
								<label for="number_col" class="control-label col-sm-6"><?php echo $objlang->get('text_col_num');?>:</label>
								<div class="col-sm-6">
									<select name="number-col" class="form-control" id="number_col">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>"><?php echo $i;?> <?php echo $i== 1? $objlang->get('text_item') : $objlang->get('text_items');?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
						</div>
						<div class="tab-pane" id="col_advanced_setting">
							<?php //Col Advanced  ?>
							<div class="form-group">
								<?php // Large Column  ?>
								<label for="large_col_cc" class="control-label col-sm-6"><?php echo $objlang->get('text_large_col_');?>:</label>
								<div class="col-sm-6">
									<select name="large-col" class="form-control" id="large_col_cc">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==3) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php // Medium Column  ?>
								<label for="medium_col_cc" class="control-label col-sm-6"><?php echo $objlang->get('text_medium_col_');?>:</label>
								<div class="col-sm-6">
									<select name="medium-col" class="form-control" id="medium_col_cc">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==4) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php // Small Column  ?>
								<label for="small_col_cc" class="control-label col-sm-6"><?php echo $objlang->get('text_small_col_');?>:</label>
								<div class="col-sm-6">
									<select name="small-col" class="form-control" id="small_col_cc">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==6) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php // Extra Column  ?>
								<label for="extra_col_cc" class="control-label col-sm-6"><?php echo $objlang->get('text_extra_col_');?>:</label>
								<div class="col-sm-6">
									<select name="extra-col" class="form-control" id="extra_col_cc">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>" <?php if($i==12) echo "selected";?>>
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
						</div>
					</div>
					<?php //.tab-content ?>
				</form>
			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit-save pull-left"><i class="fa fa-save"></i> <?php echo $objlang->get('text_save_all');?></button>
				<button type="button" class="btn btn-success submit"><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('text_save_change');?></button>
				<button type="button" class="btn btn-danger so-close" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#config_column ?>

<?php ////////////////////////////////// # Row Style ///////////////////////////////// ?>
<div id="style_row" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $objlang->get('text_row_style');?></h4>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="tab-pane">
						<ul class="nav nav-tabs" id="so_row_style">
							<li>
								<a href="#row_style" data-toggle="tab">
									<?php echo $objlang->get('entry_style') ?>
								</a>
							</li>
							<li>
								<a href="#row_advanced_style" data-toggle="tab">
									<?php echo $objlang->get('entry_advanced') ?>
								</a>
							</li>
							<li class="row-parent">
								<a href="#row_section_style" data-toggle="tab">
									<?php echo $objlang->get('text_row_section') ?>
								</a>
							</li>
						</ul>
					</div>
					<?php //.tab-pane ?>
					<div class="tab-content">
						<div class="tab-pane" id="row_style">
							<?php //Row Style  ?>
							<input class="form-control" id="row_text_class_id" type="hidden" name="text_class_id" />
							<div class="form-group">
								<?php //class suffix ?>
								<label for="row_text_class" class="control-label col-sm-4"><?php echo $objlang->get('text_css_class');?>:</label>
								<div class="col-sm-8">
									<input class="form-control" id="row_text_class" type="text" name="text_class" />
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //container_fluid ?>
								<label for="row_container_fluid" class="control-label col-sm-4"><?php echo $objlang->get('text_row_container_fluid');?>:</label>
								<div class="col-sm-8">
									<select name="row_container_fluid" class="form-control" id="row_container_fluid">
										<option value="1"><?php echo $objlang->get('text_yes');?></option>
										<option value="0"><?php echo $objlang->get('text_no');?></option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<hr>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_text');?></h4>
							<div class="form-group">
								<?php //text color ?>
								<label for="row_text_color" class="control-label col-sm-4"><?php echo $objlang->get('text_color');?>:</label>
								<div class="col-sm-8">
									<span class="row-text-color">
									<span class="row-text-color-wheel"></span>
									<input type="text" name="text_color" value="" id="row_text_color" class="row-text-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //link color ?>
								<label for="row_link_color" class="control-label col-sm-4"><?php echo $objlang->get('link_color');?>:</label>
								<div class="col-sm-8">
									<span class="row-link-color">
									<span class="row-link-color-wheel"></span>
									<input type="text" name="link_color" value="" id="row_link_color" class="row-link-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //link hover color ?>
								<label for="row_link_hover_color" class="control-label col-sm-4"><?php echo $objlang->get('link_hover_color');?>:</label>
								<div class="col-sm-8">
									<span class="row-link-hover-color">
									<span class="row-link-hover-color-wheel"></span>
									<input type="text" name="link_hover_color" value="" id="row_link_hover_color" class="row-link-hover-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //heading color ?>
								<label for="row_heading_color" class="control-label col-sm-4"><?php echo $objlang->get('heading_color');?>:</label>
								<div class="col-sm-8">
									<span class="row-heading-color">
									<span class="row-heading-color-wheel"></span>
									<input type="text" name="heading_color" value="" id="row_heading_color" class="row-heading-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<hr>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_background');?></h4>
							<div class="form-group">
								<?php //background type ?>
								<label for="row_background_type" class="control-label col-sm-4"><?php echo $objlang->get('text_background_type');?>:</label>
								<div class="col-sm-8">
									<select name="background_type" class="form-control" id="row_background_type">
										<option value="0"><?php echo $objlang->get('text_background_none');?></option>
										<option value="1"><?php echo $objlang->get('text_background_color');?></option>
										<option value="2"><?php echo $objlang->get('text_background_photo');?></option>
										<option value="3"><?php echo $objlang->get('text_background_video');?></option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="row-background row-background-color" style="display:none">
								<hr>
								<?php //background color ?>
								<h4 style="font-weight:bold">
								<?php echo $objlang->get('text_background');?> <?php echo $objlang->get('text_background_color');?>
							</h4>
								<div class="form-group">
									<?php //background color ?>
									<label for="row_bg_color" class="control-label col-sm-4"><?php echo $objlang->get('text_bg_color');?>:</label>
									<div class="col-sm-8">
										<span class="row-bg-color">
										<span class="row-bg-color-wheel"></span>
										<input type="text" name="bg_color" value="" id="row_bg_color" class="row-bg-color-value" />
										</span>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background color opacity ?>
									<label for="row_bg_opacity" class="control-label col-sm-4"><?php echo $objlang->get('text_bg_opacity');?>:</label>
									<div class="col-sm-8">
										<input type="text" name="bg_opacity" id="bg_opacity" class="form-control" />
									</div>
								</div>
								<?php //.form-group ?>
							</div>
							<div class="row-background row-background-photo" style="display:none">
								<hr>
								<?php //background photo ?>
								<h4 style="font-weight:bold">
									<?php echo $objlang->get('text_background');?> <?php echo $objlang->get('text_background_photo');?>
								</h4>
								<div class="form-group">
									<?php //background photo ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_image');?>: </label>
									<div class="col-sm-8">
										<?php  $rand=time(); ?>
										<a href="" id="thumb-image<?php echo $rand;?>" data-toggle="image" class="img-thumbnail">
											<img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" width="100" height="100"/>
										</a>
										<input class="form-control imageuploaded" type="hidden" data-base="<?php echo HTTP_CATALOG.'image/'?>" name="bg_image" id="uploadimage<?php echo $rand; ?>" />
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background repeat ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_repeat');?>: </label>
									<div class="col-sm-8">
										<select name="bg_repeat" class="form-control" id="bg_repeat">
											<option value="no-repeat"><?php echo $objlang->get('text_background_none');?></option>
											<option value="repeat"><?php echo $objlang->get('text_background_repeat');?></option>
											<option value="repeat-x"><?php echo $objlang->get('text_background_horizontal');?></option>
											<option value="repeat-y"><?php echo $objlang->get('text_background_vertical');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background position ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_position');?>: </label>
									<div class="col-sm-8">
										<select name="bg_position" class="form-control" id="bg_position">
											<option value="left top"><?php echo $objlang->get('text_bg_position_left_top');?></option>
											<option value="left center"><?php echo $objlang->get('text_bg_position_left_center');?></option>
											<option value="left bottom"><?php echo $objlang->get('text_bg_position_left_bottom');?></option>
											<option value="right top"><?php echo $objlang->get('text_bg_position_right_top');?></option>
											<option value="right center"><?php echo $objlang->get('text_bg_position_right_center');?></option>
											<option value="right bottom"><?php echo $objlang->get('text_bg_position_right_bottom');?></option>
											<option value="center top"><?php echo $objlang->get('text_bg_position_center_top');?></option>
											<option value="center center"><?php echo $objlang->get('text_bg_position_center');?></option>
											<option value="center bottom"><?php echo $objlang->get('text_bg_position_center_bottom');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background Attachment  ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_attachment');?>: </label>
									<div class="col-sm-8">
										<select name="bg_attachment" class="form-control" id="bg_attachment">
											<option value="scroll"><?php echo $objlang->get('text_background_attachment_scroll');?></option>
											<option value="fixed"><?php echo $objlang->get('text_background_attachment_fixed');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background Scale  ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_scale');?>: </label>
									<div class="col-sm-8">
										<select name="bg_scale" class="form-control" id="bg_scale">
											<option value=""><?php echo $objlang->get('text_background_none');?></option>
											<option value="auto"><?php echo $objlang->get('text_background_scale_auto');?></option>
											<option value="contain"><?php echo $objlang->get('text_background_scale_contain');?></option>
											<option value="cover"><?php echo $objlang->get('text_background_scale_cover');?></option>
											<option value="initial"><?php echo $objlang->get('text_background_scale_initial');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
							</div>
							<div class="row-background row-background-video" style="display:none">
								<hr>
								<?php //background video ?>
								<h4 style="font-weight:bold"><?php echo $objlang->get('text_background');?> <?php echo $objlang->get('text_background_video');?></h4>
								<div class="form-group">
									<?php //background type ?>
									<label for="row_video_type" class="control-label col-sm-4"><?php echo $objlang->get('text_video_type');?>:</label>
									<div class="col-sm-8">
										<select name="video_type" class="form-control" id="row_video_type">
											<option value="0"><?php echo $objlang->get('text_video_youtube');?></option>
											<option value="1"><?php echo $objlang->get('text_video_webm');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //Link Video ?>
									<label for="row_link_video" class="control-label col-sm-4"><?php echo $objlang->get('text_link_video');?>:</label>
									<div class="col-sm-8">
										<input class="form-control" id="row_link_video" type="text" name="link_video" />
									</div>
								</div>
								<?php //.form-group ?>
							</div>
						</div>
						<div class="tab-pane" id="row_advanced_style">
							<?php //Row Advanced  ?>
							<hr>
							<?php //margin ?>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_margin');?></h4>
							<div class="form-group">
								<?php //margin ?>
								<label for="row_margin" class="control-label col-sm-4"><?php echo $objlang->get('text_margin');?>:</label>
								<div class="col-sm-8">
									<input class="form-control" id="row_margin" type="text" name="margin" placeholder="10px 10px 10px 10px" />
								</div>
							</div>
							<?php //.form-group ?>

							<hr>
							<?php //padding ?>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_padding');?></h4>
							<div class="form-group">
								<?php //padding ?>
								<label for="row_padding" class="control-label col-sm-4"><?php echo $objlang->get('text_padding');?>:</label>
								<div class="col-sm-8">
									<input class="form-control" id="row_padding" type="text" name="padding" placeholder="10px 10px 10px 10px" />
								</div>
							</div>
							<?php //.form-group ?>
						</div>
						<div class="tab-pane" id="row_section_style">
							<?php //Row section_style  ?>
							<div class="form-group">
								<?php // Section On/Off ?>
								<label for="row_section" class="control-label col-sm-4"><?php echo $objlang->get('text_row_section');?>:</label>
								<div class="col-sm-8">
									<select name="row_section" class="form-control" id="row_section">
										<option value="0"><?php echo $objlang->get('text_no');?></option>
										<option value="1"><?php echo $objlang->get('text_yes');?></option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="row-section-id" style="display:none">
								<div class="form-group">
									<?php // Section Id ?>
									<label for="row_section_id" class="control-label col-sm-4"><?php echo $objlang->get('text_row_section_id');?>:</label>
									<div class="col-sm-8">
										<input class="form-control" id="row_section_id" type="text" name="row_section_id" />
									</div>
								</div>
								<?php //.form-group ?>
							</div>
							<div class="row-section-class" style="display:none">
								<div class="form-group">
									<?php // Section class ?>
									<label for="row_section_class" class="control-label col-sm-4"><?php echo $objlang->get('text_row_section_class');?>:</label>
									<div class="col-sm-8">
										<input class="form-control" id="row_section_class" type="text" name="row_section_class" />
									</div>
								</div>
								<?php //.form-group ?>
							</div>
							<div class="row-section-style" style="display:none">
								<hr>
								<h4 style="font-weight:bold"><?php echo $objlang->get('text_background');?></h4>
								<div class="form-group">
									<?php // background type ?>
									<label for="section_background_type" class="control-label col-sm-4"><?php echo $objlang->get('text_background_type');?>:</label>
									<div class="col-sm-8">
										<select name="section_background_type" class="form-control" id="section_background_type">
											<option value="0"><?php echo $objlang->get('text_background_none');?></option>
											<option value="1"><?php echo $objlang->get('text_background_color');?></option>
											<option value="2"><?php echo $objlang->get('text_background_photo');?></option>
											<option value="3"><?php echo $objlang->get('text_background_video');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="section-background section-background-color" style="display:none">
									<hr>
									<?php // background color ?>
									<h4 style="font-weight:bold"><?php echo $objlang->get('text_background_color');?></h4>
									<div class="form-group">
										<?php // background color ?>
										<label for="section_bg_color" class="control-label col-sm-4"><?php echo $objlang->get('text_bg_color');?>:</label>
										<div class="col-sm-8">
											<span class="section-bg-color">
											<span class="section-bg-color-wheel"></span>
											<input type="text" name="section_bg_color" value="" id="section_bg_color" class="section-bg-color-value" />
											</span>
										</div>
									</div>
									<?php //.form-group ?>
									<div class="form-group">
										<?php // background color opacity ?>
										<label for="section_bg_opacity" class="control-label col-sm-4"><?php echo $objlang->get('text_bg_opacity');?>:</label>
										<div class="col-sm-8">
											<input type="text" name="section_bg_opacity" id="section_bg_opacity" class="form-control" />
										</div>
									</div>
									<?php //.form-group ?>
								</div>
								<div class="section-background section-background-photo" style="display:none">
									<hr>
									<?php //background photo ?>
									<h4 style="font-weight:bold"><?php echo $objlang->get('text_background_photo');?></h4>
									<div class="form-group">
										<?php //background photo ?>
										<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_image');?>: </label>
										<div class="col-sm-8">
											<?php  $rand=time(); ?>
											<a href="" id="thumb-image-<?php echo $rand;?>" data-toggle="image" class="img-thumbnail">
												<img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" width="100" height="100"/>
											</a>
											<input class="form-control imageuploaded" type="hidden" data-base="<?php echo HTTP_CATALOG.'image/'?>" name="section_bg_image" id="uploadimage-<?php echo $rand; ?>" />
										</div>
									</div>
									<?php //.form-group ?>
									<div class="form-group">
										<?php //background repeat ?>
										<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_repeat');?>: </label>
										<div class="col-sm-8">
											<select name="section_bg_repeat" class="form-control" id="section_bg_repeat">
												<option value="no-repeat"><?php echo $objlang->get('text_background_none');?></option>
												<option value="repeat"><?php echo $objlang->get('text_background_repeat');?></option>
												<option value="repeat-x"><?php echo $objlang->get('text_background_horizontal');?></option>
												<option value="repeat-y"><?php echo $objlang->get('text_background_vertical');?></option>
											</select>
										</div>
									</div>
									<?php //.form-group ?>
									<div class="form-group">
										<?php //background position ?>
										<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_position');?>: </label>
										<div class="col-sm-8">
											<select name="section_bg_position" class="form-control" id="section_bg_position">
												<option value="left top"><?php echo $objlang->get('text_bg_position_left_top');?></option>
												<option value="left center"><?php echo $objlang->get('text_bg_position_left_center');?></option>
												<option value="left bottom"><?php echo $objlang->get('text_bg_position_left_bottom');?></option>
												<option value="right top"><?php echo $objlang->get('text_bg_position_right_top');?></option>
												<option value="right center"><?php echo $objlang->get('text_bg_position_right_center');?></option>
												<option value="right bottom"><?php echo $objlang->get('text_bg_position_right_bottom');?></option>
												<option value="center top"><?php echo $objlang->get('text_bg_position_center_top');?></option>
												<option value="center center"><?php echo $objlang->get('text_bg_position_center');?></option>
												<option value="center bottom"><?php echo $objlang->get('text_bg_position_center_bottom');?></option>
											</select>
										</div>
									</div>
									<?php //.form-group ?>
									<div class="form-group">
										<?php //background Attachment  ?>
										<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_attachment');?>: </label>
										<div class="col-sm-8">
											<select name="section_bg_attachment" class="form-control" id="section_bg_attachment">
												<option value="scroll"><?php echo $objlang->get('text_background_attachment_scroll');?></option>
												<option value="fixed"><?php echo $objlang->get('text_background_attachment_fixed');?></option>
											</select>
										</div>
									</div>
									<?php //.form-group ?>
									<div class="form-group">
										<?php //background Scale  ?>
										<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_scale');?>: </label>
										<div class="col-sm-8">
											<select name="section_bg_scale" class="form-control" id="section_bg_scale">
												<option value=""><?php echo $objlang->get('text_background_none');?></option>
												<option value="auto"><?php echo $objlang->get('text_background_scale_auto');?></option>
												<option value="contain"><?php echo $objlang->get('text_background_scale_contain');?></option>
												<option value="cover"><?php echo $objlang->get('text_background_scale_cover');?></option>
												<option value="initial"><?php echo $objlang->get('text_background_scale_initial');?></option>
											</select>
										</div>
									</div>
									<?php //.form-group ?>
								</div>
								<div class="section-background section-background-video" style="display:none">
									<hr>
									<?php //background video ?>
									<h4 style="font-weight:bold"><?php echo $objlang->get('text_background');?> <?php echo $objlang->get('text_background_video');?></h4>
									<div class="form-group">
										<?php //background type ?>
										<label for="section_video_type" class="control-label col-sm-4"><?php echo $objlang->get('text_video_type');?>:</label>
										<div class="col-sm-8">
											<select name="section_video_type" class="form-control" id="section_video_type">
												<option value="0"><?php echo $objlang->get('text_video_youtube');?></option>
												<option value="1"><?php echo $objlang->get('text_video_webm');?></option>
											</select>
										</div>
									</div>
									<?php //.form-group ?>
									<div class="form-group">
										<?php //Link Video ?>
										<label for="section_link_video" class="control-label col-sm-4"><?php echo $objlang->get('text_link_video');?>:</label>
										<div class="col-sm-8">
											<input class="form-control" id="section_link_video" type="text" name="section_link_video" />
										</div>
									</div>
									<?php //.form-group ?>
								</div>
							</div>
						</div>
					</div>
					<?php //.tab-content ?>
				</form>
			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit-save pull-left"><i class="fa fa-save"></i> <?php echo $objlang->get('text_save_all');?></button>
				<button type="button" class="btn btn-success submit"><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('text_save_change');?></button>
				<button type="button" class="btn btn-danger so-close" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#style_row ?>

<?php ///////////////////////////////// # Column Style /////////////////////////////// ?>
<div id="style_col" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $objlang->get('text_col_style');?></h4>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="tab-pane">
						<ul class="nav nav-tabs" id="so_col_style">
							<li>
								<a href="#col_style" data-toggle="tab">
									<?php echo $objlang->get('entry_config') ?>
								</a>
							</li>
							<li>
								<a href="#col_advanced_style" data-toggle="tab">
									<?php echo $objlang->get('entry_advanced') ?>
								</a>
							</li>
							<li>
								<a href="#col_responsive_layout" data-toggle="tab">
									<?php echo $objlang->get('text_responsive_layout') ?>
								</a>
							</li>
						</ul>
					</div>
					<?php //.tab-pane ?>
					<div class="tab-content">
						<div class="tab-pane" id="col_style">
							<?php //Col Style  ?>
							<input class="form-control" id="col_text_class_id" type="hidden" name="text_class_id" />
							<div class="form-group">
								<?php //class suffix ?>
								<label for="col_text_class" class="control-label col-sm-4"><?php echo $objlang->get('text_css_class');?>:</label>
								<div class="col-sm-8">
									<input class="form-control" id="col_text_class" type="text" name="text_class" />
								</div>
							</div>
							<?php //.form-group ?>
							<hr>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_text');?></h4>
							<div class="form-group">
								<?php //text color ?>
								<label for="col_text_color" class="control-label col-sm-4"><?php echo $objlang->get('text_color');?>:</label>
								<div class="col-sm-8">
									<span class="col-text-color">
										<span class="col-text-color-wheel"></span>
										<input type="text" name="text_color" value="" id="col_text_color" class="col-text-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //link color ?>
								<label for="col_link_color" class="control-label col-sm-4"><?php echo $objlang->get('link_color');?>:</label>
								<div class="col-sm-8">
									<span class="col-link-color">
										<span class="col-link-color-wheel"></span>
										<input type="text" name="link_color" value="" id="col_link_color" class="col-link-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //link hover color ?>
								<label for="col_link_hover_color" class="control-label col-sm-4"><?php echo $objlang->get('link_hover_color');?>:</label>
								<div class="col-sm-8">
									<span class="col-link-hover-color">
										<span class="col-link-hover-color-wheel"></span>
										<input type="text" name="link_hover_color" value="" id="col_link_hover_color" class="col-link-hover-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //heading color ?>
								<label for="col_heading_color" class="control-label col-sm-4"><?php echo $objlang->get('heading_color');?>:</label>
								<div class="col-sm-8">
									<span class="col-heading-color">
										<span class="col-heading-color-wheel"></span>
										<input type="text" name="heading_color" value="" id="col_heading_color" class="col-heading-color-value" />
									</span>
								</div>
							</div>
							<?php //.form-group ?>
							<hr>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_background');?></h4>
							<div class="form-group">
								<?php //background type ?>
								<label for="col_background_type" class="control-label col-sm-4"><?php echo $objlang->get('text_background_type');?>:</label>
								<div class="col-sm-8">
									<select name="background_type" class="form-control" id="col_background_type">
										<option value="0"><?php echo $objlang->get('text_background_none');?></option>
										<option value="1"><?php echo $objlang->get('text_background_color');?></option>
										<option value="2"><?php echo $objlang->get('text_background_photo');?></option>
										<option value="3"><?php echo $objlang->get('text_background_video');?></option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="col-background col-background-color" style="display:none">
								<hr>
								<?php //background color ?>
								<h4 style="font-weight:bold"><?php echo $objlang->get('text_background_color');?></h4>
								<div class="form-group">
									<?php //background color ?>
									<label for="col_bg_color" class="control-label col-sm-4"><?php echo $objlang->get('text_bg_color');?>:</label>
									<div class="col-sm-8">
										<span class="col-bg-color">
											<span class="col-bg-color-wheel"></span>
											<input type="text" name="bg_color" value="" id="col_bg_color" class="col-bg-color-value" />
										</span>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background color opacity ?>
									<label for="row_bg_opacity" class="control-label col-sm-4"><?php echo $objlang->get('text_bg_opacity');?>:</label>
									<div class="col-sm-8">
										<input type="text" name="bg_opacity" id="bg_opacity" class="form-control" />
									</div>
								</div>
								<?php //.form-group ?>
							</div>
							<div class="col-background col-background-photo" style="display:none">
								<hr>
								<?php //background photo ?>
								<h4 style="font-weight:bold"><?php echo $objlang->get('text_background_photo');?></h4>
								<div class="form-group">
									<?php //background photo ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_image');?>: </label>
									<div class="col-sm-8">
										<?php  $rand="col-".time(); ?>
										<a href="" id="thumb-image<?php echo $rand;?>" data-toggle="image" class="img-thumbnail">
											<img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" width="100" height="100"/>
										</a>
										<input class="form-control imageuploaded" type="hidden" data-base="<?php echo HTTP_CATALOG.'image/'?>" name="bg_image" id="uploadimage<?php echo $rand; ?>" />
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background repeat ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_repeat');?>: </label>
									<div class="col-sm-8">
										<select name="bg_repeat" class="form-control" id="bg_repeat">
											<option value="no-repeat"><?php echo $objlang->get('text_background_none');?></option>
											<option value="repeat"><?php echo $objlang->get('text_background_repeat');?></option>
											<option value="repeat-x"><?php echo $objlang->get('text_background_horizontal');?></option>
											<option value="repeat-y"><?php echo $objlang->get('text_background_vertical');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background position ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_position');?>: </label>
									<div class="col-sm-8">
										<select name="bg_position" class="form-control" id="bg_position">
											<option value="left top"><?php echo $objlang->get('text_bg_position_left_top');?></option>
											<option value="left center"><?php echo $objlang->get('text_bg_position_left_center');?></option>
											<option value="left bottom"><?php echo $objlang->get('text_bg_position_left_bottom');?></option>
											<option value="right top"><?php echo $objlang->get('text_bg_position_right_top');?></option>
											<option value="right center"><?php echo $objlang->get('text_bg_position_right_center');?></option>
											<option value="right bottom"><?php echo $objlang->get('text_bg_position_right_bottom');?></option>
											<option value="center top"><?php echo $objlang->get('text_bg_position_center_top');?></option>
											<option value="center center"><?php echo $objlang->get('text_bg_position_center');?></option>
											<option value="center bottom"><?php echo $objlang->get('text_bg_position_center_bottom');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background Attachment  ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_attachment');?>: </label>
									<div class="col-sm-8">
										<select name="bg_attachment" class="form-control" id="bg_attachment">
											<option value="scroll"><?php echo $objlang->get('text_background_attachment_scroll');?></option>
											<option value="fixed"><?php echo $objlang->get('text_background_attachment_fixed');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //background Scale  ?>
									<label class="control-label col-sm-4"><?php echo $olang->get('text_bg_scale');?>: </label>
									<div class="col-sm-8">
										<select name="bg_scale" class="form-control" id="bg_scale">
											<option value=""><?php echo $objlang->get('text_background_none');?></option>
											<option value="auto"><?php echo $objlang->get('text_background_scale_auto');?></option>
											<option value="contain"><?php echo $objlang->get('text_background_scale_contain');?></option>
											<option value="cover"><?php echo $objlang->get('text_background_scale_cover');?></option>
											<option value="initial"><?php echo $objlang->get('text_background_scale_initial');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
							</div>
							<div class="col-background col-background-video" style="display:none">
								<hr>
								<?php //background video ?>
								<h4 style="font-weight:bold"><?php echo $objlang->get('text_background');?> <?php echo $objlang->get('text_background_video');?></h4>
								<div class="form-group">
									<?php //background type ?>
									<label for="col_video_type" class="control-label col-sm-4"><?php echo $objlang->get('text_video_type');?>:</label>
									<div class="col-sm-8">
										<select name="col_video_type" class="form-control" id="col_video_type">
											<option value="0"><?php echo $objlang->get('text_video_youtube');?></option>
											<option value="1"><?php echo $objlang->get('text_video_webm');?></option>
										</select>
									</div>
								</div>
								<?php //.form-group ?>
								<div class="form-group">
									<?php //Link Video ?>
									<label for="col_link_video" class="control-label col-sm-4"><?php echo $objlang->get('text_link_video');?>:</label>
									<div class="col-sm-8">
										<input class="form-control" id="col_link_video" type="text" name="col_link_video" />
									</div>
								</div>
								<?php //.form-group ?>
							</div>
						</div>
						<?php //.tab-pane ?>
						<div class="tab-pane" id="col_advanced_style">
							<?php //col Advanced  ?>
							<hr>
							<?php //margin ?>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_margin');?></h4>
							<div class="form-group">
								<?php //margin ?>
								<label for="col_margin" class="control-label col-sm-4"><?php echo $objlang->get('text_margin');?>:</label>
								<div class="col-sm-8">
									<input class="form-control" id="col_margin" type="text" name="margin" placeholder="10px 10px 10px 10px" />
								</div>
							</div>
							<?php //.form-group ?>
							<hr>
							<?php //padding ?>
							<h4 style="font-weight:bold"><?php echo $objlang->get('text_padding');?></h4>
							<div class="form-group">
								<?php //padding ?>
								<label for="col_padding" class="control-label col-sm-4"><?php echo $objlang->get('text_padding');?>:</label>
								<div class="col-sm-8">
									<input class="form-control" id="col_padding" type="text" name="padding" placeholder="10px 10px 10px 10px" />
								</div>
							</div>
							<?php //.form-group ?>
						</div>
						<?php //.tab-pane ?>
						<div class="tab-pane" id="col_responsive_layout">
							<?php //Responsive layout  ?>
							<div class="form-group">
								<?php ///Column Large ?>
								<label for="large_col" class="control-label col-sm-6"><?php echo $objlang->get('text_large_col_');?>:</label>
								<div class="col-sm-6">
									<select name="lg_col" class="form-control" id="large_col">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>">
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //Column Medium ?>
								<label for="medium_col" class="control-label col-sm-6"><?php echo $objlang->get('text_medium_col_');?>:</label>
								<div class="col-sm-6">
									<select name="md_col" class="form-control" id="medium_col">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>">
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //Column Small ?>
								<label for="small_col" class="control-label col-sm-6"><?php echo $objlang->get('text_small_col_');?>:</label>
								<div class="col-sm-6">
									<select name="sm_col" class="form-control" id="small_col">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>">
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
							<div class="form-group">
								<?php //Column Extra Small ?>
								<label for="extra_col" class="control-label col-sm-6"><?php echo $objlang->get('text_extra_col_');?>:</label>
								<div class="col-sm-6">
									<select name="xs_col" class="form-control" id="extra_col">
										<?php for($i=1; $i<=12; $i++) { ?>
										<option value="<?php echo $i;?>">
											<?php echo $i;?> <?php echo ($i==1 ? $objlang->get('text_col') : $objlang->get('text_cols'));?>
										</option>
										<?php } ?>
										<option value="15">
											15 <?php echo $objlang->get('text_cols');?>
										</option>
									</select>
								</div>
							</div>
							<?php //.form-group ?>
						</div>
						<?php //.tab-pane ?>
					</div>
					<?php //.tab-content ?>
				</form>
			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit-save pull-left"><i class="fa fa-save"></i> <?php echo $objlang->get('text_save_all');?></button>
				<button type="button" class="btn btn-success submit"><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('text_save_change');?></button>
				<button type="button" class="btn btn-danger so-close" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#style_col ?>

<?php ///////////////////////////////// # Module Builder ///////////////////////////// ?>
<div id="config_module" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $objlang->get('text_add_module');?></h4>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">
				<div id="listmods">
					<?php $i=0; foreach( $extensions as $key=>$ext ){ ?>
					<?php if( ++$i%3==1 ){ ?>
					<div class="row">
						<?php } ?>
						<div class="col-sm-4 mod-widget">
							<div class="mod-head">
								<?php echo strip_tags($ext['name']) ?>
							</div>
							<div class="mod-items">
								<?php foreach( $ext['module'] as $emod ){ ?>
								<div class="module-item so-page-widget" data-module="<?php echo $emod['code'] ; ?>" data-type="module" data-name="<?php echo $emod['name'];?>">
									<div class="w-inner">
										<div class="so-page-wicon"><i class="fa fa-university"></i></div>
										<h5><?php echo $emod['name'];?></h5>
									</div>
									<?php //.w-inner ?>
									<div class="widget-tool">
										<div data-icontitle="<?php echo $objlang->get('text_java_sortModule');?>" class="so-page-wsort so-page-icon-widget"><i class="fa fa-arrows"></i></div>
										<div data-iconTitle="<?php echo $objlang->get('text_java_deleteModule');?>" class="so-page-wdelete so-page-icon-widget"><i class="fa fa-remove"></i></div>
										<div data-icontitle="<?php echo $objlang->get('text_java_editModule');?>" class="so-page-wedit so-page-icon-widget" data-href="<?php echo $ourl->link('extension/module/'.$key,'module_id='.$emod['id'].'&token='.$token);?>" data-module="<?php echo $key; ?>"><i class="fa fa-edit"></i></div>
										<div data-iconTitle="<?php echo $objlang->get('text_java_copyModule');?>" class="so-page-wcopy so-page-icon-widget"><i class="fa fa-copy"></i></div>
									</div>
									<?php //.widget-tool ?>
								</div>
								<?php }//$ext['module'] ?>
							</div>
							<?php //.mod-items ?>
						</div>
						<?php //.col-sm-4 mod-widget ?>
						<?php if(	$i%3==0 || $i == count($extensions) ){ ?>
					</div>
					<?php //.row ?>
					<?php }//$i ?>
					<?php }//$extensions ?>
				</div>
				<?php //#listmods ?>
			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger so-close" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#config_module ?>

<?php ///////////////////////////////// # Config Shortcodes ////////////////////////// ?>
<div id="config_shortcode" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="header_shortcodes_plugin">
					<div id="yt-generator-filter">
						<?php
							foreach ($groupsYT as $group => $label)
							{
								echo '<a href="javascript:;" data-filter="' . $group . '">' . $label . '</a>';
							}
						?>
					</div>
					<div id="yt-generator_box_search">
						<input name="yt_generator_search" id="yt-generator-search" value="" placeholder="Search for shortcodes" type="text">
					</div>
				</div>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">
				<div class="wpo-widgetslist">
					<div class="row yt-generator-choices">
						<div class="col-lg-12">
							<?php $i =0; foreach( $shortcoders as $name => $shortcode ){ ?>
							<?php if( ++$i%3==1 ){ ?>
							<div class="row-shortcode">
								<?php } ?>
								<div class="wapper-shortcode">
									<div class="shortcode-item so-page-widget" data-group="<?php echo $shortcode['group'];?>" data-name="<?php echo $shortcode['name'];?>" data-shortcode="<?php echo $name;?>" data-desc="<?php echo $shortcode['desc'];?>" data-type="shortcode">
										<div class="widget-tool">
											<div data-icontitle="<?php echo $objlang->get('text_java_sortShortcode');?>" class="so-page-wsort so-page-icon-widget"><i class="fa fa-arrows"></i></div>
											<div data-icontitle="<?php echo $objlang->get('text_java_deleteShortcode');?>" class="so-page-wdelete so-page-icon-widget"><i class="fa fa-remove"></i></div>
											<div data-icontitle="<?php echo $objlang->get('text_java_editShortcode');?>" class="so-page-wedit so-page-icon-widget"><i class="fa fa-edit"></i></div>
											<div data-icontitle="<?php echo $objlang->get('text_java_copyShortcode');?>" class="so-page-wcopy so-page-icon-widget"><i class="fa fa-copy"></i></div>
										</div>
										<div class="w-inner">
											<div class="so-page-wicon"><i class="fa fa-<?php echo $shortcode['icon']?>"></i></div>
											<div class="widget-title">
												<?php echo $shortcode['name']?> <span class="widget-title-edit"></span></div>
										</div>
										<textarea name="content_shortcode" class="hidden-content-shortcode hide"></textarea>
									</div>
								</div>
								<?php //.col ?>
								<?php if($i%3==0 || $i == count($shortcoders)){ ?>
							</div>
							<?php //.row ?>
							<?php }//$i ?>
							<?php }//foreach $shortcodes?>

						</div>
						<?php //.col-lg-12 ?>
					</div>
					<?php //.row ?>
				</div>
				<?php //.wpo-widgetslist ?>
				<div class="wpo-widgetform"></div>
				<?php //.wpo-widgetform ?>
			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-info pull-left yt-generator-home"> <?php echo $objlang->get('text_backtolist');?></button>
				<button type="button" class="btn btn-primary submit-save pull-left"><i class="fa fa-save"></i> <?php echo $objlang->get('text_save_all');?></button>
				<button type="button" class="btn btn-success submit"><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('text_save_change');?></button>
				<button type="button" class="btn btn-danger so-close" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#config_shortcode ?>

<?php //////////////////////////////// # Edit Shortcodes ///////////////////////////// ?>
<div id="edit_shortcode" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $objlang->get('text_edit_shortcode');?></h4>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">
				<div class="wpo-widgetform"></div>
				<?php //.wpo-widgetform ?>
			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit-save pull-left"><i class="fa fa-save"></i> <?php echo $objlang->get('text_save_all');?></button>
				<button type="button" class="btn btn-success submit"><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('text_save_change');?></button>
				<button type="button" class="btn btn-danger so-close" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#edit_shortcode ?>

<?php //////////////////////////////// # Edit Module ///////////////////////////////// ?>
<div id="edit_module" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $objlang->get('text_edit_module');?></h4>
			</div>
			<?php //.modal-header ?>
			<div class="modal-body">

			</div>
			<?php //.modal-body ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger so-close submit-save" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $objlang->get('text_close');?></button>
			</div>
			<?php //.modal-footer ?>
		</div>
		<?php //.modal-content ?>
	</div>
	<?php //.modal-dialog ?>
</div>
<?php //#edit_shortcode ?>

<script type="text/javascript">
	$('#so_row_settings a:first,#so_row_style a:first,#so_col_settings a:first,#so_col_style a:first,#language a:first').tab('show');
	/* Random string */
	function randString(n) {
		if (!n) {
			n = 5;
		}
		var text = '';
		var possible = 'abcdefghijklmnopqrstuvwxyz0123456789';
		for (var i = 0; i < n; i++) {
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}
		return text;
	}

	/* Change background type Row */
	$('#row_background_type').change(function() {
		var row_background_type = $(this).val();
		switch (row_background_type) {
			case '0':
				$('.row-background').hide();
				break;
			case '1':
				$('.row-background').hide();
				$('.row-background-color').show();
				break;
			case '2':
				$('.row-background').hide();
				$('.row-background-photo').show();
				break;
			case '3':
				$('.row-background').hide();
				$('.row-background-video').show();
				break;
		}
	});

	/* Change video type Row */
	$('#row_video_type').change(function() {
		var row_video_type = $(this).val();
		switch (row_video_type) {
			case '0':
				$('#row_link_video').val("YE7VzlLtp-4");
				break;
			case '1':
				$('#row_link_video').val("http://video.webmfiles.org/big-buck-bunny_trailer.webm");
				break;
		}
	});

	/* Show section Row */
	$('#row_section').change(function() {
		var row_section = $(this).val();
		switch (row_section) {
			case '0':
				$('.row-section-id,.row-section-class,.row-section-style').hide();
				break;
			case '1':
				$('.row-section-id,.row-section-class,.row-section-style').show();
				break;
		}
	});
	
	/* Change background type Section */
	$('#section_background_type').change(function() {
		var row_background_type = $(this).val();
		switch (row_background_type) {
			case '0':
				$('.section-background').hide();
				break;
			case '1':
				$('.section-background').hide();
				$('.section-background-color').show();
				break;
			case '2':
				$('.section-background').hide();
				$('.section-background-photo').show();
				break;
			case '3':
				$('.section-background').hide();
				$('.section-background-video').show();
				break;
		}
	});
	
	/* Change video type Section */
	$('#section_video_type').change(function() {
		var section_video_type = $(this).val();
		switch (section_video_type) {
			case '0':
				$('#section_link_video').val("YE7VzlLtp-4");
				break;
			case '1':
				$('#section_link_video').val("http://video.webmfiles.org/big-buck-bunny_trailer.webm");
				break;
		}
	});
	
	/* Change background type Col */
	$('#col_background_type').change(function() {
		var col_background_type = $(this).val();
		switch (col_background_type) {
			case '0':
				$('.col-background').hide();
				break;
			case '1':
				$('.col-background').hide();
				$('.col-background-color').show();
				break;
			case '2':
				$('.col-background').hide();
				$('.col-background-photo').show();
				break;
			case '3':
				$('.col-background').hide();
				$('.col-background-video').show();
				break;
		}
	});
	
	/* Change video type Col */
	$('#col_video_type').change(function() {
		var col_video_type = $(this).val();
		switch (col_video_type) {
			case '0':
				$('#col_link_video').val("YE7VzlLtp-4");
				break;
			case '1':
				$('#col_link_video').val("http://video.webmfiles.org/big-buck-bunny_trailer.webm");
				break;
		}
	});
	
	/* Add new Image */
	function addImage() {
		var key_add_image = "";
		$('.yt-generator-isp-add-media').click(function() {
			key_add_image = randString(10);
			$('#yt-generator-attr-image').append("<span><a href='' id='thumb-image" + key_add_image +
				"' data-toggle='image' class='img-thumbnail'><img src='<?php echo $placeholder; ?>' alt='' title='' data-placeholder='<?php echo $placeholder; ?>' width='100' height='100' /></a><input class='form-control imageuploaded' type='hidden' data-base='<?php echo HTTP_CATALOG.'image/'?>'  name='media_image{}' id='uploadimage" +
				key_add_image + "' value='no_image.png'/><i class='fa fa-times'></i></span>");
		});
	}

	var languagesDefault = "<?php echo $languagesDefault;?>";
	var textDelete = "<?php echo $objlang->get('text_java_textDelete');?>";
	var textDuplicate = "<?php echo $objlang->get('text_java_textDuplicate');?>";
	var textCol = [];
	textCol["col"] = "<?php echo $objlang->get('text_java_col');?>";
	textCol["cols"] = "<?php echo $objlang->get('text_java_cols');?>";
	textCol["sortCol"] = "<?php echo $objlang->get('text_java_sortCol');?>";
	textCol["deleteCol"] = "<?php echo $objlang->get('text_java_deleteCol');?>";
	textCol["editCol"] = "<?php echo $objlang->get('text_java_editCol');?>";
	textCol["duplicateCol"] = "<?php echo $objlang->get('text_java_duplicateCol');?>";
	textCol["addRow"] = "<?php echo $objlang->get('text_java_addRow');?>";
	textCol["addModule"] = "<?php echo $objlang->get('text_java_addModule');?>";
	textCol["addShortcode"] = "<?php echo $objlang->get('text_java_addShortcode');?>";
	var textRow = [];
	textRow["row"] = "<?php echo $objlang->get('text_java_row');?>";
	textRow["sortRow"] = "<?php echo $objlang->get('text_java_sortRow');?>";
	textRow["deleteRow"] = "<?php echo $objlang->get('text_java_deleteRow');?>";
	textRow["editRow"] = "<?php echo $objlang->get('text_java_editRow');?>";
	textRow["duplicateRow"] = "<?php echo $objlang->get('text_java_duplicateRow');?>";
	textRow["addCol"] = "<?php echo $objlang->get('text_java_addCol');?>";
	var textShortcode = [];
	textShortcode["editShortcode"] = "<?php echo $objlang->get('text_edit_shortcode');?>";
	$(".layout-builder-wrapper").each(function() {
		$($(".layout-builder", this)).so_page_builder($(".hidden-content-layout").val());
	});
</script>

<?php echo $footer; ?>
