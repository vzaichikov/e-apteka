<?php echo $header; ?>

<?php include(DIR_TEMPLATEINCLUDE . 'structured/breadcrumbs.tpl'); ?>

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
			<h1 class="collection-title cat-header"><?php echo $heading_title; ?></h1>
			
			<?php if ($banner) { ?>
				<div class="row">
					<div class="col-xs-12">
						<img class="collection-banner image-responsive" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" src="<?php echo $banner; ?>" />
					</div>
				</div>
			<?php } ?>
			
			
			<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/collection_list.tpl'); ?>		
		</div>
		
		<?php echo $column_right; ?>
		</div>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>