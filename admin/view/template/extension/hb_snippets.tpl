<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<!--Header Start-->
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
	  </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
 <!--Header End--> 
 
  <div class="container-fluid">
    <!--Start - Error / Success Message if any -->
	<?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<!--End - Error / Success Message if any -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      		<h4 style="color:#009900;"><?php echo $text_about; ?></h4><br />
			<h4><b>TESTING TOOL: <a href="https://developers.google.com/structured-data/testing-tool/" target="_blank">https://developers.google.com/structured-data/testing-tool/</a></b></h4><br />
      	<center><div id='loadgif' style='display:none;'><img src='view/image/loading-bar.gif'/></div></center>
		<div id="msgoutput" style="text-align:center;"></div>
	

          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language" class="form-horizontal">
		     <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-kg" data-toggle="tab"><?php echo $tab_kg; ?></a></li>
				<li><a href="#tab-product" data-toggle="tab"><?php echo $tab_product; ?></a></li>
				<li><a href="#tab-contact" data-toggle="tab"><?php echo $tab_contact; ?></a></li>
				<li><a href="#tab-breadcrumb" data-toggle="tab"><?php echo $tab_breadcrumb; ?></a></li>
				<li><a href="#tab-og" data-toggle="tab"><?php echo $tab_og; ?></a></li>
	          </ul>
			  <div class="tab-content">
			  
			  <style>
			  .accordion {
					margin-bottom: 20px;
				}
				.accordion-group {
    margin-bottom: 2px;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
	background-color:#fcfcfc;
}
.accordion-heading {
    border-bottom: 0;
	background-color:#999999;
	
}.accordion-heading a{
color:#FFFFFF;
font-weight:bold;
font-size:12px;
}

.accordion-toggle {
    display: block;
    padding: 8px 15px;
}
.accordion-toggle {
    cursor: pointer;
}.accordion-inner {
    padding: 9px 15px;
    border-top: 1px solid #e5e5e5;
}
			  </style>
					 <div class="tab-pane active" id="tab-kg">
					 <div class="accordion" id="kg">
					  <div class="accordion-group">
						<div class="accordion-heading">
						  <a class="accordion-toggle" data-toggle="collapse" data-parent="#kg" href="#collapseOne">
							<?php echo $text_kg_logo; ?>
						  </a>
						</div>
						<div id="collapseOne" class="accordion-body collapse in">
						  <div class="accordion-inner">
						  	<div class="form-group">
								<label class="col-sm-2 control-label">Enable Logo URL</label>
								<div class="col-sm-10">
									<select name="hb_snippets_logo_url" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_logo_url == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_logo_url == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="accordion-group">
						<div class="accordion-heading">
						  <a class="accordion-toggle" data-toggle="collapse" data-parent="#kg" href="#collapseTwo">
							<?php echo $text_kg_contact; ?>
						  </a>
						</div>
						<div id="collapseTwo" class="accordion-body collapse">
						  <div class="accordion-inner">
								<div class="form-group">
								<label class="col-sm-2 control-label">Enable Contacts to be shown in Search Results</label>
								<div class="col-sm-10">
									<select name="hb_snippets_contact_enable" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_contact_enable == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_contact_enable == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
							</div>	
							<h4 style="color:#0066CC;">Add internationalized version of the phone number, starting with the "+" symbol and country code</h4>
							<div id="corp_contact">
							<?php $contact_row = 0; ?>
							<?php if ($hb_snippets_contact){ ?>
							<?php foreach ($hb_snippets_contact as $contact){ ?>							
								<div class="form-group" id="contact-row<?php echo $contact_row; ?>">
								<div class="col-sm-2"></div>
								<div class="col-sm-4"><input type="text" placeholder="+1-401-555-1212" name="hb_snippets_contact[<?php echo $contact_row; ?>][n]" class="form-control" value="<?php echo $contact['n']; ?>"></div>
								<div class="col-sm-4"><select name="hb_snippets_contact[<?php echo $contact_row; ?>][t]" class="form-control">
								<option <?php echo ($contact['t'] == 'Customer Service')? 'selected':''; ?> >Customer Service</option>
								<option <?php echo ($contact['t'] == 'Customer Support')? 'selected':''; ?> >Customer Support</option>
								<option <?php echo ($contact['t'] == 'Technical Support')? 'selected':''; ?> >Technical Support</option>
								<option <?php echo ($contact['t'] == 'Billing Support')? 'selected':''; ?> >Billing Support</option>
								<option <?php echo ($contact['t'] == 'Bill Payment')? 'selected':''; ?> >Bill Payment</option>
								<option <?php echo ($contact['t'] == 'Sales')? 'selected':''; ?> >Sales</option>
								<option <?php echo ($contact['t'] == 'Reservations')? 'selected':''; ?> >Reservations</option>
								<option <?php echo ($contact['t'] == 'Credit Card Support')? 'selected':''; ?> >Credit Card Support</option>
								<option <?php echo ($contact['t'] == 'Emergency')? 'selected':''; ?> >Emergency</option>
								<option <?php echo ($contact['t'] == 'Baggage Tracking')? 'selected':''; ?> >Baggage Tracking</option>
								<option <?php echo ($contact['t'] == 'Roadside Assistance')? 'selected':''; ?> >Roadside Assistance</option>
								<option <?php echo ($contact['t'] == 'Package Tracking')? 'selected':''; ?> >Package Tracking</option>
								</select>
								</div>
								<div class="col-sm-2">
								<button type="button" onclick="$('#contact-row<?php echo $contact_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></div>
								</div>
								<?php $contact_row++; ?>
							<?php } ?>	
							<?php } ?>	
							</div>
							<a onclick="addcontact();" class="btn btn-default">ADD CONTACT NUMBER</a>
							
						  </div>
						</div>
					  </div>
					  <div class="accordion-group">
						<div class="accordion-heading">
						  <a class="accordion-toggle" data-toggle="collapse" data-parent="#kg" href="#collapseThree">
							<?php echo $text_kg_social; ?>
						  </a>
						</div>
						<div id="collapseThree" class="accordion-body collapse">
						  <div class="accordion-inner">
						  	<div class="form-group">
								<label class="col-sm-2 control-label">Enable Social Profile to be shown in Search Results</label>
								<div class="col-sm-10">
									<select name="hb_snippets_social_enable" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_social_enable == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_social_enable == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
							</div>
								<div id="corp_social">
									<?php $social_row = 0; ?>
									<?php if ($hb_snippets_socials){ ?>
									<?php foreach ($hb_snippets_socials as $social){ ?>							
										<div class="form-group" id="social-row<?php echo $social_row; ?>">
										<div class="col-sm-2"></div>
										<div class="col-sm-8"><input type="text" placeholder="https://www.facebook.com/your-profile" name="hb_snippets_socials[<?php echo $social_row; ?>]" class="form-control" value="<?php echo $social; ?>"></div>
										<div class="col-sm-2">
										<button type="button" onclick="$('#social-row<?php echo $social_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></div>
										</div>
										<?php $social_row++; ?>
									<?php } ?>	
									<?php } ?>	
								</div>
							<a onclick="addsocial();" class="btn btn-default">ADD SOCIAL PROFILE LINKS</a>	
						  </div>
						</div>
					  </div>
					  <div class="accordion-group">
						<div class="accordion-heading">
						  <a class="accordion-toggle" data-toggle="collapse" data-parent="#kg" href="#collapsesitelink">
							<?php echo $text_kg_searchbox; ?>
						  </a>
						</div>
					  <div id="collapsesitelink" class="accordion-body collapse">
						  <div class="accordion-inner">
						  	<div class="form-group">
								<label class="col-sm-2 control-label">Enable Sitelinks Search Box to be shown in Search Results</label>
								<div class="col-sm-10">
									<select name="hb_snippets_search_enable" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_search_enable == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_search_enable == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="accordion-group">
						<div class="accordion-heading" style="background-color:#669966;">
						  <a class="accordion-toggle" data-toggle="collapse" data-parent="#kg" href="#collapseFour">
							<i class="fa fa-gears"></i> <?php echo $text_kg_generate; ?>
						  </a>
						</div>
						<div id="collapseFour" class="accordion-body collapse">
						  <div class="accordion-inner">
						  	<div class="form-group">
								<label class="col-sm-2 control-label">Enable Knowledge Graph</label>
								<div class="col-sm-10">
									<select name="hb_snippets_kg_enable" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_kg_enable == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_kg_enable == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
							</div>
							<a onclick="generate_kg();" class="btn btn-warning">Save above settings and then click this button to Generate JSON-LD Markup for Knowledge Graph and save it again</a>
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<textarea name="hb_snippets_kg_data"  id="hb_snippets_kg_data" rows="10" class="form-control"><?php echo $hb_snippets_kg_data; ?>
									 </textarea>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					
					</div>
					<div class="tab-pane" id="tab-product">
				   		<p><i class="fa fa-info-circle"></i> Including structured data markup in web content helps Google algorithms better index and understand the content. Some data can also be used to create and display Rich Snippets within the search results. Information about a product, including price, availability, and review ratings will appear in
						search results.</p><br />
						<p><i class="fa fa-info-circle"></i> To check product page structured data, <a href="https://developers.google.com/structured-data/testing-tool/" target="_blank">https://developers.google.com/structured-data/testing-tool/</a> .</p><br />
						  <div class="form-group">
								<label class="col-sm-2 control-label">Enable Product Page Rich Snippet</label>
								<div class="col-sm-10">
									<select name="hb_snippets_prod_enable" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_prod_enable == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_prod_enable == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
							</div>
				   </div>
					
					<div class="tab-pane" id="tab-contact">
					<h4><?php echo $text_header_local; ?></h4>
					<table class="table table-hover">
			              <tr>
			                <td><?php echo $col_business_name; ?></td>
			                <td><input type="text" class="form-control" name="hb_snippets_local_name" id="hb_snippets_local_name" value="<?php echo $hb_snippets_local_name;?>" /></td>
			              </tr>
						 <tr>
			                <td><?php echo $col_address; ?></td>
			                <td><input type="text" class="form-control" name="hb_snippets_local_st" id="hb_snippets_local_st" value="<?php echo $hb_snippets_local_st;?>" /></td>
			              </tr>
			              <tr>
			                <td><?php echo $col_locality; ?></td>
			                <td><input type="text" class="form-control" name="hb_snippets_local_location" id="hb_snippets_local_location" value="<?php echo $hb_snippets_local_location;?>" /></td>
			              </tr>
						  <tr>
			                <td><?php echo $col_state; ?></td>
			                <td><input type="text" class="form-control" name="hb_snippets_local_state" id="hb_snippets_local_state" value="<?php echo $hb_snippets_local_state;?>" /></td>
			              </tr>
			              <tr>
			                <td><?php echo $col_postal; ?></td>
			               <td><input type="text" class="form-control" name="hb_snippets_local_postal" id="hb_snippets_local_postal" value="<?php echo $hb_snippets_local_postal;?>" /></td>
			              </tr>
						  <tr>
			                <td><?php echo $col_country; ?></td>
			                <td><input type="text" class="form-control" name="hb_snippets_local_country" id="hb_snippets_local_country" value="<?php echo $hb_snippets_local_country;?>" /></td>
			              </tr>
						  <!--2 new parameter added-->
						  <tr>
			                <td><?php echo $col_store_image; ?></td>
			                <td><input type="text" class="form-control" name="hb_snippets_store_image" id="hb_snippets_store_image" value="<?php echo $hb_snippets_store_image;?>" placeholder = "Enter your Local Store Picture Link" required/></td>
			              </tr>
						  <tr>
			                <td><?php echo $col_price_range; ?></td>
			                <td><input type="text" class="form-control" name="hb_snippets_price_range" id="hb_snippets_price_range" value="<?php echo $hb_snippets_price_range;?>" placeholder="$0 to $20000" required /></td>
			              </tr>
						  <tr>
						  <td></td>
						  <td><a class="btn btn-primary" onclick="generatelocalsnippet()"><?php echo $btn_generate; ?></a> <span id='loadgif2' style='display:none;'><img src='view/image/loading.gif'/></span></td>
						  </tr>
						  <tr>
			                <td><?php echo $col_local_snippet; ?></td>
			               <td><textarea name="hb_snippets_local_snippet" id="hb_snippets_local_snippet" rows="10" cols="60"><?php echo $hb_snippets_local_snippet;?></textarea></td>
			              </tr>
						  <tr>
					          <td><?php echo $col_enable; ?></td>
					          <td><select name="hb_snippets_local_enable" class="form-control">
							  <option value="y" <?php echo ($hb_snippets_local_enable == 'y')? 'selected':''; ?> >Yes</option>
							  <option value="n" <?php echo ($hb_snippets_local_enable == 'n')? 'selected':''; ?> >No</option>
							  </select></td>
					</tr>
			       </table>
				   </div>
				   <div class="tab-pane" id="tab-breadcrumb">
				   		<div class="form-group">
								<label class="col-sm-2 control-label">Enable Breadcrumbs</label>
								<div class="col-sm-10">
									<select name="hb_snippets_bc_enable" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_bc_enable == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_bc_enable == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
						</div>
				   </div>
				    
				    <div class="tab-pane" id="tab-og">
				   		<p><i class="fa fa-info-circle"></i> The Open Graph protocol enables any web page to become a rich object in a social graph. For instance, this is used on Facebook to allow any web page to have the same functionality as any other object on Facebook.
While many different technologies and schemas exist and could be combined together, there isn't a single technology which provides enough information to richly represent any web page within the social graph. The Open Graph protocol builds on these existing technologies and gives developers one thing to implement.
<br> </p> <p><i class="fa fa-info-circle"></i> OpenGraph is automatically installed by this extension provided you have a working vqmod. To check OpenGraph <a href="http://opengraphcheck.com/" target="_blank">http://opengraphcheck.com/</a> .</p><br />
						<div class="form-group">
								<label class="col-sm-4 control-label">Enable OpenGraph Protocol</label>
								<div class="col-sm-8">
									<select name="hb_snippets_og_enable" class="form-control">
									  <option value="1" <?php echo ($hb_snippets_og_enable == '1')? 'selected':''; ?> ><?php echo $text_enable; ?></option>
									  <option value="0" <?php echo ($hb_snippets_og_enable == '0')? 'selected':''; ?> ><?php echo $text_disable; ?></option>
									 </select>
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-4 control-label">Product Title Pattern (SHORTCODES: {name}, {price}, {brand}, {model})</label>
								<div class="col-sm-8">
									<input name="hb_snippets_ogp" class="form-control" value="<?php echo $hb_snippets_ogp; ?>">
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-4 control-label">Category Title Pattern (SHORTCODES: {name})</label>
								<div class="col-sm-8">
									<input name="hb_snippets_ogc" class="form-control" value="<?php echo $hb_snippets_ogc; ?>">
								</div>
						</div>
				   </div>
				   
				   </div>
          </form>
    	
      </div>
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
  <span class="help">SEO STRUCTURED DATA (EV <?php echo $extension_version; ?>) &copy; <a href="http://www.huntbee.com/">WWW.HUNTBEE.COM</a> | <a href="http://www.huntbee.com/product-support">SUPPORT</a> | <a href="http://www.huntbee.com/website-structured-data-installation?utm_source=extension&utm_medium=structured_data_extension&utm_campaign=Advance%20Microdata">ADVANCE CUSTOMIZATION</a></span></center>
</div><!--Huntbee copyrights end-->
</div>
<script type="text/javascript">
function generatelocalsnippet(){
$('#loadgif2').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_snippets/generatelocalsnippet&token=<?php echo $token; ?>',
		  data: {name: $('#hb_snippets_local_name').val(), street: $('#hb_snippets_local_st').val(), location: $('#hb_snippets_local_location').val(), postal:$('#hb_snippets_local_postal').val(),
		   state:$('#hb_snippets_local_state').val(), country:$('#hb_snippets_local_country').val(), store_image:$('#hb_snippets_store_image').val(), price_range:$('#hb_snippets_price_range').val() },
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
						var ss = json['success'];
					  	$('#hb_snippets_local_snippet').val(ss);
					   $('#loadgif2').hide();
				}
		  },			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	 });
}
function generate_kg(){
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_snippets/generatekg&token=<?php echo $token; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
						var ss = json['success'];
					  	$('#hb_snippets_kg_data').val(ss);
				}
		  },			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	 });
}
</script>
<script type="text/javascript">
var contact_row = <?php echo $contact_row; ?>;
function addcontact(){
html  = '<div class="form-group"  id="contact-row' + contact_row + '"><div class="col-sm-2"></div>';
html += '<div class="col-sm-4"><input type="text" placeholder="+1-401-555-1212" name="hb_snippets_contact[' + contact_row + '][n]" class="form-control"></div>';
html += '<div class="col-sm-4"><select name="hb_snippets_contact[' + contact_row + '][t]" class="form-control">';
html += '<option>Customer Service</option>';
html += '<option>Customer Support</option>';
html += '<option>Technical Support</option>';
html += '<option>Billing Support</option>';
html += '<option>Bill Payment</option>';
html += '<option>Sales</option>';
html += '<option>Reservations</option>';
html += '<option>Credit Card Support</option>';
html += '<option>Emergency</option>';
html += '<option>Baggage Tracking</option>';
html += '<option>Roadside Assistance</option>';
html += '<option>Package Tracking</option>';
html += '</select></div>';
html += '<div class="col-sm-2"><button type="button" onclick="$(\'#contact-row' + contact_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></div>';
html += '</div>';
$('#corp_contact').append(html);
contact_row++;
}

var social_row = <?php echo $social_row; ?>;
function addsocial(){
html  = '<div class="form-group" id="social-row' + social_row + '"><div class="col-sm-2"></div>';
html += '<div class="col-sm-8"><input type="text" placeholder="https://www.facebook.com/your-profile" name="hb_snippets_socials[' + social_row + ']" class="form-control"></div>';
html += '<div class="col-sm-2"><button type="button" onclick="$(\'#social-row' + social_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></div>';
html += '</div>';
$('#corp_social').append(html);
social_row++;
}
</script>
<?php echo $footer; ?>