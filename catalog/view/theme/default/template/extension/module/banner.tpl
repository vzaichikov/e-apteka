
<div id="banner<?php echo $module; ?>" class="swiper home-banner">	
	<div class="swiper-wrapper">
		<?php $i=0; foreach ($banners as $banner) { ?>
			<div class="swiper-slide banner-promo-single" data-gtm-banner='{"id": "<?php echo $banner['banner_analytics_id']; ?>", "name": "<?php echo $banner['title']; ?>", "creative": "InCategoryCreative", "position": "slot<?php echo $i; ?>", "url": "<?php echo $banner['link']; ?>"}'>
				<?php if ($banner['link']) { ?>
					<a href="<?php echo $banner['link']; ?>" title="<?php echo $banner['title']; ?>">
					<?php } ?>
					<?php if ( isset($banner['image_mobil']) && !empty($banner['image_mobil']) ) { ?>
						<picture>
							<source srcset="<?php echo $banner['image_mobil']; ?>" media="(max-width: 460px)">
							<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive"  width="1470" height="605">
						</picture>
						<?php } else { ?>
						<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive"  width="1470" height="605">
					<?php } ?>
					<?php if ($banner['link']) { ?>
					</a>
				<?php } ?>
			</div>
		<?php $i++; } ?>
	</div>	
	<div class="pagination"></div>	
</div>

<script type="text/javascript">
	var swiper<?php echo $module; ?> = new Swiper("#banner<?php echo $module; ?>", {
	  	slidesPerView: 1,
	 	autoplay: {
		   	delay: 3000,
		},
	 	pagination: {
		    el: '#banner<?php echo $module; ?> .pagination',
		    type: 'bullets',
		    clickable: true
		},
	});
	
	swiper<?php echo $module; ?>.on('slideChange', function () {
	});
	
</script>

