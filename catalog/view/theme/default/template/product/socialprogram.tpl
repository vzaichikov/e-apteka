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
	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
			<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
			<?php $class = 'col-xlg-10 col-md-9'; ?>
			<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
			<h1 class="socialprogram-title cat-header"><?php echo $heading_title; ?></h1>
			
			<?php if ($banner) { ?>
				<div class="row">
					<div class="col-xs-12">
						<img class="socialprogram-banner image-responsive" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" src="<?php echo $banner; ?>" />
					</div>
				</div>
			<?php } ?>
			
			
			<?php if ($socialprograms) { ?>				
				<div class="row">
					<div class="col-md-12">
						<div class="product-category-list socialprogram-list">
							<?php foreach ($socialprograms as $socialprogram) { ?>
								<div class="product-layout">
									<div class="product-layout__image"><a href="<?php echo $socialprogram['href']; ?>">
									<img src="<?php echo $socialprogram['image']; ?>" alt="<?php echo $socialprogram['name']; ?>" title="<?php echo $socialprogram['name']; ?>" class="img-responsive" loading="lazy"></a>
									</div>
									
									<div class="product-layout__caption">
										<h3 class="product-layout__name"><a href="<?php echo $socialprogram['href']; ?>"><?php echo $socialprogram['name']; ?></a></h3>
										
										<div><?php echo $socialprogram['mini_description']; ?></div>
									</div>
								</div>	
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>	
			
			
			
			
			<?php if ($products) { ?>		
				<div class="row"><div class="col-md-12"><div class="product-category-list <?php if ($show_list) { ?>product-category-list--list<? } ?>">
					<?php foreach ($products as $product) { ?>
						
						<?php echo $product['seo']; ?>
						
						<div class="product-layout">
							<div class="product-layout__image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" loading="lazy"></a></div>
							
							<div class="product-layout__caption">
								<h4 class="product-layout__name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
								<p class="product-layout__description"><?php echo $product['description']; ?></p>
								<?php if ($product['rating']) { ?>
									<div class="rating">
										<?php for ($i = 1; $i <= 5; $i++) { ?>
											<?php if ($product['rating'] < $i) { ?>
											<svg class="icon rating__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
											<?php } else { ?>
										<svg class="icon rating__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
									<?php } ?>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if ($product['quantity'] > 0) { ?>
							<?php if ($product['price']) { ?>
								<p class="price">
									<?php if (!$product['special']) { ?>
										<?php echo $product['price']; ?>
										<?php } else { ?>
										<span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
									<?php } ?>
									<?php if ($product['tax']) { ?>
										<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
									<?php } ?>
								</p>
							<?php } ?>
							<?php } else { ?>
							<p class="price price-not-in-stock">
								<?php echo $text_not_in_stock; ?>
							</p>
						<? } ?>
					</div>
					
					<div class="button-group">
					<button class="bbtn bbtn--transparent product-layout__btn-compare is-list-hidden" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><svg class="icon featured__compare-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use></svg></button>
					<?php if ($product['quantity'] > 0) { ?>
						<button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></button>
					<?php } ?>
					
				<button class="bbtn bbtn--transparent product-layout__btn-wishlist" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><svg class="icon featured__wishlist-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#heart"></use></svg></button>
				
				<button class="bbtn bbtn--transparent product-layout__btn-compare is-grid-hidden" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><svg class="icon featured__compare-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use></svg></button>
				</div>
				
				<?php if (isset($product['review_status']) && $product['review_status']) { ?>
					<div class="rating">
						<span class="rating__text"><a href="<?php echo $product['href']; ?>#tab-review"><?php echo $product['reviews']; ?> <?php echo $text_writes; ?></a> / <a href="<?php echo $product['href']; ?>#tab-review"><?php echo $text_write; ?></a></span>
						<?php for ($i = 1; $i <= 5; $i++) { ?>
							<?php if ($product['rating'] < $i) { ?>
							<svg class="icon rating__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
							<?php } else { ?>
						<svg class="icon rating__icon is-active"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
					<?php } ?>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>
</div></div></div>

<?php } ?>			




</div>

<?php echo $column_right; ?>
</div>
<?php echo $content_bottom; ?>
<?php echo $banner; ?>
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