<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-nodes" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-nodes" class="form-horizontal">
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-title">Название</label>
						<div class="col-sm-10">
							<input type="text" name="node_name" value="<?php echo $node_name; ?>" placeholder="Название" id="input-node_name" class="form-control" />
							<?php if ($error_title) { ?>
								<div class="text-danger"><?php echo $error_title; ?></div>
							<?php } ?>
						</div>
					</div>
					
		            <div class="form-group">
						<label class="col-sm-2 control-label" for="input-is_main">Основной узел</label>
						<div class="col-sm-10">
							<select name="is_main" id="input-is_main" class="form-control">
								<?php if ($is_main) { ?>
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
						<label class="col-sm-2 control-label" for="input-is_main">Подразделение с наличием</label>
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
						<label class="col-sm-2 control-label" for="input-is_catalog">Синхронизация каталога</label>
						<div class="col-sm-10">
							<select name="is_catalog" id="input-is_catalog" class="form-control">
								<?php if ($is_catalog) { ?>
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
						<label class="col-sm-2 control-label" for="input-is_customer">Синхронизация клиентов</label>
						<div class="col-sm-10">
							<select name="is_customer" id="input-is_customer" class="form-control">
								<?php if ($is_customer) { ?>
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
						<label class="col-sm-2 control-label" for="input-is_cards">Синхронизация карт лояльности</label>
						<div class="col-sm-10">
							<select name="is_cards" id="input-is_cards" class="form-control">
								<?php if ($is_cards) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-node_url">URI точки обмена</label>
						<div class="col-sm-10">
							<input type="text" name="node_url" value="<?php echo $node_url; ?>" placeholder="URI точки обмена" id="input-node_url" class="form-control" />
							<?php if ($error_code) { ?>
								<div class="text-danger"><?php echo $error_code; ?></div>
							<?php } ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-node_auth">Авторизация - логин</label>
						<div class="col-sm-10">
							<input type="text" name="node_auth" value="<?php echo $node_auth; ?>" placeholder="Авторизация - логин" id="input-node_auth" class="form-control" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-node_password">Авторизация - пароль</label>
						<div class="col-sm-10">
							<input type="text" name="node_password" value="<?php echo $node_password; ?>" placeholder="Авторизация - логин" id="input-node_password" class="form-control" />
						</div>
					</div>
				
					
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>