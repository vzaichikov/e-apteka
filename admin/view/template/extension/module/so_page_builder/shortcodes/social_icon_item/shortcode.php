<?php 
function social_icon_itemYTShortcode($atts,$contentP,$module_id,$id,$database){
	$social_color=(($atts->color == "yes")? 'color' : "");
	$social_item = "";
	$yt_title_	= 'yt_title_'.$database['language_id'];
	$social_item .= '<a data-placement="top" target="_blank" class="sb '.$atts->type." ". $atts->size."  ".$atts->style." ".$social_color.' " title="' . $atts->$yt_title_ . '" href="' . trim($atts->link) . '">';
	$social_item .= '<i class="fa fa-'.$atts->type.'"></i></a>';
	
	return $social_item;
}
?>