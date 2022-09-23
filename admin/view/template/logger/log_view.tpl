<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
      <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
<div class="panel-body">
	<form method="post" enctype="multipart/form-data" id="form">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <tbody>
				<tr>
				<td class="text-left"><?php echo $entry_log_id; ?></td>
				<td class="text-left"><?php echo $log_id; ?></td>
			  </tr>
			  <tr>
				<td class="text-left"><?php echo $entry_log_date; ?></td>
				<td class="text-left"><?php echo $log_date; ?></td>
			  </tr>
			  <tr>
				<td  class="text-left"><?php echo $entry_user_name; ?></td>
				<td class="text-left"><?php echo $user_name; ?> </td>
			  </tr>
			  <tr>
				<td class="text-left"><?php echo $entry_ip_address; ?></td>
				<td class="text-left"><?php echo $ip_address; ?></td>
			  </tr>
			  <tr>
				<td class="text-left"><?php echo $entry_log_item; ?></td>
				<td class="text-left"><?php echo $log_item; ?></td>
			  </tr>
			  <tr>
				<td class="text-left"><?php echo $entry_log_action; ?></td>
				<td class="text-left"><?php echo $log_action; ?></td>
			  </tr>
			  <tr>
				<td class="text-left"><?php echo $entry_log_data; ?></td>
				<td class="text-left"><?php html_show_array($log_data); ?></td>
			  </tr>
			</tbody>
			</table>
			</div>
  </div>	
 </div>
  <?php echo $footer; 

function do_offset($level){
	$offset = "";             // offset for subarry 
	for ($i=1; $i<$level;$i++){
	$offset = $offset . "<td></td>";
	}
	return $offset;
}

function show_array($array, $level, $sub){
	if (is_array($array) == 1){          // check if input is an array
	   foreach($array as $key_val => $value) {
		   $offset = "";
		   if (is_array($value) == 1){   // array is multidimensional
		   echo "<tr>";
		   $offset = do_offset($level);
		   echo $offset . "<td>" . $key_val . "</td>";
		   show_array($value, $level+1, 1);
		   }
		   else{                        // (sub)array is not multidim
		   if ($sub != 1){          // first entry for subarray
			   echo "<tr nosub>";
			   $offset = do_offset($level);
		   }
		   $sub = 0;
		   echo $offset . "<td main ".$sub." width=\"120\">" . $key_val . 
			   "</td><td width=\"120\">" . $value . "</td>"; 
		   echo "</tr>\n";
		   }
	   } //foreach $array
	}  
	else{ // argument $array is not an array
		return;
	}
}

function html_show_array($array){
  echo "<div class=\"table-responsive\"><table class=\"table table-bordered table-hover\" cellspacing=\"0\" border=\"1\">\n";
  show_array($array, 1, 0);
  echo "</table>\n</div>";
}

?> 