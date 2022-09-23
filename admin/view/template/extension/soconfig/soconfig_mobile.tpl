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
	
	$fonts = array(
		'standard' => 'Standard',
		'google'  => 'Google Fonts',
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
	
	
	$tabs_position = array(
		'1' => 'Bottom vertical',
		'2' => 'Bottom horizontal',
		'3' => 'Collapsed in product description',
	);
	
	
	
	
?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
                <h2><?php echo $objlang->get('heading_title_normal'); ?> </h2>
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
						<h3 class="title"><i class="fa fa-mobile" style="font-size: 32px;margin: 0 5px;"></i> SO Mobile </h3>
					</div>
					
					<div class="col-sm-6">
						<div class="pull-right">

							<a onclick="buttonApply();" data-toggle="tooltip" title="Apply Changes" class="btn btn-success"><i class="fa fa-save"></i></a>
							<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-close"></i></a>
						</div>
					</div>
				</div>
            </div>
            
			<div class="content">
				<div class="panel-body">
					<form name="settingsform" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-optimus" class="form-horizontal">
						
						<input name="buttonForm" type="hidden"  value="" />
						<input name="buttonColor" type="hidden"  value="" />
						<div class="form-horizontal">
							<div class="tab-content tab-content-main" id="tab-store<?php echo $store['store_id']; ?>">
								<?php include('options_stores_mobile.php'); ?>
							</div>

						</div>
						
					</form>


				</div>
			</div>
        </div>

    </div>

</div>



<script type="text/javascript"><!--
$(document).ready(function(){
	/********** initialisation for multstore options begin */
	$("#soconfig_colors_theme").ColorPicker({
		color: $('#soconfig_colors_theme').val(),
			onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#soconfig_colors_theme').css('backgroundColor', '#' + hex);
			$('#soconfig_colors_theme').val('#' + hex);
		}
	});
	
	$('.grouplayout .group-typeheader').on('click', '.type', function () {
		$keyheader = $(this).data("keyheader");
		
	   $('.grouplayout .group-typeheader .type').removeClass("active");
	   $(this).addClass("active");
	   
	   $(".groupheader .group-typeheader").each(function() {
			$(this).find(".type").removeClass("active");
			$(this).find("input:radio").prop("checked", false);
			if( $keyheader ==  $(this).find(".type").data("keyheader")) {
				$(this).find(".type").addClass("active");
				$(this).find(".type").prev().prop("checked", true);
			}
		});
	});
	
    $('.groupheader .group-typeheader').on('click', '.type', function () {
	   $('.groupheader .group-typeheader .type').removeClass("active");
	   $(this).addClass("active");
	});
	$('#input-description-customfooter_text').summernote({height: 120});

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

//--></script>

<?php echo $footer; ?>