<?php if (!$check_license) { ?>
	<?php if ($status != 307) { ?>
<legend><?php echo $text_license_request; ?></legend>
<div class="alert alert-info" role="alert"><?php echo $text_about_license; ?></div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="email"><span data-toggle="tooltip" title="<?php echo $help_email; ?>"><?php echo $entry_email; ?></span></label>
	<div class="col-sm-4">
		<input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="email" class="form-control" />
	</div>
	<label class="col-sm-2 control-label" for="domain"><span data-toggle="tooltip" title="<?php echo $help_domain; ?>"><?php echo $entry_domain; ?></span></label>
	<div class="col-sm-4">
		<textarea rows="1" name="domain" id="domain" class="form-control"><?php echo $domain; ?></textarea></p>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="market"><span data-toggle="tooltip" title="<?php echo $help_market; ?>"><?php echo $entry_market; ?></span></label>
	<div class="col-sm-4">
		<select name="market" id="market" class="form-control">
			<option value=""><?php echo $text_select; ?></option>
			<option value="opencartforum.com">opencartforum.com</option>
			<option value="liveopencart.ru">liveopencart.ru</option>
			<option value="oc-max.com">oc-max.com</option>
			<option value="prodelo.biz">prodelo.biz</option>
			<option value="shop.opencart-russia.ru">shop.opencart-russia.ru</option>
			<option value="opencart.com">opencart.com</option>
			<option value="devsaid.com">devsaid.com</option>
		</select>
	</div>
	<label class="col-sm-2 control-label" for="payment_id"><span data-toggle="tooltip" title="<?php echo $help_payment_id; ?>"><?php echo $entry_payment_id; ?></span></label>
	<div class="col-sm-4">
		<input type="text" name="check" value="" placeholder="<?php echo $entry_payment_id; ?>" id="payment_id" class="form-control" />
	</div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <a onclick="purchase('send');" id="send-purchase" data-toggle="tooltip" title="" class="btn btn-info btn-block col-sm-6" data-original-title="<?php echo $help_send; ?>"><i class="fa fa-envelope-o fa-2x"></i></a>
    </div>	
</div>
	<?php } ?>
<legend><?php echo $text_license; ?></legend>
<div class="form-group">
	<label class="col-sm-2 control-label" for="input-license"><span data-toggle="tooltip" title="<?php echo $help_license; ?>"><?php echo $entry_license; ?></span></label>
	<div class="col-sm-10">
		<div class="input-group">
			<input type="text" name="<?php echo $extension; ?>_license" value="<?php echo $license; ?>" placeholder="<?php echo $entry_license; ?>" id="input-license" class="form-control"/>
			<span class="input-group-btn">
				<a onclick="purchase('activate');" id="activate" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo $help_activate; ?>"><i class="fa fa-key"></i></a>
			</span>
		</div>
	</div>
</div>
<?php } else { ?>
<input type="hidden" name="<?php echo $extension; ?>_license" value="<?php echo $license; ?>" id="input-license" class="form-control" />
<?php } ?>
<legend><?php echo $text_contacts; ?></legend>
<p><?php echo $text_about_support; ?></p>
<ul style="list-style-type: none;">
	<li><i class="fa fa-skype text-primary"></i> <?php echo $text_support_skype; ?></li>
	<li><i class="fa fa-envelope" aria-hidden="true"></i>  <?php echo $text_support_email; ?></li>
	<li><i class="fa fa-link" aria-hidden="true"></i>  <a href="http://<?php echo $text_support_site; ?>" target="_blank"><?php echo $text_support_site; ?></a></li>
</ul>
<script type="text/javascript"><!--
function purchase(action) {
	switch(action) {
		case 'send':
			sUrl = 'email=' + encodeURIComponent($('#email').val()) + '&domain=' + encodeURIComponent($('#domain').val()) +'&market=' + encodeURIComponent($('#market').val()) +'&payment_id=' + encodeURIComponent($('#payment_id').val());
			break;

		case 'activate':
			sUrl = 'license=' + $('#input-license').val();
			break;
	}

	$.ajax( {
		url: '<?php echo $action; ?>&action=' + action + '&token=<?php echo $token; ?>&' + sUrl,
		dataType: 'json',
		beforeSend: function () {
			$('.alert').remove();
			$('body').fadeTo('fast', 0.7).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
		},
		complete: function () {
			$('body').fadeTo('fast', 1)
			$('#ocmax-loader').remove();
		},
		success: function (json) {
			if (json['error']) {
				$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			$('html, body').animate({ scrollTop: 0 }, 'slow');

			if (json['redirect']) {
				setTimeout(function() { location.reload() }, 1000);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}
	} );
}
//--></script>