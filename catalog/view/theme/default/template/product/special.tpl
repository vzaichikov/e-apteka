<?php echo $header; ?>

<?php include(DIR_TEMPLATEINCLUDE . 'structured/breadcrumbs.tpl'); ?>

<div class="container">
	
	<h1 id="xml_search_category_name" class="category-title"><?php echo $heading_title; ?></h1>
	
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
		
			
			<?php if ($products) { ?>
				<?php include(DIR_TEMPLATEINCLUDE . 'structured/view_sort_limit.tpl'); ?>
				
				<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_list.tpl'); ?>
				
				<style>
					a.load_more {
					<?php if (isset($loadmore_style)) { echo $loadmore_style; } else { ?>
						display:inline-block; margin:0 auto 20px auto; padding: 0.7em 2em; text-decoration:none; font-size: 16px;
					<?php } ?>
					}
				</style>
				<div id="load_more" style="display:none;">
					<div class="text-center">
						<a href="javascript:;" class="load_more bbtn bbtn-primary"><?php echo $loadmore_button; ?></a>
					</div>
				</div>
				<?php if ($loadmore_arrow_status) { ?>
					<a id="arrow_top" style="display:none;" onclick="scroll_to_top();"><svg class="arrow_top__icon">
						<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#chevron-up"></use>
					</svg></a>
				<?php } ?>
				
				<?php include(DIR_TEMPLATEINCLUDE . 'structured/pagination.tpl'); ?>
				
			<?php } ?>
			<?php if (!$show_subcats && !$categories && !$products) { ?>
				<p><?php echo $text_empty; ?></p>
				<div class="buttons">
					<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
				</div>
			<?php } ?>
			
			<?php if (!$category_info['show_subcats']) { ?>
				<!-- <hr /> -->
			<?php } ?>
			
		</div>
		
		<?php echo $column_right; ?>
	</div>
	<?php echo $content_bottom; ?>
</div>


<?php if ($description) { ?>
	<div class="container category-description">
		<div class="row">
			<div class="col-xlg-10 col-xlg-offset-1 col-lg-12">
				<div class="content-style">
					<?php echo $description; ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php echo $footer; ?>