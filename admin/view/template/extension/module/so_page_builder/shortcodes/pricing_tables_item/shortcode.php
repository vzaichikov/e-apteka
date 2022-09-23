<?php 
function pricing_tables_itemYTShortcode($atts,$contentP,$module_id,$id,$database){
	global $pcolumns,$type;
	$return='';
	$yt_title_ 			= 'yt_title_'.$database['language_id'];
	$content_ 			= 'content_'.$database['language_id'];
	$button_label_ 		= 'button_label_'.$database['language_id'];
	$yt_text_ 			= 'yt_text_'.$database['language_id'];
	if($atts->icon_name != '')
	{
		if (strpos($atts->icon_name, 'icon:') !== false) 
		{ 
		  $atts->icon_name = '<i class="fa fa-' . trim(str_replace('icon:', '', $atts->icon_name)) . '"></i>';
		}
	}
	switch ($type) {
		case 'style1':
			$text= (strtolower($atts->featured)=="yes" ? $atts->$yt_text_ : '');
			$return = '<div class="col-xs-12 col-sm-6 col-md-'.round(12/$pcolumns).' col-lg-'.round(12/$pcolumns).'">
				<div class="'.$type.' column '.(('yes' == strtolower($atts->featured)) ? ' featured' : '') .'">
				<span class="pricing-featured">'.$text.'</span>
				<div class="pricing-basic " style=""><h2>' . $atts->$yt_title_ . '</h2></div>' .
				'<div class="pricing-money block " style="" >' . $atts->price . '</div>' .$atts->$content_ .
				'<div class="pricing-bottom">
		<div class="signup"><a href="'.$atts->button_link.'">'.$atts->$button_label_.'<div class="iconsignup">'.$atts->icon_name.'</div></a></div>

	</div> ' .
			 '</div></div>';
			break;

		default:
		case 'style2':
			$return = '<div class="col-xs-12 col-sm-6 col-md-'.round(12/$pcolumns).' col-lg-'.round(12/$pcolumns).'">
				<div class="'.$type.' column '.((strtolower($atts->featured) == 'yes') ? ' featured' : '') .'">
				<div class="pricing-basic " style="background:'.$atts->background.'; color:'.$atts->color.'"><h2>' . $atts->$yt_title_ . '</h2><span class="pricing-featured">'.$atts->$yt_text_.'</span></div>' .$atts->$content_ .
				'<div class="pricing-money block ">' . $atts->price . '</div>' .
				'<div class="pricing-bottom" >
		<a class="signup" style="background:'.$atts->background.';color:'.$atts->color.'" href="'.$atts->button_link.'">'.$atts->$button_label_.'</a>
			</div> ' .
			 '</div></div>';
			break;
		case 'style3':
			$text= (strtolower($atts->featured)=="yes" ? $atts->$yt_text_ : '');
			$return = '<div class="col-xs-12 col-sm-6 col-md-'.round(12/$pcolumns).' col-lg-'.round(12/$pcolumns).'">
				<div class="'.$type.' column '.((strtolower($atts->featured) == 'yes') ? ' featured' : '') .'">
				<div class="pricing-basic " style="background:#e74847; color:'.$atts->color.'"><h2>' . $atts->$yt_title_ . '</h2>';
			if($text != ''){
				$return .= '<span class="pricing-featured">'.$text.'</span>';
			}
			$return .='</div>';
			if($atts->price != ''){
				$return .='<div class="pricing-money block "><h1>' . $atts->price . '</h1></div>';
			}
			$return .= $atts->$content_.'<div class="pricing-bottom" >
		<a class="signup" style="background:#e74847;color:'.$atts->color.'" href="'.$atts->button_link.'">'.$atts->$button_label_.'</a>
			</div> ' .
			 '</div></div>';

	}
	
	return $return;
}
?>