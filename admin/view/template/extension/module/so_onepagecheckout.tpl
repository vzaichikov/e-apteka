<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  	<div class="page-header">
    	<div class="container-fluid">
      		<div class="pull-right">
        		<button type="submit" form="form-so-onepagecheckout" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
        		<a class="btn btn-success1" onclick="$('#action').val('save_edit');$('#form-so-onepagecheckout').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_edit'); ?>" ><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('entry_button_save_and_edit')?></a>
				<a class="btn btn-info" onclick="$('#action').val('save_new');$('#form-so-onepagecheckout').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_new'); ?>" ><i class="fa fa-book"></i>  <?php echo $objlang->get('entry_button_save_and_new')?></a>
        		<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-danger"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
        	</div>
			<h1><?php echo $heading_title_so; ?></h1>
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
        		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      		</div>
      		<div class="panel-body">
	   			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-so-onepagecheckout" class="form-horizontal">
    				<input type="hidden" name="action" id="action" value=""/>        
					<ul class="nav nav-tabs" id="CheckoutTab">
						<li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-cog fa-fw"></i> <?php echo $tab_general; ?></a></li>
						<li class="dropdown">
							<a href="#" data-toggle="dropdown"><i class="fa fa-eye"></i> <?php echo $tab_layout_setting; ?><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#tab-layout" data-toggle="tab"><i class="fa fa-eye"></i> <?php echo $tab_account_setting; ?></a></li>
								<li><a href="#tab-shopping-cart-setting" data-toggle="tab"><i class="fa fa-shopping-cart"></i> <?php echo $tab_shipping_cart; ?></a></li>
								<li><a href="#tab-delivery_method-setting" data-toggle="tab"><i class="fa fa-truck" aria-hidden="true"></i> <?php echo $tab_delivery_methods; ?></a></li>
								<li><a href="#tab-payment_method-setting" data-toggle="tab"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo $tab_payment_methods; ?></a></li>
								<li><a href="#tab-confirm_order-setting" data-toggle="tab"><i class="fa fa-cart-plus" aria-hidden="true"></i> <?php echo $tab_confirm_order; ?></a></li>
							</ul>
						</li>
						<li class="">
							<a href="#tab-help" data-toggle="tab"><i class="fa fa-question-circle"></i> <?php echo $tab_help; ?></a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active in" id="tab-general">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_status_title?>"><?php echo $entry_status; ?></span></label>
								<div class="col-sm-3">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-success btn-sm  <?php echo $so_onepagecheckout_enabled == 1 ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_enabled]"  <?php echo $so_onepagecheckout_enabled == 1 ? 'checked="checked"' : ''?>  value="1" autocomplete="off"><?php echo $text_enabled?></label>
										<label class="btn btn-success btn-sm <?php echo $so_onepagecheckout_enabled == 0 ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_enabled]" <?php echo $so_onepagecheckout_enabled == 0 ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_disabled?></label>
									</div>
				  				</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-name"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_name_title?>"><?php echo $entry_name; ?></span></label>
								<div class="col-sm-3">
				  					<input type="text" name="so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_name]" value="<?php echo $so_onepagecheckout_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
				  					<?php if ($error_name) { ?>
				  						<div class="text-danger"><?php echo $error_name; ?></div>
				  					<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_layout_title?>"><?php echo $text_layout; ?></span></label>
								<div class="col-sm-3">
									<select name="so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_layout]" id="input-country" class="form-control">
			                			<option value="1" <?php echo $so_onepagecheckout_layout == 1 ? 'selected="selected"' : ''?>><?php echo $text_layout_one?></option>
			                			<option value="2" <?php echo $so_onepagecheckout_layout == 2 ? 'selected="selected"' : ''?>><?php echo $text_layout_two?></option>
			                		</select>
				  				</div>
							</div>
							<div class="form-group">
			                	<label class="col-sm-2 control-label" for="input-country"><span data-toggle="tooltip" title="" data-original-title="Set Default Country"><?php echo $text_default_country?></span></label>
			                	<div class="col-sm-3">
			                		<select name="so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_country_id]" id="input-country" class="form-control">
			                			<?php foreach ($countries as $country) {?>
			                				<option value="<?php echo $country['country_id']?>" <?php echo ($country['country_id'] == $so_onepagecheckout_country_id) ? 'selected="selected"' : ''?>><?php echo $country['name']?></option>
			                			<?php }?>
			                		</select>
			                	</div>
			                </div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-zone"><span data-toggle="tooltip" title="" data-original-title="Set Default zone"><?php echo $text_default_zone?></span></label>
								<div class="col-sm-3">
									<select name="so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_zone_id]" id="input-zone" class="form-control">
									</select>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-layout">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><span  data-toggle="tooltip" title="Disabled Register Checkout "><?php echo $text_register_account?></span></label>
								<div class="col-sm-10">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-success btn-sm button-account-type <?php echo ($so_onepagecheckout_register_checkout == 1) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_register_checkout]" <?php echo ($so_onepagecheckout_register_checkout == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
										<label class="btn btn-success btn-sm button-account-type <?php echo ($so_onepagecheckout_register_checkout == 0) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_register_checkout]" <?php echo ($so_onepagecheckout_register_checkout == 0) ? 'checked="checked"' : ''?>  value="0" autocomplete="off"><?php echo $text_no?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><span  data-toggle="tooltip" title="Disabled Guest Checkout "><?php echo $text_guest_checkout?></span></label>
								<div class="col-sm-10">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-success btn-sm <?php echo ($so_onepagecheckout_guest_checkout == 1) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_guest_checkout]" <?php echo ($so_onepagecheckout_guest_checkout == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
										<label class="btn btn-success btn-sm <?php echo ($so_onepagecheckout_guest_checkout == 0) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_guest_checkout]"  <?php echo ($so_onepagecheckout_guest_checkout == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><span  data-toggle="tooltip" title="Disabled Login "><?php echo $text_login_checkout?></span></label>
								<div class="col-sm-10">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-success btn-sm <?php echo ($so_onepagecheckout_enable_login == 1) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_enable_login]" <?php echo ($so_onepagecheckout_enable_login == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
										<label class="btn btn-success btn-sm <?php echo ($so_onepagecheckout_enable_login == 0) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_enable_login]"  <?php echo ($so_onepagecheckout_enable_login == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
									</div>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-2 control-label" for="input-account_open"><span data-toggle="tooltip" title="" data-original-title="Default select section"><?php echo $text_default_display?></span></label>
								<div class="col-sm-3">
									<div class="btn-group btn-group-justified" data-toggle="buttons">	
										<label class="btn btn-success btn-sm <?php echo ($so_onepagecheckout_account_open == 'register') ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_account_open]" <?php echo ($so_onepagecheckout_account_open == 'register') ? 'checked="checked"' : ''?> value="register" autocomplete="off" /><?php echo $text_register?></label>
										<label class="btn btn-success btn-sm <?php echo ($so_onepagecheckout_account_open == 'guest') ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_account_open]" <?php echo ($so_onepagecheckout_account_open == 'guest') ? 'checked="checked"' : ''?> value="guest" autocomplete="off" /><?php echo $text_guest?></label>
										<label class="btn btn-success btn-sm <?php echo ($so_onepagecheckout_account_open == 'login') ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_account_open]" <?php echo ($so_onepagecheckout_account_open == 'login') ? 'checked="checked"' : ''?> value="login" autocomplete="off" /><?php echo $text_login?></label>
									</div>	 
								</div>
							</div>
						</div>
						<div id="tab-shopping-cart-setting" class="tab-pane">
							<fieldset>
								<legend><?php echo $text_shopping_cart?></legend>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><span  data-toggle="tooltip" title="Shopping Cart Status" ><?php echo $text_shopping_cart_status?></span></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo ($shopping_cart_status == 1) ? 'active' : ''?> " ><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][shopping_cart_status]"  <?php echo ($shopping_cart_status == 1) ? 'checked="checked"' : ''?>  value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm <?php echo ($shopping_cart_status == 0) ? 'active' : ''?> "><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][shopping_cart_status]" <?php echo ($shopping_cart_status == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-weight"><span  data-toggle="tooltip" title="Show Weight" ><?php echo $text_show_weight?></span></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm  <?php echo ($show_product_weight == 1) ? 'active' : ''?> " ><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_weight]"  <?php echo ($show_product_weight == 1) ? 'checked="checked"' : ''?>  value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm  <?php echo ($show_product_weight == 0) ? 'active' : ''?> "><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_weight]" <?php echo ($show_product_weight == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-qnty_update"><span  data-toggle="tooltip" title="Show product Quantity update on cart"><?php echo $text_quantity_update_permission?></span></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm  <?php echo ($show_product_qnty_update == 1) ? 'active' : ''?> " ><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_qnty_update]"  <?php echo ($show_product_qnty_update == 1) ? 'checked="checked"' : ''?>  value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm  <?php echo ($show_product_qnty_update == 0) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_qnty_update]" <?php echo ($show_product_qnty_update == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-qnty_update"><span  data-toggle="tooltip" title="Show remove cart button"><?php echo $text_show_removecart?></span></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm  <?php echo ($show_product_removecart == 1) ? 'active' : ''?> " ><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_removecart]"  <?php echo ($show_product_removecart == 1) ? 'checked="checked"' : ''?>  value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm  <?php echo ($show_product_removecart == 0) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_removecart]" <?php echo ($show_product_removecart == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-image_width"><?php echo $text_product_image_size?></label>
									<div class="col-sm-3">
										<input type="text" value="<?php echo $show_product_image_width?>" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_image_width]" class="form-control" placeholder="Width"; >
										<?php if ($error_product_image_width) { ?>
					  						<div class="text-danger"><?php echo $error_product_image_width; ?></div>
					  					<?php } ?>
									</div>
									<div class="col-sm-3">
										<input type="text" value="<?php echo $show_product_image_height?>" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_product_image_height]" class="form-control" placeholder="Height"; >
										<?php if ($error_product_image_height) { ?>
					  						<div class="text-danger"><?php echo $error_product_image_height; ?></div>
					  					<?php } ?>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend><?php echo $text_coupon_voucher?></legend>
								<table class="table table-bordered">
									<thead>
										<tr>
											<td class="text-left"><?php echo $text_show_module_name?></td>
											<th class="text-center"><?php echo $text_login_account?></th>
											<th class="text-center"><?php echo $text_register_account?></th>
											<th class="text-right"><?php echo $text_guest_checkout?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left"><?php echo $text_coupon?></td>
											<td class="text-center">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $coupon_login_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][coupon_login_status]" <?php echo $coupon_login_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $coupon_login_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][coupon_login_status]" <?php echo $coupon_login_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>	
											<td class="text-center">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $coupon_register_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][coupon_register_status]" <?php echo $coupon_register_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $coupon_register_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][coupon_register_status]" <?php echo $coupon_register_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>
											<td class="text-right">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $coupon_guest_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][coupon_guest_status]" <?php echo $coupon_guest_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $coupon_guest_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][coupon_guest_status]" <?php echo $coupon_guest_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-left"><?php echo $text_reward?></td>
											<td class="text-center">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $reward_login_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][reward_login_status]" <?php echo $reward_login_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>														
														<label class="btn btn-success btn-sm  <?php echo $reward_login_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][reward_login_status]" <?php echo $reward_login_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>	
											<td class="text-center">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $reward_register_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][reward_register_status]" <?php echo $reward_register_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $reward_register_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][reward_register_status]" <?php echo $reward_register_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>
											<td class="text-right">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $reward_guest_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][reward_guest_status]" <?php echo $reward_guest_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $reward_guest_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][reward_guest_status]" <?php echo $reward_guest_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-left"><?php echo $text_voucher?></td>
											<td class="text-center">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $voucher_login_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][voucher_login_status]" <?php echo $voucher_login_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $voucher_login_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][voucher_login_status]" <?php echo $voucher_login_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>	
											<td class="text-center">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $voucher_register_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][voucher_register_status]" <?php echo $voucher_register_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $voucher_register_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][voucher_register_status]" <?php echo $voucher_register_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>
											<td class="text-right">
												<div class="col-sm-12">
													<div class="btn-group" data-toggle="buttons">
														<label class="btn btn-success btn-sm  <?php echo $voucher_guest_status == 1 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][voucher_guest_status]" <?php echo $voucher_guest_status == 1 ? 'checked="checked"': ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
														<label class="btn btn-success btn-sm  <?php echo $voucher_guest_status == 0 ? 'active': ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][voucher_guest_status]" <?php echo $voucher_guest_status == 0 ? 'checked="checked"': ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</fieldset>
						</div>
						<div id="tab-delivery_method-setting" class="tab-pane">
							<?php if (count($shipping_methods)) {?>
							<fieldset>
								<legend><?php echo $text_delivery_methods?></legend>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><span  data-toggle="tooltip" title="Status" ><?php echo $text_delivery_methods_status?></span></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo ($delivery_method_status == 1) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][delivery_method_status]" <?php echo ($delivery_method_status == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm <?php echo ($delivery_method_status == 0) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][delivery_method_status]" <?php echo ($delivery_method_status == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-customer-group"><span data-toggle="tooltip" title="" data-original-title="Default selected Shipping Method"><?php echo $text_shipping_methods?></span></label>
									<div class="col-md-5">
										<select class="form-control" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_default_shipping]">
											<?php foreach ($shipping_methods as $shipping_method) {?>
										  		<option value="<?php echo $shipping_method['code']?>" <?php echo ($shipping_method['code'] == $so_onepagecheckout_default_shipping) ? 'selected="selected"' : ''?>><?php echo $shipping_method['title']?></option>
										  	<?php }?>
										</select>
									</div>
								</div>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="text-left"><?php echo $text_shipping_methods?></th>
											<th class="text-center"><?php echo $text_status?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($shipping_methods as $shipping_method) {?>
										<?php $shipping_status = $shipping_method['code'].'_status';?>
										<tr>
											<td class="text-left"><?php echo $shipping_method['title']?></td>
											<td class="text-center">
												<div class="col-md-12">
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<label class="btn btn-success btn-sm  <?php echo (isset($setting_so_onepagecheckout_layout_setting["$shipping_status"]) && $setting_so_onepagecheckout_layout_setting["$shipping_status"] == 1) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][<?php echo $shipping_method['code']?>_status]" <?php echo (isset($setting_so_onepagecheckout_layout_setting["$shipping_status"]) && $setting_so_onepagecheckout_layout_setting["$shipping_status"] == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
															<label class="btn btn-success btn-sm  <?php echo (empty($setting_so_onepagecheckout_layout_setting["$shipping_status"]) || (isset($setting_so_onepagecheckout_layout_setting["$shipping_status"]) && $setting_so_onepagecheckout_layout_setting["$shipping_status"] == 0)) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][<?php echo $shipping_method['code']?>_status]" <?php echo (isset($setting_so_onepagecheckout_layout_setting["$shipping_status"]) && $setting_so_onepagecheckout_layout_setting["$shipping_status"] == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</fieldset>
							<?php }?>
						</div>
						<div id="tab-payment_method-setting" class="tab-pane">
							<?php if (count($payment_methods)) {?>
							<fieldset>
								<legend><?php echo $text_payment_methods?></legend>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><span  data-toggle="tooltip" title="Status" ><?php echo $text_payment_methods_status?></span></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo (@$payment_method_status == 1) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][payment_method_status]" <?php echo (@$payment_method_status == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm <?php echo (@$payment_method_status == 0) ? 'active' : ''?>"><input type="radio"  name="so_onepagecheckout[so_onepagecheckout_layout_setting][payment_method_status]" <?php echo (@$payment_method_status == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-customer-group"><span data-toggle="tooltip" title="" data-original-title="Default selected Payment Method"><?php echo $text_payment_methods?></span></label>
									<div class="col-md-5">
										<select class="form-control" name="so_onepagecheckout[so_onepagecheckout_layout_setting][so_onepagecheckout_default_payment]">
											<?php foreach ($payment_methods as $payment_method) {?>
										  		<option value="<?php echo $payment_method['code']?>" <?php echo ($payment_method['code'] == $so_onepagecheckout_default_payment) ? 'selected="selected"' : ''?>><?php echo $payment_method['title']?></option>
										  	<?php }?>
										</select>
									</div>
								</div>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="text-left"><?php echo $text_payment_methods?></th>
											<th class="text-center"><?php echo $text_status?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($payment_methods as $payment_method) {?>
										<?php $payment_status = $payment_method['code'].'_status';?>
										<tr>
											<td class="text-left"><?php echo $payment_method['title']?></td>
											<td class="text-center">
												<div class="col-md-12">
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<label class="btn btn-success btn-sm  <?php echo (isset($setting_so_onepagecheckout_layout_setting["$payment_status"]) && $setting_so_onepagecheckout_layout_setting["$payment_status"] == 1) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][<?php echo $payment_method['code']?>_status]" <?php echo (isset($setting_so_onepagecheckout_layout_setting["$payment_status"]) && $setting_so_onepagecheckout_layout_setting["$payment_status"] == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
															<label class="btn btn-success btn-sm  <?php echo (isset($setting_so_onepagecheckout_layout_setting["$payment_status"]) && $setting_so_onepagecheckout_layout_setting["$payment_status"] == 0) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][<?php echo $payment_method['code']?>_status]" <?php echo (isset($setting_so_onepagecheckout_layout_setting["$payment_status"]) && $setting_so_onepagecheckout_layout_setting["$payment_status"] == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</fieldset>
							<?php }?>
						</div>
						<div id="tab-confirm_order-setting" class="tab-pane">
							<fieldset>
								<legend><?php echo $text_confirm_order?></legend>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><?php echo $text_add_comments?></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo ($comment_status == 1) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][comment_status]" <?php echo ($comment_status == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm <?php echo ($comment_status == 0) ? 'active' : ''?> "><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][comment_status]" <?php echo ($comment_status == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><?php echo $text_require_comment?></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo ($require_comment_status == 1) ? 'active' : ''?> "><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][require_comment_status]" <?php echo ($require_comment_status == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>										
											<label class="btn btn-success btn-sm <?php echo ($require_comment_status == 0) ? 'active' : ''?> "><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][require_comment_status]" <?php echo ($require_comment_status == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><?php echo $text_show_newsletter?></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo ($show_newsletter == 1) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_newsletter]" <?php echo ($show_newsletter == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm <?php echo ($show_newsletter == 0) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_newsletter]" <?php echo ($show_newsletter == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><?php echo $text_show_privacy?></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo ($show_privacy == 1) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_privacy]" <?php echo ($show_privacy == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm <?php echo ($show_privacy == 0) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_privacy]" <?php echo ($show_privacy == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status"><?php echo $text_show_term?></label>
									<div class="col-sm-10">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-success btn-sm <?php echo ($show_term == 1) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_term]" <?php echo ($show_term == 1) ? 'checked="checked"' : ''?> value="1" autocomplete="off"><?php echo $text_yes?></label>
											<label class="btn btn-success btn-sm <?php echo ($show_term == 0) ? 'active' : ''?>"><input type="radio" name="so_onepagecheckout[so_onepagecheckout_layout_setting][show_term]" <?php echo ($show_term == 0) ? 'checked="checked"' : ''?> value="0" autocomplete="off"><?php echo $text_no?></label>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
						<div id="tab-help" class="tab-pane">
							<div class="tab-body">
								<ol>
									<li><b>Setting your FTP credentials</b></li>
									<p>In order to set your FTP credentials, navigate to System -> Settings -> Store Settings.</p>
									<p><img src="view/javascript/so_onepagecheckout/images/help/1.png" class="img-thumbnail img-responsive"></p>
									<p>Then, choose the FTP tab and fill in your FTP credentials. Make sure you check the Yes radio button for the Enable FTP field and click the blue Save button in the upper right corner of the page as shown:</p>
									<p><img src="view/javascript/so_onepagecheckout/images/help/2.png" class="img-thumbnail img-responsive"></p>
									<p>Now the Extension Installer will know how to access your FTP and you will be able to install extensions with ease.</p>
									<li><b>Installing an extension</b></li>
									<p>In order to upload an extension, navigate to Extensions -> Extension Installer. Then click the blue Upload button and provide the route to your extension' s"*.ocmod.zip" archive.</p>
									<p><img src="view/javascript/so_onepagecheckout/images/help/3.png" class="img-thumbnail img-responsive"></p>
									<li><b>Clear Modification</b></li>
									<p>In order to upload an extension, navigate to Extensions -> Modifications. Then click the blue Refresh button.</p>
									<p><img src="view/javascript/so_onepagecheckout/images/help/4.png" class="img-thumbnail img-responsive"></p>
								</ol>
							</div>
						</div>
					</div>
				</form>
			</div>
      	</div>
	</div>
</div>
<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	$('select[name=\'so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_country_id]\']').on('change', function() {
		$.ajax({
			url: 'index.php?route=localisation/country/country&token=<?php echo $token?>&country_id=' + this.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_country_id]\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
			},
			complete: function() {
				$('.fa-spin').remove();
			},
			success: function(json) {
				html = '<option value=""> --- Please Select --- </option>';

				if (json['zone'] && json['zone'] != '') {
					for (i = 0; i < json['zone'].length; i++) {
	          			html += '<option value="' + json['zone'][i]['zone_id'] + '"';

						if (json['zone'][i]['zone_id'] == '<?php echo $so_onepagecheckout_zone_id?>') {
	            			html += ' selected="selected"';
						}

						html += '>' + json['zone'][i]['name'] + '</option>';
					}
				} else {
					html += '<option value="0" selected="selected"> --- None --- </option>';
				}

				$('select[name=\'so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_zone_id]\']').html(html);
				
				$('#button-save').prop('disabled', false);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});

	$('select[name=\'so_onepagecheckout[so_onepagecheckout_general][so_onepagecheckout_country_id]\']').trigger('change');
	// for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    // go to the latest tab, if it exists:
    var lastTab = localStorage.getItem('lastTab');
    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }
    
	$('#CheckoutTab a').click(function(e) {
	  e.preventDefault();
	  $(this).tab('show');
	});

	// store the currently selected tab in the hash value
	$("ul.nav-tabs li a, ul.nav-tabs li ul li a").on("shown.bs.tab", function(e) {
	  var id = $(e.target).attr("href").substr(1);
	  window.location.hash = id;
	});

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	$('#CheckoutTab a[href="' + hash + '"]').tab('show');
});
//--></script>
<?php echo $footer; ?>