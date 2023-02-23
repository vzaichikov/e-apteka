<div class="table">
<table class="table-striped table-bordered">
	<?php if (!empty($likreestr)) { ?>										
		<?php foreach ($likreestr as $key => $value) {  ?>											
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
</table>
</div>