<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">

				<a href="<?php echo $clearQueue; ?>" class="btn btn-danger">Перезапуск очереди<?php if ($queue_running) { ?> <i class="fa fa-spinner fa-spin"></i><?php } ?></a>

				<a href="<?php echo $changetoGW; ?>" class="btn btn-warning">Основной канал (gw)</a>
				<a href="<?php echo $changetoGWR; ?>" class="btn btn-warning">Резервный канал (gwr)</a>


				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-store').submit() : false;"><i class="fa fa-trash-o"></i></button>
			</div>
			<h1><?php echo $heading_title; ?></h1>
		</div>
	</div>
	<div class="container-fluid">
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-store">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="text-left">Точка</td>
									<td class="text-left">Основной узел</td>
									<td class="text-left">Наличие</td>
									<td class="text-left">Каталог</td>
									<td class="text-left">Клиенты</td>	
									<td class="text-left">Карты</td>
									<td class="text-left">Под заказ</td>
									<td class="text-left">Последнее действие</td>
									<td class="text-left">Статус узла</td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($nodes) { ?>
									<?php foreach ($nodes as $node) { ?>
										<tr>
											<td class="text-center"><?php if (in_array($node['node_id'], $selected)) { ?>
												<input type="checkbox" name="selected[]" value="<?php echo $node['node_id']; ?>" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="selected[]" value="<?php echo $node['node_id']; ?>" />
											<?php } ?></td>
											<td class="text-left">
												<b><?php echo $node['node_name']; ?></b>
												<br /><small><?php echo $node['node_url']; ?></small>
											</td>
											<td class="text-center">
												<?php if ($node['is_main']) { ?>
													<span class="label label-success"><i class="fa fa-plus"></i></span>
													<? } else { ?>					  
													<span class="label label-danger"><i class="fa fa-minus"></i></span>
												<? } ?>
											</td>
											<td class="text-center">
												<?php if ($node['is_stock']) { ?>
													<span class="label label-success"><i class="fa fa-plus"></i></span>
													<? } else { ?>					  
													<span class="label label-danger"><i class="fa fa-minus"></i></span>
												<? } ?>
											</td>
											<td class="text-center">
												<?php if ($node['is_catalog']) { ?>
													<span class="label label-success"><i class="fa fa-plus"></i></span>
													<? } else { ?>					  
													<span class="label label-danger"><i class="fa fa-minus"></i></span>
												<? } ?>
											</td>
											<td class="text-center">
												<?php if ($node['is_customer']) { ?>
													<span class="label label-success"><i class="fa fa-plus"></i></span>
													<? } else { ?>					  
													<span class="label label-danger"><i class="fa fa-minus"></i></span>
												<? } ?>
											</td>		
											<td class="text-center">
												<?php if ($node['is_cards']) { ?>
													<span class="label label-success"><i class="fa fa-plus"></i></span>
													<? } else { ?>					  
													<span class="label label-danger"><i class="fa fa-minus"></i></span>
												<? } ?>
											</td>
											<td class="text-center">
												<?php if ($node['is_preorder']) { ?>
													<span class="label label-success"><i class="fa fa-plus"></i></span>
													<? } else { ?>					  
													<span class="label label-danger"><i class="fa fa-minus"></i></span>
												<? } ?>
											</td>
											<td class="text-left"><?php echo $node['node_last_update']; ?></td>
											<td class="text-left">										
												<? if ($node['node_last_update_error']) { ?>
													<h4><span class="label label-danger">
														<?php echo $node['node_last_update_status']; ?>
													</span></h4>
													<? } else { ?>
													<h4><span class="label label-success">
														<?php echo $node['node_last_update_status']; ?>
													</span></h4>
												<? } ?>
											</td>
											<td class="text-right">
												<a href="<?php echo $node['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
												<a href="<?php echo $node['history']; ?>" data-toggle="tooltip" title="История обмена" class="btn btn-info"><i class="fa fa-history" aria-hidden="true"></i></a>
											</td>
										</tr>
									<?php } ?>
									<?php } else { ?>
									<tr>
										<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>