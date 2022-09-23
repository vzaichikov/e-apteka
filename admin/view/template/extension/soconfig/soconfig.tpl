<?php 
/******************************************************
 * @package	SO Theme Framework for Opencart 2.0.x
 * @author	http://www.magentech.com
 * @license	GNU General Public License
 * @copyright(C) 2008-2015 Magentech.com. All rights reserved.
*******************************************************/
?>

<?php echo $header; ?><?php echo $column_left; ?>

<?php 
	$logos = array(
		'left' => 'Left',
		'center'  => 'Center',
	);
	
	$fonts = array(
		'standard' => 'Standard',
		'google'  => 'Google Fonts',
	);
	
	$columns = array(
		'1' => '1 columns',
		'2' => '2 columns',
		'3' => '3 columns',
		'4' => '4 columns',
		'5' => '5 columns',
		'6' => '6 columns',
	);
	
	$secondimg = array(
		'1' => 'One image',
		'2' => 'Second images',
	);
	
	$refine_search = array(
		'0' => 'With images',
		'1' => 'Text only',
		'2' => 'Disable',
	);
	
	$devices = array(
		'lg' => '<i class="fa fa-desktop"></i> Desktops',
		'md' => '<i class="fa fa-tablet"></i> Tablet Landscape',
		'sm' => '<i class="fa fa-tablet"></i> Tablet Portrait',
		'xs' => '<i class="fa fa-mobile"></i> Phones',
	);
	
	$fonts_normal = array(
		'inherit' => 'No Use',
		'Arial, Helvetica, sans-serif'  => 'Arial',
		'Verdana, Geneva, sans-serif'  => 'Verdana',
		'Georgia,Times New Roman, Times, serif'  => 'Georgia',
		'Impact, Arial, Helvetica, sans-serif'  => 'Impact',
		'Tahoma, Geneva, sans-serif'  => 'Tahoma',
		'Trebuchet MS, Arial, Helvetica, sans-serif'  => 'Trebuchet MS',
		'Arial Black, Gadget, sans-serif'  => 'Arial Black',
		'Times, Times New Roman, serif'  => 'Times',
		'Palatino Linotype, Book Antiqua, Palatino, serif'  => 'Palatino Linotype',
		'Lucida Sans Unicode, Lucida Grande", sans-serif'  => 'Lucida Sans Unicode',
		'MS Serif, New York, serif'  => 'MS Serif',
		'Comic Sans MS, cursive'  => 'Comic Sans MS',
		'Courier New, Courier, monospace'  => 'Courier New',
		'Lucida Console, Monaco, monospace'  => 'Lucida Console',
	);
	
	$Scssformat = array(
		'Expanded' => 'Expanded',
		'Nested' => 'Nested (default)',
		'Compressed' => 'Compressed',
		'Compact' => 'Compact',
		'Crunched' => 'Crunched',
	);
	
	$layoutStyle = array(
		'full' => 'Full Layout',
		'boxed' => 'Boxed',
		'iframed' => 'Iframed',
		'rounded' => 'Rounded',
	);
	
	$content_bg_mode = array(
		'repeat' => 'Repeat',
		'no-repeat' => 'No-Repeat',
	);
	$content_attachment = array(
		'scroll' => 'Scroll',
		'fixed' => 'Fixed',
	);
	
	
	$related_position = array(
		'vertical' => 'Vertical',
		'horizontal' => 'Horizontal',
	);
	$brands = array(
		'1' => 'Name',
		'2' => 'Logo',
		'3' => 'Logo width name',
	);

	$thumbnailPos = array(
		'bottom' => 'bottom',
		'left' => 'Left',
	);

	$zoommode = array(
		'basic' => 'Basic Zoom',
		'inner' => 'Inner Zoom',
		'lens' => 'Lens Zoom',
	);

	$tabs_position = array(
		'1' => 'Bottom vertical',
		'2' => 'Bottom horizontal',
		'3' => 'Collapsed in product description',
	);
	
	$toppanel_type = array(
		'1' => 'Clickable',
		'2' => 'Floating'
	);
	$catalog_mode = array(
		'0' => 'Grid',
		'1' => 'List'
	);
	
	$radio_style = array(
		'0' => 'Default',
		'1' => 'Button'
	);
	
	$type_banner = array(
		'1' => 'Hover effect 1',
		'2' => 'Hover effect 2',
		'3' => 'Hover effect 3',
		'4' => 'Hover effect 4',
		'5' => 'Hover effect 5',
		'6' => 'Hover effect 6',
		'7' => 'Hover effect 7',
		'8' => 'Hover effect 8',
		'9' => 'Hover effect 9',
		'10' => 'Hover effect 10',
		'11' => 'Hover effect 11',
		'12' => 'Hover effect 12',
	);
	
?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
                <h2>Theme Control Panel </h2>
                <ul class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?> </a></li>
                    <?php } ?>
                </ul>
        </div>
    </div>

    <div id="theme-options" class="container-fluid">
       <?php if (isset($error['warning'])) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
		
        <?php if (isset($success) && !empty($success)) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>

        <div class="panel ">
			<div class="content">
				<div class="panel-heading store-heading">
				
					<div class="col-sm-6">
						<div class="btn-group heading-store">View Store : </div>
						<div class="btn-group">
							<?php foreach ($stores as $store) : ?>
								<?php if ($store['store_id'] == $active_store) : ?>
									<a class="btn  dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $store['name'] ?> <span class="fa fa-angle-down"></span></a>
								<?php endif;?>
							<?php endforeach  ?>
							
							<ul class="dropdown-menu ">
								<?php 
								foreach ($stores as $store) : $store_active = ($store['store_id'] == $active_store) ? 'active' : '';
									if($store['status']) :
								?>
										<li <?php echo 'class="'.$store_active.'"'?> ><a href="<?php echo $soconfig_href.'&store_id='.$store['store_id']; ?>"><?php echo $store["name"]; ?></a></li>
								<?php 
									endif;
								endforeach; 
								?>
							</ul>

					   </div>

					</div>
					
					<div class="col-sm-6">
						<div class="pull-right">
							<a class=" products_button " href="<?php echo $mproduct; ?>" data-toggle="tooltip" data-original-title="Additional Product Options" target="_blank">Products Options</a>

							<a onclick="buttonApply();" data-toggle="tooltip" title="Apply Changes" class="btn btn-success"><i class="fa fa-save"></i></a>
							<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-close"></i></a>
						</div>
					</div>
				</div>
            </div>
            
			<div class="content">
				<div class="panel-body">
					<form name="settingsform" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-optimus" class="form-horizontal">
						<div class="form-horizontal">
							<div class="tab-content tab-content-main">
								
								<?php 
								foreach ($stores as $store) : 
									if($store['status'] && ($store['store_id'] == $active_store)) :
								?>
										<div class="clearfix tab-pane-demo " id="tab-store">
											<?php include('options_stores.php'); ?>
										</div>
								<?php 
									endif;
								endforeach; 
								?>
							</div>

						</div>
						<input name="buttonForm" type="hidden"  value="" />
						<input name="buttonColor" type="hidden"  value="" />
					</form>


				</div>
			</div>
        </div>

    </div>

</div>



<script type="text/javascript"><!--
$(document).ready(function(){

    
<?php 
foreach ($stores as $store) : 
	if($store['status'] && ($store['store_id'] == $active_store)) :
?>
		jQuery("#soconfig_colors_bgcolor<?php echo $store['store_id']; ?>").ColorPicker({
			color: jQuery('#soconfig_colors_bgcolor<?php echo $store['store_id']; ?>').val(),
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#soconfig_colors_bgcolor<?php echo $store['store_id']; ?>').css('backgroundColor', '#' + hex);
				jQuery('#soconfig_colors_bgcolor<?php echo $store['store_id']; ?>').val('#' + hex);
			}
		});

		/**************************************************** initialisation for multstore options begin */
		jQuery("#soconfig_colors_theme<?php echo $store['store_id']; ?>").ColorPicker({
			color: jQuery('#soconfig_colors_theme<?php echo $store['store_id']; ?>').val(),
				onShow: function (colpkr) {
			jQuery(colpkr).fadeIn(500);
			return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#soconfig_colors_theme<?php echo $store['store_id']; ?>').css('backgroundColor', '#' + hex);
				jQuery('#soconfig_colors_theme<?php echo $store['store_id']; ?>').val('#' + hex);
			}
		});
	  
		
		<?php foreach ($languages as $language) : ?>
		$('#input-description-customblock<?php echo $language['language_id']; ?>-<?php echo $store['store_id']; ?>').summernote({height: 150});
		$('#input-description-footer_socials<?php echo $language['language_id']; ?>-<?php echo $store['store_id']; ?>').summernote({height: 150});
		$('#input-description-footerpayment<?php echo $language['language_id']; ?>-<?php echo $store['store_id']; ?>').summernote({height: 150});
		$('#input-description-video_code<?php echo $language['language_id']; ?>-<?php echo $store['store_id']; ?>').summernote({height: 150});
		$('#input-description-product_socialshare<?php echo $language['language_id']; ?>-<?php echo $store['store_id']; ?>').summernote({height: 150});
		$('#input-description-html_product_right<?php echo $language['language_id']; ?>-<?php echo $store['store_id']; ?>').summernote({height: 150});
		<?php endforeach; ?>
		
		$('#tab-general__headertype-<?php echo $store['store_id']; ?>').on('click', '.type', function () {
		   $('#tab-general__headertype-<?php echo $store['store_id']; ?> .type').removeClass("active");
		   $(this).addClass("active");
		});
		$('#tab-general__footertype-<?php echo $store['store_id']; ?>').on('click', '.type', function () {
		   $('#tab-general__footertype-<?php echo $store['store_id']; ?> .type').removeClass("active");
		   $(this).addClass("active");
		});
		$('#tab-general__layouttype-<?php echo $store['store_id']; ?>').on('click', '.type', function () {
		    $('#tab-general__layouttype-<?php echo $store['store_id']; ?> .type').removeClass("active");
		    $(this).addClass("active");
			$keylayout = $(this).data("keylayout");
			$keyheader = $(this).data("keyheader");
			$keyfooter = $(this).data("keyfooter");
			
			$("#tab-general__headertype-<?php echo $store['store_id']; ?> .group-typeheader").each(function() {
			    $(this).find(".type").removeClass("active");
				$(this).find("input:radio").prop("checked", false);
			    if( $keyheader ==  $(this).find(".type").data("typeheader")) {
					$(this).find(".type").addClass("active");
					$(this).find(".type").prev().prop("checked", true);
			    }
			});
			$("#tab-general__footertype-<?php echo $store['store_id']; ?> .group-typeheader").each(function() {
			    $(this).find(".type").removeClass("active");
				$(this).find("input:radio").prop("checked", false);
				
			    if($keyfooter ==  $(this).find(".type").data("typefooter")) {
					$(this).find(".type").addClass("active");
					$(this).find(".type").prev().prop("checked", true);
			    }
			});
			
			var $currentcolor = $("#select_color_<?php echo $store['store_id']; ?> option").filter(":selected").val();
			$.ajax({
				url: 'index.php?route=extension/module/soconfig/getColorScheme&token=<?php echo $token; ?>&filter_name='+$keylayout ,
				dataType: 'json',
				success: function(json) {
					$.map(json, function(item) {
						var selectList = "<select name='numbers'>";
						$.each(json, function (index, value) {
							($currentcolor == value['name']) ? $current = 'selected' : $current=''; 
							
							selectList += "<option "+$current+">" + value['name'] + "</option>";
						});
						selectList += "</select>";
						$select_id = $('#select_color_<?php echo $store['store_id']; ?>');
						$select_id.html(selectList);
					});
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
			
			
		});
		
	
		$('#tab-general__bannereffect-<?php echo $store['store_id']; ?>').on('click', '.type', function () {
		   $('#tab-general__bannereffect-<?php echo $store['store_id']; ?> .type').removeClass("active");
		   $(this).addClass("active");
		});

		/*Button Radio On/Off*/
		if ($(".field-preloader:checked").val() == '0' ) $('#tab-general__preloader').hide();
		else $('#tab-general__preloader').show();
	
		$("input.field-preloader").change(function(){
			val = $(this).val();
			if(val ==0)$('#tab-general__preloader').hide();
			else $('#tab-general__preloader').show();
		});
<?php 
	endif;
endforeach;  ?>
    
	//======= Custom Code ======= 
<?php 
foreach ($stores as $store) :
	if($store['status'] && ($store['store_id'] == $active_store)) :
?>
	custom_code('cssfile',<?php echo $store['store_id']; ?>);
	custom_code('jsfile',<?php echo $store['store_id']; ?>);

<?php 
	endif;
endforeach;  ?>

    /* end stores */

});

function buttonApply() {
	document.settingsform.buttonForm.value='apply'; $('#form-optimus').submit();
}
function buttonApplyColor() {
	document.settingsform.buttonForm.value='color';$('#form-optimus').submit();
}
function installMegamenu() { 
   document.settingsform.buttonForm.value='install-data'; $('#form-optimus').submit();
}


function custom_code($input_file,$store_id){
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".customcode_wrap"); //Fields wrapper
    var add_button      = $(".add-"+$input_file+$store_id); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
			
			var $box_html = $('<div class="form-group"><label class="col-sm-2 control-label" >Enter file path</label><div class="col-sm-9"><input class="form-control" type="text" name="soconfig_custom_store['+$store_id+']['+$input_file+'][]"/></div><div class="col-sm-1"><a href="#" class="btn btn-success remove_field"><i class="fa fa-times"></i></a></div></div>');
		
            $(this).closest(".so-panel").find('.panel-container').append($box_html); //add input box
        }
    });
	
	$(window).load(function () {
		var $input_values = $('input[name^="soconfig_custom_store['+$store_id+']['+$input_file+'][]"');
		$input_values.each(function() {
			var url_file = $(this).val();
			if( url_file ){
				var ext = url_file.split(".").pop().toLowerCase();
			}
			if($input_file =='cssfile' && $.inArray(ext, ['css']) == -1){
				$(this).after('<p class="pic_error" >Add file formats should be .css</p>');
			}else if($input_file =='jsfile' && $.inArray(ext, ['js']) == -1){
				$(this).after('<p class="pic_error" >Add file formats should be .js</p>');
			}
		});
	});
	
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('.form-group').remove(); x--;
    })

}
//--></script>

<?php echo $footer; ?>