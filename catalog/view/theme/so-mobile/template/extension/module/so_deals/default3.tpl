<script>
//<![CDATA[
	var listdeal<?php echo $module;?> = [];
//]]>
</script>
<div class="module <?php echo $direction_class?> <?php echo $class_suffix; ?>">
    <?php if($disp_title_module) { ?>
		<h3 class="modtitle"><span><?php echo $head_name; ?></span></h3>
	<?php } ?>
	<?php if($pre_text != '')
		{
	?>
		<div class="form-group">
			<?php echo html_entity_decode($pre_text);?>
		</div>
	<?php
		}
	?>
	<div class="modcontent">
		<?php if (isset($list) && !empty($list))
    {
    $tag_id = 'so_deals_' . rand() . time();
    $class_respl = 'preset00-'.$nb_column0.' preset01-'.$nb_column1.' preset02-'.$nb_column2.' preset03-'.$nb_column3.' preset04-'.$nb_column4;
    $i = 0;
    $count_item = count($list);
    ?>
    <?php 
		switch($include_js){
			case 'owlCarousel':
				include($store_layout."_carousel.tpl");
			break;
			case 'slick':
				include($store_layout."_slick.tpl");
			break;
		}	
	?>

    <?php
    }else{
     echo $objlang->get('text_noitem');
    }
    ?>

	</div><!--/.modcontent-->
	<?php if($post_text != '')
	{
	?>
		<div class="form-group">
			<?php echo html_entity_decode($post_text);?>
		</div>
	<?php
	}
	?>
</div>
