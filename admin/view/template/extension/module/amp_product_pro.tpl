<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-amp_product_pro" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-amp_product_pro" class="form-horizontal">
         
            <div class="form-group">
            <label class="col-sm-2 control-label" for="checkbox1"><?php echo $entry_related; ?></label>
            <div class="col-sm-6">
				<?php if ($amp_product_pro_enable_related) { ?>
              <input type="checkbox" name="amp_product_pro_enable_related" class="ios8-switch ios8-switch-lg" id="checkbox1" checked="checked"></input>
				<?php } else { ?>
			  <input type="checkbox" name="amp_product_pro_enable_related" class="ios8-switch ios8-switch-lg" id="checkbox1"></input>  
				<?php } ?>
				<label for="checkbox1"></label>
            </div>
          </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="checkbox2"><?php echo $entry_rating; ?></label>
            <div class="col-sm-6">
				<?php if ($amp_product_pro_enable_rating) { ?>
              <input type="checkbox" name="amp_product_pro_enable_rating" class="ios8-switch ios8-switch-lg" id="checkbox2" checked="checked"></input>
				<?php } else { ?>
			  <input type="checkbox" name="amp_product_pro_enable_rating" class="ios8-switch ios8-switch-lg" id="checkbox2"></input>  
				<?php } ?>
				<label for="checkbox2"></label>
            </div>
          </div> 
		  <!--<div class="form-group">
            <label class="col-sm-2 control-label" for="checkbox3"><?php echo $entry_carousel; ?></label>
            <div class="col-sm-6">
				<?php if ($amp_product_pro_enable_carousel) { ?>
              <input type="checkbox" name="amp_product_pro_enable_carousel" class="ios8-switch ios8-switch-lg" id="checkbox3" checked="checked"></input>
				<?php } else { ?>
			  <input type="checkbox" name="amp_product_pro_enable_carousel" class="ios8-switch ios8-switch-lg" id="checkbox3"></input>  
				<?php } ?>
				<label for="checkbox3"></label>
            </div>
          </div>-->
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="checkbox4"><?php echo $entry_carousel_rel; ?></label>
            <div class="col-sm-6">
				<?php if ($amp_product_pro_enable_carousel_rel) { ?>
              <input type="checkbox" name="amp_product_pro_enable_carousel_rel" class="ios8-switch ios8-switch-lg" id="checkbox4" checked="checked"></input>
				<?php } else { ?>
			  <input type="checkbox" name="amp_product_pro_enable_carousel_rel" class="ios8-switch ios8-switch-lg" id="checkbox4"></input>  
				<?php } ?>
				<label for="checkbox4"></label>
            </div>
          </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_background; ?></label>
             
                            <div class="col-sm-3">
                              <input type="text" name="amp_product_pro_back_color" value="<?php echo $amp_product_pro_back_color; ?>"  class="form-control colorpicker" />
                            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_links; ?></label>
             
                            <div class="col-sm-3">
                              <input type="text" name="amp_product_pro_link_color" value="<?php echo $amp_product_pro_link_color; ?>"  class="form-control colorpicker" />
                            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_cart; ?></label>
             
                            <div class="col-sm-3">
                              <input type="text" name="amp_product_pro_cart_color" value="<?php echo $amp_product_pro_cart_color; ?>"  class="form-control colorpicker" />
                            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_search; ?></label>
             
                            <div class="col-sm-3">
                              <input type="text" name="amp_product_pro_search_color" value="<?php echo $amp_product_pro_search_color; ?>"  class="form-control colorpicker" />
                            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
              <input type="text" name="amp_product_pro_image_width" value="<?php echo $amp_product_pro_image_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
            <div class="col-sm-10">
              <input type="text" name="amp_product_pro_image_height" value="<?php echo $amp_product_pro_image_height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
              <?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-logo-width"><?php echo $entry_logo_width; ?></label>
            <div class="col-sm-10">
              <input type="text" name="amp_product_pro_logo_width" value="<?php echo $amp_product_pro_logo_width; ?>" placeholder="<?php echo $entry_logo_width; ?>" id="input-logo-width" class="form-control" />
              <?php if ($error_logo_width) { ?>
              <div class="text-danger"><?php echo $error_logo_width; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-logo-height"><?php echo $entry_logo_height; ?></label>
            <div class="col-sm-10">
              <input type="text" name="amp_product_pro_logo_height" value="<?php echo $amp_product_pro_logo_height; ?>" placeholder="<?php echo $entry_logo_height; ?>" id="input-logo-height" class="form-control" />
              <?php if ($error_logo_height) { ?>
              <div class="text-danger"><?php echo $error_logo_height; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="amp_product_pro_status" id="input-status" class="form-control">
                <?php if ($amp_product_pro_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>          
        </form>
      </div>
	</div>
  </div>
</div>
<style type="text/css">
input[type="checkbox"].ios8-switch {
    position: absolute;
    margin: 8px 0 0 16px;    
}
input[type="checkbox"].ios8-switch + label {
    position: relative;
    padding: 5px 0 0 50px;
    line-height: 2.0em;
}
input[type="checkbox"].ios8-switch + label:before {
    content: "";
    position: absolute;
    display: block;
    left: 0;
    top: 0;
    width: 40px; /* x*5 */
    height: 24px; /* x*3 */
    border-radius: 16px; /* x*2 */
    background: #fff;
    border: 1px solid #d9d9d9;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
input[type="checkbox"].ios8-switch + label:after {
    content: "";
    position: absolute;
    display: block;
    left: 0px;
    top: 0px;
    width: 24px; /* x*3 */
    height: 24px; /* x*3 */
    border-radius: 16px; /* x*2 */
    background: #fff;
    border: 1px solid #d9d9d9;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
input[type="checkbox"].ios8-switch + label:hover:after {
    box-shadow: 0 0 5px rgba(0,0,0,0.3);
}
input[type="checkbox"].ios8-switch:checked + label:after {
    margin-left: 16px;
}
input[type="checkbox"].ios8-switch:checked + label:before {
    background: #55D069;
}

input[type="checkbox"].ios8-switch-lg {
    margin: 10px 0 0 20px;
}
input[type="checkbox"].ios8-switch-lg + label {
    position: relative;
    padding: 7px 0 0 60px;
    line-height: 2.3em;
}
input[type="checkbox"].ios8-switch-lg + label:before {
    width: 50px; /* x*5 */
    height: 30px; /* x*3 */
    border-radius: 20px; /* x*2 */
}
input[type="checkbox"].ios8-switch-lg + label:after {
    width: 30px; /* x*3 */
    height: 30px; /* x*3 */
    border-radius: 20px; /* x*2 */
}
input[type="checkbox"].ios8-switch-lg + label:hover:after {
    box-shadow: 0 0 8px rgba(0,0,0,0.3);
}
input[type="checkbox"].ios8-switch-lg:checked + label:after {
    margin-left: 20px; /* x*2 */
}
.colorpicker {
  color: #fff;
  font-size: 10px;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 0px 0px 6px #000;
}

</style>
<?php echo $footer; ?>
<script type="text/javascript"><!--
    $('.colorpicker').each(function(index) {
      $(this).attr('id', 'colorpicker_'+index );
      var colorpicker = new Array();
      colorpicker[index] = $('#colorpicker_'+index).val();
      $('#colorpicker_'+index).css('background-color', colorpicker[index]);

      $('#colorpicker_'+index).colpick({
        layout:'rgbhex',
        submit:0,
        color: colorpicker[index],
        onChange:function(hsb,hex,rgb,el,bySetColor) {
          if(!bySetColor) {
            $(el).val('#'+hex);
            $('#colorpicker_'+index).val('#'+hex );
          }
          $(el).css('background-color','#'+hex);
          $('.colpick_current_color').css('display', 'visible' );
        }
      }).keyup(function(){
        $(this).colpickSetColor(this.value);
      });

    });
	-->
	</script>