<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">
       
          <table class="table table-bordered">

            <tr>
              <td>
                <?php echo $entry_status;?>
              </td>
              <td>
                <select name="cart_status" id="input-status" class="form-control">
                  <?php foreach($select_status as $key=>$value) { ?>
                    <option value="<?php echo $key; ?>" <?php if($key==$cart_status) {?> selected='selected' <?php } ?> ><?php echo $value; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_time;?>
              </td>
              <td class="form-inline">
                  <input type="text" class="form-control" value="<?php echo $cart_lifetime;?>" name="cart_lifetime">
                  <select name="cart_unit" id="input-units" class="form-control">
                    <?php foreach($select_units as $key=>$value) { ?>
                      <option value="<?php echo $key; ?>" <?php if($key==$cart_unit) {?> selected='selected' <?php } ?> ><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
              </td>
            </tr>

          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>