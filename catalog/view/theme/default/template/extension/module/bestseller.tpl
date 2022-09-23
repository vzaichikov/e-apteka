 <?php foreach ($products as $product) { ?>
    <?php echo $product['seo']; ?>
    <?php } ?>
<!-- <h3><?php echo $heading_title; ?></h3> -->

<div class="bestseller-list slider__list">
  <?php foreach ($products as $product) { ?>
    <div class="bestseller-list__item slider__item">

      <div class="product-layout">
        <div class="product-layout__image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive"></a></div>

        <div class="product-layout__caption">
          <h4 class="product-layout__name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
          <?php if ($product['rating']) { ?>
          <div class="rating">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
            <?php if ($product['rating'] < $i) { ?>
            <svg class="icon rating__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
            <?php } else { ?>
            <svg class="icon rating__icon is-active"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
            <?php } ?>
            <?php } ?>
          </div>
          <?php } ?>
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
        </div>

        <div class="button-group">
          <button class="bbtn bbtn--transparent product-layout__btn-compare" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><svg class="icon featured__compare-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use></svg></button>
          <?php if($product['quantity'] != 0): ?>
          <button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></button>
          <?php else: ?>
          <button class="bbtn bbtn-primary product-layout__btn-cart tooltip2" type="button"><?php echo $button_cart; ?><span class="tooltiptext">Цену уточняйте у менеджера</span></button>
          <?php endif; ?>
            <button class="bbtn bbtn--transparent product-layout__btn-wishlist" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><svg class="icon featured__wishlist-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#heart"></use></svg></button>
        </div>
      </div>

    </div>
  <?php } ?>

  <?php
  $items = count($products);
  for ($i=$items; $i < 6; $i++) {
  ?>
    <div class="bestseller-list__item slider__item"></div>
  <?php } ?>
</div>



