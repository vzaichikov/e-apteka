<?php echo $header; ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var data = [<?php echo json_encode($categories);?>];
            jQuery('#category_tree').jstree({
                'core': {
                    'data': data
                },
                'plugins': ['wholerow', 'checkbox']
            });
            var manufacturer_data = [<?php echo json_encode($manufacturers);?>];
            jQuery('#manufacturer_tree').jstree({
                'core': {
                    'data': manufacturer_data
                },
                'plugins': ['wholerow', 'checkbox']
            });
        })
    </script>
    <script type="text/javascript">

        $(document).ready(function () {

            function buildFormData(currentForm) {
                var filter_category_newmode = $("#filter_category_newmode").checked;
                var filter_manufacturer_newmode = $("#filter_manufacturer_newmode").checked;
                if (filter_category_newmode != 1) {
                    var selectedCats = $('#category_tree').jstree("get_selected");

                    var selectedCatsIds = [];
                    $.each(selectedCats, function (i, elem) {
                        selectedCatsIds.push(elem.match(/\d+/));
                    });
                    $.each(selectedCatsIds, function (i, selectedCatsId) {
                        $('<input />').attr('type', 'hidden')
                            .attr('name', 'priceControl_categories[]')
                            .attr('value', selectedCatsId)
                            .appendTo($(currentForm));
                    });
                }
                if (filter_manufacturer_newmode != 1) {
                    var selectedManufacturers = $('#manufacturer_tree').jstree("get_selected");

                    var selectedManufacturersIds = [];
                    $.each(selectedManufacturers, function (i, elem) {
                        selectedManufacturersIds.push(elem.match(/\d+/));
                    });
                    $.each(selectedManufacturersIds, function (i, selectedManufacturersId) {
                        $('<input />').attr('type', 'hidden')
                            .attr('name', 'priceControl_manufacturers[]')
                            .attr('value', selectedManufacturersId)
                            .appendTo($(currentForm));
                    });
                }
                return true;
            }

            $("#filter_category_newmode").change(function () {
                if (this.checked) {
                    $("#category_newmode").tab('show');
                } else {
                    $("#category_oldmode").tab('show');
                }
            });
            // $("#category_oldmode").tab('show');

            $("#filter_manufacturer_newmode").change(function () {
                if (this.checked) {
                    $("#manufacturer_newmode").tab('show');
                } else {
                    $("#manufacturer_oldmode").tab('show');
                }
            });

            var currentForm;
            $("#pricecontrol_rollback_button").click(function () {
                if (confirm('<?php echo $text_undo_last_changes;?>')) {
                    var url = $(this).closest('a');
                    location.resolveURL($(url).attr('href'));
                }

            })
            $("#pricecontrol_submit_button").click(function (e) {
                    currentForm = $(this).closest('form');
                    var validate = true;
                    currentForm.find(':input[required]').each(function (i, elem) {
                        if ($(elem).val() == '') {
                            $(elem).css('border-color', 'red');
                            validate = false;
                        } else {
                            $(elem).css('border', 'none');
                        }
                    });
                    if (validate) {
                        if (confirm("<?php echo $text_confirm_action;?>")) {
                           if (buildFormData(currentForm)) {
                               $(currentForm).submit();
                           }
                        }
                    } else {
                        alert("<?php echo $error_action;?>");
                        e.preventDefault();
                    }
                    return false;
                }
            );
            $("#pricecontrol_deleteSpecial_button").click(function (e) {
                currentForm = $(this).closest('form');
                if (confirm("<?php echo $text_confirm_action;?>")) {
                    if (buildFormData(currentForm)) {
                        $('<input />').attr('type', 'hidden')
                            .attr('name', 'priceControl_delete_special')
                            .attr('value', '1')
                            .appendTo($(currentForm));
                        $(currentForm).submit();
                    }
                }
            });
            $("#pricecontrol_deleteDiscount_button").click(function (e) {
                currentForm = $(this).closest('form');
                if (confirm("<?php echo $text_confirm_action;?>")) {
                    if (buildFormData(currentForm)) {
                        $('<input />').attr('type', 'hidden')
                            .attr('name', 'priceControl_delete_discount')
                            .attr('value', '1')
                            .appendTo($(currentForm));
                        $(currentForm).submit();
                    }
                }

            });
        })
    </script>

<?php echo $column_left; ?>
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <a href="<?php echo $cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
                </div>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
                      id="pricecontrol-form"
                      class="form-horizontal">
                    <div class="panel-body">
                        <p class="help small text-muted"><?php echo $help_filter; ?></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <div class="material-switch pull-right">
                                        <input id="filter_category_newmode" type="checkbox"
                                               name="price_control_filter_category_newmode"
                                            <?php if ($price_control_filter_category_newmode) echo " checked "; ?>>
                                        <label for="filter_category_newmode" class="label-default"></label>

                                        <div style="display: none;">
                                <span id="category_oldmode" data-target="#filter-category_oldmode"
                                      data-toggle="tab"></span>
                                <span id="category_newmode" data-target="#filter-category_newmode"
                                      data-toggle="tab"></span>

                                        </div>
                                    </div>
                                    <h3><i class="fa fa-list"></i> <?php echo $text_categories; ?></h3>

                                    <div class="panel-body tab-content" id="filter-category-tabs">
                                        <div
                                            class="tab-pane <?php if (!$price_control_filter_category_newmode) echo " active"; ?>"
                                            id="filter-category_oldmode">
                                            <div id="category_tree"></div>
                                        </div>
                                        <div
                                            class="tab-pane <?php if ($price_control_filter_category_newmode) echo " active"; ?>"
                                            id="filter-category_newmode">
                                            <input type="text" name="filter-category" value=""
                                                   placeholder="<?php echo $text_categories; ?>" id="input-category"
                                                   class="form-control"/>

                                            <div id="product-category" class="well well-sm"
                                                 style="height: 150px; overflow: auto;">
                                            </div>
                                            <div class="row-fluid">
                                                <label for="filter-category_include_subcategories"><input
                                                        name="filter-category_include_subcategories" type="checkbox"
                                                        checked/> <?php echo $text_include_subcategories; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <div class="material-switch pull-right">
                                        <input id="filter_manufacturer_newmode" type="checkbox"
                                               name="price_control_filter_manufacturer_newmode"
                                            <?php if ($price_control_filter_manufacturer_newmode) echo " checked "; ?>>
                                        <label for="filter_manufacturer_newmode" class="label-default"></label>
                                        <div style="display: none;">
                                <span id="manufacturer_oldmode" data-target="#filter-manufacturer_oldmode"
                                      data-toggle="tab"></span>
                                <span id="manufacturer_newmode" data-target="#filter-manufacturer_newmode"
                                      data-toggle="tab"></span>
                                        </div>
                                    </div>
                                    <h3><i class="fa fa-android"></i> <?php echo $text_manufacturers; ?></h3>

                                    <div class="panel-body tab-content" id="filter-manufacturer-tabs">
                                        <div
                                            class="tab-pane <?php if (!$price_control_filter_manufacturer_newmode) echo " active"; ?>"
                                            id="filter-manufacturer_oldmode">
                                            <div id="manufacturer_tree"></div>
                                        </div>
                                        <div
                                            class="tab-pane <?php if ($price_control_filter_manufacturer_newmode) echo " active"; ?>"
                                            id="filter-manufacturer_newmode">
                                            <input type="text" name="filter-manufacturer" value=""
                                                   placeholder="<?php echo $text_manufacturers; ?>"
                                                   id="filter-manufacturer"
                                                   class="form-control"/>

                                            <div id="product-manufacturer" class="well well-sm"
                                                 style="height: 150px; overflow: auto;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <h3><i class="fa fa-calculator"></i> <?php echo $text_prices; ?></h3>

                                    <div class="panel-body">
                                        <?php if ($price_types)
                                            echo $price_types;
                                        ?>
                                        <p class="help small text-muted"><?php echo $help_prices; ?></p>
                                    </div>
                                </div>
                                <div class="thumbnail">
                                    <h4><i class="fa fa-group"></i> <?php echo $text_customer_groups; ?></h4>
                                    <div class="panel-body">
                                        <?php if ($customer_groups)
                                            echo $customer_groups;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 panel panel-heading">
                                <h3><i class="fa fa-magic"></i> <?php echo $text_add_settings; ?></h3>
                                <ul style="list-style:none;">
                                    <li><label><input type="checkbox" name="priceControl_create_if_not_exists"
                                                      value="1"/>
                                            <?php echo $text_create_if_not_exists; ?></label>
                                    </li>
                                    <p class="help-block small text-muted"><?php echo $help_create_if_not_exists; ?></p>
                                    <li>
                                        <label><?php echo $text_discount_qty; ?>
                                            <input class="form-control" type="number" name="new_discount_quantity"
                                                   placeholder="<?php echo $text_discount_qty; ?>" value="10"></label>
                                    </li>
                                </ul>
                                <div class="thumbnail">
                                    <h4><i class="fa fa-times"></i> <?php echo $text_special_discount_actions; ?></h4>
                                    <div class="panel-body btn-block">
                                        <button class="btn btn-danger" id="pricecontrol_deleteSpecial_button"
                                            type="button"><i
                                                class="fa fa-trash"></i> <?php echo $text_delete_special; ?>
                                        </button>
                                        <button class="btn btn-danger" id="pricecontrol_deleteDiscount_button"
                                            type="button"><i
                                                class="fa fa-trash-o"></i> <?php echo $text_delete_discount; ?>
                                        </button>
                                        <p class="help-block small text-muted"><?php echo $help_delete_special_discount; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-8">
                                <div class="thumbnail">
                                    <h3><i class="fa fa-code"></i> <?php echo $text_formula_and_actions; ?></h3>
                                    <div class="panel-body">
                                        <div class="row-fluid">
                                            <div class="input-group">
                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <?php if ($math_actions)
                                                        echo $math_actions;
                                                    ?>
                                                </div>
                                                <input required class="form-control" type="text"
                                                       name="num"
                                                       placeholder="<?php echo $entry_value; ?>"/>

                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <label class="btn btn-default active"><input checked
                                                                                                 class="form-control"
                                                                                                 type="radio"
                                                                                                 name="unit"
                                                                                                 value="<?php echo ModelExtensionModulePriceControl::PRICE_CONTROL_UNIT_PERCENT; ?>"/>%</label>
                                                    <label class="btn btn-default"><input class="form-control"
                                                                                          type="radio"
                                                                                          name="unit"
                                                                                          value="<?php echo ModelExtensionModulePriceControl::PRICE_CONTROL_UNIT_NUMBER; ?>"/><?php echo $text_number; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row-fluid text-right">
                                            <button class="btn btn-success" id="pricecontrol_submit_button"
                                                    type="submit"><i class="fa fa-play"></i> <?php echo $button_run; ?>
                                            </button>
                                            <a href="<?php echo $backup_link; ?>">
                                                <button <?php echo(!$allow_backup ? "disabled" : ""); ?>
                                                    class="btn btn-warning" id="pricecontrol_rollback_button"
                                                    type="button"><i
                                                        class="fa fa-undo"></i> <?php echo $button_rollback; ?>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        <script type="text/javascript">
            // Category
            $('input[name=\'filter-category\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    label: item['name'],
                                    value: item['category_id']
                                }
                            }));
                        }
                    });
                },
                'select': function (item) {
                    $('input[name=\'filter-category\']').val('');

                    $('#product-category' + item['value']).remove();

                    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="priceControl_categories[]" value="' + item['value'] + '" /></div>');
                }
            });
            $('#product-category').delegate('.fa-minus-circle', 'click', function () {
                $(this).parent().remove();
            });
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

                    $('input[name=\'filter-category\']').val('');

                    $('#product-manufacturer' + item['value']).remove();

                    $('#product-manufacturer').append('<div id="product-manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="priceControl_manufacturers[]" value="' + item['value'] + '" /></div>');
                }
            });
            $('#product-manufacturer').delegate('.fa-minus-circle', 'click', function () {
                $(this).parent().remove();
            });
        </script>

<?php echo $footer; ?>