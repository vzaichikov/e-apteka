<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-special-setting" data-toggle="tooltip"
				title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>
				</button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
				class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
					<?php if(!$check) { ?>
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
						id="form-special-setting" class="form-horizontal">
						<div class="form-group required">
							<label class="col-sm-4 control-label"><?php echo $entry_thumb; ?></label>
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-4">
										<input name="special_setting[special_thumb_width]" type="text"
										id="input-special-thumb-width" class="form-control" placeholder="<?php echo $entry_width; ?>" value="<?php echo $special_thumb_width; ?>" />
									</div>
									<div class="col-sm-4">
										<input name="special_setting[special_thumb_height]" type="text"
										id="input-special-thumb-height" class="form-control" placeholder="<?php echo $entry_height; ?>" value="<?php echo $special_thumb_height; ?>" />
									</div>
								</div>
								<?php if ($error_thumb) { ?>
								<div class="text-danger"><?php echo $error_thumb; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-4 control-label"><?php echo $entry_popup; ?></label>
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-4">
										<input name="special_setting[special_popup_width]" type="text"
										id="input-special-popup-width" class="form-control" placeholder="<?php echo $entry_width; ?>" value="<?php echo $special_popup_width; ?>" />
									</div>
									<div class="col-sm-4">
										<input name="special_setting[special_popup_height]" type="text"
										id="input-special-popup-height" class="form-control" placeholder="<?php echo $entry_height; ?>" value="<?php echo $special_popup_height; ?>" />
									</div>
								</div>
								<?php if ($error_popup) { ?>
								<div class="text-danger"><?php echo $error_popup; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-4 control-label"><?php echo $entry_limit; ?></label>
							<div class="col-sm-8">
								<div class="row">
							<div class="col-sm-4">
								<input name="special_setting[description_limit]" type="text"
								id="input-description-limit" class="form-control" value="<?php echo $description_limit; ?>" />
							</div>
								</div>
								<?php if ($error_limit) { ?>
								<div class="text-danger"><?php echo $error_limit; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="input-special-share"><?php echo $entry_share; ?></label>
							<div class="col-sm-4">
								<select name="special_setting[special_share]" id="input-special-share" class="form-control">
									<?php if ($special_share) { ?>
									<option value="1" selected="selected"><?php echo $text_yes; ?></option>
									<option value="0"><?php echo $text_no; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_yes; ?></option>
									<option value="0" selected="selected"><?php echo $text_no; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label"><?php echo $entry_special_keyword; ?></label>
							<div class="col-sm-8">
								<div class="row">
							<div class="col-sm-4">
								<input name="special_keyword" type="text" id="input-special-keyword" class="form-control" value="<?php echo $special_keyword; ?>" />
							</div>
								</div>
							</div>
						</div>
					</form>
					<?php }else{ ?>
					<div class="col-sm-12 text-center">
						<button type="button" id="button_install" class="btn btn-warning btn-lg"><i class="fa fa-arrow-up"></i> <?php echo $button_install; ?></button>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).delegate('#button_install', 'click', function() {
			$.ajax({
				url: 'index.php?route=catalog/ochelp_special/install&token=<?php echo $token; ?>',
				type: 'post',
				dataType: 'json',
				beforeSend: function() {
					$('#button_install').button('loading');
				},
				complete: function() {
					$('#button_install').button('reset');
				},
				success: function(json) {
					$('.alert').remove();

					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
					}

					if (json['success']) {
		                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                        $('.alert').delay('2500').fadeOut('300', function() {
                    		location = json['redirect'];
                		});

					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
	</script>
<?php echo $footer; ?>