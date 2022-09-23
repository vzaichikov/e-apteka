<?php

	require_once DIR_TEMPLATE . 'module/mega_filter-fn.tpl';
	
?>

<ul class="nav nav-tabs attributes">
	<?php if( ! empty( $_configurationMain ) ) { ?>
		<li class="active"><a data-toggle="tab" href="#tab-base-attributes"><i class="glyphicon glyphicon-wrench"></i> <?php echo $tab_base_attributes; ?></a></li>
	<?php } ?>
	<li<?php echo empty( $_configurationMain ) ? ' class="active"' : ''; ?>><a data-toggle="tab" href="#tab-refresh-results"><i class="glyphicon glyphicon-repeat"></i> <?php echo $tab_refresh_results; ?></a></li>
	<li><a data-toggle="tab" href="#tab-display-list-of-items"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $tab_display_list_of_items; ?></a></li>
	<li><a data-toggle="tab" href="#tab-style"><i class="glyphicon glyphicon-adjust"></i> <?php echo $tab_style; ?></a></li>
	<li><a data-toggle="tab" href="#tab-javascript"><i class="glyphicon glyphicon-edit"></i> <?php echo $tab_javascript; ?></a></li>
	<li><a data-toggle="tab" href="#tab-other"><i class="glyphicon glyphicon-pencil"></i> <?php echo $tab_other; ?></a></li>
</ul>

<div class="tab-content">
	<?php if( ! empty( $_configurationMain ) ) { ?>
		<div class="tab-pane active" id="tab-base-attributes">
			<br /><?php echo $entry_default_values; ?><br /><br />
			<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/default-values-base-attributes.png" /><br /><br />
			<?php 

				$_baseName		= $_name . '_settings[attribs]';
				$_baseValues	= $_configurationValues['attribs'];

				require DIR_TEMPLATE . 'module/' . $_name . '-base-attribs.tpl';

			?>
		</div>
	<?php } ?>
	<div class="tab-pane<?php echo empty( $_configurationMain ) ? ' active' : ''; ?>" id="tab-refresh-results">
		<table class="table table-tbody">
			<tbody>
				<tr>
					<td width="200"><?php echo $entry_show_loader_over_results; ?></td>
					<td>
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[show_loader_over_results]', ! empty( $_configurationValues['show_loader_over_results'] ) ); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_show_loader_over_filter; ?></td>
					<td>
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[show_loader_over_filter]', ! empty( $_configurationValues['show_loader_over_filter'] ) ); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_auto_scroll_to_results; ?></td>
					<td>
						<div style="vertical-align: middle; display: inline">
							<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[auto_scroll_to_results]', ! empty( $_configurationValues['auto_scroll_to_results'] ) ); ?>
						</div>
						- <?php echo $entry_add; ?>
						<input size="4" type="text" name="<?php echo $_configurationName; ?>[add_pixels_from_top]" value="<?php echo empty( $_configurationValues['add_pixels_from_top'] ) ? 0 : $_configurationValues['add_pixels_from_top']; ?>" />
						<?php echo $text_pixels_from_top; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_ajax_pagination; ?></td>
					<td>
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[ajax_pagination]', ! empty( $_configurationValues['ajax_pagination'] ) ); ?>
					</td>
				</tr>
				<tr>
					<td rowspan="3">
						<?php echo $entry_refresh_results; ?>
					</td>
					<td>
						<input id="refresh_results_a" type="radio" name="<?php echo $_configurationName; ?>[refresh_results]" value="immediately" <?php echo empty( $_configurationValues['refresh_results'] ) || $_configurationValues['refresh_results'] == 'immediately' ? 'checked="checked"' : ''; ?> />
						<label for="refresh_results_a"><?php echo $text_immediately; ?></label>

						<div class="help"><?php echo $text_immediately_help; ?></div>
					</td>
				</tr>
				<tr>
					<td style="width: auto">
						<input id="refresh_results_b" type="radio" name="<?php echo $_configurationName; ?>[refresh_results]" value="with_delay" <?php echo ! empty( $_configurationValues['refresh_results'] ) && $_configurationValues['refresh_results'] == 'with_delay' ? 'checked="checked"' : ''; ?> />
						<label for="refresh_results_b"><?php echo $text_with_delay; ?></label>

						<div class="help"><?php echo $text_with_delay_guide; ?></div><br />
						<?php echo $text_with_delay_help; ?><input type="text" size="5" name="<?php echo $_configurationName; ?>[refresh_delay]" value="<?php echo empty( $_configurationValues['refresh_delay'] ) ? '1000' : $_configurationValues['refresh_delay']; ?>" /> <?php echo $text_milliseconds; ?>
					</td>
				</tr>
				<tr>
					<td style="width: auto">
						<input id="refresh_results_c" type="radio" name="<?php echo $_configurationName; ?>[refresh_results]" value="using_button" <?php echo ! empty( $_configurationValues['refresh_results'] ) && $_configurationValues['refresh_results'] == 'using_button' ? 'checked="checked"' : ''; ?> />
						<label for="refresh_results_c"><?php echo $text_using_button; ?></label>

						<div class="help"><?php echo $text_using_button_help; ?></div><br />

						<table style="margin-left: -4px"><tr><td width="100" style="vertical-align: top;"><b><?php echo $text_place_button; ?>:</b></td><td style="line-height: 20px">
							<input style="vertical-align: middle; margin-top: 0" <?php echo empty( $_configurationValues['place_button'] ) || $_configurationValues['place_button'] == 'bottom' ? ' checked="checked"' : ''; ?> type="radio" name="<?php echo $_configurationName; ?>[place_button]" value="bottom" id="place_button_a" /> <label for="place_button_a"><?php echo $text_place_button_bottom; ?></label><br />
							<input style="vertical-align: middle; margin-top: 0" <?php echo ! empty( $_configurationValues['place_button'] ) && $_configurationValues['place_button'] == 'top' ? ' checked="checked"' : ''; ?> type="radio" name="<?php echo $_configurationName; ?>[place_button]" value="top" id="place_button_b" /> <label for="place_button_b"><?php echo $text_place_button_top; ?></label><br />
							<input style="vertical-align: middle; margin-top: 0" <?php echo ! empty( $_configurationValues['place_button'] ) && $_configurationValues['place_button'] == 'bottom_top' ? ' checked="checked"' : ''; ?> type="radio" name="<?php echo $_configurationName; ?>[place_button]" value="bottom_top" id="place_button_c" /> <label for="place_button_c"><?php echo $text_place_button_bottom_top; ?></label><br />
							</td></tr></table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="tab-pane" id="tab-display-list-of-items">
		<table class="table table-tbody">
			<tbody>
				<tr>
					<td width="200">
						<label for="display-list-of-items_a">
							<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/display-list-of-items-scroll.png?v2" />
						</label>
						<center><input id="display-list-of-items_a" type="radio" name="<?php echo $_configurationName; ?>[display_list_of_items][type]" value="scroll"<?php echo empty( $_configurationValues['display_list_of_items']['type'] ) || $_configurationValues['display_list_of_items']['type'] == 'scroll' ? ' checked="checked"' : ''; ?> /></center>
					</td>
					<td style="vertical-align: top">
						<?php echo $entry_max_height; ?><br />
						<input type="text" name="<?php echo $_configurationName; ?>[display_list_of_items][max_height]" value="<?php echo empty( $_configurationValues['display_list_of_items']['max_height'] ) ? 155 : (int) $_configurationValues['display_list_of_items']['max_height']; ?>" /> px
						
						<br /><br />
						<?php echo $text_standard_scroll; ?>:
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[display_list_of_items][standard_scroll]', ! empty( $_configurationValues['display_list_of_items']['standard_scroll'] ) ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<label for="display-list-of-items_b">
							<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/display-list-of-items-button-more.png?v2" />
						</label>
						<center><input id="display-list-of-items_b" type="radio" name="<?php echo $_configurationName; ?>[display_list_of_items][type]" value="button_more"<?php echo ! empty( $_configurationValues['display_list_of_items']['type'] ) && $_configurationValues['display_list_of_items']['type'] == 'button_more' ? ' checked="checked"' : ''; ?> /></center>
					</td>
					<td style="vertical-align: top">
						<?php echo $entry_limit_of_items; ?><br />
						<input type="text" name="<?php echo $_configurationName; ?>[display_list_of_items][limit_of_items]" value="<?php echo empty( $_configurationValues['display_list_of_items']['limit_of_items'] ) ? 4 : (int) $_configurationValues['display_list_of_items']['limit_of_items']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/display-live-filter.png" />
					</td>
					<td style="vertical-align: top">
						<?php echo $text_enabled; ?>:
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[display_live_filter][enabled]', ! empty( $_configurationValues['display_live_filter']['enabled'] ) ); ?>
						<br /><br />
						
						<?php echo $entry_limit_live_filter; ?><br />
						
						<input type="text" name="<?php echo $_configurationName; ?>[display_live_filter][items]" value="<?php echo empty( $_configurationValues['display_live_filter']['items'] ) ? '' : (int) $_configurationValues['display_live_filter']['items']; ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="tab-pane" id="tab-style">
		<table class="table table-tbody">
			<tr>
				<td style="width: 230px;"><?php echo $entry_color_counter_background; ?></td>
				<td width="300">
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[background_color_counter]" value="<?php echo ! empty( $_configurationValues['background_color_counter'] ) ? $_configurationValues['background_color_counter'] : '#428bca'; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/couter-color.png" />
				</td>
				<td width="200"><?php echo $entry_color_counter_text; ?></td>
				<td>
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[text_color_counter]" value="<?php echo ! empty( $_configurationValues['text_color_counter'] ) ? $_configurationValues['text_color_counter'] : '#ffffff'; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/couter-color.png" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_color_search_button_background; ?></td>
				<td>
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[background_color_search_button]" value="<?php echo ! empty( $_configurationValues['background_color_search_button'] ) ? $_configurationValues['background_color_search_button'] : '#428bca'; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/search-button-color.png" />
				</td>
				<td><?php echo $entry_color_slider_background; ?></td>
				<td>
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[background_color_slider]" value="<?php echo ! empty( $_configurationValues['background_color_slider'] ) ? $_configurationValues['background_color_slider'] : ''; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/slider-color.png" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_color_header_background; ?></td>
				<td width="300">
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[background_color_header]" value="<?php echo ! empty( $_configurationValues['background_color_header'] ) ? $_configurationValues['background_color_header'] : ''; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/header-color.png" />
				</td>
				<td width="200"><?php echo $entry_color_header_text; ?></td>
				<td>
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[text_color_header]" value="<?php echo ! empty( $_configurationValues['text_color_header'] ) ? $_configurationValues['text_color_header'] : ''; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/header-color.png" />
				</td>
			</tr>
			<tr>
				<td style="width: 230px;"><?php echo $entry_color_header_border_bottom; ?></td>
				<td width="300">
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[border_bottom_color_header]" value="<?php echo ! empty( $_configurationValues['border_bottom_color_header'] ) ? $_configurationValues['border_bottom_color_header'] : ''; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/header-border-bottom-color.png" />
				</td>
				<td width="200"><?php echo $entry_image_size; ?></td>
				<td>
					<input type="text" name="<?php echo $_configurationName; ?>[image_size_width]" size="5" value="<?php echo ! empty( $_configurationValues['image_size_width'] ) ? $_configurationValues['image_size_width'] : '20'; ?>" /> x
					<input type="text" name="<?php echo $_configurationName; ?>[image_size_height]" size="5" value="<?php echo ! empty( $_configurationValues['image_size_height'] ) ? $_configurationValues['image_size_height'] : '20'; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/image-size.png" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_color_of_loader_over_results; ?></td>
				<td>
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[color_of_loader_over_results]" value="<?php echo ! empty( $_configurationValues['color_of_loader_over_results'] ) ? $_configurationValues['color_of_loader_over_results'] : ''; ?>" />
				</td>
				<td><?php echo $entry_color_of_loader_over_filter; ?></td>
				<td>
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[color_of_loader_over_filter]" value="<?php echo ! empty( $_configurationValues['color_of_loader_over_filter'] ) ? $_configurationValues['color_of_loader_over_filter'] : ''; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_widget_button_background; ?></td>
				<td colspan="3">
					<input class="mf-colorPicker" type="text" name="<?php echo $_configurationName; ?>[background_color_widget_button]" value="<?php echo ! empty( $_configurationValues['background_color_widget_button'] ) ? $_configurationValues['background_color_widget_button'] : ''; ?>" />
					
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/widget-button-background.png" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_css_style; ?></td>
				<td colspan="3">
					<?php if( empty( $_configurationMain ) ) { ?>
						<div style="margin-bottom: 10px;"><?php echo sprintf( $text_define_own_styles, $IDX ); ?></div>
					<?php } ?>
					<textarea name="<?php echo $_configurationName; ?>[css_style]" <?php echo ! empty( $_configurationMain ) ? 'cols="150"' : 'style="width:100%"'; ?> rows="20"><?php echo empty( $_configurationValues['css_style'] ) ? '' : $_configurationValues['css_style']; ?></textarea>
				</td>
			</tr>
		</table>
	</div>

	<div class="tab-pane" id="tab-javascript">
		<table class="table table-tbody">
			<tr>
				<td width="200"><?php echo $entry_javascript; ?></td>
				<td>
<?php
			
$javascript_example_code = 
"MegaFilter.prototype.beforeRequest = function() {
	var self = this;
};

MegaFilter.prototype.beforeRender = function( htmlResponse, htmlContent, json ) {
	var self = this;
};

MegaFilter.prototype.afterRender = function( htmlResponse, htmlContent, json ) {
	var self = this;
};
";
					
					?>
					<textarea name="<?php echo $_configurationName; ?>[javascript]" <?php echo ! empty( $_configurationMain ) ? 'cols="150"' : 'style="width:100%"'; ?> rows="20"><?php echo empty( $_configurationValues['javascript'] ) ? $javascript_example_code : $_configurationValues['javascript']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_content_selector; ?></td>
				<td>
					<table>
						<tr>
							<td>
								<input type="text" name="<?php echo $_configurationName; ?>[content_selector]" value="<?php echo ! empty( $_configurationValues['content_selector'] ) ? $_configurationValues['content_selector'] : '#mfilter-content-container'; ?>" />
							</td>
							<td>
								<?php echo $text_content_selector_guide; ?><br />
								<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/content_selector.jpg" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php if( ! empty( $_configurationMain ) ) { ?>
				<tr>
					<td><?php echo $entry_home_page_by_ajax; ?></td>
					<td>
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[home_page_ajax]', ! empty( $_configurationValues['home_page_ajax'] ) ); ?>
						<br /><br />
						<input size="50" type="text" placeholder="<?php echo $text_content_selector; ?>" name="<?php echo $_configurationName; ?>[home_page_content_selector]" value="<?php echo ! empty( $_configurationValues['home_page_content_selector'] ) ? $_configurationValues['home_page_content_selector'] : '#content'; ?>" />
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>

	<div class="tab-pane" id="tab-other">
		<table class="table table-tbody">
			<tr>
				<td><?php echo $entry_type_of_condition; ?></td>
				<td>
					<select name="<?php echo $_configurationName; ?>[type_of_condition]">
						<option value="or" <?php echo ! empty( $_configurationValues['type_of_condition'] ) && $_configurationValues['type_of_condition'] == 'or' ? 'selected="selected"' : ''; ?>>OR</option>
						<option value="and" <?php echo ! empty( $_configurationValues['type_of_condition'] ) && $_configurationValues['type_of_condition'] == 'and' ? 'selected="selected"' : ''; ?>>AND</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="300"><?php echo $entry_calculate_number_of_products; ?></td>
				<td>
					<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[calculate_number_of_products]', ! empty( $_configurationValues['calculate_number_of_products'] ) ); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_show_products; ?></td>
				<td>
					<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[show_number_of_products]', ! empty( $_configurationValues['show_number_of_products'] ) ); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $entry_hide_inactive_values; ?>
				</td>
				<td>
					<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[hide_inactive_values]', ! empty( $_configurationValues['hide_inactive_values'] ) ); ?>
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/hide-inactive-values.png" style="vertical-align: middle; margin-left: 20px;" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_show_reset_button; ?></td>
				<td>
					<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[show_reset_button]', ! empty( $_configurationValues['show_reset_button'] ) ); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_show_top_reset_button; ?></td>
				<td>
					<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[show_top_reset_button]', ! empty( $_configurationValues['show_top_reset_button'] ) ); ?>
				</td>
			</tr>
			<?php if( ! empty( $_configurationMain ) ) { ?>
				<tr>
					<td><?php echo $entry_enable_cache; ?></td>
					<td>
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[cache_enabled]', ! empty( $_configurationValues['cache_enabled'] ) ); ?>
						<a href="<?php echo $action_clear_cache; ?>" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> <?php echo $text_clear_cache; ?></a>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_show_products_from_subcategories; ?></td>
					<td>
						<?php if( version_compare( VERSION, '1.5.5', '>=' ) ) { ?>
							<input style="vertical-align: middle; margin-top: -2px;" type="checkbox" name="<?php echo $_configurationName; ?>[show_products_from_subcategories]" value="1" <?php echo ! empty( $_configurationValues['show_products_from_subcategories'] ) ? 'checked="checked"' : ''; ?> />

							- <?php echo $text_start_level; ?>
							<select name="<?php echo $_configurationName; ?>[level_products_from_subcategories]">
								<?php for( $i = 1; $i <= 10; $i++ ) { ?>
									<option <?php echo ! empty( $_configurationValues['level_products_from_subcategories'] ) && $_configurationValues['level_products_from_subcategories'] == $i ? ' selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>

							<span class="help"><?php echo $text_start_level_help; ?></span>
						<?php } else { ?>
							<?php echo $text_oc_155; ?>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $entry_layout_category; ?>
					</td>
					<td>
						<select name="<?php echo $_configurationName; ?>[layout_c]">
							<?php foreach( $layouts as $layout ) { ?>
								<option value="<?php echo $layout['layout_id']; ?>"<?php if( $_configurationValues['layout_c'] == $layout['layout_id'] ) { ?> selected="selected"<?php } ?>><?php echo $layout['name']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
			<?php } ?>
				<tr>
					<td>
						<?php echo $entry_in_stock_status; ?>
					</td>
					<td>
						<?php if( ! empty( $_configurationMain ) ) { ?>
							<select name="<?php echo $_configurationName; ?>[in_stock_status]" style="margin-bottom: 8px">
								<?php foreach( $stockStatuses as $stock_status ) { ?>
									<option value="<?php echo $stock_status['stock_status_id']; ?>"<?php if( $_configurationValues['in_stock_status'] == $stock_status['stock_status_id'] ) { ?> selected="selected"<?php } ?>><?php echo $stock_status['name']; ?></option>
								<?php } ?>
							</select>
							<br />
						<?php } ?>
							
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[in_stock_default_selected]', ! empty( $_configurationValues['in_stock_default_selected'] ) ); ?> <?php echo $text_in_stock_default_selected; ?>

						<?php if( ! empty( $mfp_plus_version ) ) { ?>
							<br /><br />
							<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[stock_for_options_plus]', ! empty( $_configurationValues['stock_for_options_plus'] ) ); ?> <?php echo $text_stock_for_options_plus; ?>
						<?php } ?>
					</td>
				</tr>
			<?php if( ! empty( $_configurationMain ) ) { ?>
				<tr>
					<td>
						<?php echo $entry_not_remember_filter_for_subcategories; ?>
					</td>
					<td>
						<input type="checkbox" name="<?php echo $_configurationName; ?>[not_remember_filter_for_subcategories]" value="1" <?php echo ! empty( $_configurationValues['not_remember_filter_for_subcategories'] ) ? 'checked="checked"' : ''; ?> />
						<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/not-remember-filter-for-subcategories.png" style="vertical-align: middle; margin-left: 20px;" />
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $entry_attribute_separator; ?>
						<span class="help"><?php echo $text_attribute_separator_guide; ?></span>
					</td>
					<td>
						<?php $separators = array( ',', '|', ';', '#', '/', '–' ); ?>
						<select name="<?php echo $_configurationName; ?>[attribute_separator]">
							<option value=""><?php echo $text_none; ?></option>
							<?php foreach( $separators as $separator ) { ?>
								<option value="<?php echo $separator; ?>"<?php if( ! empty( $_configurationValues['attribute_separator'] ) && $_configurationValues['attribute_separator'] == $separator ) { ?> selected="selected"<?php } ?>><?php echo $separator; ?></option>
							<?php } ?>
						</select>
						<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/attribute-spearator.png?v2" style="vertical-align: middle; margin-left: 20px;" />
					</td>
				</tr>
			<?php } ?>
			<tr>
				<td><?php echo $entry_manual_init; ?></td>
				<td>
					<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[manual_init]', ! empty( $_configurationValues['manual_init'] ) ); ?>
					<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/manual-init.png" style="vertical-align: middle; margin-left: 20px;" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_change_top_to_column_on_mobile; ?></td>
				<td>
					<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[change_top_to_column_on_mobile]', ! empty( $_configurationValues['change_top_to_column_on_mobile'] ) ); ?>
				</td>
			</tr>
			<?php if( ! empty( $_configurationMain ) ) { ?>
				<tr>
					<td><?php echo $entry_minify_support; ?></td>
					<td>
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[minify_support]', ! empty( $_configurationValues['minify_support'] ) ); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_combine_js_css_fiels; ?></td>
					<td>
						<?php echo mf_render_btn_group( $text_yes, $text_no, $_configurationName . '[combine_js_css_files]', ! empty( $_configurationValues['combine_js_css_files'] ) ); ?>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>

<link type="text/css" href="<?php echo $HTTP_URL; ?>view/stylesheet/mf/css/colorpicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/js/colorpicker.js"></script>
<script type="text/javascript">	
	(function($){
		$('input[name="<?php echo $_configurationName; ?>[calculate_number_of_products]"]').change(function(){
			var checked = $(this).val() == '1';
			
			$('input[name="<?php echo $_configurationName; ?>[show_number_of_products]"],input[name="<?php echo $_configurationName; ?>[hide_inactive_values]"]').parent().parent().parent().parent()[checked?'show':'hide']();
		});
			
		$('input[name="<?php echo $_configurationName; ?>[calculate_number_of_products]"]:checked').trigger('change');
	})(jQuery);
	
	jQuery('input[name="<?php echo $_configurationName; ?>[refresh_results]"]').change(function(){
		jQuery('input[name="<?php echo $_configurationName; ?>[refresh_results]"]').each(function(){
			var $inputs = jQuery(this).parent().find('input:not([name="<?php echo $_configurationName; ?>[refresh_results]"])');

			if( jQuery(this).is(':checked') ) {
				$inputs.removeAttr('disabled');
			} else {
				$inputs.attr('disabled', true);
			}
		});
	}).trigger('change');
	
	//Color Pickers
		jQuery("input.mf-colorPicker").each(function(){
			var tis = jQuery(this);

		    tis.ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					jQuery(el).val("#"+hex).next().css("background-color","#"+hex);
					jQuery(el).ColorPickerHide();
				},
				onChange: function(hsb, hex, rgb) {
					tis.val("#"+hex).next().css("background-color","#"+hex);
				},
				onBeforeShow: function() {
					tis.ColorPickerSetColor(tis.val());
				}
			}).bind('keyup', function(){
				tis.ColorPickerSetColor("#"+tis.val());
			});
		});
</script>