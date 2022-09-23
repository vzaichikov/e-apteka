<?php echo $header; ?>
	<style type="text/css">
		label span.grey {
			font-weight: normal;
			color: #808080;
		}
	</style>
<?php echo $column_left; ?>
	<div id="content">
		<div class="page-header">
			<div class="container-fluid">
				<div class="pull-right">
					<button type="submit" form="form-seogen" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
					<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
				</div>
				<h1><?php echo $heading_title; ?></h1>
				<ul class="breadcrumb">
					<?php foreach($breadcrumbs as $breadcrumb) { ?>
						<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="container-fluid">
		<?php if($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
		</div>
		<div class="panel-body">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-seogen" class="form-horizontal">
				<input type="hidden" id="seogen_tab" name="seogen[seogen_tab]" value="<?php echo $seogen['seogen_tab']; ?>">

				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span></label>
					<div class="col-sm-2">
						<select name="seogen_status" id="input-status" class="form-control">
							<?php if($seogen_status) { ?>
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
					<label class="col-sm-2 control-label" for="seogen_language_id"><?php echo $entry_language; ?></label>
					<div class="col-sm-2">
						<select name="seogen[language_id]" id="seogen_language_id" class="form-control">
							<?php foreach($languages as $lang) { ?>
								<option value="<?php echo $lang['language_id'] ?>"><?php echo $lang['name'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="seogen_profile"><?php echo $text_profiles?></label>
					<div class="col-sm-6">
					<div class="row">
					    <div class="col-sm-4">
							<select id="seogen_profile" onchange="changeProfile(this)" class="form-control">
								<option data-id="0" id="profile-0">--</option>
								<?php foreach($profiles as $profile) { ?>
									<option data-id="<?php echo $profile['profile_id'] ?>"
											id="profile-<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-1" style="padding-left: 0;">
							<button onclick="delProfile()" class="btn btn-primary" type="button"><?php echo $text_delete?></button>
						</div>
						<div class="col-sm-4"><input type="text" name="seogen_profile_name" class="form-control"></div>
						<div class="col-sm-1" style="padding-left: 0;">
							<button onclick="addProfile()" class="btn btn-primary" type="button"><?php echo $text_add?></button>
						</div>
					</div>
				</div>
				</div>
				<div class="form-group" id="including">
					<label class="col-sm-1 control-label"><span data-toggle="tooltip"
																title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
					<div class="col-sm-5">
						<div class="well well-sm" style="height: 205px; overflow: auto;">
							<?php $selected_categories = array(); ?>
							<?php foreach($categories as $category) { ?>
								<div>
									<?php if(in_array($category['category_id'], $seogen['only_categories'])) { ?>
										<input type="checkbox" name="seogen[only_categories][]" value="<?php echo $category['category_id']; ?>"
											   checked="checked"/>
										<?php echo $category['name']; ?>
										<?php if(count($selected_categories) < 5) {
											$selected_categories[] = $category['name'];
										} ?>
									<?php } else { ?>
										<input type="checkbox" name="seogen[only_categories][]" value="<?php echo $category['category_id']; ?>"/>
										<?php echo $category['name']; ?>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
					<label class="col-sm-1 control-label"><span data-toggle="tooltip"
																title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
					<div class="col-sm-5">
						<div class="well well-sm" style="height: 205px; overflow: auto;">
							<?php $selected_manufacturers = array(); ?>
							<?php foreach($manufacturers as $manufacturer) { ?>
								<div>
									<?php if(in_array($manufacturer['manufacturer_id'], $seogen['only_manufacturers'])) { ?>
										<input type="checkbox" name="seogen[only_manufacturers][]" value="<?php echo $manufacturer['manufacturer_id']; ?>"
											   checked="checked"/>
										<?php echo $manufacturer['name']; ?>
										<?php if(count($selected_manufacturers) < 5) {
											$selected_manufacturers[] = $manufacturer['name'];
										} ?>
									<?php } else { ?>
										<input type="checkbox" name="seogen[only_manufacturers][]" value="<?php echo $manufacturer['manufacturer_id']; ?>"/>
										<?php echo $manufacturer['name']; ?>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>

				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-categories" data-toggle="tab"><?php echo $tab_categories; ?></a></li>
					<li><a href="#tab-products" data-toggle="tab"><?php echo $tab_products; ?></a></li>
					<li><a href="#tab-manufacturers" data-toggle="tab"><?php echo $tab_manufacturers; ?></a></li>
					<li><a href="#tab-informations" data-toggle="tab"><?php echo $tab_informations; ?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active in" id="tab-categories">

						<div class="form-group row">
							<div class="col-sm-2">
								<button onclick="generate('categories');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
							</div>
							<div class="col-sm-10">
								<div class="col-sm-5"></div>
								<div class="col-sm-1">
									<label><?php echo $entry_overwrite ?></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $text_categories; ?></label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[categories_template]" value="<?php echo $seogen['categories_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_categories_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[categories_overwrite]" <?php if(isset($seogen['categories_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_categories_meta_h1; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[categories_meta_h1_template]" value="<?php echo $seogen['categories_meta_h1_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_categories_meta_h1_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[categories_meta_h1_overwrite]" <?php if(isset($seogen['categories_meta_h1_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_categories_meta_title; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[categories_meta_title_template]" value="<?php echo $seogen['categories_meta_title_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_categories_meta_title_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[categories_meta_title_overwrite]" <?php if(isset($seogen['categories_meta_title_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_categories_meta_keyword; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[categories_meta_keyword_template]" value="<?php echo $seogen['categories_meta_keyword_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_categories_meta_keyword_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[categories_meta_keyword_overwrite]" <?php if(isset($seogen['categories_meta_keyword_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_categories_meta_description; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[categories_meta_description_template]" value="<?php echo $seogen['categories_meta_description_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_categories_meta_description_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[categories_meta_description_overwrite]" <?php if(isset($seogen['categories_meta_description_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_meta_description_limit; ?>
							</label>
							<div class="col-sm-1">
								<div class="row">
								    <div class="col-sm-5">
										<div class="form-group">
											<input type="text" name="seogen[categories_meta_description_limit]" value="<?php echo $seogen['categories_meta_description_limit']; ?>" class="form-control">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_use_expressions; ?>
							</label>

							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="seogen[categories_use_expressions]"
												<?php if(isset($seogen['categories_use_expressions'])) echo "checked='checked'"; ?> class="form-control">
										&nbsp; </label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="categories_description_template">
								<?php echo $text_categories_description; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<textarea class="summernote" id="categories_description_template" cols="125" rows="2"
																							  name="seogen[categories_description_template]"><?php echo $seogen['categories_description_template']; ?></textarea>
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_categories_description_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[categories_description_overwrite]" <?php if(isset($seogen['categories_description_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<button onclick="generate('categories');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="tab-products">
						<div class="row form-group">
							<div class="col-sm-2">
								<button onclick="generate('products');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
							</div>
							<div class="col-sm-9">
								<div class="col-sm-5"></div>
								<div class="col-sm-1">
									<label><?php echo $entry_overwrite ?></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_products; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[products_template]" value="<?php echo $seogen['products_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_overwrite]" <?php if(isset($seogen['products_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_products_meta_h1; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[products_meta_h1_template]" value="<?php echo $seogen['products_meta_h1_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_meta_h1_overwrite]" <?php if(isset($seogen['products_meta_h1_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_products_meta_title; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[products_meta_title_template]" value="<?php echo $seogen['products_meta_title_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_meta_title_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_meta_title_overwrite]" <?php if(isset($seogen['products_meta_title_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_products_meta_keyword; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[products_meta_keyword_template]" value="<?php echo $seogen['products_meta_keyword_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_meta_keyword_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_meta_keyword_overwrite]" <?php if(isset($seogen['products_meta_keyword_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_products_meta_description; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[products_meta_description_template]" value="<?php echo $seogen['products_meta_description_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_meta_description_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_meta_description_overwrite]" <?php if(isset($seogen['products_meta_description_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_meta_description_limit; ?>
							</label>
							<div class="col-sm-1">
								<div class="row">
									<div class="col-sm-5">
										<div class="form-group">
											<input type="text" name="seogen[products_meta_description_limit]" value="<?php echo $seogen['products_meta_description_limit']; ?>" class="form-control">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="products_description_template">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_products_description; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<textarea class="summernote" id="products_description_template" cols="125" rows="2"
																							  name="seogen[products_description_template]"><?php echo $seogen['products_description_template']; ?></textarea>
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_description_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_description_overwrite]" <?php if(isset($seogen['products_description_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_products_tag; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[products_tag_template]" value="<?php echo $seogen['products_tag_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_tag_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_tag_overwrite]" <?php if(isset($seogen['products_tag_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_products_model; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[products_model_template]" value="<?php echo $seogen['products_model_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_products_model_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[products_model_overwrite]" <?php if(isset($seogen['products_model_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_use_expr; ?>"><?php echo $text_use_expressions; ?></span>
							</label>

							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="seogen[products_use_expressions]"
												<?php if(isset($seogen['products_use_expressions'])) echo "checked='checked'"; ?> class="form-control">
										&nbsp; </label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<button onclick="generate('products');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="tab-manufacturers">
						<div class="form-group row">
							<div class="col-sm-2">
								<button onclick="generate('manufacturers');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
							</div>
							<div class="col-sm-8">
								<div class="col-sm-5"></div>
								<div class="col-sm-1">
									<label><?php echo $entry_overwrite ?></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_manufacturers; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[manufacturers_template]" value="<?php echo $seogen['manufacturers_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_manufacturers_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[manufacturers_overwrite]" <?php if(isset($seogen['manufacturers_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_manufacturers_meta_h1; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[manufacturers_meta_h1_template]" value="<?php echo $seogen['manufacturers_meta_h1_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_manufacturers_meta_h1_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[manufacturers_meta_h1_overwrite]" <?php if(isset($seogen['manufacturers_meta_h1_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_manufacturers_meta_title; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[manufacturers_meta_title_template]" value="<?php echo $seogen['manufacturers_meta_title_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_manufacturers_meta_title_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[manufacturers_meta_title_overwrite]" <?php if(isset($seogen['manufacturers_meta_title_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_manufacturers_meta_keyword; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[manufacturers_meta_keyword_template]" value="<?php echo $seogen['manufacturers_meta_keyword_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_manufacturers_meta_keyword_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[manufacturers_meta_keyword_overwrite]" <?php if(isset($seogen['manufacturers_meta_keyword_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_manufacturers_meta_description; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[manufacturers_meta_description_template]" value="<?php echo $seogen['manufacturers_meta_description_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_manufacturers_meta_description_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[manufacturers_meta_description_overwrite]" <?php if(isset($seogen['manufacturers_meta_description_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="manufacturers_description_template">
								<span data-toggle="tooltip" title="<?php echo $help_show_expr; ?>"><?php echo $text_manufacturers_description; ?></span>
							</label>
							<div class="col-sm-10">
								<div class="row">
								    <div class="col-sm-4">
										<div class="form-group">
											<textarea class="summernote" id="manufacturers_description_template" cols="125" rows="2"
																							  name="seogen[manufacturers_description_template]"><?php echo $seogen['manufacturers_description_template']; ?></textarea>
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_manufacturers_description_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[manufacturers_description_overwrite]" <?php if(isset($seogen['manufacturers_description_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<span data-toggle="tooltip" title="<?php echo $help_use_expr; ?>"><?php echo $text_use_expressions; ?></span>
							</label>

							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="seogen[manufacturers_use_expressions]"
												<?php if(isset($seogen['manufacturers_use_expressions'])) echo "checked='checked'"; ?> class="form-control">
										&nbsp; </label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<button onclick="generate('manufacturers');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="tab-pane fade" id="tab-informations">
						<div class="form-group row">
							<div class="col-sm-2">
								<button onclick="generate('informations');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
							</div>
							<div class="col-sm-10">
								<div class="col-sm-5"></div>
								<div class="col-sm-1">
									<label><?php echo $entry_overwrite ?></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_informations; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[informations_template]" value="<?php echo $seogen['informations_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_informations_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[informations_overwrite]" <?php if(isset($seogen['informations_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_informations_meta_h1; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[informations_meta_h1_template]" value="<?php echo $seogen['informations_meta_h1_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_informations_meta_h1_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[informations_meta_h1_overwrite]" <?php if(isset($seogen['informations_meta_h1_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_informations_meta_title; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[informations_meta_title_template]" value="<?php echo $seogen['informations_meta_title_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_informations_meta_title_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[informations_meta_title_overwrite]" <?php if(isset($seogen['informations_meta_title_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_informations_meta_keyword; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[informations_meta_keyword_template]" value="<?php echo $seogen['informations_meta_keyword_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_informations_meta_keyword_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[informations_meta_keyword_overwrite]" <?php if(isset($seogen['informations_meta_keyword_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php echo $text_informations_meta_description; ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<input type="text" name="seogen[informations_meta_description_template]" value="<?php echo $seogen['informations_meta_description_template']; ?>" class="form-control">
											<label><?php echo ' <span class="grey">' . $text_available_tags . '</span> ' . $text_informations_meta_description_tags; ?></label>
										</div>
									</div>
									<div class="col-sm-4">
										<input class="overwrite" type="checkbox"
											   name="seogen[informations_meta_description_overwrite]" <?php if(isset($seogen['informations_meta_description_overwrite'])) echo "checked='checked'"; ?>>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<button onclick="generate('informations');" class="btn btn-primary pull-right" type="button"><?php echo $text_generate; ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		<a id="generate_url" style="display: none" href="<?php echo $generate?>"></a>
		</div>
		</div>
		</div>

<?php if (version_compare(VERSION, "2.3", ">=")) {?>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<?php } ?>
<script type="text/javascript"><!--
$('.summernote').summernote({height: 300});
//-->
</script>
<script type="text/javascript">
function generate(selector) {
	$(".alert-success").remove();
	//update summernote
	$('.summernote').each(function(i, e){
        if($(this).code != undefined) {
            $(this).val($(this).code());
        }
	});

	var data = $('#tab-' + selector + ' :input, #seogen_language_id, #including :input').serialize()
			+ '&name=' + selector;
	$.post($('#generate_url').attr('href'), data, function(html) {
		$(".breadcrumb").after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' +
				html +
				'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

	});
}

//$(document).ready(function() {
//	$('a[href="'+$('#seogen_tab').val()+'"]').click();
//});

//$('.nav.nav-tabs li a').click(function() {
//	$('#seogen_tab').val($(this).attr('href'));
//});

function addProfile() {
	$(".alert-success").remove();
	var spn = $('input[name="seogen_profile_name"]').val();
	if(!spn){
		return;
	}
	//update summernote
	$('.summernote').each(function(i, e){
        if($(this).code != undefined) {
            $(this).val($(this).code());
        }
    });

	$.post('<?php echo $action_profile_add; ?>', 'data=' + window.btoa($("#form-seogen").serialize()), function (json) {
		if (json.result == "success" && json.profile_id > 0) {
			$('#seogen_profile').append('<option data-id="' + json.profile_id + '" id="profile-' + json.profile_id + '">' + htmlEscape(spn) + '</option>');
		}
	}, 'json');

}
function delProfile() {
	var $seogenprofile = $('#seogen_profile option:selected');
	var profile_id = $seogenprofile.attr('id');
	var data_id = $seogenprofile.attr('data-id');
	if(data_id == "0"){
		return;
	}
	$.post('<?php echo $action_profile_del; ?>', 'profile_id='+data_id , function (json) {
		$('#profile-'+data_id).remove();
   }, 'json');

}
function changeProfile(e){
	var $seogenprofile = $('#seogen_profile option:selected');
	var data_id = $seogenprofile.attr('data-id');
	if(data_id == "0"){
		return;
	}
	$.post('<?php echo $action_profile_get; ?>', 'profile_id='+data_id, function (json) {
		$('input[name="seogen_profile_name"]').val($(e).val());
		if(json.result == "success") {
			$('input[type="checkbox"][name]').each(function(i, e){
				$e = $(e);
				var matches = $(e).attr('name').match(/seogen\[(.*)\]/);
				if(matches) {
					$(e).prop('checked', json.profile[matches[1]] != undefined);
				}
			});

			for(var name in json.profile) {
			   if (json.profile.hasOwnProperty(name)) {
				   var val = json.profile[name];
				   if (val instanceof Array){
					   for (var i = 0; i < val.length; ++i) {
						   $(':input[name="seogen['+name+'][]"][value="'+val[i]+'"]').prop('checked', true);
					   }
				   } else {
						$(':input[name="seogen['+name+']"]').val(val);
				   }
			   }
			}

			$('.summernote').each(function(i, e){
                if($(this).code != undefined) {
                    $(this).val($(this).code());
                }
            });

//			$('a[href="'+$('#seogen_tab').val()+'"]').click();
		}

   }, 'json');
}

function htmlEscape(str) {
	return String(str)
			.replace(/&/g, '&amp;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;');
}
</script>

	</div>
<?php echo $footer; ?>