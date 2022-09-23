<?php echo $header; ?>
<link href="catalog/view/theme/default/stylesheet/ele-style.css" rel="stylesheet">
<link href="catalog/view/theme/default/stylesheet/dashboard.css" rel="stylesheet">
<div class="container dashboard">
    <ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
	<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
	<?php } ?>
	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
			<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
			<?php $class = 'col-sm-9'; ?>
			<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>">
			<?php echo $content_top; ?>
			<div class="menu-box col-sm-12">
				<div class="row">
					<?php if($total_order) { ?>	
						<div class="col-md-3 col-sm-6">
							<a href="<?php echo $order; ?>"><div class="icon-box">
								<span class="icon_cart"></span>
								<h5><b><?php echo $order_total; ?></b> <br/><?php echo $text_total_order; ?></h5>
							</div></a>
						</div>
					<?php } ?>
					<?php if($total_wishlist) { ?>	
						<div class="col-md-3 col-sm-6">
							<a href="<?php echo $wishlist; ?>"><div class="icon-box">
								<span class="icon_heart"></span>
								<h5><b><?php echo $wishlist_total; ?></b><br/><?php echo $text_total_wishlist; ?> </h5>
							</div>
							</a>
						</div>
					<?php } ?>
					<?php if($total_reward) { ?>	
						<div class="col-md-3 col-sm-6">
							<a href="<?php echo $reward; ?>"><div class="icon-box">
								<span class="icon_gift"></span>
								<h5> <b><?php echo $points; ?></b><br/><?php echo $text_reward_points; ?></h5>
							</div></a>
						</div>
					<?php } ?>
					<?php if($total_download) { ?>	
						<div class="col-md-3 col-sm-6">
							<a href="<?php echo $downloads; ?>"><div class="icon-box">
								<span class="icon_download" aria-hidden="true"></span>
								<h5> <b><?php echo $totaldownload; ?></b><br/><?php echo $text_downloads; ?></h5>
							</div></a>
						</div>
					<?php } ?>
					<?php if($total_transaction) { ?>	
						<div class="col-md-3 col-sm-6">
							<a href="<?php echo $transactions; ?>"><div class="icon-box">
								<span>
									<div class="arrowdollar"></div>
								</span>
								<h5> <b><?php echo $totaltransaction; ?></b><br/><?php echo $text_transations; ?></h5>
							</div></a>
						</div>
					<?php } ?>
				</div>
				<div class="clearfix"></div>
				<div class="row icons">
					<?php if($link_editaccount) { ?>
						<div class="col-md-3 col-sm-6">
							<div class="white-box">
								<a href="<?php echo $edit;?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon1.png" alt="icon1" title="icon"/>
								<h4><?php echo $text_edit_account; ?></h4></a>
							</div>
						</div>
					<?php } ?>
					<?php if($link_password) { ?>
						<div class="col-md-3 col-sm-6">
							<div class="white-box">
								<a href="<?php echo $password; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon2.png" alt="icon1" title="icon"/>
								<h4><?php echo $text_change_password; ?></h4></a>
							</div>
						</div>
					<?php } ?>
					<?php if($link_address_book) { ?>
						<div class="col-md-3 col-sm-6">
							<div class="white-box">
								<a href="<?php echo $address; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon3.png" alt="icon1" title="icon"/>
								<h4><?php echo $text_address_book; ?></h4></a>
							</div>
						</div>
					<?php } ?>
					<?php if($link_wishlist) { ?>
						<div class="col-md-3 col-sm-6">
							<div class="white-box">
								<a href="<?php echo $wishlist; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon4.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_wishlist; ?></h4>
								</div>
							</div>
						<?php } ?>
						<?php if($link_order) { ?>
							<div class="col-md-3 col-sm-6">
								<div class="white-box">
									<a href="<?php echo $order; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon5.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_order; ?></h4></a>
								</div>
							</div>
						<?php } ?>
						<?php if($link_downloads) { ?>
							<div class="col-md-3 col-sm-6">
								<div class="white-box">
									<a href="<?php echo $download; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon6.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_download; ?></h4></a>
								</div>
							</div>
						<?php } ?>
						<?php if($link_reward) { ?>				
							<div class="col-md-3 col-sm-6">
								<div class="white-box">
									<a href="<?php echo $reward; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon8.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_reward_point; ?></h4></a>
								</div>
							</div>
						<?php } ?>
						<?php if($link_returns) { ?>
							<div class="col-md-3 col-sm-6">
								<div class="white-box">
									<a href="<?php echo $return; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon9.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_returnrequest; ?></h4></a>
								</div>
							</div>
						<?php } ?>
						<?php if($link_transaction) { ?>
							<div class="col-md-3 col-sm-6">
								<div class="white-box">
									<a href="<?php echo $transaction; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon10.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_transation; ?></h4></a>
								</div>
							</div>
						<?php } ?>
						<?php if($link_payments) { ?>
							<div class="col-md-3 col-sm-6">
								<div class="white-box">
									<a href="<?php echo $recurring; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon7.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_recurringpayments; ?></h4></a>
								</div>
							</div>
						<?php } ?>
						<?php if($link_newsletter) { ?>
							<div class="col-md-3 col-sm-6">
								<div class="white-box">
									<a href="<?php echo $newsletter; ?>"><img class="img-responsive" src="catalog/view/theme/default/image/icon11.png" alt="icon1" title="icon"/>
									<h4><?php echo $text_newsletter; ?></h4></a>
								</div>
							</div>
						<?php } ?>				
					</div>
					<?php if($latest_order) { ?>					
						<div class="table1">	
							<h3><?php echo $text_latest; ?>
								<span class="viewall"><a href="<?php echo $viewalorders; ?>"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $text_viewall; ?></a></span>
							</h3>
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-center"><?php echo $column_order_id; ?></td>
											<td class="text-center"><?php echo $column_product; ?></td>
											<td class="text-center"><?php echo $column_status; ?></td>
											<td class="text-center"><?php echo $column_total; ?></td>
											<td class="text-center"><?php echo $column_date_added; ?></td>
											<td class="text-center"></td>
										</tr>
									</thead>
									<tbody>
										<?php if($orders) { ?>
											<?php foreach ($orders as $order) { ?>
												<tr>
													<td class="text-center">#<?php echo $order['order_id']; ?></td>
													<td class="text-center"><?php echo $order['noof_product']; ?></td>
													<td class="text-center"><?php echo $order['status']; ?></td>
													<td class="text-center"><?php echo $order['total']; ?></td>
													<td class="text-center"><?php echo $order['date_added']; ?></td>
													<td class="text-center"><a class="btn btn-info" href="<?php echo $order['href']?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" ><i class="fa fa-eye" style="font-size:21px;"></i></a></td>
												</tr>
											<?php } ?>
											<?php } else { ?>
											<tr>
												<td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					<?php } ?>
					<div class="col-sm-12">
						<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
						<div class="col-sm-6 text-right"><?php echo $results; ?></div>
					</div>
				</div>
			<?php echo $content_bottom; ?></div>
		<?php echo $column_right; ?></div>
	</div>
	<style>
		<?php echo $tmdaccount_customcss; ?>
	</style>
	<?php echo $footer; ?> 
