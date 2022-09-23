<div id="<?php echo $tag_id; ?>" class="container-slider module <?php echo $direction_class?> <?php echo $class_suffix; ?>">

<?php if($disp_title_module) { ?>
	<h3 class="modtitle"><?php echo $head_name; ?></h3>
<?php } ?>

<?php if($pre_text != ''){
?>
	<div class="form-group">
		<?php echo html_entity_decode($pre_text);?>
	</div>
<?php } ?>

<div class="modcontent">
	<?php
	if (!empty($list)) {
	$btn_prev = '&#139;';
	$btn_next = '&#155;';
	$class_respl = 'preset01-'.$nb_column0.' preset02-'.$nb_column1.' preset03-'.$nb_column2.' preset04-'.$nb_column3.' preset05-'.$nb_column4.'' ;
	$count_item = count($list[0]['product']);
	$i = 0;
	if($list[0]['child_cat']){
		$class_respon = 'slider';
	}else{
		$class_respon = 'slider-full';
	}
	if (!empty($list[0]['child_cat'])) {
		$class_item_full = 'show';
	} else{
		$class_item_full = 'show-image';
	}
	?>
	<div class="page-top">
		<div class="page-title-categoryslider">
			<span>
				<?php if ($cat_title_display == 1) {
				  echo $list[0]['title'];
				 } ?>
			</span>
		</div> <!-- /.page-title-categoryslider-->
	</div> <!-- /.page-top -->
	<div class="categoryslider-content <?php echo $class_item_full; ?> <?php echo $class_respl; ?>">
		<?php if ($cat_image_display == 1) {
		?>
		<div class="item-cat-image">
			<a href="<?php echo $list[0]['link']; ?>" title="<?php echo $list[0]['titleFull']; ?>" target="<?php echo $item_link_target ?>" >
				<img class="categories-loadimage" alt="<?php echo $list[0]['titleFull']; ?>"
					 src="<?php echo $list[0]['image']; ?>"/>
			</a>
		</div> <!-- /.item-cat-image -->
		<?php } ?>
		<?php if(!empty($list[0]['product'])) { ?>
		<div class="slider so-category-slider not-js cols-6" data-effect="<?php echo $effect; ?>" >
			<?php foreach($list[0]['product'] as $product) {
				$i++;
			?>
			<?php if ($i % $nb_rows == 1 || $nb_rows == 1) { ?>
			<div class="item">
			<?php } ?>
				<div class="item-inner product-thumb transition">
					<?php if($product_image){ ?>
					<div class="image">
						<?php if ($product['special'] && $display_sale) : ?>
						<span class="label label-sale"><?php echo $objlang->get('text_sale'); ?></span>
						<?php endif; ?>
						<?php if ($product['productNew'] && $display_new) : ?>
						<span class="label label-new"><?php echo $objlang->get('text_new'); ?></span>
						<?php endif; ?>
						<a class="lt-image" href="<?php echo $product['href'] ?>" target="<?php echo $item_link_target ?>" title="<?php echo $product['name'] ?>">

							<?php if($product_image_num ==2){?>
								<img src="<?php echo $product['thumb']?>" class="img-thumb1" alt="<?php echo $product['name'] ?>">
								<img src="<?php echo $product['thumb2']?>" class="img-thumb2" alt="<?php echo $product['name'] ?>">
							<?php }else{?>
								<img src="<?php echo $product['thumb']?>" alt="<?php echo $product['name'] ?>">
							<?php }?>
						</a>
					</div> 
					<?php }?>
					<div class="caption">
						<?php if ($display_title == 1) { ?>
						<h4>
							<a href="<?php echo $product['href'] ?>" title="<?php echo $product['name'] ?>" target="<?php echo $item_link_target ?>">
								<?php  echo $product['name_maxlength'];?>
							</a>
						</h4>
						<?php } ?>
						<?php if($display_rating):?>
							<?php if ($product['rating']) { ?>
							<div class="rating">
								<?php for ($k = 1; $k <= 5; $k++) { ?>
								<?php if ($product['rating'] < $k) { ?>
								<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
								<?php } else { ?>
								<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
								<?php } ?>
								<?php } ?>
							</div> <!-- /.rating -->
							<?php }else{ ?>
							<div class="rating">
								<?php for ($j = 1; $j <= 5; $j++) { ?>
								<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
								<?php } ?>
							</div> 
							<?php } ?>
						<?php endif;?>
						<?php if ($display_description == 1) { ?>
						<?php echo  html_entity_decode($product['description_maxlength']); ?>
						<?php }
							?>
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
					</div>
					<div class="button-group">
						<?php if($display_addtocart) { ?>
						<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $objlang->get('button_cart'); ?></span></button>
						<?php } ?>
						<?php if($display_wishlist) { ?>
						<button type="button" data-toggle="tooltip" title="<?php echo $objlang->get('button_wishlist'); ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
						<?php } ?>
						<?php if($display_compare) { ?>
						<button type="button" data-toggle="tooltip" title="<?php echo $objlang->get('button_compare'); ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
						<?php } ?>
					</div> 
				</div> 

			<?php if ($i % $nb_rows == 0 || $i == $count_item) { ?>
			</div> 
			<?php } ?>
			<?php } ?>
		</div>
		<?php if (!empty($list[0]['child_cat'])) { ?>
		<div class="item-sub-cat">
			<ul>
				<?php foreach ($list[0]['child_cat'] as $cat_tree) { ?>
				<li>
					<a href="<?php echo $cat_tree['link']; ?>"
					   title="<?php echo $cat_tree['title']; ?>" target="<?php echo $item_link_target ?>" >
						<?php if(strlen($cat_tree['title']) > $cat_sub_title_maxcharacs && $cat_sub_title_maxcharacs != 0) {echo
						utf8_substr(strip_tags(html_entity_decode($cat_tree['title'], ENT_QUOTES, 'UTF-8')), 0, $cat_sub_title_maxcharacs) . '..';}else{ echo $cat_tree['title'];}
						?>
						<?php if ($cat_all_product) { ?>
						<span><?php echo '&nbsp;&nbsp;(' . $cat_tree['all_product'] . ')'.'&nbsp;'; ?></span>
						<?php } ?>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div> 
		<?php } ?>
		<?php } else{ ?>
		<p style="margin: 20px; text-align: center"><?php echo $objlang->get('text_noitem'); ?></p>
		<?php } ?>
		<div class="icon-cate">
			<a title="<?php echo $list[0]['title']; ?>"
			   href="<?php echo $list[0]['link']; ?>">
				<?php echo 'text'; ?>
			</a>
		</div> 
	</div> 
	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function ($) {
		;(function (element) {
			var id = $("#<?php echo $tag_id; ?>");
			var $element = $(element),
					$extraslider = $(".slider", $element),
					_delay = <?php echo $delay; ?>,
			_duration = <?php echo $duration; ?>,
			_effect = '<?php echo $effect; ?>',
					total_item = <?php echo $count_item ; ?>;

			$extraslider.on("initialized.owl.carousel2", function () {
				var $item_active = $(".owl2-item.active", $element);
				if ($item_active.length > 1 && _effect != "none") {
					_getAnimate($item_active);
				}
				else {
					var $item = $(".owl2-item", $element);
					$item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
				}
				var $navpage = $(".page-top .page-title-categoryslider span", id);
				$(".owl2-controls", id).insertAfter($navpage);
				$(".owl2-dot", id).css("display", "none");

			});

			$extraslider.owlCarousel2({
			rtl: <?php echo $direction?>,
			margin: <?php echo $margin;?>,
			slideBy: <?php echo $slideBy;?>,
			autoplay: <?php echo $autoplay;?>,
			autoplayHoverPause: <?php echo $pausehover ;?>,
			autoplayTimeout: <?php echo $autoplay_timeout; ?>,
			autoplaySpeed: <?php echo $autoplaySpeed; ?>,
			startPosition: <?php echo $startPosition; ?>,
			mouseDrag: <?php echo $mouseDrag;?>,
			touchDrag: <?php echo $touchDrag; ?>,
			autoWidth: false,
					responsive: {
				0:{	items: <?php echo $nb_column4;?>,
					nav: total_item <= <?php echo $nb_column4;?> ? false : ((<?php echo $nav ; ?>) ? true: false),
				},
				480:{ items: <?php echo $nb_column3;?>,
					nav: total_item <= <?php echo $nb_column3;?> ? false : ((<?php echo $nav ; ?>) ? true: false),
				},
				768:{ items: <?php echo $nb_column2;?>,
					nav: total_item <= <?php echo $nb_column2;?> ? false : ((<?php echo $nav ; ?>) ? true: false),
				},
				992:{ items: <?php echo $nb_column1;?>,
					nav: total_item <= <?php echo $nb_column1;?> ? false : ((<?php echo $nav ; ?>) ? true: false),
				},
				1200:{ items: <?php echo $nb_column0;?>,
					nav: total_item <= <?php echo $nb_column0;?> ? false : ((<?php echo $nav ; ?>) ? true: false),
				}
			},

			nav: <?php echo $nav; ?>,
			loop: true,
					navSpeed: <?php echo $navSpeed; ?>,
			navText: ["<?php echo $btn_prev; ?>", "<?php echo $btn_next; ?>"],
					navClass: ["owl2-prev", "owl2-next"]

		});

		$extraslider.on("translate.owl.carousel2", function (e) {

			var $item_active = $(".owl2-item.active", $element);
			_UngetAnimate($item_active);
			_getAnimate($item_active);
		});

		$extraslider.on("translated.owl.carousel2", function (e) {


			var $item_active = $(".owl2-item.active", $element);
			var $item = $(".owl2-item", $element);

			_UngetAnimate($item);

			if ($item_active.length > 1 && _effect != "none") {
				_getAnimate($item_active);
			} else {

				$item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});

			}
		});

		function _getAnimate($el) {
			if (_effect == "none") return;
			//if ($.browser.msie && parseInt($.browser.version, 10) <= 9) return;
			$extraslider.removeClass("extra-animate");
			$el.each(function (i) {
				var $_el = $(this);
				$(this).css({
					"-webkit-animation": _effect + " " + _duration + "ms ease both",
					"-moz-animation": _effect + " " + _duration + "ms ease both",
					"-o-animation": _effect + " " + _duration + "ms ease both",
					"animation": _effect + " " + _duration + "ms ease both",
					"-webkit-animation-delay": +i * _delay + "ms",
					"-moz-animation-delay": +i * _delay + "ms",
					"-o-animation-delay": +i * _delay + "ms",
					"animation-delay": +i * _delay + "ms",
					"opacity": 1
				}).animate({
					opacity: 1
				});

				if (i == $el.size() - 1) {
					$extraslider.addClass("extra-animate");
				}
			});
		}

		function _UngetAnimate($el) {
			$el.each(function (i) {
				$(this).css({
					"animation": "",
					"-webkit-animation": "",
					"-moz-animation": "",
					"-o-animation": "",
					"opacity": 1
				});
			});
		}

	})("#<?php echo $tag_id ; ?>");
	});
	//]]>
</script>
<?php
} else {
    echo $objlang->get('text_noitem');
} ?>
</div> 

<?php if($post_text != '')
{
?>
	<div class="form-group">
		<?php echo html_entity_decode($post_text);?>
	</div>
<?php
}
?>

</div> 


