<?php if ($specials) { ?>
<style>
	#special_actions<?php echo $module; ?>{margin-top:20px;}
	.banner-promo-single.action-text{margin-top:5px;}

	@media (min-width: 992px) {	
		#special_actions<?php echo $module; ?>{overflow-x:hidden;}
	}
</style>
<div id="special_actions<?php echo $module; ?>" class="swiper">	
	<div class="swiper-wrapper">
		<?php $i=0; foreach ($specials as $special) { ?>
			<div class="swiper-slide banner-promo-single" data-gtm-banner='{"id": "<?php echo $special['banner_analytics_id']; ?>", "name": "<?php echo $special['title']; ?>", "creative": "InCategoryCreative", "position": "slot<?php echo $i; ?>", "url": "<?php echo $special['href']; ?>"}'>				
				<?php if ($special['href']) { ?>
					<a href="<?php echo $special['href']; ?>" title="<?php echo $special['title']; ?>">
					<?php } ?>
					<img src="<?php echo $special['image']; ?>" alt="<?php echo $special['title']; ?>" class="img-responsive"  width="400" height="300" />
					<?php if ($special['href']) { ?>
					</a>
				<?php } ?>

				<?php if ($special['retail']) { ?>
					<div class="action-text text-danger text-center"><i class="fa fa-info-circle"></i> <?php echo $text_only_retail; ?></div>
				<?php } else { ?>
					<div class="action-text text-info text-center"><i class="fa fa-info-circle"></i> <?php echo $text_only_site; ?></div>
				<?php } ?>
			</div>
			<?php $i++; } ?>
		</div>	
		<div class="pagination"></div>	
	</div>

	<script type="text/javascript">
		var swiper_actions<?php echo $module; ?> = new Swiper("#special_actions<?php echo $module; ?>", {
			slidesPerView: 4,
			spaceBetween: 5,
			autoplay: {
				delay: 10000000,
			},
			pagination: {
				el: '#special_actions<?php echo $module; ?> .pagination',
				type: 'bullets',
				clickable: true
			},
			lazy: true,
			breakpoints: {
				320: {
					slidesPerView: 1,
				},
				556: {
					slidesPerView: 2,
				},
				992: {
					slidesPerView: 3,
				},
				1300: {
					slidesPerView: 4,
				},
			},
		});

		swiper_actions<?php echo $module; ?>.on('slideChange', function () {
		});

	</script>
<?php } ?>