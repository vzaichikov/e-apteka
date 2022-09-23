<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-brand" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-brand" class="form-horizontal">

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
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-type">
                    <?php echo $entry_type; ?>
                  </label>
                  <div class="col-sm-10">
                    <select id="input-type" class="form-control" name="type" >
                      <option value="1" <?php if ($type=='1') { ?>selected="selected"<?php } ?>><?php echo $text_type1; ?></option>
                      <option value="2" <?php if ($type=='2') { ?>selected="selected"<?php } ?>><?php echo $text_type2; ?></option>
                      <option value="3" <?php if ($type=='3') { ?>selected="selected"<?php } ?>><?php echo $text_type3; ?></option>
                    </select>
                  </div>
          </div>
        
          <div class="form-group">
                <label class="col-sm-2 control-label" for="filter-manufacturer"><?php echo $entry_manufacturer; ?></label>
                <div class="col-sm-10">

                  <label class="radio">
                    <input type="radio" name="all" value="1" <?php if ($all == 1) echo 'checked'; ?>> <?php echo $text_all_manufacturer; ?>
                  </label>
                  <label class="radio">
                    <input type="radio" name="all" value="2" <?php if ($all == 2) echo 'checked'; ?>> <?php echo $text_selected_manufacturer; ?>
                  </label>
                            <div class="row">
                              <div class="col-sm-12">
                   <input type="text" name="filter-manufacturer" value=""
                                                   placeholder="<?php echo $entry_manufacturer; ?>"
                                                   id="filter-manufacturer"
                                                   class="form-control"/>

                                            <div id="manufacturer" class="well well-sm"
                                                 style="height: 150px; overflow: auto;">
                                                  <?php foreach ($manufacturers as $manufacturer) { ?>
                    <div id="manufacturer<?php echo $manufacturer['manufacturer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $manufacturer['name']; ?>
                      <input type="hidden" name="manufacturers[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                    </div>
                    <?php } ?>
                                            </div>
                </div>
                </div>
                </div>
          </div>
       



          <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-thumb_width"><?php echo $entry_thumb_size; ?></label>

                    <div class="col-sm-5">
                    
                      <input type="text" name="thumb_width" value="<?php echo $thumb_width; ?>" placeholder="<?php echo $entry_thumb_width; ?>" id="input-thumb_width" class="form-control" />
                      <?php if ($error_thumb_width) { ?>
                      <div class="text-danger"><?php echo $error_thumb_width; ?></div>
                      <?php } ?>
                    </div>
                    <div class="col-sm-5">
                      <input type="text" name="thumb_height" value="<?php echo $thumb_height; ?>" placeholder="<?php echo $entry_thumb_height; ?>" id="input-thumb_height" class="form-control" />
                      <?php if ($error_thumb_height) { ?>
                      <div class="text-danger"><?php echo $error_thumb_height; ?></div>
                      <?php } ?>
                    </div>
           </div>

           <div id="brand-slider" <?php if ($type!='3') { ?>style="display:none;"<?php } ?>>
           <h3 class="text-center"><?php echo $text_type3; ?></h3>
           <div class="form-group">
                <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $quantity; ?>" id="input-quantity" class="form-control" />
                  <?php if ($error_quantity) { ?>
                  <div class="text-danger"><?php echo $error_quantity; ?></div>
                  <?php } ?>
                </div>
           </div>
           <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-auto_play">
                    <?php echo $entry_auto_play; ?>
                  </label>
                  <div class="col-sm-10">
                    <select id="input-auto_play" class="form-control" name="auto_play" >
                      <?php if ($auto_play) { ?>
                      <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                      <option value="0"><?php echo $text_no; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_yes; ?></option>
                      <option value="0" selected="selected"><?php echo $text_no; ?></option>
                      <?php } ?>
                    </select>
                  </div>
            </div>
           <div class="form-group">     
                  <label class="col-sm-2 control-label" for="input-pause_on_hover">
                    <?php echo $entry_pause_on_hover; ?>
                  </label>
                  <div class="col-sm-10">
                    <select id="input-pause_on_hover" class="form-control" name="pause_on_hover">
                      <?php if ($pause_on_hover) { ?>
                      <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                      <option value="0"><?php echo $text_no; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_yes; ?></option>
                      <option value="0" selected="selected"><?php echo $text_no; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  </div>
              <div class="form-group">  
                  <label class="col-sm-2 control-label">
                    <?php echo $entry_show_pagination; ?>
                  </label>
                <div class="col-sm-10">
                  <select id="input-show_pagination" class="form-control" name="show_pagination" >
                    <?php if ($show_pagination) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>       
                </div>      
           </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
// Manufacturer
            $('input[name=\'filter-manufacturer\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    label: item['name'],
                                    value: item['manufacturer_id']
                                }
                            }));
                        }
                    });
                },
                'select': function (item) {

                    $('#manufacturer' + item['value']).remove();

                    $('#manufacturer').append('<div id="manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="manufacturers[]" value="' + item['value'] + '" /></div>');
                }
            });
            $('#manufacturer').delegate('.fa-minus-circle', 'click', function () {
                $(this).parent().remove();
            });

            $('#input-type').on('change', function(){
              console.log(this.value);
              if(this.value == 3){
                $('#brand-slider').show();
              } else {
                $('#brand-slider').hide();
              }
            })
</script>
<?php echo $footer; ?>