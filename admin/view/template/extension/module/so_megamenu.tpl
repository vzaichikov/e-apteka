<?php echo $header; ?><?php echo $column_left;?>
<div id="content">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><?php echo $error_warning; ?></div>
        <?php } elseif ($success) {  ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php } ?>
		  <div class="page-header">
			<div class="container-fluid">
			  <div class="pull-left">
			  <h1><?php echo $heading_title_so; ?></h1>
			  <ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			  </ul>
			</div>
		  </div>
        <div class="container-fluid" id="megamenu">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div class="row">
					<ul class="nav nav-tabs" role="tablist">
						<li <?php if( $selectedid ==0 ) { ?>class="active" <?php } ?>> <a href="<?php echo $link_add; ?>"> <span class="fa fa-plus"></span><?php echo $button_add_module; ?></a></li>
						<?php $i=1; foreach( $moduletabs as $key => $module ){ ?>
						<li role="presentation" <?php if( $module['module_id']==$selectedid ) { ?>class="active"<?php } ?>>
						<a href="<?php echo $link_add; ?>&module_id=<?php echo $module['module_id']?>" aria-controls="bannermodule-<?php echo $key; ?>"  >
							<span class="fa fa-pencil"></span> <?php echo $module['name']?>
						</a>
						</li>
						<?php $i++ ;} ?>
					</ul>
				</div>

				<div id="content">
					<div class="col-md-12 col-xs-12 col-sm-12">
						<div class="background clearfix">
							<?php if(isset($moduleid) && $moduleid){?>
							<div class="left col-md-4 col-xs-12 col-sm-6 ">
									<a href="<?php echo $action; ?>&action=create" class="btn btn-primary" > <?php echo $text_creat_new_item; ?></a>

									<a id="nestable-menu">
											<button type="button" data-action="expand-all" class="btn btn-primary"><?php echo $text_expand_all; ?></button>
											<button type="button" data-action="collapse-all" class="btn btn-primary"><?php echo $text_collapse_all; ?></button>
									</a>
									<?php echo $nestable_list; ?>
									<div id='sortDBfeedback' style="padding: 10px 0px 0px 0px"></div>
							</div>
							<?php } ?>
							<?php if($action_type == 'create' || $action_type == 'edit') { ?>
							<div class="right col-md-8 col-xs-12 col-sm-6">
									<div class="buttons clearfix">
											<button type="submit" name="button-back" class="button-save" value="" title="Configuration"><i class="fa fa-cog"></i></button>
											<?php if($action_type == 'create') { ?>
											<button type="submit" name="button-create" class="button-save" value="" title="Save"><i class="fa fa-floppy-o"></i></button>
											<?php } elseif ($action_type == 'edit') { ?>
											<button type="submit" name="button-edit" class="button-save" value="" title="Save"><i class="fa fa-floppy-o"></i></button>
											<?php } else { ?>
											<button type="submit" name="button-save" class="button-save" value="" title="Save"><i class="fa fa-floppy-o"></i></button>
											<?php } ?>
									</div>
									<?php if($action_type == 'edit') { ?>
									<h4><?php echo $text_edit_item; ?><?php echo $_GET['edit']; ?>)</h4>
									<input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>" />
									<?php } else { ?>
									<h4><?php echo $text_creat_new_item; ?></h4>
									<?php } ?>
									<div class="input clearfix">
											<p><?php echo $text_name; ?></p>
											<?php
											$i = 0;
											foreach ($languages as $language) { $i++; ?>
												 <input type="text" name="name[<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_description_name; ?>" id="input-head-name-<?php echo $language['language_id']; ?>" value="<?php echo isset($name[$language['language_id']]) ? $name[$language['language_id']] : ''; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
												 <?php
												 ?>
											<?php } ?>
											<select  class="form-control" id="language">
											<?php foreach ($languages as $language) { ?>
												<?php
												if(version_compare(VERSION, '2.1.0.2', '>')) {
												?>
													<option value="<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>
												<?php } else{?>
													<option value="<?php echo $language['language_id']; ?>"><img src="../image/flags/<?php echo $language['image'] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>

												<?php }?>
											<?php } ?>
											</select>
									</div>
									<div class="input clearfix">
									<p><?php echo $text_class_menu ?></p>
											<div class="list-language">
													<input type="text" name="class_menu" value="<?php echo $class_menu; ?>">
											</div>
									</div>
									
									<h4 class="button_parent_config"><?php echo $text_parent_config; ?></h4>(<?php echo $text_parent_item; ?>)
									<div id="text_parent_config" class="collapse">
									
									<div class="input clearfix">
										<p><?php echo $text_description; ?></p>
										<?php
										$i = 0;
										foreach ($languages as $language) { $i++; ?>
											 <input type="text" name="description[<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_description_name; ?>" id="input-head-des-<?php echo $language['language_id']; ?>" value="<?php echo isset($description[$language['language_id']]) ? $description[$language['language_id']] : ''; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
											 <?php
											 ?>
										<?php } ?>
										<select  class="form-control" id="des_language">
										  <?php foreach ($languages as $language) { ?>
											<?php
												if(version_compare(VERSION, '2.1.0.2', '>')) {
												?>
													<option value="<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>
												<?php } else{?>
													<option value="<?php echo $language['language_id']; ?>"><img src="../image/flags/<?php echo $language['image'] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>

												<?php }?>
											<?php } ?>
										</select>
									</div>
								
									<div class="input clearfix">
											<p><?php echo "Icon Thumb" ?></p>
											<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $src_icon; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>"  /></a>
											<input type="hidden" name="icon" value="<?php echo $icon; ?>" id="input-image" />
									</div>

									
									<div class="input clearfix">
											<p><?php echo $text_label_item ?></p>
											<div class="list-language">
													<input type="text" name="label_item" value="<?php echo $label_item; ?>">
											</div>
									</div>

									<div class="input clearfix">
											<p><?php echo $text_icon_font ?></p>
											<div class="list-language">
													<input type="text" name="icon_font" value="<?php echo $icon_font; ?>">
											</div>
									</div>

									
									<div class="input clearfix">
											<p><?php echo $text_type_link; ?></p>
											<select name="type_link" class="type_link">
													<?php if($type_link == 1) { ?>
													<option value="0">Url</option>
													<option value="1" selected="selected">Category</option>
													<?php } else { ?>
													<option value="0" selected="selected">Url</option>
													<option value="1">Category</option>
													<?php } ?>
											</select>
									</div>
									
									<div class="input  type_link_url clearfix " <?php if($type_link == '1') { echo 'style="display:none"'; } ?>>
											<p>Url</p>
											<input type="text" value="<?php echo $link['url']; ?>" name="link[url]">
									</div>
									
									<div class="input type_link_category clearfix" <?php if($type_link != '1') { echo 'style="display:none"'; } ?>>
											<p><?php echo $text_categories; ?></p>
											<select name="link[category]">
											  <option value=""><?php echo $text_all_categories; ?></option>
											  <?php foreach ($categories as $category) { ?>
											  <option value="<?php echo $category['category_id']; ?>" <?php if($link['category'] == $category['category_id']) { echo 'selected'; } ?>><?php echo $category['name']; ?></option>
											  <?php } ?>
											</select>
									</div>
									
									<div class="input clearfix">
											<p><?php echo $text_link_in_new_window; ?></p>
											<select name="new_window">
													<?php if($new_window == 1) { ?>
													<option value="0"><?php echo $text_disabled; ?></option>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<?php } else { ?>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<option value="1"><?php echo $text_enabled; ?></option>
													<?php } ?>
											</select>
									</div>

									
									<div class="input clearfix">
											<p><?php echo $text_status; ?></p>
											<select name="status">
													<?php if( $status == 1) { ?>
													<option value="0"><?php echo $text_enabled; ?></option>
													<option value="1" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
													<option value="0" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="1"><?php echo $text_disabled; ?></option>
													<?php } ?>
											</select>
									</div>

								
									<div class="input clearfix">
											<p><?php echo $text_position; ?></p>
											<select name="position">
													<?php if($position == 1) { ?>
													<option value="0"><?php echo $text_left; ?></option>
													<option value="1" selected="selected"><?php echo $text_right; ?></option>
													<?php } else { ?>
													<option value="0" selected="selected"><?php echo $text_left; ?></option>
													<option value="1"><?php echo $text_right; ?></option>
													<?php } ?>
											</select>
									</div>
								
									<div class="input clearfix">
											<p><?php echo $text_submenu_width; ?></p>
											<input type="text" name="submenu_width" value="<?php echo $submenu_width; ?>"> <div><?php echo $text_example; ?></div>
									</div>
								
									<div class="input clearfix">
											<p><?php echo $text_display_submenu_on; ?></p>
											<select name="display_submenu">
													<?php if($display_submenu == '0') { ?>
													<option value="0" selected="selected">Hover</option>
													<?php } else { ?>
													<option value="0">Hover</option>
													<?php } ?>
													<?php if($display_submenu == '2') { ?>
													<option value="2" selected="selected">Hover intent</option>
													<?php } else { ?>
													<option value="2">Hover intent</option>
													<?php } ?>
													<?php if($display_submenu == '1') { ?>
													<option value="1" selected="selected">Click</option>
													<?php } else { ?>
													<option value="1">Click</option>
													<?php } ?>
											</select>
									</div>
								
									</div>
									<h4 class="button_content_config"><?php echo $text_content_config; ?></h4>(<?php echo $text_content_item; ?>)
									<div id="text_content_config" class="collapse">
								
									<div class="input clearfix">
											<p><?php echo $text_content_width; ?></p>
											<select name="content_width">
													<?php for($i=1; $i<13; $i++) { ?>
													<option value="<?php echo $i; ?>" <?php if($i == $content_width) { echo 'selected="selected"'; } ?>><?php echo $i; ?>/12</option>
													<?php } ?>
											</select>
									</div>
									
									<div class="input clearfix">
											<p><?php echo $text_content_type; ?></p>
											<select name="content_type">
													<?php if($content_type != '0') { ?>
													<option value="0">HTML</option>
													<?php } else { ?>
													<option value="0" selected="selected">HTML</option>
													<?php } ?>
													<?php if($content_type != '1') { ?>
													<option value="1">Product</option>
													<?php } else { ?>
													<option value="1" selected="selected">Product</option>
													<?php } ?>
													<?php if($content_type != '2') { ?>
													<option value="2">Category</option>
													<?php } else { ?>
													<option value="2" selected="selected">Category</option>
													<?php } ?>
													<?php if($content_type != '3') { ?>
													<option value="3">Manufacture</option>
													<?php } else { ?>
													<option value="3" selected="selected">Manufacture</option>
													<?php } ?>
													<?php if($content_type != '4') { ?>
													<option value="4">Image</option>
													<?php } else { ?>
													<option value="4" selected="selected">Image</option>
													<?php } ?>
													<?php if($content_type != '5') { ?>
													<option value="5">Subcategory</option>
													<?php } else { ?>
													<option value="5" selected="selected">Subcategory</option>
													<?php } ?>
													<?php if($content_type != '6') { ?>
													<option value="6">Product List</option>
													<?php } else { ?>
													<option value="6" selected="selected">Product List</option>
													<?php } ?>
											</select>
									</div>
									<div id="content_type0"<?php if($content_type != '0') { ?> style="display:none"<?php } ?> class="content_type content_type_html">
									<h5 style="margin-top:20px">HTML</h5>
									<div class="tab-pane">
											<ul id="language" class="nav nav-tabs">
													<?php foreach ($languages as $language) { ?>
													<li>
														<a data-toggle="tab" href="#content_html_<?php echo $language['language_id']; ?>">
															<?php
															if(version_compare(VERSION, '2.1.0.2', '>')) {
															?>
																<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?>
															<?php } else{?>
																<img src="../image/flags/<?php echo $language['image'] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?>

															<?php }?>
														</a>
													</li>
													<?php } ?>
											</ul>
											<div class="tab-content">
													<?php foreach ($languages as $language) { $lang_id = $language['language_id']; ?>
													
													<div id="content_html_<?php echo $language['language_id']; ?>" class="content_html tab-pane">
														<textarea name="content[html][text][<?php echo $language['language_id']; ?>]" id="content_html_text_<?php echo $language['language_id']; ?>" class="form-control summernote"><?php if(isset($content['html']['text'][$lang_id])) { echo $content['html']['text'][$lang_id]; } ?></textarea>
													</div>
													<?php } ?>
											</div>
									</div>
							</div>

							<div id="content_type1"<?php if($content_type != '1') { ?> style="display:none"<?php } ?> class="content_type">

							
							<div class="input clearfix">
									<p>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
									<input type="hidden" name="content[product][id]" value="<?php echo $content['product']['id']; ?>" />
									<input type="text" id="product_autocomplete" name="content[product][name]" value="<?php echo $content['product']['name']; ?>">
							</div>
					</div>

										<div id="content_type3"<?php if($content_type != '3') { ?> style="display:none"<?php } ?> class="content_type">
											<div class="input clearfix">
													<p>Manufacture:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
													<input type="text" id="manufacture_autocomplete" name="manufacture_autocomplete" value="">
													<div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
														<?php if(isset($content['manufacture']['id']) && $content['manufacture']['id']){ ?>
															<?php foreach ($content['manufacture']['id'] as $key=>$id_category) { ?>
															<div id="product-category<?php echo $id_category; ?>"><i class="fa fa-minus-circle"></i> <?php echo $content['manufacture']['name'][$key]; ?>
															  <input type="hidden" name="content[manufacture][name][]" value="<?php echo $content['manufacture']['name'][$key]; ?>" />
															  <input type="hidden" name="content[manufacture][id][]" value="<?php echo $id_category; ?>" />
															</div>
															<?php } ?>
														<?php } ?>
													</div>
											</div>
										</div>

										<div id="content_type4"<?php if($content_type != '4') { ?> style="display:none"<?php } ?> class="content_type">
											<div class="input clearfix">
													<p>Image:</p>
													<a href="" id="thumb-image-content" data-toggle="image" class="img-thumbnail"><img src="<?php echo (isset($content['image']['image_link'])) ? $content['image']['image_link'] : $src_image_default; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>"  /></a>
													<input type="hidden" name="content[image][link]" value="<?php echo (isset($content['image']['link'])) ? $content['image']['link'] : $image_default; ?>" id="input-image-content" />
											</div>
											<div class="input clearfix" >
													<p>Show Title</p>
													<select name="content[image][show_title]">
															<?php if($content['image']['show_title'] = 1 && isset($content['image']['show_title']) ) { ?>
															<option value="1">Yes</option>
															<?php } else { ?>
															<option value="1" selected="selected">Yes</option>
															<?php } ?>
															<?php if($content['image']['show_title'] != 0 && isset($content['image']['show_title']) ) { ?>
															<option value="0">No</option>
															<?php } else { ?>
															<option value="0" selected="selected">No</option>
															<?php } ?>
													</select>
											</div>
										</div>

										<div id="content_type5"<?php if($content_type != '5') { ?> style="display:none"<?php } ?> class="content_type">
												<div class="input clearfix">
												<p>Category</p>
												<select  multiple name="content[subcategory][category][]" style="height: 400px;width:800px">
												  <option value="" <?php if($content['subcategory']['category'] != null && $content['subcategory']['category'][0] == "") { echo 'selected'; } ?>><?php echo $text_all_categories; ?></option>
												  <?php foreach ($categories as $category) { ?>
												  <option value="<?php echo $category['category_id']; ?>" <?php if($content['subcategory']['category'] != null && in_array($category['category_id'], $content['subcategory']['category'])) { echo 'selected'; } ?>><?php echo $category['name']; ?></option>
												  <?php } ?>
												</select>
												</div>
												<div class="input clearfix">
													<p>Limit Level 1</p>
													<input type="text" name="content[subcategory][limit_level_1]" value="<?php if(isset($content['subcategory']['limit_level_1'])) echo $content['subcategory']['limit_level_1'];  ?>">
												</div>
												<div class="input clearfix">
													<p>Limit Level 2</p>
													<input type="text" name="content[subcategory][limit_level_2]" value="<?php if(isset($content['subcategory']['limit_level_2'])) echo $content['subcategory']['limit_level_2']; ?>">
												</div>
												<div class="input clearfix">
													<p>Limit Level 3</p>
													<input type="text" name="content[subcategory][limit_level_3]" value="<?php if(isset($content['subcategory']['limit_level_3'])) echo $content['subcategory']['limit_level_3']; ?>">
												</div>												
												<div class="input clearfix">
													<p>Show Title</p>
													<select name="content[subcategory][show_title]">
														<?php if($content['subcategory']['show_title'] != '1') { ?>
														<option value="1">Yes</option>
														<?php } else { ?>
														<option value="1" selected="selected">Yes</option>
														<?php } ?>
														<?php if($content['subcategory']['show_title'] != '0') { ?>
														<option value="0">No</option>
														<?php } else { ?>
														<option value="0" selected="selected">No</option>
														<?php } ?>
													</select>
												</div>
												<div class="input clearfix">
													<p>Show Image</p>
													<select name="content[subcategory][show_image]">
														<?php if($content['subcategory']['show_image'] != '1') { ?>
														<option value="1">Yes</option>
														<?php } else { ?>
														<option value="1" selected="selected">Yes</option>
														<?php } ?>
														<?php if($content['subcategory']['show_image'] != '0') { ?>
														<option value="0">No</option>
														<?php } else { ?>
														<option value="0" selected="selected">No</option>
														<?php } ?>
													</select>
												</div>
                                        
                                        <div class="input clearfix">
                                                <p>Columns</p>
                                                <select name="content[subcategory][columns]">
                                                        <?php if($content['subcategory']['columns'] != '1') { ?>
                                                        <option value="1">1</option>
                                                        <?php } else { ?>
                                                        <option value="1" selected="selected">1</option>
                                                        <?php } ?>
                                                        <?php if($content['subcategory']['columns'] != '2') { ?>
                                                        <option value="2">2</option>
                                                        <?php } else { ?>
                                                        <option value="2" selected="selected">2</option>
                                                        <?php } ?>
                                                        <?php if($content['subcategory']['columns'] != '3') { ?>
                                                        <option value="3">3</option>
                                                        <?php } else { ?>
                                                        <option value="3" selected="selected">3</option>
                                                        <?php } ?>
                                                        <?php if($content['subcategory']['columns'] != '4') { ?>
                                                        <option value="4">4</option>
                                                        <?php } else { ?>
                                                        <option value="4" selected="selected">4</option>
                                                        <?php } ?>
                                                        <?php if($content['subcategory']['columns'] != '5') { ?>
                                                        <option value="5">5</option>
                                                        <?php } else { ?>
                                                        <option value="5" selected="selected">5</option>
                                                        <?php } ?>
                                                        <?php if($content['subcategory']['columns'] != '6') { ?>
                                                        <option value="6">6</option>
                                                        <?php } else { ?>
                                                        <option value="6" selected="selected">6</option>
                                                        <?php } ?>
                                                </select>
                                        </div>

                                        
                                        <div class="input clearfix" id="submenu-type">
                                                <p>Submenu type</p>
                                                <select name="content[subcategory][submenu]">
													<?php if($content['subcategory']['submenu'] != '1') { ?>
													<option value="1">Hover</option>
													<?php } else { ?>
													<option value="1" selected="selected">Hover</option>
													<?php } ?>
													<?php if($content['subcategory']['submenu'] != '2') { ?>
													<option value="2">Visible</option>
													<?php } else { ?>
													<option value="2" selected="selected">Visible</option>
													<?php } ?>
                                                </select>
                                        </div>

                                        
                                        <div class="input clearfix" <?php if($content['subcategory']['submenu'] != '2') { echo 'style="display:none"'; } ?> id="submenu-columns">
                                        <p>Submenu columns</p>
											<select name="content[subcategory][submenu_columns]">
													<?php if($content['subcategory']['submenu_columns'] != '1') { ?>
													<option value="1">1</option>
													<?php } else { ?>
													<option value="1" selected="selected">1</option>
													<?php } ?>
													<?php if($content['subcategory']['submenu_columns'] != '2') { ?>
													<option value="2">2</option>
													<?php } else { ?>
													<option value="2" selected="selected">2</option>
													<?php } ?>
													<?php if($content['subcategory']['submenu_columns'] != '3') { ?>
													<option value="3">3</option>
													<?php } else { ?>
													<option value="3" selected="selected">3</option>
													<?php } ?>
													<?php if($content['subcategory']['submenu_columns'] != '4') { ?>
													<option value="4">4</option>
													<?php } else { ?>
													<option value="4" selected="selected">4</option>
													<?php } ?>
													<?php if($content['subcategory']['submenu_columns'] != '5') { ?>
													<option value="5">5</option>
													<?php } else { ?>
													<option value="5" selected="selected">5</option>
													<?php } ?>
													<?php if($content['subcategory']['submenu_columns'] != '6') { ?>
													<option value="6">6</option>
													<?php } else { ?>
													<option value="6" selected="selected">6</option>
													<?php } ?>
											</select>
										</div>
										</div>

										<div id="content_type6"<?php if($content_type != '6') { ?> style="display:none"<?php } ?> class="content_type">
												<div class="input clearfix">
													<p>Limit</p>
													<input type="text" name="content[productlist][limit]" value="<?php if(isset($content['productlist']['limit'])) echo $content['productlist']['limit']; ?>">
												</div>
												<div class="input clearfix">
													<p>Type</p>
													<select name="content[productlist][type]">
														<?php if($content['productlist']['type'] != 'new') { ?>
														<option value="new">New</option>
														<?php } else { ?>
														<option value="new" selected="selected">New</option>
														<?php } ?>
														<?php if($content['productlist']['type'] != 'special') { ?>
														<option value="special">Special</option>
														<?php } else { ?>
														<option value="special" selected="selected">Special</option>
														<?php } ?>
														<?php if($content['productlist']['type'] != 'bestseller') { ?>
														<option value="bestseller">Best Seller</option>
														<?php } else { ?>
														<option value="bestseller" selected="selected">Best Seller</option>
														<?php } ?>
														<?php if($content['productlist']['type'] != 'popular') { ?>
														<option value="popular">Popular</option>
														<?php } else { ?>
														<option value="popular" selected="selected">Popular</option>
														<?php } ?>
													</select>
												</div>
												<div class="input clearfix">
													<p>Show Title</p>
													<select name="content[productlist][show_title]">
														<?php if($content['productlist']['show_title'] != '1') { ?>
														<option value="1">Yes</option>
														<?php } else { ?>
														<option value="1" selected="selected">Yes</option>
														<?php } ?>
														<?php if($content['productlist']['show_title'] != '0') { ?>
														<option value="0">No</option>
														<?php } else { ?>
														<option value="0" selected="selected">No</option>
														<?php } ?>
													</select>
												</div>
                                        
                                        <div class="input clearfix">
                                                <p>Columns</p>
                                                <select name="content[productlist][col]">
                                                        <?php if($content['productlist']['col'] != '1') { ?>
                                                        <option value="1">1</option>
                                                        <?php } else { ?>
                                                        <option value="1" selected="selected">1</option>
                                                        <?php } ?>
                                                        <?php if($content['productlist']['col'] != '2') { ?>
                                                        <option value="2">2</option>
                                                        <?php } else { ?>
                                                        <option value="2" selected="selected">2</option>
                                                        <?php } ?>
                                                        <?php if($content['productlist']['col'] != '3') { ?>
                                                        <option value="3">3</option>
                                                        <?php } else { ?>
                                                        <option value="3" selected="selected">3</option>
                                                        <?php } ?>
                                                        <?php if($content['productlist']['col'] != '4') { ?>
                                                        <option value="4">4</option>
                                                        <?php } else { ?>
                                                        <option value="4" selected="selected">4</option>
                                                        <?php } ?>
                                                        <?php if($content['productlist']['col'] != '5') { ?>
                                                        <option value="5">5</option>
                                                        <?php } else { ?>
                                                        <option value="5" selected="selected">5</option>
                                                        <?php } ?>
                                                        <?php if($content['productlist']['col'] != '6') { ?>
                                                        <option value="6">6</option>
                                                        <?php } else { ?>
                                                        <option value="6" selected="selected">6</option>
                                                        <?php } ?>
                                                </select>
                                        </div>

                                        
										</div>

                                        <div id="content_type2"<?php if($content_type != '2') { ?> style="display:none"<?php } ?> class="content_type">
                                        <h5 style="margin-top:20px">Categories</h5>
                                        
                                        <div class="input clearfix">
                                                <p>Add categories<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
                                                <input type="text" id="categories_autocomplete" value="">
                                        </div>

                                        
                                        <div class="input clearfix">
                                                <p>Sort categories</p>
                                                <div class="cf nestable-lists">
                                                        <div class="dd" id="sort_categories">
                                                                <ol class="dd-list">
                                                                        <?php echo $list_categories; ?>
                                                                </ol>
                                                        </div>
                                                        <input type="hidden" id="sort_categories_data" name="content[categories][categories]" value="<?php echo !is_array($content['categories']['categories']) ? $content['categories']['categories'] : '' ; ?>" />
                                                </div>
                                        </div>

                                        
                                        <div class="input clearfix">
                                                <p>Columns</p>
                                                <select name="content[categories][columns]">
                                                        <?php if($content['categories']['columns'] != '1') { ?>
                                                        <option value="1">1</option>
                                                        <?php } else { ?>
                                                        <option value="1" selected="selected">1</option>
                                                        <?php } ?>
                                                        <?php if($content['categories']['columns'] != '2') { ?>
                                                        <option value="2">2</option>
                                                        <?php } else { ?>
                                                        <option value="2" selected="selected">2</option>
                                                        <?php } ?>
                                                        <?php if($content['categories']['columns'] != '3') { ?>
                                                        <option value="3">3</option>
                                                        <?php } else { ?>
                                                        <option value="3" selected="selected">3</option>
                                                        <?php } ?>
                                                        <?php if($content['categories']['columns'] != '4') { ?>
                                                        <option value="4">4</option>
                                                        <?php } else { ?>
                                                        <option value="4" selected="selected">4</option>
                                                        <?php } ?>
                                                        <?php if($content['categories']['columns'] != '5') { ?>
                                                        <option value="5">5</option>
                                                        <?php } else { ?>
                                                        <option value="5" selected="selected">5</option>
                                                        <?php } ?>
                                                        <?php if($content['categories']['columns'] != '6') { ?>
                                                        <option value="6">6</option>
                                                        <?php } else { ?>
                                                        <option value="6" selected="selected">6</option>
                                                        <?php } ?>
                                                </select>
                                        </div>

                                        
                                        <div class="input clearfix" id="submenu-type">
                                                <p>Submenu type</p>
                                                <select name="content[categories][submenu]">
													<?php if($content['categories']['submenu'] != '1') { ?>
													<option value="1">Hover</option>
													<?php } else { ?>
													<option value="1" selected="selected">Hover</option>
													<?php } ?>
													<?php if($content['categories']['submenu'] != '2') { ?>
													<option value="2">Visible</option>
													<?php } else { ?>
													<option value="2" selected="selected">Visible</option>
													<?php } ?>
                                                </select>
                                        </div>

                                        
                                        <div class="input clearfix" <?php if($content['categories']['submenu'] != '2') { echo 'style="display:none"'; } ?> id="submenu-columns">
                                        <p>Submenu columns</p>
                                        <select name="content[categories][submenu_columns]">
                                                <?php if($content['categories']['submenu_columns'] != '1') { ?>
                                                <option value="1">1</option>
                                                <?php } else { ?>
                                                <option value="1" selected="selected">1</option>
                                                <?php } ?>
                                                <?php if($content['categories']['submenu_columns'] != '2') { ?>
                                                <option value="2">2</option>
                                                <?php } else { ?>
                                                <option value="2" selected="selected">2</option>
                                                <?php } ?>
                                                <?php if($content['categories']['submenu_columns'] != '3') { ?>
                                                <option value="3">3</option>
                                                <?php } else { ?>
                                                <option value="3" selected="selected">3</option>
                                                <?php } ?>
                                                <?php if($content['categories']['submenu_columns'] != '4') { ?>
                                                <option value="4">4</option>
                                                <?php } else { ?>
                                                <option value="4" selected="selected">4</option>
                                                <?php } ?>
                                                <?php if($content['categories']['submenu_columns'] != '5') { ?>
                                                <option value="5">5</option>
                                                <?php } else { ?>
                                                <option value="5" selected="selected">5</option>
                                                <?php } ?>
                                                <?php if($content['categories']['submenu_columns'] != '6') { ?>
                                                <option value="6">6</option>
                                                <?php } else { ?>
                                                <option value="6" selected="selected">6</option>
                                                <?php } ?>
                                        </select>
                                </div>
                        </div>
							</div>
		</div>
        <?php } else { ?>
        <div class="right col-md-8 col-xs-12 col-sm-6">
		<div class="buttons clearfix">
			<button type="submit" name="button-save" class="button-save" value="" title="Save"><i class="fa fa-floppy-o"></i></button>
			<button type="submit" name="button-close" class="button-save" value="" title="Close"><i class="fa fa-reply"></i></button>
		</div>
        
		<input type="hidden" name="moduleid" value="<?php echo isset($_GET['module_id']) && !empty($_GET['module_id']) ? $_GET['module_id'] : $moduleid; ?>" />
        <h4><p><?php echo $text_basic_configuration; ?></p></h4>
		
		<?php  if(!isset($_GET['module_id']) || empty($_GET['module_id'])){ ?>
			<div class="input clearfix">
					<p>Import Module</p>
					<select name="import_module">
							<?php if ($modules) { ?>
								<option value="0">No Import</option>
								<?php foreach ($modules as $module) { ?>
									<option value="<?php echo $module['module_id']; ?>"><?php echo $module['name']; ?></option>
								 <?php } ?>
							<?php } ?>
					</select>
			</div>
		<?php } ?>
        
        <div class="input clearfix">
                <p><?php echo $text_name; ?></p>
                <input type="text" name="name" value="<?php echo $name; ?>"  id="input-name" class="form-control" />
        </div>
		
		 <div class="input clearfix">
                <p><?php echo $text_suffix_class; ?></p>
                <input type="text" name="suffix_class" value="<?php echo $suffix_class; ?>"  id="input-name" class="form-control" />
        </div>
		
		<div class="input clearfix">
				<p><?php echo $entry_head_name; ?></p>
				<?php
				$i = 0;
				foreach ($languages as $language) { $i++; ?>
					 <input type="text" name="head_name[<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_head_name; ?>" id="input-headname-<?php echo $language['language_id']; ?>" value="<?php echo isset($head_name[$language['language_id']]) ? $head_name[$language['language_id']] : ''; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
					 <?php
					 ?>
				<?php } ?>
				<select  class="form-control" id="head_name_language">
				<?php foreach ($languages as $language) { ?>
					<?php
					if(version_compare(VERSION, '2.1.0.2', '>')) {
					?>
						<option value="<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>
					<?php } else{?>
						<option value="<?php echo $language['language_id']; ?>"><img src="../image/flags/<?php echo $language['image'] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>

					<?php }?>
				<?php } ?>
				</select>
		</div>
	
		<div class="input clearfix">
			<p><?php echo $entry_display_title_module; ?></p>
			<select name="disp_title_module" id="input-disp_title_module" class="form-control">
				<?php
				if ($disp_title_module) { ?>
				<option value="1" selected="selected"><?php echo $text_yes; ?></option>
				<option value="0"><?php echo $text_no; ?></option>
				<?php } else { ?>
				<option value="1"><?php echo $text_yes; ?></option>
				<option value="0" selected="selected"><?php echo $text_no; ?></option>
				<?php } ?>
			</select>
		</div>
		
        <div class="input clearfix">
                <p><?php echo $text_status; ?></p>
                <select name="status">
                        <?php if ($status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                </select>
        </div>
		
        <div class="input clearfix">
                <p><?php echo $text_use_cache; ?></p>
                <label class="radio-inline">
                        <?php if ($use_cache) { ?>
                        <input type="radio" name="use_cache" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="use_cache" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                </label>
                <label class="radio-inline">
                        <?php if (!$use_cache) { ?>
                        <input type="radio" name="use_cache" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="use_cache" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                </label>
        </div>
        
        <div class="input clearfix" id="input-cache_time_form">
                <p><?php echo $text_cache_time; ?></p>
                <input type="text" name="cache_time" value="<?php echo $cache_time; ?>"  id="input-name" class="form-control" />
        </div>
        

        <h4 style="margin-top:20px"><?php echo $text_design_configuration; ?></h4>
        
        <div class="input clearfix">
                <p><?php echo $text_orientation; ?></p>
                <select name="orientation">
                        <?php if ($orientation) { ?>
                        <option value="0">Horizontal</option>
                        <option value="1" selected="selected">Vertical</option>
                        <?php } else { ?>
                        <option value="0" selected="selected">Horizontal</option>
                        <option value="1">Vertical</option>
                        <?php } ?>
                </select>
        </div>
        <!-- Search -->

        <div class="input clearfix">
                <p><?php echo $text_number_load_vertical;  ?></p>
                <input type="text" name="show_itemver" value="<?php echo $show_itemver; ?>"  id="input-name" class="form-control" />
        </div>

		
		<div class="input clearfix">
				<p><?php echo $text_navigation_text; ?></p>
				<?php
				$i = 0;
				foreach ($languages as $language) { $i++; ?>
					 <input type="text" name="navigation_text[<?php echo $language['language_id']; ?>]" placeholder="<?php echo $text_navigation_text; ?>" id="input-text-navigation-<?php echo $language['language_id']; ?>" value="<?php if(isset($navigation_text[$language['language_id']])) echo $navigation_text[$language['language_id']]; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
					 <?php
					 ?>
				<?php } ?>
				<select  class="form-control" id="navigation_language">
				<?php foreach ($languages as $language) { ?>
					<?php
					if(version_compare(VERSION, '2.1.0.2', '>')) {
					?>
						<option value="<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>
					<?php } else{?>
						<option value="<?php echo $language['language_id']; ?>"><img src="../image/flags/<?php echo $language['image'] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>

					<?php }?>
				<?php } ?>
				</select>
		</div>

        
        <div class="input clearfix">
                <p><?php echo $text_expand_menu_bar; ?></p>
                <select name="full_width">
                        <?php if ($full_width) { ?>
                        <option value="1" selected="selected">Yes</option>
                        <option value="0">No</option>
                        <?php } else { ?>
                        <option value="1">Yes</option>
                        <option value="0" selected="selected">No</option>
                        <?php } ?>
                </select>
        </div>

        
        <div class="input clearfix">
                <p><?php echo $text_home_item;?></p>
                <select name="home_item">
                        <?php if ($home_item == 'icon') { ?>
                        <option value="icon" selected="selected">Icon</option>
                        <?php } else { ?>
                        <option value="icon">Icon</option>
                        <?php } ?>
                        <?php if ($home_item == 'text') { ?>
                        <option value="text" selected="selected">Text</option>
                        <?php } else { ?>
                        <option value="text">Text</option>
                        <?php } ?>
                        <?php if ($home_item == 'disabled') { ?>
                        <option value="disabled" selected="selected">Disabled</option>
                        <?php } else { ?>
                        <option value="disabled">Disabled</option>
                        <?php } ?>
                </select>
        </div>
		
		<div class="input clearfix">
			<p><?php echo $text_home_text;?></p>
			<?php
			$i = 0;
			foreach ($languages as $language) { $i++; ?>
				 <input type="text" name="home_text[<?php echo $language['language_id']; ?>]" placeholder="<?php echo $text_home_text; ?>" id="input-home-text-<?php echo $language['language_id']; ?>" value="<?php if(isset($home_text[$language['language_id']])) echo $home_text[$language['language_id']]; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
				 <?php
				 ?>
			<?php } ?>
			<select  class="form-control" id="home_text_language">
			<?php foreach ($languages as $language) { ?>
				<?php
				if(version_compare(VERSION, '2.1.0.2', '>')) {
				?>
					<option value="<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>
				<?php } else{?>
					<option value="<?php echo $language['language_id']; ?>"><img src="../image/flags/<?php echo $language['image'] ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></option>

				<?php }?>
			<?php } ?>
			</select>
		</div>
        

        <h4 style="margin-top:20px"><?php echo $text_jquery_animations;?></h4>
        
        <div class="input clearfix">
                <p><?php echo $text_animation;?></p>
                <div>
                        <input type="radio" value="slide" name="animation" <?php if($animation == 'slide') { echo 'checked'; } ?>> Slide<br>
                        <input type="radio" value="fade" name="animation" <?php if($animation == 'fade') { echo 'checked'; } ?>> Fade<br>
                        <input type="radio" value="none" name="animation" <?php if($animation == 'none') { echo 'checked'; } ?>> None
                </div>
        </div>

        
        <div class="input clearfix">
                <p><?php echo $text_animation_time;?></p>
                <input type="text" name="animation_time" style="width:50px;margin-right:10px" value="<?php echo $animation_time; ?>">
                <div>ms</div>
        </div>
</div>
<?php } ?>
</div>
</div>
</div>
<!-- End Content -->
</form>
</div>
</div>
<script type="text/javascript">
        $('#language a:first').tab('show');
        if($("input[name='use_cache']:radio:checked").val() == '0')
        {
                $('#input-cache_time_form').hide();
        }else
        {
                $('#input-cache_time_form').show();
        }
        $("input[name='use_cache']").change(function(){
                val = $(this).val();
                if(val ==0)
                {
                        $('#input-cache_time_form').hide();
                }else
                {
                        $('#input-cache_time_form').show();
                }
        });
        $(document).ready(function() {
				$(".button_parent_config").click(function(){
					if($(this).hasClass('active'))
						$(this).removeClass('active');
					else
						$(this).addClass('active');
					$("#text_parent_config").collapse('toggle');
				});

				$(".button_content_config").click(function(){
					if($(this).hasClass('active'))
						$(this).removeClass('active');
					else
						$(this).addClass('active');
					$("#text_content_config").collapse('toggle');
				});

                $('#nestable-menu').on('click', function(e)
                {
					var target = $(e.target),
							action = target.data('action');
					if (action === 'expand-all') {
							$('.dd').nestable('expandAll');
					}
					if (action === 'collapse-all') {
							$('.dd').nestable('collapseAll');
					}
                });

				$('#language').change(function(){
					var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-head-name-'+opt_select);
					$('[id^="input-head-name-"]').addClass('hide');
					_input.removeClass('hide');
				});

				$('#head_name_language').change(function(){
					var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-headname-'+opt_select);
					$('[id^="input-headname-"]').addClass('hide');
					_input.removeClass('hide');
				});

				$('#des_language').change(function(){
					var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-head-des-'+opt_select);
					$('[id^="input-head-des-"]').addClass('hide');
					_input.removeClass('hide');
				});

				$('#navigation_language').change(function(){
					var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-text-navigation-'+opt_select);
					$('[id^="input-text-navigation-"]').addClass('hide');
					_input.removeClass('hide');
				});

				$('#home_text_language').change(function(){
					var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-home-text-'+opt_select);
					$('[id^="input-home-text-"]').addClass('hide');
					_input.removeClass('hide');
				});

                $("select[name=content_type]").change(function () {
                        $("select[name=content_type] option:selected").each(function() {
                                $(".content_type").hide();
                                $("#content_type" + $(this).val()).show();
                        });
                });
                $("#submenu-type").change(function () {
                        $("#submenu-type option:selected").each(function() {
                                if($(this).val() == 2) {
                                        $("#submenu-columns").show();
                                } else {
                                        $("#submenu-columns").hide();
                                }
                        });
                });
				$('li','.content_type_html').first().addClass('active');
				$('.tab-pane','.content_type_html .tab-content').first().addClass('active');
                $(".type_link").change(function () {
                        $(".type_link option:selected").each(function() {
                                if($(this).val() == 1) {
									$(".type_link_url").hide();
									$(".type_link_category").show();
                                } else {
									$(".type_link_category").hide();
									$(".type_link_url").show();
                                }
                        });
                });

                $('#product_autocomplete').autocomplete({
                        delay: 500,
                        source: function(request, response) {
                                $.ajax({
                                        url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $_GET['token']; ?>&filter_name=' + encodeURIComponent(request) ,
                                        dataType: 'json',
                                        success: function(json) {
                                                json.unshift({
                                                        'product_id':  0,
                                                        'name':  'None'
                                                });
                                                response($.map(json, function(item) {
                                                        return {
                                                         label: item.name,
                                                         value: item.product_id
                                                        }
                                                }));
                                        }
                                });
                        },
                        select: function(event) {

                                $('#product_autocomplete').val(event.label);
                                $('input[name=\'content[product][id]\']').val(event.value);
                                return false;
                        },
                        focus: function(event) {
                                return false;
                        }
                });

				// Manufacturer
				$('input[name=\'manufacture_autocomplete\']').autocomplete({
					'source': function(request, response) {
						$.ajax({
							url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $_GET['token']; ?>&filter_name=' +  encodeURIComponent(request),
							dataType: 'json',
							success: function(json) {
								response($.map(json, function(item) {
									return {
										label: item['name'],
										value: item['manufacturer_id']
									}
								}));
							}
						});
					},
					'select': function(item) {
						$('input[name=\'category\']').val('');

						$('#product-category' + item['value']).remove();

						$('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="content[manufacture][id][]" value="' + item['value'] + '" /><input type="hidden" name="content[manufacture][name][]" value="' + item['label'] + '" /></div>');
					}
				});

				$('#product-category').delegate('.fa-minus-circle', 'click', function() {
					$(this).parent().remove();
				});


                $('#categories_autocomplete').autocomplete({
                        delay: 500,
                        source: function(request, response) {
                                $.ajax({
                                        url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $_GET['token']; ?>&filter_name=' +  request,
                                        dataType: 'json',
                                        success: function(json) {
                                                json.unshift({
                                                        'category_id':  0,
                                                        'name':  'None'
                                                });
                                                response($.map(json, function(item) {
                                                        return {
                                                                label: item.name,
                                                                value: item.category_id
                                                        }
                                                }));
                                        }
                                });
                        },
                        select: function(event) {
                                if(event.value > 0) {
                                    $("#sort_categories > .dd-list").append('<li class="dd-item" data-id="' + event.value + '" data-name="' + event.label + '"><a class="fa fa-times"></a><div class="dd-handle">' + event.label + '</div></li>');
                                }
                                updateOutput2($('#sort_categories').data('output', $('#sort_categories_data')));
								$( "#sort_categories .fa-times" ).on( "click", function() {
									$(this).parent().remove();
									updateOutput2($('#sort_categories').data('output', $('#sort_categories_data')));
								});
                                return false;
                        },
                        focus: function(event) {
                                return false;
                        }
                });

                function lagXHRobjekt() {
                        var XHRobjekt = null;

                        try {
                                ajaxRequest = new XMLHttpRequest(); // Firefox, Opera, ...
                        } catch(err1) {
                                try {
                                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP"); // Noen IE v.
                                } catch(err2) {
                                        try {
                                                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP"); // Noen IE v.
                                        } catch(err3) {
                                                ajaxRequest = false;
                                        }
                                }
                        }
                        return ajaxRequest;
                }


                function menu_updatesort(jsonstring) {
                        mittXHRobjekt = lagXHRobjekt();

                        if (mittXHRobjekt) {
                                mittXHRobjekt.onreadystatechange = function() {
									
                                        if(ajaxRequest.readyState == 4){
                                                var ajaxDisplay = document.getElementById('sortDBfeedback');
                                                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                                        }
                                }
                                ajaxRequest.open("GET", "index.php?route=extension/module/so_megamenu&token=<?php echo $_GET['token']; ?>&jsonstring=" + jsonstring, true);
                                ajaxRequest.setRequestHeader("Content-Type", "application/json");
                                ajaxRequest.send(null);
                        }
                }

                var updateOutput = function(e)
                {
                        var list   = e.length ? e : $(e.target),
                                output = list.data('output');

                        if (window.JSON) {
                                menu_updatesort(window.JSON.stringify(list.nestable('serialize')));
                        } else {
                                alert('JSON browser support required for this demo.');
                        }
                };

                $('#nestable').nestable({
                        group: 1,
                        maxDepth: 4
                }).on('change', updateOutput);
				
                updateOutput($('#nestable').data('output', $('#nestable-output')));

                var updateOutput2 = function(e)
                {
                        var list   = e.length ? e : $(e.target),
                                output = list.data('output');
                        if (window.JSON && typeof(output)!= 'undefined' ) {
                                output.val(window.JSON.stringify(list.nestable('serialize')));
                        }
                };
                $('#sort_categories').nestable({
                       group: 1,
                        maxDepth: 5
                }).on('change', updateOutput2);

                        updateOutput2($('#sort_categories').data('output', $('#sort_categories_data')));

               $( "#sort_categories .fa-times" ).on( "click", function() {
                       $(this).parent().remove();
                       updateOutput2($('#sort_categories').data('output', $('#sort_categories_data')));
               });
			   
                ///cache
                var button = '<div class="remove-caching" style="margin-left: 15px"><button type="button" onclick="remove_cache()" title="<?php echo $button_clear_cache; ?>" class="btn btn-danger"><i class="fa fa-remove"></i> <?php echo $button_clear_cache;?></button></div>';
                var button_min = '<div class="remove-caching" style="margin-left: 7px"><button type="button" onclick="remove_cache()" title="<?php echo $button_clear_cache; ?>" class="btn btn-danger"><i class="fa fa-remove"></i> </button></div>';
                if($('#column-left').hasClass('active')){
                        $('#column-left #stats').after(button);
                }else{
                        $('#column-left #stats').after(button_min);
                }
                $('#button-menu').click(function(){
                        $('.remove-caching').remove();
                        if($(this).parents().find('#column-left').hasClass('active')){
                                $('#column-left #stats').after(button);
                        }else{
                                $('#column-left #stats').after(button_min);
                        }
                });
        });
        function remove_cache(){
                var success_remove = '<?php echo $success_remove; ?>';
                $.ajax({
                        type: 'POST',
                        url: '<?php echo $linkremove; ?>',
                        data: {	is_ajax_cache_lite: 1},
                        success: function () {
                                var html = '<div class="alert alert-success cls-remove-cache" style="margin: 5px 25px"> '+success_remove+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                                if(!($('.page-header .container-fluid .alert-success')).hasClass('cls-remove-cache')){
                                        $(html).insertAfter('.page-header .container-fluid');
                                }
                        },
                });
        }
</script>
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php echo $footer; ?>