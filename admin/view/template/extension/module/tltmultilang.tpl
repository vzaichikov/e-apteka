<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-html" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($error_library) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_library; ?></div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-html" class="form-horizontal">
		  <?php foreach ($languages as $language) { ?>		
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-meta-title-<?php echo $language['code']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />&nbsp;<?php echo $entry_meta_title; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="tltmultilang_meta_title_<?php echo $language['code']; ?>" value="<?php echo isset($tltmultilang_meta_title[$language['code']]) ? $tltmultilang_meta_title[$language['code']] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title-<?php echo $language['code']; ?>" class="form-control" />
                 <?php if (isset($error_meta_title[$language['code']])) { ?>
                 <div class="text-danger"><?php echo $error_meta_title[$language['code']]; ?></div>
                 <?php } ?>
                </div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-meta-description-<?php echo $language['code']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />&nbsp;<?php echo $entry_meta_description; ?></label>
                <div class="col-sm-10">
                  <textarea name="tltmultilang_meta_description_<?php echo $language['code']; ?>" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description-<?php echo $language['code']; ?>" class="form-control"><?php echo isset($tltmultilang_meta_description[$language['code']]) ? $tltmultilang_meta_description[$language['code']] : ''; ?></textarea>
                </div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-meta-keyword-<?php echo $language['code']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />&nbsp;<?php echo $entry_meta_keyword; ?></label>
                <div class="col-sm-10">
                  <textarea name="tltmultilang_meta_keyword_<?php echo $language['code']; ?>" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword-<?php echo $language['code']; ?>" class="form-control"><?php echo isset($tltmultilang_meta_keyword[$language['code']]) ? $tltmultilang_meta_keyword[$language['code']] : ''; ?></textarea>
                </div>
              </div> 
          <?php } ?>        
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-twitter-status"><span data-toggle="tooltip" title="<?php echo $help_twitter_status; ?>"><?php echo $entry_twitter_status; ?></span></label>
            <div class="col-sm-10">
              <select name="tltmultilang_twitter_status" id="input-twitter-status" class="form-control">
                <?php if ($tltmultilang_twitter_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-twitter-card"><?php echo $entry_twitter_card; ?></label>
            <div class="col-sm-10">
              <select name="tltmultilang_twitter_card" id="input-twitter-card" class="form-control">
                <?php if ($tltmultilang_twitter_card) { ?>
                <option value="1" selected="selected"><?php echo $text_large_image; ?></option>
                <option value="0"><?php echo $text_summary; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_large_image; ?></option>
                <option value="0" selected="selected"><?php echo $text_summary; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-twitter-name"><?php echo $entry_twitter_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="tltmultilang_twitter_name" value="<?php echo $tltmultilang_twitter_name; ?>" placeholder="<?php echo $placeholder_username; ?>" id="input-twitter-name" class="form-control" />
              <?php if ($error_twitter_name) { ?>
              <div class="text-danger"><?php echo $error_twitter_name; ?></div>
              <?php } ?>
            </div>
          </div>         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-facebook-status"><span data-toggle="tooltip" title="<?php echo $help_facebook_status; ?>"><?php echo $entry_facebook_status; ?></span></label>
            <div class="col-sm-10">
              <select name="tltmultilang_facebook_status" id="input-facebook-status" class="form-control">
                <?php if ($tltmultilang_facebook_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-facebook-name"><?php echo $entry_facebook_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="tltmultilang_facebook_name" value="<?php echo $tltmultilang_facebook_name; ?>" placeholder="<?php echo $entry_facebook_name; ?>" id="input-facebook-name" class="form-control" />
              <?php if ($error_facebook_name) { ?>
              <div class="text-danger"><?php echo $error_facebook_name; ?></div>
              <?php } ?>
            </div>
          </div>         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-facebook-appid"><?php echo $entry_facebook_appid; ?></label>
            <div class="col-sm-10">
              <input type="text" name="tltmultilang_facebook_appid" value="<?php echo $tltmultilang_facebook_appid; ?>" placeholder="<?php echo $entry_facebook_appid; ?>" id="input-facebook-appid" class="form-control" />
            </div>
          </div>
          <div class="form-group">
          	<label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $help_image; ?>"><?php echo $entry_image; ?></span></label>
            	<div class="col-sm-10">
                	<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                	<input type="hidden" name="tltmultilang_image" value="<?php echo $tltmultilang_image; ?>" id="input-image" />
             	</div>
        	</div>            
        </form>
      </div>
    </div>
  </div>
<?php echo $footer; ?>