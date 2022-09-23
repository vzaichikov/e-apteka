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

	if (!function_exists('echoSelectControl'))
	{
		function echoSelectControl($module_labels, $label_name, 
							$name, $data, $curr_val, $append_class = '', 
							$is_multi = false, $val_name = 'id', $text_name = 'name')
		{
			return '<div class="form-group ">'
		        	. '<label class="col-sm-2 control-label" for="input-name1">'
		        		. label($module_labels, $label_name)
		        	. '</label>'
		        	. '<div class="col-sm-10">'
		        		. echoSelectHtml($name, $data, $curr_val, $append_class, 
		        			$is_multi, $val_name, $text_name)
					. '</div> '
		      	. '</div> '			
			;
		}
	}
?>


<div class="panel-body">
	<form class="form" 
		action="<?php echo $setModuleSettings; ?>" method="post" 
		enctype="multipart/form-data" 
		id="form_module_settings"
	>
		<?php
			echo echoSelectControl(
				$module_labels,
				'label_ms_main_panel_switch',
				'IMCallMeAskMe[IMCallMeAskMeData_main_panel]',
				array(
					array('id' => '0', 'name' => 'Отключено'),
					array('id' => '1', 'name' => 'Включено'),
				),
				label($curr_vals, 'IMCallMeAskMeData_main_panel')
			);
		?>
		
		<div class="form-group">
			<div class="buttons col-sm-12">
				<br/>
				<a class="button btn-im-module-settings-save btn btn-primary" style="color:white">
					<i class="fa fa-save"></i> &nbsp; 
					<?php echo label($module_labels, 'label_module_btn_save'); ?>
				</a>
				&nbsp;&nbsp;&nbsp;
				<span id="save_module_status"></span>
			</div>
		</div>

	</form>
</div>

<script type="text/javascript">
	function saveModuleSettings(form) {
		jQuery('#save_module_status').removeClass('fail').removeClass('success').html('Сохраняем...');

		// Сохраняем данные
		jQuery.ajax({
			type: 'POST',
			url: form.attr('action'),		
			data: form.serializeArray(),
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					jQuery('#save_module_status').removeClass('fail').addClass('success').html('Настройки cохранены!');
				} else {
					jQuery('#save_module_status').removeClass('success').addClass('fail').html('Настройки не cохранены!');
				}
			}
		});
	}				
				
</script>

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
	
	#save_module_status.success,
	#save_status.success,
	#save_status_get_stat.success,
	#save_status_table.success
	{
    	color: green;
	}

	#save_module_status.fail,
	#save_status.fail,
	#save_status_get_stat.fail,
	#save_status_table.fail
	{
    	color: red;
	}

</style>