<?php if ($type == 'inline') { ?>
	<?php echo $instruction; ?>
<? } ?>


<?php if ($type == 'embed') { ?>
	
	<?php if ($extension == 'pdf') { ?>
		<embed src="<?php echo $instruction; ?>" width="100%" height="800px" type='application/pdf'>
	<? } ?>


<?php } ?>