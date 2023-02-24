	<table class="table table-info table-responsive table-striped table-bordered">
		<?php if (!empty($likreestr)) { ?>										
		<?php foreach ($likreestr as $key => $value) {  ?>	
		<?php if ($value) { ?>										
		<tr>
			<td>
				<?php echo $key; ?>
			</td>
			<td>
				<?php echo $value; ?>
			</td>
		</tr>											
		<?php } ?>	
		<?php } ?>										
		<?php } ?>
	</table>