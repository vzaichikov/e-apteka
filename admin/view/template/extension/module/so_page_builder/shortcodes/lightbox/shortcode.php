<?php 
function lightboxYTShortcode($atts,$contentC,$module_id,$id,$database){
	$return = '';
	/* $module_id != 0 => call shortcode in Admin */
	if($module_id != "0"){
		$css  = "";
		$css .= "/* Style LightBox */ \n";
		$css .= $atts->css_internal;
		// Get Css in $css variable
		$css .= '#yt-lightbox'.$id.'{width:'.$atts->width.'; height:'.$atts->height.';}';
		$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= $css."\n";
		// Write the contents back to the file
		file_put_contents($file, $current);
	}else{
		if(strpos($atts->video_addr, 'youtube.com')){
			$src_pop = $atts->video_addr;
			if($atts->src == "no_image.png") $simage = 'so_page_builder/images/youtube.png';
		}elseif(strpos($atts->video_addr, 'vimeo.com')){
			$src_pop = $atts->video_addr;
			if($atts->src == "no_image.png") $simage = 'so_page_builder/images/vimeo.jpg';
		}else{
			$src_pop = $database['url'].yt_image_media($atts->src);
			if($atts->src == "no_image.png") $simage = 'so_page_builder/images/url_image.png';
		}
		if($atts->src !="no_image.png" ) $simage = $atts->src;
		$frame ='';
		$tag_id = 'inline_demo'. rand(). time();
		$name_shortcode_	= 'name_shortcode_'.$database['language_id'];
		$yt_title_ 			= 'yt_title_'.$database['language_id'];
		$description_ 		= 'description_'.$database['language_id'];
		if($atts->type=="inline")
			{
				$frame .='<a href="#inline_demo'.$tag_id.'" data-rel="prettyPhoto">'.$atts->$yt_title_.'</a>';
				$frame .='<div id="inline_demo'.$tag_id.'" style="display:none;">';
				$frame .='<p>'.$atts->$description_.'</p>';
				$frame .='</div>';
			}
			else
			{
				$frame = "<img src='".$database['url'].yt_image_media($simage)."' alt='" . $atts->$yt_title_ . "' />";
				$titles = ($atts->$yt_title_ != '') ? "<h3 class='img-title'>". $atts->$yt_title_ ."</h3>" : '';
				$borderinner  = ($atts->style == "borderInner") ? "<div class='transparent-border'> </div>" : " " ;
				$image = "<span class='lightbox-hover'></span>";
				if(strtolower($atts->lightbox) == 'yes') {
					$frame = "<a href='". $src_pop . "' data-rel='prettyPhoto' title='" . $atts->$yt_title_ . "' >" .$image . $frame . $titles. $borderinner. "</a>";
			}
		}
		if($atts->name_shortcode_status == "yes")
		{
			$return .= '<h3 class="shortcodeTitle">'.$atts->$name_shortcode_.'</h3>';
		}
		$return .="<div id='yt-lightbox".$id."' class='yt-clearfix yt-lightbox curved  image-". $atts->align." ".$atts->style." ".$atts->yt_class."'>" . $frame . "</div>";
	}
	return $return;
	
	
}
?>