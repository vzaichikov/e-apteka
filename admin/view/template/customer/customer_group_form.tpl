<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-customer-group" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer-group" class="form-horizontal">
					
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab">Данные</a></li>
						<li><a href="#tab-pricegroups" data-toggle="tab">Ценовая политика</a></li>						
					</ul>
					
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<div class="form-group required">
								<label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
								<div class="col-sm-10">
									<?php foreach ($languages as $language) { ?>
										<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
											<input type="text" name="customer_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
										</div>
										<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
							<?php foreach ($languages as $language) { ?>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
									<div class="col-sm-10">
										<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
											<textarea name="customer_group_description[<?php echo $language['language_id']; ?>][description]" rows="5" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
								</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_approval; ?>"><?php echo $entry_approval; ?></span></label>
								<div class="col-sm-10">
									<label class="radio-inline">
										<?php if ($approval) { ?>
											<input type="radio" name="approval" value="1" checked="checked" />
											<?php echo $text_yes; ?>
											<?php } else { ?>
											<input type="radio" name="approval" value="1" />
											<?php echo $text_yes; ?>
										<?php } ?>
									</label>
									<label class="radio-inline">
										<?php if (!$approval) { ?>
											<input type="radio" name="approval" value="0" checked="checked" />
											<?php echo $text_no; ?>
											<?php } else { ?>
											<input type="radio" name="approval" value="0" />
											<?php echo $text_no; ?>
										<?php } ?>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-uuid">UUID</label>
								<div class="col-sm-10">
									<input type="text" name="uuid" value="<?php echo $uuid; ?>" placeholder="uuid" id="input-uuid" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-10">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="tab-pricegroups">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th class="text-left">
										Ценовая группа
									</th>
									<th class="text-left">
										UUID
									</th>
									<th class="text-left">
										Наценка / скидка
									</th>
									<th class="text-left">
										Процент
									</th>
								</thead>
								<? foreach ($customer_group_price_group as $pricegroup) { ?>
									<tr>
										<td>
											<? echo $pricegroup['pg_name']; ?>
										</td>
										<td>
											<? echo $pricegroup['pg_uuid']; ?>
										</td>
										<td>
											<select name="customer_group_price_group[<? echo $pricegroup['pricegroup_id']; ?>][plus]" class="form-control">
												<? if($pricegroup['plus']) { ?>
													<option value="1" selected="selected">+</option>
													<option value="0">-</option>
												<? } else { ?>
													<option value="1">+</option>
													<option value="0" selected="selected">-</option>
												<? } ?>
											</select>
										</td>
										<td>
											<input type="text" name="customer_group_price_group[<? echo $pricegroup['pricegroup_id']; ?>][percent]" value="<? echo $pricegroup['percent']; ?>" placeholder="0.00" class="form-control" />
										</td>
									</tr>
								<? } ?>
							</table>	
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>