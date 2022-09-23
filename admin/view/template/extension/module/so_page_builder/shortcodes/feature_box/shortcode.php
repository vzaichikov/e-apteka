<?php 
function feature_boxYTShortcode($atts,$contentC,$module_id,$id,$database) {
	$radius ='';
	$css = '';
	$return = '';
	/* $module_id != 0 => call shortcode in Admin */
	if($module_id != "0" && $atts->css_internal !=''){
		$css .= "/* Style Feature Box */ \n";
		$css .= $atts->css_internal;
		$css .= '#'.$id.'.yt-feature-box{text-align:'.$atts->align.'}';
		// Radius Manage
		if ($atts->radius) {
			$radius = ( $atts->radius != '0' ) ? 'border-radius:' . $atts->radius . 'px;' : '';
		}
		// style
		switch ($atts->style){
			case 'style1':
				$style = '#'.$id.' .yt-feature-box-icon span{background:'.$atts->box_color.'; '.$radius.'px;display: inline-block;margin-bottom: 10px; padding: '.$atts->padding.'px;text-align: center;} #'.$id.' .yt-feature-box-icon i{font-size:'.$atts->icon_size.'px; color:'.$atts->icon_color.';width:'.$atts->icon_size.'px; height:'.$atts->icon_size.'px; line-height:'.$atts->icon_size.'px;}';
			break;
			case 'style2':
				$style = '#'.$id.' .yt-feature-box-icon span{border:'.$atts->box_color.' 1px solid; '.$radius.'px;display: inline-block;margin-bottom: 10px; padding: '.$atts->padding.'px;text-align: center; background:transparent;} #'.$id.' .yt-feature-box-icon i{font-size:'.$atts->icon_size.'px; color:'.$atts->icon_color.';width:'.$atts->icon_size.'px; height:'.$atts->icon_size.'px; line-height:'.$atts->icon_size.'px;}';
			break;
		}
		$style .= '#'.$id.' .yt-feature-box-title h3{font-size:20px;line-height:20px;color:'.$atts->title_color.'}';
		
		// Get Css in $css variable
		$css .= $style;
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
		if($atts->icon !='')
		{
			if (strpos($atts->icon, 'icon:') !== false) 
			{
				$atts_icon = "<i class='fa fa-" . trim(str_replace('icon:', '', $atts->icon)) . "'></i> ";
			}else
			{
				$atts_icon = '<img src="'.yt_image_media($atts->icon).'" style="width:'.$atts->icon_size.'px" alt="" /> ';
			}
		}
		$return .= '<div id="'.$id.'" class="yt-clearfix yt-feature-box yt-feature-box-style-' . $atts->style .' '.$atts->yt_class.' text-'.$atts->align.'">
				<div class="yt-feature-box-icon"><span>'.$atts_icon.'</span></div>
				<div class="yt-feature-box-title"><h3>'. $atts->$yt_title_ . '</h3></div>
				<div class="yt-feature-box-content yt-clearfix">'.$atts->$content_.'</div>
			</div>';
	}
	return $return;
}
?>