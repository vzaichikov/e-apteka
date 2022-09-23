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
				<div class="btn-group">
					<button type="button" onclick="save();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only"></span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a onclick="save('exit');" style="cursor: pointer;"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> <?php echo $button_save_and_exit; ?></a></li>
						<li><a onclick="settings('basic');" style="cursor: pointer;"><i class="fa fa-cloud-download fa-fw" aria-hidden="true"></i> <?php echo $button_download_basic_settings; ?></a></li>
						<li><a onclick="settings('import');" style="cursor: pointer;"><i class="fa fa-download fa-fw" aria-hidden="true"></i> <?php echo $button_import_settings; ?></a></li>
						<li><a onclick="settings('export');" style="cursor: pointer;"><i class="fa fa-upload fa-fw" aria-hidden="true"></i> <?php echo $button_export_settings; ?></a></li>
					</ul>
				</div>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-danger" role="button"><i class="fa fa-reply"></i></a>
			</div>
		</div>
	</div>
 	<div class="container-fluid">
 		<?php if ($success) { ?>
    	<div class="alert alert-success">
    		<i class="fa fa-check-circle"></i> <?php echo $success; ?>
      		<button type="button" class="close" data-dismiss="alert">&times;</button>
    	</div>
    	<?php } ?>
    	<?php if ($error_warning) { ?>
    	<div class="alert alert-danger">
    		<i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      		<button type="button" class="close" data-dismiss="alert">&times;</button>
    	</div>
    	<?php } ?>
    	<div class="panel panel-default">
      		<div class="panel-heading">
        		<h3 class="panel-title"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $text_settings; ?></h3>
				<select name="store_id" id="input-store_id" onchange="location.href = 'index.php?route=extension/shipping/ukrposhta&token=<?php echo $token; ?>&store_id=' + this.value;" class="form-control" style="display: inline; width: auto;">
					<?php foreach ($stores as $store) { ?>
					<?php if ($store_id == $store['store_id'] ) { ?>
					<option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
      		</div>
      		<div class="panel-body">
        		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ukrposhta" class="form-horizontal">
        			<ul class="nav nav-tabs">
        				<?php if ($license) { ?>
			  			<li<?php if ($license) { ?> class="active"<?php } ?>><a href="#tab-general" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_general; ?></a></li>
						<li><a href="#tab-tariffs" data-toggle="tab"><i class="fa fa-calculator"></i> <?php echo $tab_tariffs; ?></a></li>
			  			<li><a href="#tab-database" data-toggle="tab"><i class="fa fa-database"></i> <?php echo $tab_database; ?></a></li>
			  			<li><a href="#tab-sender" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $tab_sender; ?></a></li>
			  			<li><a href="#tab-recipient" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $tab_recipient; ?></a></li>
			  			<li><a href="#tab-departure" data-toggle="tab"><i class="fa fa-cube" aria-hidden="true"></i> <?php echo $tab_departure; ?></a></li>
			  			<li><a href="#tab-payment" data-toggle="tab"><i class="fa fa-money" aria-hidden="true"></i> <?php echo $tab_payment; ?></a></li>
						<li><a href="#tab-consignment_note" data-toggle="tab"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo $tab_consignment_note; ?></a></li>
			  			<li><a href="#tab-cron" data-toggle="tab"><i class="fa fa-tasks"></i> <?php echo $tab_cron; ?></a></li>
		  				<?php } ?>
		  				<li role="presentation" class="dropdown<?php if (!$license) { ?> active<?php } ?>">
		  					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><i class="fa fa-life-ring"></i> <?php echo $tab_support; ?> <span class="caret"></span></a>
		  					<ul class="dropdown-menu dropdown-menu-right">
								<li<?php if (!$license) { ?> class="active"<?php } ?>><a href="#tab-support" data-toggle="tab"><?php echo $text_contacts; ?></a></li>
    							<li><a href="<?php echo $instruction_href; ?>" target="_blank"><?php echo $text_instruction; ?></a></li>
								<li><a href="<?php echo $documentation_api_href; ?>" target="_blank"><?php echo $text_documentation_api; ?></a></li>
							</ul>
		  				</li>
					</ul>
					<div class="tab-content">
						<?php if ($license) { ?>
						<div class="tab-pane fade<?php if ($license) { ?>in active<?php } ?>" id="tab-general">
							<div class="col-sm-2">
								<ul class="nav nav-pills nav-stacked">
									<li class="active"><a href="#tab-global" data-toggle="pill"><?php echo $text_global; ?></a></li>
									<li><a href="#tab-express-w" data-toggle="pill"><?php echo $text_express_w; ?></a></li>
									<li><a href="#tab-express-d" data-toggle="pill"><?php echo $text_express_d; ?></a></li>
						  			<li><a href="#tab-standard-w" data-toggle="pill"><?php echo $text_standard_w; ?></a></li>
						  			<li><a href="#tab-standard-d" data-toggle="pill"><?php echo $text_standard_d; ?></a></li>
								</ul>
							</div>
							<div class="col-sm-10">
								<div class="tab-content">
									<div class="tab-pane active" id="tab-global">
										<div class="form-group">
				      						<label class="col-sm-2 control-label" for="input-status-enabled"><span data-toggle="tooltip" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span></label>
				      						<div class="col-sm-4">
				      							<div class="radio-switch">
				      							<?php if ($ukrposhta_status) { ?>
									                <input type="radio" name="ukrposhta_status" value="0" id="input-status-disabled">
			                                        <label class="col-sm-4" for="input-status-enabled"><?php echo $text_disabled; ?></label>
				      								<input type="radio" name="ukrposhta_status" value="1" id="input-status-enabled" checked>
			                                        <label class="col-sm-4" for="input-status-disabled"><?php echo $text_enabled; ?></label>
									                <?php } else { ?>
			                                        <input type="radio" name="ukrposhta_status" value="0" id="input-status-disabled" checked>
			                                        <label class="col-sm-4" for="input-status-enabled"><?php echo $text_disabled; ?></label>
			                                        <input type="radio" name="ukrposhta_status" value="1" id="input-status-enabled">
			                                        <label class="col-sm-4" for="input-status-disabled"><?php echo $text_enabled; ?></label>
									            <?php } ?>
				      							</div>
				      						</div>
				      						<label class="col-sm-2 control-label" for="input-debugging_mode-enabled"><span data-toggle="tooltip" title="<?php echo $help_debugging_mode; ?>"><?php echo $entry_debugging_mode; ?></span></label>
				      						<div class="col-sm-4">
				      							<div class="radio-switch">
				      							<?php if ($ukrposhta['debugging_mode']) { ?>
									                <input type="radio" name="ukrposhta[debugging_mode]" value="0" id="input-debugging_mode-disabled">
			                                        <label class="col-sm-4" for="input-debugging_mode-enabled"><?php echo $text_disabled; ?></label>
				      								<input type="radio" name="ukrposhta[debugging_mode]" value="1" id="input-debugging_mode-enabled" checked>
			                                        <label class="col-sm-4" for="input-debugging_mode-disabled"><?php echo $text_enabled; ?></label>
									                <?php } else { ?>
			                                        <input type="radio" name="ukrposhta[debugging_mode]" value="0" id="input-debugging_mode-disabled" checked>
			                                        <label class="col-sm-4" for="input-debugging_mode-enabled"><?php echo $text_disabled; ?></label>
			                                        <input type="radio" name="ukrposhta[debugging_mode]" value="1" id="input-debugging_mode-enabled">
			                                        <label class="col-sm-4" for="input-debugging_mode-disabled"><?php echo $text_enabled; ?></label>
									            <?php } ?>
				      							</div>
				      						</div>
			            				</div>
			            				<div class="form-group">
			            					<label class="col-sm-2 control-label" for="input-sort_order"><span data-toggle="tooltip" title="<?php echo $help_sort_order; ?>"><?php echo $entry_sort_order; ?></span></label>
			            					<div class="col-sm-10">
			              						<input type="text" name="ukrposhta_sort_order" value="<?php echo $ukrposhta_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort_order" class="form-control" />
			            					</div>
			            				</div>
			            				<div class="form-group required">
					            			<label class="col-sm-2 control-label" for="input-ecom_bearer"><span data-toggle="tooltip" title="<?php echo $help_ecom_bearer; ?>"><?php echo $entry_ecom_bearer; ?></span></label>
					            			<div class="col-sm-10">
					              				<input type="text" name="ukrposhta[ecom_bearer]" value="<?php echo $ukrposhta['ecom_bearer']; ?>" placeholder="<?php echo $entry_ecom_bearer; ?>" id="input-ecom_bearer" class="form-control" />
												<?php if ($error_ecom_bearer) { ?>
												<div class="text-danger"><?php echo $error_ecom_bearer; ?></div>
												<?php } ?>
					            			</div>
					          			</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-tracking_bearer"><span data-toggle="tooltip" title="<?php echo $help_tracking_bearer; ?>"><?php echo $entry_tracking_bearer; ?></span></label>
											<div class="col-sm-10">
												<input type="text" name="ukrposhta[tracking_bearer]" value="<?php echo $ukrposhta['tracking_bearer']; ?>" placeholder="<?php echo $entry_tracking_bearer; ?>" id="input-tracking_bearer" class="form-control" />
												<?php if ($error_tracking_bearer) { ?>
												<div class="text-danger"><?php echo $error_tracking_bearer; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-user_token"><span data-toggle="tooltip" title="<?php echo $help_user_token; ?>"><?php echo $entry_user_token; ?></span></label>
											<div class="col-sm-10">
												<input type="text" name="ukrposhta[user_token]" value="<?php echo $ukrposhta['user_token']; ?>" placeholder="<?php echo $entry_user_token; ?>" id="input-user_token" class="form-control" />
												<?php if ($error_user_token) { ?>
												<div class="text-danger"><?php echo $error_user_token; ?></div>
												<?php } ?>
											</div>
										</div>
			            				<div class="form-group">
					          				<label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $help_image; ?>"><?php echo $entry_image; ?></span></label>
					          				<div class="col-sm-4">
					          					<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
					          					<input type="hidden" name="ukrposhta[image]" value="<?php echo $ukrposhta['image']; ?>" id="input-image" />
					          				</div>
					          				<label class="col-sm-2 control-label" for="input-image_output_place"><span data-toggle="tooltip" title="<?php echo $help_image_output_place; ?>"><?php echo $entry_image_output_place; ?></span></label>
					          				<div class="col-sm-4">
					          					<select name="ukrposhta[image_output_place]" id="input-image_output_place" class="form-control">
					          						<option value="0"><?php echo $text_select; ?></option>
			                						<?php foreach ($image_output_places as $code => $name) { ?>
			                							<?php if ($code == $ukrposhta['image_output_place']) { ?>
			                								<option value="<?php echo $code; ?>" selected="selected"><?php echo $name; ?></option>
			                							<?php } else { ?>
			                								<option value="<?php echo $code; ?>"><?php echo $name; ?></option>
			               								<?php } ?>
			                						<?php } ?>
			              						</select>
					          				</div>
					          			</div>
									</div>
									<div class="tab-pane fade" id="tab-express-w">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_status-enabled"><span data-toggle="tooltip" title="<?php echo $help_method_status; ?>"><?php echo $entry_method_status; ?></span></label>
											<div class="col-sm-4">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_w']['status']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][status]" value="0" id="input-express_w_status-disabled">
													<label class="col-sm-4" for="input-express_w_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][status]" value="1" id="input-express_w_status-enabled" checked>
													<label class="col-sm-4" for="input-express_w_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][status]" value="0" id="input-express_w_status-disabled" checked>
													<label class="col-sm-4" for="input-express_w_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][status]" value="1" id="input-express_w_status-enabled">
													<label class="col-sm-4" for="input-express_w_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_name"><span data-toggle="tooltip" title="<?php echo $help_name; ?>"><?php echo $entry_name; ?></span></label>
											<div class="col-sm-10">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#express_w_name_<?php echo $language['language_id']; ?>" aria-controls="express_w_name_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="express_w_name_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][express_w][name][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['express_w']['name'][$language['language_id']]; ?>" placeholder="<?php echo $entry_name; ?>" id="input-express_w_name_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_geo_zone_id"><span data-toggle="tooltip" title="<?php echo $help_geo_zone; ?>"><?php echo $entry_geo_zone; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][express_w][geo_zone_id]" id="input-express_w_geo_zone_id" class="form-control">
													<option value="0"><?php echo $text_all_zones; ?></option>
													<?php foreach ($geo_zones as $geo_zone) { ?>
													<?php if ($geo_zone['geo_zone_id'] == $ukrposhta['shipping_methods']['express_w']['geo_zone_id']) { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_tax_class_id"><span data-toggle="tooltip" title="<?php echo $help_tax_class; ?>"><?php echo $entry_tax_class; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][express_w][tax_class_id]" id="input-express_w_tax_class_id" class="form-control">
													<option value="0"><?php echo $text_none; ?></option>
													<?php foreach ($tax_classes as $tax_class) { ?>
													<?php if ($tax_class['tax_class_id'] == $ukrposhta['shipping_methods']['express_w']['tax_class_id']) { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_minimum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_minimum_order_amount; ?>"><?php echo $entry_minimum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][express_w][minimum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['express_w']['minimum_order_amount']; ?>" placeholder="<?php echo $entry_minimum_order_amount; ?>" id="input-express_w_minimum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_w_maximum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_maximum_order_amount; ?>"><?php echo $entry_maximum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][express_w][maximum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['express_w']['maximum_order_amount']; ?>" placeholder="<?php echo $entry_maximum_order_amount; ?>" id="input-express_w_maximum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_free_shipping"><span data-toggle="tooltip" title="<?php echo $help_free_shipping; ?>"><?php echo $entry_free_shipping; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][express_w][free_shipping]" value="<?php echo $ukrposhta['shipping_methods']['express_w']['free_shipping']; ?>" placeholder="<?php echo $entry_free_shipping; ?>" id="input-express_w_free_shipping" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_w_free_cost_text"><span data-toggle="tooltip" title="<?php echo $help_free_cost_text; ?>"><?php echo $entry_free_cost_text; ?></span></label>
											<div class="col-sm-4">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#express_w_free_cost_text_<?php echo $language['language_id']; ?>" aria-controls="express_w_free_cost_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="express_w_free_cost_text_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][express_w][free_cost_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['express_w']['free_cost_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_free_cost_text; ?>" id="input-express_w_free_cost_text_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_cost-enabled"><span data-toggle="tooltip" title="<?php echo $help_cost; ?>"><?php echo $entry_cost; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_w']['cost']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][cost]" value="0" id="input-express_w_cost-disabled">
													<label class="col-sm-4" for="input-express_w_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][cost]" value="1" id="input-express_w_cost-enabled" checked>
													<label class="col-sm-4" for="input-express_w_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][cost]" value="0" id="input-express_w_cost-disabled" checked>
													<label class="col-sm-4" for="input-express_w_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][cost]" value="1" id="input-express_w_cost-enabled">
													<label class="col-sm-4" for="input-express_w_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_w_api_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_api_calculation; ?>"><?php echo $entry_api_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_w']['api_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][api_calculation]" value="0" id="input-express_w_api_calculation-disabled">
													<label class="col-sm-4" for="input-express_w_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][api_calculation]" value="1" id="input-express_w_api_calculation-enabled" checked>
													<label class="col-sm-4" for="input-express_w_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][api_calculation]" value="0" id="input-express_w_api_calculation-disabled" checked>
													<label class="col-sm-4" for="input-express_w_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][api_calculation]" value="1" id="input-express_w_api_calculation-enabled">
													<label class="col-sm-4" for="input-express_w_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_w_tariff_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_tariff_calculation; ?>"><?php echo $entry_tariff_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_w']['tariff_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][tariff_calculation]" value="0" id="input-express_w_tariff_calculation-disabled">
													<label class="col-sm-4" for="input-express_w_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][tariff_calculation]" value="1" id="input-express_w_tariff_calculation-enabled" checked>
													<label class="col-sm-4" for="input-express_w_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][tariff_calculation]" value="0" id="input-express_w_tariff_calculation-disabled" checked>
													<label class="col-sm-4" for="input-express_w_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][tariff_calculation]" value="1" id="input-express_w_tariff_calculation-enabled">
													<label class="col-sm-4" for="input-express_w_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_w_delivery_period-enabled"><span data-toggle="tooltip" title="<?php echo $help_delivery_period; ?>"><?php echo $entry_delivery_period; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_w']['delivery_period']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][delivery_period]" value="0" id="input-express_w_delivery_period-disabled">
													<label class="col-sm-4" for="input-express_w_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][delivery_period]" value="1" id="input-express_w_delivery_period-enabled" checked>
													<label class="col-sm-4" for="input-express_w_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][delivery_period]" value="0" id="input-express_w_delivery_period-disabled" checked>
													<label class="col-sm-4" for="input-express_w_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_w][delivery_period]" value="1" id="input-express_w_delivery_period-enabled">
													<label class="col-sm-4" for="input-express_w_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab-express-d">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_status-enabled"><span data-toggle="tooltip" title="<?php echo $help_method_status; ?>"><?php echo $entry_method_status; ?></span></label>
											<div class="col-sm-4">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_d']['status']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][status]" value="0" id="input-express_d_status-disabled">
													<label class="col-sm-4" for="input-express_d_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][status]" value="1" id="input-express_d_status-enabled" checked>
													<label class="col-sm-4" for="input-express_d_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][status]" value="0" id="input-express_d_status-disabled" checked>
													<label class="col-sm-4" for="input-express_d_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][status]" value="1" id="input-express_d_status-enabled">
													<label class="col-sm-4" for="input-express_d_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_name"><span data-toggle="tooltip" title="<?php echo $help_name; ?>"><?php echo $entry_name; ?></span></label>
											<div class="col-sm-10">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#express_d_name_<?php echo $language['language_id']; ?>" aria-controls="express_d_name_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="express_d_name_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][express_d][name][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['express_d']['name'][$language['language_id']]; ?>" placeholder="<?php echo $entry_name; ?>" id="input-express_d_name_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_geo_zone_id"><span data-toggle="tooltip" title="<?php echo $help_geo_zone; ?>"><?php echo $entry_geo_zone; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][express_d][geo_zone_id]" id="input-express_d_geo_zone_id" class="form-control">
													<option value="0"><?php echo $text_all_zones; ?></option>
													<?php foreach ($geo_zones as $geo_zone) { ?>
													<?php if ($geo_zone['geo_zone_id'] == $ukrposhta['shipping_methods']['express_d']['geo_zone_id']) { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_tax_class_id"><span data-toggle="tooltip" title="<?php echo $help_tax_class; ?>"><?php echo $entry_tax_class; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][express_d][tax_class_id]" id="input-express_d_tax_class_id" class="form-control">
													<option value="0"><?php echo $text_none; ?></option>
													<?php foreach ($tax_classes as $tax_class) { ?>
													<?php if ($tax_class['tax_class_id'] == $ukrposhta['shipping_methods']['express_d']['tax_class_id']) { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_minimum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_minimum_order_amount; ?>"><?php echo $entry_minimum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][express_d][minimum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['express_d']['minimum_order_amount']; ?>" placeholder="<?php echo $entry_minimum_order_amount; ?>" id="input-express_d_minimum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_d_maximum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_maximum_order_amount; ?>"><?php echo $entry_maximum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][express_d][maximum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['express_d']['maximum_order_amount']; ?>" placeholder="<?php echo $entry_maximum_order_amount; ?>" id="input-express_d_maximum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_free_shipping"><span data-toggle="tooltip" title="<?php echo $help_free_shipping; ?>"><?php echo $entry_free_shipping; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][express_d][free_shipping]" value="<?php echo $ukrposhta['shipping_methods']['express_d']['free_shipping']; ?>" placeholder="<?php echo $entry_free_shipping; ?>" id="input-express_d_free_shipping" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_d_free_cost_text"><span data-toggle="tooltip" title="<?php echo $help_free_cost_text; ?>"><?php echo $entry_free_cost_text; ?></span></label>
											<div class="col-sm-4">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#express_d_free_cost_text_<?php echo $language['language_id']; ?>" aria-controls="express_d_free_cost_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="express_d_free_cost_text_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][express_d][free_cost_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['express_d']['free_cost_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_free_cost_text; ?>" id="input-express_d_free_cost_text_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_cost-enabled"><span data-toggle="tooltip" title="<?php echo $help_cost; ?>"><?php echo $entry_cost; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_d']['cost']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][cost]" value="0" id="input-express_d_cost-disabled">
													<label class="col-sm-4" for="input-express_d_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][cost]" value="1" id="input-express_d_cost-enabled" checked>
													<label class="col-sm-4" for="input-express_d_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][cost]" value="0" id="input-express_d_cost-disabled" checked>
													<label class="col-sm-4" for="input-express_d_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][cost]" value="1" id="input-express_d_cost-enabled">
													<label class="col-sm-4" for="input-express_d_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_d_api_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_api_calculation; ?>"><?php echo $entry_api_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_d']['api_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][api_calculation]" value="0" id="input-express_d_api_calculation-disabled">
													<label class="col-sm-4" for="input-express_d_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][api_calculation]" value="1" id="input-express_d_api_calculation-enabled" checked>
													<label class="col-sm-4" for="input-express_d_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][api_calculation]" value="0" id="input-express_d_api_calculation-disabled" checked>
													<label class="col-sm-4" for="input-express_d_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][api_calculation]" value="1" id="input-express_d_api_calculation-enabled">
													<label class="col-sm-4" for="input-express_d_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-express_d_tariff_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_tariff_calculation; ?>"><?php echo $entry_tariff_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_d']['tariff_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][tariff_calculation]" value="0" id="input-express_d_tariff_calculation-disabled">
													<label class="col-sm-4" for="input-express_d_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][tariff_calculation]" value="1" id="input-express_d_tariff_calculation-enabled" checked>
													<label class="col-sm-4" for="input-express_d_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][tariff_calculation]" value="0" id="input-express_d_tariff_calculation-disabled" checked>
													<label class="col-sm-4" for="input-express_d_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][tariff_calculation]" value="1" id="input-express_d_tariff_calculation-enabled">
													<label class="col-sm-4" for="input-express_d_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-express_d_delivery_period-enabled"><span data-toggle="tooltip" title="<?php echo $help_delivery_period; ?>"><?php echo $entry_delivery_period; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['express_d']['delivery_period']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][delivery_period]" value="0" id="input-express_d_delivery_period-disabled">
													<label class="col-sm-4" for="input-express_d_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][delivery_period]" value="1" id="input-express_d_delivery_period-enabled" checked>
													<label class="col-sm-4" for="input-express_d_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][delivery_period]" value="0" id="input-express_d_delivery_period-disabled" checked>
													<label class="col-sm-4" for="input-express_d_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][express_d][delivery_period]" value="1" id="input-express_d_delivery_period-enabled">
													<label class="col-sm-4" for="input-express_d_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="tab-standard-w">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_status-enabled"><span data-toggle="tooltip" title="<?php echo $help_method_status; ?>"><?php echo $entry_method_status; ?></span></label>
											<div class="col-sm-4">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_w']['status']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][status]" value="0" id="input-standard_w_status-disabled">
													<label class="col-sm-4" for="input-standard_w_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][status]" value="1" id="input-standard_w_status-enabled" checked>
													<label class="col-sm-4" for="input-standard_w_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][status]" value="0" id="input-standard_w_status-disabled" checked>
													<label class="col-sm-4" for="input-standard_w_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][status]" value="1" id="input-standard_w_status-enabled">
													<label class="col-sm-4" for="input-standard_w_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_name"><span data-toggle="tooltip" title="<?php echo $help_name; ?>"><?php echo $entry_name; ?></span></label>
											<div class="col-sm-10">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#standard_w_name_<?php echo $language['language_id']; ?>" aria-controls="standard_w_name_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="standard_w_name_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][standard_w][name][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['standard_w']['name'][$language['language_id']]; ?>" placeholder="<?php echo $entry_name; ?>" id="input-standard_w_name_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_geo_zone_id"><span data-toggle="tooltip" title="<?php echo $help_geo_zone; ?>"><?php echo $entry_geo_zone; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][standard_w][geo_zone_id]" id="input-standard_w_geo_zone_id" class="form-control">
													<option value="0"><?php echo $text_all_zones; ?></option>
													<?php foreach ($geo_zones as $geo_zone) { ?>
													<?php if ($geo_zone['geo_zone_id'] == $ukrposhta['shipping_methods']['standard_w']['geo_zone_id']) { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_tax_class_id"><span data-toggle="tooltip" title="<?php echo $help_tax_class; ?>"><?php echo $entry_tax_class; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][standard_w][tax_class_id]" id="input-standard_w_tax_class_id" class="form-control">
													<option value="0"><?php echo $text_none; ?></option>
													<?php foreach ($tax_classes as $tax_class) { ?>
													<?php if ($tax_class['tax_class_id'] == $ukrposhta['shipping_methods']['standard_w']['tax_class_id']) { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_minimum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_minimum_order_amount; ?>"><?php echo $entry_minimum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][standard_w][minimum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['standard_w']['minimum_order_amount']; ?>" placeholder="<?php echo $entry_minimum_order_amount; ?>" id="input-standard_w_minimum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_w_maximum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_maximum_order_amount; ?>"><?php echo $entry_maximum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][standard_w][maximum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['standard_w']['maximum_order_amount']; ?>" placeholder="<?php echo $entry_maximum_order_amount; ?>" id="input-standard_w_maximum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_free_shipping"><span data-toggle="tooltip" title="<?php echo $help_free_shipping; ?>"><?php echo $entry_free_shipping; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][standard_w][free_shipping]" value="<?php echo $ukrposhta['shipping_methods']['standard_w']['free_shipping']; ?>" placeholder="<?php echo $entry_free_shipping; ?>" id="input-standard_w_free_shipping" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_w_free_cost_text"><span data-toggle="tooltip" title="<?php echo $help_free_cost_text; ?>"><?php echo $entry_free_cost_text; ?></span></label>
											<div class="col-sm-4">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#standard_w_free_cost_text_<?php echo $language['language_id']; ?>" aria-controls="standard_w_free_cost_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="standard_w_free_cost_text_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][standard_w][free_cost_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['standard_w']['free_cost_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_free_cost_text; ?>" id="input-standard_w_free_cost_text_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_cost-enabled"><span data-toggle="tooltip" title="<?php echo $help_cost; ?>"><?php echo $entry_cost; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_w']['cost']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][cost]" value="0" id="input-standard_w_cost-disabled">
													<label class="col-sm-4" for="input-standard_w_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][cost]" value="1" id="input-standard_w_cost-enabled" checked>
													<label class="col-sm-4" for="input-standard_w_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][cost]" value="0" id="input-standard_w_cost-disabled" checked>
													<label class="col-sm-4" for="input-standard_w_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][cost]" value="1" id="input-standard_w_cost-enabled">
													<label class="col-sm-4" for="input-standard_w_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_w_api_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_api_calculation; ?>"><?php echo $entry_api_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_w']['api_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][api_calculation]" value="0" id="input-standard_w_api_calculation-disabled">
													<label class="col-sm-4" for="input-standard_w_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][api_calculation]" value="1" id="input-standard_w_api_calculation-enabled" checked>
													<label class="col-sm-4" for="input-standard_w_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][api_calculation]" value="0" id="input-standard_w_api_calculation-disabled" checked>
													<label class="col-sm-4" for="input-standard_w_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][api_calculation]" value="1" id="input-standard_w_api_calculation-enabled">
													<label class="col-sm-4" for="input-standard_w_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_w_tariff_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_tariff_calculation; ?>"><?php echo $entry_tariff_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_w']['tariff_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][tariff_calculation]" value="0" id="input-standard_w_tariff_calculation-disabled">
													<label class="col-sm-4" for="input-standard_w_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][tariff_calculation]" value="1" id="input-standard_w_tariff_calculation-enabled" checked>
													<label class="col-sm-4" for="input-standard_w_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][tariff_calculation]" value="0" id="input-standard_w_tariff_calculation-disabled" checked>
													<label class="col-sm-4" for="input-standard_w_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][tariff_calculation]" value="1" id="input-standard_w_tariff_calculation-enabled">
													<label class="col-sm-4" for="input-standard_w_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_w_delivery_period-enabled"><span data-toggle="tooltip" title="<?php echo $help_delivery_period; ?>"><?php echo $entry_delivery_period; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_w']['delivery_period']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][delivery_period]" value="0" id="input-standard_w_delivery_period-disabled">
													<label class="col-sm-4" for="input-standard_w_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][delivery_period]" value="1" id="input-standard_w_delivery_period-enabled" checked>
													<label class="col-sm-4" for="input-standard_w_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][delivery_period]" value="0" id="input-standard_w_delivery_period-disabled" checked>
													<label class="col-sm-4" for="input-standard_w_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_w][delivery_period]" value="1" id="input-standard_w_delivery_period-enabled">
													<label class="col-sm-4" for="input-standard_w_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab-standard-d">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_status-enabled"><span data-toggle="tooltip" title="<?php echo $help_method_status; ?>"><?php echo $entry_method_status; ?></span></label>
											<div class="col-sm-4">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_d']['status']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][status]" value="0" id="input-standard_d_status-disabled">
													<label class="col-sm-4" for="input-standard_d_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][status]" value="1" id="input-standard_d_status-enabled" checked>
													<label class="col-sm-4" for="input-standard_d_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][status]" value="0" id="input-standard_d_status-disabled" checked>
													<label class="col-sm-4" for="input-standard_d_status-enabled"><?php echo $text_disabled; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][status]" value="1" id="input-standard_d_status-enabled">
													<label class="col-sm-4" for="input-standard_d_status-disabled"><?php echo $text_enabled; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_name"><span data-toggle="tooltip" title="<?php echo $help_name; ?>"><?php echo $entry_name; ?></span></label>
											<div class="col-sm-10">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#standard_d_name_<?php echo $language['language_id']; ?>" aria-controls="standard_d_name_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="standard_d_name_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][standard_d][name][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['standard_d']['name'][$language['language_id']]; ?>" placeholder="<?php echo $entry_name; ?>" id="input-standard_d_name_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_geo_zone_id"><span data-toggle="tooltip" title="<?php echo $help_geo_zone; ?>"><?php echo $entry_geo_zone; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][standard_d][geo_zone_id]" id="input-standard_d_geo_zone_id" class="form-control">
													<option value="0"><?php echo $text_all_zones; ?></option>
													<?php foreach ($geo_zones as $geo_zone) { ?>
													<?php if ($geo_zone['geo_zone_id'] == $ukrposhta['shipping_methods']['standard_d']['geo_zone_id']) { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_tax_class_id"><span data-toggle="tooltip" title="<?php echo $help_tax_class; ?>"><?php echo $entry_tax_class; ?></span></label>
											<div class="col-sm-10">
												<select name="ukrposhta[shipping_methods][standard_d][tax_class_id]" id="input-standard_d_tax_class_id" class="form-control">
													<option value="0"><?php echo $text_none; ?></option>
													<?php foreach ($tax_classes as $tax_class) { ?>
													<?php if ($tax_class['tax_class_id'] == $ukrposhta['shipping_methods']['standard_d']['tax_class_id']) { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_minimum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_minimum_order_amount; ?>"><?php echo $entry_minimum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][standard_d][minimum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['standard_d']['minimum_order_amount']; ?>" placeholder="<?php echo $entry_minimum_order_amount; ?>" id="input-standard_d_minimum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_d_maximum_order_amount"><span data-toggle="tooltip" title="<?php echo $help_maximum_order_amount; ?>"><?php echo $entry_maximum_order_amount; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][standard_d][maximum_order_amount]" value="<?php echo $ukrposhta['shipping_methods']['standard_d']['maximum_order_amount']; ?>" placeholder="<?php echo $entry_maximum_order_amount; ?>" id="input-standard_d_maximum_order_amount" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_free_shipping"><span data-toggle="tooltip" title="<?php echo $help_free_shipping; ?>"><?php echo $entry_free_shipping; ?></span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="ukrposhta[shipping_methods][standard_d][free_shipping]" value="<?php echo $ukrposhta['shipping_methods']['standard_d']['free_shipping']; ?>" placeholder="<?php echo $entry_free_shipping; ?>" id="input-standard_d_free_shipping" class="form-control" />
													<span class="input-group-addon"><?php echo $text_grn; ?></span>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_d_free_cost_text"><span data-toggle="tooltip" title="<?php echo $help_free_cost_text; ?>"><?php echo $entry_free_cost_text; ?></span></label>
											<div class="col-sm-4">
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($languages as $language) { ?>
													<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#standard_d_free_cost_text_<?php echo $language['language_id']; ?>" aria-controls="standard_d_free_cost_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']]; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($languages as $language) { ?>
													<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="standard_d_free_cost_text_<?php echo $language['language_id']; ?>">
														<input type="text" name="ukrposhta[shipping_methods][standard_d][free_cost_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['shipping_methods']['standard_d']['free_cost_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_free_cost_text; ?>" id="input-standard_d_free_cost_text_<?php echo $language['language_id']; ?>" class="form-control" />
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_cost-enabled"><span data-toggle="tooltip" title="<?php echo $help_cost; ?>"><?php echo $entry_cost; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_d']['cost']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][cost]" value="0" id="input-standard_d_cost-disabled">
													<label class="col-sm-4" for="input-standard_d_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][cost]" value="1" id="input-standard_d_cost-enabled" checked>
													<label class="col-sm-4" for="input-standard_d_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][cost]" value="0" id="input-standard_d_cost-disabled" checked>
													<label class="col-sm-4" for="input-standard_d_cost-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][cost]" value="1" id="input-standard_d_cost-enabled">
													<label class="col-sm-4" for="input-standard_d_cost-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_d_api_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_api_calculation; ?>"><?php echo $entry_api_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_d']['api_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][api_calculation]" value="0" id="input-standard_d_api_calculation-disabled">
													<label class="col-sm-4" for="input-standard_d_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][api_calculation]" value="1" id="input-standard_d_api_calculation-enabled" checked>
													<label class="col-sm-4" for="input-standard_d_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][api_calculation]" value="0" id="input-standard_d_api_calculation-disabled" checked>
													<label class="col-sm-4" for="input-standard_d_api_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][api_calculation]" value="1" id="input-standard_d_api_calculation-enabled">
													<label class="col-sm-4" for="input-standard_d_api_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
											<label class="col-sm-2 control-label" for="input-standard_d_tariff_calculation-enabled"><span data-toggle="tooltip" title="<?php echo $help_tariff_calculation; ?>"><?php echo $entry_tariff_calculation; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_d']['tariff_calculation']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][tariff_calculation]" value="0" id="input-standard_d_tariff_calculation-disabled">
													<label class="col-sm-4" for="input-standard_d_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][tariff_calculation]" value="1" id="input-standard_d_tariff_calculation-enabled" checked>
													<label class="col-sm-4" for="input-standard_d_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][tariff_calculation]" value="0" id="input-standard_d_tariff_calculation-disabled" checked>
													<label class="col-sm-4" for="input-standard_d_tariff_calculation-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][tariff_calculation]" value="1" id="input-standard_d_tariff_calculation-enabled">
													<label class="col-sm-4" for="input-standard_d_tariff_calculation-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-standard_d_delivery_period-enabled"><span data-toggle="tooltip" title="<?php echo $help_delivery_period; ?>"><?php echo $entry_delivery_period; ?></span></label>
											<div class="col-sm-2">
												<div class="radio-switch">
													<?php if ($ukrposhta['shipping_methods']['standard_d']['delivery_period']) { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][delivery_period]" value="0" id="input-standard_d_delivery_period-disabled">
													<label class="col-sm-4" for="input-standard_d_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][delivery_period]" value="1" id="input-standard_d_delivery_period-enabled" checked>
													<label class="col-sm-4" for="input-standard_d_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } else { ?>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][delivery_period]" value="0" id="input-standard_d_delivery_period-disabled" checked>
													<label class="col-sm-4" for="input-standard_d_delivery_period-enabled"><?php echo $text_no; ?></label>
													<input type="radio" name="ukrposhta[shipping_methods][standard_d][delivery_period]" value="1" id="input-standard_d_delivery_period-enabled">
													<label class="col-sm-4" for="input-standard_d_delivery_period-disabled"><?php echo $text_yes; ?></label>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                  		</div>
						<div class="tab-pane fade" id="tab-tariffs">
							<blockquote>
								<h2><?php echo $text_express_tariffs; ?></h2>
							</blockquote>
							<div class="table-responsive">
								<table class="table table-bordered table-hover" id="table-tariffs-express">
									<thead>
									<tr>
										<td class="text-center" rowspan="3"><?php echo $column_weight; ?></td>
										<td class="text-center" rowspan="3"><?php echo $column_longest_side; ?></td>
										<td class="text-center" colspan="2"><?php echo $column_warehouse_service_cost; ?></td>
										<td class="text-center" colspan="2"><?php echo $column_doors_service_cost; ?></td>
										<td class="text-center" rowspan="3"><?php echo $column_action; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo $column_tariff_zone_region; ?></td>
										<td class="text-center"><?php echo $column_tariff_zone_ukraine; ?></td>
										<td class="text-center" rowspan="2"><?php echo $column_doors_pickup; ?></td>
										<td class="text-center" rowspan="2"><?php echo $column_doors_delivery; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo $column_delivery_period; ?> <input type="text" name="ukrposhta[tariffs][express][region_delivery_period]" value="<?php echo $ukrposhta['tariffs']['express']['region_delivery_period']; ?>" class="form-control" style="display: inline; width: auto;" /></td>
										<td class="text-center"><?php echo $column_delivery_period; ?> <input type="text" name="ukrposhta[tariffs][express][ukraine_delivery_period]" value="<?php echo $ukrposhta['tariffs']['express']['ukraine_delivery_period']; ?>" class="form-control" style="display: inline; width: auto;" /></td>
									</tr>
									</thead>
									<tbody>
									<?php if (isset($ukrposhta['tariffs']['express']) && is_array($ukrposhta['tariffs']['express'])) { ?>
									<?php foreach ($ukrposhta['tariffs']['express'] as $k => $tariff) { ?>
									<?php if (is_array($tariff)) { ?>
									<tr>
										<td><input type="text" name="ukrposhta[tariffs][express][<?php echo $k; ?>][weight]" value="<?php echo $tariff['weight']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][express][<?php echo $k; ?>][longest_side]" value="<?php echo $tariff['longest_side']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][express][<?php echo $k; ?>][region]" value="<?php echo $tariff['region']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][express][<?php echo $k; ?>][Ukraine]" value="<?php echo $tariff['Ukraine']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][express][<?php echo $k; ?>][overpay_doors_pickup]" value="<?php echo $tariff['overpay_doors_pickup']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][express][<?php echo $k; ?>][overpay_doors_delivery]" value="<?php echo $tariff['overpay_doors_delivery']; ?>" class="form-control" /></td>
										<td class="text-center"><button type="button" onclick="$(this).parents('tr').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
									</tr>
									<?php } ?>
									<?php } ?>
									<?php } ?>
									</tbody>
									<tfoot>
									<tr>
										<td colspan="6"></td>
										<td class="text-center"><button type="button" onclick="addTariff('express');" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
										</td>
									</tr>
									</tfoot>
								</table>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tariffs-express_discount"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
								<div class="col-sm-10">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][express][discount]" value="<?php echo $ukrposhta['tariffs']['express']['discount']; ?>" placeholder="<?php echo $entry_discount; ?>" id="input-tariffs-express_discount" class="form-control" />
										<span class="input-group-addon"><?php echo $text_pct; ?></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tariffs-express_declared_cost_commission"><span data-toggle="tooltip" title="<?php echo $help_declared_cost_commission; ?>"><?php echo $entry_declared_cost_commission; ?></span></label>
								<div class="col-sm-2">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][express][declared_cost_commission]" value="<?php echo $ukrposhta['tariffs']['express']['declared_cost_commission']; ?>" placeholder="<?php echo $entry_declared_cost_commission; ?>" id="input-tariffs-express_declared_cost_commission" class="form-control" />
										<span class="input-group-addon"><?php echo $text_pct; ?></span>
									</div>
								</div>
								<label class="col-sm-2 control-label" for="input-tariffs-express_declared_cost_minimum_commission"><span data-toggle="tooltip" title="<?php echo $help_declared_cost_minimum_commission; ?>"><?php echo $entry_declared_cost_minimum_commission; ?></span></label>
								<div class="col-sm-2">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][express][declared_cost_minimum_commission]" value="<?php echo $ukrposhta['tariffs']['express']['declared_cost_minimum_commission']; ?>" placeholder="<?php echo $entry_declared_cost_minimum_commission; ?>" id="input-tariffs-express_declared_cost_minimum_commission" class="form-control" />
										<span class="input-group-addon"><?php echo $text_grn; ?></span>
									</div>
								</div>
								<label class="col-sm-2 control-label" for="input-tariffs-express_declared_cost_bottom_line"><span data-toggle="tooltip" title="<?php echo $help_declared_cost_bottom_line; ?>"><?php echo $entry_declared_cost_bottom_line; ?></span></label>
								<div class="col-sm-2">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][express][declared_cost_bottom_line]" value="<?php echo $ukrposhta['tariffs']['express']['declared_cost_bottom_line']; ?>" placeholder="<?php echo $entry_declared_cost_bottom_line; ?>" id="input-tariffs-express_declared_cost_bottom_line" class="form-control" />
										<span class="input-group-addon"><?php echo $text_grn; ?></span>
									</div>
								</div>
							</div>
							<hr>
							<br><br><br>
							<blockquote>
								<h2><?php echo $text_standard_tariffs; ?></h2>
							</blockquote>
							<div class="table-responsive">
								<table class="table table-bordered table-hover" id="table-tariffs-standard">
									<thead>
									<tr>
										<td class="text-center" rowspan="3"><?php echo $column_weight; ?></td>
										<td class="text-center" rowspan="3"><?php echo $column_longest_side; ?></td>
										<td class="text-center" colspan="2"><?php echo $column_warehouse_service_cost; ?></td>
										<td class="text-center" colspan="2"><?php echo $column_doors_service_cost; ?></td>
										<td class="text-center" rowspan="3"><?php echo $column_action; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo $column_tariff_zone_region; ?></td>
										<td class="text-center"><?php echo $column_tariff_zone_ukraine; ?></td>
										<td class="text-center" rowspan="2"><?php echo $column_doors_pickup; ?></td>
										<td class="text-center" rowspan="2"><?php echo $column_doors_delivery; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo $column_delivery_period; ?> <input type="text" name="ukrposhta[tariffs][standard][region_delivery_period]" value="<?php echo $ukrposhta['tariffs']['standard']['region_delivery_period']; ?>" class="form-control" style="display: inline; width: auto;" /></td>
										<td class="text-center"><?php echo $column_delivery_period; ?> <input type="text" name="ukrposhta[tariffs][standard][ukraine_delivery_period]" value="<?php echo $ukrposhta['tariffs']['standard']['ukraine_delivery_period']; ?>" class="form-control" style="display: inline; width: auto;" /></td>
									</tr>
									</thead>
									<tbody>
									<?php if (isset($ukrposhta['tariffs']['standard']) && is_array($ukrposhta['tariffs']['standard'])) { ?>
									<?php foreach ($ukrposhta['tariffs']['standard'] as $k => $tariff) { ?>
									<?php if (is_array($tariff)) { ?>
									<tr>
										<td><input type="text" name="ukrposhta[tariffs][standard][<?php echo $k; ?>][weight]" value="<?php echo $tariff['weight']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][standard][<?php echo $k; ?>][longest_side]" value="<?php echo $tariff['longest_side']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][standard][<?php echo $k; ?>][region]" value="<?php echo $tariff['region']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][standard][<?php echo $k; ?>][Ukraine]" value="<?php echo $tariff['Ukraine']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][standard][<?php echo $k; ?>][overpay_doors_pickup]" value="<?php echo $tariff['overpay_doors_pickup']; ?>" class="form-control" /></td>
										<td><input type="text" name="ukrposhta[tariffs][standard][<?php echo $k; ?>][overpay_doors_delivery]" value="<?php echo $tariff['overpay_doors_delivery']; ?>" class="form-control" /></td>
										<td class="text-center"><button type="button" onclick="$(this).parents('tr').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
									</tr>
									<?php } ?>
									<?php } ?>
									<?php } ?>
									</tbody>
									<tfoot>
									<tr>
										<td colspan="6"></td>
										<td class="text-center"><button type="button" onclick="addTariff('standard');" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
										</td>
									</tr>
									</tfoot>
								</table>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tariffs-standard_discount"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
								<div class="col-sm-10">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][standard][discount]" value="<?php echo $ukrposhta['tariffs']['standard']['discount']; ?>" placeholder="<?php echo $entry_discount; ?>" id="input-tariffs-standard_discount" class="form-control" />
										<span class="input-group-addon"><?php echo $text_pct; ?></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tariffs-standard_declared_cost_commission"><span data-toggle="tooltip" title="<?php echo $help_declared_cost_commission; ?>"><?php echo $entry_declared_cost_commission; ?></span></label>
								<div class="col-sm-2">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][standard][declared_cost_commission]" value="<?php echo $ukrposhta['tariffs']['standard']['declared_cost_commission']; ?>" placeholder="<?php echo $entry_declared_cost_commission; ?>" id="input-tariffs-standard_declared_cost_commission" class="form-control" />
										<span class="input-group-addon"><?php echo $text_pct; ?></span>
									</div>
								</div>
								<label class="col-sm-2 control-label" for="input-tariffs-standard_declared_cost_minimum_commission"><span data-toggle="tooltip" title="<?php echo $help_declared_cost_minimum_commission; ?>"><?php echo $entry_declared_cost_minimum_commission; ?></span></label>
								<div class="col-sm-2">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][standard][declared_cost_minimum_commission]" value="<?php echo $ukrposhta['tariffs']['standard']['declared_cost_minimum_commission']; ?>" placeholder="<?php echo $entry_declared_cost_minimum_commission; ?>" id="input-tariffs-standard_declared_cost_minimum_commission" class="form-control" />
										<span class="input-group-addon"><?php echo $text_grn; ?></span>
									</div>
								</div>
								<label class="col-sm-2 control-label" for="input-tariffs-standard_declared_cost_bottom_line"><span data-toggle="tooltip" title="<?php echo $help_declared_cost_bottom_line; ?>"><?php echo $entry_declared_cost_bottom_line; ?></span></label>
								<div class="col-sm-2">
									<div class="input-group">
										<input type="text" name="ukrposhta[tariffs][standard][declared_cost_bottom_line]" value="<?php echo $ukrposhta['tariffs']['standard']['declared_cost_bottom_line']; ?>" placeholder="<?php echo $entry_declared_cost_bottom_line; ?>" id="input-tariffs-standard_declared_cost_bottom_line" class="form-control" />
										<span class="input-group-addon"><?php echo $text_grn; ?></span>
									</div>
								</div>
							</div>
							<hr>
						</div>
          				<div class="tab-pane fade" id="tab-database">
          					<div class="table-responsive">
            					<table class="table table-bordered table-hover">
              						<thead>
                						<tr>
                  							<td class="text-center"><?php echo $column_type; ?></td>
                  							<td class="text-center"><?php echo $column_date; ?></td>
                  							<td class="text-center"><?php echo $column_amount; ?></td>
                  							<td class="text-center"><?php echo $column_description; ?></td>
                  							<td class="text-center"><?php echo $column_action; ?></td>
                						</tr>
              						</thead>
              						<tbody>
               			 				<tr>
                  							<td class="text-left"><?php echo $entry_references; ?></td>
                  							<td class="text-center"><?php if (!empty($database['references']['update_datetime'])) { echo $database['references']['update_datetime']; } ?></td>
                  							<td class="text-center" id="td-references_amount"><?php if (!empty($database['references']['amount'])) { echo $database['references']['amount']; } ?></td>
                  							<td class="text-left"><?php echo $help_update_references; ?></td>
                  							<td class="text-center">
                  								<a onclick="update('references');" id="button-update_references" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="<?php echo $text_update; ?>"><i class="fa fa-refresh"></i></a>
                  							</td>
               			 				</tr>
              						</tbody>
            					</table>
          					</div>
          				</div>
          				<div class="tab-pane fade" id="tab-sender">
							<div class="alert alert-info" role="alert"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $text_help_sender_save; ?></div>
							<div class="alert alert-info" role="alert"><i class="fa fa-search" aria-hidden="true"></i> <?php echo $text_help_sender_search; ?></div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_name"><span data-toggle="tooltip" title="<?php echo $help_sender; ?>"><?php echo $entry_sender; ?></span></label>
								<div class="col-sm-10">
									<div class="input-group">
										<input type="text" name="ukrposhta[sender_name]" value="<?php echo $ukrposhta['sender_name']; ?>" placeholder="<?php echo $entry_sender; ?>" id="input-sender_name" class="form-control" />
										<input type="hidden" name="ukrposhta[sender]" value="<?php echo $ukrposhta['sender']; ?>" id="input-sender" />
										<span class="input-group-btn">
											<button type="button" id="button-sender_save" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_type"><span data-toggle="tooltip" title="<?php echo $help_sender_client_type; ?>"><?php echo $entry_client_type; ?></span></label>
								<div class="col-sm-10">
									<select name="ukrposhta[sender_type]" id="input-sender_type" class="form-control">
										<option value=""><?php echo $text_select; ?></option>
										<?php foreach ($client_types as $v) { ?>
										<?php if ($v['id'] == $ukrposhta['sender_type']) { ?>
										<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_tin"><span data-toggle="tooltip" title="<?php echo $help_sender_tin; ?>"><?php echo $entry_tin; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_tin]" value="<?php echo $ukrposhta['sender_tin']; ?>" placeholder="<?php echo $entry_tin; ?>" id="input-sender_tin" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_edrpou"><span data-toggle="tooltip" title="<?php echo $help_sender_edrpou; ?>"><?php echo $entry_edrpou; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_edrpou]" value="<?php echo $ukrposhta['sender_edrpou']; ?>" placeholder="<?php echo $entry_edrpou; ?>" id="input-sender_edrpou" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_bank_code"><span data-toggle="tooltip" title="<?php echo $help_sender_bank_code; ?>"><?php echo $entry_bank_code; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_bank_code]" value="<?php echo $ukrposhta['sender_bank_code']; ?>" placeholder="<?php echo $entry_bank_code; ?>" id="input-sender_bank_code" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_bank_account"><span data-toggle="tooltip" title="<?php echo $help_sender_bank_account; ?>"><?php echo $entry_bank_account; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_bank_account]" value="<?php echo $ukrposhta['sender_bank_account']; ?>" placeholder="<?php echo $entry_bank_account; ?>" id="input-sender_bank_account" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_email"><span data-toggle="tooltip" title="<?php echo $help_sender_email; ?>"><?php echo $entry_email; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_email]" value="<?php echo $ukrposhta['sender_email']; ?>" placeholder="<?php echo $entry_email; ?>" id="input-sender_email" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_phone"><span data-toggle="tooltip" title="<?php echo $help_sender_phone; ?>"><?php echo $entry_phone; ?></span></label>
								<div class="col-sm-10">
									<div class="input-group">
										<input type="text" name="ukrposhta[sender_phone]" value="<?php echo $ukrposhta['sender_phone']; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-sender_phone" class="form-control">
										<span class="input-group-btn">
											<button type="button" id="button-sender_search" data-toggle="tooltip" title="<?php echo $button_search; ?>" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_region"><span data-toggle="tooltip" title="<?php echo $help_sender_region; ?>"><?php echo $entry_region; ?></span></label>
								<div class="col-sm-10">
									<select name="ukrposhta[sender_region]" id="input-sender_region" class="form-control">
										<option value=""><?php echo $text_select; ?></option>
										<?php foreach ($zones as $v) { ?>
										<?php if ($v['zone_id'] == $ukrposhta['sender_region']) { ?>
										<option value="<?php echo $v['zone_id']; ?>" selected="selected"><?php echo $v['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $v['zone_id']; ?>"><?php echo $v['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-sender_city"><span data-toggle="tooltip" title="<?php echo $help_sender_city; ?>"><?php echo $entry_city; ?></span></label>
            					<div class="col-sm-10">
              						<input type="text" name="ukrposhta[sender_city]" value="<?php echo $ukrposhta['sender_city']; ?>" placeholder="<?php echo $entry_city; ?>" id="input-sender_city" class="form-control" />
              					</div>
              				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-sender_street"><span data-toggle="tooltip" title="<?php echo $help_sender_street; ?>"><?php echo $entry_street; ?></span></label>
            					<div class="col-sm-10">
              						<input type="text" name="ukrposhta[sender_street]" value="<?php echo $ukrposhta['sender_street']; ?>" placeholder="<?php echo $entry_street; ?>" id="input-sender_street" class="form-control" />
              					</div>
              				</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_house"><span data-toggle="tooltip" title="<?php echo $help_sender_house; ?>"><?php echo $entry_house; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_house]" value="<?php echo $ukrposhta['sender_house']; ?>" placeholder="<?php echo $entry_house; ?>" id="input-sender_house" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_flat"><span data-toggle="tooltip" title="<?php echo $help_sender_flat; ?>"><?php echo $entry_flat; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_flat]" value="<?php echo $ukrposhta['sender_flat']; ?>" placeholder="<?php echo $entry_flat; ?>" id="input-sender_flat" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_postcode"><span data-toggle="tooltip" title="<?php echo $help_sender_postcode; ?>"><?php echo $entry_postcode; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[sender_postcode]" value="<?php echo $ukrposhta['sender_postcode']; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-sender_postcode" class="form-control" />
									<input type="hidden" name="ukrposhta[sender_address]" value="<?php echo $ukrposhta['sender_address']; ?>" id="input-sender_address" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sender_address_pick_up-enabled"><span data-toggle="tooltip" title="<?php echo $help_address_pick_up; ?>"><?php echo $entry_address_pick_up; ?></span></label>
								<div class="col-sm-2">
									<div class="radio-switch">
										<?php if ($ukrposhta['sender_address_pick_up']) { ?>
										<input type="radio" name="ukrposhta[sender_address_pick_up]" value="0" id="input-sender_address_pick_up-disabled">
										<label class="col-sm-4" for="input-sender_address_pick_up-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[sender_address_pick_up]" value="1" id="input-sender_address_pick_up-enabled" checked>
										<label class="col-sm-4" for="input-sender_address_pick_up-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[sender_address_pick_up]" value="0" id="input-sender_address_pick_up-disabled" checked>
										<label class="col-sm-4" for="input-sender_address_pick_up-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[sender_address_pick_up]" value="1" id="input-sender_address_pick_up-enabled">
										<label class="col-sm-4" for="input-sender_address_pick_up-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
          				</div>
          				<div class="tab-pane fade" id="tab-recipient">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-recipient"><span data-toggle="tooltip" title="<?php echo $help_recipient; ?>"><?php echo $entry_recipient; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[recipient]" value="<?php echo $ukrposhta['recipient']; ?>" placeholder="<?php echo $entry_recipient; ?>" id="input-recipient" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-recipient_type"><span data-toggle="tooltip" title="<?php echo $help_recipient_client_type; ?>"><?php echo $entry_client_type; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[recipient_type]" value="<?php echo $ukrposhta['recipient_type']; ?>" placeholder="<?php echo $entry_client_type; ?>" id="input-recipient_type" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-recipient_tin"><span data-toggle="tooltip" title="<?php echo $help_recipient_tin; ?>"><?php echo $entry_tin; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[recipient_tin]" value="<?php echo $ukrposhta['recipient_tin']; ?>" placeholder="<?php echo $entry_tin; ?>" id="input-recipient_tin" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-recipient_edrpou"><span data-toggle="tooltip" title="<?php echo $help_recipient_edrpou; ?>"><?php echo $entry_edrpou; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[recipient_edrpou]" value="<?php echo $ukrposhta['recipient_edrpou']; ?>" placeholder="<?php echo $entry_edrpou; ?>" id="input-recipient_edrpou" class="form-control" />
								</div>
							</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-recipient_phone"><span data-toggle="tooltip" title="<?php echo $help_recipient_phone; ?>"><?php echo $entry_phone; ?></span></label>
            					<div class="col-sm-10">
            						<input type="text" name="ukrposhta[recipient_phone]" value="<?php echo $ukrposhta['recipient_phone']; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-recipient_phone" class="form-control" />
              					</div>
              				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-recipient_region"><span data-toggle="tooltip" title="<?php echo $help_recipient_region; ?>"><?php echo $entry_region; ?></span></label>
            					<div class="col-sm-10">
              						<input type="text" name="ukrposhta[recipient_region]" value="<?php echo $ukrposhta['recipient_region']; ?>" placeholder="<?php echo $entry_region; ?>" id="input-recipient_region" class="form-control" />
              					</div>
              				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-recipient_city"><span data-toggle="tooltip" title="<?php echo $help_recipient_city; ?>"><?php echo $entry_city; ?></span></label>
            					<div class="col-sm-10">
              						<input type="text" name="ukrposhta[recipient_city]" value="<?php echo $ukrposhta['recipient_city']; ?>" placeholder="<?php echo $entry_city; ?>" id="input-recipient_city" class="form-control" />
              					</div>
              				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-recipient_address"><span data-toggle="tooltip" title="<?php echo $help_recipient_address; ?>"><?php echo $entry_address; ?></span></label>
            					<div class="col-sm-10">
            						<input type="text" name="ukrposhta[recipient_address]" value="<?php echo $ukrposhta['recipient_address']; ?>" placeholder="<?php echo $entry_address; ?>" id="input-recipient_address" class="form-control" />
              					</div>
              				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-recipient_street"><span data-toggle="tooltip" title="<?php echo $help_recipient_street; ?>"><?php echo $entry_street; ?></span></label>
            					<div class="col-sm-10">
            						<input type="text" name="ukrposhta[recipient_street]" value="<?php echo $ukrposhta['recipient_street']; ?>" placeholder="<?php echo $entry_street; ?>" id="input-recipient_street" class="form-control" />
              					</div>
              				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-recipient_house"><span data-toggle="tooltip" title="<?php echo $help_recipient_house; ?>"><?php echo $entry_house; ?></span></label>
            					<div class="col-sm-10">
            						<input type="text" name="ukrposhta[recipient_house]" value="<?php echo $ukrposhta['recipient_house']; ?>" placeholder="<?php echo $entry_house; ?>" id="input-recipient_house" class="form-control" />
              					</div>
              				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-recipient_flat"><span data-toggle="tooltip" title="<?php echo $help_recipient_flat; ?>"><?php echo $entry_flat; ?></span></label>
            					<div class="col-sm-10">
            						<input type="text" name="ukrposhta[recipient_flat]" value="<?php echo $ukrposhta['recipient_flat']; ?>" placeholder="<?php echo $entry_flat; ?>" id="input-recipient_flat" class="form-control" />
              					</div>
              				</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-recipient_postcode"><span data-toggle="tooltip" title="<?php echo $help_recipient_postcode; ?>"><?php echo $entry_postcode; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ukrposhta[recipient_postcode]" value="<?php echo $ukrposhta['recipient_postcode']; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-recipient_postcode" class="form-control" />
								</div>
							</div>
          				</div>
          				<div class="tab-pane fade" id="tab-departure">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-calculate_volume-enabled"><span data-toggle="tooltip" title="<?php echo $help_calculate_volume; ?>"><?php echo $entry_calculate_volume; ?></span></label>
								<div class="col-sm-2">
									<div class="radio-switch">
										<?php if ($ukrposhta['calculate_volume']) { ?>
										<input type="radio" name="ukrposhta[calculate_volume]" value="0" id="input-calculate_volume-disabled">
										<label class="col-sm-4" for="input-calculate_volume-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[calculate_volume]" value="1" id="input-calculate_volume-enabled" checked>
										<label class="col-sm-4" for="input-calculate_volume-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[calculate_volume]" value="0" id="input-calculate_volume-disabled" checked>
										<label class="col-sm-4" for="input-calculate_volume-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[calculate_volume]" value="1" id="input-calculate_volume-enabled">
										<label class="col-sm-4" for="input-calculate_volume-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
								<label class="col-sm-2 control-label" for="input-calculate_volume_type"><span data-toggle="tooltip" title="<?php echo $help_calculate_volume_type; ?>"><?php echo $entry_calculate_volume_type; ?></span></label>
								<div class="col-sm-6">
									<select name="ukrposhta[calculate_volume_type]" id="input-calculate_volume_type" class="form-control">
										<?php foreach ($calculate_volume_types as $k => $v) { ?>
										<?php if ($k == $ukrposhta['calculate_volume_type']) { ?>
										<option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option>
										<?php } else { ?>
										<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
            				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-seats_amount"><span data-toggle="tooltip" title="<?php echo $help_seats_amount; ?>"><?php echo $entry_seats_amount; ?></span></label>
            					<div class="col-sm-10">
              						<input type="text" name="ukrposhta[seats_amount]" value="<?php echo $ukrposhta['seats_amount']; ?>" placeholder="<?php echo $entry_seats_amount; ?>" id="input-seats_amount" class="form-control" />
              					</div>
              				</div>
            				<div class="form-group">
			            		<label class="col-sm-2 control-label" for="input-announced_price"><span data-toggle="tooltip" title="<?php echo $help_announced_price; ?>"><?php echo $entry_announced_price; ?></span></label>
			            		<div class="col-sm-4">
			            			<div class="well well-sm" style="height: 150px; overflow: auto;">
			            			<?php if (is_array($totals)) { ?>
			            				<?php foreach ($totals as $code => $title) { ?>
			            				<div class="checkbox">
			            					<label>
			            					<?php if (!empty($ukrposhta['announced_price']) && is_array($ukrposhta['announced_price']) && in_array($code, $ukrposhta['announced_price'])) { ?>
			            						<input type="checkbox" name="ukrposhta[announced_price][]" value="<?php echo $code; ?>" checked="checked" /> <?php echo $title; ?>
			            					<?php } else { ?>
			            						<input type="checkbox" name="ukrposhta[announced_price][]" value="<?php echo $code; ?>" /> <?php echo $title; ?>
			            					<?php } ?>
			            					</label>
			            				</div>
			            				<?php } ?>
			            			<?php } ?>
									<?php if (!empty($ukrposhta['announced_price']) && is_array($ukrposhta['announced_price'])) { ?>
										<?php foreach ($ukrposhta['announced_price'] as $v) { ?>
										<?php if (is_array($v)) { ?>
										<div class="checkbox">
											<label>
											<?php if (in_array($v['code'], $ukrposhta['announced_price'])) { ?>
												<input type="checkbox" name="ukrposhta[announced_price][]" value="<?php echo $v['code']; ?>" checked="checked" /> <?php echo $v['name']; ?>
											<?php } else { ?>
												<input type="checkbox" name="ukrposhta[announced_price][]" value="<?php echo $v['code']; ?>" /> <?php echo $v['name']; ?>
											<?php } ?>
												<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parents('div.checkbox').remove();"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
											</label>
											<input type="hidden" name="ukrposhta[announced_price][<?php echo $v['code']; ?>][code]" value="<?php echo $v['code']; ?>" />
											<input type="hidden" name="ukrposhta[announced_price][<?php echo $v['code']; ?>][name]" value="<?php echo $v['name']; ?>" />
										</div>
										<?php } ?>
										<?php } ?>
									<?php } ?>
										<br/>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="<?php echo $button_add; ?>" onclick="addCustomMethod('announced_price');"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
			            			</div>
			            		</div>
			            		<label class="col-sm-2 control-label" for="input-announced_price_default"><span data-toggle="tooltip" title="<?php echo $help_announced_price_default; ?>"><?php echo $entry_announced_price_default; ?></span></label>
            					<div class="col-sm-4">
            						<div class="input-group">
              							<input type="text" name="ukrposhta[announced_price_default]" value="<?php echo $ukrposhta['announced_price_default']; ?>" placeholder="<?php echo $entry_announced_price_default; ?>" id="input-announced_price_default" class="form-control" />
              							<span class="input-group-addon"><?php echo $text_grn; ?></span>
              						</div>
              					</div>
			            	</div>
              				<div class="form-group">
			          			<label class="col-sm-2 control-label" for="input-departure_description"><span data-toggle="tooltip" title="<?php echo $help_departure_description; ?>"><?php echo $entry_departure_description; ?></span></label>
			            		<div class="col-sm-10">
									<a class="btn btn-default pull-right" data-toggle="collapse" href="#departure_description_t_m" aria-expanded="false" aria-controls="departure_description_t_m" role="button"><?php echo $text_macros; ?> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
									<div class="clearfix"></div>
									<div id="departure_description_t_m" class="collapse">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-sm-6">
													<?php echo $text_order_template_macros; ?>
												</div>
												<div class="col-sm-6">
													<?php echo $text_products_template_macros; ?>
												</div>
											</div>
										</div>
									</div>
			            			<textarea name="ukrposhta[departure_description]" rows="3" id="input-departure_description" class="form-control"><?php echo isset($ukrposhta['departure_description']) ? $ukrposhta['departure_description'] : ''; ?></textarea>
			          			</div>
			          		</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-recommended_letter-enabled"><span data-toggle="tooltip" title="<?php echo $help_recommended_letter; ?>"><?php echo $entry_recommended_letter; ?></span></label>
								<div class="col-sm-2">
									<div class="radio-switch">
										<?php if ($ukrposhta['recommended_letter']) { ?>
										<input type="radio" name="ukrposhta[recommended_letter]" value="0" id="input-recommended_letter-disabled">
										<label class="col-sm-4" for="input-recommended_letter-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[recommended_letter]" value="1" id="input-recommended_letter-enabled" checked>
										<label class="col-sm-4" for="input-recommended_letter-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[recommended_letter]" value="0" id="input-recommended_letter-disabled" checked>
										<label class="col-sm-4" for="input-recommended_letter-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[recommended_letter]" value="1" id="input-recommended_letter-enabled">
										<label class="col-sm-4" for="input-recommended_letter-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-check_on_delivery-enabled"><span data-toggle="tooltip" title="<?php echo $help_check_on_delivery; ?>"><?php echo $entry_check_on_delivery; ?></span></label>
								<div class="col-sm-2">
									<div class="radio-switch">
										<?php if ($ukrposhta['check_on_delivery']) { ?>
										<input type="radio" name="ukrposhta[check_on_delivery]" value="0" id="input-check_on_delivery-disabled">
										<label class="col-sm-4" for="input-check_on_delivery-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[check_on_delivery]" value="1" id="input-check_on_delivery-enabled" checked>
										<label class="col-sm-4" for="input-check_on_delivery-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[check_on_delivery]" value="0" id="input-check_on_delivery-disabled" checked>
										<label class="col-sm-4" for="input-check_on_delivery-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[check_on_delivery]" value="1" id="input-check_on_delivery-enabled">
										<label class="col-sm-4" for="input-check_on_delivery-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-on_fail_receive"><span data-toggle="tooltip" title="<?php echo $help_on_fail_receive; ?>"><?php echo $entry_on_fail_receive; ?></span></label>
								<div class="col-sm-10">
									<select name="ukrposhta[on_fail_receive]" id="input-on_fail_receive" class="form-control">
										<option value="0"><?php echo $text_select; ?></option>
										<?php foreach ($fail_receive_types as $v) { ?>
										<?php if (isset($ukrposhta['on_fail_receive']) && $v['id'] == $ukrposhta['on_fail_receive']) { ?>
										<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
            				<legend><?php echo $text_default_departure_options; ?></legend>
            				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-use_parameters"><span data-toggle="tooltip" title="<?php echo $help_use_parameters; ?>"><?php echo $entry_use_parameters; ?></span></label>
            					<div class="col-sm-10">
            						<select name="ukrposhta[use_parameters]" id="input-use_parameters" class="form-control">
                					<?php foreach ($use_parameters as $k => $v) { ?>
                						<?php if ($k == $ukrposhta['use_parameters']) { ?>
                						<option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option>
                						<?php } else { ?>
                						<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
               							<?php } ?>
                					<?php } ?>
              						</select>
            					</div>
            				</div>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-weight"><span data-toggle="tooltip" title="<?php echo $help_weight; ?>"><?php echo $entry_weight; ?></span></label>
            					<div class="col-sm-10">
            						<div class="input-group">
              							<input type="text" name="ukrposhta[weight]" value="<?php echo $ukrposhta['weight']; ?>" placeholder="0" id="input-weight" class="form-control" />
              							<span class="input-group-addon"><?php echo $text_kg; ?></span>
              						</div>
              					</div>
              				</div>
              				<div class="form-group">	
              					<label class="col-sm-2 control-label" for="input-dimensions_w"><span data-toggle="tooltip" title="<?php echo $help_dimensions; ?>"><?php echo $entry_dimensions; ?></span></label>
            					<div class="col-sm-3">
            						<div class="input-group">
              							<input type="text" name="ukrposhta[dimensions_w]" value="<?php echo $ukrposhta['dimensions_w']; ?>" placeholder="0" id="input-dimensions_w" class="form-control" />
              							<span class="input-group-addon"><?php echo $text_cm; ?></span>
              						</div>
            					</div>
            					<div class="col-sm-4">
            						<div class="input-group">
              							<input type="text" name="ukrposhta[dimensions_l]" value="<?php echo $ukrposhta['dimensions_l']; ?>" placeholder="0" id="input-dimensions_l" class="form-control" />
              							<span class="input-group-addon"><?php echo $text_cm; ?></span>
              						</div>
            					</div>
            					<div class="col-sm-3">
            						<div class="input-group">
	              						<input type="text" name="ukrposhta[dimensions_h]" value="<?php echo $ukrposhta['dimensions_h']; ?>" placeholder="0" id="input-dimensions_h" class="form-control" />
	              						<span class="input-group-addon"><?php echo $text_cm; ?></span>
              						</div>
            					</div>
          					</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-allowance_w"><span data-toggle="tooltip" title="<?php echo $help_allowance; ?>"><?php echo $entry_allowance; ?></span></label>
								<div class="col-sm-3">
									<div class="input-group">
										<input type="text" name="ukrposhta[allowance_w]" value="<?php echo $ukrposhta['allowance_w']; ?>" placeholder="0" id="input-allowance_w" class="form-control" />
										<span class="input-group-addon"><?php echo $text_cm; ?></span>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" name="ukrposhta[allowance_l]" value="<?php echo $ukrposhta['allowance_l']; ?>" placeholder="0" id="input-allowance_l" class="form-control" />
										<span class="input-group-addon"><?php echo $text_cm; ?></span>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="input-group">
										<input type="text" name="ukrposhta[allowance_h]" value="<?php echo $ukrposhta['allowance_h']; ?>" placeholder="0" id="input-allowance_h" class="form-control" />
										<span class="input-group-addon"><?php echo $text_cm; ?></span>
									</div>
								</div>
							</div>
          				</div>
          				<div class="tab-pane fade" id="tab-payment">
          					<div class="form-group">
          						<label class="col-sm-2 control-label" for="input-payer"><span data-toggle="tooltip" title="<?php echo $help_payer; ?>"><?php echo $entry_payer; ?></span></label>
            					<div class="col-sm-10">
            						<select name="ukrposhta[payer]" id="input-payer" class="form-control">
										<option value="0"><?php echo $text_select; ?></option>
                					<?php foreach ($payer_types as $v) { ?>
                						<?php if (isset($ukrposhta['payer']) && $v['id'] == $ukrposhta['payer']) { ?>
                						<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
                						<?php } else { ?>
                						<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
               							<?php } ?>
                					<?php } ?>
              						</select>
              					</div>
          					</div>
          					<div class="form-group">
			                  	<label class="col-sm-2 control-label" for="input-payment_cod"><span data-toggle="tooltip" title="<?php echo $help_payment_cod; ?>"><?php echo $entry_payment_cod; ?></span></label>
			            		<div class="col-sm-10">
			            			<div class="well well-sm" style="height: 150px; overflow: auto;">
			            			<?php foreach ($payment_methods as $code => $title) { ?>
			            				<div class="checkbox">
			            					<label>
			            					<?php if (!empty($ukrposhta['payment_cod']) && is_array($ukrposhta['payment_cod']) && in_array($code, $ukrposhta['payment_cod'])) { ?>
			            						<input type="checkbox" name="ukrposhta[payment_cod][]" value="<?php echo $code; ?>" checked="checked" /> <?php echo $title; ?>
			            					<?php } else { ?>
			            						<input type="checkbox" name="ukrposhta[payment_cod][]" value="<?php echo $code; ?>" /> <?php echo $title; ?>
			            					<?php } ?>
			            					</label>
			            				</div>
			            			<?php } ?>
									<?php if (!empty($ukrposhta['payment_cod']) && is_array($ukrposhta['payment_cod'])) { ?>
										<?php foreach ($ukrposhta['payment_cod'] as $v) { ?>
										<?php if (is_array($v)) { ?>
										<div class="checkbox">
											<label>
												<?php if (in_array($v['code'], $ukrposhta['payment_cod'])) { ?>
												<input type="checkbox" name="ukrposhta[payment_cod][]" value="<?php echo $v['code']; ?>" checked="checked" /> <?php echo $v['name']; ?>
												<?php } else { ?>
												<input type="checkbox" name="ukrposhta[payment_cod][]" value="<?php echo $v['code']; ?>" /> <?php echo $v['name']; ?>
												<?php } ?>
												<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parents('div.checkbox').remove();"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
											</label>
											<input type="hidden" name="ukrposhta[payment_cod][<?php echo $v['code']; ?>][code]" value="<?php echo $v['code']; ?>" />
											<input type="hidden" name="ukrposhta[payment_cod][<?php echo $v['code']; ?>][name]" value="<?php echo $v['name']; ?>" />
										</div>
										<?php } ?>
										<?php } ?>
									<?php } ?>
										<br/>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="<?php echo $button_add; ?>" onclick="addCustomMethod('payment_cod');"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
			            			</div>
			            		</div>
			            	</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-backward_delivery_payer"><span data-toggle="tooltip" title="<?php echo $help_backward_delivery_payer; ?>"><?php echo $entry_backward_delivery_payer; ?></span></label>
								<div class="col-sm-10">
									<select name="ukrposhta[backward_delivery_payer]" id="input-backward_delivery_payer" class="form-control">
										<option value="0"><?php echo $text_select; ?></option>
										<?php foreach ($backward_delivery_payers as $v) { ?>
										<?php if ($v['id'] == $ukrposhta['backward_delivery_payer']) { ?>
										<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['description']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $v['id']; ?>"><?php echo $v['description']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-money_transfer_method"><span data-toggle="tooltip" title="<?php echo $help_money_transfer_method; ?>"><?php echo $entry_money_transfer_method; ?></span></label>
								<div class="col-sm-10">
									<select name="ukrposhta[money_transfer_method]" id="input-money_transfer_method" class="form-control">
										<option value="0"><?php echo $text_select; ?></option>
										<?php foreach ($money_transfer_methods as $k => $v) { ?>
										<?php if ($k == $ukrposhta['money_transfer_method']) { ?>
										<option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option>
										<?php } else { ?>
										<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
          				</div>
						<div class="tab-pane fade" id="tab-consignment_note">
							<legend><?php echo $text_consignment_note_creating; ?></legend>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sms_message-enabled"><span data-toggle="tooltip" title="<?php echo $help_sms_message; ?>"><?php echo $entry_sms_message; ?></span></label>
								<div class="col-sm-2">
									<div class="radio-switch">
										<?php if ($ukrposhta['sms_message']) { ?>
										<input type="radio" name="ukrposhta[sms_message]" value="0" id="input-sms_message-disabled">
										<label class="col-sm-4" for="input-sms_message-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[sms_message]" value="1" id="input-sms_message-enabled" checked>
										<label class="col-sm-4" for="input-sms_message-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[sms_message]" value="0" id="input-sms_message-disabled" checked>
										<label class="col-sm-4" for="input-sms_message-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[sms_message]" value="1" id="input-sms_message-enabled">
										<label class="col-sm-4" for="input-sms_message-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
							<legend><?php echo $text_consignment_note_list; ?></legend>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-consignment_displayed_information"><span data-toggle="tooltip" title="<?php echo $help_displayed_information; ?>"><?php echo $entry_displayed_information; ?></span></label>
								<div class="col-sm-10">
									<select name="ukrposhta[consignment_displayed_information][]" id="input-consignment_displayed_information" class="selectpicker form-control" data-icon-base="fa" data-tick-icon="fa-check" title="<?php echo $text_select; ?>" multiple>
										<?php foreach ($consignment_displayed_information as $k => $v) { ?>
											<?php if (isset($ukrposhta['consignment_displayed_information']) && in_array($k, $ukrposhta['consignment_displayed_information'])) { ?>
												<option value="<?php echo $k; ?>" selected><?php echo $v; ?></option>
											<?php } else { ?>
												<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<legend><?php echo $text_print_settings; ?></legend>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-print_type"><span data-toggle="tooltip" title="<?php echo $help_print_type; ?>"><?php echo $entry_print_type; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="ukrposhta[print_type]" id="input-print_type" class="form-control">
                                        <option value="0"><?php echo $text_select; ?></option>
                                        <?php foreach ($print_types as $k => $v) { ?>
                                        <?php if ($ukrposhta['print_type'] == $k) { ?>
                                        <option value="<?php echo $k; ?>" selected><?php echo $v; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-print_format"><span data-toggle="tooltip" title="<?php echo $help_print_format; ?>"><?php echo $entry_print_format; ?></span></label>
								<div class="col-sm-10">
									<select name="ukrposhta[print_format]" id="input-print_format" class="form-control">
										<option value="0"><?php echo $text_select; ?></option>
									<?php foreach ($print_formats as $k => $v) { ?>
										<?php if ($ukrposhta['print_format'] == $k) { ?>
										<option value="<?php echo $k; ?>" selected><?php echo $v; ?></option>
										<?php } else { ?>
										<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
										<?php } ?>
									<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-print_sender_name-enabled"><span data-toggle="tooltip" title="<?php echo $help_print_sender_name; ?>"><?php echo $entry_print_sender_name; ?></span></label>
								<div class="col-sm-2">
									<div class="radio-switch">
										<?php if ($ukrposhta['print_sender_name']) { ?>
										<input type="radio" name="ukrposhta[print_sender_name]" value="0" id="input-print_sender_name-disabled">
										<label class="col-sm-4" for="input-print_sender_name-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[print_sender_name]" value="1" id="input-print_sender_name-enabled" checked>
										<label class="col-sm-4" for="input-print_sender_name-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[print_sender_name]" value="0" id="input-print_sender_name-disabled" checked>
										<label class="col-sm-4" for="input-print_sender_name-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[print_sender_name]" value="1" id="input-print_sender_name-enabled">
										<label class="col-sm-4" for="input-print_sender_name-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-print_delivery_price-enabled"><span data-toggle="tooltip" title="<?php echo $help_print_delivery_price; ?>"><?php echo $entry_print_delivery_price; ?></span></label>
								<div class="col-sm-2">
									<div class="radio-switch">
										<?php if ($ukrposhta['print_delivery_price']) { ?>
										<input type="radio" name="ukrposhta[print_delivery_price]" value="0" id="input-print_delivery_price-disabled">
										<label class="col-sm-4" for="input-print_delivery_price-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[print_delivery_price]" value="1" id="input-print_delivery_price-enabled" checked>
										<label class="col-sm-4" for="input-print_delivery_price-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[print_delivery_price]" value="0" id="input-print_delivery_price-disabled" checked>
										<label class="col-sm-4" for="input-print_delivery_price-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[print_delivery_price]" value="1" id="input-print_delivery_price-enabled">
										<label class="col-sm-4" for="input-print_delivery_price-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-print_declared_price-enabled"><span data-toggle="tooltip" title="<?php echo $help_print_declared_price; ?>"><?php echo $entry_print_declared_price; ?></span></label>
                                <div class="col-sm-2">
                                    <div class="radio-switch">
                                        <?php if ($ukrposhta['print_declared_price']) { ?>
                                        <input type="radio" name="ukrposhta[print_declared_price]" value="0" id="input-print_declared_price-disabled">
                                        <label class="col-sm-4" for="input-print_declared_price-enabled"><?php echo $text_no; ?></label>
                                        <input type="radio" name="ukrposhta[print_declared_price]" value="1" id="input-print_declared_price-enabled" checked>
                                        <label class="col-sm-4" for="input-print_declared_price-disabled"><?php echo $text_yes; ?></label>
                                        <?php } else { ?>
                                        <input type="radio" name="ukrposhta[print_declared_price]" value="0" id="input-print_declared_price-disabled" checked>
                                        <label class="col-sm-4" for="input-print_declared_price-enabled"><?php echo $text_no; ?></label>
                                        <input type="radio" name="ukrposhta[print_declared_price]" value="1" id="input-print_declared_price-enabled">
                                        <label class="col-sm-4" for="input-print_declared_price-disabled"><?php echo $text_yes; ?></label>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
							<legend><?php echo $text_integration_with_orders; ?></legend>
							<div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_help_integration_with_orders; ?></div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-compatible_shipping_method"><span data-toggle="tooltip" title="<?php echo $help_compatible_shipping_method; ?>"><?php echo $entry_compatible_shipping_method; ?></span></label>
								<div class="col-sm-10">
									<div class="well well-sm" style="height: 150px; overflow: auto;">
									<?php foreach ($shipping_methods as $k => $n) { ?>
										<div class="checkbox">
											<label>
												<?php if (isset($ukrposhta['compatible_shipping_method']) && is_array($ukrposhta['compatible_shipping_method']) && in_array($k, $ukrposhta['compatible_shipping_method'])) { ?>
												<input type="checkbox" name="ukrposhta[compatible_shipping_method][]" value="<?php echo $k; ?>" checked="checked" /> <?php echo $n; ?>
												<?php } else { ?>
												<input type="checkbox" name="ukrposhta[compatible_shipping_method][]" value="<?php echo $k; ?>" /> <?php echo $n; ?>
												<?php } ?>
											</label>
										</div>
									<?php } ?>
									<?php if (!empty($ukrposhta['compatible_shipping_method']) && is_array($ukrposhta['compatible_shipping_method'])) { ?>
										<?php foreach ($ukrposhta['compatible_shipping_method'] as $v) { ?>
										<?php if (is_array($v)) { ?>
										<div class="checkbox">
											<label>
												<?php if (in_array($v['code'], $ukrposhta['compatible_shipping_method'])) { ?>
												<input type="checkbox" name="ukrposhta[compatible_shipping_method][]" value="<?php echo $v['code']; ?>" checked="checked" /> <?php echo $v['name']; ?>
												<?php } else { ?>
												<input type="checkbox" name="ukrposhta[compatible_shipping_method][]" value="<?php echo $v['code']; ?>" /> <?php echo $v['name']; ?>
												<?php } ?>
												<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parents('div.checkbox').remove();"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
											</label>
											<input type="hidden" name="ukrposhta[compatible_shipping_method][<?php echo $v['code']; ?>][code]" value="<?php echo $v['code']; ?>" />
											<input type="hidden" name="ukrposhta[compatible_shipping_method][<?php echo $v['code']; ?>][name]" value="<?php echo $v['name']; ?>" />
										</div>
										<?php } ?>
										<?php } ?>
									<?php } ?>
										<br/>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="<?php echo $button_add; ?>" onclick="addCustomMethod('compatible_shipping_method');"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-consignment_create-enabled"><span data-toggle="tooltip" title="<?php echo $help_consignment_create; ?>"><?php echo $entry_consignment_create; ?></span></label>
								<div class="col-sm-1">
									<div class="radio-switch">
										<?php if (empty($ukrposhta['consignment_create'])) { ?>
										<input type="radio" name="ukrposhta[consignment_create]" value="0" id="input-consignment_create-disabled" checked>
										<label class="col-sm-4" for="input-consignment_create-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_create]" value="1" id="input-consignment_create-enabled">
										<label class="col-sm-4" for="input-consignment_create-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[consignment_create]" value="0" id="input-consignment_create-disabled">
										<label class="col-sm-4" for="input-consignment_create-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_create]" value="1" id="input-consignment_create-enabled" checked>
										<label class="col-sm-4" for="input-consignment_create-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
								<label class="col-sm-1 control-label" for="input-consignment_create_text"><?php echo $entry_menu_text; ?></label>
								<div class="col-sm-8">
									<ul class="nav nav-tabs" role="tablist">
										<?php foreach ($languages as $language) { ?>
										<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#consignment_create_text_<?php echo $language['language_id']; ?>" aria-controls="consignment_create_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<?php foreach ($languages as $language) { ?>
										<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="consignment_create_text_<?php echo $language['language_id']; ?>">
											<input type="text" name="ukrposhta[consignment_create_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['consignment_create_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_menu_text; ?>" class="form-control" />
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-consignment_edit-enabled"><span data-toggle="tooltip" title="<?php echo $help_consignment_edit; ?>"><?php echo $entry_consignment_edit; ?></span></label>
								<div class="col-sm-1">
									<div class="radio-switch">
										<?php if (empty($ukrposhta['consignment_edit'])) { ?>
										<input type="radio" name="ukrposhta[consignment_edit]" value="0" id="input-consignment_edit-disabled" checked>
										<label class="col-sm-4" for="input-consignment_edit-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_edit]" value="1" id="input-consignment_edit-enabled">
										<label class="col-sm-4" for="input-consignment_edit-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[consignment_edit]" value="0" id="input-consignment_edit-disabled">
										<label class="col-sm-4" for="input-consignment_edit-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_edit]" value="1" id="input-consignment_edit-enabled" checked>
										<label class="col-sm-4" for="input-consignment_edit-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
								<label class="col-sm-1 control-label" for="input-consignment_edit_text"><?php echo $entry_menu_text; ?></label>
								<div class="col-sm-8">
									<ul class="nav nav-tabs" role="tablist">
										<?php foreach ($languages as $language) { ?>
										<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#consignment_edit_text_<?php echo $language['language_id']; ?>" aria-controls="consignment_edit_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<?php foreach ($languages as $language) { ?>
										<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="consignment_edit_text_<?php echo $language['language_id']; ?>">
											<input type="text" name="ukrposhta[consignment_edit_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['consignment_edit_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_menu_text; ?>" class="form-control" />
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-consignment_delete-enabled"><span data-toggle="tooltip" title="<?php echo $help_consignment_delete; ?>"><?php echo $entry_consignment_delete; ?></span></label>
								<div class="col-sm-1">
									<div class="radio-switch">
										<?php if (empty($ukrposhta['consignment_delete'])) { ?>
										<input type="radio" name="ukrposhta[consignment_delete]" value="0" id="input-consignment_delete-disabled" checked>
										<label class="col-sm-4" for="input-consignment_delete-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_delete]" value="1" id="input-consignment_delete-enabled">
										<label class="col-sm-4" for="input-consignment_delete-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[consignment_delete]" value="0" id="input-consignment_delete-disabled">
										<label class="col-sm-4" for="input-consignment_delete-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_delete]" value="1" id="input-consignment_delete-enabled" checked>
										<label class="col-sm-4" for="input-consignment_delete-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
								<label class="col-sm-1 control-label" for="input-consignment_delete_text"><?php echo $entry_menu_text; ?></label>
								<div class="col-sm-8">
									<ul class="nav nav-tabs" role="tablist">
										<?php foreach ($languages as $language) { ?>
										<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#consignment_delete_text_<?php echo $language['language_id']; ?>" aria-controls="consignment_delete_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<?php foreach ($languages as $language) { ?>
										<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="consignment_delete_text_<?php echo $language['language_id']; ?>">
											<input type="text" name="ukrposhta[consignment_delete_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['consignment_delete_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_menu_text; ?>" class="form-control" />
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-consignment_assignment_to_order-enabled"><span data-toggle="tooltip" title="<?php echo $help_consignment_assignment_to_order; ?>"><?php echo $entry_consignment_assignment_to_order; ?></span></label>
								<div class="col-sm-1">
									<div class="radio-switch">
										<?php if (empty($ukrposhta['consignment_assignment_to_order'])) { ?>
										<input type="radio" name="ukrposhta[consignment_assignment_to_order]" value="0" id="input-consignment_assignment_to_order-disabled" checked>
										<label class="col-sm-4" for="input-consignment_assignment_to_order-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_assignment_to_order]" value="1" id="input-consignment_assignment_to_order-enabled">
										<label class="col-sm-4" for="input-consignment_assignment_to_order-disabled"><?php echo $text_yes; ?></label>
										<?php } else { ?>
										<input type="radio" name="ukrposhta[consignment_assignment_to_order]" value="0" id="input-consignment_assignment_to_order-disabled">
										<label class="col-sm-4" for="input-consignment_assignment_to_order-enabled"><?php echo $text_no; ?></label>
										<input type="radio" name="ukrposhta[consignment_assignment_to_order]" value="1" id="input-consignment_assignment_to_order-enabled" checked>
										<label class="col-sm-4" for="input-consignment_assignment_to_order-disabled"><?php echo $text_yes; ?></label>
										<?php } ?>
									</div>
								</div>
								<label class="col-sm-1 control-label" for="input-consignment_assignment_to_order_text"><?php echo $entry_menu_text; ?></label>
								<div class="col-sm-8">
									<ul class="nav nav-tabs" role="tablist">
										<?php foreach ($languages as $language) { ?>
										<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#consignment_assignment_to_order_text_<?php echo $language['language_id']; ?>" aria-controls="consignment_assignment_to_order_text_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<?php foreach ($languages as $language) { ?>
										<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="consignment_assignment_to_order_text_<?php echo $language['language_id']; ?>">
											<input type="text" name="ukrposhta[consignment_assignment_to_order_text][<?php echo $language['language_id']; ?>]" value="<?php echo $ukrposhta['consignment_assignment_to_order_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_menu_text; ?>" class="form-control" />
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
          				<div class="tab-pane fade" id="tab-cron">
          					<div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_help_cron; ?></div>
          					<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-key_cron"><span data-toggle="tooltip" title="<?php echo $help_key_cron; ?>"><?php echo $entry_key_cron; ?></span></label>
            					<div class="col-sm-10">
    								<div class="input-group">
    									<input type="text" name="ukrposhta[key_cron]" value="<?php echo $ukrposhta['key_cron']; ?>" placeholder="<?php echo $entry_key_cron; ?>" id="input-key_cron" class="form-control" />
    									<span class="input-group-btn">
    										<button id="button-generate-cron-key" onclick="generateKey();" type="button" class="btn btn-info" data-toggle="tooltip" title="<?php echo $button_generate; ?>"><i class="fa fa-cog"></i></button>
    									</span>
    								</div>	
    							</div>
              				</div>
          					<legend><?php echo $text_base_update; ?></legend>
              				<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-cron_update_references"><?php echo $entry_references; ?></label>
            					<div class="col-sm-10">
									<div class="input-group">
              							<input type="text" value="<?php echo $cron_update_references; ?>"  id="input-cron_update_references" class="form-control" readonly />
										<span class="input-group-btn">
											<button class="btn btn-default" type="button" data-toggle="tooltip" title="<?php echo $button_copy; ?>" onclick="copyToClipboard('input-cron_update_references');"><i class="fa fa-files-o" aria-hidden="true"></i></button>
										</span>
									</div>
              					</div>
              				</div>
              				<legend><?php echo $text_departures_tracking; ?></legend>
          					<div class="form-group">
            					<label class="col-sm-2 control-label" for="input-cron_departures_tracking"><?php echo $entry_departures_tracking; ?></label>
            					<div class="col-sm-10">
									<div class="input-group">
              							<input type="text" value="<?php echo $cron_departures_tracking; ?>"  id="input-cron_departures_tracking" class="form-control" readonly />
										<span class="input-group-btn">
											<button class="btn btn-default" type="button" data-toggle="tooltip" title="<?php echo $button_copy; ?>" onclick="copyToClipboard('input-cron_departures_tracking');"><i class="fa fa-files-o" aria-hidden="true"></i></button>
											<a href="<?php echo $cron_departures_tracking_href; ?>" class="btn btn-default" role="button" data-toggle="tooltip" title="<?php echo $button_run; ?>" target="_blank"><i class="fa fa-terminal" aria-hidden="true"></i></a>
										</span>
									</div>
              					</div>
              				</div>
              				<div class="form-group">
					        	<label class="col-sm-2 control-label" for="input-tracking_statuses"><span data-toggle="tooltip" title="<?php echo $help_tracking_statuses; ?>"><?php echo $entry_tracking_statuses; ?></span></label>
					        	<div class="col-sm-10">
								<?php if (is_array($order_statuses)) { ?>
									<select name="ukrposhta[tracking_statuses][]" id="input-tracking_statuses" class="selectpicker form-control" data-icon-base="fa" data-tick-icon="fa-check" title="<?php echo $text_select; ?>" multiple>
									<?php foreach ($order_statuses as $order_status) { ?>
										<?php if (isset($ukrposhta['tracking_statuses']) && is_array($ukrposhta['tracking_statuses']) && in_array($order_status['order_status_id'], $ukrposhta['tracking_statuses'])) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
										<?php } ?>
									<?php } ?>
									</select>
								<?php } ?>
					        	</div>
					        </div>
							<a class="btn btn-default pull-right" data-toggle="collapse" href="#message-macros-collapse" aria-expanded="false" aria-controls="message-macros-collapse" role="button"><?php echo $text_message_template_macros; ?> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
							<div class="clearfix"></div>
							<div id="message-macros-collapse" class="collapse">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="col-sm-4">
											<?php echo $text_cn_template_macros; ?>
										</div>
										<div class="col-sm-4">
											<?php echo $text_order_template_macros; ?>
										</div>
										<div class="col-sm-4">
											<?php echo $text_products_template_macros; ?>
										</div>
									</div>
								</div>
							</div>
					        <div class="panel panel-default">
							    <div class="panel-heading">
							    	<h3 class="panel-title"><?php echo $text_settings_departures_statuses; ?></h3>
								</div>
								<div class="table-responsive">
					            	<table class="table table-bordered table-hover" id="table-tracking_statuses">
					              		<thead>
					                		<tr>
					                  			<td class="text-center" width="15%"><?php echo $column_postal_company_status; ?></td>
					                  			<td class="text-center"><?php echo $column_store_status; ?></td>
												<td class="text-center"><?php echo $column_implementation_delay; ?></td>
					                  			<td class="text-center"><?php echo $column_notification; ?></td>
					                  			<td class="text-center" width="40%"><?php echo $column_message_template; ?></td>
					                  			<td class="text-center"><?php echo $column_action; ?></td>
					                		</tr>
					              		</thead>
										<tbody>
										<?php if (isset($ukrposhta['settings_tracking_statuses']) && is_array($ukrposhta['settings_tracking_statuses'])) { $c = 0; ?>
										<?php foreach ($ukrposhta['settings_tracking_statuses'] as $i => $settings) { ?>
										<tr>
											<td>
												<select name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][ukrposhta_status]" class="form-control">
													<?php foreach ($shipment_statuses as $shipment_status) { ?>
													<?php if ($shipment_status['event'] == $settings['ukrposhta_status']) { ?>
													<option value="<?php echo $shipment_status['event']; ?>" selected="selected"><?php echo $shipment_status['eventName']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $shipment_status['event']; ?>"><?php echo $shipment_status['eventName']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</td>
											<td>
												<select name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][store_status]" class="form-control">
													<?php foreach ($order_statuses as $order_status) { ?>
													<?php if ($order_status['order_status_id'] == $settings['store_status']) { ?>
													<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
											</td>
											<td>
												<div class="input-group">
														<span class="input-group-btn" style="width: 50%;">
															<select name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][implementation_delay][type]" class="form-control">
															<?php foreach ($time as $k => $v) { ?>
																<?php if ($k == $settings['implementation_delay']['type']) { ?>
																<option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option>
																<?php } else { ?>
																<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
																<?php } ?>
																<?php } ?>
															</select>
														</span><input type="text" name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][implementation_delay][value]" value="<?php echo $ukrposhta['settings_tracking_statuses'][$i]['implementation_delay']['value']; ?>" class="form-control" />
												</div>
											</td>
											<td>
												<div class="form-group">
													<label class="col-sm-10 control-label"><?php echo $entry_admin_notification; ?></label>
													<div class="col-sm-2">
														<input type="checkbox" name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][admin_notification]" <?php echo (isset($settings['admin_notification'])) ? 'checked' : '';?>>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-10 control-label"><?php echo $entry_customer_notification; ?></label>
													<div class="col-sm-2">
														<input type="checkbox" name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][customer_notification]" <?php echo (isset($settings['customer_notification'])) ? 'checked' : '';?>>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-10 control-label"><?php echo $entry_customer_notification_default; ?></label>
													<div class="col-sm-2">
														<input type="checkbox" name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][customer_notification_default]" <?php echo (isset($settings['customer_notification_default'])) ? 'checked' : '';?>>
													</div>
												</div>
											</td>
											<td>
												<div class="form-group">
													<label class="col-sm-2 control-label"><?php echo $entry_email; ?></label>
													<div class="col-sm-10">
														<ul class="nav nav-tabs" role="tablist">
															<?php foreach ($languages as $language) { ?>
															<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#tracking_statuses_email_<?php echo $c; ?>_<?php echo $language['language_id']; ?>" aria-controls="tracking_statuses_email_<?php echo $c; ?>_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
															<?php } ?>
														</ul>
														<div class="tab-content">
															<?php foreach ($languages as $language) { ?>
															<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="tracking_statuses_email_<?php echo $c; ?>_<?php echo $language['language_id']; ?>">
																<textarea name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][email][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_email; ?>"class="form-control summernote"><?php echo $ukrposhta['settings_tracking_statuses'][$i]['email'][$language['language_id']]; ?></textarea>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label"><?php echo $entry_sms; ?></label>
													<div class="col-sm-10">
														<ul class="nav nav-tabs" role="tablist">
															<?php foreach ($languages as $language) { ?>
															<li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#tracking_statuses_sms_<?php echo $c; ?>_<?php echo $language['language_id']; ?>" aria-controls="tracking_statuses_sms_<?php echo $c; ?>_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
															<?php } ?>
														</ul>
														<div class="tab-content"><?php foreach ($languages as $language) { ?>
															<div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="tracking_statuses_sms_<?php echo $c; ?>_<?php echo $language['language_id']; ?>">
																<textarea name="ukrposhta[settings_tracking_statuses][<?php echo $c; ?>][sms][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_sms; ?>"class="form-control"><?php echo $ukrposhta['settings_tracking_statuses'][$i]['sms'][$language['language_id']]; ?></textarea>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
											</td>
											<td class="text-center"><button type="button" onclick="$(this).parents('tr').remove()" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
										</tr>
										<?php $c++; } ?>
										<?php } ?>
										</tbody>
					              		<tfoot>
					              			<tr>
					              				<td colspan="5"></td>
					              				<td class="text-center"><button type="button" onclick="addTrackingStatus();" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
					              			</tr>
					              		</tfoot>
					            	</table>
					          	</div>
				          	</div>
          				</div>
          				<?php } ?>
          				<div class="tab-pane fade<?php if (!$license) { ?>in active<?php } ?>" id="tab-support">
          					<?php echo $support; ?>			
          				</div>
          			</div>
          			
          			<!-- START Modal of Verifying access to the API -->
					<div class="modal fade" id="modal-verifying_api_access" tabindex="-1" role="dialog" aria-labelledby="modal-verifying_api_access-label">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        	<h4 class="modal-title" id="modal-verifying_api_access-label"><?php echo $heading_verifying_api_access; ?></h4>
						      	</div>
							    <div class="modal-body">
				          			<div class="well" id="verifying_api_access-log"></div>
				          			<p class="text-center"><i class="fa fa-cog fa-spin fa-3x text-primary" id="verifying_api_access-icon"></i></p>
							    </div>
							    <div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i></button>
							    </div>
						    </div>
						</div>
					</div>         
				    <!-- END Modal of Verifying access to the API -->

					<!-- START Modal of custom total -->
					<div class="modal fade" id="modal-custom-method" tabindex="-1" role="dialog" aria-labelledby="modal-custom-method-label">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="modal-custom-method-label"><?php echo $heading_adding_custom_method; ?></h4>
								</div>
								<div class="modal-body">
									<input type="hidden" name="custom_method_type" value="" id="input-custom-method-type" />
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-custom-method-name"><?php echo $entry_name; ?></label>
										<div class="col-sm-10">
											<input type="text" name="custom_method_name" value="" placeholder="<?php echo $entry_name; ?>" id="input-custom-method-name" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-custom-method-code"><?php echo $entry_code; ?></label>
										<div class="col-sm-10">
											<input type="text" name="custom_method_code" value="" placeholder="<?php echo $entry_code; ?>" id="input-custom-method-code" class="form-control" />
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" onclick="addCustomMethod('save');"><i class="fa fa-check"></i></button>
									<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- END Modal of custom total -->
        		</form>
				<form action="<?php echo $action_settings; ?>&type=import" method="post" enctype="multipart/form-data" style="display: none;">
					<input type="file" name="import" accept="text/plain" id="input-import-settings" onchange="this.form.submit();">
				</form>
      		</div>
    	</div>
  	</div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script type="text/javascript"><!--
	function save(type) {
		var post_data = $('#form-ukrposhta').serialize() + '&store_id=' + $('#input-store_id').val();

		if (type === 'exit') {
			post_data += '&exit'
		}

		$.ajax( {
			url: 'index.php?route=extension/shipping/ukrposhta&token=<?php echo $token; ?>',
			type: 'POST',
			data: post_data,
			dataType: 'html',
			success: function (data, textStatus, jqXHR) {
				var $data = $(data);

				if ($data.find('div.alert-danger').length) {
					$('.container-fluid:eq(1)').prepend($data.find('div.alert-danger'));
				} else {
					if (type === 'exit') {
						location.href = 'index.php?route=extension/extension&token=<?php echo $token; ?>&type=shipping';
					}
				}

				if ($data.find('div.text-danger').length) {
					$data.find('div.text-danger').each(function(i, el) {
						var id = '#' + $(el).parents('div[class^="col-sm"]:first').find('input, select, textarea, radio').attr('id');

						$(id).parents('div[class^="col-sm"]:first').append(el);
						$(id).parents('div.form-group').addClass('has-error');
					} );
				}

				if ($data.find('div.alert-success').length) {
					$('.container-fluid:eq(1)').prepend($data.find('div.alert-success'));
				}
			}
		} );
	}

	function settings(type) {
		if (!confirm('<?php echo $text_confirm; ?>')) {
			return false;
		}

		if (type == 'basic') {
			$.ajax( {
				url: 'index.php?route=extension/shipping/ukrposhta/extensionSettings&token=<?php echo $token; ?>&type=' + type,
				type: 'GET',
				dataType: 'json',
				success: function (json) {
					if (json['success']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						setTimeout(function() { location.reload(); }, 2000);
					}

					if(json['error']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			} );
		} else if (type == 'export') {
			location.href = 'index.php?route=extension/shipping/ukrposhta/extensionSettings&token=<?php echo $token; ?>&type=' + type;
		} else if (type == 'import') {
			$('#input-import-settings').trigger('click');
		}
	}

	function formHandler(element) {
		switch (element.id) {
			case 'input-ecom_bearer':
            case 'input-tracking_bearer':
            case 'input-user_token':
				var
					ecom_bearer = $('#input-ecom_bearer').val(),
                    tracking_bearer = $('#input-tracking_bearer').val(),
                    user_token = $('#input-user_token').val();

				if (!ecom_bearer || !tracking_bearer || !user_token) {
				    break;
                }

				$('#modal-verifying_api_access').modal('show');

				$('#verifying_api_access-icon').addClass('fa-spin');
				$('#verifying_api_access-log').empty().append('<p><?php echo $text_verification_ecom_bearer; ?> <i class="fa fa-circle-o-notch fa-spin"></i></p>');

				function action(act) {
					$.ajax( {
						url: 'index.php?route=extension/shipping/ukrposhta/verifyingAPIaccess&token=<?php echo $token; ?>',
						type: 'POST',
						data: 'action=' + act + '&ecom_bearer=' + ecom_bearer + '&tracking_bearer=' + tracking_bearer + '&user_token=' + user_token,
						dataType: 'json',
						beforeSend: function () {
						},
						complete: function () {
						},
						success: function(json) {
							if (json['error']) {
								$('#verifying_api_access-log').find('i:last').replaceWith('<i class="fa fa-exclamation-circle text-danger"></i>');
								$('#verifying_api_access-icon').removeClass('fa-spin');

								for(var e in json['error']) {
									$('#verifying_api_access-log').append('<p class="text-danger">' + json['error'][e] + '</p>');
								}
							}

							if (json['next_action']) {
								$('#verifying_api_access-log').find('i').replaceWith('<i class="fa fa-check text-success" aria-hidden="true"></i>');
								$('#verifying_api_access-log').append('<p>' + json['next_action_text'] + ' <i class="fa fa-circle-o-notch fa-spin"></i></p>');

								if (json['next_action'] == 'saving') {
									$('#verifying_api_access-icon').removeClass('fa-spin');

									save();

									setTimeout(function() {
										$('#modal-verifying_api_access').modal('hide');
										location.reload();
									}, 2000);
								} else {
									action(json['next_action']);
								}
							}
						}
					} );
				}

				action('verification_ecom_bearer');

				break;

            case 'input-sender_type':
                if (element.value == 'COMPANY') {
                    $('#input-sender_tin').parents('div.form-group').fadeOut();
					$('#input-sender_edrpou, #input-sender_bank_code, #input-sender_bank_account').parents('div.form-group').fadeIn();
                } else if (element.value == 'PRIVATE_ENTREPRENEUR') {
            		$('#input-sender_edrpou').parents('div.form-group').fadeOut();
            		$('#input-sender_tin, #input-sender_bank_code, #input-sender_bank_account').parents('div.form-group').fadeIn();
                } else {
					$('#input-sender_edrpou, #input-sender_bank_code, #input-sender_bank_account').parents('div.form-group').fadeOut();
					$('#input-sender_tin').parents('div.form-group').fadeIn();
				}

                break;

            case 'input-sender_name':
                if (!$('#input-sender_name').val()) {
                    $('#input-sender').val('');
                }

                break;

            case 'input-sender_region':
            case 'input-sender_city':
            case 'input-sender_street':
            case 'input-sender_house':
            case 'input-sender_flat':
			case 'input-sender_postcode':
				$('#input-sender_address').val('');

                break;

			case 'input-standard_w_cost-enabled':
			case 'input-standard_w_cost-disabled':
			case 'input-standard_d_cost-enabled':
			case 'input-standard_d_cost-disabled':
			case 'input-express_w_cost-enabled':
			case 'input-express_w_cost-disabled':
			case 'input-express_d_cost-enabled':
			case 'input-express_d_cost-disabled':
			case 'input-calculate_volume-enabled':
			case 'input-calculate_volume-disabled':
				if (+element.value) {
					$(element).parent().parent().nextAll().fadeIn();
				} else {
					$(element).parent().parent().nextAll().fadeOut();
				}

				break;
		}
	}

	function update(type) {
		$.ajax( {
			url: 'index.php?route=extension/shipping/ukrposhta/update&type=' + type + '&token=<?php echo $token; ?>',
			dataType: 'json',
			beforeSend: function () {
				$('#button-update_' + type + ' > i').addClass('fa-spin');
			},
			complete: function () {
				var $alerts = $('.alert-danger, .alert-success');

				setTimeout(function() { $alerts.fadeOut(); }, 5000);

				$('#button-update_' + type + ' > i').removeClass('fa-spin');
			},
			success: function (json) {
				if(json['success']) {
					var diff = json['amount'] - $('#td-' + type + '_amount').text();

					$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					if (diff > 0) {
						$('#td-' + type + '_amount').append(' <strong><font color="green">+' + diff + '</font></strong>');
					} else if (diff < 0) {
						$('#td-' + type + '_amount').append(' <strong><font color="red">' + diff + '</font></strong>');
					}
				}

				if(json['error']) {
					$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		} );
	}

	function addCustomMethod(type) {
		if (type != 'save') {
			$('#input-custom-method-type').val(type);
			$('#modal-custom-method').modal('show');
		} else {
			var
				method_type = $('#input-custom-method-type').val(),
				method_name = $('#input-custom-method-name').val(),
				method_code = $('#input-custom-method-code').val();

			$('label[for=input-' + method_type + '] + div').find('br').before('<div class="checkbox"><label><input type="hidden" name="ukrposhta[' + method_type + '][' + method_code + '][code]" value="' + method_code + '" /><input type="hidden" name="ukrposhta[' + method_type + '][' + method_code + '][name]" value="' + method_name + '" /><input type="checkbox" name="ukrposhta[' + method_type + '][]" value="' + method_code + '" /> ' + method_name + ' <button type="button" class="btn btn-danger btn-xs" onclick="$(this).parents(\'div.checkbox\').remove();"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></label></div>');
		}
	}

	function addTariff(tariff_name) {
		var
			count = $('#table-tariffs-' + tariff_name + ' tbody tr').length + 1,
			row = '<tr>';

		row += '<td><input type="text" name="ukrposhta[tariffs][' + tariff_name + '][' + count + '][weight]" value="" class="form-control" /></td>';
		row += '<td><input type="text" name="ukrposhta[tariffs][' + tariff_name + '][' + count + '][longest_side]" value="" class="form-control" /></td>';
		row += '<td><input type="text" name="ukrposhta[tariffs][' + tariff_name + '][' + count + '][region]" value="" class="form-control" /></td>';
		row += '<td><input type="text" name="ukrposhta[tariffs][' + tariff_name + '][' + count + '][Ukraine]" value="" class="form-control" /></td>';
		row += '<td><input type="text" name="ukrposhta[tariffs][' + tariff_name + '][' + count + '][overpay_doors_pickup]" value="" class="form-control" /></td>';
		row += '<td><input type="text" name="ukrposhta[tariffs][' + tariff_name + '][' + count + '][overpay_doors_delivery]" value="" class="form-control" /></td>';
		row += '<td class="text-center"><button type="button" onclick="$(this).parents(\'tr\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		row += '</tr>';

		$('#table-tariffs-' + tariff_name + ' tbody').append(row);
	}

	function addTrackingStatus() {
		var
			count = $('#table-tracking_statuses tbody tr').length,
			row = '<tr>';

		row += '<td><select name="ukrposhta[settings_tracking_statuses][' + count + '][ukrposhta_status]" class="form-control"><?php foreach ($shipment_statuses as $shipment_status) { ?><option value="<?php echo $shipment_status['event']; ?>"><?php echo $shipment_status['eventName']; ?></option><?php } ?></select></td>';
		row += '<td><select name="ukrposhta[settings_tracking_statuses][' + count + '][store_status]" class="form-control"><?php foreach ($order_statuses as $order_status) { ?><option value="<?php echo $order_status["order_status_id"]; ?>"><?php echo $order_status["name"]; ?></option><?php } ?></select></td>';
		row += '<td><div class="input-group"><span class="input-group-btn" style="width: 50%;"><select name="ukrposhta[settings_tracking_statuses][' + count + '][implementation_delay][type]" class="form-control"><?php foreach ($time as $k => $v) { ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php } ?></select></span><input type="text" name="ukrposhta[settings_tracking_statuses][' + count + '][implementation_delay][value]" value="" class="form-control" /></div></td>';
		row += '<td><div class="form-group"><label class="col-sm-10 control-label"><?php echo $entry_admin_notification; ?></label><div class="col-sm-2"><input type="checkbox" name="ukrposhta[settings_tracking_statuses][' + count + '][admin_notification]"></div></div><div class="form-group"><label class="col-sm-10 control-label"><?php echo $entry_customer_notification; ?></label><div class="col-sm-2"><input type="checkbox" name="ukrposhta[settings_tracking_statuses][' + count + '][customer_notification]"></div></div><div class="form-group"><label class="col-sm-10 control-label"><?php echo $entry_customer_notification_default; ?></label> <div class="col-sm-2"><input type="checkbox" name="ukrposhta[settings_tracking_statuses][' + count + '][customer_notification_default]"></div></div></td>';
		row += '<td><div class="form-group"><label class="col-sm-2 control-label"><?php echo $entry_email; ?></label><div class="col-sm-10"><ul class="nav nav-tabs" role="tablist"><?php foreach ($languages as $language) { ?><li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#tracking_statuses_email_' + count + '_<?php echo $language['language_id']; ?>" aria-controls="tracking_statuses_email_' + count + '_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li><?php } ?> </ul><div class="tab-content"><?php foreach ($languages as $language) { ?><div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="tracking_statuses_email_' + count + '_<?php echo $language['language_id']; ?>"><textarea name="ukrposhta[settings_tracking_statuses][' + count + '][email][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_email; ?>" class="form-control summernote"></textarea></div><?php } ?></div></div></div><div class="form-group"><label class="col-sm-2 control-label"><?php echo $entry_sms; ?></label><div class="col-sm-10"><ul class="nav nav-tabs" role="tablist"><?php foreach ($languages as $language) { ?><li<?php echo ($language_id == $language['language_id']) ? ' class="active"' : '' ?>><a href="#tracking_statuses_sms_' + count + '_<?php echo $language['language_id']; ?>" aria-controls="tracking_statuses_sms_' + count + '_<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="<?php echo $language_flag[$language['language_id']] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li><?php } ?> </ul><div class="tab-content"><?php foreach ($languages as $language) { ?><div role="tabpanel" class="tab-pane<?php echo ($language_id == $language['language_id']) ? ' active' : '' ?>" id="tracking_statuses_sms_' + count + '_<?php echo $language['language_id']; ?>"><textarea name="ukrposhta[settings_tracking_statuses][' + count + '][sms][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_sms; ?>"class="form-control"></textarea></div><?php } ?></div></div></div></td>';
		row += '<td class="text-center"><button type="button" onclick="$(this).parents(\'tr\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		row += '</tr>';

		$('#table-tracking_statuses tbody').append(row);

		$('#table-tracking_statuses tbody tr:last textarea.summernote').summernote();

	}

	function generateKey() {
		$.ajax( {
			url: 'index.php?route=extension/shipping/ukrposhta/generateKey&token=<?php echo $token; ?>',
			dataType: 'json',
			beforeSend: function () {
				$('#button-generate-cron-key > i').addClass('fa-spin');
			},
			complete: function () {
				$('#button-generate-cron-key > i').removeClass('fa-spin');
			},
			success: function (json) {
				if (json['code']) {
					$('#input-key_cron').val(json['code'])
				}
			}
		} );
	}

	function copyToClipboard(container_id) {
		window.getSelection().removeAllRanges();

		if (document.selection) {
			var
				range = document.body.createTextRange(),
				el = document.getElementById(container_id);

			range.moveToElementText(el);
			range.select().createTextRange();
			document.execCommand('Copy');
		} else if (window.getSelection) {
			var
				range = document.createRange(),
				el = document.getElementById(container_id);

			range.selectNode(el);
			window.getSelection().addRange(range);
			document.execCommand('Copy');
		}
	}

	$(function() {
		$('.summernote').summernote();

		$.ajaxSetup( {
			beforeSend: function () {
				$('body').fadeTo('fast', 0.7).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
			},
			complete: function () {
				var $alerts = $('.alert-danger, .alert-success');

				setTimeout(function() { $alerts.fadeOut(); }, 5000);

				$('body').fadeTo('fast', 1);
				$('#ocmax-loader').remove();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(textStatus);
			}
		} );


		$('input[id^="input-standard_w_cost"]:checked, input[id^="input-standard_d_cost"]:checked, input[id^="input-express_w_cost"]:checked, input[id^="input-express_d_cost"]:checked, #input-sender_type, input[id^="input-calculate_volume"]:checked').each(function() {
			formHandler(this);
		} );

		$('input, select, textarea').on('change', function(e) {
			formHandler(e.currentTarget);
		} );

		$('#button-sender_save').on('click', function(e) {
			var $button = $(e.currentTarget),
				post_data = 'action=saveSender';

			post_data += '&sender='      + encodeURIComponent($('#input-sender').val());
			post_data += '&sender_name=' + encodeURIComponent($('#input-sender_name').val());
			post_data += '&sender_type=' + encodeURIComponent($('#input-sender_type').val());

			if ($('#input-sender_tin').is(':visible')) {
				post_data += '&sender_tin=' + encodeURIComponent($('#input-sender_tin').val());
			}

			if ($('#input-sender_edrpou').is(':visible')) {
				post_data += '&sender_edrpou=' + encodeURIComponent($('#input-sender_edrpou').val());
			}

			if ($('#input-sender_bank_code').is(':visible')) {
				post_data += '&sender_bank_code=' + encodeURIComponent($('#input-sender_bank_code').val());
			}

			if ($('#input-sender_bank_account').is(':visible')) {
				post_data += '&sender_bank_account=' + encodeURIComponent($('#input-sender_bank_account').val());
			}

			post_data += '&sender_email='        + encodeURIComponent($('#input-sender_email').val());
			post_data += '&sender_phone='        + encodeURIComponent($('#input-sender_phone').val());
			post_data += '&sender_region='       + encodeURIComponent($('#input-sender_region').val());
			post_data += '&sender_city='         + encodeURIComponent($('#input-sender_city').val());
			post_data += '&sender_street='       + encodeURIComponent($('#input-sender_street').val());
			post_data += '&sender_house='        + encodeURIComponent($('#input-sender_house').val());
			post_data += '&sender_flat='         + encodeURIComponent($('#input-sender_flat').val());
			post_data += '&sender_postcode='     + encodeURIComponent($('#input-sender_postcode').val());
			post_data += '&sender_address='      + encodeURIComponent($('#input-sender_address').val());

			$.ajax( {
				url: 'index.php?route=extension/shipping/ukrposhta/ukrposhtaData&token=<?php echo $token; ?>',
				type: 'POST',
				data:  post_data,
				dataType: 'json',
				beforeSend: function() {
					$button.find('i').removeClass().addClass('fa fa-circle-o-notch fa-spin');
				},
				complete: function() {
					var $alerts = $('.alert-danger, .alert-success'),
						$errors = $('.has-error'),
						$errors_text = $('.help-block');

					setTimeout(function() {
						$alerts.fadeOut();
						$errors.removeClass('has-error');
						$errors_text.remove();
					}, 5000);

					$button.find('i').removeClass().addClass('fa fa-floppy-o');
				},
				success: function (json) {
					if (json['success']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('#input-sender').val(json['sender']);
						$('#input-sender_address').val(json['sender_address']);

						setTimeout(function() { save(); }, 2000);
					} else {
						if (json['errors'] instanceof Array || json['errors'] instanceof Object) {
							for (var field in json['errors']) {
								$('div.form-group').has('label[for="input-' + field + '"]').removeClass('has-success').addClass('has-error');
								$('#span-' + field).remove('.help-block');
								$('div.form-group > div[class^="col-sm"]').has('#input-' + field).append('<span id="span-' + field + '" class="help-block">' + json['errors'][field] + '</span>');
							}
						}

						if (json['error'] instanceof Array || json['error'] instanceof Object) {
							for(var e in json['error']) {
								$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'][e] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							}
						} else if (json['error']) {
							$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
					}
				}
			} );
		} );

		$('#button-sender_search').on('click', function(e) {
			var $button = $(e.currentTarget);

			$.ajax( {
				url: 'index.php?route=extension/shipping/ukrposhta/ukrposhtaData&token=<?php echo $token; ?>',
				type: 'POST',
				data: 'action=getClientByPhone&filter=' + encodeURIComponent($('#input-sender_phone').val()),
				dataType: 'json',
				beforeSend: function() {
					$button.find('i').removeClass().addClass('fa fa-circle-o-notch fa-spin');
				},
				complete: function() {
					var $alerts = $('.alert-danger, .alert-success');

					setTimeout(function() { $alerts.fadeOut(); }, 5000);

					$button.find('i').removeClass().addClass('fa fa-search');
				},
				success: function (json) {
					if (json['success']) {
						$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('#input-sender_type').val(json['type']).trigger('change');
						$('#input-sender').val(json['uuid']);
						$('#input-sender_name').val(json['name']);
						$('#input-sender_tin').val(json['tin']);
						$('#input-sender_edrpou').val(json['edrpou']);
						$('#input-sender_bank_code').val(json['bankCode']);
						$('#input-sender_bank_account').val(json['bankAccount']);
						$('#input-sender_email').val(json['email']);
						$('#input-sender_address').val(json['addressId']);
						$('#input-sender_region').val(json['zone_id']);
						$('#input-sender_city').val(json['city']);
						$('#input-sender_street').val(json['street']);
						$('#input-sender_house').val(json['houseNumber']);
						$('#input-sender_flat').val(json['apartmentNumber']);
						$('#input-sender_postcode').val(json['postcode']);
					} else {
						if (json['error']) {
							$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						if (json['warning']) {
							$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
					}
				}
			} );
		} );
	} );
//--></script>     
<?php echo $footer; ?> 