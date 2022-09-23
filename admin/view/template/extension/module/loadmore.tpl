<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-loadmore" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-loadmore" class="form-horizontal">    
          <div class="tab-pane">
            <ul class="nav nav-tabs" id="language">
              <?php foreach ($languages as $language) { ?>
              <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
              <?php } ?>
            </ul>
            <div class="tab-content">
              <?php foreach ($languages as $language) { ?>
              <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="loadmore_button_name_<?php echo $language['language_id']; ?>"><?php echo $loadmore_button_name_title; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="loadmore_button_name_<?php echo $language['language_id']; ?>" placeholder="<?php echo $loadmore_button_name; ?>" id="loadmore_button_name_<?php echo $language['language_id']; ?>" value="<?php echo isset(${'loadmore_button_name_'.$language['language_id']}) ? ${'loadmore_button_name_'.$language['language_id']} : ''; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group" style="border-top: 1px solid #ededed;">
            <label class="col-sm-2 control-label" for="loadmore_style"><?php echo $loadmore_style_title; ?></label>
      			<div class="col-sm-10">
      				<textarea name="loadmore_style" placeholder="<?php echo $loadmore_style_title; ?>" id="loadmore_style" rows="5" class="form-control"><?php echo isset($loadmore_style) ? $loadmore_style : ''; ?></textarea>
      			</div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-arrow_status"><?php echo $loadmore_arrow_status_title; ?></label>
            <div class="col-sm-10">
              <select name="loadmore_arrow_status" id="input-arrow_status" class="form-control">
                <?php if ($loadmore_arrow_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-status"><?php echo $loadmore_status_title; ?></label>
            <div class="col-sm-10">
              <select name="loadmore_status" id="input-status" class="form-control">
                <?php if ($loadmore_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>