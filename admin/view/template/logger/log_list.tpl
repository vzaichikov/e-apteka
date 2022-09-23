<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
	    <a onclick="$('#form').attr('action', '<?php echo $clearlogger; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" data-toggle="tooltip" title="<?php echo $button_clear; ?>" class="btn btn-danger"><i class="fa fa-eraser"></i></a>
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
      <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="filter_log_date"><?php echo $entry_log_date; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_log_date" value="<?php echo $filter_log_date; ?>" placeholder="<?php echo $filter_log_date; ?>" data-date-format="YYYY-MM-DD" id="filter_log_date" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
			   
              </div>
              <div class="form-group">
                <label class="control-label" for="filter_log_item"><?php echo $entry_log_item; ?></label>
			    <select name="filter_log_item" id="filter_log_item" class="form-control">
                  <?php if (empty($filter_log_item)) { ?>
                  <option value="" selected="selected"><?php echo $entry_all; ?></option>
                  <?php } else { ?>
                  <option value=""><?php echo $entry_all; ?></option>
                  <?php } ?>
                  <?php foreach ($log_items as $log_item) { ?>
                  <?php if ($log_item['log_item'] == $filter_log_item) { ?>
                  <option value="<?php echo $log_item['log_item']; ?>" selected="selected"><?php echo $log_item['log_item']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $log_item['log_item']; ?>"><?php echo $log_item['log_item']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="filter_log_action"><?php echo $entry_log_action; ?></label>
				<select name="filter_log_action" id="filter_log_action" class="form-control" >
                  <?php if (empty($filter_log_action)) { ?>
                  <option value="" selected="selected"><?php echo $entry_all; ?></option>
                  <?php } else { ?>
                  <option value=""><?php echo $entry_all; ?></option>
                  <?php } ?>
                  <?php foreach ($log_actions as $log_action) { ?>
                  <?php if ($log_action['log_action'] == $filter_log_action) { ?>
                  <option value="<?php echo $log_action['log_action']; ?>" selected="selected"><?php echo $log_action['log_action']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $log_action['log_action']; ?>"><?php echo $log_action['log_action']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			   
              </div>
              <div class="form-group">
                <label class="control-label" for="filter_user_name"><?php echo $entry_user_name; ?></label>
				<select name="filter_user_name" id="filter_user_name" class="form-control">
                  <?php if (empty($filter_user_name)) { ?>
                  <option value="" selected="selected"><?php echo $entry_all; ?></option>
                  <?php } else { ?>
                  <option value=""><?php echo $entry_all; ?></option>
                  <?php } ?>
                  <?php foreach ($log_users as $log_user) { ?>
                  <?php if ($log_user['user_name'] == $filter_log_action) { ?>
                  <option value="<?php echo $log_user['user_name']; ?>" selected="selected"><?php echo $log_user['user_name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $log_user['user_name']; ?>"><?php echo $log_user['user_name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
             </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
			  <label class="control-label" for="filter_ip_address"><?php echo $entry_ip_address; ?></label>
               <input type="text" name="filter_ip_address" id="filter_ip_address" value="<?php echo $filter_ip_address; ?>"  class="form-control"/>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
		<form action="" method="post" enctype="multipart/form-data" id="form">
		  <div class="table-responsive">
            <table class="table table-bordered table-hover">
			 <thead>
			 <tr>
				 <td class="text-left">
				 <?php if ($sort == 'log_date') { ?>
					<a href="<?php echo $sort_log_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_log_date; ?></a>
					<?php } else { ?>
					<a href="<?php echo $sort_log_date; ?>"><?php echo $column_log_date; ?></a>
					<?php } ?>
				 </td>
				 <td class="text-left">
					<?php if ($sort == 'log_item') { ?>
					<a href="<?php echo $sort_log_item; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_log_item; ?></a>
					<?php } else { ?>
					<a href="<?php echo $sort_log_item; ?>"><?php echo $column_log_item; ?></a>
					<?php } ?>
				 </td>
				 <td class="text-left">
					 <?php if ($sort == 'log_action') { ?>
					<a href="<?php echo $sort_log_action; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_log_action; ?></a>
					<?php } else { ?>
					<a href="<?php echo $sort_log_action; ?>"><?php echo $column_log_action; ?></a>
					<?php } ?>
				 </td>
				 <td class="text-left">
					 <?php if ($sort == 'user_name') { ?>
					<a href="<?php echo $sort_user_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_user_name; ?></a>
					<?php } else { ?>
					<a href="<?php echo $sort_user_name; ?>"><?php echo $column_user_name; ?></a>
					<?php } ?>
				</td>
                <td class="text-left">
				   <?php if ($sort == 'ip_address') { ?>
					<a href="<?php echo $sort_ip_address; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip_address; ?></a>
					<?php } else { ?>
					<a href="<?php echo $sort_ip_address; ?>"><?php echo $column_ip_address; ?></a>
					<?php } ?>
				</td>
				 <td class="text-right"><?php echo $column_action; ?></td>
			 </tr>
			 </thead>
			 <tbody>
			 <?php if ($logs) { ?>
				<?php foreach ($logs as $log) { ?>
            <tr>
              <td class="text-left"><?php echo $log['log_date']; ?></td>
              <td class="text-left"><?php echo $log['log_item']; ?></td>
              <td class="text-left"><?php echo $log['log_action']; ?></td>
              <td class="text-left"><?php echo $log['user_name']; ?></td>
              <td class="text-left"><?php echo $log['ip_address']; ?></td>
              <td class="text-right">
			  <?php foreach ($log['action'] as $action) { ?>
                 <a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> 
                <?php } ?>
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
        </form>
	<div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	
	url = 'index.php?route=logger/logger&token=<?php echo $token; ?>';
	
	
	var filter_log_date = $('input[name=\'filter_log_date\']').val();
	
	if (filter_log_date) {
		url += '&filter_log_date=' + encodeURIComponent(filter_log_date);
	}
	
	var filter_log_item = $('select[name=\'filter_log_item\']').val();
	
	if (filter_log_item) {
		url += '&filter_log_item=' + encodeURIComponent(filter_log_item);
	}
	
	var filter_log_action = $('select[name=\'filter_log_action\']').val();
	
	if (filter_log_action) {
		url += '&filter_log_action=' + encodeURIComponent(filter_log_action);
	}
	
	var filter_user_name = $('select[name=\'filter_user_name\']').val();
	
	if (filter_user_name) {
		url += '&filter_user_name=' + encodeURIComponent(filter_user_name);
	}

	var filter_ip_address = $('input[name=\'filter_ip_address\']').val();
	
	if (filter_ip_address) {
		url += '&filter_ip_address=' + encodeURIComponent(filter_ip_address);
	}
	

				
	location = url;
});
//--></script>  
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
 
<?php echo $footer; ?>