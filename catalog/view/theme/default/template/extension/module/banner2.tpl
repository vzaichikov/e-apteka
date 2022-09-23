<div id="banner<?php echo $module; ?>" class="banner-2">
	<div class="row">
		<?php $i=0; foreach ($banners as $banner) { ?>
			<div class="col-md-6">
				<div class="banner-2__item">
					<div class="banner-2__img banner-promo-single" data-gtm-banner='{"id": "<?php echo $banner['banner_analytics_id']; ?>", "name": "<?php echo $banner['title']; ?>", "creative": "InCategoryCreative", "position": "slot<?php echo $i; ?>", "url": "<?php echo $banner['link']; ?>"}'>
						
						<?php if ( isset($banner['image_mobil']) && !empty($banner['image_mobil']) ) { ?>
							<?php if ($banner['link']) { ?>
								<a href="<?php echo $banner['link']; ?>" title="<?php echo $banner['title']; ?>">
								<?php } ?>
								<picture>
									<source srcset="<?php echo $banner['image_mobil']; ?>" media="(max-width: 580px)">
									<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" loading="lazy" width="1470" height="605"/>
								</picture>
								
								<?php if ($banner['link']) { ?>
								</a>
							<?php } ?>
							
							<?php } else { ?>
							
							<?php if ($banner['link']) { ?>
								<a href="<?php echo $banner['link']; ?>" title="<?php echo $banner['title']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" loading="lazy" /></a>
								<?php } else { ?>
								<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" loading="lazy" />
							<?php } ?>
							
						<?php } ?>
					</div>
				</div>
				
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
				<?php unset($banner); $i=0; foreach ($banners as $banner) { ?>
					{
						'id': '<?php echo $banner['banner_analytics_id']; ?>',
						'name': '<?php echo $banner['title']; ?>',
						'creative': 'InHomeWallCreative',
						'position': 'slot<?php echo $i; ?>'
					}<?php if ($i < count($banners)) {?>,<?php } ?>
				<? $i++; } ?>
				]
			}
		}
	});
</script>
