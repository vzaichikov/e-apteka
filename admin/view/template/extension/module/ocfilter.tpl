<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-ocfilter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary" onclick="$('#form-ocfilter').attr('action','<?php echo $save; ?>');"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-ocfilter" data-toggle="tooltip" title="<?php echo $button_apply; ?>" class="btn btn-success" onclick="$('#form-ocfilter').attr('action','<?php echo $apply; ?>');"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <ul class="list-inline pull-right">
          <li><a href="<?php echo $filter_list; ?>" target="_blank"><i class="fa fa-fw fa-code-fork"></i> <?php echo $text_filter_list; ?></a></li>
          <li><a href="<?php echo $filter_page_list; ?>" target="_blank"><i class="fa fa-fw fa-file-text-o"></i> <?php echo $text_filter_page_list; ?></a></li>
          <li><a href="https://ocfilter.com/faq" target="_blank"><i class="fa fa-fw fa-question-circle"></i> <?php echo $text_faq; ?></a></li>
        </ul>
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="" method="post" enctype="multipart/form-data" id="form-ocfilter" class="form-horizontal">
          <div role="tabs">
            <ul class="nav nav-tabs" role="tablist">
              <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
              <li><a href="#tab-option" data-toggle="tab"><?php echo $tab_option; ?></a></li>
              <li><a href="#tab-price-filtering" data-toggle="tab"><?php echo $tab_price_filtering; ?></a></li>
              <li><a href="#tab-other" data-toggle="tab"><?php echo $tab_other; ?></a></li>
              <li><a href="#tab-copy" data-toggle="tab"><?php echo $tab_copy; ?></a></li>
            </ul>

          	<div class="tab-content">
              <div id="tab-general" class="tab-pane active">
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_status; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($status) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="status" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="status" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="status" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="status" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_status; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_sub_category; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($sub_category) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="sub_category" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="sub_category" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="sub_category" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="sub_category" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_sub_category; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-sitemap-status"><?php echo $entry_sitemap; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($sitemap_status) { ?>
                      <label class="btn btn-default active" data-toggle="trigger" onclick="$('#sitemap-link').collapse('show')">
                        <input type="radio" name="sitemap_status" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default" onclick="$('#sitemap-link').collapse('hide')">
                        <input type="radio" name="sitemap_status" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default" onclick="$('#sitemap-link').collapse('show')">
                        <input type="radio" name="sitemap_status" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active" data-toggle="trigger" onclick="$('#sitemap-link').collapse('hide')">
                        <input type="radio" name="sitemap_status" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <div class="collapse" id="sitemap-link">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $entry_sitemap_link; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="sitemap_link" value="<?php echo $sitemap_link; ?>" class="form-control" onclick="$(this).select();" readonly="readonly" />
                    </div>
                  </div>
                </div>
  		        </div>

  		        <div id="tab-option" class="tab-pane">
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_search_button; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($search_button) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="search_button" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="search_button" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="search_button" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="search_button" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_search_button; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-show-selected"><?php echo $entry_show_selected; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($show_selected) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="show_selected" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="show_selected" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="show_selected" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="show_selected" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_show_selected; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-show-price"><?php echo $entry_show_price; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($show_price) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="show_price" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="show_price" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="show_price" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="show_price" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_show_price; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-show-counter"><?php echo $entry_show_counter; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($show_counter) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="show_counter" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="show_counter" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="show_counter" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="show_counter" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_show_counter; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-manufacturer"><?php echo $entry_manufacturer; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($manufacturer) { ?>
                      <label class="btn btn-default active" data-toggle="trigger" onclick="$('#manufacturer-type').collapse('show')">
                        <input type="radio" name="manufacturer" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default" onclick="$('#manufacturer-type').collapse('hide')">
                        <input type="radio" name="manufacturer" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default" onclick="$('#manufacturer-type').collapse('show')">
                        <input type="radio" name="manufacturer" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active" data-toggle="trigger" onclick="$('#manufacturer-type').collapse('hide')">
                        <input type="radio" name="manufacturer" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_manufacturer; ?></p>
                  </div>
                </div>

                <div class="collapse" id="manufacturer-type">
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-manufacturer-type"><?php echo $entry_type; ?></label>
                    <div class="col-sm-5">
                      <select name="manufacturer_type" id="input-manufacturer-type" class="form-control">
                        <?php foreach ($types as $type) { ?>
                        <?php if ($type == $manufacturer_type) { ?>
                        <option value="<?php echo $type; ?>" selected="selected"><?php echo ucfirst($type); ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-stock-status"><?php echo $entry_stock_status; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($stock_status) { ?>
                      <label class="btn btn-default active" data-toggle="trigger" onclick="$('#stock-status-method').collapse('show')">
                        <input type="radio" name="stock_status" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default" onclick="$('#stock-status-method').collapse('hide')">
                        <input type="radio" name="stock_status" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default" onclick="$('#stock-status-method').collapse('show')">
                        <input type="radio" name="stock_status" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active" data-toggle="trigger" onclick="$('#stock-status-method').collapse('hide')">
                        <input type="radio" name="stock_status" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_stock_status; ?></p>
                  </div>
                </div>

                <div class="collapse" id="stock-status-method">
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-stock-status-method"><?php echo $entry_stock_status_method; ?></label>
                    <div class="col-sm-9">
                      <div class="btn-group" data-toggle="buttons">
                        <?php if ($stock_status_method == 'quantity') { ?>
                        <label class="btn btn-default active" data-toggle="trigger" onclick="$('.collapse-group-1').collapse('hide').filter('#stock-status-quantity').collapse('show')">
                          <input type="radio" name="stock_status_method" value="quantity" autocomplete="off" checked="checked" /> <?php echo $text_stock_by_quantity; ?>
                        </label>
                        <label class="btn btn-default" onclick="$('.collapse-group-1').collapse('hide').filter('#stock-status-id').collapse('show')">
                          <input type="radio" name="stock_status_method" value="stock_status_id" autocomplete="off" /> <?php echo $text_stock_by_status_id; ?>
                        </label>
                        <?php } else { ?>
                        <label class="btn btn-default" onclick="$('.collapse-group-1').collapse('hide').filter('#stock-status-quantity').collapse('show')">
                          <input type="radio" name="stock_status_method" value="quantity" autocomplete="off" /> <?php echo $text_stock_by_quantity; ?>
                        </label>
                        <label class="btn btn-default active" data-toggle="trigger" onclick="$('.collapse-group-1').collapse('hide').filter('#stock-status-id').collapse('show')">
                          <input type="radio" name="stock_status_method" value="stock_status_id" autocomplete="off" checked="checked" /> <?php echo $text_stock_by_status_id; ?>
                        </label>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                  <div class="collapse collapse-group-1" id="stock-status-id">
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-stocks-tatus-type"><?php echo $entry_type; ?></label>
                      <div class="col-sm-5">
                        <select name="stock_status_type" id="input-stocks-tatus-type" class="form-control">
                          <?php foreach ($types as $type) { ?>
                          <?php if ($type == $stock_status_type) { ?>
                          <option value="<?php echo $type; ?>" selected="selected"><?php echo ucfirst($type); ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="collapse collapse-group-1" id="stock-status-quantity">
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-stock-out-value"><?php echo $entry_stock_out_value; ?></label>
                      <div class="col-sm-9">
                        <div class="btn-group" data-toggle="buttons">
                          <?php if ($stock_out_value) { ?>
                          <label class="btn btn-default active">
                            <input type="radio" name="stock_out_value" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                          </label>
                          <label class="btn btn-default">
                            <input type="radio" name="stock_out_value" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                          </label>
                          <?php } else { ?>
                          <label class="btn btn-default">
                            <input type="radio" name="stock_out_value" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                          </label>
                          <label class="btn btn-default active">
                            <input type="radio" name="stock_out_value" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                          </label>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  		        </div>
  		        <div id="tab-price-filtering" class="tab-pane">
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-manual-price"><?php echo $entry_manual_price; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($manual_price) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="manual_price" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="manual_price" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="manual_price" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="manual_price" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_manual_price; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-consider-discount"><?php echo $entry_consider_discount; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($consider_discount) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="consider_discount" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="consider_discount" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="consider_discount" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="consider_discount" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>
                    <p class="help-block"><?php echo $help_consider_discount; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-consider-special"><?php echo $entry_consider_special; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($consider_special) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="consider_special" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="consider_special" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="consider_special" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="consider_special" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>

                    <p class="help-block"><?php echo $help_consider_special; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-consider-option"><?php echo $entry_consider_option; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($consider_option) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="consider_option" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="consider_option" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="consider_option" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="consider_option" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>
                    <p class="help-block"><?php echo $help_consider_option; ?></p>
                  </div>
                </div>
  		        </div>

  		        <div id="tab-other" class="tab-pane">
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-show-options-limit"><?php echo $entry_show_first_limit; ?></label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="number" name="show_options_limit" min="0" value="<?php echo $show_options_limit; ?>" class="form-control" id="input-show-options-limit" />
                      <span class="input-group-addon"><?php echo $text_options; ?></span>
                    </div><!-- /.input-group -->
                    <p class="help-block"><?php echo $help_show_options_limit; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-show-values-limit"><?php echo $entry_show_first_limit; ?></label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="number" name="show_values_limit" min="0" value="<?php echo $show_values_limit; ?>" class="form-control" id="input-show-values-limit" />
                      <span class="input-group-addon"><?php echo $text_values; ?></span>
                    </div><!-- /.input-group -->
                    <p class="help-block"><?php echo $help_show_values_limit; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-hide-empty-values"><?php echo $entry_hide_empty_values; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($hide_empty_values) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="hide_empty_values" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="hide_empty_values" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="hide_empty_values" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="hide_empty_values" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <?php } ?>
                    </div>
                    <p class="help-block"><?php echo $help_hide_empty_values; ?></p>
                  </div>
                </div>
  		        </div>

  		        <div id="tab-copy" class="tab-pane">
                <h4><?php echo $nav_copy_filter; ?></h4>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-copy-type"><?php echo $entry_copy_type; ?></label>
                  <div class="col-sm-5">
                    <select name="copy_type" id="input-copy-type" class="form-control">
                      <?php foreach ($types as $type) { ?>
                      <?php if ($type == $copy_type) { ?>
                      <option value="<?php echo $type; ?>" selected="selected"><?php echo ucfirst($type); ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-truncate"><?php echo $entry_copy_status; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($copy_status > 0) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_status" value="1" autocomplete="off" checked="checked" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_status" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_status" value="-1" autocomplete="off" /> <?php echo $text_auto; ?>
                      </label>
                      <?php } else if ($copy_status < 0) { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_status" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_status" value="0" autocomplete="off" /> <?php echo $text_disabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_status" value="-1" autocomplete="off" checked="checked" /> <?php echo $text_auto; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_status" value="1" autocomplete="off" /> <?php echo $text_enabled; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_status" value="0" autocomplete="off" checked="checked" /> <?php echo $text_disabled; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_status" value="-1" autocomplete="off" /> <?php echo $text_auto; ?>
                      </label>
                      <?php } ?>
                    </div>
                    <p class="help-block"><?php echo $help_copy_status_auto; ?></p>
                  </div>
                </div>

                <h4><?php echo $nav_copy_source; ?></h4>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-copy-attribute"><?php echo $entry_copy_attribute; ?></label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <span class="input-group-btn" data-toggle="buttons">
                        <?php if ($copy_attribute) { ?>
                        <label class="btn btn-default active" data-toggle="trigger" onclick="$('[name=\'attribute_separator\']').prop('disabled', false)">
                          <input type="radio" name="copy_attribute" value="1" autocomplete="off" checked="checked" /> <?php echo $text_yes; ?>
                        </label>
                        <label class="btn btn-default" onclick="$('[name=\'attribute_separator\']').prop('disabled', true)">
                          <input type="radio" name="copy_attribute" value="0" autocomplete="off" /> <?php echo $text_no; ?>
                        </label>
                        <?php } else { ?>
                        <label class="btn btn-default" onclick="$('[name=\'attribute_separator\']').prop('disabled', false)">
                          <input type="radio" name="copy_attribute" value="1" autocomplete="off" /> <?php echo $text_yes; ?>
                        </label>
                        <label class="btn btn-default active" data-toggle="trigger" onclick="$('[name=\'attribute_separator\']').prop('disabled', true)">
                          <input type="radio" name="copy_attribute" value="0" autocomplete="off" checked="checked" /> <?php echo $text_no; ?>
                        </label>
                        <?php } ?>
                      </span>
                      <input name="attribute_separator" type="text" class="form-control" placeholder="<?php echo $entry_copy_attribute_separator; ?>" value="<?php echo $copy_attribute_separator; ?>" disabled="disabled" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-copy-filter"><?php echo $entry_copy_filter; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($copy_filter) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_filter" value="1" autocomplete="off" checked="checked" /> <?php echo $text_yes; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_filter" value="0" autocomplete="off" /> <?php echo $text_no; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_filter" value="1" autocomplete="off" /> <?php echo $text_yes; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_filter" value="0" autocomplete="off" checked="checked" /> <?php echo $text_no; ?>
                      </label>
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="input-copy-option"><?php echo $entry_copy_option; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <?php if ($copy_option) { ?>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_option" value="1" autocomplete="off" checked="checked" /> <?php echo $text_yes; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_option" value="0" autocomplete="off" /> <?php echo $text_no; ?>
                      </label>
                      <?php } else { ?>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_option" value="1" autocomplete="off" /> <?php echo $text_yes; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_option" value="0" autocomplete="off" checked="checked" /> <?php echo $text_no; ?>
                      </label>
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <h4><?php echo $nav_copy_other; ?></h4>

                <div class="form-group">
                  <label class="col-sm-3 control-label"><?php echo $entry_copy_clear_filter; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <label class="btn btn-default">
                        <input type="radio" name="copy_truncate" value="1" autocomplete="off" /> <?php echo $text_yes; ?>
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_truncate" value="0" autocomplete="off" checked="checked" /> <?php echo $text_no; ?>
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label"><?php echo $entry_copy_category; ?></label>
                  <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                      <label class="btn btn-default active">
                        <input type="radio" name="copy_category" value="1" autocomplete="off" checked="checked" /> <?php echo $text_yes; ?>
                      </label>
                      <label class="btn btn-default">
                        <input type="radio" name="copy_category" value="0" autocomplete="off" /> <?php echo $text_no; ?>
                      </label>
                    </div>
                    <p class="help-block"><?php echo $help_copy_category; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="button" class="btn btn-lg btn-primary" id="button-copy-filter" data-loading-text="<?php echo $text_loading; ?>" data-complete-text="<?php echo $text_complete; ?>"><i class="fa fa-copy"></i> <?php echo $button_copy; ?></button>
                  </div>
                </div>
  		        </div>
            </div>
          </div>
        </form>
			</div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
  $(function() {
    $('[data-toggle="trigger"][onclick]').trigger('click');
  });

  var timer;

  $('#button-copy-filter').on('click', function(e) {
    clearTimeout(timer);

    $('#tab-copy > .alert').remove();

    var button = $(this).button('loading');

    $.post('index.php?route=extension/module/ocfilter/copyFilters&token=<?php echo $token; ?>', $('[name^=\'copy_\'], [name=\'attribute_separator\']').serialize(), function(response) {
      if (response['error']) {
        button.button('reset');

        $('#tab-copy').prepend('<div class="alert alert-danger" role="alert">' + response['error'] + '</div>');
      }

      if (response['success']) {
        button.button('complete');

        $('#tab-copy').prepend('<div class="alert alert-success" role="alert">' + response['success'] + '</div>');

        timer = setTimeout(function() {
          button.button('reset');
        }, 10 * 1000);
      }
    }, 'json');
  });
//--></script>
<?php echo $footer; ?>