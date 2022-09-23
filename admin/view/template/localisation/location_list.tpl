<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-location').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-location">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td class="text-left"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'address') { ?>
                  <a href="<?php echo $sort_address; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_address; ?></a>
                <?php } else { ?>
                  <a href="<?php echo $sort_address; ?>"><?php echo $column_address; ?></a>
                  <?php } ?></td>
                  <td class="text-left">Телефон</td>
                  <td class="text-left">GeoCode</td>
                  <td class="text-left">GM Код</td>
                  <td class="text-left">1C UUID</td>
                  <td class="text-left">Остатки</td>
                  <td class="text-left">Основн. цена</td>
                  <td class="text-left">Время доставки</td>
                  <td class="text-left">Открыто</td>
                  <td class="text-left">Открыто Структ</td>
                  <td class="text-left">Точка обмена</td>
                  <td class="text-left">Статья - описание</td>
                  <td class="text-left">Сорт</td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($location) { ?>
                  <?php foreach ($location as $locations) { ?>
                    <tr>
                      <td class="text-center"><?php if (in_array($locations['location_id'], $selected)) { ?>
                        <input type="checkbox" name="selected[]" value="<?php echo $locations['location_id']; ?>" checked="checked" />
                      <?php } else { ?>
                        <input type="checkbox" name="selected[]" value="<?php echo $locations['location_id']; ?>" />
                        <?php } ?></td>
                        <td class="text-left">
                          <?php echo $locations['name']; ?>
                          
                          <?php if ($locations['temprorary_closed']) { ?>
                            <span class="label label-danger">Временно закрыто</span>
                          <?php } else { ?>
                             <span class="label label-success">Открыто</span>
                          <?php } ?>

                        </td>
                        <td class="text-left"><?php echo $locations['address']; ?></td>
                        <td class="text-left"><?php echo $locations['telephone']; ?></td>
                        <td class="text-left">
                          <span class="label label-success"><?php echo $locations['geocode']; ?></span>
                          <?php if ($locations['gmaps_link']) { ?>
                          <br /><small><?php echo $locations['gmaps_link']; ?></small>
                          <?php } ?>
                          

                        </td>

                        <td class="text-left"><span class="label label-success">drugstore<?php echo $locations['location_id']; ?></span></td>

                        <td class="text-left"><small><?php echo $locations['uuid']; ?></small></td>
                        <td class="text-left">
                         <?php if ($locations['is_stock']) { ?>
                           <span class="btn btn-success"><i class="fa fa-plus"></i></span>
                         <? } else { ?>					  
                           <span class="btn btn-danger"><i class="fa fa-minus"></i></span>
                         <? } ?>
                       </td>
                       <td class="text-left">
                         <?php if ($locations['default_price']) { ?>
                           <span class="btn btn-success"><i class="fa fa-plus"></i></span>
                         <? } else { ?>					  
                           <span class="btn btn-danger"><i class="fa fa-minus"></i></span>
                         <? } ?>
                       </td>
                       <td class="text-left" style="font-size:10px; white-space: nowrap;"><?php echo $locations['delivery_times']; ?></td>
                       <td class="text-left" style="font-size:10px; white-space: nowrap;"><?php echo $locations['open']; ?></td>
                       <td class="text-left" style="font-size:10px; white-space: nowrap;"><?php echo $locations['open_struct']; ?></td>
                       <td class="text-left" style="font-size:10px;"><?php echo $locations['node']; ?></td>
                       <td class="text-left" style="font-size:10px;"><?php echo $locations['information']; ?></td>
                       <td class="text-left"><?php echo $locations['sort_order']; ?></td>
                       <td class="text-right"><a href="<?php echo $locations['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                     </tr>
                   <?php } ?>
                 <?php } else { ?>
                  <tr>
                    <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 