<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
						<li><a href="#tab-likreestr" data-toggle="tab">Реестр</a></li>
						<li><a href="#tab-stocks" data-toggle="tab">Цены, нал</a></li>
						<li><a href="#tab-links" data-toggle="tab"><?php echo $tab_links; ?></a></li>
						<li><a href="#tab-same" data-toggle="tab"><?php echo $tab_same; ?></a></li>
						<li><a href="#tab-attribute" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
						<li><a href="#tab-option" data-toggle="tab"><?php echo $tab_option; ?></a></li>
						<li><a href="#tab-discount" data-toggle="tab"><?php echo $tab_discount; ?></a></li>
						<li><a href="#tab-special" data-toggle="tab"><?php echo $tab_special; ?></a></li>
						<li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
						<li><a href="#tab-faq" data-toggle="tab"><?php echo $tab_faq; ?></a></li>
						<li><a href="#tab-xdstickers" data-toggle="tab"><?php echo $tab_xdstickers; ?></a></li>
						<li class="hidden"><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
						<li class="hidden"><a href="#tab-reward" data-toggle="tab"><?php echo $tab_reward; ?></a></li>
						<li class="hidden"><a href="#tab-recurring" data-toggle="tab"><?php echo $tab_recurring; ?></a></li>
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
												<input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_name[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>">Название в 1С</label>
											<div class="col-sm-10">
												<input type="text" name="product_description[<?php echo $language['language_id']; ?>][original_name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['original_name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-original_name<?php echo $language['language_id']; ?>" class="form-control" />											
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
											<div class="col-sm-10">
												<textarea name="product_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-instruction<?php echo $language['language_id']; ?>">Инструкция</label>
											<div class="col-sm-10">

												<?php if (!empty($reg_instruction)) { ?>
													<div class="well">
													<div class="alert alert-danger">
														Инструкция загружена из реестра, нет необходимости ее заполнять!
													</div>

													<?php if (!empty($reg_instruction_html)) { ?>
														<div class="text-success">
															<i class="fa fa-check-circle"></i> <a href="<?php echo $reg_instruction_html; ?>" target="_blank">Инструкция в HTML существует, скачать</a>
														</div>
													<? } ?>
													<?php if (!empty($reg_instruction_pdf)) { ?>
														<div class="text-success">
															<i class="fa fa-check-circle"></i> <a href="<?php echo $reg_instruction_pdf; ?>" target="_blank">Инструкция в PDF существует, скачать</a>
														</div>
													<? } ?>
												</div>
												<? } ?>


												<textarea name="product_description[<?php echo $language['language_id']; ?>][instruction]" placeholder="Инструкция" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['instruction'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
											<div class="col-sm-10">
												<input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_meta_title[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
											<div class="col-sm-10">
												<textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
											<div class="col-sm-10">
												<textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-tag<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_tag; ?>"><?php echo $entry_tag; ?></span></label>
											<div class="col-sm-10">
												<input type="text" name="product_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['tag'] : ''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag<?php echo $language['language_id']; ?>" class="form-control" />
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						
						<div class="tab-pane" id="tab-likreestr">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_trade_name">Торгівельне найменування</label>
								<div class="col-sm-10">
									<input type="text" name="reg_trade_name" value="<?php echo $reg_trade_name; ?>" class="form-control" />											
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_unpatented_name">Міжнародне непатентоване найменування</label>
								<div class="col-sm-10">
									<input type="text" name="reg_unpatented_name" value="<?php echo $reg_unpatented_name; ?>" class="form-control" />											
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_save_terms">Термін придатності</label>
								<div class="col-sm-10">
									<input type="text" name="reg_save_terms" value="<?php echo $reg_save_terms; ?>" class="form-control" />											
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_atx_1">Код АТС 1</label>
								<div class="col-sm-10">
									<input type="text" name="reg_atx_1" value="<?php echo $reg_atx_1; ?>" class="form-control" />											
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_atx_2">Код АТС 2</label>
								<div class="col-sm-10">
									<input type="text" name="reg_atx_2" value="<?php echo $reg_atx_2; ?>" class="form-control" />											
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_atx_3">Код АТС 3</label>
								<div class="col-sm-10">
									<input type="text" name="reg_atx_3" value="<?php echo $reg_atx_3; ?>" class="form-control" />											
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_instruction">Инструкция</label>
								<div class="col-sm-10">
									<input type="text" name="reg_instruction" value="<?php echo $reg_instruction; ?>" class="form-control" />	

									<?php if (!empty($reg_instruction_html)) { ?>
										<div class="text-success">
											<i class="fa fa-check-circle"></i> <a href="<?php echo $reg_instruction_html; ?>" target="_blank">Инструкция в HTML существует, скачать</a>
										</div>
									<? } ?>
									<?php if (!empty($reg_instruction_pdf)) { ?>
										<div class="text-success">
											<i class="fa fa-check-circle"></i> <a href="<?php echo $reg_instruction_pdf; ?>" target="_blank">Инструкция в PDF существует, скачать</a>
										</div>
									<? } ?>

								</div>
							</div>
							<div class="form-group">
								<table class="table table-striped table-bordered">
									<?php if (!empty($reg_json)) { ?>										
										<?php foreach ($reg_json as $key => $value) {  ?>											
											<tr>
												<td>
													<?php echo $key; ?>
												</td>
												<td>
													<?php echo $value; ?>
												</td>
											</tr>											
										<?php } ?>										
									<?php } ?>
								</table>
							</div>
						</div>	
						
						<div class="tab-pane" id="tab-data">
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model; ?></label>
								<div class="col-sm-10">
									<input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
									<?php if ($error_model) { ?>
										<div class="text-danger"><?php echo $error_model; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-uuid">UUID</label>
								<div class="col-sm-10">
									<input type="text" name="uuid" value="<?php echo $uuid; ?>" placeholder="uuid" id="input-uuid" class="form-control" />									
									</div>
								</div>
								
								<div class="form-group">
								<label class="col-sm-2 control-label" for="input-reg_number">Регистрационный номер</label>
								<div class="col-sm-10">
								<input type="text" name="reg_number" value="<?php echo $reg_number; ?>" placeholder="reg_number" id="input-reg_number" class="form-control" />									
							</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-backlight">Подсветка блока</label>
								<div class="col-sm-2">
									<input type="color" name="backlight" value="<?php echo $backlight; ?>" placeholder="#FFFFFF" id="input-backlight" class="form-control" />																	
								</div>
								<br />
								<span class="help text-info"><i class="fa fa-info-circle"></i> блок товара будет иметь подсветку этого цвета в листингах</span>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label text-info" for="input-dnup">Не обновлять название</label>
								<div class="col-sm-10">
									<select name="dnup" id="input-dnup" class="form-control">
										<?php if ($dnup) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
									<span class="help text-info"><i class="fa fa-info-circle"></i> название товара не редактируется из 1С</span>
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
									<span class="help"><i class="fa fa-info-circle"></i> при наличии в корзине этого товара невозможна онлайн-оплата</span>
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
								<label class="col-sm-2 control-label" for="input-no_advert">Не разрешать рекламу</label>
								<div class="col-sm-10">
									<select name="no_advert" id="input-no_advert" class="form-control">
										<?php if ($no_advert) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> не допускать к рекламе в интернете</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-is_receipt">Рецептурный препарат</label>
								<div class="col-sm-10">
									<select name="is_receipt" id="input-is_receipt" class="form-control">
										<?php if ($is_receipt) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> уведомление на сайте о том, что товар рецептурный</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-is_pko">ПКО</label>
								<div class="col-sm-10">
									<select name="is_pko" id="input-is_pko" class="form-control">
										<?php if ($is_pko) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> препарат предметно-количественного учета</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-is_drug">Наркотик</label>
								<div class="col-sm-10">
									<select name="is_drug" id="input-is_drug" class="form-control">
										<?php if ($is_drug) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> наркотический препарат</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-is_preorder">Под заказ</label>
								<div class="col-sm-10">
									<select name="is_preorder" id="input-is_preorder" class="form-control">
										<?php if ($is_preorder) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-is_thermolabel">Термолабильный</label>
								<div class="col-sm-10">
									<select name="is_thermolabel" id="input-is_thermolabel" class="form-control">
										<?php if ($is_thermolabel) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> уведомление на сайте о том, что товар требует особых условий доставки</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-bestseller">Хит продаж</label>
								<div class="col-sm-10">
									<select name="bestseller" id="input-bestseller" class="form-control">
										<?php if ($bestseller) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
									<span class="help"><i class="fa fa-info-circle"></i> для ускоренного вычисления хитов продаж, вместо пересканирования в каталоге</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sku"><span data-toggle="tooltip" title="<?php echo $help_sku; ?>"><?php echo $entry_sku; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="sku" value="<?php echo $sku; ?>" placeholder="<?php echo $entry_sku; ?>" id="input-sku" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-upc"><span data-toggle="tooltip" title="<?php echo $help_upc; ?>"><?php echo $entry_upc; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="upc" value="<?php echo $upc; ?>" placeholder="<?php echo $entry_upc; ?>" id="input-upc" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-ean"><span data-toggle="tooltip" title="<?php echo $help_ean; ?>"><?php echo $entry_ean; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="ean" value="<?php echo $ean; ?>" placeholder="<?php echo $entry_ean; ?>" id="input-ean" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-jan"><span data-toggle="tooltip" title="<?php echo $help_jan; ?>"><?php echo $entry_jan; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="jan" value="<?php echo $jan; ?>" placeholder="<?php echo $entry_jan; ?>" id="input-jan" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-isbn"><span data-toggle="tooltip" title="<?php echo $help_isbn; ?>"><?php echo $entry_isbn; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="isbn" value="<?php echo $isbn; ?>" placeholder="<?php echo $entry_isbn; ?>" id="input-isbn" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-mpn"><span data-toggle="tooltip" title="<?php echo $help_mpn; ?>"><?php echo $entry_mpn; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="mpn" value="<?php echo $mpn; ?>" placeholder="<?php echo $entry_mpn; ?>" id="input-mpn" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-location"><?php echo $entry_location; ?></label>
								<div class="col-sm-10">
									<input type="text" name="location" value="<?php echo $location; ?>" placeholder="<?php echo $entry_location; ?>" id="input-location" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price; ?></label>
								<div class="col-sm-10">
									<input type="text" name="price" value="<?php echo $price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-price_retail">Цена в ритейле</label>
								<div class="col-sm-10">
									<input type="text" name="price_retail" value="<?php echo $price_retail; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price_retail" class="form-control" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
								<div class="col-sm-10">
									<select name="tax_class_id" id="input-tax-class" class="form-control">
										<option value="0"><?php echo $text_none; ?></option>
										<?php foreach ($tax_classes as $tax_class) { ?>
											<?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
												<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tax-class">Ценовая группа</label>
								<div class="col-sm-10">
									<select name="pricegroup_id" id="input-tax-class" class="form-control">
										<option value="0"><?php echo $text_none; ?></option>
										<?php foreach ($pricegroups as $pricegroup) { ?>
											<?php if ($pricegroup['pricegroup_id'] == $pricegroup_id) { ?>
												<option value="<?php echo $pricegroup['pricegroup_id']; ?>" selected="selected"><?php echo $pricegroup['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $pricegroup['pricegroup_id']; ?>"><?php echo $pricegroup['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
								<div class="col-sm-10">
									<input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-minimum"><span data-toggle="tooltip" title="<?php echo $help_minimum; ?>"><?php echo $entry_minimum; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="minimum" value="<?php echo $minimum; ?>" placeholder="<?php echo $entry_minimum; ?>" id="input-minimum" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-subtract"><?php echo $entry_subtract; ?></label>
								<div class="col-sm-10">
									<select name="subtract" id="input-subtract" class="form-control">
										<?php if ($subtract) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-stock-status"><span data-toggle="tooltip" title="<?php echo $help_stock_status; ?>"><?php echo $entry_stock_status; ?></span></label>
								<div class="col-sm-10">
									<select name="stock_status_id" id="input-stock-status" class="form-control">
										<?php foreach ($stock_statuses as $stock_status) { ?>
											<?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
												<option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_shipping; ?></label>
								<div class="col-sm-10">
									<label class="radio-inline">
										<?php if ($shipping) { ?>
											<input type="radio" name="shipping" value="1" checked="checked" />
											<?php echo $text_yes; ?>
											<?php } else { ?>
											<input type="radio" name="shipping" value="1" />
											<?php echo $text_yes; ?>
										<?php } ?>
									</label>
									<label class="radio-inline">
										<?php if (!$shipping) { ?>
											<input type="radio" name="shipping" value="0" checked="checked" />
											<?php echo $text_no; ?>
											<?php } else { ?>
											<input type="radio" name="shipping" value="0" />
											<?php echo $text_no; ?>
										<?php } ?>
									</label>
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
								<label class="col-sm-2 control-label" for="input-date-available"><?php echo $entry_date_available; ?></label>
								<div class="col-sm-3">
									<div class="input-group date">
										<input type="text" name="date_available" value="<?php echo $date_available; ?>" placeholder="<?php echo $entry_date_available; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
										<span class="input-group-btn">
											<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
										</span></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-length"><?php echo $entry_dimension; ?></label>
								<div class="col-sm-10">
									<div class="row">
										<div class="col-sm-4">
											<input type="text" name="length" value="<?php echo $length; ?>" placeholder="<?php echo $entry_length; ?>" id="input-length" class="form-control" />
										</div>
										<div class="col-sm-4">
											<input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
										</div>
										<div class="col-sm-4">
											<input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-length-class"><?php echo $entry_length_class; ?></label>
								<div class="col-sm-10">
									<select name="length_class_id" id="input-length-class" class="form-control">
										<?php foreach ($length_classes as $length_class) { ?>
											<?php if ($length_class['length_class_id'] == $length_class_id) { ?>
												<option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-weight"><?php echo $entry_weight; ?></label>
								<div class="col-sm-10">
									<input type="text" name="weight" value="<?php echo $weight; ?>" placeholder="<?php echo $entry_weight; ?>" id="input-weight" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-weight-class"><?php echo $entry_weight_class; ?></label>
								<div class="col-sm-10">
									<select name="weight_class_id" id="input-weight-class" class="form-control">
										<?php foreach ($weight_classes as $weight_class) { ?>
											<?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
												<option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
											<?php } ?>
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
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-10">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-stocks">
							
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<th class="text-left">
											Аптека
										</th>
										<th class="text-left">
											Свободный остаток
										</th>
										<th class="text-left">
											Резерв
										</th>
										<th class="text-left">
											Цена
										</th>
										<th class="text-left">
											Ритейл
										</th>
									</thead>
									<? foreach ($stocks as $stock) { ?>																			
										<tr>
											<td class="text-left">
												<? echo $stock['name'] ?>
											</td>
											<td class="text-left">
												<?php if ($stock['quantity']) { ?>
													<span class="btn btn-success"><? echo $stock['quantity'] ?></span>
													<? } else { ?>					  
													<span class="btn btn-danger"><? echo $stock['quantity'] ?></span>
												<? } ?>											
											</td>
											<td class="text-left">
												<?php if (!$stock['reserve']) { ?>
													<span class="btn btn-success"><? echo $stock['reserve'] ?></span>
													<? } else { ?>					  
													<span class="btn btn-danger"><? echo $stock['reserve'] ?></span>
												<? } ?>		
											</td>
											<td class="text-left">
												<? echo $stock['price'] ?>
											</td>
											<td class="text-left">
												<? echo $stock['price_retail'] ?>
											</td>
										</tr>
									<? } ?>
								</table>
							</div>
							
							<?php if ($social_child) { ?>
								<div class="form-group">
									<div class="col-sm-12 text-info">
										<h3><i class="fa fa-info-circle"></i> Товар участвует в социальной программе <kbd><?php echo $social_child['social_program']; ?></kbd></h3>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<th class="text-left">
												
											</th>
											<th class="text-left">
												Аптека
											</th>
											<th class="text-left">
												Свободный остаток
											</th>
											<th class="text-left">
												Резерв
											</th>
											<th class="text-left">
												Цена
											</th>
										</thead>
										<? foreach ($social_child_stocks as $social_child_stock) { ?>																			
											<tr>
												<td class="text-left text-info">
													<i class="fa fa-info-circle"></i> <?php echo $social_child['social_program']; ?>
												</td>
												<td class="text-left text-info">
													<? echo $social_child_stock['name'] ?>
												</td>
												<td class="text-left text-info">
													<?php if ($social_child_stock['quantity']) { ?>
														<span class="btn btn-success"><? echo $social_child_stock['quantity'] ?></span>
														<? } else { ?>					  
														<span class="btn btn-danger"><? echo $social_child_stock['quantity'] ?></span>
													<? } ?>											
												</td>
												<td class="text-left text-info">
													<?php if (!$social_child_stock['reserve']) { ?>
														<span class="btn btn-success"><? echo $social_child_stock['reserve'] ?></span>
														<? } else { ?>					  
														<span class="btn btn-danger"><? echo $social_child_stock['reserve'] ?></span>
													<? } ?>		
												</td>
												<td class="text-left text-info">
													<? echo $social_child_stock['price'] ?>
												</td>
											</tr>
										<? } ?>
									</table>
								</div>
							<? } ?>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-social_program">Социальная программа</label>
								<div class="col-sm-10">
									<input type="text" name="social_program" value="<?php echo $social_program; ?>" placeholder="Социальная программа" id="input-social_program" class="form-control" />
									<span class="help"><i class="fa fa-info-circle"></i> эта карточка описывает условия социальной программы</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-social_parent_id">Основной товар соцпрограммы</label>
								<div class="col-sm-10">
									<input type="text" name="social_parent_id" value="<?php echo $social_parent_id; ?>" placeholder="Основной товар соцпрограммы" id="input-social_parent_id" class="form-control" />
									<span class="help"><i class="fa fa-info-circle"></i> айдишка основного товара социальной программы</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-social_parent_uuid">Основной товар соцпрограммы</label>
								<div class="col-sm-10">
									<input type="text" name="social_parent_uuid" value="<?php echo $social_parent_uuid; ?>" placeholder="UUID основного товара соцпрограммы" id="input-social_parent_uuid" class="form-control" />
									<span class="help"><i class="fa fa-info-circle"></i> UUID основного товара социальной программы</span>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-has_dl_price">Участник "Доступні ліки"</label>
								<div class="col-sm-10">
									<select name="input-has_dl_price" id="input-has_dl_price" class="form-control">
										<?php if ($has_dl_price) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>									
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-social_parent_uuid">Ціна "Доступні ліки"</label>
								<div class="col-sm-10">
									<input type="text" name="dl_price" value="<?php echo $dl_price; ?>" placeholder="Ціна Доступні ліки" id="input-dl_price" class="form-control" />							
								</div>
							</div>
							
						</div>
						<div class="tab-pane" id="tab-links">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-manufacturer"><span data-toggle="tooltip" title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="manufacturer" value="<?php echo $manufacturer; ?>" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer" class="form-control" />
									<input type="hidden" name="manufacturer_id" value="<?php echo $manufacturer_id; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-category">Основная категория</label>
								<div class="col-sm-10">
									<select id="main_category_id" name="main_category_id" class="form-control">
										<option value="0" selected="selected"><?php echo $text_none; ?></option>
										<?php foreach($product_categories as $category) { ?>
											<?php if($category['category_id'] == $main_category_id) { ?>
												<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-collection">Основная коллекция</label>
								<div class="col-sm-10">
									<select id="main_collection_id" name="main_collection_id" class="form-control">
										<option value="0" selected="selected"><?php echo $text_none; ?></option>
										<?php foreach($collections as $collection) { ?>
											<?php if($collection['collection_id'] == $main_collection_id) { ?>
												<option value="<?php echo $collection['collection_id']; ?>" selected="selected"><?php echo $collection['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $collection['collection_id']; ?>"><?php echo $collection['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-collection">Коллекции</label>
								<div class="col-sm-10">
									<div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
										<table class="table table-striped">
											<?php foreach ($collections as $collection) { ?>
												<tr>
													<td class="checkbox">
														<label>
															<?php if (in_array($collection['collection_id'], $product_collection)) { ?>
																<input type="checkbox" name="product_collection[]" value="<?php echo $collection['collection_id']; ?>" checked="checked" />
																<?php echo $collection['name']; ?>
																<?php } else { ?>
																<input type="checkbox" name="product_collection[]" value="<?php echo $collection['collection_id']; ?>" />
																<?php echo $collection['name']; ?>
															<?php } ?>
														</label>
													</td>
												</tr>
											<?php } ?>
										</table>
									</div>
								<a onclick="$(this).parent().find(':checkbox').prop('checked', true);">выбрать все</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">снять выделение</a></div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-socialprogram">Основная социальная программа</label>
								<div class="col-sm-10">
									<select id="main_socialprogram_id" name="main_socialprogram_id" class="form-control">
										<option value="0" selected="selected"><?php echo $text_none; ?></option>
										<?php foreach($socialprograms as $socialprogram) { ?>
											<?php if($socialprogram['socialprogram_id'] == $main_socialprogram_id) { ?>
												<option value="<?php echo $socialprogram['socialprogram_id']; ?>" selected="selected"><?php echo $socialprogram['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $socialprogram['socialprogram_id']; ?>"><?php echo $socialprogram['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-socialprogram">Социальные программы</label>
								<div class="col-sm-10">
									<div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
										<table class="table table-striped">
											<?php foreach ($socialprograms as $socialprogram) { ?>
												<tr>
													<td class="checkbox">
														<label>
															<?php if (in_array($socialprogram['socialprogram_id'], $product_socialprogram)) { ?>
																<input type="checkbox" name="product_socialprogram[]" value="<?php echo $socialprogram['socialprogram_id']; ?>" checked="checked" />
																<?php echo $socialprogram['name']; ?>
																<?php } else { ?>
																<input type="checkbox" name="product_socialprogram[]" value="<?php echo $socialprogram['socialprogram_id']; ?>" />
																<?php echo $socialprogram['name']; ?>
															<?php } ?>
														</label>
													</td>
												</tr>
											<?php } ?>
										</table>
									</div>
								<a onclick="$(this).parent().find(':checkbox').prop('checked', true);">выбрать все</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">снять выделение</a></div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
									<div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_categories as $product_category) { ?>
											<div id="product-category<?php echo $product_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
												<input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip" title="<?php echo $help_filter; ?>"><?php echo $entry_filter; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="filter" value="" placeholder="<?php echo $entry_filter; ?>" id="input-filter" class="form-control" />
									<div id="product-filter" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_filters as $product_filter) { ?>
											<div id="product-filter<?php echo $product_filter['filter_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_filter['name']; ?>
												<input type="hidden" name="product_filter[]" value="<?php echo $product_filter['filter_id']; ?>" />
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
												<?php if (in_array(0, $product_store)) { ?>
													<input type="checkbox" name="product_store[]" value="0" checked="checked" />
													<?php echo $text_default; ?>
													<?php } else { ?>
													<input type="checkbox" name="product_store[]" value="0" />
													<?php echo $text_default; ?>
												<?php } ?>
											</label>
										</div>
										<?php foreach ($stores as $store) { ?>
											<div class="checkbox">
												<label>
													<?php if (in_array($store['store_id'], $product_store)) { ?>
														<input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
														<?php echo $store['name']; ?>
														<?php } else { ?>
														<input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" />
														<?php echo $store['name']; ?>
													<?php } ?>
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-primenenie"><span data-toggle="tooltip" title="Применение">Применение</span></label>
								<div class="col-sm-10">
									<input type="text" name="primenenie" value="" placeholder="Привязать статьи по Применению" id="input-primenenie" class="form-control" />
									<div id="product-primenenie" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_primenenie as $primenenie) { ?>
											<div id="product-primenenie<?php echo $primenenie['simple_blog_article_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $primenenie['primenenie'].' -> '.$primenenie['article_title']; ?>
												<input type="hidden" name="primenenie[]" value="<?php echo $primenenie['simple_blog_article_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-tags"><span data-toggle="tooltip" title="Теги">Теги</span></label>
								<div class="col-sm-10">
									<input type="text" name="tags" value="" placeholder="Привязать статьи по Тегам" id="input-tags" class="form-control" />
									<div id="product-tags" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_tags as $tags) { ?>
											<div id="product-tags<?php echo $tags['simple_blog_article_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $tags['tags'].' -> '.$tags['article_title']; ?>
												<input type="hidden" name="tags[]" value="<?php echo $tags['simple_blog_article_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-download"><span data-toggle="tooltip" title="<?php echo $help_download; ?>"><?php echo $entry_download; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="download" value="" placeholder="<?php echo $entry_download; ?>" id="input-download" class="form-control" />
									<div id="product-download" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_downloads as $product_download) { ?>
											<div id="product-download<?php echo $product_download['download_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_download['name']; ?>
												<input type="hidden" name="product_download[]" value="<?php echo $product_download['download_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-same">
							
							<div class="alert alert-success">Описание упаковки</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-name_of_part">Часть упаковки</label>
								<div class="col-sm-10">
									<input type="text" name="name_of_part" value="<?php echo $name_of_part; ?>" placeholder="Часть упаковки" id="input-name_of_part" class="form-control" />
									<span class="help"><i class="fa fa-info-circle"></i> название части упаковки: блистер, ампула, пакетик</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-count_of_parts">Количество частей в упаковке</label>
								<div class="col-sm-10">
									<input type="text" name="count_of_parts" value="<?php echo $count_of_parts; ?>" placeholder="1" id="input-count_of_parts" class="form-control" />									
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-uuid_of_part">UUID части упаковки</label>
								<div class="col-sm-10">
									<input type="text" name="uuid_of_part" value="<?php echo $uuid_of_part; ?>" placeholder="Часть упаковки" id="input-uuid_of_part" class="form-control" />									
								</div>
							</div>
							
							<div class="alert alert-success">Аналоги и дозировки - ручное назначение товаров</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-same"><span data-toggle="tooltip" title="<?php echo $help_same; ?>"><?php echo $entry_same; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="same" value="" placeholder="<?php echo $entry_same; ?>" id="input-same" class="form-control" />
									<div id="product-same" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_sames as $product_same) { ?>
											<div id="product-same<?php echo $product_same['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_same['name']; ?>
												<input type="hidden" name="product_same[]" value="<?php echo $product_same['product_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-analog"><span data-toggle="tooltip" title="<?php echo $help_analog; ?>"><?php echo $entry_analog; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="analog" value="" placeholder="<?php echo $entry_analog; ?>" id="input-analog" class="form-control" />
									<div id="product-analog" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_analogs as $product_analog) { ?>
											<div id="product-analog<?php echo $product_analog['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_analog['name']; ?>
												<input type="hidden" name="product_analog[]" value="<?php echo $product_analog['product_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-light">Безрецептурные аналоги</label>
								<div class="col-sm-10">
									<input type="text" name="light" value="" placeholder="<?php echo $entry_light; ?>" id="input-light" class="form-control" />
									<div id="product-light" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_lights as $product_light) { ?>
											<div id="product-light<?php echo $product_light['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_light['name']; ?>
												<input type="hidden" name="product_light[]" value="<?php echo $product_light['product_id']; ?>" />
											</div>
										<?php } ?>
									</div>									
									<?php if ($no_payment || $no_shipping || $is_receipt) { ?>
										<div><span class="text-info"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> этот препарат является рецептурным, либо включена невозможность оплаты и доставки. было бы неплохо добавить препараты, которые имеют сходное действие, но при этом продаются без рецепта</span></div>
									<?php } ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-related"><span data-toggle="tooltip" title="<?php echo $help_related; ?>"><?php echo $entry_related; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control" />
									<div id="product-related" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($product_relateds as $product_related) { ?>
											<div id="product-related<?php echo $product_related['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_related['name']; ?>
												<input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-attribute">
							<div class="table-responsive">
								<table id="attribute" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_attribute; ?></td>
											<td class="text-left"><?php echo $entry_text; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php $attribute_row = 0; ?>
										<?php foreach ($product_attributes as $product_attribute) { ?>
											<tr id="attribute-row<?php echo $attribute_row; ?>">
												<td class="text-left" style="width: 40%;"><input type="text" name="product_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $product_attribute['name']; ?>" placeholder="<?php echo $entry_attribute; ?>" class="form-control" />
												<input type="hidden" name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $product_attribute['attribute_id']; ?>" /></td>
												<td class="text-left"><?php foreach ($languages as $language) { ?>
													<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
														<textarea name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"><?php echo isset($product_attribute['product_attribute_description'][$language['language_id']]) ? $product_attribute['product_attribute_description'][$language['language_id']]['text'] : ''; ?></textarea>
													</div>
												<?php } ?></td>
												<td class="text-left"><button type="button" onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
											</tr>
											<?php $attribute_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2"></td>
											<td class="text-left"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="<?php echo $button_attribute_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="tab-option">
							<div class="row">
								<div class="col-sm-2">
									<ul class="nav nav-pills nav-stacked" id="option">
										<?php $option_row = 0; ?>
										<?php foreach ($product_options as $product_option) { ?>
											<li><a href="#tab-option<?php echo $option_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-option<?php echo $option_row; ?>\']').parent().remove(); $('#tab-option<?php echo $option_row; ?>').remove(); $('#option a:first').tab('show');"></i> <?php echo $product_option['name']; ?></a></li>
											<?php $option_row++; ?>
										<?php } ?>
										<li>
											<input type="text" name="option" value="" placeholder="<?php echo $entry_option; ?>" id="input-option" class="form-control" />
										</li>
									</ul>
								</div>
								<div class="col-sm-10">
									<div class="tab-content">
										<?php $option_row = 0; ?>
										<?php $option_value_row = 0; ?>
										<?php foreach ($product_options as $product_option) { ?>
											<div class="tab-pane" id="tab-option<?php echo $option_row; ?>">
												<input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_id]" value="<?php echo $product_option['product_option_id']; ?>" />
												<input type="hidden" name="product_option[<?php echo $option_row; ?>][name]" value="<?php echo $product_option['name']; ?>" />
												<input type="hidden" name="product_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" />
												<input type="hidden" name="product_option[<?php echo $option_row; ?>][type]" value="<?php echo $product_option['type']; ?>" />
												<div class="form-group">
													<label class="col-sm-2 control-label" for="input-required<?php echo $option_row; ?>"><?php echo $entry_required; ?></label>
													<div class="col-sm-10">
														<select name="product_option[<?php echo $option_row; ?>][required]" id="input-required<?php echo $option_row; ?>" class="form-control">
															<?php if ($product_option['required']) { ?>
																<option value="1" selected="selected"><?php echo $text_yes; ?></option>
																<option value="0"><?php echo $text_no; ?></option>
																<?php } else { ?>
																<option value="1"><?php echo $text_yes; ?></option>
																<option value="0" selected="selected"><?php echo $text_no; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<?php if ($product_option['type'] == 'text') { ?>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
														<div class="col-sm-10">
															<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
														</div>
													</div>
												<?php } ?>
												<?php if ($product_option['type'] == 'textarea') { ?>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
														<div class="col-sm-10">
															<textarea name="product_option[<?php echo $option_row; ?>][value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control"><?php echo $product_option['value']; ?></textarea>
														</div>
													</div>
												<?php } ?>
												<?php if ($product_option['type'] == 'file') { ?>
													<div class="form-group" style="display: none;">
														<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
														<div class="col-sm-10">
															<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
														</div>
													</div>
												<?php } ?>
												<?php if ($product_option['type'] == 'date') { ?>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
														<div class="col-sm-3">
															<div class="input-group date">
																<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value<?php echo $option_row; ?>" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
																</span></div>
														</div>
													</div>
												<?php } ?>
												<?php if ($product_option['type'] == 'time') { ?>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
														<div class="col-sm-10">
															<div class="input-group time">
																<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
																<span class="input-group-btn">
																	<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
																</span></div>
														</div>
													</div>
												<?php } ?>
												<?php if ($product_option['type'] == 'datetime') { ?>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
														<div class="col-sm-10">
															<div class="input-group datetime">
																<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
																<span class="input-group-btn">
																	<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
																</span></div>
														</div>
													</div>
												<?php } ?>
												<?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
													<div class="table-responsive">
														<table id="option-value<?php echo $option_row; ?>" class="table table-striped table-bordered table-hover">
															<thead>
																<tr>
																	<td class="text-left"><?php echo $entry_option_value; ?></td>
																	<td class="text-right"><?php echo $entry_quantity; ?></td>
																	<td class="text-left"><?php echo $entry_subtract; ?></td>
																	<td class="text-right"><?php echo $entry_price; ?></td>
																	<td class="text-right"><?php echo $entry_option_points; ?></td>
																	<td class="text-right"><?php echo $entry_weight; ?></td>
																	<td></td>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
																	<tr id="option-value-row<?php echo $option_value_row; ?>">
																		<td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][option_value_id]" class="form-control">
																			<?php if (isset($option_values[$product_option['option_id']])) { ?>
																				<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
																					<?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
																						<option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
																						<?php } else { ?>
																						<option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
																					<?php } ?>
																				<?php } ?>
																			<?php } ?>
																		</select>
																		<input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id']; ?>" /></td>
																		<td class="text-right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
																		<td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" class="form-control">
																			<?php if ($product_option_value['subtract']) { ?>
																				<option value="1" selected="selected"><?php echo $text_yes; ?></option>
																				<option value="0"><?php echo $text_no; ?></option>
																				<?php } else { ?>
																				<option value="1"><?php echo $text_yes; ?></option>
																				<option value="0" selected="selected"><?php echo $text_no; ?></option>
																			<?php } ?>
																		</select></td>
																		<td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price_prefix]" class="form-control">
																			<?php if ($product_option_value['price_prefix'] == '+') { ?>
																				<option value="+" selected="selected">+</option>
																				<?php } else { ?>
																				<option value="+">+</option>
																			<?php } ?>
																			<?php if ($product_option_value['price_prefix'] == '-') { ?>
																				<option value="-" selected="selected">-</option>
																				<?php } else { ?>
																				<option value="-">-</option>
																			<?php } ?>
																		</select>
																		<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
																		<td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points_prefix]" class="form-control">
																			<?php if ($product_option_value['points_prefix'] == '+') { ?>
																				<option value="+" selected="selected">+</option>
																				<?php } else { ?>
																				<option value="+">+</option>
																			<?php } ?>
																			<?php if ($product_option_value['points_prefix'] == '-') { ?>
																				<option value="-" selected="selected">-</option>
																				<?php } else { ?>
																				<option value="-">-</option>
																			<?php } ?>
																		</select>
																		<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $product_option_value['points']; ?>" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>
																		<td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight_prefix]" class="form-control">
																			<?php if ($product_option_value['weight_prefix'] == '+') { ?>
																				<option value="+" selected="selected">+</option>
																				<?php } else { ?>
																				<option value="+">+</option>
																			<?php } ?>
																			<?php if ($product_option_value['weight_prefix'] == '-') { ?>
																				<option value="-" selected="selected">-</option>
																				<?php } else { ?>
																				<option value="-">-</option>
																			<?php } ?>
																		</select>
																		<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $product_option_value['weight']; ?>" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>
																		<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#option-value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
																	</tr>
																	<?php $option_value_row++; ?>
																<?php } ?>
															</tbody>
															<tfoot>
																<tr>
																	<td colspan="6"></td>
																	<td class="text-left"><button type="button" onclick="addOptionValue('<?php echo $option_row; ?>');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
																</tr>
															</tfoot>
														</table>
													</div>
													<select id="option-values<?php echo $option_row; ?>" style="display: none;">
														<?php if (isset($option_values[$product_option['option_id']])) { ?>
															<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
																<option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
															<?php } ?>
														<?php } ?>
													</select>
												<?php } ?>
											</div>
											<?php $option_row++; ?>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-recurring">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_recurring; ?></td>
											<td class="text-left"><?php echo $entry_customer_group; ?></td>
											<td class="text-left"></td>
										</tr>
									</thead>
									<tbody>
										<?php $recurring_row = 0; ?>
										<?php foreach ($product_recurrings as $product_recurring) { ?>
											
											<tr id="recurring-row<?php echo $recurring_row; ?>">
												<td class="text-left"><select name="product_recurring[<?php echo $recurring_row; ?>][recurring_id]" class="form-control">
													<?php foreach ($recurrings as $recurring) { ?>
														<?php if ($recurring['recurring_id'] == $product_recurring['recurring_id']) { ?>
															<option value="<?php echo $recurring['recurring_id']; ?>" selected="selected"><?php echo $recurring['name']; ?></option>
															<?php } else { ?>
															<option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select></td>
												<td class="text-left"><select name="product_recurring[<?php echo $recurring_row; ?>][customer_group_id]" class="form-control">
													<?php foreach ($customer_groups as $customer_group) { ?>
														<?php if ($customer_group['customer_group_id'] == $product_recurring['customer_group_id']) { ?>
															<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
															<?php } else { ?>
															<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select></td>
												<td class="text-left"><button type="button" onclick="$('#recurring-row<?php echo $recurring_row; ?>').remove()" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
											</tr>
											<?php $recurring_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2"></td>
											<td class="text-left"><button type="button" onclick="addRecurring()" data-toggle="tooltip" title="<?php echo $button_recurring_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="tab-discount">
							<div class="table-responsive">
								<table id="discount" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_customer_group; ?></td>
											<td class="text-right"><?php echo $entry_quantity; ?></td>
											<td class="text-right"><?php echo $entry_priority; ?></td>
											<td class="text-right"><?php echo $entry_price; ?></td>
											<td class="text-left"><?php echo $entry_date_start; ?></td>
											<td class="text-left"><?php echo $entry_date_end; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php $discount_row = 0; ?>
										<?php foreach ($product_discounts as $product_discount) { ?>
											<tr id="discount-row<?php echo $discount_row; ?>">
												<td class="text-left"><select name="product_discount[<?php echo $discount_row; ?>][customer_group_id]" class="form-control">
													<?php foreach ($customer_groups as $customer_group) { ?>
														<?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
															<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
															<?php } else { ?>
															<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select></td>
												<td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $product_discount['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
												<td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $product_discount['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>
												<td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $product_discount['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
												<td class="text-left" style="width: 20%;"><div class="input-group date">
													<input type="text" name="product_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $product_discount['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
													<span class="input-group-btn">
														<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
													</span></div></td>
													<td class="text-left" style="width: 20%;"><div class="input-group date">
														<input type="text" name="product_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $product_discount['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
														<span class="input-group-btn">
															<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
														</span></div></td>
														<td class="text-left"><button type="button" onclick="$('#discount-row<?php echo $discount_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
											</tr>
											<?php $discount_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6"></td>
											<td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_discount_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="tab-special">
							<div class="table-responsive">
								<table id="special" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_customer_group; ?></td>
											<td class="text-right"><?php echo $entry_priority; ?></td>
											<td class="text-right">Цена / процент</td>
											<td class="text-right">Тип скидки</td>	
											<td class="text-left"><?php echo $entry_date_start; ?></td>
											<td class="text-left"><?php echo $entry_date_end; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php $special_row = 0; ?>
										<?php foreach ($product_specials as $product_special) { ?>
											<tr id="special-row<?php echo $special_row; ?>">
												<td class="text-left"><select name="product_special[<?php echo $special_row; ?>][customer_group_id]" class="form-control">
													<?php foreach ($customer_groups as $customer_group) { ?>
														<?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
															<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
															<?php } else { ?>
															<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select>
												</td>
												<td class="text-right"><input type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>
												<td class="text-right"><input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
												<td class="text-left">
													<select class="form-control" name="product_special[<?php echo $special_row; ?>][type]">
														<? if ($product_special['type'] == "%") { ?>
															<option value="=">=</option>
															<option value="%"  selected="selected">%</option>
															<? } else { ?>
															<option value="=" selected="selected">=</option>
															<option value="%">%</option>
														<? } ?>
													</select>
												</td>
												<td class="text-left" style="width: 20%;"><div class="input-group date">
													<input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
													<span class="input-group-btn">
														<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
													</span></div></td>
													<td class="text-left" style="width: 20%;"><div class="input-group date">
														<input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
														<span class="input-group-btn">
															<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
														</span></div></td>
														<td class="text-left"><button type="button" onclick="$('#special-row<?php echo $special_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
											</tr>
											<?php $special_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6"></td>
											<td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_special_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="tab-image">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_image; ?></td>
											<td></td>
										</tr>
									</thead>
									
									<tbody>
										<tr>
											<td class="text-left"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" /></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="table-responsive">
								<table id="images" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_additional_image; ?></td>
											<td class="text-right"><?php echo $entry_sort_order; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php $image_row = 0; ?>
										<?php foreach ($product_images as $product_image) { ?>
											<tr id="image-row<?php echo $image_row; ?>">
												<td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $product_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
												<td class="text-right"><input type="text" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
												<td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
											</tr>
											<?php $image_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2"></td>
											<td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<td class="text-center">
										<input type="text" value="<?php echo isset($product_description[2]) ? $product_description[2]['name'] : ''; ?>" id="input-image-search-text" class="form-control" />
									</td>
									<td class="text-center">
										
										<button type="button" onclick="searchForImage();" data-toggle="tooltip" title="" class="btn btn-primary">
											Искать картинки	
										</button>	
										
										<script>	
											function initImageSearchActions(){
												$('.btn-image-search-use').click(function(){
													var idx = $(this).attr('data-for-idx');
													var media = $('#img-search-real-url-' + idx).attr('data-real-url');												
													
													$.ajax({
														url: 'index.php?route=eapteka/imagesearch/updateProductImage&token=<?php echo $token; ?>',
														data : {
															product_id : <? echo $product_id; ?>,
															media : media
														},
														type : 'POST',
														dataType: 'json',
														success: function(json) {
															$('#input-image').val(json.image);
															$('#thumb-image > img').attr('src', json.thumb);
															console.log(json);
														},
														error : function(json){
															console.log(json);
														}
													});
												});
											}
											function searchForImage(){
												var searchtext = $('#input-image-search-text').val();
												
												$.ajax({
													url: 'index.php?route=eapteka/imagesearch/getQwantImages&token=<?php echo $token; ?>',
													type : 'POST',
													data : {
														product_id : <? echo $product_id; ?>,
														searchtext: searchtext
													},
													dataType: 'html',
													success: function(html) {
														$('#search-image-result').html(html);
														initImageSearchActions();
													},
													beforeSend: function(){
														$('#search-image-result').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
													},
													error : function(html){
														console.log(html);
													}
												});										
											}
										</script>	
									</td>
								</table>
							</div>
							<div class="row text-center" id="search-image-result">
								
							</div>
						</div>
						<div class="tab-pane" id="tab-reward">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-points"><span data-toggle="tooltip" title="<?php echo $help_points; ?>"><?php echo $entry_points; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="points" value="<?php echo $points; ?>" placeholder="<?php echo $entry_points; ?>" id="input-points" class="form-control" />
								</div>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_customer_group; ?></td>
											<td class="text-right"><?php echo $entry_reward; ?></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($customer_groups as $customer_group) { ?>
											<tr>
												<td class="text-left"><?php echo $customer_group['name']; ?></td>
												<td class="text-right"><input type="text" name="product_reward[<?php echo $customer_group['customer_group_id']; ?>][points]" value="<?php echo isset($product_reward[$customer_group['customer_group_id']]) ? $product_reward[$customer_group['customer_group_id']]['points'] : ''; ?>" class="form-control" /></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- XD Stickers start -->
						<div class="tab-pane" id="tab-xdstickers">
							<div class="table-responsive">
								<div class="form-group" style="margin: 0px">
									<label class="col-sm-2 control-label" for="input-xdstickers"><?php echo $entry_xdstickers; ?></label>
									<div class="col-sm-10">
										<div class="well well-sm" style="height: 150px; overflow: auto;">
											<?php foreach ($xdstickers as $xdsticker) { ?>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="xdstickers[][xdsticker_id]" value="<?php echo $xdsticker['xdsticker_id'];?>" <?php echo (array_search($xdsticker['xdsticker_id'], $xdstickers_product) !== false? "checked": "");?> /> <?php echo $xdsticker['name']; ?>
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- XD Stickers start -->
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
											<td class="text-left"><select name="product_layout[0]" class="form-control">
												<option value=""></option>
												<?php foreach ($layouts as $layout) { ?>
													<?php if (isset($product_layout[0]) && $product_layout[0] == $layout['layout_id']) { ?>
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
												<td class="text-left"><select name="product_layout[<?php echo $store['store_id']; ?>]" class="form-control">
													<option value=""></option>
													<?php foreach ($layouts as $layout) { ?>
														<?php if (isset($product_layout[$store['store_id']]) && $product_layout[$store['store_id']] == $layout['layout_id']) { ?>
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
					</div>
				</form>
			</div>
		</div>
	</div>
	<? /* 
		<script type="text/javascript" src="view/javascript/tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
		
		function elFinderBrowser (callback, value, meta) {
		try {
		var fm = $('<div/>').dialogelfinder({
		url : 'index.php?route=common/elfinder/connector&token=' + getURLVar('token'),
		lang : 'ru',
		width : 900,
		height: 400,
		destroyOnClose : true,
		getFileCallback : function(file, fm) {
		var info = file.name + ' (' + fm.formatSize(file.size) + ')';
		callback(file.url, {alt: info});
		},
		commandsOptions : {
		getfile : {
		oncomplete : 'close',
		multiple : false,
		folders : false
		}
		}
		}).dialogelfinder('instance');
		} catch (err) {
		$('#filePickerError').modal('show');
		$.ajax({
		url: 'index.php?route=common/filemanager&token=' + getURLVar('token'),
		dataType: 'html',
		beforeSend: function() {
		$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
		$('#button-image').prop('disabled', true);
		},
		complete: function() {
		$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
		$('#button-image').prop('disabled', false);
		},
		success: function(html) {
		$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
		
		$('#modal-image').modal('show');
		
		$('#modal-image').delegate('a.thumbnail', 'click', function(e) {
		e.preventDefault();
		
		//$(element).summernote('insertImage', $(this).attr('href'));
		callback($(this).attr('href'));							
		$('#modal-image').modal('hide');
		});
		}
		});
		}
		return false;
		}
		tinymce.init({
		selector: '.summernote',
		skin: 'bootstrap',
		language: 'ru',
		height:300,
		image_title: true,
		automatic_uploads: true,
		file_picker_types: 'image',
		file_picker_callback : elFinderBrowser,
		
		
		plugins: [
		'advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker',
		'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		'save table contextmenu directionality emoticons template paste textcolor colorpicker'
		],
		toolbar: 'bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code',
		fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
		});
		
		</script>
		<style>
		#modal-image{
		z-index: 99999;
		}
		</style>
	*/ ?>	
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet">
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
	<script type="text/javascript"><!--
		// Manufacturer
		$('input[name=\'manufacturer\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							manufacturer_id: 0,
							name: '<?php echo $text_none; ?>'
						});
						
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
				$('input[name=\'manufacturer\']').val(item['label']);
				$('input[name=\'manufacturer_id\']').val(item['value']);
			}
		});
		
		// Category
		$('input[name=\'category\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
				$('input[name=\'category\']').val('');
				
				$('#product-category' + item['value']).remove();
				
				$('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');
				
				if ($('#main_category_id option[value="' + item['value'] + '"]').length == 0) {
					$('#main_category_id').append('<option value="' + item['value'] + '">' + item['label'] + '</option>');
				}
			}
		});
		
		$('#product-category').delegate('.fa-minus-circle', 'click', function() {
			var category_id = $(this).parent().find('input[name="product_category\\[\\]"]').val();
			$('#main_category_id option[value="' + category_id + '"]').remove();
			$(this).parent().remove();
		});
		
		// Filter
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
				
				$('#product-filter' + item['value']).remove();
				
				$('#product-filter').append('<div id="product-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_filter[]" value="' + item['value'] + '" /></div>');
			}
		});
		
		$('#product-filter').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		// Downloads
		$('input[name=\'download\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['download_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'download\']').val('');
				
				$('#product-download' + item['value']).remove();
				
				$('#product-download').append('<div id="product-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_download[]" value="' + item['value'] + '" /></div>');
			}
		});
		
		$('#product-download').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		// Related
		$('input[name=\'related\']').autocomplete({
			'source': function(request, response) {
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
			'select': function(item) {
				$('input[name=\'related\']').val('');
				
				$('#product-related' + item['value']).remove();
				
				$('#product-related').append('<div id="product-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></div>');
			}
		});
		
		$('#product-related').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		// same
		$('input[name=\'same\']').autocomplete({
			'source': function(request, response) {
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
			'select': function(item) {
				$('input[name=\'same\']').val('');
				
				$('#product-same' + item['value']).remove();
				
				$('#product-same').append('<div id="product-same' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_same[]" value="' + item['value'] + '" /></div>');
			}
		});
		
		$('#product-same').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		// analog
		$('input[name=\'analog\']').autocomplete({
			'source': function(request, response) {
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
			'select': function(item) {
				$('input[name=\'analog\']').val('');
				
				$('#product-analog' + item['value']).remove();
				
				$('#product-analog').append('<div id="product-analog' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_analog[]" value="' + item['value'] + '" /></div>');
			}
		});
		
		$('#product-analog').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		// light
		$('input[name=\'light\']').autocomplete({
			'source': function(request, response) {
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
			'select': function(item) {
				$('input[name=\'light\']').val('');
				
				$('#product-light' + item['value']).remove();
				
				$('#product-light').append('<div id="product-light' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_light[]" value="' + item['value'] + '" /></div>');
			}
		});
		
		$('#product-light').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
	//--></script>
	<script type="text/javascript"><!--
		var attribute_row = <?php echo $attribute_row; ?>;
		
		function addAttribute() {
			html  = '<tr id="attribute-row' + attribute_row + '">';
			html += '  <td class="text-left" style="width: 20%;"><input type="text" name="product_attribute[' + attribute_row + '][name]" value="" placeholder="<?php echo $entry_attribute; ?>" class="form-control" /><input type="hidden" name="product_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
			html += '  <td class="text-left">';
			<?php foreach ($languages as $language) { ?>
				html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><textarea name="product_attribute[' + attribute_row + '][product_attribute_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"></textarea></div>';
			<?php } ?>
			html += '  </td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';
			
			$('#attribute tbody').append(html);
			
			attributeautocomplete(attribute_row);
			
			attribute_row++;
		}
		
		function attributeautocomplete(attribute_row) {
			$('input[name=\'product_attribute[' + attribute_row + '][name]\']').autocomplete({
				'source': function(request, response) {
					$.ajax({
						url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
						dataType: 'json',
						success: function(json) {
							response($.map(json, function(item) {
								return {
									category: item.attribute_group,
									label: item.name,
									value: item.attribute_id
								}
							}));
						}
					});
				},
				'select': function(item) {
					$('input[name=\'product_attribute[' + attribute_row + '][name]\']').val(item['label']);
					$('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').val(item['value']);
				}
			});
		}
		
		$('#attribute tbody tr').each(function(index, element) {
			attributeautocomplete(index);
		});
	//--></script>
	<script type="text/javascript"><!--
		var option_row = <?php echo $option_row; ?>;
		
		$('input[name=\'option\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/option/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								category: item['category'],
								label: item['name'],
								value: item['option_id'],
								type: item['type'],
								option_value: item['option_value']
							}
						}));
					}
				});
			},
			'select': function(item) {
				html  = '<div class="tab-pane" id="tab-option' + option_row + '">';
				html += '	<input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
				html += '	<input type="hidden" name="product_option[' + option_row + '][name]" value="' + item['label'] + '" />';
				html += '	<input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + item['value'] + '" />';
				html += '	<input type="hidden" name="product_option[' + option_row + '][type]" value="' + item['type'] + '" />';
				
				html += '	<div class="form-group">';
				html += '	  <label class="col-sm-2 control-label" for="input-required' + option_row + '"><?php echo $entry_required; ?></label>';
				html += '	  <div class="col-sm-10"><select name="product_option[' + option_row + '][required]" id="input-required' + option_row + '" class="form-control">';
				html += '	      <option value="1"><?php echo $text_yes; ?></option>';
				html += '	      <option value="0"><?php echo $text_no; ?></option>';
				html += '	  </select></div>';
				html += '	</div>';
				
				if (item['type'] == 'text') {
					html += '	<div class="form-group">';
					html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
					html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
					html += '	</div>';
				}
				
				if (item['type'] == 'textarea') {
					html += '	<div class="form-group">';
					html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
					html += '	  <div class="col-sm-10"><textarea name="product_option[' + option_row + '][value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control"></textarea></div>';
					html += '	</div>';
				}
				
				if (item['type'] == 'file') {
					html += '	<div class="form-group" style="display: none;">';
					html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
					html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
					html += '	</div>';
				}
				
				if (item['type'] == 'date') {
					html += '	<div class="form-group">';
					html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
					html += '	  <div class="col-sm-3"><div class="input-group date"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '	</div>';
				}
				
				if (item['type'] == 'time') {
					html += '	<div class="form-group">';
					html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
					html += '	  <div class="col-sm-10"><div class="input-group time"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '	</div>';
				}
				
				if (item['type'] == 'datetime') {
					html += '	<div class="form-group">';
					html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
					html += '	  <div class="col-sm-10"><div class="input-group datetime"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '	</div>';
				}
				
				if (item['type'] == 'select' || item['type'] == 'radio' || item['type'] == 'checkbox' || item['type'] == 'image') {
					html += '<div class="table-responsive">';
					html += '  <table id="option-value' + option_row + '" class="table table-striped table-bordered table-hover">';
					html += '  	 <thead>';
					html += '      <tr>';
					html += '        <td class="text-left"><?php echo $entry_option_value; ?></td>';
					html += '        <td class="text-right"><?php echo $entry_quantity; ?></td>';
					html += '        <td class="text-left"><?php echo $entry_subtract; ?></td>';
					html += '        <td class="text-right"><?php echo $entry_price; ?></td>';
					html += '        <td class="text-right"><?php echo $entry_option_points; ?></td>';
					html += '        <td class="text-right"><?php echo $entry_weight; ?></td>';
					html += '        <td></td>';
					html += '      </tr>';
					html += '  	 </thead>';
					html += '  	 <tbody>';
					html += '    </tbody>';
					html += '    <tfoot>';
					html += '      <tr>';
					html += '        <td colspan="6"></td>';
					html += '        <td class="text-left"><button type="button" onclick="addOptionValue(' + option_row + ');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
					html += '      </tr>';
					html += '    </tfoot>';
					html += '  </table>';
					html += '</div>';
					
					html += '  <select id="option-values' + option_row + '" style="display: none;">';
					
					for (i = 0; i < item['option_value'].length; i++) {
						html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
					}
					
					html += '  </select>';
					html += '</div>';
				}
				
				$('#tab-option .tab-content').append(html);
				
				$('#option > li:last-child').before('<li><a href="#tab-option' + option_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick=" $(\'#option a:first\').tab(\'show\');$(\'a[href=\\\'#tab-option' + option_row + '\\\']\').parent().remove(); $(\'#tab-option' + option_row + '\').remove();"></i>' + item['label'] + '</li>');
				
				$('#option a[href=\'#tab-option' + option_row + '\']').tab('show');
				
				$('[data-toggle=\'tooltip\']').tooltip({
					container: 'body',
					html: true
				});
				
				$('.date').datetimepicker({
					pickTime: false
				});
				
				$('.time').datetimepicker({
					pickDate: false
				});
				
				$('.datetime').datetimepicker({
					pickDate: true,
					pickTime: true
				});
				
				option_row++;
			}
		});
	//--></script>
	<script type="text/javascript"><!--
		var option_value_row = <?php echo $option_value_row; ?>;
		
		function addOptionValue(option_row) {
			html  = '<tr id="option-value-row' + option_value_row + '">';
			html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]" class="form-control">';
			html += $('#option-values' + option_row).html();
			html += '  </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';
			html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]" class="form-control">';
			html += '    <option value="1"><?php echo $text_yes; ?></option>';
			html += '    <option value="0"><?php echo $text_no; ?></option>';
			html += '  </select></td>';
			html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]" class="form-control">';
			html += '    <option value="+">+</option>';
			html += '    <option value="-">-</option>';
			html += '  </select>';
			html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]" class="form-control">';
			html += '    <option value="+">+</option>';
			html += '    <option value="-">-</option>';
			html += '  </select>';
			html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]" class="form-control">';
			html += '    <option value="+">+</option>';
			html += '    <option value="-">-</option>';
			html += '  </select>';
			html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" rel="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';
			
			$('#option-value' + option_row + ' tbody').append(html);
			$('[rel=tooltip]').tooltip();
			
			option_value_row++;
		}
	//--></script>
	<script type="text/javascript"><!--
		var discount_row = <?php echo $discount_row; ?>;
		
		function addDiscount() {
			html  = '<tr id="discount-row' + discount_row + '">';
			html += '  <td class="text-left"><select name="product_discount[' + discount_row + '][customer_group_id]" class="form-control">';
			<?php foreach ($customer_groups as $customer_group) { ?>
				html += '    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
			<?php } ?>
			html += '  </select></td>';
			html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
			html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
			html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + discount_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';
			
			$('#discount tbody').append(html);
			
			$('.date').datetimepicker({
				pickTime: false
			});
			
			discount_row++;
		}
	//--></script>
	<script type="text/javascript"><!--
		var special_row = <?php echo $special_row; ?>;
		
		function addSpecial() {
			html  = '<tr id="special-row' + special_row + '">';
			html += '  <td class="text-left"><select name="product_special[' + special_row + '][customer_group_id]" class="form-control">';
			<?php foreach ($customer_groups as $customer_group) { ?>
				html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
			<?php } ?>
			html += '  </select></td>';
			html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
			html += '  <td class="text-left"><select class="form-control" name="product_special[' + special_row + '][type]"><option value="=">=</option><option value="%"  selected="selected">%</option></select></td>';
			html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
			html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';
			
			$('#special tbody').append(html);
			
			$('.date').datetimepicker({
				pickTime: false
			});
			
			special_row++;
		}
	//--></script>
	<script type="text/javascript"><!--
		var image_row = <?php echo $image_row; ?>;
		
		function addImage() {
			html  = '<tr id="image-row' + image_row + '">';
			html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';
			
			$('#images tbody').append(html);
			
			image_row++;
		}
	//--></script>
	<script type="text/javascript"><!--
		var recurring_row = <?php echo $recurring_row; ?>;
		
		function addRecurring() {
			html  = '<tr id="recurring-row' + recurring_row + '">';
			html += '  <td class="left">';
			html += '    <select name="product_recurring[' + recurring_row + '][recurring_id]" class="form-control">>';
			<?php foreach ($recurrings as $recurring) { ?>
				html += '      <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>';
			<?php } ?>
			html += '    </select>';
			html += '  </td>';
			html += '  <td class="left">';
			html += '    <select name="product_recurring[' + recurring_row + '][customer_group_id]" class="form-control">>';
			<?php foreach ($customer_groups as $customer_group) { ?>
				html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
			<?php } ?>
			html += '    <select>';
			html += '  </td>';
			html += '  <td class="left">';
			html += '    <a onclick="$(\'#recurring-row' + recurring_row + '\').remove()" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>';
			html += '  </td>';
			html += '</tr>';
			
			$('#tab-recurring table tbody').append(html);
			
			recurring_row++;
		}
	//--></script>
	<script type="text/javascript"><!--
		$('.date').datetimepicker({
			pickTime: false
		});
		
		$('.time').datetimepicker({
			pickDate: false
		});
		
		$('.datetime').datetimepicker({
			pickDate: true,
			pickTime: true
		});
	//--></script>
	<script type="text/javascript"><!--
		$('#language a:first').tab('show');
		$('#option a:first').tab('show');
	//--></script></div>
	
	
	<script>
		// Primenenie
		$('input[name=\'primenenie\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=simple_blog/article/autocomplete&token=<?php echo $token; ?>&article_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						
						console.log(json);
						
						response($.map(json, function(item) {
							return {
								label: item['primenenie']+' -> '+item['name'],
								value: item['simple_blog_article_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'primenenie\']').val('');
				
				$('#product-primenenie' + item['value']).remove();
				
				$('#product-primenenie').append('<div id="product-primenenie' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="primenenie[]" value="' + item['value'] + '" /></div>');
				
			}
		});
		
		$('#product-primenenie').delegate('.fa-minus-circle', 'click', function() {
			var category_id = $(this).parent().find('input[name="primenenie\\[\\]"]').val();
			//$('#main_category_id option[value="' + category_id + '"]').remove();
			$(this).parent().remove();
		});
		
		// Tags
		$('input[name=\'tags\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=simple_blog/article/autocomplete&token=<?php echo $token; ?>&article_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						
						console.log(json);
						
						response($.map(json, function(item) {
							return {
								label: item['tags']+' -> '+item['name'],
								value: item['simple_blog_article_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'tags\']').val('');
				
				$('#product-tags' + item['value']).remove();
				
				$('#product-tags').append('<div id="product-tags' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="tags[]" value="' + item['value'] + '" /></div>');
				
			}
		});
		
		$('#product-tags').delegate('.fa-minus-circle', 'click', function() {
			var category_id = $(this).parent().find('input[name="tags\\[\\]"]').val();
			//$('#main_category_id option[value="' + category_id + '"]').remove();
			$(this).parent().remove();
		});
		
		
	</script>
	
	<?php echo $footer; ?>
		