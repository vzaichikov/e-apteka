<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<link href="view/stylesheet/superproduct.css" rel="stylesheet" />
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-superproducts" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-superproducts" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $TEXT_MODULE_TYPE; ?></label>
            <div class="col-sm-10">
              <div class="btn-group selectbuts">
                <?php if ($module_type) { ?>
                  <button type="button" class="btn btn-default" data-cdiv="single_module" data-value="0"><?php echo $TEXT_SINGLE_MODULE; ?></button>
                  <button type="button" class="btn btn-info" data-cdiv="tabs_module" data-value="1"><?php echo $TEXT_TABS_MODULE; ?></button>
                <?php } else { ?>
                  <button type="button" class="btn btn-info" data-cdiv="single_module" data-value="0"><?php echo $TEXT_SINGLE_MODULE; ?></button>
                  <button type="button" class="btn btn-default"  data-cdiv="tabs_module" data-value="1"><?php echo $TEXT_TABS_MODULE; ?></button>
                <?php } ?>
              </div>
              <input type="hidden" name="module_type" value="<?php echo $module_type; ?>" />
            </div>
          </div>
<div class="mtype single_module" <?php if (!$module_type) { ?>style="display: block"<?php } ?>>
  <div class="form-group">
    <label class="col-sm-2 control-label"><?php echo $TEXT_FRONT_NAME; ?></label>
    <div class="col-sm-10">
      <?php foreach ($languages as $language) { ?>
        <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
          <input type="text" name="fname[<?php echo $language['language_id']; ?>]" value="<?php echo isset($fname[$language['language_id']]) ? $fname[$language['language_id']] : ''; ?>" placeholder="<?php echo $TEXT_FRONT_NAME; ?>" class="form-control" />
        </div>
      <?php } ?>
    </div>
  </div>   
  <div class="form-group">
    <label class="col-sm-2 control-label"><?php echo $TEXT_PRODUCT_GROUP; ?></label>
    <div class="col-sm-10">
      <select name="product_group" class="form-control pgroup">
        <option value="bycat" <?php echo  $product_group == 'bycat' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_BY_CATEGORY; ?></option>
        <option value="byman" <?php echo  $product_group == 'byman' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_BY_MANUFACTURER; ?></option>
        <option value="bytag" <?php echo  $product_group == 'bytag' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_BY_TAG; ?></option>
        <option value="popular" <?php echo  $product_group == 'popular' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_POPULAR; ?></option>
        <option value="random" <?php echo  $product_group == 'random' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_RANDOM; ?></option>
        <option value="last" <?php echo  $product_group == 'last' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_LAST_VIEWED; ?></option>
        <option value="bought" <?php echo  $product_group == 'bought' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_ALSO_BOUGHT; ?></option>
        <option value="related" <?php echo  $product_group == 'related' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_RELATED; ?></option>
      </select>
      <div class="row bycat byman bytag bydiv">
        <div class="col-sm-6 pgroupa">
          <div class="bycat bydiv">
            <?php  echo $TEXT_SELECT_CATEGORY; ?>
            <select name="category" class="form-control" <?php echo $active_cat ? 'disabled' : ''; ?>>
              <?php foreach ($categories as $cat) { ?>
                <option value="<?php echo $cat['category_id'] ?>" <?php echo  $category == $cat['category_id'] ? $s : ''; ?>><?php echo $cat['name'] ?></option>
              <?php } ?>
            </select>
            <div class="row mt10">
              <div class="col-sm-6">
                <button type="button" class="disbtn form-control btn <?php echo $active_cat ? 'btn-info' : 'btn-default'; ?>" data-value="1"><?php echo $active_cat ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_FROM_ACTIVE_CATEGORY; ?></button>
                <input class="active-item" type="hidden" name="active_cat" value="<?php echo $active_cat ?>" />
              </div>
              <div class="col-sm-6">
                 <button type="button" class="disbtn2 form-control btn <?php echo $viewall_link_c ? 'btn-info' : 'btn-default'; ?>" <?php echo $active_cat ? 'disabled="disabled"' : ''; ?>><?php echo $viewall_link_c ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button>
                 <input class="viewall" type="hidden" name="viewall_link_c" value="<?php echo $viewall_link_c ?>" />
              </div>
            </div>
          </div>
          <div class="byman bydiv">
            <?php echo $TEXT_SELECT_BRAND; ?>
            <select name="brand" class="form-control" <?php echo $active_brand ? 'disabled' : ''; ?>>
              <?php foreach ($brands as $br) { ?>
                <option value="<?php echo $br['manufacturer_id'] ?>" <?php echo  $brand == $br['manufacturer_id'] ? $s : ''; ?>><?php echo $br['name'] ?></option>
              <?php } ?>
            </select>
            <div class="row mt10">
              <div class="col-sm-6">
                <button type="button" class="disbtn form-control btn <?php echo $active_brand ? 'btn-info' : 'btn-default'; ?>" data-value="1"><?php echo $active_brand ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_FROM_ACTIVE_BRAND; ?></button>
                <input type="hidden" name="active_brand" value="<?php echo $active_brand ?>" />
              </div>
              <div class="col-sm-6">
                 <button type="button" class="disbtn2 form-control btn <?php echo $viewall_link_m ? 'btn-info' : 'btn-default'; ?>" <?php echo $active_brand ? 'disabled="disabled"' : ''; ?>><?php echo $viewall_link_m ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button>
                 <input class="viewall" type="hidden" name="viewall_link_m" value="<?php echo $viewall_link_m ?>" />
              </div>
            </div>
          </div>
          <div class="bytag bydiv">
            <?php echo $TEXT_INPUT_TAG; ?>
            <input type="text" name="tag" class="form-control" value="<?php echo $tag; ?>" />
            <div class="row mt10">
              <div class="col-sm-12">
                 <button type="button" class="disbtn2 form-control btn <?php echo $viewall_link_t ? 'btn-info' : 'btn-default'; ?>" data-value="1"><?php echo $viewall_link_t ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button>
                 <input class="viewall" type="hidden" name="viewall_link_t" value="<?php echo $viewall_link_t ?>" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 pgroupb">
          <div class="">
            <?php echo $TEXT_PRODUCT_TYPE; ?>
            <select name="product_group_b" class="form-control pgroupb">
              <option value="latest" <?php echo  $product_group_b == 'latest' ? $s : ''; ?>><?php echo $TEXT_LATEST_PRODUCTS; ?></option>
              <option value="special" <?php echo  $product_group_b == 'special' ? $s : ''; ?>><?php echo $TEXT_SPECIAL_PRODUCTS; ?></option>
              <option value="bestseller" <?php echo  $product_group_b == 'bestseller' ? $s : ''; ?>><?php echo $TEXT_BESTSELLER_PRODUCTS; ?></option>
              <option value="random" <?php echo  $product_group_b == 'random' ? $s : ''; ?>><?php echo $TEXT_RANDOM_PRODUCTS; ?></option>
              <option value="popular" <?php echo  $product_group_b == 'popular' ? $s : ''; ?>><?php echo $TEXT_POPULAR_PRODUCTS; ?></option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>    
</div>
<div class="mtype tabs_module" <?php if ($module_type) { ?>style="display: block"<?php } ?>>
<div class="table-responsive">
  <table id="supertabs" class="table table-bordered table-striped">
    <thead>
      <tr>
        <td class="text-left">
          <?php echo $TEXT_FRONT_NAME_TAB; ?>
        </td>
        <td class="text-left">
          <?php echo $TEXT_PRODUCT_GROUP; ?>
        </td>
        <td class="text-left">
          <?php echo $TEXT_SORT_ORDER; ?>
        </td>
        <td class="text-right">
          &nbsp;
        </td>
      </tr>
    </thead>
    <tbody>
      <?php $i = 0; ?>
      <?php foreach ($supertabs as $supertab) { $i++; ?>
        <tr id="rrow<?php echo $i; ?>">
          <td class="text-left" style="max-width: 250px;">
            <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="supertabs[<?php echo $i; ?>][fname][<?php echo $language['language_id']; ?>]" value="<?php echo isset($supertab['fname'][$language['language_id']]) ? $supertab['fname'][$language['language_id']] : ''; ?>" placeholder="<?php echo $TEXT_FRONT_NAME_TAB; ?>" class="form-control" />
              </div>
            <?php } ?>
          </td>
          <td class="text-left">
            <select name="supertabs[<?php echo $i; ?>][product_group]" class="form-control pgroup">
              <?php $pgr = $supertab['product_group']; ?>
              <option value="bycat" <?php echo  $pgr == 'bycat' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_BY_CATEGORY; ?></option>
              <option value="byman" <?php echo  $pgr == 'byman' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_BY_MANUFACTURER; ?></option>
              <option value="bytag" <?php echo  $pgr == 'bytag' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_BY_TAG; ?></option>
              <option value="popular" <?php echo  $pgr == 'popular' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_POPULAR; ?></option>
              <option value="random" <?php echo  $pgr == 'random' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_RANDOM; ?></option>
              <option value="last" <?php echo  $pgr == 'last' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_LAST_VIEWED; ?></option>
              <option value="bought" <?php echo  $pgr == 'bought' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_ALSO_BOUGHT; ?></option>
              <option value="related" <?php echo  $pgr == 'related' ? $s : ''; ?>><?php echo $TEXT_PRODUCTS_RELATED; ?></option>
            </select>
            <div class="bycat byman bytag bydiv">
              <div class="">
                  <?php echo $TEXT_PRODUCT_TYPE; ?>
                  <?php $pgrb = $supertab['product_group_b']; ?>
                  <select name="supertabs[<?php echo $i; ?>][product_group_b]" class="form-control pgroupb">
                    <option value="latest" <?php echo  $pgrb  == 'latest' ? $s : ''; ?>><?php echo $TEXT_LATEST_PRODUCTS; ?></option>
                    <option value="special" <?php echo  $pgrb  == 'special' ? $s : ''; ?>><?php echo $TEXT_SPECIAL_PRODUCTS; ?></option>
                    <option value="bestseller" <?php echo  $pgrb  == 'bestseller' ? $s : ''; ?>><?php echo $TEXT_BESTSELLER_PRODUCTS; ?></option>
                    <option value="random" <?php echo  $pgrb  == 'random' ? $s : ''; ?>><?php echo $TEXT_RANDOM_PRODUCTS; ?></option>
                    <option value="popular" <?php echo  $pgrb  == 'popular' ? $s : ''; ?>><?php echo $TEXT_POPULAR_PRODUCTS; ?></option>
                  </select>
              </div>
              <div class="bycat bydiv">
                <?php  echo $TEXT_SELECT_CATEGORY; ?>
                  <select name="supertabs[<?php echo $i; ?>][category]" class="form-control" <?php echo $supertab['active_cat'] ? 'disabled' : ''; ?>>
                  <?php foreach ($categories as $cat) { ?>
                    <option value="<?php echo $cat['category_id'] ?>" <?php echo  $supertab['category'] == $cat['category_id'] ? $s : ''; ?>><?php echo $cat['name'] ?></option>
                  <?php } ?>
                </select>
                <div class="row mt10">
                  <div class="col-sm-6">
                    <button type="button" class="disbtn form-control btn <?php echo $supertab['active_cat'] ? 'btn-info' : 'btn-default'; ?>" data-value="1"><?php echo $supertab['active_cat'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_FROM_ACTIVE_CATEGORY; ?></button>
                    <input class="active-item" type="hidden" name="supertabs[<?php echo $i; ?>][active_cat]" value="<?php echo $supertab['active_cat'] ?>" />
                  </div>
                  <div class="col-sm-6">
                    <button type="button" class="disbtn2 form-control btn <?php echo $supertab['viewall_link_c'] ? 'btn-info' : 'btn-default'; ?>" <?php echo $supertab['active_cat'] ? 'disabled="disabled"' : ''; ?>><?php echo $supertab['viewall_link_c'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button>
                    <input class="viewall" type="hidden" name="supertabs[<?php echo $i; ?>][viewall_link_c]" value="<?php echo $supertab['viewall_link_c'] ?>" />
                </div>
              </div>
              </div>
              <div class="byman bydiv">
                <?php echo $TEXT_SELECT_BRAND; ?>
                <select name="supertabs[<?php echo $i; ?>][brand]" class="form-control" <?php echo $supertab['active_brand'] ? 'disabled' : ''; ?>>
                  <?php foreach ($brands as $br) { ?>
                    <option value="<?php echo $br['manufacturer_id'] ?>" <?php echo  $supertab['brand'] == $br['manufacturer_id'] ? $s : ''; ?>><?php echo $br['name'] ?></option>
                  <?php } ?>
                </select>
                <div class="row mt10">
                  <div class="col-sm-6">
                    <button type="button" class="disbtn form-control btn <?php echo $supertab['active_brand'] ? 'btn-info' : 'btn-default'; ?>" data-value="1"><?php echo $supertab['active_brand'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_FROM_ACTIVE_BRAND; ?></button>
                    <input type="hidden" name="supertabs[<?php echo $i; ?>][active_brand]" value="<?php echo $supertab['active_brand'] ?>" />
                  </div>
                  <div class="col-sm-6">
                    <button type="button" class="disbtn2 form-control btn <?php echo $supertab['viewall_link_m'] ? 'btn-info' : 'btn-default'; ?>" <?php echo $supertab['active_brand'] ? 'disabled="disabled"' : ''; ?>><?php echo $supertab['viewall_link_m'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button>
                    <input class="viewall" type="hidden" name="supertabs[<?php echo $i; ?>][viewall_link_m]" value="<?php echo $supertab['viewall_link_m'] ?>" />
                  </div>
                </div>
              </div>
              <div class="bytag bydiv">
                <?php echo $TEXT_INPUT_TAG; ?>
                <input type="text" name="supertabs[<?php echo $i; ?>][tag]" class="form-control" value="<?php echo $supertab['tag']; ?>" />
                <div class="mt10">
                  <button type="button" class="disbtn2 form-control btn <?php echo $supertab['viewall_link_t'] ? 'btn-info' : 'btn-default'; ?>" data-value="1"><?php echo $supertab['viewall_link_t'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button>
                  <input class="viewall" type="hidden" name="supertabs[<?php echo $i; ?>][viewall_link_t]" value="<?php echo $supertab['viewall_link_t'] ?>" />
                </div>
              </div>
            </div>
          </td>
          <td class="text-left">
            <input class="form-control" type="text" name="supertabs[<?php echo $i; ?>][order]" value="<?php echo $supertab['order']; ?>" />
          </td>
          <td class="text-right">
            <button class="btn btn-danger btn-lg remrow" onclick="remrow(<?php echo $i; ?>);"><i class="fa fa-minus"></i></button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3"></td>
        <td class="text-right">
          <button class="btn btn-success btn-lg" onclick="addTab();"><i class="fa fa-plus"></i></button>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
</div>         
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
              <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
            <div class="col-sm-10">
              <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
              <?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?>
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
  $('.mtype').css('display', 'none');
  $('.'+$(this).data('cdiv')).css('display', 'block');
});
$(document).on('click', '.disbtn', function() {
  if ($(this).hasClass('btn-default')) {
    $(this).removeClass('btn-default');
    $(this).addClass('btn-info');
    $(this).parent().parent().parent().find('select').attr('disabled', 'disabled');
    $(this).parent().parent().find('.disbtn2').attr('disabled', 'disabled');
    $(this).parent().find('input').val(1);
    $(this).find('.fa-times').addClass('fa-check');
    $(this).find('.fa-times').removeClass('fa-times');
  } else {
    $(this).removeClass('btn-info');
    $(this).addClass('btn-default');
    $(this).parent().parent().parent().find('select').removeAttr('disabled');
    $(this).parent().parent().find('.disbtn2').removeAttr('disabled');
    $(this).parent().find('input').val(0);
    $(this).find('.fa-check').addClass('fa-times');
    $(this).find('.fa-check').removeClass('fa-check');
  }
});  
$(document).on('click', '.disbtn2', function() {
  if ($(this).hasClass('btn-default')) {
    $(this).removeClass('btn-default');
    $(this).addClass('btn-info');
    $(this).parent().find('input').val(1);
    $(this).find('.fa-times').addClass('fa-check');
    $(this).find('.fa-times').removeClass('fa-times');
  } else {
    $(this).removeClass('btn-info');
    $(this).addClass('btn-default');
    $(this).parent().find('input').val(0);
    $(this).find('.fa-check').addClass('fa-times');
    $(this).find('.fa-check').removeClass('fa-check');
  }
});

$( document ).ready(function() {
  $(".pgroup").change();
  $('#form-superproducts button').on('click', function (event) {
    event.preventDefault();
  });
});

$(document).on('change','.pgroup',function(){
  $(this).parent().find('.bydiv').slideUp();
  $(this).parent().find('.'+$(this).val()).slideDown();
});
  function addTab () {
    var j = Math.random().toString(36).substr(2);

    var tab = '<tr id="rrow'+j+'"><td class="text-left" style="max-width: 250px;">';
    <?php foreach ($languages as $language) { ?>
    tab += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="supertabs['+j+'][fname][<?php echo $language['language_id']; ?>]" value="" placeholder="<?php echo $TEXT_FRONT_NAME_TAB; ?>" class="form-control" /></div>';
    <?php } ?>
    tab += '</td><td class="text-left">';
    tab += '  <select name="supertabs['+j+'][product_group]" class="form-control pgroup pgroup'+j+'">';
    tab += '    <option value="bycat"><?php echo $TEXT_PRODUCTS_BY_CATEGORY; ?></option><option value="byman"><?php echo $TEXT_PRODUCTS_BY_MANUFACTURER; ?></option><option value="bytag"><?php echo $TEXT_PRODUCTS_BY_TAG; ?></option><option value="popular"><?php echo $TEXT_PRODUCTS_POPULAR; ?></option><option value="random"><?php echo $TEXT_PRODUCTS_RANDOM; ?></option><option value="last"><?php echo $TEXT_PRODUCTS_LAST_VIEWED; ?></option><option value="bought"><?php echo $TEXT_PRODUCTS_ALSO_BOUGHT; ?></option><option value="related"><?php echo $TEXT_PRODUCTS_RELATED; ?></option>';
    tab += '  </select>';
    tab += '  <div class="bycat byman bytag bydiv">';
    tab += '    <div>';
    tab += '      <?php echo $TEXT_PRODUCT_TYPE; ?><select name="supertabs['+j+'][product_group_b]" class="form-control pgroupb">';
    tab += '       <option value="latest"><?php echo $TEXT_LATEST_PRODUCTS; ?></option><option value="special"><?php echo $TEXT_SPECIAL_PRODUCTS; ?></option><option value="bestseller"><?php echo $TEXT_BESTSELLER_PRODUCTS; ?></option><option value="random"><?php echo $TEXT_RANDOM_PRODUCTS; ?></option><option value="popular"><?php echo $TEXT_POPULAR_PRODUCTS; ?></option>';
    tab += '      </select>';
    tab += '    </div>';
    tab += '    <div class="bycat bydiv"><?php  echo $TEXT_SELECT_CATEGORY; ?>';
    tab += '      <select name="supertabs['+j+'][category]" class="form-control">';
    <?php foreach ($categories as $cat) { ?>
    tab += '        <option value="<?php echo $cat['category_id'] ?>"><?php echo addslashes($cat['name']); ?></option>';
    <?php } ?>
    tab += '      </select>';
    tab += '      <div class="row mt10">';
    tab +='         <div class="col-sm-6"><button type="button" class="disbtn form-control btn btn-default" data-value="1"><i class="fa fa-times"></i> <?php echo $TEXT_FROM_ACTIVE_CATEGORY; ?></button><input class="active-item" type="hidden" name="supertabs['+j+'][active_cat]" value="" /></div>';
    tab +='         <div class="col-sm-6"><button type="button" class="disbtn2 form-control btn btn-default"><i class="fa fa-times"></i> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button><input class="viewall" type="hidden" name="supertabs['+j+'][viewall_link_c]" value="" /></div>';
    tab += '      </div>';
    tab += '    </div>';
    tab += '    <div class="byman bydiv"><?php echo $TEXT_SELECT_BRAND; ?>';
    tab += '      <select name="supertabs['+j+'][brand]" class="form-control">';
    <?php foreach ($brands as $br) { ?>
    tab += '        <option value="<?php echo $br['manufacturer_id'] ?>"><?php echo addslashes($br['name']); ?></option>';
    <?php } ?>
    tab += '      </select>';
    tab += '      <div class="row mt10">';
    tab +='         <div class="col-sm-6"><button type="button" class="disbtn form-control btn btn-default" data-value="1"><i class="fa fa-times"></i> <?php echo $TEXT_FROM_ACTIVE_BRAND; ?></button><input class="active-item" type="hidden" name="supertabs['+j+'][active_brand]" value="" /></div>';
    tab +='         <div class="col-sm-6"><button type="button" class="disbtn2 form-control btn btn-default"><i class="fa fa-times"></i> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button><input class="viewall" type="hidden" name="supertabs['+j+'][viewall_link_m]" value="" /></div>';
    tab += '      </div>';
    tab += '    </div>';
    tab += '    <div class="bytag bydiv"><?php echo $TEXT_INPUT_TAG; ?>';
    tab += '      <input type="text" name="supertabs['+j+'][tag]" class="form-control" value="" />';
    tab += '      <div class="mt10"><button type="button" class="disbtn2 form-control btn btn-default" data-value="1"><i class="fa fa-times"></i> <?php echo $TEXT_DISPLAY_VIEW_ALL; ?></button> <input class="viewall" type="hidden" name="supertabs['+j+'][viewall_link_t]" value="" /></div>';
    tab += '    </div>';
    tab += '  </div>';
    tab += '</td>';
    tab += '<td class="text-left"><input class="form-control" type="text" name="supertabs['+j+'][order]" value="0" /></td>';
    tab += '<td class="text-right"><button class="btn btn-danger btn-lg remrow" onclick="remrow('+j+');"><i class="fa fa-minus"></i></button></td>';

    $('#supertabs tbody').append(tab);
    $(".pgroup"+j).change();
  }
  function remrow (i) {
    $('#rrow'+i).css('background', '#f00').hide('slow', function(){ $('#rrow'+i).remove(); });
  }
//--></script> 
<?php echo $footer; ?>