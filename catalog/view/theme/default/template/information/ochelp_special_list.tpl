<?php echo $header; ?>

<style type="text/css">
	/*action page*/
	.promotions-content{
	margin-top: 15px;
	}
	.promotions-content .promotions-item{
    text-align: left;
    border: 0;
    background-color: rgba(240,243,246,.77);
    margin-bottom: 20px;    
    padding: 0 !important;
    position: relative;
	}
	
	.promotions-content .promotions-item .image-promotions{
	height: auto;
	overflow: hidden;
	}
	.promotions-content .promotions-item .image-promotions img{
	width: 100%;
	height: auto;
	object-fit: cover;
	}
	.promotions-content .promotions-item .inform-promotions{
	padding: 0 15px 25px 15px;
	}
	.promotions-content .promotions-item .inform-promotions .title a{
    display: block;
    color: #353535;
    font-size: 18px;
    font-weight: 700;
    line-height: 26px;
    margin-bottom: 20px;
	}
	.promotions-content .promotions-item:hover .inform-promotions .title a{
	color: #4b5f73 !important;
	text-decoration: underline;
	}
	.promotions-content .promotions-item .inform-promotions .description{
	font-size: 14px;
	font-weight: 400;
	height: 66px;
	overflow: hidden;
	color: #59595e;
    line-height: 1.8em;
    margin-bottom: 10px;
	}
	.promotions-content .promotions-item .inform-promotions .promotion-days-left{
	color: #4f5f6f;
	font-size: 16px;
	font-weight: 600;
	display: inline-block;
	width: 100%;
	margin-bottom: 15px;
	}
	.promotions-content .promotions-item .inform-promotions .btn{
	
	}
	
	
	.promotions-content .promotions-item.deactivated .image-promotions img{
 	filter: grayscale(100%);
	}
	.promotions-content .promotions-item.deactivated span.action_deactivated{
	display: inline-block;
	position: absolute;
	top: 10px;
	right: 0;
	font-weight: 500;
	background: #2b3743;
	color: #fff;
	padding: 3px 15px;
	font-size: 14px;
	width: auto;
	}
	.bbtn{
	padding: 10px 25px !important;
	}
	.promotions-content .promotions-item .inform-promotions h3{
	height: 50px;
    overflow: hidden;
    margin: 10px 0;
	}
	.past-promotions{
		margin: 25px 0;
	}
	.promotions-content .promotions-item.deactivated .description{
		display: none;
	}
	@media screen and (max-width: 480px) {
	.promotions-content .promotions-item .image-promotions {
	height: auto;
	overflow: hidden;
	}
	.promotions-content .promotions-item .inform-promotions .btn {
	margin-bottom: 0;
	}
	}
	/* END action page*/
</style>

<div class="container">
	<!-- breadcrumb -->
	<ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
		<?php $ListItem_pos = 1; ?>
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li itemprop="itemListElement" itemscope
			itemtype="https://schema.org/ListItem"><a href="<?php echo $breadcrumb['href']; ?>" itemprop="item"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a><meta itemprop="position" content="<?php echo $ListItem_pos++; ?>" /></li>
		<?php } ?>
	</ul>
	<!-- breadcrumb -->
</div>

<div class="container">
	
	
	<div class="col-sm-12  content-row">
		
		<div class="row top-row">
			<div class="col-sm-12">
				<h1 class="headline-collection cat-header"><?php echo $heading_title; ?></h1>
			</div>
		</div>
		<div class="row">
			<?php echo $column_left; ?>
			<?php if ($column_left && $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
				<?php $class = 'col-sm-9'; ?>
				<?php } else { ?>
				<?php $class = 'col-sm-12'; ?>
			<?php } ?>
			<div id="content" class="<?php echo $class; ?> promotions-content">
				<?php if ($specials) { ?>
					<div class="row">
						<?php $i=0; foreach ($specials as $special) { $i++; ?>
							
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 <?php if (!$special['active']) { ?>deactivated<? } ?>">	
								<div class="promotions-item">				
									<?php if($special['thumb']) { ?>
										<div class="image-promotions">
											<a href="<?php echo $special['href']; ?>"><img src="<?php echo $special['thumb']; ?>" alt="<?php echo $special['title']; ?>" title="<?php echo $special['title']; ?>" class="img-responsive" /></a>
										</div>
										
									<?php } ?>
									<div class="inform-promotions">
										<h3 class="title">
											<a href="<?php echo $special['href']; ?>"><?php echo $special['title']; ?></a>
										</h3>	
										<div class="row" style="margin-top:15px;">
											<div class="col-xs-12 col-sm-6 text-left pull-left">
												<?php if ($special['active'] && $special['dateDiff']) { ?>
													<div class="promotion-days-left"><?php echo $text_special; ?> <span><?php echo $special['dateDiff']; ?></span> <?php echo $text_days; ?></div>
													<? } else { ?>
													<span class="promotion-days-left action_deactivated"><?php echo $text_ended; ?></span>
												<? } ?>
											</div>
											<div class="col-xs-12 col-sm-6 text-right pull-right">
												<a href="<?php echo $special['href']; ?>" class="load_more bbtn bbtn-primary"><?php echo $text_more; ?></a>
											</div>
										</div>
									</div>	
								</div>		
								
							</div>	
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>					
					</div>
					<?php } else { ?>
					<p><?php echo $text_empty; ?></p>
					<div class="buttons">
						<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary webfun_load_more_product"><?php echo $button_continue; ?></a></div>
					</div>
				<?php } ?>
				
				<?php if ($specials_archive) { ?>
					<hr />
					<div class="row top-row">
						<div class="col-sm-12">
					<h2 class="past-promotions"><?php echo $text_specials_archive; ?></h2>
					</div>
					</div>
					<div class="row">
						<?php $i=0; foreach ($specials_archive as $special) { $i++; ?>
							
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">	
								<div class="promotions-item deactivated">			
									<?php if($special['thumb']) { ?>
										<div class="image-promotions">
											<a href="<?php echo $special['href']; ?>"><img src="<?php echo $special['thumb']; ?>" alt="<?php echo $special['title']; ?>" title="<?php echo $special['title']; ?>" class="img-responsive" /></a>
										</div>
										
									<?php } ?>
									<div class="inform-promotions">
										<h3 class="title">
											<a href="<?php echo $special['href']; ?>"><?php echo $special['title']; ?></a>
										</h3>
										<p class="description"><?php echo $special['description']; ?></p>
										<?php if ($special['active'] && $special['dateDiff']) { ?>
											<div class="promotion-days-left"><?php echo $text_special; ?> <span><?php echo $special['dateDiff']; ?></span> <?php echo $text_days; ?></div>
											<? } else { ?>
											<span class="promotion-days-left action_deactivated"><?php echo $text_ended; ?></span>
										<? } ?>
										<a href="<?php echo $special['href']; ?>" class="load_more bbtn bbtn-primary"><?php echo $text_more; ?></a>
									</div>
								</div>
							</div>	
							
						<?php } ?>
					</div>	
				<? } ?>
			</div>
		<?php echo $column_right; ?></div>
		<?php echo $content_bottom; ?>
	</div>
</div>
<?php echo $footer; ?>