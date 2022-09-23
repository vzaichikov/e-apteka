<?php echo $header; ?>
<?php echo $seo; ?>
<script src="catalog/view/theme/default/js/swiper.min.js" type="text/javascript"></script>
<?php include(DIR_TEMPLATEINCLUDE . 'structured/breadcrumbs.tpl'); ?>

<style>
	.share-buttons{margin:0 auto}.share-block{display:inline-block;background:#fff;width:40px;height:40px;margin-bottom:16px;border:1px solid #ccc;text-align:center;transition:.5s}.share-block:hover{animation:share-animation .82s cubic-bezier(.36,.07,.19,.97) both;border-color:#00b5a5}.share-block i{font-size:18px;position:relative;top:11px}.share-block span{display:block;position:relative;top:-9px;font-size:10px;line-height:1}.share-buttons .facebook{color:#3b5998}.share-buttons .email{color:#00b5a5}.share-buttons .pinterest{color:#cc2127}.share-buttons .twitter{color:#55acee}.share-buttons .viber{color:#7360f2}.share-buttons .telegram{color:#0088cc}.share-buttons .general-share{color:#7cbc00}.@keyframes share-animation{10%,90%{transform:translate3d(-1px,0,0)}20%,80%{transform:translate3d(2px,0,0)}30%,50%,70%{transform:translate3d(-4px,0,0)}40%,60%{transform:translate3d(4px,0,0)}}
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
			
			<div class="row">				
				<div class="<?php if ($quantity_stock > 0) { ?>col-md-8<?php } else { ?>col-md-12<?php } ?> col-sm-12">
					<div class="row">
						<div class="<?php if ($quantity_stock > 0) { ?>col-sm-4<?php } else { ?>col-sm-2<?php } ?>">
							<?php if ($thumb || $images) { ?>
								<ul class="thumbnails">
									<?php if ($thumb) { ?>
										<li><a class="thumbnail zoom-foto" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>">
											<img  <?php if ($quantity_stock == 0) { ?>style="filter: grayscale(100%);"<?php } ?> src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
										</a>
										</li>
									<?php } ?>
									<?php if ($images) { ?>
										<?php foreach ($images as $image) { ?>
											<li class="image-additional zoom-foto"><a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							<?php } ?>
						</div>
						
						<div class="<?php if ($quantity_stock > 0) { ?>col-sm-8<?php } else { ?>col-sm-10<?php } ?>">	
							<?php if ($quantity_stock > 0) { ?>
								
								<!-- div class="product__text-row product__model">
									<?php echo $text_model; ?> <?php echo $model; ?>
								</div-->
								
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
											
											<?php if ($free_shipping_ukraine) { ?>
												<div class="product__freedelivery-wrap row" style="margin:0px;">
													<div class="col-lg-7 col-md-7 col-sm-10 col-xs-12 pull-right alert alert-info">
														<i class="fa fa-ambulance" aria-hidden="true"></i>&nbsp;&nbsp;<b><?php echo $text_free_shipping_ukraine; ?></b>
													</div>
												</div>
												<?php } elseif ($free_shipping_kyiv) { ?>
												<div class="product__freedelivery-wrap row" style="margin:0px;">
													<div class="col-lg-7 col-md-7 col-sm-10 col-xs-12 pull-right alert alert-info">
														<i class="fa fa-ambulance" aria-hidden="true"></i>&nbsp;&nbsp;<b><?php echo $text_free_shipping_kyiv; ?></b>
													</div>
												</div>	
											<?php } ?>
											
											<?php if (!$special) { ?>
												<div class="product__price-wrap">
													<span class="product__price"><?php echo $price; ?></span>
												</div>
												<?php } else { ?>
												<div class="product__price-wrap is-special">
													<span class="product__price"><?php echo $special; ?></span>
													<span class="product__old-price"><?php echo $price; ?></span>
												</div>
											<?php } ?>
										<?php } ?>
										<? } else { ?>
										<div class="product__price-wrap product__not-in-stock">
											<span class="product__price"><?php echo $text_not_in_stock; ?></span>
										</div>
									<? } ?>
									
									<?php if ($quantity_stock > 0) { ?>	
										<div id="product">			
											<?php if ($minimum > 1) { ?>
												<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
											<?php } ?>
										</div>
										
										<?php if ($is_receipt) { ?>
											<div class="text-danger">
												<i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $text_is_receipt; ?>
											</div>
										<?php } ?>		
										
										<?php if ($is_thermolabel) { ?>
											<div class="text-info">
												<i class="fa fa-snowflake-o" aria-hidden="true"></i> <?php echo $text_product_is_thermolabel; ?>
											</div>
										<?php } ?>
										
										<div class="button-group product__button-group">
											<?php if($quantity_stock != 0) { ?>
												<div class="form-group">								
													<div class="input-count">
														<button class="input-count__btn js-input-count-minus">–</button>
														<input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="input-count__num">
														<button class="input-count__btn js-input-count-plus">+</button>
														<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
													</div>
												</div>
											<?php } ?>
											
											<?php if ($quantity_stock > 0) { ?>
												<button id="main-add-cart-button" class="bbtn bbtn-primary product__btn-cart" type="button" data-loading-text="<?php echo $text_loading; ?>"><?php echo $button_cart; ?></button>
												
												<script>
													$('body').on('click', '#main-add-cart-button', function(){													
														let quantity=$('#input-quantity').val(); 
														cart.add('<?php echo $product_id; ?>', quantity);
													});
												</script>
												
												<?php } else { ?>							
											<?php } ?>
										<button class="bbtn bbtn--transparent product__btn-wishlist" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><svg class="icon featured__wishlist-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#heart"></use></svg></button>
									<button class="bbtn bbtn--transparent product__btn-compare" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><svg class="icon featured__compare-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#balance"></use></svg></button>
								</div>
								
								<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/options.tpl'); ?>
								
								
								
								<div class="product__text-row product__manufacturer row">
									<div class="col-sm-12 col-md-7"><code><?php echo $text_manufacturer; ?> <a href="<?php echo $manufacturers; ?>" title="<?php echo $manufacturer; ?>"><?php echo $manufacturer; ?></a></code></div>
									
									<?php if ($brand) { ?>
										<div class="col-sm-12 col-md-5"><code><?php echo $text_brand; ?> <?php echo $brand; ?></code></div>
									<?php } ?>
								</div>
								
								<?php if ($collection) { ?>
									<div class="product__text-row product__manufacturer">									
										<a href="<?php echo $collection_href; ?>" title="<?php echo $manufacturer; ?> <?php echo $collection; ?>">
											<span class="label label-success" style="font-size:100%"><?php echo $collection; ?> <i class="fa fa-external-link"></i></span>
										</a>
									</div>
								<?php } ?>
								
								<?php if ($quantity_stock > 0) { ?>
									<div class="product__stock text-success"><?php echo $stock; ?></div>
								<?php } ?>
								
								
								<?php if ($review_status) { ?>
									<div class="rating">
										<?php for ($i = 1; $i <= 5; $i++) { ?>
											<?php if ($rating < $i) { ?>
											<svg class="icon rating__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
											<?php } else { ?>
										<svg class="icon rating__icon is-active"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use></svg>
									<?php } ?>
								<?php } ?>
								<span class="rating__text"><a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({ scrollTop: $('#review-anchor').offset().top }, 1000); return false;"><?php echo $reviews; ?></a> / <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({ scrollTop: $('#review-anchor').offset().top }, 1000); return false;"><?php echo $text_write; ?></a></span>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		
		
		<?php if ($proposal) { ?>
			<div class="col-xs-12">		
				<div class="recently-viewed__wrap" id="proposal">
					<div class="container-not-wide">
						<div class="bestseller recently-viewed slider slider--tabs js-tab-slider">
							<div class="slider__header <?php if (isset($is_goog_proposal)) { ?>slider__header-green<?php } ?>">								
								<span class="slider__title">
									<?php if($proposal_text) { ?>
										<?php echo $proposal_text; ?>
									<?php } ?>
								</span>
								
								<?php $tab_num = 0; ?>
								<div class="slider__arrows js-tab-num-<?php echo $tab_num++; ?>">
									<div class="slider__arrow slider__arrow--prev">
										<svg class="icon">
										<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
									</svg>
								</div>
								<div class="slider__arrow slider__arrow--next">
									<svg class="icon">
									<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
								</svg>
							</div>
						</div>
					</div>
					
					
					<div class="slider-tab-nav__wrap">
						<div class="slider-tab-nav__arrow slider-tab-nav__arrow--prev">
							<svg class="icon">
							<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
						</svg>
					</div>
					<div class="slider-tab-nav__arrow slider-tab-nav__arrow--next">
						<svg class="icon">
						<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
					</svg>
				</div>
				<div class="slider-tab-nav__inner">
					<ul class="slider__tab-nav slider-tab-nav">
						<?php $tab_num = 0; ?>					
						<li class="slider-tab-nav__item" data-tab="js-tab-num-<?php echo $tab_num++; ?>"><?php //echo $categ['name'];?></li>					
					</ul>
				</div>
			</div>
			
			<div class="slider__tab-cont slider-tab-cont" style="padding:10px;">
				<?php $tab_num = 0; ?>
				<div class="slider__tab slider-tab js-tab-num-<?php echo $tab_num++; ?>">
					<div class="bestseller-list slider__list">
						<?php foreach ($proposal as $product) { ?>
							<div class="bestseller-list__item slider__item">
								
								<div class="product-layout">
									<div class="product-layout__image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" loading="lazy"></a></div>
									
									<div class="product-layout__caption">
										<h4 class="product-layout__name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
										<?php if($product['quantity'] > 0) { ?>
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
											<p class="price price-not-in-stock"><?php echo $text_not_in_stock; ?></p>
										<?php } ?>
									</div>
									
									<div class="button-group">
										
										<?php if($product['quantity'] > 0) { ?>
											<button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></button>
										<?php } ?>
										
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
				</div>
			</div>
		</div>
	</div>
</div>  <!-- /.bestseller__wrap -->
</div>
<?php } ?>

</div>
</div>					
<?php if ($quantity_stock > 0) { ?>
	<div class="col-md-4 col-sm-12">
		<?php echo $content_top; ?>		
	</div>
<? } ?>

</div>




<div class="row product-tabs">
	<div class="col-sm-12">
		<ul class="nav nav-pills">
			<?php if ( isset($description) && !empty(strip_tags($description)) ) { ?>
				<li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?><svg class="product-tabs__nav-icon">
				<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#edit"></use>
				</svg></a></li>
		<?php } ?>
		
		<?php if ( isset($instruction) && !empty($instruction) ) { ?>
			<li><a href="#tab-instruction" data-toggle="tab"><?php echo $tab_instruction;?><svg class="product-tabs__nav-icon">
			<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#instruction"></use>
			</svg></a></li>
	<?php } ?>
	
	<?php if ( isset($same) && count($same)>0 ) { ?>
		<li><a href="#tab-forms-of-release" data-toggle="tab"><?php echo $tab_same;?><svg class="product-tabs__nav-icon">
		<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#plus"></use>
		</svg></a></li>
<?php } ?>

<?php if ( isset($analogs) && count($analogs)>0 ) { ?>
	<li><a href="#tab-analog" data-toggle="tab"><?php echo $tab_analogs;?><svg class="product-tabs__nav-icon">
	<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#plus"></use>
	</svg></a></li>
<?php } ?>

<?php if ($attribute_groups) { ?>
	<li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?><svg class="product-tabs__nav-icon">
	<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#bars"></use>
	</svg></a></li>
<?php } ?>

<?php if ($review_status) { ?>
	<li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?><svg class="product-tabs__nav-icon">
	<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#thumbs-up-2"></use>
	</svg></a></li>
<?php } ?>
</ul>
<div class="tab-content product-tabs__content">
	<?php if ( isset($description) && !empty($description) ) { ?>
		<div class="tab-pane information-text-style active" id="tab-description" style="max-height:500px; overflow-y:scroll;"><?php echo $description; ?></div>
	<?php } ?>
	
	<?php if ( isset($instruction) && !empty($instruction) ) { ?>
		<div class="tab-pane information-text-style" id="tab-instruction" style="max-height:500px; overflow-y:scroll;"><?php echo $instruction; ?></div>
	<?php } ?>
	
	<?php if ( isset($same) && count($same)>0 ) { ?>
		<div class="tab-pane" id="tab-forms-of-release">
			<div class="product-category-list">
				<?php foreach ($same as $product) { ?>
					<?php include(dirname(__FILE__).'/single.tpl'); ?>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	
	<?php if ( isset($analogs) && count($analogs)>0 ) { ?>
		<div class="tab-pane" id="tab-analog">
			<div class="product-category-list">
				<?php foreach ($analogs as $product) { ?>
					<?php include(dirname(__FILE__).'/single.tpl'); ?>
				<?php } ?>
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
					</tbody>
				<?php } ?>
			</table>
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
</div>
</div>


<?php if ($hobofaq) { ?>
	<div class="col-xs-12"><?php echo $hobofaq; ?></div>
<?php } ?>


<?php if($products || $collection_products){ ?>
</div></div>  <?php // тут "разрываем" внешние обертки, для того, чтобы сделать фон на всю ширину  ?>

<?php if ($collection_products) { ?>	
	<div class="recently-viewed__wrap" id="collection-products">
		<div class="container">
			<div class="bestseller recently-viewed slider slider--tabs js-tab-slider">
				<div class="slider__header slider__header-green">								
					<span class="slider__title" >
						<?php echo $collection; ?>
					</span>
					
					<?php $tab_num = 0; ?>
					<div class="slider__arrows js-tab-num-<?php echo $tab_num++; ?>">
						<div class="slider__arrow slider__arrow--prev">
							<svg class="icon">
							<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
						</svg>
					</div>
					<div class="slider__arrow slider__arrow--next">
						<svg class="icon">
						<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
					</svg>
				</div>
			</div>
		</div>
		
		
		<div class="slider-tab-nav__wrap">
			<div class="slider-tab-nav__arrow slider-tab-nav__arrow--prev">
				<svg class="icon">
				<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
			</svg>
		</div>
		<div class="slider-tab-nav__arrow slider-tab-nav__arrow--next">
			<svg class="icon">
			<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
		</svg>
	</div>
	<div class="slider-tab-nav__inner">
		<ul class="slider__tab-nav slider-tab-nav">
			<?php $tab_num = 0; ?>					
			<li class="slider-tab-nav__item" data-tab="js-tab-num-<?php echo $tab_num++; ?>"><?php //echo $categ['name'];?></li>					
		</ul>
	</div>
</div>

<div class="slider__tab-cont slider-tab-cont" style="padding:10px">
	<?php $tab_num = 0; ?>
	<div class="slider__tab slider-tab js-tab-num-<?php echo $tab_num++; ?>">
		<div class="bestseller-list slider__list">
			<?php foreach ($collection_products as $product) { ?>
				<div class="bestseller-list__item slider__item">
					
					<div class="product-layout">
						<div class="product-layout__image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" loading="lazy"></a></div>
						
						<div class="product-layout__caption">
							<h4 class="product-layout__name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
							<?php if($product['quantity'] > 0) { ?>
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
								<p class="price price-not-in-stock"><?php echo $text_not_in_stock; ?></p>
							<?php } ?>
						</div>
						
						<div class="button-group">
							
							<?php if($product['quantity'] > 0) { ?>
								<button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></button>
							<?php } ?>
							
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
	</div>
</div>
</div>
</div>
</div>  <!-- /.bestseller__wrap -->
<?php } ?>

<div class="bestseller__wrap">
	<div class="container">
		<div class="bestseller product-analog slider js-tab-slider">
			<div class="slider__header">
				<div class="slider__icon-wrap">
					<!--<svg class="icon slider__icon">
						<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use>
					</svg>-->
					<img src="/image/catalog/icon/related.png" style="margin: 10px;" alt="">
					
				</div>
				<h3 class="slider__title">С этим товаром покупают</h3>
				
				<?php $tab_num = 0; ?>
				<?php //foreach($categories as $categ){ ?>
				<div class="slider__arrows js-tab-num-<?php echo $tab_num++; ?>">
					<div class="slider__arrow slider__arrow--prev">
						<svg class="icon">
						<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
					</svg>
				</div>
				<div class="slider__arrow slider__arrow--next">
					<svg class="icon">
					<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
				</svg>
			</div>
		</div>
		<?php //} ?>
	</div>
	
	
	<div class="slider-tab-nav__wrap">
		<div class="slider-tab-nav__arrow slider-tab-nav__arrow--prev">
			<svg class="icon">
			<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
		</svg>
	</div>
	<div class="slider-tab-nav__arrow slider-tab-nav__arrow--next">
		<svg class="icon">
		<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
	</svg>
</div>
<div class="slider-tab-nav__inner">
	<ul class="slider__tab-nav slider-tab-nav">
		<?php $tab_num = 0; ?>
		<?php //foreach($categories as $categ){ ?>
		<li class="slider-tab-nav__item" data-tab="js-tab-num-p<?php echo $tab_num++; ?>"><?php //echo $categ['name'];?></li>
		<?php //} ?>
	</ul>
</div>
</div>

<div class="slider__tab-cont slider-tab-cont">
	<?php $tab_num = 0; ?>
	<?php //foreach($categories as $categ){ ?>
	<div class="slider__tab slider-tab js-tab-num-p<?php echo $tab_num++; ?>">
		<div class="bestseller-list slider__list">
            <?php foreach ($products as $product) { ?>
				<div class="bestseller-list__item slider__item">
					
					<div class="product-layout">
						<div class="product-layout__image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" loading="lazy"></a></div>
						
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
</div>




</div>
<?php //} ?>
</div>
</div>
</div>
</div>  <!-- /.bestseller__wrap -->

<div class="container"><div class="row">  <?php // тут востанавливаем" внешние обертки, которые "разрывали" в начале блока  ?>
	
    <?php if (false) { ?>
		<div class="row">
			<?php if ($column_left && $column_right) { ?>
				<?php $class = 'col-xs-8 col-sm-6'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
				<?php $class = 'col-xs-6 col-md-4'; ?>
				<?php } else { ?>
				<?php $class = 'col-xs-6 col-sm-3'; ?>
			<?php } ?>
			<div class="<?php echo $class; ?>">
				<div class="product-thumb transition">
					<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
					<div class="caption">
						<h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
						<!--p><?php //echo $product['description']; ?></p-->
						<?php if ($product['rating']) { ?>
							<div class="rating">
								<?php for ($j = 1; $j <= 5; $j++) { ?>
									<?php if ($product['rating'] < $j) { ?>
										<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
										<?php } else { ?>
										<span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
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
						<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span> <i class="fa fa-shopping-cart"></i></button>
						<button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
						<button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
					</div>
				</div>
			</div>
			<?php if (($column_left && $column_right) && (($i+1) % 2 == 0)) { ?>
				<div class="clearfix visible-md visible-sm"></div>
				<?php } elseif (($column_left || $column_right) && (($i+1) % 3 == 0)) { ?>
				<div class="clearfix visible-md"></div>
				<?php } elseif (($i+1) % 4 == 0) { ?>
				<div class="clearfix visible-md"></div>
			<?php } ?>
			<?php $i++; ?>
		</div>
	<?php } ?>
<?php } ?>



<?php if ($stocks) { ?>
</div></div> <?php // тут "разрываем" внешние обертки, для того, чтобы сделать фон на всю ширину  ?>
<div class="container-fluid">
	
	<div class="row">
		<div class="col-md-12">
			<br>
			<h2 id="trigger-show-maps" class="product-stock-map__title"><?php echo $text_wherebuy; ?> <?php echo $heading_title; ?></h2>
		</div>
	</div>
	
    <div class="product__stock-map product-stock-map"  style="height: 494px;">
		<style type="text/css">
			.text-danger1{color: #a94442 !important;}
		</style>		
		
		<div id="stock-table-wrapper" class="col-md-4 col-sm-12 col-xs-12 col-no-right-padding product-stock-map__table-wrapper scrolly" style="height:100%">
			<table id="stock-table" class="table table-condensed table-bordered table-responsive product-stock-map__table">
				<?php $i=0; foreach ($stocks as $stock) { ?>
					<tr <?php if ($stock['geocode']) { ?>class="location_has_geocode" data-i="<?php echo $i; ?>"<?php } ?>>
						<td>
							<b class="product-stock-map__name"><?php echo $stock['address']; ?></b><br />
							<span class="product-stock-map__time"><i class="fa fa-clock-o <? echo $stock['faclass']; ?>"></i> <i><?php echo $stock['open']; ?></i></span>
						</td>
						<td style="white-space: nowrap;" class="<?php echo $stock['tdclass']; ?>">
							<b><?php echo $stock['price']; ?></b>
							<?php if ($is_preorder) { ?>
								<br /><span class="small"><?php echo mb_strtolower($text_preorder); ?></span>
							<?php } ?>
						</td>
					</tr>
				<?php $i++; } ?>
			</table>
		</div>
		
		<div class="col-md-8 col-sm-12 col-xs-12 col-no-left-padding" style="height:100%;position: relative;">
			<div id="stock-map" style="height:100%;position: relative;"></div>
		</div>
		
		
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
		
		<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
		
		<script>
			!function(t){var i=t(window);t.fn.visible=function(t,e,o){if(!(this.length<1)){var r=this.length>1?this.eq(0):this,n=r.get(0),f=i.width(),h=i.height(),o=o?o:"both",l=e===!0?n.offsetWidth*n.offsetHeight:!0;if("function"==typeof n.getBoundingClientRect){var g=n.getBoundingClientRect(),u=g.top>=0&&g.top<h,s=g.bottom>0&&g.bottom<=h,c=g.left>=0&&g.left<f,a=g.right>0&&g.right<=f,v=t?u||s:u&&s,b=t?c||a:c&&a;if("both"===o)return l&&v&&b;if("vertical"===o)return l&&v;if("horizontal"===o)return l&&b}else{var d=i.scrollTop(),p=d+h,w=i.scrollLeft(),m=w+f,y=r.offset(),z=y.top,B=z+r.height(),C=y.left,R=C+r.width(),j=t===!0?B:z,q=t===!0?z:B,H=t===!0?R:C,L=t===!0?C:R;if("both"===o)return!!l&&p>=q&&j>=d&&m>=L&&H>=w;if("vertical"===o)return!!l&&p>=q&&j>=d;if("horizontal"===o)return!!l&&m>=L&&H>=w}}}}(jQuery);
			;(function(f){"use strict";"function"===typeof define&&define.amd?define(["jquery"],f):"undefined"!==typeof module&&module.exports?module.exports=f(require("jquery")):f(jQuery)})(function($){"use strict";function n(a){return!a.nodeName||-1!==$.inArray(a.nodeName.toLowerCase(),["iframe","#document","html","body"])}function h(a){return $.isFunction(a)||$.isPlainObject(a)?a:{top:a,left:a}}var p=$.scrollTo=function(a,d,b){return $(window).scrollTo(a,d,b)};p.defaults={axis:"xy",duration:0,limit:!0};$.fn.scrollTo=function(a,d,b){"object"=== typeof d&&(b=d,d=0);"function"===typeof b&&(b={onAfter:b});"max"===a&&(a=9E9);b=$.extend({},p.defaults,b);d=d||b.duration;var u=b.queue&&1<b.axis.length;u&&(d/=2);b.offset=h(b.offset);b.over=h(b.over);return this.each(function(){function k(a){var k=$.extend({},b,{queue:!0,duration:d,complete:a&&function(){a.call(q,e,b)}});r.animate(f,k)}if(null!==a){var l=n(this),q=l?this.contentWindow||window:this,r=$(q),e=a,f={},t;switch(typeof e){case "number":case "string":if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(e)){e= h(e);break}e=l?$(e):$(e,q);case "object":if(e.length===0)return;if(e.is||e.style)t=(e=$(e)).offset()}var v=$.isFunction(b.offset)&&b.offset(q,e)||b.offset;$.each(b.axis.split(""),function(a,c){var d="x"===c?"Left":"Top",m=d.toLowerCase(),g="scroll"+d,h=r[g](),n=p.max(q,c);t?(f[g]=t[m]+(l?0:h-r.offset()[m]),b.margin&&(f[g]-=parseInt(e.css("margin"+d),10)||0,f[g]-=parseInt(e.css("border"+d+"Width"),10)||0),f[g]+=v[m]||0,b.over[m]&&(f[g]+=e["x"===c?"width":"height"]()*b.over[m])):(d=e[m],f[g]=d.slice&& "%"===d.slice(-1)?parseFloat(d)/100*n:d);b.limit&&/^\d+$/.test(f[g])&&(f[g]=0>=f[g]?0:Math.min(f[g],n));!a&&1<b.axis.length&&(h===f[g]?f={}:u&&(k(b.onAfterFirst),f={}))});k(b.onAfter)}})};p.max=function(a,d){var b="x"===d?"Width":"Height",h="scroll"+b;if(!n(a))return a[h]-$(a)[b.toLowerCase()]();var b="client"+b,k=a.ownerDocument||a.document,l=k.documentElement,k=k.body;return Math.max(l[h],k[h])-Math.min(l[b],k[b])};$.Tween.propHooks.scrollLeft=$.Tween.propHooks.scrollTop={get:function(a){return $(a.elem)[a.prop]()}, set:function(a){var d=this.get(a);if(a.options.interrupt&&a._last&&a._last!==d)return $(a.elem).stop();var b=Math.round(a.now);d!==b&&($(a.elem)[a.prop](b),a._last=this.get(a))}};return p});
		</script>
		<script>
			var markers = new Array();
			var	windows = new Array();
			
			var markers = new Array();  
			
			function mapInitProductPage() {
				var map = new L.map('stock-map').setView([<?php echo $geocode;?>], 12);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					zIndex : 1,
					attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
				}).addTo(map);
				
				<? unset($stock); $i=0; foreach ($stocks as $stock) { ?>
					<? if ($stock['geocode']) { ?>
						var icon<?php echo $i; ?> = new L.Icon({
							iconUrl: '<? echo $stock['icon']; ?>',
							shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
							iconSize: [25, 41],
							iconAnchor: [12, 41],
							popupAnchor: [1, -34],
							shadowSize: [41, 41]
						});
						
						markers[<? echo $i; ?>] = L.marker([<?php echo $stock['geocode'];?>], {icon:icon<?php echo $i; ?>}).addTo(map).bindPopup('<h4><? echo $stock['name']; ?></a></h4><h4><? echo $stock['price']; ?></h4><h4><span style="color: rgb(255, 0, 0);"></span></h4><p></p><p>Телефон цілодобової довідки та резервування: </p><h4> <span><strong>(044) 520-03-33</strong></span></h4>');				
					<? } ?>
				<? $i++; } ?>
				
				$('tr.location_has_geocode').mouseenter(function(){
					var it = parseInt($(this).attr('data-i'));
					markers[it].openPopup();
				});
			}
			
			$(document).ready(function(){
				var shown = false;			
				$( window ).scroll(function() {
					if ($('#trigger-show-maps').visible() && !shown){
						mapInitProductPage();
						shown = true;
					}
				});
			});
		</script>
	</div>
</div>
<div><div>
<?php } ?>



<?php if(isset($analog) AND $analog){ ?>
</div></div>  <?php // тут "разрываем" внешние обертки, для того, чтобы сделать фон на всю ширину  ?>

<div class="bestseller__wrap product-analog__wrap">
	<div class="container">
		<div class="bestseller product-analog slider slider--tabs js-tab-slider">
			<div class="slider__header">
				<div class="slider__icon-wrap">
					<svg class="icon slider__icon">
					<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#star"></use>
				</svg>
			</div>
			<div class="slider__title">
				<h3>Покупатели, которые просматривали этот товар, также интересуются</h3>
			</div>
			
			<?php $tab_num = 0; ?>
			<?php //foreach($categories as $categ){ ?>
			<div class="slider__arrows js-tab-num-<?php echo $tab_num++; ?>">
				<div class="slider__arrow slider__arrow--prev">
					<svg class="icon">
					<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
				</svg>
			</div>
			<div class="slider__arrow slider__arrow--next">
				<svg class="icon">
				<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
			</svg>
		</div>
	</div>
	<?php //} ?>
</div>


<div class="slider-tab-nav__wrap">
	<div class="slider-tab-nav__arrow slider-tab-nav__arrow--prev">
		<svg class="icon">
		<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
	</svg>
</div>
<div class="slider-tab-nav__arrow slider-tab-nav__arrow--next">
	<svg class="icon">
	<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
</svg>
</div>
<div class="slider-tab-nav__inner">
	<ul class="slider__tab-nav slider-tab-nav">
		<?php $tab_num = 0; ?>
		<?php //foreach($categories as $categ){ ?>
		<li class="slider-tab-nav__item" data-tab="js-tab-num-<?php echo $tab_num++; ?>"><?php //echo $categ['name'];?></li>
		<?php //} ?>
	</ul>
</div>
</div>

<div class="slider__tab-cont slider-tab-cont">
	<?php $tab_num = 0; ?>
	<?php //foreach($categories as $categ){ ?>
	<div class="slider__tab slider-tab js-tab-num-<?php echo $tab_num++; ?>">
		
		
		<div class="bestseller-list slider__list">
            <?php foreach ($analog as $product) { ?>
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
				<button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></button>
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




</div>
<?php //} ?>
</div>
</div>
</div>
</div>  <!-- /.bestseller__wrap -->

<div class="container"><div class="row">  <?php // тут востанавливаем" внешние обертки, которые "разрывали" в начале блока  ?>
	
    <?php if (false) { ?>
		<div class="row">
			<?php if ($column_left && $column_right) { ?>
				<?php $class = 'col-xs-8 col-sm-6'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
				<?php $class = 'col-xs-6 col-md-4'; ?>
				<?php } else { ?>
				<?php $class = 'col-xs-6 col-sm-3'; ?>
			<?php } ?>
			<div class="<?php echo $class; ?>">
				<div class="product-thumb transition">
					<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
					<div class="caption">
						<h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
						<!--p><?php //echo $product['description']; ?></p-->
						<?php if ($product['rating']) { ?>
							<div class="rating">
								<?php for ($j = 1; $j <= 5; $j++) { ?>
									<?php if ($product['rating'] < $j) { ?>
										<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
										<?php } else { ?>
										<span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
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
						<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span> <i class="fa fa-shopping-cart"></i></button>
						<button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
						<button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
					</div>
				</div>
			</div>
			<?php if (($column_left && $column_right) && (($i+1) % 2 == 0)) { ?>
				<div class="clearfix visible-md visible-sm"></div>
				<?php } elseif (($column_left || $column_right) && (($i+1) % 3 == 0)) { ?>
				<div class="clearfix visible-md"></div>
				<?php } elseif (($i+1) % 4 == 0) { ?>
				<div class="clearfix visible-md"></div>
			<?php } ?>
			<?php $i++; ?>
		</div>
	<?php } ?>
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
</div>


<script>
	$(document).ready(function(){
		passEcommerceToDataLayer('productDetail', '<?php echo $product_id?>');
	});
</script>
<script><!--
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

<script type="text/javascript"><!--
	$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
		$.ajax({
			url: 'index.php?route=product/product/getRecurringDescription',
			type: 'post',
			data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
			dataType: 'json',
			beforeSend: function() {
				$('#recurring-description').html('');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();
				
				if (json['success']) {
					$('#recurring-description').html(json['success']);
				}
			}
		});
	});
//--></script>
<script type="text/javascript"><!--
	$('#button-cart').on('click', function() {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
			dataType: 'json',
			beforeSend: function() {
				$('#button-cart').button('loading');
			},
			complete: function() {
				$('#button-cart').button('reset');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();
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
					$('.text-danger').parent().addClass('has-error');
				}
				
				if (json['success']) {
					$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
					
					$('html, body').animate({ scrollTop: 0 }, 'slow');
					
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
//--></script>

<script>
	$('.product-tabs ul.nav-pills li:first-child a').click();
</script>
<?php echo $footer; ?>