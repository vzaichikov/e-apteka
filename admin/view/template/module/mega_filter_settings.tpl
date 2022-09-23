<?php require DIR_TEMPLATE . 'module/' . $_name . '-header.tpl'; ?>

<br />

<?php
	
		$_configurationName = $_name . '_settings';
		$_configurationValues = $settings;
		$_configurationMain = true;
		
		require DIR_TEMPLATE . 'module/' . $_name . '-configuration.tpl';
	
	?>

<?php require DIR_TEMPLATE . 'module/' . $_name . '-footer.tpl'; ?>