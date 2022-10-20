<?php 
	
	function getIMCAValue($lang_settings, $lang_id, $name)
	{
		$result = '';
		if (isset($lang_settings[$lang_id])) {
			$result = $lang_settings[$lang_id][$name];
		}
		else {
			$result = $lang_settings['default'][$name];
		}
		
		return $result;
	}
	
	function echoText($lang_settings, $lang_id, $name) {
		echo getIMCAValue($lang_settings, $lang_id, $name);
	}
	
	function echoTextAfter($lang_settings, $lang_id, $name) {
		$result = getIMCAValue($lang_settings, $lang_id, $name);
		$is_after_inc = getIMCAValue($lang_settings, $lang_id, $name . '_inc');
		
		if(trim($result) == '' || ('' . $is_after_inc == '0')) 
		return;
		
		echo '<div class="form-group">'
		. '<div class="col-sm-12">'
		. $result
		. '</div>'
		. '</div>'
		;
	}
	
	function getClassReq($lang_settings,  $lang_id, $name) {
		$result = getIMCAValue($lang_settings, $lang_id, $name);
		
		return (('' . $result) == '1' ? 'required' : '' );
	}
	
	function isInc($lang_settings,  $lang_id, $name) {
		$result = getIMCAValue($lang_settings, $lang_id, $name);
		
		return ('' . $result) == '1';
	}
	
	
	function echoField($lang_settings, $lang_id, $name) {
		if (isInc($lang_settings, $lang_id, $name . '_inc')) {
			echo '<div class="form-group ' . getClassReq($lang_settings, $lang_id, $name . '_req') . '">'
			. '<div class="col-sm-12 phone_wrap">'
			. '<span class="input-group-addon"><i class="fa fa-fw fa-phone-square" aria-hidden="true"></i></span>'
			. '<input type="text" name="' . $name . '" value="" ' 
			. ' placeholder="' 
			. getIMCAValue($lang_settings, $lang_id, $name . '_ph')
			.  '" class="form-control" />'
			. '</div>'
			. '</div>'
			;
			echoTextAfter($lang_settings, $lang_id, $name . '_after');
		}
	}
	
	
	function echoFieldArea($lang_settings, $lang_id, $name) {
		if (isInc($lang_settings, $lang_id, $name . '_inc')) {
			echo '<div class="form-group ' . getClassReq($lang_settings, $lang_id, $name . '_req') . '">'
			. '<div class="col-sm-12">'
			. '<textarea name="' . $name . '" rows="5" ' 
			. ' placeholder="' 
			. getIMCAValue($lang_settings, $lang_id, $name . '_ph')
			.  '" class="form-control" ></textarea>'
			. '</div>'
			. '</div>'
			;
			echoTextAfter($lang_settings, $lang_id, $name . '_after');
		}
	}
?>

<div class="modal fade" id="imcallask-form-container-popup" data-remote="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
				</button>
                <h2 class="modal-title text-center" id="exampleModalLabel">
                	<?php echoText($lang_settings, $language_id, 'header'); ?>
				</h2>
			</div>
			
            <div class="modal-body text-center">
                <form class="form-horizontal" method="post" action="index.php?route=extension/module/IMCallMeAskMe/sendMessage">
                	<!-- After Header -->
                	<?php echoTextAfter($lang_settings, $language_id, 'header_after'); ?>
                	
                	<!-- Name field  ---->
                	<?php echoField($lang_settings, $language_id, 'name'); ?>
					
                	<!-- Email field  -->
                	<?php echoField($lang_settings, $language_id, 'email'); ?>
					
                	<!-- Tel field  -->
                	<?php echoField($lang_settings, $language_id, 'tel'); ?>
					
                	<!-- Text field  -->
                	<?php echoFieldArea($lang_settings, $language_id, 'text'); ?>
					
					<input type="hidden" name="token" value="<?php echo $token; ?>" />
					
                    <div class="form-group">
						<div class="buttons col-sm-12 text-center">
                        	<button type="submit" class="bbtn bbtn-primary product-layout__btn-cart" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                        		<?php echoText($lang_settings, $language_id, 'btn_ok'); ?>
							</button>                        	
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$("input[name='tel']").inputmask("+38(099)999-99-99")
	});
</script>