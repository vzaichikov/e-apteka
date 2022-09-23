<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-metaseo_anypage" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-metaseo_anypage" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-settings" data-toggle="tab"><i class="fa fa-cog"></i> <?php echo $tab_settings; ?></a></li>
						<li><a href="#tab-help" data-toggle="tab"><i class="fa fa-comment"></i> <?php echo $tab_help; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-settings">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-metaseo_anypage_status"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
								<?php $checked = ($metaseo_anypage_status)? 'checked="checked"':''; ?>
									<label class="switcher" title="<?php echo $entry_status; ?>">
									<input name="metaseo_anypage_status" id="input-metaseo_anypage_status" value="1" type="checkbox" <?php echo $checked; ?>>
									<span><span></span></span></label>							
								</div>
							</div>
							<?php $page_row = 0; ?>
<fieldset id="pages">							
							<?php foreach ($metaseo_anypage_routes as $metaseo_anypage) { ?>
							<?php if (isset($metaseo_anypage['route']) && $metaseo_anypage['route']) { ?>
							<div class="form-group">
								<div class="col-sm-3">Route
									<input type="text" class="form-control" name="metaseo_anypage_routes[<?php echo $page_row; ?>][route]" value="<?php echo $metaseo_anypage['route']; ?>" />
								</div>
								<div class="col-sm-8">
								title
								<?php foreach ($languages as $language) { ?>
								<div class="input-group">
									<span class="input-group-addon"><img title="<?php echo $language['name']; ?>" src="<?php echo $language['image']; ?>"></span>
									<input type="text" class="form-control" name="metaseo_anypage_routes[<?php echo $page_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($metaseo_anypage['title'][$language['language_id']])?$metaseo_anypage['title'][$language['language_id']]:''; ?>" >
								</div>
								<?php } ?>
								<hr />
								meta_description
								<?php foreach ($languages as $language) { ?>
								<div class="input-group">
									<span class="input-group-addon"><img title="<?php echo $language['name']; ?>" src="<?php echo $language['image']; ?>"></span>
									<input type="text" class="form-control" name="metaseo_anypage_routes[<?php echo $page_row; ?>][meta_description][<?php echo $language['language_id']; ?>]" value="<?php echo isset($metaseo_anypage['meta_description'][$language['language_id']])?	$metaseo_anypage['meta_description'][$language['language_id']]:''; ?>" >
								</div>
								<?php } ?>
								</div>
								<div class="col-sm-1">
									<button type="button" class="btn btn-danger" onclick="$(this).closest('.form-group').remove()"><i class="fa fa-minus-circle"></i></button>
								</div>
							</div>
							<?php }	?>
							<?php $page_row++; ?>
							<?php }	?>
</fieldset>							
							<div class="form-group">
								<div class="col-sm-12">
									<button type="button" onclick="addPage()" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add</button>
								</div>
							</div>

						</div>
						<div class="tab-pane" id="tab-help">
						<?php echo $text_support; ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<style>
label.switcher input[type="checkbox"] {display:none}
label.switcher input[type="checkbox"] + span {position:relative;display:inline-block;vertical-align:middle;width:36px;height:17px;margin:0 5px 0 0;background:#ccc;border:solid 1px #999;border-radius:10px;box-shadow:inset 0 1px 2px #999;cursor:pointer;transition:all ease-in-out .2s;}
label.switcher input[type="checkbox"]:checked + span {background:#8fbb6c;border:solid 1px #7da35e;}
label.switcher input[type="checkbox"]:checked + span span {right:0;left:auto}
label.switcher span span{position:absolute;background:white;height:17px;width:17px;display:inlaine-box;left:0;top:-1px;border-radius:50%}
</style>
<script type="text/javascript">
var page_row = <?php echo $page_row; ?>;
function addPage() {
	var html = '';
	html += '\
	<div class="form-group">\
		<div class="col-sm-3">Route\
			<input type="text" class="form-control" name="metaseo_anypage_routes[' + page_row + '][route]" value="" /> \
		</div>\
		<div class="col-sm-8">title';
		<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group">\
		<span class="input-group-addon"><img title="<?php echo $language['name']; ?>" src="<?php echo $language['image']; ?>"></span>\
		<input type="text" class="form-control" name="metaseo_anypage_routes[' + page_row + '][title][<?php echo $language['language_id']; ?>]" value="" />\
	</div>';
		<?php } ?>
	html += '<hr />';
	html += 'meta_description';
		<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group">\
		<span class="input-group-addon"><img title="<?php echo $language['name']; ?>" src="<?php echo $language['image']; ?>"></span>\
		<input type="text" class="form-control" name="metaseo_anypage_routes[' + page_row + '][meta_description][<?php echo $language['language_id']; ?>]" value="" />\
	</div>';
		<?php } ?>
	html += '</div>';
	html += '<div class="col-sm-1">\
		<button type="button" class="btn btn-danger" onclick="$(this).closest(\'.form-group\').remove()"><i class="fa fa-minus-circle"></i></button>\
	</div>\
	</div>';
	$('#pages').append(html);

	page_row++;
}

</script>

<?php echo $footer; ?>