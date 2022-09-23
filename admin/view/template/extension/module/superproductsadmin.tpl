<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<link href="view/stylesheet/superproduct.css" rel="stylesheet" />
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-superproducts-admin" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-superproducts-admin" class="form-horizontal">
          <h2><?php echo $TEXT_FUNCTIONAL_SETTINGS; ?></h2>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_SINGLEMOD_TPL; ?></label>
            <div class="col-sm-10">
              <select name="superproductsadmin_singlemod_tpl" class="form-control">
                <option value="superproducts.tpl" <?php if ($superproductsadmin_singlemod_tpl == 'superproducts.tpl') { ?>selected="selected"<?php } ?>>SuperProducts.tpl</option>
                <option value="latest.tpl" <?php if ($superproductsadmin_singlemod_tpl == 'latest.tpl') { ?>selected="selected"<?php } ?>>Latest.tpl</option>
                <option value="special.tpl" <?php if ($superproductsadmin_singlemod_tpl == 'special.tpl') { ?>selected="selected"<?php } ?>>Special.tpl</option>
                <option value="featured.tpl" <?php if ($superproductsadmin_singlemod_tpl == 'featured.tpl') { ?>selected="selected"<?php } ?>>Featured.tpl</option>
                <option value="bestseller.tpl" <?php if ($superproductsadmin_singlemod_tpl == 'bestseller.tpl') { ?>selected="selected"<?php } ?>>BestSeller.tpl</option>
                <option value="superproducts_single.tpl" <?php if ($superproductsadmin_singlemod_tpl == 'superproducts_single.tpl') { ?>selected="selected"<?php } ?>>Custom Tpl Provided via support</option>
              </select>
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_TABSMOD_TPL; ?></label>
            <div class="col-sm-10">
              <select name="superproductsadmin_tabsmodmod_tpl" class="form-control">
                <option value="superproducts.tpl" <?php if ($superproductsadmin_tabsmodmod_tpl == 'superproducts.tpl') { ?>selected="selected"<?php } ?>>SuperProducts.tpl</option>
                <option value="latest.tpl" <?php if ($superproductsadmin_tabsmodmod_tpl == 'latest.tpl') { ?>selected="selected"<?php } ?>>Latest.tpl</option>
                <option value="special.tpl" <?php if ($superproductsadmin_tabsmodmod_tpl == 'special.tpl') { ?>selected="selected"<?php } ?>>Special.tpl</option>
                <option value="featured.tpl" <?php if ($superproductsadmin_tabsmodmod_tpl == 'featured.tpl') { ?>selected="selected"<?php } ?>>Featured.tpl</option>
                <option value="bestseller.tpl" <?php if ($superproductsadmin_tabsmodmod_tpl == 'bestseller.tpl') { ?>selected="selected"<?php } ?>>BestSeller.tpl</option>
                <option value="superproducts_intab.tpl" <?php if ($superproductsadmin_tabsmodmod_tpl == 'superproducts_intab.tpl') { ?>selected="selected"<?php } ?>>Custom Tpl Provided via support</option>
              </select>
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_VIEWALL_INTAB; ?></label>
            <div class="col-sm-10">
               <div class="btn-group selectbuts">
                <?php if ($superproductsadmin_viewlink_pos) { ?>
                  <button type="button" class="btn btn-default" data-value="0"><?php echo $TEXT_VIEWALL_INTAB_DOWN; ?></button>
                  <button type="button" class="btn btn-info" data-value="1"><?php echo $TEXT_VIEWALL_INTAB_UP; ?></button>
                <?php } else { ?>
                  <button type="button" class="btn btn-info" data-value="0"><?php echo $TEXT_VIEWALL_INTAB_DOWN; ?></button>
                  <button type="button" class="btn btn-default" data-value="1"><?php echo $TEXT_VIEWALL_INTAB_UP; ?></button>
                <?php } ?>
              </div>
              <input type="hidden" name="superproductsadmin_viewlink_pos" value="<?php echo $superproductsadmin_viewlink_pos; ?>" />
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_TITLE_REGEX; ?></label>
            <div class="col-sm-10">
               <button type="button" class="btn btn-default showhidchange"><?php echo $TEXT_CHANGE; ?></button>
               <div class="hidchange" style="display: none">
                 <?php echo $TEXT_REGEX_CAUTION; ?>
                 <textarea class="form-control" name="superproductsadmin_title_regex"><?php echo $superproductsadmin_title_regex ; ?></textarea>
               </div>
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_SUPERP_CACHE; ?></label>
            <div class="col-sm-10">
               <div class="btn-group selectbuts">
                <?php if ($superproductsadmin_enable_cache) { ?>
                  <button type="button" class="btn btn-default" data-value="0"><?php echo $TEXT_DISABLED; ?></button>
                  <button type="button" class="btn btn-info" data-value="1"><?php echo $TEXT_ENABLED; ?></button>
                <?php } else { ?>
                  <button type="button" class="btn btn-info" data-value="0"><?php echo $TEXT_DISABLED; ?></button>
                  <button type="button" class="btn btn-default" data-value="1"><?php echo $TEXT_ENABLED; ?></button>
                <?php } ?>
              </div>
              <input type="hidden" name="superproductsadmin_enable_cache" value="<?php echo $superproductsadmin_enable_cache; ?>" />
            </div>
          </div> 

          <h2><?php echo $TEXT_LANGUAGE_SETTINGS; ?></h2>

          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_VIEWALL_TAG; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
               <div class="input-group">
                 <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                 <input type="text" name="superproductsadmin_langvars[<?php echo $language['language_id']; ?>][tag_view_link]" value="<?php echo isset($superproductsadmin_langvars[$language['language_id']]['tag_view_link']) ? $superproductsadmin_langvars[$language['language_id']]['tag_view_link'] : ''; ?>" placeholder="<?php echo $TEXT_VIEWALL_TAG; ?>" class="form-control" />
               </div>
              <?php } ?>
            </div>
          </div> 

          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_VIEWALL_CAT; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
               <div class="input-group">
                 <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                 <input type="text" name="superproductsadmin_langvars[<?php echo $language['language_id']; ?>][cat_view_link]" value="<?php echo isset($superproductsadmin_langvars[$language['language_id']]['cat_view_link']) ? $superproductsadmin_langvars[$language['language_id']]['cat_view_link'] : ''; ?>" placeholder="<?php echo $TEXT_VIEWALL_CAT; ?>" class="form-control" />
               </div>
              <?php } ?>
            </div>
          </div> 

          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $TEXT_VIEWALL_MAN; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
               <div class="input-group">
                 <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                 <input type="text" name="superproductsadmin_langvars[<?php echo $language['language_id']; ?>][man_view_link]" value="<?php echo isset($superproductsadmin_langvars[$language['language_id']]['man_view_link']) ? $superproductsadmin_langvars[$language['language_id']]['man_view_link'] : ''; ?>" placeholder="<?php echo $TEXT_VIEWALL_MAN; ?>" class="form-control" />
               </div>
              <?php } ?>
            </div>
          </div> 

        </form>
      </div>
    </div>
  </div>
</div> 
<script type="text/javascript"><!--

$('.selectbuts button').on('click', function() {
  $(this).parent().parent().find('input').val($(this).data('value'));
  $(this).parent().find('button').attr("class", "btn btn-default");
  $(this).addClass('btn-info');
});
$('.showhidchange').on('click', function () {
  $(this).toggleClass('btn-info');
  $(this).next('.hidchange').slideToggle();
});

//--></script> 
<?php echo $footer; ?>