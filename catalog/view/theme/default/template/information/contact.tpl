<?php echo $header; ?>

<div class="container">
	<!-- breadcrumb -->
	<ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
		<?php $ListItem_pos = 1; ?>
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li itemprop="itemListElement" itemscope
			itemtype="https://schema.org/ListItem"><a href="<?php echo $breadcrumb['href']; ?>" itemprop="item"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a><meta itemprop="position" content="<?php echo $ListItem_pos++; ?>" /></li>
		<?php } ?>
	</ul> 
	<!-- breadcrumb -->
</div>

<div class="container">
	<div class="col-sm-12  content-row">
		<div class="row">
			<h1 class="headline-collection cat-header"><?php echo $heading_title; ?></h1>
<?php if ($hb_snippets_local_enable == 'y'){echo html_entity_decode($hb_snippets_local_snippet);} ?>
		</div>
	</div>
</div>

<div class="container">
	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
			<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
			<?php $class = 'col-sm-9'; ?>
			<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<?php $class = 'col-sm-12'; ?>
		<div id="content" style="margin-bottom:20px; min-height:auto;" class="<?php echo $class; ?>">
			<style>
				.content-style p {margin-bottom:0px;}
			</style>
			<div class="row">
				<div class="col-md-6 col-xs-12 contact__info">
					<div class="row">
						<div class="col-xs-12">
							<?php echo $content_top; ?>
						</div>
					</div>
					<hr />
					
				</div>
				
				<div class="col-md-6 col-xs-12 contact__form">
					<?php echo $content_bottom; ?>	
					
					
					<div class="row">
						<div class="col-xs-12 text-left" style="margin-top:20px;">
							<a href="https://www.facebook.com/agp.kyiv/" rel="nofollow">
								<svg style="color:#1cacdc; fill:#1cacdc;  height:50px; width:50px;"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#facebook-logo"></use></svg>					
							</a>
							<a href="https://instagram.com/agp.kyiv/" rel="nofollow">
								<svg style="color:#1cacdc; fill:#1cacdc; height:50px; width:50px;"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#instagram-logo"></use></svg>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php echo $column_right; ?></div>
</div>

<div class="container">
	<div class="row product-stock-map"  style="height: 450px;">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2541.504982383401!2d30.533904400010147!3d50.43169395546735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf058c7e51cb%3A0x820176ff4108cb97!2z0JDQv9GC0LXQutCwINCz0L7RgNC80L7QvdCw0LvRjNC90YvRhSDQv9GA0LXQv9Cw0YDQsNGC0L7QsiDihJYx!5e0!3m2!1sru!2sua!4v1639489972662!5m2!1sru!2sua" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
	</div>
</div>


<?php echo $footer; ?>