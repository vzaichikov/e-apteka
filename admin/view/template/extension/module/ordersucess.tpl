<?php echo $header; ?>
<script src="view/javascript/bootstrap/js/bootstrap-switch.js"></script>
<script src="view/javascript/bootstrap/js/highlight.js"></script>
<script src="view/javascript/bootstrap/js/bootstrap-switch.js"></script>
<script src="view/javascript/bootstrap/js/main.js"></script>
<link href="view/javascript/bootstrap/css/bootstrap-switch.css" rel="stylesheet">
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-ordersucess" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ordersucess" class="form-horizontal">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
				<li><a href="#tab-invoice" data-toggle="tab"><?php echo $tab_invoice; ?></a></li>
				<li><a href="#tab-language" data-toggle="tab"><?php echo $tab_languge; ?></a></li>
				<li><a href="#tab-products" data-toggle="tab"><?php echo $tab_products; ?></a></li>
				<li><a href="#tab-google" data-toggle="tab"><?php echo $tab_google; ?></a></li>
				<li><a href="#tab-custom_css" data-toggle="tab"><?php echo $tab_custome_css; ?></a></li>
			</ul>
			<div class="tab-content">
			<div class="tab-pane active" id="tab-general">
				
			  
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
					<div class="col-sm-10">
					  <select name="ordersucess_status" id="input-status" class="form-control">
						<?php if ($ordersucess_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-orderinvoice"><?php echo $entry_orderinvoice; ?></label>
					<div class="col-sm-10">
					<input <?php if($ordersucess_ordinvoc){ echo"checked=checked"; } ?>  type="radio" name="ordersucess_ordinvoc" value="1" data-radio-all-off="true" class="switch-radio2"/>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-printinvoice"><?php echo $entry_printinvoice; ?></label>
					<div class="col-sm-10">
						<input type="radio" name="ordersucess_printinvoice_status" id="input-printinvoice" value="1" <?php if ($ordersucess_printinvoice_status) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-orderdetail"><?php echo $entry_orderdetail; ?></label>
					<div class="col-sm-10">
						<input type="radio" name="ordersucess_orderdetail" id="input-orderdetail" value="1" <?php if ($ordersucess_orderdetail) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-paymentaddress"><?php echo $entry_paymentaddress; ?></label>
					<div class="col-sm-10">
						<input type="radio" name="ordersucess_paymentadres" id="input-paymentaddress" value="1" <?php if ($ordersucess_paymentadres) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-shippingaddress"><?php echo $entry_shippingaddress; ?></label>
					<div class="col-sm-10">
						<input type="radio" name="ordersucess_shippingaddress" id="input-shippingaddress" value="1" <?php if ($ordersucess_shippingaddress) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-enablefacebookshare"><?php echo $entry_enablefacebookshare; ?></label>
					<div class="col-sm-10">
						<input type="radio" name="ordersucess_enablefacebookshare" id="input-enablefacebookshare" value="1" <?php if ($ordersucess_enablefacebookshare) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-enabletwittershare"><?php echo $entry_enabletwittershare; ?></label>
					<div class="col-sm-10">
						<input type="radio" name="ordersucess_enabletwittershare" id="input-enabletwittershare" value="1" <?php if ($ordersucess_enabletwittershare) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-enablegoogleshare"><?php echo $entry_enablegoogleshare; ?></label>
					<div class="col-sm-10">
						<input type="radio" name="ordersucess_enablegoogleshare" id="input-enablegoogleshare" value="1" <?php if ($ordersucess_enablegoogleshare) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-productimage"><?php echo $entry_productimage; ?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-3">
								<input type="text" name="ordersucess_proimg_width" id="input-productimage" value="<?php echo $ordersucess_proimg_width; ?>" class="form-control" />
							</div>
							<div class="col-sm-3">
								<input type="text" name="ordersucess_proimg_height" id="input-productimage" value="<?php echo $ordersucess_proimg_height; ?>" class="form-control" />
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-titlebgcolor"><?php echo $entry_titlebgcolor; ?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-3">
								<input type="text" name="ordersucess_titlebgcolor" value="<?php echo $ordersucess_titlebgcolor; ?>"  id="input-titlebgcolor" class="form-control color" />
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-titlecolor"><?php echo $entry_titlecolor; ?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-3">
								<input type="text" name="ordersucess_titlecolor" value="<?php echo $ordersucess_titlecolor; ?>"  id="input-titlecolor" class="form-control color" />
							</div>
						</div>
					</div>
				</div>
				
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td class="text-left"><?php echo $column_image; ?></td>
								<td class="text-left"><?php echo $column_name; ?></td>
								<td class="text-left"><?php echo $column_model; ?></td>
								<td class="text-left"><?php echo $column_sku; ?></td>
								<td class="text-left"><?php echo $column_quantity; ?></td>
								<td class="text-left"><?php echo $column_unitprice; ?></td>
								<td class="text-left"><?php echo $column_total; ?></td>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td class="text-left"><input type="radio" name="ordersucess_showimage" id="input-showimage" value="1" <?php if ($ordersucess_showimage) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" /></td>
							
							<td class="text-left"><input type="radio" name="ordersucess_proname" id="input-productname" value="1" <?php if ($ordersucess_proname) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" /></td>
							
							<td class="text-left"><input type="radio" name="ordersucess_model" id="input-model" value="1" <?php if ($ordersucess_model) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" /></td>
							
							<td class="text-left"><input type="radio" name="ordersucess_sku" id="input-sku" value="1" <?php if ($ordersucess_sku) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" /></td>
							
							<td class="text-left"><input type="radio" name="ordersucess_quantity" id="input-quantity" value="1" <?php if ($ordersucess_quantity) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" /></td>
							
							<td class="text-left"><input type="radio" name="ordersucess_uniprice" id="input-uniprice" value="1" <?php if ($ordersucess_uniprice) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" /></td>
							
							
							
							<td class="text-left"><input type="radio" name="ordersucess_total" id="input-total" value="1" <?php if ($ordersucess_total) { ?> checked <?php } ?>data-radio-all-off="true" class="switch-radio2" /></td>
								
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="tab-invoice">
				<ul class="nav nav-tabs" id="language">
					<?php foreach ($languages as $language) { ?>
					<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
					<?php } ?>
				</ul>
				<div class="tab-content">
				<?php foreach ($languages as $language) { ?>
					<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_heading; ?></label>
							<div class="col-sm-7">
								<input type="text" name="ordersucess_pageheading[<?php echo $language['language_id']; ?>][pageheading]" value="<?php echo isset($ordersucess_pageheading[$language['language_id']]) ? $ordersucess_pageheading[$language['language_id']]['pageheading'] : ''; ?>" placeholder="<?php echo $entry_heading; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
							</div>
							<div class="col-sm-3">
								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-msgguestuser<?php echo $language['language_id']; ?>"><?php echo $entry_msgguestuser; ?></label>
							<div class="col-sm-7">
							  <textarea name="ordersucess_guestuser[<?php echo $language['language_id']; ?>][guestuser]" placeholder="<?php echo $entry_msgguestuser; ?>" id="input-msgguestuser<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($ordersucess_guestuser[$language['language_id']]) ? $ordersucess_guestuser[$language['language_id']]['guestuser'] : ''; ?></textarea>
							</div>
							<div class="col-sm-3">
								<h2>Short Codes</h2>
								<ul class="list-unstyled">
									<li>{order_id} = Order Id</li>
									<li>{firstname} = First Name</li>
									<li>{lastname} = Last Name</li>
									<li>{account} = Account Page</li>
									<li>{order_history} = Order History Page</li>
									<li>{downloads} = Download page</li>
									<li>{contact_us} = Contact Us</li>
								</ul>
							</div>
						</div>
						<div class="form-group">
						<label class="col-sm-2 control-label" for="input-msgreguser<?php echo $language['language_id']; ?>"><?php echo $entry_msgreguser; ?></label>
							<div class="col-sm-7">
							  <textarea name="ordersucess_reguser[<?php echo $language['language_id']; ?>][reguser]" placeholder="<?php echo $entry_msgreguser; ?>" id="input-msgreguser<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($ordersucess_reguser[$language['language_id']]) ? $ordersucess_reguser[$language['language_id']]['reguser'] : ''; ?></textarea>
							</div>
							<div class="col-sm-3">
								<h2>Short Codes</h2>
								<ul class="list-unstyled">
									<li>{order_id} = Order Id</li>
									<li>{firstname} = First Name</li>
									<li>{lastname} = Last Name</li>
									<li>{account} = Account Page</li>
									<li>{order_history} = Order History Page</li>
									<li>{downloads} = Download page</li>
									<li>{contact_us} = Contact Us</li>
								</ul>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-account<?php echo $language['language_id']; ?>"><?php echo $entry_account_lable; ?></label>
							<div class="col-sm-7">
								<input type="text" name="ordersucess_shortcut[<?php echo $language['language_id']; ?>][account_lable]" value="<?php echo isset($ordersucess_shortcut[$language['language_id']]) ? $ordersucess_shortcut[$language['language_id']]['account_lable'] : ''; ?>" placeholder="<?php echo $entry_account_lable; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
							</div>
							<div class="col-sm-3">
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-order_history<?php echo $language['language_id']; ?>"><?php echo $entry_order_history; ?></label>
							<div class="col-sm-7">
								<input type="text" name="ordersucess_shortcut[<?php echo $language['language_id']; ?>][order_history]" value="<?php echo isset($ordersucess_shortcut[$language['language_id']]) ? $ordersucess_shortcut[$language['language_id']]['order_history'] : ''; ?>" placeholder="<?php echo $entry_order_history; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
							</div>
							<div class="col-sm-3">
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_downloads; ?></label>
							<div class="col-sm-7">
								<input type="text" name="ordersucess_shortcut[<?php echo $language['language_id']; ?>][downloads]" value="<?php echo isset($ordersucess_shortcut[$language['language_id']]) ? $ordersucess_shortcut[$language['language_id']]['downloads'] : ''; ?>" placeholder="<?php echo $entry_downloads; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
							</div>
							<div class="col-sm-3">
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_contactus; ?></label>
							<div class="col-sm-7">
								<input type="text" name="ordersucess_shortcut[<?php echo $language['language_id']; ?>][contactus]" value="<?php echo isset($ordersucess_shortcut[$language['language_id']]) ? $ordersucess_shortcut[$language['language_id']]['contactus'] : ''; ?>" placeholder="<?php echo $entry_contactus; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
							</div>
							<div class="col-sm-3">
								
							</div>
						</div>
						
						
					</div>
				<?php } ?>
				</div>
			</div>
			<div class="tab-pane" id="tab-language">
				<ul class="nav nav-tabs" id="languagess">
					<?php foreach ($languages as $language) { ?>
					<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
					<?php } ?>
				</ul>
				<div class="tab-contents">
				<?php foreach ($languages as $language) { ?>
					<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
						<div class="tab-pane" id="tab-language">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-package-order_details"><?php echo $entry_order_details;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][order_details]" value="<?php if(isset($ordersucess_language[$language['language_id']]['order_details'])){echo $ordersucess_language[$language['language_id']]['order_details']; }?>" placeholder="<?php echo $entry_order_details; ?>" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-package-order_id"><?php echo $entry_order_id;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][order_id]" value="<?php if(isset($ordersucess_language[$language['language_id']]['order_id'])){echo $ordersucess_language[$language['language_id']]['order_id']; }?>" placeholder="<?php echo $entry_order_id; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-date_added"><?php echo $entry_date_added;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][date_added]" value="<?php if(isset($ordersucess_language[$language['language_id']]['date_added'])){echo $ordersucess_language[$language['language_id']]['date_added']; }?>" placeholder="<?php echo $entry_date_added; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-payment_method"><?php echo $entry_payment_method;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][payment_method]" value="<?php if(isset($ordersucess_language[$language['language_id']]['payment_method'])){echo $ordersucess_language[$language['language_id']]['payment_method']; }?>" placeholder="<?php echo $entry_payment_method; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-shipping_method"><?php echo $entry_shipping_method;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][shipping_method]" value="<?php if(isset($ordersucess_language[$language['language_id']]['shipping_method'])){echo $ordersucess_language[$language['language_id']]['shipping_method']; }?>" placeholder="<?php echo $entry_shipping_method; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][email]" value="<?php if(isset($ordersucess_language[$language['language_id']]['email'])){echo $ordersucess_language[$language['language_id']]['email']; }?>" placeholder="<?php echo $entry_email; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][telephone]" value="<?php if(isset($ordersucess_language[$language['language_id']]['telephone'])){echo $ordersucess_language[$language['language_id']]['telephone']; }?>" placeholder="<?php echo $entry_telephone; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-order_status"><?php echo $entry_order_status;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][order_status]" value="<?php if(isset($ordersucess_language[$language['language_id']]['order_status'])){echo $ordersucess_language[$language['language_id']]['order_status']; }?>" placeholder="<?php echo $entry_order_status; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-payment_address"><?php echo $entry_payment_address;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][payment_address]" value="<?php if(isset($ordersucess_language[$language['language_id']]['payment_address'])){echo $ordersucess_language[$language['language_id']]['payment_address']; }?>" placeholder="<?php echo $entry_payment_address; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-shipping_address"><?php echo $entry_shipping_address;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][shipping_address]" value="<?php if(isset($ordersucess_language[$language['language_id']]['shipping_address'])){echo $ordersucess_language[$language['language_id']]['shipping_address']; }?>" placeholder="<?php echo $entry_shipping_address; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][image]" value="<?php if(isset($ordersucess_language[$language['language_id']]['image'])){echo $ordersucess_language[$language['language_id']]['image']; }?>" placeholder="<?php echo $entry_image; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-product_name"><?php echo $entry_product_name;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][product_name]" value="<?php if(isset($ordersucess_language[$language['language_id']]['product_name'])){echo $ordersucess_language[$language['language_id']]['product_name']; }?>" placeholder="<?php echo $entry_product_name; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][model]" value="<?php if(isset($ordersucess_language[$language['language_id']]['model'])){echo $ordersucess_language[$language['language_id']]['model']; }?>" placeholder="<?php echo $entry_model; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-sku"><?php echo $entry_sku;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][sku]" value="<?php if(isset($ordersucess_language[$language['language_id']]['sku'])){echo $ordersucess_language[$language['language_id']]['sku']; }?>" placeholder="<?php echo $entry_sku; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][quantity]" value="<?php if(isset($ordersucess_language[$language['language_id']]['quantity'])){echo $ordersucess_language[$language['language_id']]['quantity']; }?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][price]" value="<?php if(isset($ordersucess_language[$language['language_id']]['price'])){echo $ordersucess_language[$language['language_id']]['price']; }?>" placeholder="<?php echo $entry_price; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-total"><?php echo $entry_total;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][total]" value="<?php if(isset($ordersucess_language[$language['language_id']]['total'])){echo $ordersucess_language[$language['language_id']]['total']; }?>" placeholder="<?php echo $entry_total; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-continue"><?php echo $entry_continue;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][continue]" value="<?php if(isset($ordersucess_language[$language['language_id']]['continue'])){echo $ordersucess_language[$language['language_id']]['continue']; }?>" placeholder="<?php echo $entry_continue; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-printInvoice"><?php echo $entry_printInvoice;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][printinvoice]" value="<?php if(isset($ordersucess_language[$language['language_id']]['printinvoice'])){echo $ordersucess_language[$language['language_id']]['printinvoice']; }?>" placeholder="<?php echo $entry_printinvoice; ?>" class="form-control" >
					</div>
				</div>
				
				<h2 class="text-center">Invoice Page Lables</h2>
				<hr/>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-invoice_page"><?php echo $entry_invoice_page;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoice_page]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoice_page'])){echo $ordersucess_language[$language['language_id']]['invoice_page']; }?>" placeholder="<?php echo $entry_invoice_page; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-package-order_details"><?php echo $entry_order_details;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoorder_details]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoorder_details'])){echo $ordersucess_language[$language['language_id']]['invoorder_details']; }?>" placeholder="<?php echo $entry_order_details; ?>" class="form-control" >
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invotelephone]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invotelephone'])){echo $ordersucess_language[$language['language_id']]['invotelephone']; }?>" placeholder="<?php echo $entry_telephone; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoemail]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoemail'])){echo $ordersucess_language[$language['language_id']]['invoemail']; }?>" placeholder="<?php echo $entry_email; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-date_added"><?php echo $entry_date_added;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invodate_added]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invodate_added'])){echo $ordersucess_language[$language['language_id']]['invodate_added']; }?>" placeholder="<?php echo $entry_date_added; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-package-order_id"><?php echo $entry_order_id;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoorder_id]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoorder_id'])){echo $ordersucess_language[$language['language_id']]['invoorder_id']; }?>" placeholder="<?php echo $entry_order_id; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-payment_method"><?php echo $entry_payment_method;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invopayment_method]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invopayment_method'])){echo $ordersucess_language[$language['language_id']]['invopayment_method']; }?>" placeholder="<?php echo $entry_payment_method; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-shipping_method"><?php echo $entry_shipping_method;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoshipping_method]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoshipping_method'])){echo $ordersucess_language[$language['language_id']]['invoshipping_method']; }?>" placeholder="<?php echo $entry_shipping_method; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoimage]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoimage'])){echo $ordersucess_language[$language['language_id']]['invoimage']; }?>" placeholder="<?php echo $entry_image; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-product_name"><?php echo $entry_product_name;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoproduct_name]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoproduct_name'])){echo $ordersucess_language[$language['language_id']]['invoproduct_name']; }?>" placeholder="<?php echo $entry_product_name; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invomodel]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invomodel'])){echo $ordersucess_language[$language['language_id']]['invomodel']; }?>" placeholder="<?php echo $entry_model; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-sku"><?php echo $entry_sku;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invosku]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invosku'])){echo $ordersucess_language[$language['language_id']]['invosku']; }?>" placeholder="<?php echo $entry_sku; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoquantity]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoquantity'])){echo $ordersucess_language[$language['language_id']]['invoquantity']; }?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invoprice]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invoprice'])){echo $ordersucess_language[$language['language_id']]['invoprice']; }?>" placeholder="<?php echo $entry_price; ?>" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-total"><?php echo $entry_total;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_language[<?php echo $language['language_id'];?>][invototal]" value="<?php if(isset($ordersucess_language[$language['language_id']]['invototal'])){echo $ordersucess_language[$language['language_id']]['invototal']; }?>" placeholder="<?php echo $entry_total; ?>" class="form-control" >
					</div>
				</div>
			</div>	
					</div>
				<?php } ?>
				</div>
			</div>
				
			<div class="tab-pane" id="tab-products">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-title"><?php echo $entry_title;?></label>
					<div class="col-sm-10">
						<input type="text" name="ordersucess_title" value="<?php echo $ordersucess_title; ?>" placeholder="<?php echo $entry_title;?>" id="input-title" class="form-control">
					</div>
				</div>
				<div class="form-group">
				<label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
				<div class="col-sm-10">
				  <input type="text" name="ordersucess_productname" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
				  <div id="ordersuccess-product" class="well well-sm" style="height: 150px; overflow: auto;">
					<?php foreach ($products as $product) { ?>
					<div id="ordersuccess-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
					  <input type="hidden" name="ordersucess_product[]" value="<?php echo $product['product_id']; ?>" />
					</div>
					<?php } ?>
				  </div>
				</div>
			  </div>
			</div>
			<div class="tab-pane" id="tab-google">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-title"><?php echo $entry_google_con;?></label>
					<div class="col-sm-7">
						<textarea rows="10" name="ordersucess_google_conversion" placeholder="<?php echo $entry_google_con; ?>" value="" id="input-google_conversion" class="form-control"><?php echo $ordersucess_google_conversion; ?></textarea>
					</div>
					
					<div class="col-sm-3">
						<h2>Short Codes</h2>
						<ul class="list-unstyled">
							Language Code :: {language_code} <br/>
							Order Total :: {order_total} <br/>
							Currency Code :: {currency_code} 
						</ul>
					</div>
				</div> 
			</div>
			<div class="tab-pane" id="tab-custom_css">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-custom_css"><?php echo $entry_custom_css;?></label>
					<div class="col-sm-10">
						<textarea name="ordersucess_custom_css" rows="8" placeholder="<?php echo $entry_custom_css; ?>" value="" id="input-custom_css" class="form-control"><?php echo $ordersucess_custom_css; ?></textarea>
					</div>
				</div> 
			</div>	
				
				
		</div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
 
<script src="view/javascript/colorbox/jquery.minicolors.js"></script>
<link rel="stylesheet" href="view/stylesheet/jquery.minicolors.css">
<script type="text/javascript"><!--
$('#languagess a:first').tab('show');
//--></script>	
<script>
		$(document).ready( function() {
			
            $('.color').each( function() {
               		$(this).minicolors({
					control: $(this).attr('data-control') || 'hue',
					defaultValue: $(this).attr('data-defaultValue') || '',
					inline: $(this).attr('data-inline') === 'true',
					letterCase: $(this).attr('data-letterCase') || 'lowercase',
					opacity: $(this).attr('data-opacity'),
					position: $(this).attr('data-position') || 'bottom left',
					change: function(hex, opacity) {
						if( !hex ) return;
						if( opacity ) hex += ', ' + opacity;
						try {
							console.log(hex);
						} catch(e) {}
					},
					theme: 'bootstrap'
				});
                
            });
			
		});
$('#language a:first').tab('show');
</script>
<script type="text/javascript"><!--
$('input[name=\'ordersucess_productname\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'ordersucess_productname\']').val('');
		
		$('#ordersuccess-product' + item['value']).remove();
		
		$('#ordersuccess-product').append('<div id="ordersuccess-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="ordersucess_product[]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#ordersuccess-product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
<style>
.minicolors-theme-bootstrap .minicolors-input{width:100%; height:35px;}
</style>
<?php echo $footer; ?>
