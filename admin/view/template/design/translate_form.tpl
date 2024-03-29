<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-translate" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-translate" class="form-horizontal">
          
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-translate-group"><?php echo $entry_translate_group; ?></label>
            <div class="col-sm-10">
              <input type="text" name="translate_group_id" value="<?php echo $translate_group_id; ?>" id="input-translate-group" class="form-control">
              <?php if ($error_translate_group) { ?>
              <div class="text-danger"><?php echo $error_translate_group; ?></div>
              <?php } ?>
            </div>
          </div>
		  		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="translate_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($translate_description[$language['language_id']]) ? $translate_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-lower"><?php echo $entry_layout; ?></label>
			<div class="col-sm-10">
				<select name="layout_id" class="form-control">
					<option value="0">Все</option>
					<?php foreach ($layouts as $layout) { ?>
						<?php if ($layout_id == $layout['layout_id']) { ?>
							<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		
			<div class="form-group">
			<label class="col-sm-2 control-label" for="input-lower"><?php echo $entry_lower; ?></label>
			<div class="col-sm-10">
				<div class="checkbox">
					<label>
						<?php if ($lower) { ?>
							<input type="checkbox" name="lower" value="1" checked="checked" id="input-lower" />
							<?php } else { ?>
							<input type="checkbox" name="lower" value="1" id="input-lower" />
						<?php } ?>
					&nbsp; </label>
				</div>
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
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
