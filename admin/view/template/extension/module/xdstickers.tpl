<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button onclick="$('#xdstickers_apply').attr('value','1'); $('#form-xdstickers').submit();" data-toggle="tooltip" title="<?php echo $button_apply; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
				<button type="submit" form="form-xdstickers" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1 style="display:block;"><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div id="xdstickers_block" class="container-fluid">
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
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab_settings"><?php echo $text_tab_settings; ?></a></li>
				<li><a data-toggle="tab" href="#tab_auto_stickers"><?php echo $text_tab_auto_stickers; ?></a></li>
				<li><a data-toggle="tab" href="#tab_custom"><?php echo $text_tab_custom; ?></a></li>
				<li><a data-toggle="tab" href="#tab_bulk_custom"><?php echo $text_tab_bulk_custom; ?></a></li>
			</ul>
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-xdstickers" class="form-horizontal">
				<input type="hidden" name="xdstickers_apply" value="" id="xdstickers_apply" class="form-control" />
				<div class="tab-content">
					<div class="tab-pane active" id="tab_settings">
						<div class="lead well well-sm text-info">
							<strong><?php echo $text_tab_settings_title; ?></strong>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $entry_xdstickers_position; ?></label>
									<div class="col-sm-9">
										<select name="xdstickers[position]" class="form-control">
											<?php if ($xdstickers['position']) { ?>
												<option value="1" selected="selected"><?php echo $text_topright; ?></option>
												<option value="0"><?php echo $text_topleft; ?></option>
											<?php } else { ?>
												<option value="1"><?php echo $text_topright; ?></option>
												<option value="0" selected="selected"><?php echo $text_topleft; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $entry_xdstickers_styles; ?></label>
									<div class="col-sm-9">
										<textarea name="xdstickers[inline_styles]" rows="4" style="width:100%"><?php echo $xdstickers['inline_styles']; ?></textarea>
										<p class="text-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $xdstickers_styles_help; ?></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $entry_xdstickers_status; ?></label>
									<div class="col-sm-9">
										<select name="xdstickers[status]" class="form-control">
											<?php if ($xdstickers['status']) { ?>
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
						</div>
					</div>
					<div class="tab-pane" id="tab_auto_stickers">
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_sale_title; ?></strong>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table id="xdstickers_sale" class="table table-striped table-bordered">
									<thead>
										<tr>
											<td class="text-left" style="width: 25%;"><?php echo $entry_sticker_text; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_color; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_bg; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_sale_property; ?></td>
											<td class="text-right" style="width: 15%;"><?php echo $entry_sticker_status; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left" style="width: 25%;">
												<?php foreach ($languages as $language) { ?>
													<div class="input-group pull-left">
														<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span>
														<input type="text" name="xdstickers[sale][text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($xdstickers['sale']['text'][$language['language_id']]) ? $xdstickers['sale']['text'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_sticker_text; ?>" class="form-control" />
													</div>
												<?php } ?>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['sale']['color']; ?>;"></i></span>
														<input type="text" name="xdstickers[sale][color]" value="<?php echo isset($xdstickers['sale']['color']) ? $xdstickers['sale']['color'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['sale']['bg']?>;"></i></span>
														<input type="text" name="xdstickers[sale][bg]" value="<?php echo isset($xdstickers['sale']['bg']) ? $xdstickers['sale']['bg'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-right" style="width: 15%;">
												<select name="xdstickers[sale][discount_status]" class="form-control">
													<?php if ($xdstickers['sale']['discount_status']) { ?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } ?>
												</select>
											</td>
											<td class="text-right" style="width: 15%;">
												<select name="xdstickers[sale][status]" class="form-control">
													<?php if ($xdstickers['sale']['status']) { ?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_bestseller_title; ?></strong>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table id="xdstickers_bestseller" class="table table-striped table-bordered">
									<thead>
										<tr>
											<td class="text-left" style="width: 25%;"><?php echo $entry_sticker_text; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_color; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_bg; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_bestseller_property; ?></td>
											<td class="text-right" style="width: 15%;"><?php echo $entry_sticker_status; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left" style="width: 25%;">
												<?php foreach ($languages as $language) { ?>
													<div class="input-group pull-left">
														<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span>
														<input type="text" name="xdstickers[bestseller][text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($xdstickers['bestseller']['text'][$language['language_id']]) ? $xdstickers['bestseller']['text'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_sticker_text; ?>" class="form-control" />
													</div>
												<?php } ?>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['bestseller']['color']; ?>;"></i></span>
														<input type="text" name="xdstickers[bestseller][color]" value="<?php echo isset($xdstickers['bestseller']['color']) ? $xdstickers['bestseller']['color'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['bestseller']['bg']?>;"></i></span>
														<input type="text" name="xdstickers[bestseller][bg]" value="<?php echo isset($xdstickers['bestseller']['bg']) ? $xdstickers['bestseller']['bg'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<input type="text" name="xdstickers[bestseller][property]" value="<?php echo isset($xdstickers['bestseller']['property']) ? $xdstickers['bestseller']['property'] : ''; ?>" class="form-control" />
											</td>
											<td class="text-right" style="width: 15%;">
												<select name="xdstickers[bestseller][status]" class="form-control">
													<?php if ($xdstickers['bestseller']['status']) { ?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_novelty_title; ?></strong>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table id="xdstickers_novelty" class="table table-striped table-bordered">
									<thead>
										<tr>
											<td class="text-left" style="width: 25%;"><?php echo $entry_sticker_text; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_color; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_bg; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_novelty_property; ?></td>
											<td class="text-right" style="width: 15%;"><?php echo $entry_sticker_status; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left" style="width: 25%;">
												<?php foreach ($languages as $language) { ?>
													<div class="input-group pull-left">
														<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span>
														<input type="text" name="xdstickers[novelty][text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($xdstickers['novelty']['text'][$language['language_id']]) ? $xdstickers['novelty']['text'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_sticker_text; ?>" class="form-control" />
													</div>
												<?php } ?>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['novelty']['color']; ?>;"></i></span>
														<input type="text" name="xdstickers[novelty][color]" value="<?php echo isset($xdstickers['novelty']['color']) ? $xdstickers['novelty']['color'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['novelty']['bg']?>;"></i></span>
														<input type="text" name="xdstickers[novelty][bg]" value="<?php echo isset($xdstickers['novelty']['bg']) ? $xdstickers['novelty']['bg'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<input type="text" name="xdstickers[novelty][property]" value="<?php echo isset($xdstickers['novelty']['property']) ? $xdstickers['novelty']['property'] : ''; ?>" class="form-control" />
											</td>
											<td class="text-right" style="width: 15%;">
												<select name="xdstickers[novelty][status]" class="form-control">
													<?php if ($xdstickers['novelty']['status']) { ?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_last_title; ?></strong>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table id="xdstickers_last" class="table table-striped table-bordered">
									<thead>
										<tr>
											<td class="text-left" style="width: 25%;"><?php echo $entry_sticker_text; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_color; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_bg; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_last_property; ?></td>
											<td class="text-right" style="width: 15%;"><?php echo $entry_sticker_status; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left" style="width: 25%;">
												<?php foreach ($languages as $language) { ?>
													<div class="input-group pull-left">
														<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span>
														<input type="text" name="xdstickers[last][text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($xdstickers['last']['text'][$language['language_id']]) ? $xdstickers['last']['text'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_sticker_text; ?>" class="form-control" />
													</div>
												<?php } ?>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['last']['color']; ?>;"></i></span>
														<input type="text" name="xdstickers[last][color]" value="<?php echo isset($xdstickers['last']['color']) ? $xdstickers['last']['color'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['last']['bg']?>;"></i></span>
														<input type="text" name="xdstickers[last][bg]" value="<?php echo isset($xdstickers['last']['bg']) ? $xdstickers['last']['bg'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<input type="text" name="xdstickers[last][property]" value="<?php echo isset($xdstickers['last']['property']) ? $xdstickers['last']['property'] : ''; ?>" class="form-control" />
											</td>
											<td class="text-right" style="width: 15%;">
												<select name="xdstickers[last][status]" class="form-control">
													<?php if ($xdstickers['last']['status']) { ?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_freeshipping_title; ?></strong>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table id="xdstickers_freeshipping" class="table table-striped table-bordered">
									<thead>
										<tr>
											<td class="text-left" style="width: 25%;"><?php echo $entry_sticker_text; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_color; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_bg; ?></td>
											<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_freeshipping_property; ?></td>
											<td class="text-right" style="width: 15%;"><?php echo $entry_sticker_status; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left" style="width: 25%;">
												<?php foreach ($languages as $language) { ?>
													<div class="input-group pull-left">
														<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span>
														<input type="text" name="xdstickers[freeshipping][text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($xdstickers['freeshipping']['text'][$language['language_id']]) ? $xdstickers['freeshipping']['text'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_sticker_text; ?>" class="form-control" />
													</div>
												<?php } ?>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['freeshipping']['color']; ?>;"></i></span>
														<input type="text" name="xdstickers[freeshipping][color]" value="<?php echo isset($xdstickers['freeshipping']['color']) ? $xdstickers['freeshipping']['color'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<div class="color_input">
													<div class="input-group">
														<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['freeshipping']['bg']?>;"></i></span>
														<input type="text" name="xdstickers[freeshipping][bg]" value="<?php echo isset($xdstickers['freeshipping']['bg']) ? $xdstickers['freeshipping']['bg'] : ''; ?>" class="form-control col-xs-8" />
													</div>
												</div>
											</td>
											<td class="text-left" style="width: 20%;">
												<input type="text" name="xdstickers[freeshipping][property]" value="<?php echo isset($xdstickers['freeshipping']['property']) ? $xdstickers['freeshipping']['property'] : ''; ?>" class="form-control" />
											</td>
											<td class="text-right" style="width: 15%;">
												<select name="xdstickers[freeshipping][status]" class="form-control">
													<?php if ($xdstickers['freeshipping']['status']) { ?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<hr style="border-color:#000;" />
						<div class="h2 text-success text-center" style="margin-bottom:0;">
							<strong><?php echo $text_tab_stock_stickers; ?></strong>
						</div>
						<?php foreach($stock_statuses as $stock_status) { ?>
							<?php $stock_status_id =$stock_status['stock_status_id']; ?>
							<div class="h4 text-primary" style="margin-bottom:0;">
								<strong><?php echo $stock_status['name']; ?></strong>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<table id="xdstickers_stock" class="table table-striped table-bordered">
										<thead>
											<tr>
												<td class="text-left" style="width:30%;"><?php echo $entry_sticker_text; ?></td>
												<td class="text-left" style="width:25%;"><?php echo $entry_sticker_color; ?></td>
												<td class="text-left" style="width:25%;"><?php echo $entry_sticker_bg; ?></td>
												<td class="text-right" style="width:20%;"><?php echo $entry_sticker_status; ?></td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-left" style="width: 25%;">
													<?php foreach ($languages as $language) { ?>
														<?php $language_id = $language['language_id']; ?>
														<div class="input-group pull-left">
															<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span>
															<input type="text" name="xdstickers[stock][<?php echo $stock_status_id; ?>][text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($xdstickers['stock'][$stock_status_id]['text'][$language['language_id']]) ? $xdstickers['stock'][$stock_status_id]['text'][$language['language_id']] : ''; ?>"  class="form-control" />
														</div>
													<?php } ?>
												</td>
												<td class="text-left" style="width: 20%;">
													<div class="color_input">
														<div class="input-group">
															<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['stock'][$stock_status_id]['color']; ?>;"></i></span>
															<input type="text" name="xdstickers[stock][<?php echo $stock_status_id; ?>][color]" value="<?php echo isset($xdstickers['stock'][$stock_status_id]['color']) ? $xdstickers['stock'][$stock_status_id]['color'] : ''; ?>" class="form-control col-xs-8" />
														</div>
													</div>
												</td>
												<td class="text-left" style="width: 20%;">
													<div class="color_input">
														<div class="input-group">
															<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $xdstickers['stock'][$stock_status_id]['bg']?>;"></i></span>
															<input type="text" name="xdstickers[stock][<?php echo $stock_status_id; ?>][bg]" value="<?php echo isset($xdstickers['stock'][$stock_status_id]['bg']) ? $xdstickers['stock'][$stock_status_id]['bg'] : ''; ?>" class="form-control col-xs-8" />
														</div>
													</div>
												</td>
												<td class="text-right" style="width: 15%;">
													<select name="xdstickers[stock][<?php echo $stock_status_id; ?>][status]" class="form-control">
														<?php if (isset($xdstickers['stock'][$stock_status_id]['status']) && $xdstickers['stock'][$stock_status_id]['status'] == '1') { ?>
															<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
															<option value="0"><?php echo $text_disabled; ?></option>
														<?php } else { ?>
															<option value="1"><?php echo $text_enabled; ?></option>
															<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="tab-pane" id="tab_custom">
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_custom_title; ?></strong>
						</div>
						<div class="form-group">
							<div class="col-sm-12">

									<table id="xdstickers_custom" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_title; ?></td>
												<td class="text-left" style="width: 25%;"><?php echo $entry_sticker_text; ?></td>
												<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_color; ?></td>
												<td class="text-left" style="width: 20%;"><?php echo $entry_sticker_bg; ?></td>
												<td class="text-right" style="width: 10%;"><?php echo $entry_sticker_status; ?></td>
												<td class="text-right" style="width: 5%;"></td>
											</tr>
										</thead>
										<tbody>
											<?php $custom_xdsticker['xdsticker_id'] = 0; ?>
											<?php foreach ($custom_xdstickers as $custom_xdsticker) { ?>
												<tr id="custom_xdsticker-row<?php echo $custom_xdsticker['xdsticker_id']; ?>">
													<td class="hidden"><input type="hidden" name="custom_xdsticker[<?php echo $custom_xdsticker['xdsticker_id']; ?>][xdsticker_id]" value="<?php echo $custom_xdsticker['xdsticker_id']; ?>" class="hidden" /></td>
													<td class="text-left" style="width: 20%;">
														<input type="text" name="custom_xdsticker[<?php echo $custom_xdsticker['xdsticker_id']; ?>][name]" value="<?php echo $custom_xdsticker['name']; ?>" placeholder="<?php echo $entry_sticker_title; ?>" class="form-control" />
													</td>
													<td class="text-left" style="width: 25%;">
														<?php foreach ($languages as $language) { ?>
															<div class="input-group pull-left"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span>
																<input type="text" name="custom_xdsticker[<?php echo $custom_xdsticker['xdsticker_id']; ?>][text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($custom_xdsticker['text'][$language['language_id']]) ? $custom_xdsticker['text'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_sticker_text; ?>" class="form-control" />
															</div>
														<?php } ?>
													</td>
													<td class="text-left" style="width: 20%;">
														<div class="color_input">
															<div class="input-group">
																<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $custom_xdsticker['color_color']; ?>;"></i></span>
																<input type="text" value="<?php echo $custom_xdsticker['color_color']; ?>" class="form-control" name="custom_xdsticker[<?php echo $custom_xdsticker['xdsticker_id']; ?>][color_color]" />
															</div>
														</div>
													</td>
													<td class="text-left" style="width: 20%;">
														<div class="color_input">
															<div class="input-group">
																<span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style="color:<?php echo $custom_xdsticker['bg_color']; ?>;"></i></span>
																<input type="text" value="<?php echo $custom_xdsticker['bg_color']; ?>" class="form-control" name="custom_xdsticker[<?php echo $custom_xdsticker['xdsticker_id']; ?>][bg_color]" />
															</div>
														</div>
													</td>
													<td class="text-right" style="width: 10%;">
														<select name="custom_xdsticker[<?php echo $custom_xdsticker['xdsticker_id']; ?>][status]" class="form-control">
															<?php if ($custom_xdsticker['status']) { ?>
																<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
																<option value="0"><?php echo $text_disabled; ?></option>
															<?php } else { ?>
																<option value="1"><?php echo $text_enabled; ?></option>
																<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
															<?php } ?>
														</select>
													</td>
													<td class="text-right" style="width: 5%;">
														<button type="button" onclick="removeCustomXDSticker(<?php echo $custom_xdsticker['xdsticker_id']; ?>)" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
															<i class="fa fa-minus-circle"></i>
														</button>
													</td>
												</tr>
											<?php $custom_xdsticker['xdsticker_id']++; ?>
											<?php } ?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="5"></td>
												<td class="text-right">
													<button type="button" onclick="addCustomXDSticker();" data-toggle="tooltip" title="<?php echo $button_custom_xdsticker_add; ?>" class="btn btn-primary">
														<i class="fa fa-plus-circle"></i>
													</button>
												</td>
											</tr>
										</tfoot>
									</table>

							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab_bulk_custom">
						<div class="h4 text-primary" style="margin-bottom:0;">
							<strong><?php echo $text_tab_bulk_custom_title; ?></strong>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-bulk_categories"><?php echo $entry_bulk_categories; ?></label>
							<div class="col-sm-10">
								<select name="module_bulk_categories" id="input-bulk_categories" class="form-control">
									<option value="0"><?php echo $text_all_categories; ?></option>
									<?php foreach ($bulk_categories as $bulk_category) { ?>
										<option value="<?php echo $bulk_category['category_id']; ?>"><?php echo $bulk_category['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-bulk_custom_xdstickers"><?php echo $entry_bulk_custom_xdstickers; ?></label>
							<div class="col-sm-10">
								<select name="module_bulk_custom_xdstickers" id="input-bulk_custom_xdstickers" class="form-control">
									<?php foreach ($bulk_custom_xdstickers as $bulk_custom_xdsticker) { ?>
										<option value="<?php echo $bulk_custom_xdsticker['xdsticker_id']; ?>"><?php echo $bulk_custom_xdsticker['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6 text-right">
								<label class="control-label text-warning"><strong><?php echo $entry_bulk_warning; ?></strong></label>
							</div>
							<div class="col-sm-2 text-right">
								<button type="button" class="btn btn-block btn-success" onclick="$('#xdstickers_apply').attr('value','1'); $('#form-xdstickers').submit();"><?php echo $button_apply; ?></button>
							</div>
							<div class="col-sm-2 text-right">
								<button type="button" class="btn btn-block btn-danger" onclick="bulkDeleteCustomXDStickers();"><?php echo $button_custom_xdstickers_bulk_delete; ?></button>
							</div>
							<div class="col-sm-2 text-right">
								<button type="button" class="btn btn-block btn-primary" onclick="bulkAddCustomXDStickers();"><?php echo $button_custom_xdstickers_bulk; ?></button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.color_input input').ColorPicker({
			onChange: function (hsb, hex, rgb, el) {
				$(el).val("#" +hex);
				$(el).parent().find('.fa').css("color", "#" + hex);
				// console.log(hex);
			},
			onShow: function (colpkr) {
				$(colpkr).show();
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).hide();
				return false;
			}
		});
	});
</script>
<script type="text/javascript"><!--
	var custom_xdsticker_row = <?php echo $custom_xdsticker['xdsticker_id']; ?>;

	function addCustomXDSticker() {
		// console.log($('#xdstickers_custom tbody tr:last td.hidden > input').val());
		var last_xdsticker_id = parseInt($('#xdstickers_custom tbody tr:last td.hidden > input').val()) + 1;
		html  = '<tr id="custom_xdsticker-row' + custom_xdsticker_row + '">';
		html += '  <td class="hidden"><input type="hidden" name="custom_xdsticker[' + custom_xdsticker_row + '][xdsticker_id]" value="' + last_xdsticker_id + '" class="hidden" /></td>';
		html += '  <td class="text-left" style="width: 20%;"><input type="text" name="custom_xdsticker[' + custom_xdsticker_row + '][name]" value="" placeholder="<?php echo $entry_sticker_title; ?>" class="form-control" /></td>';
		html += '  <td class="text-left" style="width: 25%;">';
		<?php foreach ($languages as $language) { ?>
		html += '  <div class="input-group pull-left">';
		html += '  <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> </span><input type="text" name="custom_xdsticker[' + custom_xdsticker_row + '][text][<?php echo $language['language_id']; ?>]" value="" placeholder="<?php echo $entry_sticker_text; ?>" class="form-control" />';
		html += '  </div>';
		<?php } ?>
		html += '  </td>';
		html += '  <td class="text-left color_input" style="width: 20%;"><div class="input-group"><span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style=""></i></span><input type="text" name="custom_xdsticker[' + custom_xdsticker_row + '][color_color]" value="" placeholder="<?php echo $entry_sticker_color; ?>" class="form-control" /></div></td>';
		html += '  <td class="text-left color_input" style="width: 20%;"><div class="input-group"><span class="input-group-addon" style="border-bottom-right-radius:0; border-top-right-radius:0; padding: 4px 8px;"><i class="fa fa-circle fa-2x fa-fw" aria-hidden="true" style=""></i></span><input type="text" name="custom_xdsticker[' + custom_xdsticker_row + '][bg_color]" value="" placeholder="<?php echo $entry_sticker_bg; ?>" class="form-control" /></div></td>';
		html += '  <td class="text-right" style="width: 10%;"><select name="custom_xdsticker[' + custom_xdsticker_row + '][status]" class="form-control"><option value="1"><?php echo $text_enabled; ?></option><option value="0" selected="selected"><?php echo $text_disabled; ?></option></select></td>';
		html += '  <td class="text-right" style="width: 5%;"><button type="button" onclick="removeCustomXDSticker(' + custom_xdsticker_row  + ');" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#xdstickers_custom tbody').append(html);

		$('.color_input input').ColorPicker({
			onChange: function (hsb, hex, rgb, el) {
				$(el).val("#" +hex);
				$(el).parent().find('.fa').css("color", "#" + hex);
				// console.log(hex);
			},
			onShow: function (colpkr) {
				$(colpkr).show();
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).hide();
				return false;
			}
		});

		custom_xdsticker_row++;
	}

	function removeCustomXDSticker(xdsticker_id) {
		var for_post = {};
		for_post.xdsticker_id = xdsticker_id;
		remove_row = '#custom_xdsticker-row' + xdsticker_id;
		$.ajax({
			url: 'index.php?route=extension/module/xdstickers/delete_xdsticker&token=<?php echo $token; ?>',
			type: 'post',
			data: for_post,
			dataType: 'json',
			beforeSend: function() {
				$('#xdstickers_block .alert').remove();
			},
			complete: function() {
			},
			success: function(json) {
				console.log('AJAX SUCCESS!!!');
				if (json['success']) {
					$('#xdstickers_block').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					$(remove_row).remove();
				}
				if (json['error']) {
					$('#xdstickers_block').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+json['error']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				$('#xdstickers_block').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_ajax; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}

	function bulkAddCustomXDStickers() {
		var for_post = {};
		for_post.module_bulk_categories = $('#input-bulk_categories').val();
		for_post.module_bulk_custom_xdstickers = $('#input-bulk_custom_xdstickers').val();
		$.ajax({
			url: 'index.php?route=extension/module/xdstickers/bulkAddCustomXDStickers&token=<?php echo $token; ?>',
			type: 'post',
			data: for_post,
			dataType: 'json',
			beforeSend: function() {
				$('#xdstickers_block .alert').remove();
			},
			complete: function() {
			},
			success: function(json) {
				console.log(json);
				if (json['success']) {
					$('#xdstickers_block').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				if (json['error']) {
					$('#xdstickers_block').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+json['error']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				$('#xdstickers_block').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_ajax; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				console.log("thrownError: " + thrownError + "\r\n xhr.status: " + xhr.status + "\r\n xhr.statusText: " + xhr.statusText + "\r\n xhr.responseText: " + xhr.responseText);
			}
		});
	}

	function bulkDeleteCustomXDStickers() {
		var for_post = {};
		for_post.module_bulk_categories = $('#input-bulk_categories').val();
		for_post.module_bulk_custom_xdstickers = $('#input-bulk_custom_xdstickers').val();
		$.ajax({
			url: 'index.php?route=extension/module/xdstickers/bulkDeleteCustomXDStickers&token=<?php echo $token; ?>',
			type: 'post',
			data: for_post,
			dataType: 'json',
			beforeSend: function() {
				$('#xdstickers_block .alert').remove();
			},
			complete: function() {
			},
			success: function(json) {
				console.log(json);
				if (json['success']) {
					$('#xdstickers_block').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				if (json['error']) {
					$('#xdstickers_block').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+json['error']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				$('#xdstickers_block').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_ajax; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				console.log("thrownError: " + thrownError + "\r\n xhr.status: " + xhr.status + "\r\n xhr.statusText: " + xhr.statusText + "\r\n xhr.responseText: " + xhr.responseText);
			}
		});
	}
//--></script>
<?php echo $footer; ?>