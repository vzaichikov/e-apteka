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

?>


<div class="panel-body ">
	<form class="form" 
		action="<?php echo $getStat; ?>" method="post" 
		enctype="multipart/form-data" 
		id="form_get_stat"
	>
		<div class="well">
			<div class="row">
				<div class="col-sm-<?php echo ($stat_filter_type == 'min' ? '3' : '6'); ?>">
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_labels, 'label_filter_status'); ?>
				    </label>
				    <?php echo echoSelectHtml('IMCallMeAskMe[status][]', $module_lists['status'], ''); ?>
				  </div>
				<?php
					if ($stat_filter_type == 'min')
					{
				?>
				</div>
				<div class="col-sm-3">
				<?php
					}
				?>
					<div class="form-group">
						<label class="control-label">
							<?php echo label($module_labels, 'label_filter_sort') ?>
						</label>
						<?php echo echoSelectHtml('IMCallMeAskMe[sort][]', $module_lists['sort'], '', ''); ?>
					</div>
				</div>
				<div class="col-sm-<?php echo ($stat_filter_type == 'min' ? '3' : '6'); ?>">
				  	<div class="form-group">
					    <label class="control-label" for="input-date-start">
					    	<?php echo label($module_labels, 'label_filter_date_start'); ?>
					    </label>
					    <div class="input-group date">
					      	<input type="text" name="IMCallMeAskMe[filter_date_start]" 
					      		value="<?php echo date('d.m.Y'); ?>" 
					      		placeholder="<?php echo label($module_labels, 'label_filter_date_start'); ?>" 
					      		data-date-format="DD.MM.YYYY" 
					      		class="form-control"/>
					      	<span class="input-group-btn">
					      	<button type="button" class="btn btn-default">
					      		<i class="fa fa-calendar"></i>
					      	</button>
					      	</span>
					    </div>
				  	</div>
				<?php
					if ($stat_filter_type == 'min')
					{
				?>
				</div>
				<div class="col-sm-3">
				<?php
					}
				?>
				  	<div class="form-group">
					    <label class="control-label" for="input-date-end">
					    	<?php echo label($module_labels, 'label_filter_date_end'); ?>
					    </label>
					    <div class="input-group date">
					      	<input type="text" name="IMCallMeAskMe[filter_date_end]" 
					      		value="<?php echo date('d.m.Y'); ?>" 
					      		placeholder="<?php echo label($module_labels, 'label_filter_date_end'); ?>" 
					      		data-date-format="DD.MM.YYYY" 
					      		class="form-control"/>
					      	<span class="input-group-btn">
					      	<button type="button" class="btn btn-default">
					      		<i class="fa fa-calendar"></i>
					      	</button>
					      	</span>
					    </div>
				  	</div>
				<?php
					if ($stat_filter_type == 'min')
					{
				?>
				</div>
				<div class="col-sm-12">
				<?php
					}
				?>
					<button type="button"  
					  		class="btn btn-primary pull-right button-filter">
						<i class="fa fa-search"></i> 
					  	<?php echo label($module_labels, 'label_module_btn_filter'); ?>
					</button>
					<span id="save_status_get_stat"></span>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<button type="button"  
			  		class="btn btn-danger pull-right button-delete">
				<i class="fa fa-close"></i> 
			  	<?php echo label($module_labels, 'label_module_btn_delete'); ?>
			</button>
			<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<button type="button"  
			  		class="btn btn-info pull-right button-save">
				<i class="fa fa-save"></i> 
			  	<?php echo label($module_labels, 'label_module_btn_save'); ?>
			</button>
			<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<button type="button"  
			  		class="btn btn-success pull-right button-complete">
				<i class="fa fa-check"></i> 
			  	<?php echo label($module_labels, 'label_module_btn_status_complete'); ?>
			</button>
			<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<button type="button"  
			  		class="btn btn-warning pull-right button-wait">
				<i class="fa fa-circle-o"></i> 
			  	<?php echo label($module_labels, 'label_module_btn_status_wait'); ?>
			</button>
			<span id="save_status_table"></span>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-results">
				<thead>
					<tr>
						<th>
							<input type="checkbox">
						</th>
						<th><?php echo label($module_labels, 'label_table_header_stat_id'); ?></th>
						<th><?php echo label($module_labels, 'label_table_header_lang'); ?></th>
						
						<th><?php echo label($module_labels, 'label_table_header_fields'); ?></th>

						<th><?php echo label($module_labels, 'label_table_header_utm'); ?></th>
						
						<th><?php echo label($module_labels, 'label_table_header_status'); ?></th>
						<th><?php echo label($module_labels, 'label_table_header_url'); ?></th>
						<th><?php echo label($module_labels, 'label_table_header_comment'); ?></th>
						<th><?php echo label($module_labels, 'label_table_header_date_create'); ?></th>
						<th><?php echo label($module_labels, 'label_table_header_date_modify'); ?></th>
						<th><?php echo label($module_labels, 'label_table_header_ip'); ?></th>
					</tr>	
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</form>
</div>

<script type="text/javascript">
	var IMCA_module_links = {
		setStatus: decodeURIComponent('<?php echo $module_links["setStatus"] ?>')
			.replace('&amp;', '&'),
		saveStat: decodeURIComponent('<?php echo $module_links["saveStat"] ?>')
			.replace('&amp;', '&'),	
		deleteStat: decodeURIComponent('<?php echo $module_links["deleteStat"] ?>')
			.replace('&amp;', '&')
	},
		is_version_2_2 = '<?php echo $is_version_2_2 ?>'
	;

	function IMCA_parseDate(date) {
		//debugger;
		// Если нечего парсить
		if (!date) return null;
		// Если код изначально был в формате C#
		if (typeof(date) === 'string' && date.indexOf('/Date(') === 0) return new Date(parseInt(date.substring(6)));
		// Если мы взяли iso формат
		else if (typeof(date) === 'string' && date.replace('-', '').length != date.length) {
			return new Date(date.replace(/(\d+)-(\d+)-(\d+)/, '$2/$3/$1'));
		}
		// Если мы взяли русский формат
		else if (typeof(date) === 'string' && date.replace('.', '').length != date.length) {
			return new Date(date.replace(/(\d+)\.(\d+)\.(\d+)/, '$2/$1/$3'));
		}
		// Если передан готовый объект
		else if (typeof(date) === 'object' && date.constructor === Date) return date;
		// Пришел некорректный параметр отдаем пустой объект
		return null;
	}

	function IMCA_toDate(_date) {
		//debugger;
		var date;
		// Если входной формат не корректен,
		// то возвращаем пустую строку
		if (!(date = IMCA_parseDate(_date))) return '';
		return (date.getDate() < 10 ? '0' + date.getDate() : '' + date.getDate()) + '.' + (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : '' + (date.getMonth() + 1)) + '.' + date.getFullYear() + ' ' + (date.getHours() < 10 ? '0' + date.getHours() : '' + date.getHours()) + ':' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : '' + date.getMinutes());
	}

	function IMCA_actionWithTable(form, data, url, need_table_reform) {
		//debugger;
		jQuery('#save_status_table').removeClass('fail').removeClass('success')
		.html('Выполняем операцию...');
		
		jQuery.ajax({
			url: url,
			type: 'post',
			data: data,
			dataType: 'json',
			success: function (json) {
				if (json['success']) {
					jQuery('#save_status_table').removeClass('fail').addClass('success')
					.html('Операция выполнена!');
					
					if (need_table_reform) {
						IMCA_loadGetStat(form);
					}
				} else {
					jQuery('#save_status_table').removeClass('success').addClass('fail')
					.html('Возникли ошибки!');
				}
			}
		});
	}

	function IMCA_bindTableAndButtonEvents(form) {
		//debugger;
		form.find('.button-save, .button-delete, .button-complete, .button-wait').unbind();
		form.find('table.table-results *').unbind();
		
		form.find('table.table-results thead input').click(function () {
			var item = jQuery(this)
			;
			if (item.prop('checked')) {
				item.closest('table').find('tbody input').prop('checked', 'checked');
			}
			else {
				item.closest('table').find('tbody input').removeAttr('checked');
			}
		});
		
		form.find('.button-delete').click(function () {
			var data = []
			;
			
			form.find('table.table-results tbody input:checked').each(function () {
				var item = jQuery(this)
				;
				data.push({
					name: 'IMCallMeAskMe[items][]',
					value: item.closest('tr').find('td.id').text()
				});
			});
			
			if (data.length > 0) {
				IMCA_actionWithTable(form, data, IMCA_module_links.deleteStat, true);
			}
		});

		form.find('.button-save').click(function () {
			var data = [],
				cnt = 0
			;

			form.find('table.table-results tbody input:checked').each(function () {
				var item = jQuery(this)
				;
				data.push({
					name: 'IMCallMeAskMe[items][' + cnt + '][stat_id]',
					value: item.closest('tr').find('td.id').text()
				});
				data.push({
					name: 'IMCallMeAskMe[items][' + cnt + '][comment]',
					value: item.closest('tr').find('textarea').val()
				});
				
				cnt++;
			});
			
			if (data.length > 0) {
				IMCA_actionWithTable(form, data, IMCA_module_links.saveStat, true);
			}
		});

		form.find('.button-complete').click(function () {
			var data = [],
				cnt = 0
			;

			form.find('table.table-results tbody input:checked').each(function () {
				var item = jQuery(this)
				;
				data.push({
					name: 'IMCallMeAskMe[items][' + cnt + '][stat_id]',
					value: item.closest('tr').find('td.id').text()
				});
				data.push({
					name: 'IMCallMeAskMe[items][' + cnt + '][status]',
					value: 1
				});
				
				cnt++;
			});
			
			if (data.length > 0) {
				IMCA_actionWithTable(form, data, IMCA_module_links.setStatus, true);
			}
		});

		form.find('.button-wait').click(function () {
			var data = [],
				cnt = 0
			;

			form.find('table.table-results tbody input:checked').each(function () {
				var item = jQuery(this)
				;
				data.push({
					name: 'IMCallMeAskMe[items][' + cnt + '][stat_id]',
					value: item.closest('tr').find('td.id').text()
				});
				data.push({
					name: 'IMCallMeAskMe[items][' + cnt + '][status]',
					value: 0
				});
				
				cnt++;
			});
			
			if (data.length > 0) {
				IMCA_actionWithTable(form, data, IMCA_module_links.setStatus, true);
			}
		});
	}

	function IMCA_loadGetStat(form) {
		
		console.log(form.attr('action'));
		//debugger;
		
		jQuery('#save_status_get_stat').removeClass('fail').removeClass('success')
		.html('Получаем данные...');
		
		jQuery.ajax({
			url: form.attr('action'),
			type: 'post',
			data: form.serializeArray(),
			dataType: 'json',
			success: function (json) {
				
				console.log(json);
					
					
				if (json['success']) {
					jQuery('#save_status_get_stat').removeClass('fail').addClass('success')
					.html('Данные получены!');
					
					var tbody = form.find('table.table-results tbody')
					;
					
					tbody.html('');
					
					// Заполняем таблицу данными
					for (var cnt = 0; cnt < json['data'].length; cnt++) {
						var item = json['data'][cnt];
						
						var row = jQuery('<tr>'),
							path_lang_image = json['path_lang_image']
						;
						
						tbody.append(row);
						
						row.html(
							'<td>'
								+ '<input type="checkbox"/>'
							+ '</td>'
							+ '<td class="text-right id">'
								+ item['stat_id']
							+ '</td>'
							+ '<td>'
								//+ item['lang_name']
								+ '<img src="' 
									+ path_lang_image + item['lang_code'] + '/' + item['lang_code'] + '.png'
								+ '" />'
							+ '</td>'
							+ '<td class="nowrap">'
				        		+ '<b>Имя</b>: ' + item['user_name']
				        		+ '<br/>'
				        		+ '<b>Почта</b>: ' + item['email']
				        		+ '<br/>'
				        		+ '<b>Телефон</b>: ' + item['phone']
				        		+ '<br/>'
				        		+ '<b>Сообщение</b>: ' 
				        			+ '<br/>'
						        		+ item['text']
				        		+ '<br/>'
							+ '</td>'
							+ '<td class="nowrap">'
				        		+ '<b>Source</b>: ' + item['utm_source']
				        		+ '<br/>'
				        		+ '<b>Medium</b>: ' + item['utm_medium']
				        		+ '<br/>'
				        		+ '<b>Campaign</b>: ' + item['utm_campaign']
				        		+ '<br/>'
				        		+ '<b>Content</b>: ' + item['utm_content']
				        		+ '<br/>'
				        		+ '<b>Term</b>: ' + item['utm_term']
				        		+ '<br/>'
							+ '</td>'
							+ '<td class="nowrap ' + (('' + item['status']) == '0' ? '' : 'green') + ' ">'
								+ (('' + item['status']) == '0'
									? 'В ожидании'
									: 'Запрос выполнен')
							+ '</td>'
							+ '<td>'
								+ '<a href="' + item['url'] + '" target="_blank">'
									+ 'Ссылка' // + item['url']
								+ '</a>'
							+ '</td>'
							+ '<td>'
								+ '<textarea>'
									+ item['comment']
								+ '</textarea>'
							+ '</td>'
							+ '<td>'
								+ IMCA_toDate(item['date_create'])
							+ '</td>'
							+ '<td>'
								+ IMCA_toDate(item['date_modify'])
							+ '</td>'
							+ '<td>'
								+ item['ip']
							+ '</td>'
						);
					}
					
					IMCA_bindTableAndButtonEvents(form);
			
				} else {
					jQuery('#save_status_get_stat').removeClass('success').addClass('fail')
					.html('При загрузке возникли ошибки!');
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

	#form_get_stat .table-results textarea
	{
		width: 100%;
	}

</style>