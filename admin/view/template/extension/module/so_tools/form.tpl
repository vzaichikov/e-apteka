<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  	<div class="page-header">
    	<div class="container-fluid">
      		<div class="pull-right">
        		<button type="submit" form="form-so-tools" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
        		<a class="btn btn-success" onclick="$('#action').val('save_edit');$('#form-so-tools').submit();" data-toggle="tooltip" title="<?php echo $button_savestay; ?>" ><i class="fa fa-pencil-square-o"></i> <?php echo $button_savestay?></a>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
        	</div>
			<h1><?php echo $heading_title_so; ?></h1>
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
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_layout; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
    	<?php } ?>
    	<div class="panel panel-default">
      		<div class="panel-heading">
        		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      		</div>
      		<div class="panel-body">
	   			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-so-tools" class="form-horizontal">
	   				<input type="hidden" name="action" id="action" value=""/>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_status_help?>"><?php echo $text_status; ?></span></label>
						<div class="col-sm-3">
							<select name="status" id="input-status" class="form-control">
								<?php if (isset($status) && $status == 1) {?>
	                				<option value="1" selected="selected"><?php echo $text_enabled?></option>
	                				<option value="0"><?php echo $text_disabled?></option>
	                			<?php }else {?>
	                				<option value="1"><?php echo $text_enabled?></option>
	                				<option value="0" selected="selected"><?php echo $text_disabled?></option>
	                			<?php }?>
	                		</select>
		  				</div>
					</div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-name"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_name_help?>"><?php echo $text_name; ?></span></label>
                        <div class="col-sm-3">
                            <input type="text" id="input-name" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
                            <?php if ($error_name) { ?>
                                <div class="text-danger"><?php echo $error_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-position"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_position_help?>"><?php echo $text_position; ?></span></label>
                        <div class="col-sm-3">
                            <select name="position" id="input-position" class="form-control">
                                <?php if (isset($position) && $position == 'left') {?>
                                    <option value="left" selected="selected"><?php echo $text_left?></option>
                                    <option value="right"><?php echo $text_right?></option>
                                <?php }else {?>
                                    <option value="left"><?php echo $text_left?></option>
                                    <option value="right" selected="selected"><?php echo $text_right?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-top"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_top_help?>"><?php echo $text_top; ?></span></label>
                        <div class="col-sm-3">
                            <input type="text" id="input-top" name="top" value="<?php echo $top; ?>" id="input-top" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-show_category"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_show_category_help?>"><?php echo $text_show_category; ?></span></label>
                        <div class="col-sm-3">
                            <select name="show_category" id="input-show_category" class="form-control">
                                <?php if (isset($show_category) && $show_category == 1) {?>
                                    <option value="1" selected="selected"><?php echo $text_yes?></option>
                                    <option value="0"><?php echo $text_no?></option>
                                <?php }else {?>
                                    <option value="1"><?php echo $text_yes?></option>
                                    <option value="0" selected="selected"><?php echo $text_no?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-show_cart"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_show_cart_help?>"><?php echo $text_show_cart; ?></span></label>
                        <div class="col-sm-3">
                            <select name="show_cart" id="input-show_cart" class="form-control">
                                <?php if (isset($show_cart) && $show_cart == 1) {?>
                                    <option value="1" selected="selected"><?php echo $text_yes?></option>
                                    <option value="0"><?php echo $text_no?></option>
                                <?php }else {?>
                                    <option value="1"><?php echo $text_yes?></option>
                                    <option value="0" selected="selected"><?php echo $text_no?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-show_account"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_show_account_help?>"><?php echo $text_show_account; ?></span></label>
                        <div class="col-sm-3">
                            <select name="show_account" id="input-show_account" class="form-control">
                                <?php if (isset($show_account) && $show_account == 1) {?>
                                    <option value="1" selected="selected"><?php echo $text_yes?></option>
                                    <option value="0"><?php echo $text_no?></option>
                                <?php }else {?>
                                    <option value="1"><?php echo $text_yes?></option>
                                    <option value="0" selected="selected"><?php echo $text_no?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-show_search"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_show_search_help?>"><?php echo $text_show_search; ?></span></label>
                        <div class="col-sm-3">
                            <select name="show_search" id="input-show_search" class="form-control">
                                <?php if (isset($show_search) && $show_search == 1) {?>
                                    <option value="1" selected="selected"><?php echo $text_yes?></option>
                                    <option value="0"><?php echo $text_no?></option>
                                <?php }else {?>
                                    <option value="1"><?php echo $text_yes?></option>
                                    <option value="0" selected="selected"><?php echo $text_no?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-show_recent_product"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_show_recent_product_help?>"><?php echo $text_show_recent_product; ?></span></label>
                        <div class="col-sm-3">
                            <select name="show_recent_product" id="input-show_recent_product" class="form-control">
                                <?php if (isset($show_recent_product) && $show_recent_product == 1) {?>
                                    <option value="1" selected="selected"><?php echo $text_yes?></option>
                                    <option value="0"><?php echo $text_no?></option>
                                <?php }else {?>
                                    <option value="1"><?php echo $text_yes?></option>
                                    <option value="0" selected="selected"><?php echo $text_no?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-limit-product"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_limit_product_help?>"><?php echo $text_limit_product; ?></span></label>
                        <div class="col-sm-3">
                            <input type="text" id="input-limit-product" name="limit_product" value="<?php echo $limit_product; ?>" id="input-top" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-show_backtop"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_show_backtop_help?>"><?php echo $text_show_backtop; ?></span></label>
                        <div class="col-sm-3">
                            <select name="show_backtop" id="input-show_backtop" class="form-control">
                                <?php if (isset($show_backtop) && $show_backtop == 1) {?>
                                    <option value="1" selected="selected"><?php echo $text_yes?></option>
                                    <option value="0"><?php echo $text_no?></option>
                                <?php }else {?>
                                    <option value="1"><?php echo $text_yes?></option>
                                    <option value="0" selected="selected"><?php echo $text_no?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
	   			</form>
	   		</div>
	   	</div>
	</div>
</div>
<?php echo $footer; ?>