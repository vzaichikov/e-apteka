<?php
function testimonialYTShortcode($atts,$contentC,$module_id,$id,$database){
    global $border_testimonial,$background_,$display_avatar;
    $testimonial ='';
	$css    = '';
	if($module_id != "0" && $atts->css_internal != ''){
		$css .= "/* Style Testimonial */ \n";
		$css .= $atts->css_internal;
		$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= $css."\n";
		// Write the contents back to the file
		file_put_contents($file, $current);
	}else{
		$border_testimonial = $atts->border;
		$background_ = $atts->background;
		$background_image = ($atts->background != 'no_image.png' ? 'background:url('.yt_image_media($atts->background).');' : '');
		$src_thumb='';
		$css_add ='';
		$tag_id = rand().time();
		$name_shortcode_	= 'name_shortcode_'.$database['language_id'];
		$yt_title_ 			= 'yt_title_'.$database['language_id'];
		$atts_array = (array) $atts;
		if($atts->name_shortcode_status == "yes")
		{
			$testimonial .= '<h3 class="shortcodeTitle">'.$atts->$name_shortcode_.'</h3>';
		}
		$display_avatar = $atts->display_avatar;
		$testimonial .= '<div class="moduletable yt-clearfix '.(($atts->display_avatar == 'true') ? "background" : "").' column-'.$atts->items_column0.' '.$atts->yt_class.'"  style="'.$background_image.'padding-top:10px;color:'.$atts->title_color.';">
		<h3 style=" text-align:center">';
		if(array_key_exists($yt_title_, $atts_array) ) $atts->$yt_title_;

		$testimonial .='</h3>
			<div id="'.$tag_id.'"
				 class="yt-testimonial button-type2">
				<div class="extraslider-inner" data-effect="fadeIn">';
				if(!empty($contentC))
				{
					add_ytshortcode("testimonial_item");
					$atts->dem = 1;
					foreach($contentC as $child => $value)
					{
						$testimonial .= testimonial_itemYTShortcode($value,$atts,$module_id,$id,$database);
						$atts->dem += 1;
					}
				}	
		
		$testimonial .='	</div>
			</div>
			<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready(function ($) {
					;(function (element) {
						var $element = $(element),
								$extraslider = $(".extraslider-inner", $element),
								_delay = 800,
								_duration = 500,
								_effect = "fadeIn";

						$extraslider.on("initialized.owl.carousel", function () {
							var $item_active = $(".owl-item.active", $element);
							if ($item_active.length > 1 && _effect != "none") {
								_getAnimate($item_active);
							}
							else {
								var $item = $(".owl-item", $element);
								$item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
							}
							$(".owl-nav", $element).insertBefore($extraslider);
							$(".owl-controls", $element).insertAfter($extraslider);
							
						});

						$extraslider.owlCarousel2({
						margin: 5,
						slideBy: 1,
						autoplay: false,
						autoplayHoverPause: true,
						autoplayTimeout: 5000,
						autoplaySpeed: 2000,
						startPosition: 0,
						mouseDrag: true,
						touchDrag: true,
						autoWidth: false,
						responsive: {
							0: 	{ items: '.$atts->items_column4.' } ,
							480: { items: '.$atts->items_column3.' },
							768: { items: '.$atts->items_column2.' },
							992: { items: '.$atts->items_column1.' },
							1200: {items: '.$atts->items_column0.'}
						},
							dotClass: "owl2-dot",
							dotsClass: "owl2-dots",
							dots: false,
							dotsSpeed:5000,
							nav: true,
							loop: false,
							navSpeed: 2000,
							navText: ["", ""],
							navClass: ["owl2-prev", "owl2-next"]

						});
						function _getAnimate($el) {
							if (_effect == "none") return;
							//if ($.browser.msie && parseInt($.browser.version, 10) <= 9) return;
							$extraslider.removeClass("extra-animate");
							$el.each(function (i) {
								var $_el = $(this);
								$(this).css({
									"-webkit-animation": _effect + " " + _duration + "ms ease both",
									"-moz-animation": _effect + " " + _duration + "ms ease both",
									"-o-animation": _effect + " " + _duration + "ms ease both",
									"animation": _effect + " " + _duration + "ms ease both",
									"-webkit-animation-delay": +i * _delay + "ms",
									"-moz-animation-delay": +i * _delay + "ms",
									"-o-animation-delay": +i * _delay + "ms",
									"animation-delay": +i * _delay + "ms",
									"opacity": 1
								}).animate({
									opacity: 1
								});

								if (i == $el.size() - 1) {
									$extraslider.addClass("extra-animate");
								}
							});
						}

						function _UngetAnimate($el) {
							$el.each(function (i) {
								$(this).css({
									"animation": "",
									"-webkit-animation": "",
									"-moz-animation": "",
									"-o-animation": "",
									"opacity": 0
								});
							});
						}

					})("#'.$tag_id.'");
				});
			</script>
		</div>';
	}
    return $testimonial;
}
?>
