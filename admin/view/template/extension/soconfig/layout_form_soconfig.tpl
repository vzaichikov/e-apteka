<?php 
require('options_field.php');
?>

<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-layout" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-layout" class="form-horizontal">
          <fieldset>
            <legend><?php echo $text_route; ?></legend>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                <?php if ($error_name) { ?>
                <div class="text-danger"><?php echo $error_name; ?></div>
                <?php } ?>
              </div>
            </div>
            <table id="route" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $entry_store; ?></td>
                  <td class="text-left"><?php echo $entry_route; ?></td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php $route_row = 0; ?>
                <?php foreach ($layout_routes as $layout_route) { ?>
                <tr id="route-row<?php echo $route_row; ?>">
                  <td class="text-left"><select name="layout_route[<?php echo $route_row; ?>][store_id]" class="form-control">
                      <option value="0"><?php echo $text_default; ?></option>
                      <?php foreach ($stores as $store) { ?>
                      <?php if ($store['store_id'] == $layout_route['store_id']) { ?>
                      <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                  <td class="text-left"><input type="text" name="layout_route[<?php echo $route_row; ?>][route]" value="<?php echo $layout_route['route']; ?>" placeholder="<?php echo $entry_route; ?>" class="form-control" /></td>
                  <td class="text-left"><button type="button" onclick="$('#route-row<?php echo $route_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                </tr>
                <?php $route_row++; ?>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2"></td>
                  <td class="text-left"><button type="button" onclick="addRoute();" data-toggle="tooltip" title="<?php echo $button_route_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                </tr>
              </tfoot>
            </table>
          </fieldset>
		  
          <fieldset>
			<?php global $module_row;$module_row = 0; ?>
				<legend><?php echo $text_module; ?></legend>
				<div class="bs-callout bs-callout-info" id="callout-alerts-no-default"> <h4>Content Header</h4> </div>
				<div class="well"> 
					<div class="row">
						<div class="col-md-3 col-sm-12"> 
							<pre><h2 class="text-center">Logo</h2></pre>
						</div>
						<div class="col-md-3 col-sm-12"> 
							<?php echo create_position('Menu Horizontal','content_menu',$layout_modules,$extensions,$module_row); ?>
						</div>
						
						<div class="col-md-3 col-sm-12"> 
							<?php echo create_position('Menu Vertical','content_menu1',$layout_modules,$extensions,$module_row); ?>
						</div>
						
						<div class="col-md-3 col-sm-12"> 
							<?php echo create_position('Content Search','content_search',$layout_modules,$extensions,$module_row); ?>
						</div>
					 </div>
				</div>
				
				<div class="bs-callout bs-callout-info" id="callout-alerts-no-default"> <h4>Content Main</h4> </div>
				<div class="well"> 
					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-12">
							<?php echo create_position('Column Left','column_left',$layout_modules,$extensions,$module_row); ?>
						</div>
						<div class="col-lg-6 col-md-4 col-sm-12">
							<div class="row">
								
								<div class="col-sm-12"> 
									<?php echo create_position('Content Top','content_top',$layout_modules,$extensions,$module_row); ?>
								</div>
								<div class="col-sm-12"> 
									<?php echo create_position('Content Bottom','content_bottom',$layout_modules,$extensions,$module_row); ?>
								</div>
							</div>
						</div>
					  
						<div class="col-lg-3 col-md-4 col-sm-12">
							<?php echo create_position('Content Right','column_right',$layout_modules,$extensions,$module_row); ?>
						</div>
						<?php 
						if (isset($layout_route))	:
						if(($layout_route['route'])=='mobile/home'  ) : ?>
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12"> 
									<?php echo create_posmobile('Content Mobile','content_mobile',$layout_modules,$extensions,$module_row); ?>
								</div>
								
							</div>
						</div>
						<?php endif;?>
						<?php endif;?>
					</div>
				</div>
				
				<div class="bs-callout bs-callout-info" id="callout-alerts-no-default"> <h4>Content Footer</h4> </div>
				<div class="well"> 
					<div class="row">
					
						<div class="col-md-12 col-sm-12"> 
							<?php echo create_position('Content Footer Top','footertop',$layout_modules,$extensions,$module_row); 
							
							?>
						</div>
						<div class="col-md-6 col-sm-12"> 
							<?php echo create_position('Footer Block1 (Used in Footer 1,2,3)','footer_block1',$layout_modules,$extensions,$module_row); 
							
							?>
						</div>
						<div class="col-md-6 col-sm-12"> 
							<?php echo create_position('Footer Block2 (Used in Footer 1,2,3)','footer_block2',$layout_modules,$extensions,$module_row); 
							
							?>
						</div>
						<div class="col-md-6 col-sm-12"> 
							<?php echo create_position('Footer Block3 (Used in Footer 4,5)','footer_block3',$layout_modules,$extensions,$module_row); 
							
							?>
						</div>
						<div class="col-md-6 col-sm-12"> 
							<?php echo create_position('Footer Block4 (Used in Footer 4)','footer_block4',$layout_modules,$extensions,$module_row); 
							
							?>
						</div>
						<div class="col-md-12 col-sm-12"> 
							<?php echo create_position('Content Footer Bottom','footerbottom',$layout_modules,$extensions,$module_row); ?>
						</div>
					 </div>
				</div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <style>
	.form-order{
		border: 1px solid #ccc;    
		vertical-align: top;
		margin-left: -1px;
	}
  </style>
  <script type="text/javascript"><!--
var route_row = <?php echo $route_row; ?>;

function addRoute() {
	html  = '<tr id="route-row' + route_row + '">';
	html += '  <td class="text-left"><select name="layout_route[' + route_row + '][store_id]" class="form-control">';
	html += '  <option value="0"><?php echo $text_default; ?></option>';
	<?php foreach ($stores as $store) { ?>
	html += '<option value="<?php echo $store['store_id']; ?>"><?php echo addslashes($store['name']); ?></option>';
	<?php } ?>   
	html += '  </select></td>';
	html += '  <td class="text-left"><input type="text" name="layout_route[' + route_row + '][route]" value="" placeholder="<?php echo $entry_route; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#route-row' + route_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#route tbody').append(html);
	
	route_row++;
}

var module_row = <?php echo $module_row; ?>;

function addModule(type) {
	html  = '<tr id="module-row' + module_row + '">';
    html += '  <td class="text-left"><div class="input-group"><select name="layout_module[' + module_row + '][code]" class="form-control input-sm">';
	<?php foreach ($extensions as $extension) { ?>
	html += '    <optgroup label="<?php echo addslashes($extension['name']); ?>">';
	<?php if (!$extension['module']) { ?>
	html += '      <option value="<?php echo $extension['code']; ?>"><?php echo addslashes($extension['name']); ?></option>';
	<?php } else { ?>
	<?php foreach ($extension['module'] as $module) { ?>
	html += '      <option value="<?php echo $module['code']; ?>"><?php echo addslashes($module['name']); ?></option>';
	<?php } ?>
	<?php } ?>
	html += '    </optgroup>';
	<?php } ?>
	html += '  </select>';
    html += '  <input type="hidden" name="layout_module[' + module_row + '][position]" value="' + type.replace('-', '_') + '" />';
	html += '  <div class="input-group-btn"><input type="text" size="5" class="form-order input-sm" name="layout_module[' + module_row + '][sort_order]" value="" /><a href="" target="_blank" type="button" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a><button type="button" onclick="$(\'#module-row' + module_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button></div></div></td>';
	html += '</tr>';
	
	$('#module-' + type + ' tbody').append(html);
	
	$('#module-' + type + ' tbody select[name=\'layout_module[' + module_row + '][code]\']').val($('#module-' + type + ' tfoot select').val());
	
	$('#module-' + type + ' select[name*=\'code\']').trigger('change');
		
	$('#module-' + type + ' tbody input[name*=\'sort_order\']').each(function(i, element) {
		$(element).val(i);
	});
	
	module_row++;
}

$('#module-content_left, #module-column_right, #module-content_top, #module-content_bottom , #module-content_menu,#module-content_menu1, #module-content_search,#module-footertop,#module-footerbottom').delegate('select[name*=\'code\']', 'change', function() {
	var part = this.value.split('.');
	console.log(part[0]);
	if (!part[1]) {
		$(this).parent().find('a').attr('href', 'index.php?route=extension/module/' + part[0] + '&token=<?php echo $token; ?>');
	} else {
		$(this).parent().find('a').attr('href', 'index.php?route=extension/module/' + part[0] + '&token=<?php echo $token; ?>&module_id=' + part[1]);
	}
});
$('#module-content_left, #module-column_right, #module-content_top, #module-content_bottom,#module-content_menu,#module-content_menu1,#module-content_search,#module-footertop,#module-footerbottom').trigger('change');
//--></script> 
</div>
<?php echo $footer; ?>