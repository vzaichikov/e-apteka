<table class="table">
 <tr>
    <td class="col-xs-3">
    	<h5><span class="required">* </span><strong><?php echo $entry_code; ?></strong></h5>    
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $entry_code_help; ?></span></td>
    <td class="col-xs-9">
        <div class="col-xs-4">
        <select id="Checker" name="alsoviewed[Enabled]" class="form-control">
            <option value="yes" <?php echo (!empty($data['alsoviewed']['Enabled']) && $data['alsoviewed']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
           <option value="no" <?php echo (empty($data['alsoviewed']['Enabled']) || $data['alsoviewed']['Enabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
        </select>
        </div>
   </td>
  </tr>
  <tr>
    <td class="col-xs-3">
        <h5><strong><?php echo $text_image_dimensions; ?></strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $text_image_dimensions_help; ?></span>
    </td>
    <td class="col-xs-9">
        <div class="col-xs-4">
            <div class="input-group">
              <span class="input-group-addon">Width:&nbsp;</span>
              <input type="text" class="form-control" name="alsoviewed[PictureWidth]" value="<?php echo (isset($data['alsoviewed']['PictureWidth'])) ? $data['alsoviewed']['PictureWidth'] : '80' ?>" />
              <span class="input-group-addon"><?php echo $text_pixels; ?></span>
            </div><br />
            <div class="input-group">
              <span class="input-group-addon">Height:</span>
              <input type="text" class="form-control" name="alsoviewed[PictureHeight]" value="<?php echo (isset($data['alsoviewed']['PictureHeight'])) ? $data['alsoviewed']['PictureHeight'] : '80' ?>" />
              <span class="input-group-addon"><?php echo $text_pixels; ?></span>
            </div>
        </div>
    </td>
    </tr>
    <tr>
        <td class="col-xs-3">
        	<h5><strong><?php echo $text_products; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $text_products_help; ?></span></td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="input-group">
                  	<input type="text" class="form-control" name="alsoviewed[NumberOfProducts]" value="<?php echo (isset($data['alsoviewed']['NumberOfProducts'])) ? $data['alsoviewed']['NumberOfProducts'] : '5' ?>" />
					<span class="input-group-addon"><?php echo $text_products_small; ?></span>
                </div>
            </div>
        </td>
    </tr>
  <tr>
     <td class="col-xs-3">
        <h5><strong><?php echo $custom_css; ?></strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $custom_css_help; ?></span></td>
     <td class="col-xs-9">
    	<div class="col-xs-4">
        	<textarea name="alsoviewed[CustomCSS]" class="form-control AlsoViewedCustomCSS"><?php echo (isset($data['alsoviewed']['CustomCSS'])) ? $data['alsoviewed']['CustomCSS'] : '' ?></textarea>
        </div>
    </td>
    </tr>
</table>
<script type="text/javascript">
var toggleCSScheckbox = function() {
	$('input[type=checkbox][id^=buttonPosCheckbox]').each(function(index, element) {
		if ($(this).is(':checked')) {
			$($(this).attr('data-textinput')).removeAttr('disabled');
		} else {
			$($(this).attr('data-textinput')).attr('disabled','disabled');
		}
	});
}
var createBinds = function() {
	$('input[type=checkbox][id^=buttonPosCheckbox]').unbind('change').bind('change', function() {
		toggleCSScheckbox();
	});
	
	$('.buttonPositionOptionBox').unbind('change').bind('çhange', function() {
		$($(this).attr('data-checkbox')).removeAttr('checked');
		toggleCSScheckbox();
	});
};
toggleCSScheckbox();
createBinds();
</script>
     </td>
  </tr>
</table>
<script>
$('.AlsoViewedLayout input[type=checkbox]').change(function() {
    if ($(this).is(':checked')) { 
        $('.AlsoViewedItemStatusField', $(this).parent()).val(1);
    } else {
        $('.AlsoViewedItemStatusField', $(this).parent()).val(0);
    }
});
$('.AlsoViewedEnabled').change(function() {
    toggleAlsoViewedActive(true);
});
var toggleAlsoViewedActive = function(animated) {
   if ($('.AlsoViewedEnabled').val() == 'yes') {
        if (animated) 
            $('.AlsoViewedActiveTR').fadeIn();
        else 
            $('.AlsoViewedActiveTR').show();
    } else {
        if (animated) 
            $('.AlsoViewedsActiveTR').fadeOut();
        else 
            $('.AlsoViewedActiveTR').hide();
    }
}
toggleAlsoViewedActive(false);
</script>
<script>
$(function() {
    var $typeSelector = $('#Checker');
	var $toggleArea2 = $('#mainSettingsTab');
	 if ($typeSelector.val() === 'yes') {
			$toggleArea2.show();
        }
        else {
			$toggleArea2.hide();
        }
    $typeSelector.change(function(){
        if ($typeSelector.val() === 'yes') {
			$toggleArea2.show(300);
        }
        else {
			$toggleArea2.hide(300);
        }
    });
});
</script>