<div id="<?php echo $tag_id?>" class="so-deal <?php echo ($position_thumbnail == 'vertical' ? 'slick-vertical' : 'slick-horizontal')?> so-deals-slick deals-slider-preload">
	<div class="so-deals-slider-loading"></div>
	<div class="deals-nav"></div>
	<div class="deals-content">
		<div class="ds-items">
			<?php
			$j = 0;
			foreach ($list as $product){ $j++;	
			?>
			<div class="ds-item cf <?php echo ($j==1 ? 'active' : ''); ?>">
				<div class="ds-item-inner">
					<div class="ds-image-thumb">
						<img src="<?php echo $product['thumb']?>" alt="<?php echo $product['name'] ?>" class="img-responsive">
					</div>
				</div>
			</div>
			<?php }?>
		</div>
		<div class="ds-items-detail">
		<?php 
		$p = 0;
		foreach ($list as $product){ $p++;
		?>
			<div class="item <?php echo ($p==1 ? 'active' : ''); ?>">
				<div class="product-thumb transition">
					<div class="image">
						<?php if ($product['special'] && $display_sale) : ?>
							<span class="label label-sale"><?php echo $objlang->get('text_sale'); ?>
								<?php if(!isset($discount_status) || $discount_status) echo $product['discount']; ?>
							</span>
						<?php endif; ?>
						<?php if ($product['productNew'] && $display_new) : ?>
							<span class="label label-new"><?php echo $objlang->get('text_new'); ?></span>
						<?php endif; ?>
						<?php if($product_image) { ?>
							<a href="<?php echo $product['href'];?>" target="<?php echo $item_link_target;?>">
								<?php if($product_image_num ==2){?>
									<img src="<?php echo $product['thumb']?>" class="img-thumb1 img-responsive" alt="<?php echo $product['name'] ?>">
									<img src="<?php echo $product['thumb2']?>" class="img-thumb2 img-responsive" alt="<?php echo $product['name'] ?>">
								<?php }else{?>
									<img src="<?php echo $product['thumb']?>" alt="<?php echo $product['name'] ?>" class="img-responsive">
								<?php }?>
							</a>
						 <?php } ?>
					</div>					
					<div class="captions">
						<?php if($display_title == 1) { ?>
						<h4><a href="<?php echo $product['href']; ?>" target="<?php echo $item_link_target;?>" title="<?php echo $product['name']; ?>" ><?php echo $product['name_maxlength']; ?></a></h4>
						<?php } ?>
						<?php if($display_rating):?>
						<div class="rating">
							<?php for ($j = 1; $j <= 5; $j++) { ?>
							<?php if ($product['rating'] < $j) { ?>
								<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
							<?php } else { ?>
								<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
							<?php } ?>
							<?php } ?>
						</div>
						<?php endif;?>
						<?php if($display_description){ ?>
						<p><?php echo  html_entity_decode($product['description_maxlength']); ?></p>
						<?php } ?>
						
						<?php if ($product['price'] && $display_price) { ?>
						<p class="price">
							<?php if (!$product['special']) { ?>
							<?php echo $product['price']; ?>
							<?php } else { ?>
							<span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
							<?php } ?>
							<?php if ($product['tax']) { ?>
							<span class="price-tax"><?php echo $objlang->get('text_tax'); ?> <?php echo $product['tax']; ?></span>
							<?php } ?>
						</p>
						<?php } ?>
						<?php if($display_addtocart || $display_wishlist || $display_compare){	?>								
							<div class="button-group">	
								<?php if($display_addtocart){?>
									<button class="addToCart btn-button" type="button" data-toggle="tooltip" title="<?php echo $objlang->get('button_cart'); ?>" onclick="cart.add('<?php echo $product['product_id']; ?>');">
										<span><?php echo $objlang->get('button_cart'); ?></span>
									</button>
								<?php } ?>
								
														
								<?php if($display_wishlist){?>
									<button class="wishlist btn-button" type="button" data-toggle="tooltip" title="<?php echo $objlang->get('button_wishlist'); ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
								<?php } ?>
								
								
								<?php if($display_compare){?>
									<button class="compare btn-button" type="button" data-toggle="tooltip" title="<?php echo $objlang->get('button_compare'); ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-refresh"></i></button>
								<?php }?>																	
							</div>
						<?php } ?>
					
					</div>
					<div class="item-time">							
						<div class="item-timer product_time_<?php echo $product['product_id']?>"></div>
						<script type="text/javascript">
							//<![CDATA[
							listdeal<?php echo $module?>.push('product_time_<?php echo $product['product_id']?>|<?php echo $product['specialPriceToDate'] ?>');
							//]]>
						</script>
					</div>
					
				</div>
			</div>
		<?php }?>
		</div>
	</div>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function ($) {  ;
	(function (element) {
		var $element = $(element);
		setTimeout(function () {
			$('.so-deals-slider-loading', $element).remove();
			$element.removeClass('deals-slider-preload');
			__runDealsSlider();
		}, 1000);
		function __runDealsSlider() {
		var sync1 = $('.ds-items-detail',$element),
			sync2 = $('.ds-items',$element);

		sync2.slick({
			<?php if($position_thumbnail =='vertical') { ?>
				vertical:true,
			<?php } ?>
			arrows: false,
			autoplay: <?php echo $autoplay; ?>,
			slidesToShow: <?php echo $nb_column0;?>,
			slidesToScroll: <?php echo $slideBy; ?>,
			infinite: <?php echo $loop; ?>,
			initialSlide: <?php echo $startPosition; ?>,
			speed: <?php echo $autoplayTimeout ?>,
			autoplaySpeed: <?php echo $autoplaySpeed ;?>,
			asNavFor: '#<?php echo $tag_id;?> .ds-items-detail',
			pauseOnHover: <?php echo $autoplayHoverPause ;?>,
			dots: false,
			centerMode: false,
			focusOnSelect: true,
			responsive: [
				{
					breakpoint: 1199,
					settings: {
						slidesToShow: <?php echo $nb_column0;?>,
						slidesToScroll: <?php echo $slideBy; ?>
					}
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: <?php echo $nb_column1;?>,
						slidesToScroll: <?php echo $slideBy; ?>
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: <?php echo $nb_column2;?>,
						slidesToScroll: <?php echo $slideBy; ?>
					}
				},
				{
					breakpoint: 479,
					settings: {
						slidesToShow: <?php echo $nb_column3;?>,
						slidesToScroll: <?php echo $slideBy; ?>
					}
				},
				{
					breakpoint: 320,
					settings: {
						slidesToShow: <?php echo $nb_column4;?>,
						slidesToScroll: <?php echo $slideBy; ?>
					}
				}
			]
		});

		sync1.slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: <?php echo $autoplay; ?>,
			infinite: <?php echo $loop; ?>,
			arrows: <?php echo $navs; ?>,	
			initialSlide: 0,
			//fade: true,
			speed: <?php echo $autoplayTimeout ?>,
			autoplaySpeed: <?php echo $autoplaySpeed ;?>,
			focusOnSelect: true,
			rtl: <?php echo $direction ;?>,
			pauseOnHover: <?php echo $autoplayHoverPause ;?>,
			appendArrows: "#<?php echo $tag_id?> .deals-nav",
			prevArrow: '<span class="slick-prev">&#60;</span>', 
			nextArrow: '<span class="slick-next">&#62;</span>',
			asNavFor: '#<?php echo $tag_id;?> .ds-items'
		});
		<?php if(count($list) <= 1){?>
			$('#<?php echo $tag_id?> .deals-nav').hide();
		<?php }?>
	}
	data = new Date(2013, 10, 26, 12, 00, 00);
	function CountDown(date, id) {
		dateNow = new Date();
		amount = date.getTime() - dateNow.getTime();
		if (amount < 0 && $('#' + id).length) {
			$('.' + id).html("Now!");
		} else {
			days = 0;
			hours = 0;
			mins = 0;
			secs = 0;
			out = "";
			amount = Math.floor(amount / 1000);
			days = Math.floor(amount / 86400);
			amount = amount % 86400;
			hours = Math.floor(amount / 3600);
			amount = amount % 3600;
			mins = Math.floor(amount / 60);
			amount = amount % 60;
			secs = Math.floor(amount);
			if (days != 0) {
				out += "<div class='time-item time-day'>" + "<div class='num-time'>" + days + "</div>" + " <div class='name-time'>" + ((days == 1) ? "<?php echo $objlang->get('text_Day');?>" : "<?php echo $objlang->get('text_Days');?>") + "</div>" + "</div> ";
			}
			if(days == 0 && hours != 0)
			{
				 out += "<div class='time-item time-hour' style='width:33.33%'>" + "<div class='num-time'>" + hours + "</div>" + " <div class='name-time'>" + ((hours == 1) ? "<?php echo $objlang->get('text_Hour');?>" : "<?php echo $objlang->get('text_Hours');?>") + "</div>" + "</div> ";
			}else if (hours != 0) {
				out += "<div class='time-item time-hour'>" + "<div class='num-time'>" + hours + "</div>" + " <div class='name-time'>" + ((hours == 1) ? "<?php echo $objlang->get('text_Hour');?>" : "<?php echo $objlang->get('text_Hours');?>") + "</div>" + "</div> ";
			}
			if(days == 0 && hours != 0)
			{
				out += "<div class='time-item time-min' style='width:33.33%'>" + "<div class='num-time'>" + mins + "</div>" + " <div class='name-time'>" + ((mins == 1) ? "<?php echo $objlang->get('text_Min');?>" : "<?php echo $objlang->get('text_Mins');?>") + "</div>" + "</div> ";
				out += "<div class='time-item time-sec' style='width:33.33%'>" + "<div class='num-time'>" + secs + "</div>" + " <div class='name-time'>" + ((secs == 1) ? "<?php echo $objlang->get('text_Sec');?>" : "<?php echo $objlang->get('text_Secs');?>") + "</div>" + "</div> ";
				out = out.substr(0, out.length - 2);
			}else if(days == 0 && hours == 0)
			{
				out += "<div class='time-item time-min' style='width:50%'>" + "<div class='num-time'>" + mins + "</div>" + " <div class='name-time'>" + ((mins == 1) ? "<?php echo $objlang->get('text_Min');?>" : "<?php echo $objlang->get('text_Mins');?>") + "</div>" + "</div> ";
				out += "<div class='time-item time-sec' style='width:50%'>" + "<div class='num-time'>" + secs + "</div>" + " <div class='name-time'>" + ((secs == 1) ? "<?php echo $objlang->get('text_Sec');?>" : "<?php echo $objlang->get('text_Secs');?>") + "</div>" + "</div> ";
				out = out.substr(0, out.length - 2);
			}else{
				out += "<div class='time-item time-min'>" + "<div class='num-time'>" + mins + "</div>" + " <div class='name-time'>" + ((mins == 1) ? "<?php echo $objlang->get('text_Min');?>" : "<?php echo $objlang->get('text_Mins');?>") + "</div>" + "</div> ";
				out += "<div class='time-item time-sec'>" + "<div class='num-time'>" + secs + "</div>" + " <div class='name-time'>" + ((secs == 1) ? "<?php echo $objlang->get('text_Sec');?>" : "<?php echo $objlang->get('text_Secs');?>") + "</div>" + "</div> ";
				out = out.substr(0, out.length - 2);
			}

			$('.' + id).html(out);

			setTimeout(function () {
				CountDown(date, id);
			}, 1000);
		}
	}
	if (listdeal<?php echo $module?>.length > 0) {
		for (var i = 0; i < listdeal<?php echo $module?>.length; i++) {
			var arr = listdeal<?php echo $module?>[i].split("|");
			if (arr[1].length) {
				var data = new Date(arr[1]);
				CountDown(data, arr[0]);
			}
		}
	}
	})('#<?php echo $tag_id?>');
	});
	//]]>
</script>
</div>