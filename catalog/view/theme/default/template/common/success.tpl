
<?php echo $header; ?>
<style>
	.checkout-success .success-text,
	.checkout-success .after-success{
		float: unset;
		margin: auto;
		display: grid;
		align-items: center;
		padding: 60px 0;
		grid-template-columns: 160px 1fr;
	    grid-template-rows: 1fr auto;
		grid-gap: 30px;
	}
	.checkout-success .after-success .whitepay_payment,
	.checkout-success .success-text .whitepay_payment{
		grid-column-start: 1;
		grid-column-end: 3;
		grid-row-start: 2;
		grid-row-end: 2;
	}
	.checkout-success .success-text .img-block-bg{		
		background-image: url(data:image/svg+xml;base64,PHN2ZyBpZD0i0KHQu9C+0LlfMSIgZGF0YS1uYW1lPSLQodC70L7QuSAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNTUgMjU1Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6Izk1YzExZjt9LmNscy0ye2ZpbGw6IzU5YjAzMTt9LmNscy0ze2ZpbGw6I2ZmZjt9PC9zdHlsZT48L2RlZnM+PGNpcmNsZSBjbGFzcz0iY2xzLTEiIGN4PSIxMjcuNSIgY3k9IjEyNy41IiByPSIxMjMuMjYiLz48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik0xMjgsMjU1LjVBMTI3LjUsMTI3LjUsMCwxLDEsMjU1LjUsMTI4LDEyNy42NSwxMjcuNjUsMCwwLDEsMTI4LDI1NS41Wk0xMjgsOUExMTksMTE5LDAsMSwwLDI0NywxMjgsMTE5LjE3LDExOS4xNywwLDAsMCwxMjgsOVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0wLjUgLTAuNSkiLz48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik0xOTYuMjYsNzAuNDVjLTcuMzUtNy41MS0yMi44LTguODktMzAsMGwtMzcsNDUuODgtMTcuNiwyMS44NWMtMi4wOSwyLjU5LTQuNTYsNi40Ny03LjI3LDEwLjA3bC0xLjU5LTEuNjNMOTAuOTMsMTM0LjM0Yy0xOS4wNS0xOS41OC00OSwxMC4zOS0zMCwyOS45NSw5LjgzLDEwLjEsMTkuODYsMjQuMjIsMzMuMTksMjkuNTQsMTQuNjEsNS44NSwyNy41Ny0xLjE4LDM3LTEyLjU4LDIyLTI2LjcsNDMuNDMtNTMuOSw2NS4xNC04MC44NUMyMDMuNDksOTEuNDMsMjA0Ljg2LDc5LjI1LDE5Ni4yNiw3MC40NVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0wLjUgLTAuNSkiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik0xOTUuNzEsNjguMzRjLTcuMzQtNy41MS0yMi43OS04Ljg5LTMwLDBsLTM3LDQ1Ljg4LTE3LjYxLDIxLjg1Yy0yLjA4LDIuNTktNC41Niw2LjQ2LTcuMjYsMTAuMDZsLTEuNTktMS42My0xMi0xMi4yOGMtMTktMTkuNTctNDksMTAuNC0yOS45NSwzMCw5LjgyLDEwLjEsMTkuODYsMjQuMjEsMzMuMTgsMjkuNTQsMTQuNjIsNS44NCwyNy41Ny0xLjE5LDM3LTEyLjU4LDIyLTI2LjcsNDMuNDMtNTMuOTEsNjUuMTMtODAuODVDMjAyLjk0LDg5LjMyLDIwNC4zMiw3Ny4xMywxOTUuNzEsNjguMzRaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMC41IC0wLjUpIi8+PC9zdmc+);
	}
	.checkout-success .after-success .img-block-bg{
		background-image: url(data:image/svg+xml;base64,PHN2ZyBpZD0i0KHQu9C+0LlfMSIgZGF0YS1uYW1lPSLQodC70L7QuSAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNTUgMjU1Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6IzcxM2M5MDt9LmNscy0ye2ZpbGw6IzY2MjQ4Mzt9LmNscy0ze2ZpbGw6I2ViZDUwMDt9PC9zdHlsZT48L2RlZnM+PGNpcmNsZSBjbGFzcz0iY2xzLTEiIGN4PSIxMjcuNSIgY3k9IjEyNy41IiByPSIxMjMuMjYiLz48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik0xMjgsMjU1LjVBMTI3LjUsMTI3LjUsMCwxLDEsMjU1LjUsMTI4LDEyNy42NSwxMjcuNjUsMCwwLDEsMTI4LDI1NS41Wk0xMjgsOUExMTksMTE5LDAsMSwwLDI0NywxMjgsMTE5LjE3LDExOS4xNywwLDAsMCwxMjgsOVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0wLjUgLTAuNSkiLz48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik0xMjkuODUsNDMuNzdhNC41NSw0LjU1LDAsMCwxLDQuMzUsMi41OWwyMy4wOSw0Ny40N2E0LjU3LDQuNTcsMCwwLDAsMy42NCwyLjU2bDUyLjkxLDUuODlhNC44LDQuOCwwLDAsMSwyLjYxLDguMjlsLTM4Ljg0LDM4Ljk0YTUuMTIsNS4xMiwwLDAsMC0xLjQ3LDQuNGw4LjM3LDUyLjc3YTUuMTksNS4xOSwwLDAsMS00Ljg5LDUuOTMsNC44LDQuOCwwLDAsMS0yLjI3LS41TDEzMC4yNiwxODguN2E0LjY1LDQuNjUsMCwwLDAtMi4yNi0uNDgsNSw1LDAsMCwwLTIuMjkuNjRMNzgsMjE1LjU4YTQuOTQsNC45NCwwLDAsMS0yLjI4LjY1QTQuNjYsNC42NiwwLDAsMSw3MSwyMTAuNjVsOS43NC01My40MWE0Ljc1LDQuNzUsMCwwLDAtMS4zNS00LjNMNDEuNDcsMTE2LjY4Yy0yLjg3LTIuNzQtMS4yLTcuNzUsMi44MS04LjQ4bDUzLjExLTkuNTlhNS4yLDUuMiwwLDAsMCwzLjcyLTIuODJsMjQuMzItNDkuMTNBNS4xMSw1LjExLDAsMCwxLDEyOS44NSw0My43N1oiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0wLjUgLTAuNSkiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik0xMjguODUsNDEuNzdhNC41NSw0LjU1LDAsMCwxLDQuMzUsMi41OWwyMy4wOSw0Ny40N2E0LjYsNC42LDAsMCwwLDMuNjQsMi41Nmw1Mi45MSw1Ljg5YTQuOCw0LjgsMCwwLDEsMi42MSw4LjI5bC0zOC44NCwzOC45NGE1LjEyLDUuMTIsMCwwLDAtMS40Nyw0LjRsOC4zNyw1Mi43N2E1LjE3LDUuMTcsMCwwLDEtNC44OSw1LjkyLDQuNjcsNC42NywwLDAsMS0yLjI3LS40OUwxMjkuMjYsMTg2LjdhNC42NSw0LjY1LDAsMCwwLTIuMjYtLjQ4LDUsNSwwLDAsMC0yLjI5LjY0TDc3LDIxMy41OGE0Ljk0LDQuOTQsMCwwLDEtMi4yOS42NUE0LjY1LDQuNjUsMCwwLDEsNzAsMjA4LjY1bDkuNzQtNTMuNDFhNC43NSw0Ljc1LDAsMCwwLTEuMzUtNC4zTDQwLjQ3LDExNC42OGMtMi44Ny0yLjc0LTEuMjEtNy43NSwyLjgxLTguNDhsNTMuMTEtOS41OWE1LjI1LDUuMjUsMCwwLDAsMy43Mi0yLjgybDI0LjMyLTQ5LjEzQTUuMTEsNS4xMSwwLDAsMSwxMjguODUsNDEuNzdaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMC41IC0wLjUpIi8+PC9zdmc+);

	}
	.img-block-bg{
		width: 160px;
		height: 160px;
		background-repeat: no-repeat;
		background-size: contain;
		background-position: right;
	}
	.content-text p{
		color: #111111;
	}
	.checkout-success .after-success p{
		font-size: 20px;
	}
	.content-text h4{
		margin-bottom: 25px;
		font-size: 30px;
		color: #111111;
	}
	.checkout-success .left-block,
	.checkout-success .right-block{
		box-shadow: 0px 0px 57px 0px rgba(0, 0, 0, 0.15);
		background-color: rgb(255, 255, 255);
		border-radius: 10px;
		padding: 50px 35px;
	}
	.checkout-success .right-block{
		width: 55%;
		position: sticky;
		top: 65px;
		font-size: 16px;
	}
	.ds.wrap-block{
		display: flex;
		flex-wrap: wrap;
		align-items: flex-start;
		justify-content: space-between;
	}
	.ds.wrap-block .right-block > .row{
		margin-bottom: 5px;
		margin-left: 0;
		margin-right: 0;
	}
	.ds.wrap-block h2 {
		font-size: 24px;
		text-transform: uppercase;
		margin-bottom: 30px;
		color: #111111;
	}
	.table-wrap{
		margin: 0 -25px;
	}
	.table-order{
		width: 100%;
		border-collapse: separate;
		border-spacing: 25px 0;

	}
	.table-order thead th{
		font-size: 14px;
		font-weight: 400;
		color: #353535;
	}
	.table-order thead th:not(:first-of-type){
		text-align: center;
	}
	.table-order tr td{
		font-size: 18px;
		font-weight: 400;
		color: #353535;
		text-align: center;
	}
	.table-order tr td a{
		color: #353535;
		font-size: 15px;
	}
	.table-order tr td.border-bottom{
		border-bottom: 1px solid #e7e7e7;
		padding: 8px 0;
		text-align: left;
	}
	.table-order tr:last-of-type td.border-bottom{
		border-bottom: 0;
	}
	.table-order tr td.img-cell{
		display: grid;
		grid-template-columns: 82px 1fr;
		align-items: center;
		grid-gap: 10px;
		max-width: 490px;
	}
	.table-order .img-cell .img-product,
	.table-order .img-product{
		width: 82px;
		height: 82px;
		object-fit: cover;
	}
	.btn-uppercase{
		background: #1cacdc;
		color: #fff;
		text-transform: uppercase;
		padding: 14px 34px;
		font-size: 18px;
		border-radius: 3px;
		border: 0;
		margin-top: 20px;
	}
	@media screen and (max-width: 1400px) {
		.table-wrap {
			margin: 0 -15px;
		}
		.table-order {
			border-spacing: 15px 0;
		}
	}
	@media screen and (max-width: 1200px) {
		.checkout-success .left-block, 
		.checkout-success .right-block{
			width: 100%;
		}
		.checkout-success .left-block{
			margin-bottom: 30px;
		}
		.img-block-bg{
			width: 100%;
			height: 100%;
			margin-left: auto;
		}

	}
	@media screen and (max-width: 767px) {
		.checkout-success .success-text, 
		.checkout-success .after-success{
			padding: 30px 15px;
			grid-template-columns: 120px 1fr;
			align-items: flex-start;
		}
		.checkout-success .left-block, 
		.checkout-success .right-block {
			padding: 25px 15px;
		}
		.checkout-success .right-block {
			font-size: 16px;
		}
		.img-block-bg {
			width: 100px;
			height: 100px;			
		}
		.content-text h4 {
			margin-bottom: 15px;
			font-size: 22px;
		}
		.content-text p{
			font-size: 14px;
		}
		.ds.wrap-block h2 {
			font-size: 20px;
			margin-bottom: 30px;
		}
		.table-wrap {
			margin: 0;
		}
		.table-order {
			width: 100%;
			border-collapse: collapse;
			display: block;
		}
		.table-order tbody,
		.table-order tr td.img-cell,
		.table-order tfoot{
			display: block;
		}
		.table-order tbody tr{
			display: grid;
			grid-template-columns: auto 1fr;
			grid-template-rows: repeat(3, auto);
			grid-gap: 0 10px;
			width: 100%;
			padding: 8px 0;
		}
		.img-product{
			grid-area: 1 / 1 / 4 / 2;
		}
		.table-order tr td,
		.table-order tr td.border-bottom {
			font-size: 15px;
			text-align: left;
			padding: 0;
		}
		.table-order tr td:last-of-type{
			font-size: 17px;
		}
		.table-order tbody td[aria-label]:before{
			content: attr(aria-label) ":";
			margin-right: 6px;
		}
		.table-order thead th:not(:first-of-type),
		.table-order .price-column{
			display: none;
		}
		.table-order tr td.border-bottom{
			border: 0;
		}
		.table-order tbody tr:not(:last-of-type) {
			border-bottom: 1px solid #e7e7e7;
		}
		.table-order tfoot tr{
			display: flex;
			width: 100%;
			align-items: center;
			justify-content: flex-end;
		}
		.table-order tfoot tr td{
			margin-left: 9px;
		}
	}
	@media screen and (max-width: 576px) {
		.checkout-success .success-text, 
		.checkout-success .after-success {
			grid-template-columns: 65px 1fr;
			grid-gap: 20px;
		}
		.img-block-bg {
			width: 65px;
			height: 65px;
		}
		.content-text h4 {
			margin-bottom: 15px;
			font-size: 16px;
		}
		.content-text p {
			font-size: 12px;
		}
		.ds.wrap-block h2 {
			font-size: 15px;
			margin-bottom: 30px;
		}
		.table-order thead th {
			font-size: 12px;
		}
		.table-order .img-cell .img-product, 
		.table-order .img-product {
			width: 50px;
			height: 50px;
		}
		.table-order tr td{
			margin-bottom: 6px;
		}
		.table-order tr td a,
		.table-order tr td{
			font-size: 12px;
		}
		.table-order tr td:last-of-type,
		.checkout-success .right-block {
			font-size: 14px;
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
	<div class="success-text col-lg-7">
		<div class="img-block-bg"></div>
		<div class="content-text">
			<h4><?php echo $text_success1; ?></h4>
			<p><?php echo $text_success2; ?></p>
		</div>

		<?php if (!empty($whitepay_payment)) { ?>
			<script>
				function proceed_whitepay(){
					$.ajax({
						url		 : '<?php echo $whitepay_payment; ?>', 
						type 	 : 'GET',
						dataType : 'json',
						beforeSend: function(){
							$('.product-layout__btn-cart').prop('disabled', true);
							$('.product-layout__btn-cart').prop("onclick", null).off("click");
							$('.product-layout__btn-cart').addClass('spin');
						},
						success: function(json){
							if (json.status == 'ok' && json.acquiring_url){
								console.log(json.acquiring_url);
								window.open(json.acquiring_url, '_blank').focus();
							} else {
								$('.product-layout__btn-cart').addClass('err');
							}
						},
						error: function(){
							$('.product-layout__btn-cart').addClass('err');
							$('.product-layout__btn-cart').removeClass('spin');
						}
					});
				}
			</script>
			<div class="whitepay_payment">
				<style>
					.product-layout__btn-cart.spin svg{
						animation-name: spin;
						animation-duration: 5000ms;
						animation-iteration-count: infinite;
						animation-timing-function: linear; 
					}
					@keyframes spin {
						from {
							transform:rotate(0deg);
						}
						to {
							transform:rotate(360deg);
						}
					}
					.product-layout__btn-cart.err{
						background-color: #e5354c;
					}
					.product-layout__btn-cart{
						display: flex;
						width: 100%;
						align-items: center;
						justify-content: center;
						font-size: 16px;
						font-weight: 500;
						height: 60px;
						border-radius: 5px;
					}
					.product-layout__btn-cart svg{margin-right: 5px; animation-name: none;}
				</style>
				<form action="<?php echo $whitepay_payment; ?>" target="_blank">
					<button class="bbtn bbtn-primary product-layout__btn-cart" type="submit"><?php echo $whitepay_pay_button_text; ?></button>
				</form>
			</div>
		<?php } ?>
	</div>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-lg-7 col-lg-offset-3 text-center">		
			
		</div>
	</div>
	<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
	<?php if (isset($order)): ?>
		<div class="ds wrap-block">
			<div class="col-lg-5 left-block">				
				<h2><?php echo $text_success3; ?></h2>
				<div class="table-wrap">
					<table class="table-order">
						<thead>
							<tr>
								<th><?php echo $text_success4; ?></th>
								<th class="price-column"><?php echo $text_price; ?></th>
								<th><?php echo $text_qty; ?></th>
								<th><?php echo $text_success5; ?></th>
							</tr>
						</thead>
						<tbody>				  

							<?php foreach ($products as $product) { ?>
								<tr>
									<td class="img-cell border-bottom">
										<img src="<?php echo $product['thumb']; ?>" class="img-product"/>
										<a class="link" href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?>
										<br /><small><small><?php echo $product['manufacturer']; ?></small></small>
									</a>

								</td>
								<td class="price-column"><?php echo isset($product['special']) ? $product['special'] : $product['price']; ?></td>
								<td aria-label="<?php echo $text_qty; ?>"><?php echo $product['quantity']; ?></td>
								<td><?php echo $product['total']; ?></td>
							</tr>

						<?php } ?>	

					</tbody>
					<tfoot>
						<tr>
							<td colspan="2" style="text-align: right; padding-top: 20px;"><?php echo $text_success6; ?></td>
							<td colspan="2" style="padding-top: 20px; text-align: right;"><?php echo $order['total']; ?></td>
						</tr>
					</tfoot>
				</table>	

				<div class="row">
					<div class="col-xs-12 text-center">		
						<?php if (!empty($whitepay_payment)) { ?>
							<style>
								.product-layout__btn-cart{
									display: flex;
									width: 100%;
									align-items: center;
									justify-content: center;
									font-size: 16px;
									font-weight: 500;
									height: 40px;
									border-radius: 5px;
								}
								.product-layout__btn-cart svg{margin-right: 5px;}
							</style>
							<button class="bbtn bbtn-primary product-layout__btn-cart" type="button" onclick="proceed_whitepay();"><?php echo $whitepay_pay_button_text; ?></button>
						<?php } ?>
					</div>
				</div>

			</div>		
		</div>

		<div class="col-lg-6 right-block">
			<div class="row">
				<h2><?php echo $text_success7; ?></h2>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<b><?php echo $text_order_id; ?></b>
				</div>
				<div class="col-sm-8">
					<?php echo $order['order_id']; ?>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-4">
					<b><?php echo $text_datetime; ?></b>
				</div>
				<div class="col-sm-8">
					<?php echo date('d.m.Y H:i'); ?>
				</div>
			</div>

			<hr style="margin:10px 0px;" />

			<?php if (!empty($order['firstname'])) { ?>
				<div class="row">
					<div class="col-sm-4">
						<b><?php echo $text_name; ?></b>
					</div>
					<div class="col-sm-8">
						<?php echo $order['firstname'] . " " . $order['lastname']; ?>
					</div>
				</div>
			<?php } ?>

			<?php if (!empty($order['telephone'])): ?>
				<div class="row">
					<div class="col-sm-4">
						<b><?php echo $text_phone; ?></b>
					</div> 
					<div class="col-sm-8">
						<?php echo $order['telephone']; ?>
					</div>
				</div>
			<?php endif; ?>			

			<?php if (!empty($order['email'])): ?>
				<div class="row">
					<div class="col-sm-4">
						<b><?php echo $text_email; ?></b>
					</div>
					<div class="col-sm-8">
						<?php echo $order['email']; ?>
					</div>
				</div>
			<?php endif; ?>



			<?php if (!empty($order['shipping_firstname'])) { ?>

				<hr style="margin:10px 0px;" />

				<div class="row">
					<div class="col-sm-4">
						<b><?php echo $text_shipping_name; ?></b>
					</div> 
					<div class="col-sm-8">
						<?php echo $order['shipping_firstname'] . " " . $order['shipping_lastname']; ?>
					</div>
				</div>
			<?php } ?>

			<?php if (!empty($order['telephone']) || !empty($order['fax'])): ?>
			<div class="row">
				<div class="col-sm-4">
					<b><?php echo $text_fax; ?></b>
				</div>
				<div class="col-sm-8">
					<?php echo $order['fax']?$order['fax']:$order['telephone']; ?>
				</div>
			</div>
		<?php endif; ?>


		<?php if (!empty($order['email'])): ?>
			<div class="row">
				<div class="col-sm-4">
					<b><?php echo $text_shipping_email; ?></b>
				</div>
				<div class="col-sm-8">
					<?php echo $order['email']; ?>
				</div>
			</div>
		<?php endif; ?>

		<hr style="margin:10px 0px;" />

		<?php if (!empty($order['payment_method'])): ?>
			<div class="row">
				<div class="col-sm-4">
					<b><?php echo $text_payment; ?></b>
				</div>
				<div class="col-sm-8">	
					<?php echo $order['payment_method'] ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if (!empty($order['shipping_method'])): ?>
			<hr style="margin:10px 0px;" />
			<div class="row">
				<div class="col-sm-4">
					<b><?php echo $text_delivery; ?></b>
				</div>
				<div class="col-sm-8">								
					<?php echo $order['shipping_method']; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<? if (!empty($order['shipping_address_1'])) { ?>
				<div class="col-sm-4">
					<b><?php echo $text_address; ?></b>
				</div>
				<div class="col-sm-8">	
					<?php echo !empty($order['shipping_city']) ? $order['shipping_city'].'<br />' : ''; ?>
					<?php echo !empty($order['shipping_address_1']) ? $order['shipping_address_1'].'<br />' : ''; ?>							
				</div>
			<? } ?>						
		</div>

		<? if (!empty($open)) { ?>
			<div class="col-sm-4">
				<b><?php echo $text_worktime; ?></b>
			</div>
			<div class="col-sm-8">	
				<?php echo $open; ?>							
			</div>
		<? } ?>	

		<div class="row">
			<div class="col-sm-4">
				<b><?php echo $text_callcenter; ?></b>
			</div>
			<div class="col-sm-8">	
				<?php echo $callcenter_telephone; ?>
			</div>
		</div>
		<hr style="margin:10px 0px;" />

		<div class="row">
			<div class="col-sm-4">
				<b><?php echo $text_seller; ?></b>
			</div>
			<div class="col-sm-8">	
				<small><?php echo $seller; ?></small>
			</div>					
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
			<!-- <div class="buttons">
				<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo
				$button_continue; ?></a></div>
			</div> -->
			<?php echo $content_bottom; ?></div>
		<!-- <div class="after-success col-md-7">
			<div class="img-block-bg"></div>
			<div class="content-text">
			<p>Мы будем очень благодарны если после получения товара вы оставите отзыв о нашей компании.</p>
			<p>Ваше мнение очень важно для нас и будет полезно другим покупателям.</p>
			<a href="https://www.google.com/" target="_blank" class="btn btn-uppercase">Оставить отзыв</a>
			</div>
		</div> -->
		<?php echo $column_right; ?></div>
	</div>

	<?php if (checkIfStringIsEmail($ecommerceData['email']) && $ecommerceData['email'] != 'fastorder@e-apteka.com.ua') { ?>
		<script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>

		<script>
			window.renderOptIn = function() {
				window.gapi.load('surveyoptin', function() {
					window.gapi.surveyoptin.render(
					{
						"merchant_id": 258362434,
						"order_id": "<?php echo $ecommerceData['id']; ?>",
						"email": "<?php echo $ecommerceData['email']; ?>",
						"delivery_country": "UA",
						"estimated_delivery_date": "<?php echo $ecommerceData['estimated_date']; ?>",

						<?php if ($ecommerceData['gtins']) {  ?>
							"products": [<?php echo implode(',', $ecommerceData['gtins']); ?>]
						<?php } ?>
					});
				});
			}
		</script>
	<?php } ?>

	<?php if ($products) { ?>

		<script type="text/javascript">
			$(document).ready(function(){
				window.dataLayer = window.dataLayer || [];
				console.log('dataLayer.push ' + 'orderPurchaseSuccess');
				dataLayer.push({
					'event': 'orderPurchaseSuccess',
					'ecommerce': {
						'currencyCode': '<?php echo $ecommerceData['currencyCode']; ?>',  
						'purchase': {
							'id': '<? echo $ecommerceData['id'] ?>',                        
							'affiliation': '<? echo $ecommerceData['affiliation'] ?>',
							'revenue': '<? echo $ecommerceData['revenue'] ?>',  
							'tax':'<? echo $ecommerceData['tax'] ?>',

							<?php if (!empty($ecommerceData['coupon'])) { ?>
								'coupon':'<? echo $ecommerceData['coupon'] ?>',
							<?php } ?>

							'shipping': '<? echo $ecommerceData['shipping'] ?>',
							'actionField': {
								'id': '<? echo $ecommerceData['id'] ?>',                        
								'affiliation': '<? echo $ecommerceData['affiliation'] ?>',
								'revenue': '<? echo $ecommerceData['revenue'] ?>',  
								'tax':'<? echo $ecommerceData['tax'] ?>',

								<?php if (!empty($ecommerceData['coupon'])) { ?>
									'coupon':'<? echo $ecommerceData['coupon'] ?>',
								<?php } ?>

								'shipping': '<? echo $ecommerceData['shipping'] ?>'
							},
							'products': [
							<? $i=0; foreach ($ecommerceData['products'] as $ecommerceProduct) { ?>
								{
									'id' : '<? echo $ecommerceProduct['id']; ?>',
									'name' : '<? echo $ecommerceProduct['name'] ?>',
									'brand' : '<? echo $ecommerceProduct['brand'] ?>',
									'category' : '<? echo $ecommerceProduct['category'] ?>',
									'price' : '<? echo $ecommerceProduct['price'] ?>',
									'quantity' : '<? echo $ecommerceProduct['quantity'] ?>',
									'total' : '<? echo $ecommerceProduct['total'] ?>'
								}	<? if ($i < count($ecommerceData['products'])) { ?>,<?php } $i++; ?>
							<? } ?>

							]					
						}	
					}
				});
			});

			var imgProd = document.querySelectorAll('.table-order tbody tr td img');
			if (window.matchMedia('(max-width: 767px)').matches) {
				if(imgProd){
					imgProd.forEach(item => {
						var trParent = item.closest('tr');
						trParent.insertAdjacentElement('afterbegin', item);
					})
				}
			} 


		</script>


	<?php } ?>


<style>
			<?php echo $tmdaccount_customcss; ?>
			</style>
	<?php echo $footer; ?>		