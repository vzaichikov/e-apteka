<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
      <div class="container-fluid">
        <div class="pull-right">
          <button type="submit" form="form-auto-translator" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
          <a onclick="$('#apply').attr('value', '1'); $('#form-auto-translator').submit();" data-toggle="tooltip" title="<?php echo $button_apply; ?>" class="btn btn-success"><i class="fa fa-refresh"></i></a>
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
        <h1><i class="fa fa-language" style="color:#00BFFF;"></i> <?php echo $heading_title; ?></h1>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_setting; ?></h3>
        </div>
        <div class="panel-body">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-auto-translator" class="form-horizontal">
            <input type="hidden" name="apply" id="apply" value="0">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-bars tab-icon"></i> <?php echo $tab_general; ?></a></li>
              <li><a href="#tab-auto" data-toggle="tab"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_auto_mode; ?>"><i class="fa fa-refresh"></i> <?php echo $tab_auto; ?></span></a></li>
              <li><a href="#tab-log" data-toggle="tab" id="tab-log-btn" data-loading-text="<i class='fa fa-spinner fa-pulse'> <?php echo $text_loading; ?>"><i class="fa fa-history"></i> <?php echo $tab_log; ?></a></li>             
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-general">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_translator; ?>"><?php echo $entry_translator; ?></span></label>
                  <div class="col-sm-10">
                    <select name="auto_translator_status" id="input-status" class="form-control">
                      <option value="0" <?php if (!isset($auto_translator_status) || $auto_translator_status == '0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                      <option value="1" <?php if (isset($auto_translator_status) && $auto_translator_status == '1') { ?>selected="selected"<?php } ?>><?php echo $text_google; ?></option>
                      <option value="2" <?php if (isset($auto_translator_status) && $auto_translator_status == '2') { ?>selected="selected"<?php } ?>><?php echo $text_microsoft; ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-source"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_source_language; ?>"><?php echo $entry_source; ?></span></label>
                  <div class="col-sm-10">
                    <select name="auto_translator_source" id="input-source" class="form-control">
                      <?php foreach($languages as $language){ ?>
                      <option value="<?php echo $language['language_id']; ?>" <?php if ($auto_translator_source == $language['language_id']) { ?>selected="selected"<?php } ?>><?php echo $language['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <fieldset>
                  <legend><?php echo $text_auto_mode; ?></legend>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-send-interval"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_send_interval; ?>"><?php echo $entry_send_interval; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="auto_translator_send_interval" value="<?php echo isset($auto_translator_send_interval)?$auto_translator_send_interval:'100'; ?>" placeholder="<?php echo $entry_send_interval; ?>" id="input-send-interval" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-limit-item"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_limit_item; ?>"><?php echo $entry_limit_item; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="auto_translator_limit_item" value="<?php echo isset($auto_translator_limit_item)?$auto_translator_limit_item:'10000'; ?>" placeholder="<?php echo $entry_limit_item; ?>" id="input-limit-item" class="form-control" />
                    </div>
                  </div>
                </fieldset>
                <fieldset>
                  <legend><?php echo $text_google; ?></legend>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-api_key"><span data-toggle="tooltip" data-html="true" title="<?php echo htmlspecialchars($help_google_key); ?>"><?php echo $entry_api_key; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="auto_translator_api_key" value="<?php echo isset($auto_translator_api_key)?$auto_translator_api_key:''; ?>" placeholder="<?php echo $entry_api_key; ?>" id="input-api_key" class="form-control" />
                      <div><?php echo $help_google_key_link; ?></div>
                    </div>
                  </div>
                  <?php foreach($languages as $language){ ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-language<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_g_api_language; ?>"><?php echo $language['name']; ?></span></label>
                    <div class="col-sm-10">
                      <select name="auto_translator_g_language[<?php echo $language['language_id']; ?>]" id="input-g-language<?php echo $language['language_id']; ?>" class="form-control">
                        <?php foreach($google_languages as $key => $name){ ?>
                        <option value="<?php echo $key; ?>" <?php if (isset($auto_translator_g_language[$language['language_id']]) && $auto_translator_g_language[$language['language_id']] == $key) { ?>selected="selected"<?php } ?>><?php echo $name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } ?>
                  </fieldset>
                <fieldset>
                  <legend><?php echo $text_microsoft; ?></legend>
                  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_m_api_key; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button></div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-microsoft_key"><span data-toggle="tooltip" data-html="true" title="<?php echo htmlspecialchars($help_microsoft_key); ?>"><?php echo $entry_microsoft_key; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="auto_translator_microsoft_key" value="<?php echo isset($auto_translator_microsoft_key)?$auto_translator_microsoft_key:''; ?>" placeholder="<?php echo $entry_microsoft_key; ?>" id="input-microsoft_key" class="form-control" />
                      <div><?php echo $help_microsoft_key_link; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="select-microsoft-token"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_microsoft_token; ?>"><?php echo $entry_microsoft_token; ?></span></label>
                    <div class="col-sm-10">
                      <select name="auto_translator_microsoft_token" id="select-microsoft-token" class="form-control">
                        <option value="0" <?php if (!isset($auto_translator_microsoft_token) || $auto_translator_microsoft_token == 0) { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                        <option value="1" <?php if (isset($auto_translator_microsoft_token) && $auto_translator_microsoft_token) { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" style="opacity: 0.6;">
                    <label class="col-sm-2 control-label" for="input-client_id"><span data-toggle="tooltip" data-html="true" title="<?php echo htmlspecialchars($help_client_id); ?>"><?php echo $entry_client_id; ?></span></label>
                    <div class="col-sm-4">
                      <input type="text" name="auto_translator_client_id" value="<?php echo isset($auto_translator_client_id)?$auto_translator_client_id:''; ?>" placeholder="<?php echo $entry_client_id; ?>" id="input-client_id" class="form-control" />
                    </div>
                    <label class="col-sm-2 control-label" for="input-client_secret"><?php echo $entry_client_secret; ?></label>
                    <div class="col-sm-4">
                      <input type="text" name="auto_translator_client_secret" value="<?php echo isset($auto_translator_client_secret)?$auto_translator_client_secret:''; ?>" placeholder="<?php echo $entry_client_secret; ?>" id="input-client_secret" class="form-control" />
                    </div>
                  </div>
                  <?php foreach($languages as $language){ ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-m-language<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_m_api_language; ?>"><?php echo $language['name']; ?></span></label>
                    <div class="col-sm-10">
                      <select name="auto_translator_m_language[<?php echo $language['language_id']; ?>]" id="input-m-language<?php echo $language['language_id']; ?>" class="form-control">
                        <?php foreach($microsoft_languages as $key => $name){ ?>
                        <option value="<?php echo $key; ?>" <?php if (isset($auto_translator_m_language[$language['language_id']]) && $auto_translator_m_language[$language['language_id']] == $key) { ?>selected="selected"<?php } ?>><?php echo $name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } ?>
                </fieldset>
              </div>
              <div class="tab-pane" id="tab-auto">
                <div class="form-group">
                  <?php if($auto_translator_status != '0') { ?>
                  <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_translate_from; ?></label>
                  <div class="col-sm-2">
                    <?php foreach($languages as $language){ ?>
                    <?php if($language['language_id'] == $auto_translator_source) { ?>
                      <div style="padding-top: 9px;"><span class="label label-default"><?php echo $language['name']; ?></span></div>
                    <?php } ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                  <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_translator; ?></label>
                  <div class="col-sm-2">
                    <?php if($auto_translator_status == '0') { ?>
                    <div style="padding-top: 9px;"><span class="label label-danger"><?php echo $text_disabled; ?></span></div>
                    <?php } ?>
                    <?php if($auto_translator_status == '1') { ?>
                    <div style="padding-top: 9px;"><span class="label label-success"><?php echo $text_google; ?></span></div>
                    <?php } ?>
                    <?php if($auto_translator_status == '2') { ?>
                    <div style="padding-top: 9px;"><span class="label label-success"><?php echo $text_microsoft; ?></span></div>
                    <?php } ?>
                  </div>
                </div>
                <?php if($auto_translator_status != '0') { ?>
                <?php if($auto_translator_status ==  '1' && $auto_translator_api_key || $auto_translator_status ==  '2' && $auto_translator_microsoft_key || $auto_translator_status ==  '2' && $auto_translator_client_id && $auto_translator_client_secret) { ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-language_id"><?php echo $entry_translate_language; ?></label>
                  <div class="col-sm-10">
                    <select name="language_id" id="input-language_id" class="form-control">
                      <option value="0" selected="selected"><?php echo $text_all_languages; ?></option>
                      <?php foreach($languages as $language){ ?>
                        <?php if($language['language_id'] != $auto_translator_source) { ?>
                        <option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group" id="section">
                  <label class="col-sm-2 control-label" for="input-section_id"><?php echo $entry_section; ?></label>
                  <div class="col-sm-10">
                    <select name="section_id" id="input-section_id" class="form-control">
                      <option value="0" selected="selected"><?php echo $text_select; ?></option>
                      <option value="1"><?php echo $text_product; ?></option>
                      <option value="19"><?php echo $text_product_attribute; ?></option>
                      <option value="2"><?php echo $text_category; ?></option>
                      <option value="3"><?php echo $text_filter; ?></option>
                      <option value="4"><?php echo $text_filter_group; ?></option>
                      <option value="5"><?php echo $text_attribute; ?></option>
                      <option value="6"><?php echo $text_attribute_group; ?></option>
                      <option value="7"><?php echo $text_option; ?></option>
                      <option value="8"><?php echo $text_option_value; ?></option>
                      <option value="9"><?php echo $text_download; ?></option>
                      <option value="10"><?php echo $text_information; ?></option>
                      <option value="11"><?php echo $text_banner; ?></option>
                      <option value="12"><?php echo $text_recurring; ?></option>
                      <option value="13"><?php echo $text_customer_group; ?></option>
                      <option value="14"><?php echo $text_custom_field; ?></option>
                      <option value="15"><?php echo $text_custom_field_value; ?></option>
                      <option value="16"><?php echo $text_voucher_theme; ?></option>
                      <option value="17"><?php echo $text_length_classes; ?></option>
                      <option value="18"><?php echo $text_weight_classes; ?></option>
                    </select>
                    <div data-loading-text="<i class='fa fa-spinner fa-pulse'> <?php echo $text_loading; ?>"></div>
                  </div>
                </div>
                <?php } else { ?>
                <div class="alert alert-warning"><i class="fa fa-info-circle"></i> <?php echo $error_api_key; ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button></div>
                <?php } ?>
                <?php } ?>
              </div>
              <div class="tab-pane" id="tab-log">
                <p>
                  <textarea wrap="off" rows="20" name="logs" class="form-control"><?php echo $log ?></textarea>
                </p>
                <div class="text-right">
                  <a href="#" class="btn btn-warning" id="clear-log" data-loading-text="<i class='fa fa-spinner fa-pulse'> <?php echo $text_loading; ?>">
                    <i class="fa fa-eraser"></i> <?php echo $button_clear ?>
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript"><!--
  $("#clear-log").on('click', function(e) {
    e.preventDefault();
    var element = $(this);
    $.ajax({
      url: '<?php echo html_entity_decode($clear_log); ?>',
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        element.button('loading');
      },
      complete: function() {
        element.button('reset');
      },
      success: function (json) {
        if(json.success){
          $('textarea[name=\'logs\']').val('');
          alert(json.success);
        } else if(json.error){
          alert(json.error);
        }
      }
    });
  });
  $("#tab-log-btn").on('click', function(e) {
    var element = $(this);
    $.ajax({
      url: '<?php echo html_entity_decode($get_log); ?>',
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        element.button('loading');
        $('textarea[name=\'logs\']').val('');
      },
      complete: function() {
        element.button('reset');
      },
      success: function (json) {
        $('textarea[name=\'logs\']').val(json.log);
      }
    });
  });
  //--></script>
<script type="text/javascript"><!--
  $('select[name=\'section_id\']').change(function(){
    $( "#field" ).remove();
    $( "#category" ).remove();
    $( "#number-item" ).remove();
    $( "#status" ).remove();
    $( "#btn-translate" ).remove();
    $( "#change-item" ).remove();
    $( "#filter" ).remove();
    $( "#limit" ).remove();
    $( "#item_id" ).remove();
    $( "#item_list" ).remove();
    var element = $(this);
    switch ($(this).val()) {
      case '1':{
        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_product_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($product_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '<a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);"><?php echo $text_unselect_all; ?></a></div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);

        $.ajax({
          url: '<?php echo html_entity_decode($categories); ?>',
          type: 'post',
          dataType: 'json',
          beforeSend: function() {
            element.next().button('loading');
          },
          complete: function() {
            if($('#number-item').length){
              element.next().button('reset');
            }
          },
          success: function (json) {
            html = '<div class="form-group" id="category">';
            html += '<label class="col-sm-2 control-label" for="input-category_id"><?php echo $entry_product_category; ?></label>';
            html += '<div class="col-sm-10">';
            html += '<select name="category_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-category_id" class="form-control">';
            html += '<option value="0"><?php echo $text_all_categories; ?></option>';
            var i;
            for (i = 0; i < json.length; ++i) {
              html += '<option value="' + json[i]['category_id'] + '">' + json[i]['name'] + '</option>';
            }
            html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></i></div>';
            html += '</div>';
            html += '</div>';

            $('#section').after(html);
          }
        });
        break;
      }
      case '2':{
        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_category_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
        <?php foreach($category_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '<a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);"><?php echo $text_unselect_all; ?></a></div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '3':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_filter_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($filter_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '4':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_filter_group_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($filter_group_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '5':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_attribute_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($attribute_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '6':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_attribute_group_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($attribute_group_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '7':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_option_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($option_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '8':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_option_value_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($option_value_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '9':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_download_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($download_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '10':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_information_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($information_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '<a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);"><?php echo $text_unselect_all; ?></a></div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '11':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_banner_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($banner_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '12':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_recurring_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($recurring_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '13':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_customer_group_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($customer_group_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '<a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);"><?php echo $text_unselect_all; ?></a></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '14':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_custom_field_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($custom_field_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '15':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_custom_field_value_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($custom_field_value_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '16':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_voucher_theme_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($voucher_theme_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '17':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_length_class_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($length_class_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '<a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);"><?php echo $text_unselect_all; ?></a></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '18':{

        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_weight_class_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($weight_class_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '<a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);"><?php echo $text_unselect_all; ?></a></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);
        break;
      }
      case '19':{
        html = '<div class="form-group" id="field">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_product_attribute_field; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div id="field-list" class="well well-sm" style="height: 150px; overflow: auto;">';
      <?php foreach($product_attribute_fields as $field) { ?>
          html += '<div class="checkbox">';
          html += '<label>';
          html += '<input type="checkbox" name="field_list[]" value="<?php echo $field['id']; ?>" <?php if($field['checked']) { ?>checked="checked"<?php } ?> /><?php echo $field['name']; ?>';
          html += '</label>';
          html += '</div>';
        <?php } ?>
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group" id="status">';
        html += '<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_product_status; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<select name="status_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val());" id="input-status" class="form-control">';
        html += '<option value=""><?php echo $text_all_items; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></div>';
        html += '</div>';
        html += '</div>';

        $('#tab-auto').append(html);

        $.ajax({
          url: '<?php echo html_entity_decode($categories); ?>',
          type: 'post',
          dataType: 'json',
          beforeSend: function() {
            element.next().button('loading');
          },
          complete: function() {
            if($('#number-item').length){
              element.next().button('reset');
            }
          },
          success: function (json) {
            html = '<div class="form-group" id="category">';
            html += '<label class="col-sm-2 control-label" for="input-category_id"><?php echo $entry_product_category; ?></label>';
            html += '<div class="col-sm-10">';
            html += '<select name="category_id" onchange="getListItems($(this), $(\'select[name=filter_id]\').val())" id="input-category_id" class="form-control">';
            html += '<option value="0"><?php echo $text_all_categories; ?></option>';
            var i;
            for (i = 0; i < json.length; ++i) {
              html += '<option value="' + json[i]['category_id'] + '">' + json[i]['name'] + '</option>';
            }
            html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></i></div>';
            html += '</div>';
            html += '</div>';

            $('#section').after(html);
          }
        });
        break;
      }
    }

    html = '<div class="form-group" id="filter">';
    html += '<label class="col-sm-2 control-label" for="select_filter_id"><?php echo $entry_filter; ?></label>';
    html += '<div class="col-sm-10">';
    html += '<select name="filter_id" onchange="getFilter($(this))" id="select_filter_id" class="form-control">';
    html += '<option value="0"><?php echo $text_all_items; ?></option>';
    html += '<option value="1"><?php echo $text_by_groups; ?></option>';
    html += '<option value="4"><?php echo $text_by_groups_id; ?></option>';
    html += '<option value="2"><?php echo $text_by_id; ?></option>';
    html += '<option value="3"><?php echo $text_by_list; ?></option>';
    html += '</select><div data-loading-text="<i class=\'fa fa-spinner fa-pulse\'> <?php echo $text_loading; ?>"></i></div>';
    html += '</div>';
    html += '</div>';

    $('#tab-auto').append(html);

    getListItems($(this));
  });
  function getFilter(element) {
    $( "#limit" ).remove();
    $( "#item_id" ).remove();
    switch (element.val()) {
      case '1':{
        html = '<div class="form-group" id="limit">';
        html += '<label class="col-sm-2 control-label" for="input-start-number"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_start_number; ?>"><?php echo $entry_start_number; ?></span></label>';
        html += '<div class="col-sm-4">';
        html += '<input name="start_number" id="input-start-number" class="form-control" />';
        html += '</div>';
        html += '<label class="col-sm-2 control-label" for="input-last-number"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_last_number; ?>"><?php echo $entry_last_number; ?></span></label>';
        html += '<div class="col-sm-4">';
        html += '<input name="last_number" id="input-last-number" class="form-control" />';
        html += '</div>';
        html += '</div>';
        $('#filter').after(html);
        $('[data-toggle="tooltip"]').tooltip();
        getListItems(element);
        break;
      }
      case '2':{
        html = '<div class="form-group" id="item_id">';
        html += '<label class="col-sm-2 control-label" for="input-item_id"><?php echo $entry_item_id; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<input name="item_id" id="input-item_id" class="form-control" placeholder="<?php echo $entry_item_id; ?>" />';
        html += '</div>';
        html += '</div>';
        $('#filter').after(html);
        getListItems(element);
        break;
      }
      case '3':{
        getListItems(element, 3);
        break;
      }
      case '4':{
        html = '<div class="form-group" id="limit">';
        html += '<label class="col-sm-2 control-label" for="input-start-id"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_start_id; ?>"><?php echo $entry_start_id; ?></span></label>';
        html += '<div class="col-sm-4">';
        html += '<input name="start_id" id="input-start-id" class="form-control" />';
        html += '</div>';
        html += '<label class="col-sm-2 control-label" for="input-last-id"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_last_id; ?>"><?php echo $entry_last_id; ?></span></label>';
        html += '<div class="col-sm-4">';
        html += '<input name="last_id" id="input-last-id" class="form-control" />';
        html += '</div>';
        html += '</div>';
        $('#filter').after(html);
        $('[data-toggle="tooltip"]').tooltip();
        getListItems(element);
        break;
      }
      default :{
        getListItems(element);
        break;
      }
    }
  }
  var loop_id = 0;
  var change_id = 0;
  var item_list = [];
  var item_list_reserve = [];
  function getListItems(element, type = 0) {
    $( "#item_list" ).remove();
    $( "#number-item" ).remove();
    $( "#btn-translate" ).remove();
    $( "#change-item" ).remove();
    loop_id = 0;
    change_id = 0;
    $.ajax({
      url: '<?php echo html_entity_decode($items); ?>',
      type: 'post',
      data: $("#form-auto-translator").serialize(),
      dataType: 'json',
      beforeSend: function() {
        element.next().button('loading');
      },
      complete: function() {
        element.next().button('reset');
      },
      success: function (json) {
        item_list_reserve = item_list = json;
        html = '<div class="form-group" id="item_list">';
        if('<?php echo $auto_translator_limit_item; ?>' > json.length) {
          html += '<label class="col-sm-2 control-label" for="input-item_id"><?php echo $entry_item_list; ?></label>';
          html += '<div class="col-sm-10">';
          if(type == 3) {
            html += '<div id="field-list" class="well well-sm" style="height: 200px; overflow: auto;">';
            var i;
            for (i = 0; i < json.length; ++i) {
              html += '<div class="checkbox">';
              html += '<label>';
              html += '<input type="checkbox" name="item_list[]" value="' + json[i]['id'] + '" checked="checked"/> ' + json[i]['id'] + ' - <span class="item-status-' + json[i]['id'] + '"></span>' + json[i]['name'] + ' <a href="' + json[i]['link'] + '" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo $text_link ?></a></p>';
              html += '</label>';
              html += '</div>';
            }
            html += '</div>';
            html += '<a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);"><?php echo $text_unselect_all; ?></a></div>';

          } else {
            html += '<div id="field-list" class="well well-sm" style="height: 200px; overflow: auto;">';
            html += '<p>ID - Name</p>';
            var i;
            for (i = 0; i < json.length; ++i) {
              html += '<p>' + json[i]['id'] + ' - <span class="item-status-' + json[i]['id'] + '"></span>' + json[i]['name'] + ' <a href="' + json[i]['link'] + '" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo $text_link ?></a></p>';
            }
            html += '</div>';
            html += '</div>';
          }
          $('#select_filter_id option[value="3"]').removeAttr('disabled');
        } else {
          html += '<label class="col-sm-2 control-label" for="input-item_id"><span data-toggle="tooltip" data-html="true" title="<?php echo sprintf($help_disabled_list,$auto_translator_limit_item); ?>"><?php echo $entry_item_list; ?></span></label>';
          html += '<div class="col-sm-10">';
          html += '<div style="padding-top: 9px;"><span class="label label-warning"><?php echo $text_disabled; ?></span></div>';
          html += '</div>';
          $('#select_filter_id option[value="3"]').attr('disabled','disabled');
        }
        html += '</div>';

        html += '<div class="form-group" id="number-item">';
        html += '<label class="col-sm-2 control-label"><?php echo $entry_number_item; ?></label>';
        html += '<div class="col-sm-10">';
        html += '<div style="padding-top: 9px;"><span class="label label-info">' + json.length + '</span></div>';
        html += '</div>';
        html += '</div>';
        if(json.length != '0') {
          html += '<div class="form-group" id="btn-translate">';
          html += '<label class="col-sm-2 control-label"></label>';
          html += '<div class="col-sm-10">';
          html += '<a class="btn btn-success btn-translate" onclick="startTranslate($(this));" data-loading-text="<i class=\'fa fa-spinner fa-spin \'></i> <?php echo $text_translation; ?>"><i class="fa fa-play" aria-hidden="true"></i> <?php echo $button_start; ?></a>';
          html += '';
          html += '</div>';
          html += '</div>';
        }
        $('#tab-auto').append(html);
      }
    });
  }
  var loop_f;
  function startTranslate(e) {
    if($("select[name='filter_id']").val() == 3){
      item_list = $("input[name='item_list[]']:checked").map(function(){
        return {id: $(this).val()};
      });
    } else if($("select[name='filter_id']").val() == 2){
      item_list = [{id: $("input[name='item_id']").val()}];
    } else if($("select[name='filter_id']").val() == 1) {
      if ($("input[name='start_number']").val() && $("input[name='last_number']").val()) {
        item_list = item_list_reserve.slice(parseInt($("input[name='start_number']").val()) - 1, parseInt($("input[name='last_number']").val()));
      } else if ($("input[name='start_number']").val() == '' && $("input[name='last_number']").val()) {
        item_list = item_list_reserve.slice(0, parseInt($("input[name='last_number']").val()));
      } else if ($("input[name='start_number']").val() && $("input[name='last_number']").val() == '') {
        item_list = item_list_reserve.slice(parseInt($("input[name='start_number']").val()) - 1);
      }
    } else if($("select[name='filter_id']").val() == 4){
      item_list = [];
      if($("input[name='start_id']").val() && $("input[name='last_id']").val()){
        for(var id_i = 0; id_i < item_list_reserve.length; id_i++){
          if(item_list_reserve[id_i]['id'] >= parseInt($("input[name='start_id']").val()) && item_list_reserve[id_i]['id'] <= parseInt($("input[name='last_id']").val())) {
            item_list.push({id: item_list_reserve[id_i]['id']});
          }
        }
      } else if($("input[name='start_id']").val() == '' && $("input[name='last_id']").val()){
        for(var id_i = 0; id_i < item_list_reserve.length; id_i++){
          if(item_list_reserve[id_i]['id'] <= parseInt($("input[name='last_id']").val())) {
            item_list.push({id: item_list_reserve[id_i]['id']});
          }
        }
      } else if($("input[name='start_id']").val() && $("input[name='last_id']").val() == ''){
        for(var id_i = 0; id_i < item_list_reserve.length; id_i++){
          if(item_list_reserve[id_i]['id'] >= parseInt($("input[name='start_id']").val())) {
            item_list.push({id: item_list_reserve[id_i]['id']});
          }
        }
      }
    }

    $( "#change-item" ).remove();
    e.button('loading');
    loop_f = setInterval(ajaxTranslate, ($("input[name='field_list[]']:checked").length?$("input[name='field_list[]']:checked").length:1)*<?php echo $auto_translator_send_interval; ?>);
    $(".btn-translate").after(' <a class="btn btn-danger btn-stop" onclick="stopTranslate()"><i class="fa fa-stop" aria-hidden="true"></i> <?php echo $button_stop; ?></a>');
    $(".btn-translate").after(' <a class="btn btn-warning btn-pause" onclick="pauseTranslate()"><i class="fa fa-pause" aria-hidden="true"></i> <?php echo $button_pause; ?></a>');
    html = '<div class="form-group" id="change-item">';
    html += '<label class="col-sm-2 control-label"><?php echo $entry_change_item; ?></label>';
    html += '<div class="col-sm-10">';
    html += '<div style="padding-top: 9px;"><span class="label label-success change-item">' + change_id + '</span>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    $('#btn-translate').before(html);

  }
  function pauseTranslate() {
    clearInterval(loop_f);
    $(".btn-translate").button('reset');
    $(".btn-pause").remove();
    $(".btn-stop").remove();
  }
  function stopTranslate() {
    clearInterval(loop_f);
    loop_id = 0;
    change_id = 0;
    $(".btn-translate").button('reset');
    $(".btn-pause").remove();
    $(".btn-stop").remove();
  }

  function ajaxTranslate() {
    if(item_list.length){
      $.ajax({
        url: '<?php echo html_entity_decode($translate); ?>',
        type: 'post',
        async: false,
        data: $("#form-auto-translator").serialize() + "&item_id=" + item_list[loop_id]['id'] + "&iteration_id=" + loop_id + "&item_count=" + item_list.length,
        dataType: 'json',
        beforeSend: function () {
          $('.item-status-' + item_list[loop_id]['id']).html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
        },
        complete: function () {
        },
        success: function (json) {
          if (json.status) {
            change_id++;
            $('.change-item').text(change_id);
            $('.item-status-' + json.item_id).html('<i class="fa fa-check" style="color: green;" aria-hidden="true"></i>');
          } else {
            $('.item-status-' + json.item_id).html('<i class="fa fa-times" style="color: red;" aria-hidden="true"></i>');
          }
          if (item_list.length == loop_id+1) {
            clearInterval(loop_f);
            $(".btn-translate").button('reset');
            $(".btn-pause").remove();
            $(".btn-stop").remove();
            loop_id = 0;
            change_id = 0;
          } else {
            loop_id++;
          }
          if(json.error){
            loop_id = 0;
            change_id = 0;
            $('span[class^="item-status"]').html('');
            $('.change-item').after(' <span class="label label-danger">' + json.error + '</span>');
            clearInterval(loop_f);
            $(".btn-translate").button('reset');
            $(".btn-stop").remove();
            $(".btn-pause").remove();
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          clearInterval(loop_f);
          $(".btn-translate").button('reset');
          $(".btn-stop").remove();
          $(".btn-pause").remove();
          loop_id = 0;
          change_id = 0;
          $('.change-item').after(' <span class="label label-danger">' + xhr.status + ' ' + thrownError + '</span>');
        }
      });
    } else{
      $('.change-item').after(' <span class="label label-danger"><?php echo $error_item_list_count; ?></span>');
      clearInterval(loop_f);
      $(".btn-translate").button('reset');
      $(".btn-stop").remove();
      $(".btn-pause").remove();
      loop_id = 0;
      change_id = 0;
    }
  }

  //--></script>
<script type="text/javascript"><!--
  function getNotification() {
    $('#mod-notification').empty().html('<div id="mod-notification"><i class="fa fa-spinner"> <?php echo $text_load_message; ?></div>');
    setTimeout(
      function(){
        $.ajax({
          type: 'GET',
          url: '<?php echo html_entity_decode($notification); ?>',
          dataType: 'json',
          success: function(json) {
            if (json['error']) {
              $('#mod-notification').empty().html(json['error']+' <span style="cursor:pointer;float:right;" onclick="getNotifications();"><i class="fa fa-refresh"></i> <?php echo $text_retry; ?></span>');
            } else if (json['message']) {
              $('#mod-notification').html(json['message']);
            }
          },
          failure: function(){
            $('#mod-notification').html('<?php echo $error_notification; ?> <span style="cursor:pointer;float:right;" onclick="getNotifications();"><i class="fa fa-refresh"></i> <?php echo $text_retry; ?></span>');
          },
          error: function() {
            $('#mod-notification').html('<?php echo $error_notification; ?> <span style="cursor:pointer;float:right;" onclick="getNotifications();"><i class="fa fa-refresh"></i> <?php echo $text_retry; ?></span>');
          }
        });
      },
      500
    );
  }

  $(document).ready(function() {
    getNotification();
  });
  //--></script>
<script type="text/javascript"><!--
  $('#language a:first').tab('show');
  //--></script>
<style>
  li.active .tab-icon{
    color: #1E91CF;
  }
  .page-header h1 a{
    color: #CFCFCF;
  }
</style>
<?php echo $footer; ?>