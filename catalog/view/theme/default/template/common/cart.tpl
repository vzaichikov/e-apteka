<div id="cart" class="btn-group btn-block header-cart">
	<button type="button" onclick="showPopupCart(true);" <? /* data-toggle="dropdown"  data-loading-text="<?php echo $text_loading; ?>" */ ?> class="header-cart__btn "><svg class="icon header-cart__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#cart"></use></svg><span id="cart-total-count" class="header-cart__total-count"><?php echo $quantity; ?></span>
		<span id="cart-total" class="header-cart__total"><?php echo $text_items; ?></span>
		<? /* <span class="header-cart__title"><?php echo $text_cart2; ?></span> */ ?></button>		
</div>
