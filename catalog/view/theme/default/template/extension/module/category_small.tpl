<? if ($categories) { ?>
	<style>
		.label-margined{
			font-size:14px;
			margin-left:5px;
			margin-bottom: 5px;
			display: inline-block;
		}
	</style>


	<div class="module box-with-categories">
		<div class="mod-content box-category">
			<?php $i = 0; foreach ($categories as $category) { $i++; ?>
				<?php if ($category['category_id'] == $category_id) { ?>
							<a href="<?php echo $category['href']; ?>" class="active"><span class="label label-info label-margined"><?php echo $category['name']; ?></span></a>
						<?php } else { ?>
							<a href="<?php echo $category['href']; ?>"><span class="label label-info label-margined"><?php echo $category['name']; ?></span></a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
<? } ?>
