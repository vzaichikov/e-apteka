<?php

if( ! function_exists( 'mf_render_btn_group' ) ) {
	
	function mf_render_btn( array $options, $name, $value ) {
		$html = '<div class="btn-group" data-toggle="fm-buttons">';
		
		if( $value === false ) {
			$value = '0';
		} else if( $value === true ) {
			$value = '1';
		}
		
		foreach( $options as $key => $val ) {
			if( ! is_array( $val ) ) {
				$val = array( 'name' => $val );
			}
			
			$html .= '<label class="btn btn-primary btn-xs' . ( (string) $value == (string) $key ? ' active' : '' ) . '"' . ( isset( $val['tooltip'] ) ? ' data-toggle="tooltip" title="' . $val['tooltip'] . '"' : '' ) . '>';
			$html .= '<input type="radio" name="' . $name . '"' . ( (string) $value == (string) $key ? ' checked="checked"' : '' ) . ' value="' . $key . '">' . $val['name'];
			$html .= '</label>';
		}
		
		$html .= '</div>';
		
		return $html;
	}
	
	function mf_render_btn_group( $text_yes, $text_no, $name, $enabled ) {
		return mf_render_btn(array(
			'1' => array( 'name' => '<i class="fa fa-check"></i>', 'tooltip' => $text_yes ),
			'0' => array( 'name' => '<i class="fa fa-remove"></i>', 'tooltip' => $text_no )
		), $name, $enabled ? '1' : '0');
	}
	
	function mf_render_btn_collapsed( $text_yes, $text_no, $text_pc, $text_mobile, $name, $value ) {
		return mf_render_btn(array(
			'1' => array( 'name' => '<i class="fa fa-check"></i>', 'tooltip' => $text_yes ),
			'0' => array( 'name' => '<i class="fa fa-remove"></i>', 'tooltip' => $text_no ),
			'pc' => array( 'name' => '<i class="fa fa-desktop"></i>', 'tooltip' => $text_pc ),
			'mobile' => array( 'name' => '<i class="fa fa-phone"></i>', 'tooltip' => $text_mobile )
		), $name, $value);
	}
	
	function mf_render_element( $type, $attr ) {
		$html = '<tr>';
		
		if( isset( $attr['name'] ) ) {
			$html .= '<td class="vertical-middle">';
			
			$html .= $attr['name'];
			
			if( isset( $attr['group_name'] ) ) {
				$html .= '<br />';
				$html .= '[' . $attr['group_name'] . ']';
			}
		
			if( $attr['mf_id'] != 'default' && strpos( $attr['_name'], '[default_group]' ) === false ) {
				$html .= '<br /><br />';
				$html .= '<center>';
				$html .= '<button type="button" class="btn btn-xs btn-info" data-mf-id="' . $attr['mf_id'] . '" data-mf-action="set-tooltip" data-mf-idx="' . $attr['IDX'] . '" data-mf-type="' . $type . '">' . $attr['lang']['text_set_tooltip'] . '</button>';
				$html .= '</center>';
			}
		
			$html .= '</td>';
		}
		
		////////////////////////////////////////////////////////////////////////
		
		$html .= '<td class="vertical-middle text-center">';
		$html .= mf_render_btn_group( $attr['lang']['text_yes'], $attr['lang']['text_no'], $attr['_name'] . '[enabled]', ! empty( $attr['_values']['enabled'] ) );
		$html .= '</td>';
		
		////////////////////////////////////////////////////////////////////////
		
		if( isset( $attr['type'] ) ) {
			$html .= '<td class="vertical-middle text-center">';
			$html .= $attr['type'];
			$html .= '</td>';
		}
		
		////////////////////////////////////////////////////////////////////////
		
		$html .= '<td>';
		
		$tmpTypes = array( 'checkbox', 'radio', 'select', 'image', 'image_radio', 'image_list_radio', 'image_list_checkbox', 'slider' );
		
		if( $type == 'attribs' ) {
			$tmpTypes[] = 'text';
		}
		
		$html .= '<select class="form-control" name="' . $attr['_name'] . '[type]">';
		
		$idxx = 0; 
		
		foreach( $tmpTypes as $tmpType ) {
			$html .= '<option value="' . $tmpType . '"';
			
			if( ( empty( $attr['_values'] ) && ! $idxx ) || ( ! empty( $attr['_values']['type'] ) && $attr['_values']['type'] == $tmpType ) ) {
				$html .= ' selected="selected"';
			}
			
			$html .= '>';
			$html .= $attr['lang']['text_type_' . $tmpType];
			$html .= '</option>';
			
			$idxx++;
		}
		
		$html .= '</select>';
		$html .= '<br />';
		
		$html .= '<select class="form-control" name="' . $attr['_name'] . '[display_live_filter]">';
		$html .= '<option value="";';
		
		if( empty( $attr['_values']['display_live_filter'] ) ) {
			$html .= ' selected="selected"';
		}
		
		$html .= '>' . $attr['lang']['text_display_live_filter'] . ' ' . $attr['lang']['text_by_default'] . '</option>';
		$html .= '<option value="1"';
		
		if( ! empty( $attr['_values']['display_live_filter'] ) && $attr['_values']['display_live_filter'] == '1' ) {
			$html .= ' selected="selected"';
		}
		
		$html .= '>' . $attr['lang']['text_display_live_filter'] . ' - ' . $attr['lang']['text_yes'] . '</option>';
		$html .= '<option value="-1"';
		
		if( ! empty( $attr['_values']['display_live_filter'] ) && $attr['_values']['display_live_filter'] == '-1' ) {
			$html .= ' selected="selected"';
		}
		
		$html .= '>' . $attr['lang']['text_display_live_filter'] . ' - ' . $attr['lang']['text_no'] . '</option>';
		$html .= '</select>';
		$html .= '</td>';
		
		////////////////////////////////////////////////////////////////////////
		
		$html .= '<td class="text-center">';
		$html .= mf_render_btn_collapsed( $attr['lang']['text_yes'], $attr['lang']['text_no'], $attr['lang']['text_pc'], $attr['lang']['text_mobile'], $attr['_name'] . '[collapsed]', empty( $attr['_values']['collapsed'] ) ? '0' : $attr['_values']['collapsed'] );
		$html .= '</td>';
		
		////////////////////////////////////////////////////////////////////////
		
		$html .= '<td class="text-center">';
		$html .= '<select class="form-control" name="' . $attr['_name'] . '[display_list_of_items]">';
		$html .= '<option value=""';
		
		if( empty( $attr['_values']['display_list_of_items'] ) ) {
			$html .= ' selected="selected"';
		}
		
		$html .= '>' . $attr['lang']['text_by_default'] . '</option>';
		$html .= '<option value="scroll"';
		
		if( ! empty( $attr['_values']['display_list_of_items'] ) && $attr['_values']['display_list_of_items'] == 'scroll' ) {
			$html .= ' selected="selected"';
		}
		
		$html .= '>' . $attr['lang']['text_with_scroll'] . '</option>';
		$html .= '<option value="button_more"';
		
		if( ! empty( $attr['_values']['display_list_of_items'] ) && $attr['_values']['display_list_of_items'] == 'button_more' ) {
			$html .= ' selected="selected"';
		}
		
		$html .= '>' . $attr['lang']['text_with_button_more'] . '</option>';
		$html .= '</select>';
		$html .= '</td>';
		
		////////////////////////////////////////////////////////////////////////
		
		$html .= '<td class="text-center">';
		$html .= '<select class="form-control" name="' . $attr['_name'] . '[sort_order_values]">';
		$html .= '<option value=""';
		
		if( empty( $attr['_values']['sort_order_values'] ) ) {
			$html .= ' selected="selected"';
		}
		
		$html .= '>' . $attr['lang']['text_by_default'] . '</option>';

		
		$sortOrderValues = array(
			'string_asc'	=> $attr['lang']['text_string_asc'],
			'string_desc'	=> $attr['lang']['text_string_desc'],
			'numeric_asc'	=> $attr['lang']['text_numeric_asc'],
			'numeric_desc'	=> $attr['lang']['text_numeric_desc']
		);
		
		foreach( $sortOrderValues as $k => $v ) {
			$html .= '<option value="' . $k . '"';

			if( ! empty( $attr['_values']['sort_order_values'] ) && $attr['_values']['sort_order_values'] == $k ) {
				$html .= ' selected="selected"';
			}
			
			$html .= '>' . $v . '</option>';
		}
		
		$html .= '</select>';
		$html .= '</td>';
		
		////////////////////////////////////////////////////////////////////////
		
		if( $attr['mf_id'] != 'default' ) {
			$html .= '<td class="text-center">';
			$html .= '<input class="form-control" type="text" name="' . $attr['_name'] . '[sort_order]" value="';

			if( isset( $attr['_values']['sort_order'] ) ) {
				$html .= $attr['_values']['sort_order'];
			}

			$html .= '" size="3" />';
			$html .= '</td>';
		}
		
		////////////////////////////////////////////////////////////////////////
		
		if( $attr['mf_id'] != 'default' ) {
			$html .= '<td class="text-center">';
			$html .= '<a href="#" data-mf-action="remove-' . $type . '" data-mf-type="' . $type . '" data-mf-id="' . $attr['mf_id'] . '" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>';
			$html .= '</td>';
		}
			
		$html .= '</tr>';
		
		return $html;
	}
	
}