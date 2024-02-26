<?php echo $header; ?>
<link rel="stylesheet" href="/catalog/view/javascript/countdown/jquery.countdown.css">
<style type="text/css">
	/*action page*/
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
	.bbtn1{
	padding: 10px 25px !important;
	}
	.promotions-content .promotions-item .inform-promotions h3{
	height: 50px;
    overflow: hidden;
    margin-top: 10px;
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
<style type="text/css">
	
	h1{
	margin-top: 15px;
	margin-bottom: 15px;
	}
	#timer-end{
	display: flex;
	flex-direction: row;
	justify-content: space-between;
	padding: 9px 0px;
	width: 228px;
	margin: auto;
	}
	
	#timer-end div{
	
	display: flex;
	flex-direction: column;
	font-size: 16px;
	text-align: center;
	color: #2b3743;
	} 
	
	#timer-end div span{
	
	font-size: 32px;
	font-weight: bold;
	color: #2b3743;
	margin-bottom: 5px;
	}
	#promotion-content{
	display: flex;
	flex-direction: row;
	margin-bottom: 20px;
	}
	#promotion-content .banner-block{
	padding-right: 0;
	}
	#promotion-content .product-timer-block{
	padding-left: 0;
	}
	#promotion-content .product-timer-block .timer{
	text-align: center;
	}
	#promotion-content .product-timer-block .timer .text{
	font-size: 16px;
	margin-bottom: 15px;
	}
	#promotion-content .product-timer-block .well{
	margin: 0;
	height: 100%;
	}
	#promotion-content .product-timer-block .description{
	max-height: 230px;
	overflow-y: auto;
	margin-top: 15px;
	}
	.special_end{
	font-size: 18px;
	color: #fc0003;
	display: block;
	text-align: center;
	}
	@media screen and (max-width: 1200px) {
	#promotion-content .banner-block img{
	object-fit: cover;
	height: 100% !important;
	}
	
	}
	@media screen and (max-width: 992px) {
	#promotion-content{
	flex-direction: column;
	}
	#promotion-content .banner-block{
	padding-right: 15px;
	}
	#promotion-content .product-timer-block{
	padding-left: 15px;
	}
	#promotion-content .banner-block img {
	height: auto!important;
	}
	#promotion-content .product-timer-block .well{
	display: inline-block;
	width: 100%;
	}
	}
	@media screen and (max-width: 480px) {
	#promotion-content .product-timer-block .well > div{
	padding: 0 !important;		
	}
	#promotion-content .banner-block,
	#promotion-content .retail-info-block,
	#promotion-content .product-timer-block{
	padding: 0 5px !important;
	}

	.product-timer-block .well{border-radius:0px; margin-top:10px;}
	}
	
</style>

<?php include(DIR_TEMPLATEINCLUDE . 'structured/breadcrumbs.tpl'); ?>

<div class="container">
	<div class="col-sm-12  content-row">
		<div class="row">
			<h1 class="headline-collection cat-header"><?php echo $heading_title; ?></h1>
		</div>						
		<div id="promotion-content" class="row top-row">
			<? if ($banner) { ?>
				<div class="col-xs-12 col-md-4 banner-block">
					<img class="img-responsive" src="<?php echo $banner; ?>" alt="<?php echo $heading_title; ?>" />
				</div>				
			<? } ?>
			<div class="col-xs-12 col-md-4 product-timer-block">
				<div class="well">
					<?php if($special_date_diff) { ?>					
						<?php echo $timer_custom_css_styles;?>
						<div class="timer pull-right col-xs-12">									
							<div class="text"><?php echo $text_action_time_to_end; ?></div>
							<span id="timer-end"></span>
						</div>					
						<? } else { ?>
						<?php echo $text_ended; ?>
						<span class="special_end"><?php echo $text_promo_ended; ?></span>
					<?php } ?>					
					<div class="col-xs-12 description">		
						<?php echo $description; ?>	
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4 retail-info-block">
				<div class="alert alert-<?php if ($retail) { ?>danger<? } else { ?>success<?php } ?>">
					<?php echo $retail_info;?>
				</div>
			</div>
		</div>
		
		<div class="row"><?php echo $column_left; ?>
			<?php if ($column_left && $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
				<?php $class = 'col-sm-9'; ?>
				<?php } else { ?>
				<?php $class = 'col-sm-12'; ?>
			<?php } ?>
			<?php echo $content_top; ?>				
			<?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_list.tpl'); ?>
			
			<?php include(DIR_TEMPLATEINCLUDE . 'structured/pagination.tpl'); ?>
			
			<?php echo $column_right; ?>
		</div>
		<div class="clearfix"></div>
		
		<?php if ($specials) { ?>
			<div class="col-sm-12 promotions-content">
				<h2 class="cat-header"><?php echo $text_more_actions; ?></h2>
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
									<?php if ($special['active'] && $special['dateDiff']) { ?>
										<div class="promotion-days-left"><?php echo $text_special; ?> <span><?php echo $special['dateDiff']; ?></span> <?php echo $text_days; ?></div>
										<? } else { ?>
										<span class="promotion-days-left action_deactivated"><?php echo $text_ended; ?></span>
									<? } ?>
									<a href="<?php echo $special['href']; ?>" class="load_more bbtn1 bbtn bbtn-primary"><?php echo $text_more; ?></a>
								</div>	
							</div>		
							
						</div>	
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
	</div>
	<div class="container">
		<?php echo $content_bottom; ?>
	</div>
	
	
	
	<?php echo $footer; ?>
	
	<script src="/catalog/view/javascript/countdown/jquery.countdown.min.js"></script>
	<script type="text/javascript">
		ts = new Date('<?php echo date("Y/m/d", strtotime($special_date_diff)); ?>');
		$('#timer-end').countdown('<?php echo date("Y/m/d", strtotime($special_date_diff)); ?>', function(event) {
			var $this = $(this).html(event.strftime(''
			+ '<div><span>%D</span>дн.</div>'
			+ '<div><span>%H</span>год.</div>'
			+ '<div><span>%M</span>хв.</div>'
			+ '<div><span>%S</span>сек.</div>'));
		});  
		
	</script>

