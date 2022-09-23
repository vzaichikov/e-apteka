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