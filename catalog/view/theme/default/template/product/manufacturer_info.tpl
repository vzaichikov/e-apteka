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
		<div id="content" class="<?php echo $class; ?>">
			<?php echo $content_top; ?>
			 <?php if ($hb_snippets_bc_enable == '1'){ ?>
			<?php 
				$count_breadcrumb = 0; 
				$bc = '';
				foreach ($breadcrumbs as $breadcrumb) { 
				$count_breadcrumb = $count_breadcrumb + 1; 
				$bc .= '{
    "@type": "ListItem",
    "position": '.$count_breadcrumb.',
    "item": {
      "@id": "'.$breadcrumb['href'].'",
      "name": "'.$breadcrumb['text'].'"
    }},';
	}
	$bc = str_replace('<i class="fa fa-home"></i>','Home',$bc);
	$bc = rtrim($bc,',');
	?>
			<script type="application/ld+json">
			{
		  "@context": "http://schema.org",
		  "@type": "BreadcrumbList",
		  "itemListElement": [<?php echo $bc; ?>]}
		  </script>
		  <?php } ?>
		
			<h1 class="product-manufacturer__title cat-header"><?php echo $heading_title; ?></h1>
			
			<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/collection_list.tpl'); ?>
			
			<?php if ($products) { ?>
				<?php include(DIR_TEMPLATEINCLUDE . 'structured/view_sort_limit.tpl'); ?>
				
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