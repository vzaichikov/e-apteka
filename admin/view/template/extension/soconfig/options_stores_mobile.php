<?php 
/******************************************************
 * @package	SO Theme Framework for Opencart 2.0.x
 * @author	http://www.magentech.com
 * @license	GNU General Public License 
 * @copyright(C) 2008-2015 Magentech.com. All rights reserved.
*******************************************************/
global $config_mobile;
$config_mobile = $module;
require('field_mobile.tpl');
?>

<div class="sidebar">
	<ul class="nav nav-tabs main_tabs_vertical">
		<li class="active"><a href="#tab-general<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $objlang->get('maintabs_general'); ?></a></li>
		<li><a href="#tab-barbottom<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $objlang->get('maintabs_barbottom'); ?></a></li>
		<li><a href="#tab-barleft<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $objlang->get('maintabs_barleft'); ?></a></li>
		<li><a href="#tab-products<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $objlang->get('maintabs_products') ; ?></a></li>
		<li><a href="#tab-fonts<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $objlang->get('maintabs_fonts'); ?></a></li>
		<li><a href="#tab-advanced<?php echo $store['store_id']; ?>" data-toggle="tab"> <?php echo $objlang->get('maintabs_advanced'); ?></a></li>
	</ul>
</div>

<div class="tab-content main_content_vertical col-sm-10">
   
    <!-------------------------------------Tab General---------------------------------->
    <div class="tab-pane active" id="tab-general<?php echo $store['store_id']; ?>">
        <ul class="nav nav-tabs  main_tabs_2 ">
            <li class="active"><a href="#tab-general-layout1" class="selected" data-toggle="tab"><?php echo $objlang->get('general_tab_general') ?></a></li>
			<li><a href="#tab-general-layout2" data-toggle="tab"><?php echo $objlang->get('general_tab_header'); ?></a></li>
			<li><a href="#tab-general-layout3" data-toggle="tab"><?php echo $objlang->get('general_tab_footer'); ?></a></li>
			
			
        </ul>

        <div class="tab-content ">
			<?php // General  Blocks--------------------------------------------- ?>
            <div class="tab-pane active" id="tab-general-layout1">
				<div class="so-panel">
					<h3 class="panel-title"><?php echo $objlang->get('themecolor_heading') ?></h3>
					<div class="panel-container">
						<div id="tab-general__layouttype" class="form-group">
							
							<div class="col-sm-2" style="padding:0;">
								<label class="col-sm-12 control-label" >Layout Type</label>
								<div class="clearfix" style="margin:30px 0; display: inline-block;">
									<p class="help-hint-text">
										<i class="fa fa-bullhorn" aria-hidden="true"></i> 
										<span>Create New Color</span>
									</p>
									<p class="help-block"><strong>Step 1:</strong> Fill color and color code -> Click button Compile CSS -> Create a new Color.</p>
									<p class="help-block"><strong>Step 2:</strong>  Select the color you just created -> Click button Save. </p>
									
								</div>
							</div>
							<div class="col-sm-10 text-center grouplayout">
								<?php echo field_typelayout('mobilelayout',$typelayout,'6'); ?>
							</div>
						</div>
						<div class="form-group" >
							<label class="col-sm-2 control-label" ><?php echo $objlang->get('general_createcolor') ?></label>
							<div class="col-sm-2">
								<?php echo field_text('nameColor','Name Color'); ?>
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<i class="input-group-addon fa fa-paint-brush" aria-hidden="true"></i>
									<input class="form-control text-capital" id="soconfig_colors_theme" style="background-color:<?php echo $config_mobile['colorHex'] ?>;color:white" type="text" name="mobile_general[colorHex]" value="<?php echo $config_mobile['colorHex'] ?>" placeholder="Select color:" />
								</div>
							</div>
							<div class="col-sm-5">
								<button onclick="buttonApplyColor();" class="btn btn-primary" type="button" ><i class="fa fa-compress" aria-hidden="true"></i> Compile CSS</button>
							</div>
							<div class="col-sm-offset-2 col-sm-10">
								<div class="text-warning" style="margin-top:20px;">
								<p><i class="fa fa-exclamation-triangle" style="font-size:18px;"></i> Compile css not working then: </p>
								1.Tab Advanced → SCSS Compile = On .</br>
								2.Tab Advanced → User Developer Compile Muti Color = On .
								</div>
								
							</div>
						</div>
						
						
						<div id="tab-general__themecolor" class="form-group">
							<label class="col-sm-2 control-label" ><?php echo $objlang->get('general_stylecolor') ?></label>
						
							<div class="col-sm-2">
								<?php if(!empty($allThemeColor) || !isset($allThemeColor)): ?>
									<select name="mobile_general[listcolor]" class="form-control text-capital" id="select_color">
										<?php 
											foreach ($allThemeColor as $fv => $fc) { 
												($fc == $config_mobile['listcolor'] ) ? $current = 'selected' : $current=''; ?>
												<option value="<?php echo $fc; ?>" <?php echo $current; ?> ><?php echo $fc; ?></option>	
										<?php 
											}
										?>
									</select>
								<?php endif;?>
							</div>
						</div>
						
					</div>
                </div>
				<div class="so-panel">
					<h3 class="panel-title"><?php echo $objlang->get('platforms_heading') ?></h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-2 control-label" ><?php echo $objlang->get('general_mobile_status') ?></label>
							<div class="col-sm-10">
								<?php echo field_onOff('platforms_mobile'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" ><?php echo $objlang->get('general_logo_mobile') ?></label>
							<div class="col-sm-10">
								<a href="" id="thumb-logomobile" data-toggle="image" class="img-thumbnail">
									<img src="<?php echo $imgmobile ?>"  data-placeholder="Background Image:" />
								</a>
								<input type="hidden" name="mobile_general[logomobile]" value="<?php echo $config_mobile['logomobile']?>" id="input-logomobile" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" ><?php echo $objlang->get('general_topbar_status') ?></label>
							<div class="col-sm-10">
								<?php echo field_onOff('barnav'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label"> <?php echo $objlang->get('general_copyright_text') ?> </label>
							<div class="col-sm-5">
								<?php echo field_text('copyright','Footer copyright content'); ?>
							</div>
						</div>
					</div>
                </div>
				
			
            </div>
           
			<?php // Header  Blocks--------------------------------------------- ?>
            <div id="tab-general-layout2" class="tab-pane">
				<div class="so-panel">
					<h3 class="panel-title"><?php echo $objlang->get('typeheader_heading') ?> </h3>
					<span class="help-block"><?php echo $objlang->get('typeheader_dec') ?></span>
					<p class="help-hint">
						<i class="fa fa-bullhorn" aria-hidden="true"></i> 
						<span><?php echo $objlang->get('typeheader_text') ?></span>
					</p>
					<div class=" groupheader">
					<?php echo field_typeheader('mobileheader',$typelayout); ?>
					</div>
				</div>
				
            </div>
			<?php // Footer  Blocks--------------------------------------------- ?>
            <div id="tab-general-layout3" class="tab-pane">
				<div class="so-panel">
					<h3 class="panel-title">Other Footer </h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Payment Image</label>
							<div class="col-sm-10">
								<a href="" id="thumb-payment" data-toggle="image" class="img-thumbnail">
									<img src="<?php echo $imgpayment ?>"  data-placeholder="Background Image:" />
								</a>
								<input type="hidden" name="mobile_general[imgpayment]" value="<?php echo $config_mobile['imgpayment']?>" id="input-payment" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Telephone No</label>
							<div class="col-sm-2" id="soconfig_general_store_headerspy_container">
								<?php echo field_onOff('phone_status'); ?>
							</div>
							<div class="col-sm-4" >
								<?php echo field_text('phone_text'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Email Us</label>
							<div class="col-sm-2" id="soconfig_general_store_headerspy_container">
								<?php echo field_onOff('email_status'); ?>
							</div>
							<div class="col-sm-4" >
								<?php echo field_text('email_text'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Custom Footer </label>
							<div class="col-sm-2" id="soconfig_general_store_headerspy_container">
								<?php echo field_onOff('customfooter_status'); ?>
							</div>
							<div class="col-sm-8">
								<?php echo field_textarea('customfooter_text');?>
							</div>
						</div>
						
						
					</div>
				</div>
				<div class="so-panel">
					<div class="form-group no-margin" >
						<h3 class="col-sm-3 panel-title ">Add Link Menu For Footer</h3>
					</div>
					
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Show Menu Footer</label>
							<div class="col-sm-10">
								<?php echo field_onOff('menufooter_status'); ?>
							</div>
						</div>
						
						<!-- Menu More -->
						<div id="tab_payment" class="form-group">
							<table class="bottom-bar" id="listgroup-footer">
								<thead>
									<tr>
										<td class="first" style="width: 20%;" >Name</td>
										<td>Link</td>
										<td style="width: 10%;">Sort</td>
										<td style="width: 10%;">Delete</td>
									</tr>
								</thead>
								<?php 
									$menu_row = 0; 
									if(isset($footermenus) && $footermenus != '') {
									foreach($footermenus as $menuitem) { 
										if(!empty($menuitem['name'])){
									?>
									<tbody id="list<?php echo $menu_row; ?>">
										<tr>
											<td class="first">
												<div class="payment-name">
													<input class="form-control" type="text" value="<?php if(isset($menuitem['name'])) { echo $menuitem['name']; } ?>" name="mobile_general[footermenus][<?php echo $menu_row; ?>][name]">
												</div>
											</td>
											<td>
												<input class="form-control" type="text" value="<?php if(isset($menuitem['link'])) { echo $menuitem['link']; } ?>" name="mobile_general[footermenus][<?php echo $menu_row; ?>][link]">
											</td>
											<td >
												<input class="form-control" type="text" class="sort" value="<?php if(isset($menuitem['sort'])) { echo $menuitem['sort']; } ?>" name="mobile_general[footermenus][<?php echo $menu_row; ?>][sort]">
											</td>
											
											<td>
												<a onclick="$('#list<?php echo $menu_row; ?>').remove();" class="btn btn-danger">Remove</a>
											</td>
										</tr>
									</tbody>
									<?php $menu_row++; 
										}
									} 
								}
								?>
								<tfoot></tfoot>
							</table>
							
							<a onclick="add_footermenu();" class="add-item-payment btn btn-primary">Add item</a>
							<script type="text/javascript">
							var menu_row = <?php echo $menu_row; ?>;
							function add_footermenu() {
								html  = '<tbody id="list' + menu_row + '">';
								html += '  <tr>';
								html += '    <td class="first">';
								html += '		<div class="payment_name"><input class="form-control" type="text" name="mobile_general[footermenus][' + menu_row + '][name]"></div>';
								html += '    </td>';
								html += '    <td>';
								html += '		<input class="form-control" type="text" name="mobile_general[footermenus][' + menu_row + '][link]">';
								html += '    </td>';
								html += '    <td>';
								html += '		<input class="form-control" type="text" class="sort" name="mobile_general[footermenus][' + menu_row + '][sort]">';
								html += '    </td>';
								html += '    <td><a onclick="$(\'#list' + menu_row + '\').remove();" class="btn btn-danger">Remove</a></td>';
								html += '  </tr>';
								html += '</tbody>';
								
								$('#listgroup-footer tfoot').before(html);
								menu_row++;
							}
							</script> 
						</div>
						<!--  END Menu More -->
					
						
					</div>
				</div>
            </div>
			
			

        </div>
    </div>
	<!-------------------------------------end tab General---------------------------------->
	
	<!-------------------------------------Tab Bar Bottom ---------------------------------->
	<div id="tab-barbottom<?php echo $store['store_id']; ?>" class="tab-pane">
		<div class="so-panel">
			<div class="form-group no-margin" >
				<h3 class="col-sm-2 panel-title "><?php echo $objlang->get('barmore_heading') ?></h3>
			</div>
			
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-2 control-label" ><?php echo $objlang->get('barmore_status') ?></label>
					<div class="col-sm-6">
						<?php echo field_onOff('barmore_status'); ?>
					</div>
					<div class="col-sm-4 text-right">
						<img src="../admin/view/options/menumore.png" alt="" />
					</div>
				</div>
				
				<!-- Menu More -->
				<div id="tab_payment" class="form-group">
					<table class="bottom-bar" id="listgroup">
						<thead>
							<tr>
								<td class="first" style="width: 20%;" >Name</td>
								<td>Link</td>
								<td style="width: 10%;">Sort</td>
								<td style="width: 10%;">Delete</td>
							</tr>
						</thead>
						<?php 
							$module_row = 0; 
							if(isset($listmenus) && $listmenus != '') {
							foreach($listmenus as $menuitem) { 
								if(!empty($menuitem['name'])){
							?>
							<tbody id="list<?php echo $module_row; ?>">
								<tr>
									<td class="first">
										<div class="payment-name">
											<input class="form-control" type="text" value="<?php if(isset($menuitem['name'])) { echo $menuitem['name']; } ?>" name="mobile_general[listmenus][<?php echo $module_row; ?>][name]">
										</div>
									</td>
									<td>
										<input class="form-control" type="text" value="<?php if(isset($menuitem['link'])) { echo $menuitem['link']; } ?>" name="mobile_general[listmenus][<?php echo $module_row; ?>][link]">
									</td>
									<td >
										<input class="form-control" type="text" class="sort" value="<?php if(isset($menuitem['sort'])) { echo $menuitem['sort']; } ?>" name="mobile_general[listmenus][<?php echo $module_row; ?>][sort]">
									</td>
									
									<td>
										<a onclick="$('#list<?php echo $module_row; ?>').remove();" class="btn btn-danger">Remove</a>
									</td>
								</tr>
							</tbody>
							<?php $module_row++; 
								}
							} 
						}
						?>
						<tfoot></tfoot>
					</table>
					
					<a onclick="addPayment();" class="add-item-payment btn btn-primary">Add item</a>
					<script type="text/javascript">
					var module_row = <?php echo $module_row; ?>;
					function addPayment() {
						html  = '<tbody id="list' + module_row + '">';
						html += '  <tr>';
						html += '    <td class="first">';
						html += '		<div class="payment_name"><input class="form-control" type="text" name="mobile_general[listmenus][' + module_row + '][name]"></div>';
						html += '    </td>';
						html += '    <td>';
						html += '		<input class="form-control" type="text" name="mobile_general[listmenus][' + module_row + '][link]">';
						html += '    </td>';
						html += '    <td>';
						html += '		<input class="form-control" type="text" class="sort" name="mobile_general[listmenus][' + module_row + '][sort]">';
						html += '    </td>';
						html += '    <td><a onclick="$(\'#list' + module_row + '\').remove();" class="btn btn-danger">Remove</a></td>';
						html += '  </tr>';
						html += '</tbody>';
						
						$('#listgroup tfoot').before(html);
						
						module_row++;
					}
					</script> 
				</div>
				<!--  END Menu More -->
			
				
			</div>
		</div>
		
	</div>
	<!-------------------------------------end Tab Bar Bottom ---------------------------------->
	
	<!-------------------------------------Tab Bar Left ---------------------------------->
	<div id="tab-barleft<?php echo $store['store_id']; ?>" class="tab-pane">
		<div class="so-panel">
			<div class="form-group no-margin" >
				<h3 class="col-sm-2 panel-title "><?php echo $objlang->get('barleft_heading') ?></h3>
				<div class="col-sm-10 text-right">
					<img src="../admin/view/options/navbar.png" alt="" />
				</div>
			</div>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-2 control-label" ><?php echo $objlang->get('barsearch_status') ?></label>
					<div class="col-sm-6">
						<?php echo field_onOff('barsearch_status'); ?>
					</div>
					
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" ><?php echo $objlang->get('barwistlist_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_onOff('barwistlist_status'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" ><?php echo $objlang->get('barcompare_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_onOff('barcompare_status'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" ><?php echo $objlang->get('barcurenty_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_onOff('barcurenty_status'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" ><?php echo $objlang->get('barlanguage_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_onOff('barlanguage_status'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-------------------------------------Tab Products sliders, products listings-->
	<div class="tab-pane" id="tab-products<?php echo $store['store_id']; ?>">
		<div class="so-panel">
			<h3 class="panel-title"><?php echo $objlang->get('category_heading') ?></h3>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $objlang->get('general_morecategory_status') ?> </label>
					<div class="col-sm-10">
						<?php echo field_onOff('category_more'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $objlang->get('general_compare_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_onOff('compare_status'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $objlang->get('general_wishlist_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_onOff('wishlist_status'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $objlang->get('general_addcart_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_onOff('addcart_status'); ?>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
	<!-------------------------------------end products listings---------------------------->
	 <!-------------------------------------Tab Fonts-->
    <div class="tab-pane" id="tab-fonts<?php echo $store['store_id']; ?>">
		<div class="so-panel">
			<h3 class="panel-title"><?php echo $objlang->get('fonts_heading') ?> <span class="help-block">If you want to speed up your site use one of the common fonts instead of the fonts from Google.</span></h3>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-3 control-label" >Body Font Setting</label>
					<div class="col-sm-9">
						<div class="block-group fonts-change">
							<?php echo field_onOffFont('body_status'); ?>
							<div class="block-group items-font font-standard" >
								<?php echo field_select('normal_body',$fonts_normal); ?>
							</div>
							<div class="block-group items-font font-google" >
								<label class="control-label">    Google URL :    </label>
								<div class="">
									<?php echo field_text('url_body'); ?>
									<span class="help-block">Example: http://fonts.googleapis.com/css?family=Roboto:400,500,700 <a href="https://www.google.com/fonts">⇒ View More</a></span>
								</div>
							</div>
							<div class="block-group items-font font-google" >
								<label class=" control-label"> Google Family :</label>
								<div class="">
									<?php echo field_text('family_body'); ?>
									<span class="help-block"> Example: Roboto, sans-serif;</span>
								</div>
							</div>
						</div>
						<div class="block-group">
							<?php echo field_textarea('selector_body','Add css selectors'); ?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Heading Setting </label>
					<div class="col-sm-9">
						<div class="block-group fonts-change">
							<?php echo field_onOffFont('heading_status'); ?>
							<div class="block-group items-font font-standard" >
								<?php echo field_select('normal_heading',$fonts_normal); ?>
							</div>
							<div class="block-group items-font font-google" >
								<label class="control-label">    Google URL :    </label>
								<div class="">
									<?php echo field_text('url_heading'); ?>
									<span class="help-block">Example: http://fonts.googleapis.com/css?family=Roboto:400,500,700 <a href="https://www.google.com/fonts">⇒ View More</a></span>
								</div>
							</div>
							<div class="block-group items-font font-google" >
								<label class=" control-label"> Google Family :</label>
								<div class="">
									<?php echo field_text('family_heading'); ?>
									<span class="help-block"> Example: Roboto, sans-serif;</span>
								</div>
							</div>
						</div>
						<div class="block-group">
							<?php echo field_textarea('selector_heading','Add css selectors'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>				
    </div>
    <!-------------------------------------end tab Fonts-->
	
	<!-------------------------------------Tab Tab Advanced-->
	<div class="tab-pane" id="tab-advanced<?php echo $store['store_id']; ?>">
		<div class="so-panel">
			<h3 class="panel-title"><?php echo $objlang->get('compile_heading') ?></h3>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-2 control-label" > <?php echo $objlang->get('compile_status') ?></label>
					<div class="col-sm-2">
						<?php echo field_onOff('scsscompile'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" > <?php echo $objlang->get('cssformat_status') ?></label>
					<div class="col-sm-10">
						<?php echo field_select('scssformat',$Scssformat,'width30'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" ><?php echo $objlang->get('muticolor_status') ?> </label>
					<div class="col-sm-2">
						<?php echo field_onOff('compilemuticolor'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-------------------------------------End Tab Advanced-->
	
</div>
