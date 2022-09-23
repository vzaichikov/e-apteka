<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-footerlink" class="form-horizontal">
		<ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
        </ul>
		<div class="tab-content">
         <div class="tab-pane active in" id="tab-general">
            <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
            </ul>
			<div class="tab-content">
		   <?php foreach ($languages as $language) { ?>
          <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
			<div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="footerlink_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($footerlink_description[$language['language_id']]) ? $footerlink_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
             </div>
            </div>
            <?php } ?>
			<div class="form-group">
                <label class="col-sm-2 control-label" for="input-link"><?php echo $entry_link; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="link" value="<?php echo $link; ?>"  id="input-link" class="form-control" />
                </div>
              </div>
			  
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-select_heading"><?php echo $entry_select_heading; ?></label>
                <div class="col-sm-10">
				  <select name="selectheading" id="input-select_heading" class="form-control">
					<option value="" selected="selected"><?php echo $text_select ?></option>
					<?php if($footertitle) {?>
                  <?php foreach ($footertitle as $_footer) { ?>
					<?php if($_footer['footertitle_id']==$selectheading){?>
                    <option value="<?php echo $_footer['footertitle_id']; ?>" selected="selected"><?php echo $_footer['title']; ?></option>
                  <?php } else {?>
				  <option value="<?php echo $_footer['footertitle_id']; ?>"><?php echo $_footer['title']; ?></option>
				  <?php } }?>
				  <?php }?>
                </select>
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
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>"  id="input-sort-order" class="form-control" />
                </div>
              </div>
          </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script> 
</div>
<?php echo $footer; ?>