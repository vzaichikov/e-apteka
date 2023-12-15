<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> <a href="<?php echo $repair; ?>" data-toggle="tooltip" title="<?php echo $button_rebuild; ?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-collection').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-collection">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked).trigger('change');" /></td>
                                    <td class="text-left"><?php if ($sort == 'name') { ?>
                                        <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                                    <?php } ?></td>
                                    
                                    <td class="text-right">Фильтр</td>
                                    
                                    <td class="text-right">Бренд</td>
                                    <td class="text-right"><?php if ($sort == 'sort_order') { ?>
                                        <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                                    <?php } ?></td>
                                    <td class="text-right"><?php echo $column_action; ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($collections) { ?>
                                    <?php foreach ($collections as $collection) { ?>
                                        <tr>
                                            <td class="text-center"><?php if (in_array($collection['collection_id'], $selected)) { ?>
                                                <input type="checkbox" name="selected[]" value="<?php echo $collection['collection_id']; ?>" checked="checked" />
                                                <?php } else { ?>
                                                <input type="checkbox" name="selected[]" value="<?php echo $collection['collection_id']; ?>" />
                                            <?php } ?></td>
                                            <?php if ($collection['href']) { ?>
                                                <td class="left">
                                                    <?php foreach ($languages as $language) { ?>
                                                        <?php if (isset($collection['descriptions'][$language['language_id']])) { ?>
                                                            <div><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php echo $collection['indent']; ?><a href="<?php echo $collection['href']; ?>"><b><?php echo $collection['descriptions'][$language['language_id']]['name']; ?></b></a>&nbsp;&nbsp;<i class="fa fa-sort-desc"></i></div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                                <?php } else { ?>
                                                <td class="left">
                                                    <?php foreach ($languages as $language) { ?>
                                                        <?php if (isset($collection['descriptions'][$language['language_id']])) { ?>
                                                            <div><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php echo $collection['indent']; ?><b><?php echo $collection['descriptions'][$language['language_id']]['name']; ?></b></div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            
                                            <td class="text-left" width="400px">
                                                <?php foreach ($languages as $language) { ?>
													<?php if (isset($collection['descriptions'][$language['language_id']])) { ?>
														<div><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['country']; ?>" /> <small><?php echo $collection['descriptions'][$language['language_id']]['alternate_name']; ?></small></div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                            
                                            
                                            <td class="text-right"><span class="label label-success"><?php echo $collection['manufacturer']; ?></span></td>
                                            <td class="text-right"><?php echo $collection['sort_order']; ?></td>
                                            <td class="text-right"><a href="<?php echo $collection['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>