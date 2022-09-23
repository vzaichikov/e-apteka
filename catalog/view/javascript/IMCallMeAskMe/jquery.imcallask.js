function IMCallMeAskMe_getQueryParam(name) {
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href.split('#')[0]);
    if (results)
        return results[1];
    else
        return '';
}

function IMCallMeAskMe_collectParams(form) {
	var sendArray = form.serializeArray(),
		queryArray = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term']
	;

	// Сохраняем UTM метки
	for (var cnt = 0; cnt < queryArray.length; cnt++) {
		sendArray.push({
			name: queryArray[cnt],
			value: 	IMCallMeAskMe_getQueryParam(queryArray[cnt])
		});
	}
	
	return sendArray;
}

function IMCallMeAskMe_formSubmit(container) {
	container.find('form').submit(function (e) {
		e.preventDefault();
		
		var jq = jQuery,
			form = jq(this),
        	submit = form.find('button[type=submit]')
        ;

        
		container.find('.has-error').removeClass('has-error');

        jq.ajax({
            url: form.attr('action'),
            type: 'post',
            cache: false,
            data: IMCallMeAskMe_collectParams(form),
            dataType: 'json',
            beforeSend: function() {
                submit.button('loading');
            },
            complete: function() {
                submit.button('reset');
            },
            success: function(json) {
                
                console.log(json);
                console.log(json['messages']['text']);
                
                container.find('.alert, .text-danger').remove();

                if (json['error']) {
                    
                    if (json['warning']) {
                        form.prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }

                    for (i in json['messages']) {
                        var element = container.find('input[name="' + i + '"], textarea[name="' + i + '"]');
                        element.closest('.form-group').addClass('has-error');
                    }

					if (json['email_send']) {
						var element = jq('<div class="alert alert-danger" role="alert"></div>');
						element.text(json['email_send']);
						form.prepend(element);
					}

                    // Highlight any found errors
                    jq('.text-danger').parent().addClass('has-error');
                    
                    
                }else {
                	var status_complete = jQuery(
                		'<div class="alert alert-success">'
							+ json['complete']
						+ '</div>'
                	);
                	status_complete.insertBefore(form.find('*:first'));
					container.find('#imcallask-form-container-popup').fadeOut(3000, function() {
						jq(this).modal('hide');
						form.find('.alert-success').remove();
					});//.modal('hide');
				}
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
		
		return false;
	});
}

function IMCallMeAskMe_formPopup () {
	var jq = jQuery
	;
	
	if (jq('.imcallask-form-container').length > 0) {
		jq('.imcallask-form-container #imcallask-form-container-popup').modal();
	}
	else {
		var container = jq('<div class="imcallask-form-containe">')
		;
		
		jQuery('body').append(container);
		
		jq.ajax('index.php?route=extension/module/IMCallMeAskMe/getPopup', {
			success: function (html) {
				var hidden = jq('<input type="hidden" name="url" value="">');
				container.html(html);
				container.find('form').append(hidden);
				hidden.val(encodeURIComponent(window.location));
				
				container.find('#imcallask-form-container-popup').modal();
				IMCallMeAskMe_formSubmit(container);
			}
		});		
	}
}

function IMCallMeAskMe_createButton() {
	var jq = jQuery,
		btn = jq('<a href="#" class="imcallask-btn-mini hidden-xs"><div class="imcallask-btn-mini-phone"></div></a>')
	;

	jq('body').append(btn);
	btn.click(function (e) {
		e.preventDefault();
		//$('.imcallask-btn-mini .imcallask-btn-mini-phone').addClass('active');
		IMCallMeAskMe_formPopup();

		return false;
	});
}

$(document).ready(function(){
	IMCallMeAskMe_createButton();
});