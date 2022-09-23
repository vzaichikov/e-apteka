<?php require DIR_TEMPLATE . 'module/' . $_name . '-header.tpl'; ?>

<br /><br />
<center>
	<font style="font-weight:300; font-size: 30px;">Thank you for choosing</font> <font style="font-weight:400; font-size: 30px;">Mega Filter PRO</font>
</center>
<br />
<hr />

<table style="margin: 0 auto;">
	<tbody>
		<?php if ( ! empty( $_error_warning2 ) ) { ?>
		<tr><td><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $_error_warning2; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div></td></tr>
		<?php } ?>
		<?php if( ! empty( $files ) ) { ?>
			<tr>
				<td class="text-center">
					Make sure that these files exist and that has permissions to write to them:<br /><br />
					<pre class="text-left"><?php echo implode( '<br />', $files ); ?></pre>
					<br />
					
					<a href="<?php echo $action; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> Check permissions again</a>
					<br />
					<br />
					<br />
					
					<font style="font-weight:300; font-size: 20px;">How to change the file permissions ?</font>
					<br />
					<br />

					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/permissions.jpg" style="max-width: 100%; border: 1px solid #ccc; padding: 5px;" />
					
				</td>
			</tr>
		<?php } else { ?>
			<tr>
				<td class="text-center">
					To complete installation, please enter the following data:
					<table style="margin: 20px auto;">
						<tr>
							<td class="text-right" style="padding: 14px 5px 0 0; vertical-align: top; font-weight: bold;">
								Order ID:
							</td>
							<td class="text-left" style="padding: 5px;">
								<input type="text" name="order_id" value="<?php echo empty( $_POST['order_id'] ) ? '' : $_POST['order_id']; ?>" class="form-control" style="width: 150px; " />
							</td>
						</tr>
						<tr>
							<td class="text-right" style="padding: 14px 5px 0 0; vertical-align: top; font-weight: bold;">
								OpenCart e-mail:
							</td>
							<td class="text-left" style="padding: 5px;">
								<input type="text" value="<?php echo empty( $_POST['oc_email'] ) ? '' : $_POST['oc_email']; ?>" name="oc_email" class="form-control" style="width: 310px;" />
								<div class="help-block">E-mail address that you are use on OpenCart.com</div>
							</td>
						</tr>
					</table>
					<button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Confirm</button>
				</td>
			</tr>
			<tr>
				<td>
					<br />
					<br />
					<font style="font-weight:300; font-size: 20px;">Where I can find my Order ID ?</font>
					<br />
					<br />

					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/order_id.jpg" style="max-width: 100%; border: 1px solid #ccc; padding: 2px;" />

					<br />
					<br />

					Please go to OpenCart store (<a href="https://www.opencart.com/index.php?route=account/order" target="_blank">click here</a>) &rightarrow; Account &rightarrow; Orders History (1) &rightarrow; and copy Order ID of MFP (2)
				</td>
			</tr>
		<?php } ?>
		<tr>
			<td class="text-center">
				<br />
				<br />
				<br />
				<font style="font-weight:300; font-size: 20px;">Problems with the installation?</font>
				<br />
				<br />
				
				If you don't know how to finish installation of MFP please contact us: <a href="mailto:info@ocdemo.eu">info@ocdemo.eu</a><br />
				(don't forget to include your Order ID and FTP data)
			</td>
		</tr>
	</tbody>
</table>
<br /><br />
<?php require DIR_TEMPLATE . 'module/' . $_name . '-footer.tpl'; ?>