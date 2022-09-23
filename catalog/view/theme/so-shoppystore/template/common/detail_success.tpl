<?php echo $header; ?>
<div class="container">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
			<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
			<?php $class = 'col-sm-9'; ?>
			<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
			<?php if (isset($order)): ?>
			<div class="ds container">
				<div class="col-md-8">
					<? if ($need_locations) { ?>
						
						<? foreach ($products_by_location as $location) { ?>
							<div class="row">
								<div class="col-md-12">
									<h4><? echo $location['location']; ?></h4>
									<span class="bg-success"><h6># <? echo $location['order_id']; ?></h6></span>
								</div>
							</div>
							<?php foreach ($location['products'] as $product) { ?>
								<div class="product row">
								<div class="col-md-4">
									<img src="<?php echo $product['image']; ?>" />
								</div>
								<div class="col-md-8">                   
									<div class="row">
										<a class="link" href="<?php echo $product['href']; ?>" target="_blank"><?php echo
										$product['name']; ?></a>
									</div>
									<div class="row">
										<span><?php echo $text_price; ?></span>
										<b><?php echo isset($product['special']) ? $product['special'] : $product['price']; ?></b>
									</div>
									<div class="row">
										<span><?php echo $text_qty; ?></span>
										<b><?php echo $product['quantity']; ?></b>
									</div>
								</div>
							</div>
							<? } ?>
						<? } ?>
						
						<? } else { ?>
						<h2><?php echo $text_title; ?></h2>
						<?php foreach ($products as $product) { ?>
							<div class="product row">
								<div class="col-md-4">
									<img src="<?php echo $product['image']; ?>" />
								</div>
								<div class="col-md-8">                   
									<div class="row">
										<a class="link" href="<?php echo $product['href']; ?>" target="_blank"><?php echo
										$product['name']; ?></a>
									</div>
									<div class="row">
										<span><?php echo $text_price; ?></span>
										<b><?php echo isset($product['special']) ? $product['special'] : $product['price']; ?></b>
									</div>
									<div class="row">
										<span><?php echo $text_qty; ?></span>
										<b><?php echo $product['quantity']; ?></b>
									</div>
								</div>
							</div>
						<?php } ?>				
					<? } ?>
				</div>
				<div class="col-md-4">
					<div class="row">
						<h2><?php echo $text_details; ?></h2>
					</div>
					<?php if (!empty($order['firstname'])): ?>
					<div class="row">
						<b><?php echo $text_name; ?></b> <?php echo $order['firstname'] . " " . $order['lastname']; ?>
					</div>
					<?php endif; ?>
					<?php if (!empty($order['email'])): ?>
					<div class="row">
						<b><?php echo $text_email; ?></b> <?php echo $order['email']; ?>
					</div>
					<?php endif; ?>
					<?php if (!empty($order['shipping_company'])): ?>
					<div class="row">
						<b><?php echo $text_company; ?></b> <?php echo $order['shipping_company']; ?>
					</div>
					<?php endif; ?>
					<?php if (!empty($order['telephone'])): ?>
					<div class="row">
						<b><?php echo $text_phone; ?></b> <?php echo $order['telephone']; ?>
					</div>
					<?php endif; ?>
					<?php if (!empty($order['shipping_method'])): ?>
					<div class="row">
						<b><?php echo $text_delivery; ?></b> <?php echo $order['shipping_method']; ?>
					</div>
					<?php endif; ?>
					<?php if (!empty($order['payment_method'])): ?>
					<div class="row">
						<b><?php echo $text_payment; ?></b> <?php echo $order['payment_method'] ?>
					</div>
					<?php endif; ?>
					<div class="row">
					<? if (!empty($order['shipping_address_1'])) { ?>
						<b><?php echo $text_address; ?></b>
						<?php echo !empty($order['shipping_postcode']) ? $order['shipping_postcode'].', ' : ''; ?>
						<?php echo !empty($order['shipping_country']) ? $order['shipping_country'].', ' : ''; ?>
						<?php echo !empty($order['shipping_city']) ? $order['shipping_city'].', ' : ''; ?>
						<?php echo !empty($order['shipping_address_1']) ? $order['shipping_address_1'].', ' : ''; ?>
						<?php echo !empty($order['shipping_address_2']) ? $order['shipping_address_2'].', ' : ''; ?>
					<? } ?>
					<? if (!empty($order['payment_address_1'])) { ?>
						<b><?php echo $text_address; ?></b>
						<?php echo !empty($order['payment_postcode']) ? $order['payment_postcode'].', ' : ''; ?>
						<?php echo !empty($order['payment_country']) ? $order['payment_country'].', ' : ''; ?>
						<?php echo !empty($order['payment_city']) ? $order['payment_city'].', ' : ''; ?>
						<?php echo !empty($order['payment_address_1']) ? $order['payment_address_1'].', ' : ''; ?>
						<?php echo !empty($order['payment_address_2']) ? $order['payment_address_2'].', ' : ''; ?>
					
					<? } ?>
					</div>
				</div>
			</div>			
			<style>
				.ds {margin: 20px 0 50px 0;}
				.ds .product {border-bottom: 1px solid #F0F0F0;padding:10px;margin: 0;}
				.ds .product img {max-width: 100%;max-height: 150px;margin: 0 auto;display: block;}
				.ds .product span {color:#808080;}
				.ds .product a {font-size: 1.2em}
			</style>
			<?php else: ?>
			<h1><?php echo $heading_title; ?></h1>
            <?php echo $text_message; ?>
			<?php endif; ?>
			<div class="buttons">
				<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo
				$button_continue; ?></a></div>
			</div>
		<?php echo $content_bottom; ?></div>
	<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
