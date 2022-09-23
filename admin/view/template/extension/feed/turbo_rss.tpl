<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">  

        
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                    <select name="turbo_rss_status" class="form-control">
                        <?php if ($turbo_rss_status && $turbo_rss_status == 1) { ?>
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
                <label class="col-sm-2 control-label"><?php echo $entry_limit; ?></label>
                <div class="col-sm-10">
                    <input name="turbo_rss_limit" type="text" value="<?php echo $turbo_rss_limit ? $turbo_rss_limit : '100'; ?>" class="form-control">
                    <?php if ($error_limit) { ?>
                        <span class="error"><?php echo $error_limit; ?></span>
                    <?php } ?>
                </div>
            </div>


		

    		<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_price; ?></label>
                <div class="col-sm-10"><input type="checkbox" name="turbo_rss_show_price" value="1"<?php echo $turbo_rss_show_price == 1 ? ' checked="checked"' : ''; ?>>
    		 </div>
            </div>


			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_include_tax; ?></label>
                <div class="col-sm-10"><input type="checkbox" name="turbo_rss_include_tax" value="1"<?php echo $turbo_rss_include_tax == 1 ? ' checked="checked"' : ''; ?>>
    		</div>
            </div>


    		<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_image; ?></label>
                <div class="col-sm-10"><input type="checkbox" name="turbo_rss_show_image" value="1"<?php echo $turbo_rss_show_image == 1 ? ' checked="checked"' : ''; ?>>
    		</div>
            </div>


    		<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image_size; ?></label>
                <div class="col-sm-10"><input type="text" size="3" value="<?php echo $turbo_rss_image_width; ?>" name="turbo_rss_image_width">
    			x
    			<input type="text" size="3" value="<?php echo $turbo_rss_image_height; ?>" name="turbo_rss_image_height">
			<?php if ($error_image_dimensions) { ?>
    			<span class="error"><?php echo $error_image_dimensions; ?></span>
			<?php } ?>
    		</div>
            </div>


    		<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_data_feed; ?></label>
                <div class="col-sm-10">
                    <?php foreach ($data_feed as $feed){
                        echo '<a target="_blank" href="'.$feed.'">'.$feed.'</a><br>';
                    } ?>
                </div>
            </div>

        </form>
        </div>
    </div>
</div>
</div>
<?php echo $footer; ?>