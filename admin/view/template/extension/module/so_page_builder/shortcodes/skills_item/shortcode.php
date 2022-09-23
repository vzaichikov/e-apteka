<?php 
function skills_itemYTShortcode($atts,$contentP,$module_id,$id,$database){
	global $no_number;
	$yt_title_ 	 = 'yt_title_'.$database['language_id'];
	$skill_item  =  "<div class='form-group'>";
	$skill_item .=  "<strong>".$atts->$yt_title_."</strong>";
	$atts->number = (is_int((int)$atts->number) && (int)$atts->number > 0 ? $atts->number : 100);
	$skill_item .=   ($no_number != 'no') ? "<span class='pull-right'>".$atts->number."%</span>" : '' ;
	$skill_item .=   "<div class='progress progress-danger active'> <div style='width:". $atts->number ."%' class='bar'></div> </div>";
	$skill_item .=  "</div>";

	return $skill_item;
}
?>