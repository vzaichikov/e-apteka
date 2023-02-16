<?php echo $header; ?>
<?php echo $seo; ?>

<link href="catalog/view/theme/default/js/liFixar/liFixar.css" rel="stylesheet" media="screen" />
<script src="catalog/view/theme/default/js/liFixar/jquery.liFixar.js" type="text/javascript"></script>
<script src="catalog/view/theme/default/js/scrollbooster.min.js" type="text/javascript"></script>

<?php include(DIR_TEMPLATEINCLUDE . 'structured/breadcrumbs.tpl'); ?>

<style>
	.share-buttons{margin:0 auto}.share-block{display:inline-block;background:#fff;width:40px;height:40px;margin-bottom:16px;border:1px solid #ccc;text-align:center;transition:.5s}.share-block:hover{animation:share-animation .82s cubic-bezier(.36,.07,.19,.97) both;border-color:#00b5a5}.share-block i{font-size:18px;position:relative;top:11px}.share-block span{display:block;position:relative;top:-9px;font-size:10px;line-height:1}.share-buttons .facebook{color:#3b5998}.share-buttons .email{color:#00b5a5}.share-buttons .pinterest{color:#cc2127}.share-buttons .twitter{color:#55acee}.share-buttons .viber{color:#7360f2}.share-buttons .telegram{color:#0088cc}.share-buttons .general-share{color:#7cbc00}.@keyframes share-animation{10%,90%{transform:translate3d(-1px,0,0)}20%,80%{transform:translate3d(2px,0,0)}30%,50%,70%{transform:translate3d(-4px,0,0)}40%,60%{transform:translate3d(4px,0,0)}}
	#tab-delivery-pay .col-xlg-10.col-xlg-offset-1{
	width: 100% !important;
	max-width: 100%	!important;
	margin: 0;
	}
	.text-danger a{
	cursor: pointer;
	}
	@media screen and (max-width: 556px) {

    .product__order-wrap-main{
        height: 85px !important;
        flex-wrap: wrap;
         display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto 1fr;
        gap: 10px;
    }
    .product__order-wrap-main .alert.alert-danger{
        padding: 10px;
        margin: 0;
        font-size: 12px;
        grid-column-start: 1;
        grid-column-end: 3;
        grid-row-start: 1;
        grid-row-end: 1;
    }
    .product__order-wrap-main .product__order-wrap{
       
    }
}
</style>

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
		
		<div id="content" class="<?php echo $class; ?> product-page__content">
			
			<h1 class="product__title text-center"><?php echo $heading_title; ?></h1>
			
			<!-- tab new product -->
			<div class="product-tabs">
				<div class="js-dragscroll-wrap2">
					<ul class="nav nav-pills js-dragscroll2">
						
						<li class="active">
							<a href="#tab-about-prod" data-toggle="tab"><?php echo $text_all_about_product; ?>
								<!-- <svg class="product-tabs__nav-icon">
									<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#edit"></use>
								</svg> -->
							</a>
						</li>

						<?php if ( $is_mobile && isset($description) && !empty(trim(strip_tags($description)))) { ?>
							<li>
								<a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?>
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#instruction"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>
						
						<?php if ( isset($instruction) && !empty(trim(strip_tags($instruction)))) { ?>
							<li>
								<a href="#tab-instruction" data-toggle="tab"><?php echo $tab_instruction; ?>
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#instruction"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>
						
						<?php if ($attribute_groups) { ?>
							<li>
								<a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?>
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#bars"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>

						<?php if ( !empty($likreestr)) { ?>
							<li>
								<a href="#tab-likreestr" data-toggle="tab"><?php echo $tab_likreestr; ?>
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#instruction"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>
						
						<?php if ( isset($analogs) && count($analogs)>0 ) { ?>
							<li>
								<a href="#tab-analog" data-toggle="tab"><?php echo $tab_analogs;?>
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#plus"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>						
						
						<?php if ( isset($same) && count($same)>0 ) { ?>
							<li>
								<a href="#tab-forms-of-release" data-toggle="tab"><?php echo $tab_same;?>
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#plus"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>

						<li>
							<a href="#tab-delivery-pay" data-toggle="tab"><?php echo $text_delivery_pay; ?>
								<!-- <svg class="product-tabs__nav-icon">
									<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#edit"></use>
								</svg> -->
							</a>
						</li>												
						
						<?php if ( !empty($hobofaq)) { ?>
							<li>
								<a href="#tab-hobofaq" data-toggle="tab">FAQ
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#plus"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>
						
						<?php if ($review_status) { ?>
							<li>
								<a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?>
									<!-- <svg class="product-tabs__nav-icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#thumbs-up-2"></use>
									</svg> -->
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="tab-content" id="product">
					<div class="tab-pane active" id="tab-about-prod">
						<div class="<?php if ($quantity_stock > 0) { ?>col-md-8 col-lg-7<?php } else { ?>col-md-12<?php } ?> col-sm-12">
							<div class="row">
								<div class="<?php if ($quantity_stock > 0) { ?>col-sm-4<?php } else { ?>col-sm-2<?php } ?>">
									<?php if ($thumb || $images) { ?>
										
										<?php $i=1; if ($images) { ?>
											<div class="gallery-thumbs">
												<div class="swiper-container thumbImages_<?php echo count($images); ?>">
													<!--swiper-wrapper-->
													<div class="swiper-wrapper">
														<?php $i = 1;
															if ($thumb) { ?>
															<div class="swiper-slide">
																<img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" width="370" height="370"/>
															</div>
														<?php } ?>
														<?php foreach ($images as $image) { ?>
															<?php if (isset($image['thumb'])) { ?>
																<div class="swiper-slide 2">
																	<img src="<?php echo $image['thumb']; ?>"
																	alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" width="370" height="370">
																</div>
															<?php } ?>
														<?php $i++; } ?>
													</div>
												</div>
												<!-- Add Arrows -->
												
												<div class="swiper-button-next"></div>
												<div class="swiper-button-prev"></div>
												
											</div>
										<?php } ?>
										
										<div class="gallery-top" <?php if (!$images) { ?> style="margin-left: 0" <?php } ?>>

											<style>
												.product__btn-compare{position: absolute;right: 15px;top: 20px;width: 40px;height: 35px;z-index: 10;border: 0;padding: 0;}
												.product__btn-wishlist{position: absolute;right: 15px;top: 60px;width: 40px;height: 35px;z-index: 10;border: 0;padding: 0;}
												.product__btn-compare svg, .product__btn-wishlist svg{fill: #afdfee}
											</style>	
											<button class="bbtn bbtn--transparent product__btn-wishlist" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');">
												<svg class="icon featured__wishlist-icon">
													<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#heart"></use>
												</svg>
											</button>

											<button class="bbtn bbtn--transparent product__btn-compare" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');">
												<svg class="icon featured__compare-icon">
													<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use>
												</svg>
											</button>

											<div class="swiper-container topImages_<?php echo count($images); ?>">
												
												<!--swiper-wrapper-->
												<div class="swiper-wrapper">
													<!--swiper-slide-->
													<?php if ($thumb || $images) { ?>
														<div class="swiper-slide">
															<img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" width="370" height="370">
														</div>
														
														<?php $i = 1; if ($images) { ?>
															<?php foreach ($images as $image) { ?>
																<?php if (isset($image['thumb'])) { ?>
																	<div class="swiper-slide">
																		<img src="<?php echo $image['popup']; ?>" alt="<?php echo $heading_title; ?>" width="100" height="100">
																	</div>
																<?php } ?>
															<?php $i++; } ?>
														<?php } ?>
													<?php } ?>
													<!--/swiper-slide-->
												</div>
												<!--/swiper-wrapper-->
												<div class="swiper-pagination"></div>
											</div>
											
											<div><small class="text-muted"><?php echo $text_picture_may_differ; ?></small></div>
											
										</div>
										
									<?php } ?>
								</div>
								
								<div class="<?php if ($quantity_stock > 0) { ?>col-sm-8<?php } else { ?>col-sm-10<?php } ?>">
									<?php if ($quantity_stock > 0) { ?>										
										<?php if ($reward) { ?>
											<div class="product__reward">
												<?php echo $text_reward; ?> <?php echo $reward; ?>
											</div>
										<?php } ?>																				
									<? } ?>
									
									<div class="product__info product-info">
										<div class="product-info__col-content">
											<?php if ( isset($special_date_end) ){ ?>
												<script>
													function getTimeRemaining(endtime) {
														var t = Date.parse(endtime) - Date.parse(new Date());
														var seconds = Math.floor((t / 1000) % 60);
														var minutes = Math.floor((t / 1000 / 60) % 60);
														var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
														var days = Math.floor(t / (1000 * 60 * 60 * 24));
														return {
															'total': t,
															'days': days,
															'hours': hours,
															'minutes': minutes,
															'seconds': seconds
														};
													}
													
													function initializeClock(id, endtime) {
														var clock = document.getElementById(id);
														var daysSpan = clock.querySelector('.days');
														var hoursSpan = clock.querySelector('.hours');
														var minutesSpan = clock.querySelector('.minutes');
														var secondsSpan = clock.querySelector('.seconds');
														
														function updateClock() {
															var t = getTimeRemaining(endtime);
															
															daysSpan.innerHTML = t.days;
															hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
															minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
															secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
															
															if (t.total <= 0) {
																clearInterval(timeinterval);
															}
														}
														
														updateClock();
														var timeinterval = setInterval(updateClock, 1000);
													}
												</script>
												<div class="product-action-price">
													<?php if ($price && $special) { ?>
														<div class="product-action-price__discount discount">
															<?php $discount = round(100 - ( floatval($special)*100/floatval($price))); ?>
															<div class="discount__text">скидка</div>
															<div class="discount__value">-<?php echo $discount."%"; ?></div>
														</div>
													<?php } ?>
													
													<div class="product-action-price__timer timer">
														<p>До конца акции осталось:</p>
														<div id="countdown-<?php echo $product_id; ?>" class="countdown">
															<div class="countdown-number">
																<span class="days countdown-time"></span>
																<span class="countdown-text">дней</span>
															</div>
															<div class="countdown-number">
																<span class="hours countdown-time"></span>
																<span class="countdown-text">часов</span>
															</div>
															<div class="countdown-number">
																<span class="minutes countdown-time"></span>
																<span class="countdown-text">минут</span>
															</div>
															<div class="countdown-number">
																<span class="seconds countdown-time"></span>
																<span class="countdown-text">секунд</span>
															</div>
														</div>
														
														<script>
															var deadline = '<?php echo $special_date_end; ?>';
															initializeClock('countdown-<?php echo $product_id; ?>', deadline);
														</script>
													</div>
												</div>
											<?php } ?>
											
											<?php if ($quantity_stock > 0) { ?>
												<?php if ($price) { ?>
													
													<div class="product__order-wrap-main <?php if (!$options) { ?>not_options<?php } ?>">
														<div class="product__order-wrap <?php if ($special) { ?>is-special-bg<?php } ?> ">
															<?php if (!$special) { ?>
																<div class="product__price-wrap">
																	<span class="product__price"><?php echo $price; ?></span>
																	<?php if (mb_strlen($price) > 9) {?><style>.product__price{--price-font : 20px;} </style><?}?>
																</div>
																<?php } else { ?>
																<div class="product__price-wrap is-special">
																	<span class="product__price"><?php echo $special; ?></span>
																	<span class="product__old-price"><?php echo $price; ?></span>
																</div>
															<?php } ?>
															
															<div class="button-group product__button-group">
																<?php if($quantity_stock != 0) { ?>
																	<div class="form-group">
																		<div class="input-count">
																			<button class="input-count__btn js-input-count-minus">–</button>
																			<input type="text" name="quantity-main" value="<?php echo $minimum; ?>" size="2" id="input-quantity-main" class="input-count__num" />
																			<button class="input-count__btn js-input-count-plus">+</button>
																			<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
																			<input type="hidden" name="oneclick_location_id" value="">
																		</div>
																	</div>
																<?php } ?>
																
																<?php if ($quantity_stock > 0) { ?>
																	<input type="hidden" name="order-type" value="full" />
																
																	<button id="main-add-cart-button" class="bbtn bbtn-primary product__btn-cart" type="button" data-loading-text="<?php echo $text_loading; ?>">
																		<?php echo $button_cart; ?>
																	</button>
																	
																	<?php if (!$no_fast_order) { ?>	
																		<button type="button" id="main-fastorder-button" class="btn btn-block boc_order_btn" data-target="#boc_order_all" data-product="<?php echo $heading_title; ?>" data-product_id="<?php echo $product_id; ?>" title="<?php echo $buyoneclick_name; ?>"><?php echo $buyoneclick_name; ?></button>
																	<?php } ?>
																	
																	
																	<?php if ($options && $text_full_pack) { ?>
																		<small><?php echo $text_full_pack; ?></small>
																	<?php } ?>
																	<?php } else { ?>
																	
																<?php } ?>
																
																
																<div id="price_mob"></div>
															</div>
														</div>
														
														<?php if ($options) { ?>
															<?php foreach ($options as $option) { ?>
																<?php foreach ($option['product_option_value'] as $option_value) { ?>
																	<div class="product__order-wrap <?php if ($special) { ?>is-special-bg<?php } ?>">
																		<?php if ($option_value['price']) { ?>
																			<div class="product__price-wrap">
																				<span class="product__price"><?php echo $option_value['price']; ?></span>
																			</div>
																		<?php } ?>
																		
																		<div class="button-group product__button-group">
																			<?php if($quantity_stock > 0) { ?>
																				<div class="form-group">
																					<div class="input-count">
																						<button class="input-count__btn js-input-count-minus">–</button>
																						<input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity-option" class="input-count__num" />
																						<button class="input-count__btn js-input-count-plus">+</button>
																					</div>
																				</div>
																			<?php } ?>
																			
																			<?php if ($quantity_stock > 0) { ?>
																				<button id="main-add-cart-button-stock-logic" class="bbtn bbtn-primary product__btn-cart" type="button" data-loading-text="<?php echo $text_loading; ?>">
																					<?php echo $button_cart; ?>
																				</button>
																				
																				<?php if (!$no_fast_order) { ?>
																					<button type="button" id="main-fastorder-button-stock-logic" data-loading-text="<?php echo $buyoneclick_text_loading; ?>" class="btn btn-block boc_order_btn" data-target="#boc_order" data-product="<?php echo $heading_title; ?>" data-product_id="<?php echo $product_id; ?>" title="<?php echo $buyoneclick_name; ?>"><?php echo $buyoneclick_name; ?></button>
																				<?php } ?>
																				
																				<?php if ($text_part_pack) { ?>
																					<small><?php echo $text_part_pack; ?></small>
																				<?php } ?>
																				<?php } else { ?>
																				
																			<?php } ?>
																		</div>
																		
																		<div style="display:none;">
																			<div id="option<?php echo $product_id; ?>">
																				<?php if ($option['type'] == 'radio') { ?>
																					<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
																						<div id="input-option<?php echo $option['product_option_id']; ?>">
																							<?php foreach ($option['product_option_value'] as $option_value) { ?>
																								<div class="checkbox">
																									<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
																								</div>
																							<?php } ?>
																						</div>
																					</div>
																				<?php } ?>
																			</div>
																		</div>
																	</div>
																<?php } ?>
															<?php } ?>
															
														<?php } ?>
													</div>
													<!-- product__order-wrap-main -->
												<?php } ?>
												<? } else { ?>
												<div class="product__price-wrap product__not-in-stock">
													<span class="product__price"><?php echo $text_not_in_stock; ?></span>
												</div>
											<? } ?>
											
											<?php if ($quantity_stock > 0) { ?>
												
												<div id="product">
													<?php if ($minimum > 1) { ?>
														<div class="alert alert-info" style="padding:5px 0px;"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
													<?php } ?>
												</div>
												
												<?php if ($delivery_to_ukraine_unavailable) { ?>
													<div class="text-danger" style="padding:10px 0px 5px;">
														<i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_delivery_to_ukraine_unavailable; ?>
													</div>
												<?php } ?>
												
												<?php if ($is_receipt) { ?>
													<div class="text-danger" style="padding:10px 0px 5px;">
														<i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_is_receipt; ?>
													<? /*	<br />
														<i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_is_receipt2; ?>
													*/ ?>
													</div>
												<?php } ?>
												<?php if (false && $review_status) { ?>
													<hr>
													<div class="rating">
														<?php for ($i = 1; $i <= 5; $i++) { ?>
															<?php if ($rating < $i) { ?>
																<svg class="icon rating__icon">
																	<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use>
																</svg>
																<?php } else { ?>
																<svg class="icon rating__icon is-active">
																	<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use>
																</svg>
															<?php } ?>
														<?php } ?>
														<span class="rating__text">
															<a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({ scrollTop: $('#review-anchor').offset().top }, 1000); return false;"><?php echo $reviews; ?></a> / <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({ scrollTop: $('#review-anchor').offset().top }, 1000); return false;"><?php echo $text_write; ?></a>
														</span>
													</div>
													<hr>
												<?php } ?>
												
												<div class="product__text-row product__manufacturer row">
													<div class="col-sm-12">														
														<a href="<?php echo $manufacturers; ?>" title="<?php echo $manufacturer; ?>">
															<?php echo $manufacturer; ?>
														</a>
													</div>
													
													<?php if ($brand) { ?>
														<div class="col-sm-12">
															<?php echo $text_brand; ?> <?php echo $brand; ?>
														</div>
													<?php } ?>
												</div>
												
												<?php if ($collection) { ?>
													<div class="product__text-row product__manufacturer">
														<a href="<?php echo $collection_href; ?>" title="<?php echo $manufacturer; ?> <?php echo $collection; ?>">
															<span class="label label-success" style="font-size:100%"><?php echo $collection; ?> <i class="fa fa-external-link"></i></span>
														</a>
													</div>
												<?php } ?>
												
												<?php /* if ($quantity_stock > 0) { ?>
													<div class="product__stock text-success">
														<?php echo $stock; ?>
													</div>
												<?php } */ ?>

												<div class="product__order-info-wrap">
														<?php if (false && $free_shipping_kyiv) { ?>
															<div class="product__freedelivery-wrap row" style="margin:0px;">
																<div class="col-xs-12 pull-right alert alert-success" style="margin:0px;">
																	<i class="fa fa-ambulance" aria-hidden="true"></i>&nbsp;&nbsp;<b><?php echo $text_free_shipping_kyiv; ?></b>
																</div>
															</div>
														<?php } ?>													
													</div>
												
											<?php } ?>
										</div>
									</div>
								</div>
							</div>

						<?php if (!$is_mobile) { ?>				
							<?php if ( isset($description) && !empty(trim(strip_tags($description)))) { ?>
								<div class="description-block" style="display: inline-block;margin: 25px 0; width: 100%;">
									<?php echo $description; ?>
								</div>
							<?php } else { ?>
								<?php if ($attribute_groups) { ?>
									<div class="description-block" style="display: inline-block;margin: 25px 0; width: 100%;">
										<table class="table table-bordered">
											<?php foreach ($attribute_groups as $attribute_group) { ?>
												<thead>
													<tr>
														<td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
														<tr>
															<td><?php echo $attribute['name']; ?></td>
															<td><?php echo $attribute['text']; ?></td>
														</tr>
													<?php } ?>

													<?php if ($attribute_group['attribute_group_id'] == 8 && $gtin) { ?>
														<tr>
															<td>EAN</td>
															<td><?php echo $gtin; ?></td>
														</tr>
													<?php } ?>
													<?php if ($attribute_group['attribute_group_id'] == 8 && $atx_tree) { ?>
														<tr>
															<td>ATX</td>
															<td>
																<?php foreach ($atx_tree as $atx) { ?>
																	<?php if ($atx['atx_code'] == $reg_atx_1) { ?>
																		<b><?php echo $atx['atx_code']; ?></b>
																	<?php } else { ?>
																		<?php echo $atx['atx_code']; ?>
																	<?php } ?>
																	<a href="<?php echo $atx['href']?>" title="<?php echo $atx['name']; ?>"><?php echo $atx['name']; ?></a><br />
																<?php } ?>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											<?php } ?>
										</table>
									</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>	
						</div>
						
						<?php if ($quantity_stock > 0) { ?>
							<div class="col-md-4 col-lg-5 col-sm-12" >
								<style>
									.big-spinner{margin-bottom: 10px;}
									.big-spinner i {font-size: 32px; }
								</style>
								<h3 class="product-delivery-info__h3"><?php echo $text_is_in_stock_in_drugstores; ?></h3>
								<div id="stocks-in-product" class="ajax-module-reloadable" data-modpath="product/product/stocks" data-x="<?php echo $product_id; ?>">
									<div class="row text-center big-spinner"><div class="col-sm-12"><i class="fa fa-spinner fa-spin"></i></div></div>
								</div>

								<?php echo $content_top; ?>
							</div>
						<? } ?>
						
						<?php if ($proposal_rendered) { ?>
							<div id="proposal" class="row">
								<?php echo $proposal_rendered; ?>
							</div>
						<?php } ?>
						
					</div>



					
					<?php if (!empty($hobofaq)) { ?>
						<div class="tab-pane hobofaq-text-style" id="tab-hobofaq">
							<?php echo $hobofaq; ?>
						</div>
					<?php } ?>

					<?php if ( isset($instruction) && !empty($instruction) ) { ?>
						<div class="tab-pane information-text-style" id="tab-instruction" style="max-height:500px; overflow-y:scroll;">							
						</div>
					<?php } ?>

					<?php if ( !empty($likreestr) ) { ?>
						<div class="tab-pane information-text-style" id="tab-likreestr" style="max-height:500px; overflow-y:scroll;">							
						</div>
					<?php } ?>
					
					<?php if ($is_mobile && isset($description) && !empty(trim(strip_tags($description)))) { ?>
						<div class="tab-pane information-text-style" id="tab-description">		
							<div class="description-block" style="display: inline-block;margin: 25px 0; width: 100%;">
								<?php echo $description; ?>
							</div>		
						</div>
					<?php } ?>
					
					<?php if ($attribute_groups) { ?>
						<div class="tab-pane" id="tab-specification">
							<table class="table table-bordered">
								<?php foreach ($attribute_groups as $attribute_group) { ?>
									<thead>
										<tr>
											<td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
											<tr>
												<td><?php echo $attribute['name']; ?></td>
												<td><?php echo $attribute['text']; ?></td>
											</tr>
										<?php } ?>										
										<?php if ($attribute_group['attribute_group_id'] == 8 && $gtin) { ?>
											<tr>
												<td>EAN</td>
												<td><?php echo $gtin; ?></td>
											</tr>
										<?php } ?>
										<?php if ($attribute_group['attribute_group_id'] == 8 && $atx_tree) { ?>
											<tr>
												<td>ATX</td>
												<td>
													<?php foreach ($atx_tree as $atx) { ?>
														<?php if ($atx['atx_code'] == $reg_atx_1) { ?>
															<b><?php echo $atx['atx_code']; ?></b>
														<?php } else { ?>
															<?php echo $atx['atx_code']; ?>
														<?php } ?>
														<a href="<?php echo $atx['href']?>" title="<?php echo $atx['name']; ?>"><?php echo $atx['name']; ?></a><br />
													<?php } ?>
												</td>
											</tr>
										<?php } ?>											
									</tbody>
								<?php } ?>
							</table>
						</div>
					<?php } ?>
					
					<?php if ( isset($analogs) && count($analogs)>0 ) { ?>
						<div class="tab-pane" id="tab-analog">
							<div class="product-category-list">
								<?php foreach ($analogs as $product) { ?>
									<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_single.tpl'); ?>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					
					<div class="tab-pane" id="tab-delivery-pay">
						<div class="tab-delivery-wrap">
							<!-- доставка и оплата -->
							<?php echo $content_top; ?>
						</div>
					</div>
					
					
					
					<?php if ( isset($same) && count($same)>0 ) { ?>
						<div class="tab-pane" id="tab-forms-of-release">
							<div class="product-category-list">
								<?php foreach ($same as $product) { ?>
									<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_single.tpl'); ?>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					
					<?php if ($review_status) { ?>
						<div class="tab-pane" id="tab-review">
							<form class="form-horizontal review" id="form-review">
								<div id="review"></div>
								<br id="review-anchor">
								<br>
								<h2><?php echo $text_write; ?></h2>
								<?php if ($review_guest) { ?>
									
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group required rating-form">
													<label class="control-label"><?php echo $entry_rating; ?></label>
													&nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
													<input type="radio" name="rating" value="1" />
													&nbsp;
													<input type="radio" name="rating" value="2" />
													&nbsp;
													<input type="radio" name="rating" value="3" />
													&nbsp;
													<input type="radio" name="rating" value="4" />
													&nbsp;
													<input type="radio" name="rating" value="5" />
												&nbsp;<?php echo $entry_good; ?></div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group required">
													<input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" placeholder="<?php echo $entry_name; ?>">
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group required">
													<input type="email" name="email" value="<?php echo $customer_email; ?>" id="input-email" class="form-control" placeholder="<?php echo $entry_email; ?>">
												</div>
											</div>
											
											
										</div>
										
										<div class="row">
											<div class="col-sm-8">
												<div class="form-group required">
													<textarea name="text" rows="5" id="input-review" class="form-control" placeholder="<?php echo $entry_review; ?>"></textarea>
													<!--div class="help-block"><?php echo $text_note; ?></div-->
												</div>
											</div>
										</div>
										
										<div class="col-sm-12">
											<?php echo $captcha; ?>
										</div>
										
										<div class="buttons clearfix">
											<button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="bbtn"><?php echo $button_continue; ?></button>
										</div>
										
									</div>
									<div class="clearfix"></div>
									<?php } else { ?>
									<?php echo $text_login; ?>
								<?php } ?>
							</form>
						</div>
					<?php } ?>
				</div>
			</div>
			<!-- tab new product END-->
		</div>
		
		
		<?php if (!empty($collection_rendered)) { ?>
			<?php echo $collection_rendered; ?>
		<?php } ?>
		
		<?php if (!empty($products_rendered)) { ?>
			<?php echo $products_rendered; ?>
		<?php } ?>
		
		
		<?php if ($tags) { ?>
			<p><?php echo $text_tags; ?>
				<?php for ($i = 0; $i < count($tags); $i++) { ?>
					<?php if ($i < (count($tags) - 1)) { ?>
						<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
						<?php } else { ?>
						<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
					<?php } ?>
				<?php } ?>
			</p>
		<?php } ?>
	<?php echo $content_bottom; ?></div>
<?php echo $column_right; ?></div>
<div class="addTo-cart-wrapper" style="height: 125px;">
	<div class="addTo-cart-holder">
		<div class="addTo-cart-container">
			<div class="addTo-cart-image">
				<?php if ($thumb) { ?>
					<img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" width="60" height="60"/>
				<?php } ?>
			</div>
			<div class="addTo-cart-details">
				<h3>
					<?php echo $heading_title; ?>
				</h3>
				<?php if ($quantity_stock > 0) { ?>
					<div class="addTo-cart-details-price">
						<?php if ($price) { ?>
							<?php if (!$special) { ?>
								<div class="price__new"><?php echo $price; ?></div>
								<?php } else { ?>
								<div class="price__new"><?php echo $special; ?></div>
								<div class="price__old"><?php echo $price; ?></div>
							<?php } ?>
						<?php } ?>
					</div>
					<?php } else { ?>
					<span class="product__price" style="color: #767f82;font-size: 25px;">Нет в наличии</span>
				<?php } ?>
			</div>
			<?php if ($quantity_stock > 0) { ?>
				<div class="addTo-cart-qty">
					
					<?php if(!$no_fast_order) {?>
						<button type="button" class="btn btn-block boc_order_btn" onclick="$('#main-fastorder-button').trigger('click');" data-target="#boc_order_all" data-product="<?php echo $heading_title; ?>" data-product_id="<?php echo $product_id; ?>" title="<?php echo $buyoneclick_name; ?>"><?php echo $buyoneclick_name; ?></button>
					<?php } ?>	
				</div>
			<?php } ?>
		</div>
	</div>
</div>
</div>



<script>
	$(document).ready(function(){
		passEcommerceToDataLayer('productDetail', '<?php echo $product_id?>');
	});
</script>

<script><!--
	if(document.documentElement.clientWidth < 560) {
		// $('.product__info.product-info .product-info__col-content .product__price-wrap').clone().appendTo('#price_mob');
	}
	if(document.documentElement.clientWidth > 1000) {
		$('#main-add-cart-button').clone().prependTo('.addTo-cart-qty');
		
        var showFixedAdd = $('#tab-about-prod .description-block').innerHeight();
		
        if ($(this).scrollTop() > showFixedAdd) $('.addTo-cart-holder').fadeIn();
        else $('.addTo-cart-holder').fadeOut();
        $(window).scroll(function () {
            if ($(this).scrollTop() > showFixedAdd) $('.addTo-cart-holder').fadeIn();
            else $('.addTo-cart-holder').fadeOut();
		});
		
		$(function(){
		    $('.addTo-cart-holder').liFixar({
		      	side: 'bottom',
		     	position: 10,
      			fix: function(el, side){
					el.liFixar('update');
					el.parent('.addTo-cart-wrapper').removeClass('unfix');
				},
				unfix: function(el, side){
					el.liFixar('update');
					el.parent('.addTo-cart-wrapper').addClass('unfix');
				}
			});
		});
	};

	$('.input-count').on('click', '.js-input-count-minus', function(e) {
		e.preventDefault;
		
		var value = $(this).siblings('.input-count__num');
		var q = parseInt( value.val() );
		
		if ( q > 1) {
			q = q - 1;
			value.val(q);
		}
	});
	
	$('.input-count').on('click', '.js-input-count-plus', function(e) {
		e.preventDefault;
		
		var value = $(this).siblings('.input-count__num');
		var q = parseInt( value.val() );
		
		q = q + 1;
		value.val(q);
	});
//--></script>

<script>
	$('body').on('click', '#main-add-cart-button', function(){
		let quantity=$('#input-quantity-main').val();
		cart.add('<?php echo $product_id; ?>', quantity, false, true);
	});
	// $('body').on('click', '#main-add-cart-button-stock-logic', function(){
	// 	let quantity=$('#input-quantity-main').val();
	// 	cart.add('<?php echo $product_id; ?>', quantity);
	// });
</script>
<script type="text/javascript"><!--

	$('#main-fastorder-button').on('click', function() {
		$('#product input[name=\'order-type\']').val('full');
		$('input[name=\'oneclick_location_id\']').val('0');
		callFastOrderPopup($(this));		
	});
	
	$('#main-fastorder-button-stock-logic').on('click', function() {	
		$('#product input[name=\'order-type\']').val('part');
	
		<?php if ($options) { ?>
			<?php foreach ($options as $option) { ?>
				<?php foreach ($option['product_option_value'] as $option_value) { ?>
					<?php if ($option['type'] == 'radio') { ?>
						$("input[name='option[<?php echo $option['product_option_id']; ?>]']").click();
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>	
		
		$('input[name=\'oneclick_location_id\']').val('0');
		callFastOrderPopup($(this));
	});
	
	$('#main-add-cart-button-stock-logic').on('click', function() {
		
		
		<?php if ($options) { ?>
			<?php foreach ($options as $option) { ?>
				<?php foreach ($option['product_option_value'] as $option_value) { ?>
					<?php if ($option['type'] == 'radio') { ?>
						$("input[name='option[<?php echo $option['product_option_id']; ?>]']").click();
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		
		
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				$('.alert, .text-danger').not('.text-danger-not-remove').remove();
				if (json['redirect']) {
					location = json['redirect'];
				}
				$('.form-group').removeClass('has-error');
				
				if (json['error']) {
					if (json['error']['option']) {
						for (i in json['error']['option']) {
							var element = $('#input-option' + i.replace('_', '-'));
							
							if (element.parent().hasClass('input-group')) {
								element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
								} else {
								element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
							}
						}
					}
					
					if (json['error']['recurring']) {
						$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
					}
					
					// Highlight any found errors
					// $('.text-danger').parent().addClass('has-error');
				}
				
				if (json['success']) {
					console.log(json);
					
					// Need to set timeout otherwise it wont update the total
					setTimeout(function () {
						// $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
						
						// количество товара в конзине (штук)
						$('#cart-total-count').html(json['quantity']);
						
						// сумма товаров в корзине (грн)
						$('#cart-total').html(json['total']);
					}, 100);
					showPopupCart(true);
					
					// $('html, body').animate({ scrollTop: 0 }, 'slow');
					
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
//--></script>
<script type="text/javascript"><!--
	<? /*
		$('.date').datetimepicker({
		pickTime: false
		});
		
		$('.datetime').datetimepicker({
		pickDate: true,
		pickTime: true
		});
		
		$('.time').datetimepicker({
		pickDate: false
		});
	*/ ?>
	
	$('button[id^=\'button-upload\']').on('click', function() {
		var node = this;
		
		$('#form-upload').remove();
		
		$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
		
		$('#form-upload input[name=\'file\']').trigger('click');
		
		if (typeof timer != 'undefined') {
			clearInterval(timer);
		}
		
		timer = setInterval(function() {
			if ($('#form-upload input[name=\'file\']').val() != '') {
				clearInterval(timer);
				
				$.ajax({
					url: 'index.php?route=tool/upload',
					type: 'post',
					dataType: 'json',
					data: new FormData($('#form-upload')[0]),
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {
						$(node).button('loading');
					},
					complete: function() {
						$(node).button('reset');
					},
					success: function(json) {
						$('.text-danger').remove();
						
						if (json['error']) {
							$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
						}
						
						if (json['success']) {
							alert(json['success']);
							
							$(node).parent().find('input').val(json['code']);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		}, 500);
	});
//--></script>
<script type="text/javascript"><!--
	$('#review').delegate('.pagination a', 'click', function(e) {
		e.preventDefault();
		
		$('#review').fadeOut('slow');
		
		$('#review').load(this.href);
		
		$('#review').fadeIn('slow');
	});
	
	$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');
	
	$('#button-review').on('click', function() {
		$.ajax({
			url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
			type: 'post',
			dataType: 'json',
			data: $("#form-review").serialize(),
			beforeSend: function() {
				$('#button-review').button('loading');
			},
			complete: function() {
				$('#button-review').button('reset');
			},
			success: function(json) {
				$('.alert-success, .alert-danger').remove();
				
				if (json['error']) {
					showModalMsg('<div class="alert-danger">' + json['error'] + '</div>', false);
					// $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				}
				
				if (json['success']) {
					showModalMsg('<div class="alert-success">' + json['success'] + '</div>', false);
					// $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
					
					$('input[name=\'name\']').val('');
					$('textarea[name=\'text\']').val('');
					$('input[name=\'rating\']:checked').prop('checked', false);
				}
			}
		});
	});
	<?php if ($images && count($images > 1)) { ?>
		if ($(".gallery-top")[0]) {
			var galleryThumbs<?php echo count($images); ?> = new Swiper('.gallery-thumbs .swiper-container.thumbImages_<?php echo count($images); ?>', {
				centeredSlides: false,
				<?php if(count($images) >= 2)  {?>
					slidesPerView: 3,
					loop: true,
					loopedSlides: 3,
					height: 300,
					breakpoints: {
						1280: {
							loopedSlides: 3,
						},
					},
					<?php } else { ?>
					slidesPerView: 2,
					height: 200,
					loopedSlides: 2,
					breakpoints: {
						1280: {
							loopedSlides: 2,
						},
					},
				<?php } ?>
				touchRatio: 0.2,
				slideToClickedSlide: true,
				direction: 'vertical',
				navigation: {
			        nextEl: '.gallery-thumbs .swiper-button-next',
			        prevEl: '.gallery-thumbs .swiper-button-prev',
				},
				
			});
			
			var galleryTop<?php echo count($images); ?> = new Swiper('.gallery-top .swiper-container.topImages_<?php echo count($images); ?>', {
				slidesPerView: 'auto',
				loop: true,
				loopedSlides: 2,
				pagination: {
					el: '.gallery-top .swiper-pagination',
					clickable: true,
				},
				breakpoints: {
					1280: {
						loopedSlides: 3,
					},
				},
				<?php if(count($images) < 2)  {?>
					thumbs: {
						swiper: galleryThumbs<?php echo count($images); ?>
					}
				<?php } ?>
			});
			
			<?php if(count($images) >= 2)  {?>
				galleryTop<?php echo count($images); ?>.controller.control = galleryThumbs<?php echo count($images); ?>;
				galleryThumbs<?php echo count($images); ?>.controller.control = galleryTop<?php echo count($images); ?>;
			<?php } ?>
		}
	<?php } ?>
	
	<? /*
		$(document).ready(function() {
		$('.thumbnails').magnificPopup({
		delegate: 'a.popup-image',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-with-zoom',
		gallery: {
		enabled: true,
		navigateByImgClick: true,
		preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
		tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		titleSrc: function(item) {
		return item.el.attr('title');
		}
		}
		});
		});
	*/ ?>
//--></script>

<script>

	$(document).ready(function(){
		var instruction_shown = false;
		$('a[href="#tab-instruction"]').on('shown.bs.tab', function (event) {
			if (!instruction_shown){
				console.log('Fired loading instruction');
				$('#tab-instruction').load('index.php?route=product/product/instruction&product_id=<?php echo $product_id; ?>', function(){ instruction_shown = true; });				
			}
		});

		var likreestr_shown = false;
		$('a[href="#tab-likreestr"]').on('shown.bs.tab', function (event) {
			if (!likreestr_shown){
				console.log('Fired loading likreestr');
				$('#tab-likreestr').load('index.php?route=product/product/likreestr&product_id=<?php echo $product_id; ?>', function(){ likreestr_shown = true; });				
			}
		});

		var delivery_pay_shown = false;
		$('a[href="#tab-delivery-pay1"]').on('shown.bs.tab', function (event) {
			if (!delivery_pay_shown){
				console.log('Fired loading delivery_pay');
				$('#tab-instruction').load('index.php?route=product/product/instruction&product_id=<?php echo $product_id; ?>', function(){ delivery_pay_shown = true; });
			}
		});
	});
	


  	$(document).on('keypress', '#input-quantity-main,#input-quantity-option', function(e) {
	    if (e.key.match(/[^0-9]/)) {
	      	return false;
	    };
	    var val = this.value;
	    val = val.substring(0, this.selectionStart) + e.key + val.substring(this.selectionEnd)
	    var intVal = parseInt(val, 10);
	    if (intVal < 0 || intVal > 30)
	      	return false;
  	});

  	$(document).on('input', '#input-quantity-main,#input-quantity-option', function(e) {
	    var val = (!this.value.match(/^\d+$/)) ? -1 : parseInt(this.value, 10);
	    if (val < 1) {
	      val = 1;
	      this.value = val;
	    } else if (val > 30) {
	      val = 30;
	      this.value = val;
	    }
  	});





	$('.product-tabs ul.nav-pills li:first-child a').click();
	
	// New mobile Tabs
	let M2 = document.querySelector(".js-dragscroll-wrap2");
	if ($(window).width() >= 768){
		if (M2) {
			let e2 = M2.querySelector(".js-dragscroll2");
			new ScrollBooster({
				viewport: M2,
				content: e2,
				emulateScroll: false,
				mode: "x",
				direction: 'horizontal',
				bounceForce: .2, onUpdate: t2 => {
					e2.style.transform = `translate(\n                  ${-t2.position.x}px, 0px                )`
				}
			})
		}
	} else if ($(window).width() < 768) {
		setTimeout(function(){

			let selectWrap = document.querySelector(".js-dragscroll-wrap2");
			let selectTrigger = document.createElement('button');
			let list = document.querySelector(".js-dragscroll2");
			let listTabs = document.querySelectorAll(".js-dragscroll2 li");
			
			selectTrigger.classList.add('tab-selector', 'bbtn');
			selectWrap.insertAdjacentElement('afterbegin', selectTrigger);						
			
			function textInBtn(li){
				selectTrigger.textContent = li.textContent;
			}
			
			if(listTabs){
				listTabs.forEach((element)=>{
					if(element.classList.contains('active')){
						textInBtn(element);
					}
					element.addEventListener('click', function(){
						textInBtn(element);
						list.classList.toggle('show');
					});
				});
				selectTrigger.addEventListener('click', function(){
					list.classList.toggle('show');
				});
			};
			
			window.addEventListener('click', e => { 
				const target = e.target 
				if (!target.closest('.js-dragscroll-wrap2')) {
					list.classList.remove('show');
				}
			})
		},100)
	}
	
	
	
	
	
	
	
</script>

<?php echo $footer; ?>