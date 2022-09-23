<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-ocfilter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
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
    <div class="panel panel-default">
      <div class="panel-body">
	      <form id="form-ocfilter" action="<?php echo $action; ?>" method="post">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-other" data-toggle="tab"><?php echo $tab_other; ?></a></li>
            <li><a href="#tab-values" data-toggle="tab"><?php echo $tab_values; ?></a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
		          <table class="form">
		            <tr>
		              <td><?php echo $entry_name; ?></td>
		              <td>
		                <?php foreach ($languages as $language) { ?>
		                <input type="text" name="ocfilter_option_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo (isset($name[$language['language_id']]) ? $name[$language['language_id']]['name'] : ''); ?>" size="50" />&nbsp;<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><br />
		                <?php } ?>
		              </td>
		            </tr>
		            <tr>
		              <td>URL псевдоним:</td>
		              <td>
		                <input type="text" name="keyword" value="<?php echo $keyword; ?>" size="50" />
		              </td>
		            </tr>
		            <tr>
		              <td><?php echo $entry_category; ?></td>
		              <td>
                    <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                    <div id="option-category" class="well well-sm" style="height: 150px; overflow: auto;">
                      <?php foreach ($option_categories as $category_id => $_name) { ?>
                      <div id="option-category<?php echo $category_id; ?>"><i class="fa fa-minus-circle"></i> <?php echo $_name; ?>
                        <input type="hidden" name="category_id[<?php echo $category_id; ?>]" value="<?php echo $_name; ?>" />
                      </div>
                      <?php } ?>
                    </div>
		              </td>
		            </tr>
		            <tr>
		              <td><?php echo $entry_type; ?></td>
		              <td>
		                <select name="type" class="with-subfield" data-subfield="type">
		                  <?php foreach ($types as $key => $value) { ?>
		                  <?php if ($type == $key) { ?>
		                  <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
		                  <?php } else { ?>
		                  <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
		                  <?php } ?>
		                  <?php } ?>
		                </select>
										<div class="subfield type sf-checkbox sf-radio<?php echo (($type == 'checkbox' || $type == 'radio') ? ' visible' : ''); ?>">
		                	<label><span><?php echo $entry_selectbox; ?></span><input type="checkbox" name="selectbox" value="1"<?php echo ($selectbox ? ' checked="checked"' : ''); ?> /></label>
										</div>
										<div class="subfield type sf-checkbox sf-radio<?php echo (($type == 'checkbox' || $type == 'radio') ? ' visible' : ''); ?>">
		                	<label><span><?php echo $entry_is_color; ?></span><input type="checkbox" name="color" value="1"<?php echo ($color ? ' checked="checked"' : ''); ?> /></label>
										</div>
										<div class="subfield type sf-checkbox sf-radio<?php echo (($type == 'checkbox' || $type == 'radio') ? ' visible' : ''); ?>">
		                	<label><span><?php echo $entry_is_image; ?></span><input type="checkbox" name="image" value="1"<?php echo ($image ? ' checked="checked"' : ''); ?> /></label>
										</div>
		              </td>
		            </tr>
		            <tr>
		              <td><?php echo $entry_sort_order; ?></td>
		              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" /></td>
		            </tr>
		            <tr>
		              <td><?php echo $entry_status; ?></td>
		              <td>
		                <?php if ($status) { ?>
										<input type="checkbox" name="status" checked="checked" value="1" />
		                <?php } else { ?>
										<input type="checkbox" name="status" value="1" />
		                <?php } ?>
		              </td>
		            </tr>
		          </table>
		        </div>
		        <div id="tab-other" class="tab-pane">
		          <table class="form">
		            <tr>
		              <td><?php echo $entry_postfix; ?></td>
		              <td>
		                <?php foreach ($languages as $language) { ?>
		                <input type="text" name="ocfilter_option_description[<?php echo $language['language_id']; ?>][postfix]" value="<?php echo (isset($name[$language['language_id']]) ? $name[$language['language_id']]['postfix'] : ''); ?>" size="10" />&nbsp;<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><br />
		                <?php } ?>
		              </td>
		            </tr>
		            <tr>
		              <td><?php echo $entry_description; ?></td>
		              <td>
		                <?php foreach ($languages as $language) { ?>
		                <textarea name="ocfilter_option_description[<?php echo $language['language_id']; ?>][description]" rows="3" cols="50" style="resize: none;"><?php echo (isset($name[$language['language_id']]) ? $name[$language['language_id']]['description'] : ''); ?></textarea>&nbsp;<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><br />
		                <?php } ?>
		              </td>
		            </tr>
		            <tr>
		              <td><?php echo $entry_store; ?></td>
		              <td>
		                <div class="scrollbox">
		                  <?php $class = 'even'; ?>
		                  <div class="<?php echo $class; ?>">
		                    <?php if (in_array(0, $option_store)) { ?>
		                    <input type="checkbox" name="option_store[]" value="0" checked="checked" />
		                    <?php echo $text_default; ?>
		                    <?php } else { ?>
		                    <input type="checkbox" name="option_store[]" value="0" />
		                    <?php echo $text_default; ?>
		                    <?php } ?>
		                  </div>
		                  <?php foreach ($stores as $store) { ?>
		                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
		                  <div class="<?php echo $class; ?>">
		                    <?php if (in_array($store['store_id'], $option_store)) { ?>
		                    <input type="checkbox" name="option_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
		                    <?php echo $store['name']; ?>
		                    <?php } else { ?>
		                    <input type="checkbox" name="option_store[]" value="<?php echo $store['store_id']; ?>" />
		                    <?php echo $store['name']; ?>
		                    <?php } ?>
		                  </div>
		                  <?php } ?>
		                </div>
		              </td>
		            </tr>
		          </table>
		        </div>
		        <div id="tab-values" class="tab-pane">
		          <div class="header"><a onclick="ocfilter.form.addValue();" class="btn btn-primary"><?php echo $text_add_value; ?></a></div>
		          <ul id="sortable">
		            <?php foreach ($ocfilter_option_values as $key => $value) { ?>
		            <li>
		              <a class="delete" onclick="ocfilter.form.deleteValue($(this));">Delete</a>
		              <div class="fields">
		              	<input type="hidden" name="ocfilter_option_value[update][<?php echo $value['value_id']; ?>][image]" value="<?php echo $value['image']; ?>" id="value-image-<?php echo $key; ?>" />
		                <input type="hidden" name="ocfilter_option_value[update][<?php echo $value['value_id']; ?>][color]" value="<?php echo $value['color']; ?>" />
		              	<input type="number" name="ocfilter_option_value[update][<?php echo $value['value_id']; ?>][sort_order]" value="<?php echo $value['sort_order']; ?>" />
		                <?php foreach ($languages as $language) { ?>
		                <label><input type="text" class="value-name" name="ocfilter_option_value[update][<?php echo $value['value_id']; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo (isset($value['language'][$language['language_id']]) ? $value['language'][$language['language_id']]['name'] : ''); ?>" size="80" />&nbsp;<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></label>
		                <?php } ?>
		              </div>
									<a href="#" class="color-handler<?php echo ($color ? ' visible' : ''); ?>" title="<?php echo $text_select_color; ?>"<?php echo ($value['color'] ? ' style="background: #' . $value['color'] . ';"' : ''); ?>></a>
									<a href="#" class="image-handler<?php echo ($image ? ' visible' : '') . ($value['image'] ? ' inserted' : ''); ?>" title="<?php echo $text_browse_image; ?>" id="value-image-thumb-<?php echo $key; ?>"><img src="<?php echo $value['thumb']; ?>" alt="" /><i class="fa fa-fw fa-picture-o"></i></a>
		            </li>
		            <?php } ?>
		          </ul>
		          <div class="bottom"><a onclick="ocfilter.form.addValue();" class="btn btn-primary"><?php echo $text_add_value; ?></a></div>
						</div>
	        </div>
      	</form>
			</div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--

$(function() {
  $('.with-subfield').trigger('change');

  // Category
  $('input[name=\'category\']').autocomplete({
  	'source': function(request, response) {
  		$.ajax({
  			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
  			dataType: 'json',
  			success: function(json) {
  				response($.map(json, function(item) {
  					return {
  						label: item['name'],
  						value: item['category_id']
  					}
  				}));
  			}
  		});
  	},
  	'select': function(item) {
  		$('#option-category' + item['value']).remove();

  		$('#option-category').append('<div id="option-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_id[' + item['value'] + ']" value="' + item['label'] + '" /></div>');

  		$('input[name=\'category\']').val('');
  	}
  });

  $('#option-category').delegate('.fa-minus-circle', 'click', function() {
  	$(this).parent().remove();
  });
});

ocfilter.php.color = <?php echo $color; ?>;
ocfilter.php.image = <?php echo $image; ?>;
ocfilter.php.no_image = '<?php echo $no_image; ?>';

ocfilter.php.text_image_manager = '<?php echo $text_image_manager; ?>';
ocfilter.php.text_select_color = '<?php echo $text_select_color; ?>';
ocfilter.php.text_browse_image = '<?php echo $text_browse_image; ?>';

ocfilter.php.languages = [];

<?php foreach ($languages as $language) { ?>
ocfilter.php.languages.push({
	'language_id': <?php echo $language['language_id']; ?>,
	'name': '<?php echo $language['name']; ?>',
  'code': '<?php echo $language['code']; ?>'
});
<?php } ?>
//--></script>
<?php echo $footer; ?>