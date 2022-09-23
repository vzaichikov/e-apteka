<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-buyoneclick" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1 style="display:block;font-size: 20px;"><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-buyoneclick" class="form-horizontal">
			<?php if ($error_warning) { ?>
				<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
					<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>
			<?php } ?>
			<ul class="nav nav-tabs" style="margin-bottom:0;">
				<li class="active"><a href="#settings_main" data-toggle="tab"><?php echo $settings_main; ?></a></li>
				<li><a href="#settings_sms" data-toggle="tab"><?php echo $settings_sms; ?></a></li>
				<li><a href="#settings_analytics" data-toggle="tab"><?php echo $settings_analytics; ?></a></li>
				<li><a href="#text_tab_help" data-toggle="tab"><?php echo $text_tab_help; ?></a></li>
			</ul>
			<div class="tab-content">
				<div id="settings_main" class="tab-pane fade in active">
					<div class="col-xs-12" style="border: 1px solid #ddd; border-top: none;">
						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
							<div class="col-sm-10">
								<?php foreach ($languages as $language) { ?>
									<?php $language_id = $language['language_id']; ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="buyoneclick[name][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_name; ?>" value="<?php echo isset($buyoneclick['name'][$language_id]) ? $buyoneclick['name'][$language_id] : ''; ?>" class="form-control" />
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-success_type"><?php echo $entry_success_type; ?></label>
							<div class="col-sm-10">
								<select name="buyoneclick[success_type]" id="input-success_type" class="form-control">
									<?php if (isset($buyoneclick['success_type']) && $buyoneclick['success_type'] != '1') { ?>
										<option value="0" selected="selected"><?php echo $success_type0; ?></option>
										<option value="1"><?php echo $success_type1; ?></option>
									<?php } else { ?>
										<option value="0"><?php echo $success_type0; ?></option>
										<option value="1" selected="selected"><?php echo $success_type1; ?></option>
									<?php } ?>
								</select>
								<p class="hidden"><?php echo $success_type_tooltip; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $entry_success_field; ?></label>
							<div class="col-sm-10">
								<?php foreach ($languages as $language) { ?>
									<?php $language_id = $language['language_id']; ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="buyoneclick[success_field][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_success_field; ?>" value="<?php echo isset($buyoneclick['success_field'][$language_id]) ? $buyoneclick['success_field'][$language_id] : ''; ?>" class="form-control" />
									</div>
								<?php } ?>
								<p><?php echo $success_field_tooltip; ?></p>
							</div>
						</div>
						<div class="form-group" style="border-top: 1px solid #ccc;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $field1_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[field1_status]" class="form-control">
											<?php if ($buyoneclick['field1_status'] == '1') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } elseif ($buyoneclick['field1_status'] == '2') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2" selected="selected"><?php echo $field_required; ?></option>
											<?php } else { ?>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $field2_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[field2_status]" class="form-control">
											<?php if ($buyoneclick['field2_status'] == '1') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } elseif ($buyoneclick['field2_status'] == '2') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2" selected="selected"><?php echo $field_required; ?></option>
											<?php } else { ?>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border: none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $field3_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[field3_status]" class="form-control">
											<?php if ($buyoneclick['field3_status'] == '1') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } elseif ($buyoneclick['field3_status'] == '2') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2" selected="selected"><?php echo $field_required; ?></option>
											<?php } else { ?>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $field4_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[field4_status]" class="form-control">
											<?php if ($buyoneclick['field4_status'] == '1') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } elseif ($buyoneclick['field4_status'] == '2') { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2" selected="selected"><?php echo $field_required; ?></option>
											<?php } else { ?>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="2"><?php echo $field_required; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border: none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $agree_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[agree_status]" class="form-control">
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php foreach ($informations as $information) { ?>
												<?php if ($information['information_id'] == $buyoneclick['agree_status']) { ?>
													<option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
												<?php } else { ?>
													<option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $entry_option_status; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[option_status]" class="form-control">
											<?php if ($buyoneclick['option_status']) { ?>
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
						</div>
						<div class="form-group" style="border: none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $entry_validation_type; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[validation_type]" class="form-control">
											<?php if ($buyoneclick['validation_type'] == $value_validation_type1) { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="<?php echo $value_validation_type1; ?>" selected="selected"><?php echo $text_validation_type1; ?></option>
												<option value="<?php echo $value_validation_type2; ?>"><?php echo $text_validation_type2; ?></option>
											<?php } elseif ($buyoneclick['validation_type'] == $value_validation_type2) { ?>
												<option value="0"><?php echo $text_disabled; ?></option>
												<option value="<?php echo $value_validation_type1; ?>"><?php echo $text_validation_type1; ?></option>
												<option value="<?php echo $value_validation_type2; ?>" selected="selected"><?php echo $text_validation_type2; ?></option>
											<?php } else { ?>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<option value="<?php echo $value_validation_type1; ?>"><?php echo $text_validation_type1; ?></option>
												<option value="<?php echo $value_validation_type2; ?>"><?php echo $text_validation_type2; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $entry_style_status; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[style_status]" class="form-control">
											<?php if ($buyoneclick['style_status']) { ?>
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
						</div>
						<div class="form-group" style="border: none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label"><?php echo $text_stock_warning; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[stock_status]" class="form-control">
											<?php if ($buyoneclick['stock_status']) { ?>
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
							<div class="col-sm-6 col-xs-12">
								<div class="row">
								</div>
							</div>
						</div>
						<div class="row" style="border-top: 1px solid #ddd;">
							<div class="col-sm-4 col-xs-12">
								<p class="text-center h4" for="input-status_product"><?php echo $entry_status_product; ?></p>
							</div>
							<div class="col-sm-4 col-xs-12">
								<p class="text-center h4" for="input-status_category" style="padding-top:0px;"><?php echo $entry_status_category; ?></p>
							</div>
							<div class="col-sm-4 col-xs-12">
								<p class="text-center h4" for="input-status_module" style="padding-top:0px;"><?php echo $entry_status_module; ?></p>
							</div>
						</div>
						<div class="form-group" style="border-top: none; padding-top: 5px;">
							<div class="col-sm-4 col-xs-12">
								<select name="buyoneclick[status_product]" id="input-status_product" class="form-control">
									<?php if ($buyoneclick['status_product']) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-4 col-xs-12">
								<select name="buyoneclick[status_category]" id="input-status_category" class="form-control">
									<?php if ($buyoneclick['status_category']) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-4 col-xs-12">
								<select name="buyoneclick[status_module]" id="input-status_module" class="form-control">
									<?php if ($buyoneclick['status_module']) { ?>
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
				</div>
				<div id="settings_sms" class="tab-pane fade">
					<!---------- SMS settings ------------>
					<div class="col-xs-12" style="border: 1px solid #ddd; border-top: none;">
						<!---------- SMS.ru ------------>
						<div class="col-sm-12 text-center h2"><?php echo $smsru_form_title; ?></div>
						<div class="col-sm-12 text-center h4" style="text-transform:uppercase; padding-bottom:1em;"><?php echo $smsru_form_subtitle; ?></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="smsru_api"><?php echo $smsru_api_title; ?></label>
							<div class="col-sm-10">
								<input type="text" name="buyoneclick[smsru_api]" value="<?php echo $buyoneclick['smsru_api']; ?>" placeholder="<?php echo $smsru_api_title; ?>" id="smsru_api" class="form-control" />
							</div>
							<div class="col-sm-offset-2 col-sm-10">
								<?php echo $smsru_api_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_login"><?php echo $smsru_login_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smsru_login]" value="<?php echo $buyoneclick['smsru_login']; ?>" placeholder="<?php echo $smsru_login_title; ?>" id="smsru_login" class="form-control" />
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_password"><?php echo $smsru_password_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smsru_password]" value="<?php echo $buyoneclick['smsru_password']; ?>" placeholder="<?php echo $smsru_password_title; ?>" id="smsru_password" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_number"><?php echo $smsru_number_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smsru_number]" value="<?php echo $buyoneclick['smsru_number']; ?>" placeholder="<?php echo $smsru_number_title; ?>" id="smsru_number" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smsru_number_tooltip; ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_name"><?php echo $smsru_name_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smsru_name]" value="<?php echo $buyoneclick['smsru_name']; ?>" placeholder="<?php echo $smsru_name_title; ?>" id="smsru_name" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smsru_name_tooltip; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_admin_sms"><?php echo $smsru_admin_sms_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smsru_admin_sms]" value="<?php echo $buyoneclick['smsru_admin_sms']; ?>" placeholder="<?php echo $smsru_admin_sms_title; ?>" id="smsru_admin_sms" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smsru_admin_sms_tooltip; ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_status"><?php echo $smsru_admin_status_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[smsru_admin_status]" id="smsru_admin_status" class="form-control">
											<?php if ($buyoneclick['smsru_admin_status']) { ?>
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
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_client_sms"><?php echo $smsru_client_sms_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smsru_client_sms]" value="<?php echo $buyoneclick['smsru_client_sms']; ?>" placeholder="<?php echo $smsru_client_sms_title; ?>" id="smsru_client_sms" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smsru_client_sms_tooltip; ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smsru_client_status"><?php echo $smsru_client_status_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[smsru_client_status]" id="smsru_client_status" class="form-control">
											<?php if ($buyoneclick['smsru_client_status']) { ?>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smsru_client_status_tooltip; ?>
									</div>
								</div>
							</div>
						</div>
					<hr style="border-color: #000;" />
						<!---------- SMSC.ua ------------>
						<div class="col-sm-12 text-center h2" style="margin-top:0;"><?php echo $smscua_form_title; ?></div>
						<div class="col-sm-12 text-center h4" style="text-transform:uppercase; padding-bottom:1em;"><?php echo $smscua_form_subtitle; ?></div>
						<div class="form-group">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_login"><?php echo $smscua_login_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smscua_login]" value="<?php echo $buyoneclick['smscua_login']; ?>" placeholder="<?php echo $smscua_login_title; ?>" id="smscua_login" class="form-control" />
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_password"><?php echo $smscua_password_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smscua_password]" value="<?php echo $buyoneclick['smscua_password']; ?>" placeholder="<?php echo $smscua_password_title; ?>" id="smscua_password" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_number"><?php echo $smscua_number_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smscua_number]" value="<?php echo $buyoneclick['smscua_number']; ?>" placeholder="<?php echo $smscua_number_title; ?>" id="smscua_number" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smscua_number_tooltip; ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_name"><?php echo $smscua_name_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smscua_name]" value="<?php echo $buyoneclick['smscua_name']; ?>" placeholder="<?php echo $smscua_name_title; ?>" id="smscua_name" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smscua_name_tooltip; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_admin_sms"><?php echo $smscua_admin_sms_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smscua_admin_sms]" value="<?php echo $buyoneclick['smscua_admin_sms']; ?>" placeholder="<?php echo $smscua_admin_sms_title; ?>" id="smscua_admin_sms" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smscua_admin_sms_tooltip; ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_admin_status"><?php echo $smscua_admin_status_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[smscua_admin_status]" id="smscua_admin_status" class="form-control">
											<?php if ($buyoneclick['smscua_admin_status']) { ?>
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
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_client_sms"><?php echo $smscua_client_sms_title; ?></label>
									<div class="col-sm-8">
										<input type="text" name="buyoneclick[smscua_client_sms]" value="<?php echo $buyoneclick['smscua_client_sms']; ?>" placeholder="<?php echo $smscua_client_sms_title; ?>" id="smscua_client_sms" class="form-control" />
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smscua_client_sms_tooltip; ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-sm-4 control-label" for="smscua_client_status"><?php echo $smscua_client_status_title; ?></label>
									<div class="col-sm-8">
										<select name="buyoneclick[smscua_client_status]" id="smscua_client_status" class="form-control">
												<?php if ($buyoneclick['smscua_client_status']) { ?>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-offset-4 col-sm-8">
										<?php echo $smscua_client_status_tooltip; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!---------- End SMS settings ------------>
				</div>
				<div id="settings_analytics" class="tab-pane fade">
					<!---------- Analytics settings ------------>
					<div class="col-xs-12" style="border: 1px solid #ddd; border-top: none;">
						<!---------- Yandex.ru ------------>
						<div class="col-sm-12 text-center h2" style="margin:1em auto"><?php echo $ya_form_title; ?></div>
						<div class="form-group">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="ya_counter"><?php echo $ya_counter_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[ya_counter]" value="<?php echo $buyoneclick['ya_counter']; ?>" placeholder="<?php echo $ya_counter_title; ?>" id="ya_counter" class="form-control" />
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="ya_identificator"><?php echo $ya_identificator_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[ya_identificator]" value="<?php echo $buyoneclick['ya_identificator']; ?>" placeholder="<?php echo $ya_identificator_title; ?>" id="ya_identificator" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="ya_identificator_send"><?php echo $ya_identificator_send_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[ya_identificator_send]" value="<?php echo $buyoneclick['ya_identificator_send']; ?>" placeholder="<?php echo $ya_identificator_send_title; ?>" id="ya_identificator_send" class="form-control" />
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="ya_identificator_success"><?php echo $ya_identificator_success_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[ya_identificator_success]" value="<?php echo $buyoneclick['ya_identificator_success']; ?>" placeholder="<?php echo $ya_identificator_success_title; ?>" id="ya_identificator_success" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-2 control-label" for="ya_target_status"><?php echo $ya_target_status_title; ?></label>
							<div class="col-sm-10">
								<select name="buyoneclick[ya_status]" id="ya_target_status" class="form-control">
									<?php if ($buyoneclick['ya_status']) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					<hr style="border-color: #000;" />
						<!---------- Google.com ------------>
						<div class="col-sm-12 text-center h2" style="margin:1em auto"><?php echo $google_form_title; ?></div>
						<div class="form-group">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="google_category_btn"><?php echo $google_category_btn_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[google_category_btn]" value="<?php echo $buyoneclick['google_category_btn']; ?>" placeholder="<?php echo $google_category_btn_title; ?>" id="google_category_btn" class="form-control" />
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="google_action_btn"><?php echo $google_action_btn_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[google_action_btn]" value="<?php echo $buyoneclick['google_action_btn']; ?>" placeholder="<?php echo $google_action_btn_title; ?>" id="google_action_btn" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="google_category_send"><?php echo $google_category_send_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[google_category_send]" value="<?php echo $buyoneclick['google_category_send']; ?>" placeholder="<?php echo $google_category_send_title; ?>" id="google_category_send" class="form-control" />
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="google_action_send"><?php echo $google_action_send_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[google_action_send]" value="<?php echo $buyoneclick['google_action_send']; ?>" placeholder="<?php echo $google_action_send_title; ?>" id="google_action_send" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="google_category_success"><?php echo $google_category_success_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[google_category_success]" value="<?php echo $buyoneclick['google_category_success']; ?>" placeholder="<?php echo $google_category_success_title; ?>" id="google_category_success" class="form-control" />
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-12 col-xs-12 text-right" for="google_action_success"><?php echo $google_action_success_title; ?></label>
									<div class="col-md-8 col-sm-12 col-xs-12">
										<input type="text" name="buyoneclick[google_action_success]" value="<?php echo $buyoneclick['google_action_success']; ?>" placeholder="<?php echo $google_action_success_title; ?>" id="google_action_success" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-2 control-label" for="google_target_status"><?php echo $google_target_status_title; ?></label>
							<div class="col-sm-10">
								<select name="buyoneclick[google_status]" id="google_target_status" class="form-control">
									<?php if ($buyoneclick['google_status']) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					<hr style="border-color: #000;" />
						<!---------- Extended analytics ------------>
						<div class="col-sm-12 text-center h2" style="margin:1em auto"><?php echo $exan_form_title; ?></div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-2 control-label" for="exan_status"><?php echo $exan_status_title; ?></label>
							<div class="col-sm-10">
								<select name="buyoneclick[exan_status]" id="exan_status" class="form-control">
									<?php if ($buyoneclick['exan_status']) { ?>
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
				</div>
				<div id="text_tab_help" class="tab-pane fade">
					<div class="col-xs-12" style="border: 1px solid #ddd; border-top: none;">
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_help_title; ?></strong>
						</div>
						<div class="text_help" style="margin-top:2em;"><?php echo $text_help; ?></div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript"><!--
		$('#language a:first').tab('show');
		$('#sms_settings a:first').tab('show');
		$('#analytics_settings a:first').tab('show');
		//-->
	</script>
</div>
<?php echo $footer; ?>