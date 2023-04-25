<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-location" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-location" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>						
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">

							<div class="form-group">
								<label class="col-sm-2 control-label text-danger" for="input-is_stock">Временно закрыто</label>
								<div class="col-sm-10">
									<select name="temprorary_closed" id="input-temprorary_closed" class="form-control">
										<?php if ($temprorary_closed) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
									<br /><span class="help">Если "включено", то аптека пропадет из списка активных на странице "Аптеки на карте", также будет исключена при выборе на странице заказа</span>
								</div>
							</div>


							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
								<div class="col-sm-10">
									<input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
									<?php if ($error_name) { ?>
										<div class="text-danger"><?php echo $error_name; ?></div>
									<?php } ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-node_id">Точка обмена</label>
								<div class="col-sm-10">
									<select name="node_id" id="input-node_id" class="form-control">
										<option value="0">Не привязывать точку обмена</option>
										
										<? foreach ($nodes as $node) { ?>
											<option value="<? echo $node['node_id']; ?>" <? if ($node['node_id'] == $node_id) { ?>selected="selected"<? } ?>><? echo $node['node_name']; ?></option>	
										<? } ?>
										
									</select>
								</div>
							</div>
							
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-uuid">UUID</label>
								<div class="col-sm-10">
									<input type="text" name="uuid" value="<?php echo $uuid; ?>" placeholder="uuid" id="input-uuid" class="form-control" />				
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-is_stock">Это аптека с наличием</label>
								<div class="col-sm-10">
									<select name="is_stock" id="input-is_stock" class="form-control">
										<?php if ($is_stock) { ?>
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
								<label class="col-sm-2 control-label" for="input-is_stock">Эта аптека может продавать наркотики</label>
								<div class="col-sm-10">
									<select name="can_sell_drugs" id="input-can_sell_drugs" class="form-control">
										<?php if ($can_sell_drugs) { ?>
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
								<label class="col-sm-2 control-label" for="input-default_price">Цена по умолчанию</label>
								<div class="col-sm-10">
									<select name="default_price" id="input-default_price" class="form-control">
										<?php if ($default_price) { ?>
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
								<label class="col-sm-2 control-label" for="input-information_id">Статья с описанием</label>
								<div class="col-sm-10">
									<select name="information_id" id="input-information_id" class="form-control">
										<option value="0">Не привязывать, использовать описание</option>
										
										<? foreach ($informations as $information) { ?>
											<option value="<? echo $information['information_id']; ?>" <? if ($information['information_id'] == $information_id) { ?>selected="selected"<? } ?>><? echo $information['title']; ?></option>	
										<? } ?>
										
									</select>
								</div>
							</div>
							
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-address"><?php echo $entry_address; ?></label>
								<div class="col-sm-10">
									<textarea type="text" name="address" placeholder="<?php echo $entry_address; ?>" rows="5" id="input-address" class="form-control"><?php echo $address; ?></textarea>
									<?php if ($error_address) { ?>
										<div class="text-danger"><?php echo $error_address; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-geocode"><span data-toggle="tooltip" data-container="#content" title="<?php echo $help_geocode; ?>"><?php echo $entry_geocode; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="geocode" value="<?php echo $geocode; ?>" placeholder="<?php echo $entry_geocode; ?>" id="input-geocode" class="form-control" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-gmaps_link">GMAPS LINK</label>
								<div class="col-sm-10">
									<input type="text" name="gmaps_link" value="<?php echo $gmaps_link; ?>" placeholder="https://goo.gl/maps/JQr87emgi6b7Q9ZS6" id="input-gmaps_link" class="form-control" />
								</div>
							</div>

							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
								<div class="col-sm-10">
									<input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
									<?php if ($error_telephone) { ?>
										<div class="text-danger"><?php echo $error_telephone; ?></div>
									<?php  } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-fax">Дополнительный телефон</label>
								<div class="col-sm-10">
									<input type="text" name="fax" value="<?php echo $fax; ?>" placeholder="<?php echo $entry_fax; ?>" id="input-fax" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
								<div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
									<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-open"><span data-toggle="tooltip" data-container="#content" title="<?php echo $help_open; ?>"><?php echo $entry_open; ?></span></label>
								<div class="col-sm-10">
									<textarea name="open" rows="5" placeholder="<?php echo $entry_open; ?>" id="input-open" class="form-control"><?php echo $open; ?></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-open_struct"><span data-toggle="tooltip" data-container="#content" title="<?php echo $help_open; ?>"><?php echo $entry_open; ?>, структурно</span></label>
								<div class="col-sm-10">
									<textarea name="open_struct" rows="5" placeholder="<?php echo $entry_open; ?>" id="input-open_struct" class="form-control"><?php echo $open_struct; ?></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-comment"><span data-toggle="tooltip" data-container="#content" title="<?php echo $help_comment; ?>"><?php echo $entry_comment; ?></span></label>
								<div class="col-sm-10">
									<textarea name="comment" rows="5" placeholder="<?php echo $entry_comment; ?>" id="input-comment" class="form-control"><?php echo $comment; ?></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-delivery_times">Варианты времени доставки</label>
								<div class="col-sm-10">
									<textarea name="delivery_times" rows="5" placeholder="" id="input-delivery_times" class="form-control"><?php echo $delivery_times; ?></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort_order">Сортировка</label>
								<div class="col-sm-10">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="0" id="input-sort_order" class="form-control" />
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-data">
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
												<input type="text" name="location_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($location_description[$language['language_id']]) ? $location_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_name[$language['language_id']])) { ?>
													<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-open<?php echo $language['language_id']; ?>">Открыто</label>
											<div class="col-sm-10">
												<textarea name="location_description[<?php echo $language['language_id']; ?>][open]" id="input-open<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($location_description[$language['language_id']]) ? $location_description[$language['language_id']]['open'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-address<?php echo $language['language_id']; ?>"><?php echo $entry_address; ?></label>
											<div class="col-sm-10">
												<input type="text" name="location_description[<?php echo $language['language_id']; ?>][address]" value="<?php echo isset($location_description[$language['language_id']]) ? $location_description[$language['language_id']]['address'] : ''; ?>" id="input-address<?php echo $language['language_id']; ?>" class="form-control" />											
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-comment<?php echo $language['language_id']; ?>"><?php echo $entry_comment; ?></label>
											<div class="col-sm-10">
												<textarea name="location_description[<?php echo $language['language_id']; ?>][comment]" rows="5" placeholder="" id="input-comment<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($location_description[$language['language_id']]) ? $location_description[$language['language_id']]['comment'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-delivery_times<?php echo $language['language_id']; ?>">Варианты времени доставки</label>
											<div class="col-sm-10">
												<textarea name="location_description[<?php echo $language['language_id']; ?>][delivery_times]" rows="5" placeholder="" id="input-delivery_times<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($location_description[$language['language_id']]) ? $location_description[$language['language_id']]['delivery_times'] : ''; ?></textarea>
											</div>
										</div>
									</div>
								<?php } ?>
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
<script type="text/javascript"><!--
	$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>