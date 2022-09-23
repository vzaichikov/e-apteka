<?php
if ($modules) :
?>
<aside class="col-md-3 col-sm-3  col-xs-12 content-aside right_column">
	<span id="remove-sidebar" class="fa fa-times"></span>
	<?php foreach ($modules as $module) { ?>
		<?php echo $module; ?>
	<?php } ?>
</aside>
<?php endif; ?>
