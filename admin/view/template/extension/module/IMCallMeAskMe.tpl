<?php echo $header; ?><?php echo $column_left; ?>

<?php 
	if (!function_exists('echoText'))
	{
		function echoText($lang_settings, $lang_id, $name) {
			if (isset($lang_settings[$lang_id])) {
				echo $lang_settings[$lang_id][$name];
			}
			else {
				echo $lang_settings['default'][$name];
			}
		}
	}

	if (!function_exists('echoTextString'))
	{
		function echoTextString($lang_settings, $lang_id, $name) {
			if (isset($lang_settings[$lang_id])) {
				return $lang_settings[$lang_id][$name];
			}
			else {
				return $lang_settings['default'][$name];
			}
		}
	}

	if (!function_exists('label'))
	{
		function label($module_label, $name)
		{
			if (isset($module_label)){
			    if (is_array($module_label)) {
			        if (isset($module_label[$name]))
			            return $module_label[$name];
			    }
			}
		    return $name;
		}
	}

	if (!function_exists('echoTextArea'))
	{
		function echoTextArea($lang_settings, $lang_id, $name) {
			if (isset($lang_settings[$lang_id])) {
				echo $lang_settings[$lang_id][$name];
			}
			else {
				echo $lang_settings['default'][$name];
			}
		}
	}

	if (!function_exists('echoTextAreaString'))
	{
		function echoTextAreaString($lang_settings, $lang_id, $name) {
			if (isset($lang_settings[$lang_id])) {
				return $lang_settings[$lang_id][$name];
			}
			else {
				return $lang_settings['default'][$name];
			}
		}
	}
	
	if (!function_exists('echoSelect'))
	{
		function echoSelect($lang_settings, $lang_id, $name, $val) {
			$is_selected = false;
			if (isset($lang_settings[$lang_id])) {
				$is_selected = ('' . $lang_settings[$lang_id][$name] == '' . $val);
			}
			else {
				$is_selected = ('' . $lang_settings['default'][$name] == '' . $val);
			}
			
			echo $is_selected ? 'selected="selected"' : '';
		}
	}

	if (!function_exists('echoSelectHtml'))
	{
		function echoSelectHtml($name, $data, $curr_val, $append_class = '', 
							$is_multi = false, $val_name = 'id', $text_name = 'name')
		{
			$result = '<select name="' . $name . '" ' 
						. ' class="form-control ' . $append_class . '" '
						. ($is_multi ? ' multiple="multiple" ' : '') 
				. ' >';
			
			foreach($data as $key => $item)
			{
				$result .= '<option value="' . $item[$val_name] . '" '
							. (('' . $item[$val_name] == $curr_val )? ' selected="selected" ' : '')	. '>'
						. $item[$text_name]
					. '</option>';
			}
			
			return $result . '</select>';
		}
	}

	if (!function_exists('echoSelectString'))
	{
		function echoSelectString($lang_settings, $lang_id, $name, $val) {
			$is_selected = false;
			if (isset($lang_settings[$lang_id])) {
				$is_selected = ('' . $lang_settings[$lang_id][$name] == '' . $val);
			}
			else {
				$is_selected = ('' . $lang_settings['default'][$name] == '' . $val);
			}
			
			return $is_selected ? 'selected="selected"' : '';
		}
	}
	
	if (!function_exists('echoFieldControl'))
	{
		function echoFieldControl($lang_settings, $lang_id, $module_labels, $name) {
			$result =
				'<div class="tab-pane" id="fields_' . $lang_id . '_' . $name . '"> '
				//. '<div class="form-group ">'
		        	//. '<span class="col-sm-10 blue">'
		        		//. '<b>' . label($module_labels, 'label_field_' . $name . '_delimeter') . '</b>'
		        	//. '</span>'
		      	//. '</div>'
				. '<!-- ' . $name . ' And ' . $name . ' PlaceHolder-->'
				. '<div class="form-group ">'
		        	. '<label class="col-sm-2 control-label" for="input-name1">'
		        		. label($module_labels, 'label_field_' . $name)
		        	. '</label>'
		        	. '<div class="col-sm-4">'
		          		. '<input type="text" '
		          			. 'name="IMCallMeAskMe[set_langs][' . $lang_id . '][' . $name . ']" '
		          			. 'value="' . echoTextString($lang_settings, $lang_id, $name) . '" '
		          			. 'placeholder="' . label($module_labels, 'label_field_' . $name) .'" ' 
		          			. 'class="form-control"/>'
					. '</div>'
		        	. '<label class="col-sm-2 control-label" for="input-name1">'
		        		. label($module_labels, 'label_field_' . $name . '_placeholder')
		        	. '</label>'
		        	. '<div class="col-sm-4">'
		          		. '<input type="text" '
		          			. 'name="IMCallMeAskMe[set_langs][' . $lang_id . '][' . $name . '_ph]" '
		          			. 'value="' . echoTextString($lang_settings, $lang_id, $name . '_ph') . '" '
		          			. 'placeholder="' . label($module_labels, 'label_field_' . $name . '_placeholder') . '" '
		          			. 'class="form-control"/>'
					. '</div> '
		      	. '</div> '
				. '<!-- ' . $name . ' Req And Inc -->'
				. '<div class="form-group ">'
		        	. '<label class="col-sm-2 control-label" for="input-name1">'
		        		. label($module_labels, 'label_field_include')
		        	. '</label>'
		        	. '<div class="col-sm-4">'
			    		. '<select name="IMCallMeAskMe[set_langs][' . $lang_id . '][' . $name . '_inc]" '
			    			. 'class="form-control" '
			    		. '> '
		                    . '<option value="1" '
		                    	. echoSelectString($lang_settings, $lang_id, $name . '_inc', '1')
		                    . '>Да</option> '
							. '<option value="0" '
			                    . echoSelectString($lang_settings, $lang_id, $name . '_inc', '0')
			                    . '>Нет</option> '
						. '</select>'
					. '</div> '
		        	. '<label class="col-sm-2 control-label" for="input-name1"> '
		        		. label($module_labels, 'label_field_required')
		        	. '</label> '
		        	. '<div class="col-sm-4"> '
			    		. '<select name="IMCallMeAskMe[set_langs][' . $lang_id . '][' . $name . '_req]" '
			    			. 'class="form-control" '
			    		. '> '
		                    . '<option value="1" '
		                    	. echoSelectString($lang_settings, $lang_id, $name . '_req', '1')
		                    . '>Да</option> '
							. '<option value="0" '
			                    . echoSelectString($lang_settings, $lang_id, $name . '_req', '0')
			                    . '>Нет</option> '
							. '</select>'
						. '</select> '
					. '</div> '
		      	. '</div> '
				. '<!-- ' . $name . ' After --> '
				. '<div class="form-group ">'
		        	. '<label class="col-sm-2 control-label" for="input-name1">'
		        		. label($module_labels, 'label_field_after_include')
		        	. '</label>'
		        	. '<div class="col-sm-10">'
			    		. '<select name="IMCallMeAskMe[set_langs][' . $lang_id . '][' . $name . '_after_inc]" '
			    			. 'class="form-control" '
			    		. '> '
		                    . '<option value="1" '
		                    	. echoSelectString($lang_settings, $lang_id, $name . '_after_inc', '1')
		                    . '>Да</option> '
							. '<option value="0" '
			                    . echoSelectString($lang_settings, $lang_id, $name . '_after_inc', '0')
			                    . '>Нет</option> '
						. '</select>'
					. '</div> '
		      	. '</div> '			
		      	. '<div class="form-group "> '
		        	. '<label class="col-sm-2 control-label" for="input-name1"> '
		        		. label($module_labels, 'label_after_field_' . $name)
		        	. '</label> '
		        	. '<div class="col-sm-10"> '
		          		. '<textarea '
		          			. 'name="IMCallMeAskMe[set_langs][' . $lang_id . '][' . $name . '_after]" '
		          			. 'placeholder="' . label($module_labels, 'label_after_field_' . $name) . '" '
		          			. 'class="form-control"> '
		          				. echoTextAreaString($lang_settings, $lang_id, 
		          									$name . '_after')
		          			. '</textarea> '
					. '</div> '
		      	. '</div> '
		      	. '</div> '
			;
			
			return $result;
		}
	}
?>

<div id="content">
	<div class="container-fluid page-header">
		<div class="breadcrumb">
		  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		  		<?php echo $breadcrumb['separator']; ?>
		  			<a href="<?php echo $breadcrumb['href']; ?>">
		  		<?php echo $breadcrumb['text']; ?></a>
		  	<?php } ?>
		</div>
	</div>

	<?php if ($error_warning) { ?>
		<div class="warning">
			<?php echo $error_warning; ?>
		</div>
	<?php } ?>

	<div class="box">
		<div class="container-fluid">
		  	<div class="heading">
		    	<h1>
		    		<?php echo $h1_text; ?> - <small><?php echo $h2_text; ?></small>
		    	</h1>
				<br/>
		  	</div>
		</div>
	  	<div style="clear:both;"></div>
		<div class="content" >
			<!-- --------------------------------------------------- -->
			<!-- OpenCart Style Start -->
			<!-- --------------------------------------------------- -->
			<div class="container-fluid">
			<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-tabs" id="imcallmetabs">
					<li>
						<a href="#imcallmetabssettings" data-toggle="tab">
							<?php echo label($module_labels, 'label_settings'); ?>
						</a>
					</li>
					<li>
						<a href="#imcallmetabsstat" data-toggle="tab">
							<?php echo label($module_labels, 'label_stat'); ?>
						</a>
					</li>
					<li>
						<a href="#imcallmetabsmodulesettings" data-toggle="tab">
							<?php echo label($module_labels, 'label_module_settings'); ?>
						</a>
					</li>
				</ul>
				<div class="tab-content">
				<div class="tab-pane" id="imcallmetabssettings">
					<div class="panel-body">
						<div class="form-group">
							<div class="buttons">
								<a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-default">
									<i class="fa fa-reply"></i> &nbsp; 
									<?php echo label($module_labels, 'label_module_btn_cancel'); ?>
								</a>
								<a class="button btn-im-save btn btn-primary" style="color:white">
									<i class="fa fa-save"></i> &nbsp; 
									<?php echo label($module_labels, 'label_module_btn_save'); ?>
								</a>
								<span id="save_status"></span>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" 
							action="<?php echo $replace; ?>" method="post" 
							enctype="multipart/form-data" 
							id="form_call_ask"
						>
							<ul class="nav nav-tabs" id="language">
								<?php 
	           						foreach ($languages as $language) { 
			           			?>
			           			<li>
			           				<a href="#language<?php echo $language['language_id']; ?>" 
			           					data-toggle="tab"
			           				>
			           					<img src="<?php echo $language['imgsrc']; ?>" 
			           						title="<?php echo $language['name']; ?>" /> 
			           					<?php echo $language['name']; ?>
			           				</a>
			           			</li>
			         			<?php 
			         				} 
			         			?>
							</ul>
							
							<div class="tab-content">
								<?php 
	           						foreach ($languages as $language) { 
			           			?>
			           			<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
			           				<!-- Admin Email -->
			           				<div class="form-group required">
				                    	<label class="col-sm-2 control-label" for="input-name1">
				                    		<?php echo label($module_labels, 'label_admin_email'); ?>
				                    	</label>
				                    	<div class="col-sm-10">
				                      		<input type="text" 
				                      			name="IMCallMeAskMe[set_langs][<?php echo $language['language_id']; ?>][admin_email]" 
				                      			value="<?php echoText($lang_settings, $language['language_id'], 'admin_email'); ?>" 
				                      			placeholder="<?php echo label($module_labels, 'label_admin_email'); ?>" 
				                      			class="form-control"/>
										</div>
				                  	</div>
			           				<!-- Header -->
			           				<div class="form-group required">
				                    	<label class="col-sm-2 control-label" for="input-name1">
				                    		<?php echo label($module_labels, 'label_header_name'); ?>
				                    	</label>
				                    	<div class="col-sm-10">
				                      		<input type="text" 
				                      			name="IMCallMeAskMe[set_langs][<?php echo $language['language_id']; ?>][header]" 
				                      			value="<?php echoText($lang_settings, $language['language_id'], 'header'); ?>" 
				                      			placeholder="<?php echo label($module_labels, 'label_header_name'); ?>" 
				                      			class="form-control"/>
										</div>
				                  	</div>
			           				<!-- Header After -->
									<div class="form-group ">
							        	<label class="col-sm-2 control-label" for="input-name1">
							        		<?php echo label($module_labels, 'label_field_after_include');?>
							        	</label>
							        	<div class="col-sm-10">
								    		<select name="IMCallMeAskMe[set_langs][<?php echo $language['language_id']; ?>][header_after_inc]" 
								    			class="form-control" 
								    		> 
							                    <option value="1" 
							                    	<?php echoSelect($lang_settings, $language['language_id'], 'header_after_inc', '1'); ?>
							                    >Да</option> 
												<option value="0" 
								                    <?php echoSelect($lang_settings, $language['language_id'], 'header_after_inc', '0'); ?>
								                >Нет</option> 
											</select>
										</div> 
							      	</div> 			
			           				<div class="form-group ">
				                    	<label class="col-sm-2 control-label" for="input-name1">
				                    		<?php echo label($module_labels, 'label_after_header_text'); ?>
				                    	</label>
				                    	<div class="col-sm-10">
				                      		<textarea 
				                      			name="IMCallMeAskMe[set_langs][<?php echo $language['language_id']; ?>][header_after]" 
				                      			placeholder="<?php echo label($module_labels, 'label_after_header_text'); ?>" 
				                      			class="form-control">
				                      				<?php echoTextArea($lang_settings, $language['language_id'], 
				                      									'header_after'); ?>
				                      			</textarea>
										</div>
				                  	</div>

			           				<!-- Complete -->
			           				<div class="form-group required">
				                    	<label class="col-sm-2 control-label" for="input-name1">
				                    		<?php echo label($module_labels, 'label_field_complete'); ?>
				                    	</label>
				                    	<div class="col-sm-10">
				                      		<input type="text" 
				                      			name="IMCallMeAskMe[set_langs][<?php echo $language['language_id']; ?>][complete_send]" 
				                      			value="<?php echoText($lang_settings, $language['language_id'], 'complete_send'); ?>" 
				                      			placeholder="<?php echo label($module_labels, 'label_field_complete'); ?>" 
				                      			class="form-control"/>
										</div>
				                  	</div>

									<!-- -------------------------------- -->
									<!-- Buttons Start -->
									<!-- -------------------------------- -->
			           				<div class="form-group ">
				                    	<span class="col-sm-10 blue">
				                    		<b>
				                    			<?php echo label($module_labels, 'label_btn_delimeter'); ?>
				                    		</b>
				                    	</span>
				                  	</div>
			           				<!-- Name And Name PlaceHolder-->
			           				<div class="form-group ">
				                    	<label class="col-sm-2 control-label" for="input-name1">
				                    		<?php echo label($module_labels, 'label_btn_ok'); ?>
				                    	</label>
				                    	<div class="col-sm-4">
				                      		<input type="text" 
				                      			name="IMCallMeAskMe[set_langs][<?php echo $language['language_id']; ?>][btn_ok]" 
				                      			value="<?php echoText($lang_settings, $language['language_id'], 'btn_ok'); ?>" 
				                      			placeholder="<?php echo label($module_labels, 'label_field_name'); ?>" 
				                      			class="form-control"/>
										</div>
				                    	<label class="col-sm-2 control-label" for="input-name1">
				                    		<?php echo label($module_labels, 'label_btn_cancel'); ?>
				                    	</label>
				                    	<div class="col-sm-4">
				                      		<input type="text" 
				                      			name="IMCallMeAskMe[set_langs][<?php echo $language['language_id']; ?>][btn_cancel]" 
				                      			value="<?php echoText($lang_settings, $language['language_id'], 'btn_cancel'); ?>" 
				                      			placeholder="<?php echo label($module_labels, 'label_field_name_placeholder'); ?>" 
				                      			class="form-control"/>
										</div>
				                  	</div>		

									<!-- -------------------------------- -->
									<!-- Buttons End -->
									<!-- -------------------------------- -->

			           				<div class="form-group ">
				                    	<span class="col-sm-10 blue">
				                    		<b>
				                    			<?php echo label($module_labels, 'label_fields_delimeter'); ?>
				                    		</b>
				                    	</span>
				                  	</div>

									<ul class="nav nav-tabs imcallmesakme-fields" id="fields_<?php echo $language['language_id']; ?>">
					           			<li>
					           				<a href="#fields_<?php echo $language['language_id']; ?>_name" data-toggle="tab">
					           					<?php 
					           						echo label($module_labels, 'label_field_name_delimeter')
					           					?>
					           				</a>
					           			</li>
					           			<li>
					           				<a href="#fields_<?php echo $language['language_id']; ?>_email" data-toggle="tab">
					           					<?php 
					           						echo label($module_labels, 'label_field_email_delimeter')
					           					?>
					           				</a>
					           			</li>
					           			<li>
					           				<a href="#fields_<?php echo $language['language_id']; ?>_tel" data-toggle="tab">
					           					<?php 
					           						echo label($module_labels, 'label_field_tel_delimeter')
					           					?>
					           				</a>
					           			</li>
					           			<li>
					           				<a href="#fields_<?php echo $language['language_id']; ?>_text" data-toggle="tab">
					           					<?php 
					           						echo label($module_labels, 'label_field_text_delimeter')
					           					?>
					           				</a>
					           			</li>
									</ul>
									<div class="tab-content">
									<!-- -------------------------------- -->
									<!-- Field Name Start -->
									<!-- -------------------------------- -->
									<?php 
										echo 
										echoFieldControl(
											$lang_settings, 
											$language['language_id'],
											$module_labels,
											'name'
										);
									?>
									<!-- -------------------------------- -->
									<!-- Field Name End -->
									<!-- -------------------------------- -->
									
									<!-- -------------------------------- -->
									<!-- Field Email Start -->
									<!-- -------------------------------- -->
									<?php 
										echo 
										echoFieldControl(
											$lang_settings, 
											$language['language_id'],
											$module_labels,
											'email'
										);
									?>
									<!-- -------------------------------- -->
									<!-- Field Email End -->
									<!-- -------------------------------- -->

									<!-- -------------------------------- -->
									<!-- Field Tel Start -->
									<!-- -------------------------------- -->
									<?php 
										echo 
										echoFieldControl(
											$lang_settings, 
											$language['language_id'],
											$module_labels,
											'tel'
										);
									?>
									<!-- -------------------------------- -->
									<!-- Field Tel End -->
									<!-- -------------------------------- -->

									<!-- -------------------------------- -->
									<!-- Field Text Start -->
									<!-- -------------------------------- -->
									<?php 
										echo 
										echoFieldControl(
											$lang_settings, 
											$language['language_id'],
											$module_labels,
											'text'
										);
									?>
									<!-- -------------------------------- -->
									<!-- Field Text End -->
									<!-- -------------------------------- -->
									</div>
								</div>
			         			<?php 
			         				}
			         			?> 
							</div>
						</form>
					</div>
				</div>
				<div class="tab-pane" id="imcallmetabsstat">
					<?php echo $IMCallMeAskMe_statView; ?>
				</div>
				<div class="tab-pane" id="imcallmetabsmodulesettings">
					<?php echo $IMCallMeAskMe_settingsView; ?>
				</div>
				</div>
			</div>
			</div>
			</div>
			<script type="text/javascript">
				
				function saveSettings() {
					jQuery('#save_status').removeClass('fail').removeClass('success').html('Сохраняем...');

					// Костыль для саммер
					jQuery(".note-editable").each(function() {
				     	jQuery(this).closest('.note-editor').prev().val(jQuery(this).html());
				  	});
					// Сохраняем данные
					jQuery.ajax({
						type: 'POST',
						url: 'index.php?route=extension/module/IMCallMeAskMe/saveSettings&token=<?php echo $token; ?>',		
						data: jQuery('#form_call_ask input, #form_call_ask select, #form_call_ask textarea'),
						dataType: 'json',
						success: function(json) {
							if (json['success']) {
								jQuery('#save_status').removeClass('fail').addClass('success').html('Настройки cохранены!');
							} else {
								jQuery('#save_status').removeClass('success').addClass('fail').html('Настройки не cохранены!');
							}
						}
					});
				}				
				
				jQuery(function () {
					jQuery('#form_call_ask textarea').summernote({
						height: 100,
						callbacks: {
							onChange: function(contents, editable) {
								//console.log('onChange:', contents, editable);
								if ((editable||{}).context)
									jQuery(editable.context).val(contents);
							}
						},
						onChange: function(contents, editable) {
							//console.log('onChange:', contents, editable);
							if ((editable||{}).context)
								jQuery(editable.context).val(contents);
						}
					});

					// Костыль для саммер
					jQuery(".note-editable").keyup(function(event) {
				     	jQuery(this).closest('.note-editor').prev().val(jQuery(this).html());
				  	});
					
					jQuery('#language a:first').tab('show');
					jQuery('#imcallmetabs a:first').tab('show');
					jQuery('.imcallmesakme-fields').each(function () {
						jQuery(this).find('a:first').tab('show');
					});
					
					jQuery('.date').datetimepicker({
						pickTime: false
					});
					
					IMCA_loadGetStat(jQuery('#imcallmetabsstat form'));
					
					jQuery('#imcallmetabsstat .button-filter').click(function () {
						IMCA_loadGetStat(jQuery(this).closest('form'));
					});
					
					jQuery('.btn-im-save').click(function () {
						saveSettings();
					});

					jQuery('.btn-im-module-settings-save').click(function () {
						saveModuleSettings(jQuery(this).closest('form'));
					});
				});
			</script>
			<!-- --------------------------------------------------- -->
			<!-- OpenCart Style End -->
			<!-- --------------------------------------------------- -->
		</div>
		
  	</div>
</div>

<style type="text/css">
	.form-group span.blue
	{
		color: #000042;
    	font-size: 15px;
	}
	
	.green
	{
		background-color: rgb(143, 187, 108);
    	color: white;
	}
	
	table.table-results tbody td
	{
		vertical-align: top;
	}
	
	table.table-results tbody td.nowrap
	{
		white-space: nowrap;
	}
	
	#save_status.success,
	#save_status_get_stat.success,
	#save_status_table.success
	{
    	color: green;
	}

	#save_status.fail,
	#save_status_get_stat.fail,
	#save_status_table.fail
	{
    	color: red;
	}

</style>

<?php echo $footer; ?>