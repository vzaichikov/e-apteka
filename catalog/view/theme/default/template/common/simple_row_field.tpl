<div style="max-height: 500px; overflow-y:scroll;" class="form-group <?php if ($required) { ?>required<?php } ?> row-<?php echo $id ?>">

	<?php if ($id == 'shipping_location_id') { ?>
    	<span class='col-sm-1' for="<?php echo $id ?>"></span>
	<?php } else { ?>
		<label class="control-label <?php echo $page == 'checkout' ? 'col-sm-4' : 'col-sm-2' ?>" for="<?php echo $id ?>"><?php echo $label ?></label>
	<?php } ?>

	<?php if ($id == 'shipping_location_id') { ?>
		<div class="<?php echo $page == 'checkout' ? 'col-sm-11' : 'col-sm-10' ?>">
	<?php } else { ?>
		<div class="<?php echo $page == 'checkout' ? 'col-sm-8' : 'col-sm-10' ?>">
	<?php } ?>
    
		<?php if ($type == 'select' || $type == 'select2') { ?>
			<select class="form-control" name="<?php echo $name ?>" id="<?php echo $id ?>" <?php echo $bootstrap ? 'data-theme="bootstrap"' : '' ?> <?php echo $type == 'select2' ? 'data-type="select2"' : '' ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>>
				<?php foreach ($values as $info) { ?>
					<option value="<?php echo $info['id'] ?>" <?php echo $value == $info['id'] ? 'selected="selected"' : '' ?>><?php echo $info['text'] ?></option>
				<?php } ?>
			</select>
			<?php } elseif ($type == 'radio') { ?>
			<div>

			<?php if ($id == 'shipping_location_id') { ?>	
				<?php foreach ($values as $info_id => $info) { ?>
					<div class="radio el-radio">
						<input type="radio" name="<?php echo $name ?>" id="<?php echo $id ?>_<?php echo $info_id ?>" value="<?php echo $info['id'] ?>" <?php echo $value == $info['id'] ? 'checked="checked"' : '' ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>>

						<label class="el-radio-style" for="<?php echo $id ?>_<?php echo $info_id ?>">
							<span><?php echo $info['text'] ?></span>
						</label>
					</div>
				<?php } ?>
			<?php } else { ?>
				<?php foreach ($values as $info_id => $info) { ?>
					<div class="radio el-radio">
						<input type="radio" name="<?php echo $name ?>" id="<?php echo $id ?>_<?php echo $info_id ?>" value="<?php echo $info['id'] ?>" <?php echo $value == $info['id'] ? 'checked="checked"' : '' ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>>

						<label class="el-radio-style" for="<?php echo $id ?>_<?php echo $info_id ?>">
							<span><?php echo $info['text'] ?></span>
						</label>
					</div>
				<?php } ?>
			<?php } ?>
			</div>
			<?php } elseif ($type == 'checkbox') { ?>
			<div>
				<?php if ($name == 'customer[is_fourteen]' && count($values) == 1) { ?>					
					<?php foreach ($values as $info_id => $info) { ?>
						<div class="checkbox">
							<div class="el-checkbox">
								<input type="hidden" name="<?php echo $name ?>[<?php echo $info['id'] ?>]" value="0">
								<label class="el-checkbox-style">
								<input type="checkbox" name="<?php echo $name ?>[<?php echo $info['id'] ?>]" id="<?php echo $id ?>" value="1" <?php echo !empty($value[$info['id']]) ? 'checked="checked"' : '' ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>><?php echo $info['text'] ?></label>
							</div>
						</div>
					<?php } ?>					
					<?php } else { ?>										
					<?php foreach ($values as $info_id => $info) { ?>
						<div class="checkbox">
							<div class="el-checkbox">
								<input type="hidden" name="<?php echo $name ?>[<?php echo $info['id'] ?>]" value="0">
								<label class="el-checkbox-style"><input type="checkbox" name="<?php echo $name ?>[<?php echo $info['id'] ?>]" id="<?php echo $id ?>_<?php echo $info_id ?>" value="1" <?php echo !empty($value[$info['id']]) ? 'checked="checked"' : '' ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>><?php echo $info['text'] ?></label>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<?php } elseif ($type == 'switcher') { ?>
			<div>
				<div class="checkbox">
					<input type="hidden" name="<?php echo $name ?>" value="0">
					<label><input type="checkbox" name="<?php echo $name ?>" id="<?php echo $id ?>" value="1" <?php echo $value == '1' ? 'checked="checked"' : '' ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>><?php echo $placeholder ?></label>
				</div>
			</div>
			<?php } elseif ($type == 'textarea') { ?>
			<textarea class="form-control" name="<?php echo $name ?>" id="<?php echo $id ?>" placeholder="<?php echo $placeholder ?>" <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>><?php echo $value ?></textarea>
			<?php } elseif ($type == 'captcha') { ?>
			<?php if ($site_key) { ?>
				<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>&onload=recaptchaInit&render=explicit" type="text/javascript" async defer></script>
				<input type="hidden" name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $value ?>">
				<script type="text/javascript">
					function recaptchaCallback(value) {
						$('#<?php echo $id ?>').val(value).trigger('change');
					}
					function recaptchaInit(){
						grecaptcha.render('simple-recaptcha');
					}
				</script>
				<div id="simple-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-callback="recaptchaCallback"></div>
				<?php } else { ?>
				<input type="text" class="form-control " name="<?php echo $name ?>" id="<?php echo $id ?>" value="" placeholder="<?php echo $placeholder ?>" <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>>
				<div class="simple-captcha-container"><img src="index.php?<?php echo $additional_path ?>route=common/simple_connector/captcha&t=<?php echo $time ?>" alt="" id="captcha" /></div>
			<?php } ?>
			<?php } elseif ($type == 'file') { ?>
			<input type="button" value="<?php echo $button_upload; ?>" data-file="<?php echo $id ?>" class="button form-control">
			<div id="text_<?php echo $id ?>" style="margin-top:3px;max-width:200px;"><?php echo $filename ?></div>
			<input type="hidden" name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $value ?>">
			<?php } elseif ($type == 'date') { ?>
			<div class="input-group date">
				<input class="form-control" type="text" name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $value ?>" placeholder="<?php echo $placeholder ?>" <?php echo $attrs ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>>
				<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				</span>
			</div>
			<?php } elseif ($type == 'time') { ?>
			<div class="input-group time">
				<input class="form-control" type="text" name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $value ?>" placeholder="<?php echo $placeholder ?>" <?php echo $attrs ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>>
				<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-clock-o"></i></button>
				</span>
			</div>
			<?php } else { ?>
			<input  class="form-control" type="<?php echo $type ?>" <?php echo $type == 'password' ? 'data-validate-on="keyup"' : '' ?> name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $value ?>" placeholder="<?php echo $placeholder ?>" <?php echo $attrs ?> <?php echo $reload ? 'data-onchange="reloadAll"' : 'data-reload-payment-form="true"'?>>
		<?php } ?>
		<?php if (!empty($rules)) { ?>
			<div class="simplecheckout-rule-group" data-for="<?php echo $id ?>">
				<?php foreach ($rules as $rule) { ?>
					<div <?php echo $rule['display'] && !$rule['passed'] ? '' : 'style="display:none;"' ?> data-for="<?php echo $id ?>" data-rule="<?php echo $rule['id'] ?>" class="simplecheckout-error-text simplecheckout-rule" <?php echo $rule['attrs'] ?>><?php echo $rule['text'] ?></div>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if ($description) { ?>
			<div class="simplecheckout-tooltip" data-for="<?php echo $id ?>"><?php echo $description ?></div>
		<?php } ?>
	</div>
</div>	