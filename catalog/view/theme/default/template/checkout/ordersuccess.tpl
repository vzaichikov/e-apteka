<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>	
	</li>
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
      <h1><?php echo $heading_title; ?></h1> 
	   <div class="pull-right">
		<a style="background:<?php echo $titlebgcolor;?>; border:solid 1px <?php echo $titlebgcolor?>; color:<?php echo $titlecolor;?>;" target="_blank" href="<?php echo $invoice; ?>" class="btn btn-primary"><i class="fa fa-print"></i> <?php echo $button_invoice_print; ?></a></div>
	<?php if($printinvoice=='1') { ?>	
	  
	<?php } ?>
      <?php echo $text_message; ?>
	  
	   
	   
	  <!--Order Code-->
	  <?php if($orderdetail=='1') { ?>
	  <table class="table table-bordered table-hover">
        <thead>
          <tr style="background:<?php echo $titlebgcolor;?>; color:<?php echo $titlecolor;?>;">
            <td class="text-left" colspan="2"><?php echo $text_order_detail; ?></td>
		 
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;">
			<?php if($orderinvoice=='1') { ?>
              <b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
			<?php }?>
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
			  <?php if ($payment_method) { ?>
              <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br /><?php } ?>
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
              <?php } ?></td>
			  <td class="text-left" style="width: 50%;">
			  <b><?php echo $text_email;?> </b><?php echo $email;?><br />
			  <b><?php echo $text_telephone;?> </b><?php echo $telephone;?><br />
			  <b><?php echo $text_orderstatus;?> </b><?php echo $orderstatusname;?><br />
			  </td>
          </tr>
        </tbody>
      </table>
	  <?php } ?>
	   
      <table class="table table-bordered table-hover">
        <thead>
          <tr style="background:<?php echo $titlebgcolor;?>; color:<?php echo $titlecolor;?>;">
			<?php if($paymentaddress=='1') { ?>
            <td class="text-left" style="width: 50%; vertical-align: top;"><?php echo $text_payment_address; ?></td>
			<?php } ?>
			<?php if($shippingaddress=='1') { ?>
            <?php if ($shipping_address) { ?>
            <td class="text-left" style="width: 50%; vertical-align: top;"><?php echo $text_shipping_address; ?></td>
            <?php } } ?>            
          </tr>
        </thead>
        <tbody>
          <tr>
			<?php if($paymentaddress=='1') { ?>
            <td class="text-left"><?php echo $payment_address; ?></td>
			 <?php } ?>
			 <?php if($shippingaddress=='1') { ?>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><?php echo $shipping_address; ?></td>
			 <?php } }?>
          </tr>
        </tbody>
      </table>
	  
      <div class="table-responsive">
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
			 <?php if($productsku=='1') {
			 $r++  ?>
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
			  <?php if($text_share) { $r++ ?>
			 <td class="text-center"><b><?php echo $text_share; ?></b></td>
			  <?php } ?>
        </tr>
      </thead>
      <tbody>
		 <?php if(isset($order['products'])){ ?>
        <?php foreach ($order['products'] as $product) { ?>
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
		  <td class="text-center" colspan="<?php echo $r?>">
		  <?php if($facebookshare=='1') { ?>	
			<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $product['href'] ?>" target="_blank" data-toggle="tooltip" title="Share"><img style="display:inline-block;" src="catalog/view/theme/default/image/fb_new.png" class="img-responsive" alt="fb" title="fb" /></a>
			<?php } ?>
			<?php if($twittershare=='1') { ?>
			<a href="http://twitter.com/share?text=<?php echo $product['name']?>&url=<?php echo $product['href'] ?>" target="_blank" data-toggle="tooltip" title="Share"><img style="display:inline-block;" src="catalog/view/theme/default/image/tw_new.png" class="img-responsive" alt="tw" title="tw" /></a>
			<?php } ?>
			<?php if($googleshare=='1') { ?>
			<a href="https://plus.google.com/share?url=<?php echo $product['href'] ?>" target="_blank" data-toggle="tooltip" title="Share"> <img style="display:inline-block;" src="catalog/view/theme/default/image/g+_new.png" class="img-responsive" alt="g+" title="g+" /></a>
			
			<?php } ?></td>
        </tr>
		
		 <?php } } ?>
		<?php if(isset($vouchers)){ ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr style="background:#2197c4; color:#fff;">
          <td><?php echo $voucher['description']; ?></td>
          <td></td>
          <td class="text-right">1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
        </tr>
		  <?php } } ?>
		<?php if(isset($totals)){ ?>
        <?php foreach ($totals as $total) { ?>
        <tr>
			  <td colspan="<?php echo $r-2;?>"></td>
			  <td class="text-right"><b><?php echo $total['title']; ?></b></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
        <?php } } ?>
      </tbody>
    </table>
      </div>
	  <!--Order Code-->
	  <?php 
	 if(!empty($tracking)){ 
					echo html_entity_decode($tracking, ENT_QUOTES, 'UTF-8');
			 }
		?>
      <div class="buttons col-sm-12 continuebtn">
		<div class="pull-right"><a style="background:<?php echo $titlebgcolor;?>; border:solid 1px <?php echo $titlebgcolor?>; color:<?php echo $titlecolor;?>;" href="<?php echo $continue; ?>" class="btn btn-primary"><i class="fa fa-home"></i> <?php echo $button_continue; ?></a></div>
      </div>
	<!--Products-->
	
	<h1 class="text-center"><?php echo $text_relatedproduct?></h1>
	<hr/>
	<div class="row">
	
	  <?php foreach ($relproducts as $product) { ?>
	  <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="product-thumb transition">
		  <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
		  <div class="caption">
			<h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
			<p><?php echo $product['description']; ?></p>
			<?php if ($product['rating']) { ?>
			<div class="rating">
			  <?php for ($i = 1; $i <= 5; $i++) { ?>
			  <?php if ($product['rating'] < $i) { ?>
			  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
			  <?php } else { ?>
			  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
			  <?php } ?>
			  <?php } ?>
			</div>
			<?php } ?>
			<?php if ($product['price']) { ?>
			<p class="price">
			  <?php if (!$product['special']) { ?>
			  <?php echo $product['price']; ?>
			  <?php } else { ?>
			  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
			  <?php } ?>
			  <?php if ($product['tax']) { ?>
			  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
			  <?php } ?>
			</p>
			<?php } ?>
		  </div>
		  <div class="button-group">
			<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
			<button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
			<button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
		  </div>
		</div>
	  </div>
	  <?php } ?>
	</div>
	<!--Products-->
    <?php echo $content_bottom; ?></div>
	<?php echo $column_right; ?></div>
	</div>
	<style>
	.continuebtn{padding-right:0px;padding-bottom:10px}
	.socilashare{padding:0px 3px 20px  0px;border-bottom:solid 1px #ccc; margin-bottom:20px}
	<?php echo $customcss; ?>
	</style>
<?php echo $footer; ?>