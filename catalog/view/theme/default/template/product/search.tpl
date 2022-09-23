<?php echo $header; ?>

<?php include(DIR_TEMPLATEINCLUDE . 'structured/breadcrumbs.tpl'); ?>

	<style>
		.subcategory-intersection{
			padding: 7px;
			margin: 5px;
			border: 1px solid #e4e4e4;
			border-radius: 5px;
			display: inline-block;
			float: left;
			word-wrap: none;
		}

		.subcategory-intersection.active{
			color: #FFF;
			background-color: #23a1d1;
		}
		.subcategory-intersection.active .badge.badge-primary{
			background-color: #FFF;
			color:  #23a1d1;
		}
	</style>


<div class="container">
	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
			<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
			<?php $class = 'col-xlg-10 col-md-9'; ?>
			<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
			<h1 class="product-manufacturer__title cat-header"><?php echo $heading_title; ?></h1>
			
			<?php if ($products || $top_found_cmas || $intersections) { ?>
				<?php include(DIR_TEMPLATEINCLUDE . 'structured/search_categories_list.tpl'); ?>
				<?php include(DIR_TEMPLATEINCLUDE . 'structured/intersections_list.tpl');  ?>	

				<?php if ($products) { ?>
					<?php include(DIR_TEMPLATEINCLUDE . 'structured/view_sort_limit.tpl'); ?>
				<?php } ?>
							
				<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_list.tpl'); ?>
				
				<?php include(DIR_TEMPLATEINCLUDE . 'structured/pagination.tpl'); ?>
				
				<?php } else { ?>
				<p><?php echo $text_empty; ?></p>
				<div class="buttons">
					<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
				</div>
			<?php } ?>
		<?php echo $content_bottom; ?></div>
	<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>