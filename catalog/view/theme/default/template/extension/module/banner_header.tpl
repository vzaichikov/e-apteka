<div class="wrap" style="background-color:<?php echo $background; ?>;">
	<div class="container">
		<div class="row">

			<style>
				#top-temprorary-banner{font-size:18px;}
				#top-temprorary-banner img{width:150px;}
				@media only screen and (max-width: 992px){
					#top-temprorary-banner{font-size:14px;}
					#top-temprorary-banner img{width:100px;}
				}
			</style>

			<div class="col-sm-12 col-md-12 text-center"  id="top-temprorary-banner-wrap" style="padding:0px!important;  display:none;" >

						<?php /* ?>
				<div id="top-temprorary-banner" style="text-align: center; background-color:<?php echo $banner['background']; ?>; padding:5px 5px; color:#0066cc;">
					Завантажуйте наш додаток з Play Store - з ним замовляти швидше. <a href="https://play.google.com/store/apps/details?id=ua.com.eapteka.twa" target="_blank" noindex nofollow rel="nofollow" title="Google Play Store"><img src="/catalog/view/image/gplay_ua1.svg" /></a>
				</div>
				<?php */	?>


				<div id="banner<?php echo $module; ?>" class="swiper" style="background-color:<?php echo $banner['background']; ?>">
					<div class="swiper-wrapper">
						<?php $i=0;  foreach ($banners as $banner) { ?>
							<div class="swiper-slide item text-center" data-gtm-banner='{"id": "<?php echo $banner['banner_analytics_id']; ?>", "name": "<?php echo $banner['title']; ?>", "creative": "InTopHeaderCreative", "position": "slot<?php echo $i; ?>", "url": "<?php echo $banner['link']; ?>"}'>
								<?php if ($banner['link']) { ?>
									<a href="<?php echo $banner['link']; ?>">
										<picture>
										  	<source media="(min-width: 768px)" srcset="<?php echo $banner['image']; ?>">
										  	<source media="(min-width: 320px)" srcset="<?php echo $banner['image_mobil']; ?>">
										  	<img src="<?php echo $banner['image']; ?>" class="img-responsive" alt="<?php echo $banner['title']; ?>" loading="lazy">
										</picture>
									</a>
								<?php } else { ?>
									<picture>
									  	<source media="(min-width: 768px)" srcset="<?php echo $banner['image']; ?>">
									  	<source media="(min-width: 320px)" srcset="<?php echo $banner['image_mobil']; ?>">
									  	<img src="<?php echo $banner['image']; ?>" class="img-responsive" style="display:inline-block;" alt="<?php echo $banner['title']; ?>" loading="lazy">
									</picture>
								<?php } ?>
							</div>
						<?php $i++; } ?>
					</div>
				</div>
				
			</div>
		</div>
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
						'creative': 'InTopHeaderCreative',
						'position': 'slot<?php echo $i; ?>'
					}<?php if ($i < count($banners)) {?>,<?php } ?>
					<? $i++; } ?>
					]
				}
			}
		});
	</script>