<div data-type="title" class="hide"><?php echo $title; ?></div>
<?php foreach( $languages as $language_id => $language ) { ?>
	<?php echo $language; ?>:<br />
	<textarea class="form-control" name="languages[<?php echo $language_id; ?>]"><?php echo isset( $values[$language_id] ) ? $values[$language_id] : ''; ?></textarea><br />
<?php } ?>
