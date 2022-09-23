<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link href="catalog/view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet"></head>
<body>
<div class="container">
  <?php foreach ($orders as $order) { ?>
  <div style="page-break-after: always;">
    <h1><?php echo $text_invoice; ?> #<?php echo $order['order_id']; ?></h1>
	 <?php if($orderdetail=='1') { ?>
    <table class="table table-bordered">
      <thead>
        <tr style="background:<?php echo $titlebgcolor;?>; border:solid 1px <?php echo $titlebgcolor?>; color:<?php echo $titlecolor;?>;">
          <td colspan="2"><?php echo $text_order_detail; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 50%;"><address>
            <strong><?php echo $order['store_name']; ?></strong><br />
            <?php echo $order['store_address']; ?>
            </address>
            <b><?php echo $text_telephone; ?></b> <?php echo $order['store_telephone']; ?><br />
            <?php if ($order['store_fax']) { ?>
            <b><?php echo $text_fax; ?></b> <?php echo $order['store_fax']; ?><br />
            <?php } ?>
            <b><?php echo $text_email; ?></b> <?php echo $order['store_email']; ?><br />
            <b><?php echo $text_website; ?></b> <a href="<?php echo $order['store_url']; ?>"><?php echo $order['store_url']; ?></a></td>
          <td style="width: 50%;"><b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
            <?php if ($order['invoice_no']) { ?>
            <b><?php echo $text_invoice_no; ?></b> <?php echo $order['invoice_no']; ?><br />
            <?php } ?>
            <b><?php echo $text_order_id; ?></b> <?php echo $order['order_id']; ?><br />
            <b><?php echo $text_payment_method; ?></b> <?php echo $order['payment_method']; ?><br />
            <?php if ($order['shipping_method']) { ?>
            <b><?php echo $text_shipping_method; ?></b> <?php echo $order['shipping_method']; ?><br />
            <?php } ?></td>
        </tr>
      </tbody>
    </table>
	 <?php } ?>
    <table class="table table-bordered">
      <thead>
        <tr style="background:<?php echo $titlebgcolor;?>; border:solid 1px <?php echo $titlebgcolor?>; color:<?php echo $titlecolor;?>;">
		<?php if($paymentaddress=='1') { ?>
          <td style="width: 50%;"><b><?php echo $text_payment_address; ?></b></td>
		  <?php } ?>
			<?php if($shippingaddress=='1') { ?>
          <td style="width: 50%;"><b><?php echo $text_shipping_address; ?></b></td>
		  <?php } ?>
        </tr>
      </thead>
      <tbody>
        <tr>
		<?php if($paymentaddress=='1') { ?>
          <td><address>
            <?php echo $order['payment_address']; ?>
            </address></td>
			 <?php } ?>
			 <?php if($shippingaddress=='1') { ?>
          <td><address>
            <?php echo $order['shipping_address']; ?>
            </address></td>
			 <?php } ?>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr style="background:<?php echo $titlebgcolor;?>; border:solid 1px <?php echo $titlebgcolor?>; color:<?php echo $titlecolor;?>;">
		<?php $r=0; if($showimage=='1') { $r++  ?>
           <td class="text-center"><?php echo $column_image; ?></td>
		   <?php } ?>
			<?php if($productname=='1') { $r++  ?>
            <td class="text-left"><?php echo $column_name; ?></td>
			<?php } ?>
			<?php if($productmodel=='1') { $r++  ?>
			<td><b><?php echo $column_model; ?></b></td>
			<?php } ?>
			 <?php if($productsku=='1') { $r++  ?>
			 <td><b><?php echo $column_sku; ?></b></td>
			 <?php } ?>
			 <?php if($productqty=='1') { $r++ ?>
			<td class="text-right"><b><?php echo $column_quantity; ?></b></td>
			 <?php } ?>
			 <?php if($productunitprice=='1') { $r++ ?>
			<td class="text-right"><b><?php echo $column_price; ?></b></td>
			 <?php } ?>
			 <?php if($producttotal=='1') { $r++ ?>
			<td class="text-right"><b><?php echo $column_total; ?></b></td>
			 <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order['product'] as $product) { ?>
        <tr>
		<?php if($showimage=='1') { ?>
			<td class="text-center"><?php if ($product['image']) { ?>
			<img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
			<?php } else { ?>
			<span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
		 <?php } ?></td>
		 <?php } ?>
		 <?php if($productname=='1') { ?>
          <td><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
            <?php } ?></td>
			<?php } ?>
			<?php if($productmodel=='1') { ?>
          <td><?php echo $product['model']; ?></td>
		    <?php } ?>
			  <?php if($productsku=='1') { ?>
		    <?php if(isset($product['sku'])) { ?>
          <td><?php echo $product['sku']; ?></td>
		  <?php } else {?>
		  <td></td>
		  
			  <?php } }?>
		  <?php if($productqty=='1') { ?>
          <td class="text-right"><?php echo $product['quantity']; ?></td>
		  <?php } ?>
		  <?php if($productunitprice=='1') { ?>
          <td class="text-right"><?php echo $product['price']; ?></td>
		   <?php } ?>
		    <?php if($producttotal=='1') { ?>
          <td class="text-right"><?php echo $product['total']; ?></td>
		  <?php } ?>
        </tr>
        <?php } ?>
        <?php foreach ($order['voucher'] as $voucher) { ?>
        <tr style="background:#2197c4; color:#fff;">
          <td><?php echo $voucher['description']; ?></td>
          <td></td>
          <td class="text-right">1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($order['total'] as $total) { ?>
        <tr>
			  <td colspan="<?php echo $r-2;?>"></td>
			  <td class="text-right"><b><?php echo $total['title']; ?></b></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php if ($order['comment']) { ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b><?php echo $text_comment; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $order['comment']; ?></td>
        </tr>
      </tbody>
    </table>
    <?php } ?>
  </div>
  <?php } ?>
</div>
</body>
</html>