<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="row">                     
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select name="filter_manufacturer_id" id="input-manufacturer_id" class="form-control">
                                    <option value="*">Производитель</option>								
                                    <?php foreach ($manufacturers as $manufacturer) { ?>
                                        <?php if ($manufacturer['manufacturer_id'] == $filter_manufacturer_id) { ?>
                                            <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <select name="filter_category_id" id="input-category_id" class="form-control">
                                    <option value="*">Категория</option>								
                                    <?php foreach ($categories as $category) { ?>
                                        <?php if ($category['category_id'] == $filter_category_id) { ?>
                                            <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <select name="filter_collection_id" id="input-collection_id" class="form-control">
                                    <option value="*">Коллекция</option>								
                                    <?php foreach ($collections as $collection) { ?>
                                        <?php if ($collection['collection_id'] == $filter_collection_id) { ?>
                                            <option value="<?php echo $collection['collection_id']; ?>" selected="selected"><?php echo $collection['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $collection['collection_id']; ?>"><?php echo $collection['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="input-group date">
                                    <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">                                
                                <div class="input-group date">
                                    <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                    </span></div>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">                                
                                <select name="filter_order_status_id" id="input-status" class="form-control">
                                    <option value="0">Статус заказа</option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">                                
                                <select name="filter_count_conversion" id="input-filter_count_conversion" class="form-control">
                                    <option value="0" <?php if (!$filter_count_conversion) { ?>selected="selected"<?php } ?>>Конверсия - нет</option>
                                    <option value="1" <?php if ($filter_count_conversion) { ?>selected="selected"<?php } ?>>Конверсия - да</option>                                   
                                </select>
                            </div>
                            <div class="form-group">
								<input type="text" name="filter_product_name" value="<?php echo $filter_product_name; ?>" placeholder="Товар" id="input-product-name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="label label-info"><i class="fa fa-info-circle"></i> внимание, актуальная информация в БД начиная с июня 2020 года, информация о конверсии с 15.01.2021</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-left"></td>
                                <td class="text-left"><?php echo $column_name; ?></td>
                                <td class="text-left">Мин цена</td>
                                <td class="text-left">Ср. цена</td>
                                <td class="text-left">Макс. цена</td>                        
                                <td class="text-right">Куплено,шт.</td>
                                <?php if ($filter_count_conversion) { ?>
                                    <td class="text-left">Просмотров</td>
                                    <td class="text-left">Конверсия</td>
                                <?php } ?>
                                <td class="text-right">Куплено,сумма</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products) { ?>
                                <?php foreach ($products as $product) { ?>
                                    <tr>
                                        <td class="text-left"><img src="<?php echo $product['image']; ?>" /></td>
                                        <td class="text-left">
                                            <b><?php echo $product['name']; ?></b><br />
                                            <span class='label label-success'><?php echo $product['product_id']; ?></span>
                                            <?php if ($product['manufacturer']) { ?>
                                                <span class='label label-info'><?php echo $product['manufacturer']; ?></span>
                                            <?php } ?>
                                            <?php if ($product['category']) { ?>
                                                <span class='label label-warning'><?php echo $product['category']; ?></span>
                                            <?php } ?>
                                            <?php if ($product['collection']) { ?>
                                                <span class='label label-success'><?php echo $product['collection']; ?></span>
                                            <?php } ?>
                                            
                                            
                                        </td>
                                        <td class="text-left"><?php echo $product['min_price']; ?></td>
                                        <td class="text-left"><?php echo $product['avg_price']; ?></td>
                                        <td class="text-left"><?php echo $product['max_price']; ?></td>
                                        
                                        <td class="text-center"><b><?php echo $product['quantity']; ?></b></td>
                                        
                                        <?php if ($filter_count_conversion) { ?>
                                            <td class="text-center"><b><?php echo $product['viewed']; ?></b></td>
                                            <td class="text-center"><span class='label label-success'><?php echo $product['conversion']; ?></span></td>
                                        <?php } ?>
                                        
                                        <td class="text-center"><b><?php echo $product['total']; ?></b></td>
                                    </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center" colspan="2">На текущей странице</td>
                                <td class="text-left" nowrap><span class='label label-success'><?php echo $totals['min_price']; ?></span></td>
                                <td class="text-left" nowrap><span class='label label-success'><?php echo $totals['avg_price']; ?></span></td>
                                <td class="text-left" nowrap><span class='label label-success'><?php echo $totals['max_price']; ?></span></td>
                                <td class="text-right"><span class='label label-success'><?php echo $totals['quantity']; ?></span></td>
                                <?php if ($filter_count_conversion) { ?>
                                    <td class="text-center"><span class='label label-success'><?php echo $totals['viewed']; ?></span></td>
                                    <td class="text-center"><span class='label label-success'><?php echo $totals['conversion']; ?></span></td>
                                <?php } ?>
                                <td class="text-right" nowrap><span class='label label-success'><?php echo $totals['total']; ?></span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
        $('#button-filter').on('click', function() {
            url = 'index.php?route=report/product_purchased&token=<?php echo $token; ?>';
            
            var filter_date_start = $('input[name=\'filter_date_start\']').val();
            
            if (filter_date_start) {
                url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
            }
            
            var filter_date_end = $('input[name=\'filter_date_end\']').val();
            
            if (filter_date_end) {
                url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
            }
            
            var filter_manufacturer_id = $('select[name=\'filter_manufacturer_id\']').val();
			
			if (filter_manufacturer_id != '*') {
				url += '&filter_manufacturer_id=' + encodeURIComponent(filter_manufacturer_id);
            }
            
            var filter_collection_id = $('select[name=\'filter_collection_id\']').val();
			
			if (filter_collection_id != '*') {
				url += '&filter_collection_id=' + encodeURIComponent(filter_collection_id);
            }
            
            var filter_category_id = $('select[name=\'filter_category_id\']').val();
			
			if (filter_category_id != '*') {
				url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
            }
			
            var filter_count_conversion = $('select[name=\'filter_count_conversion\']').val();
			
			if (filter_count_conversion != 0) {
				url += '&filter_count_conversion=' + encodeURIComponent(filter_count_conversion);
            }
            
            var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();
            
            if (filter_order_status_id != 0) {
                url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
            }
            
            var filter_product_name = $('input[name=\'filter_product_name\']').val();
			
			if (filter_product_name) {
				url += '&filter_product_name=' + encodeURIComponent(filter_product_name);
            }
            
            var filter_count_conversion = $('select[name=\'filter_count_conversion\']').val();
            
            location = url;
        });
    //--></script> 
    <script type="text/javascript"><!--
        $('.date').datetimepicker({
            pickTime: false
        });
    //--></script> 
</div>
<?php echo $footer; ?>