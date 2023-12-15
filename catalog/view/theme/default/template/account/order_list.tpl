<?php echo $header; ?>
<style type="text/css">
	@media screen and (max-width: 560px){
		.table-responsive{
			display: flex;
			flex-direction: column;
			overflow: hidden;
			border: 0 !important;
		}
		.order_history thead{
			display: none;
		}	
		.order_history,
		.order_history tbody tr{
			display: flex;
			position: relative;
			flex-direction: column;
			border: none !important;
		}
		.order_history tbody{
			border: 2px solid #1cacdc !important;
			margin-bottom: 10px;
			border-radius: 5px;
			padding: 10px 10px;
		}
		.order_history tbody tr td{
			border: none !important
		}
		.table-striped > tbody > tr:nth-of-type(2n+1){
			background: transparent;
		}
		.order_history .details_order,
		.order_history .order_id{
			width: calc(100% - 105px);
		}
		.order_history .details_order br{
			display: none
		}
		.order_history .details_order{
			display: flex;
			flex-wrap: wrap;

		}
		.order_history .details_order small{
			margin-right: 5px;
			padding: 3px 7px;
			margin-bottom: 5px;
			white-space: initial;
			text-align: left;
			line-height: 16px;
		}
		.order_history .details_order small:last-child{
			margin-right: 0
		}
		.order_history .td_flex {
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
		.order_history .td_flex::before{
			content: attr(data-text);
			font-size: 14px;
			color: #333;
		}
		.order_history  .btn_group{
			position: absolute;
			top: 0;
			right: 0;
		}
		.order_history .bbtn.product-layout__btn-cart{
			display: flex !important;
			width: 100%;
			align-items: center;
			justify-content: center;
		}
		.order_history .bbtn.product-layout__btn-cart svg{
			margin-right: 8px
		}
		.order_history .product_tr .row{
			display: flex;
			flex-direction: column;
			margin-bottom: 10px;
			border-bottom: 1px solid #1cacdc;
			padding-bottom: 10px;
		}
		.order_history .product_tr .row:first-child{
			margin-top: 10px;
			border-top: 1px solid #1cacdc;
			padding-top: 10px;
		}
		.order_history .product_tr .row:last-child{
			margin-bottom: 0;
			border-bottom: 0;
		}
		.order_history .product_tr .row > div{
			white-space: initial !important;
		}
	}
	
</style>
<?php if ($tmdaccount_status==1) { ?>
				<link href="catalog/view/theme/default/stylesheet/ele-style.css" rel="stylesheet">
				<link href="catalog/view/theme/default/stylesheet/dashboard.css" rel="stylesheet">
				<div class="container dashboard">
				<?php } else { ?>
				<div class="container">
				<?php } ?>
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

<?php if ($tmdaccount_status==1) { ?>
				<link href="catalog/view/theme/default/stylesheet/ele-style.css" rel="stylesheet">
				<link href="catalog/view/theme/default/stylesheet/dashboard.css" rel="stylesheet">
				<div class="container dashboard">
				<?php } else { ?>
				<div class="container">
				<?php } ?>
	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
			<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
			<?php $class = 'col-sm-9'; ?>
			<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
			<h1><?php echo $heading_title; ?></h1>
			<?php if ($orders) { ?>
				<div class="table-responsive">
					<?php foreach ($orders as $order) { ?>
						<table class="table table-striped order_history">
							<thead>
								<tr>
									<td class="text-left"><?php echo $column_order_id; ?></td>
									<td class="text-left"><?php echo $column_details; ?></td>
									<td class="text-left"><?php echo $column_status; ?></td>
									<td class="text-left"><?php echo $column_total; ?></td>
									<td class="text-left"><?php echo $column_date_added; ?></td>
									<td></td>
								</tr>
							</thead>
							<tbody>					
								<tr>
									<td class="text-left order_id"><b>№ <?php echo $order['order_id']; ?></b></td>
									<td class="text-right details_order">
										<?php if ($order['shipping_method']) {?>
											<small class="label label-info">
												<?php echo $order['shipping_method']; ?>
											</small>
										<?php } ?>
										
										<?php if ($order['shipping_address_1']) {?>
											<br /><small class="label label-info">
												<?php echo $order['shipping_address_1']; ?>
											</small>
										<?php } ?>
										
										<?php if ($order['payment_method']) {?>
											<br /><small class="label label-success">
												<?php echo $order['payment_method']; ?>
											</small>
										<?php } ?>
									</td>
									<td class="text-left td_flex order_status" data-text="<?php echo $column_status; ?>"><?php echo $order['status']; ?></td>
									<td class="text-left td_flex order_total" data-text="<?php echo $column_total; ?>"><?php echo $order['total']; ?></td>
									<td class="text-left td_flex date_added" data-text="<?php echo $column_date_added; ?>"><?php echo $order['date_added']; ?></td>
									<td class="text-right btn_group">
										<a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="bbtn bbtn--icon"><svg class="icon">
											<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#eye"></use>
										</svg></a>&nbsp;
										<a data-toggle="tooltip" data-order-id="<? echo $order['order_id']; ?>" title="<?php echo $button_delete; ?>" class="bbtn bbtn--icon delete-order"><svg class="icon">
											<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#close"></use>
										</svg></a>
									</td>
								</tr>
								
								<tr class="product_tr">
									<td class="text-left" colspan="5"  style="border-bottom-width:3px">
										<?php foreach ($order['order_products'] as $order_product) { ?>
											<div class="row">
												<div class="col-sm-1">
													<img src="<?php echo $order_product['thumb']; ?>" />
												</div>
												<div class="col-sm-7">
													<?php echo $order_product['name']; ?>
													
													<?php foreach ($order_product['option'] as $option) { ?>
														<br /><small class="label label-info"><?php echo $option['value']; ?></small>
													<?php } ?>
												</div>
												<div class="col-sm-2">
													<?php if (!$order_product['special']) { ?>
														<style>.product__price{font-size:16px!important;}</style>
														<span class="product__price"><?php echo $order_product['price']; ?></span>
														<?php } else { ?>
														<span class="product__price"><?php echo $order_product['special']; ?></span>
														<span class="product__price product__old-price"><?php echo $order_product['price']; ?></span>
													<?php } ?>
													
													<br />
													<?php if ($order_product['stock']) { ?>
														<small class="label label-success"><?php echo $text_in_stock; ?></small>
													<?php } else { ?>
														<small class="label label-success"><?php echo $text_not_in_stock; ?></small>
													<? } ?>
														
													
												</div>
												<div class="col-sm-2">
													<?php echo $order_product['quantity']; ?> шт.
												</div>
											</div>
										<?php } ?>
									</td>
									<td class="text-right"  style="border-bottom-width:3px">
										<style>a.product-layout__btn-cart{font-size:14px!important;border-color:#00a046;background-color:#00a046;}</style>
										<a href="<?php echo $order['reorder']; ?>" data-toggle="tooltip" title="" class="product-layout__btn-cart bbtn bbtn--icon" data-original-title="<?php echo $button_reorder; ?>"><svg class="icon">
											<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#cart"></use>
											</svg><br />
											<?php echo $button_reorder; ?>
										</a>
									</td>
								</tr>
							</tbody>
							
						<?php } ?>
					</table>
				</div>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
				<?php } else { ?>
				<p><?php echo $text_empty; ?></p>
			<?php } ?>
			<div class="buttons clearfix">
				<div class="pull-right"><a href="<?php echo $continue; ?>" class="bbtn"><?php echo $button_continue; ?></a></div>
			</div>
		<?php echo $content_bottom; ?></div>
	<?php echo $column_right; ?></div>
</div>
<script>
	$(document).ready(function(){
		$('.delete-order').click(function(){
			var elem = $(this);
			$.ajax({
				url : 'index.php?route=account/order/hide&order_id='+elem.attr('data-order-id'),
				beforeSend : function(){},
				error : function(){},
				success : function(e){
					if (e==1){
						elem.removeClass('btn-danger').addClass('btn-success');
						elem.prop('title', '<?php echo $button_cancel; ?>');
						elem.children('i').removeClass('fa-times').addClass('fa-undo');
						} else {
						elem.removeClass('btn-success').addClass('btn-danger');
						elem.prop('title', '<?php echo $button_delete; ?>');
						elem.children('i').removeClass('fa-undo').addClass('fa-times');					
					}					
				}
			});			
		});		
	});	
</script>
<style>
			<?php echo $tmdaccount_customcss; ?>
			</style>
<?php echo $footer; ?>
