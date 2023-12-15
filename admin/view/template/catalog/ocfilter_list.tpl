<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="Добавить опцию фильтра" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-product').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-category-id"><?php echo $entry_category; ?></label>
                <select name="filter_category_id" id="input-category-id" class="form-control ocfilter-categories">
                  <option value=""></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if ($category['category_id'] == $filter_category_id) { ?>
                  <option value="<?php echo $category['category_id']; ?>" class="level-<?php echo $category['level']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>" class="level-<?php echo $category['level']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-type"><?php echo $entry_type; ?></label>
                <select name="filter_type" id="input-type" class="form-control">
                  <option value=""></option>
                  <?php foreach ($types as $key => $type) { ?>
                  <?php if ($key == $filter_type) { ?>
                  <option value="<?php echo $key; ?>" selected="selected"><?php echo $type; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value=""></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (($filter_status !== null) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
              <button type="button" onclick="ocfilter.list.filter(); return false;" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked).trigger('change');" /></td>
		              <td class="left"><a href="<?php echo $sort_name; ?>" <?php echo ($sort == 'cod.name' ? 'class="' . strtolower($order) . '"' : ''); ?>><?php echo $column_name; ?></a></td>
		              <td class="left"><?php echo $column_values; ?></td>
		              <td class="left"><?php echo $column_categories; ?></td>
		              <td class="left"><?php echo $column_type; ?></td>
		              <td class="right"><a href="<?php echo $sort_order; ?>" <?php echo ($sort == 'co.sort_order' ? 'class="' . strtolower($order) . '"' : ''); ?>><?php echo $column_sort_order; ?></a></td>
		              <td class="right"><?php echo $column_status; ?></td>
		              <td class="right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($options) { ?>
                <?php foreach ($options as $option) { ?>
                <tr>
                  <td class="text-center">
										<?php if ($option['selected']) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $option['option_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $option['option_id']; ?>" />
                    <?php } ?>
									</td>
		              <td class="left"><input type="text" name="name" value="<?php echo $option['name']; ?>" size="40" class="edit" for="<?php echo $option['option_id']; ?>" /></td>
		              <td class="left"><?php echo $option['values']; ?></td>
		              <td class="left"><?php echo $option['categories']; ?></td>
		              <td class="left">
		                <select class="edit" name="type" for="<?php echo $option['option_id']; ?>">
		                  <option value=""><?php echo $text_none; ?></option>
		                  <?php foreach ($types as $key => $type) { ?>
		                  <option value="<?php echo $key; ?>"<?php echo ($key == $option['type'] ? ' selected="selected"' : ''); ?>><?php echo ucfirst($type); ?></option>
		                  <?php } ?>
		                </select>
									</td>
		              <td class="right"><input type="text" name="sort_order" value="<?php echo $option['sort_order']; ?>" size="6" class="edit" for="<?php echo $option['option_id']; ?>" style="text-align: right;" /></td>
		              <td class="right">
										<?php if ($option['status']) { ?>
										<label><input type="checkbox" class="edit" name="status" value="1" for="<?php echo $option['option_id']; ?>" checked="checked" /><span><?php echo $text_enabled; ?></span></label>
										<?php } else { ?>
										<label><input type="checkbox" class="edit" name="status" value="1" for="<?php echo $option['option_id']; ?>" /><span><?php echo $text_disabled; ?></span></label>
										<?php } ?>
									</td>
		              <td class="right">
                    <a href="<?php echo $option['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
		              </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
	<script type="text/javascript"><!--

	ocfilter.php.filter_get = [];

	<?php foreach ($filter_get as $key) { ?>
	ocfilter.php.filter_get.push('<?php echo $key; ?>');
	<?php } ?>

	ocfilter.php.text_enabled = '<?php echo $text_enabled; ?>';
	ocfilter.php.text_disabled = '<?php echo $text_disabled; ?>';

	//--></script>
</div>
<?php echo $footer; ?>