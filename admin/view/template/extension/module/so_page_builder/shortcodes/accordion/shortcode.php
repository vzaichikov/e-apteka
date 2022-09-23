<?php
function accordionYTShortcode($atts,$contentC,$module_id,$id,$database){
	global $accordion_style, $accordion_color_background_active, $accordion_color_active, $accordion_background_active;
	$accordion_style = $atts->style;
	$accordion_color_background_active = $atts->color_background_active;
	$accordion_color_active = $atts->color_active;
	$accordion_background_active = $atts->background_active;
	$css ='';
	
	$accordion = "";
	$name_shortcode_	= 'name_shortcode_'.$database['language_id'];
	if($atts->name_shortcode_status == "yes"){
		$accordion .= '<h3 class="shortcodeTitle">'.$atts->$name_shortcode_.'</h3>';
	}
	$accordion .= "<ul class='yt-clearfix yt-accordion ".$id." ".trim($atts->style)." ".$atts->yt_class."'>";
	if(!empty($contentC))
	{
		add_ytshortcode("accordion_item");
		$atts->dem = 1;
		foreach($contentC as $child => $value)
		{
			$accordion .= accordion_itemYTShortcode($value,$atts,$module_id,$id,$database);
			$atts->dem += 1;
		}
	}
	$accordion .= "</ul>";
	if($module_id != "0" && $atts->css_internal != ''){
		$css .= "/* Style Accordion */ \n";
		$css .= '#'.$id.'.yt-accordion{width:'.$atts->width.'%}';
		$css .= $atts->css_internal;
		$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= $css."\n";
		// Write the contents back to the file
		file_put_contents($file, $current);
	}
	return $accordion;
}	
?>