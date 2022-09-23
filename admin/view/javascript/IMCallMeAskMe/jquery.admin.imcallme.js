function IMCA_getQueryParam(name) {
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href.split('#')[0]);
    if (results)
        return results[1];
    else
        return '';
}


jQuery(function () {
	var jq = jQuery,
		sendArray = [{name: 'IMCallMeAskMe[stat_filter_type]', value: 'min'}]
	;
	
	jq.ajax({
		url: 'index.php?route=extension/module/IMCallMeAskMe/statView&token=' + IMCA_getQueryParam('token'),
		type: 'POST',
		cache: false,
		data: sendArray,
		dataType: 'html',
		success: function (html) {
			// Выход, если ошибка или не хватает прав доступа
			if (jq.trim(html) == '')
				return;
			if (jq(html).find('body').length > 0 || jq(html).find('#form_get_stat').length == 0)
				return;
				
			var container = jq('#container #content .container-fluid'),
				row = jq('<div class="panel panel-default" id="imcallmetabsstat">')
			;
			
			container.prepend(row);
			row.append(
				'<div class="panel-heading">'
			    	+ '<h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Менеджер звонков</h3>'
			  	+ '</div>'
			);
			
			row.append(html);
			
			IMCA_loadGetStat(jq('#imcallmetabsstat form'));

			jq('#imcallmetabsstat .date').datetimepicker({
				pickTime: false
			});
			
			jq('#imcallmetabsstat .button-filter').click(function () {
				IMCA_loadGetStat(jq(this).closest('form'));
			});
		}
	});
});
