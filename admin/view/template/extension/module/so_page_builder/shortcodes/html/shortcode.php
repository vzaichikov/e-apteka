<?php 
function htmlYTShortcode($atts,$contentC,$module_id,$id,$database) {
	$return  = "";
	$css	 = "";
	if($module_id != "0" && $atts->css_internal != ''){
		$css .= "/* Style Html */ \n";
		$css .= $atts->css_internal;
		$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= $css."\n";
		// Write the contents back to the file
		file_put_contents($file, $current);
	}else{
		$name_shortcode_	= 'name_shortcode_'.$database['language_id'];
		$content_ 			= 'content_'.$database['language_id'];
		if($atts->name_shortcode_status == "yes"){
			$return .= '<h3 class="shortcodeTitle">'.$atts->$name_shortcode_.'</h3>';
		}
		$text_content = isset($atts->$content_) ? $atts->$content_ : '';
		if($atts->yt_class != ""){
			$return .= '<div class="'.$atts->yt_class.'">';
			$return .= $text_content;
			$return .= '</div>';
		}else{
			$return .= $text_content;
		}
	}
	return $return;
}
?>