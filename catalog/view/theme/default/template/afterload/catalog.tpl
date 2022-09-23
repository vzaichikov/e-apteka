<?php if ($categories) { ?>
<div class="catalog__heding js-catalog-btn"><svg class="icon catalog__heding__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#burger"></use></svg>Каталог<span class="hidden-lg hidden-md hidden-sm hidden-xs">&nbsp;&nbsp;товаров</span></div>
<div class="catalog__list-wrap">
	<ul class="catalog__list">
		<?php foreach ($categories as $category) { ?>
			<?php
				$category_icon = '<svg class="icon catalog__list-icon 1" width="30" height="30"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#pills"></use></svg>';
				if (isset($category['icon']) && !empty($category['icon'])) {
                    $category_icon = '<svg class="icon catalog__list-icon 2" width="30" height="30"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#'.$category['icon'].'"></use></svg>';
				}
				$category_has_children_arrow = '<span class="catalog__list-arrow-wrap"><svg class="icon catalog__list-arrow" width="14" height="16"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#angle-arrow-down"></use></svg></span>';
			?>
			<?php if ($category['children']) { ?>
				
				<li class="catalog__list-item has-children"><a href="<?php echo $category['href']; ?>" class="catalog__list-link has-children"><?php echo $category_icon.$category['name'].$category_has_children_arrow; ?></a>
					
					<?php if ( $category['icon'] === "medication-guide" ) { ?>
						<ul class="catalog__list-2 catalog__list-2--2col">
							<?php } else { ?>
							<ul class="catalog__list-2">
							<?php } ?>
							<?php foreach ($category['children'] as $child) { ?>
								
								<?php if ($child['children']) { ?>
									<li class="catalog__list-item has-children"><a href="<?php echo $child['href']; ?>" class="catalog__list-link has-children"><?php echo $child['name'].$category_has_children_arrow; ?></a>
										
										<ul class="catalog__list-3">
											<?php foreach ($child['children'] as $ch) { ?>
												<li class="catalog__list-item"><a href="<?php echo $ch['href']; ?>" class="catalog__list-link"><?php echo $ch['name']; ?></a></li>
											<?php } ?>
										</ul>
										
									</li>
									<?php } else { ?>
									<li class="catalog__list-item"><a href="<?php echo $child['href']; ?>" class="catalog__list-link"><?php echo $child['name']; ?></a></li>
								<?php } ?>
								
							<?php } ?>
						</ul>
						
					</li>
					<?php } else { ?>
                    <li class="catalog__list-item"><a href="<?php echo $category['href']; ?>" class="catalog__list-link"><?php echo $category_icon.$category['name']; ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
	</div>
	
	<?php /*
		<script>
		$('.js-catalog-btn').on('click', function(){
		$('#catalog').toggleClass('is-open');
		});
	</script> */ ?>
<?php } ?>

