<?php 
function tabs_itemYTShortcode($atts,$contentP,$module_id,$id,$database){
	global $tab_array;
	if($atts->icon !=''){
		if (strpos($atts->icon, 'icon:') !== false) {
			$atts->icon = "<i class='fa fa-" . trim(str_replace('icon:', '', $atts->icon)) . "'></i> ";	
		}
	}
	$yt_title_ 			= 'yt_title_'.$database['language_id'];
	$content_ 			= 'content_'.$database['language_id'];
	$tab_array[] = array("title" => $atts->$yt_title_,"icon" => $atts->icon , "content" => $atts->$content_);
}
?>