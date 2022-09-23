<?php 
/******************************************************
 * @package	SO Theme Framework for Opencart 2.0.x
 * @author	http://www.magentech.com
 * @license	GNU General Public License
 * @copyright(C) 2008-2015 Magentech.com. All rights reserved.
*******************************************************/
?>


<?php 
global  $storeid;
$storeid = isset($store["store_id"]) ? $store["store_id"] : 0;

if (!function_exists('field_onOff')) {
	function field_onOff($nameconfig,$config,$element) {
		global $storeid ;
		$onClassActive = null;
		$offClassActive = null;
		$onCheck = null;
		$offCheck = null;
		
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : '';
			
		(($values == 1)? $onClassActive ='btn-success active' : $offClassActive='btn-success active');
		(($values == 1)? $onCheck ='checked="checked"' : $offCheck='checked="checked"');
		
		$fieldOnOff  = '<div class="btn-group btn-toggle" data-toggle="buttons">';
		$fieldOnOff .= '<label class="btn btn-default btn-sm '.$onClassActive.'">';
		$fieldOnOff .= '<input type="radio" class="field-'.$element.'" name="'.$names.'" value="1" '.$onCheck.'>ON';
		$fieldOnOff .= '</label>';
		$fieldOnOff .= '<label class="btn btn-default btn-sm '.$offClassActive.'">';
		$fieldOnOff .= '<input type="radio" class="field-'.$element.'" name="'.$names.'" value="0" '.$offCheck.'>OFF';
		$fieldOnOff .= '</label>';
		$fieldOnOff .=	'</div>';
		return $fieldOnOff;
	}
}


if (!function_exists('field_onOffFont')) {
	function field_onOffFont($nameconfig,$config,$element) {
		global $storeid ;
		$onClassActive = null;
		$offClassActive = null;
		$onCheck = null;
		$offCheck = null;
		
		
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : 'standard';
		
		(($values == 'standard')? $onClassActive ='btn-success active' : $offClassActive='btn-success active');
		(($values == 'standard')? $onCheck ='checked="checked"' : $offCheck='checked="checked"');
		
		$fieldOnOff  = '<div class="btn-group btn-toggle block-group " data-toggle="buttons">';
		$fieldOnOff .= '<label class="btn btn-default btn-sm '.$onClassActive.'">';
		$fieldOnOff .= '<input class="type-fonts" type="radio" name="'.$names.'" value="standard" '.$onCheck.'>Standard';
		$fieldOnOff .= '</label>';
		$fieldOnOff .= '<label class="btn btn-default btn-sm '.$offClassActive.'">';
		$fieldOnOff .= '<input class="type-fonts" type="radio" name="'.$names.'" value="google" '.$offCheck.'>Google Fonts';
		$fieldOnOff .= '</label>';
		$fieldOnOff .=	'</div>';
		return $fieldOnOff;
	}
}

if (!function_exists('field_typeheader')) {
	function field_typeheader($nameconfig,$config,$element,$element_array,$columns= null){
		global $storeid ;
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : '';
		$columns = isset($columns) ? 'col-sm-'.round(12/$columns) : 'col-sm-12';
		$fieldType  = '<div class="panel-container row">';
		
		$result = [];
		foreach ($element_array as  $fc){
			if (!array_intersect($fc[$element], $result)) {
				$result = $fc[$element];
				$keylayout = $fc['key'];
				$element_key = $fc[$element]['key'];
				
				$fieldType  .= '<div class="'.$columns.'"><div class="group-typeheader  radio ">';
				$fieldType  .= '<h3 class="typetitle">'.$fc[$element]['title'].'</h3>';
				$fieldType  .= '<label class="col-sm-12">';
				
				if($element_key == $values  ){
					$fieldType  .= '<input type="radio" name="'.$names.'" value="'.$element_key.'" checked  >';
					$fieldType  .= '<span class="type fa active" data-keylayout="'.$keylayout.'" data-'.$element.'="'.$element_key.'"><img src="view/options/'.$element.$element_key.'.jpg" alt="'.$element.$element_key.'"/></span>';
				}else{
					$fieldType  .= '<input type="radio" name="'.$names.'" value="'.$element_key.'" >';
					$fieldType  .= '<span class="type fa" data-keylayout="'.$keylayout.'" data-'.$element.'="'.$element_key.'"><img src="view/options/'.$element.$element_key.'.jpg" alt="'.$element.$element_key.'"/></span>';
				}
				$fieldType  .= '</label>';
				
				$fieldType  .= '</div></div>';
			}
		}
		$fieldType  .= '</div>';
		return $fieldType;
	}
	
}

if (!function_exists('field_typelayout')) {
	function field_typelayout($nameconfig,$config,$element,$element_array,$columns= null){
		global $storeid ;
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : '';
		$columns = isset($columns) ? 'col-sm-'.round(12/$columns) : 'col-sm-15';
		$fieldType  = '<div class="panel-container row">';
		foreach ($element_array as  $fc){
			
			$keylayout = $fc['key'];
			$keyheader = $fc['typeheader']['key'];
			$keyfooter = $fc['typefooter']['key'];
			
			$fieldType  .= '<div class="'.$columns.' text-center"><div class="group-typeheader  radio ">';
			$fieldType  .= '<label class="col-sm-12">';
			if($fc['key'] == $values){
				$fieldType  .= '<input  type="radio" name="'.$names.'" value="'.$fc['key'].'" checked  >';
				$fieldType  .= '<span class="type fa active" data-keylayout="'.$keylayout.'" data-keyheader="'.$keyheader.'" data-keyfooter="'.$keyfooter.'" ><img  src="view/options/'.$element.$fc['key'].'.jpg" alt="'.$element.$fc['key'].'"/></span>';
			}else{
				$fieldType  .= '<input type="radio" name="'.$names.'" value="'.$fc['key'].'" >';
				$fieldType  .= '<span class="type fa" data-keylayout="'.$keylayout.'" data-keyheader="'.$keyheader.'" data-keyfooter="'.$keyfooter.'"><img src="view/options/'.$element.$fc['key'].'.jpg" alt="'.$element.$fc['key'].'"/></span>';
			}
			$fieldType  .= '</label>';
			$fieldType  .= '<h3 class="typetitle">'.$fc['typelayout'].'</h3>';
			$fieldType  .= '</div></div>';
		}
		$fieldType  .= '</div>';
		return $fieldType;
	}
}

if (!function_exists('field_typebanner')) {
	function field_typebanner($nameconfig,$config,$element,$element_array,$columns= null){
		global $storeid ;
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : '';
		
		$columns = isset($columns) ? 'col-sm-'.round(12/$columns) : 'col-sm-12';
		$fieldType  = '<div class="panel-container row">';
		foreach ($element_array as $fv => $fc){
			$fieldType  .= '<div class="banners-effect-'.$fv.' hover_effect_type '.$columns.'"><div class="group-typeheader group-banners  radio">';
			
			$fieldType  .= '<label class="col-sm-12">';
			if($fv == $values){
				$fieldType  .= '<input type="radio" name="'.$names.'" value="'.$fv.'" checked  >';
				$fieldType  .= '<h3 class="typetitle">'.$fc.'</h3>';
				$fieldType  .= '<div class="banners type fa active"><div><a href="javascript:void(0)" ><img src="view/options/banner-01.png" alt=""></a></div></div>';
			}else{
				$fieldType  .= '<input type="radio" name="'.$names.'" value="'.$fv.'" >';
				$fieldType  .= '<h3 class="typetitle">'.$fc.'</h3>';
				$fieldType  .= '<div class="banners type fa"><div><a href="javascript:void(0)"><img src="view/options/banner-01.png" alt=""></a></div></div>';
			}
			$fieldType  .= '</label>';
			
			$fieldType  .= '</div></div>';
		}
		$fieldType  .= '</div>';
		return $fieldType;
	}
}


if (!function_exists('field_text')) {
	function field_text($nameconfig='',$config='',$element='',$placeholder=''){
		global $storeid ;
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : '';
		
		return '<input type="text" name="'.$names.'" value="'.$values.'" placeholder="'.$placeholder.'"  class="form-control" />';
	}
}

if (!function_exists('field_textarea')) {
	function field_textarea($nameconfig,$config,$element,$placeholder){
		global $storeid ;
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : '';
		return '<textarea name="'.$names.'" rows="5" placeholder="'.$placeholder.'" id="input-description-'.$element.'-'.$storeid.'" class="form-control">'.$values.'</textarea>';
	}
}


if (!function_exists('field_select')) {
	function field_select($nameconfig,$config,$element,$element_array,$element_class =''){
		global $storeid ;
		$names	= $nameconfig.'['.$storeid.']['.$element.']';
		$values	= isset($config[$storeid][$element]) ? $config[$storeid][$element] : '';
		
		$fieldSelect  = '<select name="'.$names.'"  class="form-control '.$element_class.'">';
		foreach ($element_array as $fv => $fc){
			($fv == $values) ? $current = 'selected' : $current='';
			$fieldSelect .= '<option value="'.$fv.'" '.$current.' >'.$fc.'</option>	';
		}
		$fieldSelect .= '</select>';
		return $fieldSelect;
	}
}

if (!function_exists('field_langHori')) {
	function field_langHori($languages,$storeid , $nameconfig,$config,$element,$size=null){
		
		$fieldLangHori   = '<div class="tab-horizontal">';
		$fieldLangHori  .= '<ul class="nav nav-tabs main_tabs_horizontal">';
		
		foreach ($languages as $language){
			$active = $language['language_id'] == 1 ? 'active' : ' ';
			$fieldLangHori .= '<li class="'.$active.'">
			<a href="#language-'.$element.$language['language_id'].$storeid.'" data-toggle="tab"><img src="language/'.$language['code'].'/'.$language['code'].'.png" title="'.$language['name'].'" /> '.$language['name'].'</a>
			</li>';
		}
		$fieldLangHori .= '</ul>';
		$fieldLangHori .= '<div class="tab-content">';
		foreach ($languages as $language){
			$active = $language['language_id'] == 1 ? 'active' : ' ';
			$names	= $nameconfig.'['.$storeid.']['.$element.']['.$language['language_id'].']';
			$values	= isset($config[$storeid][$element][$language['language_id']])?$config[$storeid][$element][$language['language_id']]: '';
		
			$fieldLangHori .= '<div class="tab-pane '.$active.'" id="language-'.$element.$language['language_id'].$storeid.'">';
			$fieldLangHori .= '<input type="text" name="'.$names.'" value="'.$values.'"  class="form-control" size="'.$size.'" />';
			$fieldLangHori .= '</div>';
		}
		$fieldLangHori .= '</div>';
		$fieldLangHori .= '</div>';
		
		return $fieldLangHori;
	}
}

if (!function_exists('field_langTextarea')) {
	function field_langTextarea($languages,$storeid , $nameconfig,$config,$element){
		
	
		$fieldLangTextarea  = '<ul class="nav nav-tabs">';
		
		foreach ($languages as $language){
			$active = $language['language_id'] == 1 ? 'active' : ' ';
			$fieldLangTextarea .= '<li class="'.$active.'">
			<a href="#language-'.$element.$language['language_id'].$storeid.'" data-toggle="tab"><img src="language/'.$language['code'].'/'.$language['code'].'.png" title="'.$language['name'].'" /> '.$language['name'].'</a>
			</li>';
		}
		$fieldLangTextarea .= '</ul>';
		$fieldLangTextarea .= '<div class="tab-content">';
		foreach ($languages as $language){
			$active = $language['language_id'] == 1 ? 'active' : ' ';
			$names	= $nameconfig.'['.$storeid.']['.$element.']['.$language['language_id'].']';
			$values	= isset($config[$storeid][$element][$language['language_id']])?$config[$storeid][$element][$language['language_id']]: '';
		
			$fieldLangTextarea .= '<div class="tab-pane '.$active.'" id="language-'.$element.$language['language_id'].$storeid.'">';
			$fieldLangTextarea .='<textarea name="'.$names.'" id="input-description-'.$element.$language['language_id'].'-'.$storeid.'">';
			$fieldLangTextarea .=  $values;
			$fieldLangTextarea .= '</textarea>';
			$fieldLangTextarea .= '</div>';
		}
		$fieldLangTextarea .= '</div>';
		
		
		return $fieldLangTextarea;
	}
}

if (!function_exists('create_position')) {
	function create_position($titlepositon=null,$namepositon=null,$layout_modules=null,$extensions=null,$module_row=0) {
		global $module_row;
		$create_position  = '<table id="module-'.$namepositon.'" class="table table-striped table-bordered table-hover">';
		$create_position .= '<thead><tr><td class="text-center">'.$titlepositon.'</td></tr></thead> <tbody>';
		
		foreach ($layout_modules as $layout_module) { 
			if ($layout_module['position'] == $namepositon) {
				
				$create_position .= '<tr id="module-row'.$module_row.'"><td class="text-left"><div class="input-group">';
				$create_position .= '<select name="layout_module['.$module_row.'][code]" class="form-control input-sm">';
				
				foreach ($extensions as $extension) {
					$create_position .= '<optgroup label="'. $extension['name'].'">';
					if (!$extension['module']) {
						if ($extension['code'] == $layout_module['code']) {
							$create_position .= '<option value="'. $extension['code'] .'" selected="selected">'. $extension['name'].'</option>';
						}else{
							$create_position .= '<option value="'. $extension['code'] .'" >'. $extension['name'].'</option>';
						}
							
					}else{
						foreach ($extension['module'] as $module) { 
							if ($module['code'] == $layout_module['code']) { 
								$create_position .= '<option value="'.$module['code'].'" selected="selected">'.$module['name'].'</option>';
							}else{
								$create_position .= '<option value="'. $module['code'] .'">'. $module['name'].'</option>';
							}
						}
					}
					$create_position .= '</optgroup>';
				}
				
				$create_position .= '</select>';
				$create_position .= '<input type="hidden" name="layout_module['.$module_row.'][position]" value="'. $layout_module['position'].'" />';
				$create_position .= '<div class="input-group-btn">';
					$create_position .= '<input type="text" size="5" class="form-order input-sm" name="layout_module['. $module_row.'][sort_order]" value="'. $layout_module['sort_order'].'" />';
					$create_position .= '<a href="'. $layout_module['edit'] .'" type="button" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
					$create_position .= '<button type="button" onclick=$("#module-row'.$module_row.'").remove(); data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>';
				$create_position .= ' </div>';
				$create_position .= '</div></td></tr>';
				$module_row++;
			}
		}
		
		$create_position .= '</tbody>';
		$create_position .= '<tfoot><tr><td class="text-left"><div class="input-group">';
		$create_position .= ' <select class="form-control input-sm">';
		foreach ($extensions as $extension) {
					$create_position .= '<optgroup label="'.$extension['name'] .'">';
			if (!$extension['module']) { 
					$create_position .= '<option value="'. $extension['code'] .'">'. $extension['name'].'</option>';
			}else{
				foreach ($extension['module'] as $module) { 
					$create_position .= '<option value="'. $module['code'] .'">'. $module['name'].'</option>';
				}
			}
		}
		$create_position .= ' </select>';
		$create_position .= ' <div class="input-group-btn">';
		$create_position .=	'<button type="button" onclick=addModule("'.$namepositon.'") data-toggle="tooltip" title="Add Module" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>';
		$create_position .=	'</div>';
		$create_position .=	'</div></td></tr> </tfoot>';
		$create_position .=	'</table>';
		
		return $create_position;
		
	}	
}


if (!function_exists('create_posmobile')) {
	function create_posmobile($titlepositon=null,$namepositon=null,$layout_modules=null,$extensions=null,$module_row=0) {
		global $module_row;
		$create_position  = '<table id="module-'.$namepositon.'" class="table table-striped table-bordered table-hover">';
		$create_position .= '<thead><tr><td class="text-center">'.$titlepositon.'</td></tr></thead> <tbody>';
		
		foreach ($layout_modules as $layout_module) { 
			if ($layout_module['position'] == $namepositon) {
				
				$create_position .= '<tr id="module-row'.$module_row.'"><td class="text-left"><div class="input-group">';
				$create_position .= '<select name="layout_module['.$module_row.'][code]" class="form-control input-sm">';
				
				foreach ($extensions as $extension) {
					$create_position .= '<optgroup label="'. $extension['name'].'">';
					if (!$extension['module']) {
						if ($extension['code'] == $layout_module['code']) {
							$create_position .= '<option value="'. $extension['code'] .'" selected="selected">'. $extension['name'].'</option>';
						}else{
							$create_position .= '<option value="'. $extension['code'] .'" >'. $extension['name'].'</option>';
						}
							
					}else{
						foreach ($extension['module'] as $module) { 
							if ($module['code'] == $layout_module['code']) { 
								$create_position .= '<option value="'.$module['code'].'" selected="selected">'.$module['name'].'</option>';
							}else{
								$create_position .= '<option value="'. $module['code'] .'">'. $module['name'].'</option>';
							}
						}
					}
					$create_position .= '</optgroup>';
				}
				
				$create_position .= '</select>';
				$create_position .= '<input type="hidden" name="layout_module['.$module_row.'][position]" value="'. $layout_module['position'].'" />';
				$create_position .= '<div class="input-group-btn"><h5 style="margin: 0 15px;">Layout Mobile</h5></div>';
				$create_position .= '<div class="input-group-btn">';
					$create_position .= '<input type="text" size="5" class="form-order input-sm" name="layout_module['. $module_row.'][sort_order]" value="'. $layout_module['sort_order'].'" />';
					$create_position .= '<a href="'. $layout_module['edit'] .'" type="button" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
					$create_position .= '<button type="button" onclick=$("#module-row'.$module_row.'").remove(); data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>';
				$create_position .= ' </div>';
				$create_position .= '</div></td></tr>';
				$module_row++;
			}
		}
		
		$create_position .= '</tbody>';
		$create_position .= '<tfoot><tr><td class="text-left"><div class="input-group">';
		$create_position .= ' <select class="form-control input-sm">';
		foreach ($extensions as $extension) {
					$create_position .= '<optgroup label="'.$extension['name'] .'">';
			if (!$extension['module']) { 
					$create_position .= '<option value="'. $extension['code'] .'">'. $extension['name'].'</option>';
			}else{
				foreach ($extension['module'] as $module) { 
					$create_position .= '<option value="'. $module['code'] .'">'. $module['name'].'</option>';
				}
			}
		}
		$create_position .= ' </select>';
		$create_position .= ' <div class="input-group-btn">';
		$create_position .=	'<button type="button" onclick=addModule("'.$namepositon.'") data-toggle="tooltip" title="Add Module" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>';
		$create_position .=	'</div>';
		$create_position .=	'</div></td></tr> </tfoot>';
		$create_position .=	'</table>';
		
		return $create_position;
		
	}	
}
?>