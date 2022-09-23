<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-primary"><i class="fa fa-reply"></i></a>				
			</div>
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
		<?php if ($success) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-info"></i> Информация о точке обмена</h3>
			</div>
			<div class="panel-body">
				<h4>
					<? echo $node_info['node_name']; ?>
					
					<? if ($node_info['node_last_update_error']) { ?>
						<span class="label label-danger">
							<?php echo $node_info['node_last_update_status']; ?>
						</span>
						<? } else { ?>
						<span class="label label-success">
							<?php echo $node_info['node_last_update_status']; ?>
						</span>
					<? } ?>
				</h4>
				<h4>
					<? echo $node_info['node_url']; ?>
				</h4>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> История обмена (последние 50 записей)</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>								
								<td class="text-left">Дата, время</td>
								<td class="text-left">Тип обмена</td>
								<td class="text-left">Статус</td>
								<td class="text-left">Ответ системы</td>									
							</tr>
						</thead>
						<tbody>
							<?php if ($histories) { ?>
								<?php foreach ($histories as $history) { ?>
									<tr>											
										<td class="text-left"><?php echo $history['date_added']; ?></td>										
										<td class="text-left">
											<h4><span class="label label-info"><?php echo $history['type']; ?></span></h4>
										</td>
										<td class="text-left">
											<? if ($history['is_error']) { ?>
												<h4><span class="label label-danger">
													<?php echo $history['status']; ?>
												</span></h4>
												<? } else { ?>
												<h4><span class="label label-success">
													<?php echo $history['status']; ?>
												</span></h4>
											<? } ?>
										</td>
										<td class="text-left">										
											<small>
												<?php echo $history['json']; ?>
											</small>
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
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>