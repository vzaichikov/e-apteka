<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">

<!-- quicksave -->
	  <?php if (isset($pidqs) && $pidqs) { ?>
	  <button id="qsave" style="margin: 0 10px;" data-toggle="tooltip" title="Сохранить и остаться" class="btn btn-warning"><i class="fa fa-save"></i></button>
	  <?php } ?>
<!-- quicksave end -->
			
				<button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
						<li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
						<li><a href="#tab-faq" data-toggle="tab"><?php echo $tab_faq; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" id="language">
								<?php foreach ($languages as $language) { ?>
									<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
									<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
											<div class="col-sm-10">
												<input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_name[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-alternate_name<?php echo $language['language_id']; ?>">Синонимы, или альтернативные названия</label>
											<div class="col-sm-10">
												<textarea rows="20" name="category_description[<?php echo $language['language_id']; ?>][alternate_name]" placeholder="<?php echo $entry_description; ?>" id="input-alternate_name<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['alternate_name'] : ''; ?></textarea>
												<span class="help"><i class="fa fa-info-circle"></i> каждое с новой строки</span>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-seo_name<?php echo $language['language_id']; ?>">SEO Название</label>
											<div class="col-sm-10">
												<input type="text" name="category_description[<?php echo $language['language_id']; ?>][seo_name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['seo_name'] : ''; ?>" placeholder="Google Category Tree" id="input-seo_name<?php echo $language['language_id']; ?>" class="form-control" />
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-google_tree<?php echo $language['language_id']; ?>">Google Tree</label>
											<div class="col-sm-10">
												<input type="text" name="category_description[<?php echo $language['language_id']; ?>][google_tree]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['google_tree'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-google_tree<?php echo $language['language_id']; ?>" class="form-control" />
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
											<div class="col-sm-10">
												<textarea name="category_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
											<div class="col-sm-10">
												<input type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_meta_title[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
											<div class="col-sm-10">
												<textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
											<div class="col-sm-10">
												<textarea name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="tab-pane" id="tab-data">
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-onlineapteka"><img height="20px" src="https://e-apteka.com.ua/image/brand/marker-icon-brand-med-service.svg" />Онлайн-аптека</label>
								<div class="col-sm-10">
									<input type="text" name="onlineapteka" value="<?php echo $onlineapteka; ?>" placeholder="Начните вводить для автоподбора" id="input-onlineapteka" class="form-control" />
									<input type="hidden" name="onlineapteka_id" value="<?php echo $onlineapteka_id; ?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-uuid">UUID</label>
								<div class="col-sm-10">
									<input type="text" name="uuid" value="<?php echo $uuid; ?>" placeholder="uuid" id="input-uuid" class="form-control" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-uuid">ATX CODE</label>
								<div class="col-sm-10">
									<input type="text" name="atx_code" value="<?php echo $atx_code; ?>" placeholder="atx_code" id="input-atx_code" class="form-control" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-uuid">Действующее вещество</label>
								<div class="col-sm-10">
									<input type="text" name="substance" value="<?php echo $substance; ?>" placeholder="substance" id="input-substance" class="form-control" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-no_payment">Не разрешать оплату</label>
								<div class="col-sm-10">
									<select name="no_payment" id="input-no_payment" class="form-control">
										<?php if ($no_payment) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> при наличии в корзине хотя бы одного товара из этой категории невозможна онлайн-оплата</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-no_shipping">Не разрешать доставку</label>
								<div class="col-sm-10">
									<select name="no_shipping" id="input-no_shipping" class="form-control">
										<?php if ($no_shipping) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> при наличии в корзине хотя бы одного товара из этой категории невозможна доставка</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_parent; ?></label>
								<div class="col-sm-10">
									<input type="text" name="path" value="<?php echo $path; ?>" placeholder="<?php echo $entry_parent; ?>" id="input-parent" class="form-control" />
									<input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
									<?php if ($error_parent) { ?>
										<div class="text-danger"><?php echo $error_parent; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-parent">Google/Facebook Merchant</label>
								<div class="col-sm-8">
									<input type="text" name="google_base_category" value="<?php echo $google_base_category; ?>" placeholder="Категория Google (автодополнение)" id="input-google-category" class="form-control" />
									<input type="hidden" name="google_base_category_id" value="<?php echo $google_base_category_id; ?>" />
								</div>
								<div class="col-sm-2"><button type="button" data-toggle="tooltip" title="" class="btn btn-danger" onclick="$('input[name=\'google_base_category\']').val('');$('input[name=\'google_base_category_id\']').val('');" data-original-title="Отключить"><i class="fa fa-trash-o"></i></button></div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-banner">Баннер</label>
								<div class="col-sm-10">
									<select name="banner" id="input-banner" class="form-control <?php if($is_attach_banner == 1): ?>atach<?php endif; ?>">
										<?php foreach ($banners as $item) { ?>
											<option value="<?= $item['banner_id'] ?>" <?php if($item['banner_id'] == $banner): ?>selected="selected"<?php endif; ?>><?php echo $item['name']; ?></option>
										<?php } ?>
									</select>
									<?php if($is_attach_banner == 1): ?>
									<div class="text-danger custom_error" style="display: none">Сперва отсоедините от родительской</div>
									<input type="hidden" name="error_parent" value="1" />
									<?php endif; ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-categories_banner"><span data-toggle="tooltip" title="Дочерние категории">Дочерние категории для баннера</span></label>
								<div class="col-sm-10">
									<input type="text" name="categories_banner" value="" placeholder="Дочерние категории" id="input-categories_banner" class="form-control" />
									<div id="categories_banner" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($categories_banner as $category_banner) { ?>
											<div id="categories_banner<?php echo $category_banner['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category_banner['name']; ?>
												<input type="hidden" name="category_banner[]" value="<?php echo $category_banner['category_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-icon"><span data-toggle="tooltip" title="Имя иконки в svg файле">Имя иконки в svg файле</span></label>
								<div class="col-sm-10">
									<input type="text" name="icon" value="<?php echo $icon; ?>" placeholder="Имя иконки в svg файле" id="input-icon" class="form-control" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip" title="<?php echo $help_filter; ?>"><?php echo $entry_filter; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="filter" value="" placeholder="<?php echo $entry_filter; ?>" id="input-filter" class="form-control" />
									<div id="category-filter" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($category_filters as $category_filter) { ?>
											<div id="category-filter<?php echo $category_filter['filter_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category_filter['name']; ?>
												<input type="hidden" name="category_filter[]" value="<?php echo $category_filter['filter_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
								<div class="col-sm-10">
									<div class="well well-sm" style="height: 150px; overflow: auto;">
										<div class="checkbox">
											<label>
												<?php if (in_array(0, $category_store)) { ?>
													<input type="checkbox" name="category_store[]" value="0" checked="checked" />
													<?php echo $text_default; ?>
													<?php } else { ?>
													<input type="checkbox" name="category_store[]" value="0" />
													<?php echo $text_default; ?>
												<?php } ?>
											</label>
										</div>
										<?php foreach ($stores as $store) { ?>
											<div class="checkbox">
												<label>
													<?php if (in_array($store['store_id'], $category_store)) { ?>
														<input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
														<?php echo $store['name']; ?>
														<?php } else { ?>
														<input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" />
														<?php echo $store['name']; ?>
													<?php } ?>
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
									<?php if ($error_keyword) { ?>
										<div class="text-danger"><?php echo $error_keyword; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
								<div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
									<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-top"><span data-toggle="tooltip" title="<?php echo $help_top; ?>"><?php echo $entry_top; ?></span></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if ($top) { ?>
												<input type="checkbox" name="top" value="1" checked="checked" id="input-top" />
												<?php } else { ?>
												<input type="checkbox" name="top" value="1" id="input-top" />
											<?php } ?>
										&nbsp; </label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-column"><span data-toggle="tooltip" title="<?php echo $help_column; ?>"><?php echo $entry_column; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="column" value="<?php echo $column; ?>" placeholder="<?php echo $entry_column; ?>" id="input-column" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-10">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-show_subcats">Отображать подкатегории, не товары</label>
								<div class="col-sm-10">
									<select name="show_subcats" id="input-show_subcats" class="form-control">
										<?php if ($show_subcats) { ?>
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
								<label class="col-sm-2 control-label" for="input-is_searched">Поиск по первому слову</label>
								<div class="col-sm-10">
									<select name="is_searched" id="input-is_searched" class="form-control">
										<?php if ($is_searched) { ?>
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
								<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
									<select name="status" id="input-status" class="form-control">
										<?php if ($status) { ?>
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
								<label class="col-sm-2 control-label" for="input-status_widget">Показывать виджет ошибки</label>
								<div class="col-sm-10">
									<select name="status_widget" id="input-status_widget" class="form-control">
										<?php if ($status_widget) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-design">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_store; ?></td>
											<td class="text-left"><?php echo $entry_layout; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left"><?php echo $text_default; ?></td>
											<td class="text-left"><select name="category_layout[0]" class="form-control">
												<option value=""></option>
												<?php foreach ($layouts as $layout) { ?>
													<?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']) { ?>
														<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
														<?php } else { ?>
														<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select></td>
										</tr>
										<?php foreach ($stores as $store) { ?>
											<tr>
												<td class="text-left"><?php echo $store['name']; ?></td>
												<td class="text-left"><select name="category_layout[<?php echo $store['store_id']; ?>]" class="form-control">
													<option value=""></option>
													<?php foreach ($layouts as $layout) { ?>
														<?php if (isset($category_layout[$store['store_id']]) && $category_layout[$store['store_id']] == $layout['layout_id']) { ?>
															<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
															<?php } else { ?>
															<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="tab-faq">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $faq_name; ?></label>
								<div class="col-sm-10">
									<?php foreach($languages as $language) { ?>
										<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="category_description[<?php echo $language['language_id']; ?>][faq_name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['faq_name'] : ''; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" style="width:50%;display:inline-block;"/></div><br />
									<?php } ?>
								</div>
							</div>  
							<div class="table-responsive">
								<table id="faq" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-center"><?php echo $column_question; ?></td>
											<td class="text-center"><?php echo $column_faq; ?></td>
											<td class="text-center" style="width:10%"><?php echo $column_icon; ?></td>
											<td class="text-center" style="width:10%"><?php echo $column_sort_order; ?></td>
											<td class="text-center" style="width:10%"></td>
										</tr>
									</thead>
									<tbody>
										<?php $faq_row = 0; ?>
										<?php foreach ($category_faq as $category_faq) { ?>
											<tr id="faq-row<?php echo $faq_row; ?>">
												<td class="text-center">
													<?php foreach($languages as $language) { ?>
														<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="category_faq[<?php echo $faq_row; ?>][question][<?php echo $language['language_id']; ?>]" value="<?php if (isset($category_faq['question'][$language['language_id']])) echo $category_faq['question'][$language['language_id']]; ?>" class="form-control" style="display:inline-block;width:80%;" /></div><br />
													<?php } ?>
												</td>
												<td class="text-center">
													<?php foreach($languages as $language) { ?>
														<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><textarea rows="3" name="category_faq[<?php echo $faq_row; ?>][faq][<?php echo $language['language_id']; ?>]" class="form-control summernote" style="display:inline-block;width:80%;"><?php if (isset($category_faq['faq'][$language['language_id']])) echo $category_faq['faq'][$language['language_id']]; ?></textarea></div><br />
													<?php } ?> 
												</td>
												<td class="text-center"><input type="text" name="category_faq[<?php echo $faq_row; ?>][icon]" value="<?php echo $category_faq['icon']; ?>" class="form-control" /></td>
												<td class="text-center"><input type="text" name="category_faq[<?php echo $faq_row; ?>][sort_order]" value="<?php echo $category_faq['sort_order']; ?>" class="form-control" /></td>
												<td class="text-center"><button type="button" onclick="$('#faq-row<?php echo $faq_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
											</tr> 
											<?php $faq_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4"></td>
											<td class="text-center"><button type="button" onclick="addFaq();" data-toggle="tooltip" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>			
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
	<script type="text/javascript">
		<!--
		// Google Category
		$('input[name=\'google_base_category\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=extension/feed/google_base/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['google_base_category_id']
							}
						}));
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			},
			'select': function(item) {
				$(this).val(item['label']);
				$('input[name=\'google_base_category_id\']').val(item['value']);
			}
		});

		$('input[name=\'onlineapteka\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/onlineapteka&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							category_id: 0,
							name: '<?php echo $text_none; ?>'
						});
						
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'onlineapteka\']').val(item['label']);
				$('input[name=\'onlineapteka_id\']').val(item['value']);
			}
		});

		$('input[name=\'path\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							category_id: 0,
							name: '<?php echo $text_none; ?>'
						});
						
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'path\']').val(item['label']);
				$('input[name=\'parent_id\']').val(item['value']);
			}
		});
	//--></script>
	
	<script type="text/javascript"><!--
		$('input[name=\'filter\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['filter_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'filter\']').val('');
				
				$('#category-filter' + item['value']).remove();
				
				$('#category-filter').append('<div id="category-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_filter[]" value="' + item['value'] + '" /></div>');
			}
		});
		
		$('#category-filter').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		
		
		var cat_id = <?php echo $category_id; ?>;
		$('input[name=\'categories_banner\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete2&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request) + '&category_id=' + cat_id,
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'categories_banner\']').val('');
				
				$('#categories_banner' + item['value']).remove();
				
				$('#categories_banner').append('<div id="categories_banner' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_banner[]" value="' + item['value'] + '" /></div>');
			}
		});
		$('#categories_banner').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		
		
	//--></script>
	<script type="text/javascript"><!--
		
		$('select[name=\'banner\']').click(function (e) {
			$('.custom_error').hide();
			if($(this).hasClass('atach')){
				$('.custom_error').show();
			}
		});
		
		$('#language a:first').tab('show');
	//--></script></div>

				<script type="text/javascript"><!--
				var faq_row = <?php echo $faq_row; ?>;
				function addFaq() {
				html  = '<tr id="faq-row' + faq_row + '">';
				html += '  <td class="text-center">';
				<?php foreach($languages as $language) { ?>
					html += ' <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="category_faq[' + faq_row + '][question][<?php echo $language['language_id']; ?>]" value="" class="form-control" style="display:inline-block;width:80%;" /></div><br />';
				<?php } ?>
				html += '</td>';
				html += '  <td class="text-center">';
				<?php foreach($languages as $language) { ?>
					html += ' <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><textarea rows="3" name="category_faq[' + faq_row + '][faq][<?php echo $language['language_id']; ?>]" value="" class="form-control summernote" style="display:inline-block;width:80%;"></textarea></div><br />';
				<?php } ?>
				html += '</td>';
				html += '  <td class="text-center" style="width:10%"><input type="text" name="category_faq[' + faq_row + '][icon]" value=""  class="form-control" /></td>';
				html += '  <td class="text-center" style="width:10%"><input type="text" name="category_faq[' + faq_row + '][sort_order]" value=""  class="form-control" /></td>';
				html += '  <td class="text-center"><button type="button" onclick="$(\'#faq-row' + faq_row + '\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
				html += '</tr>';
				
				$('#faq tbody').append(html);
				initSummernote();
				
				faq_row++;
				}
				//--></script>
			

<script type="text/javascript"><!--
//quicksave
$("#qsave").on("click",function(){
for(var zz=$(".note-editor").length,i=0;zz>i;i++){var yy=$(".note-editor").eq(i).parent().children("textarea").attr("id");if("function"==typeof $().code)var content=$("#"+yy).code();else var content=$("#"+yy).summernote("code");$("#"+yy).html(content)}
$.ajax({type:"post",data:$("form").serialize(),url:"index.php?route=catalog/category/qsave&token=<?php echo $token; ?>&category_id=<?php echo $pidqs; ?>",dataType:"json",beforeSend:function(){$("#qsave").prop("disabled",!0)},complete:function(){$("#qsave").prop("disabled",!1)},success:function(e){if($(".alert").remove(),$(".text-danger").remove(),$(".form-group").removeClass("has-error"),e.error){if(html='<div class="alert alert-danger">',html+=" "+e.error.warning+' <button type="button" class="close" data-dismiss="alert">&times;</button></br>',e.error.keyword&&($("#input-keyword").after('<div class="text-danger">'+e.error.keyword+"</div>"),html+='</br><i class="fa fa-exclamation-circle"></i> '+e.error.keyword),e.error.name){var r="";for(i in e.error.name){var a=$("#input-name"+i);$(a).parent().hasClass("input-group")?($(a).parent().after('<div class="text-danger">'+e.error.name[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.name[i]):($(a).after('<div class="text-danger">'+e.error.name[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.name[i])}html+=r}if(e.error.meta_title){var r="";for(i in e.error.meta_title){var a=$("#input-meta-title"+i);$(a).parent().hasClass("input-group")?($(a).parent().after('<div class="text-danger">'+e.error.meta_title[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.meta_title[i]):($(a).after('<div class="text-danger">'+e.error.meta_title[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.meta_title[i])}html+=r}$(".text-danger").parentsUntil(".form-group").parent().addClass("has-error"),html+=" </div>",$("#content > .container-fluid").prepend(html)}e.success&&$("#content > .container-fluid").prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+e.success+'  <button type="button" class="close" data-dismiss="alert">&times;</button></div>')},error:function(e,r,a){alert(a+"\r\n"+e.statusText+"\r\n"+e.responseText)}})});
//quicksave end
//--></script>
			
	<?php echo $footer; ?>		