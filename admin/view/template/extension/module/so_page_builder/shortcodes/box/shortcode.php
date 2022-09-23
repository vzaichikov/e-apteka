<?php 
function boxYTShortcode($atts,$contentC,$module_id,$id,$database) {
	$radius ='';
	$css = '';
	$return = '';
	/* $module_id != 0 => call shortcode in Admin */
	if($module_id != "0"){
		// Radius Manage
		if ($atts->radius) {
			$radius = ( $atts->radius != '0' ) ? 'border-radius:' . $atts->radius . 'px;' : '';
		}
		$css .= "/* Style Box */ \n";
		$css .= $atts->css_internal;
		// Get Css in $css variable
		$css .= '#'.$id.'{'.$radius.'border-color:' . $atts->box_color . ';} #'.$id.' .yt-box-title { background-color:' . $atts->box_color . ';color:' . $atts->title_color . ';}';
		$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= $css."\n";
		// Write the contents back to the file
		file_put_contents($file, $current);
	}else{
		// Output HTML
		$name_shortcode_	= 'name_shortcode_'.$database['language_id'];
		$yt_title_ 			= 'yt_title_'.$database['language_id'];
		$content_ 			= 'content_'.$database['language_id'];
		
		if($atts->name_shortcode_status == "yes"){
			$return .= '<h3 class="shortcodeTitle">'.$atts->$name_shortcode_.'</h3>';
		}
		$return .= '<div id="'.$id.'" class="yt-clearfix yt-box yt-box-style-' . $atts->style .' '.$atts->yt_class.'">
				<div class="yt-box-title">'. $atts->$yt_title_ . '
				</div>
				<div class="yt-box-content yt-clearfix">'.$atts->$content_.'</div>
			</div>';
	}
	return $return;
}
?>