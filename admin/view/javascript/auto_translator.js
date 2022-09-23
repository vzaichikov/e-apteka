
function getGoogleTranslate(btn, key, source, target, type, name, full) {
    $('.translate-error').remove();
    var format = 'text';
    if(full){
        var from_el = $(type + '[name=\'' + name + '\']');
    } else {
        var from_el = $(type + '[name=\'' + name + btn.parent().find(type + ':first').attr('name').match(/\[(.*?)\]/g)[1] + '\']');
    }
    var to_el = btn.parent().find(type + ':first');
    var text = from_el.val();
    if(to_el.next().hasClass('note-editor')){
        format = 'html';
        text = from_el.next().find('.note-editable').html();
        text.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
    }else if(to_el.next().is('[class*="cke_editor_input"]')){
        format = 'html';
        text = CKEDITOR.instances[from_el.attr('id')].getData();
        text.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
    }
    $.ajax({
        url: 'https://translation.googleapis.com/language/translate/v2',
        type: 'post',
        data: 'key=' + key + '&format=' + format + '&source=' + source + '&target=' + target + '&q=' + encodeURIComponent(text),
        beforeSend: function() {
            btn.button('loading');
        },
        complete: function() {
            btn.button('reset');
        },
        success: function(response) {
            if(to_el.next().hasClass('note-editor')){
                to_el.next().find('.note-editable').html(response.data.translations[0].translatedText);
            } else if(to_el.next().is('[class*="cke_editor_input"]')){
                CKEDITOR.instances[to_el.attr('id')].setData(response.data.translations[0].translatedText);
            }
            to_el.val(response.data.translations[0].translatedText);
        },
        error: function(jqXHR, textStatus, errorThrown){
            btn.parent().prepend('<div class="alert alert-danger translate-error"><i class="fa fa-exclamation-circle"></i> Error: ' + jqXHR.responseJSON.error.message + ' ' + jqXHR.responseJSON.error.code + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }
    });
}

function updateMicrosoftToken() {
    $.ajax({
        url: 'index.php?route=module/auto_translator/getmicrosofttoken&token=' + getURLVar('token'),
        type: 'get',
        success: function(response) {
            if(response.token){
                $('input[name=\'microsoft_token\']').val(response.token);
            } else if(response.error){
                $('input[name=\'microsoft_token\']').data('error', response.error);
            }
        }
    });
}

function getMicrosoftTranslate(btn, from, target, type, name, full) {
    $('.translate-error').remove();
    if($('input[name=\'microsoft_token\']').val()){
        var format = 'text/plain';
        if(full){
            var from_el = $(type + '[name=\'' + name + '\']');
        } else {
            var from_el = $(type + '[name=\'' + name + btn.parent().find(type + ':first').attr('name').match(/\[(.*?)\]/g)[1] + '\']');
        }
        var to_el = btn.parent().find(type + ':first');
        var text = from_el.val();
        var token = $('input[name=\'microsoft_token\']').val();
        if(to_el.next().hasClass('note-editor')){
            format = 'text/html';
            text = from_el.next().find('.note-editable').html();
            text.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
        }else if(to_el.next().is('[class*="cke_editor_input"]')){
            format = 'text/html';
            text = CKEDITOR.instances[from_el.attr('id')].getData();
            text.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
        }
        if(text.length > 9000){
            btn.button('loading');
            var parts = text.match(/[\S\s]{1,9000}(?=[^>]*(<\s*\/?\s*(\w+\b)|$))(?=\s+\S*|<.+?>|$)/gim);
            var list = [];
            for(var i=0;i<parts.length;i++) {
                $.ajax({
                    url: 'https://api.microsofttranslator.com/V2/Ajax.svc/Translate',
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    data: "appId=Bearer " + encodeURIComponent(token) + "&contentType=" + encodeURIComponent(format) + "&from=" + encodeURIComponent(from) + "&to=" + encodeURIComponent(target) + "&text=" + encodeURIComponent(parts[i]),
                    success: function(response) {
                        list[parseInt(i)] = response;
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        btn.parent().prepend('<div class="alert alert-danger translate-error"><i class="fa fa-exclamation-circle"></i> Error: ' + jqXHR.status + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }
                });
            }
            if(to_el.next().hasClass('note-editor')){
                to_el.next().find('.note-editable').html(list.join(" "));
            } else if(to_el.next().is('[class*="cke_editor_input"]')){
                CKEDITOR.instances[to_el.attr('id')].setData(list.join(" "));
            }
            to_el.val(list.join(" "));
            btn.button('reset');
        } else {
            $.ajax({
                url: 'https://api.microsofttranslator.com/V2/Ajax.svc/Translate',
                type: 'get',
                dataType: 'json',
                data: "appId=Bearer " + encodeURIComponent(token) + "&contentType=" + encodeURIComponent(format) + "&from=" + encodeURIComponent(from) + "&to=" + encodeURIComponent(target) + "&text=" + encodeURIComponent(text),
                beforeSend: function() {
                    btn.button('loading');
                },
                complete: function() {
                    btn.button('reset');
                },
                success: function(response) {
                    if(to_el.next().hasClass('note-editor')){
                        to_el.next().find('.note-editable').html(response);
                    } else if(to_el.next().is('[class*="cke_editor_input"]')){
                        CKEDITOR.instances[to_el.attr('id')].setData(response);
                    }
                    to_el.val(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    var ajax_error;
                    if (jqXHR.status === 0) {
                        ajax_error = 'Not connect.n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        ajax_error = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        ajax_error = 'Internal Server Error [500].';
                    } else if (textStatus === 'parsererror') {
                        ajax_error = 'Requested JSON parse failed.';
                    } else if (textStatus === 'timeout') {
                        ajax_error = 'Time out error.';
                    } else if (textStatus === 'abort') {
                        ajax_error = 'Ajax request aborted.';
                    } else {
                        ajax_error = 'Uncaught Error.n' + jqXHR.responseText;
                    }
                    btn.parent().prepend('<div class="alert alert-danger translate-error"><i class="fa fa-exclamation-circle"></i> ' + ajax_error + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            });
        }
    } else {
        btn.parent().prepend('<div class="alert alert-danger translate-error"><i class="fa fa-exclamation-circle"></i> ' + $('input[name=\'microsoft_token\']').data('error') + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    }
}

function getCopy(btn, type, name, full) {
    if(full){
        var from_el =  $(type + '[name=\''+ name + '\']');
    } else {
        var from_el =  $('[name=\''+ name + btn.parent().find(type + ':first').attr('name').match(/\[(.*?)\]/g)[1] + '\']');
    }
    var to_el =  btn.parent().find(type + ':first');
    if(to_el.next().hasClass('note-editor')){
        to_el.next().find('.note-editable').html(from_el.next().find('.note-editable').html());
    } else if(to_el.next().is('[class*="cke_editor_input"]')){
        CKEDITOR.instances[to_el.attr('id')].setData(CKEDITOR.instances[from_el.attr('id')].getData());
    }
    to_el.val(from_el.val());
}