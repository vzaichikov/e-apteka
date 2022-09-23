<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-right"></td>
                                <td class="text-left">URL</td>
                                <td class="text-left">Отправлено, дата</td>
                                <td class="text-left">Отправлено, время</td>
                                <td class="text-left">Google API</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($indexes) { ?>
                                <?php foreach ($indexes as $index) { ?>
                                    <tr>
                                        <td class="text-left"><?php echo $index['indexer_id']; ?></td>
                                        <td class="text-left"><?php echo $index['indexer_url']; ?></td>
                                        <td class="text-left"><?php echo $index['date_added']; ?></td>
                                        <td class="text-left"><?php echo $index['time_added']; ?></td>
                                        <td class="text-center" data-action="<?php echo $index['action']; ?>">
                                            <i class="fa fa-refresh update-google-data" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
                <script>
                  $('.update-google-data').click(function(){
                    $(this).removeClass('fa-refresh').addClass('fa-spinner fa-spin');
                    $(this).parent().load($(this).parent().attr('data-action'));
                  });
                </script>
                
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>        