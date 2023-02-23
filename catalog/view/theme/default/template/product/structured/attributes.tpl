<table class="table table-info table-responsive table-striped table-bordered">
	<tbody>	
		<?php if ($manufacturer) { ?>
		<tr>
			<td><?php echo $text_manufacturer; ?></td>
			<td><a href="<?php echo $manufacturers; ?>" title="<?php echo $manufacturer; ?>"><?php echo $manufacturer; ?></a></td>
		</tr>
		<?php } ?>

		<?php foreach ($attribute_groups as $attribute_group) { ?>
		<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
		<?php if ($attribute['text']) { ?>
		<tr>
			<td><?php echo $attribute['name']; ?></td>
			<td><?php echo $attribute['text']; ?></td>
		</tr>
		<?php } ?>
		<?php } ?>												
		<?php } ?>

		<?php if ($attribute_group['attribute_group_id'] == 8 && $gtin) { ?>
		<tr>
			<td>EAN</td>
			<td><?php echo $gtin; ?></td>
		</tr>
		<?php } ?>

		<?php if ($attribute_group['attribute_group_id'] == 8 && $atx_tree) { ?>
		<tr>
			<td>ATX</td>
			<td>
				<?php foreach ($atx_tree as $atx) { ?>
				<?php if ($atx['atx_code'] == $reg_atx_1) { ?>
				<b><?php echo $atx['atx_code']; ?></b>
				<?php } else { ?>
				<?php echo $atx['atx_code']; ?>
				<?php } ?>
				<a href="<?php echo $atx['href']?>" title="<?php echo $atx['name']; ?>"><?php echo $atx['name']; ?></a><br />
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>