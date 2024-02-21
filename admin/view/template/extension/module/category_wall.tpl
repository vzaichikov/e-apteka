<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category-wall-lite" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($error_width) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_width; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php } ?>
  <?php if ($error_height) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_height; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php } ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
    <span class="pull-right"><?php echo $text_info; ?>  | <a target="_blank" href="https://opencart.su/extension/prostaya-stena-kategorij/"><?php echo $text_page_module; ?></a>  | <a href="https://opencart.su" target="_blank"><img src="https://opencart.su/image/logo.svg" height="22px"></a></span>
  </div>
  <div class="panel-body">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category-wall-lite" class="form-horizontal">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
        <div class="col-sm-4">
          <select name="category_wall_status" id="input-status" class="form-control">
            <?php if ($category_wall_status) { ?>
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
        <label class="col-sm-2 control-label" for="input-type">Тип</label>
        <div class="col-sm-4">
          <select name="category_wall_type" id="input-type" class="form-control">
            <?php if ($category_wall_type == 'viewed') { ?>
              <option value="viewed" selected="selected">Просмотры</option>
              <option value="bought">Покупки</option>
            <?php } else { ?>
              <option value="viewed">Просмотры</option>
              <option value="bought" selected="selected">Покупки</option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group required">
       <label class="col-sm-2 control-label" for="category-category_wall_category_limit">Лимит категорий</label>
       <div class="col-sm-4">
        <input type="text" name="category_wall_category_limit" value="<?php echo $category_wall_category_limit; ?>" placeholder="5" id="category_wall_category_limit" class="form-control" />
      </div>      
    </div>

    <div class="form-group required">
       <label class="col-sm-2 control-label" for="category-category_wall_product_limit">Лимит товаров</label>
       <div class="col-sm-4">
        <input type="text" name="category_wall_product_limit" value="<?php echo $category_wall_product_limit; ?>" placeholder="5" id="category_wall_product_limit" class="form-control" />
      </div>      
    </div>

    <div class="form-group required">
       <label class="col-sm-2 control-label" for="category-category_wall_product_threshold">Threshold</label>
       <div class="col-sm-4">
        <input type="text" name="category_wall_product_threshold" value="<?php echo $category_wall_product_threshold; ?>" placeholder="5" id="category_wall_product_threshold" class="form-control" />
      </div>      
    </div>

      <div class="form-group required">
       <label class="col-sm-2 control-label" for="category-wall-width"><?php echo $entry_width; ?></label>
       <div class="col-sm-4">
        <input type="text" name="category_wall_width" value="<?php echo $category_wall_width; ?>" placeholder="<?php echo $entry_width; ?>" id="category-wall-width" class="form-control" />
      </div>      
    </div>

    <div class="form-group required">
     <label class="col-sm-2 control-label" for="category-wall-width"><?php echo $entry_height; ?></label>
     <div class="col-sm-4">
      <input type="text" name="category_wall_height" value="<?php echo $category_wall_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
    </div>
  </div>


</form>
</div>
</div>
</div>
</div>
<?php echo $footer; ?>