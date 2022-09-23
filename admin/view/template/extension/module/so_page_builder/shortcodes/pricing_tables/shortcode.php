<?php 
function pricing_tablesYTShortcode($atts,$contentC,$module_id,$id,$database){
	global $pcolumns,$type;
	$return = "";
	$css    = '';
	if($module_id != "0" && $atts->css_internal != ''){
		$css .= "/* Style Pricing Tables */ \n";
		$css .= $atts->css_internal;
		$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= $css."\n";
		// Write the contents back to the file
		file_put_contents($file, $current);
	}else{
		$type = $atts->type;
		$pcolumns	= $atts->columns;
		$class 		= 'yt-pricing block row col-' . $atts->columns.' pricing-'.$atts->type;
		$name_shortcode_	= 'name_shortcode_'.$database['language_id'];
		if($atts->name_shortcode_status == "yes")
		{
			$return .= '<h3 class="shortcodeTitle">'.$atts->$name_shortcode_.'</h3>';
		}
		$return .= '<div class="'.$class.' '.$atts->yt_class.'">';
		if(!empty($contentC)){
			add_ytshortcode("pricing_tables_item");
			$atts->dem = 1;
			foreach($contentC as $child => $value){
				$return .= pricing_tables_itemYTShortcode($value,$atts,$module_id,$id,$database);
				$atts->dem += 1;
			}
		}
		$return .= '</div>';
	}
	return $return;
}
?>