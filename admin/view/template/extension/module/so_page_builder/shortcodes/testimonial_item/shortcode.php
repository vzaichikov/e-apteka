<?php 
function testimonial_itemYTShortcode($atts,$contentP,$module_id,$id,$database){
	global $border_testimonial,$column_testimonial,$background_,$display_avatar;
    $css='';
	$testimonial_item ='';
	$testimonial_avatar = '';
	$author_ 			= 'author_'.$database['language_id'];
	$position_ 			= 'position_'.$database['language_id'];
	$content_ 			= 'content_'.$database['language_id'];
	$atts->avatar 		= ($atts->avatar != '' ? $atts->avatar : 'no_image.png');
	$testimonial_avatar .='<img class="img-responsive" src="' . $database['url'] . yt_image_media($atts->avatar) . '" alt="'.$atts->$author_.'" width="150" height="150" style="border-radius:50%; width:auto; margin:0 auto; max-width:100%;"/> ';
	$testimonial_item = '<div class="item" style="border:'.$border_testimonial.'; '.(($background_!= '') ? "background:rgba(255,255,255,0.8)" : "").' ">
							<div class="item-wrap">
								<div class="item-wrap-inner">';
								if($display_avatar == 'yes'){
	$testimonial_item .= '			<div class="item-img-info">
										'.$testimonial_avatar.'
									</div>';
								}
	$testimonial_item .= '			<div class="item-info">
										'.$atts->$content_.'
										<h5>'.$atts->$author_.'</h5>
										<span class="position">'.$atts->$position_.'</span>
									</div>
								</div>
							</div>
						</div>';
	return $testimonial_item;
}
?>
