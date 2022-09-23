<?php 
/******************************************************
 * @package	SO Theme Framework for Opencart 2.0.x
 * @author	http://www.magentech.com
 * @license	GNU General Public License
 * @copyright(C) 2008-2015 Magentech.com. All rights reserved.
*******************************************************/
require('options_field.php');
$scsscompile 	= isset($soconfig_advanced_store[$store['store_id']]['scsscompile']) ? $soconfig_advanced_store[$store['store_id']]['scsscompile'] : '' ;
$compileMutiColor 	= isset($soconfig_advanced_store[$store['store_id']]['compileMutiColor']) ? $soconfig_advanced_store[$store['store_id']]['compileMutiColor'] : '' ;
$colorNameHex 	= isset($soconfig_advanced_store[$store["store_id"]]['theme_color']) ? $soconfig_advanced_store[$store["store_id"]]['theme_color'] : '';
$currentcolor   = isset($soconfig_general_store[$store["store_id"]]['themecolor']) ? $soconfig_general_store[$store["store_id"]]['themecolor'] : '' ;
$imgpreloader_store	= isset($soconfig_general_store[$store["store_id"]]['imgpreloader']) ? $soconfig_general_store[$store["store_id"]]['imgpreloader']: '';
$imgpayment_store	= isset($soconfig_general_store[$store["store_id"]]['imgpayment']) ? $soconfig_general_store[$store["store_id"]]['imgpayment']: '';
$pattern_store		= isset($soconfig_layout_store[$store["store_id"]]["pattern"]) ? $soconfig_layout_store[$store["store_id"]]["pattern"]: '';


$theme_color =  isset($colorNameHex) && !empty($colorNameHex) ? $colorNameHex : '#3b5998'; 
?>
<div class="sidebar">
<h3 class="title"> <?php echo $theme;?> </h3>
<ul class="nav nav-tabs main_tabs_vertical">
    <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $maintabs_general; ?></a></li>
    <li><a href="#tab-layout" data-toggle="tab"><?php echo $maintabs_layout; ?></a></li>
    <li><a href="#tab-products" data-toggle="tab"><?php echo $maintabs_products; ?></a></li>
    <li><a href="#tab-fonts" data-toggle="tab"><?php echo $maintabs_fonts; ?></a></li>
    <li><a href="#tab-slide" data-toggle="tab"><?php echo $maintabs_social; ?></a></li>
	<li><a href="#tab-custom" data-toggle="tab"><?php echo $maintabs_custom; ?></a></li>
  
	<li><a href="#tab-advanced" data-toggle="tab"><i class="fa fa-wrench"></i> Advanced</a></li>
	
	<li><a href="#tab-sampledata" data-toggle="tab"><?php echo $maintabs_sampledata; ?></a></li>
	
</ul>
</div>
<div class="tab-content main_content_vertical col-sm-10">
    <!-------------------------------------Tab General---------------------------------->
    <div class="tab-pane active" id="tab-general">
        <ul class="nav nav-tabs  main_tabs_2 ">
            <li class="active"><a href="#tab-general-layout1-<?php echo $store['store_id']; ?>" class="selected" data-toggle="tab"><?php echo $general_tab_general; ?></a></li>
            <li><a href="#tab-general-layout2-<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $general_tab_header; ?></a></li>
            <li><a href="#tab-general-layout3-<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $general_tab_footer; ?> </a></li>
			<li><a href="#tab-general-layout4-<?php echo $store['store_id']; ?>" data-toggle="tab">Banner Effect</a></li>
        </ul>

        <div class="tab-content ">
			<?php // General  Blocks--------------------------------------------- ?>
            <div class="tab-pane active" id="tab-general-layout1-<?php echo $store['store_id']; ?>">
				
				<div class="so-panel">
					<h3 class="panel-title">Themes Color</h3>
					<div class="panel-container">
						<div id="tab-general__layouttype-<?php echo $store['store_id']; ?>" class="form-group">
							
							<div class="col-sm-2" style="padding:0;">
								<label class="col-sm-12 control-label" >Layout Type</label>
								<div class="clearfix" style="margin:30px 0; display: inline-block;">
									<p class="help-hint-text">
										<i class="fa fa-bullhorn" aria-hidden="true"></i> 
										<span>Create New Color</span>
									</p>
									<p class="help-block"><strong>Step 1:</strong> Select the layout you want to display.<p>
									<p class="help-block"><strong>Step 2:</strong> Fill color and color code -> Click button Compile CSS -> Create a new Color.</p>
									<p class="help-block"><strong>Step 3:</strong>  Select the color you just created -> Click button Save. </p>
									
								</div>
							</div>
							<div class="col-sm-10">
								<?php echo field_typelayout('soconfig_general_store',$soconfig_general_store,'typelayout',$typelayouts); ?>
							</div>
						</div>
						
						
						<div class="form-group" >
							<label class="col-sm-2 control-label" >Create Color</label>
							<div class="col-sm-2">
								<?php echo field_text('soconfig_advanced_store',$soconfig_advanced_store,'name_color','Name Color'); ?>
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<i class="input-group-addon fa fa-paint-brush" aria-hidden="true"></i>
									<input class="form-control text-capital" id="soconfig_colors_theme<?php echo $store["store_id"]; ?>" style="background-color:<?php echo $theme_color ?>;color:white" type="text" name="soconfig_advanced_store[<?php echo $store["store_id"]?>][theme_color]" value="<?php echo $theme_color ?>" placeholder="Select color:" />
								</div>
							</div>
							<div class="col-sm-5">
								<button onclick="buttonApplyColor();" class="btn btn-primary" type="button" <?php  if( $scsscompile ) echo "disabled='disabled'" ?>><i class="fa fa-compress" aria-hidden="true"></i> Compile CSS</button>
							</div>
							<div class="col-sm-offset-2 col-sm-10">
								<?php  if($scsscompile || $compileMutiColor ): ?>
								<div class="text-warning" style="margin-top:20px;">
								<p><i class="fa fa-exclamation-triangle" style="font-size:18px;"></i> Compile css not working then: </p>
								1.Tab Advanced → SCSS Compile = On .</br>
								2.Tab Advanced → User Developer Compile Muti Color = On .
								</div>
								<?php endif; ?>
							</div>
							
						</div>
						
						
						
						<div id="tab-general__themecolor-<?php echo $store['store_id']; ?>" class="form-group">
							<label class="col-sm-2 control-label" >Select Color</label>
							<div class="col-sm-2">
								
								<select name="soconfig_general_store[<?php echo $store["store_id"] ?>][themecolor]" class="form-control text-capital" id="select_color_<?php echo $store["store_id"] ?>">
									<?php foreach ($allThemeColor[$store["store_id"]] as $fv => $fc) {?>
										<?php ($fc == $currentcolor ) ? $current = 'selected' : $current=''; ?>
										<option value="<?php echo $fc; ?>" <?php echo $current; ?> ><?php echo $fc; ?></option>	
									<?php } ?>
								</select>
								
							</div>
						</div>
					</div>
                </div>
				
				<div class="so-panel">
					<h3 class="panel-title">General</h3>
					<div class="panel-container">
						
						<div class="form-group">
							<label class="col-sm-2 control-label" ><?php echo $general_res_layout; ?> </label>
							<div class="col-sm-10">
								<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'layouts'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" ><?php echo $general_back_top; ?> </label>
							<div class="col-sm-10">
								<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'backtop'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="Lazy Load is delays loading of images in long web pages">Lazy Loader</span>
							</label>
							<div class="col-sm-10">
								<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'scroll_animation'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">  <?php echo $general_copyright; ?>  </label>
							<div class="col-sm-4">
								<?php echo field_text('soconfig_general_store',$soconfig_general_store,'copyright','Footer copyright content'); ?>
							</div>
						</div>
						
					</div>
                </div>
				
            </div>
           

			<?php // Header  Blocks--------------------------------------------- ?>
            <div id="tab-general-layout2-<?php echo $store['store_id']; ?>" class="tab-pane">
				<div class="clearfix so-panelType">
					<div class="tabs_vertical_headertype  col-sm-2">
					<ul class="nav nav-tabs ">
						<li class="active"><a href="#tab-general__headertype-<?php echo $store['store_id']; ?>" data-toggle="tab" aria-expanded="false">Header Type</a></li>
						<li class=""><a href="#tab-general__headerother-<?php echo $store['store_id']; ?>" data-toggle="tab" aria-expanded="true">Top Panel</a></li>
					</ul>
					</div>
					<div class="tab-content col-sm-10">
						<div id="tab-general__headertype-<?php echo $store['store_id']; ?>" class="tab-pane active">
							<div class="so-panel">
								<h3 class="panel-title">Type of Header</h3>
								<span class="help-block">If you need content from other header like phone number you need to set it in custom Theme Control Panel.</span>
								<p class="help-hint">
									<i class="fa fa-bullhorn" aria-hidden="true"></i> 
									<span>You can set these headers for any skin you want</span>
								</p>
								<?php echo field_typeheader('soconfig_general_store',$soconfig_general_store,'typeheader',$typelayouts); ?>
							</div>
							
						</div>
						<div id="tab-general__headerother-<?php echo $store['store_id']; ?>" class="tab-pane">
							<div class="so-panel">
								<h3 class="panel-title">Top Panel</h3>
								<div class="panel-container">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="logo_position<?php echo $store["store_id"]; ?>">
											Status:
										</label>
										<div class="col-sm-10">
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'toppanel_status'); ?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" >
											Type:
										</label>
										<div class="col-sm-10">
											<?php echo field_select('soconfig_general_store',$soconfig_general_store,'toppanel_type',$toppanel_type,'width30'); ?>
										</div>
									</div>
									
									
								</div>
							</div>
						
							<div class="so-panel">	
								<h3 class="panel-title">Top Bar</h3>
								<div class="panel-container">
									<div class="form-group">
										<label class="col-sm-2 control-label">Telephone No</label>
										<div class="col-sm-2" id="soconfig_general_store_headerspy_container">
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'phone_status'); ?>
										</div>
										<div class="col-sm-8" >
											<?php echo field_langHori($languages,$storeid ,'soconfig_general_store',$soconfig_general_store,'contact_number',50);?>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Welcome Message</label>
										<div class="col-sm-2" >
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'welcome_message_status'); ?>
										</div>
										<div class="col-sm-8" >
											<?php echo field_langHori($languages,$storeid ,'soconfig_general_store',$soconfig_general_store,'welcome_message',50);?>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Wishlist Link</label>
										<div class="col-sm-3" >
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'wishlist_status'); ?>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Checkout Link</label>
										<div class="col-sm-3" >
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'checkout_status'); ?>
										</div>
									</div>
									
									<div class="form-group last">
										<label class="col-sm-2 control-label">Language/Currency Title</label>
										<div class="col-sm-3" >
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'lang_status'); ?>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				
				
				
            </div>

			
			<?php // Footer Blocks ----------------------------------------------- ?>
            <div id="tab-general-layout3-<?php echo $store['store_id']; ?>" class="tab-pane">
				<div class="clearfix so-panelType">
					<ul class="nav nav-tabs tabs_vertical_headertype  col-sm-2">
						<li class="active"><a href="#tab-general__footertype-<?php echo $store['store_id']; ?>" data-toggle="tab" aria-expanded="false">Footer Type</a></li>
						<li class=""><a href="#tab-general__footerother-<?php echo $store['store_id']; ?>" data-toggle="tab" aria-expanded="true">Other Footer</a></li>
					</ul>
					<div class="tab-content col-sm-10">
						<div id="tab-general__footertype-<?php echo $store['store_id']; ?>" class="tab-pane active">
							<div class="so-panel">
								<h3 class="panel-title">Type of Footer</h3>
								<span class="help-block">If you need content from other footer like contact us you need to set it in custom modules.</span>
								<p class="help-hint">
									<i class="fa fa-bullhorn" aria-hidden="true"></i> 
									<span>You can set these footer for any skin you want</span>
								</p>
								<?php echo field_typeheader('soconfig_general_store',$soconfig_general_store,'typefooter',$typelayouts); ?>
							</div>
							
						</div>
						
						<div id="tab-general__footerother-<?php echo $store['store_id']; ?>" class="tab-pane">
							<div class="so-panel">
								<h3 class="panel-title">Preloading Screen</h3>
								<div class="panel-container">	
									<div class="form-group">
										<label class="col-sm-2 control-label" >Preloader </label>
										<div class="col-sm-10">
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'preloader'); ?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" >
											<span data-toggle="tooltip" title="Edit content here Footer Custom Block.">
												Image Preloader:
											</span>
										</label>
										<div class="col-sm-10">
											<a href="" id="thumb-preloader<?php echo $store['store_id']; ?>" data-toggle="image" class="img-thumbnail">
												<img src="<?php echo $imgpreloader[$store["store_id"]]; ?>"  data-placeholder="Background Image:" />
											</a>
											<input type="hidden" name="soconfig_general_store[<?php echo $store["store_id"]?>][imgpreloader]" value="<?php echo $soconfig_general_store[$store["store_id"]]['imgpreloader']; ?>" id="input-preloader<?php echo $store["store_id"]?>" />
										
										</div>
										
									</div>
								</div>
							</div>
							<div class="so-panel">
								<h3 class="panel-title">Payment Block</h3>
								<div class="panel-container">
									<div class="form-group">
										<label class="col-sm-2 control-label" > Status: </label>
										<div class="col-sm-10">
											<?php echo field_onOff('soconfig_general_store',$soconfig_general_store,'imgpayment_status'); ?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" >
											<span data-toggle="tooltip" title="Edit content here Footer Custom Block.">
												Image (Payment block):
											</span>
										</label>
										<div class="col-sm-10">
											<a href="" id="thumb-imgpayment<?php echo $store['store_id']; ?>" data-toggle="image" class="img-thumbnail">
												<img src="<?php echo $imgpayment[$store["store_id"]]; ?>"  data-placeholder="Background Image:" />
											</a>
											<input type="hidden" name="soconfig_general_store[<?php echo $store["store_id"]?>][imgpayment]" value="<?php echo $imgpayment_store; ?>" id="input-imgpayment<?php echo $store["store_id"]?>" />
										
										</div>
										
									</div>
									
								</div>
							</div>
							
							

						</div>
					</div>
				</div>
			
            </div>
            
			<?php // Effect Banner  Blocks--------------------------------------------- ?>
            <div id="tab-general-layout4-<?php echo $store['store_id']; ?>" class="tab-pane">
				<div class="clearfix">
					
						<div id="tab-general__bannereffect-<?php echo $store['store_id']; ?>" class="tab-pane">
							<div class="so-panel">
								<h3 class="panel-title">Hover over image below to see effect.</h3>
								<p class="help-hint">
									<i class="fa fa-bullhorn" aria-hidden="true"></i> 
									<span>Hover over image below to see effect.</span>
								</p>
								<?php echo field_typebanner('soconfig_general_store',$soconfig_general_store,'type_banner',$type_banner,3); ?>
							</div>
							
						</div>
						
					
				</div>
				
				
				
            </div>

        </div>
    </div>
    <!-------------------------------------end tab General---------------------------------->

    <!-------------------------------------Tab Layout---------------------------------------->
    <div class="tab-pane" id="tab-layout">
		<!--subtabs: General -->
		<div class="tab-pane active" id="tab-colors-layout1-<?php echo $store['store_id']; ?>">
			<div class="so-panel">
				<h3 class="panel-title">Theme Layout Settings</h3>
				<div class="panel-container">
					<div class="form-group">
						<label class="col-sm-3 control-label" >
							<span data-toggle="tooltip" title="With the boxed layout you can choose additional options such as custom background images, patterns and solid colors">Layout Style</span>
						</label>
						<div class="col-sm-9">
							<div class="btn-group btn-toggle block-group " data-toggle="buttons">
								<?php echo field_select('soconfig_layout_store',$soconfig_layout_store,'layoutstyle',$layoutStyle); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" ">
							 <span data-toggle="tooltip" title="Set background color for all content.">Body Background Color:</span>
						</label>
						<div class="col-sm-9">
							<?php $general_bgcolor = isset($soconfig_layout_store[$store["store_id"]]['general_bgcolor']) ? $soconfig_layout_store[$store["store_id"]]['general_bgcolor'] : '';?>
							<input class="form-control width30" id="soconfig_colors_bgcolor<?php echo $store["store_id"]; ?>" style="background-color:<?php echo $general_bgcolor ?>;color:white" type="text" name="soconfig_layout_store[<?php echo $store["store_id"]; ?>][general_bgcolor]" value="<?php echo $general_bgcolor?>" placeholder="Background color:" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" >Overlay pattern</label>
						<div class="col-sm-9">
							<?php for ($i = 1; $i <= 45; $i++) { ?>
								<div class="img-patt"><small><?php echo $i; ?></small><img src="../catalog/view/theme/<?php echo $theme;?>/images/patterns/<?php echo $i; ?>.png" alt="pattern <?php echo $i; ?>"></div>
							<?php } ?>
						  
							<select class="form-control width30" name="soconfig_layout_store[<?php echo $store["store_id"]; ?>][pattern]" >
								<option value="none"selected="selected">None</option>
								<?php 
									
								if(!empty($pattern_store)):
									for ($pattern_id = 1; $pattern_id <= 45; $pattern_id++) {($soconfig_layout_store[$store["store_id"]]["pattern"]== $pattern_id) ? $currentpat = 'selected' : $currentpat = '';
										?>
										<option value="<?php echo $pattern_id; ?>" <?php echo $currentpat; ?>><?php echo $pattern_id; ?></option>
										<?php
									}
								endif; ?>
							</select>
							<small class="help-block">Select a pattern number if you want to use one.</small>
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<span data-toggle="tooltip" title="Set background image for all site.">Background Image:</span>
						</label>
						<div class="col-sm-9">
							<a href="" id="thumb-contentbg<?php echo $store['store_id']; ?>" data-toggle="image" class="img-thumbnail">
								<img src="<?php echo $contentbg[$store["store_id"]]?>"  data-placeholder="Background Image:" />
							</a>
							<input type="hidden" name="soconfig_general_store[<?php echo $store["store_id"]?>][contentbg]" value="<?php echo $soconfig_general_store[$store["store_id"]]['contentbg']; ?>" id="input-contentbg<?php echo $store['store_id']; ?>" />
						</div>
						
						
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" >
							 <span data-toggle="tooltip" title="Set background image display mode">
								 Background Image display mode
							 </span>
						</label>
						<div class="col-sm-9">
							<?php echo field_select('soconfig_layout_store',$soconfig_layout_store,'content_bg_mode',$content_bg_mode,'width30'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" >
							Background Image display Attachment
						</label>
						<div class="col-sm-9">
							<?php echo field_select('soconfig_layout_store',$soconfig_layout_store,'content_attachment',$content_attachment,'width30'); ?>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!--subtabs: General -->
    </div>
    <!-------------------------------------end tab Colors,backgrounds,fonts-->

    <!-------------------------------------Tab Products sliders, products listings-->
    <div class="tab-pane" id="tab-products">

        <ul class="nav nav-tabs  main_tabs_2">
            <li class="active"><a href="#tab-products-layout1-<?php echo $store['store_id']; ?>" class="selected" data-toggle="tab"><?php echo $pages_pro_listings; ?></a></li>
            <li><a href="#tab-products-layout2-<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $pages_pro_label; ?></a></li>
            <li><a href="#tab-products-layout3-<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $pages_pro_detail; ?></a></li>
        </ul>
        <div class="tab-content">
            <!--subtabs: Listings -->
            <div class="tab-pane active wrapper-tabcategory" id="tab-products-layout1-<?php echo $store['store_id']; ?>">
				
				<div class="so-panel">
					<h3 class="panel-title">Refine Search</h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-3 control-label" >
								<?php echo $product_catalog_refine ?>
							</label>
							<div class="col-sm-9">
								
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'product_catalog_refine',$refine_search,'width30'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-product_catalog_refine_col"><?php echo $product_catalog_refine_col ?></span></label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs" >
									<?php foreach ($devices as $subfix => $device) : ?>
									<li class="<?php echo ($subfix == 'lg' ? 'active' : ''); ?>"><a href="#language-catalog_refine_<?php echo $subfix ?><?php echo $store["store_id"]; ?>" data-toggle="tab"><?php echo $device ?></a></li>
									<?php endforeach; ?>
								</ul>
								<div class="tab-content">
									<?php foreach ($devices as $subfix => $device) : ?>
									<div class="tab-pane <?php echo ($subfix == 'lg' ? 'active' : ''); ?>" id="language-catalog_refine_<?php echo $subfix ?><?php echo $store["store_id"]; ?>">
										<select name="soconfig_pages_store[<?php echo $store["store_id"]; ?>][product_catalog_refine_col_<?php echo $subfix; ?>]" class="form-control width30">
										   <?php 
											if(isset($soconfig_pages_store)){
											foreach ($columns as $fv => $fc) { ?>
												<?php ($fv == $soconfig_pages_store[$store["store_id"]]["product_catalog_refine_col_".$subfix] ) ? $current = 'selected' : $current=''; ?>
												<option value="<?php echo $fv; ?>" <?php echo $current; ?> ><?php echo $fc; ?></option>	
											<?php }
											}
											?>
											
										</select>
									</div>
									<?php endforeach; ?>
									<span class="help-block"><?php echo $entry_catalog_column_help; ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="so-panel">
					<h3 class="panel-title">Category Page</h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-3 control-label">Display Todays Deals</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'deals_today'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo $product_catalog_image; ?></label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'lstimg_cate_status'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-product_catalog_mode">
								<span data-toggle="tooltip" title="Create your listings into simple catalog."><?php echo $product_catalog_mode ?></span>
							</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'product_catalog_mode',$catalog_mode,'width30'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-listing_quick_type"><?php echo $product_catalog_column ?></label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs" >
									<?php foreach ($devices as $subfix => $device) : ?>
									<li class="<?php echo ($subfix == 'lg' ? 'active' : ''); ?>"><a href="#language-product_catalog_<?php echo $subfix ?><?php echo $store["store_id"]; ?>" data-toggle="tab"><?php echo $device ?></a></li>
									<?php endforeach; ?>
								</ul>
								<div class="tab-content">
									<?php foreach ($devices as $subfix => $device) : ?>
									<div class="tab-pane <?php echo ($subfix == 'lg' ? 'active' : ''); ?>" id="language-product_catalog_<?php echo $subfix ?><?php echo $store["store_id"]; ?>">
										<select name="soconfig_pages_store[<?php echo $store["store_id"]; ?>][product_catalog_column_<?php echo $subfix; ?>]" class="form-control width30">
										   <?php foreach ($columns as $fv => $fc) { ?>
												<?php ($fv == $soconfig_pages_store[$store["store_id"]]["product_catalog_column_".$subfix] ) ? $current = 'selected' : $current=''; ?>
												<option value="<?php echo $fv; ?>" <?php echo $current; ?> ><?php echo $fc; ?></option>	
											<?php } ?>
										</select>
									</div>
									<?php endforeach; ?>
									<span class="help-block"><?php echo $entry_catalog_column_help; ?></span>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-listing_quick_type">Product grid number per row of special, search, manufacturer</label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs" >
									<?php foreach ($devices as $subfix => $device) : ?>
									<li class="<?php echo ($subfix == 'lg' ? 'active' : ''); ?>"><a href="#other_catalog_<?php echo $subfix ?><?php echo $store["store_id"]; ?>" data-toggle="tab"><?php echo $device ?></a></li>
									<?php endforeach; ?>
								</ul>
								<div class="tab-content">
									<?php foreach ($devices as $subfix => $device) : ?>
									<div class="tab-pane <?php echo ($subfix == 'lg' ? 'active' : ''); ?>" id="other_catalog_<?php echo $subfix ?><?php echo $store["store_id"]; ?>">
										<select name="soconfig_pages_store[<?php echo $store["store_id"]; ?>][other_catalog_column_<?php echo $subfix; ?>]" class="form-control width30">
										   <?php foreach ($columns as $fv => $fc) { ?>
												<?php ($fv == $soconfig_pages_store[$store["store_id"]]["other_catalog_column_".$subfix] ) ? $current = 'selected' : $current='4'; ?>
												<option value="<?php echo $fv; ?>" <?php echo $current; ?> ><?php echo $fc; ?></option>	
											<?php } ?>
										</select>
									</div>
									<?php endforeach; ?>
									<span class="help-block"><?php echo $entry_catalog_column_help; ?></span>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				
				<div class="so-panel">
					<h3 class="panel-title">Product Item</h3>
					<div class="panel-container">
						<div class="form-group">
						
							<label class="col-sm-3 control-label">Slide to 2nd image automatically</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'secondimg',$secondimg,'width30'); ?>
							</div>
						</div>
					   <div class="form-group">
							<label class="col-sm-3 control-label">Show rating</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'rating_status'); ?>
								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo $show_product_item_desc; ?></label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'lstdescription_status'); ?>
								<span class="help-block">Only for "Grid" view. This option performs</span>
							</div>
						</div>
					</div>
				</div>
				
			</div>

            <!--subtabs: labels -->
            <div id="tab-products-layout2-<?php echo $store['store_id']; ?>" class="tab-pane">
				<div class="so-panel">
					<h3 class="panel-title">Product labels</h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-3 control-label">Show "Sale" label:</label>
							<div class="col-sm-5">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'sale_status'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="sale_text1">Title for "Sale" label:</label>
							<div class="col-sm-5">
								<?php echo field_langHori($languages,$storeid ,'soconfig_pages_store',$soconfig_pages_store,'sale_text');?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Show "New" label:</label>
							<div class="col-sm-5">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'new_status'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="new_text1">Title for "New" label:</label>
							<div class="col-sm-5">
								<?php echo field_langHori($languages,$storeid ,'soconfig_pages_store',$soconfig_pages_store,'new_text');?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-days">
								<span data-toggle="tooltip" title="Number of days from the date "Date Available" to today date for a product.">
								Period of holding "New" label:
								</span>
							</label>
							<div class="col-sm-2">
								<?php echo field_text('soconfig_pages_store',$soconfig_pages_store,'days','Period of holding New label:'); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								<span data-toggle="tooltip" title="Set display or not 'QUICK VIEW' function on products in sliders.">Show "QUICK VIEW" function:</span>
							</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'quick_status'); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for="quick_view_text1">Title for "Quick view" label:</label>
							<div class="col-sm-6">
								<?php echo field_langHori($languages,$storeid ,'soconfig_pages_store',$soconfig_pages_store,'quick_view_text');?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								<span data-toggle="tooltip" title="Set display or not 'Discount' label.">Show "Discount" label:</span>
							</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'discount_status'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								<span data-toggle="tooltip" title="Set display or not countdown of Special Offer in product sliders.">Show countdown of Special Offer:</span>
							</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'countdown_status'); ?>
							</div>
						</div>
					</div>
				</div>
            </div>

            <!--subtabs: product page -->
            <div id="tab-products-layout3-<?php echo $store['store_id']; ?>" class="tab-pane">
                <div class="so-panel">
					<h3 class="panel-title">Options Styles</h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-thumbnails_position">Option Radio Style:</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'radio_style',$radio_style,'width30'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-thumbnails_position">Option Checkbox Style:</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'check_style',$radio_style,'width30'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="so-panel">
					<h3 class="panel-title">Product Page</h3>
					<div class="panel-container">
				
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-thumbnails_position">Position of block with thumbnails previews:</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'thumbnails_position',$thumbnailPos,'width30'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-cloudzoom_mode">
								<span data-toggle="tooltip" title="Choose position of cloudzoom image preview on product page.">Enable Product Zoom</span>
							</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'product_enablezoom'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-tabs_position">Product Zoom Mode</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'product_zoommode',$zoommode,'width30'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								<span data-toggle="tooltip" title="Lens Zoom Size is viewport size to move and enlarge the image. Please enter number style and not negative number">Lens Zoom Size</span>
							</label>
							<div class="col-sm-2">
								<?php echo field_text('soconfig_pages_store',$soconfig_pages_store,'product_zoomlenssize',''); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-tabs_position">Tabs block:</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'tabs_position',$tabs_position,'width30'); ?>
							</div>
						</div>
					</div>
				</div>	
				<div class="so-panel">
					<h3 class="panel-title">Social Share</h3>
					<div class="panel-container">
						
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-meta-keyword">Show Custom</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'product_page_button'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label" >Custom block</label>
							<div class="col-sm-9">
								<?php echo field_langTextarea($languages,$storeid ,'soconfig_pages_store',$soconfig_pages_store,'product_socialshare');?>
							</div>
						</div>
					</div>
				</div>
				<div class="so-panel">
					<h3 class="panel-title">Related products</h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-related">Show Related</label>
							<div class="col-sm-9">
								<?php echo field_onOff('soconfig_pages_store',$soconfig_pages_store,'related_status'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-tabs_position">Orientation Related :</label>
							<div class="col-sm-9">
								<?php echo field_select('soconfig_pages_store',$soconfig_pages_store,'related_position',$related_position,'width30'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-listing_quick_type">Related product number per row <p class="help-block">(use orientation related = Horizontal)</p></label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs" >
									<?php foreach ($devices as $subfix => $device) : ?>
									<li class="<?php echo ($subfix == 'lg' ? 'active' : ''); ?>"><a href="#language-product_related_<?php echo $subfix ?><?php echo $store["store_id"]; ?>" data-toggle="tab"><?php echo $device ?></a></li>
									<?php endforeach; ?>
								</ul>
								<div class="tab-content">
									<?php foreach ($devices as $subfix => $device) : ?>
									<div class="tab-pane <?php echo ($subfix == 'lg' ? 'active' : ''); ?>" id="language-product_related_<?php echo $subfix ?><?php echo $store["store_id"]; ?>">
										<select name="soconfig_pages_store[<?php echo $store["store_id"]; ?>][product_related_column_<?php echo $subfix; ?>]" class="form-control width30">
										   <?php foreach ($columns as $fv => $fc) { ?>
												<?php ($fv == $soconfig_pages_store[$store["store_id"]]["product_related_column_".$subfix] ) ? $current = 'selected' : $current=''; ?>
												<option value="<?php echo $fv; ?>" <?php echo $current; ?> ><?php echo $fc; ?></option>	
											<?php } ?>
										</select>
									</div>
									<?php endforeach; ?>
									<span class="help-block"><?php echo $entry_catalog_column_help; ?></span>
								</div>
							</div>
						</div>
					</div>	
				</div>		
					
				
            </div>
			
        </div>

    </div>
    <!------------------------------------end tab Pages-->

    <!-------------------------------------Tab Fonts-->
    <div class="tab-pane" id="tab-fonts">
		
		<div class="so-panel">
			<h3 class="panel-title">Fonts<span class="help-block">If you want to speed up your site use one of the common fonts instead of the fonts from Google.</span></h3>
			<div class="panel-container">
				<div class="form-group">
					
					<label class="col-sm-3 control-label" ><?php echo $fonts_body; ?> </label>
					<div class="col-sm-9">
						<div class="block-group fonts-change">
							<?php echo field_onOffFont('soconfig_fonts_store',$soconfig_fonts_store,'body_status'); ?>
							<div class="block-group items-font font-standard" >
								<?php echo field_select('soconfig_fonts_store',$soconfig_fonts_store,'normal_body',$fonts_normal); ?>
							</div>
							<div class="block-group items-font font-google" >
								<label class="control-label">  <?php echo $entry_google_url; ?>  </label>
								<div class="">
									<?php echo field_text('soconfig_fonts_store',$soconfig_fonts_store,'url_body'); ?>
									<span class="help-block"><?php echo $entry_google_url_help ?></span>
								</div>
							</div>
							<div class="block-group items-font font-google" >
								<label class=" control-label"> <?php echo $entry_google_family ?></label>
								<div class="">
									<?php echo field_text('soconfig_fonts_store',$soconfig_fonts_store,'family_body'); ?>
									<span class="help-block"> <?php echo $entry_google_family_help ?></span>
								</div>
							</div>
						</div>
						<div class="block-group">
							<?php echo field_textarea('soconfig_fonts_store',$soconfig_fonts_store,'selector_body','Add css selectors'); ?>
						</div>
					</div>
				</div>
		
				<div class="form-group">
					<label class="col-sm-3 control-label" ><?php echo $fonts_menu; ?> </label>
					<div class="col-sm-9">
						<div class="block-group fonts-change">
							<?php echo field_onOffFont('soconfig_fonts_store',$soconfig_fonts_store,'menu_status'); ?>
							<div class="block-group items-font font-standard" >
								<?php echo field_select('soconfig_fonts_store',$soconfig_fonts_store,'normal_menu',$fonts_normal); ?>
							</div>
							<div class="block-group items-font font-google" >
								<label class="control-label">  <?php echo $entry_google_url; ?>  </label>
								<div class="">
									<?php echo field_text('soconfig_fonts_store',$soconfig_fonts_store,'url_menu'); ?>
									<span class="help-block"><?php echo $entry_google_url_help ?></span>
								</div>
							</div>
							<div class="block-group items-font font-google" >
								<label class=" control-label"> <?php echo $entry_google_family ?></label>
								<div class="">
									<?php echo field_text('soconfig_fonts_store',$soconfig_fonts_store,'family_menu'); ?>
									<span class="help-block"> <?php echo $entry_google_family_help ?></span>
								</div>
							</div>
						</div>
						<div class="block-group">
							<?php echo field_textarea('soconfig_fonts_store',$soconfig_fonts_store,'selector_menu','Add css selectors'); ?>
						</div>
					</div>
				</div>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label" ><?php echo $fonts_heading; ?> </label>
					<div class="col-sm-9">
						<div class="block-group fonts-change">
							<?php echo field_onOffFont('soconfig_fonts_store',$soconfig_fonts_store,'heading_status'); ?>
							<div class="block-group items-font font-standard" >
								<?php echo field_select('soconfig_fonts_store',$soconfig_fonts_store,'normal_heading',$fonts_normal); ?>
							</div>
							<div class="block-group items-font font-google" >
								<label class="control-label"> <?php echo $entry_google_url; ?> </label>
								<div class="">
									<?php echo field_text('soconfig_fonts_store',$soconfig_fonts_store,'url_heading'); ?>
									<span class="help-block"><?php echo $entry_google_url_help ?></span>
								</div>
							</div>
							<div class="block-group items-font font-google" >
								<label class=" control-label"> <?php echo $entry_google_family ?></label>
								<div class="">
									<?php echo field_text('soconfig_fonts_store',$soconfig_fonts_store,'family_heading'); ?>
									<span class="help-block"> <?php echo $entry_google_family_help ?></span>
								</div>
							</div>
						</div>
						<div class="block-group">
							<?php echo field_textarea('soconfig_fonts_store',$soconfig_fonts_store,'selector_heading','Add css selectors'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>				
    </div>
    <!-------------------------------------end tab Fonts-->
	
	<!-------------------------------------Tab Social-->
	<div class="tab-pane" id="tab-slide">
		<div class="so-panel">
			<h3 class="panel-title">Facebook</h3>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-3 control-label" >
						Show Facebook
					</label>
					<div class="col-sm-9">
						<?php echo field_onOff('soconfig_social_store',$soconfig_social_store,'social_fb_status'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" >
						Facebook ID:
					</label>
					<div class="col-sm-3">
						<?php echo field_text('soconfig_social_store',$soconfig_social_store,'facebook','Facebook profile name'); ?>
					</div>
					<div class="col-sm-4">
						 <a href="http://findmyfacebookid.com/" target="_blank" style="display: block;float: left;width: auto;margin-top: 7px">Find your Facebook ID »</a>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="so-panel">
			<h3 class="panel-title">Twitter</h3>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-3 control-label" >
						Show Twitter
					</label>
					<div class="col-sm-9">
						<?php echo field_onOff('soconfig_social_store',$soconfig_social_store,'social_twitter_status'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" >
						Twitter username:
					</label>
					<div class="col-sm-3">
						<?php echo field_text('soconfig_social_store',$soconfig_social_store,'twitter','Twitter account name'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="so-panel">
			<h3 class="panel-title">Custom</h3>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-3 control-label" >Show Custom </label>
					<div class="col-sm-3">
						<?php echo field_onOff('soconfig_social_store',$soconfig_social_store,'social_custom_status'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Custom block</label>
					<div class="col-sm-9">
						<?php echo field_langTextarea($languages,$storeid ,'soconfig_social_store',$soconfig_social_store,'video_code');?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-------------------------------------Tab Custom-->
	<div class="tab-pane" id="tab-custom">
		<div class="tab-horizontal">
			<ul class="nav nav-tabs  main_tabs_2">
				<li class="active"><a href="#tab-custom-layout1-<?php echo $store['store_id']; ?>" class="selected" data-toggle="tab"><?php echo $custom_tab_css_input; ?></a></li>
				<li><a href="#tab-custom-layout2-<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $custom_tab_css_file; ?></a></li>
				<li><a href="#tab-custom-layout3-<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $custom_tab_js_input; ?></a></li>
				<li><a href="#tab-custom-layout4-<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $custom_tab_js_file; ?></a></li>

			</ul>
		</div>
        <div class="tab-content ">
			<?php // Custom  CSS--------------------------------------------- ?>
		
            <div class="tab-pane active" id="tab-custom-layout1-<?php echo $store['store_id']; ?>">
				<div class="so-panel">
					<h3 class="panel-title">CSS CODE DIRECT INPUT</h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Status </label>
							<div class="col-sm-10">
								<?php echo field_onOff('soconfig_custom_store',$soconfig_custom_store,'cssinput_status'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<?php $custom_css = isset($soconfig_custom_store[$store["store_id"]]['soconfig_custom_store']['custom_css']) ? $soconfig_custom_store[$store["store_id"]]['soconfig_custom_store']['custom_css'] : '';?>
								<textarea name="soconfig_custom_store[<?php echo $store['store_id']; ?>][custom_css]" rows="20"  class="custom-code form-control code-input"><?php echo $custom_css; ?></textarea>
							</div>
						</div>
						
					</div>
				</div>
            </div>
           
            <div id="tab-custom-layout2-<?php echo $store['store_id']; ?>" class="customcode_wrap tab-pane">
				<div class="so-panel">
					
					<div class="form-group no-margin" >
						<h3 class="col-sm-2 panel-title ">ADD CSS FILES</h3>
						<div class="col-sm-10 text-right"><a class="btn btn-success add-cssfile<?php echo $store['store_id']; ?>" > <i class="fa fa-plus-circle"></i> Add file</a></div>
					</div>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Status </label>
							<div class="col-sm-10">
								<?php echo field_onOff('soconfig_custom_store',$soconfig_custom_store,'cssfile_status'); ?>
							</div>
						</div>
							
						<?php
						if(isset($cssfile[$store['store_id']]) && !empty($cssfile[$store['store_id']])){
							foreach ($cssfile[$store['store_id']] as $file_css) {
								?>
									<div class="form-group">
										<label class="col-sm-2 control-label" >Enter file path</label>
										<div class="col-sm-9">
											<input class="form-control" type="text" name="soconfig_custom_store[<?php echo $store['store_id']; ?>][cssfile][]" value="<?php echo $file_css ?>" />
										</div>
										<div class="col-sm-1">
											<a href="#" class="btn btn-success remove_field"><i class="fa fa-times"></i></a>
										</div>
									</div>
							<?php  
							}
						}else {?>
							<div class="form-group">
								<label class="col-sm-2 control-label" >Enter file path</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="soconfig_custom_store[<?php echo $store['store_id'] ?>][cssfile][]" value="catalog/view/theme/<?php echo $theme;?>/css/custom.css" />
								</div>
							</div>
						<?php } ?>
						
					</div>
				</div>
			</div>

			<?php // Custom  JS--------------------------------------------- ?>
            <div id="tab-custom-layout3-<?php echo $store['store_id']; ?>" class="tab-pane">
				<div class="so-panel">
					<h3 class="panel-title ">JS CODE DIRECT INPUT</h3>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Status </label>
							<div class="col-sm-10">
								<?php echo field_onOff('soconfig_custom_store',$soconfig_custom_store,'jsinput_status'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<?php $custom_js = isset($soconfig_custom_store[$store["store_id"]]['soconfig_custom_store']['custom_js']) ? $soconfig_custom_store[$store["store_id"]]['soconfig_custom_store']['custom_js'] : '';?>
								<textarea name="soconfig_custom_store[<?php echo $store['store_id']; ?>][custom_js]" rows="20" class="custom-code form-control code-input"><?php echo $custom_js; ?></textarea>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div id="tab-custom-layout4-<?php echo $store['store_id']; ?>" class="customcode_wrap tab-pane">
				<div class="so-panel">
					
					<div class="form-group no-margin" >
						<h3 class="col-sm-2 panel-title ">ADD JS FILES</h3>
						<div class="col-sm-10 text-right"><a class="btn btn-success add-jsfile<?php echo $store['store_id']; ?>" > <i class="fa fa-plus-circle"></i> Add file</a></div>
					</div>
					<div class="panel-container">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Status </label>
							<div class="col-sm-10">
								<?php echo field_onOff('soconfig_custom_store',$soconfig_custom_store,'jsfile_status'); ?>
							</div>
						</div>
				
						<?php
						if(isset($jsfile[$store['store_id']]) && !empty($jsfile[$store['store_id']])){
							foreach ($jsfile[$store['store_id']] as $file_js) {
								?>
									<div class="form-group">
										<label class="col-sm-2 control-label" >Enter file path</label>
										<div class="col-sm-9">
											<input class="form-control" type="text" name="soconfig_custom_store[<?php echo $store['store_id']; ?>][jsfile][]" value="<?php echo $file_js ?>" />
										</div>
										<div class="col-sm-1">
											<a href="#" class="btn btn-success remove_field"><i class="fa fa-times"></i></a>
										</div>
									</div>
							<?php  
							}
						}else {?>
							<div class="form-group">
								<label class="col-sm-2 control-label" >Enter file path</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="soconfig_custom_store[<?php echo $store['store_id'] ?>][jsfile][]" value="catalog/view/theme/<?php echo $theme;?>/js/custom.js" />
								</div>
							</div>
						<?php } ?>
						
					</div>
				</div>
			</div>
			
		</div>
	 
	</div>
	<!-------------------------------------end tab Custom-->
	
	<!-------------------------------------Tab Sample Data-->
	<div class="tab-pane" id="tab-sampledata">
		<div class="so-panel">
			<h3 class="panel-title">Install sample data <span class="help-block">If you want to make your shop look exactly like our demo. Install sample data.</span></h3>
			<div class="panel-container ">
				<div class="form-group" style="margin-top:20px;">
					<?php if ($do == ''){?>
					<table class="table table-bordered table-hover sort-table">
						 <thead>
						  <tr>
							<th>Demo Layout</th>
							<th style="width:150px;text-align:center;">Action</th>
						  </tr>
						</thead>
						<tbody>
						<?php
						foreach($demos as $data){
							echo '<tr>';
							echo '<td><a href="'.$data['link'].'" target="_blank">'.$data['title'].'</a></td>';
							echo '<td style="text-align:center;"><div class="btn-group">
							 <a href="'.$base_href.'&do=install-alert&layout='.$data['key'].'"><span class="btn btn-block btn-success">Select</span></a>
							 </div></td>';
							echo '</tr>';
						}
						?>
						</tbody>
					</table>
					<?php  } elseif($do == 'install-alert'){ ?>
						<div class="box box-primary">  
						   <div class="box-body">
							  <div class="alert alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4><i class="icon fa fa-warning"></i> Layout installation caution</h4>
								Please note that all your Soconfig Theme Configuration settings and  Theme modules will be removed.  
								 
							  </div> 
							  <hr>
						   </div>
						   <div class="box-footer">
							  <a href="<?php echo $base_href;?>"><button class="btn btn-default" type="button">Cancel</button></a>
							  <a href="<?php echo $base_href;?>&do=install&layout=<?php echo $layout;?>"><span class="btn btn-primary pull-right" type="submit">Continue</span></a>
						   </div>
						</div>
					
					<?php }elseif($do == 'install'){?>
					<div class="box box-primary">  
					 
						<div class="box-body">
							<input type="hidden" name="required_layout" value="<?php echo $layout;?>">
							<div class="col-md-6">
								<div class="form-group">
									<label>Store:</label>
									<?php
									foreach($stores as $store){
									   if ($store['store_id'] == $store_id)
										 echo $store['name'];
									}
									?>
								</div>
							 
								<div class="form-group">
								   <label>Layout:</label>
								   <?php 
								    foreach($demos as $data){
									    if ($data['key'] == $layout) echo $data['title'];
									}
								   ?>
								</div>
							 
								<div class="form-group <?php echo isset($soconfig['form_fileds_with_error']) ? (in_array('home_layout',$soconfig['form_fileds_with_error']) ? 'has-error' : '') : '';?>">
								   <label>Choose Home page layout:</label>
								   <select class="form-control select2" name="home_layout">
								   <option value="">---</option>
									<?php foreach($oc_layouts as $data){
										echo '<option value="'.$data['layout_id'].'">'.$data['name'].'</option>'; 
									} ?>       
								   </select>
								</div>
								
							</div> 
						 
							<hr class="clearfix"> 
						</div>
					   
						<div class="box-footer clearfix">
						   <a href="<?php echo $base_href;?>"><button class="btn btn-default" type="button">Back</button></a>
						   <button onclick="installMegamenu();" class="btn btn-success pull-right" type="submit">Install</button>
						</div>
					 </div>
					
					<?php }elseif($do == 'install-success'){ ?>
					<div class="box box-primary">  
					   <div class="box-body">
					   
						  <div class="alert alert-success do-not-hide">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Layout installation</h4>
							<p>Installed successfully!  </p>
						  </div>
						  
							<p><strong>To complete installation follow these steps:</strong></p>
							<ul class="list"> 
								<li>Go to <a href="<?php echo $base_href;?>" target="_blank">Tab General </a> and click on Save button</li>
								<li>Go to <a href="<?php echo $base_href;?>" target="_blank">Tab Layout</a> and click on Save button</li>
								<li>Go to <a href="<?php echo $base_href;?>" target="_blank">Tab Pages</a> and click on Save button</li>
								<li>Go to <a href="<?php echo $base_href;?>" target="_blank">Tab Social Widget</a> and click on Save button</li>
								<li>Go to <a href="<?php echo $base_href;?>" target="_blank">Tab Fonts</a> and click on Save button</li>
								<li>Go to <a href="<?php echo $base_href;?>" target="_blank">Tab Advanced</a> and click on Save button</li>
								<li>Installation complete!</li>
							</ul>
							<hr class="clearfix"> 
					   </div>
					   
					   <div class="box-footer">
						  <a href="<?php echo $base_href;?>"><button class="btn btn-default" type="button">Back</button></a>
						  
					   </div>
					   
					</div>
					
					<?php }elseif( $do == 'install-failed'){?>
					<div class="col-md-12">
					 <div class="box box-primary">  
					   <div class="box-header with-border">
						 <h3 class="box-title">Demo layouts</h3>
					   </div>
					   <div class="box-body">
						  <div class="alert alert-error do-not-hide">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-warning"></i>Installation error</h4>
							Layout was not installed.  
						  </div> 
						 
					   </div>
					   
					   <div class="box-footer">
						  <a href="<?php echo $base_href;?>"><button class="btn btn-default" type="button">Back</button></a>
					   </div>
					 </div>
					</div>
					<?php } ?>
					
				</div>
				
			</div>
		</div>
	</div>
	<!-------------------------------------End Tab Sample Data-->
	
	
	<!-------------------------------------Tab Tab Advanced-->
	<div class="tab-pane" id="tab-advanced">
		
		<div class="so-panel">
			<h3 class="panel-title">SCSS Compile</h3>
			<div class="panel-container">
				<div class="form-group">
					<label class="col-sm-2 control-label" >SCSS Compile</label>
					<div class="col-sm-2">
						<?php echo field_onOff('soconfig_advanced_store',$soconfig_advanced_store,'scsscompile'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" >CSS Format</label>
					<div class="col-sm-3">

						<select name="soconfig_advanced_store[<?php echo $store["store_id"]; ?>][scssformat]" class="form-control">
							<?php foreach ($Scssformat as $fv => $fc) { ?>
								<?php 
									if($fv == $soconfig_advanced_store[$store["store_id"]]["scssformat"] && isset($soconfig_advanced_store[$store["store_id"]]["scssformat"])){
										$current = "selected";
									}else{
										$current = "";
									}

								?>
								<option value="<?php echo $fv; ?>" <?php echo $current; ?> ><?php echo $fc; ?></option>	
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" >User Developer Compile Muti Color</label>
					<div class="col-sm-2">
						<?php echo field_onOff('soconfig_advanced_store',$soconfig_advanced_store,'compileMutiColor'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="so-panel hidden">
			<h3 class="panel-title">Performance</h3>
			<div class="panel-container">
				
				<div class="form-group">
					<label class="col-sm-2 control-label" >Minify CSS </label>
					<div class="col-sm-10">
						<?php echo field_onOff('soconfig_advanced_store',$soconfig_advanced_store,'minify_css'); ?>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Minify JS</label>
					<div class="col-sm-10">
						<?php echo field_onOff('soconfig_advanced_store',$soconfig_advanced_store,'minify_js'); ?>
						
					</div>
				</div>
				<div class="form-group" style="padding:0;border:none;">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<a href="<?php echo $clear_cache_href;?>" data-toggle="tooltip"  data-original-title="Clear Minify"><button class="btn btn-primary" type="button"><i class="fa fa-eraser"></i> Clear Minify</button></a>
						<span style="margin:0 10px;">Delete all of the theme css, js file path: system/soconfig/data/cache/minify.</span>
					</div>
				</div>
				
				
			</div>
		</div>


	</div>
	<!-------------------------------------End Tab Advanced-->
	
</div>
