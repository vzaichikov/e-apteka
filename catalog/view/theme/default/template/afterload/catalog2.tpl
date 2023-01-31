<?php if ($categories) { ?>
		<style type="text/css">
			@media (min-width: 992px){
				.catalog__list-wrap .level_1 > .topmenu {
					display: none;
					position: absolute;
					background: white;
					left: 348px;
					top: 0;
					max-width: 1670px;
				}
				.catalog__list-wrap .level_1:hover > .topmenu{
					display: block;
				}
				.catalog__list-2{
					left: 0 !important;
					box-shadow: none !important;
					display: grid !important;
					width: 100% !important;
					position: relative !important;
					grid-template-columns: 1fr 1fr 1fr 1fr;
					min-height: 1px !important;
					border: 0 !important;
				}
				.catalog__list-2 .level_2{
					transition: all .3s ease-in-out;
					position: relative;
				}
				.catalog__list-2 .level_2 .catalog__list-arrow-wrap{
					transition: all .3s ease-in-out;
				}
				.catalog__list-wrap .level_1.active > a,
				.catalog__list-2 .level_2.active > a{
					background-color: #f1f8fe;
					color: #14a0d4;
					text-decoration: none;
				}
				.catalog__list-2 .level_2.active .catalog__list-arrow-wrap{
					transform: rotate(90deg);
				}		

				.catalog__list-3{
					padding: 0 !important;
					left: 0 !important; 
					top:43px !important;
				}
				.catalog__list-3 li a{
					font-size: 15px !important;
					padding-top: 5px !important;
					padding-bottom: 5px !important;
					min-height: 1px;
					padding-left: 17px !important;
				}
			}
			@media (min-width: 1400px){
				.catalog__list-2 .level_2 a{
					font-size: 15px !important;
				}
				#catalog .catalog__list-3 li a{
					font-size: 14px !important;
					padding: 4px 10px !important;
				}
			}

			@media (min-width: 1200px) and (max-width: 1440px) {
				#catalog .catalog__list-2 .level_2 a{
					font-size: 15px !important;
				}
				#catalog .catalog__list-3 li a{
					font-size: 15px !important;
					padding: 5px 15px !important;
				}
				.catalog__list-2 .level_2 a{
					font-size: 15px !important;
				}
				#catalog .catalog__list-3 li a{
					font-size: 15px !important;
					padding: 5px 15px !important;
				}
				#catalog .catalog__list-3 {
					left: 274px !important;
					top: 0 !important;
				}

				#catalog .level_2:nth-child(3n+3) .catalog__list-3{
					left: -274px !important;
				}
			}

			@media (min-width: 992px) and (max-width: 1600px) {
				.catalog__list-2{
					grid-template-columns: 1fr 1fr 1fr;
				}
				.catalog__list-2 .level_2 a{
					font-size: 15px !important;
				}

				#catalog .catalog__list-3 li a{
					font-size: 15px !important;
					padding: 5px 15px !important;
				}
				.catalog__list .level_1:last-child .catalog__list-2{
					grid-template-columns: 1fr 1fr 1fr 1fr !important
				}
				
			}		

			@media (min-width: 992px) and (max-width: 1200px){			
				#catalog .catalog__list-3 {
					padding: 0 !important;
					left: 200px !important;
					top: 0px !important;
				}
				#catalog .catalog__list-2 .level_2 a{
					font-size: 12px !important;
				}

				#catalog .level_2:nth-child(3n+3) .catalog__list-3{
					left: -200px !important;
				}

				#catalog .catalog__list-3 li a{
					font-size: 12px !important;
					padding: 5px 10px !important;
				}
			}

			@media (min-width: 992px) and (max-width: 1440px){
				
				.catalog__list-2 .level_2.active .catalog__list-arrow-wrap{
					transform: rotate(0deg)
				}
				#catalog .catalog__list-2 .level_2.active:nth-child(3n+3) .catalog__list-arrow-wrap{
					transform: rotate(-180deg) !important
				}	
			}

			/*mob*/
			@media screen and (max-width: 992px){
				.level_1.is-open .topmenu .catalog__list-2,
				.level_1.is-open .topmenu{
					display: block;
				}
				#catalog .topmenu{
					width: 100% !important;
					height: auto !important;
				}
			}
		</style>

	
	<div class="catalog__heding js-catalog-btn"><svg class="icon catalog__heding__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#burger"></use></svg><?php echo $text_catalog; ?></span></div>
	<div class="catalog__list-wrap">
		<ul class="catalog__list" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
		<meta itemprop="name" content="Меню">
			<?php foreach ($categories as $category) { ?>
				<?php
				$category_icon = '<svg class="icon catalog__list-icon" width="30" height="30"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#pills"></use></svg>';
				if (isset($category['icon']) && !empty($category['icon'])) {
					$category_icon = '<svg class="icon catalog__list-icon" width="30" height="30"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#'.$category['icon'].'"></use></svg>';
				}
				$category_has_children_arrow = '<span class="catalog__list-arrow-wrap"><svg class="icon catalog__list-arrow"  width="14" height="16"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#angle-arrow-down"></use></svg></span>';
				?>
				<?php if ($category['children']) { ?>

					<li class="catalog__list-item has-children level_1"><a itemprop="url" href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>" class="catalog__list-link has-children"><?php echo $category_icon; ?><span itemprop="name"><?php echo $category['name']; ?></span></a>
						<div class="topmenu">
							<?php if ( $category['icon'] === "medication-guide" ) { ?>
								<ul class="catalog__list-2 catalog__list-2--2col">
								<?php } else { ?>
									<ul class="catalog__list-2">
									<?php } ?>
									<?php foreach ($category['children'] as $child) { ?>

										<?php if ($child['children']) { ?>
											<li class="catalog__list-item has-children level_2"><a itemprop="url" href="<?php echo $child['href']; ?>" class="catalog__list-link has-children"><span itemprop="name"><?php echo $child['name'] ?></span><?php echo $category_has_children_arrow; ?></a>

												<ul class="catalog__list-3">
													<?php foreach ($child['children'] as $ch) { ?>
														<li class="catalog__list-item"><a itemprop="url" href="<?php echo $ch['href']; ?>" title="<?php echo $ch['name']; ?>" class="catalog__list-link"><span itemprop="name"><?php echo $ch['name']; ?></span></a></li>
													<?php } ?>
												</ul>

											</li>
										<?php } else { ?>
											<li class="catalog__list-item level_2"><a itemprop="url" href="<?php echo $child['href']; ?>" title="<?php echo $child['name']; ?>" class="catalog__list-link"><span itemprop="name"><?php echo $child['name']; ?></span></a></li>
										<?php } ?>

									<?php } ?>
								</ul>
							</div>	
						</li>
					<?php } else { ?>
						<li class="catalog__list-item"><a itemprop="url" href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>" class="catalog__list-link"><?php echo $category_icon; ?><span itemprop="name"><?php echo $category['name']; ?></span></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>

		<script src="/catalog/view/theme/default/template/afterload/js/jquery.menu-aim.js"></script>

		<script type="text/javascript">
			$(document).ready(function () {


				if(document.documentElement.clientWidth > 992) {  

					var $menu = $(".catalog__list");

					$menu.menuAim({
						activate: activateSubmenu,
						deactivate: deactivateSubmenu
					});

					function activateSubmenu(row) {
						var $row = $(row),
						submenuId = $row.find('.topmenu'),
						$submenu = $(submenuId),
						height = $('#catalog .catalog__list-wrap').outerHeight(),
						width = $('.header__bottom .container').outerWidth();


						$submenu.css({
							display: "block",
							top: -1,
							width: width - 348,
							left: 348,
							height: height - 4  
						});

						$row.find("a").addClass("maintainHover");
						$row.addClass("active");
					}

					function deactivateSubmenu(row) {
						var $row = $(row),
						submenuId = $row.find('.topmenu'),
						$submenu = $(submenuId);

						$submenu.css("display", "none");
						$row.find("a").removeClass("maintainHover");
						$row.removeClass("active");
					}

					$(".catalog__list li").click(function(e) {
						e.stopPropagation();
					});

					$(document).click(function() {
						$(".topmenu").css("display", "none");
						$("a.maintainHover").removeClass("maintainHover");
					});

					if(document.documentElement.clientWidth > 992) {  
						$('.catalog__list-2 .level_2').each(function(){
							$(this).mousemove(function(){
								$(this).addClass('active'); 
								var _wLevel2 = $(this).width();              
								$('.catalog__list-3').css('width',_wLevel2);
							});
							$(this).mouseout(function(){
								$(this).removeClass('active');	                    
							});
						});	
					}	


					var minW = $(window).width = 992;
					var maxW = $(window).width > 1200;
					if(minW < maxW) {  
						$('.catalog__list-2 .level_2').each(function(){
							$(this).mousemove(function(){
								$(this).addClass('active'); 
								var _wLevel2 = $(this).width();              
								$('.catalog__list-3').css('width',_wLevel2+20);
							});
							$(this).mouseout(function(){
								$(this).removeClass('active');	                    
							});
						});		
					}	
				}


				$(window).resize(function() {
					if(document.documentElement.clientWidth > 992) {  

						var $menu = $(".catalog__list");

						$menu.menuAim({
							activate: activateSubmenu,
							deactivate: deactivateSubmenu
						});

						function activateSubmenu(row) {
							var $row = $(row),
							submenuId = $row.find('.topmenu'),
							$submenu = $(submenuId),
							height = $('#catalog .catalog__list-wrap').outerHeight(),
							width = $('.header__bottom .container').outerWidth();


							$submenu.css({
								display: "block",
								top: -1,
								width: width - 348,
								left: 348,
								height: height - 4  
							});

							$row.find("a").addClass("maintainHover");
							$row.addClass("active");
						}

						function deactivateSubmenu(row) {
							var $row = $(row),
							submenuId = $row.find('.topmenu'),
							$submenu = $(submenuId);

							$submenu.css("display", "none");
							$row.find("a").removeClass("maintainHover");
							$row.removeClass("active");
						}

						$(".catalog__list li").click(function(e) {
							e.stopPropagation();
						});

						$(document).click(function() {
							$(".topmenu").css("display", "none");
							$("a.maintainHover").removeClass("maintainHover");
						});

						if(document.documentElement.clientWidth > 992) {  
							$('.catalog__list-2 .level_2').each(function(){
								$(this).mousemove(function(){
									$(this).addClass('active'); 
									var _wLevel2 = $(this).width();              
									$('.catalog__list-3').css('width',_wLevel2);
								});
								$(this).mouseout(function(){
									$(this).removeClass('active');	                    
								});
							});	
						}	


						var minW = $(window).width = 992;
						var maxW = $(window).width > 1200;
						if(minW < maxW) {  
							$('.catalog__list-2 .level_2').each(function(){
								$(this).mousemove(function(){
									$(this).addClass('active'); 
									var _wLevel2 = $(this).width();              
									$('.catalog__list-3').css('width',_wLevel2+20);
								});
								$(this).mouseout(function(){
									$(this).removeClass('active');	                    
								});
							});		
						}	
					}
				});

			});		


		</script>
		<?php } ?>