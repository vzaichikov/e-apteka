<div id="bannerpro<?php echo $module; ?>"  class="swiper-container <?php echo $css_class; ?> <?php if($mobile_image){ echo 'mobile-image'; }?>">
  	<div class="swiper-wrapper">
  		<?php $i=0; foreach ($bannerspro as $bannerpro) { ?>
        	<div class="swiper-slide banner-promo-single" data-gtm-banner='{"id": "<?php echo $bannerpro['banner_analytics_id']; ?>", "name": "<?php echo $bannerpro['title']; ?>", "creative": "InCategoryCreative", "position": "slot<?php echo $i; ?>", "url": "<?php echo $bannerpro['link']; ?>"}'>
        		<?php if ($bannerpro['link']) { ?>
					<a href="<?php echo $bannerpro['link']; ?>" title="<?php echo $bannerpro['title']; ?>">
				<?php } ?>			
					<picture>
						<?php if (!empty($bannerpro['image_mobile'])) { ?><source srcset="<?php echo $bannerpro['image_mobile']; ?>" media="(max-width: 580px)"><?php } ?>
						<img src="<?php echo $bannerpro['image']; ?>" alt="<?php echo $bannerpro['title']; ?>" class="img-responsive" loading="lazy"/>
					</picture>
					
					<?php if ($text) { ?>
						<div class="text-bannerpro">
							<div class="text-bannerpro-inner"><?php echo $bannerpro['title']; ?></div>
						</div>
					<?php } ?>
				<?php if ($bannerpro['link']) { ?></a><?php } ?>
			</div>
		<?php $i++; } ?>
	</div>
</div>

<script>
	window.dataLayer = window.dataLayer || [];
	console.log('dataLayer.push ' + 'promoView');
	dataLayer.push({
		'ecommerce': {
			'promoView': {
				'promotions': [                   
				<?php unset($bannerpro); $i=0; foreach ($bannerspro as $bannerpro) { ?>
					{
						'id': '<?php echo $bannerpro['banner_analytics_id']; ?>',
						'name': '<?php echo $bannerpro['title']; ?>',
						'creative': 'InCategoryCreative',
						'position': 'slot<?php echo $i; ?>'
					}<?php if ($i < count($bannerspro)) {?>,<?php } ?>
				<? $i++; } ?>
				]
			}
		}
	});
</script>

<style>
	#bannerpro<?php echo $module; ?> .item {
	height: <?php echo $height; ?>px;
	}
	#bannerpro<?php echo $module; ?> .text-bannerpro {
	height: <?php echo $height; ?>px;
	width: <?php echo $width; ?>px;
	opacity: <?php echo $texthover; ?>;
	background: <?php echo $banner_bg; ?>;
	}
	#bannerpro<?php echo $module; ?> .text-bannerpro:hover {
	opacity: 1;
	}
	<?php if($mobile_image){ ?>
		#bannerpro<?php echo $module; ?> .item {
		height: auto;
		}
	<?php } ?>
	@media screen and (max-width: 640px) {
	<?php if($hide_text){ ?>
		#bannerpro<?php echo $module; ?> .text-bannerpro {
		display: none;
		}
	<?php } ?>
	.carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img{
	margin: auto;
	}
	}
</style>
<script type="text/javascript"><!--
	var swiper = new Swiper("#bannerpro<?php echo $module; ?>", {
		pagination: {
			el: ".swiper-pagination",
		},
	});
--></script>
